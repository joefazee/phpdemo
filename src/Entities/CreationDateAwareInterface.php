<?php

declare(strict_types=1);

namespace App\Entities;

interface CreationDateAwareInterface
{
    public function getCreatedAt(): ?\DateTimeInterface;
    public function setCreatedAt(?\DateTimeInterface $createdAt): void;
}
