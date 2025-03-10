<?php
// [GET] [PUT] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/introduction_section
header('Content-Type: application/json');

// Get user_id from token
require_once __DIR__ . '/../core/middleware/PermissionMiddleware.php';
require_once __DIR__ . '/../config/TokenUtils.php';

// Initialize permission middleware
$permissionMiddleware = new PermissionMiddleware();

try {
    // Kiểm tra phương thức request
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            include __DIR__ . '/introduction_section/get_introduction_section.php';
            break;

        case 'PUT':
            $userId = TokenUtils::validateTokenAndGetUserId();
            $permissionMiddleware->authorize($userId, 'put_header');
            include __DIR__ . '/introduction_section/put_introduction_section.php';
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