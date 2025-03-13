<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/db.php';

if (!isset($conn) || !($conn instanceof mysqli)) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Không thể kết nối đến cơ sở dữ liệu"
    ]);
    exit;
}

try {
    // Truy vấn để lấy tất cả các role
    $sql = "SELECT * FROM role";
    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception("Lỗi truy vấn: " . $conn->error);
    }

    $roles = [];
    while ($row = $result->fetch_assoc()) {
        if ($row['id'] != 3) {
            $roles[] = [
                'id' => $row['id'],
                'name' => $row['name']
            ];
        }
    }

    echo json_encode([
        "ok" => true,
        "success" => true,
        "data" => $roles,
        "message" => "Lấy danh sách role thành công"
    ]);

} catch (Exception $e) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => $e->getMessage()
    ]);
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
?>
