<?php
// [PUT] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/contact/1
// Kết nối đến cơ sở dữ liệu
require_once __DIR__ . '/../config/db.php';

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
        "message" => "Lỗi xác thực"
    ]);
    exit;
}

// Lấy id từ URL
$request_uri = $_SERVER['REQUEST_URI'];
preg_match('/\/send_contacts\/(read|sent)\/(\d+)/', $request_uri, $matches);
$action = isset($matches[1]) ? $matches[1] : '';
$id = isset($matches[2]) ? (int)$matches[2] : null;

// Kiểm tra id hợp lệ
if ($id <= 0) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "ID không hợp lệ"
    ]);
    exit;
}

// Cập nhật trạng thái dựa trên action
if ($action === 'read') {
    $is_read = 1;
    $sql = "UPDATE Contacts SET is_read = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $is_read, $id);
} else if ($action === 'sent') {
    $is_sent = 1;
    $sql = "UPDATE Contacts SET is_sent = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $is_sent, $id);
} else {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Hành động không hợp lệ"
    ]);
    exit;
}

if ($stmt->execute()) {
    echo json_encode([
        "ok" => true,
        "success" => true,
        "message" => "Cập nhật thành công"
    ]);
} else {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Lỗi cập nhật: " . $stmt->error
    ]);
}

$stmt->close();
$conn->close();
?>
