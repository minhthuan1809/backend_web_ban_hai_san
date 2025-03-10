<?php
// [GET] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/news
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
    // Lấy tham số page, limit và search từ URL
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 6;
    $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
    $offset = ($page - 1) * $limit;

    // Lấy tổng số bản ghi với điều kiện tìm kiếm
    $total_sql = "SELECT COUNT(*) as total FROM news WHERE title LIKE '%$search%'";
    $total_result = $conn->query($total_sql);
    if ($total_result === false) {
        throw new Exception("Lỗi truy vấn: " . $conn->error);
    }
    $total_row = $total_result->fetch_assoc();
    $total_records = $total_row['total'];
    $total_pages = ceil($total_records / $limit);

    // Lấy bản ghi từ bảng news với phân trang và điều kiện tìm kiếm
    $sql = "SELECT * FROM news WHERE title LIKE '%$search%' ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
    $result = $conn->query($sql);

    if ($result === false) {
        throw new Exception("Lỗi truy vấn: " . $conn->error);
    }

    $news = [];
    while ($row = $result->fetch_assoc()) {
        // Trích xuất nội dung bên trong thẻ HTML đầu tiên trong description
        preg_match_all('/<([^>]+)>(.*?)<\/\1>/', $row['description'], $matches);
        if (count($matches[0]) > 3) {
            $description_text = '';
            foreach ($matches[2] as $content) {
                $description_text .= strip_tags($content) . ' ';
            }
        } else {
            $description_text = strip_tags($row['description']);
        }

        $news[] = [
            "id" => $row['id'],
            "title" => $row['title'],
            "description" => $description_text,
            "image_url" => $row['image_url'],
            "created_at" => $row['created_at'],
            "status" => $row['status'],
            "updated_at" => $row['updated_at']
        ];
    }

    echo json_encode([
        "ok" => true,
        "success" => true,
        "data" => $news,
        "total_pages" => $total_pages
    ]);

} catch (Exception $e) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => $e->getMessage()
    ]);
} finally {
    if (isset($result)) {
        $result->close();
    }
    if (isset($conn)) {
        $conn->close();
    }
}
?>
