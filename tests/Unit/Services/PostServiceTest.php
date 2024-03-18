<?php

namespace App\Tests\Unit\Services;

use App\Core\Http\Response;
use App\DTO\PostData;
use App\Entities\User;
use App\Entities\UserInterface;
use App\Repositories\PostRepositoryInterface;
use App\Security\AuthInterface;
use App\Services\PostService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use App\Entities\PostInterface;
use App\Exceptions\NotFoundException;
use App\Repositories\UserRepositoryInterface;

class PostServiceTest extends TestCase
{
    private PostRepositoryInterface|MockObject $postRepository;
    private UserRepositoryInterface|MockObject $userRepository;

    /**
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    protected function setUp(): void
    {
        $this->postRepository = $this->createMock(PostRepositoryInterface::class);
        $this->userRepository = $this->createMock(UserRepositoryInterface::class);
    }

    public function testCreatePostThrowsNotFoundExceptionIfAuthorIsNotFound(): void
    {
        $postData = new PostData('title', 'content', 'thumbnail', 1);

        $this->userRepository->expects($this->once())->method('find')->willReturn(null);

        $postService = new PostService($this->postRepository, $this->userRepository);

        $this->expectException(NotFoundException::class);
        $postService->createPost($postData);
    }

    /**
     * @throws \App\Exceptions\NotFoundException
     */
    public function testCreatePostThrowsInvalidArgumentExceptionWithTitleIsTooShort(): void
    {
        $postData = new PostData('a', 'content', 'thumbnail', 1);
        $author = $this->makeUser();

        $this->userRepository->expects($this->once())->method('find')->willReturn($author);

        $postService = new PostService($this->postRepository, $this->userRepository);

        $this->expectException(\InvalidArgumentException::class);
        $postService->createPost($postData);
    }

    /**
     * @throws \App\Exceptions\NotFoundException
     */
    public function testCreatePostThrowsInvalidArgumentExceptionWithContentIsTooShort(): void
    {
        $postData = new PostData('long title and more', 'c', 'thumbnail', 1);
        $author = $this->makeUser();

        $this->userRepository->expects($this->once())->method('find')->willReturn($author);

        $postService = new PostService($this->postRepository, $this->userRepository);

        $this->expectException(\InvalidArgumentException::class);
        $postService->createPost($postData);
    }

    public function testCreatePostIsSuccessful(): void
    {
        $postData = new PostData('long title and more', 'long content and more', 'thumbnail', 1);
        $author = $this->makeUser();
        $post = $postData->toEntity();

        $this->userRepository->expects($this->once())->method('find')->willReturn($author);
        $this->postRepository->expects($this->once())->method('save')->willReturn($post);

        $postService = new PostService($this->postRepository, $this->userRepository);

        $this->assertEquals($post, $postService->createPost($postData));
    }



    private function makeUser(): UserInterface
    {
        $user = new User();
        $user->setId(1);
        $user->setUsername('Username');
        $user->setEmail('Email');
        $user->setPassword('Password');
        $user->setCreatedAt(new \DateTimeImmutable('2024-01-01 00:00:00'));
        return $user;
    }
}
