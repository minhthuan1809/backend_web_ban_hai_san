<?php
require_once '../config/db.php';

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
$env_content = file_get_contents('../.env');
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

    // Chuẩn bị và thực thi câu lệnh SQL
    $stmt = $conn->prepare("DELETE FROM Navigation_Menu WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode([
                "ok" => true,
                "success" => true,
                "message" => "Xóa menu thành công"
            ]);
        } else {
            echo json_encode([
                "ok" => false,
                "success" => false,
                "message" => "Không tìm thấy menu với ID đã cho"
            ]);
        }
    } else {
        throw new Exception("Lỗi khi xóa menu");
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
