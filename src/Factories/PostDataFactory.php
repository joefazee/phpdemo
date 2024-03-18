<?php

declare(strict_types=1);

namespace App\Factories;

use App\DTO\PostData;

class PostDataFactory
{
    public function create(
        string $title,
        string $content,
        string $thumbnail,
        int $authorId
    ): PostData {
        return new PostData(
            title: $title,
            content: $content,
            thumbnail: $thumbnail,
            authorId: $authorId
        );
    }

    public function createFromArray(array $data): PostData
    {
        return new PostData(
            title: $data['title'] ?? '',
            content: $data['content'] ?? '',
            thumbnail: $data['thumbnail'] ?? '',
            authorId: $data['authorId'] ?? 0,
        );
    }
}
