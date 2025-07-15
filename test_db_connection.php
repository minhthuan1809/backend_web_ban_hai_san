<?php
// Hiển thị tất cả lỗi
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Kiểm tra kết nối cơ sở dữ liệu</h1>";

// Thông tin kết nối
$servername = "42.96.16.211";
$username = "haisan";
$password = "haisan";
$dbname = "haisan";
$port = 3306;

echo "<h2>Thông tin kết nối:</h2>";
echo "Server: $servername<br>";
echo "Username: $username<br>";
echo "Database: $dbname<br>";
echo "Port: $port<br>";

// Thiết lập thời gian chờ kết nối
ini_set('default_socket_timeout', 5);

echo "<h2>Kiểm tra kết nối:</h2>";

// Kiểm tra kết nối bằng mysqli
echo "<h3>Kiểm tra kết nối bằng mysqli:</h3>";
try {
    $start_time = microtime(true);
    
    $conn = new mysqli($servername, $username, $password, $dbname, $port);
    
    $end_time = microtime(true);
    $execution_time = ($end_time - $start_time);
    
    if ($conn->connect_error) {
        echo "<div style='color:red;'>Kết nối mysqli thất bại: " . $conn->connect_error . "</div>";
    } else {
        echo "<div style='color:green;'>Kết nối mysqli thành công! (Thời gian: " . number_format($execution_time, 2) . " giây)</div>";
        
        // Kiểm tra các bảng
        $tables = $conn->query("SHOW TABLES");
        if ($tables && $tables->num_rows > 0) {
            echo "<h4>Danh sách bảng:</h4><ul>";
            while ($table = $tables->fetch_array()) {
                echo "<li>" . $table[0] . "</li>";
            }
            echo "</ul>";
        } else {
            echo "<div>Không có bảng nào hoặc không thể truy vấn danh sách bảng.</div>";
        }
        
        $conn->close();
    }
} catch (Exception $e) {
    echo "<div style='color:red;'>Lỗi mysqli: " . $e->getMessage() . "</div>";
}

// Kiểm tra kết nối bằng PDO
echo "<h3>Kiểm tra kết nối bằng PDO:</h3>";
try {
    $start_time = microtime(true);
    
    $pdo = new PDO("mysql:host=$servername;port=$port;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $end_time = microtime(true);
    $execution_time = ($end_time - $start_time);
    
    echo "<div style='color:green;'>Kết nối PDO thành công! (Thời gian: " . number_format($execution_time, 2) . " giây)</div>";
    
    // Kiểm tra phiên bản MySQL
    $stmt = $pdo->query("SELECT version()");
    $version = $stmt->fetchColumn();
    echo "<div>Phiên bản MySQL: $version</div>";
    
} catch (PDOException $e) {
    echo "<div style='color:red;'>Lỗi PDO: " . $e->getMessage() . "</div>";
}

// Kiểm tra ping đến máy chủ
echo "<h3>Kiểm tra kết nối mạng:</h3>";
$ping_output = [];
$ping_result = -1;
exec("ping -n 3 $servername", $ping_output, $ping_result);
echo "<div>Kết quả ping: " . ($ping_result === 0 ? "<span style='color:green;'>Thành công</span>" : "<span style='color:red;'>Thất bại</span>") . "</div>";
echo "<pre>" . implode("\n", $ping_output) . "</pre>";

// Kiểm tra cổng
echo "<h3>Kiểm tra cổng MySQL (3306):</h3>";
$connection = @fsockopen($servername, $port, $errno, $errstr, 5);
if (is_resource($connection)) {
    echo "<div style='color:green;'>Cổng 3306 mở và có thể kết nối!</div>";
    fclose($connection);
} else {
    echo "<div style='color:red;'>Không thể kết nối đến cổng 3306: $errstr ($errno)</div>";
}
?> 