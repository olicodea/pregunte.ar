<?php
include_once "third-party/dompdf/autoload.inc.php";
use Dompdf\Dompdf;
class GeneradorPDF
{
    public function __construct() {

    }

    public function generarPDF($titulo, $srcGrafico) {
        $dompdf = new Dompdf();
        $dompdf->loadHtml("<h1>" . $titulo . "</h1><br><img src='" . $srcGrafico . "' alt='grafico'>'");
        $dompdf->render();
        header("Content-type: application/pdf");
        header("Content-Disposition: inline; filename=documento.pdf");
        echo $dompdf->output();
    }
}