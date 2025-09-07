<?php
declare(strict_types=1);

return [
    // route => [controller, method]
    'GET' => [
        '/'        => ['HomeController', 'index'],
        '/about'   => ['HomeController', 'about'],
        '/register' => ['AuthController', 'showRegisterForm'],
        '/login'   => ['AuthController', 'showLoginForm'],
        '/logout'    => ['AuthController', 'logout'],
        '/articles/create' => ['ArticleController', 'createForm'],
        '/articles'        => ['ArticleController', 'index'],
        '/articles/{id}' => ['ArticleController', 'show'],
    ],
    'POST' => [
        '/register' => ['AuthController', 'register'],
        '/login'    => ['AuthController', 'login'],
        '/articles/create' => ['ArticleController', 'store'],
        '/articles/{id}/comments' => ['CommentController', 'store'],
    ]
];