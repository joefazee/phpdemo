<?php

declare(strict_types=1);

namespace App\Entities;

interface CommentInterface extends IntAwareIdInterface, CreationDateAwareInterface, ArrayableInterface
{
    public function getAuthor(): UserInterface;
    public function setAuthor(UserInterface $author): void;
    public function getContent(): string;
    public function setContent(string $content): void;

    public function getPost(): PostInterface;

    public function setPost(PostInterface $post): void;
}
