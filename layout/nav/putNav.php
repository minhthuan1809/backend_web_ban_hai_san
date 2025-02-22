<?php
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
        "message" => "auth failed"
    ]);
    exit;
}

try {
    // Lấy ID từ URL path
    $url_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $path_parts = explode('/', $url_path);
    $id = end($path_parts);

    if (!$id || !is_numeric($id)) {
        throw new Exception("ID không hợp lệ");
    }

    // Lấy dữ liệu từ request
    $data = json_decode(file_get_contents("php://input"), true);

    // Chuẩn bị câu lệnh SQL
    $sql = "UPDATE Navigation_Menu SET ";
    $params = [];
    $types = "";
    
    // Xây dựng câu lệnh SQL động dựa trên dữ liệu được gửi
    if (isset($data['name'])) {
        $sql .= "name = ?, ";
        $params[] = $data['name'];
        $types .= "s";
    }
    if (isset($data['url'])) {
        $sql .= "url = ?, ";
        $params[] = $data['url'];
        $types .= "s";
    }
    if (isset($data['order'])) {
        $sql .= "`order` = ?, ";
        $params[] = $data['order'];
        $types .= "i";
    }
    
    // Xóa dấu phẩy và khoảng trắng cuối cùng
    $sql = rtrim($sql, ", ");
    
    $sql .= " WHERE id = ?";
    $types .= "i";
    $params[] = $id;

    // Thực thi câu lệnh
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode([
                "ok" => true,
                "success" => true,
                "message" => "Cập nhật menu thành công"
            ]);
        } else {
            echo json_encode([
                "ok" => false,
                "success" => false,
                "message" => "Không có thay đổi nào được thực hiện"
            ]);
        }
    } else {
        throw new Exception("Lỗi khi cập nhật menu");
    }

} catch (Exception $e) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Lỗi: " . $e->getMessage()
    ]);
} finally {
    if (isset($stmt)) {
        $stmt->close();
    }
    $conn->close();
}
?>
