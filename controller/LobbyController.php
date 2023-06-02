<?php

class LobbyController
{
    private $renderer;
    private $lobbyModel;

    public function __construct($lobbyModel, $renderer)
    {
        $this->renderer = $renderer;
        $this->lobbyModel = $lobbyModel;
    }
    public function list(){
        $usuario = $_SESSION["usuario"];
        $data["lobbyData"] = $this->lobbyModel->getLobbyData($usuario["nombreDeUsuario"]);
        $data["usuarioLogeado"] = $_SESSION["usuario"];
        $this->renderer->render('lobby', $data);
    }

    public function cerrarSesion() {
        session_unset();
        header("Location: /home");
        exit();
    }
}