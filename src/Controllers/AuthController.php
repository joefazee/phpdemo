<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Http\Response;
use App\Security\AuthInterface;

class AuthController
{
    public function __construct(
        private readonly Response $response,
        private readonly AuthInterface $auth,
    ) {
    }

    public function login(): string
    {
        $this->auth->login('not-used', 'not-used');
         $this->response->redirect('/');
         return '';
    }
}
