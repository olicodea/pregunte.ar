<?php
class loginController
{
    private $render;
    private $loginModel;
    private $moduleHelper;

    public function __construct($moduleHelper, $loginModel, $render) {

        $this->moduleHelper = $moduleHelper;
        $this->render = $render;
        $this->loginModel = $loginModel;
    }


    public function list() {

        $data["errorlogin"] = $_SESSION["errorlogin"] ?? null;
        $data["errorMsgUsuarioNoValidado"] = $_SESSION["errorMsgUsuarioNoValidado"] ?? null;

        $this->render->render("login", $data);

        unset($_SESSION["errorlogin"]);
        unset($_SESSION["errorMsgUsuarioNoValidado"]);
    }

    public function loguearse() {

        $autenticacion = $this->loginModel->autenticarUsuario($_POST["usuario"], $_POST["password"]);

        if(!$autenticacion){
            Logger::warning("Usuario o contraseña incorrecto");
            $_SESSION["errorlogin"] = "usuario o contraseña incorrectos";
            header("location: /login");
            exit();
        }

        $validarRol = $this->loginModel->validarRolUsuario($_POST["usuario"]);

        if($validarRol != null) {
            Logger::warning("Usuario no validado");
            $_SESSION["errorMsgUsuarioNoValidado"]="usuario no validado";
            header("location: /login");
            exit();
        }

        $_SESSION["usuario"] = $autenticacion;

        Logger::info("usuario logueado con exito: ". $_SESSION["usuario"]["mail"]);

        $this->redirectPorRol();
    }

    private function redirectPorRol() {

        $rolUsuario = $_SESSION["usuario"]["idRol"];
        header("Location: /" . $this->moduleHelper->getLobbyPorRol($rolUsuario));

        exit();
    }
}