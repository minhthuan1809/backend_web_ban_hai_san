<?php

header('Content-Type: application/json');

// Lấy token từ header Authorization
$headers = apache_request_headers();
$auth_header = isset($headers['Authorization']) ? $headers['Authorization'] : '';
$token = '';

if (preg_match('/Bearer\s+(.*)$/i', $auth_header, $matches)) {
    $token = $matches[1];
}

// Đọc API_KEY_TOKEN từ file .env
$env_content = file_get_contents(__DIR__ . '/../.env');
$api_key_token = '';
if (preg_match('/API_KEY_TOKEN=(.*)/', $env_content, $matches)) {
    $api_key_token = trim($matches[1]);
}

// Kiểm tra token
if ($token !== $api_key_token) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Lỗi xác thực "
    ]);
    exit;
}

// Kiểm tra phương thức request
if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
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
    // Lấy ID từ URL
    $request_uri = $_SERVER['REQUEST_URI'];
    preg_match('/\/products\/(\d+)$/', $request_uri, $matches);
    $id = isset($matches[1]) ? (int)$matches[1] : 0;

    if ($id <= 0) {
        throw new Exception("ID không hợp lệ");
    }

    // Xóa tất cả hình ảnh theo ID sản phẩm
    $sql_delete_images = "DELETE FROM product_images WHERE product_id = ?";
    $stmt_images = $conn->prepare($sql_delete_images);
    $stmt_images->bind_param("i", $id);
    
    if ($stmt_images->execute() === false) {
        throw new Exception("Lỗi truy vấn xóa hình ảnh: " . $stmt_images->error);
    }

    // Xóa bản ghi từ bảng sản phẩm theo ID
    $sql_delete_product = "DELETE FROM products WHERE id = ?";
    $stmt_product = $conn->prepare($sql_delete_product);
    $stmt_product->bind_param("i", $id);
    
    if ($stmt_product->execute() === false) {
        throw new Exception("Lỗi truy vấn xóa sản phẩm: " . $stmt_product->error);
    }

    echo json_encode([
        "ok" => true,
        "success" => true,
        "message" => "Sản phẩm xóa thành công"
    ]);

} catch (Exception $e) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => $e->getMessage()
    ]);
} finally {
    if (isset($stmt_images)) {
        $stmt_images->close();
    }
    if (isset($stmt_product)) {
        $stmt_product->close();
    }
    if (isset($conn)) {
        $conn->close();
    }
}
