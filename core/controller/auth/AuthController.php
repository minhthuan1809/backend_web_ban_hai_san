<?php
include_once __DIR__ . '/../../../config/db.php';
session_start();

class AuthController {
    private $db;

    public function __construct() {
        global $conn;
        $this->db = $conn;
    }

    public function login($email, $password) {
        try {
            // Kiểm tra email tồn tại
            $stmt = $this->db->prepare("SELECT * FROM user WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                // Tạo session cho user
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['logged_in'] = true;

                // Tạo token ngẫu nhiên cho API authentication
                $token = bin2hex(random_bytes(32));
                $stmt = $this->db->prepare("UPDATE user SET api_token = ? WHERE id = ?");
                $stmt->execute([$token, $user['id']]);

                return [
                    'status' => 'success',
                    'message' => 'Đăng nhập thành công',
                    'data' => [
                        'user_id' => $user['id'],
                        'email' => $user['email'],
                        'api_token' => $token
                    ]
                ];
            }

            return [
                'status' => 'error',
                'message' => 'Email hoặc mật khẩu không đúng'
            ];

        } catch (PDOException $e) {
            return [
                'status' => 'error',
                'message' => 'Lỗi server: ' . $e->getMessage()
            ];
        }
    }

    public function logout() {
        if (isset($_SESSION['user_id'])) {
            // Xóa token
            $stmt = $this->db->prepare("UPDATE user SET api_token = NULL WHERE id = ?");
            $stmt->execute([$_SESSION['user_id']]);

            // Hủy session
            session_unset();
            session_destroy();

            return [
                'status' => 'success',
                'message' => 'Đăng xuất thành công'
            ];
        }

        return [
            'status' => 'error',
            'message' => 'Không có phiên đăng nhập'
        ];
    }

    public function getCurrentUser() {
        if (isset($_SESSION['user_id'])) {
            $stmt = $this->db->prepare("SELECT id, email, fullName FROM user WHERE id = ?");
            $stmt->execute([$_SESSION['user_id']]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            return [
                'status' => 'success',
                'data' => $user
            ];
        }

        return [
            'status' => 'error',
            'message' => 'Người dùng chưa đăng nhập'
        ];
    }

    public function verifyApiToken($token) {
        $stmt = $this->db->prepare("SELECT id FROM user WHERE api_token = ?");
        $stmt->execute([$token]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ? true : false;
    }

    public function register($email, $password, $fullName) {
        try {
            // Basic validation
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return ['status' => 'error', 'message' => 'Email không hợp lệ'];
            }
            
            // Check if email already exists
            $stmt = $this->db->prepare("SELECT id FROM user WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                return ['status' => 'error', 'message' => 'Email đã tồn tại'];
            }
            
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert new user
            $stmt = $this->db->prepare("INSERT INTO user (email, password, fullName) VALUES (?, ?, ?)");
            $stmt->execute([$email, $hashedPassword, $fullName]);
            
            return ['status' => 'success', 'message' => 'Đăng ký thành công'];
            
        } catch (PDOException $e) {
            return ['status' => 'error', 'message' => 'Đăng ký thất bại: ' . $e->getMessage()];
        }
    }
}