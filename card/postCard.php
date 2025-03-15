<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/TokenUtils.php';
// [POST] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/cart
header('Content-Type: application/json');

// Kiểm tra phương thức request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Phương thức không hợp lệ, vui lòng sử dụng POST"
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

    // Lấy dữ liệu từ body request
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['product_id']) || !isset($data['quantity'])) {
        throw new Exception("Thiếu thông tin sản phẩm hoặc số lượng");
    }

    $productId = $data['product_id'];
    $quantity = $data['quantity'];

    // Kiểm tra sản phẩm có tồn tại không
    $checkProduct = $conn->prepare("SELECT id, quantity FROM products WHERE id = ?");
    if ($checkProduct === false) {
        throw new Exception("Lỗi chuẩn bị câu lệnh SQL: " . $conn->error);
    }
    
    $checkProduct->bind_param("i", $productId);
    $checkProduct->execute();
    $productResult = $checkProduct->get_result();
    
    if ($productResult->num_rows === 0) {
        throw new Exception("Sản phẩm không tồn tại");
    }
    
    $productData = $productResult->fetch_assoc();
    $availableQuantity = $productData['quantity'];
    
    // Kiểm tra nếu sản phẩm hết hàng
    if ($availableQuantity <= 0) {
        throw new Exception("Sản phẩm đã hết hàng");
    }
    
    if ($quantity <= 0) {
        throw new Exception("Số lượng sản phẩm phải lớn hơn 0");
    }
    
    if ($quantity > $availableQuantity) {
        throw new Exception("Số lượng sản phẩm vượt quá số lượng có sẵn");
    }
    
    $checkProduct->close();

    // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
    $checkCart = $conn->prepare("SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?");
    if ($checkCart === false) {
        throw new Exception("Lỗi chuẩn bị câu lệnh SQL: " . $conn->error);
    }
    
    $checkCart->bind_param("ii", $userId, $productId);
    $checkCart->execute();
    $cartResult = $checkCart->get_result();
    
    if ($cartResult->num_rows > 0) {
        // Sản phẩm đã có trong giỏ hàng, cập nhật số lượng
        $cartItem = $cartResult->fetch_assoc();
        $newQuantity = $cartItem['quantity'] + $quantity;
        
        if ($newQuantity > $availableQuantity) {
            throw new Exception("Tổng số lượng sản phẩm vượt quá số lượng có sẵn");
        }
        
        $updateCart = $conn->prepare("UPDATE cart SET quantity = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
        if ($updateCart === false) {
            throw new Exception("Lỗi chuẩn bị câu lệnh SQL: " . $conn->error);
        }
        
        $updateCart->bind_param("ii", $newQuantity, $cartItem['id']);
        $updateCart->execute();
        
        if ($updateCart->affected_rows > 0) {
            echo json_encode([
                "ok" => true,
                "success" => true,
                "message" => "Cập nhật số lượng sản phẩm trong giỏ hàng thành công"
            ]);
        } else {
            throw new Exception("Không thể cập nhật giỏ hàng");
        }
        
        $updateCart->close();
    } else {
        // Thêm sản phẩm mới vào giỏ hàng
        $insertCart = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
        if ($insertCart === false) {
            throw new Exception("Lỗi chuẩn bị câu lệnh SQL: " . $conn->error);
        }
        
        $insertCart->bind_param("iii", $userId, $productId, $quantity);
        $insertCart->execute();
        
        if ($insertCart->affected_rows > 0) {
            echo json_encode([
                "ok" => true,
                "success" => true,
                "message" => "Thêm sản phẩm vào giỏ hàng thành công"
            ]);
        } else {
            throw new Exception("Không thể thêm sản phẩm vào giỏ hàng");
        }
        
        $insertCart->close();
    }
    
    $checkCart->close();

} catch(Exception $e) {
    http_response_code(500);
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => $e->getMessage()
    ]);
}

$conn->close();
?>
