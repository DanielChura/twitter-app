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

    public static function getByEmail(Database $db, string $email ){
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $db->query($sql, ["email" => $email]);
        return $stmt->fetch();
    }
}
