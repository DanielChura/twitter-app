<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Database\Database;
use App\Models\Post;
use App\Models\User;

class UserController
{
    private Database $db;

    public function __construct()
    {
        require __DIR__ . "/../../config/config.php";
        $this->db = new Database($config);
    }

    public function index(): void
    {
        $users = User::getAll($this->db);
        require __DIR__ . "/../Views/Users/index.php";
    }

    public function getProfile(string $id): void
    {
        $user_id = (int)$id;
        $follower = $_SESSION["user_id"] ?? null;

        $user = User::getById($this->db, $user_id);
        $posts = Post::getPostsByUserId($this->db, $user_id);
        $is_followed = $follower ? User::isFollowing($this->db, $follower, $user_id) : false;
        $isMe = $follower === $user_id;

        $currentUser = $follower ? User::getById($this->db, (int)$follower) : null;
        $followedUsers = $follower
            ? User::getFollowedUsers($this->db, (int)$follower)
            : [];

        require __DIR__ . "/../Views/components/Users/user-profile.php";
    }

    public function follow(string $user_id): void
    {
        $follower = $_SESSION["user_id"] ?? null;
        if (!$follower || (int)$follower === (int)$user_id) {
            $this->redirect("/twitter-app/src/public/users/$user_id");
        }

        if (User::isFollowing($this->db, (int)$follower, (int)$user_id)) {
            User::unfollow($this->db, (int)$follower, (int)$user_id);
        } else {
            User::follow($this->db, (int)$follower, (int)$user_id);
        }

        $this->redirect("/twitter-app/src/public/users/$user_id");
    }

    public function likePost(string $post_id): void
    {
        $user_id = $_SESSION["user_id"] ?? null;
        if (!$user_id) {
            $this->redirect("/twitter-app/src/public/login");
        }

        Post::like($this->db, (int)$user_id, (int)$post_id);
        $this->redirect("/twitter-app/src/public/home");
    }

    private function redirect(string $url): void
    {
        header("Location: $url");
        exit();
    }
}
