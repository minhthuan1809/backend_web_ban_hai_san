<?php
// [PUT] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/footer/introduction 
//     {
//         "title": "string",
//         "description": "string"
//     }
header('Content-Type: application/json');

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

// Get the data from the request body
$data = json_decode(file_get_contents('php://input'), true);
if (json_last_error() !== JSON_ERROR_NONE || !isset($data['title'], $data['description'])) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Dữ liệu không hợp lệ"
    ]);
    exit;
}

// Update the single record
try {
    $updateSql = "UPDATE layout_introductionsfooter SET title = ?, description = ?, updated_at = NOW()";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("ss", $data['title'], $data['description']);
    
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
