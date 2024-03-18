<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\PostInterface;

interface PostRepositoryInterface
{
    public function find(int $id): ?PostInterface;
    public function all(int $offset, int $limit): array;
    public function save(PostInterface $post): PostInterface;
    public function setTotalRecords(int $n): void;
    public function getTotalRecords(): int;
}
