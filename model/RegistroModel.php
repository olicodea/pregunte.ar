<?php

class RegistroModel {

    private $database;
    public function __construct($database) {
        $this->database = $database;
    }

    public function guardar($datosRegistro) {
        $sql = "INSERT INTO `usuario` (`nombreCompleto`, `fechaDeNacimiento`, `genero`, `pais`, `ciudad`, `mail`, `nombreDeUsuario`, `contrasenia`, `fotoDePerfil`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $typesParams = "sssssssss";
        $this->database->save($typesParams, $datosRegistro, $sql);
    }
}