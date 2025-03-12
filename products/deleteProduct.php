<?php
// [DELETE] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/products/25
header('Content-Type: application/json');

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
    // Lấy ID từ URL
    $request_uri = $_SERVER['REQUEST_URI'];
    preg_match('/\/products\/(\d+)$/', $request_uri, $matches);
    $id = isset($matches[1]) ? (int)$matches[1] : 0;

    if ($id <= 0) {
        throw new Exception("ID không hợp lệ");
    }

    // Kiểm tra xem sản phẩm có tồn tại không
    $check_sql = "SELECT id FROM products WHERE id = $id";
    $result = $conn->query($check_sql);
    
    if ($result->num_rows === 0) {
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "Không tìm thấy sản phẩm với ID này"
        ]);
        exit;
    }

    // Bắt đầu transaction
    $conn->begin_transaction();

    try {
        // Xóa hình ảnh sản phẩm trước
        $delete_images_sql = "DELETE FROM product_images WHERE product_id = $id";
        if (!$conn->query($delete_images_sql)) {
            throw new Exception("Không thể xóa hình ảnh sản phẩm");
        }

        // Sau đó xóa sản phẩm
        $delete_product_sql = "DELETE FROM products WHERE id = $id";
        if (!$conn->query($delete_product_sql)) {
            throw new Exception("Không thể xóa sản phẩm");
        }

        // Commit transaction nếu mọi thứ thành công
        $conn->commit();

        echo json_encode([
            "ok" => true,
            "success" => true,
            "message" => "Xóa sản phẩm thành công"
        ]);

    } catch (Exception $e) {
        // Rollback nếu có lỗi
        $conn->rollback();
        throw $e;
    }

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
