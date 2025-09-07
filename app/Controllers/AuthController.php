<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;
use App\Core\Redirect;

class AuthController
{
    public function showRegisterForm(): void {
        require __DIR__ . '/../views/register.html';
    }

    public function register(): void {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm  = $_POST['confirm'] ?? '';

        if ($username === '' || $password === '' || $confirm === '') {
            echo "All fields are required.";
            return;
        }

        if ($password !== $confirm) {
            echo "Passwords do not match.";
            return;
        }

        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("SELECT id FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        if ($stmt->fetch()) {
            echo "Username already taken.";
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
        echo "<h1>Login Page (to be implemented)</h1>";
    }

    public function login(): void {
        echo "Login handling (to be implemented)";
    }

}