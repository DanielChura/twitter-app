<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Database\Database;
use App\Models\User;

class UserController
{
    private Database $db;
    public function __construct()
    {
        require __DIR__ . "/../../config/config.php";
        $this->db = new Database($config);
    }

    public function index()
    {
        $users = User::getAll($this->db);
        require __DIR__ . "/../Views/Users/index.php";
    }

    public function register()
    {
        require __DIR__ . "/../Views/auth/register.php";
    }
    public function storedRegister()
    {
        try {
            $data = [
                "username" => $_POST["username"],
                "email" => $_POST["email"],
                "password" => $_POST["password"],
                "bio" => $_POST["bio"] ?? null,
                "avatar_url" => $_POST["avatar_url"] ?? null,
            ];
            if (empty($data["username"]) || empty($data["email"]) || empty($data["password"])) {
                throw new \Exception("Todos los campos son obligatorios.");
            }
            User::registerUser($this->db, $data);
            header("Location: /twitter-app/src/public/");
            exit();
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function login()
    {
        require __DIR__ . "/../Views/auth/login.php";
    }

    public function storedLogin()
    {
        try {
            $email = $_POST["email"];
            $password = $_POST["password"];

            if (empty($email) || empty($password)) {
                throw new \Exception("Todos los campos son obligatorios.");
            }

            $user = User::getByEmail($this->db, $email);
            if ($user && password_verify($password, $user["password"])) {
                session_start();
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["username"] = $user["username"];
                header("Location: /twitter-app/src/public/");
                exit();
            }
            echo "Usuario o contraseña incorrecta";
            exit();
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
