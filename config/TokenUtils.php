<?php
require_once __DIR__ . '/jwt_utils.php';

class TokenUtils {
    /**
     * Lấy user_id từ token JWT
     * 
     * @param string|null $token JWT token hoặc null để tự động lấy từ header
     * @return int|null ID của người dùng hoặc null nếu token không hợp lệ
     */
    public static function getUserIdFromToken($token = null) {
        // Nếu không có token được cung cấp, lấy từ header
        if ($token === null) {
            $headers = apache_request_headers();
            $auth_header = isset($headers['Authorization']) ? $headers['Authorization'] : '';
            
            if (preg_match('/Bearer\s+(.*)$/i', $auth_header, $matches)) {
                $token = $matches[1];
            }
        }

        if (empty($token)) {
            return null;
        }

        $payload = JwtUtils::validateToken($token);
        if (!$payload) {
            return null;
        }

        return $payload->user_id ?? null;
    }

    /**
     * Xác thực token và trả về user_id, nếu không hợp lệ sẽ trả về lỗi JSON và thoát
     * 
     * @param string|null $token JWT token hoặc null để tự động lấy từ header
     * @return int ID của người dùng
     * @throws Exception nếu token không hợp lệ hoặc đã hết hạn
     */
    public static function validateTokenAndGetUserId($token = null) {
        $userId = self::getUserIdFromToken($token);
        
        if ($userId === null) {
            header('Content-Type: application/json');
            http_response_code(401);
            echo json_encode([ 'ok' => false, 'success' => false, 'message' => 'Token không hợp lệ hoặc đã hết hạn']);
            exit();
        }
        
        return $userId;
    }
}
?>