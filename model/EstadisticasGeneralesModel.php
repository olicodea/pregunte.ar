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

    public function getGraficoCantidadPreguntas() {
        $preguntasTotales = [5,20,33,42,120,505,705];
        $preguntasSugeridas = [5,15,17,23,80,380,200];
        $labels = ["Lun", "Mar", "Mier", "Jue", "Vier", "Sab", "Dom"];
        return $this->generadorGrafico->generarGraficoCombinadoBarPlots($this->tituloGraficoPreguntas, $labels, $preguntasTotales, $this->leyendaPreguntasTotales, $preguntasSugeridas, $this->leyendaPreguntasSugeridas);
    }

    public function getGraficoCantidadPartidas() {
        $partidasTotales = [23, 56, 66, 23, 80, 380, 780, 1200, 760, 280, 777, 900];
        $labels = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"];
        return $this->generadorGrafico->generarGraficoCombinadoBarPlots($this->tituloGraficoPartidas, $labels, $partidasTotales, $this->leyendaPartidas);
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
        switch ($option) {
            case "month":
                $sql = $this->getSQLMonth();
                break;
            case "day":
                $sql = $this->getSQLDay();
                break;
            default:
                $sql = $this->getSQLYear();
                break;
        }

        $result = $this->database->queryAllWithMerge($sql);
        foreach ($result as &$item) {
           $item = intval($item);
        }
        return $result;
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

    private function getSQLDay()
    {
        return "SELECT CAST(IFNULL(u.TotalUsuarios, 0) AS INT) AS TotalUsuarios
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
                    SELECT COUNT(u.idUsuario) AS TotalUsuarios, DAYOFWEEK(u.fechaUsuario) AS dia_semana
                    FROM usuario u
                    WHERE YEAR(u.fechaUsuario) = YEAR(CURDATE()) AND WEEK(u.fechaUsuario) = WEEK(CURDATE())
                    GROUP BY DAYOFWEEK(u.fechaUsuario)
                ) u ON d.dia_semana = u.dia_semana
                ORDER BY d.dia_semana";
    }

    private function getSQLMonth()
    {
        return "SELECT COALESCE(u.TotalUsuarios, 0) AS TotalUsuarios 
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
                          SELECT COUNT(u.idUsuario) AS TotalUsuarios, MONTH(u.fechaUsuario) AS mes
                          FROM usuario u WHERE YEAR(u.fechaUsuario) = YEAR(CURDATE()
                      ) 
                          GROUP BY MONTH(u.fechaUsuario) ) u ON d.mes = u.mes 
                          ORDER BY d.mes;";
    }

    private function getSQLYear()
    {
        return "SELECT COALESCE(u.TotalUsuarios, 0) AS TotalUsuarios
                FROM (
                    SELECT YEAR(CURDATE()) - 4 AS anio UNION ALL
                    SELECT YEAR(CURDATE()) - 3 UNION ALL
                    SELECT YEAR(CURDATE()) - 2 UNION ALL
                    SELECT YEAR(CURDATE()) - 1 UNION ALL
                    SELECT YEAR(CURDATE())
                ) d
                LEFT JOIN (
                    SELECT COUNT(u.idUsuario) AS TotalUsuarios, YEAR(u.fechaUsuario) AS anio
                    FROM usuario u
                    WHERE YEAR(u.fechaUsuario) >= YEAR(CURDATE()) - 4
                    GROUP BY YEAR(u.fechaUsuario)
                ) u ON d.anio = u.anio
                ORDER BY d.anio";
    }
}