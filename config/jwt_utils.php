<?php
class JwtUtils {
    private static $secretKey = "your_secret_key_here"; // Thay thế bằng secret key thực của bạn
    
    public static function generateToken($userId, $email) {
        $header = json_encode([
            'typ' => 'JWT',
            'alg' => 'HS256'
        ]);
        
        $payload = json_encode([
            'user_id' => $userId,
            'email' => $email,
            'iat' => time(),
            'exp' => time() + (60 * 60) // Token hết hạn sau 1 giờ
        ]);
        
        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
        
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, self::$secretKey, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
        
        return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    }
    
    public static function validateToken($token) {
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