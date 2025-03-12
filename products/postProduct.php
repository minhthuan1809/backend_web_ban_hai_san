<?php
// [POST] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/products
require_once __DIR__ . '/../config/db.php'; // Sửa đường dẫn để đảm bảo đúng vị trí file

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

    // Thông báo khi dữ liệu không có
    if (!isset($data['name']) || !isset($data['description']) || !isset($data['price']) || !isset($data['status']) || !isset($data['category']) || !isset($data['hot']) || !isset($data['quantity'])) {
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "Thông báo không có dữ liệu bạn không được để trống"
        ]);
        exit;
    }

    // Kiểm tra từng trường dữ liệu có trống không
    if (empty($data['name'])) {
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "Tên sản phẩm không được để trống"
        ]);
        exit;
    }

    if (empty($data['description'])) {
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "Mô tả không được để trống"
        ]);
        exit;
    }

    if (!isset($data['price']) || $data['price'] <= 0) {
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "Giá sản phẩm không hợp lệ"
        ]);
        exit;
    }

    if (!isset($data['quantity']) || $data['quantity'] <= 0) {
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => "Số lượng sản phẩm không hợp lệ"
        ]);
        exit;
    }

    // Chuẩn bị câu lệnh SQL
    $sql = "INSERT INTO products (name, description, price, status, category, hot, quantity) VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    // Chuẩn bị và thực thi câu lệnh
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        throw new Exception("Lỗi chuẩn bị câu lệnh: " . $conn->error);
    }

    // Chuyển đổi giá trị boolean thành số nguyên
    $status = $data['status'] ? 1 : 0;
    $hot = $data['hot'] ? 1 : 0;
    $price = (int)str_replace(['.',',','₫',' '], '', $data['price']);
    
    $stmt->bind_param("ssiisii", 
        $data['name'], 
        $data['description'],
        $price,
        $status,
        $data['category'],
        $hot,
        $data['quantity']
    );
    
    if ($stmt->execute()) {
        // Lấy ID sản phẩm vừa chèn
        $product_id = $conn->insert_id;

        // Kiểm tra nếu có hình ảnh trong dữ liệu gửi lên
        if (isset($data['images']) && is_array($data['images'])) {
            foreach ($data['images'] as $image_url) {
                // Thêm hình ảnh vào bảng product_images
                $image_sql = "INSERT INTO product_images (product_id, image_url) VALUES (?, ?)";
                $image_stmt = $conn->prepare($image_sql);
                if ($image_stmt === false) {
                    throw new Exception("Lỗi chuẩn bị câu lệnh thêm hình ảnh: " . $conn->error);
                }
                $image_stmt->bind_param("is", $product_id, $image_url);
                $image_stmt->execute();
                $image_stmt->close();
            }
        }

        echo json_encode([
            "ok" => true,
            "success" => true,
            "message" => "Thêm sản phẩm mới thành công",
        ]);
    } else {
        throw new Exception("Lỗi khi thêm sản phẩm mới: " . $stmt->error);
    }

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
