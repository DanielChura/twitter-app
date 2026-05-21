<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Posts</title>
</head>

<body class="bg-light">

    <section class="container py-4">

        <?php foreach ($posts as $post): ?>

            <!-- username, avatar_url, email, content, image_url -->
            <div class="bg-white border rounded mx-auto mb-4 p-4" style="max-width: 600px;">

                <!-- HEADER USER -->
                <div class="d-flex gap-3 align-items-center mb-3">

                    <img src=<?= $post["avatar_url"] ?>
                        class="rounded-circle"
                        width="48" height="48"
                        alt="user">

                    <div class="d-flex flex-column">
                        <div class="fw-bold"><?= $post["username"] ?></div>
                        <div class="text-muted"><?= $post["email"] ?></div>
                    </div>

                </div>

                <!---->
                <div class="mb-3">

                    <p class="mb-2">
                        <?= $post["content"] ?>
                    </p>

                    <?php if (!empty($post["image_url"])): ?>
                        <img src="<?= $post["image_url"] ?>" class="w-100 rounded">
                    <?php endif; ?>

                </div>

                <!---->
                <div class="d-flex justify-content-start gap-4 pt-3 border-top">

                    <button class="btn btn-primary p-2 rounded-circle">
                        <i class="bi bi-heart"></i>
                    </button>

                    <button class="btn btn-primary p-2 rounded-circle">
                        <i class="bi bi-chat"></i>
                    </button>

                    <button class="btn btn-primary p-2 rounded-circle">
                        <i class="bi bi-share"></i>
                    </button>

                </div>

            </div>

        <?php endforeach ?>

    </section>

</body>

</html>