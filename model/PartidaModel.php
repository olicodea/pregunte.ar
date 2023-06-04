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

    public function findCategoriasAlAzar() {
        $categorias = $this->findCategorias();
        $categoriasAlAzar = shuffle($categorias);
        return $categoriasAlAzar;
    }

    private function findPreguntasDisponiblesPorIdCategoria($idCategoria) {
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

    // PERSISTENCIA DE PARTIDA

    public function guardar($datosPartida) {
        $this->guardarPartida($datosPartida);
    }

    private function guardarPartida($datosPartida)
    {
        $sql = "INSERT INTO partida (idUsuario, puntaje, cantidadDeRespuestasAcertadas, duracion) VALUES (?, ?, ?, ?)";
        $typesParams = "iiis";
        $this->database->save($typesParams, $datosPartida, $sql);
    }

    public function guardarPreguntaRespondida($idPregunta, $idusuario) {
        $datosPreguntaRespondida = [ $idPregunta, $idusuario ];
        $sql = "INSERT INTO `pregunta_respondida`(`idPregunta`, `idUsuario`) VALUES (?,?)";
        $typesParams = "ii";
        $this->database->save($typesParams, $datosPreguntaRespondida, $sql);
    }


    private function guardarReporte($datosReporte){
        $sql = "INSERT INTO `reporte`(`idPregunta`, `Comentario`) VALUES (?,?)";
        $typesParams = "is";
        $this->database->save($typesParams, $datosReporte, $sql);
    }

    public function getCategoriaSiguiente(&$categorias) {
        return array_shift($categorias);
    }

    public function getPreguntaSiguiente($idCategoria) {
        $preguntasDisponibles = $this->findPreguntasDisponiblesPorIdCategoria($idCategoria);

        //TODO: Hay que ver despues el tema de la dificultad
        $indiceAleatorio = array_rand($preguntasDisponibles);
        $preguntaSiguiente = $preguntasDisponibles[$indiceAleatorio];

        return $preguntaSiguiente;
    }
}