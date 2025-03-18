<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../email/send.php';

if (!isset($conn) || !($conn instanceof mysqli)) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Không thể kết nối đến cơ sở dữ liệu"
    ]);
    exit;
}

try {
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
            discount_code, discount_percent, final_total, free_of_charge, payment_method, note, discount_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

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
    $discount_id = isset($data['discount_id']) ? $data['discount_id'] : null;

    // Chuyển mảng products thành JSON
    $data_product = json_encode($data['products']);
    if ($data_product === false) {
        throw new Exception("Lỗi khi chuyển đổi dữ liệu sản phẩm sang JSON");
    }

    // Bind các tham số
    if (!$stmt->bind_param("isssssiiissi",
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
        $note,
        $discount_id
    )) {
        throw new Exception("Lỗi bind tham số: " . $stmt->error);
    }

    // Thực thi câu lệnh
    if (!$stmt->execute()) {
        throw new Exception("Lỗi thực thi câu lệnh: " . $stmt->error);
    }

    // Lấy ID đơn hàng vừa tạo
    $order_id = $conn->insert_id;
   
    // Xóa tất cả sản phẩm trong giỏ hàng của người dùng sau khi đặt hàng thành công
    $delete_cart_sql = "DELETE FROM cart WHERE user_id = ?";
    $delete_stmt = $conn->prepare($delete_cart_sql);
    if ($delete_stmt === false) {
        throw new Exception("Lỗi chuẩn bị câu lệnh xóa giỏ hàng: " . $conn->error);
    }
    $delete_stmt->bind_param("i", $data['user_id']);
    $delete_stmt->execute();
    $delete_stmt->close();

    // Giảm số lượng mã giảm giá nếu có sử dụng
    if ($discount_id) {
        $update_discount_sql = "UPDATE discount SET quantity = quantity - 1 WHERE id = ? AND quantity > 0";
        $update_discount_stmt = $conn->prepare($update_discount_sql);
        if ($update_discount_stmt === false) {
            throw new Exception("Lỗi chuẩn bị câu lệnh cập nhật số lượng mã giảm giá: " . $conn->error);
        }
        $update_discount_stmt->bind_param("i", $discount_id);
        $update_discount_stmt->execute();
        $update_discount_stmt->close();
    }

    // Gửi email xác nhận đơn hàng cho khách hàng
    try {
        // Lấy thông tin email của khách hàng từ bảng user (không phải users)
        $user_sql = "SELECT email, fullName FROM user WHERE id = ?";
        $user_stmt = $conn->prepare($user_sql);
        if ($user_stmt === false) {
            throw new Exception("Lỗi chuẩn bị câu lệnh lấy thông tin người dùng: " . $conn->error);
        }
        $user_stmt->bind_param("i", $data['user_id']);
        $user_stmt->execute();
        $user_result = $user_stmt->get_result();
        $user_data = $user_result->fetch_assoc();
        $user_stmt->close();

        if ($user_data && isset($user_data['email'])) {
            // Chuẩn bị nội dung email
            $to = $user_data['email'];
            $subject = "Xác nhận đơn hàng #" . $order_id;
            
            // Tạo nội dung HTML cho email
            $message = "<div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px;'>";
            $message .= "<h2 style='color: #2c3e50; text-align: center; margin-bottom: 20px;'>Xác Nhận Đơn Hàng #" . $order_id . "</h2>";
            $message .= "<p style='color: #34495e; font-size: 16px; line-height: 1.5;'>Kính gửi " . htmlspecialchars($user_data['fullName']) . ",</p>";
            $message .= "<p style='color: #34495e; font-size: 16px; line-height: 1.5;'>Cảm ơn bạn đã đặt hàng tại cửa hàng của chúng tôi. Đơn hàng của bạn đã được xác nhận.</p>";
            
            $message .= "<h3 style='color: #2c3e50; margin-top: 20px;'>Chi tiết đơn hàng:</h3>";
            $message .= "<table style='width: 100%; border-collapse: collapse; margin-bottom: 20px;'>";
            $message .= "<tr style='background-color: #f8f9fa;'>";
            $message .= "<th style='padding: 10px; border: 1px solid #ddd; text-align: left;'>Sản phẩm</th>";
            $message .= "<th style='padding: 10px; border: 1px solid #ddd; text-align: center;'>Số lượng</th>";
            $message .= "<th style='padding: 10px; border: 1px solid #ddd; text-align: right;'>Giá</th>";
            $message .= "<th style='padding: 10px; border: 1px solid #ddd; text-align: right;'>Tổng</th>";
            $message .= "</tr>";
            
            $products = json_decode($data_product, true);
            $subtotal = 0;
            
            foreach ($products as $product) {
                // Lấy thông tin chi tiết sản phẩm từ cơ sở dữ liệu
                $product_sql = "SELECT name, price FROM products WHERE id = ?";
                $product_stmt = $conn->prepare($product_sql);
                $product_stmt->bind_param("i", $product['product_id']);
                $product_stmt->execute();
                $product_result = $product_stmt->get_result();
                $product_info = $product_result->fetch_assoc();
                $product_stmt->close();
                
                if ($product_info) {
                    $total = $product_info['price'] * $product['quantity'];
                    $subtotal += $total;
                    
                    $message .= "<tr>";
                    $message .= "<td style='padding: 10px; border: 1px solid #ddd;'>" . htmlspecialchars($product_info['name']) . "</td>";
                    $message .= "<td style='padding: 10px; border: 1px solid #ddd; text-align: center;'>" . $product['quantity'] . "</td>";
                    $message .= "<td style='padding: 10px; border: 1px solid #ddd; text-align: right;'>" . number_format($product_info['price']) . " VNĐ</td>";
                    $message .= "<td style='padding: 10px; border: 1px solid #ddd; text-align: right;'>" . number_format($total) . " VNĐ</td>";
                    $message .= "</tr>";
                }
            }
            $message .= "</table>";
            
            $message .= "<div style='margin-top: 20px; border-top: 1px solid #ddd; padding-top: 15px;'>";
            $message .= "<table style='width: 100%;'>";
            $message .= "<tr><td style='padding: 5px 0;'>Tổng tiền hàng:</td><td style='text-align: right;'>" . number_format($subtotal) . " VNĐ</td></tr>";
            
            if ($discount_percent > 0) {
                $discount_amount = $subtotal * ($discount_percent / 100);
                $message .= "<tr><td style='padding: 5px 0;'>Mã giảm giá (" . htmlspecialchars($discount_code) . "):</td><td style='text-align: right;'>-" . number_format($discount_amount) . " VNĐ</td></tr>";
            }
            
            $message .= "<tr><td style='padding: 5px 0;'>Phí vận chuyển:</td><td style='text-align: right;'>" . number_format($free_of_charge) . " VNĐ</td></tr>";
            $message .= "<tr style='font-weight: bold;'><td style='padding: 10px 0; border-top: 1px solid #ddd;'>Tổng thanh toán:</td><td style='text-align: right; border-top: 1px solid #ddd;'>" . number_format($final_total) . " VNĐ</td></tr>";
            $message .= "</table>";
            $message .= "</div>";
            
            $message .= "<div style='margin-top: 30px;'>";
            $message .= "<h3 style='color: #2c3e50;'>Thông tin giao hàng:</h3>";
            $message .= "<p><strong>Người nhận:</strong> " . htmlspecialchars($data['name']) . "</p>";
            $message .= "<p><strong>Số điện thoại:</strong> " . htmlspecialchars($data['phone']) . "</p>";
            $message .= "<p><strong>Địa chỉ:</strong> " . htmlspecialchars($data['address']) . "</p>";
            $message .= "<p><strong>Phương thức thanh toán:</strong> " . ($payment_method == 'cod' ? 'Thanh toán khi nhận hàng' : 'Chuyển khoản ngân hàng') . "</p>";
            
            if (!empty($note)) {
                $message .= "<p><strong>Ghi chú:</strong> " . htmlspecialchars($note) . "</p>";
            }
            $message .= "</div>";
            
            $message .= "<div style='margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd; text-align: center; color: #7f8c8d;'>";
            $message .= "<p>Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ với chúng tôi.</p>";
            $message .= "<p>Cảm ơn bạn đã mua sắm tại cửa hàng của chúng tôi!</p>";

            $message .= "</div>";
            $message .= "<p style='text-align: center; color: #7f8c8d;'>Trân trọng cảm ơn!</p>";
            
            $message .= "</div>";
            
            // Sử dụng class mailer để gửi email
            $mailer = new mailer();
            $result = $mailer->dathang($subject, $message, $to);
            
            // Ghi log kết quả gửi email
            if ($result === 'Message has been sent') {
                error_log("Đã gửi email xác nhận đơn hàng #" . $order_id . " đến " . $to);
            } else {
                error_log("Không thể gửi email xác nhận đơn hàng #" . $order_id . " đến " . $to . ": " . $result);
            }
        } else {
            error_log("Không tìm thấy email cho user_id: " . $data['user_id']);
        }
    } catch (Exception $email_error) {
        // Ghi log lỗi gửi email nhưng không dừng quy trình
        error_log("Lỗi gửi email: " . $email_error->getMessage());
    }

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
