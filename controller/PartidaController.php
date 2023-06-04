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
        $data["respuestas"] = $_SESSION["respuestas"] ?? [];
        $data["respuestaOKMessage"] = $_SESSION["respuestaOKMessage"] ?? null;
        $data["respuestaMALMessage"] = $_SESSION["respuestaMALMessage"] ?? null;

        $this->renderer->render('partida', $data);

        if(isset($_SESSION["respuestaOKMessage"]) || isset($_SESSION["respuestaMALMessage"])) {
            unset($_SESSION["pregunta"]);
            unset($_SESSION["respuestaOKMessage"]);
            unset($_SESSION["respuestaMALMessage"]);
        }
    }

    public function responder() {
        $this->partidaModel->guardarPreguntaRespondida($_SESSION["pregunta"]["idPregunta"], $_SESSION["usuario"]["idUsuario"]);
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
        if( ! isset($_SESSION["partida"]) ) {
            $_SESSION["partida"] = $this->partidaModel->createPartidaInicial();
        }

        //TODO: Cambiar el PartidaModel para no tener que accede a ["respuestas"][0]
        if($respuestaSeleccionada == $_SESSION["respuestas"][0]["respuestaCorrecta"]) {
            $_SESSION["respuestaOKMessage"] = "¡CORRECTO!";
            $this->partidaModel->updatePartidaActual($_SESSION["partida"]);
        } else {
            $_SESSION["respuestaMALMessage"] = "LA PARTIDA TERMINO";
        }
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
        $preguntaSiguiente = $this->partidaModel->getPreguntaSiguiente($categoriaSiguiente["idCategoria"]);

        return $preguntaSiguiente;
    }

    private function chequearArrayCategorias() {
        if(empty($_SESSION["categorias"])) {
            unset($_SESSION["categorias"]);
        }
    }
}