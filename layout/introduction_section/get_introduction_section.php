<?php
// [GET] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/introduction_section
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
    // Lấy ID từ URL nếu có
    $url_parts = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
    $id = end($url_parts);

    // Chuẩn bị câu lệnh SQL
    $sql = "SELECT * FROM layout_introductionssection";
    $params = [];
    $types = "";

    // Nếu có ID và ID hợp lệ, thêm điều kiện WHERE
    if (is_numeric($id)) {
        $sql .= " WHERE id = ?";
        $params[] = $id;
        $types .= "i";
    }

    // Chuẩn bị và thực thi câu lệnh
    $stmt = $conn->prepare($sql);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
        throw new Exception("Lỗi khi truy vấn: " . $stmt->error);
    }

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    if (empty($data)) {
        if (is_numeric($id)) {
            throw new Exception("Không tìm thấy bản ghi với ID = " . $id);
        } else {
            throw new Exception("Không có dữ liệu");
        }
    }

    echo json_encode([
        "ok" => true,
        "success" => true,
        "data" => is_numeric($id) ? $data[0] : $data,
        "message" => "Lấy dữ liệu thành công"
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
