<?php

namespace App\Entities;

interface UserInterface extends
    IntAwareIdInterface,
    ArrayableInterface,
    CreationDateAwareInterface
{
    public function getUsername(): string;
    public function setUsername(string $username): void;

    public function getEmail(): string;
    public function setEmail(string $email): void;

    public function getPassword(): string;

    public function setPassword(string $password): void;
}
