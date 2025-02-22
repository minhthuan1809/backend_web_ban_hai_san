
<?php
// [POST] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/customer_section/customer__section
// {
//     "name": "...",
//     "image_url": "...",
//     "description": "..."
// } 
header('Content-Type: application/json');

// Kiểm tra phương thức request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
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

    if (empty($data)) {
        throw new Exception("Không có dữ liệu được gửi");
    }

    // Kiểm tra các trường bắt buộc
    if (!isset($data['name']) || !isset($data['image_url']) || !isset($data['description'])) {
        throw new Exception("Thiếu thông tin bắt buộc");
    }

    // Chuẩn bị câu lệnh SQL
    $sql = "INSERT INTO layout_customer_section (name, image_url, description) VALUES (?, ?, ?)";
    
    // Chuẩn bị và thực thi câu lệnh
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $data['name'], $data['image_url'], $data['description']);
    $result = $stmt->execute();

    if (!$result) {
        throw new Exception("Lỗi khi thêm mới: " . $stmt->error);
    }

    echo json_encode([
        "ok" => true,
        "success" => true,
        "message" => "Thêm mới thành công",
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