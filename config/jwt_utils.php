<?php
// test
class JwtUtils {
    private static $secretKey = '/KEY_JWT=(.*)/'; // Thay thế bằng secret key thực của bạn
    
    // Thêm phương thức dọn dẹp blacklist
    private static function cleanupBlacklist() {
        global $conn;
        try {
            // Xóa các token đã hết hạn (older than 1 hour - thời gian hết hạn của token)
            $sql = "DELETE FROM blacklisted_tokens WHERE created_at < (NOW() - INTERVAL 1 HOUR)";
            if ($conn->query($sql) === false) {
                throw new Exception("Lỗi xóa token hết hạn: " . $conn->error);
            }
        } catch (Exception $e) {
            error_log("Lỗi cleanup blacklist: " . $e->getMessage());
        }
    }
    
    private static function isTokenBlacklisted($token) {
        global $conn;
        // Dọn dẹp blacklist trước khi kiểm tra
        self::cleanupBlacklist();
        
        $sql = "SELECT id FROM blacklisted_tokens WHERE token = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            error_log("Lỗi prepare statement: " . $conn->error);
            return false;
        }
        
        $stmt->bind_param("s", $token);
        if (!$stmt->execute()) {
            error_log("Lỗi execute statement: " . $stmt->error);
            return false;
        }
        
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }
    
    public static function generateToken($userId, $email) {
        $header = json_encode([
            'typ' => 'JWT',
            'alg' => 'HS256'
        ]);
        
        $payload = json_encode([
            'user_id' => $userId,
            'email' => $email,
            'iat' => time(),
            'exp' => time() + (6 * 60 * 60) // Token hết hạn sau 6 giờ
        ]);
        
        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
        
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, self::$secretKey, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
        
        return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    }
    
    public static function validateToken($token) {
        // Kiểm tra token có trong blacklist không
        if (self::isTokenBlacklisted($token)) {
            return false;
        }
        
        $parts = explode('.', $token);
        if (count($parts) != 3) {
            return false;
        }
        
        $header = base64_decode(str_replace(['-', '_'], ['+', '/'], $parts[0]));
        $payload = base64_decode(str_replace(['-', '_'], ['+', '/'], $parts[1]));
        $signature = $parts[2];
        
        $expectedSignature = hash_hmac('sha256', $parts[0] . "." . $parts[1], self::$secretKey, true);
        $expectedSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($expectedSignature));
        
        if ($signature !== $expectedSignature) {
            return false;
        }
        
        $payload = json_decode($payload);
        if (!$payload || !isset($payload->exp) || $payload->exp < time()) {
            return false;
        }
        
        return $payload;
    }
}
?>