<?php

namespace App\Entities;

class Comment implements CommentInterface
{
    private int $id = 0;

    private string $content = '';

    private ?UserInterface $author = null;

    private ?PostInterface $post = null;

    private ?\DateTimeInterface $createdAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getAuthor(): UserInterface
    {
        return $this->author;
    }

    public function setAuthor(UserInterface $author): void
    {
        $this->author = $author;
    }

    public function getPost(): PostInterface
    {
        return $this->post;
    }

    public function setPost(PostInterface $post): void
    {
        $this->post = $post;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'content' => $this->content,
            'author' => $this->author->toArray(),
            'post' => $this->post->toArray(),
            'createdAt' => $this->createdAt?->format('Y-m-d H:i:s'),
        ];
    }
}
