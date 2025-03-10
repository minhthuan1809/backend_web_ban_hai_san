<?php
// [PUT] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/customer_section/customer_img_section
//      {
//                "image_url": "https://scontent.fhan17-1.fna.fbcdn.net/v/t1.15752-9/476910520_1976798496147567_3316850609173496871_n.png?_nc_cat=111&ccb=1-7&_nc_sid=0024fc&_nc_eui2=AeG9rl0p6_I41QRDhQy64BpGrYwEG4xAFIqtjAQbjEAUinH6vLA-mx-HjT2g3TD0qU7o0ooePG_hLOXHrvRCOvsr&_nc_ohc=_-OmregOGi0Q7kNvgFPk-GQ&_nc_oc=AdhWp0qc0gsv5Z6E-9RhkrLB5pvb2MAtItBordLBlayMR4FcFeJRftfaWN3dhO-o1Ow&_nc_ad=z-m&_nc_cid=0&_nc_zt=23&_nc_ht=scontent.fhan17-1.fna&oh=03_Q7cD1gE-XNJYwRJIajjLkPNv79GcIoZFgi1pVNQ2OraIzszs_g&oe=67DA22C1",
//                "title": "Khách hàng nói gì về chúng tôi dgsasdfsdaf"
//            }
header('Content-Type: application/json');

// Kiểm tra phương thức request
if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Phương thức " . $_SERVER['REQUEST_METHOD'] . " không được hỗ trợ"
    ]);
    exit;
}

require_once __DIR__ . '/../../../config/db.php';

if (!isset($conn) || !($conn instanceof mysqli)) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Không thể kết nối đến cơ sở dữ liệu"
    ]);
    exit;
}


try {
    // Lấy dữ liệu từ request
    $data = json_decode(file_get_contents("php://input"), true);

    if (empty($data) || !isset($data['image_url']) || !isset($data['title'])) {
        throw new Exception("Không có dữ liệu hình ảnh hoặc tiêu đề được gửi");
    }

    // Chuẩn bị câu lệnh SQL với id = 1
    $sql = "UPDATE layout_customer_section_img SET image_url = ?, title = ? WHERE id = 1";
    
    // Chuẩn bị và thực thi câu lệnh
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $data['image_url'], $data['title']);
    $result = $stmt->execute();

    if (!$result) {
        throw new Exception("Lỗi khi cập nhật: " . $stmt->error);
    }

    if ($stmt->affected_rows === 0) {
        throw new Exception("Không có bản ghi nào được cập nhật");
    }

    echo json_encode([
        "ok" => true,
        "success" => true,
        "message" => "Cập nhật thành công"
    ]);

} catch (Exception $e) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => $e->getMessage()
    ]);
}

$conn->close();
?>
