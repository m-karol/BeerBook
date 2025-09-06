<?php
declare(strict_types=1);

namespace App\Core;

class Autoloader {
    public static function register(): void {
        spl_autoload_register(function (string $class): void {
            // Only handle classes in "App\" namespace
            if (strpos($class, 'App\\') !== 0) {
                return;
            }

            // Convert namespace to file path
            $relativeClass = substr($class, 4); // remove "App\"
            $relativePath  = str_replace('\\', DIRECTORY_SEPARATOR, $relativeClass) . '.php';

            $file = __DIR__ . '/../' . $relativePath;

            if (file_exists($file)) {
                require $file;
            }
        });
    }
}
