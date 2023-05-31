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
        $data["errorMsgRegistro"] = $_SESSION["errorMsgRegistro"] ?? null;
        $this->renderer->render("registro", $data);
        unset($_SESSION["errorMsgRegistro"]);
    }

    public function guardar()
    {
        if(!isset($_SESSION["DatosUsuario"]) || !isset($_SESSION["DatosLogin"])) {
            $_SESSION["errorMsgRegistro"] = "Para registrarse es necesario completar todos los datos";
            header("Location: /registro");
            exit();
        }
        unset($_SESSION["errorMsgRegistro"]);

        list($pais, $ciudad) = explode(", ", $_SESSION["DatosUsuario"]["PaisCiudad"]);

        $passwordHasheada = md5($_SESSION["DatosLogin"]["Password"]);

        $datosRegistro = [
            $_SESSION["DatosUsuario"]["NombreCompleto"],
            $_SESSION["DatosUsuario"]["FechaNacimiento"],
            $_SESSION["DatosUsuario"]["Sexo"],
            $pais,
            $ciudad,
            $_SESSION["DatosLogin"]["Mail"],
            $_SESSION["DatosLogin"]["NombreUsuario"],
            $passwordHasheada,
            $_SESSION["DatosLogin"]["FotoPerfil"],
        ];

        $result = $this->registroModel->guardar($datosRegistro);

        if($result) {
            header("Location: /");
            session_destroy();
            exit();
        }
    }
}