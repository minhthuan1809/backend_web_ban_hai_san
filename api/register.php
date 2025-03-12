<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/jwt_utils.php';
require_once __DIR__ . '/../core/controller/auth/AuthController.php';
require_once __DIR__ . '/../email/send.php';

// Bắt đầu session ở đầu file nếu chưa có session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Để debug session
error_reporting(E_ALL);
ini_set('display_errors', 1);

$database = $conn;
$db = $database;

// Debug: Log all session data
error_log('Current SESSION data: ' . json_encode($_SESSION));

// Tạo bảng verification_codes nếu chưa tồn tại
$createTable = "CREATE TABLE IF NOT EXISTS verification_codes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    code VARCHAR(6) NOT NULL,
    fullname VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$db->query($createTable);

// Xử lý xác thực mã
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['verify'])) {
    $data = json_decode(file_get_contents("php://input"));

    if (!isset($data->code) || !isset($data->email)) {
        http_response_code(400);
        echo json_encode([
            "ok" => false,
            "status" => "error", 
            "message" => "Thiếu mã xác thực hoặc email"
        ]);
        exit();
    }

    // Xóa các mã hết hạn (5 phút)
    $db->query("DELETE FROM verification_codes WHERE created_at < (NOW() - INTERVAL 5 MINUTE)");

    // Kiểm tra mã xác thực
    $stmt = $db->prepare("SELECT * FROM verification_codes WHERE email = ? AND code = ? AND created_at > (NOW() - INTERVAL 5 MINUTE)");
    $stmt->bind_param("ss", $data->email, $data->code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        http_response_code(400);
        echo json_encode([
            "ok" => false,
            "status" => "error",
            "message" => "Mã xác thực không chính xác hoặc đã hết hạn"
        ]);
        exit();
    }

    // Lấy thông tin người dùng
    $userData = $result->fetch_assoc();

    try {
        $authController = new AuthController();
        
        // Đăng ký tài khoản với mật khẩu chưa hash
        $registerResult = $authController->register(
            $userData['email'],
            $userData['password'], 
            $userData['fullname']
        );

        // Xóa mã xác thực sau khi đăng ký thành công
        $stmt = $db->prepare("DELETE FROM verification_codes WHERE email = ?");
        $stmt->bind_param("s", $userData['email']);
        $stmt->execute();

        http_response_code(200);
        echo json_encode([
            "ok" => true,
            "status" => "success",
            "message" => "Tài khoản đã được kích hoạt thành công"
        ]);

    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            "ok" => false,
            "status" => "error",
            "message" => $e->getMessage()
        ]);
    }
    exit();
}

// Xử lý đăng ký và gửi mã xác thực
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_GET['verify']) && !isset($_GET['resend'])) {
    $data = json_decode(file_get_contents("php://input"));

    if (!empty($data->email) && !empty($data->password) && !empty($data->fullname)) {
        // Kiểm tra email đã tồn tại trong bảng user
        $checkEmail = "SELECT id FROM user WHERE email = ?";
        $stmt = $db->prepare($checkEmail);
        $stmt->bind_param("s", $data->email);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            http_response_code(400);
            echo json_encode([
                "ok" => false,
                "status" => "error",
                "message" => "Email đã được sử dụng"
            ]);
            exit();
        }

        // Tạo mã xác thực mới
        $verificationCode = rand(100000, 999999);
        
        // Xóa mã cũ nếu có
        $stmt = $db->prepare("DELETE FROM verification_codes WHERE email = ?");
        $stmt->bind_param("s", $data->email);
        $stmt->execute();
        
        // Lưu mã mới vào database - lưu mật khẩu gốc không hash
        $stmt = $db->prepare("INSERT INTO verification_codes (email, code, fullname, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $data->email, $verificationCode, $data->fullname, $data->password);
        
        if ($stmt->execute()) {
            // Gửi email xác thực
            $mailer = new mailer();
            $emailContent = "Xin chào " . htmlspecialchars($data->fullname) . ",<br><br>";
            $emailContent .= "Cảm ơn bạn đã đăng ký tài khoản. Mã xác thực của bạn là: <b>" . $verificationCode . "</b><br>";
            $emailContent .= "Mã này sẽ hết hạn sau 5 phút.<br><br>";
            $emailContent .= "Trân trọng,<br>Đội ngũ hỗ trợ";
            
            $result = $mailer->dathang("Xác thực đăng ký tài khoản", $emailContent, $data->email);

            if($result === 'Message has been sent') {
                http_response_code(200);
                echo json_encode([
                    "ok" => true,
                    "status" => "success", 
                    "message" => "Mã xác thực đã được gửi đến email của bạn"
                ]);
            } else {
                http_response_code(500);
                echo json_encode([
                    "ok" => false,
                    "status" => "error",
                    "message" => "Không thể gửi email xác thực"
                ]);
            }
        } else {
            http_response_code(500);
            echo json_encode([
                "ok" => false,
                "status" => "error",
                "message" => "Lỗi khi lưu mã xác thực"
            ]);
        }
    } else {
        http_response_code(400);
        echo json_encode([
            "ok" => false,
            "status" => "error",
            "message" => "Vui lòng điền đầy đủ thông tin đăng ký"
        ]);
    }
}

// Thêm endpoint để gửi lại mã xác thực
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['resend'])) {
    $data = json_decode(file_get_contents("php://input"));
    
    if (!isset($data->email)) {
        http_response_code(400);
        echo json_encode([
            "ok" => false,
            "status" => "error",
            "message" => "Vui lòng cung cấp email"
        ]);
        exit();
    }

    // Kiểm tra email trong bảng verification_codes
    $stmt = $db->prepare("SELECT * FROM verification_codes WHERE email = ?");
    $stmt->bind_param("s", $data->email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        http_response_code(400);
        echo json_encode([
            "ok" => false,
            "status" => "error",
            "message" => "Email chưa được đăng ký"
        ]);
        exit();
    }

    $userData = $result->fetch_assoc();
    
    // Tạo mã mới
    $newCode = (string)rand(100000, 999999);
    
    // Cập nhật mã mới
    $stmt = $db->prepare("UPDATE verification_codes SET code = ?, created_at = CURRENT_TIMESTAMP WHERE email = ?");
    $stmt->bind_param("ss", $newCode, $data->email);
    $stmt->execute();
    
    // Gửi email với mã mới
    $mailer = new mailer();
    $emailContent = "Xin chào " . htmlspecialchars($userData['fullname']) . ",<br><br>";
    $emailContent .= "Mã xác thực mới của bạn là: <b>" . $newCode . "</b><br>";
    $emailContent .= "Mã này sẽ hết hạn sau 5 phút.<br><br>";
    $emailContent .= "Trân trọng,<br>Đội ngũ hỗ trợ";
    
    $result = $mailer->dathang("Mã xác thực mới", $emailContent, $data->email);

    if($result === 'Message has been sent') {
        http_response_code(200);
        echo json_encode([
            "ok" => true,
            "status" => "success",
            "message" => "Mã xác thực mới đã được gửi đến email của bạn"
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            "ok" => false,
            "status" => "error",
            "message" => "Không thể gửi mã xác thực mới"
        ]);
    }
    exit();
}
?>