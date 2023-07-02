<?php

class EstadisticasGeneralesController
{
    private $renderer;
    private $estadisticasGeneralesModel;
    public function __construct($estadisticasGeneralesModel, $renderer) {
        $this->renderer = $renderer;
        $this->estadisticasGeneralesModel = $estadisticasGeneralesModel;
    }
    public function list() {
        $data["vistaEstadisticasGenerales"] = true;
        $this->renderer->render('estadisticasGenerales', $data);
    }

    public function mostrarCantidadJugadores() {
        $option = $_GET["option"] ?? "year";
        return $this->estadisticasGeneralesModel->getGraficoCantidadJugadores($option);
    }

    public function mostrarCantidadUsuariosNuevos() {
        return $this->estadisticasGeneralesModel->getGraficoCantidadUsuariosNuevos();
    }

    public function mostrarCantidadPreguntas() {
        $option = $_GET["option"] ?? "year";
        return $this->estadisticasGeneralesModel->getGraficoCantidadPreguntas($option);
    }

    public function mostrarCantidadPartidas() {
        $option = $_GET["option"] ?? "year";
        return $this->estadisticasGeneralesModel->getGraficoCantidadPartidas($option);
    }

    public function imprimirReporte() {
        $this->estadisticasGeneralesModel->imprimirReporte($_GET["reporte"], $_POST["imagen"]);
    }
}