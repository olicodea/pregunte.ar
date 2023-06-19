<?php

class PreguntasReportadasModel
{
    private $database;
    private $ESTADO_REPORTE = "REPORTADA";
    private $ESTADO_ACEPTADA = "ACEPTADA";

    public function __construct($database) {
        $this->database = $database;
    }

    public function findPreguntasReportadas() {
        $sql = "SELECT p.idPregunta, p.pregunta, 
                (SELECT COUNT(*) FROM reporte WHERE idPregunta = p.idPregunta) AS cantidadReportes
                FROM pregunta p JOIN estado_pregunta ep ON ep.idEstadoPregunta = p.idEstadoPregunta
                WHERE ep.descripcion = ?";

        return mysqli_fetch_all($this->database->queryWthParameters($sql, $this->ESTADO_REPORTE), MYSQLI_ASSOC);
    }

    public function findComentariosReportesPorIdPregunta($idPregunta) {
        $sql = "SELECT r.comentario FROM reporte r WHERE r.idPregunta = ?";

        $comentarios = mysqli_fetch_all($this->database->queryWthParameters($sql, $idPregunta), MYSQLI_ASSOC);
        return array_filter($comentarios, function ($comentario) {
            return $comentario["comentario"] != "Sin comentarios";
        });
    }

    public function rechazarReporte($idPregunta) {
        $this->cambiarEstadoPregunta($idPregunta);
        $this->eliminarReportesPorIdPregunta($idPregunta);
    }

    private function cambiarEstadoPregunta($idPregunta)
    {
        $sql = "UPDATE pregunta p
                SET p.idEstadoPregunta = (SELECT ep.idEstadoPregunta FROM estado_pregunta ep WHERE ep.descripcion = ?) 
                WHERE p.idPregunta = ?";
        $datosCambiarEstado = [$this->ESTADO_ACEPTADA, $idPregunta];
        $typesParams = "si";
        $this->database->save($typesParams, $datosCambiarEstado, $sql);
    }

    private function eliminarReportesPorIdPregunta($idPregunta)
    {
        $sql = "DELETE FROM reporte WHERE idPregunta = ?";
        $typesParams = "i";
        $datosEliminar = [$idPregunta];
        $this->database->save($typesParams, $datosEliminar, $sql);
    }
}