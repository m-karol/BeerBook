<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Redirect;
use App\Core\Database;

class ArticleController {
    public function createForm(): void {
        // Protect page: only logged-in users
        if (!Auth::check()) {
            Redirect::to('/login');
        }

        require __DIR__ . '/../views/create_article.html';
    }

    public function store(): void {
        if (!Auth::check()) {
            Redirect::to('/login');
        }

        $title = trim($_POST['title'] ?? '');
        $content = trim($_POST['content'] ?? '');

        if ($title === '' || $content === '') {
            echo "All fields are required.";
            return;
        }

        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("
            INSERT INTO articles (user_id, title, content)
            VALUES (:user_id, :title, :content)
        ");
        $stmt->execute([
            ':user_id' => Auth::id(),
            ':title'   => $title,
            ':content' => $content,
        ]);

        echo "Article created successfully!";
    }
}
