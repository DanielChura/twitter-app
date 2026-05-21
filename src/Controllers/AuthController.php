<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Database\Database;
use App\Models\User;

class AuthController
{
    private Database $db;

    public function __construct()
    {
        require __DIR__ . "/../../config/config.php";
        $this->db = new Database($config);
    }

    public function register(): void
    {
        require __DIR__ . "/../Views/auth/register.php";
    }

    public function storedRegister(): void
    {
        try {
            $this->validateRegisterData($_POST);
            
            $data = [
                "username" => $_POST["username"],
                "email" => $_POST["email"],
                "password" => $_POST["password"],
                "bio" => $_POST["bio"] ?? null,
                "avatar_url" => $_POST["avatar_url"] ?? null,
            ];

            User::registerUser($this->db, $data);
            $this->redirect("/twitter-app/src/public/");
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function login(): void
    {
        require __DIR__ . "/../Views/auth/login.php";
    }

    public function storedLogin(): void
    {
        try {
            $email = $_POST["email"] ?? null;
            $password = $_POST["password"] ?? null;

            if (!$email || !$password) {
                throw new \Exception("Todos los campos son obligatorios.");
            }

            $user = User::getByEmail($this->db, $email);
            if ($user && password_verify($password, $user["password"])) {
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["username"] = $user["username"];
                $this->redirect("/twitter-app/src/public/home");
            }

            throw new \Exception("Usuario o contraseña incorrecta.");
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    private function validateRegisterData(array $data): void
    {
        if (empty($data["username"]) || empty($data["email"]) || empty($data["password"])) {
            throw new \Exception("Todos los campos son obligatorios.");
        }
    }

    public function logOut(): void
    {
        $_SESSION = [];
        session_destroy();
        $this->redirect("/twitter-app/src/public/home");
    }

    private function redirect(string $url): void
    {
        header("Location: $url");
        exit();
    }
}
