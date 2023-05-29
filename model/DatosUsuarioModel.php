<?php

class DatosUsuarioModel
{
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
}