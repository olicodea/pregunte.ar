<?php

class PartidaController
{
    private $renderer;
    private $partidaModel;

    private $TIEMPO_INICIAL = 10000;

    public function __construct($partidaModel, $renderer)
    {
        $this->renderer = $renderer;
        $this->partidaModel = $partidaModel;
    }
    public function list() {
        $data["tiempoInicial"] = $this->chequearTemporizador();
        $data["jugando"] = $this->estaJugando() && !isset($_SESSION["respuestaOKMessage"]);
        $data["pregunta"] =  $_SESSION["pregunta"] ?? $this->generarPregunta();
        $data["categoria"] = $_SESSION["categoria"] ?? null;
        $data["respuestas"] = isset($_SESSION["respuestas"]) ? $this->getRespuestas() : [];
        $data["respuestaOKMessage"] = $_SESSION["respuestaOKMessage"] ?? null;
        $data["respuestaMALMessage"] = $_SESSION["respuestaMALMessage"] ?? null;
        $data["respondio"] = $this->hayRespuestaEnSesion();
        $data["usuarioLogeado"] = $_SESSION["usuario"];

        $this->renderer->render('partida', $data);

        if(isset($_SESSION["respuestaOKMessage"]) || isset($_SESSION["respuestaMALMessage"])) {
            $this->unsetVariablesSESSION();
        }
    }

    public function responder() {
        $reportado = $_GET["toggleReportar"] ?? null;
        $respuesta = $_GET["respuesta"] ?? null;
        $duracion = $_GET["tiempoRespuesta"] ?? 0;
        $this->partidaModel->guardarReporte($reportado, $_SESSION["pregunta"]["idPregunta"]);

        $this->verificarRespuesta($respuesta, intval($duracion));

        if( ! $this->estaJugando() ) {
            $datosPartida = [
                $_SESSION["usuario"]["idUsuario"],
                $_SESSION["partida"]["puntaje"],
                $_SESSION["partida"]["respuestasAcertadas"],
                round($_SESSION["partida"]["duracion"])
            ];

            unset($_SESSION["partida"]);
            $this->partidaModel->guardar($datosPartida);
        }

        header("Location: /partida");
    }

    private function estaJugando() {
        return ! ( (isset($_SESSION["respuestaMALMessage"])) );
    }

    private function verificarRespuesta($respuestaSeleccionada, $duracionRespuesta) {
        if( ! isset($_SESSION["partida"]) ) {
            $_SESSION["partida"] = $this->partidaModel->createPartidaInicial();
        }

        $_SESSION["respuestaElegida"] = $respuestaSeleccionada ?? null;
        if(isset($_SESSION["partida"]["duracion"])) {
            $_SESSION["partida"]["duracion"] += $duracionRespuesta;
        } else {
            $_SESSION["partida"]["duracion"] = $duracionRespuesta;
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

    public function unsetVariablesSESSION()
    {
        unset($_SESSION["pregunta"]);
        unset($_SESSION["respuestaOKMessage"]);
        unset($_SESSION["respuestaMALMessage"]);
        unset($_SESSION["respuestaElegida"]);
        unset($_SESSION["respuestas"]);
        unset($_SESSION["categoria"]);
        unset($_SESSION["tiempoInicioPartida"]);
    }

    private function hayRespuestaEnSesion() {
        return isset($_SESSION["respuestaOKMessage"]) || isset($_SESSION["respuestaMALMessage"]);
    }

    public function tiempoRestante() {
        if( !isset($_SESSION["tiempoInicioPartida"]) ) {
            $tiempoRestante = $this->TIEMPO_INICIAL;
        } else {
            $tiempoRestante = $this->TIEMPO_INICIAL - (microtime(true) * 1000 - $_SESSION["tiempoInicioPartida"]);
        }

        $response = [
            'tiempoRestante' => $tiempoRestante
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function iniciaTemporizadorEnSesion() {
        $_SESSION["tiempoInicioPartida"] = microtime(true) * 1000;
        echo true;
    }

    private function chequearTemporizador() {
        if(isset($_SESSION["tiempoInicioPartida"])) {
            $tiempoRestante = $this->TIEMPO_INICIAL - (microtime(true) * 1000 - $_SESSION["tiempoInicioPartida"]) - 1000;
            if($tiempoRestante <= 0) {
                $this->reiniciarPartida();
            }
        } else {
            $tiempoRestante = $this->TIEMPO_INICIAL;
        }

        return round($tiempoRestante / 1000);
    }

    public function reiniciarPartida() {
        $this->unsetVariablesSESSION();
        header("Location: /partida");
        exit();
    }

    public function borrarTemporizador() {
        unset($_SESSION["tiempoInicioPartida"]);
    }
}