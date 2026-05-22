<?php if (isset($post)): ?>
    <div class="post-card">
        <div class="post-card-header">
            <a href="<?= url("/users/{$post['user_id']}") ?>" class="post-card-header-link">
                <img src="<?= htmlspecialchars($post['avatar_url']) ?>" alt="Avatar de <?= htmlspecialchars($post['username']) ?>" class="post-card-avatar">
                <div>
                    <p class="post-card-author"><?= htmlspecialchars($post['username']) ?></p>
                    <p class="post-card-handle">@<?= htmlspecialchars($post['email']) ?></p>
                </div>
            </a>
        </div>

        <p class="post-card-content"><?= htmlspecialchars($post['content']) ?></p>

        <?php if (!empty($post['image_url'])): ?>
            <img src="<?= htmlspecialchars($post['image_url']) ?>" alt="post image" class="post-card-image">
        <?php endif; ?>

        <div class="post-card-actions">
            <form action="<?= url("/likePost/{$post['post_id']}") ?>" method="post" class="post-card-form">
                <button type="submit" class="post-card-btn">❤️ <?= $post['total_likes'] ?? 0 ?> Me gusta</button>
            </form>
            <a href="<?= url("/post/{$post['post_id']}") ?>" class="post-card-btn">💬 <?= $post["total_comments"] ?? 0 ?></a>
            <button type="button" class="post-card-btn">↗️ Compartir</button>
        </div>
    </div>

<?php endif; ?>