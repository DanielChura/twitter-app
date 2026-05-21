<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Database\Database;
use App\Models\Post;
use App\Models\User;

class PostController
{
    private Database $db;

    public function __construct()
    {
        require __DIR__ . "/../../config/config.php";
        $this->db = new Database($config);
    }

    public function index(): void
    {
        $posts = Post::getAllPosts($this->db);

        $userId = $_SESSION["user_id"] ?? null;
        $currentUser = $userId ? User::getById($this->db, (int)$userId) : null;
        $followedUsers = $userId
            ? User::getFollowedUsers($this->db, (int)$userId)
            : [];

        require __DIR__ . "/../Views/components/posts/index.php";
    }

    public function storedPost(): void
    {
        try {
            $user_id = $_SESSION["user_id"] ?? null;
            if (!$user_id) {
                $this->redirect("/twitter-app/src/public/login");
            }

            $this->validatePostData($_POST);

            $post = [
                "content" => $_POST["content"],
                "image_url" => $_POST["image_url"] ?? null,
                "user_id" => $user_id
            ];

            Post::createPost($this->db, $post);
            $this->redirect("/twitter-app/src/public/home");
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    private function validatePostData(array $data): void
    {
        if (empty($data["content"])) {
            throw new \Exception("El contenido del post es obligatorio.");
        }
    }

    private function redirect(string $url): void
    {
        header("Location: $url");
        exit();
    }
}
