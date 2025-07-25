# Backend Web Bán Hải Sản

Website backend cho hệ thống bán hải sản trực tuyến, xây dựng bằng PHP và MySQL.

## Cài đặt với Docker

### Yêu cầu
- Docker
- Docker Compose

### Các bước cài đặt
1. Clone repository:
```
git clone <repository_url>
cd backend_web_ban_hai_san
```

2. Khởi chạy Docker Compose:
```
docker-compose up -d
```

3. Truy cập website:
```
http://localhost:9999
```

### Thông tin cơ sở dữ liệu
- Host: localhost
- Port: 3306
- Database: haisan
- Username: haisan
- Password: haisan

## Cấu trúc thư mục
- address: API quản lý địa chỉ
- api: API xác thực và người dùng
- card: API quản lý giỏ hàng
- config: Cấu hình kết nối cơ sở dữ liệu
- contact: API quản lý liên hệ
- discount: API quản lý mã giảm giá
- orders: API quản lý đơn hàng
- products: API quản lý sản phẩm
- role: API quản lý vai trò và phân quyền
- user: API quản lý người dùng
