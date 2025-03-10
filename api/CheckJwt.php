<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8"); 
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/jwt_utils.php';

$database = $conn;
$db = $database;

// Lấy token từ header Authorization
$headers = apache_request_headers();
$token = null;

if (isset($headers['Authorization'])) {
    $token = str_replace('Bearer ', '', $headers['Authorization']);
}

if ($token) {
    try {
        // Kiểm tra và giải mã token
        $decoded = JwtUtils::validateToken($token);
        
        if ($decoded) {
            // Token hợp lệ, lấy thông tin user
            $userId = $decoded->user_id;
            $stmt = $db->prepare("SELECT * FROM user WHERE id = ?");
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $email = $row['email'];
                $fullName = $row['fullName']; 
                $avatar = $row['avatar'];
                $level = $row['role_id'];
                


                    http_response_code(200);
                echo json_encode(array(
                    "ok" => true,
                    "status" => true,
                    "data" => [
                        // "id" => $userId,
                        "email" => $email,
                        "name" => $fullName,
                        "avatar" => $avatar,
                        "level" => $level
                    ]
                ));
                
                
            } else {
                http_response_code(401);
                echo json_encode(array(
                    "ok" => false,
                    "status" => false,
                    "message" => "Không tìm thấy thông tin người dùng"
                ));
            }
        } else {
            http_response_code(401);
            echo json_encode(array(
                "ok" => false,
                "status" => false,
                // token false
                "message" => "Bạn cần đăng nhập lại" 
            ));
        }
    } catch (Exception $e) {
        http_response_code(401);
        echo json_encode(array(
            "ok" => false,
            "status" => false,
            "message" => "Lỗi xác thực: " . $e->getMessage()
        ));
    }
} else {
    http_response_code(401);
    echo json_encode(array(
        "ok" => false,
        "status" => false,
        "message" => "Token không được cung cấp"
    ));
}
?>
