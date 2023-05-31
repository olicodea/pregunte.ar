<?php

class DatosLoginController
{
    private $renderer;
    private $fileManager;
    private $mailREGEX = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
    private $nombreUsuarioREGEX = '/^[a-zA-Z0-9]+$/';
    private $passwordREGEX = '/^(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}$/';

    private $extensionImagenREGEX = '/^.*\.(png|jpg)$/i';
    public function __construct($renderer, $fileManager)
    {
        $this->renderer = $renderer;
        $this->fileManager = $fileManager;
    }

    public function list()
    {
        $data["Mail"] = $_SESSION["DatosLogin"]["Mail"] ?? "";
        $data["NombreUsuario"] = $_SESSION["DatosLogin"]["NombreUsuario"] ?? "";
        $data["Password"] = $_SESSION["DatosLogin"]["Password"] ?? "";
        $data["ConfirmarPassword"] = $_SESSION["DatosLogin"]["ConfirmarPassword"] ?? "";
        $data["errorMsgLogin"] = $_SESSION["errorMsgLogin"] ?? null;

        $this->renderer->render("datosLogin", $data);
        unset($_SESSION["errorMsgLogin"]);
    }

    public function validar() {
        $error = "";

        if(isset($_POST["Mail"]) && isset($_POST["NombreUsuario"]) && isset($_POST["Password"]) && isset($_POST["ConfirmarPassword"]) && isset($_FILES["FotoPerfil"])) {
            if(!preg_match($this->mailREGEX, $_POST["Mail"])) {
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

            if(!preg_match($this->extensionImagenREGEX, $_FILES["FotoPerfil"]["name"])){
                $error .= "La imagen no es válida. Debe ser .jpg o .png";
            }
        }

        $_SESSION["DatosLogin"] = [
            "Mail" => $_POST["Mail"],
            "NombreUsuario" => $_POST["NombreUsuario"],
            "Password" => $_POST["Password"],
            "ConfirmarPassword" => $_POST["ConfirmarPassword"],
            "FotoPerfil" => $this->fileManager->guardarImagen($_FILES["FotoPerfil"], $_POST["NombreUsuario"])
        ];

        if(strlen($error) > 0) {
            $_SESSION["errorMsgLogin"] = $error != "" ? $error : null;
            header("Location: /datosLogin");
            exit();
        }

        $_SESSION["errorMsgLogin"] = null;
        header("Location: /registro");
    }
}