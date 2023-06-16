<?php
session_start();
include_once('Configuration.php');
$configuration = new Configuration();
$router = $configuration->getRouter();
$moduleHelper = $configuration->getModuleHelper();

$module = $_GET['module'] ?: 'home';
$method = $_GET['action'] ?: 'list';

$moduleHelper->chequearModulo($module, $_SESSION["usuario"] ?? false);

$router->route($module, $method);
