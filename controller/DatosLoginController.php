<?php

class DatosLoginController
{
    private $renderer;
    private $datosLoginModel;

    private $fileManager;
    private $mailREGEX = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
    private $nombreUsuarioREGEX = '/^[a-zA-Z0-9]+$/';
    private $passwordREGEX = '/^(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}$/';

    private $extensionImagenREGEX = '/^.*\.(png|jpg)$/i';
    public function __construct($datosLoginModel, $renderer, $fileManager)
    {
        $this->renderer = $renderer;
        $this->datosLoginModel = $datosLoginModel;
        $this->fileManager = $fileManager;
    }

    public function list()
    {
        $data["Mail"] = $_SESSION["Mail"] ?? "";
        $data["NombreUsuario"] = $_SESSION["NombreUsuario"] ?? "";
        $data["Password"] = $_SESSION["Password"] ?? "";
        $data["ConfirmarPassword"] = $_SESSION["ConfirmarPassword"] ?? "";
        $data["errorMsgLogin"] = $_SESSION["errorMsgLogin"] ?? null;

        $this->renderer->render("datosLogin", $data);
    }

    public function validar() {
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

        $_SESSION["Mail"] = $_POST["Mail"];
        $_SESSION["NombreUsuario"] = $_POST["NombreUsuario"];
        $_SESSION["Password"] = $_POST["Password"];
        $_SESSION["ConfirmarPassword"] = $_POST["ConfirmarPassword"];
        $_SESSION["FotoPerfil"] = $this->fileManager->guardarImagen($_FILES["FotoPerfil"], $_SESSION["NombreUsuario"]);
        //TODO: Hacer que la notificacion desaparezca despues de "x" segundos

        if(strlen($error) > 0) {
            $_SESSION["errorMsgLogin"] = $error != "" ? $error : null;
            header("Location: /datosLogin");
            return;
        }

        header("Location: /registro");
    }
}