<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/TokenUtils.php';

class HistoryOrderUser {
    private $conn;
    private $userId;
    private $page;
    private $limit;

    public function __construct($conn, $userId, $page = 1, $limit = 10) {
        $this->conn = $conn;
        $this->userId = $userId;
        $this->page = $page;
        $this->limit = $limit;
    }

    private function getProductDetails($products) {
        $product_list = array();
        
        foreach($products as $product) {
            $product_id = $product['product_id'];
            $quantity = $product['quantity'];
            
            $products_sql = "SELECT p.id, p.name, p.price, p.category,
                            (SELECT pi.image_url 
                             FROM product_images pi 
                             WHERE pi.product_id = p.id 
                             LIMIT 1) as image_url
                           FROM products p
                           WHERE p.id = ?";
                           
            $stmt_product = $this->conn->prepare($products_sql);
            $stmt_product->bind_param("i", $product_id);
            $stmt_product->execute();
            $product_result = $stmt_product->get_result();
            
            if($product_info = $product_result->fetch_assoc()) {
                $product_info['quantity'] = $quantity;
                $product_list[] = $product_info;
            }
        }
        
        return $product_list;
    }

    private function getOrders() {
        $offset = ($this->page - 1) * $this->limit;
        
        // Đếm tổng số đơn hàng
        $count_query = "SELECT COUNT(*) as total FROM orders WHERE user_id = ?";
        $stmt_count = $this->conn->prepare($count_query);
        $stmt_count->bind_param("i", $this->userId);
        $stmt_count->execute();
        $total = $stmt_count->get_result()->fetch_assoc()['total'];

        // Lấy đơn hàng theo phân trang
        $query = "SELECT * FROM orders WHERE user_id = ? LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iii", $this->userId, $this->limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();

        $orders = array();
        while($row = $result->fetch_assoc()) {
            $products = json_decode($row['data_product'], true);
            $row['products'] = $this->getProductDetails($products);
            unset($row['data_product']);
            $orders[] = $row;
        }

        return [
            'data' => $orders,
            'total' => $total,
            'total_pages' => ceil($total / $this->limit)
        ];
    }

    private function getHistoryOrders() {
        $offset = ($this->page - 1) * $this->limit;

        // Đếm tổng số đơn hàng lịch sử
        $count_query = "SELECT COUNT(*) as total FROM history_orders WHERE user_id = ?";
        $stmt_count = $this->conn->prepare($count_query);
        $stmt_count->bind_param("i", $this->userId);
        $stmt_count->execute();
        $total = $stmt_count->get_result()->fetch_assoc()['total'];

        // Lấy đơn hàng lịch sử theo phân trang
        $query = "SELECT * FROM history_orders WHERE user_id = ? LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iii", $this->userId, $this->limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();

        $history_orders = array();
        while($row = $result->fetch_assoc()) {
            $products = json_decode($row['data_product'], true);
            $row['products'] = $this->getProductDetails($products);
            unset($row['data_product']);
            $history_orders[] = $row;
        }

        return [
            'data' => $history_orders,
            'total' => $total,
            'total_pages' => ceil($total / $this->limit)
        ];
    }

    public function getOrderHistory() {
        try {
            if (!isset($this->conn) || !($this->conn instanceof mysqli)) {
                return [
                    "ok" => false,
                    "success" => false,
                    "message" => "Không thể kết nối đến cơ sở dữ liệu"
                ];
            }

            $orders = $this->getOrders();
            $history_orders = $this->getHistoryOrders();

            if(count($orders['data']) > 0 || count($history_orders['data']) > 0) {
                return [
                    "ok" => true,
                    "success" => true,
                    "message" => "Lấy danh sách đơn hàng thành công",
                    "data" => [
                        "orders" => $orders['data'],
                        "orders_pagination" => [
                            "total" => $orders['total'],
                            "total_pages" => $orders['total_pages'],
                            "current_page" => $this->page
                        ],
                        "history_orders" => $history_orders['data'],
                        "history_pagination" => [
                            "total" => $history_orders['total'], 
                            "total_pages" => $history_orders['total_pages'],
                            "current_page" => $this->page
                        ]
                    ]
                ];
            } else {
                http_response_code(404);
                return [
                    "ok" => false,
                    "success" => false,
                    "message" => "Không tìm thấy đơn hàng nào"
                ];
            }

        } catch(Exception $e) {
            http_response_code(401);
            return [
                "ok" => false,
                "success" => false,
                "message" => "Lỗi xác thực: " . $e->getMessage()
            ];
        }
    }
}

// Sử dụng class
header('Content-Type: application/json');

try {
    $userId = TokenUtils::validateTokenAndGetUserId();
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
    
    $historyOrder = new HistoryOrderUser($conn, $userId, $page, $limit);
    $result = $historyOrder->getOrderHistory();
    echo json_encode($result);
} catch(Exception $e) {
    http_response_code(401);
    echo json_encode([
        "ok" => false,
        "success" => false,
        "message" => "Lỗi xác thực: " . $e->getMessage()
    ]);
}
?>
