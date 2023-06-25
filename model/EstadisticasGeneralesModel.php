<?php

class EstadisticasGeneralesModel
{
    private $database;
    private $generadorGrafico;

    private $tituloGraficoUsuarios = "Cantidad de usuarios totales y nuevos";
    private $leyendaJugadoresTotales = "Usuarios Totales";
    private $leyendaJugadoresNuevos = "Usuarios Nuevos";

    private $tituloGraficoPreguntas = "Cantidad de preguntas totales y sugeridas";
    private $leyendaPreguntasTotales = "Preguntas Totales";
    private $leyendaPreguntasSugeridas = "Preguntas Sugeridas";

    private $tituloGraficoPartidas = "Cantidad de partidas";
    private $leyendaPartidas = "Partidas";

    public function __construct($generadorGrafico, $database) {
        $this->generadorGrafico = $generadorGrafico;
        $this->database = $database;
    }

    public function getGraficoCantidadJugadores() {
        $usuariosTotales = [5,20,33,42,120,505,705,900,1020,1300,1800,2500];
        $usuariosNuevos = [5,15,17,23,80,380,200,195, 120, 280, 500, 700];
        $labels = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"];
        return $this->generadorGrafico->generarGraficoCombinadoBarPlots($this->tituloGraficoUsuarios, $labels, $usuariosTotales, $this->leyendaJugadoresTotales, $usuariosNuevos, $this->leyendaJugadoresNuevos);
    }

    public function getGraficoCantidadPreguntas() {
        $preguntasTotales = [5,20,33,42,120,505,705];
        $preguntasSugeridas = [5,15,17,23,80,380,200];
        $labels = ["Lun", "Mar", "Mier", "Jue", "Vier", "Sab", "Dom"];
        return $this->generadorGrafico->generarGraficoCombinadoBarPlots($this->tituloGraficoPreguntas, $labels, $preguntasTotales, $this->leyendaPreguntasTotales, $preguntasSugeridas, $this->leyendaPreguntasSugeridas);
    }

    public function getGraficoCantidadPartidas() {
        $partidasTotales = [23, 56, 66, 23, 80, 380, 780, 1200, 760, 280, 777, 900];
        $labels = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"];
        return $this->generadorGrafico->generarGraficoCombinadoBarPlots($this->tituloGraficoPartidas, $labels, $partidasTotales, $this->leyendaPartidas);
    }
}