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
        $data["jugando"] = $this->estaJugando();
        $data["pregunta"] =  $_SESSION["pregunta"] ?? $this->generarPregunta();
        $data["respuestas"] = $_SESSION["respuestas"];
        $data["respuestaOKMessage"] = $_SESSION["respuestaOKMessage"] ?? null;
        $data["respuestaMALMessage"] = $_SESSION["respuestaMALMessage"] ?? null;

        $this->renderer->render('partida', $data);

        if(isset($_SESSION["respuestaOKMessage"]) || isset($_SESSION["respuestaMALMessage"])) {
            unset($_SESSION["pregunta"]);
        }

        unset($_SESSION["respuestaOKMessage"]);
        unset($_SESSION["respuestaMALMessage"]);
    }

    public function responder() {
        $this->verificarRespuesta($_GET["respuesta"]);

        $datosPartida = [
            $_SESSION["usuario"]["idUsuario"],
            $_SESSION["partida"]["puntaje"],
            $_SESSION["partida"]["respuestasAcertadas"],
            10 //TODO: Se hardcodea por ahora la duracion de partida
        ];

        if( ! $this->estaJugando() ) {
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
            $_SESSION["partida"] = [
                "puntaje" => 0,
                "respuestasAcertadas" => 0
            ];
        }

        //TODO: Cambiar el PartidaModel para no tener que accede a ["respuestas"][0]
        if($respuestaSeleccionada == $_SESSION["respuestas"][0]["respuestaCorrecta"]) {
            $_SESSION["respuestaOKMessage"] = "¡CORRECTO!";
            $_SESSION["partida"]["puntaje"] += 5;
            $_SESSION["partida"]["respuestasAcertadas"] += 1;
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

            //TODO: Cambiar el PartidaModel para no tener que accede a ["respuestas"][0]
            $respuestas = $this->partidaModel->findRespuestaPorId($preguntaSiguiente["idRespuesta"]);

            // Mezcla los elementos al azar
            shuffle($respuestas);

            $_SESSION["pregunta"] = $preguntaSiguiente;
            $_SESSION["respuestas"] = $respuestas;
        }

        return $_SESSION["pregunta"];
    }

    private function generarArrayCategorias()
    {
        $categorias = $this->partidaModel->findCategorias();

        // Mezcla los elementos al azar
        shuffle($categorias);

        return $categorias;
    }

    private function generarPreguntaPorCategoria()
    {
        //Agarra el primer item, lo retorno y lo borra del array
        $categoriaSiguiente = array_shift($_SESSION["categorias"]);

        $preguntasDisponibles = $this->partidaModel->findPreguntasDisponiblesPorIdCategoria($categoriaSiguiente["idCategoria"]);
        //TODO: Hay que ver despues el tema de la dificultad
        $indiceAleatorio = array_rand($preguntasDisponibles);
        $preguntaSiguiente = $preguntasDisponibles[$indiceAleatorio];

        return $preguntaSiguiente;
    }

    private function chequearArrayCategorias() {
        if(empty($_SESSION["categorias"])) {
            unset($_SESSION["categorias"]);
        }
    }
}