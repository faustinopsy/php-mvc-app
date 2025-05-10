<?php
namespace App;

// Rotas para páginas
$router->addRoute('GET', '/', 'UserController', 'index');
$router->addRoute('GET', '/user/create', 'UserController', 'create');
$router->addRoute('GET', '/user/edit/{id}', 'UserController', 'edit');
$router->addRoute('GET', '/user/view/{id}', 'UserController', 'show');

$router->addRoute('POST', '/user/store', 'UserController', 'store');
$router->addRoute('POST', '/user/update/{id}', 'UserController', 'update');
$router->addRoute('POST', '/user/delete/{id}', 'UserController', 'delete');
