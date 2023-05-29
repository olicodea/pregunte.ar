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
        list($pais, $ciudad) = explode(", ", $_SESSION["PaisCiudad"]);
        $datosRegistro = [
            $_SESSION["NombreCompleto"],
            $_SESSION["FechaNacimiento"],
            $_SESSION["Sexo"],
            $pais,
            $ciudad,
            $_SESSION["Mail"],
            $_SESSION["NombreUsuario"],
            $_SESSION["Password"],
            $_SESSION["FotoPerfil"],
        ];

        $result = $this->registroModel->guardar($datosRegistro);
        if($result) {
            header("Location: /registro");
            session_destroy();
            exit();
        }
    }
}