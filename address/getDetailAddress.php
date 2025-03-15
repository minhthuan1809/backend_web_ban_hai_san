<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/TokenUtils.php';
// [GET] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/address
header('Content-Type: application/json');

// Kiểm tra phương thức request
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Phương thức không hợp lệ, vui lòng sử dụng GET"
    ]);
    exit;
}

try {
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

    // Truy vấn để lấy tất cả địa chỉ của user
    $sql = "SELECT * FROM address WHERE user_id = ? ORDER BY created_at DESC";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        throw new Exception("Lỗi chuẩn bị câu lệnh SQL: " . $conn->error);
    }

    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $addresses = array();
        while($row = $result->fetch_assoc()) {
            $addresses[] = array(
                'id' => $row['id'],
                'user_id' => $row['user_id'], 
                'name' => $row['name'],
                'address' => $row['address'],
                'phone' => $row['phone'],
                'created_at' => $row['created_at'],
                'updated_at' => $row['updated_at']
            );
        }
        
        echo json_encode([
            'ok' => true,
            'success' => true,
            'message' => 'Lấy danh sách địa chỉ thành công',
            'data' => $addresses
        ]);
    } else {
        http_response_code(404);
        echo json_encode([
            'ok' => false,
            'success' => false,
            'message' => 'Không tìm thấy địa chỉ nào cho người dùng này'
        ]);
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
