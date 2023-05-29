<?php
include_once ('third-party/phpqrcode/qrlib.php');
class PerfilController{

    private $perfilModel;

    private $renderer;

    private $generadorQr;

    public function __construct($perfilModel, $renderer, $generadorQr){
        $this->perfilModel = $perfilModel;
        $this->renderer = $renderer;
        $this->generadorQr = $generadorQr;
    }

    public function list(){
        $data["perfil"] = $this->perfilModel->getPerfil("sebacavs95");
        // Se sobreescribe siempre el qr en la imagen qr.png de public
        $this->generadorQr->getQrById("http://localhost/user/?id=2");
        $this->renderer->render("perfil_usuario_caracteristicas",$data);
    }
}