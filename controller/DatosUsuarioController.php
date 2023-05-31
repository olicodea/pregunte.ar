<?php
class DatosUsuarioController
{
    private $renderer;
    private $datosUsuarioModel;
    private $nombreCompletoREGEX = "/^[A-Za-z\s]+$/";
    private $sexoREGEX = "/^(Masculino|Femenino|No binario)$/";
    private $paisCiudadREGEX = "/^[a-zA-Z\s,áéíóúÁÉÍÓÚñÑ]+$/";
    public function __construct($datosUsuarioModel, $renderer)
    {
        $this->renderer = $renderer;
        $this->datosUsuarioModel = $datosUsuarioModel;
    }

    public function list()
    {
        $data["NombreCompleto"] = $_SESSION["DatosUsuario"]["NombreCompleto"] ?? "";
        $data["FechaNacimiento"] = $_SESSION["DatosUsuario"]["FechaNacimiento"] ?? "";
        $data["Sexo"] = $_SESSION["DatosUsuario"]["Sexo"] ?? "";
        $data["PaisCiudad"] = $_SESSION["DatosUsuario"]["PaisCiudad"] ?? "";
        $data["sexos"] = $this->datosUsuarioModel->getSexos($data["Sexo"]);
        $data["errorMsgUsuario"] = $_SESSION["errorMsgUsuario"] ?? null;
        $this->renderer->render("datosUsuario", $data);
        unset($_SESSION["errorMsgUsuario"]);
    }

    public function validar() {
        $error = "";

        if(isset($_POST["NombreCompleto"]) && isset($_POST["FechaNacimiento"]) && isset($_POST["Sexo"]) && isset($_POST["PaisCiudad"])) {
            if(!preg_match($this->nombreCompletoREGEX, $_POST["NombreCompleto"])){
                $error .= "El nombre no es válido. ";
            }

            if(!strtotime($_POST["FechaNacimiento"])) {
                $error .= "La fecha no es válida. ";
            }

            if(!preg_match($this->sexoREGEX, $_POST["Sexo"])) {
                $error .= "El sexo no es válido. ";
            }

            if(!preg_match($this->paisCiudadREGEX, $_POST["PaisCiudad"])) {
                echo $_POST["PaisCiudad"];
                $error .= "País/ciudad no es válido.";
            }
        }

        $_SESSION["DatosUsuario"] = [
            "NombreCompleto" => $_POST["NombreCompleto"],
            "FechaNacimiento" => $_POST["FechaNacimiento"],
            "Sexo" => $_POST["Sexo"],
            "PaisCiudad" => $_POST["PaisCiudad"]
        ];

        if(strlen($error) > 0) {
            $_SESSION["errorMsgUsuario"] = $error != "" ? $error : null;
            header("Location: /datosUsuario");
            exit();
        }
        $_SESSION["errorMsgUsuario"] = null;
        header("Location: /datosLogin");
    }
}