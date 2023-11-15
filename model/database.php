<?php
    $dsn = 'mysql:host=localhost;dbname=blog_db';
    $username = 'root';
    try {
        $db = new PDO($dsn, $username);
    } catch (PDOException $e) {
        $error = "Database Error: ";
        $error .= $e->getMessage();
        require_once('view/error.php');
        exit();
    }