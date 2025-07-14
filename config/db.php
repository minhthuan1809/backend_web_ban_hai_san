<?php
$servername = "42.96.16.211"; // Docker service name for MySQL
$username = "haisan"; // Username cho MySQL
$password = "haisan"; // Password cho MySQL
$dbname = "haisan"; // Your database name
$port = 3306; // Your database port

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

?>
