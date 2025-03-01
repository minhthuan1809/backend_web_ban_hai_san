        <?php
// [GET] [PUT] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/news
header('Content-Type: application/json');

// Kiểm tra phương thức request
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $request_uri = $_SERVER['REQUEST_URI'];
        if (preg_match('/\/news\/\d+$/', $request_uri)) {
            include __DIR__ . '/detailNew.php';
        } else {
            // Lấy tất cả bản ghi từ bảng News
            include __DIR__ . '/getNew.php';
        }
        break;

    case 'PUT':
        include __DIR__ . '/putNew.php';
        break;
   
    case 'POST':
        include __DIR__ . '/postNews.php';
        break;

    case 'DELETE':
        include __DIR__ . '/deleteNews.php';
        break;
    default:
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "Phương thức " . $_SERVER['REQUEST_METHOD'] . " không được hỗ trợ"
        ]);
}
?>