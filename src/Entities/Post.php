<?php

declare(strict_types=1);

namespace App\Entities;

class Post implements PostInterface
{
    private int $id = 0;

    private string $title = '';

    private string $content = '';

    private ?UserInterface $author = null;

    private string $thumbnail = '';

    private ?\DateTimeInterface $createdAt = null;

    private int $commentCount = 0;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }


    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getAuthor(): ?UserInterface
    {
        return $this->author;
    }

    public function setAuthor(?UserInterface $author): void
    {
        $this->author = $author;
    }

    public function getThumbnail(): string
    {
        return $this->thumbnail;
    }

    public function setThumbnail(string $thumbnail): void
    {
        $this->thumbnail = $thumbnail;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getCommentCount(): int
    {
        return $this->commentCount;
    }

    public function setCommentCount(int $commentCount): void
    {
        $this->commentCount = $commentCount;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'author' => $this->author->toArray(),
            'thumbnail' => $this->thumbnail,
            'createdAt' => $this->createdAt?->format('Y-m-d H:i:s'),
        ];
    }
}
