<?php
// [PUT] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/hero_section/1 
// {
//     "image_url": "string",
//     "title": "string",
//     "description": "string"
// }
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
    // Lấy ID từ URL
    $url_parts = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
    $id = end($url_parts);

    if (!is_numeric($id)) {
        throw new Exception("ID không hợp lệ");
    }

    // Kiểm tra xem bản ghi có tồn tại không
    $check_sql = "SELECT id FROM layout_slide_header WHERE id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("i", $id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows === 0) {
        throw new Exception("Không tìm thấy bản ghi với ID = " . $id);
    }

    // Lấy dữ liệu từ request
    $data = json_decode(file_get_contents("php://input"), true);

    if (empty($data)) {
        throw new Exception("Không có dữ liệu được gửi");
    }

    // Chuẩn bị câu lệnh SQL
    $sql = "UPDATE layout_slide_header SET ";
    $params = [];
    $types = "";

    if (isset($data['image_url'])) {
        $sql .= "image_url = ?, ";
        $params[] = $data['image_url'];
        $types .= "s";
    }

    if (isset($data['title'])) {
        $sql .= "title = ?, ";
        $params[] = $data['title'];
        $types .= "s";
    }

    if (isset($data['description'])) {
        $sql .= "description = ?, ";
        $params[] = $data['description'];
        $types .= "s";
    }

    // Xóa dấu phẩy cuối cùng và thêm điều kiện WHERE
    $sql = rtrim($sql, ", ") . " WHERE id = ?";
    $params[] = $id;
    $types .= "i";

    // Chuẩn bị và thực thi câu lệnh
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $result = $stmt->execute();

    if (!$result) {
        throw new Exception("Lỗi khi cập nhật: " . $stmt->error);
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
