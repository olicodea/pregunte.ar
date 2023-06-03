<?php

class PartidaModel
{
    private $database;

    public function __construct($database){
        $this->database = $database;
    }

    public function findCategorias() {
        return $this->database->query("SELECT idCategoria, descripcion FROM categoria_preguntas");
    }

    public function findPreguntasDisponiblesPorIdCategoria($idCategoria) {
        $sql = "SELECT p.* FROM pregunta p WHERE idPregunta NOT IN ( SELECT idPregunta FROM pregunta_respondida ) AND p.idCategoria = $idCategoria";
        $resultado = $this->database->query($sql);
        return $resultado;
    }

    public function findRespuestaPorId($idRespuesta) {
        $sql = "SELECT * FROM respuesta r JOIN pregunta p ON p.idRespuesta = r.idRespuesta WHERE p.idRespuesta = $idRespuesta";
        $resultado = $this->database->query($sql);
        return $resultado;
    }

    //TODO: Hay que ver de hacer el metodo findPreguntasDisponiblesPorIdCategoria teniendo en cuenta la dificultad
}