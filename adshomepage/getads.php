<?php
require_once __DIR__ . '/../config/db.php';

header('Content-Type: application/json');

try {
    $sql = "SELECT * FROM layout_ads";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $ads = array();
        while($row = $result->fetch_assoc()) {
            $ads[] = array(
                'id' => $row['id'],
                'image_url' => $row['image_url'], 
                'title' => $row['title'],
                'is_active' => (bool)$row['is_active'], // Chuyển đổi trực tiếp sang boolean
                'created_at' => $row['created_at'],
                'updated_at' => $row['updated_at']
            );
        }
        
        echo json_encode([
            'ok' => true,
            'success' => true,
            'data' => $ads
        ]);
    } else {
        echo json_encode([
            'ok' => true,
            'success' => true,
            'data' => []
        ]);
    }

} catch(Exception $e) {
    http_response_code(500);
    echo json_encode([
        'ok' => false,
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

$conn->close();
?>
