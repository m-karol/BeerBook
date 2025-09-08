<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'My App' ?></title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<header>
    <?php
    $isLoggedIn = isset($_SESSION['user_id']);
    ?>
    <nav style="background:#333; padding:1em; display:flex; justify-content:space-between; align-items:center;">
        <div>
            <a href="/" style="color:white; margin-right:1em; text-decoration:none;">Home</a>
            <a href="/articles" style="color:white; margin-right:1em; text-decoration:none;">Articles</a>
            <a href="/about" style="color:white; margin-right:1em; text-decoration:none;">About</a>

            <?php if (!$isLoggedIn): ?>
                <a href="/login" style="color:white; margin-right:1em; text-decoration:none;">Login</a>
                <a href="/register" style="color:white; margin-right:1em; text-decoration:none;">Register</a>
            <?php else: ?>
                <a href="/articles/create" style="color:white; margin-right:1em; text-decoration:none;">Create Article</a>
            <?php endif; ?>
        </div>

        <div>
            <?php if ($isLoggedIn): ?>
                <form method="POST" action="/logout" style="margin:0;">
                    <button type="submit" style="background:#ff4d4d; border:none; padding:0.5em 1em; color:white; cursor:pointer;">
                        Logout
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </nav>
</header>

<main class="container">
    <?= $content ?? '' ?>
</main>


</body>
</html>

