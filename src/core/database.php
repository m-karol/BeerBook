<?php
declare(strict_types=1);

namespace src\core;

use http\Exception\RuntimeException;

final class database {

    private static ?self $instance = null;
    private \PDO $pdo;

    private function __construct() {
        $host = getenv('DB_HOST') ?: '127.0.0.1';
        $port = getenv('DB_PORT') ?: '5432';
        $dbname = getenv('DB_DATABASE') ?: 'db';
        $user = getenv('DB_USERNAME') ?: 'docker';
        $password = getenv('DB_PASSWORD') ?: 'docker';

        $dsn = sprintf('pgsql:host=%s;port=%s;dbname=%s',$host,$port,$dbname);

        $options = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $this->pdo = new \PDO($dsn, $user, $password, $options);
            $this->pdo->exec('SET NAMES utf8');
        } catch (\PDOException $e) {
            throw new \RuntimeException('Database connection error: ' . $e->getMessage(), (int)$e->getCode(), $e);
        }
    }

    public static function getInstance(): self {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection(): \PDO {
        return $this->pdo;
    }

    public function query(string $query, array $params = []): \PDOStatement {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }

    private function __clone() {}
    private function __wakeup(): void {}

}