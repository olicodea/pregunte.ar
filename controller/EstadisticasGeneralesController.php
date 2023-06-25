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
        $this->renderer->render('estadisticasGenerales');
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
}