<?php

class LobbyModel
{

    private $database;

    public function __construct($database){
        $this->database = $database;
    }

    public function getLobbyData($user){
        $query = "SELECT u.nombreDeUsuario, r.puntaje, r.puesto
                  FROM usuario u
                  LEFT JOIN ranking r ON r.idUsuario = u.idUsuario
                  WHERE u.nombreDeUsuario = ?";

        $result =  $this->database->queryWthParameters($query, $user);
        return mysqli_fetch_assoc($result);
    }
    public function getLobbyPartidasJugadas($user){
        $query = "SELECT p.idPartida as 'Partidas Jugadas', p.puntaje
                    FROM partida p
                    LEFT JOIN usuario u
                    ON p.idUsuario = u.idUsuario
                    WHERE u.nombreDeUsuario = ?
                    ORDER BY p.idPartida DESC";

        return $this->database->queryWthParameters($query, $user);
    }
}