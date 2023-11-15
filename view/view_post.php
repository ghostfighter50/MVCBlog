<?php
require_once('header.php');
require_once('controllers/post_controller.php');
?>

<?php require_once('header.php') ?>

<?php if ($post): ?>
        <div class="container mt-4 d-flex flex-column min-vh-100">
            <div>
            <div class="actions-card">
                <div class="card-header">
                    <h5 class="card-title"><?= $post['title'] ?></h5>
                </div>
                <div class="card-body">
                    <p><?= $post['content'] ?></p>
                    <p class="text-muted">Posted on <?= $post['date'] ?></p>
                </div>
            </div>
            <div class="mt-auto">
                <p><button class="btn btn-dark" onclick="window.location.replace('/')">Back to List</button></p>
            </div>
            </div>
        </div>
<?php endif; ?>
<?php require_once('footer.php') ?>
