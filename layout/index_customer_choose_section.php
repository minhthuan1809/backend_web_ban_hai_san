<?php
// [GET] [PUT] [POST] [DELETE] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/customer_choose_section
require_once __DIR__ . '/../core/middleware/PermissionMiddleware.php';
require_once __DIR__ . '/../config/TokenUtils.php';
header('Content-Type: application/json');

// Get user_id from token


// Initialize permission middleware
$permissionMiddleware = new PermissionMiddleware();
// Kiểm tra phương thức request
$request_uri = $_SERVER['REQUEST_URI'];

try {
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        include __DIR__ . '/customer_choose_section/get_customer_choose_section.php';
        break;
    case 'POST':
        $userId = TokenUtils::validateTokenAndGetUserId();
        $permissionMiddleware->authorize($userId, 'post_header');
        if (strpos($request_uri, '/item') !== false) {
            include __DIR__ . '/customer_choose_section/item/post_customer_choose_item_section.php';
            exit;
        }
        include __DIR__ . '/customer_choose_section/post_customer_choose_section.php';
        break;
    case 'PUT':
        $userId = TokenUtils::validateTokenAndGetUserId();
        $permissionMiddleware->authorize($userId, 'put_header');
        if (strpos($request_uri, '/customer__section') !== false) {
            include __DIR__ . '/customer_choose_section/bg_title/put_customer_choose.php';
            exit;
        }
        else if (strpos($request_uri, '/item') !== false) {
            include __DIR__ . '/customer_choose_section/item/put_customer_choose_item_section.php';
            exit;
        }
        break;
    case 'DELETE':
        $userId = TokenUtils::validateTokenAndGetUserId();
        $permissionMiddleware->authorize($userId, 'delete_header');
        if (strpos($request_uri, '/item') !== false) {
            include __DIR__ . '/customer_choose_section/item/delete_customer_choose_item_section.php';
            exit;
        }
        break;
    default:
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "Phương thức " . $_SERVER['REQUEST_METHOD'] . " không được hỗ trợ"
        ]);
        exit;
}
} catch (Exception $e) {
    http_response_code(401);
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Đã có lỗi xảy ra: " . $e->getMessage()
    ]);
}