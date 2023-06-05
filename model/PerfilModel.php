<?php

class PerfilModel{

    private $database;

    public function __construct($database) {
        $this->database = $database;
    }

    public function getPerfil($user) {
        $query = "SELECT u.nombreDeUsuario, u.nombreCompleto, u.fotoDePerfil, r.puntaje, COUNT(p.idUsuario) as 'partidasJugadas'
                                        FROM usuario u
                                        LEFT JOIN ranking r
                                        ON r.idUsuario = u.idUsuario
                                        LEFT JOIN partida p
                                        ON p.idUsuario = u.idUsuario
                                        WHERE u.nombreDeUsuario = ?";

        return $this->database->queryWthParameters($query, $user);
    }
}