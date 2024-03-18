<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Http\Response;
use App\Repositories\PostRepositoryInterface;

class HomeController
{
    public function __construct(
        protected PostRepositoryInterface $postRepository,
        protected Response $response,
    ) {
    }

    public function index(): string
    {
        $page = $_GET['page'] ?? 1;
        $perPage = 3;
        $offset = ($page - 1) * $perPage;

        return $this->response->render('index.php', [
            'posts' => $this->postRepository->all($offset, $perPage),
            'page' => $page,
            'total' => $this->postRepository->getTotalRecords(),
            'totalPages' => ceil($this->postRepository->getTotalRecords() / $perPage),
        ]);
    }
}
