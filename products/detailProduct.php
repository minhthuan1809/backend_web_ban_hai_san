<?php
// [GET] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/products/1
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
    // Lấy ID sản phẩm từ URL
    $request_uri = $_SERVER['REQUEST_URI'];
    preg_match('/\/products\/(\d+)$/', $request_uri, $matches);
    $product_id = isset($matches[1]) ? (int)$matches[1] : 0;

    if ($product_id <= 0) {
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "ID sản phẩm không hợp lệ"
        ]);
        exit;
    }

    // Lấy thông tin chi tiết của sản phẩm (không cần join với product_images)
    $product_sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($product_sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $product_result = $stmt->get_result();

    if ($product_result === false) {
        throw new Exception("Lỗi truy vấn: " . $conn->error);
    }

    $product = $product_result->fetch_assoc();

    if ($product) {
        // Lấy tất cả hình ảnh của sản phẩm
        $images_sql = "SELECT id, image_url FROM product_images WHERE product_id = ?";
        $stmt_images = $conn->prepare($images_sql);
        $stmt_images->bind_param("i", $product_id);
        $stmt_images->execute();
        $images_result = $stmt_images->get_result();

        $images = [];
        while ($image_row = $images_result->fetch_assoc()) {
            $images[] = [
                "id" => $image_row['id'],
                "image_url" => $image_row['image_url']
            ];
        }

        echo json_encode([
            "ok" => true,
            "success" => true,
            "data" => [
                "id" => $product['id'],
                "name" => $product['name'],
                "description" => $product['description'],
                "price" => number_format($product['price'], 0, ',', '.') . ' ₫',
                "quantity_sold" => $product['quantity_sold'],
                "quantity" => $product['quantity'],
                "star" => $product['star'],
                "status" => (int)$product['status'] == 1 ? true : false,
                "category" => $product['category'],
                "hot" => (int)$product['hot'],
                "created_at" => $product['created_at'],
                "updated_at" => $product['updated_at'],
                "images" => $images
            ]
        ]);
    } else {
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "Sản phẩm không tồn tại"
        ]);
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
    if (isset($stmt_images)) {
        $stmt_images->close();
    }
    if (isset($conn)) {
        $conn->close();
    }
}
?>