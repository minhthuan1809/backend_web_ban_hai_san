<?php
// [POST] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/footer/social 
// {
//     "platform": "string",
//     "url": "string"
// }

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
    $insertSql = "INSERT INTO layout_social_media_links (platform, url, target) VALUES (?, ?, ?)";
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
        ]);
    } else {
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "đã tồn tại"
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
