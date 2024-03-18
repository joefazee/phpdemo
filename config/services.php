<?php

declare(strict_types=1);

use App\Core\Container;
use App\DB\Connection;
use  App\Config\Config;
use App\Repositories\PostRepository;
use App\Repositories\PostRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryInterface;
use App\Security\AuthInterface;
use App\Security\CookieAuth;
use App\Services\PostServiceInterface;
use App\Services\PostService;

$config = new Config($_ENV);
$connection = Connection::getInstance($config->db);

$container = Container::getInstance();
$container->set(PostRepositoryInterface::class, fn() => new PostRepository($connection->getPdo()));
$container->set(UserRepositoryInterface::class, fn() => new UserRepository($connection->getPdo()));
$container->set(PostServiceInterface::class, PostService::class);
$container->set(AuthInterface::class,CookieAuth::class);

return $container;
