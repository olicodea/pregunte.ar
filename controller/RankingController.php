<?php

class RankingController
{
    private $renderer;

    public function __construct($renderer)
    {
        $this->renderer = $renderer;
    }
    public function list(){
        $data["usuarioLogeado"] = $_SESSION["usuario"] ?? null;
        $this->renderer->render('ranking', $data);
    }
}