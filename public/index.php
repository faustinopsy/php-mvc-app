<?php
session_start();

require_once '../vendor/autoload.php';
use App\Core\Router;
$router = new Router();

require_once './web.php';
require_once './api.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__. '/../');
$dotenv->load();

$route = $router->resolve($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

if ($route) {
    $controllerName = "App\\Controllers\\" . $route['controller'];
    $action = $route['action'];
    $params = $route['params'] ?? [];

    $controller = new $controllerName();

    call_user_func_array([$controller, $action], $params);
} else {
    http_response_code(404);
    require '../app/Views/errors/404.php';
}