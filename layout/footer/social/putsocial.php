<?php
// [PUT] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/footer/social/1 
//     {
//         "platform": "string",
//         "url": "string"
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


// Get the ID from the request URI
$request_uri = $_SERVER['REQUEST_URI'];
$id = basename($request_uri);

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

// Update existing social media link
try {
    $updateSql = "UPDATE layout_social_media_links SET platform = ?, url = ?, target = ? WHERE id = ?";
    $stmt = $conn->prepare($updateSql);
    
    if ($stmt === false) {
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "Không thể chuẩn bị câu lệnh SQL"
        ]);
        exit;
    }

    $stmt->bind_param("sssi", $data['platform'], $data['url'], $target, $id);
    
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
?>
