<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/jwt_utils.php';

$database = $conn;
$db = $database;

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->email) && !empty($data->password)) {
    $email = $data->email;
    $stmt = $db->prepare("SELECT id, email, password, status FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id = $row['id'];
        $email = $row['email'];
        $password = $row['password'];
        $status = $row['status'];

        if ($status === 1) {
            http_response_code(401);
            echo json_encode(array(
                "ok" => false,
                "status" => false,
                "message" => "Tài khoản của bạn đã bị khóa. Vui lòng liên hệ quản trị viên."
            ));
            exit;
        }
        
        // Verify password
        if (password_verify($data->password, $password)) {
            $token = JwtUtils::generateToken($id, $email);
            
            http_response_code(200);
            echo json_encode(array(
                "ok" => true,
                "status" => true,
                "message" => "Đăng nhập thành công.",
                "token" => $token
            ));
        } else {
            http_response_code(401);
                echo json_encode(array(
                "ok" => false,
                "status" => false,
                "message" => "Email hoặc mật khẩu không đúng."
            ));
        }
    } else {
        http_response_code(401);
        echo json_encode(array(
            "ok" => false,
            "status" => false,
            "message" => "Email hoặc mật khẩu không đúng."
        ));
    }
} else {
    http_response_code(400);
    echo json_encode(array(
        "status" => false,
        "message" => "Không thể đăng nhập. Dữ liệu không đầy đủ."
    ));
}
?> 