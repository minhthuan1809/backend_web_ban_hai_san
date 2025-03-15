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

if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Phương thức không hợp lệ, vui lòng sử dụng PUT"
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
preg_match('/\/address\/(\d+)$/', $request_uri, $matches);
$id = isset($matches[1]) ? (int)$matches[1] : 0;

if ($id <= 0) {
    echo json_encode([
        "ok" => false,
        "message" => "ID không hợp lệ"
    ]);
    exit;
}

// Lấy dữ liệu từ body request
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['name']) || !isset($data['address']) || !isset($data['phone'])) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Thiếu thông tin bắt buộc"
    ]);
    exit;
}

// Kiểm tra xem địa chỉ có tồn tại và thuộc về user không
$checkAddress = $conn->prepare("SELECT id FROM address WHERE id = ? AND user_id = ?");
$checkAddress->bind_param("ii", $id, $userId);
$checkAddress->execute();
$result = $checkAddress->get_result();

if ($result->num_rows === 0) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Không tìm thấy địa chỉ hoặc bạn không có quyền chỉnh sửa"
    ]);
    $checkAddress->close();
    $conn->close();
    exit;
}
$checkAddress->close();

// Kiểm tra tên địa chỉ đã tồn tại chưa (trừ địa chỉ hiện tại)
$checkName = $conn->prepare("SELECT id FROM address WHERE user_id = ? AND name = ? AND id != ?");
$checkName->bind_param("isi", $userId, $data['name'], $id);
$checkName->execute();
$nameResult = $checkName->get_result();

if ($nameResult->num_rows > 0) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Tên gợi nhớ đã tồn tại"
    ]);
    $checkName->close();
    $conn->close();
    exit;
}
$checkName->close();

// Cập nhật địa chỉ
$stmt = $conn->prepare("UPDATE address SET name = ?, address = ?, phone = ? WHERE id = ? AND user_id = ?");
$stmt->bind_param("sssii", $data['name'], $data['address'], $data['phone'], $id, $userId);

if ($stmt->execute()) {
    echo json_encode([
        "ok" => true,
        "success" => true,
        "message" => "Cập nhật địa chỉ thành công",
        "data" => [
            "id" => $id,
            "user_id" => $userId,
            "name" => $data['name'],
            "address" => $data['address'],
            "phone" => $data['phone']
        ]
    ]);
} else {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Lỗi khi cập nhật địa chỉ: " . $stmt->error
    ]);
}

$stmt->close();
$conn->close();
