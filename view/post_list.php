<?php
// Include header and necessary files
require_once('header.php');
require_once('model/database.php');
require_once('model/post_db.php');
?>

<!-- Main content container -->
<div class="container mt-4">

    <!-- Actions Section -->
    <section id="actions">
        <div class="container mt-4 mx-auto">
            <div class="actions-card">
                <div class="card-header">
                    <h5 class="card-title">Actions</h5>
                </div>
                <div class="card-body">
                    <br>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPostModal">➕Add Post</button>
                    <br><br>
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAllPostsModal">🗑️ Delete all Posts</button>
                    <br><br>
                </div>
            </div>
        </div>
    </section>

    <!-- List Section -->
    <?php if ($posts) { ?>
                <section id="list" class="list">
                    <table class="table table-dark">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($posts as $post): ?>
                                        <tr>
                                            <td class="detail"><?= $post['postID'] ?></td>
                                            <td><?= $post['title'] ?></td>
                                            <td><?= $post['date'] ?></td>
                                            <td>
                                                <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#editPostModal<?= $post['postID'] ?>" data-post-id="<?= $post['postID'] ?>">
                                                    Edit
                                                </button>
                                                <br><br>
                                                <a href="?action=view_post&post_id=<?= $post['postID'] ?>" class="btn btn-primary btn-sm">View Post</a>
                                                <br><br>
                                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deletePostModal<?= $post['postID'] ?>" data-post-id="<?= $post['postID'] ?>">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </section>
    <?php } else { ?>
                <!-- Displayed if there are no blog posts -->
                <div class="alert bg-dark" role="alert">
                    No blog posts exist yet.
                </div>
    <?php } ?>

<!-- Add Post Modal -->
<div class="modal fade" id="addPostModal" tabindex="-1" aria-labelledby="addPostModalLabel" aria-hidden="true">
    <!-- Modal content for adding a new post -->
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title" id="addPostModalLabel">Add Blog Post</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Add post form -->
                <form action="." method="post" id="add__form" class="add__form">
                    <!-- Hidden input for action -->
                    <input type="hidden" name="action" value="add_post">
                    <!-- Input fields for title and content -->
                    <div class="add__inputs mb-3">
                        <label for="title" class="form-label">Title:</label>
                        <input type="text" name="title" class="form-control" maxlength="30" placeholder="Title" autofocus required>
                    </div>
                    <div class="add__inputs mb-3">
                        <label for="content" class="form-label">Content:</label>
                        <textarea name="content" class="form-control" placeholder="Content" rows="4" required></textarea>
                    </div>
                    <!-- Submit button -->
                    <div class="add__addItem">
                        <button type="submit" class="btn btn-success">➕ Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Post Modals -->
<?php foreach ($posts as $post): ?>
            <div class="modal fade" id="editPostModal<?= $post['postID'] ?>" tabindex="-1" aria-labelledby="editPostModalLabel<?= $post['postID'] ?>" aria-hidden="true">
                <!-- Modal content for editing a post -->
                <div class="modal-dialog">
                    <div class="modal-content bg-dark text-white">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editPostModalLabel<?= $post['postID'] ?>">Edit Blog Post</h5>
                            <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Edit post form -->
                            <form action="." method="post" id="edit__form" class="edit__form">
                                <!-- Hidden inputs for action and post_id -->
                                <input type="hidden" name="action" value="edit_post">
                                <input type="hidden" name="post_id" value="<?= $post['postID'] ?>">
                                <!-- Input fields for title and content -->
                                <div class="add__inputs mb-3">
                                    <label for="title" class="form-label">Title:</label>
                                    <input type="text" name="title" class="form-control" maxlength="30" placeholder="Title" value="<?= $post['title'] ?>" required>
                                </div>
                                <div class="add__inputs mb-3">
                                    <label for="content" class="form-label">Content:</label>
                                    <textarea name="content" class="form-control" placeholder="Content" rows="4" required><?= $post['content'] ?></textarea>
                                </div>
                                <!-- Submit button -->
                                <div class="add__addItem">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delete Post Modal -->
            <div class="modal fade" id="deletePostModal<?= $post['postID'] ?>" tabindex="-1" aria-labelledby="deletePostModalLabel<?= $post['postID'] ?>" aria-hidden="true">
                <!-- Modal content for deleting a post -->
                <div class="modal-dialog">
                    <div class="modal-content bg-dark text-white">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deletePostModalLabel<?= $post['postID'] ?>">Delete Blog Post</h5>
                            <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete this post?</p>
                            <!-- Delete post form -->
                            <form action="." method="post">
                                <!-- Hidden inputs for action and post_id -->
                                <input type="hidden" name="action" value="delete_post">
                                <input type="hidden" name="post_id" value="<?= $post['postID'] ?>">
                                <!-- Submit button -->
                                <button type="submit" class="btn btn-danger">🗑️ Yes, Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
<?php endforeach; ?>

<!-- Delete All Posts Modal -->
<div class="modal fade" id="deleteAllPostsModal" tabindex="-1" aria-labelledby="deleteAllPostsModalLabel" aria-hidden="true">
    <!-- Modal content for deleting all posts -->
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteAllPostsModalLabel">Delete every Blog Post</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete all the posts?</p>
                <!-- Delete all posts form -->
                <form action="." method="post">
                    <!-- Hidden input for action -->
                    <input type="hidden" name="action" value="delete_all_posts">
                    <!-- Submit button -->
                    <button type="submit" class="btn btn-danger">🗑️ Yes, Delete all Posts</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php') ?>


</div>

<?php require_once('footer.php') ?>
    