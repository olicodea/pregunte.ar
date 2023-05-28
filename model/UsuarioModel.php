<?php

class UsuarioModel
{
    private $database;

    public function __construct($database) {
        $this->database = $database;
    }

    public function validateUserMail($usuaername) {
        //todo actualizar el usuario de la tabla
        die("Actualizar campo validar del mail");

    }
}