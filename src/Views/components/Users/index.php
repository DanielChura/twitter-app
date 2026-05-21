<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios - Twitter App</title>
    <link rel="stylesheet" href="/twitter-app/src/public/css/app.css">
    <link rel="stylesheet" href="/twitter-app/src/public/css/layout.css">
</head>
<body>
    <div class="users-page">
        <h2 class="users-title">Usuarios</h2>
        <?php if (isset($users)): ?>
            <?php foreach ($users as $user) : ?>
                <div class="post-card">
                    <div class="post-card-header">
                        <img src="<?= htmlspecialchars($user['avatar_url'] ?? '') ?>" alt="Avatar de <?= htmlspecialchars($user['username']) ?>" class="post-card-avatar" onerror="this.remove()">
                        <div>
                            <a href="/twitter-app/src/public/users/<?= $user['id'] ?>" class="profile-link">
                                <p class="post-card-author"><?= htmlspecialchars($user['username']) ?></p>
                            </a>
                            <p class="post-card-handle">@<?= htmlspecialchars($user['email']) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        <?php endif ?>
    </div>
</body>
</html>