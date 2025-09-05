<?php
declare(strict_types=1);

echo "Hello World!";

require_once __DIR__ . '/../src/core/database.php';

use src\core\database;

try {
    $db = database::getInstance()->getConnection();
    $stmt = $db->prepare('SELECT * FROM `users`');
    $row = $stmt->fetch();

    if ($row && isset($row['ok'])) {
        echo 'DB connection is ok';
    } else {
        echo 'DB connected, but test query returned unexpected result';
    }
} catch (\Throwable $e) {
    http_response_code(500);
    echo 'DB connection error: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES | ENT_SUBSTITUTE,'UTF-8');
}

