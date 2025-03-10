<?php
header('Content-Type: application/json');
// [DELETE] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/users/{id}

// Sửa đường dẫn để phù hợp với cấu trúc thư mục
require_once __DIR__ . '/../config/db.php';

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
    $request_uri = $_SERVER['REQUEST_URI'];
    preg_match('/\/users\/(\d+)$/', $request_uri, $matches);
    $id = isset($matches[1]) ? (int)$matches[1] : 0;

    if ($id <= 0) {
        throw new Exception("ID không hợp lệ");
    }

    // Kiểm tra xem người dùng có tồn tại không
    $check_sql = "SELECT id FROM user WHERE id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("i", $id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows === 0) {
        throw new Exception("Không tìm thấy người dùng với ID đã cho");
    }

    // Xóa bản ghi từ bảng user theo ID
    $sql = "DELETE FROM user WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute() === false) {
        throw new Exception("Lỗi truy vấn: " . $stmt->error);
    }

    echo json_encode([
        "ok" => true,
        "success" => true,
        "message" => "Người dùng đã được xóa thành công"
    ]);

} catch (Exception $e) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => $e->getMessage()
    ]);
} finally {
    if (isset($check_stmt)) {
        $check_stmt->close();
    }
    if (isset($stmt)) {
        $stmt->close(); 
    }
    if (isset($conn)) {
        $conn->close();
    }
}
?>