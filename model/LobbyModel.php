<?php

class LobbyModel
{

    private $database;

    public function __construct($database){
        $this->database = $database;
    }

    public function getLobby($user){
        $query = "SELECT u.nombreDeUsuario, r.puntajeTotal, r.puesto
                  FROM usuario u
                  LEFT JOIN ranking r ON r.idUsuario = u.idUsuario
                  WHERE u.nombreDeUsuario = ?";

        return $this->database->queryWthParameters($query, $user);
    }
}