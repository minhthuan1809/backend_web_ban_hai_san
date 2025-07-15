<?php
// Danh sách các cách kết nối để thử
$connection_methods = [
    // Phương thức 1: Kết nối qua localhost
    function() {
        $conn = @new mysqli("localhost", "haisan", "haisan", "haisan");
        return $conn;
    },
    // Phương thức 2: Kết nối qua IP
    function() {
        $conn = @new mysqli("127.0.0.1", "haisan", "haisan", "haisan");
        return $conn;
    },
    // Phương thức 3: Kết nối qua socket mặc định
    function() {
        $conn = @new mysqli("localhost", "haisan", "haisan", "haisan", 3306, ini_get("mysqli.default_socket"));
        return $conn;
    }
];

// Thử từng cách kết nối
$conn = null;
$connection_error = "";

foreach ($connection_methods as $method) {
    $temp_conn = $method();
    if (!$temp_conn->connect_error) {
        $conn = $temp_conn;
        break;
    } else {
        $connection_error = $temp_conn->connect_error;
    }
}

// Nếu tất cả các cách kết nối đều thất bại
if (!$conn || $conn->connect_error) {
    error_log("Database connection error: " . $connection_error);
    die("Không thể kết nối đến cơ sở dữ liệu. Vui lòng kiểm tra lại cấu hình kết nối.<br>Chi tiết lỗi: " . $connection_error);
}
?>
