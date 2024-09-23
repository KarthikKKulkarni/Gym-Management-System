<?php
$host = 'localhost';
$dbname = 'gym_management';
$username = 'root';  // Default MySQL username
$password = '';      // Default MySQL password (change if you have set one)

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}
?>
