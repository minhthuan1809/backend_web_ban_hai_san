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
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            if ($user && password_verify($password, $user['password'])) {
                // Tạo session cho user
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['logged_in'] = true;

                // Tạo token ngẫu nhiên cho API authentication
                $token = bin2hex(random_bytes(32));
                $stmt = $this->db->prepare("UPDATE user SET api_token = ? WHERE id = ?");
                $stmt->bind_param("si", $token, $user['id']);
                $stmt->execute();

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

        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Lỗi server: ' . $e->getMessage()
            ];
        }
    }

    public function getCurrentUser() {
        if (isset($_SESSION['user_id'])) {
            $stmt = $this->db->prepare("SELECT id, email, fullName FROM user WHERE id = ?");
            $stmt->bind_param("i", $_SESSION['user_id']);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

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
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    public function register($email, $password, $fullname) {
        try {
            // Basic validation
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return ['status' => 'error', 'message' => 'Email không hợp lệ'];
            }
            
            // Check if email already exists
            $stmt = $this->db->prepare("SELECT id FROM user WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                return [
                    'ok' => false,
                    'status' => 'error', 
                    'message' => 'Email đã tồn tại'
                ];
            }
            
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $role_id = 2;
            $avatar = 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1742015676/c8rpqw6wk8edghzxo4xg.jpg';
            
            // Insert new user
            $stmt = $this->db->prepare("INSERT INTO user (email, password, fullName, role_id, avatar) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssis", $email, $hashedPassword, $fullname, $role_id, $avatar);
            $stmt->execute();
            
            return [
                'ok' => true,
                'status' => 'success', 
                'message' => 'Đăng ký thành công'
            ];
            
        } catch (Exception $e) {
            return [
                'ok' => false,
                'status' => 'error', 
                'message' => 'Đăng ký thất bại: ' . $e->getMessage()
            ];
        }
    }
}