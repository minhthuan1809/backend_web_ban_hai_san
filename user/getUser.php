<?php
// [GET] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/users
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
    $total_sql = "SELECT COUNT(*) as total FROM user WHERE fullName LIKE '%$search%' OR email LIKE '%$search%'";
    $total_result = $conn->query($total_sql);
    if ($total_result === false) {
        throw new Exception("Lỗi truy vấn: " . $conn->error);
    }
    $total_row = $total_result->fetch_assoc();
    $total_records = $total_row['total'];
    $total_pages = ceil($total_records / $limit);

    // Lấy bản ghi từ bảng user với phân trang và điều kiện tìm kiếm
    $sql = "SELECT u.id, u.fullName, u.email, u.avatar, u.role_id, r.name as role_name, u.status, u.created_at, u.updated_at 
            FROM user u
            LEFT JOIN role r ON u.role_id = r.id
            WHERE u.fullName LIKE '%$search%' OR u.email LIKE '%$search%' 
            ORDER BY u.created_at DESC LIMIT $limit OFFSET $offset";
    $result = $conn->query($sql);

    if ($result === false) {
        throw new Exception("Lỗi truy vấn: " . $conn->error);
    }

    $users = [];
    while ($row = $result->fetch_assoc()) {
        // Lấy địa chỉ của người dùng
        $address_sql = "SELECT id, name, address, phone FROM address WHERE user_id = " . $row['id'];
        $address_result = $conn->query($address_sql);
        
        $addresses = [];
        if ($address_result && $address_result->num_rows > 0) {
            while ($address_row = $address_result->fetch_assoc()) {
                $addresses[] = [
                    "id" => $address_row['id'],
                    "name" => $address_row['name'],
                    "address" => $address_row['address'],
                    "phone" => $address_row['phone']
                ];
            }
        }
        
        $users[] = [
            "id" => $row['id'],
            "fullName" => $row['fullName'], 
            "email" => $row['email'],
            "avatar" => $row['avatar'],
            "roleId" => $row['role_id'],
            "level" => $row['role_name'],
            "status" => $row['status'] == 1 ? true : false,
            "created_at" => $row['created_at'],
            "updated_at" => $row['updated_at'],
            "addresses" => $addresses
        ];
        if (isset($address_result)) {
            $address_result->close();
        }
    }

    echo json_encode([
        "ok" => true,
        "success" => true,
        "data" => $users,
        "total_pages" => $total_pages
    ]);

} catch (Exception $e) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => $e->getMessage()
    ]);
} finally {
    if (isset($result)) {
        $result->close();
    }
    if (isset($conn)) {
        $conn->close();
    }
}
?>
