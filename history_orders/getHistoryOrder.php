<?php
require_once __DIR__ . '/../config/db.php';

try {
    // Lấy tham số tìm kiếm từ request
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
    $offset = ($page - 1) * $limit;

    // Xây dựng câu query với điều kiện tìm kiếm
    $sql = "SELECT ho.*, u.fullName as user_fullName, u.email as user_email, u.avatar as user_avatar,
            COUNT(*) OVER() as total_records 
            FROM history_orders ho
            LEFT JOIN user u ON ho.user_id = u.id 
            WHERE 1=1";

    $params = array();
    $types = "";

    if (!empty($search)) {
        $search = "%$search%";
        $sql .= " AND (ho.id LIKE ? OR ho.phone LIKE ? OR ho.name LIKE ? OR u.fullName LIKE ? OR u.email LIKE ?)";
        $types .= "sssss";
        $params[] = $search;
        $params[] = $search;
        $params[] = $search;
        $params[] = $search;
        $params[] = $search;
    }

    $sql .= " ORDER BY ho.created_at DESC LIMIT ? OFFSET ?";
    $types .= "ii";
    $params[] = $limit;
    $params[] = $offset;

    $stmt = $conn->prepare($sql);

    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result === false) {
        throw new Exception("Lỗi truy vấn: " . $conn->error);
    }

    $total_records = 0;
    if ($result->num_rows > 0) {
        $history_orders = array();
        while ($row = $result->fetch_assoc()) {
            $total_records = $row['total_records'];
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
            $history_order = array(
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
                'reason' => $row['reason'],
                'products' => $product_list,
                'created_at' => $row['created_at'],
                'updated_at' => $row['updated_at']
            );

            $history_orders[] = $history_order;
        }

        echo json_encode([
            'ok' => true,
            'success' => true,
            'message' => 'Lấy danh sách lịch sử đơn hàng thành công',
            'data' => $history_orders,
            'pagination' => [
                'page' => $page,
                'limit' => $limit,
                'total_records' => (int)$total_records,
                'total_pages' => ceil($total_records / $limit)
            ]
        ]);
    } else {
        echo json_encode([
            'ok' => false,
            'success' => false,
            'message' => 'Không có lịch sử đơn hàng nào',
            'pagination' => [
                'page' => $page,
                'limit' => $limit,
                'total_records' => 0,
                'total_pages' => 0
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
