<?php
namespace App;
use App\core\Router;
$router = new Router();

// Rotas para páginas
$router->addRoute('GET', '/', 'UserController', 'index');
$router->addRoute('GET', '/user/create', 'UserController', 'create');
$router->addRoute('GET', '/user/edit/{id}', 'UserController', 'edit');
$router->addRoute('GET', '/user/view/{id}', 'UserController', 'show');

$router->addRoute('POST', '/user/store', 'UserController', 'store');
$router->addRoute('POST', '/user/update/{id}', 'UserController', 'update');
$router->addRoute('GET', '/user/delete/{id}', 'UserController', 'delete');

// Rotas para API
$router->addRoute('GET', '/api/users', 'ApiUserController', 'apiGetAllUsers');
$router->addRoute('GET', '/api/user/{id}', 'ApiUserController', 'apiGetUser');
$router->addRoute('POST', '/api/users', 'ApiUserController', 'apiCreateUser');
$router->addRoute('PUT', '/api/user/{id}', 'ApiUserController', 'apiUpdateUser');
$router->addRoute('DELETE', '/api/user/{id}', 'ApiUserController', 'apiDeleteUser');