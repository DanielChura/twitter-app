<?php

declare(strict_types=1);

function url(string $path): string
{
    return "/twitter-app/src/public" . $path;
}

function verifyCSRF(): void
{
    if (empty($_SESSION["csrf_token"]) || $_SESSION["csrf_token"] !== $_POST["csrf_token"]) {
        throw new Exception("Token CSRF no valido");
    }
}
