<?php

class LoginModel{
    private $database;

    public function __construct($database){
        $this->database = $database;
    }

    public function autenticarUsuario($usuario, $password) {
        $sql = "SELECT * FROM usuario WHERE nombreDeUsuario = ?";
        $resultado = $this->database->queryWthParameters($sql, $usuario);
        $usuarioBD = mysqli_fetch_assoc($resultado);
        $passwordhasheadea = md5($password);
        //TODO: validar el rol del usuario que sea diferente a NoValidado

        return  $passwordhasheadea  == $usuarioBD["contrasenia"] ? $usuarioBD : false;

    }
}