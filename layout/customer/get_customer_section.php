<?php
// [GET] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/customer_section
header('Content-Type: application/json');

// Kiểm tra phương thức request
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Phương thức " . $_SERVER['REQUEST_METHOD'] . " không được hỗ trợ"
    ]);
    exit;
}

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
    // Lấy dữ liệu từ bảng customer_section
    $sql_section = "SELECT * FROM layout_customer_section";
    $result_section = $conn->query($sql_section);

    if (!$result_section) {
        throw new Exception("Lỗi truy vấn customer_section: " . $conn->error);
    }

    // Lấy dữ liệu từ bảng customer_section_img
    $sql_img = "SELECT * FROM layout_customer_section_img";
    $result_img = $conn->query($sql_img);

    if (!$result_img) {
        throw new Exception("Lỗi truy vấn customer_section_img: " . $conn->error);
    }

    $sections = [];
    while ($row = $result_section->fetch_assoc()) {
        $sections[] = [
            "id" => $row['id'],
            "name" => $row['name'],
            "image_url" => $row['image_url'],
            "description" => $row['description']
        ];
    }

    $images = [];
    while ($row = $result_img->fetch_assoc()) {
        $images[] = [
            "id" => $row['id'],
            "image_url" => $row['image_url'],
            "title" => $row['title']
        ];
    }

    echo json_encode([
        "ok" => true,
        "success" => true,
        "data" => [
            "sections" => $sections,
            "images" => $images
        ]
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
