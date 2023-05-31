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
        return true;
    }

    public function getMailValidacionSubject() {
        return "Validación de cuenta";
    }

    public function getMailValidacionMessage() {
        return "¡Gracias por registrarte! Haz click en el siguiente enlace para validar la cuenta: <a href='localhost/validarCuenta/validar&token=1234'>Validar cuenta</a>";
    }
}