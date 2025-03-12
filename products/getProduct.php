<?php
// [GET] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/products
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
    // Lấy tham số page, limit và search từ URL
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 20; // Đặt limit là 2 như yêu cầu
    $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
    $offset = ($page - 1) * $limit;

    // Xây dựng điều kiện tìm kiếm: tìm theo cả name và category
    $search_condition = "p.name LIKE '%$search%' OR p.category LIKE '%$search%'";

    // Lấy tổng số bản ghi với điều kiện tìm kiếm cập nhật
    $total_sql = "SELECT COUNT(DISTINCT p.id) as total FROM products p WHERE $search_condition";
    $total_result = $conn->query($total_sql);
    if ($total_result === false) {
        throw new Exception("Lỗi truy vấn: " . $conn->error);
    }
    $total_row = $total_result->fetch_assoc();
    $total_records = $total_row['total'];
    $total_pages = ceil($total_records / $limit);

    // Sửa lại câu truy vấn để tìm theo cả name và category
    $sql = "SELECT DISTINCT p.id FROM products p 
            WHERE $search_condition
            ORDER BY p.created_at DESC 
            LIMIT $offset, $limit";
    
    $result = $conn->query($sql);
    if ($result === false) {
        throw new Exception("Lỗi truy vấn: " . $conn->error);
    }

    $product_ids = [];
    while ($row = $result->fetch_assoc()) {
        $product_ids[] = $row['id'];
    }

    $products = [];

    // Chỉ khi có sản phẩm thỏa mãn điều kiện
    if (!empty($product_ids)) {
        $product_ids_str = implode(',', $product_ids);
        
        // Lấy thông tin chi tiết của các sản phẩm và hình ảnh đầu tiên
        $product_sql = "SELECT p.*, 
                        (SELECT pi.image_url 
                         FROM product_images pi 
                         WHERE pi.product_id = p.id 
                         LIMIT 1) as image_url
                        FROM products p 
                        WHERE p.id IN ($product_ids_str) 
                        ORDER BY p.created_at DESC";
                        
        $product_result = $conn->query($product_sql);
        if ($product_result === false) {
            throw new Exception("Lỗi truy vấn: " . $conn->error);
        }

        while ($row = $product_result->fetch_assoc()) {
            $products[] = [
                "id" => $row['id'],
                "name" => $row['name'],
                "description" => $row['description'],
                "price" => number_format($row['price'], 0, ',', '.') . ' ₫',
                "quantity_sold" => $row['quantity_sold'],
                "status" => $row['status'] == 0 ? false : true,
                "category" => $row['category'],
                "hot" => $row['hot'] == 1 ? true : false,
                "star" => $row['star'],
                "quantity" => $row['quantity'],
                "created_at" => $row['created_at'],
                "updated_at" => $row['updated_at'],
                "images" => $row['image_url'] // Sử dụng ảnh mặc định nếu không có
            ];
        }
    }

    echo json_encode([
        "ok" => true,
        "success" => true,
        "data" => $products,
        "total_pages" => $total_pages,
        "total_records" => $total_records,
        "current_page" => $page,
        "limit" => $limit
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
    if (isset($product_result)) {
        $product_result->close();
    }
    if (isset($conn)) {
        $conn->close();
    }
}
?>