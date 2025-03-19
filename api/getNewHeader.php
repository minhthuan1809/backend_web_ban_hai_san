<?php
header('Content-Type: application/json');

// Sửa đường dẫn để phù hợp với cấu trúc thư mục
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
    // Lấy 4 bài viết có thời gian mới nhất
    $sql = "SELECT * FROM news WHERE status = 1 ORDER BY created_at DESC LIMIT 4";
    $result = $conn->query($sql);

    if ($result === false) {
        throw new Exception("Lỗi truy vấn: " . $conn->error);
    }

    $news = [];
    while ($row = $result->fetch_assoc()) {
        $news[] = [
            'id' => $row['id'],
            'title' => $row['title'],
            'description' => $row['description'], 
            'image_url' => $row['image_url'],
            'created_at' => $row['created_at']
        ];
    }

    echo json_encode([
        "ok" => true,
        "success" => true,
        "data" => $news
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
