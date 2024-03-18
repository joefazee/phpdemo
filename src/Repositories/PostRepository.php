<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Post;
use App\Entities\PostInterface;
use App\Entities\User;
use App\Entities\UserInterface;
use PDO;

class PostRepository implements PostRepositoryInterface
{
    protected PDO $db;

    private int $totalRecords;

    public function __construct(PDO $db)
    {
        $this->db = $db;
        $this->totalRecords = 0;
    }

    public function find(int $id): ?PostInterface
    {
        $q = 'SELECT p.id, p.title, p.content, p.thumbnail, p.created_at, 
       COUNT(c.id) AS comment_count, u.id AS author_id, u.username AS author_username, u.email AS author_email
    FROM posts p
    LEFT JOIN comments c ON p.id = c.post_id
    INNER JOIN users u ON p.user_id = u.id
    WHERE p.id = :id
    GROUP BY p.id';
        $stmt = $this->db->prepare($q);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        if (!$row) {
            return null;
        }

        $this->setTotalRecords(1);
        return $this->createPost($row);
    }

    public function all(int $offset, int $limit): array
    {
        $q = 'SELECT p.id, p.title, p.content, p.thumbnail, p.created_at, 
                COUNT(c.id) AS comment_count, u.id AS author_id, u.username AS author_username, 
                u.email AS author_email,COUNT(*) OVER() AS total_records
            FROM posts p
            LEFT JOIN comments c ON p.id = c.post_id
            INNER JOIN users u ON p.user_id = u.id
            GROUP BY p.id
            ORDER BY p.created_at DESC
            LIMIT :offset, :limit';
        $stmt = $this->db->prepare($q);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        $posts = [];

        while ($row = $stmt->fetch()) {
            $this->setTotalRecords((int) $row['total_records']);
            $posts[] = $this->createPost($row);
        }

        return $posts;
    }

    public function save(PostInterface $post): PostInterface
    {
        $q = 'INSERT INTO posts (title, content, thumbnail, user_id, created_at) VALUES (:title, :content, :thumbnail, :user_id, :created_at)';
        $stmt = $this->db->prepare($q);
        $stmt->execute([
            'title' => $post->getTitle(),
            'content' => $post->getContent(),
            'thumbnail' => $post->getThumbnail(),
            'user_id' => $post->getAuthor()?->getId(),
            'created_at' => $post->getCreatedAt(),
        ]);
        $post->setId((int) $this->db->lastInsertId());
        return $post;
    }

    /**
     * @throws \Exception
     */
    private function createPost(array $row): PostInterface
    {
        $post = new Post();
        $post->setId((int) $row['id']);
        $post->setTitle($row['title']);
        $post->setContent($row['content']);
        $post->setThumbnail($row['thumbnail']);
        $post->setCommentCount((int) $row['comment_count']);
        $post->setCreatedAt(new \DateTimeImmutable($row['created_at'] ?: 'now'));
        $post->setAuthor($this->createUser($row));
        return $post;
    }

    private function createUser(array $row): UserInterface
    {
        $user =  new User();
        $user->setId((int) $row['author_id']);
        $user->setUsername($row['author_username']);
        $user->setEmail($row['author_email']);
        return $user;
    }

    public function setTotalRecords(int $n): void
    {
        $this->totalRecords = $n;
    }

    public function getTotalRecords(): int
    {
        return $this->totalRecords;
    }
}
