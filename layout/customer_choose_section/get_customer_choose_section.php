<?php
// [GET] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/customer_choose_section
header('Content-Type: application/json');

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
    // Lấy dữ liệu từ bảng layout_customer_choose_section
    $sql1 = "SELECT * FROM layout_customer_choose_section";
    $result1 = $conn->query($sql1);
    
    // Lấy dữ liệu từ bảng layout_customer_choose_item_section
    $sql2 = "SELECT * FROM layout_customer_choose_item_section";
    $result2 = $conn->query($sql2);

    if ($result1 === false || $result2 === false) {
        throw new Exception("Lỗi truy vấn cơ sở dữ liệu");
    }

    $customer_choose = [];
    $customer_choose_items = [];

    // Xử lý dữ liệu từ bảng layout_customer_choose_section
    while ($row = $result1->fetch_assoc()) {
        $customer_choose[] = [
            "id" => $row["id"],
            "title" => $row["title"],
            "image_url" => $row["image_url"]
        ];
    }

    // Xử lý dữ liệu từ bảng layout_customer_choose_item_section
    while ($row = $result2->fetch_assoc()) {
        $customer_choose_items[] = [
            "id" => $row["id"],
            "icon" => $row["icon"],
            "title" => $row["title"],
            "description" => $row["description"]
        ];
    }

    echo json_encode([
        "ok" => true,
        "success" => true,
        "message" => "Lấy dữ liệu thành công",
        "data" => [
            "img_title" => $customer_choose,
            "item" => $customer_choose_items
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
