<?php

class UsuarioModel
{
    private $database;

    public function __construct($database) {
        $this->database = $database;
    }

    public function validateUserMail($idUser) {
        $this->database->queryWthParameters("UPDATE usuario SET mailValidado = TRUE WHERE idUsuario = ?", $idUser);

    }
}