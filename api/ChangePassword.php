<?php
require_once __DIR__ . '/../config/TokenUtils.php';
require_once __DIR__ . '/../config/db.php';

header('Content-Type: application/json');

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

    if (!isset($data['old_password']) || !isset($data['new_password'])) {
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "Thiếu thông tin mật khẩu cũ hoặc mật khẩu mới"
        ]);
        exit;
    }

    // Kiểm tra mật khẩu cũ
    $sql = "SELECT password FROM user WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if (!password_verify($data['old_password'], $user['password'])) {
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "Mật khẩu cũ không chính xác"
        ]);
        exit;
    }

    // Cập nhật mật khẩu mới
    $new_password_hash = password_hash($data['new_password'], PASSWORD_DEFAULT);
    $sql = "UPDATE user SET password = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $new_password_hash, $userId);

    if ($stmt->execute()) {
        echo json_encode([
            "ok" => true,
            "success" => true,
            "message" => "Đổi mật khẩu thành công"
        ]);
    } else {
        throw new Exception("Lỗi khi cập nhật mật khẩu");
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
