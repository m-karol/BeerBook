<?php
declare(strict_types=1);

namespace app\Core;

class Redirect
{
    public static function to(string $path): void
    {
        header("Location: $path");
        exit;
    }
}