<?php
$servername = "42.96.16.211"; // Địa chỉ IP MySQL bên ngoài
$username = "haisan";
$password = "haisan";
$dbname = "haisan";
$port = 3306;

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
