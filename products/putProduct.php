<?php
// [PUT] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/products/{id}
// Kết nối đến cơ sở dữ liệu
require_once __DIR__ . '/../config/db.php';

// Lấy dữ liệu từ body request
$data = json_decode(file_get_contents('php://input'), true);

// Lấy id từ URL
$request_uri = $_SERVER['REQUEST_URI'];
preg_match('/\/products\/(\d+)/', $request_uri, $matches);
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

// Lấy thông tin sản phẩm hiện tại
$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$currentProduct = $result->fetch_assoc();

if (!$currentProduct) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Không tìm thấy sản phẩm"
    ]);
    exit;
}

// Chuẩn bị dữ liệu cập nhật
$name = isset($data['name']) ? $data['name'] : $currentProduct['name'];
$description = isset($data['description']) ? $data['description'] : $currentProduct['description'];
$price = isset($data['price']) ? (int)str_replace(['.',',','₫',' '], '', $data['price']) : $currentProduct['price'];
$status = isset($data['status']) ? ($data['status'] ? 1 : 0) : $currentProduct['status'];
$category = isset($data['category']) ? $data['category'] : $currentProduct['category'];
$hot = isset($data['hot']) ? ($data['hot'] ? 1 : 0) : $currentProduct['hot'];
$quantity = isset($data['quantity']) ? (int)$data['quantity'] : $currentProduct['quantity'];

// Cập nhật sản phẩm
$sql = "UPDATE products SET name=?, description=?, price=?, status=?, category=?, hot=?, quantity=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ssiisiii', $name, $description, $price, $status, $category, $hot, $quantity, $id);

if ($stmt->execute()) {
    echo json_encode([
        "ok" => true,
        "success" => true,
        "message" => "Cập nhật sản phẩm thành công"
    ]);
} else {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Lỗi cập nhật: " . $stmt->error
    ]);
}

$stmt->close();
$conn->close();
?>
