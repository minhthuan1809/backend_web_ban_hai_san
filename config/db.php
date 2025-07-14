<?php
$servername = "1Panel-mysql-BzOO"; // Your server name
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
