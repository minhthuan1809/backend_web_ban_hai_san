<?php
require_once __DIR__ . '/core/middleware/PermissionMiddleware.php';
require_once __DIR__ . '/config/TokenUtils.php';

// Set content type to JSON for consistent response format
header('Content-Type: application/json');

// Lấy user_id từ token
$userId = TokenUtils::validateTokenAndGetUserId();

// Permission to check
$requiredPermission = 'get_contact';

// Initialize permission middleware
$permissionMiddleware = new PermissionMiddleware();

try {
    // Check if user has the required permission
    $permissionMiddleware->authorize($userId, $requiredPermission);
    
    // If we get here, the user has permission
    echo json_encode([
        "ok" => true,
        "success" => true,
        "message" => "Welcome to MyPhone Shop",
        "user_id" => $userId
    ]);
    
} catch (Exception $e) {
    // Handle any unexpected errors
    http_response_code(500);
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Error: " . $e->getMessage()
    ]);
}
?>
