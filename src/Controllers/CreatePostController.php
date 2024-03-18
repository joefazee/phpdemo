<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Http\Response;
use App\Factories\PostDataFactory;
use App\Services\PostServiceInterface;

class CreatePostController
{
    public function __construct(
        private PostDataFactory $postDataFactory,
        private Response $response,
        private PostServiceInterface $postService,
    ) {
    }


    public function index(): string
    {
        return $this->response->render('new-entry.php');
    }

    public function store(): string
    {
        try {
            $postData = $this->postDataFactory->create(
                $_POST['title'],
                $_POST['content'],
                $_POST['thumbnail'],
                1,
            );

            $this->postService->createPost($postData);

            $this->response->redirect('/');
        } catch (\Exception $e) {
            return $this->response->render('new-entry.php', [
               'error' => $e->getMessage(),
            ]);
        }

        return '';
    }
}
