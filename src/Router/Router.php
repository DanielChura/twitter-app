<?php

declare(strict_types=1);

namespace App\Router;

class Router
{
    private array $routes = [];

    public function add(
        string $method,
        string $uri,
        callable|array $controller,
    ) {
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

    public function put(string $uri, callable|array $controller)
    {
        $this->add('PUT', $uri, $controller);
    }

    public function delete(string $uri, callable|array $controller)
    {
        $this->add('DELETE', $uri, $controller);
    }

    public function dispatch()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'])['path'];


        $routesForMethod = $this->routes[$method] ?? [];

        if (isset($routesForMethod[$uri])) {
            $handler = $routesForMethod[$uri];

            if (is_array($handler)) {
                [$class, $method] = $handler;
                $controller = new $class;
                return $controller->$method();
            }

            if (is_callable($handler)) {
                return call_user_func($handler);
            }

        }
        http_response_code(404);
        echo "404 not found";
    }
}