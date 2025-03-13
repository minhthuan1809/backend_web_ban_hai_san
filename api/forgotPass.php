<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../email/send.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Tạo bảng reset_password_codes nếu chưa tồn tại
$createTable = "CREATE TABLE IF NOT EXISTS reset_password_codes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    code VARCHAR(6) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($createTable);

// API 1: Gửi mã xác thực qua email
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['sendcode'])) {
    $data = json_decode(file_get_contents("php://input"));

    if (!isset($data->email)) {
        http_response_code(400);
        echo json_encode([
            "ok" => false,
            "message" => "Vui lòng cung cấp địa chỉ email"
        ]);
        exit();
    }

    // Kiểm tra email có tồn tại
    $stmt = $conn->prepare("SELECT id FROM user WHERE email = ?");
    $stmt->bind_param("s", $data->email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        http_response_code(404);
        echo json_encode([
            "ok" => false,
            "message" => "Email không tồn tại trong hệ thống"
        ]);
        exit();
    }

    // Tạo mã xác nhận mới
    $code = sprintf("%06d", mt_rand(0, 999999));

    // Xóa mã cũ nếu có
    $stmt = $conn->prepare("DELETE FROM reset_password_codes WHERE email = ?");
    $stmt->bind_param("s", $data->email);
    $stmt->execute();

    // Lưu mã mới
    $stmt = $conn->prepare("INSERT INTO reset_password_codes (email, code) VALUES (?, ?)");
    $stmt->bind_param("ss", $data->email, $code);
    if ($stmt->execute()) {
        // Gửi email
        $mailer = new mailer();
        
        $emailContent = '
        <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px;">
            <h2 style="color: #2c3e50; text-align: center; margin-bottom: 20px;">Đặt Lại Mật Khẩu</h2>
            
            <p style="color: #34495e; font-size: 16px; line-height: 1.5;">Xin chào, ' . $data->email . '</p>
            
            <div style="background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin: 20px 0;">
                <p style="color: #2c3e50; font-size: 18px; text-align: center; margin: 0;">
                    Mã xác nhận của bạn là: <br>
                    <span style="font-size: 32px; font-weight: bold; color: #e74c3c; letter-spacing: 5px;">' . $code . '</span>
                </p>
            </div>
            
            <p style="color: #7f8c8d; font-size: 14px;">Mã này sẽ hết hạn sau 5 phút.</p>
            
            <p style="color: #34495e; margin-top: 20px;">Trân trọng,<br>Hải sản Minh Thuận</p>
            
            <div style="border-top: 1px solid #ddd; margin-top: 20px; padding-top: 20px; text-align: center; font-size: 12px; color: #95a5a6;">
                Email này được gửi từ Hải sản Minh Thuận, vui lòng không trả lời.
            </div>
        </div>';
        
        $result = $mailer->dathang("Đặt lại mật khẩu", $emailContent, $data->email);

        if($result === 'Message has been sent') {
            echo json_encode([
                "ok" => true,
                "message" => "Mã xác nhận đã được gửi đến email của bạn"
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                "ok" => false,
                "message" => "Không thể gửi email"
            ]);
        }
    }
}

// API 2: Xác thực mã
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['verify'])) {
    $data = json_decode(file_get_contents("php://input"));

    if (!isset($data->email) || !isset($data->code)) {
        http_response_code(400);
        echo json_encode([
            "ok" => false,
            "message" => "Thiếu email hoặc mã xác nhận"
        ]);
        exit();
    }

    // Xóa mã hết hạn
    $conn->query("DELETE FROM reset_password_codes WHERE created_at < (NOW() - INTERVAL 5 MINUTE)");

    // Kiểm tra mã
    $stmt = $conn->prepare("SELECT * FROM reset_password_codes WHERE email = ? AND code = ? AND created_at > (NOW() - INTERVAL 5 MINUTE)");
    $stmt->bind_param("ss", $data->email, $data->code);
    $stmt->execute();
    
    if ($stmt->get_result()->num_rows === 0) {
        http_response_code(400);
        echo json_encode([
            "ok" => false,
            "message" => "Mã xác nhận không chính xác hoặc đã hết hạn"
        ]);
        exit();
    }

    echo json_encode([
        "ok" => true,
        "message" => "Xác thực mã thành công"
    ]);
}

// API 3: Đổi mật khẩu mới
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['reset'])) {
    $data = json_decode(file_get_contents("php://input"));

    if (!isset($data->email) || !isset($data->code) || !isset($data->new_password)) {
        http_response_code(400);
        echo json_encode([
            "ok" => false,
            "message" => "Thiếu thông tin cần thiết"
        ]);
        exit();
    }

    // Kiểm tra email có tồn tại trong hệ thống
    $stmt = $conn->prepare("SELECT id FROM user WHERE email = ?");
    $stmt->bind_param("s", $data->email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        http_response_code(404);
        echo json_encode([
            "ok" => false,
            "message" => "Email không tồn tại trong hệ thống"
        ]);
        exit();
    }

    // Kiểm tra mã xác nhận lần cuối
    $stmt = $conn->prepare("SELECT * FROM reset_password_codes WHERE email = ? AND code = ? AND created_at > (NOW() - INTERVAL 5 MINUTE)");
    $stmt->bind_param("ss", $data->email, $data->code);
    $stmt->execute();
    
    if ($stmt->get_result()->num_rows === 0) {
        http_response_code(400);
        echo json_encode([
            "ok" => false,
            "message" => "Mã xác nhận không chính xác hoặc đã hết hạn"
        ]);
        exit();
    }

    // Cập nhật mật khẩu mới
    $hashed_password = password_hash($data->new_password, PASSWORD_DEFAULT);
    
    try {
        // Bắt đầu transaction
        $conn->begin_transaction();
        
        // Cập nhật mật khẩu
        $stmt = $conn->prepare("UPDATE user SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $hashed_password, $data->email);
        $stmt->execute();
        
        // Kiểm tra xem có dòng nào được cập nhật không
        if ($stmt->affected_rows === 0) {
            throw new Exception("Không thể cập nhật mật khẩu");
        }
        
        // Xóa mã xác nhận đã sử dụng
        $stmt = $conn->prepare("DELETE FROM reset_password_codes WHERE email = ?");
        $stmt->bind_param("s", $data->email);
        $stmt->execute();
        
        // Gửi email xác nhận đổi mật khẩu thành công
        $mailer = new mailer();
        
        $successEmailContent = '
        <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px;">
            <h2 style="color: #2c3e50; text-align: center; margin-bottom: 20px;">Đổi Mật Khẩu Thành Công</h2>
            
            <p style="color: #34495e; font-size: 16px; line-height: 1.5;">Xin chào, ' . $data->email . '</p>
            
            <div style="background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin: 20px 0;">
                <p style="color: #2c3e50; font-size: 18px; text-align: center; margin: 0;">
                    Mật khẩu của bạn đã được thay đổi thành công!
                </p>
            </div>
            
            <p style="color: #7f8c8d; font-size: 14px;">Nếu bạn không thực hiện thay đổi này, vui lòng liên hệ với chúng tôi ngay lập tức.</p>
            
            <p style="color: #34495e; margin-top: 20px;">Trân trọng,<br>Hải sản Minh Thuận</p>
            
            <div style="border-top: 1px solid #ddd; margin-top: 20px; padding-top: 20px; text-align: center; font-size: 12px; color: #95a5a6;">
                Email này được gửi từ Hải sản Minh Thuận, vui lòng không trả lời.
            </div>
        </div>';
        
        $mailer->dathang("Xác nhận đổi mật khẩu thành công", $successEmailContent, $data->email);
        
        // Commit transaction
        $conn->commit();
        
        echo json_encode([
            "ok" => true,
            "message" => "Mật khẩu đã được đặt lại thành công"
        ]);
        
    } catch (Exception $e) {
        // Rollback nếu có lỗi
        $conn->rollback();
        
        http_response_code(500);
        echo json_encode([
            "ok" => false,
            "message" => $e->getMessage()
        ]);
    }
}
?>
