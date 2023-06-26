<?php

class EstadisticasJugadoresModel
{
    private $database;
    private $generadorGrafico;
    private $generadorPDF;
    private $TITULO_GRAFICO_PAIS = "Cantidad de jugadores por pais";
    private $TITULO_GRAFICO_GENERO = "Cantidad de jugadores por Genero";
    private $TITULO_GRAFICO_EDAD = "Cantidad de jugadores totales por Grupo de edad";
    private $GRUPOS_EDAD = ["Menores", "Jubilados", "Medio"];

    public function __construct($generadorPDF, $generadorGrafico, $database) {
        $this->generadorPDF = $generadorPDF;
        $this->generadorGrafico = $generadorGrafico;
        $this->database = $database;
    }

    public function getGraficoPorPais($option = null) {
        $criterio = "pais";
        $cantidadJugadoresPorPais = $this->findCantidadJugadoresPorPais($option);
        $valoresPorPais = $this->extraerValores($cantidadJugadoresPorPais, $option, $criterio);
        $labelsPorPais = $this->extraerLabels($option);
        $titulo = $this->getTituloGrafico($option, $criterio);
        return $this->generadorGrafico->generarGraficoCombinadoBarPlotsVarios($valoresPorPais, $labelsPorPais, $titulo, $criterio);
    }

    public function getGraficoPorGenero($option = null) {
        $criterio = "genero";
        $cantidadJugadoresPorGenero = $this->findCantidadJugadoresPorGenero($option);
        $cantidadPorGenero = $this->extraerValores($cantidadJugadoresPorGenero, $option, $criterio);
        $labelsPorGenero = $this->extraerLabels($option);
        $titulo = $this->getTituloGrafico($option, $criterio);
        return $this->generadorGrafico->generarGraficoCombinadoBarPlotsVarios($cantidadPorGenero, $labelsPorGenero, $titulo, $criterio);
    }

    public function getGraficoPorGrupoDeEdad() {
        $cantidadJugadoresPorGrupoEdad = $this->definirJugadoresPorGrupoDeEdad();
        $cantidadPorGenero = array_values($cantidadJugadoresPorGrupoEdad);
        return $this->generadorGrafico->generarGraficoBarGradientLeftReflection($cantidadPorGenero, $this->GRUPOS_EDAD, $this->TITULO_GRAFICO_EDAD);
    }

    public function imprimirReporte($reporte, $graficoBase64) {
        $titulo = $this->getTituloReporte($reporte);
        $this->generadorPDF->generarPDF($titulo, $graficoBase64);
    }

    public function findCantidadJugadoresPorPais($option) {
        if($option == 'year' || !$option) {
            $sql = "SELECT u.pais, CONCAT(GROUP_CONCAT(CONCAT(u.anio, ':', u.TotalUsuarios) ORDER BY u.anio SEPARATOR ',')) AS data
                    FROM (
                        SELECT YEAR(u.fechaUsuario) AS anio, u.pais, COUNT(u.idUsuario) AS TotalUsuarios
                        FROM usuario u
                        WHERE YEAR(u.fechaUsuario) >= YEAR(CURDATE()) - 5
                        GROUP BY YEAR(u.fechaUsuario), u.pais
                        ORDER BY YEAR(u.fechaUsuario), u.pais
                    ) u GROUP BY u.pais";

        }

        if($option == 'month') {
            $sql = "SELECT u.pais, CONCAT(GROUP_CONCAT(CONCAT(u.mes, ':', COALESCE(u.TotalUsuarios, 0)) ORDER BY u.mes SEPARATOR ',')) AS data
                    FROM (
                        SELECT MONTH(u.fechaUsuario) AS mes, u.pais, COUNT(u.idUsuario) AS TotalUsuarios
                        FROM usuario u
                        WHERE YEAR(u.fechaUsuario) = YEAR(CURDATE())
                        GROUP BY MONTH(u.fechaUsuario), u.pais
                        ORDER BY MONTH(u.fechaUsuario), u.pais
                        ) u GROUP BY u.pais";
        }

        if($option == 'day') {
            $sql = "SELECT u.pais, CONCAT( GROUP_CONCAT(CONCAT(u.dia_semana, ':', COALESCE(u.TotalUsuarios, 0)) ORDER BY u.dia_semana SEPARATOR ',') ) AS data 
                    FROM ( SELECT DAYNAME(u.fechaUsuario) AS dia_semana, u.pais, COUNT(u.idUsuario) AS TotalUsuarios 
                           FROM usuario u 
                           WHERE YEAR(u.fechaUsuario) = YEAR(CURDATE()) AND WEEK(u.fechaUsuario) = WEEK(CURDATE()) 
                           GROUP BY DAYOFWEEK(u.fechaUsuario), u.pais 
                           ORDER BY DAYOFWEEK(u.fechaUsuario), u.pais 
                        ) u GROUP BY u.pais";
        }
        return $this->database->query($sql);
    }
    private function findCantidadJugadoresPorGenero($option)
    {
        if ($option == 'year' || !$option) {
            $sql = "SELECT u.genero, CONCAT(GROUP_CONCAT(CONCAT(u.anio, ':', u.TotalUsuarios) ORDER BY u.anio SEPARATOR ',')) AS data
                    FROM (
                        SELECT YEAR(u.fechaUsuario) AS anio, u.genero, COUNT(u.idUsuario) AS TotalUsuarios
                        FROM usuario u
                        WHERE YEAR(u.fechaUsuario) >= YEAR(CURDATE()) - 5
                        GROUP BY YEAR(u.fechaUsuario), u.genero
                        ORDER BY YEAR(u.fechaUsuario), u.genero
                    ) u GROUP BY u.genero";

        }
        if ($option == 'month') {
            $sql = "SELECT u.genero, CONCAT(GROUP_CONCAT(CONCAT(u.mes, ':', COALESCE(u.TotalUsuarios, 0)) ORDER BY u.mes SEPARATOR ',')) AS data
                    FROM (
                        SELECT MONTH(u.fechaUsuario) AS mes, u.genero, COUNT(u.idUsuario) AS TotalUsuarios
                        FROM usuario u
                        WHERE YEAR(u.fechaUsuario) = YEAR(CURDATE())
                        GROUP BY MONTH(u.fechaUsuario), u.genero
                        ORDER BY MONTH(u.fechaUsuario), u.genero
                        ) u GROUP BY u.genero";
        }
        if ($option == 'day') {
            $sql = "SELECT u.genero, CONCAT( GROUP_CONCAT(CONCAT(u.dia_semana, ':', COALESCE(u.TotalUsuarios, 0)) ORDER BY u.dia_semana SEPARATOR ',') ) AS data 
                    FROM ( SELECT DAYNAME(u.fechaUsuario) AS dia_semana, u.genero, COUNT(u.idUsuario) AS TotalUsuarios 
                           FROM usuario u 
                           WHERE YEAR(u.fechaUsuario) = YEAR(CURDATE()) AND WEEK(u.fechaUsuario) = WEEK(CURDATE()) 
                           GROUP BY DAYOFWEEK(u.fechaUsuario), u.genero 
                           ORDER BY DAYOFWEEK(u.fechaUsuario), u.genero 
                        ) u GROUP BY u.genero";
        }
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

    private function extraerValores($cantidadJugadores, $option, $criterio)
    {
        switch ($option) {
            case "year":
                return $this->generarValoresYear($criterio, $cantidadJugadores);
            case "month":
                return $this->generarValoresMonth($criterio, $cantidadJugadores);
            case "day":
                return $this->generarValoresDay($criterio, $cantidadJugadores);
        }
        return $this->generarValoresYear($criterio, $cantidadJugadores);
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

    private function generarValoresYear($criterio, $cantidadJugadores)
    {
        $years = range(date('Y') - 4, date('Y'));
        return $this->generarValores($criterio, $cantidadJugadores, "year", $years);
    }

    private function generarValoresMonth($criterio, $cantidadJugadores)
    {
        $months = range(1, 12); // Array con los números de los meses
        return $this->generarValores($criterio, $cantidadJugadores, "month", $months);
    }

    private function generarValoresDay($criterio, $cantidadJugadores)
    {
        $daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        return $this->generarValores($criterio, $cantidadJugadores, "day", $daysOfWeek);
    }

    private function getTituloGrafico($option, $criterio)
    {
        switch ($option) {
            case "year":
                return "Cantidad de usuarios por $criterio en los ultimos 5 años";
            case "month":
                return "Cantidad de usuarios por $criterio en el ultimo año, por mes";
            case "day":
                return "Cantidad de usuarios por $criterio en la ultima semana";
        }
        return "Cantidad de usuarios por $criterio en los ultimos 5 años";
    }

    private function extraerLabels($option) {
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

    private function generarValores($criterio, $cantidadJugadores, $criterioDate, $dateArray)
    {
        $valores = [];

        foreach ($cantidadJugadores as $cantidad) {
            $dataString = $cantidad['data'];
            // Obtener los pares de valores separados por comas
            $dataPairs = explode(',', $dataString);

            $dateValues = [];
            foreach ($dataPairs as $pair) {
                $this->filtrarDataPorTipoDate($dateValues, $pair, $criterioDate);
            }

            $resultData = [];
            foreach ($dateArray as $date) {
                // Obtener el valor correspondiente al día de la semana o asignar 0 si no existe
                $resultData[] = $dateValues[$date] ?? 0;
            }

            $valores[] = [
                "$criterio" => $cantidad[$criterio],
                "data" => $resultData
            ];
        }

        return $valores;
    }

    private function filtrarDataPorTipoDate(&$dateValues , $pair, $criterioDate) {
        switch ($criterioDate) {
            case "month":
                // Separar el mes y el valor
                list($month, $value) = explode(':', $pair);
                // Convertir el mes y el valor a enteros
                $month = intval($month);
                $value = intval($value);
                // Asignar el valor al mes correspondiente
                $dateValues[$month] = $value;
                break;

            case "day":
                // Separar el día de la semana y el valor
                list($day, $value) = explode(':', $pair);
                // Asignar el valor al día de la semana correspondiente
                $dateValues[$day] = intval($value);
                break;
            default:
                // Separar el año y el valor
                list($year, $value) = explode(':', $pair);
                // Convertir el valor a entero y asignarlo al año correspondiente
                $dateValues[$year] = intval($value);
                break;
        }
    }
}