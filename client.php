<?php
// [GET][POST][PUT][DELETE] http://localhost/backend_web_ban_hai_san/client.php

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header("HTTP/1.1 200 OK");
    exit();
}

$request_uri = $_SERVER['REQUEST_URI'];

//[GET][POST][PUT][DELETE] http://localhost/backend_web_ban_hai_san/client.php/navbar 
if (preg_match('/\/navbar/', $request_uri)) {
    include __DIR__ . '/layout/nav.php';
}

//[PUT] http://localhost/backend_web_ban_hai_san/client.php/logo 
else if (preg_match('/\/logo/', $request_uri)) {
    include __DIR__ . '/layout/putlogo.php';
}   

// [GET] [PUT] [POST] [DELETE] http://localhost/backend_web_ban_hai_san/client.php/footer 
else if (preg_match('/\/footer/', $request_uri)) {
    include __DIR__ . '/layout/indexfooter.php';
} 

// [GET] [PUT] [POST] [DELETE] http://localhost/backend_web_ban_hai_san/client.php/hero_section 
else if (preg_match('/\/hero_section/', $request_uri)) {
    include __DIR__ . '/layout/index_hero_section.php';
}

// [PUT]  http://localhost/backend_web_ban_hai_san/client.php/introduction_section 
else if (preg_match('/\/introduction_section/', $request_uri)) {
    include __DIR__ . '/layout/index_introduction_section.php';
}

// [GET] [PUT] [POST] [DELETE] http://localhost/backend_web_ban_hai_san/client.php/customer_section 
else if (preg_match('/\/customer_section/', $request_uri)) {
    include __DIR__ . '/layout/index_customer_section.php';
}

else {
    echo json_encode([
        'ok' => false,
        'success' => false,
        'message' => 'URL không hợp lệ hoặc không tìm thấy'
    ]);
    http_response_code(404);
}
