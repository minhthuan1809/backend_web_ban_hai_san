<?php
// [GET] [PUT] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/introduction_section
header('Content-Type: application/json');

// Kiểm tra phương thức request
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        include __DIR__ . '/introduction_section/get_introduction_section.php';
        break;

    case 'PUT':
        include __DIR__ . '/introduction_section/put_introduction_section.php';
        break;
   
    default:
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "Phương thức " . $_SERVER['REQUEST_METHOD'] . " không được hỗ trợ"
        ]);
}
?>