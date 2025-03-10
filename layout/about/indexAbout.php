<?php
// [GET] [PUT] [POST] [DELETE] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/about/
header('Content-Type: application/json');
require_once __DIR__ . '/../../core/middleware/PermissionMiddleware.php';
require_once __DIR__ . '/../../config/TokenUtils.php';
// Initialize permission middleware
$permissionMiddleware = new PermissionMiddleware();
// Kiểm tra phương thức request
$request_uri = $_SERVER['REQUEST_URI'];

try {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            include __DIR__ . '/getAbout.php';
            break;
        case 'POST':
            $userId = TokenUtils::validateTokenAndGetUserId();
            $permissionMiddleware->authorize($userId, 'post_about');
            if (strpos($request_uri, '/Item') !== false) {
                include __DIR__ . '/item/postItem.php';
                exit;
            }
            if (strpos($request_uri, '/OrderProcess') !== false) {
                include __DIR__ . '/OrderProcess/postOrderProcess.php';
                exit;
            }
            include __DIR__ . '/postAbout.php';
            break;
        case 'PUT':
            $userId = TokenUtils::validateTokenAndGetUserId();
            $permissionMiddleware->authorize($userId, 'put_about');
            if (strpos($request_uri, '/story') !== false) {
                include __DIR__ . '/story/putStory.php';
                exit;
            }
            if (strpos($request_uri, '/Item') !== false) {
                include __DIR__ . '/item/putItem.php';
                exit;
            }
            if (strpos($request_uri, '/space') !== false) {
                include __DIR__ . '/space/putAboutSpace.php';
                exit;
            }
            if (strpos($request_uri, '/OrderingService') !== false) {
                include __DIR__ . '/OrderingService/putOrderingService.php';
                exit;
            }
            if (strpos($request_uri, '/OrderProcess') !== false) {
                include __DIR__ . '/OrderProcess/putOrderProcess.php';
                exit;
            }
            if (strpos($request_uri, '/Commitment') !== false) {
                include __DIR__ . '/Commitment/putCommitment.php';
                exit;
            }
            include __DIR__ . '/putAbout.php';
            break;  
        case 'DELETE':
            $userId = TokenUtils::validateTokenAndGetUserId();
            $permissionMiddleware->authorize($userId, 'delete_about');
            if (strpos($request_uri, '/Item') !== false) {
                include __DIR__ . '/item/deleteItem.php';
                exit;
            }
            if (strpos($request_uri, '/OrderProcess') !== false) {
                include __DIR__ . '/OrderProcess/deleteOrderProcess.php';
                exit;
            }
            include __DIR__ . '/deleteAbout.php';
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
?>