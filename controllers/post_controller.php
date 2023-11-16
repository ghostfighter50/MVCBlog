<?php

// Include necessary files
require_once('model/database.php');
require_once('model/post_db.php');

class PostController
{
    // Instance of the PostDB class
    private $postDB;

    // Constructor to initialize the class with a database connection
    public function __construct($db, $errorConfig, $messageConfig)
    {
        // Create an instance of PostDB and pass the database connection and error/message configuration
        $this->postDB = new PostDB($db, $errorConfig, $messageConfig);
    }

    // Get a specific post by its ID
    public function getPostById($post_id)
    {
        // Get post details from the database
        $post = $this->postDB->getPostById($post_id);

        // Check for errors
        if ($this->postDB->getError()) {
            $error = $this->postDB->getError();
            require_once('view/error.php');
        } else {
            // Load the view for displaying a single post
            require_once('view/view_post.php');
        }
    }

    // Add a new post
    public function addPost($title, $content)
    {
        // Add a new post to the database
        $this->postDB->addPost($title, $content);

        // Check for errors
        if ($this->postDB->getError()) {
            $error = $this->postDB->getError();
            require_once('view/error.php');
        } else {
            // Redirect to the post list with a success message
            $message = $this->postDB->getMessage();
            header("Location: .?action=list_posts&message=$message");
        }
    }

    // Edit an existing post
    public function editPost($post_id, $title, $content)
    {
        // Edit an existing post in the database
        $this->postDB->editPost($post_id, $title, $content);

        // Check for errors
        if ($this->postDB->getError()) {
            $error = $this->postDB->getError();
            require_once('view/error.php');
        } else {
            // Redirect to the post list with a success message
            $message = $this->postDB->getMessage();
            header("Location: .?action=list_posts&message=$message");
        }
    }

    // Delete a post
    public function deletePost($post_id)
    {
        // Delete a post from the database
        $this->postDB->deletePost($post_id);

        // Check for errors
        if ($this->postDB->getError()) {
            $error = $this->postDB->getError();
            require_once('view/error.php');
        } else {
            // Redirect to the post list with a success message
            $message = $this->postDB->getMessage();
            header("Location: .?action=list_posts&message=$message");
        }
    }

    // Delete all posts
    public function deleteAllPosts()
    {
        // Delete all posts from the database
        $this->postDB->deleteAllPosts();

        // Check for errors
        if ($this->postDB->getError()) {
            $error = $this->postDB->getError();
            require_once('view/error.php');
        } else {
            // Redirect to the post list with a success message
            $message = $this->postDB->getMessage();
            header("Location: .?action=list_posts&message=$message");
        }
    }

    // Get a list of all posts
    public function listPosts()
    {
        // Get a list of all posts from the database
        $posts = $this->postDB->listPosts();

        // Check for errors
        if ($this->postDB->getError()) {
            $error = $this->postDB->getError();
            require_once('view/error.php');
        } else {
            // Load the view for displaying the list of posts
            require_once('view/post_list.php');
        }
    }

    public function downloadPdf($post_id)
    {
        $post = $this->postDB->getPostById($post_id);

        if ($this->postDB->getError()) {
            $error = $this->postDB->getError();
            echo $error;
            exit();
        } else {
            $pdfContent = $this->postDB->generatePdfContent($post['title'], $post['content']);
            $title = $post['title'];
            // Send the PDF to the browser for download
            header('Content-Type: application/pdf');
            header("Content-Disposition: attachment; filename='MVC_blog_$title.pdf'");
            echo $pdfContent;
            exit();
        }
    }
}
?>
