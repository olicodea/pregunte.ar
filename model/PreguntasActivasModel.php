<?php

class PreguntasActivasModel
{
    private $database;
    private $ESTADO_PREGUNTAS = "ACEPTADA";
    private $ESTADO_ELIMINAR = "ANULADA";
    public function __construct($database)
    {
        $this->database = $database;
    }

    public function findPreguntasActivas() {
        $sql = "SELECT p.idPregunta, p.pregunta, ep.descripcion as estado, u.nombreDeUsuario as usuario, p.idCategoria, p.idRespuesta FROM pregunta p
                JOIN estado_pregunta ep on ep.idEstadoPregunta = p.idEstadoPregunta
                JOIN usuario u on u.idusuario = p.idUsuario
                WHERE ep.descripcion like ?";

        return mysqli_fetch_all($this->database->queryWthParameters($sql, $this->ESTADO_PREGUNTAS), MYSQLI_ASSOC);
    }

    public function findRespuestasPorIdRespuesta($idRespuesta)
    {
        $sql = "SELECT r.respuestaA, r.respuestaB, r.respuestaC, r.respuestaD, r.respuestaCorrecta
                FROM respuesta r WHERE r.idRespuesta = ?";

        $result = mysqli_fetch_assoc($this->database->queryWthParameters($sql, $idRespuesta));
        return $this->generarRespuestas($result);
    }

    public function anularPregunta($idPregunta, $decision)
    {
        $estadoFinal = $this->evaluarDecision($decision);
        $sql = "UPDATE pregunta p 
                SET p.idEstadoPregunta = (SELECT ep.idEstadoPregunta FROM estado_pregunta ep WHERE ep.descripcion = ?)
                WHERE p.idPregunta = ?";
        $datosAprobar = [$estadoFinal, $idPregunta];
        $typesParam = "si";
        $this->database->save($typesParam, $datosAprobar, $sql);
    }

    private function evaluarDecision($decision)
    {
        if($decision == "eliminar") {
            return $this->ESTADO_ELIMINAR;
        }
    }
}