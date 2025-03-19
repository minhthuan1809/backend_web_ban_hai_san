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
    include __DIR__ . '/layout/indexFooters.php';
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

// [GET] [PUT] [POST] [DELETE] http://localhost/backend_web_ban_hai_san/client.php/customer_choose_section 
else if (preg_match('/\/customer_choose_section/', $request_uri)) {
    include __DIR__ . '/layout/index_customer_choose_section.php';
}

// [GET] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/contacts
else if (preg_match('/\/contacts/', $request_uri)) {
    include __DIR__ . '/layout/footer/contacts/getContact.php';
}

// [GET] [POST] [PUT] [DELETE] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/news
else if (preg_match('/\/news/', $request_uri)) {
    include __DIR__ . '/news/indexnews.php';
}
// [GET] [POST] [PUT] [DELETE] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/send_contacts
else if (preg_match('/\/send_contacts/', $request_uri)) {
    include __DIR__ . '/contact/IndexContact.php';
}

// [GET] [POST] [PUT] [DELETE] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/about
else if (preg_match('/\/about/', $request_uri)) {
    include __DIR__ . '/layout/about/indexAbout.php';
}

// [GET] [PUT] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/products
else if (preg_match('/\/products/', $request_uri)) {
    include __DIR__ . '/products/indexProducts.php';
    
}

// [POST] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/auth/register
else if (preg_match('/\/auth\/register/', $request_uri)) {
    include __DIR__ . '/api/register.php';
}

// [POST] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/auth/login
else if (preg_match('/\/auth\/login/', $request_uri)) {
    include __DIR__ . '/api/login.php';
}



// [GET] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/auth/user
else if (preg_match('/\/auth\/user/', $request_uri)) {
    include __DIR__ . '/api/CheckJwt.php';
}

// [GET] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/users
else if (preg_match('/\/users/', $request_uri)) {
    include __DIR__ . '/user/indexUser.php';
}

// [GET] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/role
else if (preg_match('/\/role/', $request_uri)) {
    include __DIR__ . '/role/indexRole.php';
}

// [GET] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/ads
else if (preg_match('/\/ads/', $request_uri)) {
    include __DIR__ . '/adshomepage/indexAds.php';
}

// [GET] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/forgotpass
else if (preg_match('/\/forgotpass/', $request_uri)) {
    include __DIR__ . '/api/forgotPass.php';
}

// [GET] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/address
else if (preg_match('/\/address/', $request_uri)) {
    include __DIR__ . '/address/indexAddress.php';
}
// [GET] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/change_password
else if (preg_match('/\/change_password/', $request_uri)) {
    include __DIR__ . '/api/ChangePassword.php';
}

// [GET] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/change_infor_user
else if (preg_match('/\/change_infor_user/', $request_uri)) {
    include __DIR__ . '/api/ChangeInforUser.php';
}

// [GET] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/card
else if (preg_match('/\/card/', $request_uri)) {
    include __DIR__ . '/card/indexCard.php';
}

// [GET] [POST] [PUT] [DELETE] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/discount
else if (preg_match('/\/discount/', $request_uri)) {
    include __DIR__ . '/discount/indexDiscount.php';
}
//  [GET] [POST] [PUT] [DELETE] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/order
else if (preg_match('/\/order/', $request_uri)) {
    include __DIR__ . '/orders/indexOrder.php';
}
// [GET] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/history_order
else if (preg_match('/\/history_order/', $request_uri)) {
    include __DIR__ . '/history_orders/indexHistoryOrder.php';
}

// [GET] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/dashboard
else if (preg_match('/\/dashboard/', $request_uri)) {
    include __DIR__ . '/api/dashboard.php';
}

// [GET] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/history_discount
else if (preg_match('/\/history_discount/', $request_uri)) {
    include __DIR__ . '/historyDiscount/getHistoryDiscount.php';
}

// [GET] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/stats
else if (preg_match('/\/stats/', $request_uri)) {
    include __DIR__ . '/api/Stats.php';
}

// [GET] http://localhost/backend_web_ban_hai_san/index1.php/api/client/v1/news_header
else if (preg_match('/\/news_header/', $request_uri)) {
    include __DIR__ . '/api/getNewHeader.php';
}
else {
    echo json_encode([
        'ok' => false,
        'success' => false,
        'message' => 'URL không hợp lệ hoặc không tìm thấy'
    ]);
    http_response_code(404);
}
