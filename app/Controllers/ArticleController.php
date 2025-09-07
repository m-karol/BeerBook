<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;

class ArticleController
{
    public function index(): void {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("SELECT id, title FROM articles ORDER BY created_at DESC");
        $articles = $stmt->fetchAll();

        require __DIR__ . '/../views/articles/index.php';
    }

    public function createForm(): void {
        require __DIR__ . '/../views/articles/create.html';
    }

    public function store(): void {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            http_response_code(403);
            echo "You must be logged in to create an article.";
            return;
        }

        $title = trim($_POST['title'] ?? '');
        $content = trim($_POST['content'] ?? '');

        if ($title === '' || $content === '') {
            echo "Both title and content are required.";
            return;
        }

        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO articles (title, content, user_id) VALUES (:title, :content, :user_id)");
        $stmt->execute([
            ':title' => $title,
            ':content' => $content,
            ':user_id' => $_SESSION['user_id'],
        ]);

        header("Location: /articles");
        exit;
    }

    public function show($id): void {
        $db = Database::getInstance()->getConnection();

        // Get the article
        $stmt = $db->prepare("SELECT a.*, u.username FROM articles a 
                              JOIN users u ON a.user_id = u.id
                              WHERE a.id = :id");
        $stmt->execute([':id' => $id]);
        $article = $stmt->fetch();

        if (!$article) {
            http_response_code(404);
            echo "Article not found.";
            return;
        }

        // Get comments
        $stmt = $db->prepare("SELECT c.*, u.username 
                              FROM comments c 
                              JOIN users u ON c.user_id = u.id 
                              WHERE c.article_id = :id 
                              ORDER BY c.created_at ASC");
        $stmt->execute([':id' => $id]);
        $comments = $stmt->fetchAll();

        require __DIR__ . '/../views/show.html';
    }
}
