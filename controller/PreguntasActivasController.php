<?php

class PreguntasActivasController
{
    private $renderer;
    private $preguntasActivasModel;

    public function __construct($preguntasActivasModel, $renderer)
    {
        $this->preguntasActivasModel = $preguntasActivasModel;
        $this->renderer = $renderer;
    }
    public function list(){
        $data["usuarioLogeado"] = $_SESSION["usuario"];
        $data["preguntasActivas"] = $this->preguntasActivasModel->findPreguntasActivas();
        $data["vistaPreguntasActivas"] = true;
        $this->renderer->render('preguntasActivas', $data);
    }

    public function findRespuestas() {
        $respuestas = $this->preguntasActivasModel->findRespuestasPorIdRespuesta($_GET["idRespuesta"]);
        header('Content-Type: application/json');
        echo json_encode($respuestas);
    }

    public function eliminarPregunta(){
        $this->preguntasActivasModel->anularPregunta($_POST["idPregunta"], "eliminar");
        echo true;
    }
}