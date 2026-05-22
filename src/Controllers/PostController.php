<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Database\Database;
use App\Models\Post;
use App\Models\User;
use Exception;

class PostController
{
    public function __construct(private Database $db) {}

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
                $this->redirect(url('/login'));
            }

            $this->validatePostData($_POST);

            $post = [
                "content" => $_POST["content"],
                "image_url" => $_POST["image_url"] ?? null,
                "user_id" => $user_id
            ];

            verifyCSRF();

            Post::createPost($this->db, $post);
            $this->redirect(url('/home'));
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    private function validatePostData(array $data): void
    {
        if (empty($data["content"])) {
            throw new Exception("El contenido del post es obligatorio.");
        }
    }

    private function redirect(string $url): void
    {
        header("Location: $url");
        exit();
    }

    public function postById(string $post_id): void
    {
        $userId = $_SESSION["user_id"] ?? null;
        $post = Post::getPostById($this->db, (int)$post_id);

        if (!$post) {
            http_response_code(404);
            echo "Post no encontrado";
            return;
        }

        $currentUser = $userId ? User::getById($this->db, (int)$userId) : null;
        $followedUsers = $userId
            ? User::getFollowedUsers($this->db, (int)$userId)
            : [];

        ob_start();
        require __DIR__ . "/../Views/components/post-card.php";
        $comments = Post::getCommentsByPostId($this->db, (int)$post_id);
        require __DIR__ . "/../Views/components/comments/comment.php";
        $content = ob_get_clean();

        $userName = $currentUser["username"] ?? null;
        $userHandle = $currentUser["username"] ?? null;
        $userAvatar = $currentUser["avatar_url"] ?? null;
        $activeNav = "";
        $pageTitle = "Post";
        require __DIR__ . "/../Views/components/app-layout.php";
    }

    public function comment(string $post_id): void
    {
        $user_id = $_SESSION["user_id"] ?? null;
        $content = $_POST["content"] ?? null;

        try {
            verifyCSRF();
            verifyCSRF();
            Post::commentPost($this->db, (int)$post_id, (int)$user_id, $content);
            $this->redirect(url("/post/$post_id"));
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
