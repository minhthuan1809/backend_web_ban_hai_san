<?php
// [GET] [PUT] [POST] [DELETE] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/address/{id}

header('Content-Type: application/json');



try {
    // Kiểm tra quyền truy cập dựa trên phương thức request
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            include __DIR__ . '/getDetailAddress.php';
            break;
        case 'PUT':
            include __DIR__ . '/putAddress.php';
            break;
        case 'POST':
            include __DIR__ . '/postAddress.php'; 
            break;
        case 'DELETE':
            include __DIR__ . '/deleteAddress.php';
            break;

        default:
            echo json_encode([
                "ok" => false,
                "success" => false,
                "message" => "Phương thức " . $_SERVER['REQUEST_METHOD'] . " không được hỗ trợ"
            ]);
    }
} catch (Exception $e) {
    // Xử lý lỗi bao gồm cả lỗi phân quyền
    http_response_code(403);
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
?>