<?php
// Hiển thị tất cả lỗi
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Kiểm tra Socket MySQL</h1>";

// Danh sách các đường dẫn socket MySQL phổ biến
$socket_paths = [
    "/var/run/mysqld/mysqld.sock",
    "/var/lib/mysql/mysql.sock",
    "/tmp/mysql.sock",
    "/var/mysql/mysql.sock",
    "/opt/local/var/run/mysql8/mysqld.sock",
    "/opt/local/var/run/mysql57/mysqld.sock",
    "/opt/local/var/run/mysql56/mysqld.sock",
    "/opt/local/var/run/mysql5/mysqld.sock"
];

// Kiểm tra từng đường dẫn socket
echo "<h2>Kiểm tra các đường dẫn socket:</h2>";
echo "<ul>";
foreach ($socket_paths as $socket_path) {
    if (file_exists($socket_path)) {
        echo "<li style='color:green;'>$socket_path - Tồn tại</li>";
    } else {
        echo "<li style='color:red;'>$socket_path - Không tồn tại</li>";
    }
}
echo "</ul>";

// Kiểm tra cấu hình PHP
echo "<h2>Cấu hình MySQL trong PHP:</h2>";
$mysql_config = ini_get("mysqli.default_socket");
echo "mysqli.default_socket: " . ($mysql_config ?: "Không được đặt") . "<br>";

// Kiểm tra kết nối qua socket
echo "<h2>Thử kết nối qua socket:</h2>";
$username = "haisan";
$password = "haisan";
$dbname = "haisan";

foreach ($socket_paths as $socket_path) {
    echo "<h3>Thử kết nối qua socket: $socket_path</h3>";
    try {
        $mysqli = @new mysqli("localhost", $username, $password, $dbname, null, $socket_path);
        if ($mysqli->connect_error) {
            echo "<div style='color:red;'>Kết nối thất bại: " . $mysqli->connect_error . "</div>";
        } else {
            echo "<div style='color:green;'>Kết nối thành công!</div>";
            $mysqli->close();
        }
    } catch (Exception $e) {
        echo "<div style='color:red;'>Lỗi: " . $e->getMessage() . "</div>";
    }
}

// Kiểm tra thông tin PHP
echo "<h2>Thông tin PHP:</h2>";
echo "PHP version: " . phpversion() . "<br>";
echo "PHP SAPI: " . php_sapi_name() . "<br>";

// Kiểm tra các extension MySQL
echo "<h2>MySQL extensions:</h2>";
echo "MySQLi: " . (extension_loaded('mysqli') ? 'Đã cài đặt' : 'Không cài đặt') . "<br>";
echo "PDO MySQL: " . (extension_loaded('pdo_mysql') ? 'Đã cài đặt' : 'Không cài đặt') . "<br>";

// Hiển thị thông tin hệ thống
echo "<h2>Thông tin hệ thống:</h2>";
$uname = php_uname();
echo "OS: $uname<br>";
?> 