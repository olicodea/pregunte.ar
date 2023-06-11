<?php

class RankingModel
{
    private $database;

    public function __construct($database){
        $this->database = $database;
    }
    public function armarRankingJugadores() {
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
}