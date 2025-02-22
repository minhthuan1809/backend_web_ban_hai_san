<?php
header('Content-Type: application/json');

// Kiểm tra phương thức request
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Phương thức " . $_SERVER['REQUEST_METHOD'] . " không được hỗ trợ"
    ]);
    exit;
}

// Sử dụng đường dẫn tuyệt đối để require file
require_once __DIR__ . '/../../config/db.php';

if (!isset($conn) || !($conn instanceof mysqli)) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Không thể kết nối đến cơ sở dữ liệu"
    ]);
    exit;
}

try {
    // Lấy dữ liệu từ bảng introductionsfooter
    $introSql = "SELECT * FROM introductionsfooter";
    $introResult = $conn->query($introSql);
    $introData = $introResult->fetch_assoc();

    // Lấy dữ liệu từ bảng contactsfooter
    $contactSql = "SELECT * FROM contactsfooter";
    $contactResult = $conn->query($contactSql);
    $contacts = [];
    while ($row = $contactResult->fetch_assoc()) {
        $contacts[] = $row;
    }

    // Lấy dữ liệu từ bảng social_media_links
    $socialSql = "SELECT * FROM social_media_links";
    $socialResult = $conn->query($socialSql);
    $socialLinks = [];
    while ($row = $socialResult->fetch_assoc()) {
        $socialLinks[] = $row;
    }

    // Lấy dữ liệu từ bảng copyright
    $copyrightSql = "SELECT * FROM copyright";
    $copyrightResult = $conn->query($copyrightSql);
    $copyrightData = $copyrightResult->fetch_assoc();

    // Tổng hợp dữ liệu
    $response = [
        "ok" => true,
        "success" => true,
        "data" => [
            "introduction" => $introData,
            "contacts" => $contacts,
            "social_links" => $socialLinks,
            "copyright" => $copyrightData
        ]
    ];

    echo json_encode($response);

} catch (Exception $e) {
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => $e->getMessage()
    ]);
}

$conn->close();
?>
