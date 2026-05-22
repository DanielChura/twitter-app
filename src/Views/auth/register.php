<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse - Twitter App</title>
    <link rel="stylesheet" href="<?= url('/css/auth.css') ?>">
</head>

<body>
    <section class="auth-container">
        <form action="<?= url('/register') ?>" method="post" class="auth-form">
            <input name="csrf_token" type="hidden" value="<?= $_SESSION["csrf_token"] ?>">
            <h1 class="auth-title">Crear Cuenta</h1>
            <input name="csrf_token" type="hidden" value="<?=$_SESSION["csrf_token"]?>">
            <div class="auth-form-group">
                <label for="username" class="auth-label">Username</label>
                <input type="text" class="auth-input" required name="username" id="username">
            </div>
            <div class="auth-form-group">
                <label for="email" class="auth-label">Email</label>
                <input type="email" class="auth-input" required name="email" id="email">
            </div>
            <div class="auth-form-group">
                <label for="password" class="auth-label">Password</label>
                <input type="password" class="auth-input" required name="password" id="password">
            </div>
            <div class="auth-form-group">
                <label for="bio" class="auth-label">Bio (opcional)</label>
                <input type="text" class="auth-input" name="bio" id="bio">
            </div>
            <div class="auth-form-group">
                <label for="avatar_url" class="auth-label">Avatar URL (opcional)</label>
                <input type="text" class="auth-input" name="avatar_url" id="avatar_url">
            </div>
            <button type="submit" class="auth-btn">Registrarse</button>
            <p class="auth-link">¿Ya tienes cuenta? <a href="<?= url('/login') ?>">Inicia sesión</a></p>
        </form>
    </section>
</body>

</html>