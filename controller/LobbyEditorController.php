<?php

class LobbyEditorController
{
    private $renderer;

    public function __construct($renderer)
    {
        $this->renderer = $renderer;
    }
    public function list() {
        $data["usuarioLogeado"] = $_SESSION["usuario"];
        $this->renderer->render('lobbyEditor', $data);
    }
}