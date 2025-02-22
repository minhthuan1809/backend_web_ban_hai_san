<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: HEAD, GET, POST, PUT, PATCH, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
header('Content-Type: text/html'); // Changed to text/html

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header("HTTP/1.1 200 OK");
    exit();
}

$request_uri = $_SERVER['REQUEST_URI'];

if (strpos($request_uri, '/api/client/v1') !== false) {
    include './layout/client.php';
} else if (strpos($request_uri, '/api/admin/v1') !== false) {
    include './layout/admin.php';
} else {
    echo "<div style='display: flex; justify-content: center; align-items: center; height: 100vh;'><h1 style='text-align: center; color: red; font-size: 50px; '>Xin chào bạn muốn gì ?</h1></div>"; // Returning HTML
}
