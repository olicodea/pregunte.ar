<?php

class CategoriasActivasController
{
    private $renderer;

    public function __construct($renderer)
    {
        $this->renderer = $renderer;
    }
    public function list(){
        $this->renderer->render('categoriasActivas');
    }
}