<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\PostData;
use App\Entities\PostInterface;
use App\Exceptions\NotFoundException;
use App\Repositories\PostRepositoryInterface;
use App\Repositories\UserRepositoryInterface;

readonly class PostService implements PostServiceInterface
{
    public function __construct(
        private PostRepositoryInterface $postRepository,
        private UserRepositoryInterface $userRepository,
    ) {
    }

    public function createPost(PostData $postData): PostInterface
    {
        $author = $this->userRepository->find($postData->getAuthorId());
        if ($author === null) {
            throw new NotFoundException('Author not found');
        }

        if (mb_strlen($postData->getTitle()) < 5) {
            throw new \InvalidArgumentException('Title too short');
        }

        if (mb_strlen($postData->getContent()) < 10) {
            throw new \InvalidArgumentException('Content too short');
        }


        $entity = $postData->toEntity();
        $entity->setAuthor($author);

        return $this->postRepository->save($entity);
    }

    public function getPost(int $id): PostInterface
    {
        $post = $this->postRepository->find($id);
        if ($post === null) {
            throw new NotFoundException('post with that id not found');
        }
        return $post;
    }
}
