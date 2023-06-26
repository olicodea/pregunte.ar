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
        $option = $_GET["option"] ?? "year";
        return $this->estadisticasJugadoresModel->getGraficoPorPais($option);
    }

    public function mostrarCantidadJugadoresPorGenero() {
        $option = $_GET["option"] ?? "year";
        return $this->estadisticasJugadoresModel->getGraficoPorGenero($option);
    }

    public function mostrarCantidadJugadoresPorGrupoDeEdad() {
        return $this->estadisticasJugadoresModel->getGraficoPorGrupoDeEdad();
    }

    public function imprimirReporte() {
        $this->estadisticasJugadoresModel->imprimirReporte($_GET["reporte"], $_POST["imagen"]);
    }
}