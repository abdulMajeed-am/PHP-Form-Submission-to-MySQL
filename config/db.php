<?php
$host = '127.0.0.1';  // or 'localhost'
$db   = 'practice_db'; // Database name
$user = 'root';        // Your MySQL username
$pass = '';            // Your MySQL password (empty in WAMP)
$charset = 'utf8mb4';

try {
    $pdo = new PDO("mysql:host=$host;charset=$charset", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create database if it doesn't exist
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db`");
    $pdo->exec("USE `$db`");

} catch (PDOException $e) {
    die("DB Connection failed: " . $e->getMessage());
}
?>
