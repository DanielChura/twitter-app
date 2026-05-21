<?php
// Generar contenido del feed
ob_start();
?>

<div class="create-post">
    <h3 class="create-post-title">Crear Post</h3>
    <form action="/twitter-app/src/public/storedPost" method="post">
        <textarea name="content" placeholder="¿Qué está pasando?" required class="create-post-textarea"></textarea>
        <input type="text" name="image_url" placeholder="URL de imagen (opcional)" class="create-post-input">
        <button type="submit" class="create-post-btn">Publicar</button>
    </form>
</div>

<?php foreach ($posts as $post): ?>
    <?php include __DIR__ . "/../post-card.php"; ?>
<?php endforeach; ?>

<?php
$content = ob_get_clean();
$userId = $_SESSION["user_id"] ?? null;
$userName = $currentUser["username"] ?? null;
$userHandle = $currentUser["username"] ?? null;
$userAvatar = $currentUser["avatar_url"] ?? null;
$activeNav = "home";
$pageTitle = "Inicio";
require __DIR__ . "/../app-layout.php";
?>