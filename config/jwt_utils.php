<?php
class JwtUtils {
    private static $secret_key = '/API_KEY_TOKEN=(.*)/';
    private static $algorithm = 'HS256';

    public static function generateToken($user_id, $email) {
        $header = json_encode([
            'typ' => 'JWT',
            'alg' => self::$algorithm
        ]);

        $payload = json_encode([
            'user_id' => $user_id,
            'email' => $email,
            'iat' => time(),
            'exp' => time() + (60 * 60)
        ]);

        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

        $signature = hash_hmac('sha256', 
            $base64UrlHeader . "." . $base64UrlPayload, 
            self::$secret_key, 
            true
        );

        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    }

    public static function validateToken($token) {
        $parts = explode(".", $token);
        if (count($parts) != 3) {
            return false;
        }

        list($base64UrlHeader, $base64UrlPayload, $base64UrlSignature) = $parts;

        $signature = base64_decode(str_replace(['-', '_'], ['+', '/'], $base64UrlSignature));
        
        $validSignature = hash_hmac('sha256', 
            $base64UrlHeader . "." . $base64UrlPayload, 
            self::$secret_key, 
            true
        );

        if ($signature !== $validSignature) {
            return false;
        }

        $payload = json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], $base64UrlPayload)));
        
        if ($payload->exp < time()) {
            return false;
        }

        return $payload;
    }
}
?> 