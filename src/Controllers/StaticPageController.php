<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Http\Response;

class StaticPageController
{
    public function __construct(
        private readonly Response $response,
    ) {
    }

    public function privacy(): string
    {
        return $this->response->render('privacy.php');
    }
}
