<?php
// [DELETE] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/footer/social/1
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


// Get the ID from the request URI
$request_uri = $_SERVER['REQUEST_URI'];
$id = basename($request_uri);

// Validate the ID
if (!is_numeric($id)) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "ID không hợp lệ"
    ]);
    http_response_code(400); // Bad Request
    exit;
}

// Prepare the DELETE statement
try {
    $deleteSql = "DELETE FROM layout_social_media_links WHERE id = ?";
    $stmt = $conn->prepare($deleteSql);
    
    if ($stmt === false) {
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "Không thể chuẩn bị câu lệnh SQL"
        ]);
        exit;
    }

    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo json_encode([
            "ok" => true,
            "success" => true,
            "message" => "Xóa thành công"
        ]);
    } else {
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "Không thể xóa bản ghi"
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
