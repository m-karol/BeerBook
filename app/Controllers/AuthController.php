<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;
use App\Core\Redirect;

class AuthController
{
    public function showRegisterForm(): void {
        require __DIR__ . '/../views/register.html.php';
    }

    public function register(): void {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm  = $_POST['confirm'] ?? '';

        if ($username === '' || $password === '' || $confirm === '') {
            $title = "Register";
            $error = "All fields are required.";
            ob_start();
            echo "<p style='color:red;'>$error</p>";
            $content = ob_get_clean();
            require __DIR__ . '/../views/layout.html.php';
            return;
        }

        if ($password !== $confirm) {
            $title = "Register";
            $error = "Passwords do not match.";
            ob_start();
            echo "<p style='color:red;'>$error</p>";
            $content = ob_get_clean();
            require __DIR__ . '/../views/layout.html.php';
            return;
        }

        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("SELECT id FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        if ($stmt->fetch()) {
            $title = "Register";
            $error = "Username already taken.";
            ob_start();
            echo "<p style='color:red;'>$error</p>";
            $content = ob_get_clean();
            require __DIR__ . '/../views/layout.html.php';
            return;
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $db->prepare("INSERT INTO users (username, password_hash, role) 
                              VALUES (:username, :password_hash, 'user')");
        $stmt->execute([
            ':username' => $username,
            ':password_hash' => $hash
        ]);

        Redirect::to('/login');
    }

    public function showLoginForm(): void {
        require __DIR__ . '/../views/login.html.php';
    }

    public function login(): void {
        require __DIR__ . '/../views/articles.html.php';
    }

    public function logout(): void {

        // Clear session data
        $_SESSION = [];
        session_destroy();

        // Redirect to home
        header("Location: /");
        exit;
    }

}