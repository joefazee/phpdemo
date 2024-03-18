<?php

/**
 * TODO: This class does not do any authentication. It is just a placeholder.
 */

namespace App\Security;

class CookieAuth implements AuthInterface
{
    private const string COOKIE_NAME = 'basic_blog_auth';

    public function __construct()
    {
    }

    public function login(string $email, string $password): bool
    {
        setcookie(self::COOKIE_NAME, '1', time() + 3600, '/');
        return true;
    }

    public function logout(): void
    {
        setcookie(self::COOKIE_NAME, '', time() - 3600, '/');
    }

    public function isLoggedIn(): bool
    {
        return isset($_COOKIE[self::COOKIE_NAME]);
    }
}
