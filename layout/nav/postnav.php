<?php
// [POST] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/nav
require_once __DIR__ . '/../../config/db.php';

if (!isset($conn) || !($conn instanceof mysqli)) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Không thể kết nối đến cơ sở dữ liệu"
    ]);
    exit;
}


try {
    // Lấy dữ liệu từ request
    $data = json_decode(file_get_contents("php://input"), true);

    // Kiểm tra dữ liệu có trống không
    if (empty($data)) {
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "Dữ liệu gửi lên không được để trống"
        ]);
        exit;
    }

    // Kiểm tra dữ liệu bắt buộc
    if (!isset($data['name']) || !isset($data['url'])) {
        throw new Exception("Thiếu thông tin bắt buộc");
    }

    // Kiểm tra từng trường dữ liệu có trống không
    if (empty($data['name'])) {
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "Tên menu không được để trống"
        ]);
        exit;
    }

    if (empty($data['url'])) {
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "URL không được để trống"
        ]);
        exit;
    }

    // Kiểm tra trùng lặp URL và tên
    $check_sql = "SELECT * FROM layout_navigation_menu WHERE url = ? OR name = ?";
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
    $sql = "INSERT INTO layout_navigation_menu (name, url, parent_id, order_position, is_active, is_visible) VALUES (?, ?, ?, ?, ?, ?)";
    
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
