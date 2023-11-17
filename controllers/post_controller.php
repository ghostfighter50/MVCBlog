<?php

/**
 * Include necessary files
 */
require_once('model/database.php');
require_once('model/post_db.php');

/**
 * Class PostController
 */
class PostController
{
    /**
     * Instance of the PostDB class
     * @var PostDB
     */
    private $postDB;

    /**
     * Constructor to initialize the class with a database connection
     * @param object $db - The database connection object
     * @param array $errorConfig - The error configuration array
     * @param array $messageConfig - The message configuration array
     */
    public function __construct($db, $errorConfig, $messageConfig)
    {
        // Create an instance of PostDB and pass the database connection and error/message configuration
        $this->postDB = new PostDB($db, $errorConfig, $messageConfig);
    }

    /**
     * Get a specific post by its ID
     * @param int $post_id - The ID of the post
     */
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

    /**
     * Add a new post
     * @param string $title - The title of the post
     * @param string $content - The content of the post
     */
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

    /**
     * Edit an existing post
     * @param int $post_id - The ID of the post
     * @param string $title - The updated title of the post
     * @param string $content - The updated content of the post
     */
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

    /**
     * Delete a post
     * @param int $post_id - The ID of the post to be deleted
     */
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

    /**
     * Delete all posts
     */
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

    /**
     * Get a list of all posts
     */
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

    /**
     * Download a PDF for a specific post
     * @param int $post_id - The ID of the post
     */
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
