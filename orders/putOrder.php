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
    // Lấy ID từ URL
    $urlParts = explode('/', $_SERVER['REQUEST_URI']);
    $orderId = end($urlParts);

    if (!is_numeric($orderId)) {
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "ID đơn hàng không hợp lệ"
        ]);
        exit;
    }

    // Lấy dữ liệu từ request
    $data = json_decode(file_get_contents("php://input"), true);
    
    // Tạo câu lệnh SQL động dựa trên dữ liệu gửi lên
    $updateFields = [];
    $params = [];
    $types = "";

    // Kiểm tra và thêm các trường cần cập nhật
    if (isset($data['status'])) {
        $updateFields[] = "status = ?";
        $params[] = $data['status'];
        $types .= "s";

        // Nếu status là canceled thì lưu vào history_orders và xóa khỏi orders
        if ($data['status'] === 'canceled') {
            // Lấy thông tin đơn hàng hiện tại
            $getOrderSql = "SELECT user_id, name, phone, address, data_product, discount_code, discount_percent, final_total, free_of_charge, payment_method, note FROM orders WHERE id = ?";
            $stmt = $conn->prepare($getOrderSql);
            $stmt->bind_param("i", $orderId);
            $stmt->execute();
            $result = $stmt->get_result();
            $orderData = $result->fetch_assoc();

            if ($orderData) {
                // Thêm vào bảng history_orders
                $insertHistorySql = "INSERT INTO history_orders (user_id, name, phone, address, data_product, discount_code, discount_percent, final_total, free_of_charge, payment_method, note, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'canceled')";
                $stmtHistory = $conn->prepare($insertHistorySql);
                $stmtHistory->bind_param("isssssiiiss", 
                    $orderData['user_id'],
                    $orderData['name'],
                    $orderData['phone'],
                    $orderData['address'],
                    $orderData['data_product'],
                    $orderData['discount_code'],
                    $orderData['discount_percent'],
                    $orderData['final_total'],
                    $orderData['free_of_charge'],
                    $orderData['payment_method'],
                    $orderData['note']
                );
                if($stmtHistory->execute()) {
                    $history_order_id = $stmtHistory->insert_id;

                    // Kiểm tra và tăng số lượng mã giảm giá nếu có
                    if(!empty($orderData['discount_code'])) {
                        $updateDiscountSql = "UPDATE discount SET quantity = quantity + 1 WHERE code = ?";
                        $stmtDiscount = $conn->prepare($updateDiscountSql);
                        $stmtDiscount->bind_param("s", $orderData['discount_code']);
                        $stmtDiscount->execute();
                    }

                    // Xóa đơn hàng khỏi bảng orders
                    $deleteOrderSql = "DELETE FROM orders WHERE id = ?";
                    $stmtDelete = $conn->prepare($deleteOrderSql);
                    $stmtDelete->bind_param("i", $orderId);
                    $stmtDelete->execute();

                    echo json_encode([
                        "ok" => true,
                        "success" => true,
                        "message" => "Đã hủy đơn hàng thành công",
                        "history_order_id" => $history_order_id
                    ]);
                    exit;
                }
            }
        }

        // Nếu status là completed thì lưu vào history_orders và cập nhật số lượng sản phẩm
        if ($data['status'] === 'completed') {
            // Lấy thông tin đơn hàng hiện tại
            $getOrderSql = "SELECT user_id, name, phone, address, data_product, discount_code, discount_percent, final_total, free_of_charge, payment_method, note FROM orders WHERE id = ?";
            $stmt = $conn->prepare($getOrderSql);
            $stmt->bind_param("i", $orderId);
            $stmt->execute();
            $result = $stmt->get_result();
            $orderData = $result->fetch_assoc();

            if ($orderData) {
                // Thêm vào bảng history_orders
                $insertHistorySql = "INSERT INTO history_orders (user_id, name, phone, address, data_product, discount_code, discount_percent, final_total, free_of_charge, payment_method, note, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'completed')";
                $stmtHistory = $conn->prepare($insertHistorySql);
                $stmtHistory->bind_param("isssssiiiss", 
                    $orderData['user_id'],
                    $orderData['name'],
                    $orderData['phone'],
                    $orderData['address'],
                    $orderData['data_product'],
                    $orderData['discount_code'],
                    $orderData['discount_percent'],
                    $orderData['final_total'],
                    $orderData['free_of_charge'],
                    $orderData['payment_method'],
                    $orderData['note']
                );
                if($stmtHistory->execute()) {
                    $history_order_id = $stmtHistory->insert_id;

                    // Cập nhật số lượng sản phẩm
                    $products = json_decode($orderData['data_product'], true);
                    foreach ($products as $product) {
                        $updateProductSql = "UPDATE products SET quantity = quantity - ?, quantity_sold = quantity_sold + ? WHERE id = ?";
                        $stmtProduct = $conn->prepare($updateProductSql);
                        $stmtProduct->bind_param("iii", $product['quantity'], $product['quantity'], $product['product_id']);
                        $stmtProduct->execute();
                    }

                    // Thêm vào discount_history nếu có mã giảm giá
                    if(!empty($orderData['discount_code'])) {
                        // Lấy discount_id
                        $getDiscountIdSql = "SELECT id FROM discount WHERE code = ?";
                        $stmtDiscountId = $conn->prepare($getDiscountIdSql);
                        $stmtDiscountId->bind_param("s", $orderData['discount_code']);
                        $stmtDiscountId->execute();
                        $discountResult = $stmtDiscountId->get_result();
                        $discountData = $discountResult->fetch_assoc();

                        if($discountData) {
                            // Thêm vào discount_history
                            $insertDiscountHistorySql = "INSERT INTO discount_history (discount_id, order_history_id) VALUES (?, ?)";
                            $stmtDiscountHistory = $conn->prepare($insertDiscountHistorySql);
                            $stmtDiscountHistory->bind_param("ii", $discountData['id'], $history_order_id);
                            $stmtDiscountHistory->execute();
                        }
                    }

                    // Xóa đơn hàng khỏi bảng orders
                    $deleteOrderSql = "DELETE FROM orders WHERE id = ?";
                    $stmtDelete = $conn->prepare($deleteOrderSql);
                    $stmtDelete->bind_param("i", $orderId);
                    $stmtDelete->execute();

                    echo json_encode([
                        "ok" => true,
                        "success" => true,
                        "message" => "Đã hoàn thành đơn hàng thành công",
                        "history_order_id" => $history_order_id
                    ]);
                    exit;
                }
            }
        }
    }
    
    if (isset($data['address'])) {
        $updateFields[] = "address = ?";
        $params[] = $data['address'];
        $types .= "s";
    }

    // Nếu không có trường nào được cập nhật
    if (empty($updateFields)) {
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "Không có dữ liệu cần cập nhật"
        ]);
        exit;
    }

    // Thêm ID vào params và types
    $params[] = $orderId;
    $types .= "i";

    // Tạo câu lệnh SQL
    $sql = "UPDATE orders SET " . implode(", ", $updateFields) . " WHERE id = ?";
    
    // Chuẩn bị và thực thi câu lệnh
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        throw new Exception("Lỗi chuẩn bị câu lệnh: " . $conn->error);
    }

    $stmt->bind_param($types, ...$params);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            // Lấy thông tin đơn hàng hiện tại
            $getOrderSql = "SELECT discount_code FROM orders WHERE id = ?";
            $stmt = $conn->prepare($getOrderSql);
            $stmt->bind_param("i", $orderId);
            $stmt->execute();
            $result = $stmt->get_result();
            $orderData = $result->fetch_assoc();

            if ($orderData && !empty($orderData['discount_code'])) {
                // Lấy discount_id
                $getDiscountIdSql = "SELECT id FROM discount WHERE code = ?";
                $stmtDiscountId = $conn->prepare($getDiscountIdSql);
                $stmtDiscountId->bind_param("s", $orderData['discount_code']);
                $stmtDiscountId->execute();
                $discountResult = $stmtDiscountId->get_result();
                $discountData = $discountResult->fetch_assoc();

                if ($discountData) {
                    // Thêm vào discount_history
                    $insertDiscountHistorySql = "INSERT INTO discount_history (discount_id, order_history_id) VALUES (?, ?)";
                    $stmtDiscountHistory = $conn->prepare($insertDiscountHistorySql);
                    $stmtDiscountHistory->bind_param("ii", $discountData['id'], $orderId);
                    $stmtDiscountHistory->execute();
                }
            }

            echo json_encode([
                "ok" => true,
                "success" => true,
                "message" => "Cập nhật đơn hàng thành công"
            ]);
        } else {
            echo json_encode([
                "ok" => false,
                "success" => false,
                "message" => "Không tìm thấy đơn hàng hoặc không có thay đổi"
            ]);
        }
    } else {
        throw new Exception("Lỗi cập nhật đơn hàng: " . $stmt->error);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
?>
