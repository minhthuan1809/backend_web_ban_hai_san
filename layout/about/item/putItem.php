<?php
// [PUT] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/about/Item/{id}
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

// Sửa đường dẫn file config
require_once __DIR__ . '/../../../config/db.php'; // Đã sửa đường dẫn

if (!isset($conn) || !($conn instanceof mysqli)) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Không thể kết nối đến cơ sở dữ liệu"
    ]);
    exit;
}

try {
    // Lấy id từ URL
    $request_uri = $_SERVER['REQUEST_URI'];
    preg_match('/\/about\/Item\/(\d+)/', $request_uri, $matches);
    $id = isset($matches[1]) ? (int)$matches[1] : null;

    // Kiểm tra id hợp lệ
    if ($id <= 0) {
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "ID không hợp lệ"
        ]);
        exit;
    }

    // Lấy dữ liệu từ request body
    $data = json_decode(file_get_contents("php://input"), true);

    // Cập nhật dữ liệu cho bảng layout_benefit
    $sql = "UPDATE layout_benefit SET icon = ?, title = ?, description = ? WHERE id = ?";
    
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        throw new Exception("Lỗi chuẩn bị câu lệnh: " . $conn->error);
    }

    // Gán giá trị từ dữ liệu request
    $icon = $data['icon'];
    $title = $data['title'];
    $description = $data['description'];

    $stmt->bind_param("sssi", $icon, $title, $description, $id);
    
    if ($stmt->execute()) {
        echo json_encode([
            "ok" => true,
            "success" => true,
            "message" => "Cập nhật thành công"
        ]);
    } else {
        throw new Exception("Lỗi khi cập nhật: " . $stmt->error);
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