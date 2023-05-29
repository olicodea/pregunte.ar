<?php
session_start();
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
        $nombreCompleto = $_SESSION["NombreCompleto"] ?? "";
        $fechaNacimiento = $_SESSION["FechaNacimiento"] ?? "";
        $sexo = $_SESSION["Sexo"] ?? "";
        $paisCiudad = $_SESSION["PaisCiudad"] ?? "";

        $data["NombreCompleto"] = $nombreCompleto;
        $data["FechaNacimiento"] = $fechaNacimiento;
        $data["Sexo"] = $sexo;
        $data["PaisCiudad"] = $paisCiudad;
        $data["sexos"] = $this->datosUsuarioModel->getSexos($sexo);
        $this->renderer->render("datosUsuario", $data);
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

        if($error != "") {
            die($error);
        }

        $_SESSION["NombreCompleto"] = $_POST["NombreCompleto"];
        $_SESSION["FechaNacimiento"] = $_POST["FechaNacimiento"];
        $_SESSION["Sexo"] = $_POST["Sexo"];
        $_SESSION["PaisCiudad"] = $_POST["PaisCiudad"];

        header("Location: /DatosLogin");
    }
}