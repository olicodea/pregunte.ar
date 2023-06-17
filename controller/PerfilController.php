<?php
include_once ('third-party/phpqrcode/qrlib.php');
class PerfilController {

    private $perfilModel;

    private $renderer;

    private $generadorQr;

    private $apiGoogleMaps;

    public function __construct($perfilModel, $renderer, $generadorQr, $apiGoogleMaps) {
        $this->perfilModel = $perfilModel;
        $this->renderer = $renderer;
        $this->generadorQr = $generadorQr;
        $this->apiGoogleMaps = $apiGoogleMaps;
    }

    public function list() {
        if(isset($_SESSION["usuario"])){
            $user = $_SESSION["usuario"];
            $data["ApiGoogleMapsPerfil"] = $this->apiGoogleMaps;
            $data["perfil"] = $this->perfilModel->getPerfil($user["nombreDeUsuario"]);
            $data["usuarioLogeado"] = $_SESSION["usuario"];
            $data["longitud"] = $_SESSION["usuario"]["longitud"];
            $data["latitud"] = $_SESSION["usuario"]["latitud"];
            // Se sobreescribe siempre el qr en la imagen qr.png de public
            $idUsuario = $user["idUsuario"];

            $this->generadorQr->getQrById("http://localhost/perfil/list&id=$idUsuario");

            $this->renderer->render("perfil_usuario_caracteristicas", $data);
        } else{
            header("location: /home");
            exit();
        }
    }

    public function verPerfilDeOtroUsuario() {
        if(isset($_GET["nombreUsuario"])) {
            $usuarioAVer = $_GET["nombreUsuario"];
            $data["perfil"] = $this->perfilModel->getPerfil($usuarioAVer);
            $data["usuarioLogeado"] = $this->perfilModel->getUsuario($usuarioAVer);
            $idUsuario = $data["usuarioLogeado"]["idUsuario"];

            $this->generadorQr->getQrById("http://localhost/perfil/verPerfilDeOtroUsuario&id=$idUsuario");
            $this->renderer->render("perfil_usuario_caracteristicas", $data);
        } else {
            header("location: /lobby");
            exit();
        }
    }


}