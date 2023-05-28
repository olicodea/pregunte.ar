<?php

class MailValidationModel
{
    private $database;

    public function __construct($database) {
        $this->database = $database;
    }

    public function getValidation($validationCode) {
        return $this->database->queryWthParameters('SELECT * FROM validations where validationCode = ?', $validationCode);

    }
}