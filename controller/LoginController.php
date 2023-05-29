<?php
class loginController
{
    private $render;
    private $loginModel;


    public function __construct($loginModel,$render)
    {
        $this->render = $render;
        $this->loginModel = $loginModel;
    }

    public function execute()
    {
        $data["login"] = $this->loginModel->getLogin();
        $this->render->render("login", $data);
    }

    public function list()
    {
        $data["usuario"] = $_POST["usuario"];
        $data["contraceña"] = $_POST["contraceña"];
        $this->render->render("loguse", $data);
    }
}