<?php
include_once "third-party/dompdf/autoload.inc.php";
use Dompdf\Dompdf;
class GeneradorPDF
{
    public function __construct() {

    }

    public function generarPDF($titulo, $graficoBase64) {
        $dompdf = new Dompdf();
        $dompdf->loadHtml("<h1 style='font-family: Arial, sans-serif; text-align: center;'>" . $titulo . "</h1><img src='" . $graficoBase64 . "' alt='grafico'>");
        $dompdf->render();
        header("Content-type: application/pdf");
        header("Content-Disposition: inline; filename=documento.pdf");
        echo $dompdf->output();
    }
}