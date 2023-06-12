<?php

class PartidaController
{
    private $renderer;
    private $partidaModel;

    public function __construct($partidaModel, $renderer)
    {
        $this->renderer = $renderer;
        $this->partidaModel = $partidaModel;
    }
    public function list() {
        $data["jugando"] = $this->estaJugando() && !isset($_SESSION["respuestaOKMessage"]);
        $data["pregunta"] =  $_SESSION["pregunta"] ?? $this->generarPregunta();
        $data["categoria"] = $_SESSION["categoria"] ?? null;
        $data["respuestas"] = isset($_SESSION["respuestas"]) ? $this->getRespuestas() : [];
        $data["respuestaOKMessage"] = $_SESSION["respuestaOKMessage"] ?? null;
        $data["respuestaMALMessage"] = $_SESSION["respuestaMALMessage"] ?? null;
        $data["respondio"] = $this->hayRespuestaEnSesion();
        $data["usuarioLogeado"] = $_SESSION["usuario"];
        $this->renderer->render('partida', $data);

        $this->unsetVariablesSESSION();
    }

    public function responder() {
        $reportado = $_GET["toggleReportar"] ?? null;
        $this->partidaModel->guardarReporte($reportado, $_SESSION["pregunta"]["idPregunta"]);

        $this->verificarRespuesta($_GET["respuesta"]);

        if( ! $this->estaJugando() ) {
            $datosPartida = [
                $_SESSION["usuario"]["idUsuario"],
                $_SESSION["partida"]["puntaje"],
                $_SESSION["partida"]["respuestasAcertadas"],
                10 //TODO: Se hardcodea por ahora la duracion de partida
            ];

            unset($_SESSION["partida"]);
            $this->partidaModel->guardar($datosPartida);
        }

        header("Location: /partida");
    }

    private function estaJugando() {
        return ! ( (isset($_SESSION["respuestaMALMessage"])) );
    }

    private function verificarRespuesta($respuestaSeleccionada) {
        $_SESSION["respuestaElegida"] = $respuestaSeleccionada;

        if( ! isset($_SESSION["partida"]) ) {
            $_SESSION["partida"] = $this->partidaModel->createPartidaInicial();
        }

        //TODO: Cambiar el PartidaModel para no tener que acceder a ["respuestas"][0]
        if($respuestaSeleccionada == $_SESSION["respuestas"][0]["respuestaCorrecta"]) {
            $fueCorrecta = true;
            $this->partidaModel->updatePartidaActual($_SESSION["partida"]);
            $_SESSION["respuestaOKMessage"] = "¡CORRECTO! Puntaje de partida: " . $_SESSION["partida"]["puntaje"];
        } else {
            $fueCorrecta = false;
            $_SESSION["respuestaMALMessage"] = "¡LA PARTIDA TERMINO! Puntaje de partida: " . $_SESSION["partida"]["puntaje"];
        }

        $this->partidaModel->guardarPreguntaRespondida($_SESSION["pregunta"]["idPregunta"], $_SESSION["usuario"]["idUsuario"], $fueCorrecta);
    }

    private function generarPregunta()
    {
        $this->chequearArrayCategorias();

        if( ! isset($_SESSION["categorias"]) ) {
            $_SESSION["categorias"] = $this->generarArrayCategorias();
        }

        if( isset($_SESSION["categorias"]) ) {
            $preguntaSiguiente = $this->generarPreguntaPorCategoria();

            $respuestas = $this->partidaModel->findRespuestaPorId($preguntaSiguiente["idRespuesta"]);
            $_SESSION["pregunta"] = $preguntaSiguiente;
            $_SESSION["respuestas"] = $respuestas;
        }

        return $_SESSION["pregunta"];
    }

    private function generarArrayCategorias()
    {
        $categorias = $this->partidaModel->findCategoriasAlAzar();
        return $categorias;
    }

    private function generarPreguntaPorCategoria()
    {
        $categoriaSiguiente = $this->partidaModel->getCategoriaSiguiente($_SESSION["categorias"]);
        $_SESSION["categoria"] = $categoriaSiguiente;
        $preguntaSiguiente = $this->partidaModel->getPreguntaSiguiente($categoriaSiguiente["idCategoria"], $_SESSION["usuario"]["idUsuario"]);

        return $preguntaSiguiente;
    }

    private function chequearArrayCategorias() {
        if(empty($_SESSION["categorias"])) {
            unset($_SESSION["categorias"]);
        }
    }

    private function getRespuestas() {
        if(isset($_SESSION["respuestaOKMessage"]) || isset($_SESSION["respuestaMALMessage"])) {
            $respuestasCorrecta = $_SESSION["respuestas"][0]["respuestaCorrecta"];
            return $this->partidaModel->getRespuestasAMarcarComoCorrectaIncorrectaYDisabled($_SESSION["respuestas"][0], $_SESSION["respuestaElegida"], $respuestasCorrecta);
        } else {
            return $this->partidaModel->getRespuestasAMostrar($_SESSION["respuestas"][0]);
        }
    }

    private function unsetVariablesSESSION()
    {
        if(isset($_SESSION["respuestaOKMessage"]) || isset($_SESSION["respuestaMALMessage"])) {
            unset($_SESSION["pregunta"]);
            unset($_SESSION["respuestaOKMessage"]);
            unset($_SESSION["respuestaMALMessage"]);
            unset($_SESSION["respuestaElegida"]);
            unset($_SESSION["respuestas"]);
            unset($_SESSION["categoria"]);
        }
    }

    private function hayRespuestaEnSesion()
    {
        return isset($_SESSION["respuestaOKMessage"]) || isset($_SESSION["respuestaMALMessage"]);
    }
}