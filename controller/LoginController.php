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
        $_SESSION["usuario"] = $this->loginModel->autenticarUsuario($_POST["usuario"], $_POST["password"]);
        header("Location: /");
    }
}