<?php
// [PUT] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/nav
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
    // Lấy ID từ URL path
    $url_parts = explode('/', rtrim($_SERVER['REQUEST_URI'], '/'));
    $id = end($url_parts);

    if (!$id || !is_numeric($id)) {
        throw new Exception("ID không hợp lệ");
    }

    // Lấy dữ liệu từ request
    $data = json_decode(file_get_contents("php://input"), true);

    if (empty($data)) {
        throw new Exception("Không có dữ liệu được gửi");
    }

    // Chuẩn bị câu lệnh SQL
    $sql = "UPDATE layout_navigation_menu SET ";
    $params = [];
    $types = "";
    
    // Xây dựng câu lệnh SQL động dựa trên dữ liệu được gửi
    if (isset($data['name'])) {
        $sql .= "name = ?, ";
        $params[] = $data['name'];
        $types .= "s";
    }
    if (isset($data['url'])) {
        $sql .= "url = ?, ";
        $params[] = $data['url'];
        $types .= "s";
    }
    if (isset($data['order_position'])) {
        $sql .= "order_position = ?, ";
        $params[] = $data['order_position'];
        $types .= "i";
    }

    // Kiểm tra xem có trường nào được cập nhật không
    if (empty($params)) {
        throw new Exception("Không có trường nào được cập nhật");
    }
    
    // Xóa dấu phẩy và khoảng trắng cuối cùng
    $sql = rtrim($sql, ", ");
    
    $sql .= " WHERE id = ?";
    $types .= "i";
    $params[] = $id;

    // Thực thi câu lệnh
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        throw new Exception("Lỗi chuẩn bị câu lệnh: " . $conn->error);
    }

    $stmt->bind_param($types, ...$params);
    
    if (!$stmt->execute()) {
        throw new Exception("Lỗi thực thi câu lệnh: " . $stmt->error);
    }

    if ($stmt->affected_rows > 0) {
        echo json_encode([
            "ok" => true,
            "success" => true,
            "message" => "Cập nhật menu thành công"
        ]);
    } else {
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "Bạn không có thay đổi gì"
        ]);
    }

} catch (Exception $e) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => $e->getMessage()
    ]);
} finally {
    if (isset($stmt)) {
        $stmt->close();
    }
    if (isset($conn)) {
        $conn->close();
    }
}
?>
