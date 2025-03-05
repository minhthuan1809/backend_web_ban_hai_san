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
preg_match('/\/send_contacts\/(\d+)$/', $request_uri, $matches);
$id = isset($matches[1]) ? (int)$matches[1] : 0;

if ($id <= 0) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "ID không hợp lệ"
    ]);
    exit;
}

// Lấy token từ header Authorization
$headers = apache_request_headers();
$auth_header = isset($headers['Authorization']) ? $headers['Authorization'] : '';
$token = '';

if (preg_match('/Bearer\s+(.*)$/i', $auth_header, $matches)) {
    $token = $matches[1];
}

// Đọc API_KEY_TOKEN từ file .env
$env_content = file_get_contents(__DIR__ . '/../.env');
$api_key_token = '';
if (preg_match('/API_KEY_TOKEN=(.*)/', $env_content, $matches)) {
    $api_key_token = trim($matches[1]);
}

// Kiểm tra token
if ($token !== $api_key_token) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Xác thực không thành công"
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

// Thực hiện truy vấn để xóa dữ liệu
$stmt = $conn->prepare("DELETE FROM Contacts WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode([
            "ok" => true,
            "success" => true,
            "message" => "Liên hệ đã được xóa thành công."
        ]);
    } else {
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "Không tìm thấy liên hệ với ID đã cho."
        ]);
    }
} else {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Lỗi khi xóa liên hệ: " . $stmt->error
    ]);
}

$stmt->close();
$conn->close();
