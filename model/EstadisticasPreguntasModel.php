<?php

class EstadisticasPreguntasModel
{
    private $database;
    private $generadorPDF;
    private $ROL_JUGADOR = "Jugador";

    public function __construct($generadorPDF, $database) {
        $this->generadorPDF = $generadorPDF;
        $this->database = $database;
    }

    public function listarJugadores() {
        $sql = "SELECT u.idUsuario as idJugador, u.nombreDeUsuario as nombreUsuario FROM usuario u
                WHERE u.idRol = (SELECT r.idRol FROM rol r WHERE r.descripcion like ?)";
        return mysqli_fetch_all($this->database->queryWthParameters($sql, $this->ROL_JUGADOR), MYSQLI_ASSOC);
    }

    public function getPorcentajeAciertos($idJugador) {
        $cantidadPreguntasRespondidas = $this->getCantidadPreguntasRespondidasPorIdUsuario($idJugador);
        $cantidadAciertos = $this->getCantidadAciertosPorIdUsuario($idJugador);

        $porcentajeAciertos = $this->calcularPorcentajeAciertos($cantidadPreguntasRespondidas, $cantidadAciertos);
        $porcentajeError = $this->calcularPorcentajeError($porcentajeAciertos);

        return [$porcentajeAciertos, $porcentajeError];
    }

    public function imprimirReporte($reporte, $graficoBase64, $nombreUsuario) {
        $titulo = $this->getTituloReporte($reporte, $nombreUsuario);
        $this->generadorPDF->generarPDF($titulo, $graficoBase64);
    }

    private function getCantidadPreguntasRespondidasPorIdUsuario($idJugador)
    {
        $sql = "SELECT COUNT(*) AS preguntasRespondidas FROM pregunta_respondida pr WHERE pr.idUsuario = ?";
        $result = mysqli_fetch_assoc($this->database->queryWthParameters($sql, $idJugador));
        return $result["preguntasRespondidas"];
    }

    private function getCantidadAciertosPorIdUsuario($idJugador)
    {
        $sql = "SELECT COUNT(*) AS preguntasAcertadas FROM pregunta_respondida pr WHERE pr.idUsuario = ? AND pr.fueCorrecta = 1";
        $result = mysqli_fetch_assoc($this->database->queryWthParameters($sql, $idJugador));
        return $result["preguntasAcertadas"];
    }

    private function calcularPorcentajeAciertos($cantidadPreguntasRespondidas, $cantidadAciertos)
    {
        if($cantidadPreguntasRespondidas == 0) {
            return 0;
        }

        return ($cantidadAciertos / $cantidadPreguntasRespondidas) * 100;
    }

    private function calcularPorcentajeError($porcentajeAciertos)
    {
        return 100 - $porcentajeAciertos;
    }

    private function getTituloReporte($reporte, $nombreUsuario)
    {
        if ($reporte == "porcentajes") {
            return "Reporte de " . $nombreUsuario;
        }
    }
}