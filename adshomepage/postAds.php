<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once __DIR__ . '/../config/db.php';

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->image_url) && !empty($data->title)) {
    
    $image_url = $data->image_url;
    $title = $data->title;
    $is_active = isset($data->is_active) && $data->is_active === true ? 1 : 0;

    try {
        $sql = "INSERT INTO layout_ads (image_url, title, is_active) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $image_url, $title, $is_active);

        if ($stmt->execute()) {
            http_response_code(201);
            echo json_encode([
                "ok" => true,
                "success" => true,
                "message" => "Thêm quảng cáo thành công"
            ]);
        } else {
            throw new Exception("Lỗi khi thêm quảng cáo");
        }
    } catch(Exception $e) {
        http_response_code(500);
        echo json_encode([
            "ok" => false,
            "success" => false,
            "message" => $e->getMessage()
        ]);
    }
} else {
    http_response_code(400);
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Dữ liệu không đầy đủ. Vui lòng kiểm tra lại"
    ]);
}

$conn->close();
?>
