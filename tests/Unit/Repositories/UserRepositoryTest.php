<?php

declare(strict_types=1);

namespace App\Tests\Unit\Repositories;

use App\Entities\User;
use App\Entities\UserInterface;
use App\Repositories\UserRepository;
use PDO;
use PDOStatement;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class UserRepositoryTest extends TestCase
{
    private PDO|MockObject $db;

    private PDOStatement|MockObject $stmt;

    /**
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    protected function setUp(): void
    {
        $this->db = $this->createMock(PDO::class);
        $this->stmt = $this->createMock(PDOStatement::class);
    }

    /**
     * @throws \Exception
     */
    public function testFind(): void
    {
        $user = $this->createUser();
        $expected = [
            'id' => 1,
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
            'created_at' => (new \DateTimeImmutable('2024-01-01 00:00:00'))->format('Y-m-d H:i:s')
        ];
        $this->stmt->expects($this->once())->method('execute')->willReturn(true);
        $this->stmt->expects($this->once())->method('fetch')->willReturn($expected);
        $this->db->expects($this->once())->method('prepare')->willReturn($this->stmt);
        $repository = new UserRepository($this->db);
        $this->assertEquals($user, $repository->find(1));
    }

    /**
     * @throws \Exception
     */
    public function testFindFoundNoRecord(): void
    {
        $this->stmt->expects($this->once())->method('execute')->willReturn(true);
        $this->stmt->expects($this->once())->method('fetch')->willReturn(false);
        $this->db->expects($this->once())->method('prepare')->willReturn($this->stmt);
        $repository = new UserRepository($this->db);
        $this->assertNull($repository->find(1));
    }

    /**
     * @throws \Exception
     */
    public function testUpdate(): void
    {
        $user = $this->createUser();
        $this->stmt->expects($this->once())->method('execute')->willReturn(true);
        $this->db->expects($this->once())->method('prepare')->willReturn($this->stmt);
        $repository = new UserRepository($this->db);
        $this->assertEquals($user, $repository->save($user));
    }

    /**
     * @throws \Exception
     */
    public function testSave(): void
    {
        $user = $this->createUser();
        $user->setId(0);
        $this->stmt->expects($this->once())->method('execute')->willReturn(true);
        $this->db->expects($this->once())->method('prepare')->willReturn($this->stmt);
        $repository = new UserRepository($this->db);
        $this->assertEquals($user, $repository->save($user));
    }


    private function createUser(): UserInterface
    {
        $user = new User();
        $user->setId(1);
        $user->setUsername('Username');
        $user->setEmail('Email');
        $user->setPassword('Password');
        $user->setCreatedAt(new \DateTimeImmutable('2024-01-01 00:00:00'));
        return $user;
    }
}
