<?php

class CategoriaModel
{
    private $database;

    public function __construct($database){
        $this->database = $database;
    }

    public function guardarCategoria($color, $nombreCategoria, $idRolUsuario, $idCategoria = null) {
        $idEstado = $this->getIdEstadoAGuardarPorIdRol($idRolUsuario);
        $datosAGuardar = $this->cargarDatosCategoria($nombreCategoria, $color, $idEstado, $idCategoria);
        $this->guardar($datosAGuardar, $idCategoria);
    }

    private function getIdEstadoAGuardarPorIdRol($idRolUsuario)
    {
        $sql = "SELECT r.descripcion FROM rol r WHERE r.idRol = ?";
        $result = mysqli_fetch_assoc($this->database->queryWthParameters($sql, $idRolUsuario));
        $estado = $this->getEstadoPorRol($result["descripcion"]);
        return $this->getIdEstadoPorDescripcion($estado);
    }

    private function getEstadoPorRol($descripcion)
    {
        switch ($descripcion) {
            case "Jugador":
                return "PARA REVISAR";
            case "Editor":
                return "ACEPTADA";
        }
    }

    private function getIdEstadoPorDescripcion(string $estado)
    {
        $sql = "SELECT ep.idEstadoPregunta FROM estado_pregunta ep WHERE ep.descripcion like ?";
        $result = mysqli_fetch_assoc($this->database->queryWthParameters($sql, $estado));
        return $result["idEstadoPregunta"];
    }

    private function cargarDatosCategoria($nombreCategoria, $color, $idEstado, $idCategoria = null)
    {
        $datosAGuardar = [$nombreCategoria, $color, $idEstado];

        if($idCategoria) {
            $datosAGuardar[] = $idCategoria;
        }

        return $datosAGuardar;
    }

    private function guardar($datosAGuardar, $idCategoria)
    {
        if($idCategoria) {
            $sql = "UPDATE categoria_preguntas SET descripcion = ?, color = ?, idEstado = ?
                    WHERE idCategoria = ?";
        } else {
            $sql = "INSERT INTO categoria_preguntas (descripcion, color, idEstado) 
                VALUES (?, ?, ?)";
        }

        $typesParams = "ssi";

        $this->database->save($typesParams, $datosAGuardar, $sql);
    }
}