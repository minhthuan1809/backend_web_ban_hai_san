<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once __DIR__ . '/../config/db.php';

$database = $conn;
$db = $database;

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->fullName) && !empty($data->email) && !empty($data->roleId) && !empty($data->password)) {
    
    // Basic validation
    if (!filter_var($data->email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode([
            "status" => false,
            "message" => "Email không hợp lệ"
        ]);
        exit;
    }

    // Kiểm tra roleId = 3
    if ($data->roleId == 3) {
        http_response_code(400);
        echo json_encode([
            "ok" => false,
            "status" => false,
            "message" => "Không thể cấp quyền này cho người dùng"
        ]);
        exit;
    }

    $fullName = $data->fullName;
    $email = $data->email;
    $avatar = $data->avatar ?? 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1742015676/c8rpqw6wk8edghzxo4xg.jpg';
    $roleId = $data->roleId;
    $status = 0; // Thay đổi từ false thành 0 vì cột status trong DB yêu cầu kiểu integer
    $password = password_hash($data->password, PASSWORD_DEFAULT);

    // Kiểm tra xem email đã tồn tại chưa
    $checkEmail = $db->prepare("SELECT id FROM user WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $result = $checkEmail->get_result();

    if ($result->num_rows > 0) {
        http_response_code(400);
        echo json_encode([
            "ok" => false,
            "status" => false,
            "message" => "Email đã tồn tại trong hệ thống"
        ]);
        exit;
    }

    // Thêm người dùng mới
    try {
        $stmt = $db->prepare("INSERT INTO user (fullName, email, avatar, role_id, status, password) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt === false) {
            throw new Exception("Lỗi chuẩn bị câu lệnh SQL: " . $db->error);
        }

        $stmt->bind_param("sssiii", $fullName, $email, $avatar, $roleId, $status, $password); // Thay đổi "sssiss" thành "sssiii" vì status là integer

        if($stmt->execute()) {
            http_response_code(201);
            echo json_encode([
                "ok" => true,
                "status" => true,
                "message" => "Người dùng đã được tạo thành công"
            ]);
        } else {
            throw new Exception("Không thể tạo người dùng: " . $stmt->error);
        }

    } catch (Exception $e) {
        http_response_code(503);
        echo json_encode([
            "ok" => false,
            "status" => false,
            "message" => $e->getMessage()
        ]);
    }

} else {
    http_response_code(400);
    echo json_encode([
        "ok" => false,
        "status" => false,
        "message" => "Không thể tạo người dùng. Dữ liệu không đầy đủ"
    ]);
}
?>
