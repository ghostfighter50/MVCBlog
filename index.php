<?php

// Include necessary files.
require_once('model/database.php');
require_once('controllers/post_controller.php');

// Retrieve action and input parameters.
$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING) ?? filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING) ?? 'list_posts';
$post_id = filter_input(INPUT_POST, 'post_id', FILTER_SANITIZE_STRING) ?? filter_input(INPUT_GET, 'post_id', FILTER_SANITIZE_STRING);
$title = nl2br(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING));
$content = nl2br(filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRING));

// Load error and message configurations.
$errorConfig = json_decode(file_get_contents('config/errors.json'), true);
$messageConfig = json_decode(file_get_contents('config/messages.json'), true);
$Error404 = json_decode(file_get_contents('config/errors.json'), true)['404Error'];
$postController = new PostController($db, $errorConfig, $messageConfig);

// Perform action based on the requested action in the URI paramaters.
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
    case 'download_pdf':
        $postController->downloadPdf($post_id);
        break;   
    default:
        $postController->listPosts();
}

?>
