<?php

class DatosLoginController
{
    private $renderer;
    private $datosLoginModel;
    private $mailREGEX = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
    private $nombreUsuarioREGEX = '/^[a-zA-Z0-9]+$/';
    private $passwordREGEX = '/^(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}$/';

    private $extensionImagenREGEX = '/^.*\.(png|jpg)$/i';
    public function __construct($datosLoginModel, $renderer)
    {
        $this->renderer = $renderer;
        $this->datosLoginModel = $datosLoginModel;
    }

    public function list()
    {
        $mail = $_SESSION["Mail"] ?? "";
        $nombreUsuario = $_SESSION["NombreUsuario"] ?? "";
        $password = $_SESSION["Password"] ?? "";
        $confirmarPassword = $_SESSION["ConfirmarPassword"] ?? "";

        $data["Mail"] = $mail;
        $data["NombreUsuario"] = $nombreUsuario;
        $data["Password"] = $password;
        $data["ConfirmarPassword"] = $confirmarPassword;
        $this->renderer->render("datosLogin", $data);
    }

    public function validar() {
        //TODO: Falta validar Imagen/Foto de Perfil

        $error = "";

        if(isset($_POST["Mail"]) && isset($_POST["NombreUsuario"]) && isset($_POST["Password"]) && isset($_POST["ConfirmarPassword"])) {
            if(!preg_match($this->mailREGEX, $_POST["Mail"])){
                $error .= "El mail no es válido. ";
            }

            if(!preg_match($this->nombreUsuarioREGEX, $_POST["NombreUsuario"])) {
                $error .= "El nombre de usuario no es válida. ";
            }

            if(!preg_match($this->passwordREGEX, $_POST["Password"])) {
                $error .= "El password no es válido. ";
            }

            if(!preg_match($this->passwordREGEX, $_POST["ConfirmarPassword"])) {
                $error .= "La confirmación de password no es válida. ";
            }

            if($_POST["Password"] != $_POST["ConfirmarPassword"]) {
                $error .= "Las contraseñas no coinciden.";
            }
        }

        if($error != "") {
            die($error);
        }

        $_SESSION["Mail"] = $_POST["Mail"];
        $_SESSION["NombreUsuario"] = $_POST["NombreUsuario"];
        $_SESSION["Password"] = $_POST["Password"];
        $_SESSION["ConfirmarPassword"] = $_POST["ConfirmarPassword"];
        //TODO: Agregar logica de imagenes
        $_SESSION["ImagenURL"] = "TEST";

        header("Location: /registro");
    }
}