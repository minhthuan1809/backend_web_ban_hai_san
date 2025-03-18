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
    $data = json_decode(file_get_contents('php://input'), true);
    
    // Lấy ID từ URL
    $request_uri = $_SERVER['REQUEST_URI'];
    preg_match('/\/discount\/(\d+)/', $request_uri, $matches);
    
    if (!isset($matches[1])) {
        throw new Exception("Không tìm thấy ID trong URL");
    }
    
    $id = $matches[1];

    $updateFields = [];
    $types = '';
    $params = [];

    if (isset($data['name'])) {
        $updateFields[] = "name = ?";
        $types .= "s";
        $params[] = $data['name'];
    }

    if (isset($data['discount_percent'])) {
        $updateFields[] = "discount_percent = ?";
        $types .= "i";
        $params[] = intval($data['discount_percent']);
    }

    if (isset($data['quantity'])) {
        $updateFields[] = "quantity = ?";
        $types .= "i"; 
        $params[] = intval($data['quantity']);
    }

    if (isset($data['start_time'])) {
        $updateFields[] = "start_time = ?";
        $types .= "s";
        $params[] = date('Y-m-d', strtotime($data['start_time'])) . ' 00:00:00';
    }

    if (isset($data['end_time'])) {
        $updateFields[] = "end_time = ?";
        $types .= "s";
        $params[] = date('Y-m-d', strtotime($data['end_time'])) . ' 00:00:00';
    }

    if (isset($data['status'])) {
        $updateFields[] = "status = ?";
        $types .= "i";
        $params[] = $data['status'] === true ;
    }

    if (empty($updateFields)) {
        throw new Exception("Không có trường nào được cập nhật");
    }

    $updateFields[] = "updated_at = CURRENT_TIMESTAMP";
    
    $sql = "UPDATE discount SET " . implode(", ", $updateFields) . " WHERE id = ?";
    
    $types .= "i";
    $params[] = $id;

    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode([
                "ok" => true,
                "success" => true,
                "message" => "Cập nhật mã giảm giá thành công"
            ]);
        } else {
            throw new Exception("Không tìm thấy mã giảm giá với ID này");
        }
    } else {
        throw new Exception("Lỗi khi cập nhật mã giảm giá: " . $conn->error);
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
