<?php

class PreguntasSugeridasModel
{

    private $database;
    private $ESTADO_PREGUNTAS = "PARA REVISAR";
    public function __construct($database)
    {
        $this->database = $database;
    }

    public function findPreguntasSugeridas() {
        $sql = "SELECT idPregunta, pregunta, ep.descripcion as estado FROM pregunta p
                JOIN estado_pregunta ep on ep.idEstadoPregunta = p.idEstadoPregunta
                WHERE ep.descripcion like ?";

        return $this->database->queryWthParameters($sql, $this->ESTADO_PREGUNTAS);
    }
}