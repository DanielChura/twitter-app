<?php

declare(strict_types=1);

namespace App\Models;

use App\Database\Database;

class Post
{
    public static function getAllPosts(Database $db)
    {
        $sql = "SELECT username, avatar_url, email, content, image_url FROM posts p INNER JOIN users u ON p.user_id = u.id";
        $stmt = $db->query($sql);
        return $stmt->fetchAll();
    }

    public static function createPost(Database $db, array $data): bool

    {
        extract($data);
        $sql = "INSERT INTO posts (user_id,content,image_url) VALUES (:user_id,:content,:image_url)";

        return (bool) $db->query($sql, ["user_id" => $user_id, "content" => $content, "image_url" => $image_url]);
    }
}
