<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($article['title']) ?></title>
<link rel="stylesheet" href="/css/style.css">
</head>
<body>
<?php include __DIR__ . '/../views/partials/nav.html.php'; ?>

<main class="container">
    <article class="article">
        <h1><?= htmlspecialchars($article['title']) ?></h1>
        <p class="meta">
            By <strong><?= htmlspecialchars($article['username']) ?></strong>
            on <?= htmlspecialchars($article['created_at']) ?>
        </p>
        <div class="content">
            <?= nl2br(htmlspecialchars($article['content'])) ?>
        </div>
    </article>

    <section class="comments">
        <h2>Comments</h2>

        <?php if (empty($comments)): ?>
            <p>No comments yet.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($comments as $comment): ?>
                    <li class="comment">
                        <p><strong><?= htmlspecialchars($comment['username']) ?></strong>
                            (<?= htmlspecialchars($comment['created_at']) ?>)</p>
                        <p><?= nl2br(htmlspecialchars($comment['content'])) ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </section>
</main>
</body>
</html>
