<?php

require_once('model/database.php');
require_once('controllers/post_controller.php');

$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING) ?? filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING) ?? 'list_posts';
$post_id = filter_input(INPUT_POST, 'post_id', FILTER_SANITIZE_STRING) ?? filter_input(INPUT_GET, 'post_id', FILTER_SANITIZE_STRING);
$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
$content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRING);

$postController = new PostController($db);

switch ($action) {
    case 'list_posts':
        $postController->listPosts();
        break;
    case 'add_post':
        $postController->addPost($title, $content);
        break;
    case 'edit_post':

        $postController->editPost($post_id, $title, $content);
        break;
    case 'delete_post':
        $postController->deletePost($post_id);
        break;
    case 'delete_all_posts':
        $postController->deleteAllPosts();
        break;
    case 'view_post':
        $postController->getPostById($post_id);
        break;
    default:
        $postController->listPosts();
}
?>
