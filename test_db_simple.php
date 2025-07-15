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

// Phương thức 2: Kết nối qua IP localhost
echo "<h3>Phương thức 2: Kết nối qua IP 127.0.0.1</h3>";
$conn2 = @new mysqli("127.0.0.1", "haisan", "haisan", "haisan");
if ($conn2->connect_error) {
    echo "<div style='color:red;'>Kết nối thất bại: " . $conn2->connect_error . "</div>";
} else {
    echo "<div style='color:green;'>Kết nối thành công!</div>";
    $conn2->close();
}

// Phương thức 3: Kết nối qua IP nội bộ của container web
echo "<h3>Phương thức 3: Kết nối qua IP nội bộ (172.17.0.2)</h3>";
$conn3 = @new mysqli("172.17.0.2", "haisan", "haisan", "haisan");
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

// Hiển thị các host trong /etc/hosts
echo "<h2>Nội dung file hosts:</h2>";
if (file_exists('/etc/hosts')) {
    echo "<pre>" . htmlspecialchars(file_get_contents('/etc/hosts')) . "</pre>";
} else {
    echo "<div>Không thể đọc file /etc/hosts</div>";
}

// Kiểm tra kết nối mạng
echo "<h2>Kiểm tra kết nối mạng:</h2>";
$hosts_to_check = ['localhost', '127.0.0.1', '172.17.0.2', '42.96.16.211'];

foreach ($hosts_to_check as $host) {
    echo "<h3>Kiểm tra host: $host</h3>";
    
    // Thử ping
    $ping_output = [];
    $ping_result = -1;
    exec("ping -c 1 $host 2>&1", $ping_output, $ping_result);
    echo "<div>Kết quả ping: " . ($ping_result === 0 ? "<span style='color:green;'>Thành công</span>" : "<span style='color:red;'>Thất bại</span>") . "</div>";
    echo "<pre>" . implode("\n", $ping_output) . "</pre>";
    
    // Thử telnet đến cổng 3306
    $connection = @fsockopen($host, 3306, $errno, $errstr, 2);
    if (is_resource($connection)) {
        echo "<div style='color:green;'>Cổng 3306 mở và có thể kết nối!</div>";
        fclose($connection);
    } else {
        echo "<div style='color:red;'>Không thể kết nối đến cổng 3306: $errstr ($errno)</div>";
    }
}
?> 