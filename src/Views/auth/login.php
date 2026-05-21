<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Twitter App</title>
    <link rel="stylesheet" href="/twitter-app/src/public/css/auth.css">
</head>
<body>
    <section class="auth-container">
        <form action="/twitter-app/src/public/login" method="post" class="auth-form">
            <h1 class="auth-title">Iniciar Sesión</h1>
            <div class="auth-form-group">
                <label for="email" class="auth-label">Email</label>
                <input type="email" class="auth-input" required name="email" id="email">
            </div>
            <div class="auth-form-group">
                <label for="password" class="auth-label">Password</label>
                <input type="password" class="auth-input" required name="password" id="password">
            </div>
            <button type="submit" class="auth-btn">Iniciar Sesión</button>
            <p class="auth-link">¿No tienes cuenta? <a href="/twitter-app/src/public/register">Regístrate</a></p>
        </form>
    </section>
</body>
</html>