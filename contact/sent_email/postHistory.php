<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../email/send.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8"); 
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Tạo bảng email_history nếu chưa tồn tại
$createTable = "CREATE TABLE IF NOT EXISTS email_history (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    content TEXT NOT NULL,
    gmail VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

$conn->query($createTable);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));

    if (!isset($data->content) || !isset($data->gmail) || !isset($data->title)) {
        http_response_code(400);
        echo json_encode([
            "ok" => false,
            "message" => "Thiếu thông tin cần thiết"
        ]);
        exit();
    }

    // Lưu vào database trước, không phụ thuộc vào việc gửi email
    $stmt = $conn->prepare("INSERT INTO email_history (content, gmail, title) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $data->content, $data->gmail, $data->title);
    $saveSuccess = $stmt->execute();
    $stmt->close();

    // Sử dụng class mailer để gửi email
    $mailer = new mailer();
    // Sửa lại: gửi email đến địa chỉ gmail được cung cấp trong request
    $result = $mailer->dathang($data->title, $data->content, $data->gmail);

    if ($result === 'Message has been sent') {
        echo json_encode([
            "ok" => true,
            "message" => "Đã gửi email và lưu lịch sử thành công"
        ]);
    } else {
        // Nếu gửi email thất bại nhưng đã lưu vào database
        if ($saveSuccess) {
            echo json_encode([
                "ok" => true,
                "message" => "Đã lưu lịch sử nhưng không thể gửi email. Lỗi: " . $result
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                "ok" => false,
                "message" => "Không thể gửi email và lưu lịch sử. Lỗi: " . $result
            ]);
        }
    }
}

$conn->close();
?>
