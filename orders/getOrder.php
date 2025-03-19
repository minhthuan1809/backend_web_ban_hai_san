<?php
require_once __DIR__ . '/../config/db.php';

try {
    // Lấy tham số từ request
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
    $offset = ($page - 1) * $limit;

    // Xây dựng câu truy vấn cơ sở
    $sql = "SELECT o.*, u.fullName as user_fullName, u.email as user_email, u.avatar as user_avatar 
            FROM orders o
            LEFT JOIN user u ON o.user_id = u.id";

    // Thêm điều kiện tìm kiếm nếu có
    if (!empty($search)) {
        $search = "%$search%";
        $sql .= " WHERE o.id LIKE ? OR o.phone LIKE ? OR u.email LIKE ?";
    }

    // Thêm sắp xếp và phân trang
    $sql .= " ORDER BY o.created_at DESC LIMIT ? OFFSET ?";

    // Chuẩn bị và thực thi truy vấn
    $stmt = $conn->prepare($sql);
    if (!empty($search)) {
        $stmt->bind_param("sssii", $search, $search, $search, $limit, $offset);
    } else {
        $stmt->bind_param("ii", $limit, $offset);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result === false) {
        throw new Exception("Lỗi truy vấn: " . $conn->error);
    }

    // Đếm tổng số đơn hàng
    $count_sql = "SELECT COUNT(*) as total FROM orders o LEFT JOIN user u ON o.user_id = u.id";
    if (!empty($search)) {
        $count_sql .= " WHERE o.id LIKE ? OR o.phone LIKE ? OR u.email LIKE ?";
        $count_stmt = $conn->prepare($count_sql);
        $count_stmt->bind_param("sss", $search, $search, $search);
    } else {
        $count_stmt = $conn->prepare($count_sql);
    }
    $count_stmt->execute();
    $total_result = $count_stmt->get_result();
    $total_row = $total_result->fetch_assoc();
    $total = $total_row['total'];
    $total_pages = ceil($total / $limit);

    if ($result->num_rows > 0) {
        $orders = array();
        while ($row = $result->fetch_assoc()) {
            // Chuyển đổi chuỗi data_product thành mảng
            $products = json_decode($row['data_product'], true);
            
            // Lấy thông tin sản phẩm
            $product_list = array();
            if (!empty($products)) {
                foreach($products as $product) {
                    $product_id = $product['product_id'];
                    $quantity = $product['quantity'];
                    
                    $products_sql = "SELECT p.id, p.name, p.price, p.description, 
                                    (SELECT pi.image_url 
                                     FROM product_images pi 
                                     WHERE pi.product_id = p.id 
                                     LIMIT 1) as img
                                   FROM products p
                                   WHERE p.id = ?";
                                   
                    $stmt = $conn->prepare($products_sql);
                    $stmt->bind_param("i", $product_id);
                    $stmt->execute();
                    $products_result = $stmt->get_result();
                    
                    if ($products_result && $products_result->num_rows > 0) {
                        $product_data = $products_result->fetch_assoc();
                        $product_list[] = array(
                            'id' => $product_data['id'],
                            'img' => $product_data['img'],
                            'name' => $product_data['name'],
                            'price' => $product_data['price'],
                            'quantity' => $quantity
                        );
                    }
                }
            }

            // Tạo mảng thông tin đơn hàng
            $order = array(
                'id' => $row['id'],
                'user_id' => $row['user_id'],
                'user' => array(
                    'fullName' => $row['user_fullName'],
                    'email' => $row['user_email'], 
                    'avatar' => $row['user_avatar']
                ),
                'name' => $row['name'],
                'phone' => $row['phone'],
                'address' => $row['address'],
                'note' => $row['note'],
                'discount_code' => $row['discount_code'],
                'discount_percent' => $row['discount_percent'],
                'final_total' => $row['final_total'],
                'free_of_charge' => $row['free_of_charge'],
                'payment_method' => $row['payment_method'],
                'status' => $row['status'],
                'products' => $product_list,
                'created_at' => $row['created_at'],
                'updated_at' => $row['updated_at'],
            );

            $orders[] = $order;
        }

        echo json_encode([
            'ok' => true,
            'success' => true,
            'message' => 'Lấy danh sách đơn hàng thành công',
            'data' => [
                'orders' => $orders,
                'pagination' => [
                    'page' => $page,
                    'limit' => $limit,
                    'total' => $total,
                    'total_pages' => $total_pages
                ]
            ]
        ]);
    } else {
        echo json_encode([
            'ok' => true,
            'success' => false,
            'message' => 'Không có đơn hàng nào',
            'data' => [
                'orders' => [],
                'pagination' => [
                    'page' => $page,
                    'limit' => $limit,
                    'total' => 0,
                    'total_pages' => 0
                ]
            ]
        ]);
    }

} catch(Exception $e) {
    http_response_code(500);
    echo json_encode([
        'ok' => false,
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

$conn->close();
?>
