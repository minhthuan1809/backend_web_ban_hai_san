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
    // Kiểm tra token
    $headers = getallheaders();
    $token = isset($headers['Authorization']) ? str_replace('Bearer ', '', $headers['Authorization']) : null;

    if (!$token) {
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "Không tìm thấy token xác thực"
        ]);
        exit;
    }

    // Kiểm tra token trong blacklist
    $checkBlacklistSql = "SELECT id FROM blacklisted_tokens WHERE token = ?";
    $stmt = $conn->prepare($checkBlacklistSql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "Token không hợp lệ"
        ]);
        exit;
    }

    // Lấy ID từ URL
    $url = $_SERVER['REQUEST_URI'];
    preg_match('/\/order\/cancel\/(\d+)/', $url, $matches);
    $orderId = isset($matches[1]) ? $matches[1] : null;

    if (!$orderId || !is_numeric($orderId)) {
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "ID đơn hàng không hợp lệ"
        ]);
        exit;
    }

    // Lấy dữ liệu từ request
    $data = json_decode(file_get_contents("php://input"), true);

    // Kiểm tra status có phải là canceled không
    if (!isset($data['status']) || $data['status'] !== 'canceled') {
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "Trạng thái không hợp lệ. Chỉ chấp nhận status 'canceled'"
        ]);
        exit;
    }

    // Kiểm tra có lý do hủy đơn không
    if (!isset($data['reason'])) {
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "Vui lòng cung cấp lý do hủy đơn"
        ]);
        exit;
    }

    // Lấy thông tin đơn hàng hiện tại
    $getOrderSql = "SELECT user_id, name, phone, address, data_product, discount_code, discount_percent, final_total, free_of_charge, payment_method, note FROM orders WHERE id = ?";
    $stmt = $conn->prepare($getOrderSql);
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $result = $stmt->get_result();
    $orderData = $result->fetch_assoc();

    if ($orderData) {
        // Thêm vào bảng history_orders
        $insertHistorySql = "INSERT INTO history_orders (user_id, name, phone, address, data_product, discount_code, discount_percent, final_total, free_of_charge, payment_method, note, reason, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'canceled')";
        $stmtHistory = $conn->prepare($insertHistorySql);
        $stmtHistory->bind_param("isssssiiisss", 
            $orderData['user_id'],
            $orderData['name'],
            $orderData['phone'],
            $orderData['address'],
            $orderData['data_product'],
            $orderData['discount_code'],
            $orderData['discount_percent'],
            $orderData['final_total'],
            $orderData['free_of_charge'],
            $orderData['payment_method'],
            $orderData['note'],
            $data['reason']
        );
        if($stmtHistory->execute()) {
            $history_order_id = $stmtHistory->insert_id;

            // Xóa đơn hàng khỏi bảng orders
            $deleteOrderSql = "DELETE FROM orders WHERE id = ?";
            $stmtDelete = $conn->prepare($deleteOrderSql);
            $stmtDelete->bind_param("i", $orderId);
            $stmtDelete->execute();

            echo json_encode([
                "ok" => true,
                "success" => true,
                "message" => "Đã hủy đơn hàng thành công",
            ]);
            exit;
        }
    } else {
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "Không tìm thấy đơn hàng"
        ]);
        exit;
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
