<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/jwt_utils.php';
require_once __DIR__ . '/../core/controller/auth/AuthController.php';

$database = $conn;
$db = $database;

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->email) && !empty($data->password) && !empty($data->fullname)) {
    $auth = new AuthController();
    $result = $auth->register($data->email, $data->password, $data->fullname);
    
    if ($result['status'] === 'success') {
        http_response_code(201);
    } else {
        http_response_code(400);
    }
    
    echo json_encode($result);
} else {
    http_response_code(400);
    echo json_encode(array(
        "status" => "error",
        "message" => "Không thể đăng ký. Dữ liệu không đầy đủ."
    ));
} 
?>