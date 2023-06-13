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
        $data["lobbyData"] = $this->lobbyModel->getLobbyDataNew($usuario["idUsuario"], $usuario["nombreDeUsuario"]);
        $data["usuarioLogeado"] = $_SESSION["usuario"];
        $data["lobbyPartidasJugadas"] = $this->lobbyModel->getLobbyPartidasJugadas($usuario["nombreDeUsuario"]);
        $this->renderer->render('lobby', $data);
    }

    public function cerrarSesion() {
        session_unset();
        header("Location: /home");
        exit();
    }
}