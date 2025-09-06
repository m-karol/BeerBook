<?php
declare(strict_types=1);

namespace App\Core;

class Router {
    private array $routes;

    public function __construct(string $routesFile) {
        if (!file_exists($routesFile)) {
            throw new \RuntimeException("Routes file not found: $routesFile");
        }
        $this->routes = require $routesFile;
    }

    public function dispatch(string $uri): void {
        $path = parse_url($uri, PHP_URL_PATH);

        if (!isset($this->routes[$path])) {
            http_response_code(404);
            echo "<h1>404 Not Found</h1>";
            return;
        }

        [$controllerName, $method] = $this->routes[$path];
        $controllerClass = "\\App\\Controllers\\$controllerName";

        if (!class_exists($controllerClass)) {
            http_response_code(500);
            echo "<h1>Controller $controllerClass not found</h1>";
            return;
        }

        $controller = new $controllerClass();

        if (!method_exists($controller, $method)) {
            http_response_code(500);
            echo "<h1>Method $method not found in $controllerClass</h1>";
            return;
        }

        $controller->$method();

    }
}