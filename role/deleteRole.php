<?php
// [DELETE] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/role/{id}
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
    // Lấy ID role từ URL
    $url_components = parse_url($_SERVER['REQUEST_URI']);
    $path_parts = explode('/', trim($url_components['path'], '/'));
    $role_id = end($path_parts);

    if (!is_numeric($role_id)) {
        throw new Exception("ID vai trò không hợp lệ");
    }

    // Bắt đầu transaction
    $conn->begin_transaction();

    // Kiểm tra xem role có tồn tại không và lấy thông tin role
    $role_id = $conn->real_escape_string($role_id);
    $check_sql = "SELECT id, name FROM role WHERE id = '$role_id'";
    $check_result = $conn->query($check_sql);
    
    if ($check_result->num_rows === 0) {
        throw new Exception("Không tìm thấy vai trò với ID: $role_id");
    }

    $role_data = $check_result->fetch_assoc();
    
    // Kiểm tra nếu là role user hoặc super_admin
    if ($role_data['name'] === 'user' || $role_data['name'] === 'super_admin') {
        throw new Exception("Không thể xóa vai trò này vì đây là vai trò hệ thống");
    }

    // Xóa role (các bản ghi trong role_permission sẽ tự động bị xóa do ràng buộc ON DELETE CASCADE)
    $sql = "DELETE FROM role WHERE id = '$role_id'";
    
    if (!$conn->query($sql)) {
        throw new Exception("Lỗi khi xóa vai trò: " . $conn->error);
    }

    // Commit transaction
    $conn->commit();

    echo json_encode([
        "ok" => true,
        "success" => true,
        "message" => "Xóa vai trò thành công"
    ]);

} catch (Exception $e) {
    // Rollback nếu có lỗi
    if (isset($conn)) {
        $conn->rollback();
    }
    
    http_response_code(400);
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => $e->getMessage()
    ]);
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
?>
