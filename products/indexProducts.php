<?php
// [GET] [PUT] [POST] [DELETE] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/products/1
require_once __DIR__ . '/../core/middleware/PermissionMiddleware.php';
require_once __DIR__ . '/../config/TokenUtils.php';

header('Content-Type: application/json');

// Khởi tạo permission middleware
$permissionMiddleware = new PermissionMiddleware();

$request_uri = $_SERVER['REQUEST_URI'];
// Kiểm tra phương thức request
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (preg_match('/\/products\/\d+$/', $request_uri)) {
            include __DIR__ . '/detailProduct.php';
        }
        else if (strpos($request_uri, '/products/section') !== false) {
            include __DIR__ . '/getProductSection.php';
        }
        else {
            // Thay đổi để tránh lỗi Undefined array key "id"
            include __DIR__ . '/getProduct.php';
        }
        break;

    case 'PUT':
        $userId = TokenUtils::validateTokenAndGetUserId();
        $permissionMiddleware->authorize($userId, 'put_product');
        include __DIR__ . '/putProduct.php';
        break;
   
    case 'POST':
        $userId = TokenUtils::validateTokenAndGetUserId();
        $permissionMiddleware->authorize($userId, 'post_product');
        if (preg_match('/\/products\/img\/\d+$/', $request_uri)) {
            include __DIR__ . '/AddImgProduct.php';
          
        } else {
            include __DIR__ . '/postProduct.php';
        }
        
        break;

    case 'DELETE':
        $userId = TokenUtils::validateTokenAndGetUserId();
        $permissionMiddleware->authorize($userId, 'delete_product');
        if (preg_match('/\/products\/img\/\d+$/', $request_uri)) {
            include __DIR__ . '/deleteImgProduct.php';
        } else {
          include __DIR__ . '/deleteProduct.php';
        }
        break;
    default:
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "Phương thức " . $_SERVER['REQUEST_METHOD'] . " không được hỗ trợ"
        ]);
}
?>