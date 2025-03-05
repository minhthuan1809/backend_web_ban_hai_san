<?php
// [GET] [POST] [DELETE] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/send_contacts   
header('Content-Type: application/json');
// Kiểm tra phương thức request
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        include __DIR__ . '/getContact.php';
        break;
    case 'POST':
        include __DIR__ . '/postContact.php';
        break; 
    case 'DELETE':
        include __DIR__ . '/deleteContact.php';
        break;
    case 'PUT':
        include __DIR__ . '/putContact.php';
    default:
        break;
       ;
}
?>