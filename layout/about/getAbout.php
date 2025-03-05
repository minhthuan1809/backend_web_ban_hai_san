<?php
// Start Generation Here

require_once __DIR__ . '/../../config/db.php'; // Đã sửa đường dẫn

if (!isset($conn) || !($conn instanceof mysqli)) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Không thể kết nối đến cơ sở dữ liệu"
    ]);
    exit;
}

try {
    // Lấy dữ liệu từ tất cả các bảng
    $tables = ['layout_story', 'layout_ordering_process', 'layout_ordering_online', 'layout_space', 'layout_benefit', 'layout_commitment'];
    $data = [];

    foreach ($tables as $table) {
        $sql = "SELECT * FROM $table";
        $result = $conn->query($sql);

        if (!$result) {
            throw new Exception("Lỗi truy vấn $table: " . $conn->error);
        }

        while ($row = $result->fetch_assoc()) {
            $data[$table][] = $row;
        }
    }

    echo json_encode([
        "ok" => true,
        "success" => true,
        "data" => $data
    ]);

} catch (Exception $e) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Lỗi: " . $e->getMessage()
    ]);
} finally {
    if (isset($conn) && $conn instanceof mysqli) {
        $conn->close();
    }
}
