<?php
// Database configuration
$host = 'localhost';  // or your server's IP or domain
$dbname = 'task_sql';  // Your database name
$username = 'root';  // MySQL username (usually 'root' for local environments like XAMPP)
$password = '';  // MySQL password (empty for XAMPP, set if necessary)

try {
    // Create a PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully"; 
}
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
