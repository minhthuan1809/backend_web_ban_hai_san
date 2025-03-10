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
$icon = isset($data['icon']) ? $data['icon'] : '';
$title = isset($data['title']) ? $data['title'] : '';
$description = isset($data['description']) ? $data['description'] : '';

// Kết nối đến cơ sở dữ liệu
require_once __DIR__ . '/../../../config/db.php';

if (!isset($conn) || !($conn instanceof mysqli)) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Không thể kết nối đến cơ sở dữ liệu"
    ]);
    exit;
}

// Thực hiện truy vấn để thêm dữ liệu vào bảng layout_benefit
$stmt = $conn->prepare("INSERT INTO layout_benefit (icon, title, description) VALUES (?, ?, ?)");
if ($stmt === false) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Lỗi chuẩn bị câu lệnh: " . $conn->error
    ]);
    exit;
}

$stmt->bind_param("sss", $icon, $title, $description);

if ($stmt->execute()) {
    echo json_encode([
        "ok" => true,
        "success" => true,
        "message" => "Thêm thành công."
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