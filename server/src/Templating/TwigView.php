<?php
declare(strict_types=1);

namespace App\Templating;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

final class TwigView
{
    private Environment $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../../templates');
        $this->twig = new Environment($loader);
    }

    public function render(string $template, array $params = []): string
    {
        return $this->twig->render($template, $params);
    }
}
