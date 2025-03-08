        <?php
// [GET] [PUT] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/news
require_once __DIR__ . '/../core/middleware/PermissionMiddleware.php';
require_once __DIR__ . '/../config/TokenUtils.php';

header('Content-Type: application/json');

// Get user_id from token
$userId = TokenUtils::validateTokenAndGetUserId();

// Initialize permission middleware
$permissionMiddleware = new PermissionMiddleware();

try {
    // Check permission based on request method
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $permissionMiddleware->authorize($userId, 'put_new');
            $request_uri = $_SERVER['REQUEST_URI'];
            if (preg_match('/\/news\/\d+$/', $request_uri)) {
                include __DIR__ . '/detailNew.php';
            } else {
                // Lấy tất cả bản ghi từ bảng News
                include __DIR__ . '/getNew.php';
            }
            break;

        case 'PUT':
            $permissionMiddleware->authorize($userId, 'put_new');
            include __DIR__ . '/putNew.php';
            break;
   
        case 'POST':
            $permissionMiddleware->authorize($userId, 'post_new');
            include __DIR__ . '/postNews.php';
            break;

        case 'DELETE':
            $permissionMiddleware->authorize($userId, 'delete_new');
            include __DIR__ . '/deleteNew.php';
            break;

        default:
            echo json_encode([
                "ok" => false,
                "success" => false,
                "message" => "Phương thức " . $_SERVER['REQUEST_METHOD'] . " không được hỗ trợ"
            ]);
    }
} catch (Exception $e) {
    // Handle any errors including permission errors
    http_response_code(403);
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
?>