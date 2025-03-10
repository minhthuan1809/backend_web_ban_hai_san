<?php
// [PUT] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/about/space/{id}
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
    preg_match('/\/about\/space\/(\d+)/', $request_uri, $matches);
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

    // Cập nhật dữ liệu cho bảng layout_space
    $sql = "UPDATE layout_space SET icon = ?, title = ?, description_one = ?, description_two = ?, description_three = ?, description_four = ? WHERE id = ?";
    
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        throw new Exception("Lỗi chuẩn bị câu lệnh: " . $conn->error);
    }

    // Gán giá trị từ dữ liệu request
    $icon = $data['icon'];
    $title = $data['title'];
    $description_one = $data['description_one'];
    $description_two = $data['description_two'];
    $description_three = $data['description_three'];
    $description_four = $data['description_four'];

    $stmt->bind_param("ssssssi", $icon, $title, $description_one, $description_two, $description_three, $description_four, $id);
    
    if ($stmt->execute()) {
        echo json_encode([
            "ok" => true,
            "success" => true,
            "message" => "Cập nhật không gian thành công"
        ]);
    } else {
        throw new Exception("Lỗi khi cập nhật không gian: " . $stmt->error);
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