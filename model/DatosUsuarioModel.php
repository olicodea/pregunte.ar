<?php

class DatosUsuarioModel
{
    private $nombreCompletoREGEX = "/^[A-Za-z\s]+$/";
    private $sexoREGEX = "/^(Masculino|Femenino|No binario)$/";
    private $paisCiudadREGEX = "/^[a-zA-Z\s,áéíóúÁÉÍÓÚñÑ]+$/";
    private $sexos = [
        ["sexo" => "Masculino", "selected" => ""],
        ["sexo" => "Femenino", "selected" => ""],
        ["sexo" => "No binario", "selected" => ""]
    ];
    public function getSexos($sexoSeleccionado = null) {
        $this->setSexoSeleccionado($sexoSeleccionado);
        return $this->sexos;
    }

    private function setSexoSeleccionado($sexoSeleccionado = null) {
        foreach ($this->sexos as &$sexo) {
            if($sexo["sexo"] == $sexoSeleccionado){
                $sexo["selected"] = "selected";
            }
        }
    }

    public function validarCamposConCriterios(&$error) {
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
}