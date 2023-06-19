<?php

class PreguntasReportadasModel
{
    private $database;
    private $ESTADO_REPORTE = "REPORTADA";

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
}