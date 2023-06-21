<?php

class ApiModel{

    private $database;

    public function __construct($database){
        $this->database = $database;
    }

    public function findPreguntasPorIdCategoria($idCategoria) {
        $sql = "SELECT ph.idHome, ph.pregunta, ph.respuestaA, ph.respuestaB, ph.respuestaC, ph.respuestaD, ph.respuestaCorrecta FROM partida_home ph 
                WHERE ph.idCategoria = $idCategoria";

        $resultado = $this->database->query($sql);

        shuffle($resultado);

        return $resultado;
    }

}