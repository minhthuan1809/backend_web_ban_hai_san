<?php
$servername = "localhost"; // Your server name
$username = "root"; // Thường username mặc định của XAMPP là "root"
$password = ""; // Mặc định password trong XAMPP thường để trống
$dbname = "haisan"; // Your database name
$port = 3306; // Your database port

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

?>
