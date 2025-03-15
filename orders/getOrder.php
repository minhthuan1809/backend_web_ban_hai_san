<?php
require_once __DIR__ . '/../config/db.php';

try {
    // Lấy thông tin từ bảng orders và user
    $sql = "SELECT o.*, u.fullName as user_fullName, u.email as user_email, u.avatar as user_avatar 
            FROM orders o
            LEFT JOIN user u ON o.user_id = u.id 
            ORDER BY o.created_at DESC";
    $result = $conn->query($sql);

    if ($result === false) {
        throw new Exception("Lỗi truy vấn: " . $conn->error);
    }

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
            'data' => $orders
        ]);
    } else {
        echo json_encode([
            'ok' => false,
            'success' => false,
            'message' => 'Không có đơn hàng nào'
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
