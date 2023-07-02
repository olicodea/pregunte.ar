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

        $data["okMessage"] = $_SESSION["okMessageCategoria"] ?? null;
        $data["errorMessage"] = $_SESSION["errorMessageCategoria"] ?? null;

        $this->renderer->render('categoria', $data);

        unset($_SESSION["errorMessageCategoria"]);
        $this->unsetSessionVariables();
    }

    public function guardar() {
        if($this->verificarPostVariables()) {
            $idCategoria = $_SESSION["categoriaCargada"]["idCategoria"] ?? null;

            $this->categoriaModel->guardarCategoria($_POST["Color"], $_POST["NombreCategoria"], $_SESSION["usuario"]["idRol"], $idCategoria);
            unset($_SESSION["categoriaCargada"]);
            $_SESSION["okMessageCategoria"] = "La categoría se guardo correctamente.";
            header("Location: /categoria");

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
        $_SESSION["errorMessageCategoria"] = "Todos los campos deben estar completos";
        header("Location: /categoria");
    }

    private function unsetSessionVariables()
    {
        if(isset($_SESSION["okMessageCategoria"])) {
            unset($_SESSION["okMessageCategoria"]);
            unset($_SESSION["categoriaCargada"]);
        }
    }

    private function verificarPostVariables()
    {
        $verificacion = false;

        if(isset($_POST["Color"]) && isset($_POST["NombreCategoria"])) {
            if(!empty($_POST["Color"]) && !empty($_POST["NombreCategoria"])) {
                $verificacion = true;
            }
        }

        return $verificacion;
    }
}