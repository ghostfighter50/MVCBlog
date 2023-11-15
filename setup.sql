-- Create a database
CREATE DATABASE IF NOT EXISTS blog_db;

-- Use the created database
USE blog_db;

-- Create a table for blog posts
CREATE TABLE IF NOT EXISTS posts (
    postID INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert some sample data
INSERT INTO posts (title, content) VALUES
    ('First Post', 'This is the content of the first blog post.'),
    ('Second Post', 'Here is the content of the second blog post.');
