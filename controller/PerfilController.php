<?php
include_once ('third-party/phpqrcode/qrlib.php');
class PerfilController{

    private $perfilModel;

    private $renderer;

    private $generadorQr;

    public function __construct($perfilModel, $renderer, $generadorQr) {
        $this->perfilModel = $perfilModel;
        $this->renderer = $renderer;
        $this->generadorQr = $generadorQr;
    }

    public function list() {
        // Esto se uso para hardcodear y probar, pero asi deberia funcionar con el session del login
      /*  $_SESSION["usuario"][0] = [
          "nombreDeUsuario" => "sebacavs95",
          "idUsuario" => "2"
        ];*/

        if($_SESSION["usuario"]){
            $user = $_SESSION["usuario"][0]['nombreDeUsuario'];
            $data["perfil"] = $this->perfilModel->getPerfil($user);

            // Se sobreescribe siempre el qr en la imagen qr.png de public
            $idUsuario = $_SESSION["usuario"][0]['idUsuario'];
            $this->generadorQr->getQrById("http://localhost/perfil/?id=$idUsuario");
            $this->renderer->render("perfil_usuario_caracteristicas",$data);
        } else{
            header("location: /home");
            exit();
        }
    }
}