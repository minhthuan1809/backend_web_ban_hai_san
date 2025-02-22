<?php
header('Content-Type: application/json');

// Kiểm tra phương thức request
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        include './footter/getfooter.php';
        echo "get";
        break;
    case 'POST':
        include './footter/postfooter.php';
        break;
    case 'PUT':
        include './footter/putfooter.php';
        break;
    case 'DELETE':
        include './footter/deletefooter.php';
        break;
    default:
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "Phương thức " . $_SERVER['REQUEST_METHOD'] . " không được hỗ trợ"
        ]);
}
?>