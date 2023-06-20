<?php

class DatosLoginModel
{
    private $database;
    private $mailREGEX = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
    private $nombreUsuarioREGEX = '/^[a-zA-Z0-9]+$/';
    private $passwordREGEX = '/^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,16}$/';

    private $extensionImagenREGEX = '/^.*\.(png|jpg)$/i';

    public function __construct($database) {
        $this->database = $database;
    }

    public function validarCamposConCriterios($mail, $nombreUsuario, $password, $confirmarPassword, $fotoPerfil) {
        $error = "";

        if(!preg_match($this->mailREGEX, $mail)) {
            $error .= "El mail no es válido. ";
        }

        if(!preg_match($this->nombreUsuarioREGEX, $nombreUsuario)) {
            $error .= "El nombre de usuario no es válida. ";
        }

        if(!preg_match($this->passwordREGEX, $password)) {
            $error .= "El password no es válido. ";
        }

        if(!preg_match($this->passwordREGEX, $confirmarPassword)) {
            $error .= "La confirmación de password no es válida. ";
        }

        if($password != $confirmarPassword) {
            $error .= "Las contraseñas no coinciden. ";
        }

        if(!preg_match($this->extensionImagenREGEX, $fotoPerfil)){
            $error .= "La imagen no es válida. Debe ser .jpg o .png. ";
        }

        return $error;
    }
    public function getErrorSiNombreDeUsuarioEsRepetido($NombreUsuario) {
        $sql = "SELECT COUNT(*) as contUsuario FROM usuario WHERE nombreDeUsuario = ?";
        $resultado = mysqli_fetch_assoc($this->database->queryWthParameters($sql, $NombreUsuario));
        if($resultado["contUsuario"] > 0) {
            return "El nombre de usuario $NombreUsuario no se encuentra disponible. ";
        }
        return "";
    }

    public function getErrorSiMailEsRepetido($Mail) {
        $sql = "SELECT COUNT(*) as contMail FROM usuario WHERE mail = ?";
        $resultado = mysqli_fetch_assoc($this->database->queryWthParameters($sql, $Mail));
        if($resultado["contMail"] > 0) {
            return "El email $Mail no se encuentra disponible. ";
        }
        return "";
    }
}