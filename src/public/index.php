<?php
require __DIR__ . "/../../vendor/autoload.php";
require __DIR__ . "/../../config/config.php";

session_start();

use App\Controllers\AuthController;
use App\Controllers\PostController;
use App\Controllers\UserController;
use App\Database\Database;
use App\Router\Router;

$pdo = new Database($config);
$router = new Router();

// AUTH
$router->get("$BASE_URL/register", [AuthController::class, "register"]);
$router->post("$BASE_URL/register", [AuthController::class, "storedRegister"]);
$router->get("$BASE_URL/login", [AuthController::class, "login"]);
$router->post("$BASE_URL/login", [AuthController::class, "storedLogin"]);

// USERS
$router->get("$BASE_URL/users", [UserController::class, "index"]);
$router->get("$BASE_URL/users/{id}", [UserController::class, "getProfile"]);
$router->post("$BASE_URL/follow/{user_id}", [UserController::class, "follow"]);
$router->post("$BASE_URL/unfollow/{id}", [UserController::class, "unfollow"]);

// POSTS
$router->get("$BASE_URL/home", [PostController::class, "index"]);
$router->post("$BASE_URL/storedPost", [PostController::class, "storedPost"]);
$router->post("$BASE_URL/likePost/{post_id}", [UserController::class, "likePost"]);

// AUTH LOGOUT
$router->get("$BASE_URL/logout", [AuthController::class, "logOut"]);

// HOME
$router->get("$BASE_URL/", function () {
    echo "Hola Bienvenido";
});

$router->dispatch();
