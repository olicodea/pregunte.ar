<?php

class MailValidationModel
{
    private $database;

    public function __construct($database) {
        $this->database = $database;
    }

    public function getValidation($validationCode) {
        return $this->database->queryWthParameters('SELECT * FROM validaciones where codigo = ?', $validationCode);
    }

    public function deleteValidation($idUser) {
        $this->database->queryWthParameters("DELETE FROM validaciones WHERE idUsuario = ?", $idUser);
    }
}