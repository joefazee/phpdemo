<?php

declare(strict_types=1);

namespace App\DTO;

use App\Entities\Post;
use App\Entities\PostInterface;
use App\Entities\User;

class PostData
{
    public function __construct(
        private string $title,
        private string $content,
        private string $thumbnail,
        private int $authorId
    ) {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getAuthorId(): int
    {
        return $this->authorId;
    }

    public function setThumbnail(string $thumbnail): void
    {
        $this->thumbnail = $thumbnail;
    }

    public function getThumbnail(): string
    {
        return $this->thumbnail;
    }

    public function toEntity(): PostInterface
    {
        $post = new Post();
        $post->setTitle($this->title);
        $post->setContent($this->content);
        $author = new User();
        $author->setId($this->authorId);
        $post->setAuthor($author);
        $post->setThumbnail($this->thumbnail);
        return $post;
    }
}
