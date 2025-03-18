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
    // Lấy tham số filter từ URL
    $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
    
    // Xây dựng điều kiện WHERE dựa trên bộ lọc
    $where_clause = "";
    switch($filter) {
        case 'hot':
            $where_clause = "WHERE p.hot = 1";
            break;
        case 'fish':
            $where_clause = "WHERE p.category = 'fish'";
            break;
        case 'shrimp':
            $where_clause = "WHERE p.category = 'shrimp'";
            break;
        case 'crab':
            $where_clause = "WHERE p.category = 'crab'";
            break;
        default:
            $where_clause = "WHERE 1=1";
    }

    // Lấy 8 sản phẩm theo bộ lọc
    $sql = "SELECT p.*, 
            (SELECT pi.image_url 
             FROM product_images pi 
             WHERE pi.product_id = p.id 
             LIMIT 1) as image_url
            FROM products p
            $where_clause
            ORDER BY p.quantity_sold DESC
            LIMIT 8";

    $result = $conn->query($sql);
    if ($result === false) {
        throw new Exception("Lỗi truy vấn: " . $conn->error);
    }

    $products = [];
    $count = 0;

    while ($row = $result->fetch_assoc()) {
        $products[] = [
            "id" => $row['id'],
            "name" => $row['name'], 
            "price" => number_format($row['price'], 0, ',', '.') . ' ₫',
            "quantity_sold" => $row['quantity_sold'],
            "status" => $row['status'] == 0 ? false : true,
            "category" => $row['category'],
            "hot" => $row['hot'] == 1 ? true : false,
            "star" => $row['star'],
            "quantity" => $row['quantity'],
            "created_at" => $row['created_at'],
            "updated_at" => $row['updated_at'],
            "images" => $row['image_url']
        ];
        $count++;
    }

    // Nếu chưa đủ 8 sản phẩm, lấy thêm các sản phẩm bán chạy
    if ($count < 8) {
        $remaining = 8 - $count;
        $existing_ids = array_column($products, 'id');
        $existing_ids_str = empty($existing_ids) ? '0' : implode(',', $existing_ids);

        $additional_sql = "SELECT p.*,
                          (SELECT pi.image_url 
                           FROM product_images pi 
                           WHERE pi.product_id = p.id 
                           LIMIT 1) as image_url
                          FROM products p 
                          WHERE p.id NOT IN ($existing_ids_str)
                          ORDER BY p.quantity_sold DESC
                          LIMIT $remaining";

        $additional_result = $conn->query($additional_sql);
        if ($additional_result === false) {
            throw new Exception("Lỗi truy vấn: " . $conn->error);
        }

        while ($row = $additional_result->fetch_assoc()) {
            $products[] = [
                "id" => $row['id'],
                "name" => $row['name'],
                "price" => number_format($row['price'], 0, ',', '.') . ' ₫',
                "quantity_sold" => $row['quantity_sold'], 
                "status" => $row['status'] == 0 ? false : true,
                "category" => $row['category'],
                "hot" => $row['hot'] == 1 ? true : false,
                "star" => $row['star'],
                "quantity" => $row['quantity'],
                "created_at" => $row['created_at'],
                "updated_at" => $row['updated_at'],
                "images" => $row['image_url']
            ];
        }
        $additional_result->close();
    }

    echo json_encode([
        "ok" => true,
        "success" => true,
        "data" => $products
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