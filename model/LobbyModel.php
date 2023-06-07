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
        $query = "SELECT p.puntaje, p.cantidadDeRespuestasAcertadas
                    FROM partida p
                    LEFT JOIN usuario u
                    ON p.idUsuario = u.idUsuario
                    WHERE u.nombreDeUsuario = ?
                    ORDER BY p.idPartida DESC";
        $resultado = $this->database->queryWthParameters($query, $user);
        $partidasJugadas = $this->crearArrayPartidas($resultado);

        return $partidasJugadas;
    }

    private function crearArrayPartidas($resultado)
    {
        $partidasJugadas = [];

        foreach ($resultado as $clave => $valor) {
            $partidasJugadas[] = [
                "nroPartida" => $clave + 1,
                "puntaje" => $valor["puntaje"],
                "cantidadDeRespuestasAcertadas" => $valor["cantidadDeRespuestasAcertadas"]
            ];
        }

        $partidasInvertidas = array_reverse($partidasJugadas);
        return $partidasInvertidas;
    }
}