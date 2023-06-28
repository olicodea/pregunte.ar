<?php

class CrearPreguntaModel
{
    private $database;

    public function __construct($database) {
        $this->database = $database;
    }

    public function findCategoriasPreguntas($categoriaSeleccionada = null) {
        $sql = "SELECT * FROM `categoria_preguntas` WHERE idEstado = 1";
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

    public function guardar($idUsuario, $idRol, $idCategoria, $pregunta, $respuestaA, $respuestaB, $respuestaC, $respuestaD, $respuestaCorrecta, $idPregunta = null) {
        $datosRespuesta = [$respuestaA, $respuestaB, $respuestaC, $respuestaD, $$respuestaCorrecta];
        $idRespuesta = $this->guardarRespuesta($datosRespuesta);
        $idEstadoPregunta = $this->getIdEstadoAGuardarPorIdRol($idRol);
        $idDificultad = 1; //TODO: Por ahora se hardcodea la dificultad, hay que ver como setearla
        $datosPregunta = $this->cargarDatosPregunta($pregunta, $idDificultad, $idCategoria, $idUsuario, $idRespuesta, $idEstadoPregunta, $idPregunta);
        $this->guardarPregunta($datosPregunta, $idPregunta);
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

    private function guardarPregunta($datosPregunta, $idPregunta = null)
    {
        if($idPregunta) {
            $sql = "UPDATE pregunta SET pregunta = ?, idDificultad = ?, idCategoria = ?, idRespuesta = ?, idEstadoPregunta = ?
                    WHERE idPregunta = ?";
        } else {
            $sql = "INSERT INTO pregunta (pregunta, idDificultad, idCategoria, idUsuario, idRespuesta, idEstadoPregunta) 
                VALUES (?, ?, ?, ?, ?, ?)";
        }
        $typesParams = "siiiii";

        $this->database->save($typesParams, $datosPregunta, $sql);
    }

    private function getIdEstadoAGuardarPorIdRol($idRol)
    {
        $sql = "SELECT r.descripcion FROM rol r WHERE r.idRol = ?";
        $result = mysqli_fetch_assoc($this->database->queryWthParameters($sql, $idRol));
        $estado = $this->getEstadoPorRol($result["descripcion"]);
        $idEstadoAGuardar = $this->getIdEstadoPorDescripcion($estado);
        return $idEstadoAGuardar;
    }

    private function getEstadoPorRol($descripcion)
    {
        switch ($descripcion) {
            case "Jugador":
                return "PARA REVISAR";
            case "Editor":
                return "ACEPTADA";
        }
        return "PARA REVISAR";
    }

    private function getIdEstadoPorDescripcion($estado)
    {
        $sql = "SELECT ep.idEstadoPregunta FROM estado_pregunta ep WHERE ep.descripcion like ?";
        $result = mysqli_fetch_assoc($this->database->queryWthParameters($sql, $estado));
        return $result["idEstadoPregunta"];
    }

    public function findPreguntaPorIdPregunta($idPregunta) {
        $sql = "SELECT * FROM pregunta p WHERE p.idPregunta = ?";
        return mysqli_fetch_assoc($this->database->queryWthParameters($sql, $idPregunta));
    }

    public function findRespuestasPorIdRespuesta($idRespuesta) {
        $sql = "SELECT * FROM respuesta r WHERE r.idRespuesta = ?";
        return mysqli_fetch_assoc($this->database->queryWthParameters($sql, $idRespuesta));
    }

    private function cargarDatosPregunta($pregunta, $idDificultad, $idCategoria, $idUsuario, $idRespuesta, $idEstadoPregunta, $idPregunta = null)
    {
        if($idPregunta) {
            return [$pregunta, $idDificultad, $idCategoria, $idRespuesta, $idEstadoPregunta, $idPregunta];
        } else {
            return [$pregunta, $idDificultad, $idCategoria, $idUsuario, $idRespuesta, $idEstadoPregunta];
        }
    }
}