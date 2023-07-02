<?php

class CategoriasActivasModel
{
    private $database;
    private $ESTADO_ACTIVA = "ACEPTADA";
    private $MENSAJE_SIN_CATEGORIAS = "Sin categorias";
    private $ESTADO_ANULADA = "ANULADA";

    public function __construct($database){
        $this->database = $database;
    }

    public function findCategoriasActivas() {
        $sql = "SELECT idCategoria, descripcion FROM categoria_preguntas 
                WHERE idEstado = (
                    SELECT ep.idEstadoPregunta FROM estado_pregunta ep 
                    WHERE ep.descripcion = ?
                )";
        $result = $this->database->queryWthParameters($sql, $this->ESTADO_ACTIVA);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function verificarSiNoHayCategorias($categorias) {
        return empty($categorias) ? $this->MENSAJE_SIN_CATEGORIAS : false;
    }

    public function anularCategoria($idCategoria)
    {
        $sql = "UPDATE categoria_preguntas
                SET idEstado = (SELECT ep.idEstadoPregunta FROM estado_pregunta ep WHERE ep.descripcion = ?)
                WHERE idCategoria = ?";

        $datosAnular = [$this->ESTADO_ANULADA, $idCategoria];
        $typesParam = "si";
        $this->database->save($typesParam, $datosAnular, $sql);
    }
}