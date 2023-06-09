<?php
session_start();
include_once('Configuration.php');
$configuration = new Configuration();
$router = $configuration->getRouter();
$userSessionHelper = $configuration->getModuleHelper();

$module = $_GET['module'] ?: 'home';
$method = $_GET['action'] ?: 'list';

$userSessionHelper->chequearModulo($module, isset($_SESSION["usuario"]));

$router->route($module, $method);
