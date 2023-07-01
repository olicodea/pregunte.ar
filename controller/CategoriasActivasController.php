<?php

class CategoriasActivasController
{
    private $renderer;

    private $categoriasActivasModel;

    public function __construct($categoriasActivasModel, $renderer)
    {
        $this->categoriasActivasModel = $categoriasActivasModel;
        $this->renderer = $renderer;
    }
    public function list(){
        $data["usuarioLogeado"] = $_SESSION["usuario"];
        $data["vistaCategoriasActivas"] = true;
        $data["categoriasActivas"] = $this->categoriasActivasModel->findCategoriasActivas();
        $data["sinCategorias"] = $this->categoriasActivasModel->verificarSiNoHayCategorias($data["categoriasActivas"]);
        $this->renderer->render('categoriasActivas', $data);
    }

    public function eliminarPregunta() {
        $this->categoriasActivasModel->anularCategoria($_POST["idCategoria"], "eliminar");
        echo true;
    }
}