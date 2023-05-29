<?php

class PerfilModel{

    private $database;

    public function __construct($database) {
        $this->database = $database;
    }

    public function getPerfil($user) {
        return $this->database->query("SELECT u.nombreDeUsuario, u.nombreCompleto, u.fotoDePerfil, r.puntaje, COUNT(ej.idUsuario)
                                        FROM usuario u
                                        INNER JOIN ranking r
                                        ON r.idUsuario = u.idUsuario
                                        INNER JOIN estadisticas_jugadores ej
                                        ON ej.idUsuario = u.idUsuario
                                        WHERE u.nombreDeUsuario = '{$user}'");
    }

}