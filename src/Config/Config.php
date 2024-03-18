<?php

declare(strict_types=1);

namespace App\Config;

/**
 * @property-read ?array $db
 */
class Config
{
    /**
     * @var array<string, mixed> $config
     */
    protected array $config = [];

    /**
     * @param array<string, string> $env
     */
    public function __construct(array $env)
    {
        $this->config = [
            'db' => [
                'host'     => $env['DB_HOST'],
                'user'     => $env['DB_USER'],
                'pass'     => $env['DB_PASS'],
                'database' => $env['DB_NAME'],
                'driver'   => $env['DB_DRIVER'] ?? 'mysql',
            ],
        ];
    }

    public function __get(string $name): mixed
    {
        return $this->config[$name] ?? null;
    }
}
