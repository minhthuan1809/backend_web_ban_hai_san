<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: HEAD, GET, POST, PUT, PATCH, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header("HTTP/1.1 200 OK");
    exit();
}

$request_uri = $_SERVER['REQUEST_URI'];

if (strpos($request_uri, '/api/client/v1') !== false) {
    if (strpos($request_uri, '/logout') !== false) {
        include __DIR__ . '/api/Logout.php';
    } else {
        include __DIR__ . '/client.php';
        }
} else if (strpos($request_uri, '/api/admin/v1') !== false) {
    include __DIR__ . '/admin.php';
} else {
    echo json_encode([
        'ok' => false,
        'success' => false,
        'message' => 'URL not found'
    ]);
    http_response_code(404);
}





// // Get token from Authorization header
// $headers = apache_request_headers();
// $auth_header = isset($headers['Authorization']) ? $headers['Authorization'] : '';
// $token = '';

// if (preg_match('/Bearer\s+(.*)$/i', $auth_header, $matches)) {
//     $token = $matches[1];
// }

// // Read API_KEY_TOKEN from .env file
// $env_content = file_get_contents(__DIR__ . '/../../../.env');
// $api_key_token = '';
// if (preg_match('/API_KEY_TOKEN=(.*)/', $env_content, $matches)) {
//     $api_key_token = trim($matches[1]);
// }

// // Check token
// if ($token !== $api_key_token) {
//     echo json_encode([
//         "ok" => false,
//         "success" => false,
//         "message" => "xác thực thất bại"
//     ]);
//     exit;
// }