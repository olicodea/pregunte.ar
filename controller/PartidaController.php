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
        $data["jugando"] = true;
        $data["respuestaOK"] = $_SESSION["respuestaOK"] ?? null;
        $data["respuestaOKMessage"] = $_SESSION["respuestaOK"] ? "CORRECTO!" : null;
        $this->renderer->render('partida', $data);
    }

    public function responder() {
        $respuestaSeleccionada = $_GET["respuesta"];
        if($respuestaSeleccionada == "Blanco"){
            $_SESSION["respuestaOK"] = true;
        }
        header("Location: /partida");
        exit();
    }
}