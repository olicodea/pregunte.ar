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
        $data["preguntas"] = $this->chequearPreguntasSugeridas();
        $data["sinPreguntas"] = $data["preguntas"] == null ? "Sin preguntas sugeridas" : false;
        $this->renderer->render('preguntasSugeridas', $data);
    }

    public function findRespuestas() {
        $respuestas = $this->preguntasSugeridasModel->findRespuestasPorIdRespuesta($_GET["idRespuesta"]);
        header('Content-Type: application/json');
        echo json_encode($respuestas);
    }

    public function aprobarPregunta() {
        $this->preguntasSugeridasModel->resolverRevisionPregunta($_POST["idPregunta"], "aprobar");
        echo true;
    }

    public function rechazarPregunta() {
        $this->preguntasSugeridasModel->resolverRevisionPregunta($_POST["idPregunta"], "rechazar");
        echo true;
    }

    private function chequearPreguntasSugeridas()
    {
        $preguntas = $this->preguntasSugeridasModel->findPreguntasSugeridas();
        return empty($preguntas) ? null : $preguntas;
    }
}