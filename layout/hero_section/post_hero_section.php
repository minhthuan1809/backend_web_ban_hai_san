<?php
// [POST] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/hero_section 
// {
//     "image_url": "string",
//     "title": "string",
//     "description": "string"
// }
header('Content-Type: application/json');

// Kiểm tra phương thức request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Phương thức " . $_SERVER['REQUEST_METHOD'] . " không được hỗ trợ"
    ]);
    exit;
}

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
    // Lấy dữ liệu từ request
    $data = json_decode(file_get_contents("php://input"), true);

    // Kiểm tra dữ liệu bắt buộc
    if (empty($data['image_url']) || empty($data['title']) || empty($data['description'])) {
        throw new Exception("Thiếu thông tin bắt buộc");
    }

    // Chuẩn bị câu lệnh SQL
    $sql = "INSERT INTO layout_slide_header (image_url, title, description) VALUES (?, ?, ?)";
    
    // Chuẩn bị và thực thi câu lệnh
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $data['image_url'], $data['title'], $data['description']);
    $result = $stmt->execute();

    if (!$result) {
        throw new Exception("Lỗi khi thêm mới: " . $stmt->error);
    }

    echo json_encode([
        "ok" => true,
        "success" => true,
        "message" => "Thêm mới thành công"
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
