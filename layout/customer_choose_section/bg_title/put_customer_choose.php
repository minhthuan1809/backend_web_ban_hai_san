<?php
// [PUT] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/customer_choose_section/bg_title
header('Content-Type: application/json');

// Kiểm tra phương thức request
if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Phương thức " . $_SERVER['REQUEST_METHOD'] . " không được hỗ trợ"
    ]);
    exit;
}

require_once __DIR__ . '/../../../config/db.php';

if (!isset($conn) || !($conn instanceof mysqli)) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Không thể kết nối đến cơ sở dữ liệu"
    ]);
    exit;
}

// Lấy token từ header Authorization
$headers = apache_request_headers();
$auth_header = isset($headers['Authorization']) ? $headers['Authorization'] : '';
$token = '';

if (preg_match('/Bearer\s+(.*)$/i', $auth_header, $matches)) {
    $token = $matches[1];
}

// Đọc API_KEY_TOKEN từ file .env
$env_content = file_get_contents(__DIR__ . '/../../../.env');
$api_key_token = '';
if (preg_match('/API_KEY_TOKEN=(.*)/', $env_content, $matches)) {
    $api_key_token = trim($matches[1]);
}

// Kiểm tra token
if ($token !== $api_key_token) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Xác thực thất bại"
    ]);
    exit;
}

try {
    // Lấy dữ liệu từ request
    $data = json_decode(file_get_contents("php://input"), true);

    if (empty($data) || !isset($data['image_url']) || !isset($data['title'])) {
        throw new Exception("Không có dữ liệu hình ảnh hoặc tiêu đề được gửi");
    }

    // Chuẩn bị câu lệnh SQL với id = 1
    $sql = "UPDATE layout_customer_choose_section SET image_url = ?, title = ? WHERE id = 1";
    
    // Chuẩn bị và thực thi câu lệnh
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $data['image_url'], $data['title']);
    $result = $stmt->execute();

    if (!$result) {
        throw new Exception("Lỗi khi cập nhật: " . $stmt->error);
    }

    if ($stmt->affected_rows === 0) {
        throw new Exception("Không có bản ghi nào được cập nhật");
    }

    echo json_encode([
        "ok" => true,
        "success" => true,
        "message" => "Cập nhật thành công"
    ]);

} catch (Exception $e) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => $e->getMessage()
    ]);
}

$conn->close();
?>
