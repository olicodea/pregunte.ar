<?php

class CategoriasSugeridasController
{
    private $renderer;
    private $categoriasSugeridasModel;

    public function __construct($categoriasSugeridasModel, $renderer)
    {
        $this->categoriasSugeridasModel = $categoriasSugeridasModel;
        $this->renderer = $renderer;
    }
    public function list() {
        $data["usuarioLogeado"] = $_SESSION["usuario"];
        $data["categorias"] = $this->categoriasSugeridasModel->findCategoriasSugeridas();
        $data["sinCategorias"] = empty($data["categorias"]) ? "Sin categorias sugeridas" : false;
        $data["vistaCategoriasSugeridas"] = true;
        $this->renderer->render('categoriasSugeridas', $data);
    }

    public function aprobarCategoria() {
        $this->categoriasSugeridasModel->resolverRevisionCategoria($_POST["idCategoria"], "aprobar");
        echo true;
    }

    public function rechazarCategoria() {
        $this->categoriasSugeridasModel->resolverRevisionCategoria($_POST["idCategoria"], "rechazar");
        echo true;
    }

}