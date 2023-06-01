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
    $data["errorlogin"]=$_SESSION["errorlogin"]??null;
        $this->render->render("login",$data);
    }

    public function loguearse() {
        $autenticacion = $this->loginModel->autenticarUsuario($_POST["usuario"], $_POST["password"]);
        if(!$autenticacion){
            $_SESSION["errorlogin"]="usuario o contraseña incorrectos";
            header("location: /login");
            exit();
        }
        $_SESSION["usuario"]=$autenticacion;
        header("Location: /lobby");
        exit();
    }
}