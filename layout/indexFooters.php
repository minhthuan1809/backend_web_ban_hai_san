<?php
// [GET] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/footer
require_once __DIR__ . '/../core/middleware/PermissionMiddleware.php';
require_once __DIR__ . '/../config/TokenUtils.php';

header('Content-Type: application/json');

try {
    // Initialize permission middleware
    $permissionMiddleware = new PermissionMiddleware();
    // Kiểm tra phương thức request
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            // Kiểm tra nếu đường dẫn không phải là /footer
            $request_uri = $_SERVER['REQUEST_URI'];
            if (strpos($request_uri, '/footer') === false) {
                echo json_encode([
                    "ok" => false,
                    "success" => false,
                    "message" => "Đường dẫn không hợp lệ"
                ]);
                http_response_code(400); // Bad Request
                exit;
            }
            include __DIR__ . '/footer/getfooter.php';
            break;

        // cập nhật [put]/footer/contacts/3
        case 'PUT':
            $userId = TokenUtils::validateTokenAndGetUserId();
            $permissionMiddleware->authorize($userId, 'put_footer');
            // Kiểm tra nếu URL chứa /contacts thì chuyển hướng sang thư mục contacts
            $request_uri = $_SERVER['REQUEST_URI'];
            if (strpos($request_uri, '/contacts') !== false) {
                include __DIR__ . '/footer/contacts/putcontact.php';
                exit;
            }
            else if (strpos($request_uri, '/introduction') !== false) {
                include __DIR__ . '/footer/introduction/put_introduction.php';
                exit;
            }
            else if (strpos($request_uri, '/copyright') !== false) {
                include __DIR__ . '/footer/copyright/put_copyright.php';
                exit;
            }
            else if (strpos($request_uri, '/social') !== false) {
                include __DIR__ . '/footer/social/putsocial.php';
                exit;
            }
            break;

        // xóa  [delete]/footer/contacts/3
        case 'DELETE':
            $userId = TokenUtils::validateTokenAndGetUserId();
            $permissionMiddleware->authorize($userId, 'delete_footer');
            // Chuyển hướng yêu cầu xóa contacts vào thư mục contacts
            $request_uri = $_SERVER['REQUEST_URI'];
            if (strpos($request_uri, '/contacts') !== false) {
                include __DIR__ . '/footer/contacts/deletecontact.php'; // Chạy vào thư mục contacts
                exit;
            }
            else if (strpos($request_uri, '/social') !== false) {
                include __DIR__ . '/footer/social/deletesocial.php';
                exit;
            }
            break;

        // port
        case 'POST':
            $userId = TokenUtils::validateTokenAndGetUserId();
            $permissionMiddleware->authorize($userId, 'post_footer');
            // Kiểm tra nếu URL chứa /contacts thì chuyển hướng sang thư mục contacts
            $request_uri = $_SERVER['REQUEST_URI'];
            if (strpos($request_uri, '/contacts') !== false) {
                include __DIR__ . '/footer/contacts/postcontact.php';
                exit;
            }
            else if (strpos($request_uri, '/social') !== false) {
                include __DIR__ . '/footer/social/postsocial.php';
                exit;
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