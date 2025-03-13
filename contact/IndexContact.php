<?php
// [GET] [POST] [DELETE] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/send_contacts   
require_once __DIR__ . '/../core/middleware/PermissionMiddleware.php';
require_once __DIR__ . '/../config/TokenUtils.php';
header('Content-Type: application/json');
// Kiểm tra phương thức request
$permissionMiddleware = new PermissionMiddleware();
$request_uri = $_SERVER['REQUEST_URI'];
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $userId = TokenUtils::validateTokenAndGetUserId();
        $permissionMiddleware->authorize($userId, 'get_contacts');
        if (preg_match('/\/send_contacts\/history/', $request_uri)) {
            include __DIR__ . '/sent_email/getHistory.php';
        }else{
            include __DIR__ . '/getContact.php';
        }
        break;
    case 'POST':
        if (preg_match('/\/send_contacts\/history/', $request_uri)) {
            include __DIR__ . '/sent_email/postHistory.php';
        }else{
            include __DIR__ . '/postContact.php';
        }
        break; 
    case 'DELETE':
        $userId = TokenUtils::validateTokenAndGetUserId();
        $permissionMiddleware->authorize($userId, 'delete_contacts');
        if (preg_match('/\/send_contacts\/history/', $request_uri)) {
            include __DIR__ . '/sent_email/deleteHistory.php';
        }else{
            include __DIR__ . '/deleteContact.php';
        }
        break;
    case 'PUT':
        include __DIR__ . '/putContact.php';
        break;
    default:
        break;
}
?>