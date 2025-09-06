<?php
declare(strict_types=1);

require_once __DIR__ . '/../app/Core/Database.php';

use App\Core\Database;

try {
    $db = Database::getInstance()->getConnection();
    $stmt = $db->query('SELECT NOW() as current_time');
    $row = $stmt->fetch();
    echo "Connected to database!";
    echo "<br>";
    echo "Server time: " . htmlspecialchars($row['current_time']) . "<br>";
} catch (Throwable $e) {
    http_response_code(500);
    echo "Database connection failed!";
    echo "<br>";
    echo htmlspecialchars($e->getMessage());
}
