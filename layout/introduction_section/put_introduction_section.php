<?php
// [PUT] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/introduction_section
// {
//     "title": "string",
//     "description": "string",
//     "content": "string"
// }
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

// Kết nối database
require_once __DIR__ . '/../../config/db.php';

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
$env_content = file_get_contents(__DIR__ . '/../../.env');
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

    // Kiểm tra xem bản ghi có tồn tại không
    $check_sql = "SELECT COUNT(*) as count FROM layout_introductionssection WHERE id = 1";
    $check_result = $conn->query($check_sql);
    $row = $check_result->fetch_assoc();
    
    if ($row['count'] == 0) {
        // Nếu không tồn tại, thực hiện INSERT
        $insert_sql = "INSERT INTO layout_introductionssection (id, title, description, content) VALUES (1, ?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("sss", $data['title'], $data['description'], $data['content']);
    } else {
        // Nếu tồn tại, thực hiện UPDATE
        $update_sql = "UPDATE layout_introductionssection SET title = ?, description = ?, content = ? WHERE id = 1";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("sss", $data['title'], $data['description'], $data['content']);
    }

    $result = $stmt->execute();

    if (!$result) {
        throw new Exception("Lỗi khi cập nhật: " . $stmt->error);
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
