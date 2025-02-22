<?php
// [GET] [PUT] [POST] [DELETE] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/hero_section
header('Content-Type: application/json');
// Kiểm tra phương thức request
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        include __DIR__ . '/hero_section/get_hero_section.php';
        break;
    case 'POST':
        include __DIR__ . '/hero_section/post_hero_section.php';
        break;
    case 'PUT':
        include __DIR__ . '/hero_section/put_hero_section.php';
        break;
    case 'DELETE':
        include __DIR__ . '/hero_section/delete_hero_section.php';
        break;
    default:
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "Phương thức " . $_SERVER['REQUEST_METHOD'] . " không được hỗ trợ"
        ]);
}
?>