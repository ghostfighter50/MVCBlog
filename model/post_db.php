<?php
require_once 'vendor/autoload.php';

class PostDB
{
    private $db;
    private $errorConfig;
    private $messageConfig;
    private $error;
    private $message;

    /**
     * Constructor for PostDB class.
     *
     * @param PDO $db Database connection
     * @param array $errorConfig Configuration for error messages
     * @param array $messageConfig Configuration for success messages
     */
    public function __construct($db, $errorConfig, $messageConfig)
    {
        $this->db = $db;
        $this->errorConfig = $errorConfig;
        $this->messageConfig = $messageConfig;
    }

    /**
     * Get the last error message.
     *
     * @return string|null Last error message or null if no error
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Get the last success message.
     *
     * @return string|null Last success message or null if no success
     */

    public function getMessage()
    {
        return $this->message;
    }


    /**
     * Add a new post to the database.
     *
     * @param string $title Title of the post
     * @param string $content Content of the post
     */
    public function addPost($title, $content)
    {
        try {
            $query = 'INSERT INTO posts (title, content) VALUES (:title, :content)';
            $statement = $this->db->prepare($query);
            $statement->bindValue(':title', $title);
            $statement->bindValue(':content', $content);
            $statement->execute();
            $statement->closeCursor();
            $this->message = $this->messageConfig['AddPostSuccess'];
        } catch (PDOException $e) {
            $this->error = $this->errorConfig['AddPostError'];
        }
    }

    /**
     * Edit an existing post in the database.
     *
     * @param int $post_id ID of the post to edit
     * @param string $title New title for the post
     * @param string $content New content for the post
     */
    public function editPost($post_id, $title, $content)
    {
        try {
            $query = 'UPDATE posts SET title = :title, content = :content WHERE postID = :post_id';
            $statement = $this->db->prepare($query);
            $statement->bindValue(':title', $title);
            $statement->bindValue(':content', $content);
            $statement->bindValue(':post_id', $post_id);
            $statement->execute();
            $statement->closeCursor();
            $this->message = $this->messageConfig['EditPostSuccess'];
        } catch (PDOException $e) {
            $this->error = $this->errorConfig['EditPostError'];
        }
    }

    /**
     * Delete a post from the database.
     *
     * @param int $post_id ID of the post to delete
     */
    public function deletePost($post_id)
    {
        try {
            $query = 'DELETE FROM posts WHERE postID = :post_id';
            $statement = $this->db->prepare($query);
            $statement->bindValue(':post_id', $post_id);
            $statement->execute();
            $statement->closeCursor();
            $this->message = $this->messageConfig['DeletePostSuccess'];
        } catch (PDOException $e) {
            $this->error = $this->errorConfig['DeletePostError'];
        }
    }

    /**
     * Delete all posts from the database.
     */
    public function deleteAllPosts()
    {
        try {
            $query = 'TRUNCATE TABLE posts';
            $statement = $this->db->prepare($query);
            $statement->execute();
            $statement->closeCursor();
            $this->message = $this->messageConfig['DeleteAllPostsSuccess'];
        } catch (PDOException $e) {
            $this->error = $this->errorConfig['DeleteAllPostsError'];
        }
    }

    /**
     * Retrieve a list of all posts from the database.
     *
     * @return array List of posts
     */
    public function listPosts()
    {
        try {
            $query = 'SELECT * FROM posts';
            $statement = $this->db->prepare($query);
            $statement->execute();
            $posts = $statement->fetchAll();
            $statement->closeCursor();
            return $posts;
        } catch (PDOException $e) {
            $this->error = $this->errorConfig['FetchError'];
            return [];
        }
    }

    /**
     * Retrieve a specific post by ID from the database.
     *
     * @param int $post_id ID of the post to retrieve
     * @return mixed|null The post or null if not found
     */
    public function getPostById($post_id)
    {
        try {
            $query = 'SELECT * FROM posts WHERE postID = :post_id';
            $statement = $this->db->prepare($query);
            $statement->bindValue(':post_id', $post_id);
            $statement->execute();
            $post = $statement->fetch();
            $statement->closeCursor();

            if (!$post) {
                $this->error = $this->errorConfig['NotFoundError'];
            }

            return $post;
        } catch (PDOException $e) {
            $this->error = $this->errorConfig['FetchError'];
            return null;
        }
    }

    /**
     * Generate PDF content for a post.
     *
     * @param string $title Title of the post
     * @param string $content Content of the post
     * @return string|false Generated PDF content or false on error
     */
    public function generatePdfContent($title, $content)
    {
        try {
            $pdf = new FPDF();
            $pdf->AddPage();
            $pdf->SetFont('Arial', '', 20);
            $pdf->Cell(0, 15, html_entity_decode(utf8_decode($title), ENT_QUOTES), 0, 1, 'C');
            $pdf->SetFont('Arial', '', 12);
            $pdf->MultiCell(0, 10, html_entity_decode(utf8_decode($content), ENT_QUOTES));

            return $pdf->Output('', 'S');
        } catch (Exception $e) {
            $this->error = $this->errorConfig['PDFError'];
            return false;
        }
    }
}
?>
