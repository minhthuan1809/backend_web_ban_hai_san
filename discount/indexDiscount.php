<?php
// [GET] [PUT] [POST] [DELETE] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/discount
require_once __DIR__ . '/../core/middleware/PermissionMiddleware.php';
require_once __DIR__ . '/../config/TokenUtils.php';

header('Content-Type: application/json');

// Khởi tạo permission middleware
$permissionMiddleware = new PermissionMiddleware();

$request_uri = $_SERVER['REQUEST_URI'];
// Kiểm tra phương thức request
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (preg_match('/\/discount\/search/', $request_uri)) {
            include __DIR__ . '/searchDiscount.php';
        } else {
            $userId = TokenUtils::validateTokenAndGetUserId();
            $permissionMiddleware->authorize($userId, 'get_discount');
            include __DIR__ . '/getDiscount.php';
        }
        break;

    case 'PUT':
        $userId = TokenUtils::validateTokenAndGetUserId();
        $permissionMiddleware->authorize($userId, 'put_discount');
        include __DIR__ . '/putDiscount.php';
        break;
   
    case 'POST':
        $userId = TokenUtils::validateTokenAndGetUserId();
        $permissionMiddleware->authorize($userId, 'post_discount');
        include __DIR__ . '/postDiscount.php';
        break;

    case 'DELETE':
        $userId = TokenUtils::validateTokenAndGetUserId();
        $permissionMiddleware->authorize($userId, 'delete_discount');
        include __DIR__ . '/deleteDiscount.php';
        break;
        
    default:
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "Phương thức " . $_SERVER['REQUEST_METHOD'] . " không được hỗ trợ"
        ]);
}
?>