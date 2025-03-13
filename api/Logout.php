<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/jwt_utils.php';

// Kiểm tra OPTIONS request
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Tạo bảng blacklisted_tokens nếu chưa tồn tại
$createTable = "CREATE TABLE IF NOT EXISTS blacklisted_tokens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    token TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($createTable);

// Lấy token từ header Authorization
$headers = apache_request_headers();
$token = null;

if (isset($headers['Authorization'])) {
    $token = str_replace('Bearer ', '', $headers['Authorization']);
}

if ($token) {
    try {
        // Kiểm tra xem token đã bị blacklist chưa
        $checkStmt = $conn->prepare("SELECT id FROM blacklisted_tokens WHERE token = ?");
        $checkStmt->bind_param("s", $token);
        $checkStmt->execute();
        $result = $checkStmt->get_result();

        if ($result->num_rows > 0) {
            http_response_code(200);
            echo json_encode(array(
                "ok" => true,
                "success" => true,
                "message" => "Đăng xuất thành công"
            ));
        } else {
            // Xác thực token
            $payload = JwtUtils::validateToken($token);
            
            if ($payload) {
                // Thêm token vào blacklist
                $stmt = $conn->prepare("INSERT INTO blacklisted_tokens (token) VALUES (?)");
                $stmt->bind_param("s", $token);
                $stmt->execute();
                
                http_response_code(200);
                echo json_encode(array(
                    "ok" => true,
                    "success" => true,
                    "message" => "Đăng xuất thành công"
                ));
            } else {
                http_response_code(200);
                echo json_encode(array(
                    "ok" => true,
                    "success" => true,
                    "message" => "Đăng xuất thành công"
                ));
            }
        }
    } catch (Exception $e) {
        http_response_code(200);
        echo json_encode(array(
            "ok" => true,
            "success" => true,
            "message" => "Lỗi xác thực: " . $e->getMessage()
        ));
    }
} else {
    http_response_code(200);
    echo json_encode(array(
        "ok" => true,
        "success" => true,
        "message" => "Đăng xuất thành công"
    ));
}
?>
