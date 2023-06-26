<?php
require_once ('third-party/jpgraph/src/jpgraph.php');
require_once ('third-party/jpgraph/src/jpgraph_pie.php');
require_once ('third-party/jpgraph/src/jpgraph_bar.php');
require_once ('third-party/jpgraph/src/jpgraph_line.php');

class GeneradorGrafico {

    public function __construct() {

    }
    public function generarGraficoTorta($arrayData, $tituloGrafico) {
        // Create the Pie Graph.
        $graph = new PieGraph(350,250);

        $theme_class="DefaultTheme";
        //$graph->SetTheme(new $theme_class());

        // Set A title for the plot
        $graph->title->Set($tituloGrafico);
        $graph->SetBox(true);

        // Create
        $p1 = new PiePlot($arrayData);
        $graph->Add($p1);

        $p1->ShowBorder();
        $p1->SetColor('black');
        $p1->SetSliceColors(['#19A875','#F34949']);
        $graph->Stroke();
    }

    public function generarGraficoBarPlot($arrayValores, $arrayLabels, $titulo) {
        $datay= $arrayValores;

        $graph = new Graph(450,400,'auto');
        $graph->SetScale("textlin");

        $theme_class = new UniversalTheme;
        $graph->SetTheme($theme_class);

        $graph->Set90AndMargin(70,40,40,40);
        $graph->img->SetAngle(90);

        $graph->SetBox(false);

        //$graph->ygrid->SetColor('gray');
        $graph->ygrid->Show(false);
        $graph->ygrid->SetFill(false);
        $graph->xaxis->SetTickLabels($arrayLabels);
        $graph->yaxis->HideLine(false);
        $graph->yaxis->HideTicks(false,false);

        $graph->SetBackgroundGradient('#00CED1', '#FFFFFF', GRAD_HOR, BGRAD_PLOT);

        $b1plot = new BarPlot($datay);

        $graph->Add($b1plot);
        $graph->title->Set($titulo);

        $b1plot->SetWeight(0);
        $b1plot->SetFillGradient("#808000","#90EE90",GRAD_HOR);
        $b1plot->SetWidth(17);

        $graph->Stroke();
    }

    public function generarGraficoBarGradientLeftReflection($valores, $labels, $titulo) {
        $datay = $valores;


        $graph = new Graph(400,300,'auto');
        $graph->SetScale("textlin");

        //$theme_class="DefaultTheme";
        //$graph->SetTheme(new $theme_class());

        $graph->SetBox(false);

        //$graph->yaxis->SetTickPositions(array(0,10,30,50,70,90), array(5,15,40,60,80));
        //$graph->ygrid->SetColor('gray');
        $graph->ygrid->SetFill(false);
        $graph->xaxis->SetTickLabels($labels);
        $graph->yaxis->HideLine(false);
        $graph->yaxis->HideTicks(false,false);

        $b1plot = new BarPlot($datay);

        $graph->Add($b1plot);

        $b1plot->SetColor("white");
        $b1plot->SetFillGradient("#4B0082","white",GRAD_LEFT_REFLECTION);
        $b1plot->SetWidth(45);
        $graph->title->Set($titulo);

        $graph->Stroke();
    }

    public function generarGraficoCombinadoBarPlots($titulo, $labels, $valores1, $leyenda1, $valores2 = null, $leyenda2 = null) {
        $data1y= $valores1;
        $data2y= $valores2;

        $graph = new Graph(600,320,'auto');
        $graph->SetScale("textlin");
        $graph->SetY2Scale("lin",0,90);
        $graph->SetY2OrderBack(false);

        $theme_class = new UniversalTheme;
        $graph->SetTheme($theme_class);

        $graph->SetMargin(40,20,46,80);

        $graph->SetBox(false);

        $graph->ygrid->SetFill(false);
        $graph->yaxis->HideLine(false);
        $graph->yaxis->HideTicks(false,false);
        $graph->xaxis->SetTickLabels($labels);

        $b1plot = new BarPlot($data1y);
        $b2plot = $data2y != null ? new BarPlot($data2y) : null;

        $gbplot = $b2plot != null ? new GroupBarPlot(array($b1plot,$b2plot)) : new GroupBarPlot(array($b1plot));

        $graph->Add($gbplot);

        $b1plot->SetColor("#0000CD");
        $b1plot->SetFillColor("#0000CD");
        $b1plot->SetLegend($leyenda1);

        if($b2plot != null) {
            $b2plot->SetColor("#B0C4DE");
            $b2plot->SetFillColor("#B0C4DE");
            $b2plot->SetLegend($leyenda2);
        }

        $graph->legend->SetFrameWeight(1);
        $graph->legend->SetColumns(6);
        $graph->legend->SetColor('#4E4E4E','#00A78A');



        $graph->title->Set($titulo);

        $graph->Stroke();
    }

    public function generarGraficoCombinadoBarPlotsVarios($valores, $labels, $titulo, $criterio) {
        $graph = new Graph(600,320,'auto');
        $graph->SetScale("textlin");
        $graph->SetY2Scale("lin",0,90);
        $graph->SetY2OrderBack(false);

        $theme_class = new UniversalTheme;
        $graph->SetTheme($theme_class);

        $graph->SetMargin(40,20,46,80);

        $graph->SetBox(false);

        $graph->ygrid->SetFill(false);
        $graph->yaxis->HideLine(false);
        $graph->yaxis->HideTicks(false,false);
        $graph->xaxis->SetTickLabels($labels);

        $gbplot = $this->generarBarPlots($valores, $criterio);

        $graph->Add($gbplot);

        $graph->legend->SetFrameWeight(1);
        $graph->legend->SetColumns(sizeof($valores));
        $graph->legend->SetColor('#4E4E4E','#00A78A');

        $graph->title->Set($titulo);

        $graph->Stroke();
    }

    private function generarBarPlots($valores, $criterio) {
        $plots = [];
        foreach($valores as $valor){

            $leyenda = $valor["$criterio"];

            $barplot = new BarPlot($valor["data"]); //[5,0,0,3,0]
            $color = "#ccc";
            $barplot->SetColor($color);
            $barplot->SetFillColor($color);
            $barplot->SetLegend($leyenda);


            $plots[] = $barplot;
        }
        return new GroupBarPlot($plots);
    }
}
