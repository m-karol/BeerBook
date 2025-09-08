<?php
declare(strict_types=1);

namespace App\Controllers;

class HomeController
{
    public function index(): void {
        require __DIR__ . '/../views/home.html.php';
    }

    public function about(): void {
        require __DIR__ . '/../views/about.html.php';
    }
}