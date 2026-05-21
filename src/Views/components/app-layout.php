<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? "Twitter App" ?></title>
    <link rel="stylesheet" href="/twitter-app/src/public/css/layout.css">
    <link rel="stylesheet" href="/twitter-app/src/public/css/post-card.css">
    <link rel="stylesheet" href="/twitter-app/src/public/css/profile.css">
    <link rel="stylesheet" href="/twitter-app/src/public/css/app.css">
    <link rel="stylesheet" href="/twitter-app/src/public/css/banner.css">
</head>
<?php
$user_id = $_SESSION["user_id"] ?? null;
?>

<body>
    <div class="layout-container">
        <!-- Izquierda: Logo + Nav + Perfil -->
        <aside class="aside-left">
            <div class="side-inner">
                <a href="/twitter-app/src/public/home" class="logo-link">
                    <svg viewBox="0 0 24 24" width="32" height="32" fill="#1d9bf0">
                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                    </svg>
                </a>
                <?php if ($user_id): ?>
                    <nav class="side-nav">
                        <a href="/twitter-app/src/public/home" class="nav-item <?= ($activeNav ?? '') === 'home' ? 'nav-item--active' : '' ?>">
                            <svg class="nav-icon" viewBox="0 0 24 24" width="26" height="26">
                                <path d="M12 1.696L.622 8.807l1.06 1.696L3 9.679V21h18V9.679l1.318.824 1.06-1.696L12 1.696zM12 3.29l7 5.11V19H5V8.4l7-5.11z" />
                            </svg>
                            <span class="nav-label">Inicio</span>
                        </a>
                        <a href="/twitter-app/src/public/users/<?= $user_id ?>" class="nav-item <?= ($activeNav ?? '') === 'profile' ? 'nav-item--active' : '' ?>">
                            <svg class="nav-icon" viewBox="0 0 24 24" width="26" height="26">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                            </svg>
                            <span class="nav-label">Perfil</span>
                        </a>
                        <a href="#" class="nav-item">
                            <svg class="nav-icon" viewBox="0 0 24 24" width="26" height="26">
                                <path d="M5.5 7.5C5.5 5.57 7.07 4 9 4s3.5 1.57 3.5 3.5S10.93 11 9 11s-3.5-1.57-3.5-3.5zM18.5 6.5c0 1.66-1.34 3-3 3s-3-1.34-3-3 1.34-3 3-3 3 1.34 3 3zM9 13c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm6.5 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z" />
                            </svg>
                            <span class="nav-label">Seguidos</span>
                        </a>
                    </nav>

                    <a href="/twitter-app/src/public/home" class="post-btn">Postear</a>

                    <div class="nav-spacer"></div>

                    <div class="user-card-row">
                        <a href="/twitter-app/src/public/users/<?= $user_id ?>" class="user-card">
                            <img src="<?= htmlspecialchars($userAvatar) ?>" alt="<?= htmlspecialchars($userName) ?>" class="user-card-avatar">
                            <div class="user-card-info">
                                <p class="user-card-name"><?= htmlspecialchars($userName ?? "Usuario") ?></p>
                                <p class="user-card-handle">@<?= htmlspecialchars($userHandle ?? "usuario") ?></p>
                            </div>
                        </a>
                        <a href="/twitter-app/src/public/logout" class="logout-btn" title="Cerrar sesión">
                            <svg viewBox="0 0 24 24" width="20" height="20">
                                <path d="M5 21h14c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2H5c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2zm0-2V5h14l.002 14H5z" />
                                <path d="M10.707 12.293L9.293 10.88 6.464 13.71l2.829 2.828 1.414-1.414L10.293 14H15v-2z" />
                            </svg>
                        </a>
                    </div>

                <?php endif; ?>
            </div>
        </aside>

        <!-- Centro: Feed Principal -->
        <main class="main-content">
            <header class="header">
                <h2><?= $pageTitle ?? "Inicio" ?></h2>
            </header>
            <div class="content">
                <?= $content ?? ""; ?>
            </div>
        </main>

        <!-- Derecha: Búsqueda y Sugerencias -->
        <aside class="aside-right">
            <div class="search-box">
                <input type="text" placeholder="Buscar">
            </div>

            <div class="widget">
                <h3>A quienes sigo</h3>
                <?php if (!empty($followedUsers)): ?>
                    <?php foreach ($followedUsers as $fu): ?>
                        <a href="/twitter-app/src/public/users/<?= $fu['id'] ?>" class="suggested-user">
                            <img src="<?= htmlspecialchars($fu['avatar_url']) ?>" alt="Avatar de <?= htmlspecialchars($fu['username']) ?>" class="user-img">
                            <div>
                                <p><strong><?= htmlspecialchars($fu['username']) ?></strong></p>
                                <p class="text-muted">@<?= htmlspecialchars($fu['email']) ?></p>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted">No sigues a nadie aún</p>
                <?php endif; ?>
            </div>
        </aside>
    </div>
    <?php if (!$user_id):
        require __DIR__ . "/header/banner.php";
    endif; ?>
</body>

</html>