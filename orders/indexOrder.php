<?php
// [GET] [PUT] [POST] [DELETE] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/order
require_once __DIR__ . '/../core/middleware/PermissionMiddleware.php';
require_once __DIR__ . '/../config/TokenUtils.php';

header('Content-Type: application/json');

// Khởi tạo permission middleware
$permissionMiddleware = new PermissionMiddleware();

try {
    // Kiểm tra quyền truy cập dựa trên phương thức request
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            try {
                $userId = TokenUtils::validateTokenAndGetUserId();
                $permissionMiddleware->authorize($userId, 'get_order');
                include __DIR__ . '/getOrder.php';
            } catch (Exception $e) {
                http_response_code(404);
                echo json_encode([
                    "ok" => false,
                    "success" => false,
                    "message" => "Không có đơn hàng nào"
                ]);
            }
            break;

        case 'PUT':
            $userId = TokenUtils::validateTokenAndGetUserId();
            $permissionMiddleware->authorize($userId, 'put_order');
            include __DIR__ . '/putOrder.php';
            break;
   
        case 'POST':
          
            include __DIR__ . '/potsOrder.php';
            break;

        case 'DELETE':
            $userId = TokenUtils::validateTokenAndGetUserId();
            $permissionMiddleware->authorize($userId, 'delete_order');
            include __DIR__ . '/deleteOrder.php';
            break;

        default:
            echo json_encode([
                "ok" => false,
                "success" => false,
                "message" => "Phương thức " . $_SERVER['REQUEST_METHOD'] . " không được hỗ trợ"
            ]);
    }
} catch (Exception $e) {
    // Xử lý lỗi bao gồm cả lỗi phân quyền
    http_response_code(403);
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
?>