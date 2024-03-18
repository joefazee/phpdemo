<?php

declare(strict_types=1);

namespace App\Security;

interface AuthInterface
{
    public function login(string $email, string $password): bool;

    public function logout(): void;

    public function isLoggedIn(): bool;
}

// find the user -> IDResolver
// checking the identity, password, AD, IDChckerInterface (UserIngterface, $\)
// session-based (direct)
// jwt - jwt-token
