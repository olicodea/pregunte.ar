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
        $this->renderer->render('lobby');
    }

    public function perfilLobby(){
        $data["lobby"] = $this->lobbyModel->getLobby('sebacavs95');
        $this->renderer->render("lobby",$data);
    }
}