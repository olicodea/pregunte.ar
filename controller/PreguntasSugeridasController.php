<?php

class PreguntasSugeridasController
{
    private $renderer;
    private $preguntasSugeridasModel;

    public function __construct($preguntasSugeridasModel, $renderer)
    {
        $this->preguntasSugeridasModel = $preguntasSugeridasModel;
        $this->renderer = $renderer;
    }
    public function list(){
        $data["usuarioLogeado"] = $_SESSION["usuario"];
        $data["preguntas"] = $this->preguntasSugeridasModel->findPreguntasSugeridas();
        $this->renderer->render('preguntasSugeridas', $data);
    }
}