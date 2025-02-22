<?php
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

// Sửa đường dẫn file config
require_once __DIR__ . '/../config/db.php';

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
$env_content = file_get_contents(__DIR__ . '/../.env');
$api_key_token = '';
if (preg_match('/API_KEY_TOKEN=(.*)/', $env_content, $matches)) {
    $api_key_token = trim($matches[1]);
}

// Kiểm tra token
if ($token !== $api_key_token) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "auth failed"
    ]);
    exit;
}

try {
    // Lấy dữ liệu từ request
    $data = json_decode(file_get_contents("php://input"), true);

    // Kiểm tra xem có dữ liệu được gửi không
    if (empty($data)) {
        throw new Exception("Không có dữ liệu được gửi");
    }

    // Chuẩn bị câu lệnh SQL
    $sql = "UPDATE Website_Brand SET ";
    $params = [];
    $types = "";
    
    // Xây dựng câu lệnh SQL động dựa trên dữ liệu được gửi
    if (isset($data['brand_name'])) {
        $sql .= "brand_name = ?, ";
        $params[] = $data['brand_name'];
        $types .= "s";
    }
    if (isset($data['logo_url'])) {
        $sql .= "logo_url = ?, ";
        $params[] = $data['logo_url'];
        $types .= "s";
    }
    if (isset($data['alt_text'])) {
        $sql .= "alt_text = ?, ";
        $params[] = $data['alt_text'];
        $types .= "s";
    }
    
    // Kiểm tra xem có trường nào được cập nhật không
    if (empty($params)) {
        throw new Exception("Không có trường nào được cập nhật");
    }
    
    // Xóa dấu phẩy và khoảng trắng cuối cùng
    $sql = rtrim($sql, ", ");
    
    // Thực thi câu lệnh
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        throw new Exception("Lỗi chuẩn bị câu lệnh: " . $conn->error);
    }
    
    $stmt->bind_param($types, ...$params);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode([
                "ok" => true,
                "success" => true,
                "message" => "Cập nhật thương hiệu thành công"
            ]);
        } else {
            echo json_encode([
                "ok" => false,
                "success" => false,
                "message" => "Không có thay đổi nào được thực hiện"
            ]);
        }
    } else {
        throw new Exception("Lỗi khi cập nhật thương hiệu: " . $stmt->error);
    }

} catch (Exception $e) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Lỗi: " . $e->getMessage()
    ]);
} finally {
    if (isset($stmt) && $stmt !== false) {
        $stmt->close();
    }
    if (isset($conn) && $conn instanceof mysqli) {
        $conn->close();
    }
}
?>
