<?php
// [GET] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/hero_section
header('Content-Type: application/json');



// Kết nối database
require_once __DIR__ . '/../../config/db.php';

if (!isset($conn) || !($conn instanceof mysqli)) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Không thể kết nối đến cơ sở dữ liệu"
    ]);
    exit;
}

try {
    // Truy vấn dữ liệu từ bảng slide_header
    $sql = "SELECT * FROM layout_slide_header";
    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception("Lỗi truy vấn: " . $conn->error);
    }

    $slides = [];
    while ($row = $result->fetch_assoc()) {
        $slides[] = [
            "id" => $row['id'],
            "image_url" => $row['image_url'],
            "title" => $row['title'], 
            "description" => $row['description']    
        ];
    }

    echo json_encode([
        "ok" => true,
        "success" => true,
        "data" => $slides
    ]);

} catch (Exception $e) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => $e->getMessage()
    ]);
}

$conn->close();
?>
