<?php
// Kết nối đến MySQL trong môi trường Docker
// Sử dụng localhost hoặc IP nội bộ của container

// Thông tin kết nối
$servername = "localhost"; // Thử kết nối đến MySQL trong cùng container
$username = "haisan";
$password = "haisan";
$dbname = "haisan";
$port = 3306;

// Thiết lập thời gian chờ kết nối
ini_set('default_socket_timeout', 5);
mysqli_options(MYSQLI_OPT_CONNECT_TIMEOUT, 5);

// Thử kết nối với xử lý lỗi
try {
    // Tạo kết nối
    $conn = @new mysqli($servername, $username, $password, $dbname, $port);
    
    // Kiểm tra kết nối
    if ($conn->connect_error) {
        // Nếu kết nối localhost thất bại, thử kết nối qua IP nội bộ
        $conn = @new mysqli("127.0.0.1", $username, $password, $dbname, $port);
        
        if ($conn->connect_error) {
            // Nếu cả hai cách đều thất bại, thử kết nối qua IP container
            $conn = @new mysqli("172.17.0.2", $username, $password, $dbname, $port);
            
            if ($conn->connect_error) {
                throw new Exception("Connection failed: " . $conn->connect_error);
            }
        }
    }
} catch (Exception $e) {
    // Ghi log lỗi
    error_log("Database connection error: " . $e->getMessage());
    
    // Hiển thị thông báo lỗi thân thiện
    echo "Không thể kết nối đến cơ sở dữ liệu. Vui lòng kiểm tra lại cấu hình kết nối.";
    echo "<br>Chi tiết lỗi: " . $e->getMessage();
    die();
}
?>
