<?php
// Catches database connection errors without exposing sensitive information.
// Database connection using PDO for secure access  PDO => (PHP Data Objects)
$host = 'localhost';
$dbname = 'secure_app';
$username = 'root';
$password = '';
// PDO supports prepared statements to prevent SQL Injection.
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
