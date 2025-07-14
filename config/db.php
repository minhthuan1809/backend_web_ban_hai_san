<?php
$servername = getenv('DB_HOST') ?: "haisan"; // Server name từ biến môi trường hoặc mặc định
$username = getenv('DB_USER') ?: "haisan"; // Username từ biến môi trường hoặc mặc định
$password = getenv('DB_PASSWORD') ?: "haisan"; // Password từ biến môi trường hoặc mặc định
$dbname = getenv('DB_NAME') ?: "haisan"; // Database name từ biến môi trường hoặc mặc định
$port = getenv('DB_PORT') ?: 3306; // Database port từ biến môi trường hoặc mặc định

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

?>
