<?php

declare(strict_types=1);

namespace App\Models;

use App\Database\Database;

class Post
{
    public static function getAllPosts(Database $db): array
    {
        $sql = "SELECT 
            p.id as post_id,
            u.id as user_id, 
            u.username, 
            u.avatar_url, 
            u.email, 
            p.content, 
            p.image_url, 
            COUNT(pl.post_id) AS total_likes
        FROM posts p
        INNER JOIN users u ON p.user_id = u.id
        LEFT JOIN post_likes pl ON p.id = pl.post_id
        GROUP BY p.id";
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
}
