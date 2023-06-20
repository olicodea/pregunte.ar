<?php

class ModuleHelper
{
    private $noLoginUserSites = ["home","login","registro","datosLogin","datosUsuario","mailValidation"];
    private $loginUserSites = ["lobby", "perfil", "partida", "crearPregunta", "ranking", "session", "audio"];
    private $editorSites = ["lobbyEditor", "perfil", "preguntasActivas", "preguntasSugeridas", "preguntasReportadas", "crearPregunta", "session"];
    public function __construct() {

    }

    public function chequearModulo(&$module, $usuarioEnSesion) {
        if(!$usuarioEnSesion) {
            if(!in_array($module, $this->noLoginUserSites)) {
                $module = 'home';
            }
        } else {
            $rolUsuario = $usuarioEnSesion["idRol"];

            if(!in_array($module, $this->getSitesPorRol($rolUsuario))) {
                $module = $this->getLobbyPorRol($rolUsuario);
            }
        }
    }

    private function getSitesPorRol($rolUsuario)
    {
        //TODO: El rol habria que verificarlo con el string "Editor", "Jugador"
        switch ($rolUsuario) {
            case 1:
               return $this->loginUserSites;
            case 2:
                return $this->editorSites;
        }

        return null;
    }

    public function getLobbyPorRol($rolUsuario)
    {
        //TODO: El rol habria que verificarlo con el string "Editor", "Jugador"
        switch ($rolUsuario) {
            case 1:
                return "lobby";
            case 2:
                return "lobbyEditor";
        }

        return "home";
    }
}