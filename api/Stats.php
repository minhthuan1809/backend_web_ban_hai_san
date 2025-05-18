<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/TokenUtils.php';
require_once __DIR__ . '/../core/middleware/PermissionMiddleware.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

try {
    // Khởi tạo permission middleware
    $permissionMiddleware = new PermissionMiddleware();

    // Xác thực token
    $userId = TokenUtils::validateTokenAndGetUserId(); 
    $permissionMiddleware->authorize($userId, 'get_stats');

    // Lấy ngày từ tham số URL, nếu không có thì dùng ngày hiện tại
    $date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

    $stats = new Stats();
    $revenueStats = $stats->getRevenueStats(); // Giữ nguyên không thêm tham số date
    $productStats = $stats->getProductStats($date);
    $paymentMethodStats = $stats->getPaymentMethodStats($date);
    $discountStats = $stats->getDiscountStats($date);
    $totalRevenue = $stats->getTotalRevenue($date);

    echo json_encode([
        'ok' => true,
        'success' => true,
        'message' => 'Lấy thống kê thành công',
        'data' => [
            'revenueStats' => $revenueStats,
            'productStats' => $productStats,
            'paymentMethodStats' => $paymentMethodStats,
            'discountStats' => $discountStats,
            'totalRevenue' => $totalRevenue
        ]
    ]);

} catch(Exception $e) {
    http_response_code(500);
    echo json_encode([
        'ok' => false,
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}

class Stats {
    private $conn;

    public function __construct() {
        global $conn;
        if (!isset($conn) || !($conn instanceof mysqli)) {
            throw new Exception("Không thể kết nối đến cơ sở dữ liệu");
        }
        $this->conn = $conn;
    }

    public function getTotalRevenue($date) {
        try {
            // Lấy tổng doanh thu và tổng giảm giá trong ngày
            $sql = "SELECT 
                    SUM(final_total) as total_revenue,
                    SUM(final_total * discount_percent / 100) as total_discount
                    FROM history_orders 
                    WHERE DATE(created_at) = ?
                    AND status = 'completed'";

            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("s", $date);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            return [
                'total_revenue' => (int)($row['total_revenue'] ?? 0),
                'total_discount' => (int)($row['total_discount'] ?? 0),
            ];

        } catch (Exception $e) {
            throw new Exception("Lỗi khi tính tổng doanh thu: " . $e->getMessage());
        }
    }

    public function getRevenueStats() {
        try {
            // Lấy ngày hiện tại và 2 ngày trước
            $today = date('Y-m-d');
            $yesterday = date('Y-m-d', strtotime('-1 day'));
            $twoDaysAgo = date('Y-m-d', strtotime('-2 day'));

            // Khởi tạo mảng kết quả
            $stats = [
                'today' => ['revenue' => 0, 'orders' => 0],
                'yesterday' => ['revenue' => 0, 'orders' => 0],
                'twoDaysAgo' => ['revenue' => 0, 'orders' => 0]
            ];

            // Lấy tất cả đơn hàng trong 3 ngày gần nhất
            $sql = "SELECT created_at, final_total FROM history_orders 
                   WHERE status = 'completed' 
                   AND DATE(created_at) >= ?";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("s", $twoDaysAgo);
            $stmt->execute();
            $result = $stmt->get_result();

            // Xử lý từng đơn hàng
            while($row = $result->fetch_assoc()) {
                $orderDate = date('Y-m-d', strtotime($row['created_at']));
                
                switch($orderDate) {
                    case $today:
                        $stats['today']['revenue'] += (int)$row['final_total'];
                        $stats['today']['orders']++;
                        break;
                    case $yesterday:
                        $stats['yesterday']['revenue'] += (int)$row['final_total'];
                        $stats['yesterday']['orders']++;
                        break;
                    case $twoDaysAgo:
                        $stats['twoDaysAgo']['revenue'] += (int)$row['final_total'];
                        $stats['twoDaysAgo']['orders']++;
                        break;
                }
            }
            
            $stmt->close();
            return $stats;

        } catch (Exception $e) {
            throw new Exception("Lỗi khi lấy thống kê doanh thu: " . $e->getMessage());
        }
    }

    public function getProductStats($date) {
        try {
            // Lấy tất cả đơn hàng theo ngày được chọn
            $sql = "SELECT h.data_product, p.id, p.name, p.price 
                   FROM history_orders h
                   CROSS JOIN products p
                   WHERE h.status = 'completed' 
                   AND DATE(h.created_at) = ?";

            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("s", $date);
            $stmt->execute();
            $result = $stmt->get_result();

            // Khởi tạo mảng thống kê sản phẩm
            $productStats = [];

            // Xử lý từng đơn hàng
            while ($row = $result->fetch_assoc()) {
                $productId = $row['id'];
                
                // Khởi tạo thống kê cho sản phẩm nếu chưa có
                if (!isset($productStats[$productId])) {
                    $productStats[$productId] = [
                        'id' => (int)$productId,
                        'name' => $row['name'],
                        'price' => (int)$row['price'],
                        'order_count' => 0,
                        'total_quantity' => 0,
                        'total_revenue' => 0
                    ];
                }

                // Xử lý data_product từ JSON
                if ($row['data_product']) {
                    $orderProducts = json_decode($row['data_product'], true);
                    if (is_array($orderProducts)) {
                        foreach ($orderProducts as $product) {
                            if ($product['product_id'] == $productId) {
                                $quantity = (int)$product['quantity'];
                                $productStats[$productId]['order_count']++;
                                $productStats[$productId]['total_quantity'] += $quantity;
                                $productStats[$productId]['total_revenue'] += $quantity * $row['price'];
                            }
                        }
                    }
                }
            }

            // Lọc sản phẩm có bán trong ngày và sắp xếp theo số lượng bán
            $finalStats = array_values(array_filter($productStats, function($item) {
                return $item['total_quantity'] > 0;
            }));

            usort($finalStats, function($a, $b) {
                return $b['total_quantity'] - $a['total_quantity'];
            });

            return $finalStats;

        } catch (Exception $e) {
            throw new Exception("Lỗi khi lấy thống kê sản phẩm: " . $e->getMessage());
        }
    }

    public function getPaymentMethodStats($date) {
        try {
            // Khởi tạo mảng kết quả với giá trị mặc định
            $stats = [
                [
                    'method' => 'Thanh toán khi nhận hàng',
                    'method_code' => 'cod',
                    'total_orders' => 0,
                    'total_revenue' => 0
                ],
                [
                    'method' => 'Chuyển khoản ngân hàng',
                    'method_code' => 'bank',
                    'total_orders' => 0,
                    'total_revenue' => 0
                ]
            ];

            // Lấy thống kê theo ngày được chọn
            $sql = "SELECT payment_method, COUNT(*) as total_orders, SUM(final_total) as total_revenue 
                   FROM history_orders 
                   WHERE status = 'completed' 
                   AND DATE(created_at) = ?
                   GROUP BY payment_method";

            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("s", $date);
            $stmt->execute();
            $result = $stmt->get_result();

            // Cập nhật số liệu thực tế
            while ($row = $result->fetch_assoc()) {
                foreach ($stats as &$stat) {
                    if ($stat['method_code'] === $row['payment_method']) {
                        $stat['total_orders'] = (int)$row['total_orders'];
                        $stat['total_revenue'] = (int)$row['total_revenue'];
                        break;
                    }
                }
            }

            return $stats;

        } catch (Exception $e) {
            throw new Exception("Lỗi khi lấy thống kê phương thức thanh toán: " . $e->getMessage());
        }
    }

    public function getDiscountStats($date) {
        try {
            $sql = "SELECT 
                    discount_code,
                    COUNT(*) as times_used,
                    SUM(final_total * discount_percent / 100) as total_discount_amount
                    FROM history_orders 
                    WHERE DATE(created_at) = ?
                    AND discount_code != ''
                    AND status = 'completed'
                    GROUP BY discount_code";

            $stmt = $this->conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Lỗi chuẩn bị truy vấn: " . $this->conn->error);
            }

            $stmt->bind_param("s", $date);
            
            if (!$stmt->execute()) {
                throw new Exception("Lỗi thực thi truy vấn: " . $stmt->error);
            }

            $result = $stmt->get_result();
            $discountStats = [];

            while ($row = $result->fetch_assoc()) {
                $discountStats[] = [
                    'discount_code' => $row['discount_code'],
                    'times_used' => (int)$row['times_used'],
                    'total_discount_amount' => (int)$row['total_discount_amount']
                ];
            }

            return $discountStats;

        } catch (Exception $e) {
            throw new Exception("Lỗi khi lấy thống kê mã giảm giá: " . $e->getMessage());
        }
    }
}