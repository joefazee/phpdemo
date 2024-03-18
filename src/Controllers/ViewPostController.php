<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Http\Response;
use App\Services\PostServiceInterface;

class ViewPostController
{
    public function __construct(
        private PostServiceInterface $postService,
        private Response $response,
    ) {
    }

    public function index(): string
    {
        $id = $_GET['id'] ?? null;
        try {
            $post = $this->postService->getPost((int) $id);
        } catch (\Exception $e) {
            return $this->response->render('index.php', ['error' => $e->getMessage()]);
        }

        return $this->response->render('post.php', ['post' => $post]);
    }
}
