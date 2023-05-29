<?php
include_once ('third-party/phpqrcode/qrlib.php');
class GeneradorQr{

    public function __construct(){

    }

    public function getQrById($qrString){
        return QRcode::png($qrString,"public/img/qr.png");
    }
}
