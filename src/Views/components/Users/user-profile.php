<?php
ob_start();
?>

<?php if (isset($user)): ?>
    <div class="profile-header">
        <div class="profile-top">
            <img src="<?= htmlspecialchars($user["avatar_url"]) ?>" alt="<?= htmlspecialchars($user["username"]) ?>" class="profile-avatar-large">
            <div class="profile-info">
                <h3 class="profile-name"><?= htmlspecialchars($user["username"]) ?></h3>
                <p class="profile-handle">@<?= htmlspecialchars($user["email"]) ?></p>
                <p class="profile-bio"><?= htmlspecialchars($user["bio"] ?? "Sin biografía") ?></p>
            </div>
            <?php if (!$isMe): ?>
                <form action="/twitter-app/src/public/follow/<?= $user["id"] ?>" method="post">
                    <button class="profile-follow-btn">Seguir</button>
                </form>
            <?php endif; ?>
        </div>

        <div class="profile-stats">
            <div>
                <p class="profile-stat-number"><?= $user["total_followers"] ?? 0 ?></p>
                <p class="profile-stat-label">Seguidores</p>
            </div>
            <div>
                <p class="profile-stat-number">0</p>
                <p class="profile-stat-label">Siguiendo</p>
            </div>
        </div>
    </div>

    <h4 class="profile-posts-title">Posts</h4>
    <?php if (!empty($posts)): ?>
        <?php foreach ($posts as $post): ?>
            <?php include __DIR__ . "/../post-card.php"; ?>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="profile-empty">
            <p class="profile-empty-text">No hay posts disponibles</p>
        </div>
    <?php endif; ?>
<?php endif; ?>

<?php
$content = ob_get_clean();
$userId = $_SESSION["user_id"] ?? null;
$userName = $currentUser["username"] ?? "Usuario";
$userHandle = $currentUser["username"] ?? "usuario";
$userAvatar = $currentUser["avatar_url"] ?? "";
$activeNav = "profile";
$pageTitle = ($user["username"] ?? "Perfil") . " - Twitter App";
require __DIR__ . "/../app-layout.php";
?>