<?php
header('Content-Type: application/json');
// [DELETE] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/products/img/1
// Kiểm tra phương thức request
if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Phương thức " . $_SERVER['REQUEST_METHOD'] . " không được hỗ trợ"
    ]);
    exit;
}

require_once __DIR__ . '/../config/db.php';

try {
    // Lấy ID hình ảnh từ URL
    $request_uri = $_SERVER['REQUEST_URI'];
    preg_match('/\/products\/img\/(\d+)$/', $request_uri, $matches);
    $image_id = isset($matches[1]) ? (int)$matches[1] : 0;

    if ($image_id <= 0) {
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "ID hình ảnh không hợp lệ"
        ]);
        exit;
    }

    // Xóa hình ảnh từ bảng product_images
    $delete_sql = "DELETE FROM product_images WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $image_id);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode([
                "ok" => true,
                "success" => true,
                "message" => "Xóa hình ảnh thành công"
            ]);
        } else {
            echo json_encode([
                "ok" => false,
                "success" => false,
                "message" => "Không tìm thấy hình ảnh để xóa"
            ]);
        }
    } else {
        throw new Exception("Lỗi khi xóa hình ảnh: " . $conn->error);
    }

} catch (Exception $e) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => $e->getMessage()
    ]);
} finally {
    if (isset($stmt)) {
        $stmt->close();
    }
    if (isset($conn)) {
        $conn->close();
    }
}
?>
