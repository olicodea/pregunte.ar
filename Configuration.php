<?php

use PHPMailer\PHPMailer\PHPMailer;

include_once('helpers/MySqlDatabase.php');
include_once("helpers/MustacheRender.php");
include_once('helpers/Router.php');
include_once('helpers/FileManager.php');
include_once('helpers/GeneradorQr.php');
include_once('helpers/Mailer.php');
include_once ('helpers/Logger.php');
include_once('helpers/ModuleHelper.php');
include_once('helpers/GeneradorGrafico.php');
include_once('helpers/GeneradorPDF.php');

include_once('model/LoginModel.php');
include_once('model/UsuarioModel.php');
include_once('model/MailValidationModel.php');
include_once('model/DatosUsuarioModel.php');
include_once('model/RegistroModel.php');
include_once('model/PerfilModel.php');
include_once('model/LobbyModel.php');
include_once('model/PartidaModel.php');
include_once('model/DatosLoginModel.php');
include_once('model/CrearPreguntaModel.php');
include_once('model/RankingModel.php');
include_once('model/AudioModel.php');
include_once('model/PreguntasSugeridasModel.php');
include_once('model/PreguntasActivasModel.php');
include_once('model/PreguntasReportadasModel.php');
include_once('model/ApiModel.php');
include_once('model/EstadisticasPreguntasModel.php');
include_once('model/EstadisticasJugadoresModel.php');
include_once('model/EstadisticasGeneralesModel.php');
include_once('model/CategoriaModel.php');

include_once('controller/LoginController.php');
include_once('controller/MailValidationController.php');
include_once('controller/RegistroController.php');
include_once('controller/DatosLoginController.php');
include_once('controller/DatosUsuarioController.php');
include_once('controller/PerfilController.php');
include_once('controller/HomeController.php');
include_once('controller/LobbyController.php');
include_once('controller/PartidaController.php');
include_once('controller/CrearPreguntaController.php');
include_once('controller/RankingController.php');
include_once('controller/AudioController.php');
include_once('controller/LobbyEditorController.php');
include_once('controller/PreguntasSugeridasController.php');
include_once('controller/PreguntasReportadasController.php');
include_once('controller/PreguntasActivasController.php');
include_once('controller/SessionController.php');
include_once('controller/ApiController.php');
include_once('controller/LobbyAdminController.php');
include_once('controller/EstadisticasJugadoresController.php');
include_once('controller/EstadisticasPreguntasController.php');
include_once('controller/EstadisticasGeneralesController.php');
include_once('controller/CategoriaController.php');

include_once('third-party/mustache/src/Mustache/Autoloader.php');
include_once('third-party/PHPMailer-master/src/PHPMailer.php');
include_once('third-party/PHPMailer-master/src/Exception.php');
include_once('third-party/PHPMailer-master/src/SMTP.php');

class Configuration {
    private $configFile = 'config/config.ini';
    private $configMail = 'config/configMail.ini';
    private $configAPIS = 'config/configAPIS.ini';

    public function __construct() {
    }

    public function getLoginController() {
        return new LoginController($this->getModuleHelper(), new LoginModel($this->getDatabase()), $this->getRenderer());
    }

    public function getAudioController() {
        return new AudioController(new AudioModel());
    }

    public function getLobbyController() {
        return new LobbyController(new LobbyModel($this->getDatabase()),$this->getRenderer());
    }

    public function getApiController() {
        return new ApiController(new ApiModel($this->getDatabase()));
    }

    public function getMailValidationController() {
        return new MailValidationController(
            new MailValidationModel($this->getDatabase()),
            new UsuarioModel($this->getDatabase()),
            $this->getRenderer());
    }

    public function getRegistroController() {
        return new RegistroController(new RegistroModel($this->getDatabase()), $this->getRenderer(), $this->getMailer());
    }

    public function getDatosLoginController() {
        return new DatosLoginController(new DatosLoginModel($this->getDatabase()), $this->getRenderer(), $this->getFileManager());
    }

    public function getDatosUsuarioController() {
        return new DatosUsuarioController(new DatosUsuarioModel(), $this->getRenderer(), $this->getApiGoogleMaps());
    }

    public function getPerfilController() {
        return new PerfilController(
            new PerfilModel($this->getDatabase()),
            $this->getRenderer(), $this->getGeneradorQr(), $this->getApiGoogleMaps());
    }

    public function getHomeController() {
        return new HomeController($this->getRenderer());
    }

    public function getPartidaController() {
        return new PartidaController(new PartidaModel($this->getDatabase()), $this->getRenderer());
    }

    public function getCrearPreguntaController() {
        return new CrearPreguntaController(new CrearPreguntaModel($this->getDatabase()), $this->getRenderer());
    }

    public function getRankingController() {
        return new RankingController(new RankingModel($this->getDatabase()) ,$this->getRenderer());
    }

    public function getLobbyEditorController() {
        return new LobbyEditorController($this->getRenderer());
    }

    public function getPreguntasSugeridasController() {
        return new PreguntasSugeridasController(new PreguntasSugeridasModel($this->getDatabase()), $this->getRenderer());
    }

    public function getPreguntasReportadasController() {
        return new PreguntasReportadasController(new PreguntasReportadasModel($this->getDatabase()), $this->getRenderer());
    }

    public function getPreguntasActivasController() {
        return new PreguntasActivasController(new PreguntasActivasModel($this->getDatabase()), $this->getRenderer());
    }

    public function getSessionController() {
        return new SessionController();
    }

    public function getLobbyAdminController() {
        return new LobbyAdminController($this->getRenderer());
    }

    public function getEstadisticasGeneralesController() {
        return new EstadisticasGeneralesController(new EstadisticasGeneralesModel($this->getGeneradorPDF(), $this->getGeneradorGrafico(), $this->getDatabase()), $this->getRenderer());
    }

    public function getEstadisticasJugadoresController() {
        return new EstadisticasJugadoresController(new EstadisticasJugadoresModel($this->getGeneradorPDF(), $this->getGeneradorGrafico(), $this->getDatabase()), $this->getRenderer());
    }

    public function getEstadisticasPreguntasController() {
        return new EstadisticasPreguntasController(new EstadisticasPreguntasModel($this->getGeneradorPDF(), $this->getDatabase()), $this->getGeneradorGrafico(), $this->getRenderer());
    }

    public function getCategoriaController() {
        return new CategoriaController(new CategoriaModel($this->getDatabase()), $this->getRenderer());
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

    private function getConfigMail() {
        return parse_ini_file($this->configMail);
    }

    private function getConfigAPIS() {
        return parse_ini_file($this->configAPIS);
    }

    private function getApiGoogleMaps() {
        $apis = $this->getConfigAPIS();
        return $apis["ApiGoogleMaps"];
    }

    private function getPHPMailer() {
        return new PHPMailer(true);
    }

    private function getMailer() {
        $configMail = $this->getConfigMail();
        return new Mailer(
            $this->getPHPMailer(),
            $configMail["Host"],
            $configMail["SMTPAuth"],
            $configMail["Username"],
            $configMail["Password"],
            $configMail["Port"],
            $configMail["From"],
            $configMail["FromName"]
        );
    }

    public function getModuleHelper()
    {
        return new ModuleHelper();
    }

    public function getGeneradorGrafico() {
        return new GeneradorGrafico();
    }

    public function getGeneradorPDF() {
        return new GeneradorPDF();
    }
}