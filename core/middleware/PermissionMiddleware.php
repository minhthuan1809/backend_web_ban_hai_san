<?php
require_once __DIR__ . '../../controller/permission/PermissionController.php';

class PermissionMiddleware {
    private $permissionController;
    
    public function __construct() {
        $this->permissionController = new PermissionController();
    }
    
    /**
     * Kiểm tra quyền truy cập
     * 
     * @param int $userId ID của người dùng
     * @param string $permission Quyền cần kiểm tra
     * @return bool True nếu có quyền, ngược lại là False
     */
    public function checkPermission($userId, $permission) {
        return $this->permissionController->can($userId, $permission);
    }
    
    /**
     * Xác thực quyền và trả về lỗi nếu không có quyền
     * 
     * @param int $userId ID của người dùng
     * @param string $permission Quyền cần kiểm tra
     * @return void
     */
    public function authorize($userId, $permission) {
        if (!$this->checkPermission($userId, $permission)) {
            header('Content-Type: application/json');
            http_response_code(403);
            echo json_encode([
                "ok" => false,
                "success" => false,
                "message" => "Bạn không có quyền thực hiện hành động này",
          
            ]);
            exit;
        }
    }
}
