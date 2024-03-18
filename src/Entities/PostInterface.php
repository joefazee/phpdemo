<?php

declare(strict_types=1);

namespace App\Entities;

interface PostInterface extends CreationDateAwareInterface, IntAwareIdInterface, ArrayableInterface
{
    public function getTitle(): string;
    public function setTitle(string $title): void;
    public function getContent(): string;
    public function setContent(string $content): void;
    public function getAuthor(): ?UserInterface;
    public function setAuthor(?UserInterface $author): void;
    public function getThumbnail(): string;
    public function setThumbnail(string $thumbnail): void;
    public function setCommentCount(int $commentCount): void;

    public function getCommentCount(): int;
}
