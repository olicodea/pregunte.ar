<?php

class RegistroModel {

    private $database;
    public function __construct($database) {
        $this->database = $database;
    }

    public function guardar($datosRegistro) {
        $sql = "INSERT INTO `usuario` (`nombreCompleto`, `fechaDeNacimiento`, `genero`, `paisCiudad`, `mail`, `nombreDeUsuario`, `pass`, `fotoDePerfil`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $typesParams = "ssssssss";
        $this->database->save($typesParams, $datosRegistro, $sql);
    }
}