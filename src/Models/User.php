<?php

declare(strict_types=1);

namespace App\Models;

use App\Database\Database;

class User
{
    public static function getAll(Database $db): array
    {
        $sql = "SELECT * FROM users";
        $stmt = $db->query($sql);
        return $stmt->fetchAll();
    }

    public static function registerUser(Database $db, array $user): bool
    {
        extract($user);
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO users (username, email, password, bio, avatar_url) VALUES (:username, :email, :password, :bio, :avatar_url)";
        return (bool) $db->query($sql, [
            "username" => $username,
            "email" => $email,
            "password" => $hashedPassword,
            "bio" => $bio,
            "avatar_url" => $avatar_url
        ]);
    }

    public static function getByEmail(Database $db, string $email): ?array
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $db->query($sql, ["email" => $email]);
        return $stmt->fetch() ?: null;
    }

    public static function getById(Database $db, int $id): ?array
    {
        $sql = "SELECT u.id, u.username, u.bio, u.avatar_url, u.email, COUNT(f.followed_id) AS total_followers, u.created_at 
                FROM users u 
                LEFT JOIN followers f ON u.id = f.followed_id 
                WHERE u.id = :id 
                GROUP BY u.id";
        $stmt = $db->query($sql, ["id" => $id]);
        return $stmt->fetch() ?: null;
    }

    public static function follow(Database $db, int $follower_id, int $followed_id): bool
    {
        if ($follower_id === $followed_id) {
            return false;
        }
        $sql = "INSERT INTO followers (follower_id, followed_id) VALUES (:follower_id, :followed_id)";
        return (bool) $db->query($sql, ["follower_id" => $follower_id, "followed_id" => $followed_id]);
    }

    public static function unfollow(Database $db, int $follower_id, int $followed_id): bool
    {
        $sql = "DELETE FROM followers WHERE follower_id = :follower_id AND followed_id = :followed_id";
        return (bool) $db->query($sql, ["follower_id" => $follower_id, "followed_id" => $followed_id]);
    }

    public static function getFollowedUsers(Database $db, int $follower_id): array
    {
        $sql = "SELECT u.id, u.username, u.email, u.avatar_url 
                FROM followers f 
                INNER JOIN users u ON f.followed_id = u.id 
                WHERE f.follower_id = :follower_id";
        $stmt = $db->query($sql, ["follower_id" => $follower_id]);
        return $stmt->fetchAll();
    }

    public static function isFollowing(Database $db, int $follower_id, int $followed_id): bool
    {
        $sql = "SELECT * FROM followers WHERE follower_id = :follower_id AND followed_id = :followed_id";
        $stmt = $db->query($sql, ["follower_id" => $follower_id, "followed_id" => $followed_id]);
        return $stmt->rowCount() > 0;
    }
}
