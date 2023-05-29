<?php
class loginController
{
    private $render;
    private $loginModel;


    public function __construct($loginModel, $render)
    {
        $this->render = $render;
        $this->loginModel = $loginModel;
    }
    public function list()
    {
        $this->render->render("login");
    }

    public function loguearse() {

        // TODO: Tomar los parametros de POST usuario y contraseña. Llamar al model para que valide el usuario y creamos un objeto usuario
        // TODO: Comparamos la contraseña del post con la de la BD
        // TODO: Guardamos en $_SESSION["usuario"] un objeto usuario con los datos (a excepcion de la contraseña)

        $usuario["nombreUsuario"] = "Rafita";
        $this->render->render("loguse", $usuario);
    }
}