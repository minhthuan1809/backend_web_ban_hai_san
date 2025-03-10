<?php
// [PUT] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/introduction_section
// {
//     "title": "string", 
//     "description": "string",
//     "content": "string",
//     "image_url": "string"
// }
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

// Kết nối database
require_once __DIR__ . '/../../config/db.php';

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

    if (empty($data)) {
        throw new Exception("Không có dữ liệu được gửi");
    }

    // Kiểm tra xem bản ghi có tồn tại không
    $check_sql = "SELECT COUNT(*) as count FROM layout_introductionssection WHERE id = 1";
    $check_result = $conn->query($check_sql);
    $row = $check_result->fetch_assoc();
    
    if ($row['count'] == 0) {
        // Nếu không tồn tại, thực hiện INSERT
        $insert_sql = "INSERT INTO layout_introductionssection (id, title, description, content, image_url) VALUES (1, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("ssss", $data['title'], $data['description'], $data['content'], $data['image_url']);
    } else {
        // Nếu tồn tại, thực hiện UPDATE
        $update_sql = "UPDATE layout_introductionssection SET title = ?, description = ?, content = ?, image_url = ? WHERE id = 1";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("ssss", $data['title'], $data['description'], $data['content'], $data['image_url']);
    }

    $result = $stmt->execute();

    if (!$result) {
        throw new Exception("Lỗi khi cập nhật: " . $stmt->error);
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
