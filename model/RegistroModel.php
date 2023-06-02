<?php

class RegistroModel {

    private $database;
    public function __construct($database) {
        $this->database = $database;
    }

    public function guardar($datosRegistro, $nombreUsuario) {
        $this->crearUsuario($datosRegistro);
        $usuario = $this->getIdUsuarioByNombreDeUsuario($nombreUsuario);
        $this->crearCodigoValidacion($usuario["idUsuario"]);
        $validacion = $this->getCodigoValidacionByIdUsuario($usuario["idUsuario"]);
        return $validacion["codigo"];
    }

    public function getMailValidacionSubject() {
        return "Validación de cuenta";
    }

    public function getMailValidacionMessage($codigo) {
        return "¡Gracias por registrarte! Haz click en el siguiente enlace para validar la cuenta: <a href='localhost/mailValidation/validate&codigo=$codigo'>Validar cuenta</a>";
    }

    private function crearCodigoValidacion($idUsuario) {
        $sql = "INSERT INTO `validaciones` (`idValidacion`, `codigo`, `idUsuario`) VALUES (NULL, ?, ?)";

        $random_string = uniqid(time(), true);
        $validation_code = md5($random_string);

        $typesParams = "si";
        $datosAInsertar = [$validation_code, $idUsuario];

        $this->database->save($typesParams, $datosAInsertar, $sql);
    }

    private function getIdUsuarioByNombreDeUsuario($nombreUsuario) {
        $sql = "SELECT idUsuario FROM usuario WHERE nombreDeUsuario = ?";
        $resultado = $this->database->queryWthParameters($sql, $nombreUsuario);
        return mysqli_fetch_assoc($resultado);
    }

    public function getCodigoValidacionByIdUsuario($idUsuario) {
        $sql = "SELECT codigo FROM validaciones WHERE idUsuario = ?";
        $resultado = $this->database->queryWthParameters($sql, $idUsuario);
        return mysqli_fetch_assoc($resultado);
    }

    private function crearUsuario($datosRegistro) {
        $sql = "INSERT INTO `usuario` (`nombreCompleto`, `fechaDeNacimiento`, `genero`, `pais`, `ciudad`, `mail`, `nombreDeUsuario`, `contrasenia`, `fotoDePerfil`, `idRol`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $typesParams = "sssssssssi";
        $this->database->save($typesParams, $datosRegistro, $sql);
    }
}