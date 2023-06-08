<?php

class CrearPreguntaController
{
    private $renderer;
    private $crearPreguntaModel;

    public function __construct($crearPreguntaModel, $renderer)
    {
        $this->crearPreguntaModel = $crearPreguntaModel;
        $this->renderer = $renderer;
    }
    public function list() {
        $data["categorias"] = $this->crearPreguntaModel->findCategoriasPreguntas($_SESSION["categoriaSeleccionada"] ?? null);
        $data["errorMsgCrearPregunta"] = $_SESSION["errorMsgCrearPregunta"] ?? null;
        $this->renderer->render('crearPregunta', $data);

        unset($_SESSION["errorMsgCrearPregunta"]);
    }

    public function guardar() {
        if($this->validarPostSeteados())
        {
            $this->crearPreguntaModel->guardar($_SESSION["usuario"]["idUsuario"],$_POST["categoria"], $_POST["pregunta"], $_POST["respuestaA"], $_POST["respuestaB"], $_POST["respuestaC"], $_POST["respuestaD"], $_POST["respuestaCorrecta"]);
            header("Location: /lobby");
            exit();
        }

        if(isset($_POST["categoria"]))
        {
            $_SESSION["categoriaSeleccionada"] = $_POST["categoria"];
        }

        $_SESSION["errorMsgCrearPregunta"] = "Todos los campos deben estar completos";
        header("Location: /crearPregunta");
    }

    private function validarPostSeteados()
    {
        return isset($_POST["categoria"]) && isset($_POST["pregunta"]) && isset($_POST["respuestaA"]) && isset($_POST["respuestaB"]) && isset($_POST["respuestaC"]) && isset($_POST["respuestaD"]) && isset($_POST["respuestaCorrecta"]);
    }

}