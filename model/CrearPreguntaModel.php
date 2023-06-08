<?php

class CrearPreguntaModel
{
    private $database;

    public function __construct($database) {
        $this->database = $database;
    }

    public function findCategoriasPreguntas($categoriaSeleccionada = null) {
        $sql = "SELECT * FROM `categoria_preguntas`";
        $resultado = $this->database->query($sql);

        $categorias = [];

        foreach ($resultado as $item) {
            $categorias[] = [
                "idCategoria" => $item["idCategoria"],
                "descripcion" => $item["descripcion"],
                "selected" => $categoriaSeleccionada != null ? $this->chequearSelected($item["idCategoria"], $categoriaSeleccionada) : ""
            ];
        }
        return $categorias;
    }

    public function guardar($idUsuario, $idCategoria, $pregunta, $respuestaA, $respuestaB, $respuestaC, $respuestaD, $respuestaCorrecta) {
        $datosRespuesta = [$respuestaA, $respuestaB, $respuestaC, $respuestaD, $respuestaCorrecta];
        $idRespuesta = $this->guardarRespuesta($datosRespuesta);
        $idEstadoPregunta = 3; // TODO: Por ahora se hardcodea el idEstado, 3 es "PARA REVISAR", hay que hacer una consulta
        $idDificultad = 1; //TODO: Por ahora se hardcodea la dificultad, hay que ver como setearla
        $datosPregunta = [$pregunta, $idDificultad, $idCategoria, $idUsuario, $idRespuesta, $idEstadoPregunta];
        $this->guardarPregunta($datosPregunta);
    }

    private function chequearSelected($idCategoria, $categoriaSeleccionada)
    {
        if($idCategoria == $categoriaSeleccionada) {
            return "selected";
        }
        return "";
    }

    private function guardarRespuesta($datosRespuesta)
    {
        $sql = "INSERT INTO respuesta(respuestaA, respuestaB, respuestaC, respuestaD, respuestaCorrecta) 
        VALUES (?, ?, ?, ?, ?)";
        $typesParams = "sssss";
        $this->database->save($typesParams, $datosRespuesta, $sql);
        return $this->database->getLastInsertedId();
    }

    private function guardarPregunta($datosPregunta)
    {
        $sql = "INSERT INTO pregunta (pregunta, idDificultad, idCategoria, idUsuario, idRespuesta, idEstadoPregunta) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $typesParams = "siiiii";
        $this->database->save($typesParams, $datosPregunta, $sql);
    }
}