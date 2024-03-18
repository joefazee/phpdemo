<?php

declare(strict_types=1);

namespace App\Core;

use App\Core\Http\Router;

readonly class App
{
    public function __construct(private Router $router)
    {
    }

    /**
     * @throws \ReflectionException
     * @throws \App\Exceptions\NotFoundException
     * @throws \App\Exceptions\ContainerException
     */
    public function execute(): string
    {
        return $this->router->resolve($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
    }
}
