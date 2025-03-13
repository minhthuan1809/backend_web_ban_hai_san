<?php
require_once __DIR__ . '/../../config/db.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Tạo bảng email_history nếu chưa tồn tại
$createTable = "CREATE TABLE IF NOT EXISTS email_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    content TEXT NOT NULL,
    gmail VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($createTable);

// Lấy tham số tìm kiếm từ URL
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

// Lấy tham số phân trang
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
$offset = ($page - 1) * $limit;

// Xây dựng điều kiện tìm kiếm
$whereClause = "";
if (!empty($search)) {
    $whereClause = "WHERE gmail LIKE '%$search%' OR title LIKE '%$search%'";
}

// Lấy tổng số bản ghi để tính toán tổng số trang
$total_sql = "SELECT COUNT(*) as total FROM email_history $whereClause";
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_assoc();
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);

// Lấy lịch sử email với điều kiện tìm kiếm và phân trang
$sql = "SELECT id, content, gmail, title, created_at FROM email_history 
        $whereClause 
        ORDER BY created_at DESC 
        LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

if ($result) {
    $emails = array();
    while ($row = $result->fetch_assoc()) {
        $emails[] = array(
            'id' => $row['id'],
            'content' => $row['content'],
            'gmail' => $row['gmail'], 
            'title' => $row['title'],
            'created_at' => $row['created_at']
        );
    }
    
    echo json_encode([
        "ok" => true,
        "data" => $emails,
        "pagination" => [
            "total_records" => $total_records,
            "total_pages" => $total_pages,
            "current_page" => $page,
            "limit" => $limit
        ]
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        "ok" => false,
        "message" => "Không thể lấy lịch sử email"
    ]);
}

$conn->close();
?>
