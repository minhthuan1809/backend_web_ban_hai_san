<?php
// [PUT] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/user/10
require_once __DIR__ . '/../config/db.php'; // Sửa đường dẫn để đảm bảo đúng vị trí file

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
    $id = basename($_SERVER['REQUEST_URI']);
    
    // Kiểm tra ID có tồn tại không
    if (empty($id)) {
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "Trường ID không tồn tại"
        ]);
        exit;
    }

    // Lấy dữ liệu từ request
    $data = json_decode(file_get_contents("php://input"), true);

    // Kiểm tra dữ liệu có trống không
    if (empty($data)) {
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "Dữ liệu gửi lên không được để trống"
        ]);
        exit;
    }

    // Xây dựng câu lệnh SQL động dựa trên dữ liệu được gửi lên
    $updateFields = [];
    $types = '';
    $params = [];

    if (isset($data['fullName']) && !empty($data['fullName'])) {
        $updateFields[] = "fullName = ?";
        $types .= 's';
        $params[] = $data['fullName'];
    }

    if (isset($data['email']) && !empty($data['email'])) {
        $updateFields[] = "email = ?";
        $types .= 's';
        $params[] = $data['email'];
    }

    if (isset($data['password']) && !empty($data['password'])) {
        $updateFields[] = "password = ?";
        $types .= 's';
        $params[] = password_hash($data['password'], PASSWORD_DEFAULT);
    }

    if (isset($data['avatar']) && !empty($data['avatar'])) {
        $updateFields[] = "avatar = ?";
        $types .= 's';
        $params[] = $data['avatar'];
    }

    if (isset($data['roleId'])) {
        $updateFields[] = "role_id = ?";
        $types .= 'i';
        $params[] = $data['roleId'];
    }

    if (isset($data['status'])) {
        $updateFields[] = "status = ?";
        $types .= 'i';
        $params[] = $data['status'];
    }

    if (empty($updateFields)) {
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "Không có dữ liệu nào được cập nhật"
        ]);
        exit;
    }

    // Thêm tham số ID vào cuối
    $types .= 'i';
    $params[] = $id;

    // Tạo câu lệnh SQL
    $sql = "UPDATE user SET " . implode(", ", $updateFields) . " WHERE id = ?";
    
    // Chuẩn bị và thực thi câu lệnh
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        throw new Exception("Lỗi chuẩn bị câu lệnh: " . $conn->error);
    }

    // Bind các tham số động
    $stmt->bind_param($types, ...$params);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows === 0) {
            echo json_encode([
                "ok" => false,
                "success" => false,
                "message" => "Đã có lỗi xảy ra, người dùng không tồn tại hoặc không có thay đổi"
            ]);
        } else {
            echo json_encode([
                "ok" => true,
                "success" => true,
                "message" => "Cập nhật người dùng thành công"
            ]);
        }
    } else {
        throw new Exception("Lỗi khi cập nhật người dùng: " . $stmt->error);
    }

} catch (Exception $e) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Lỗi: " . $e->getMessage()
    ]);
} finally {
    if (isset($stmt) && $stmt !== false) {
        $stmt->close();
    }
    if (isset($conn) && $conn instanceof mysqli) {
        $conn->close();
    }
}
?>
