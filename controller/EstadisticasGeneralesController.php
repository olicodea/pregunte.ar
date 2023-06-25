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
        return $this->estadisticasGeneralesModel->getGraficoCantidadJugadores();
    }

    public function mostrarCantidadPreguntas() {
        return $this->estadisticasGeneralesModel->getGraficoCantidadPreguntas();
    }

    public function mostrarCantidadPartidas() {
        return $this->estadisticasGeneralesModel->getGraficoCantidadPartidas();
    }

    public function imprimirReporte() {
        $this->estadisticasGeneralesModel->imprimirReporte($_GET["reporte"], $_POST["imagen"]);
    }
}