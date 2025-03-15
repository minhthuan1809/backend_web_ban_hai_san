<?php
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
    // Tạo bảng orders nếu chưa tồn tại
    $createTableSQL = "CREATE TABLE IF NOT EXISTS orders (
        id INT PRIMARY KEY AUTO_INCREMENT,
        user_id INT NOT NULL,
        name VARCHAR(255),
        phone VARCHAR(20), 
        address TEXT,
        data_product JSON,
        discount_code VARCHAR(50),
        discount_percent INT,
        final_total INT,
        free_of_charge INT,
        payment_method ENUM('cod', 'bank'),
        note TEXT,
        status ENUM('pending', 'processing', 'completed', 'canceled') DEFAULT 'pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

    if (!$conn->query($createTableSQL)) {
        throw new Exception("Lỗi tạo bảng orders: " . $conn->error);
    }

    // Lấy dữ liệu từ request
    $data = json_decode(file_get_contents("php://input"), true);

    // Kiểm tra dữ liệu có trống không
    if (empty($data)) {
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "Dữ liệu gửi lên không được để trống"
        ]);
        exit;
    }

    // Kiểm tra các trường bắt buộc
    if (!isset($data['user_id']) || !isset($data['name']) || !isset($data['phone']) || 
        !isset($data['address']) || !isset($data['products'])) {
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "Thiếu thông tin đơn hàng bắt buộc"
        ]);
        exit;
    }

    // Kiểm tra số lượng sản phẩm trong kho
    foreach ($data['products'] as $product) {
        $check_stock_sql = "SELECT id, name, quantity FROM products WHERE id = ?";
        $check_stmt = $conn->prepare($check_stock_sql);
        if ($check_stmt === false) {
            throw new Exception("Lỗi chuẩn bị câu lệnh kiểm tra tồn kho: " . $conn->error);
        }
        $check_stmt->bind_param("i", $product['product_id']);
        $check_stmt->execute();
        $result = $check_stmt->get_result();
        $product_data = $result->fetch_assoc();
        
        if (!$product_data) {
            echo json_encode([
                "ok" => false,
                "success" => false,
                "message" => "Không tìm thấy sản phẩm " . $product['product_id']
            ]);
            exit;
        }

        $requested_quantity = intval($product['quantity']);
        $available_quantity = intval($product_data['quantity']);

        if ($requested_quantity > $available_quantity) {
            echo json_encode([
                "ok" => false,
                "success" => false,
                "message" => "Sản phẩm " . $product_data['name'] . " chỉ còn " . $available_quantity . " sản phẩm trong kho"
            ]);
            exit;
        }
        $check_stmt->close();
    }

    // Chuẩn bị câu lệnh SQL
    $sql = "INSERT INTO orders (user_id, name, phone, address, data_product, 
            discount_code, discount_percent, final_total, free_of_charge, payment_method, note) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        throw new Exception("Lỗi chuẩn bị câu lệnh: " . $conn->error);
    }

    // Gán giá trị mặc định cho các trường không bắt buộc
    $discount_code = isset($data['discount_code']) ? $data['discount_code'] : '';
    $discount_percent = isset($data['discount_percent']) ? $data['discount_percent'] : 0;
    $final_total = isset($data['final_total']) ? $data['final_total'] : 0;
    $free_of_charge = isset($data['free_of_charge']) ? $data['free_of_charge'] : 0;
    $payment_method = isset($data['payment_method']) ? $data['payment_method'] : 'cod';
    $note = isset($data['note']) ? $data['note'] : '';

    // Chuyển mảng products thành JSON
    $data_product = json_encode($data['products']);
    if ($data_product === false) {
        throw new Exception("Lỗi khi chuyển đổi dữ liệu sản phẩm sang JSON");
    }

    // Bind các tham số
    if (!$stmt->bind_param("isssssiiiss",
        $data['user_id'],
        $data['name'],
        $data['phone'], 
        $data['address'],
        $data_product,
        $discount_code,
        $discount_percent,
        $final_total,
        $free_of_charge,
        $payment_method,
        $note
    )) {
        throw new Exception("Lỗi bind tham số: " . $stmt->error);
    }

    // Thực thi câu lệnh
    if (!$stmt->execute()) {
        throw new Exception("Lỗi thực thi câu lệnh: " . $stmt->error);
    }

   
    // Xóa tất cả sản phẩm trong giỏ hàng của người dùng sau khi đặt hàng thành công
    $delete_cart_sql = "DELETE FROM cart WHERE user_id = ?";
    $delete_stmt = $conn->prepare($delete_cart_sql);
    if ($delete_stmt === false) {
        throw new Exception("Lỗi chuẩn bị câu lệnh xóa giỏ hàng: " . $conn->error);
    }
    $delete_stmt->bind_param("i", $data['user_id']);
    $delete_stmt->execute();
    $delete_stmt->close();

    echo json_encode([
        "ok" => true,
        "success" => true,
        "message" => "Thêm đơn hàng mới thành công"
    ]);

} catch (Exception $e) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Lỗi: " . $e->getMessage()
    ]);
} finally {
    if (isset($stmt) && $stmt !== false) {
        $stmt->close();
    }
    if (isset($conn) && $conn instanceof mysqli) {
        $conn->close();
    }
}
?>
