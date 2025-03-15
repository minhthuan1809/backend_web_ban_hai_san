<?php
require_once __DIR__ . '/../config/TokenUtils.php';
require_once __DIR__ . '/../config/db.php';
//[POST] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/address
// Kiểm tra phương thức request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Phương thức không hợp lệ, vui lòng sử dụng POST"
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
        "message" => "Lỗi xác thực"
    ]);
    exit;
}

$token = str_replace('Bearer ', '', $headers['Authorization']);

try {
    // Xác thực token và lấy user_id từ token
    $userId = TokenUtils::validateTokenAndGetUserId($token);
    if (!$userId) {
        throw new Exception("Token không hợp lệ");
    }

    // Kiểm tra xem token có thuộc về user hiện tại không
    $sql = "SELECT id FROM user WHERE id = ?";
    $checkUserToken = $conn->prepare($sql);
    if ($checkUserToken === false) {
        throw new Exception("Lỗi chuẩn bị câu lệnh SQL: " . $conn->error);
    }
    
    $checkUserToken->bind_param("i", $userId);
    $checkUserToken->execute();
    $result = $checkUserToken->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception("Token không hợp lệ cho người dùng này");
    }
    $checkUserToken->close();

} catch (Exception $e) {
    http_response_code(401); 
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => $e->getMessage()
    ]);
    exit;
}

// Kiểm tra kết nối database
if (!isset($conn) || !($conn instanceof mysqli)) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Không thể kết nối đến cơ sở dữ liệu"
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

// Kiểm tra tên địa chỉ đã tồn tại chưa
$sql = "SELECT id FROM address WHERE user_id = ? AND name = ?";
$checkName = $conn->prepare($sql);
if ($checkName === false) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Lỗi chuẩn bị câu lệnh SQL: " . $conn->error
    ]);
    exit;
}

$checkName->bind_param("is", $userId, $data['name']);
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

// Kiểm tra số lượng địa chỉ hiện có của user
$sql = "SELECT COUNT(*) as count FROM address WHERE user_id = ?";
$checkAddressCount = $conn->prepare($sql);
if ($checkAddressCount === false) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Lỗi chuẩn bị câu lệnh SQL: " . $conn->error
    ]);
    exit;
}

$checkAddressCount->bind_param("i", $userId);
$checkAddressCount->execute();
$countResult = $checkAddressCount->get_result()->fetch_assoc();

if ($countResult['count'] >= 5) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Bạn chỉ có thể có tối đa 5 địa chỉ"
    ]);
    $checkAddressCount->close();
    $conn->close();
    exit;
}
$checkAddressCount->close();

// Thêm địa chỉ mới
$sql = "INSERT INTO address (user_id, name, address, phone) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Lỗi chuẩn bị câu lệnh SQL: " . $conn->error
    ]);
    exit;
}

$stmt->bind_param("isss", $userId, $data['name'], $data['address'], $data['phone']);

if ($stmt->execute()) {
    $newAddressId = $stmt->insert_id;
    echo json_encode([
        "ok" => true,
        "success" => true,
        "message" => "Thêm địa chỉ thành công",
  
    ]);
} else {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Lỗi khi thêm địa chỉ: " . $stmt->error
    ]);
}

$stmt->close();
$conn->close();
?>
