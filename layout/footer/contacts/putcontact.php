<?php
// [PUT] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/footer/contacts/1 
// {
//     "icon": "string",
//     "type": "string"
// }

header('Content-Type: application/json');

// Check request method
if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Phương thức " . $_SERVER['REQUEST_METHOD'] . " không được hỗ trợ"
    ]);
    exit;
}

// Use absolute path to require the database configuration file
require_once __DIR__ . '/../../../config/db.php';

if (!isset($conn) || !($conn instanceof mysqli)) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Không thể kết nối đến cơ sở dữ liệu" 
    ]);
    exit;
}

// Get token from Authorization header
$headers = apache_request_headers();
$auth_header = isset($headers['Authorization']) ? $headers['Authorization'] : '';
$token = '';

if (preg_match('/Bearer\s+(.*)$/i', $auth_header, $matches)) {
    $token = $matches[1];
}

// Read API_KEY_TOKEN from .env file
$env_content = file_get_contents(__DIR__ . '/../../../.env');
$api_key_token = '';
if (preg_match('/API_KEY_TOKEN=(.*)/', $env_content, $matches)) {
    $api_key_token = trim($matches[1]);
}

// Check token
if ($token !== $api_key_token) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "xác thực thất bại"
    ]);
    exit;
}

// Get id from URL
$id = basename($_SERVER['REQUEST_URI']); // Get the last segment of the URL

if (!is_numeric($id) || intval($id) <= 0) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "ID không hợp lệ"
    ]);
    exit;
}

// Get the data from the request body
$data = json_decode(file_get_contents('php://input'), true);
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Dữ liệu không hợp lệ"
    ]);
    exit;
}

// Update record by id
try {
    $updateSql = "UPDATE layout_contactsfooter SET icon = ?, type = ?, updated_at = NOW() WHERE id = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("ssi", $data['icon'], $data['type'], $id);
    
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
            "message" => "Không thể cập nhật bản ghi"
        ]);
    }

    $stmt->close();
} catch (Exception $e) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => $e->getMessage()
    ]);
}

$conn->close();