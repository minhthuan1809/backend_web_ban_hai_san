<?php


if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header("HTTP/1.1 200 OK");
    exit();
}

$request_uri = $_SERVER['REQUEST_URI'];

//[GET][POST][PUT][DELETE] http://localhost/backend_web_ban_hai_san/client.php/navbar 
if (strpos($request_uri, '/navbar') !== false) {
    include __DIR__ . '/layout/nav.php';
}

//[PUT] http://localhost/backend_web_ban_hai_san/client.php/logo 
else if (strpos($request_uri, '/logo') !== false) {
    include __DIR__ . '/layout/putlogo.php';
}   

// [GET] [PUT] [POST] [DELETE] http://localhost/backend_web_ban_hai_san/client.php/footer 
else if (strpos($request_uri, '/footer') !== false) {
    include __DIR__ . '/layout/indexfooter.php';
} 

else {
    echo json_encode([
        'ok' => false,
        'success' => false,
        'message' => 'URL not found'
    ]);
    http_response_code(404);
}
