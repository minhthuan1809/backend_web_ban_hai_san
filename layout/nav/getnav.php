<?php
header('Content-Type: application/json'); // Set the content type to JSON

// Include the database connection file
require_once __DIR__ . '/../../config/db.php'; // Sửa đường dẫn để trỏ đến file db.php chính xác

// Kiểm tra kết nối
if (!isset($conn) || !($conn instanceof mysqli)) {
    $error_response = [
        "error" => true,
        "message" => "Không thể kết nối đến cơ sở dữ liệu"
    ];
    echo json_encode($error_response);
    exit;
}

try {
    // Query to select data from the Navigation_Menu table
    $sql = "SELECT * FROM Navigation_Menu";
    $logoImg = "SELECT * FROM Website_Brand";
    $result = $conn->query($sql);
    $resultLogo = $conn->query($logoImg);
    $response = [];
    $logo = [];

    if ($result->num_rows > 0 && $resultLogo->num_rows > 0) {
        // Fetch all results into an array
        while($row = $result->fetch_assoc()) {
            $response[] = $row;
        }
        while($rowLogo = $resultLogo->fetch_assoc()) {
            $logo = $rowLogo;
        }
        
        $final_response = [
            "ok" => true,
            "success" => true,
            "data" => [
                "navigation" => $response,
                "brand" => $logo
            ]
        ];
    } else {
        $final_response = [
            "ok" => false,
            "success" => false,
            "message" => "Không tìm thấy dữ liệu"
        ];
    }

    // Return the response as JSON
    echo json_encode($final_response);

} catch (Exception $e) {
    // Xử lý lỗi và trả về thông báo
    $error_response = [
        "ok" => false,
        "success" => false,
        "error" => true,
        "message" => "Đã xảy ra lỗi: " . $e->getMessage()
    ];
    echo json_encode($error_response);
} finally {
    $conn->close(); // Chỉ đóng kết nối một lần ở cuối script
}
?>
