<?php
declare(strict_types=1);

namespace App\Database;

use PDO;
use PDOException;

final class Connection
{
    private static PDO $instance;

    private function __construct() {}
    private function __clone(): void {}

    public static function init(): void
    {
        $dsn = sprintf(
            'pgsql:host=%s;port=%s;dbname=%s',
            getenv('DB_HOST') ?: 'localhost',
            getenv('DB_PORT') ?: '5432',
            getenv('DB_NAME') ?: 'pgdb'
        );
        $user = getenv('DB_USER') ?: 'pguser';
        $password = getenv('DB_PASSWORD') ?: '3344';

        try {
            self::$instance = new PDO($dsn, $user, $password, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            throw new \RuntimeException('DB connection failed: ' . $e->getMessage());
        }
    }

    public static function get(): PDO
    {
        return self::$instance;
    }
}

// Run on class load - more predicatble than lazy loading :3
Connection::init();
