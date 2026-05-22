<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? "Twitter App" ?></title>
    <link rel="stylesheet" href="<?= url('/css/layout.css') ?>">
    <link rel="stylesheet" href="<?= url('/css/post-card.css') ?>">
    <link rel="stylesheet" href="<?= url('/css/create-post.css') ?>">
    <link rel="stylesheet" href="<?= url('/css/comment-card.css') ?>">
    <link rel="stylesheet" href="<?= url('/css/profile.css') ?>">
    <link rel="stylesheet" href="<?= url('/css/app.css') ?>">
    <link rel="stylesheet" href="<?= url('/css/banner.css') ?>">
</head>
<?php
$user_id = $_SESSION["user_id"] ?? null;
?>

<body>
    <div class="layout-container">
        <!-- Izquierda: Logo + Nav + Perfil -->
        <aside class="aside-left">
            <div class="side-inner">
                <a href="<?= url('/home') ?>" class="logo-link">
                    <span class="logo-icon-wrap"><?php require __DIR__ . "/icons/logo-icon.php"; ?></span>
                </a>
                <?php if ($user_id): ?>
                    <nav class="side-nav">
                        <a href="<?= url('/home') ?>"
                            class="nav-item <?= ($activeNav ?? '') === 'home' ? 'nav-item--active' : '' ?>">
                            <span class="nav-icon"><?php require __DIR__ . "/icons/home-icon.php"; ?></span>
                            <span class="nav-label">Inicio</span>
                        </a>
                        <a href="<?= url("/users/{$user_id}") ?>"
                            class="nav-item <?= ($activeNav ?? '') === 'profile' ? 'nav-item--active' : '' ?>">
                            <span class="nav-icon"><?php require __DIR__ . "/icons/profile-icon.php"; ?></span>
                            <span class="nav-label">Perfil</span>
                        </a>
                        <a href="#" class="nav-item">
                            <span class="nav-icon"><?php require __DIR__ . "/icons/follow-icon.php"; ?></span>
                            <span class="nav-label">Seguidos</span>
                        </a>
                    </nav>

                    <a href="<?= url('/home') ?>" class="post-btn">Postear</a>

                    <div class="nav-spacer"></div>

                    <div class="user-card-row">
                        <a href="<?= url("/users/{$user_id}") ?>" class="user-card">
                            <img src="<?= htmlspecialchars($userAvatar) ?>" alt="<?= htmlspecialchars($userName) ?>"
                                class="user-card-avatar">
                            <div class="user-card-info">
                                <p class="user-card-name"><?= htmlspecialchars($userName ?? "Usuario") ?></p>
                                <p class="user-card-handle">@<?= htmlspecialchars($userHandle ?? "usuario") ?></p>
                            </div>
                        </a>
                        <a href="<?= url('/logout') ?>" class="logout-btn" title="Cerrar sesión">
                            <?php require __DIR__ . "/icons/logout-icon.php"; ?>
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
                <span class="search-icon"><?php require __DIR__ . "/icons/search-icon.php"; ?></span>
                <input type="text" placeholder="Buscar">
            </div>

            <div class="widget">
                <h3>A quienes sigo</h3>
                <?php if (!empty($followedUsers)): ?>
                    <?php foreach ($followedUsers as $fu): ?>
                        <a href="<?= url("/users/{$fu['id']}") ?>" class="suggested-user">
                            <img src="<?= htmlspecialchars($fu['avatar_url']) ?>"
                                alt="Avatar de <?= htmlspecialchars($fu['username']) ?>" class="user-img">
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