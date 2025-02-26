<?php
// [GET] [PUT] [POST] [DELETE] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/customer_choose_section
header('Content-Type: application/json');
// Kiểm tra phương thức request
$request_uri = $_SERVER['REQUEST_URI'];

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        include __DIR__ . '/customer_choose_section/get_customer_choose_section.php';
        break;
    case 'POST':
        if (strpos($request_uri, '/item') !== false) {
            include __DIR__ . '/customer_choose_section/item/post_customer_choose_item_section.php';
            exit;
        }
        include __DIR__ . '/customer_choose_section/post_customer_choose_section.php';
        break;
    case 'PUT':
        if (strpos($request_uri, '/customer__section') !== false) {
            include __DIR__ . '/customer_choose_section/bg_title/put_customer_choose.php';
            exit;
        }
        else if (strpos($request_uri, '/item') !== false) {
            include __DIR__ . '/customer_choose_section/item/put_customer_choose_item_section.php';
            exit;
        }
        break;
    case 'DELETE':
        if (strpos($request_uri, '/item') !== false) {
            include __DIR__ . '/customer_choose_section/item/delete_customer_choose_item_section.php';
            exit;
        }
        break;
    default:
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "Phương thức " . $_SERVER['REQUEST_METHOD'] . " không được hỗ trợ"
        ]);
        exit;
}
?>