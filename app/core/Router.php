<?php
namespace App\core;

class Router {
    private $routes = [];

    public function addRoute($method, $path, $controller, $action) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'controller' => $controller,
            'action' => $action
        ];
    }

    public function resolve($requestMethod, $requestUri) {
        foreach ($this->routes as $route) {
            if ($route['method'] === $requestMethod) {
                $pattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_-]+)', $route['path']);
                $pattern = '#^' . $pattern . '$#';

                if (preg_match($pattern, $requestUri, $matches)) {
                    array_shift($matches); // Remove o primeiro elemento (URI completo)
                    return [
                        'controller' => $route['controller'],
                        'action' => $route['action'],
                        'params' => $matches // Parâmetros capturados
                    ];
                }
            }
        }
        return null;
    }
}