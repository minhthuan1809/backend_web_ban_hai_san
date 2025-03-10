<?php
// [PUT] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/role/{id}
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

    // Lấy dữ liệu từ body request
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['name']) || empty($data['name'])) {
        throw new Exception("Tên vai trò không được để trống");
    }

    if (!isset($data['permissions']) || empty($data['permissions'])) {
        throw new Exception("Danh sách quyền không được để trống");
    }

    // Bắt đầu transaction
    $conn->begin_transaction();

    // Kiểm tra xem role có tồn tại không
    $role_id = $conn->real_escape_string($role_id);
    $check_sql = "SELECT name FROM role WHERE id = '$role_id'";
    $check_result = $conn->query($check_sql);
    
    if ($check_result->num_rows === 0) {
        throw new Exception("Không tìm thấy vai trò với ID: $role_id");
    }

    $role_data = $check_result->fetch_assoc();
    if ($role_data['name'] === 'user' || $role_data['name'] === 'super_admin') {
        throw new Exception("Không thể chỉnh sửa vai trò hệ thống");
    }

    // Kiểm tra xem tên mới đã tồn tại chưa (trừ tên hiện tại)
    $role_name = $conn->real_escape_string($data['name']);
    $check_name_sql = "SELECT id FROM role WHERE name = '$role_name' AND id != '$role_id'";
    $check_name_result = $conn->query($check_name_sql);
    
    if ($check_name_result->num_rows > 0) {
        throw new Exception("Vai trò với tên '$role_name' đã tồn tại");
    }

    // Cập nhật tên role
    $update_sql = "UPDATE role SET name = '$role_name' WHERE id = '$role_id'";
    if (!$conn->query($update_sql)) {
        throw new Exception("Lỗi khi cập nhật tên vai trò: " . $conn->error);
    }

    // Xóa tất cả quyền hiện tại của role
    $delete_perms_sql = "DELETE FROM role_permission WHERE role_id = '$role_id'";
    if (!$conn->query($delete_perms_sql)) {
        throw new Exception("Lỗi khi xóa quyền cũ: " . $conn->error);
    }

    // Lấy danh sách quyền từ bảng permission
    $sql = "SELECT id, name FROM permission";
    $result = $conn->query($sql);
    
    if (!$result) {
        throw new Exception("Lỗi khi lấy danh sách quyền: " . $conn->error);
    }

    $permission_map = [];
    while ($row = $result->fetch_assoc()) {
        $permission_map[$row['name']] = $row['id'];
    }

    // Chuẩn bị câu lệnh INSERT nhiều dòng
    $values = [];
    $inserted_permission_names = [];

    // Thêm các quyền mới cho role
    foreach ($data['permissions'] as $permission_id => $value) {
        if ($value === true && isset($permission_map[$permission_id])) {
            $permission_number = $permission_map[$permission_id];
            $values[] = "($role_id, $permission_number)";
            $inserted_permission_names[] = $permission_id;
        }
    }

    if (!empty($values)) {
        $values_str = implode(", ", $values);
        $sql = "INSERT INTO role_permission (role_id, permission_id) VALUES $values_str";
        
        if (!$conn->query($sql)) {
            throw new Exception("Lỗi khi thêm quyền mới: " . $conn->error);
        }
    } else {
        throw new Exception("Không có quyền hợp lệ nào được chọn");
    }

    // Commit transaction
    $conn->commit();

    // Chuẩn bị dữ liệu trả về
    $return_permissions = [];
    foreach ($permission_map as $perm_name => $perm_id) {
        $return_permissions[$perm_name] = in_array($perm_name, $inserted_permission_names);
    }

    echo json_encode([
        "ok" => true,
        "success" => true,
        "message" => "Cập nhật vai trò thành công"
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