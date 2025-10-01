<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Controllers\AuthController;
use App\Controllers\ForumController;
use Bramus\Router\Router;

$router = new Router();

$router->get('/', function() { echo ForumController::index(); });

$router->get('/login', function() { echo AuthController::login(); });
$router->post('/login', function() { echo AuthController::login(); });
$router->get('/logout', function() { AuthController::logout(); }); // Redirects internally

$router->get('/register', function() { echo AuthController::register(); });
$router->post('/register', function() { echo AuthController::register(); });

$router->post('/post', function() { echo ForumController::create(); });
$router->get('/post/(\d+)', function($id) { echo ForumController::view((int)$id); });
$router->post('/post/(\d+)/comment', function($id) { echo ForumController::addComment((int)$id); });
$router->get('/random-post', function() { \App\Controllers\ForumController::randomPost(); });

$router->run();
