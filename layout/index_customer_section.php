<?php
// [GET] [PUT] [POST] [DELETE] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/customer_section
header('Content-Type: application/json');
// Kiểm tra phương thức request
$request_uri = $_SERVER['REQUEST_URI'];

require_once __DIR__ . '/../core/middleware/PermissionMiddleware.php';
require_once __DIR__ . '/../config/TokenUtils.php';

// Get user_id from token

$permissionMiddleware = new PermissionMiddleware();
try {

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        include __DIR__ . '/customer/get_customer_section.php';
        break;
    case 'POST':
        $userId = TokenUtils::validateTokenAndGetUserId();
        $permissionMiddleware->authorize($userId, 'post_header');
        include __DIR__ . '/customer/customer_section/post_customer_section.php';
        break;
    case 'PUT':
        $userId = TokenUtils::validateTokenAndGetUserId();
        $permissionMiddleware->authorize($userId, 'put_header');
        if (strpos($request_uri, '/customer__section') !== false) {
            include __DIR__ . '/customer/customer_section/put_customer_section.php';
            exit;
        }
        else if (strpos($request_uri, '/customer_img_section') !== false) {
            include __DIR__ . '/customer/customer_section_img/put_customer_section_img.php';
            exit;
        }
       
        break;
    case 'DELETE':
        $userId = TokenUtils::validateTokenAndGetUserId();
        $permissionMiddleware->authorize($userId, 'delete_header');
        include __DIR__ . '/customer/customer_section/delete_customer_section.php';
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