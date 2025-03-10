<?php
// [PUT] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/news/10
header('Content-Type: application/json');
require_once __DIR__ . '/../config/db.php'; // Đảm bảo đường dẫn đúng

if (!isset($conn) || !($conn instanceof mysqli)) {
    echo json_encode(["ok" => false, "success" => false, "message" => "Không thể kết nối đến cơ sở dữ liệu"]);
    exit;
}

try {
    // Lấy ID từ URL
    $request_uri = $_SERVER['REQUEST_URI'];
    preg_match('/\/news\/(\d+)$/', $request_uri, $matches);
    $id = isset($matches[1]) ? (int)$matches[1] : 0;
    
    if ($id <= 0) {
        throw new Exception("ID không hợp lệ");
    }

    // Lấy dữ liệu JSON từ request
    $data = json_decode(file_get_contents("php://input"), true);
    
    if (empty($data)) {
        throw new Exception("Dữ liệu gửi lên không được để trống");
    }

    // Xây dựng danh sách các cột cần cập nhật
    $fields = [];
    $values = [];
    
    if (isset($data['title']) && trim($data['title']) !== '') {
        $fields[] = "title = ?";
        $values[] = $data['title'];
    }
    if (isset($data['description']) && trim($data['description']) !== '') {
        $fields[] = "description = ?";
        $values[] = $data['description'];
    }
    if (isset($data['image_url']) && trim($data['image_url']) !== '') {
        $fields[] = "image_url = ?";
        $values[] = $data['image_url'];
    }
    if (isset($data['status']) && is_numeric($data['status'])) {
        $fields[] = "status = ?";
        $values[] = (int)$data['status'];
    }

    // Kiểm tra nếu không có trường nào được gửi về để cập nhật
    if (empty($fields)) {
        throw new Exception("Không có dữ liệu để cập nhật");
    }

    // Thêm ID vào cuối danh sách giá trị
    $values[] = $id;

    // Chuẩn bị câu lệnh SQL động
    $sql = "UPDATE news SET " . implode(", ", $fields) . " WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        throw new Exception("Lỗi chuẩn bị câu lệnh: " . $conn->error);
    }

    // Tạo kiểu dữ liệu phù hợp với số lượng tham số
    $types = str_repeat("s", count($values) - 1) . "i"; // Tất cả đều là string trừ ID (integer)
    $stmt->bind_param($types, ...$values);

    // Thực thi truy vấn
    if ($stmt->execute()) {
        if ($stmt->affected_rows === 0) {
            throw new Exception("Không tìm thấy bài viết hoặc không có thay đổi");
        }
        echo json_encode(["ok" => true, "success" => true, "message" => "Cập nhật tin tức thành công"]);
    } else {
        throw new Exception("Lỗi khi cập nhật tin tức: " . $stmt->error);
    }
} catch (Exception $e) {
    echo json_encode(["ok" => false, "success" => false, "message" => "Lỗi: " . $e->getMessage()]);
} finally {
    if (isset($stmt) && $stmt !== false) {
        $stmt->close();
    }
    if (isset($conn) && $conn instanceof mysqli) {
        $conn->close();
    }
}
