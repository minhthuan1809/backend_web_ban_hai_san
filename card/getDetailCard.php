<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/TokenUtils.php';
// [GET] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/cart
header('Content-Type: application/json');

// Kiểm tra phương thức request
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Phương thức không hợp lệ, vui lòng sử dụng GET"
    ]);
    exit;
}

try {
    // Kiểm tra token xác thực
    $headers = getallheaders();
    if (!isset($headers['Authorization'])) {
        http_response_code(401);
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "Lỗi xác thực - Token không tồn tại"
        ]);
        exit;
    }

    $token = str_replace('Bearer ', '', $headers['Authorization']);

    // Xác thực token và lấy user_id từ token
    $userId = TokenUtils::validateTokenAndGetUserId($token);
    if (!$userId) {
        throw new Exception("Token không hợp lệ hoặc đã hết hạn");
    }

    // Kiểm tra xem token có thuộc về user hiện tại không
    $sql = "SELECT id FROM user WHERE id = ?";
    $checkUserToken = $conn->prepare($sql);
    if ($checkUserToken === false) {
        throw new Exception("Lỗi chuẩn bị câu lệnh SQL: " . $conn->error);
    }
    
    $checkUserToken->bind_param("i", $userId);
    $checkUserToken->execute();
    $result = $checkUserToken->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception("Token không hợp lệ cho người dùng này");
    }
    $checkUserToken->close();

    // Truy vấn để lấy tất cả sản phẩm trong giỏ hàng của user
    $sql = "SELECT c.id, c.user_id, c.product_id, c.quantity, c.created_at, c.updated_at,
                   p.name as product_name, p.price, p.quantity as product_quantity, 
                   p.quantity_sold, p.star, p.status, p.category, p.hot, 
                   pi.image_url as image
            FROM cart c
            INNER JOIN products p ON c.product_id = p.id
            LEFT JOIN (
                SELECT product_id, MIN(image_url) as image_url
                FROM product_images
                GROUP BY product_id
            ) pi ON p.id = pi.product_id
            WHERE c.user_id = ?
            ORDER BY c.created_at DESC";
            
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        throw new Exception("Lỗi chuẩn bị câu lệnh SQL: " . $conn->error);
    }

    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $cartItems = array();
        $productQuantities = array();
        
        // Đầu tiên, thu thập tất cả các mục giỏ hàng
        while($row = $result->fetch_assoc()) {
            $productId = $row['product_id'];
            
            // Nếu sản phẩm đã tồn tại trong mảng, cộng dồn số lượng
            if (isset($productQuantities[$productId])) {
                $productQuantities[$productId] += $row['quantity'];
            } else {
                $productQuantities[$productId] = $row['quantity'];
                
                // Thêm sản phẩm vào mảng cartItems
                $cartItems[] = array(
                    'id' => $row['id'],
                    'user_id' => $row['user_id'],
                    'product_id' => $row['product_id'],
                    'product_name' => $row['product_name'],
                    'price' => $row['price'],
                    'image' => $row['image'],
                    'quantity' => $row['quantity'],
                    'product_quantity' => $row['product_quantity'],
                    'star' => $row['star'],
                    'status' => $row['status'] === 1 ? true : false,
                    'category' => $row['category'],
                    'hot' => $row['hot'],
                );
            }
        }
        
        // Cập nhật số lượng cho mỗi sản phẩm
        foreach ($cartItems as &$item) {
            $item['quantity'] = (string)$productQuantities[$item['product_id']];
        }
        
        echo json_encode([
            'ok' => true,
            'success' => true,
            'message' => 'Lấy danh sách giỏ hàng thành công',
            'data' => $cartItems
        ]);
    } else {
        http_response_code(404);
        echo json_encode([
            'ok' => false,
            'success' => false,
            'message' => 'Không có sản phẩm nào trong giỏ hàng'
        ]);
    }

    $stmt->close();

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
