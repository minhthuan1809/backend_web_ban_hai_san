<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8"); 
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once __DIR__ . '/../config/db.php';

// Lấy ID từ URL
$url = $_SERVER['REQUEST_URI'];
preg_match('/\/ads\/(\d+)$/', $url, $matches);

if (!empty($matches[1])) {
    try {
        $id = $matches[1];
        
        // Kiểm tra xem quảng cáo có tồn tại không
        $check_sql = "SELECT id FROM layout_ads WHERE id = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("i", $id);
        $check_stmt->execute();
        $result = $check_stmt->get_result();
        
        if ($result->num_rows === 0) {
            http_response_code(404);
            echo json_encode([
                "ok" => false,
                "success" => false,
                "message" => "Không tìm thấy quảng cáo với ID này"
            ]);
            exit();
        }
        
        // Lấy dữ liệu từ body request
        $data = json_decode(file_get_contents("php://input"));
        
        if (isset($data->is_active)) {
            // Chuyển đổi boolean thành số nguyên (0 hoặc 1)
            $is_active = $data->is_active === true ? 1 : 0;
            
            $sql = "UPDATE layout_ads SET is_active = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $is_active, $id);

            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    http_response_code(200);
                    echo json_encode([
                        "ok" => true,
                        "success" => true,
                        "message" => "Cập nhật thành công"
                    ]);
                } else {
                    http_response_code(400);
                    echo json_encode([
                        "ok" => false,
                        "success" => false,
                        "message" => "Không có thay đổi nào được thực hiện"
                    ]);
                }
            } else {
                throw new Exception("Lỗi khi cập nhật");
            }
        } else {
            http_response_code(400);
            echo json_encode([
                "ok" => false,
                "success" => false,
                "message" => "Thiếu thông tin trạng thái quảng cáo"
            ]);
        }
    } catch(Exception $e) {
        http_response_code(500);
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => $e->getMessage()
        ]);
    }
} else {
    http_response_code(400);
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Thiếu ID quảng cáo cần cập nhật"
    ]);
}

$conn->close();
?>
