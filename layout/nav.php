<?php
header('Content-Type: application/json');

// Kiểm tra phương thức request
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        include __DIR__ . '/nav/getnav.php';
        break;
    case 'POST':
        include __DIR__ . '/nav/postnav.php';
        break;
    case 'PUT':
        include __DIR__ . '/nav/putnav.php';
        break;
    case 'DELETE':
        include __DIR__ . '/nav/deletenav.php';
        break;
    default:
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "Phương thức " . $_SERVER['REQUEST_METHOD'] . " không được hỗ trợ"
        ]);
}
?>