<?php
// Habilitar errores para ver qué falla
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// 1. Validar si existe la configuración de la base de datos
if (!file_exists('config/database.php')) {
    die("<b>Error:</b> El archivo <code>config/database.php</code> no existe.");
}
require_once 'config/database.php';

// 2. Procesar la URL limpiando los parámetros GET (?categoria=1)
$urlRequest = isset($_GET['url']) ? $_GET['url'] : 'home';
$urlClean = strtok($urlRequest, '?');
$urlParams = explode('/', rtrim($urlClean, '/'));

$controllerName = !empty($urlParams[0]) ? ucfirst($urlParams[0]) . 'Controller' : 'HomeController';
$methodName = isset($urlParams[1]) && !empty($urlParams[1]) ? $urlParams[1] : 'index';

$controllerFile = 'controllers/' . $controllerName . '.php';

// 3. Validar si existe el controlador
if (!file_exists($controllerFile)) {
    die("<b>Error:</b> No se encontró el archivo del controlador en <code>{$controllerFile}</code>.");
}

require_once $controllerFile;

if (!class_exists($controllerName)) {
    die("<b>Error:</b> El archivo <code>{$controllerFile}</code> existe, pero no tiene la clase <code>{$controllerName}</code>.");
}

$controller = new $controllerName();

if (!method_exists($controller, $methodName)) {
    die("<b>Error:</b> El controlador <code>{$controllerName}</code> no tiene el método <code>{$methodName}</code>.");
}

// 4. Ejecutar la acción
$param = isset($urlParams[2]) ? $urlParams[2] : null;
$controller->$methodName($param);