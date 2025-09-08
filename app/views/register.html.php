<?php
$title = "Register";
ob_start();
?>
    <h1>Register</h1>
    <form method="POST" action="/register">
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
        <label>
            Confirm Password:
            <input type="password" name="confirm" required>
        </label>
        <br><br>
        <button type="submit">Register</button>
    </form>
<?php
$content = ob_get_clean();
require __DIR__ . '/layout.html.php';
