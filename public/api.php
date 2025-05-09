<?php
namespace App;

// Rotas para API
$router->addRoute('GET', '/api/users', 'ApiUserController', 'apiGetAllUsers');
$router->addRoute('GET', '/api/user/{id}', 'ApiUserController', 'apiGetUser');
$router->addRoute('POST', '/api/users', 'ApiUserController', 'apiCreateUser');
$router->addRoute('PUT', '/api/user/{id}', 'ApiUserController', 'apiUpdateUser');
$router->addRoute('DELETE', '/api/user/{id}', 'ApiUserController', 'apiDeleteUser');