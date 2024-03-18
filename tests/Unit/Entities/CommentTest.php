<?php

declare(strict_types=1);

namespace App\Tests\Unit\Entities;

use App\Entities\Comment;
use App\Entities\CommentInterface;
use App\Entities\Post;
use App\Entities\PostInterface;
use App\Entities\User;
use App\Entities\UserInterface;
use PHPUnit\Framework\TestCase;

class CommentTest extends TestCase
{
    private CommentInterface $comment;

    private UserInterface $author;

    private PostInterface $post;

    protected function setUp(): void
    {
        $this->comment = new Comment();

        $this->author = new User();
        $this->author->setUsername('Author');
        $this->author->setId(1);

        $this->post = new Post();
        $this->post->setTitle('Title');
        $this->post->setId(1);

        $this->comment->setAuthor($this->author);
        $this->comment->setContent('Content');
        $this->comment->setId(1);
        $this->comment->setPost($this->post);
    }

    public function testGetId(): void
    {
        $this->assertSame(1, $this->comment->getId());
    }

    public function testGetAuthor(): void
    {
        $this->assertSame($this->author, $this->comment->getAuthor());
    }

    public function testSetAndGetCreatedAt(): void
    {
        $createdAt = new \DateTime();
        $this->comment->setCreatedAt($createdAt);
        $this->assertSame($createdAt, $this->comment->getCreatedAt());
    }

    public function testSetAndGetContent(): void
    {
        $this->comment->setContent('New Content');
        $this->assertSame('New Content', $this->comment->getContent());
    }


    public function testSetAndGetPost(): void
    {
        $this->assertSame($this->post, $this->comment->getPost());
    }
}
