<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Database\Database;
use App\Models\User;

class AuthController
{

    public function __construct(private Database $db) {}

    public function register(): void
    {
        require __DIR__ . "/../Views/auth/register.php";
    }

    public function storedRegister(): void
    {
        try {
            verifyCSRF();
            $this->validateRegisterData($_POST);

            $data = [
                "username" => $_POST["username"],
                "email" => $_POST["email"],
                "password" => $_POST["password"],
                "bio" => $_POST["bio"] ?? null,
                "avatar_url" => $_POST["avatar_url"] ?? null,
            ];
            User::registerUser($this->db, $data);
            $this->redirect(url('/'));
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
            $this->redirect(url('/home'));
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
        $this->redirect(url('/home'));
    }

    private function redirect(string $url): void
    {
        header("Location: $url");
        exit();
    }
}
