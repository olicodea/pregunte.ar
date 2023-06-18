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
        $data["guardadoOkMessage"] = $_SESSION["guardadoOkMessage"] ?? null;
        $data["errorMsgCrearPregunta"] = $_SESSION["errorMsgCrearPregunta"] ?? null;
        $this->renderer->render('crearPregunta', $data);

        unset($_SESSION["errorMsgCrearPregunta"]);
        unset($_SESSION["guardadoOkMessage"]);
    }

    public function guardar() {
        if($this->validarPostSeteados())
        {
            $this->crearPreguntaModel->guardar($_SESSION["usuario"]["idUsuario"], $_SESSION["usuario"]["idRol"], $_POST["categoria"], $_POST["pregunta"], $_POST["respuestaA"], $_POST["respuestaB"], $_POST["respuestaC"], $_POST["respuestaD"], $_POST["respuestaCorrecta"]);
            $_SESSION["guardadoOkMessage"] = "La pregunta se guardo correctamente.";
            header("Location: /crearPregunta");
            exit();
        }

        $this->setErrorMessageyReload();
    }

    private function validarPostSeteados()
    {
        return isset($_POST["categoria"]) && isset($_POST["pregunta"]) && isset($_POST["respuestaA"]) && isset($_POST["respuestaB"]) && isset($_POST["respuestaC"]) && isset($_POST["respuestaD"]) && isset($_POST["respuestaCorrecta"]);
    }

    private function setErrorMessageyReload()
    {
        $this->guardarCategoriaSeleccionadaEnSESSION();

        $_SESSION["errorMsgCrearPregunta"] = "Todos los campos deben estar completos";
        header("Location: /crearPregunta");
    }

    private function guardarCategoriaSeleccionadaEnSESSION()
    {
        if(isset($_POST["categoria"]))
        {
            $_SESSION["categoriaSeleccionada"] = $_POST["categoria"];
        }
    }

}