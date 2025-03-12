<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once __DIR__ . '/../config/db.php';

// Lấy ID từ URL
$url = $_SERVER['REQUEST_URI'];
preg_match('/\/ads\/(\d+)/', $url, $matches);

if (!empty($matches[1])) {
    try {
        $id = $matches[1];
        
        $sql = "DELETE FROM layout_ads WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                http_response_code(200);
                echo json_encode([
                    "ok" => true,
                    "success" => true,
                    "message" => "Xóa quảng cáo thành công"
                ]);
            } else {
                http_response_code(404);
                echo json_encode([
                    "ok" => false,
                    "success" => false, 
                    "message" => "Không tìm thấy quảng cáo với ID này"
                ]);
            }
        } else {
            throw new Exception("Lỗi khi xóa quảng cáo");
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
        "message" => "Thiếu ID quảng cáo cần xóa"
    ]);
}

$conn->close();
?>
