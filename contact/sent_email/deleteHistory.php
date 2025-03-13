<?php
if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Phương thức không hợp lệ, vui lòng sử dụng DELETE"
    ]);
    exit;
}

// Lấy ID từ URL
$request_uri = $_SERVER['REQUEST_URI'];
preg_match('/\/send_contacts\/history\/(\d+)$/', $request_uri, $matches);
$id = isset($matches[1]) ? (int)$matches[1] : 0;

if ($id <= 0) {
    echo json_encode([
        "ok" => false,
        "message" => "ID không hợp lệ"
    ]);
    exit;
}


// Kết nối đến cơ sở dữ liệu
require_once __DIR__ . '/../../config/db.php';

if (!isset($conn) || !($conn instanceof mysqli)) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Không thể kết nối đến cơ sở dữ liệu"
    ]);
    exit;
}

// Thực hiện truy vấn để xóa dữ liệu
$stmt = $conn->prepare("DELETE FROM email_history WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode([
            "ok" => true,
            "success" => true,
            "message" => "Lịch sử email đã được xóa thành công."
        ]);
    } else {
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "Không tìm thấy lịch sử email với ID đã cho."
        ]);
    }
} else {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Lỗi khi xóa lịch sử email: " . $stmt->error
    ]);
}

$stmt->close();
$conn->close();
