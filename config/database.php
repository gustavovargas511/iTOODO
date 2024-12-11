<?php
include $_SERVER['DOCUMENT_ROOT'] . '/TODOit/config.php';

try {
    // Create a new PDO instance
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT;
    $pdo = new PDO($dsn, DB_USER, DB_PASS); // Use DB_USER for the username and DB_PASS for the password

    // Set PDO attributes
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Enable exceptions for errors
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // Set default fetch mode to associative array

    // echo "Connected to the database successfully!";
    // echo '<script>alert("Connected to the database successfully!");</script>';
} catch (PDOException $e) {
    // Handle connection error
    die("Connection failed: " . $e->getMessage());
    // echo '<script>alert("Connection failed: ' . addslashes($e->getMessage()) . '");</script>';
}
?>