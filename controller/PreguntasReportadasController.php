<?php

class PreguntasReportadasController
{
    private $renderer;
    private $preguntasReportadasModel;

    public function __construct($preguntasReportadasModel, $renderer)
    {
        $this->renderer = $renderer;
        $this->preguntasReportadasModel = $preguntasReportadasModel;
    }
    public function list(){
        $data["usuarioLogeado"] = $_SESSION["usuario"];
        $data["preguntasReportadas"] = $this->preguntasReportadasModel->findPreguntasReportadas();
        $data["vistaPreguntasReportadas"] = true;
        $this->renderer->render('preguntasReportadas', $data);
    }
}