<?php
require_once __DIR__ . '/../config/db.php';

try {
    // Thêm header cho API
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    // Tạo mã giảm giá ngẫu nhiên gồm 8 ký tự chữ cái
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomCode = '';
    for ($i = 0; $i < 8; $i++) {
        $randomCode .= $characters[rand(0, strlen($characters) - 1)];
    }

    // Lấy dữ liệu từ request
    $data = json_decode(file_get_contents("php://input"), true);
    
    // Kiểm tra các trường bắt buộc
    if (!isset($data['discount_percent']) || !isset($data['quantity'])) {
        throw new Exception("Thiếu thông tin bắt buộc: discount_percent và quantity");
    }

    $name = isset($data['name']) ? $data['name'] : '';
    $discountPercent = $data['discount_percent'];
    $quantity = $data['quantity'];

    // Xử lý thời gian
    $startTime = isset($data['start_time']) ? 
        date('Y-m-d', strtotime($data['start_time'])) . ' 00:00:00' : 
        date('Y-m-d') . ' 00:00:00';

    $endTime = isset($data['end_time']) ? 
        date('Y-m-d', strtotime($data['end_time'])) . ' 00:00:00' : 
        '2038-01-01 00:00:00';

    // Sử dụng Prepared Statement để tránh SQL injection
    $sql = "INSERT INTO discount (name, code, discount_percent, quantity, start_time, end_time) 
            VALUES (?, ?, ?, ?, ?, ?)";
            
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiiss", $name, $randomCode, $discountPercent, $quantity, $startTime, $endTime);

    if ($stmt->execute()) {
        echo json_encode([
            'ok' => true,
            'status' => true,
            'message' => 'Thêm mã giảm giá thành công',
           
        ]);
    } else {
        throw new Exception("Lỗi khi thêm mã giảm giá: " . $stmt->error);
    }

} catch(Exception $e) {
    echo json_encode([
        'ok' => false,
        'status' => false,
        'message' => $e->getMessage()
    ]);
} finally {
    if (isset($stmt)) {
        $stmt->close();
    }
    if (isset($conn)) {
        $conn->close();
    }
}
?>
