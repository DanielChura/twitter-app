<?php

declare(strict_types=1);

namespace App\Models;

use App\Database\Database;

class Post
{
    public static function getAllPosts(Database $db): array
    {
        $sql = "SELECT 
    p.id AS post_id,
    u.id AS user_id, 
    u.username, 
    u.avatar_url, 
    u.email, 
    p.content, 
    p.image_url,
    (SELECT COUNT(*) FROM post_likes WHERE post_id = p.id) AS total_likes,
    (SELECT COUNT(*) FROM comments WHERE post_id = p.id) AS total_comments
FROM posts p
INNER JOIN users u ON p.user_id = u.id
GROUP BY p.id, u.id, u.username, u.avatar_url, u.email, p.content, p.image_url";
        $stmt = $db->query($sql);
        return $stmt->fetchAll();
    }

    public static function getPostsByUserId(Database $db, int $id): array
    {
        $sql = "SELECT 
    posts.id as post_id,
    users.id as user_id,
    posts.content,
    posts.created_at,
    posts.image_url,
    users.username,
    users.avatar_url,
    users.email
FROM posts
INNER JOIN users ON posts.user_id = users.id
WHERE posts.user_id = :id
ORDER BY posts.created_at DESC;";
        $stmt = $db->query($sql, ["id" => $id]);
        return $stmt->fetchAll();
    }

    public static function createPost(Database $db, array $data): bool
    {
        extract($data);
        $sql = "INSERT INTO posts (user_id, content, image_url) VALUES (:user_id, :content, :image_url)";
        return (bool) $db->query($sql, ["user_id" => $user_id, "content" => $content, "image_url" => $image_url]);
    }

    public static function like(Database $db, int $user_id, int $post_id): bool
    {
        $isLiked = $db->query(
            "SELECT * FROM post_likes WHERE user_id = :user_id AND post_id = :post_id",
            ["user_id" => $user_id, "post_id" => $post_id]
        )->rowCount() > 0;

        if ($isLiked) {
            $sql = "DELETE FROM post_likes WHERE user_id = :user_id AND post_id = :post_id";
            return (bool) $db->query($sql, ["user_id" => $user_id, "post_id" => $post_id]);
        }

        $sql = "INSERT INTO post_likes (user_id, post_id) VALUES (:user_id, :post_id)";
        return (bool) $db->query($sql, ["user_id" => $user_id, "post_id" => $post_id]);
    }

    public static function getPostById(Database $db, int $post_id)
    {
        $sql = "SELECT 
    p.id AS post_id,
    p.content,
    p.image_url,
    p.created_at,
    u.id AS user_id,
    u.username,
    u.email,
    u.avatar_url,
    (SELECT COUNT(*) FROM post_likes WHERE post_id = p.id) AS total_likes,
    (SELECT COUNT(*) FROM comments WHERE post_id = p.id) AS total_comments
FROM posts p
INNER JOIN users u ON p.user_id = u.id
WHERE p.id = :post_id;";

        $stmt = $db->query($sql, ["post_id" => $post_id]);
        return $stmt->fetch();
    }

    public static function getCommentsByPostId(Database $db, int $post_id)
    {
        $sql = "SELECT u.id AS user_id, u.username, u.email, u.avatar_url, c.id AS comment_id, c.content, c.created_at FROM comments c INNER JOIN users u ON c.user_id = u.id WHERE c.post_id = :post_id";
        $stmt = $db->query($sql, [":post_id" => $post_id]);
        return $stmt->fetchAll();
    }

    public static function commentPost(Database $db, int $post_id, int $user_id, string $content): bool
    {
        $sql = "INSERT INTO comments (post_id, user_id, content) VALUES (:post_id, :user_id, :content)";
        $stmt = $db->query($sql, ["post_id" => $post_id, "user_id" => $user_id, "content" => $content]);
        return $stmt->rowCount() > 0;
    }
}
