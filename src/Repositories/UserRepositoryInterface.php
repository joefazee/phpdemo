<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\UserInterface;

interface UserRepositoryInterface
{
    public function find(int $id): ?UserInterface;
    public function save(UserInterface $blog): UserInterface;
}
