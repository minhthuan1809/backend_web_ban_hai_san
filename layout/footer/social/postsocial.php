<?php
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
if (json_last_error() !== JSON_ERROR_NONE || !isset($data['platform']) || !isset($data['url'])) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Dữ liệu không hợp lệ"
    ]);
    exit;
}

// Set default target if not provided
$target = isset($data['target']) ? $data['target'] : '_self';

// Insert new social media link
try {
    $insertSql = "INSERT INTO social_media_links (platform, url, target) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insertSql);
    
    if ($stmt === false) {
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "Không thể chuẩn bị câu lệnh SQL"
        ]);
        exit;
    }

    $stmt->bind_param("sss", $data['platform'], $data['url'], $target);
    
    if ($stmt->execute()) {
        echo json_encode([
            "ok" => true,
            "success" => true,
            "message" => "Thêm mới thành công",
            "id" => $conn->insert_id
        ]);
    } else {
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "Không thể thêm bản ghi"
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
