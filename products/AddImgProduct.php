<?php
header('Content-Type: application/json');
// [POST] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/products/img/21
// Kiểm tra phương thức request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Phương thức " . $_SERVER['REQUEST_METHOD'] . " không được hỗ trợ"
    ]);
    exit;
}

require_once __DIR__ . '/../config/db.php';

try {
    // Lấy ID sản phẩm từ URL
    $request_uri = $_SERVER['REQUEST_URI'];
    preg_match('/\/products\/img\/(\d+)$/', $request_uri, $matches);
    $product_id = isset($matches[1]) ? (int)$matches[1] : 0;

    if ($product_id <= 0) {
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "ID sản phẩm không hợp lệ"
        ]);
        exit;
    }

    // Kiểm tra xem sản phẩm có tồn tại không
    $check_product = "SELECT id FROM products WHERE id = ?";
    $stmt = $conn->prepare($check_product);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "Sản phẩm không tồn tại"
        ]);
        exit;
    }

    // Lấy dữ liệu từ request body
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['image_url']) || empty($data['image_url'])) {
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "URL hình ảnh không được để trống"
        ]);
        exit;
    }
 
    // Thêm URL hình ảnh vào database
    $insert_sql = "INSERT INTO product_images (product_id, image_url) VALUES (?, ?)";
    $stmt = $conn->prepare($insert_sql);
    $stmt->bind_param("is", $product_id, $data['image_url']);
    
    if ($stmt->execute()) {
        echo json_encode([
            "ok" => true,
            "success" => true,
            "message" => "Thêm hình ảnh thành công",
        
        ]);
    } else {
        throw new Exception("Lỗi khi thêm hình ảnh: " . $conn->error);
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
