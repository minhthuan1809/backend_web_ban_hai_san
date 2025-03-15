<?php
require_once __DIR__ . '/../config/TokenUtils.php';
require_once __DIR__ . '/../config/db.php';

if (!isset($conn) || !($conn instanceof mysqli)) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Không thể kết nối đến cơ sở dữ liệu"
    ]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Phương thức không hợp lệ, vui lòng sử dụng DELETE"
    ]);
    exit;
}

// Kiểm tra token xác thực
$headers = getallheaders();
if (!isset($headers['Authorization'])) {
    http_response_code(401);
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "lỗi xác thực"
    ]);
    exit;
}

$token = str_replace('Bearer ', '', $headers['Authorization']);

try {
    // Xác thực token
    $userId = TokenUtils::validateTokenAndGetUserId($token);
    if (!$userId) {
        throw new Exception("Token không hợp lệ");
    }
} catch (Exception $e) {
    http_response_code(401); 
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => $e->getMessage()
    ]);
    exit;
}

// Lấy ID từ URL
$request_uri = $_SERVER['REQUEST_URI'];
preg_match('/\/address\/(\d+)$/', $request_uri, $matches);
$id = isset($matches[1]) ? (int)$matches[1] : 0;

if ($id <= 0) {
    echo json_encode([
        "ok" => false,
        "message" => "ID không hợp lệ"
    ]);
    exit;
}

// Thực hiện truy vấn để xóa địa chỉ
$stmt = $conn->prepare("DELETE FROM address WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode([
            "ok" => true,
            "success" => true,
            "message" => "Địa chỉ đã được xóa thành công."
        ]);
    } else {
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "Không tìm thấy địa chỉ với ID đã cho."
        ]);
    }
} else {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Lỗi khi xóa địa chỉ: " . $stmt->error
    ]);
}

$stmt->close();
$conn->close();
