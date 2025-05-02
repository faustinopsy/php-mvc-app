<?php
namespace App;
use App\core\Router;
$router = new Router();

// Rotas para páginas
$router->addRoute('GET', '/', 'UserController', 'index');
$router->addRoute('GET', '/user/create', 'UserController', 'create');
$router->addRoute('POST', '/user/store', 'UserController', 'store');
$router->addRoute('GET', '/user/edit/{id}', 'UserController', 'edit');
$router->addRoute('POST', '/user/update/{id}', 'UserController', 'update');
$router->addRoute('GET', '/user/delete/{id}', 'UserController', 'delete');
$router->addRoute('GET', '/user/{id}', 'UserController', 'show');

// Rotas para API
$router->addRoute('GET', '/api/user/{id}', 'UserController', 'apiGetUser');
$router->addRoute('GET', '/api/users', 'UserController', 'apiGetAllUsers');
$router->addRoute('POST', '/api/user/update/{id}', 'UserController', 'apiUpdateUser');
$router->addRoute('GET', '/api/user/delete/{id}', 'UserController', 'apiDeleteUser');