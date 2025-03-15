<?php
require_once __DIR__ . '/../config/TokenUtils.php';
require_once __DIR__ . '/../config/db.php';

if (!isset($conn) || !($conn instanceof mysqli)) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Không thể kết nối đến cơ sở dữ liệu"
    ]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Phương thức không hợp lệ, vui lòng sử dụng DELETE"
    ]);
    exit;
}

// Kiểm tra token xác thực
$headers = getallheaders();
if (!isset($headers['Authorization'])) {
    http_response_code(401);
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "lỗi xác thực"
    ]);
    exit;
}

$token = str_replace('Bearer ', '', $headers['Authorization']);

try {
    // Xác thực token
    $userId = TokenUtils::validateTokenAndGetUserId($token);
    if (!$userId) {
        throw new Exception("Token không hợp lệ");
    }
} catch (Exception $e) {
    http_response_code(401); 
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => $e->getMessage()
    ]);
    exit;
}

// Lấy ID từ URL
$request_uri = $_SERVER['REQUEST_URI'];
preg_match('/\/card\/minus\/(\d+)$/', $request_uri, $matches);
$id = isset($matches[1]) ? (int)$matches[1] : 0;

if ($id <= 0) {
    echo json_encode([
        "ok" => false,
        "message" => "ID không hợp lệ"
    ]);
    exit;
}

// Kiểm tra số lượng hiện tại trong giỏ hàng
$checkQuantity = $conn->prepare("SELECT quantity FROM cart WHERE id = ? AND user_id = ?");
$checkQuantity->bind_param("ii", $id, $userId);
$checkQuantity->execute();
$result = $checkQuantity->get_result();

if ($result->num_rows === 0) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Không tìm thấy sản phẩm trong giỏ hàng"
    ]);
    exit;
}

$row = $result->fetch_assoc();
$currentQuantity = $row['quantity'];

if ($currentQuantity <= 1) {
    // Nếu số lượng là 1, xóa sản phẩm khỏi giỏ hàng
    $stmt = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $id, $userId);
} else {
    // Giảm số lượng đi 1
    $newQuantity = $currentQuantity - 1;
    $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("iii", $newQuantity, $id, $userId);
}

if ($stmt->execute()) {
    echo json_encode([
        "ok" => true,
        "success" => true,
        "message" => $currentQuantity <= 1 ? "Đã xóa sản phẩm khỏi giỏ hàng" : "Đã giảm số lượng sản phẩm"
    ]);
} else {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Lỗi khi cập nhật giỏ hàng: " . $stmt->error
    ]);
}

$checkQuantity->close();
$stmt->close();
$conn->close();
