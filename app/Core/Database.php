<?php
declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;
use PDOStatement;

class Database {
    private static ?self $instance = null;
    private PDO $pdo;

    private function __construct() {

        $host = getenv('DB_HOST') ?: 'db';
        $port = getenv('DB_PORT') ?: '5432';
        $dbname = getenv('DB_NAME') ?: 'db';
        $user = getenv('DB_USER') ?: 'docker';
        $password = getenv('DB_PASS') ?: 'docker';

        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $user, $password, $options);
            $this->pdo->exec("SET NAMES 'utf8'");
        } catch (PDOException $e) {
            throw new \RuntimeException("Database connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance(): self {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection(): PDO {
        return $this->pdo;
    }

    public function query(string $query, array $params = []): PDOStatement {
        $statement = $this->pdo->prepare($query);
        $statement->execute($params);
        return $statement;
    }

    private function __wakeup() {}
    private function __clone() {}

}