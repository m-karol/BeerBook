<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;

class CommentController
{
    public function store($id): void {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            http_response_code(403);
            echo "You must be logged in to post a comment.";
            return;
        }

        $content = trim($_POST['content'] ?? '');
        if ($content === '') {
            echo "Comment cannot be empty.";
            return;
        }

        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO comments (article_id, user_id, content) 
                              VALUES (:article_id, :user_id, :content)");
        $stmt->execute([
            ':article_id' => $id,
            ':user_id' => $_SESSION['user_id'],
            ':content' => $content,
        ]);

        header("Location: /articles/$id");
        exit;
    }
}
