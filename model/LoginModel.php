<?php

class LoginModel{
    private $database;

    public function __construct($database){
        $this->database = $database;
    }

    //TODO: Consulta para traer el usuario por nombreDeUsuario
    public function autenticarUsuario($usuario, $password) {
        $sql = "SELECT * FROM usuario WHERE nombreDeUsuario = ?";
        $resultado = $this->database->queryWthParameters($sql, $usuario);
        $usuarioBD = mysqli_fetch_assoc($resultado);

        return $password == $usuarioBD["contrasenia"] ? $usuarioBD : "Usuario o contraseña incorrecto/s";
    }
}