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

    public function comentariosReportesPorIdPregunta() {
        $comentarios = $this->preguntasReportadasModel->findComentariosReportesPorIdPregunta($_POST["idPregunta"]);
        header('Content-Type: application/json');
        echo json_encode($comentarios);
    }

    public function rechazarReporte() {
        $this->preguntasReportadasModel->rechazarReporte($_POST["idPregunta"]);
        echo true;
    }
}