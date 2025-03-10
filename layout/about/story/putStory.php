<?php
// [PUT] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/about/story
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
    // Lấy dữ liệu từ request body
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['title']) || !isset($data['description_one']) || !isset($data['description_two'])) {
        throw new Exception("Thiếu thông tin cần thiết");
    }

    // Cập nhật dữ liệu cho bảng layout_story
    $sql = "UPDATE layout_story SET title = ?, description_one = ?, description_two = ? WHERE id = 1";
    
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        throw new Exception("Lỗi chuẩn bị câu lệnh: " . $conn->error);
    }

    // Gán giá trị từ dữ liệu request
    $title = $data['title'];
    $description_one = $data['description_one'];
    $description_two = $data['description_two'];

    $stmt->bind_param("sss", $title, $description_one, $description_two);
    
    if ($stmt->execute()) {
        echo json_encode([
            "ok" => true,
            "success" => true,
            "message" => "Cập nhật câu chuyện thành công"
        ]);
    } else {
        throw new Exception("Lỗi khi cập nhật câu chuyện: " . $stmt->error);
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
