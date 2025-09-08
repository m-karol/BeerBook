<?php
$title = "Welcome to My App";
ob_start();
?>
    <h1>Welcome!</h1>
    <p>This is a simple CRUD learning project built with PHP, PostgreSQL, and Nginx.</p>
    <p>Use the navigation above to explore the site.</p>
<?php
$content = ob_get_clean();
require __DIR__ . '/layout.html.php';
