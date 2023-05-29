<?php

class RegistroController
{
    private $registroModel;
    private $renderer;

    public function __construct($registroModel, $renderer)
    {
        $this->renderer = $renderer;
        $this->registroModel = $registroModel;
    }

    public function list()
    {
        $this->renderer->render("registro");
    }

    public function guardar()
    {
        $datosRegistro = [
            $_SESSION["NombreCompleto"],
            $_SESSION["FechaNacimiento"],
            $_SESSION["Sexo"],
            $_SESSION["PaisCiudad"],
            $_SESSION["Mail"],
            $_SESSION["NombreUsuario"],
            $_SESSION["Password"],
            "TEST",
        ];

        $result = $this->registroModel->guardar($datosRegistro);
        if($result) {
            echo "GUARDADO";
            session_destroy();
            exit();
        }

        echo "PROBLEMA AL GUARDAR";
    }

    public function delete()
    {
        die('llame a delete');
    }
}