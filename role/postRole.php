<?php
// [POST] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/role
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

    // Kiểm tra xem tên vai trò đã tồn tại chưa
    $role_name = $conn->real_escape_string($data['name']);
    $check_sql = "SELECT id FROM role WHERE name = '$role_name'";
    $check_result = $conn->query($check_sql);
    
    if ($check_result->num_rows > 0) {
        throw new Exception("Vai trò với tên '$role_name' đã tồn tại");
    }

    // Thêm role mới
    $sql = "INSERT INTO role (name) VALUES ('$role_name')";
    
    if (!$conn->query($sql)) {
        throw new Exception("Lỗi khi thêm vai trò: " . $conn->error);
    }
    
    $role_id = $conn->insert_id;

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

    // Thêm các quyền cho role
    foreach ($data['permissions'] as $permission_id => $value) {
        // Kiểm tra nếu quyền được đánh dấu là true và tồn tại trong permission_map
        if ($value === true && isset($permission_map[$permission_id])) {
            $permission_number = $permission_map[$permission_id];
            
            // Kiểm tra xem quyền đã tồn tại chưa
            $check_perm_sql = "SELECT * FROM role_permission WHERE role_id = $role_id AND permission_id = $permission_number";
            $check_perm_result = $conn->query($check_perm_sql);
            
            if ($check_perm_result->num_rows == 0) {
                $values[] = "($role_id, $permission_number)";
                $inserted_permission_names[] = $permission_id;
            }
        }
    }

    if (!empty($values)) {
        // Thực hiện INSERT nhiều dòng cùng lúc
        $values_str = implode(", ", $values);
        $sql = "INSERT INTO role_permission (role_id, permission_id) VALUES $values_str";
        
        if (!$conn->query($sql)) {
            throw new Exception("Lỗi khi thêm quyền: " . $conn->error);
        }
    } else {
        throw new Exception("Không có quyền hợp lệ nào được chọn hoặc các quyền đã tồn tại");
    }

    // Commit transaction
    $conn->commit();

    // Chuẩn bị dữ liệu trả về theo đúng cấu trúc ban đầu
    $return_permissions = [];
    foreach ($permission_map as $perm_name => $perm_id) {
        $return_permissions[$perm_name] = in_array($perm_name, $inserted_permission_names);
    }

    echo json_encode([
        "ok" => true,
        "success" => true,
        "message" => "Thêm vai trò thành công",
    
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