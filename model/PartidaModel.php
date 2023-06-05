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
        // Esta linea mezcla al azar el array categorias
        shuffle($categorias);
        return $categorias;
    }

    private function findPreguntasDisponiblesPorIdCategoria($idCategoria) {
        $sql = "SELECT p.* FROM pregunta p WHERE idPregunta NOT IN ( SELECT idPregunta FROM pregunta_respondida ) AND p.idCategoria = $idCategoria";
        $resultado = $this->database->query($sql);
        return $resultado;
    }

    public function findRespuestaPorId($idRespuesta) {
        $sql = "SELECT r.respuestaA, r.respuestaB, r.respuestaC, r.respuestaD, r.respuestaCorrecta FROM respuesta r JOIN pregunta p ON p.idRespuesta = r.idRespuesta WHERE p.idRespuesta = $idRespuesta";
        $resultado = $this->database->query($sql);

        return $resultado;
    }

    //TODO: Hay que ver de hacer el metodo findPreguntasDisponiblesPorIdCategoria teniendo en cuenta la dificultad

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

    public function createPartidaInicial() {
        $partidaInicial = [
            "puntaje" => 0,
            "respuestasAcertadas" => 0
        ];
        return $partidaInicial;
    }

    public function updatePartidaActual(&$partida) {
        $partida["puntaje"] += 5;
        $partida["respuestasAcertadas"] ++;
    }

    public function guardarReporte($reportado, $idPregunta){
        if($reportado == "on") {
            $sql = "INSERT INTO `reporte`(`idPregunta`, `Comentario`) VALUES (?,?)";
            $typesParams = "is";
            $datosReporte = [
                $idPregunta,
                "Pregunta reportada" //TODO: por ahora se hardcodea el comentario. Luego se agregara la funcionalidad de comentar un reporte
            ];
            $this->database->save($typesParams, $datosReporte, $sql);
        }
    }

    public function getRespuestasAMostrar($respuestas) {
        $respuestasAMostrar = [];

        foreach($respuestas as $clave => $respuesta) {
            if($clave != "respuestaCorrecta") {
                $respuestasAMostrar[] = [
                    "respuesta" => [
                        "respuesta" => $respuesta,
                        "esCorrecta" => false,
                        "esIncorrecta" => false,
                        "esDisabled" => false
                    ]
                ];
            }
        }

        return $respuestasAMostrar;
    }

    public function getRespuestasAMarcarComoCorrectaIncorrectaYDisabled($respuestas, $respuestaElegida, $respuestaCorrecta) {
        $respuestasAMotrarMarcadas = [];

        foreach($respuestas as $clave => $respuesta) {
            if($clave != "respuestaCorrecta") {
                $respuestasAMotrarMarcadas[] = [
                    "respuesta" => [
                        "respuesta" => $respuesta,
                        "esCorrecta" =>  $this->verificarRespuestaCorrecta($respuesta, $respuestaCorrecta, $respuestaElegida),
                        "esIncorrecta" => $this->verificarRespuestaIncorrecta($respuesta, $respuestaElegida, $respuestaCorrecta),
                        "esDisabled" => $this->verificarRespuestaDisabled($respuesta, $respuestaElegida, $respuestaCorrecta)
                    ]
                ];
            }
        }

        return $respuestasAMotrarMarcadas;
    }

    private function verificarRespuestaCorrecta($respuesta, $respuestaCorrecta, $respuestaElegida)
    {
        if($respuesta == $respuestaCorrecta && $respuestaCorrecta == $respuestaElegida) {
            return true;
        }

        if($respuesta == $respuestaCorrecta) {
            return true;
        }

        return false;
    }

    private function verificarRespuestaIncorrecta($respuesta, $respuestaElegida, $respuestaCorrecta)
    {
        if ($respuesta == $respuestaElegida && $respuestaElegida != $respuestaCorrecta) {
            return true;
        }

        return false;
    }

    private function verificarRespuestaDisabled($respuesta, $respuestaElegida, $respuestaCorrecta)
    {
        if($respuesta != $respuestaCorrecta && $respuestaElegida != $respuestaCorrecta && $respuesta != $respuestaElegida) {
            return true;
        }

        if($respuesta != $respuestaCorrecta && $respuesta != $respuestaElegida) {
            return true;
        }

        return false;
    }
}