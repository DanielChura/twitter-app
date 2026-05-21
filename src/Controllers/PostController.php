<?php

namespace App\Controllers;

use App\Database\Database;
use App\Models\Post;

class PostController
{
    private Database $db;
    public function __construct()
    {
        require __DIR__ . "/../../config/config.php";
        $this->db = new Database($config);
    }

    public function index()
    {
        $posts = Post::getAllPosts($this->db);
        require __DIR__ . "/../Views/posts/index.php";
    }

    public function createPost()
    {
        require __DIR__ . "/../Views/posts/createPost.php";
    }
    public function storedPost()
    {
        session_start();
        $post = [
            "content" => $_POST["content"],
            "image_url" => $_POST["image_url"],
            "user_id" => $_SESSION["user_id"]
        ];
        try {
            Post::createPost($this->db, $post);
            header("Location: /twitter-app/src/public/home");
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
