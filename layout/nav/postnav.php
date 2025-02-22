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
    // Lấy dữ liệu từ request
    $data = json_decode(file_get_contents("php://input"), true);

    // Kiểm tra dữ liệu bắt buộc
    if (!isset($data['name']) || !isset($data['url'])) {
        throw new Exception("Thiếu thông tin bắt buộc");
    }

    // Kiểm tra trùng lặp URL và tên
    $check_sql = "SELECT * FROM Navigation_Menu WHERE url = ? OR name = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ss", $data['url'], $data['name']);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "URL hoặc tên menu đã tồn tại"
        ]);
        exit;
    }

    // Chuẩn bị câu lệnh SQL
    $sql = "INSERT INTO Navigation_Menu (name, url, parent_id, order_position, is_active, is_visible) VALUES (?, ?, ?, ?, ?, ?)";
    
    // Gán giá trị mặc định nếu không được cung cấp
    $parent_id = isset($data['parent_id']) ? $data['parent_id'] : null;
    $order_position = isset($data['order_position']) ? $data['order_position'] : 0;
    $is_active = isset($data['is_active']) ? $data['is_active'] : 0;
    $is_visible = isset($data['is_visible']) ? $data['is_visible'] : 1;
    
    // Chuẩn bị và thực thi câu lệnh
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        throw new Exception("Lỗi chuẩn bị câu lệnh: " . $conn->error);
    }
    
    $stmt->bind_param("ssiiis", 
        $data['name'], 
        $data['url'],
        $parent_id,
        $order_position,
        $is_active,
        $is_visible
    );
    
    if ($stmt->execute()) {
        echo json_encode([
            "ok" => true,
            "success" => true,
            "message" => "Thêm menu mới thành công",
            "id" => $conn->insert_id
        ]);
    } else {
        throw new Exception("Lỗi khi thêm menu mới: " . $stmt->error);
    }

} catch (Exception $e) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Lỗi: " . $e->getMessage()
    ]);
} finally {
    if (isset($check_stmt)) {
        $check_stmt->close();
    }
    if (isset($stmt) && $stmt !== false) {
        $stmt->close();
    }
    if (isset($conn) && $conn instanceof mysqli) {
        $conn->close();
    }
}
?>
