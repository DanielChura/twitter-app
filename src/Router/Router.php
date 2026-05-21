<?php

declare(strict_types=1);

namespace App\Router;

class Router
{
    private array $routes = [];

    public function add(string $method, string $uri, callable|array $controller)
    {
        $this->routes[$method][$uri] = $controller;
    }

    public function get(string $uri, callable|array $controller)
    {
        $this->add('GET', $uri, $controller);
    }

    public function post(string $uri, callable|array $controller)
    {
        $this->add('POST', $uri, $controller);
    }

    public function dispatch()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'])['path'];

        $routesForMethod = $this->routes[$method] ?? [];

        if (isset($routesForMethod[$uri])) {
            $handler = $routesForMethod[$uri];
            return $this->executeHandler($handler);
        }

        foreach ($routesForMethod as $routePattern => $handler) {
            $params = $this->matchRoute($routePattern, $uri);
            if ($params !== null) {
                return $this->executeHandler($handler, $params);
            }
        }

        http_response_code(404);
        echo "404 not found";
    }

    private function matchRoute(string $pattern, string $uri): ?array
    {
        $regexPattern = preg_replace('/\{(\w+)\}/', '(?P<$1>\d+)', $pattern);
        $regexPattern = "#^" . $regexPattern . "$#";

        if (preg_match($regexPattern, $uri, $matches)) {
            return array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
        }

        return null;
    }

    private function executeHandler(callable|array $handler, array $params = [])
    {
        if (is_array($handler)) {
            [$class, $method] = $handler;
            $controller = new $class;
            return $controller->$method(...array_values($params));
        }

        if (is_callable($handler)) {
            return call_user_func($handler);
        }
    }
}
