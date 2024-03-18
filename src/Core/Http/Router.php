<?php

declare(strict_types=1);

namespace App\Core\Http;

use App\Core\Container;
use App\Exceptions\NotFoundException;

class Router
{
    private array $routes = [];

    public function __construct(private readonly Container $container)
    {
    }

    public function register(HttpMethod $httpMethod, string $path, callable|array $action): self
    {
        $this->routes[$httpMethod->value][$path] = $action;
        return $this;
    }

    public function get(string $path, callable|array $action): self
    {
        return $this->register(HttpMethod::GET, $path, $action);
    }

    public function post(string $path, callable|array $action): self
    {
        return $this->register(HttpMethod::POST, $path, $action);
    }

    public function all(): array
    {
        return $this->routes;
    }

    /**
     * @throws \ReflectionException
     * @throws \App\Exceptions\NotFoundException
     * @throws \App\Exceptions\ContainerException
     */
    public function resolve(string $httpMethod, string $path)
    {
        $routePath = explode('?', $path)[0];
        $action = $this->routes[$httpMethod][$routePath] ?? null;
        if ($action === null) {
            throw new NotFoundException('Route: ' . $routePath . ' not found');
        }

        if (is_callable($action)) {
            return $action();
        }

        [$controller, $method] = $action;
        if (class_exists($controller)) {
            $classObj = $this->container->get($controller);

            if (method_exists($classObj, $method)) {
                return call_user_func_array([$classObj, $method], []);
            }
        }

        throw new NotFoundException('Route: ' . $routePath . ' not found');
    }
}
