<?php
$title = "About";
ob_start();
?>
    <h1>About This Project</h1>
    <p>This is a small CRUD learning project built with PHP, PostgreSQL, and Nginx.</p>
    <p>It includes authentication, articles, and comments.</p>
<?php
$content = ob_get_clean();
require __DIR__ . '/layout.html.php';
