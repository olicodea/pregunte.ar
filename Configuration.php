<?php
include_once('helpers/MySqlDatabase.php');
include_once("helpers/MustacheRender.php");
include_once('helpers/Router.php');
include_once('helpers/FileManager.php');
include_once('helpers/GeneradorQr.php');

include_once('model/LoginModel.php');
include_once('model/UsuarioModel.php');
include_once('model/MailValidationModel.php');
include_once('model/DatosUsuarioModel.php');
include_once('model/DatosLoginModel.php');
include_once('model/RegistroModel.php');
include_once('model/PerfilModel.php');
include_once('model/LobbyModel.php');

include_once('controller/LoginController.php');
include_once('controller/MailValidationController.php');
include_once('controller/RegistroController.php');
include_once('controller/DatosLoginController.php');
include_once('controller/DatosUsuarioController.php');
include_once('controller/PerfilController.php');
include_once('controller/HomeController.php');
include_once('controller/LobbyController.php');

include_once('third-party/mustache/src/Mustache/Autoloader.php');


class Configuration {
    private $configFile = 'config/config.ini';

    public function __construct() {
    }

    public function getLoginController() {
        return new LoginController(new LoginModel($this->getDatabase()), $this->getRenderer());
    }

    public function getLobbyController() {
        return new LobbyController(new LobbyModel($this->getDatabase()),$this->getRenderer());
    }

    public function getMailValidationController() {
        return new MailValidationController(
            new MailValidationModel($this->getDatabase()),
            new UsuarioModel($this->getDatabase()),
            $this->getRenderer());
    }

    public function getRegistroController() {
        return new RegistroController(new RegistroModel($this->getDatabase()), $this->getRenderer());
    }

    public function getDatosLoginController() {
        return new DatosLoginController(new DatosLoginModel(), $this->getRenderer(), $this->getFileManager());
    }

    public function getDatosUsuarioController() {
        return new DatosUsuarioController(new DatosUsuarioModel(), $this->getRenderer());
    }

    public function getPerfilController(){
        return new PerfilController(
            new PerfilModel($this->getDatabase()),
            $this->getRenderer(), $this->getGeneradorQr());
    }

    public function getHomeController(){
        return new HomeController($this->getRenderer());
    }

    private function getArrayConfig() {
        return parse_ini_file($this->configFile);
    }

    private function getRenderer() {
        return new MustacheRender('view/partial');
    }

    private function getFileManager() {
        return new FileManager();
    }

    public function getDatabase() {
        $config = $this->getArrayConfig();
        return new MySqlDatabase(
            $config['servername'],
            $config['username'],
            $config['password'],
            $config['database']);
    }

    public function getRouter() {
        return new Router(
            $this,
            "getHomeController",
            "list");
    }

    public function getGeneradorQr(){
        return new GeneradorQr();
    }
}