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
    public function list(){
        $data["vistaCategoria"] = true;
        $data["usuarioLogeado"] = $_SESSION["usuario"];
        $this->renderer->render('categoria', $data);
    }

    public function guardar() {
        if(isset($_POST["Color"]) &&  isset($_POST["NombreCategoria"]) ) {
            $this->categoriaModel->guardarCategoria($_POST["Color"], $_POST["NombreCategoria"], $_SESSION["usuario"]["idRol"]);
            $_SESSION["guardadoOkMessage"] = "La categoría se guardo correctamente.";
            header("Location: /categoria");
            exit();
        }

        $this->setErrorMessageyReload();
    }

    private function setErrorMessageyReload()
    {
        $_SESSION["errorMsg"] = "Todos los campos deben estar completos";
        header("Location: /categoria");
    }
}