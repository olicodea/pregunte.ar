<?php

class CategoriasSugeridasModel
{
    private $database;
    private $ESTADO_SUGERIDA = "PARA REVISAR";
    private $ESTADO_APROBAR = "ACEPTADA";
    private $ESTADO_RECHAZAR = "RECHAZADA";

    public function __construct($database) {
        $this->database = $database;
    }

    public function findCategoriasSugeridas() {
        $sql = "SELECT idCategoria, descripcion, color FROM categoria_preguntas 
                WHERE idEstado = (
                    SELECT ep.idEstadoPregunta FROM estado_pregunta ep 
                    WHERE ep.descripcion = ?
                )";

        $result = $this->database->queryWthParameters($sql, $this->ESTADO_SUGERIDA);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function resolverRevisionCategoria($idCategoria, $decisionRevision)
    {
        $decision = $this->evaluarDecisionDeRevision($decisionRevision);
        $sql = "UPDATE categoria_preguntas cp 
                SET cp.idEstado = (SELECT ep.idEstadoPregunta FROM estado_pregunta ep WHERE ep.descripcion = ?)
                WHERE cp.idCategoria = ?";
        $datosAprobar = [$decision, $idCategoria];
        $typesParam = "si";
        $this->database->save($typesParam, $datosAprobar, $sql);
    }

    private function evaluarDecisionDeRevision($decisionRevision)
    {
        $estadoFinal = $this->ESTADO_SUGERIDA;

        if($decisionRevision == "aprobar") {
            $estadoFinal = $this->ESTADO_APROBAR;
        }

        if($decisionRevision == "rechazar") {
            $estadoFinal = $this->ESTADO_RECHAZAR;
        }

        return $estadoFinal;
    }
}