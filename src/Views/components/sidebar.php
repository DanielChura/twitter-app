<?php
// sidebar.php - Sidebar con información del usuario
?>
<div class="sidebar-card">
    <?php if (isset($_SESSION['user_id'])): ?>
        <div class="sidebar-centered">
            <a href="<?= url("/users/{$_SESSION['user_id']}") ?>" class="sidebar-link">
                <h3><?= htmlspecialchars($_SESSION['username']) ?></h3>
            </a>
            <a href="<?= url("/users/{$_SESSION['user_id']}") ?>" class="sidebar-link--blue">Ver mi perfil</a>
        </div>
        <a href="<?= url('/logout') ?>" class="sidebar-btn sidebar-btn--logout">Cerrar sesión</a>
    <?php else: ?>
        <div class="sidebar-centered">
            <p class="sidebar-mb">No has iniciado sesión</p>
            <a href="<?= url('/login') ?>" class="sidebar-btn sidebar-btn--primary sidebar-mb">Iniciar sesión</a>
            <a href="<?= url('/register') ?>" class="sidebar-btn sidebar-btn--secondary">Registrarse</a>
        </div>
    <?php endif; ?>
</div>
