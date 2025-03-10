<?php
include_once __DIR__ . '/../../../config/db.php';

class PermissionController {
    private $db;

    public function __construct() {
        global $conn;
        $this->db = $conn;
    }

    /**
     * Kiểm tra xem người dùng có quyền thực hiện hành động cụ thể không
     * 
     * @param int $userId ID của người dùng
     * @param string $permissionName Tên quyền cần kiểm tra
     * @return bool True nếu người dùng có quyền, ngược lại là False
     */
    public function can($userId, $permissionName) {
        try {
            // Kiểm tra user_id hợp lệ
            if (!$userId || $userId <= 0) {
                return false;
            }

            // Lấy role_id của user
            $stmt = $this->db->prepare("SELECT role_id FROM user WHERE id = ?");
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows === 0) {
                return false; // Người dùng không tồn tại
            }
            
            $user = $result->fetch_assoc();
            $roleId = $user['role_id'];
            
            // Kiểm tra nếu role_id null
            if (!$roleId) {
                return false;
            }
            
            // Kiểm tra xem role có quyền này không
            $stmt = $this->db->prepare("
                SELECT 1 
                FROM role_permission rp
                JOIN permission p ON rp.permission_id = p.id
                WHERE rp.role_id = ? AND p.name = ?
                LIMIT 1
            ");
            $stmt->bind_param("is", $roleId, $permissionName);
            $stmt->execute();
            $result = $stmt->get_result();
            
            return $result->num_rows > 0;
            
        } catch (Exception $e) {
            // Log lỗi nếu cần
            error_log("Permission check error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Lấy tất cả quyền của một vai trò
     * 
     * @param int $roleId ID của vai trò
     * @return array Danh sách các quyền
     */
    public function getRolePermissions($roleId) {
        try {
            $stmt = $this->db->prepare("
                SELECT p.id, p.name 
                FROM permission p
                JOIN role_permission rp ON p.id = rp.permission_id
                WHERE rp.role_id = ?
            ");
            $stmt->bind_param("i", $roleId);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $permissions = [];
            while ($row = $result->fetch_assoc()) {
                $permissions[] = $row;
            }
            
            return $permissions;
            
        } catch (Exception $e) {
            return [];
        }
    }

    /**
     * Gán quyền cho vai trò
     * 
     * @param int $roleId ID của vai trò
     * @param int $permissionId ID của quyền
     * @return bool True nếu thành công, ngược lại là False
     */
    public function assignPermissionToRole($roleId, $permissionId) {
        try {
            // Kiểm tra xem đã tồn tại chưa
            $checkStmt = $this->db->prepare("
                SELECT 1 FROM role_permission 
                WHERE role_id = ? AND permission_id = ?
            ");
            $checkStmt->bind_param("ii", $roleId, $permissionId);
            $checkStmt->execute();
            $result = $checkStmt->get_result();
            
            if ($result->num_rows > 0) {
                return true; // Đã tồn tại
            }
            
            // Thêm mới
            $stmt = $this->db->prepare("
                INSERT INTO role_permission (role_id, permission_id) 
                VALUES (?, ?)
            ");
            $stmt->bind_param("ii", $roleId, $permissionId);
            return $stmt->execute();
            
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Tạo quyền mới
     * 
     * @param string $name Tên quyền
     * @return int|bool ID của quyền mới hoặc False nếu thất bại
     */
    public function createPermission($name) {
        try {
            // Kiểm tra xem quyền đã tồn tại chưa
            $checkStmt = $this->db->prepare("SELECT id FROM permission WHERE name = ?");
            $checkStmt->bind_param("s", $name);
            $checkStmt->execute();
            $result = $checkStmt->get_result();
            
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row['id']; // Trả về ID nếu đã tồn tại
            }
            
            // Tạo quyền mới
            $stmt = $this->db->prepare("INSERT INTO permission (name) VALUES (?)");
            $stmt->bind_param("s", $name);
            
            if ($stmt->execute()) {
                return $stmt->insert_id;
            }
            
            return false;
            
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Tạo vai trò mới
     * 
     * @param string $name Tên vai trò
     * @return int|bool ID của vai trò mới hoặc False nếu thất bại
     */
    public function createRole($name) {
        try {
            // Kiểm tra xem vai trò đã tồn tại chưa
            $checkStmt = $this->db->prepare("SELECT id FROM role WHERE name = ?");
            $checkStmt->bind_param("s", $name);
            $checkStmt->execute();
            $result = $checkStmt->get_result();
            
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row['id']; // Trả về ID nếu đã tồn tại
            }
            
            // Tạo vai trò mới
            $stmt = $this->db->prepare("INSERT INTO role (name) VALUES (?)");
            $stmt->bind_param("s", $name);
            
            if ($stmt->execute()) {
                return $stmt->insert_id;
            }
            
            return false;
            
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Gán vai trò cho người dùng
     * 
     * @param int $userId ID của người dùng
     * @param int $roleId ID của vai trò
     * @return bool True nếu thành công, ngược lại là False
     */
    public function assignRoleToUser($userId, $roleId) {
        try {
            $stmt = $this->db->prepare("UPDATE user SET role_id = ? WHERE id = ?");
            $stmt->bind_param("ii", $roleId, $userId);
            return $stmt->execute();
            
        } catch (Exception $e) {
            return false;
        }
    }
}
