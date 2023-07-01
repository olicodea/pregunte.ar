<?php
class CategoriaController
{
    private $renderer;
    private $categoriaModel;

    public function __construct($categoriaModel, $renderer)
    {
        $this->categoriaModel = $categoriaModel;
        $this->renderer = $renderer;
    }
    public function list() {
        $data["vistaCategoria"] = true;
        $data["usuarioLogeado"] = $_SESSION["usuario"];
        $data["descripcion"] = $_SESSION["categoriaCargada"]["descripcion"] ?? null;
        $data["color"] = $_SESSION["categoriaCargada"]["color"] ?? null;
        $this->renderer->render('categoria', $data);
    }

    public function guardar() {
        if(isset($_POST["Color"]) &&  isset($_POST["NombreCategoria"]) ) {
            $idCategoria = $_SESSION["categoriaCargada"]["idCategoria"] ?? null;

            $this->categoriaModel->guardarCategoria($_POST["Color"], $_POST["NombreCategoria"], $_SESSION["usuario"]["idRol"], $idCategoria);

            $_SESSION["guardadoOkMessage"] = "La categoría se guardo correctamente.";
            header("Location: /categoria");

            $this->unsetSessionVariables();

            exit();
        }

        $this->setErrorMessageyReload();
    }

    public function comenzarEdicionCategoria() {
        $idCategoria = $_GET["idCategoria"] ?? null;

        if($idCategoria) {
            $_SESSION["categoriaCargada"] = $this->categoriaModel->findCategoriaPorId($idCategoria);
        }

        header("Location: /categoria");
    }

    private function setErrorMessageyReload()
    {
        $_SESSION["errorMsg"] = "Todos los campos deben estar completos";
        header("Location: /categoria");
    }

    private function unsetSessionVariables()
    {
        if(isset($_SESSION["guardadoOkMessage"])) {
            unset($_SESSION["guardadoOkMessage"]);
            unset($_SESSION["categoriaCargada"]);
        }
    }
}