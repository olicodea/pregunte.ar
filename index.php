<?php
session_start();
include_once('Configuration.php');
$configuration = new Configuration();
$router = $configuration->getRouter();

$module = '';
$method = '';

if(!isset($_SESSION["usuario"])) {
    $module = $_GET['module'] ?? 'home';
    $method = $_GET['action'] ?? 'list';
} else {
    $module = $_GET['module'] ?? 'lobby';
    $method = $_GET['action'] ?? 'list';
}

$router->route($module, $method);



