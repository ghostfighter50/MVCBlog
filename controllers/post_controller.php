<?php

require_once('model/database.php');
require_once('model/post_db.php');

class PostController
{
    private $postDB;

    public function __construct($db)
    {
        $this->postDB = new PostDB($db);
    }

    public function getPostById($post_id)
    {
        $post = $this->postDB->getPostById($post_id);

        if ($this->postDB->getError()) {
            $error = $this->postDB->getError();
            require_once('view/error.php');
        } else {
            require_once('view/view_post.php');
        }
    }

    public function addPost($title, $content)
    {
        $this->postDB->addPost($title, $content);

        if ($this->postDB->getError()) {
            $error = $this->postDB->getError();
            require_once('view/error.php');
        } else {
            $message = $this->postDB->getMessage();
            header("Location: .?action=list_posts&message=$message");
        }
    }

    public function editPost($post_id, $title, $content)
    {
        $this->postDB->editPost($post_id, $title, $content);

        if ($this->postDB->getError()) {
            $error = $this->postDB->getError();
            require_once('view/error.php');
        } else {
            $message = $this->postDB->getMessage();
            header("Location: .?action=list_posts&message=$message");
        }
    }

    public function deletePost($post_id)
    {
        $this->postDB->deletePost($post_id);

        if ($this->postDB->getError()) {
            $error = $this->postDB->getError();
            require_once('view/error.php');
        } else {
            $message = $this->postDB->getMessage();
            header("Location: .?action=list_posts&message=$message");
        }
    }
    public function deleteAllPosts()
    {
        $this->postDB->deleteAllPosts();

        if ($this->postDB->getError()) {
            $error = $this->postDB->getError();
            require_once('view/error.php');
        } else {
            $message = $this->postDB->getMessage();
            header("Location: .?action=list_posts&message=$message");
        }
    }
    public function listPosts()
    {
        $posts = $this->postDB->listPosts();

        if ($this->postDB->getError()) {
            $error = $this->postDB->getError();
            require_once('view/error.php');
        } else {
            require_once('view/post_list.php');
        }
    }
}
?>
