<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Database;
use App\Core\Redirect;

class AuthController {
    public function showRegisterForm(): void {
        require __DIR__ . '/../views/register.html';
    }

    public function register(): void {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['confirm'] ?? '';

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
        if (Auth::check()) {
            Redirect::to('/');
        }

        require __DIR__ . '/../views/login.html';
    }

    public function login(): void {
        if (Auth::check()) {
            Redirect::to('/');
        }

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($username === '' || $password === '') {
            echo "Both fields are required.";
            return;
        }

        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT id, username, password_hash, role FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password_hash'])) {
            echo "Invalid username or password.";
            return;
        }

        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'role' => $user['role'],
        ];

        Redirect::to('/');
    }


    public function logout(): void {
        unset($_SESSION['user']);
        session_destroy();
        Redirect::to('/login');
    }

}