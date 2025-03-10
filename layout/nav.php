<?php
// [GET] [PUT] [POST] [DELETE] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/nav
require_once __DIR__ . '/../core/middleware/PermissionMiddleware.php';
require_once __DIR__ . '/../config/TokenUtils.php';

header('Content-Type: application/json');

$permissionMiddleware = new PermissionMiddleware();
try {

    // Kiểm tra phương thức request
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            include __DIR__ . '/nav/getnav.php';
            break;
        case 'POST':
            try {
                // Lấy user_id từ token
                $userId = TokenUtils::validateTokenAndGetUserId();
                // Khởi tạo permission middleware
                $permissionMiddleware->authorize($userId, 'post_nav_logo');
                include __DIR__ . '/nav/postnav.php';
            } catch (Exception $e) {
                echo json_encode([
                    "ok" => false,
                    "success" => false,
                    "message" => $e->getMessage()
                ]);
            }
            break;
        case 'PUT':
            try {
                // Lấy user_id từ token  
                $userId = TokenUtils::validateTokenAndGetUserId();
                // Khởi tạo permission middleware
                $permissionMiddleware->authorize($userId, 'put_nav_logo');
                include __DIR__ . '/nav/putnav.php';
            } catch (Exception $e) {
                echo json_encode([
                    "ok" => false,
                    "success" => false,
                    "message" => $e->getMessage()
                ]);
            }
            break;
        case 'DELETE':
            try {
                // Lấy user_id từ token
                $userId = TokenUtils::validateTokenAndGetUserId();
                // Khởi tạo permission middleware
                $permissionMiddleware->authorize($userId, 'delete_nav_logo');
                include __DIR__ . '/nav/deletenav.php';
            } catch (Exception $e) {
                echo json_encode([
                    "ok" => false,
                    "success" => false,
                    "message" => $e->getMessage()
                ]);
            }
            break;
        default:
            echo json_encode([
                "ok" => false,
                "success" => false,
                "message" => "Phương thức " . $_SERVER['REQUEST_METHOD'] . " không được hỗ trợ"
            ]);
    }
} catch (Exception $e) {
    http_response_code(401);
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Đã có lỗi xảy ra: " . $e->getMessage()
    ]);
}
?>