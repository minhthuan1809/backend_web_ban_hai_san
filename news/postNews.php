<?php
// [POST] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/news
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

    // Thông báo khi dữ liệu không có
    if (!isset($data['title']) || !isset($data['description']) || !isset($data['image_url']) || !isset($data['status'])) {
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "Thông báo không có dữ liệu bạn không được để trống"
        ]);
        exit;
    }

    // Kiểm tra từng trường dữ liệu có trống không
    if (empty($data['title'])) {
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "Tiêu đề không được để trống"
        ]);
        exit;
    }

    if (empty($data['description'])) {
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "Mô tả không được để trống"
        ]);
        exit;
    }

    if (empty($data['image_url'])) {
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "URL hình ảnh không được để trống"
        ]);
        exit;
    }

    // Chuẩn bị câu lệnh SQL
    $sql = "INSERT INTO news (title, description, image_url, status) VALUES (?, ?, ?, ?)";
    
    // Gán giá trị mặc định nếu không được cung cấp
    $status = isset($data['status']) ? (bool)$data['status'] : true;
    
    // Chuẩn bị và thực thi câu lệnh
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        throw new Exception("Lỗi chuẩn bị câu lệnh: " . $conn->error);
    }
    
    $stmt->bind_param("sssi", 
        $data['title'], 
        $data['description'],
        $data['image_url'],
        $status
    );
    
    if ($stmt->execute()) {
        echo json_encode([
            "ok" => true,
            "success" => true,
            "message" => "Thêm tin tức mới thành công",
        ]);
    } else {
        throw new Exception("Lỗi khi thêm tin tức mới: " . $stmt->error);
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
