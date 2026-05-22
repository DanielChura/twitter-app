<?php
require __DIR__ . "/../../vendor/autoload.php";
require __DIR__ . "/../../config/config.php";

set_exception_handler(function (Throwable $e) {
     http_response_code(500);
     error_log($e->getMessage());
     require __DIR__ . "/../Views/components/error/500.php";
});

session_start();

if (empty($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}

use App\Controllers\AuthController;
use App\Controllers\PostController;
use App\Controllers\UserController;
use App\Database\Database;
use App\Router\Router;

$pdo = new Database($config);
$router = new Router();

// AUTH
$router->get(url("/register"), [new AuthController($pdo), "register"]);
$router->post(url("/register"), [new AuthController($pdo), "storedRegister"]);
$router->get(url("/login"), [new AuthController($pdo), "login"]);
$router->post(url("/login"), [new AuthController($pdo), "storedLogin"]);

// USERS
$router->get(url("/users/{id}"), [new UserController($pdo), "getProfile"]);
$router->post(url("/follow/{user_id}"), [new UserController($pdo), "follow"]);
$router->post(url("/unfollow/{id}"), [new UserController($pdo), "unfollow"]);

// POSTS
$router->get(url("/home"), [new PostController($pdo), "index"]);
$router->post(url("/storedPost"), [new PostController($pdo), "storedPost"]);
$router->post(url("/likePost/{post_id}"), [new UserController($pdo), "likePost"]);
$router->get(url("/post/{post_id}"), [new PostController($pdo), "postById"]);

//COMMENTS
$router->post(url("/comment/{post_id}"), [new PostController($pdo), "comment"]);

// AUTH LOGOUT
$router->get(url("/logout"), [new AuthController($pdo), "logOut"]);

// HOME
$router->get(url("/"), function () {
     echo "Hola Bienvenido";
});

$router->dispatch();
