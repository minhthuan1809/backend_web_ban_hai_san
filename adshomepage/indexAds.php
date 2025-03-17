<?php
// [GET] [PUT] [POST] [DELETE] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/users
require_once __DIR__ . '/../core/middleware/PermissionMiddleware.php';
require_once __DIR__ . '/../config/TokenUtils.php';

header('Content-Type: application/json');

// Khởi tạo permission middleware
$permissionMiddleware = new PermissionMiddleware();

try {
    // Kiểm tra quyền truy cập dựa trên phương thức request
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            if (file_exists(__DIR__ . '/getads.php')) {
                include __DIR__ . '/getads.php';
            } else {
                throw new Exception("Không tìm thấy file getads.php");
            }
            break;

        case 'PUT':
            $userId = TokenUtils::validateTokenAndGetUserId();
            $permissionMiddleware->authorize($userId, 'put_header');
            if (file_exists(__DIR__ . '/putAds.php')) {
                include __DIR__ . '/putAds.php';
            } else {
                throw new Exception("Không tìm thấy file putAds.php");
            }
            break;
   
        case 'POST':
            $userId = TokenUtils::validateTokenAndGetUserId();
            $permissionMiddleware->authorize($userId, 'post_header');
            if (file_exists(__DIR__ . '/postAds.php')) {
                include __DIR__ . '/postAds.php';
            } else {
                throw new Exception("Không tìm thấy file postAds.php");
            }
            break;

        case 'DELETE':
            $userId = TokenUtils::validateTokenAndGetUserId();
            $permissionMiddleware->authorize($userId, 'delete_header');
            if (file_exists(__DIR__ . '/deleteAds.php')) {
                include __DIR__ . '/deleteAds.php';
            } else {
                throw new Exception("Không tìm thấy file deleteAds.php");
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
    // Xử lý lỗi bao gồm cả lỗi phân quyền
    http_response_code(403);
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
?>