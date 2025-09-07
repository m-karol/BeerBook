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

    public function dispatch(string $uri, string $method): void {
        $path = parse_url($uri, PHP_URL_PATH);
        $method = strtoupper($method);

        if (!isset($this->routes[$method])) {
            http_response_code(404);
            echo "<h1>404 Not Found</h1>";
            return;
        }

        foreach ($this->routes[$method] as $route => [$controllerName, $action]) {
            $pattern = preg_replace('#\{[a-zA-Z_][a-zA-Z0-9_]*\}#', '([0-9]+)', $route);
            $pattern = "#^" . $pattern . "$#";

            if (preg_match($pattern, $path, $matches)) {
                array_shift($matches); // first element is the full match

                $controllerClass = "\\App\\Controllers\\$controllerName";

                if (!class_exists($controllerClass)) {
                    http_response_code(500);
                    echo "<h1>Controller $controllerClass not found</h1>";
                    return;
                }

                $controller = new $controllerClass();

                if (!method_exists($controller, $action)) {
                    http_response_code(500);
                    echo "<h1>Method $action not found in $controllerClass</h1>";
                    return;
                }

                // Pass dynamic route parameters to controller method
                $controller->$action(...$matches);
                return;
            }
        }

        http_response_code(404);
        echo "<h1>404 Not Found</h1>";
    }
}
