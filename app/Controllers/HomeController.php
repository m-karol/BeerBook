<?php
declare(strict_types=1);

namespace App\Controllers;

class HomeController
{
    public function index(): void
    {
        echo "<h1>Hello from HomeController::index()</h1>";
        echo "<p>If you see this, routing works!</p>";
    }

    public function about(): void
    {
        echo "<h1>About Page</h1>";
        echo "<p>This is a simple test page served via Router.</p>";
    }
}