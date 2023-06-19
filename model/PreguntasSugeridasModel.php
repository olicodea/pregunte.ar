<?php

class PreguntasSugeridasModel
{

    private $database;
    private $ESTADO_PREGUNTAS = "PARA REVISAR";
    private $ESTADO_APROBAR = "ACEPTADA";
    private $ESTADO_RECHAZAR = "RECHAZADA";
    public function __construct($database)
    {
        $this->database = $database;
    }

    public function findPreguntasSugeridas() {
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

    public function resolverRevisionPregunta($idPregunta, $decisionRevision)
    {
        $decision = $this->evaluarDecisionDeRevision($decisionRevision);
        $sql = "UPDATE pregunta p 
                SET p.idEstadoPregunta = (SELECT ep.idEstadoPregunta FROM estado_pregunta ep WHERE ep.descripcion = ?)
                WHERE p.idPregunta = ?";
        $datosAprobar = [$decision, $idPregunta];
        $typesParam = "si";
        $this->database->save($typesParam, $datosAprobar, $sql);
    }

    private function generarRespuestas($result)
    {
        return [
            "respuestaA" => [
                "respuesta" => $result["respuestaA"],
                "esCorrecta" => $result["respuestaA"] == $result["respuestaCorrecta"]
            ],
            "respuestaB" => [
                "respuesta" => $result["respuestaB"],
                "esCorrecta" => $result["respuestaB"] == $result["respuestaCorrecta"]
            ],
            "respuestaC" => [
                "respuesta" => $result["respuestaC"],
                "esCorrecta" => $result["respuestaC"] == $result["respuestaCorrecta"]
            ],
            "respuestaD" => [
                "respuesta" => $result["respuestaD"],
                "esCorrecta" => $result["respuestaD"] == $result["respuestaCorrecta"]
            ]
        ];
    }

    private function evaluarDecisionDeRevision($decisionRevision)
    {
        if($decisionRevision == "aprobar") {
            return $this->ESTADO_APROBAR;
        }

        if($decisionRevision == "rechazar") {
            return $this->ESTADO_RECHAZAR;
        }
    }
}