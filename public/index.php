<?php
declare(strict_types=1);

require __DIR__ . '/../app/Core/Autoloader.php';

use App\Core\Autoloader;
use App\Core\Router;

// Register custom autoloader
Autoloader::register();

// Boot the router
$router = new Router(__DIR__ . '/../app/routes.php');
$router->dispatch($_SERVER['REQUEST_URI']);
