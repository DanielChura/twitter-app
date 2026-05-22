<?php if (isset($post)): ?>

    <div class="comment-form">
        <img src="<?= htmlspecialchars($currentUser['avatar_url'] ?? '') ?>" alt="" class="comment-form-avatar">
        <form action="<?= url("/comment/{$post['post_id']}") ?>" method="post">
            <textarea name="content" required placeholder="Agrega un comentario" class="comment-form-textarea"></textarea>
            <input name="csrf_token" type="hidden" value="<?= $_SESSION["csrf_token"] ?>">
            <button type="submit" class="comment-form-btn">Enviar</button>
        </form>
    </div>

    <?php if (isset($comments)) : ?>
        <?php foreach ($comments as $comment): ?>
            <div class="comment-card">
                <div class="comment-card-header">
                    <img src="<?= htmlspecialchars($comment['avatar_url'] ?? '') ?>" alt="" class="comment-card-avatar">
                    <div>
                        <a href="<?= url("/users/{$comment['user_id']}") ?>" class="comment-card-author"><?= htmlspecialchars($comment['username']) ?></a>
                        <p class="comment-card-handle">@<?= htmlspecialchars($comment['email']) ?></p>
                    </div>
                </div>
                <p class="comment-card-content"><?= htmlspecialchars($comment['content']) ?></p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
<?php endif; ?>