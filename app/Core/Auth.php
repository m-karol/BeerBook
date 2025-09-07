<?php

declare(strict_types=1);

namespace App\Core;

class Auth
{
    public static function check(): bool {
        return isset($_SESSION['user']);
    }

    public static function user(): ?array {
        return $_SESSION['user'] ?? null;
    }

    public static function id(): ?int {
        return $_SESSION['user']['id'] ?? null;
    }

    public static function role(): ?string {
        return $_SESSION['user']['role'] ?? null;
    }
}
