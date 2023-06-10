<?php

class ModuleHelper
{
    private $noLoginUserSites = ["home","login","registro","datosLogin","datosUsuario","mailValidation"];
    private $loginUserSites = ["lobby", "perfil", "partida", "crearPregunta", "ranking"];

    public function __construct() {

    }

    public function chequearModulo(&$module, $usuarioEstaEnSesion) {
        if(!$usuarioEstaEnSesion) {
            if(!in_array($module, $this->noLoginUserSites)) {
                $module = 'home';
            }
        } else {
            if(!in_array($module, $this->loginUserSites)) {
                $module = 'lobby';
            }
        }
    }
}