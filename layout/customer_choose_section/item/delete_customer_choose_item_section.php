<?php
// [DELETE] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/customer_choose_section/item/1
header('Content-Type: application/json');

// Kiểm tra phương thức request
if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
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

    // Chuẩn bị câu lệnh SQL để xóa
    $sql = "DELETE FROM layout_customer_choose_item_section WHERE id = ?";
    
    // Chuẩn bị và thực thi câu lệnh
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $result = $stmt->execute();

    if (!$result) {
        throw new Exception("Lỗi khi xóa: " . $stmt->error);
    }

    if ($stmt->affected_rows === 0) {
        throw new Exception("Không tìm thấy mục để xóa");
    }

    echo json_encode([
        "ok" => true,
        "success" => true,
        "message" => "Xóa thành công"
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
