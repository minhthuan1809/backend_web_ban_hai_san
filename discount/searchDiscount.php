<?php
require_once __DIR__ . '/../config/db.php';

try {
    // Thêm header cho API
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    // Lấy tham số tìm kiếm từ URL
    $search = isset($_GET['search']) ? $_GET['search'] : '';

    // Sử dụng prepared statement để tránh SQL injection
    $sql = "SELECT id, name, code, discount_percent, start_time, quantity, end_time, status, created_at, updated_at FROM discount";
    
    // Thêm điều kiện tìm kiếm nếu có
    if (!empty($search)) {
        $sql .= " WHERE code = ?";
    }

    $stmt = $conn->prepare($sql);

    // Bind tham số tìm kiếm nếu có
    if (!empty($search)) {
        $stmt->bind_param("s", $search);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $discounts = array();
        while($row = $result->fetch_assoc()) {
            // Kiểm tra số lượng mã giảm giá
            if ($row['quantity'] <= 0) {
                echo json_encode([
                    'ok' => false,
                    'status' => false,
                    'message' => 'Mã giảm giá đã hết'
                ]);
                exit;
            }
            // Kiểm tra thời gian mã giảm giá
            $current_time = date('Y-m-d H:i:s');
            if ($current_time > $row['end_time']) {
                echo json_encode([
                    'ok' => false,
                    'status' => false,
                    'message' => 'Mã giảm giá đã hết hạn'
                ]);
                exit;
            }
            // Định dạng lại thời gian
            $row['start_time'] = date('Y-m-d H:i:s', strtotime($row['start_time']));
            $row['end_time'] = date('Y-m-d H:i:s', strtotime($row['end_time']));
            $row['created_at'] = date('Y-m-d H:i:s', strtotime($row['created_at']));
            $row['updated_at'] = date('Y-m-d H:i:s', strtotime($row['updated_at']));
            $row['status'] = isset($row['status']) ? ($row['status'] == 1 ? true : false) : false;
            $discounts[] = $row;
        }
        
        echo json_encode([
            'ok' => true,
            'status' => true,
            'message' => 'Lấy thông tin mã giảm giá thành công',
            'data' => $discounts
        ]);
    } else {
        echo json_encode([
            'ok' => false,
            'status' => false,
            'message' => 'Không tìm thấy mã giảm giá'
        ]);
    }

} catch(Exception $e) {
    echo json_encode([
        'ok' => false, 
        'status' => false,
        'message' => 'Không tìm thấy mã giảm giá'
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
