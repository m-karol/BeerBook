<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Database\Connection;
use App\Templating\TwigView;

final class AuthController
{
    public static function login(): string
    {
        $view = new TwigView();

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            return $view->render('login.twig');
        }

        $pdo = Connection::get();
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $stmt = $pdo->prepare('SELECT id, password FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password'])) {
            http_response_code(400);
            return json_encode(['error' => 'Invalid credentials']);
        }

        session_start();
        $_SESSION['user_id'] = $user['id'];

        return json_encode(['success' => true]);
    }

    public static function register(): string
    {
        $view = new TwigView();

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            return $view->render('register.twig');
        }

        $pdo = Connection::get();
        $email = $_POST['email'] ?? '';
        $password = password_hash($_POST['password'] ?? '', PASSWORD_DEFAULT);

        $stmt = $pdo->prepare('INSERT INTO users (email, password) VALUES (?, ?)');
        try {
            $stmt->execute([$email, $password]);
        } catch (\PDOException $e) {
            http_response_code(400);
            return json_encode(['error' => 'Email already in use']);
        }

        return json_encode(['success' => true]);
    }

    public static function logout(): void
    {
        session_start();
        session_destroy();
        header('Location: /login');
    }
}
