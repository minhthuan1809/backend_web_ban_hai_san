<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../../config/db.php';

if (!isset($conn) || !($conn instanceof mysqli)) {
    $error_response = [
        "ok" => false,
        "success" => false,
        "data" => [
            "navigation" => [],
            "brand" => []
        ]
    ];
    echo json_encode($error_response);
    exit;
}

try {
    $sql = "SELECT * FROM layout_navigation_menu ORDER BY order_position ASC";
    $logoImg = "SELECT * FROM layout_website_brand";
    $result = $conn->query($sql);
    $resultLogo = $conn->query($logoImg);
    $response = [];
    $logo = [];

    // Kiểm tra và lấy dữ liệu navigation nếu có
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $response[] = $row;
        }
    }

    // Kiểm tra và lấy dữ liệu brand nếu có  
    if ($resultLogo && $resultLogo->num_rows > 0) {
        while($rowLogo = $resultLogo->fetch_assoc()) {
            $logo = $rowLogo;
        }
    }

    $final_response = [
        "ok" => true,
        "success" => true,
        "data" => [
            "navigation" => $response,
            "brand" => $logo
        ]
    ];

    echo json_encode($final_response);

} catch (Exception $e) {
    $error_response = [
        "ok" => false,
        "success" => false,
        "error" => true,
        "message" => "Đã xảy ra lỗi: " . $e->getMessage(),
        "data" => [
            "navigation" => [],
            "brand" => []
        ]
    ];
    echo json_encode($error_response);
} finally {
    $conn->close();
}
?>
