<?php

class DatosLoginController
{
    private $datosLoginModel;
    private $renderer;
    private $fileManager;

    public function __construct($datosLoginModel, $renderer, $fileManager)
    {
        $this->datosLoginModel = $datosLoginModel;
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

    private function validarCampos(&$error) {
        $error .= $this->datosLoginModel->validarCamposConCriterios($_POST["Mail"], $_POST["NombreUsuario"], $_POST["Password"], $_POST["ConfirmarPassword"], $_FILES["FotoPerfil"]["name"]);
    }

    private function validarCamposPOST() {
        $error = "";

        if(isset($_POST["Mail"]) && isset($_POST["NombreUsuario"]) && isset($_POST["Password"]) && isset($_POST["ConfirmarPassword"]) && isset($_FILES["FotoPerfil"])) {
            $this->validarCampos($error);
            $this->validarNombreUsuarioQueNoSeaRepetido($_POST["NombreUsuario"], $error);
            $this->validarMailQueNoSeaRepetido($_POST["Mail"], $error);
        }

        return $error;
    }

    public function validar() {
        $error = $this->validarCamposPOST();

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

    private function validarNombreUsuarioQueNoSeaRepetido($NombreUsuario, &$error)
    {
        $error .= $this->datosLoginModel->getErrorSiNombreDeUsuarioEsRepetido($NombreUsuario);
    }

    private function validarMailQueNoSeaRepetido($Mail, &$error)
    {
        $error .= $this->datosLoginModel->getErrorSiMailEsRepetido($Mail);
    }
}