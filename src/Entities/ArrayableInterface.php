<?php

declare(strict_types=1);

namespace App\Entities;

interface ArrayableInterface
{
    public function toArray(): array;
}
