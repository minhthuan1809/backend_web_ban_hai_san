<?php
// [GET] [POST] [DELETE] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/send_contacts   
require_once __DIR__ . '/../core/middleware/PermissionMiddleware.php';
require_once __DIR__ . '/../config/TokenUtils.php';
header('Content-Type: application/json');
// Kiểm tra phương thức request
$permissionMiddleware = new PermissionMiddleware();
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $userId = TokenUtils::validateTokenAndGetUserId();
        $permissionMiddleware->authorize($userId, 'get_contacts');
        include __DIR__ . '/getContact.php';
        break;
    case 'POST':
        include __DIR__ . '/postContact.php';
        break; 
    case 'DELETE':
        $userId = TokenUtils::validateTokenAndGetUserId();
        $permissionMiddleware->authorize($userId, 'delete_contacts');
        include __DIR__ . '/deleteContact.php';
        break;
    case 'PUT':
        include __DIR__ . '/putContact.php';
        break;
    default:
        break;
}
?>