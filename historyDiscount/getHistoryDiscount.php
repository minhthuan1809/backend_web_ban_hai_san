<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../core/middleware/PermissionMiddleware.php';
require_once __DIR__ . '/../config/TokenUtils.php';

if (!isset($conn) || !($conn instanceof mysqli)) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Không thể kết nối đến cơ sở dữ liệu"
    ]);
    exit;
}

try {
    $userId = TokenUtils::validateTokenAndGetUserId();
    $permissionMiddleware = new PermissionMiddleware();
    $permissionMiddleware->authorize($userId, 'get_discount');

    $sql = "SELECT dh.*, ho.*, u.id as user_id, u.fullName as user_name, u.email, u.avatar, d.name as discount_name, d.code as discount_code, d.discount_percent
            FROM discount_history dh
            JOIN history_orders ho ON dh.order_history_id = ho.id
            JOIN user u ON ho.user_id = u.id 
            JOIN discount d ON dh.discount_id = d.id";
            
    $result = $conn->query($sql);

    if ($result) {
        $historyDiscounts = [];
        while ($row = $result->fetch_assoc()) {
            $data_products = json_decode($row['data_product'], true);
            
     
            $historyDiscounts[] = $row;
        }

        echo json_encode([
            "ok" => true,
            "success" => true,
            "data" => $historyDiscounts
        ]);
    } else {
        throw new Exception("Lỗi truy vấn: " . $conn->error);
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
