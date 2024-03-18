<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\PostData;
use App\Entities\PostInterface;

interface PostServiceInterface
{
    public function createPost(PostData $postData): PostInterface;

    public function getPost(int $id): PostInterface;
}
