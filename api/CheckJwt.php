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
                
                // Lấy thông tin địa chỉ của người dùng
                $address_sql = "SELECT id, name, address, phone FROM address WHERE user_id = ?";
                $address_stmt = $db->prepare($address_sql);
                $address_stmt->bind_param("i", $userId);
                $address_stmt->execute();
                $address_result = $address_stmt->get_result();
                
                $addresses = [];
                if ($address_result && $address_result->num_rows > 0) {
                    while ($address_row = $address_result->fetch_assoc()) {
                        $addresses[] = [
                            "id" => $address_row['id'],
                            "address" => $address_row['address'],
                            "phone" => $address_row['phone'],
                            "name" => $address_row['name']
                        ];
                    }
                }

                http_response_code(200);
                echo json_encode(array(
                    "ok" => true,
                    "status" => true,
                    "data" => [
                        "id" => $userId,
                        "email" => $email,
                        "name" => $fullName,
                        "avatar" => $avatar,
                        "level" => $level,
                        "addresses" => $addresses
                    ]
                ));
                
                if (isset($address_stmt)) {
                    $address_stmt->close();
                }
                
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
