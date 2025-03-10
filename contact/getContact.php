<?php

// Kết nối đến cơ sở dữ liệu
require_once __DIR__ . '/../config/db.php';
$headers = apache_request_headers();



if (!isset($conn) || !($conn instanceof mysqli)) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Không thể kết nối đến cơ sở dữ liệu"
    ]);
    exit;
}

try {
    // Lấy tham số page, limit và search từ URL
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Mặc định là 1
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10; // Mặc định là 10
    $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
    $offset = ($page - 1) * $limit;

    // Lấy tổng số bản ghi để tính toán tổng số trang
    $total_sql = "SELECT COUNT(*) as total FROM contacts WHERE name LIKE '%$search%' OR gmail LIKE '%$search%'";
    $total_result = $conn->query($total_sql);
    if ($total_result === false) {
        throw new Exception("Lỗi truy vấn: " . $conn->error);
    }
    $total_row = $total_result->fetch_assoc();
    $total_records = $total_row['total'];
    $total_pages = ceil($total_records / $limit);

    // Lấy dữ liệu từ bảng Contacts với điều kiện tìm kiếm và giới hạn, sắp xếp theo ngày mời nhất
    $sql = "SELECT * FROM contacts WHERE name LIKE '%$search%' OR gmail LIKE '%$search%' ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
    $result = $conn->query($sql);

    if ($result === false) {
        throw new Exception("Lỗi truy vấn: " . $conn->error);
    }

    $contacts = [];
    while ($row = $result->fetch_assoc()) {
        $contacts[] = [
            "id" => $row['id'],
            "name" => $row['name'],
            "content" => $row['content'],
            "gmail" => $row['gmail'],
            "title" => $row['title'],
            "is_read" => $row['is_read'] == 1 ? true : false,
            "is_sent" => $row['is_sent'] == 1 ? true : false,
            "created_at" => $row['created_at'],
            "updated_at" => $row['updated_at']
        ];
    }

    echo json_encode([
        "ok" => true,
        "success" => true,
        "data" => $contacts,
        "total_pages" => $total_pages // Trả về tổng số trang
    ]);

} catch (Exception $e) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => $e->getMessage()
    ]);
} finally {
    $conn->close();
}
?>