<?php
// [GET] [PUT] [POST] [DELETE] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/hero_section
require_once __DIR__ . '/../core/middleware/PermissionMiddleware.php';
require_once __DIR__ . '/../config/TokenUtils.php';

header('Content-Type: application/json');

// Khởi tạo permission middleware
$permissionMiddleware = new PermissionMiddleware();

try {
    // Kiểm tra phương thức request
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            include __DIR__ . '/hero_section/get_hero_section.php';
            break;
        case 'POST':
            $userId = TokenUtils::validateTokenAndGetUserId();
            $permissionMiddleware->authorize($userId, 'post_header');
            include __DIR__ . '/hero_section/post_hero_section.php';
            break;
        case 'PUT':
            $userId = TokenUtils::validateTokenAndGetUserId();
            $permissionMiddleware->authorize($userId, 'put_header');
            include __DIR__ . '/hero_section/put_hero_section.php';
            break;
        case 'DELETE':
            $userId = TokenUtils::validateTokenAndGetUserId();
            $permissionMiddleware->authorize($userId, 'delete_header');
            include __DIR__ . '/hero_section/delete_hero_section.php';
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