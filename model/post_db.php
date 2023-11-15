<?php

class PostDB {
    private $db;
    private $error;
    private $message;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getError()
    {
        return $this->error;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function addPost($title, $content)
    {
        try {
            $query = 'INSERT INTO posts (title, content) VALUES (:title, :content)';
            $statement = $this->db->prepare($query);
            $statement->bindValue(':title', $title);
            $statement->bindValue(':content', $content);
            $statement->execute();
            $statement->closeCursor();
            $this->message = "Post added successfully.";
        } catch (PDOException $e) {
            $this->error = "Error adding post " . $e->getMessage();
        }
    }

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
            $this->message = "Post edited successfully.";
        } catch (PDOException $e) {
            $this->error = "Error editing post: " . $e->getMessage();
        }
    }

    public function deletePost($post_id)
    {
        try {
            $query = 'DELETE FROM posts WHERE postID = :post_id';
            $statement = $this->db->prepare($query);
            $statement->bindValue(':post_id', $post_id);
            $statement->execute();
            $statement->closeCursor();
            $this->message = "Post deleted successfully.";
        } catch (PDOException $e) {
            $this->error = "Error deleting post: " . $e->getMessage();
        }
    }
    public function deleteAllPosts()
    {
        try {
            $query = 'DROP posts';
            $statement = $this->db->prepare($query);
            $statement->execute();
            $statement->closeCursor();
            $this->message = "All Posts deleted successfully.";
        } catch (PDOException $e) {
            $this->error = "Error deleting all Posts: " . $e->getMessage();
        }
    }

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
            $this->error = "Error fetching posts: " . $e->getMessage();
            return [];
        }
    }

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
                $this->error = "Post not found.";
            }

            return $post;
        } catch (PDOException $e) {
            $this->error = "Error fetching post: " . $e->getMessage();
            return null;
        }
    }
}
?>
