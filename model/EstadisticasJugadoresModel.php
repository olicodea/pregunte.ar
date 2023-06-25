<?php

class EstadisticasJugadoresModel
{
    private $database;
    private $generadorGrafico;
    private $generadorPDF;
    private $TITULO_GRAFICO_PAIS = "Cantidad de jugadores por pais";
    private $TITULO_GRAFICO_GENERO = "Cantidad de jugadores por Genero";
    private $TITULO_GRAFICO_EDAD = "Cantidad de jugadores por Grupo de edad";
    private $GRUPOS_EDAD = ["Menores", "Jubilados", "Medio"];

    public function __construct($generadorPDF, $generadorGrafico, $database) {
        $this->generadorPDF = $generadorPDF;
        $this->generadorGrafico = $generadorGrafico;
        $this->database = $database;
    }

    public function getGraficoPorPais($graficoTemp = null) {
        $cantidadJugadoresPorPais = $this->findCantidadJugadoresPorPais();
        $valoresPorPais = $this->extraerValoresOLabels($cantidadJugadoresPorPais, "cantidadPorPais");
        $labelsPorPais = $this->extraerValoresOLabels($cantidadJugadoresPorPais, "pais");
        return $this->generadorGrafico->generarGraficoBarPlot($valoresPorPais, $labelsPorPais, $this->TITULO_GRAFICO_PAIS, $graficoTemp);
    }

    public function getGraficoPorGenero($graficoTemp = null) {
        $cantidadJugadoresPorGenero = $this->findCantidadJugadoresPorGenero();
        $cantidadPorGenero = $this->extraerValoresOLabels($cantidadJugadoresPorGenero, "cantidadPorGenero");
        $labelsPorGenero = $this->extraerValoresOLabels($cantidadJugadoresPorGenero, "genero");
        return $this->generadorGrafico->generarGraficoBarGradientLeftReflection($cantidadPorGenero, $labelsPorGenero, $this->TITULO_GRAFICO_GENERO, $graficoTemp);
    }

    public function getGraficoPorGrupoDeEdad($graficoTemp = null) {
        $cantidadJugadoresPorGrupoEdad = $this->definirJugadoresPorGrupoDeEdad();
        $cantidadPorGenero = array_values($cantidadJugadoresPorGrupoEdad);
        return $this->generadorGrafico->generarGraficoBarGradientLeftReflection($cantidadPorGenero, $this->GRUPOS_EDAD, $this->TITULO_GRAFICO_EDAD, $graficoTemp);
    }

    public function imprimirReporte($reporte, $graficoBase64) {
        $titulo = $this->getTituloReporte($reporte);
        $this->generadorPDF->generarPDF($titulo, $graficoBase64);
    }

    public function findCantidadJugadoresPorPais() {
        $sql = "SELECT u.pais, count(u.idUsuario) as cantidadPorPais FROM usuario u GROUP BY u.pais HAVING COUNT(u.idUsuario)";
        return $this->database->query($sql);
    }

    private function extraerValoresOLabels($cantidadJugadores, $key)
    {
        $valores = [];

        foreach ($cantidadJugadores as $cantidad) {
            $valores[] = $cantidad[$key];
        }

        return $valores;
    }

    private function findCantidadJugadoresPorGenero()
    {
        $sql = "SELECT u.genero, count(u.idUsuario) as cantidadPorGenero FROM usuario u GROUP BY u.genero HAVING COUNT(u.idUsuario)";
        return $this->database->query($sql);
    }

    private function definirJugadoresPorGrupoDeEdad()
    {
        $jugadores = $this->findJugadoresConFechaNacimiento();
        return $this->calcularJugadoresPorFechaNacimiento($jugadores);
    }

    private function findJugadoresConFechaNacimiento()
    {
        $sql ="SELECT idUsuario, fechaDeNacimiento FROM usuario";
        return $this->database->query($sql);
    }

    private function calcularJugadoresPorFechaNacimiento($jugadores)
    {
        $cantidadJugadoresPorFechaNacimiento = [
            "Menores" => 0,
            "Jubilados" => 0,
            "Medio" => 0
        ];

        $fechaActual = new DateTime();

        foreach ($jugadores as $jugador) {
            $fechaNacimiento = new DateTime($jugador["fechaDeNacimiento"]);
            $edad = $fechaActual->diff($fechaNacimiento)->y;

            switch ($edad) {
                case $edad < 18:
                    $cantidadJugadoresPorFechaNacimiento["Menores"]++;
                    break;
                case $edad >= 18 || $edad < 60:
                    $cantidadJugadoresPorFechaNacimiento["Medio"]++;
                    break;
                    case $edad >= 60:
                $cantidadJugadoresPorFechaNacimiento["Jubilados"]++;
                break;
            }
        }

        return $cantidadJugadoresPorFechaNacimiento;
    }

    private function getTituloReporte($reporte)
    {
        switch ($reporte) {
            case "jugadoresPais":
                return "Cantidad de jugadores por país";
            case "jugadoresGenero":
                return "Cantidad de jugadores por genero";
            case "jugadoresGrupoEdad":
                return "Cantidad de jugadores por grupo de edad";
        }
    }
}