<?php
// Hiển thị tất cả lỗi
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Kiểm tra kết nối cơ sở dữ liệu đơn giản</h1>";

// Thử kết nối với MySQL
echo "<h2>Kết nối MySQL:</h2>";

// Phương thức 1: Kết nối qua localhost
echo "<h3>Phương thức 1: Kết nối qua localhost</h3>";
$conn1 = @new mysqli("localhost", "haisan", "haisan", "haisan");
if ($conn1->connect_error) {
    echo "<div style='color:red;'>Kết nối thất bại: " . $conn1->connect_error . "</div>";
} else {
    echo "<div style='color:green;'>Kết nối thành công!</div>";
    $conn1->close();
}

// Phương thức 2: Kết nối qua IP
echo "<h3>Phương thức 2: Kết nối qua IP 127.0.0.1</h3>";
$conn2 = @new mysqli("127.0.0.1", "haisan", "haisan", "haisan");
if ($conn2->connect_error) {
    echo "<div style='color:red;'>Kết nối thất bại: " . $conn2->connect_error . "</div>";
} else {
    echo "<div style='color:green;'>Kết nối thành công!</div>";
    $conn2->close();
}

// Phương thức 3: Kết nối qua container
echo "<h3>Phương thức 3: Kết nối qua container MySQL</h3>";
$conn3 = @new mysqli("1Panel-mysql-BzOO", "haisan", "haisan", "haisan");
if ($conn3->connect_error) {
    echo "<div style='color:red;'>Kết nối thất bại: " . $conn3->connect_error . "</div>";
} else {
    echo "<div style='color:green;'>Kết nối thành công!</div>";
    $conn3->close();
}

// Phương thức 4: Kết nối qua IP bên ngoài
echo "<h3>Phương thức 4: Kết nối qua IP bên ngoài</h3>";
$conn4 = @new mysqli("42.96.16.211", "haisan", "haisan", "haisan");
if ($conn4->connect_error) {
    echo "<div style='color:red;'>Kết nối thất bại: " . $conn4->connect_error . "</div>";
} else {
    echo "<div style='color:green;'>Kết nối thành công!</div>";
    $conn4->close();
}

// Hiển thị thông tin hệ thống
echo "<h2>Thông tin hệ thống:</h2>";
echo "PHP version: " . phpversion() . "<br>";
echo "Server software: " . $_SERVER['SERVER_SOFTWARE'] . "<br>";
echo "Server name: " . $_SERVER['SERVER_NAME'] . "<br>";
echo "Server addr: " . ($_SERVER['SERVER_ADDR'] ?? 'N/A') . "<br>";
echo "Document root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
?> 