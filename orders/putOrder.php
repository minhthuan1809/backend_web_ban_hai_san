<?php
require_once __DIR__ . '/../config/db.php';

if (!isset($conn) || !($conn instanceof mysqli)) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Không thể kết nối đến cơ sở dữ liệu"
    ]);
    exit;
}

try {
    // Lấy ID từ URL
    $urlParts = explode('/', $_SERVER['REQUEST_URI']);
    $orderId = end($urlParts);

    if (!is_numeric($orderId)) {
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "ID đơn hàng không hợp lệ"
        ]);
        exit;
    }

    // Lấy dữ liệu từ request
    $data = json_decode(file_get_contents("php://input"), true);
    
    // Tạo câu lệnh SQL động dựa trên dữ liệu gửi lên
    $updateFields = [];
    $params = [];
    $types = "";
    
    // Kiểm tra và thêm các trường cần cập nhật
    if (isset($data['status'])) {
        $updateFields[] = "status = ?";
        $params[] = $data['status'];
        $types .= "s";
    }
    
    if (isset($data['address'])) {
        $updateFields[] = "address = ?";
        $params[] = $data['address'];
        $types .= "s";
    }

    // Nếu không có trường nào được cập nhật
    if (empty($updateFields)) {
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "Không có dữ liệu cần cập nhật"
        ]);
        exit;
    }

    // Thêm ID vào params và types
    $params[] = $orderId;
    $types .= "i";

    // Tạo câu lệnh SQL
    $sql = "UPDATE orders SET " . implode(", ", $updateFields) . " WHERE id = ?";
    
    // Chuẩn bị và thực thi câu lệnh
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
                "message" => "Cập nhật đơn hàng thành công"
            ]);
        } else {
            echo json_encode([
                "ok" => false,
                "success" => false,
                "message" => "Không tìm thấy đơn hàng hoặc không có thay đổi"
            ]);
        }
    } else {
        throw new Exception("Lỗi cập nhật đơn hàng: " . $stmt->error);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
?>
