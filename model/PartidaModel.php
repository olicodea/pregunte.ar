<?php

class PartidaModel
{
    private $database;
    private $ESTADO_REPORTADA = "REPORTADA";
    private $CANTIDAD_PARA_ACEPTAR_REPORTE = 3;

    public function __construct($database){
        $this->database = $database;
    }

    public function findCategorias() {
        return $this->database->query("SELECT idCategoria, descripcion, color FROM categoria_preguntas");
    }

    public function findCategoriasAlAzar() {
        $categorias = $this->findCategorias();
        // Esta linea mezcla al azar el array categorias
        shuffle($categorias);
        return $categorias;
    }

    public function findRespuestaPorId($idRespuesta) {
        $sql = "SELECT r.respuestaA, r.respuestaB, r.respuestaC, r.respuestaD, r.respuestaCorrecta FROM respuesta r JOIN pregunta p ON p.idRespuesta = r.idRespuesta WHERE p.idRespuesta = $idRespuesta";
        $resultado = $this->database->query($sql);

        return $resultado;
    }

    public function guardar($datosPartida) {
        $this->guardarPartida($datosPartida);
    }

    private function guardarPartida($datosPartida)
    {
        $sql = "INSERT INTO partida (idUsuario, puntaje, cantidadDeRespuestasAcertadas, duracion) VALUES (?, ?, ?, ?)";
        $typesParams = "iiii";
        $this->database->save($typesParams, $datosPartida, $sql);
    }

    public function guardarPreguntaRespondida($idPregunta, $idusuario, $fueCorrecta) {
        $datosPreguntaRespondida = [ $idPregunta, $idusuario, $fueCorrecta ];
        $sql = "INSERT INTO `pregunta_respondida`(`idPregunta`, `idUsuario`, `fueCorrecta`) VALUES (?, ?, ?)";
        $typesParams = "iii";
        $this->database->save($typesParams, $datosPreguntaRespondida, $sql);
    }

    public function getCategoriaSiguiente(&$categorias) {
        return array_shift($categorias);
    }

    public function getPreguntaSiguiente($idCategoria, $idUsuario) {
        $preguntas = $this->findPreguntas($idCategoria, $idUsuario);
        $indiceAleatorio = array_rand($preguntas);
        $preguntaSiguiente = $preguntas[$indiceAleatorio];
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
            $this->chequearReportes($idPregunta);
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

    private function findPreguntas($idCategoria, $idUsuario)
    {
        $preguntasDisponibles = $this->findPreguntasDisponiblesPorIdCategoria($idCategoria, $idUsuario);
        $preguntasPorNivel = $this->definirPreguntasPorNivel($preguntasDisponibles, $idUsuario);

        if(count($preguntasPorNivel) > 0) {
            return $preguntasPorNivel;
        } else {
            return $preguntasDisponibles;
        }
    }

    private function findPreguntasDisponiblesPorIdCategoria($idCategoria, $idUsuario) {
        $sql = "SELECT p.idPregunta, p.pregunta, p.idCategoria, p.idUsuario, p.idRespuesta, p.idEstadoPregunta FROM pregunta p 
                WHERE p.idCategoria = $idCategoria
                AND NOT EXISTS ( SELECT 1 FROM pregunta_respondida pr WHERE pr.idPregunta = p.idPregunta AND pr.idUsuario = $idUsuario )";
        $resultado = $this->database->query($sql);
        return $this->getPreguntasCompletas($resultado);
    }

    private function definirPreguntasPorNivel($preguntasDisponibles, $idUsuario)
    {
        $nivelPreguntasUsuario = $this->definirNivelPreguntasUsuario($idUsuario);
        $preguntasFiltradas = array_filter($preguntasDisponibles, function ($pregunta) use ($nivelPreguntasUsuario){
            return $nivelPreguntasUsuario == $pregunta["dificultadPregunta"];
        });
        return $preguntasFiltradas;
    }

    private function definirNivelPreguntasUsuario($idUsuario)
    {
        $totalPreguntasContestadas = $this->findPreguntasContestadasPorUsuarioId($idUsuario);
        $totalPreguntasCorrectas = $this->findPreguntasContestadasCorrectamentePorUsuarioId($idUsuario);

        if($totalPreguntasContestadas > 0) {
            $porcentajeCorrectas = ($totalPreguntasCorrectas / $totalPreguntasContestadas) * 100;
        } else {
            return "MEDIA";
        }

        return $this->getDificultadPorPorcentaje($porcentajeCorrectas);
    }

    private function findPreguntasContestadasPorUsuarioId($idUsuario)
    {
        $sql = "SELECT COUNT(*) AS total_preguntas FROM pregunta_respondida WHERE idUsuario = ?";
        $resultado = mysqli_fetch_assoc($this->database->queryWthParameters($sql, $idUsuario));
        return $resultado["total_preguntas"];
    }

    private function findPreguntasContestadasCorrectamentePorUsuarioId($idUsuario)
    {
        $sql = "SELECT SUM(cantidadDeRespuestasAcertadas) AS total_correctas FROM partida WHERE idUsuario = ?";
        $resultado = mysqli_fetch_assoc($this->database->queryWthParameters($sql, $idUsuario));
        return $resultado["total_correctas"];
    }

    private function getPreguntasCompletas($preguntas)
    {
        $preguntasCompletas = [];
        foreach ($preguntas as $pregunta) {
            $preguntasCompletas[] = $this->generarPreguntaCompleta($pregunta);
        }
        return $preguntasCompletas;
    }

    private function generarPreguntaCompleta($pregunta)
    {
        $pregunta["dificultadPregunta"] = $this->definirDificultadPregunta($pregunta["idPregunta"]);
        return $pregunta;
    }

    private function definirDificultadPregunta($idPregunta)
    {
        $totalPreguntasContestadasPorIdPregunta = $this->findTotalDePreguntasContestadasPorIdPregunta($idPregunta);
        $totalPreguntasCorrectasPorIdPregunta = $this->findTotalPreguntasContestadasCorrectamentePorIdPregunta($idPregunta);

        if($totalPreguntasContestadasPorIdPregunta > 0) {
            $porcentajeCorrectas = ($totalPreguntasCorrectasPorIdPregunta / $totalPreguntasContestadasPorIdPregunta) * 100;
        } else {
            return "MEDIA";
        }

        return $this->getDificultadPorPorcentaje($porcentajeCorrectas);
    }

    private function findTotalDePreguntasContestadasPorIdPregunta($idPregunta)
    {
        $sql = "SELECT COUNT(*) AS total_preguntas FROM pregunta_respondida WHERE idPregunta = ?";
        $resultado = mysqli_fetch_assoc($this->database->queryWthParameters($sql, $idPregunta));
        return $resultado["total_preguntas"];
    }

    private function findTotalPreguntasContestadasCorrectamentePorIdPregunta($idPregunta)
    {
        $sql = "SELECT COUNT(*) AS total_correctas FROM pregunta_respondida WHERE idPregunta = ? AND fueCorrecta = 1";
        $resultado = mysqli_fetch_assoc($this->database->queryWthParameters($sql, $idPregunta));
        return $resultado["total_correctas"];
    }

    private function getDificultadPorPorcentaje($porcentaje)
    {
        switch ($porcentaje) {
            case $porcentaje >= 70:
                return "DIFÍCIL";
            case $porcentaje <= 30:
                return "FÁCIL";
            default:
                return "MEDIA";
        }
    }

    private function chequearReportes($idPregunta)
    {
        $sql = "SELECT COUNT(*) AS cantidadReportes FROM reporte WHERE idPregunta = ?";
        $result = mysqli_fetch_assoc($this->database->queryWthParameters($sql, $idPregunta));
        $cantidadReportes = $result["cantidadReportes"];

        if($cantidadReportes >= $this->CANTIDAD_PARA_ACEPTAR_REPORTE) {
            $this->cambiarEstadoAReportada($idPregunta);
        }
    }

    private function cambiarEstadoAReportada($idPregunta)
    {
        $sql = "UPDATE pregunta p 
                SET p.idEstadoPregunta = (SELECT ep.idEstadoPregunta FROM estado_pregunta ep WHERE ep.descripcion = ?) 
                WHERE p.idPregunta = ?";
        $typesParams = "si";
        $datosReporte = [$this->ESTADO_REPORTADA, $idPregunta];

        $this->database->save($typesParams, $datosReporte, $sql);
    }
}