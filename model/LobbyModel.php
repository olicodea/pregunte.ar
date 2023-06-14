<?php

class LobbyModel
{

    private $database;

    public function __construct($database){
        $this->database = $database;
    }

    public function getLobbyDataNew($idUsuario, $nombreUsuario) {
        $puestoUsuario = $this->getPuestoUsuario($nombreUsuario);
        $puntajeUsuario = $this->calcularPuntajeUsuario($idUsuario);

        $data = [
            "nombreDeUsuario" => $nombreUsuario,
            "puntaje" => $puntajeUsuario,
            "puesto" => $puestoUsuario
        ];

        return $data;
    }

    private function getPuestoUsuario($nombreUsuario) {
        $rankingJugadores = $this->generarRanking();

        foreach ($rankingJugadores as $rankingJugador) {
            if($rankingJugador["nombreDeUsuario"] === $nombreUsuario) {
                return $rankingJugador["puesto"];
            }
        }

        return "-";
    }

    private function calcularPuntajeUsuario($idUsuario) {
        $query = "SELECT SUM(puntaje) AS puntaje FROM partida WHERE idUsuario = ?";
        $result =  mysqli_fetch_assoc($this->database->queryWthParameters($query, $idUsuario));
        if($result["puntaje"] == null) {
            return 0;
        }
        return $result["puntaje"];
    }

    private function generarRanking()
    {
        $sql = "SELECT u.nombreDeUsuario, u.fotoDePerfil, SUM(p.puntaje) AS puntajeTotal, COUNT(p.idUsuario) AS cantidadPartidasJugadas
                FROM usuario u JOIN partida p ON u.idUsuario = p.idUsuario
                GROUP BY u.idUsuario, u.nombreDeUsuario, u.fotoDePerfil
                ORDER BY puntajeTotal DESC, cantidadPartidasJugadas ASC";

        $result = $this->database->query($sql);
        $jugadoresConPuesto = [];

        foreach ($result as $index => $item) {
            $jugadoresConPuesto[] = [
                "puesto" => $index + 1,
                "nombreDeUsuario" => $item["nombreDeUsuario"],
                "puntajeTotal" => $item["puntajeTotal"],
                "fotoDePerfil" => $item["fotoDePerfil"]
            ];
        }

        return $jugadoresConPuesto;
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
                    ORDER BY p.idPartida";
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