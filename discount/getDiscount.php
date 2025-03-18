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
        $sql .= " WHERE name LIKE ? OR code LIKE ?";
    }

    $stmt = $conn->prepare($sql);

    // Bind tham số tìm kiếm nếu có
    if (!empty($search)) {
        $searchParam = "%$search%";
        $stmt->bind_param("ss", $searchParam, $searchParam);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $discounts = array();
        while($row = $result->fetch_assoc()) {
            // Định dạng lại thời gian
            $row['start_time'] = date('Y-m-d H:i:s', strtotime($row['start_time']));
            $row['end_time'] = date('Y-m-d H:i:s', strtotime($row['end_time']));
            $row['created_at'] = date('Y-m-d H:i:s', strtotime($row['created_at']));
            $row['updated_at'] = date('Y-m-d H:i:s', strtotime($row['updated_at']));
            // Kiểm tra số lượng mã giảm giá và thời gian
            $current_time = date('Y-m-d H:i:s');
            if ($row['quantity'] <= 0 || $current_time > $row['end_time']) {
                $row['status'] = false;
            } else {
                $row['status'] = isset($row['status']) ? ($row['status'] == 1 ? true : false) : false;
            }
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
            'message' => 'Không có mã giảm giá nào'
        ]);
    }

} catch(Exception $e) {
    echo json_encode([
        'ok' => false, 
        'status' => false,
        'message' => 'Lỗi khi lấy thông tin mã giảm giá: ' . $e->getMessage()
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
