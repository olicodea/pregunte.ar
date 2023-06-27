<?php
class CategoriaController
{
    private $renderer;


    public function __construct($renderer)
    {
        $this->renderer = $renderer;
    }
    public function list(){
        $data["vistaCategoria"] = true;
        $this->renderer->render('categoria', $data);
    }

    public function guardar() {
        header("Location: categoria");
        //TODO: Implementar guardado de categoria
    }
}