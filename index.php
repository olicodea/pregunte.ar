<?php
session_start();
include_once('Configuration.php');
$configuration = new Configuration();
$router = $configuration->getRouter();

$module = $_GET['module'] ?: 'home';
$method = $_GET['action'] ?: 'list';


if(!isset($_SESSION["usuario"])) {
    $module = $module == 'login' ? 'login': 'home';
} else {
    if($module == 'login' || $module == 'home'){
        $module = 'lobby';
    }
}

$router->route($module, $method);



