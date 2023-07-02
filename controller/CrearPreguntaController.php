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
        $data["pregunta"] = $_SESSION["preguntaCargada"]["pregunta"] ?? null;
        $data["respuestaA"] = $_SESSION["respuestas"]["respuestaA"] ?? null;
        $data["respuestaB"] = $_SESSION["respuestas"]["respuestaB"] ?? null;
        $data["respuestaC"] = $_SESSION["respuestas"]["respuestaC"] ?? null;
        $data["respuestaD"] = $_SESSION["respuestas"]["respuestaD"] ?? null;
        $data["respuestaCorrectaCrear"] = $_SESSION["respuestas"]["respuestaCorrecta"] ?? null;

        $data["okMessage"] = $_SESSION["guardadoOkMessage"] ?? null;
        $data["errorMessage"] = $_SESSION["errorMsgCrearPregunta"] ?? null;

        $this->renderer->render('crearPregunta', $data);

        unset($_SESSION["errorMsgCrearPregunta"]);
        $this->unsetSessionVariablesPorMessageOk();
    }

    public function guardar() {
        if($this->validarPostSeteados())
        {
            $this->crearPreguntaModel->guardar($_SESSION["usuario"]["idUsuario"], $_SESSION["usuario"]["idRol"], $_POST["categoria"], $_POST["pregunta"], $_POST["respuestaA"], $_POST["respuestaB"], $_POST["respuestaC"], $_POST["respuestaD"], $_POST["respuestaCorrecta"], $this->chequearIdPregunta());
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

    public function comenzarEdicion() {
        $idPregunta = $_GET["idPregunta"] ?? null;

        if($idPregunta) {
            $_SESSION["preguntaCargada"] = $this->crearPreguntaModel->findPreguntaPorIdPregunta($idPregunta);
            $_SESSION["categoriaSeleccionada"] = $_SESSION["preguntaCargada"]["idCategoria"];
            $_SESSION["respuestas"] = $this->crearPreguntaModel->findRespuestasPorIdRespuesta($_SESSION["preguntaCargada"]["idRespuesta"]);
        }

        header("Location: /crearPregunta");
    }

    private function chequearIdPregunta()
    {
        return $_SESSION["preguntaCargada"]["idPregunta"] ?? null;
    }

    private function unsetSessionVariablesPorMessageOk()
    {
        if(isset($_SESSION["guardadoOkMessage"])) {
            unset($_SESSION["guardadoOkMessage"]);
            unset($_SESSION["preguntaCargada"]);
            unset($_SESSION["categoriaSeleccionada"]);
            unset($_SESSION["respuestas"]);
        }
    }
}