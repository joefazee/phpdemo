<?php

declare(strict_types=1);

namespace App\Core\Http;

enum StatusCode: int
{
    case OK  = 200;

    case CREATED = 201;

    case NOT_FOUND = 404;
    case INTERNAL_SERVER_ERROR = 500;

    public function getDescription(): string
    {
        return match ($this) {
            self::OK => 'OK',
            self::CREATED => 'Created',
            self::NOT_FOUND => 'Not Found',
            self::INTERNAL_SERVER_ERROR => 'Internal Server Error',
        };
    }
}
