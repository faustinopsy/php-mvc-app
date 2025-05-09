<?php
namespace App\Core;

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
                $routeParts = explode('/', trim($route['path'], '/'));
                $uriParts = explode('/', trim($requestUri, '/'));

                if (count($routeParts) !== count($uriParts)) {
                    continue; // Se o número de segmentos não for igual, pule para a próxima rota
                }

                $params = [];
                $isMatch = true;

                foreach ($routeParts as $index => $part) {
                    if (strpos($part, '{') === 0 && strpos($part, '}') === strlen($part) - 1) {
                        // É um parâmetro dinâmico, capture o valor
                        $params[] = $uriParts[$index];
                    } elseif ($part !== $uriParts[$index]) {
                        // Não é um parâmetro e não corresponde, então não é uma rota válida
                        $isMatch = false;
                        break;
                    }
                }

                if ($isMatch) {
                    return [
                        'controller' => $route['controller'],
                        'action' => $route['action'],
                        'params' => $params
                    ];
                }
            }
        }
        return null; // Nenhuma rota correspondente encontrada
    }
}