<?php

declare(strict_types=1);

use App\Core\Http\Router;

$container = require __DIR__ . '/services.php';
$router = new Router($container);


$router->get('/', [\App\Controllers\HomeController::class, 'index']);
$router->get('/new-entry', [\App\Controllers\CreatePostController::class, 'index']);
$router->post('/new-entry', [\App\Controllers\CreatePostController::class, 'store']);
$router->get('/posts', [\App\Controllers\ViewPostController::class, 'index']);
$router->get('/login', [\App\Controllers\AuthController::class, 'login']);
$router->get('/privacy', [\App\Controllers\StaticPageController::class, 'privacy']);
$router->get('/ss', fn () => 'sss');

return $router;
