<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\User;
use App\Entities\UserInterface;
use PDO;

class UserRepository implements UserRepositoryInterface
{
    protected PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * @throws \Exception
     */
    public function find(int $id): ?UserInterface
    {
        $q = 'select id, username, email, password, created_at from users where id = :id';
        $stmt = $this->db->prepare($q);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        if (!$row) {
            return null;
        }
        return $this->createUser($row);
    }

    public function save(UserInterface $blog): UserInterface
    {
        if ($blog->getId() === 0) {
            return $this->insert($blog);
        }
        return $this->update($blog);
    }

    /**
     * @throws \Exception
     */
    protected function createUser(array $row): UserInterface
    {
        $user = new User();
        $user->setId((int) $row['id']);
        $user->setUsername($row['username']);
        $user->setEmail($row['email']);
        $user->setPassword($row['password']);
        $user->setCreatedAt(new \DateTimeImmutable($row['created_at']));
        return $user;
    }

    protected function insert(UserInterface $user): UserInterface
    {
        $q = 'insert into users (username, email, password, created_at) values 
                 (:username, :email, :password, :created_at)';
        $stmt = $this->db->prepare($q);
        $stmt->execute([
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'created_at' => $user->getCreatedAt()?->format('Y-m-d H:i:s'),
        ]);
        $user->setId((int) $this->db->lastInsertId());
        return $user;
    }

    protected function update(UserInterface $user): UserInterface
    {
        $q = 'update users set username = :username, 
                 email = :email, 
                 password = :password, 
                 created_at = :created_at where id = :id';
        $stmt = $this->db->prepare($q);
        $stmt->execute([
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'created_at' => $user->getCreatedAt()?->format('Y-m-d H:i:s'),
        ]);
        return $user;
    }
}
