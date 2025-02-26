<?php
// [GET] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/contacts
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

// Sử dụng đường dẫn tuyệt đối để require file cấu hình database
require_once __DIR__ . '/../../../config/db.php';

if (!isset($conn) || !($conn instanceof mysqli)) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Không thể kết nối đến cơ sở dữ liệu"
    ]);
    exit;
}

try {
    // Lấy tất cả bản ghi từ bảng layout_contactsfooter
    $sql = "SELECT * FROM layout_contactsfooter ORDER BY created_at DESC";
    $result = $conn->query($sql);

    if ($result === false) {
        throw new Exception("Lỗi truy vấn: " . $conn->error);
    }

    $contacts = [];
    while ($row = $result->fetch_assoc()) {
        $contacts[] = [
            "id" => $row['id'],
            "icon" => $row['icon'],
            "type" => $row['type'],
            "created_at" => $row['created_at'],
            "updated_at" => $row['updated_at']
        ];
    }

    echo json_encode([
        "ok" => true,
        "success" => true,
        "data" => $contacts
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
