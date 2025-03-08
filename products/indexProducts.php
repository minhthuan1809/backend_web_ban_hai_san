<?php
// [GET] [PUT] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/products/1
header('Content-Type: application/json');

// Kiểm tra phương thức request
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
     $request_uri = $_SERVER['REQUEST_URI'];
        if (preg_match('/\/products\/\d+$/', $request_uri)) {
            include __DIR__ . '/detailProduct.php';
        } else {
            // Thay đổi để tránh lỗi Undefined array key "id"
            include __DIR__ . '/getProduct.php';
        }
        break;

    case 'PUT':
        include __DIR__ . '/putProduct.php';
        break;
   
    case 'POST':
        include __DIR__ . '/postProduct.php';
        
        break;

    case 'DELETE':
        include __DIR__ . '/deleteProduct.php';
        break;
    default:
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "Phương thức " . $_SERVER['REQUEST_METHOD'] . " không được hỗ trợ"
        ]);
}
?>