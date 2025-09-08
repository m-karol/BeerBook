<?php
include __DIR__ . '/../partials/nav.html.php'; ?>

<main style="padding:2em; max-width:600px; margin:auto;">
    <h1>Create Article</h1>

    <form method="POST" action="/articles">
        <label>
            Title:<br>
            <input type="text" name="title" required style="width:100%; padding:0.5em;">
        </label>
        <br><br>
        <label>
            Content:<br>
            <textarea name="content" rows="6" required style="width:100%; padding:0.5em;"></textarea>
        </label>
        <br><br>
        <button type="submit" style="padding:0.5em 1em;">Publish</button>
    </form>
</main>
