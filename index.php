<?php
session_start();
include_once('Configuration.php');
$configuration = new Configuration();
$router = $configuration->getRouter();

$module = $_GET['module'] ?: 'home';
$method = $_GET['action'] ?: 'list';

if(!isset($_SESSION["usuario"])) {
    $module = $module == 'login' ? 'login'
        : ($module == 'registro' ? 'registro'
            : ($module == 'datosLogin' ? 'datosLogin'
                : ($module == 'datosUsuario' ? 'datosUsuario'
                    : 'home')));
} else {
    if($module == 'login' || $module == 'home' || $module == 'registro' || $module == 'datosLogin' || $module == 'datosUsuario') {
        $module = 'lobby';
    }
}

$router->route($module, $method);



