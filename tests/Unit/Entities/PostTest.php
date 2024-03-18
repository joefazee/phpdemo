<?php

declare(strict_types=1);

namespace App\Tests\Unit\Entities;

use App\Entities\Post;
use App\Entities\User;
use PHPUnit\Framework\TestCase;

class PostTest extends TestCase
{
    public function testGetId(): void
    {
        $post = new Post();
        $post->setId(1);
        $this->assertSame(1, $post->getId());
    }

    public function testGetTitle(): void
    {
        $post = new Post();
        $post->setTitle('Hello World');
        $this->assertSame('Hello World', $post->getTitle());
    }

    public function testGetContent(): void
    {
        $post = new Post();
        $post->setContent('Hello World');
        $this->assertSame('Hello World', $post->getContent());
    }

    public function testGetAuthor(): void
    {
        $post = new Post();
        $user = new User();
        $post->setAuthor($user);
        $this->assertSame($user, $post->getAuthor());
    }

    public function testGetThumbnail(): void
    {
        $post = new Post();
        $post->setThumbnail('thumbnail.jpg');
        $this->assertSame('thumbnail.jpg', $post->getThumbnail());
    }

    public function testGetCreatedAt(): void
    {
        $post = new Post();
        $post->setCreatedAt(new \DateTime());
        $this->assertInstanceOf(\DateTime::class, $post->getCreatedAt());
    }

    public function testArrayable(): void
    {

        $fixedCreatedAt = new \DateTime('2020-01-01 00:00:00');
        $post = new Post();
        $post->setId(1);
        $post->setTitle('Hello World');
        $post->setContent('Hello World');
        $post->setCreatedAt($fixedCreatedAt);
        $user = new User();
        $post->setAuthor($user);
        $post->setThumbnail('thumbnail.jpg');
        $post->setCreatedAt($fixedCreatedAt);

        $expected = [
            'id' => 1,
            'title' => 'Hello World',
            'content' => 'Hello World',
            'author' => $user->toArray(),
            'thumbnail' => 'thumbnail.jpg',
            'createdAt' => $fixedCreatedAt->format('Y-m-d H:i:s'),
        ];

        $this->assertSame($expected, $post->toArray());
    }
}
