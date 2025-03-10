<?php
// [PUT] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/logo
require_once __DIR__ . '/../core/middleware/PermissionMiddleware.php';
require_once __DIR__ . '/../config/TokenUtils.php';

header('Content-Type: application/json');

try {
    // Lấy user_id từ token
    $userId = TokenUtils::validateTokenAndGetUserId();

    // Khởi tạo permission middleware
    $permissionMiddleware = new PermissionMiddleware();

    // Kiểm tra quyền truy cập
    $permissionMiddleware->authorize($userId, 'put_nav_logo');

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
    require_once __DIR__ . '/../config/db.php';

    if (!isset($conn) || !($conn instanceof mysqli)) {
        throw new Exception("Không thể kết nối đến cơ sở dữ liệu");
    }

    // Tạo bảng website_brand nếu chưa tồn tại
    $create_table_sql = "CREATE TABLE IF NOT EXISTS layout_website_brand (
        id INT AUTO_INCREMENT PRIMARY KEY,
        brand_name VARCHAR(100) NOT NULL,
        logo_url LONGTEXT NOT NULL,
        alt_text VARCHAR(100)
    )";
    
    if (!$conn->query($create_table_sql)) {
        throw new Exception("Lỗi tạo bảng: " . $conn->error);
    }

    // Kiểm tra xem đã có dữ liệu trong bảng chưa
    $check_sql = "SELECT COUNT(*) as count FROM layout_website_brand";
    $result = $conn->query($check_sql);
    $row = $result->fetch_assoc();
    
    if ($row['count'] == 0) {
        // Nếu bảng trống, thêm dữ liệu mặc định
        $insert_sql = "INSERT INTO layout_website_brand (brand_name, logo_url, alt_text) VALUES ('', '', '')";
        if (!$conn->query($insert_sql)) {
            throw new Exception("Lỗi thêm dữ liệu mặc định: " . $conn->error);
        }
    }

    // Lấy dữ liệu từ request body
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['logo_url']) || !isset($data['brand_name']) || !isset($data['alt_text'])) {
        throw new Exception("Thiếu thông tin cần thiết");
    }

    // Cập nhật dữ liệu
    $sql = "UPDATE layout_website_brand SET brand_name = ?, logo_url = ?, alt_text = ? WHERE id = 1";
    
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        throw new Exception("Lỗi chuẩn bị câu lệnh: " . $conn->error);
    }

    $stmt->bind_param("sss", $data['brand_name'], $data['logo_url'], $data['alt_text']);
    
    if ($stmt->execute()) {
        echo json_encode([
            "ok" => true,
            "success" => true,
            "message" => "Cập nhật thương hiệu thành công"
        ]);
    } else {
        throw new Exception("Lỗi khi cập nhật thương hiệu: " . $stmt->error);
    }

} catch (Exception $e) {
    http_response_code(401);
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => $e->getMessage()
    ]);
    exit;
} finally {
    if (isset($stmt) && $stmt !== false) {
        $stmt->close();
    }
    if (isset($conn) && $conn instanceof mysqli) {
        $conn->close();
    }
}
?>
