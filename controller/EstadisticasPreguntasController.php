<?php

class EstadisticasPreguntasController
{
    private $renderer;
    private $generadorGrafico;
    private $estadisticasPreguntasModel;
    private $TITULO_GRAFICO = "Porcentaje de aciertos";

    public function __construct($estadisticasPreguntasModel, $generadorGrafico, $renderer) {
        $this->generadorGrafico = $generadorGrafico;
        $this->renderer = $renderer;
        $this->estadisticasPreguntasModel = $estadisticasPreguntasModel;
    }
    public function list() {
        $data["jugadores"] = $this->listarJugadores();
        $this->renderer->render('estadisticasPreguntas', $data);
    }

    public function listarJugadores() {
        return $this->estadisticasPreguntasModel->listarJugadores();
    }

    public function mostrarPorcentajeAciertos() {
        $porcentajesAciertos = $this->getPorcentajeAciertos($_GET["idJugador"]);
        return $this->generadorGrafico->generarGraficoTorta($porcentajesAciertos, $this->TITULO_GRAFICO);
    }

    private function getPorcentajeAciertos($idJugador)
    {
        return $this->estadisticasPreguntasModel->getPorcentajeAciertos($idJugador);
    }
}