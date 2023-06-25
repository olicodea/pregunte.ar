<?php

class EstadisticasJugadoresController
{
    private $renderer;
    private $estadisticasJugadoresModel;

    public function __construct($estadisticasJugadoresModel, $renderer) {
        $this->estadisticasJugadoresModel = $estadisticasJugadoresModel;
        $this->renderer = $renderer;
    }
    public function list() {
        $data["vistaEstadisticasJugadores"] = true;
        $this->renderer->render('estadisticasJugadores', $data);
    }

    public function mostrarJugadoresPorPais() {
        return $this->estadisticasJugadoresModel->getGraficoPorPais();
    }

    public function mostrarCantidadJugadoresPorGenero() {
        return $this->estadisticasJugadoresModel->getGraficoPorGenero();
    }

    public function mostrarCantidadJugadoresPorGrupoDeEdad() {
        return $this->estadisticasJugadoresModel->getGraficoPorGrupoDeEdad();
    }

    public function imprimirReporte() {
        $this->estadisticasJugadoresModel->imprimirReporte($_GET["reporte"], $_POST["imagen"]);
    }
}