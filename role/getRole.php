<?php
// [GET] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/role
header('Content-Type: application/json');

// Kiểm tra phương thức request
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Phương thức " . $_SERVER['REQUEST_METHOD'] . " không được hỗ trợ"
    ]);
    exit;
}

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
    // Lấy tham số page, limit và search từ URL
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 6;
    $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
    $offset = ($page - 1) * $limit;

    // Lấy tổng số bản ghi với điều kiện tìm kiếm
    $total_sql = "SELECT COUNT(DISTINCT r.id) as total 
                  FROM role r 
                  WHERE r.name LIKE '%$search%'";
    $total_result = $conn->query($total_sql);
    if ($total_result === false) {
        throw new Exception("Lỗi truy vấn: " . $conn->error);
    }
    $total_row = $total_result->fetch_assoc();
    $total_records = $total_row['total'];
    $total_pages = ceil($total_records / $limit);

    // Lấy danh sách tất cả các quyền từ bảng permission
    $permissions_sql = "SELECT name FROM permission";
    $permissions_result = $conn->query($permissions_sql);
    $all_permissions = [];
    while($permission = $permissions_result->fetch_assoc()) {
        $all_permissions[] = $permission['name'];
    }

    // Lấy bản ghi từ bảng role với phân trang và điều kiện tìm kiếm
    $sql = "SELECT r.id, r.name, GROUP_CONCAT(p.name) as permissions 
            FROM role r
            LEFT JOIN role_permission rp ON r.id = rp.role_id
            LEFT JOIN permission p ON rp.permission_id = p.id
            WHERE r.name LIKE '%$search%'
            GROUP BY r.id
            ORDER BY r.id DESC 
            LIMIT $limit OFFSET $offset";
    $result = $conn->query($sql);

    if ($result === false) {
        throw new Exception("Lỗi truy vấn: " . $conn->error);
    }

    $roles = [];
    while ($row = $result->fetch_assoc()) {
        $role_permissions = $row['permissions'] ? explode(',', $row['permissions']) : [];
        
        // Tạo mảng quyền với true/false
        $permission_status = [];
        foreach ($all_permissions as $permission) {
            $permission_status[$permission] = in_array($permission, $role_permissions);
        }

        $roles[] = [
            "id" => $row['id'],
            "name" => $row['name'],
            "permissions" => $permission_status,
            // "created_at" => $row['created_at'],
            // "updated_at" => $row['updated_at']
        ];
    }

    echo json_encode([
        "ok" => true,
        "success" => true,
        "data" => $roles,
        "total_pages" => $total_pages
    ]);

} catch (Exception $e) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => $e->getMessage()
    ]);
} finally {
    if (isset($permissions_result)) {
        $permissions_result->close();
    }
    if (isset($result)) {
        $result->close();
    }
    if (isset($conn)) {
        $conn->close();
    }
}
?>
