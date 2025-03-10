<?php
// [PUT] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/customer_choose_section/item/5
header('Content-Type: application/json');

// Kiểm tra phương thức request
if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Phương thức " . $_SERVER['REQUEST_METHOD'] . " không được hỗ trợ"
    ]);
    exit;
}

require_once __DIR__ . '/../../../config/db.php';

if (!isset($conn) || !($conn instanceof mysqli)) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Không thể kết nối đến cơ sở dữ liệu"
    ]);
    exit;
}

try {
    // Lấy ID từ URL
    $url_parts = explode('/', rtrim($_SERVER['REQUEST_URI'], '/'));
    $id = end($url_parts);

    if (!$id || !is_numeric($id)) {
        throw new Exception("ID không hợp lệ");
    }

    // Lấy dữ liệu từ body request
    $data = json_decode(file_get_contents('php://input'), true);

    // Kiểm tra dữ liệu bắt buộc
    if (!isset($data['icon']) || !isset($data['title']) || !isset($data['description'])) {
        throw new Exception("Thiếu thông tin bắt buộc");
    }

    // Chuẩn bị câu lệnh SQL để cập nhật
    $sql = "UPDATE layout_customer_choose_item_section SET icon = ?, title = ?, description = ? WHERE id = ?";
    
    // Chuẩn bị và thực thi câu lệnh
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $data['icon'], $data['title'], $data['description'], $id);
    $result = $stmt->execute();

    if (!$result) {
        throw new Exception("Lỗi khi cập nhật: " . $stmt->error);
    }

    if ($stmt->affected_rows === 0) {
        throw new Exception("Bạn Không có thay đổi gì");
    }

    echo json_encode([
        "ok" => true,
        "success" => true,
        "message" => "Cập nhật thành công"
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
