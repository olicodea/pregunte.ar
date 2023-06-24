<?php

class EstadisticasPreguntasController
{
    private $renderer;

    public function __construct($renderer) {
        $this->renderer = $renderer;
    }
    public function list() {
        $this->renderer->render('estadisticasPreguntas');
    }

    public function generarGrafico() {
        require_once ('third-party/jpgraph/src/jpgraph.php');
        require_once ('third-party/jpgraph/src/jpgraph_pie.php');
        // Some data
        $data = [40, 70];

        // Create the Pie Graph.
        $graph = new PieGraph(350,250);

        $theme_class="DefaultTheme";
        //$graph->SetTheme(new $theme_class());

        // Set A title for the plot
        $graph->title->Set("Porcentaje de respuestas correctas");
        $graph->SetBox(true);

        // Create
        $p1 = new PiePlot($data);
        $graph->Add($p1);

        $p1->ShowBorder();
        $p1->SetColor('black');
        $p1->SetSliceColors(['green','red']);
        $graph->Stroke();
    }
}