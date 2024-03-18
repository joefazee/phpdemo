<?php

declare(strict_types=1);

namespace App\Core;

use App\Exceptions\ContainerException;
use App\Exceptions\NotFoundException;

class Container
{
    private static ?Container $instance = null;
    private array $services = [];

    public static function getInstance(): Container
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @throws \ReflectionException
     * @throws \App\Exceptions\NotFoundException
     * @throws \App\Exceptions\ContainerException
     */
    public function get(string $id)
    {
        if ($this->has($id)) {
            $service = $this->services[$id];
            if (is_callable($service)) {
                return $service($this);
            }
            $id = $service;
        }

        return $this->resolveService($id);
    }

    public function has(string $id): bool
    {
        return array_key_exists($id, $this->services);
    }

    public function set(string $id, callable|string $concrete): static
    {
        $this->services[$id] = $concrete;
        return $this;
    }

    /**
     * @throws \ReflectionException
     * @throws \App\Exceptions\NotFoundException
     * @throws \App\Exceptions\ContainerException
     */
    private function resolveService(mixed $id)
    {
        $reflectionClass = $this->getReflectionClass($id);
        $constructor = $reflectionClass->getConstructor();

        if (is_null($constructor)) {
            return new $id();
        }

        $parameters = $constructor->getParameters();

        if (empty($parameters)) {
            return new $id();
        }

        $dependencies = $this->getDependencies($parameters, $id);

        return $reflectionClass->newInstanceArgs($dependencies);
    }

    private function getReflectionClass(mixed $id): \ReflectionClass
    {
        try {
            return new \ReflectionClass($id);
        } catch (\ReflectionException $e) {
            throw new NotFoundException("Class $id not found: " . $e->getMessage());
        }
    }

    private function getDependencies(array $parameters, mixed $id): array
    {
        return array_map(
            function (\ReflectionParameter $param) use ($id) {
                $name = $param->getName();
                $type = $param->getType();

                if (! $type) {
                    throw new ContainerException(
                        'Failed to resolve class "' . $id . '" because param "' . $name . '" is missing a type hint'
                    );
                }

                if ($type instanceof \ReflectionUnionType) {
                    throw new ContainerException(
                        'Failed to resolve class "' . $id . '" because of union type for param "' . $name . '"'
                    );
                }

                if ($type instanceof \ReflectionNamedType && ! $type->isBuiltin()) {
                    return $this->get($type->getName());
                }

                throw new ContainerException(
                    'Failed to resolve class "' . $id . '" because invalid param "' . $name . '"'
                );
            },
            $parameters
        );
    }
}
