<?php

class audioController
{
    private $audioModel;

    public function __construct($audioModel)
    {
        $this->audioModel = $audioModel;
    }
    public function correcta(){
        $correcta = $this->audioModel->getCorrecta();
        echo $correcta;
    }

    public function incorrecta(){
        $incorrecta = $this->audioModel->getIncorrecta();
        echo $incorrecta;
    }
}