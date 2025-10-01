<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Database\Connection;
use App\Templating\TwigView;

final class ForumController
{
    public static function index(): string
    {
        $pdo = Connection::get();
        $posts = $pdo->query('
            SELECT p.id, p.content, u.email
            FROM posts p
            JOIN users u ON u.id = p.user_id
            ORDER BY p.id DESC
        ')->fetchAll();

        $view = new TwigView();

        session_start();
        $loggedIn = isset($_SESSION['user_id']);

        return $view->render('forum.twig', [
            'posts' => $posts,
            'loggedIn' => $loggedIn
        ]);
    }

    public static function create(): string
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            http_response_code(403);
            return json_encode(['error' => 'Not logged in']);
        }

        $title = trim($_POST['title'] ?? '');
        $content = trim($_POST['content'] ?? '');
        if ($content === '' || $title === '') {
            http_response_code(400);
            return json_encode(['error' => 'Title and content required']);
        }

        $pdo = Connection::get();
        $stmt = $pdo->prepare('INSERT INTO posts (user_id, title, content) VALUES (?, ?, ?)');
        $stmt->execute([$_SESSION['user_id'], $title, $content]);

        return json_encode(['success' => true]);
    }

    public static function view(int $id): string
    {
        $pdo = Connection::get();

        $stmt = $pdo->prepare('
            SELECT p.id, p.title, p.content, u.email 
            FROM posts p 
            JOIN users u ON u.id = p.user_id 
            WHERE p.id = ?
        ');
        $stmt->execute([$id]);
        $post = $stmt->fetch();

        if (!$post) {
            http_response_code(404);
            return "Post not found";
        }

        $stmt = $pdo->prepare('
            SELECT c.id, c.content, u.email 
            FROM comments c 
            JOIN users u ON u.id = c.user_id 
            WHERE c.post_id = ? 
            ORDER BY c.id ASC
        ');
        $stmt->execute([$id]);
        $comments = $stmt->fetchAll();

        session_start();
        $loggedIn = isset($_SESSION['user_id']);

        $view = new \App\Templating\TwigView();
        return $view->render('post.twig', [
            'post' => $post,
            'comments' => $comments,
            'loggedIn' => $loggedIn
        ]);
    }

    public static function addComment(int $postId): string
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            http_response_code(403);
            return json_encode(['error' => 'Not logged in']);
        }

        $content = trim($_POST['content'] ?? '');
        if ($content === '') {
            http_response_code(400);
            return json_encode(['error' => 'Empty comment']);
        }

        $pdo = Connection::get();
        $stmt = $pdo->prepare('INSERT INTO comments (post_id, user_id, content) VALUES (?, ?, ?)');
        $stmt->execute([$postId, $_SESSION['user_id'], $content]);

        return json_encode(['success' => true]);
    }

    public static function randomPost(): void
    {
        $pdo = Connection::get();
        $stmt = $pdo->query('SELECT id FROM posts ORDER BY RANDOM() LIMIT 1');
        $post = $stmt->fetch();

        header('Content-Type: application/json');

        if ($post) {
            echo json_encode(['postId' => $post['id']]);
        } else {
            echo json_encode(['error' => 'No posts available']);
        }
    }
}
