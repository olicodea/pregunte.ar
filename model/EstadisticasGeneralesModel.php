<?php

class EstadisticasGeneralesModel
{
    private $database;
    private $generadorGrafico;
    private $generadorPDF;
    private $tituloGraficoUsuarios = "Cantidad de usuarios totales";
    private $leyendaJugadoresTotales = "Usuarios Totales";
    private $leyendaJugadoresNuevos = "Usuarios Nuevos";
    private $tituloGraficoPreguntas = "Cantidad de preguntas totales y sugeridas";
    private $leyendaPreguntasTotales = "Preguntas Totales";
    private $leyendaPreguntasSugeridas = "Preguntas Sugeridas";

    private $tituloGraficoPartidas = "Cantidad de partidas";
    private $leyendaPartidas = "Partidas";
    private $LABEL_USUARIOS_NUEVOS = "Usuarios Nuevos";
    private $TITULO_GRAFICO_USUARIO_NUEVOS = "Cantidad de usuarios nuevos";

    private $CRITERIO_USUARIO_NUEVO = 5;

    public function __construct($generadorPDF, $generadorGrafico, $database) {
        $this->generadorPDF = $generadorPDF;
        $this->generadorGrafico = $generadorGrafico;
        $this->database = $database;
    }

    public function getGraficoCantidadJugadores($option = null) {
        $usuariosTotales = $this->findUsuariosTotalesPorOption($option);
        $valoresTotales = $this->extraerValores($usuariosTotales);
        $labels = $this->extraerLabels($option);
        return $this->generadorGrafico->generarGraficoCombinadoBarPlotsVarios($valoresTotales, $labels, $this->tituloGraficoUsuarios, "usuario");
    }

    public function getGraficoCantidadUsuariosNuevos() {
        $cantidadUsuariosNuevos = array_values($this->calcularCantidadUsuariosNuevos());
        return $this->generadorGrafico->generarGraficoBarGradientLeftReflection($cantidadUsuariosNuevos, [$this->LABEL_USUARIOS_NUEVOS], $this->TITULO_GRAFICO_USUARIO_NUEVOS);
    }

    public function getGraficoCantidadPreguntas($option = null) {
        $preguntasTotales = $this->findPreguntasTotalesPorOption($option);
        $preguntasSugeridas = $this->findPreguntasTotalesSugeridasPorOption($option);
        $valoresTotales = $this->extraerValoresPreguntas($preguntasTotales, $preguntasSugeridas);
        return $this->generadorGrafico->generarGraficoCombinadoBarPlotsVarios($valoresTotales, $this->extraerLabels($option), $this->tituloGraficoPreguntas, "pregunta");
    }

    public function getGraficoCantidadPartidas($option = null) {
        $partidasTotales = $this->findPartidasTotalesPorOption($option);
        return $this->generadorGrafico->generarGraficoCombinadoBarPlots($this->tituloGraficoPartidas, $this->extraerLabels($option), $partidasTotales, $this->leyendaPartidas);
    }

    public function imprimirReporte($reporte, $graficoBase64) {
        $titulo = $this->getTituloReporte($reporte);
        $this->generadorPDF->generarPDF($titulo, $graficoBase64);
    }

    private function getTituloReporte($reporte)
    {
        switch ($reporte) {
            case "cantidadPartidas":
                return "Reporte de usuarios";
            case "cantidadJugadores":
                return "Reporte de preguntas";
            case "cantidadPreguntas":
                return "Reporte de partidas";
        }
    }
    private function findUsuariosTotalesPorOption($option)
    {
        $id = "idUsuario";
        $fecha = "fechaUsuario";
        $tabla = "usuario";

        return $this->getTotales($option, $id, $fecha, $tabla);
    }

    private function extraerValores($usuariosTotales)
    {
        return [
            [
                "usuario" => "usuario",
                "data" => $usuariosTotales
            ]
        ];
    }

    private function extraerLabels($option)
    {
        switch ($option) {
            case "month":
                return ["ene", "feb", "mar", "abr", "may", "jun", "jul", "ago", "sep", "oct", "nov", "dic"];
            case "day":
                return ["dom", "lun", "mar", "mie", "jue", "vie", "sab"];
            case "year":
                return range(date('Y') - 4, date('Y'));
        }
        return range(date('Y') - 4, date('Y'));
    }

    private function getSQLDay($id, $fecha, $tabla, $filtroExtra)
    {
        return "SELECT CAST(IFNULL(u.Total, 0) AS INT) AS Total
                FROM (
                    SELECT 1 AS dia_semana UNION ALL
                    SELECT 2 UNION ALL
                    SELECT 3 UNION ALL
                    SELECT 4 UNION ALL
                    SELECT 5 UNION ALL
                    SELECT 6 UNION ALL
                    SELECT 7
                ) d
                LEFT JOIN (
                    SELECT COUNT(u.$id) AS Total, DAYOFWEEK(u.$fecha) AS dia_semana
                    FROM $tabla u
                    WHERE YEAR(u.$fecha) = YEAR(CURDATE()) AND WEEK(u.$fecha) = WEEK(CURDATE())
                    " . $filtroExtra . "
                    GROUP BY DAYOFWEEK(u.$fecha)
                ) u ON d.dia_semana = u.dia_semana
                ORDER BY d.dia_semana";
    }

    private function getSQLMonth($id, $fecha, $tabla, $filtroExtra)
    {
        return "SELECT COALESCE(u.Total, 0) AS Total 
                FROM ( SELECT 1 AS mes UNION ALL 
                      SELECT 2 UNION ALL 
                      SELECT 3 UNION ALL 
                      SELECT 4 UNION ALL 
                      SELECT 5 UNION ALL 
                      SELECT 6 UNION ALL 
                      SELECT 7 UNION ALL 
                      SELECT 8 UNION ALL 
                      SELECT 9 UNION ALL 
                      SELECT 10 UNION ALL 
                      SELECT 11 UNION ALL 
                      SELECT 12 ) d LEFT JOIN ( 
                          SELECT COUNT(u.$id) AS Total, MONTH(u.$fecha) AS mes
                          FROM $tabla u WHERE YEAR(u.$fecha) = YEAR(CURDATE() " .
                        $filtroExtra
                       . " ) 
                          GROUP BY MONTH($fecha) ) u ON d.mes = u.mes 
                          ORDER BY d.mes";
    }

    private function getSQLYear($id, $fecha, $tabla, $filtroExtra)
    {
        return "SELECT COALESCE(u.Total, 0) AS Total
                FROM (
                    SELECT YEAR(CURDATE()) - 4 AS anio UNION ALL
                    SELECT YEAR(CURDATE()) - 3 UNION ALL
                    SELECT YEAR(CURDATE()) - 2 UNION ALL
                    SELECT YEAR(CURDATE()) - 1 UNION ALL
                    SELECT YEAR(CURDATE())
                ) d
                LEFT JOIN (
                    SELECT COUNT(u.$id) AS Total, YEAR(u.$fecha) AS anio
                    FROM $tabla u
                    WHERE YEAR(u.$fecha) >= YEAR(CURDATE()) - 4 " . $filtroExtra . "
                    GROUP BY YEAR(u.$fecha)
                ) u ON d.anio = u.anio
                ORDER BY d.anio";
    }

    private function calcularCantidadUsuariosNuevos()
    {
        return $this->findUsuariosConFechaCreacionUsuario($this->CRITERIO_USUARIO_NUEVO);
    }

    private function findUsuariosConFechaCreacionUsuario($CRITERIO_USUARIO_NUEVO)
    {
        $sql ="SELECT COUNT(*) as cantidadUsuariosNuevos FROM usuario
                WHERE fechaUsuario >= DATE_SUB(CURDATE(), INTERVAL ? DAY)";
        $result = $this->database->queryWthParameters($sql, $CRITERIO_USUARIO_NUEVO);
        return mysqli_fetch_assoc($result);
    }

    private function findPreguntasTotalesPorOption($option)
    {
        $id = "idPregunta";
        $fecha = "fechaPregunta";
        $tabla = "pregunta";

        return $this->getTotales($option, $id, $fecha, $tabla);
    }

    private function findPreguntasTotalesSugeridasPorOption($option)
    {
        $id = "idPregunta";
        $fecha = "fechaPregunta";
        $tabla = "pregunta";
        $filtroExtra = " AND u.idEstadoPregunta = (SELECT ep.idEstadoPregunta FROM estado_pregunta ep WHERE ep.descripcion = 'PARA REVISAR') ";
        return $this->getTotales($option, $id, $fecha, $tabla, $filtroExtra);
    }

    private function findPartidasTotalesPorOption($option)
    {
        $id = "idPartida";
        $fecha = "fechaPartida";
        $tabla = "partida";
        return $this->getTotales($option, $id, $fecha, $tabla);
    }

    public function getTotales($option, $id, $fecha, $tabla, $filtroExtra = "")
    {
        switch ($option) {
            case "month":
                $sql = $this->getSQLMonth($id, $fecha, $tabla, $filtroExtra);
                break;
            case "day":
                $sql = $this->getSQLDay($id, $fecha, $tabla, $filtroExtra);
                break;
            default:
                $sql = $this->getSQLYear($id, $fecha, $tabla, $filtroExtra);
                break;
        }

        $result = $this->database->queryAllWithMerge($sql);
        foreach ($result as &$item) {
            $item = intval($item);
        }
        return $result;
    }

    private function extraerValoresPreguntas($preguntasTotales, $preguntasSugeridas)
    {
        return [
            [
                "pregunta" => "Preguntas Totales",
                "data" => $preguntasTotales
            ],
            [
                "pregunta" => "Preguntas Sugeridas",
                "data" => $preguntasSugeridas
            ]
        ];
    }
}