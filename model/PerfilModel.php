<?php

class PerfilModel{

    private $database;

    public function __construct($database) {
        $this->database = $database;
    }

    public function getPerfil($user) {
        $query = "SELECT u.nombreDeUsuario, u.nombreCompleto, u.fotoDePerfil, SUM(p.puntaje) as puntaje, COUNT(p.idUsuario) as 'partidasJugadas', u.latitud, u.longitud
                                        FROM usuario u
                                        LEFT JOIN partida p
                                        ON p.idUsuario = u.idUsuario
                                        WHERE u.nombreDeUsuario = ?";

        return $this->database->queryWthParameters($query, $user);
    }

    public function getUsuario($user) {
        $sql = "SELECT * FROM usuario WHERE nombreDeUsuario = ?";
        return mysqli_fetch_assoc($this->database->queryWthParameters($sql, $user));
    }
}