<?php

// Read and decode the database configuration from the JSON file
$databaseConfig = json_decode(file_get_contents("config/database.json"), true);

if ($databaseConfig === null) {
    $error = "Error decoding database configuration.";
    require_once('view/error.php');
    exit();
}

$host = $databaseConfig['host'] ?? '';       // Database host
$dbname = $databaseConfig['dbname'] ?? '';   // Database name
$username = $databaseConfig['username'] ?? '';   // Database username
$password = $databaseConfig['password'] ?? '';   // Database password
$dsn = "mysql:host=$host;dbname=$dbname";    // Data Source Name (DSN) for PDO

try {
    $db = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    $error = "Database Error: " . $e->getMessage();
    require_once('view/error.php');
    exit();
}
?>
