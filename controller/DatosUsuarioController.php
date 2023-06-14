<?php
class DatosUsuarioController
{
    private $renderer;
    private $datosUsuarioModel;
    private $apiGoogleMaps;

    public function __construct($datosUsuarioModel, $renderer, $ApiGoogleMaps)
    {
        $this->renderer = $renderer;
        $this->datosUsuarioModel = $datosUsuarioModel;
        $this->apiGoogleMaps = $ApiGoogleMaps;
    }

    public function list()
    {
        $data["ApiGoogleMaps"] = $this->apiGoogleMaps;
        $data["NombreCompleto"] = $_SESSION["DatosUsuario"]["NombreCompleto"] ?? "";
        $data["FechaNacimiento"] = $_SESSION["DatosUsuario"]["FechaNacimiento"] ?? "";
        $data["Sexo"] = $_SESSION["DatosUsuario"]["Sexo"] ?? "";
        $data["PaisCiudad"] = $_SESSION["DatosUsuario"]["PaisCiudad"] ?? "";
        $data["sexos"] = $this->datosUsuarioModel->getSexos($data["Sexo"]);
        $data["errorMsgUsuario"] = $_SESSION["errorMsgUsuario"] ?? null;
        $data["latLong"] = $this->getLatitudLongitudSesion();

        $this->renderer->render("datosUsuario", $data);

        unset($_SESSION["errorMsgUsuario"]);
    }

    private function validarCamposPOST() {
        $error = "";

        if(isset($_POST["NombreCompleto"]) && isset($_POST["FechaNacimiento"]) && isset($_POST["Sexo"]) && isset($_POST["PaisCiudad"])) {
            $this->datosUsuarioModel->validarCamposConCriterios($error);
        }

        return $error;
    }

    public function guardarLatitudLongitud() {
        if (isset($_POST["dato"])) {
            $_SESSION["latitud"] = $_POST["dato"]["latitude"];
            $_SESSION["longitud"] = $_POST["dato"]["longitude"];
        }
    }

    public function validar() {
        $error = $this->validarCamposPOST();

        $_SESSION["DatosUsuario"] = [
            "NombreCompleto" => $_POST["NombreCompleto"],
            "FechaNacimiento" => $_POST["FechaNacimiento"],
            "Sexo" => $_POST["Sexo"],
            "PaisCiudad" => $_POST["PaisCiudad"],
            "latitud" => $_SESSION["latitud"],
            "longitud" => $_SESSION["longitud"]
        ];

        if(strlen($error) > 0) {
            $_SESSION["errorMsgUsuario"] = $error != "" ? $error : null;
            header("Location: /datosUsuario");
            exit();
        }
        $_SESSION["errorMsgUsuario"] = null;

        header("Location: /datosLogin");
    }

    private function getLatitudLongitudSesion()
    {
        if(isset($_SESSION["latitud"]) && isset($_SESSION["longitud"])){
            return [
                "latitud" => $_SESSION["latitud"],
                "longitud" => $_SESSION["longitud"]
            ];
        }
        return null;
    }
}