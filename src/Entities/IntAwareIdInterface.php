<?php

declare(strict_types=1);

namespace App\Entities;

interface IntAwareIdInterface
{
    public function getId(): int;
    public function setId(int $id): void;
}
