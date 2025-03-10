<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Đây là phương thức POST"
    ]);
    exit;
}

// Lấy dữ liệu từ request
$data = json_decode(file_get_contents('php://input'), true);
$name = isset($data['name']) ? $data['name'] : '';
$content = isset($data['content']) ? $data['content'] : '';
$gmail = isset($data['gmail']) ? $data['gmail'] : '';
$title = isset($data['title']) ? $data['title'] : '';

// Kiểm tra dữ liệu
if (empty($name) || empty($content) || empty($gmail)) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Tên, nội dung và email không được để trống."
    ]);
    exit;
}

// Kết nối đến cơ sở dữ liệu
require_once __DIR__ . '/../config/db.php';

if (!isset($conn) || !($conn instanceof mysqli)) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Không thể kết nối đến cơ sở dữ liệu"
    ]);
    exit;
}

// Thực hiện truy vấn để thêm dữ liệu vào bảng Contacts
$stmt = $conn->prepare("INSERT INTO contacts (name, content, gmail, title) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $content, $gmail, $title);

if ($stmt->execute()) {
    echo json_encode([
        "ok" => true,
        "success" => true,
        "message" => "Liên hệ đã được gửi thành công."
    ]);
} else {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Lỗi khi gửi liên hệ: " . $stmt->error
    ]);
}

$stmt->close();
$conn->close();
?>