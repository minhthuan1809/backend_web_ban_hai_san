<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once(__DIR__ . '/../config/db.php');

// Lấy doanh thu theo từng tháng trong năm
$sql_revenue_by_month = "SELECT 
    MONTH(created_at) as month,
    COALESCE(SUM(final_total), 0) as revenue,
    COUNT(*) as total_orders
    FROM history_orders 
    WHERE YEAR(created_at) = YEAR(CURRENT_DATE())
    GROUP BY MONTH(created_at)
    ORDER BY month ASC";

$result_by_month = $conn->query($sql_revenue_by_month);
$revenue_by_month = array();

// Khởi tạo mảng với 12 tháng, revenue và total_orders mặc định là 0
for($i = 1; $i <= 12; $i++) {
    $revenue_by_month[$i] = array(
        'month' => $i,
        'revenue' => 0,
        'total_orders' => 0
    );
}

// Cập nhật revenue và total_orders cho các tháng có dữ liệu
while($row = $result_by_month->fetch_assoc()) {
    $month = (int)$row['month'];
    $revenue_by_month[$month]['revenue'] = (int)$row['revenue'];
    $revenue_by_month[$month]['total_orders'] = (int)$row['total_orders'];
}

// Chuyển đổi mảng kết hợp thành mảng tuần tự
$revenue_by_month = array_values($revenue_by_month);

// Lấy doanh thu theo ngày chỉ với đơn hàng thành công
$sql_revenue_by_day = "SELECT 
    DATE(created_at) as date,
    COALESCE(SUM(final_total), 0) as revenue
    FROM history_orders 
    WHERE DATE(created_at) = CURDATE() 
    AND status = 'completed'
    GROUP BY DATE(created_at)";

$result_by_day = $conn->query($sql_revenue_by_day);
$revenue_by_day = 0;

if($row = $result_by_day->fetch_assoc()) {
    $revenue_by_day = (int)$row['revenue'];
}

// Lấy top 10 sản phẩm bán chạy nhất
$sql_top_products = "SELECT 
    id,
    name, 
    price,
    quantity_sold,
    category
    FROM products
    ORDER BY quantity_sold DESC
    LIMIT 10";

$result_top_products = $conn->query($sql_top_products);
$top_products = array();

while($row = $result_top_products->fetch_assoc()) {
    $top_products[] = $row;
}

// Khởi tạo mặc định cho tất cả trạng thái
$order_status = array(
    'pending' => 0,
    'processing' => 0, 
    'completed' => 0,
    'canceled' => 0,
    'total' => 0
);

// Lấy số lượng đơn hàng theo trạng thái từ bảng orders theo ngày hiện tại
$sql_order_status = "SELECT 
    status,
    COUNT(*) as count 
    FROM orders 
    WHERE DATE(created_at) = CURDATE()
    GROUP BY status";

$result_order_status = $conn->query($sql_order_status);

while($row = $result_order_status->fetch_assoc()) {
    $order_status[$row['status']] = (int)$row['count'];
    $order_status['total'] += (int)$row['count'];
}

// Cộng thêm số lượng từ bảng history_orders theo ngày hiện tại
$sql_history_status = "SELECT 
    status,
    COUNT(*) as count 
    FROM history_orders 
    WHERE DATE(created_at) = CURDATE()
    GROUP BY status";

$result_history_status = $conn->query($sql_history_status);

while($row = $result_history_status->fetch_assoc()) {
    $order_status[$row['status']] += (int)$row['count'];
    $order_status['total'] += (int)$row['count'];
}

// Lấy số tài khoản được tạo trong ngày
$sql_accounts_today = "SELECT COUNT(*) as count 
    FROM user 
    WHERE DATE(created_at) = CURDATE()";

$result_accounts = $conn->query($sql_accounts_today);
$accounts_today = 0;

if($row = $result_accounts->fetch_assoc()) {
    $accounts_today = (int)$row['count'];
}

// Tính tỷ lệ hoàn thành đơn hàng theo ngày
$sql_completion_rate = "SELECT 
    COUNT(CASE WHEN status = 'completed' THEN 1 END) as completed_orders,
    COUNT(*) as total_orders
    FROM history_orders 
    WHERE DATE(created_at) = CURDATE()";

$result_completion = $conn->query($sql_completion_rate);
$completion_rate = 0;

if($row = $result_completion->fetch_assoc()) {
    $total_orders = (int)$row['total_orders'];
    if($total_orders > 0) {
        $completion_rate = round(((int)$row['completed_orders'] / $total_orders) * 100, 2);
    }
}

// Lấy top 5 mã giảm giá được sử dụng nhiều nhất
$sql_top_discounts = "SELECT 
    d.code,
    d.name,
    d.discount_percent,
    COUNT(dh.discount_id) as usage_count
    FROM discount d
    LEFT JOIN discount_history dh ON d.id = dh.discount_id
    GROUP BY d.id
    ORDER BY usage_count DESC
    LIMIT 5";

$result_top_discounts = $conn->query($sql_top_discounts);
$top_discounts = array();

while($row = $result_top_discounts->fetch_assoc()) {
    $top_discounts[] = $row;
}

$response = array(
    'revenue_by_month' => $revenue_by_month,
    'revenue_by_day' => $revenue_by_day,
    'top_products' => $top_products,
    'order_status' => $order_status,
    'accounts_today' => $accounts_today,
    'completion_rate' => $completion_rate,
    'top_discounts' => $top_discounts
);

echo json_encode($response);
?>
