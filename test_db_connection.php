<?php
// Hiển thị tất cả lỗi
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Kiểm tra kết nối cơ sở dữ liệu</h1>";

// Danh sách các máy chủ cần kiểm tra
$servers = [
    [
        'name' => 'Localhost',
        'host' => 'localhost',
        'username' => 'haisan',
        'password' => 'haisan',
        'dbname' => 'haisan',
        'port' => 3306
    ],
    [
        'name' => 'Localhost IP',
        'host' => '127.0.0.1',
        'username' => 'haisan',
        'password' => 'haisan',
        'dbname' => 'haisan',
        'port' => 3306
    ],
    [
        'name' => 'Container MySQL',
        'host' => '1Panel-mysql-BzOO',
        'username' => 'haisan',
        'password' => 'haisan',
        'dbname' => 'haisan',
        'port' => 3306
    ],
    [
        'name' => 'IP Bên ngoài',
        'host' => '42.96.16.211',
        'username' => 'haisan',
        'password' => 'haisan',
        'dbname' => 'haisan',
        'port' => 3306
    ]
];

// Thiết lập thời gian chờ kết nối
ini_set('default_socket_timeout', 3); // Giảm thời gian chờ để kiểm tra nhanh hơn

// Kiểm tra từng máy chủ
foreach ($servers as $server) {
    echo "<hr><h2>Kiểm tra kết nối đến: {$server['name']} ({$server['host']})</h2>";
    
    // Kiểm tra kết nối bằng mysqli
    echo "<h3>Kiểm tra kết nối bằng mysqli:</h3>";
    try {
        $start_time = microtime(true);
        
        $conn = @new mysqli($server['host'], $server['username'], $server['password'], $server['dbname'], $server['port']);
        
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
    
    // Kiểm tra cổng
    echo "<h3>Kiểm tra cổng MySQL (3306):</h3>";
    $connection = @fsockopen($server['host'], $server['port'], $errno, $errstr, 2);
    if (is_resource($connection)) {
        echo "<div style='color:green;'>Cổng 3306 mở và có thể kết nối!</div>";
        fclose($connection);
    } else {
        echo "<div style='color:red;'>Không thể kết nối đến cổng 3306: $errstr ($errno)</div>";
    }
}

// Hiển thị thông tin hệ thống
echo "<hr><h2>Thông tin hệ thống:</h2>";
echo "<div>PHP version: " . phpversion() . "</div>";
echo "<div>Server software: " . $_SERVER['SERVER_SOFTWARE'] . "</div>";
echo "<div>Server name: " . $_SERVER['SERVER_NAME'] . "</div>";
echo "<div>Server addr: " . ($_SERVER['SERVER_ADDR'] ?? 'N/A') . "</div>";

// Hiển thị các extension PHP đã cài đặt
echo "<h3>PHP Extensions:</h3>";
$extensions = get_loaded_extensions();
echo "<ul>";
foreach ($extensions as $extension) {
    echo "<li>$extension</li>";
}
echo "</ul>";

// Kiểm tra các biến môi trường liên quan đến cơ sở dữ liệu
echo "<h3>Biến môi trường:</h3>";
$env_vars = [
    'DB_HOST',
    'DB_USER',
    'DB_PASSWORD',
    'DB_NAME',
    'DB_PORT'
];

echo "<ul>";
foreach ($env_vars as $var) {
    $value = getenv($var) ?: 'Not set';
    echo "<li>$var: $value</li>";
}
echo "</ul>";
?> 