<?php
include_once ('third-party/phpqrcode/qrlib.php');
class PerfilController {

    private $perfilModel;

    private $renderer;

    private $generadorQr;

    public function __construct($perfilModel, $renderer, $generadorQr) {
        $this->perfilModel = $perfilModel;
        $this->renderer = $renderer;
        $this->generadorQr = $generadorQr;
    }

    public function list() {
        if(isset($_SESSION["usuario"])){
            $user = $_SESSION["usuario"];
            $data["perfil"] = $this->perfilModel->getPerfil($user["nombreDeUsuario"]);
            $data["usuarioLogeado"] = $_SESSION["usuario"];

            // Se sobreescribe siempre el qr en la imagen qr.png de public
            $idUsuario = $user["idUsuario"];
            $this->generadorQr->getQrById("http://localhost/perfil/lista&id=$idUsuario");
            $this->renderer->render("perfil_usuario_caracteristicas", $data);
        } else{
            header("location: /home");
            exit();
        }
    }
}