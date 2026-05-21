<?php
require __DIR__ . "/../../vendor/autoload.php";
require __DIR__ . "/../../config/config.php";

session_start();

use App\Controllers\PostController;
use App\Controllers\UserController;
use App\Database\Database;
use App\Router\Router;

$pdo = new Database($config);
$router = new Router();

$router->get("$BASE_URL/", function () {
     echo "Hola Bienvenido";
});

if (isset($_SESSION["user_id"])) {
     echo $_SESSION["user_id"];
} else {
     echo "No hay sesión iniciada";
}

//USER
$router->get("$BASE_URL/users", [UserController::class, "index"]);
$router->get("$BASE_URL/register", [UserController::class, "register"]);
$router->post("$BASE_URL/register", [UserController::class, "storedRegister"]);
$router->get("$BASE_URL/login", [UserController::class, "login"]);
$router->post("$BASE_URL/login", [UserController::class, "storedLogin"]);

//POSTS
$router->get("$BASE_URL/home", [PostController::class, "index"]);
$router->get("$BASE_URL/createPost", [PostController::class, "createPost"]);
$router->post("$BASE_URL/storedPost", [PostController::class, "storedPost"]);

$router->dispatch();
