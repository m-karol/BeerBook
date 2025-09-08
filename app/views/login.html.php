<?php
$title = "Login";
ob_start();
?>
    <h1>Login</h1>
    <form method="POST" action="/login">
        <label>
            Username:
            <input type="text" name="username" required>
        </label>
        <br><br>
        <label>
            Password:
            <input type="password" name="password" required>
        </label>
        <br><br>
        <button type="submit">Login</button>
    </form>
<?php
$content = ob_get_clean();
require __DIR__ . '/layout.html.php';
