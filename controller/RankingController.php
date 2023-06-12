<?php

class RankingController
{
    private $renderer;
    private $rankingModel;

    public function __construct($rankingModel, $renderer)
    {
        $this->renderer = $renderer;
        $this->rankingModel = $rankingModel;
    }
    public function list() {
        $data["usuarioLogeado"] = $_SESSION["usuario"] ?? null;
        $data["jugadores"] = $this->rankingModel->armarRankingJugadores();
        $this->renderer->render('ranking', $data);
    }
}