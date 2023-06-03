<?php
session_start();
include_once('Configuration.php');
$configuration = new Configuration();
$router = $configuration->getRouter();

$noLoginUserSites = ["login","registro","datosLogin","datosUsuario","mailValidation"];


$module = $_GET['module'] ?: 'home';
$method = $_GET['action'] ?: 'list';

$value = in_array($module, $noLoginUserSites);

var_dump($value);

if(!isset($_SESSION["usuario"])) {
    if(!in_array($module, $noLoginUserSites)){
        $module = 'home';
    }
} else {
    if(in_array($module, $noLoginUserSites)){
        $module = 'lobby';
    }
}

$router->route($module, $method);