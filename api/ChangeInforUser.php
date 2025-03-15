<?php
require_once __DIR__ . '/../config/TokenUtils.php';
require_once __DIR__ . '/../config/db.php';

header('Content-Type: application/json');

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
        "message" => "Lỗi xác thực - Token không tồn tại"
    ]);
    exit;
}

$token = str_replace('Bearer ', '', $headers['Authorization']);

try {
    // Xác thực token và lấy user_id từ token
    $userId = TokenUtils::validateTokenAndGetUserId($token);
    if (!$userId) {
        throw new Exception("Token không hợp lệ hoặc đã hết hạn");
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

    // Lấy dữ liệu từ body request
    $data = json_decode(file_get_contents('php://input'), true);

    // Chuẩn bị câu lệnh SQL update
    $sql = "UPDATE user SET ";
    $types = "";
    $params = array();
    $updateFields = array();

    // Kiểm tra và thêm fullName nếu có
    if (isset($data['fullName']) && !empty($data['fullName'])) {
        $updateFields[] = "fullName = ?";
        $types .= "s";
        $params[] = $data['fullName'];
    }

    // Kiểm tra và thêm avatar nếu có
    if (isset($data['avatar']) && !empty($data['avatar'])) {
        $updateFields[] = "avatar = ?";
        $types .= "s";
        $params[] = $data['avatar'];
    }

    // Nếu không có trường nào được cập nhật
    if (empty($updateFields)) {
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "Không có thông tin nào được cập nhật"
        ]);
        exit;
    }

    $sql .= implode(", ", $updateFields);
    $sql .= " WHERE id = ?";
    $types .= "i";
    $params[] = $userId;

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        throw new Exception("Lỗi chuẩn bị câu lệnh SQL: " . $conn->error);
    }

    // Bind các tham số động
    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        echo json_encode([
            "ok" => true,
            "success" => true,
            "message" => "Cập nhật thông tin thành công"
        ]);
    } else {
        throw new Exception("Lỗi khi cập nhật thông tin");
    }

    $stmt->close();

} catch(Exception $e) {
    http_response_code(500);
    echo json_encode([
        'ok' => false,
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

$conn->close();
?>
