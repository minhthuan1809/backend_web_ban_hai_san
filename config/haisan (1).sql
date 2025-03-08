-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 08, 2025 lúc 04:59 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `haisan`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `gmail` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT '',
  `is_read` tinyint(1) DEFAULT 0,
  `is_sent` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `content`, `gmail`, `title`, `is_read`, `is_sent`, `created_at`, `updated_at`) VALUES
(42, 'sd sdf', 'bán cho con tom hùm', 'thuan18092003@gmail.com', 'mua hàng', 1, 0, '2025-03-05 15:42:52', '2025-03-05 15:43:12');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `layout_benefit`
--

CREATE TABLE `layout_benefit` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `icon` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `layout_benefit`
--

INSERT INTO `layout_benefit` (`id`, `icon`, `title`, `description`, `created_at`, `updated_at`) VALUES
(1, 'ShoppingBag', 'Chất Lượng', 'Cam kết sử dụng hải sản tươi sống 100%', '2025-03-03 23:48:42', '2025-03-05 13:58:27'),
(2, 'Target', 'Đa Dạng', 'Thực đơn phong phú với hơn 100 món ăn', '2025-03-03 23:48:42', '2025-03-05 14:30:04'),
(4, 'ThumbsUp', 'Uy Tín', '20 năm kinh nghiệm phục vụ', '2025-03-03 23:48:42', '2025-03-03 23:48:42'),
(10, 'Server', 'Phục Vụ', 'Đội ngũ nhân viên chuyên nghiệp, thân thiện', '2025-03-05 14:09:55', '2025-03-05 14:09:55');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `layout_commitment`
--

CREATE TABLE `layout_commitment` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description_one` text NOT NULL,
  `description_two` text NOT NULL,
  `description_three` text NOT NULL,
  `description_four` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `layout_commitment`
--

INSERT INTO `layout_commitment` (`id`, `title`, `description_one`, `description_two`, `description_three`, `description_four`, `created_at`, `updated_at`) VALUES
(1, 'Cam Kết Của Chúng Tôi ', 'Đảm bảo chất lượng món ăn từ nhà hàng ', 'Giao hàng đúng giờ, đúng địa chỉ', 'Đổi trả miễn phí nếu món ăn không đúng yêu cầu', 'Nhân viên giao hàng chuyên nghiệp, thân thiện', '2025-03-03 23:45:43', '2025-03-05 15:40:49');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `layout_contactsfooter`
--

CREATE TABLE `layout_contactsfooter` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `icon` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `layout_contactsfooter`
--

INSERT INTO `layout_contactsfooter` (`id`, `icon`, `type`, `created_at`, `updated_at`) VALUES
(1, 'Map', '123 Đường ABC, Quận XYZ', '2025-02-23 05:01:47', '2025-02-25 23:56:47'),
(2, 'Phone', '(123) 456-7890', '2025-02-23 05:01:47', '2025-02-23 05:01:47'),
(3, 'Mail', 'info@example.com', '2025-02-23 05:01:47', '2025-02-23 05:01:47'),
(4, 'CalendarCheck2', 'Thứ 2 - Thứ 5: 11:00 - 22:00; Thứ 6 - Chủ Nhật: 11:00 - 23:00', '2025-02-23 05:01:47', '2025-02-23 05:01:47');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `layout_copyright`
--

CREATE TABLE `layout_copyright` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `text` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `layout_copyright`
--

INSERT INTO `layout_copyright` (`id`, `text`, `created_at`, `updated_at`) VALUES
(1, '2025 MINHTHUAN. Bản quyền được bảo lưu . ', '2025-02-23 05:01:47', '2025-02-26 14:32:05');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `layout_customer_choose_item_section`
--

CREATE TABLE `layout_customer_choose_item_section` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `icon` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `layout_customer_choose_item_section`
--

INSERT INTO `layout_customer_choose_item_section` (`id`, `icon`, `title`, `description`) VALUES
(2, 'Utensils', 'Duy trì hương vị và chất lượng ', 'thực phẩm ngon nhất'),
(3, 'Check', 'Món ăn được chế biến phong phú', 'và đa dạng'),
(4, 'ThumbsUp', 'Giá cả ổn định, phong cách phục vụ', 'chuyên nghiệp'),
(5, 'Cookie', 'Thực phẩm sạch, tươi ngon nhất ', 'được lựa chọn kỹ càng');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `layout_customer_choose_section`
--

CREATE TABLE `layout_customer_choose_section` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `image_url` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `layout_customer_choose_section`
--

INSERT INTO `layout_customer_choose_section` (`id`, `title`, `image_url`) VALUES
(1, 'Đây là lý do khách hàng thường chọn chúng tôi ', 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1740498965/bduiyctdoxey8pszwsyn.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `layout_customer_section`
--

CREATE TABLE `layout_customer_section` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image_url` longtext NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `layout_customer_section`
--

INSERT INTO `layout_customer_section` (`id`, `name`, `image_url`, `description`) VALUES
(8, 'Nguyễn Minh Thuận ', 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1740416201/jmuk2wda4x0i58tuofah.jpg', 'Nhà hàng có không gian thoáng đãng, món ăn chế biến tinh tế và nhân viên phục vụ chu đáo. Đặc biệt là các món hải sản tươi ngon khiến tôi muốn quay lại lần nữa.'),
(11, 'Nguyễn Huy Chiến', 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1740416219/sywqviwdl4xfoxdn4spo.jpg', 'Vừa bước vào nhà hàng Minh Thuận, tôi đã bị cuốn hút bởi không gian ấm cúng, sạch sẽ và có chút gì đó rất gần gũi. Mùi hương của những món ăn thơm lừng lan tỏa trong không khí khiến bụng tôi sôi lên réo rắt.\n\nTôi nhanh chóng gọi vài món đặc trưng của quán. Khi đĩa thức ăn được mang ra, tôi không thể không trầm trồ: trình bày đẹp mắt, hương thơm quyến rũ. Cắn một miếng, vị giác như bùng nổ! Gia vị nêm nếm vừa miệng, nguyên liệu tươi ngon, từng miếng thịt mềm tan trong miệng, nước sốt đậm đà, đúng chuẩn \"cực phẩm nhân gian\".'),
(12, 'Lò Tiến Anh', 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1740416235/sfuj8sa9ahyfrkioerbz.jpg', 'Nhà hàng có không gian thoáng đãng, món ăn chế biến tinh tế và nhân viên phục vụ chu đáo. Đặc biệt là các món hải sản tươi ngon khiến tôi muốn quay lại lần nữa.'),
(13, 'Pham Văn Hiếu', 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1740417451/kcmyqphtrooxff1omafl.jpg', 'Nhà hàng có không gian thoáng đãng, món ăn chế biến tinh tế và nhân viên phục vụ chu đáo. Đặc biệt là các món hải sản tươi ngon khiến tôi muốn quay lại lần nữa.'),
(14, 'Nguyễn Thanh Nam', 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1740416405/g5eepwgefewr95sikiox.jpg', 'Ngồi xuống bàn, anh không ngần ngại gọi ngay những món đặc trưng của nhà hàng. Khi đĩa thức ăn được bưng ra, mắt anh sáng rực như tìm thấy kho báu. Mỗi miếng ăn đưa vào miệng đều là sự hòa quyện hoàn hảo giữa hương vị và cách nêm nếm tinh tế, khiến anh không thể ngừng lại. Đặc biệt, món \"đặc sản Minh Thuận\" với lớp vỏ giòn rụm, nhân mềm thơm đã khiến anh phải gật gù tán thưởng.\n\nKhông chỉ đồ ăn ngon, thái độ phục vụ cũng khiến anh hài lòng. Nhân viên nhanh nhẹn, niềm nở, sẵn sàng đáp ứng mọi yêu cầu của khách. Càng ăn,Máy Đớp càng cảm thấy mình đã tìm đúng nơi để thỏa mãn niềm đam mê ẩm thực.'),
(15, 'Cưu Vân Long', 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1740416396/ahxjsz5vsjaxkybv4t61.jpg', 'Nhà hàng có không gian thoáng đãng, món ăn chế biến tinh tế và nhân viên phục vụ chu đáo. Đặc biệt là các món hải sản tươi ngon khiến tôi muốn quay lại lần nữa.'),
(18, 'Nguyễn Thị Ánh', 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1740417236/mvhkiwhjjhs3a3rxhyhz.jpg', 'Nhà hàng có không gian thoáng đãng, món ăn chế biến tinh tế và nhân viên phục vụ chu đáo. Đặc biệt là các món hải sản tươi ngon khiến tôi muốn quay lại lần nữa.'),
(19, 'Vũ Quang Huy', 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1740417508/kmzu6xqjl2ykrbc1s3lz.jpg', 'Nhà hàng có không gian thoáng đãng, món ăn chế biến tinh tế và nhân viên phục vụ chu đáo. Đặc biệt là các món hải sản tươi ngon khiến tôi muốn quay lại lần nữa.');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `layout_customer_section_img`
--

CREATE TABLE `layout_customer_section_img` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image_url` longtext NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `layout_customer_section_img`
--

INSERT INTO `layout_customer_section_img` (`id`, `image_url`, `title`) VALUES
(1, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1740416033/cssio8csvlt3atdgsijg.webp', 'Khách hàng nói về chùng tôi ');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `layout_introductionsfooter`
--

CREATE TABLE `layout_introductionsfooter` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `layout_introductionsfooter`
--

INSERT INTO `layout_introductionsfooter` (`id`, `title`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Giới thiệu ', 'Là một nhà hàng sang trọng với không gian ấm cúng và phong cách hiện đại. Chúng tôi phục vụ các món ăn đặc sắc được chế biến từ những nguyên liệu tươi ngon nhất cùng đồ uống chất lượng cao.', '2025-02-23 05:01:47', '2025-02-26 00:35:16');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `layout_introductionssection`
--

CREATE TABLE `layout_introductionssection` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `content` text NOT NULL,
  `image_url` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `layout_introductionssection`
--

INSERT INTO `layout_introductionssection` (`id`, `title`, `description`, `content`, `image_url`) VALUES
(1, 'Minh Thuận', 'Nhà hàng hải sản Minh Thuận là điểm đến lý tưởng cho những tín đồ yêu thích hải sản tươi sống. Tọa lạc ngay sát bờ biển Bình Thuận, Minh Thuận tự hào mang đến nguồn hải sản tươi ngon nhất, được đánh bắt trực tiếp mỗi ngày. Với hơn 50 loại hải sản phong phú, chế biến theo công thức đặc biệt, chúng tôi mang đến những món ăn thơm ngon, đậm đà hương vị biển cả, khiến thực khách nhớ mãi không quên.', 'Tận hưởng hải sản chất lượng mà không phải lo về giá cả. Chúng tôi cam kết mang đến những sản phẩm tươi sạch, an toàn với mức giá hợp lý, cùng dịch vụ tận tâm.', 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1740419894/tcnprvj4ldlnmtd8hhfc.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `layout_navigation_menu`
--

CREATE TABLE `layout_navigation_menu` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `url` varchar(255) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `order_position` int(11) NOT NULL,
  `is_active` tinyint(1) DEFAULT 0,
  `is_visible` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `layout_navigation_menu`
--

INSERT INTO `layout_navigation_menu` (`id`, `name`, `url`, `parent_id`, `order_position`, `is_active`, `is_visible`) VALUES
(11, 'Trang Chủ', '/', NULL, 1, 0, 1),
(13, 'Tin Tức', '/news', NULL, 5, 0, 1),
(14, 'Sản Phẩm', '/products', NULL, 2, 0, 1),
(15, 'Liên hệ', '/contact', NULL, 4, 0, 1),
(16, 'Giới thiệu', '/about', NULL, 3, 0, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `layout_ordering_online`
--

CREATE TABLE `layout_ordering_online` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `icon` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description_one` text NOT NULL,
  `description_two` text NOT NULL,
  `description_three` text NOT NULL,
  `description_four` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `layout_ordering_online`
--

INSERT INTO `layout_ordering_online` (`id`, `icon`, `title`, `description_one`, `description_two`, `description_three`, `description_four`, `created_at`, `updated_at`) VALUES
(1, 'Truck', 'Giao Hàng Tận Nơi', ' Phạm vi giao hàng: 10km từ nhà hàng', 'Thời gian giao hàng: 30-45 phút', 'Đóng gói cẩn thận, giữ nhiệt tốt', 'Miễn phí giao hàng cho đơn từ 500.000đ', '2025-03-03 23:42:46', '2025-03-05 14:30:34'),
(2, 'Clock', 'Thời Gian Phục Vụ', 'Nhà hàng: 10:00 - 22:00', 'Đặt hàng online: 10:00 - 21:00', 'Phục vụ tất cả các ngày trong tuần', 'Hotline đặt hàng: 0123 456 789', '2025-03-03 23:42:46', '2025-03-05 12:07:12');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `layout_ordering_process`
--

CREATE TABLE `layout_ordering_process` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `icon` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `layout_ordering_process`
--

INSERT INTO `layout_ordering_process` (`id`, `icon`, `title`, `description`, `created_at`, `updated_at`) VALUES
(1, 'ShoppingBag', 'Chọn món', 'Dễ dàng đặt hàng qua website hoặc gọi điện trực tiếp', '2025-03-03 23:31:02', '2025-03-03 23:31:02'),
(2, 'CreditCard', 'Thanh Toán', 'Đa dạng phương thức thanh toán: tiền mặt, chuyển khoản, ví điện tử', '2025-03-03 23:31:02', '2025-03-03 23:31:02'),
(3, 'Truck', 'Giao Hàng', 'Giao hàng nhanh chóng, đảm bảo chất lượng món ăn', '2025-03-03 23:31:02', '2025-03-03 23:31:02');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `layout_slide_header`
--

CREATE TABLE `layout_slide_header` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `layout_slide_header`
--

INSERT INTO `layout_slide_header` (`id`, `image_url`, `title`, `description`) VALUES
(2, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1740415996/wwvzoukjrkdlskbdkmei.jpg', 'MINH THUẬN', 'Chào mừng bạn đến với nhà hàng của chúng tôi !'),
(3, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1740416005/ds6ckdcq5kr0y7li04z6.jpg', 'Hải Sản Minh Thuận', 'Chào mừng bạn đến với nhà hàng của chúng tôi !'),
(10, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1740418715/whhrjpet9wfshn9hsrjo.jpg', 'MINH THUẬN', 'Chào mừng bạn đến với nhà hàng của chúng tôi !');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `layout_social_media_links`
--

CREATE TABLE `layout_social_media_links` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `platform` varchar(50) NOT NULL,
  `url` varchar(255) NOT NULL,
  `target` text DEFAULT '_self',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `layout_social_media_links`
--

INSERT INTO `layout_social_media_links` (`id`, `platform`, `url`, `target`, `created_at`, `updated_at`) VALUES
(1, 'Facebook', 'https://facebook.com/minhthuan', '_blank', '2025-02-23 05:01:47', '2025-02-23 05:01:47'),
(2, 'Instagram', 'https://instagram.com/minhthuan', '_blank', '2025-02-23 05:01:47', '2025-02-23 05:01:47'),
(3, 'Youtube', 'https://youtube.com/minhthuan', '_blank', '2025-02-23 05:01:47', '2025-02-23 05:01:47');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `layout_space`
--

CREATE TABLE `layout_space` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `icon` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description_one` text NOT NULL,
  `description_two` text NOT NULL,
  `description_three` text NOT NULL,
  `description_four` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `layout_space`
--

INSERT INTO `layout_space` (`id`, `icon`, `title`, `description_one`, `description_two`, `description_three`, `description_four`, `created_at`, `updated_at`) VALUES
(3, 'ChefHat', 'Khu Vực Bếp Chuyên Nghiệp', 'Nhân viên bếp được đào tạo bài bản', 'Trang thiết bị hiện đại, đảm bảo vệ sinh an toàn thực phẩm', 'Khu vực sơ chế và chế biến thực phẩm', 'Hệ thống làm mát và thông gió đạt chuẩn', '2025-03-05 11:49:57', '2025-03-05 11:49:57'),
(4, 'Cookie', 'Đội Ngũ Bếp ', 'Đội ngũ bếp trưởng với hơn 15 năm kinh nghiệm', 'Rất nhiều món ăn đặc sắc được chế biến', 'Quy trình chế biến chuẩn mực', 'Kiểm soát chất lượng nghiêm ngặt', '2025-03-05 11:49:57', '2025-03-05 11:50:33');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `layout_story`
--

CREATE TABLE `layout_story` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description_one` longtext NOT NULL,
  `description_two` longtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `layout_story`
--

INSERT INTO `layout_story` (`id`, `title`, `description_one`, `description_two`, `created_at`, `updated_at`) VALUES
(1, 'Câu Chuyện Của Chúng Tôi', 'Nhà hàng Hải Sản Minh Thuận được thành lập từ năm 2003, khởi đầu là một quán ăn nhỏ với tâm huyết mang đến những món hải sản tươi ngon nhất cho thực khách. Qua hơn 20 năm phát triển, chúng tôi đã trở thành một trong những nhà hàng hải sản uy tín nhất trong khu vực.', 'Với sự phát triển của công nghệ, chúng tôi đã mở rộng dịch vụ sang mảng đặt hàng trực tuyến và giao hàng tận nơi, giúp thực khách có thể thưởng thức các món ăn ngon của nhà hàng ngay tại nhà.', '2025-03-03 23:09:07', '2025-03-05 10:29:09');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `layout_website_brand`
--

CREATE TABLE `layout_website_brand` (
  `id` int(11) NOT NULL,
  `logo_url` longtext NOT NULL,
  `brand_name` varchar(100) NOT NULL,
  `alt_text` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `layout_website_brand`
--

INSERT INTO `layout_website_brand` (`id`, `logo_url`, `brand_name`, `alt_text`) VALUES
(1, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741257963/yj7dvm6ysxedc6arlrrr.png', 'Hải sản', 'Logo web bán hải sản');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `news`
--

CREATE TABLE `news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `image_url` longtext NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `news`
--

INSERT INTO `news` (`id`, `title`, `description`, `image_url`, `status`, `created_at`, `updated_at`) VALUES
(29, 'thuan3d', '<h3><strong>Tôm rang me được ngợi là món ăn đơn giản, dễ ăn và dễ chế biến. Vị ngọt từ tôm kết hợp với vị chua của me chính ngọt ngon của me, thêm chút nước mắm vừa miệng.</strong></h3><h1><em>Nguyên liệu cần chuẩn bị để thực hiện món tôm rang me bao gồm:</em></h1><ol><li><p><em>Tôm sú đã làm sạch</em></p></li><li><p><em>Me tươi</em></p></li><li><p><em>Hành lá, rau ăn</em></p></li><li><p><em>Những thành phần khác như nước mắm, dầu ăn, đường...</em></p></li><li><p><em>Cách sơ chế nguyên liệu chế biến:</em></p></li><li><p><em>Tôm rửa sạch, đánh vảy và cắt râu</em></p></li><li><p><em>Ngâm tôm với nước muối, rửa sạch với nước, để ráo sau đó chế biến</em></p></li><li><p><em>Đồ gia vị</em></p></li><li><p><em>Cách làm tôm rang me như sau:</em></p></li></ol><p></p><h3><strong>Tôm rang me được ngợi là món ăn đơn giản, dễ ăn và dễ chế biến. Vị ngọt từ tôm kết hợp với vị chua của me chính ngọt ngon của me, thêm chút nước mắm vừa miệng.</strong></h3><h1><em>Nguyên liệu cần chuẩn bị để thực hiện món tôm rang me bao gồm:</em></h1><ol><li><p><em>Tôm sú đã làm sạch</em></p></li><li><p><em>Me tươi</em></p></li><li><p><em>Hành lá, rau ăn</em></p></li><li><p><em>Những thành phần khác như nước mắm, dầu ăn, đường...</em></p></li><li><p><em>Cách sơ chế nguyên liệu chế biến:</em></p></li><li><p><em>Tôm rửa sạch, đánh vảy và cắt râu</em></p></li><li><p><em>Ngâm tôm với nước muối, rửa sạch với nước, để ráo sau đó chế biến</em></p></li><li><p><em>Đồ gia vị</em></p></li><li><p><em>Cách làm tôm rang me như sau:</em></p></li></ol><blockquote><p><em>Bắt đầu, cho nướng chảo, sau đó cho 1 muỗng dầu ăn vào. Phi đầu tôm lên, cho 1 muỗng nước bột đầu để tạo màu sắc. Đầu tiên, bắt đầu rây khoảng 2 – 3 phút là có thể tắt bếp. Hỗn hợp đầu có màu đỏ, mùi thơm.</em></p><p></p><p><em>thuan1d</em></p></blockquote><p></p><h3><strong>Tôm rang me được ngợi là món ăn đơn giản, dễ ăn và dễ chế biến. Vị ngọt từ tôm kết hợp với vị chua của me chính ngọt ngon của me, thêm chút nước mắm vừa miệng.</strong></h3><h1><em>Nguyên liệu cần chuẩn bị để thực hiện món tôm rang me bao gồm:</em></h1><ol><li><p><em>Tôm sú đã làm sạch</em></p></li><li><p><em>Me tươi</em></p></li><li><p><em>Hành lá, rau ăn</em></p></li><li><p><em>Những thành phần khác như nước mắm, dầu ăn, đường...</em></p></li><li><p><em>Cách sơ chế nguyên liệu chế biến:</em></p></li><li><p><em>Tôm rửa sạch, đánh vảy và cắt râu</em></p></li><li><p><em>Ngâm tôm với nước muối, rửa sạch với nước, để ráo sau đó chế biến</em></p></li><li><p><em>Đồ gia vị</em></p></li><li><p><em>Cách làm tôm rang me như sau:</em></p></li></ol><blockquote><p><em>Bắt đầu, cho nướng chảo, sau đó cho 1 muỗng dầu ăn vào. Phi đầu tôm lên, cho 1 muỗng nước bột đầu để tạo màu sắc. Đầu tiên, bắt đầu rây khoảng 2 – 3 phút là có thể tắt bếp. Hỗn hợp đầu có màu đỏ, mùi thơm.</em></p><p></p><p><em>thuan1d</em></p></blockquote><p></p><h3><strong>Tôm rang me được ngợi là món ăn đơn giản, dễ ăn và dễ chế biến. Vị ngọt từ tôm kết hợp với vị chua của me chính ngọt ngon của me, thêm chút nước mắm vừa miệng.</strong></h3><h1><em>Nguyên liệu cần chuẩn bị để thực hiện món tôm rang me bao gồm:</em></h1><ol><li><p><em>Tôm sú đã làm sạch</em></p></li><li><p><em>Me tươi</em></p></li><li><p><em>Hành lá, rau ăn</em></p></li><li><p><em>Những thành phần khác như nước mắm, dầu ăn, đường...</em></p></li><li><p><em>Cách sơ chế nguyên liệu chế biến:</em></p></li><li><p><em>Tôm rửa sạch, đánh vảy và cắt râu</em></p></li><li><p><em>Ngâm tôm với nước muối, rửa sạch với nước, để ráo sau đó chế biến</em></p></li><li><p><em>Đồ gia vị</em></p></li><li><p><em>Cách làm tôm rang me như sau:</em></p></li></ol><blockquote><p><em>Bắt đầu, cho nướng chảo, sau đó cho 1 muỗng dầu ăn vào. Phi đầu tôm lên, cho 1 muỗng nước bột đầu để tạo màu sắc. Đầu tiên, bắt đầu rây khoảng 2 – 3 phút là có thể tắt bếp. Hỗn hợp đầu có màu đỏ, mùi thơm.</em></p><p></p><p><em>thuan1d</em></p></blockquote><p></p><h3><strong>Tôm rang me được ngợi là món ăn đơn giản, dễ ăn và dễ chế biến. Vị ngọt từ tôm kết hợp với vị chua của me chính ngọt ngon của me, thêm chút nước mắm vừa miệng.</strong></h3><h1><em>Nguyên liệu cần chuẩn bị để thực hiện món tôm rang me bao gồm:</em></h1><ol><li><p><em>Tôm sú đã làm sạch</em></p></li><li><p><em>Me tươi</em></p></li><li><p><em>Hành lá, rau ăn</em></p></li><li><p><em>Những thành phần khác như nước mắm, dầu ăn, đường...</em></p></li><li><p><em>Cách sơ chế nguyên liệu chế biến:</em></p></li><li><p><em>Tôm rửa sạch, đánh vảy và cắt râu</em></p></li><li><p><em>Ngâm tôm với nước muối, rửa sạch với nước, để ráo sau đó chế biến</em></p></li><li><p><em>Đồ gia vị</em></p></li><li><p><em>Cách làm tôm rang me như sau:</em></p></li></ol><blockquote><p><em>Bắt đầu, cho nướng chảo, sau đó cho 1 muỗng dầu ăn vào. Phi đầu tôm lên, cho 1 muỗng nước bột đầu để tạo màu sắc. Đầu tiên, bắt đầu rây khoảng 2 – 3 phút là có thể tắt bếp. Hỗn hợp đầu có màu đỏ, mùi thơm.</em></p><p></p><p><em>thuan1d</em></p></blockquote><p></p><h3><strong>Tôm rang me được ngợi là món ăn đơn giản, dễ ăn và dễ chế biến. Vị ngọt từ tôm kết hợp với vị chua của me chính ngọt ngon của me, thêm chút nước mắm vừa miệng.</strong></h3><h1><em>Nguyên liệu cần chuẩn bị để thực hiện món tôm rang me bao gồm:</em></h1><ol><li><p><em>Tôm sú đã làm sạch</em></p></li><li><p><em>Me tươi</em></p></li><li><p><em>Hành lá, rau ăn</em></p></li><li><p><em>Những thành phần khác như nước mắm, dầu ăn, đường...</em></p></li><li><p><em>Cách sơ chế nguyên liệu chế biến:</em></p></li><li><p><em>Tôm rửa sạch, đánh vảy và cắt râu</em></p></li><li><p><em>Ngâm tôm với nước muối, rửa sạch với nước, để ráo sau đó chế biến</em></p></li><li><p><em>Đồ gia vị</em></p></li><li><p><em>Cách làm tôm rang me như sau:</em></p></li></ol><blockquote><p><em>Bắt đầu, cho nướng chảo, sau đó cho 1 muỗng dầu ăn vào. Phi đầu tôm lên, cho 1 muỗng nước bột đầu để tạo màu sắc. Đầu tiên, bắt đầu rây khoảng 2 – 3 phút là có thể tắt bếp. Hỗn hợp đầu có màu đỏ, mùi thơm.</em></p><p></p><p><em>thuan1d</em></p></blockquote><p></p><h3><strong>Tôm rang me được ngợi là món ăn đơn giản, dễ ăn và dễ chế biến. Vị ngọt từ tôm kết hợp với vị chua của me chính ngọt ngon của me, thêm chút nước mắm vừa miệng.</strong></h3><h1><em>Nguyên liệu cần chuẩn bị để thực hiện món tôm rang me bao gồm:</em></h1><ol><li><p><em>Tôm sú đã làm sạch</em></p></li><li><p><em>Me tươi</em></p></li><li><p><em>Hành lá, rau ăn</em></p></li><li><p><em>Những thành phần khác như nước mắm, dầu ăn, đường...</em></p></li><li><p><em>Cách sơ chế nguyên liệu chế biến:</em></p></li><li><p><em>Tôm rửa sạch, đánh vảy và cắt râu</em></p></li><li><p><em>Ngâm tôm với nước muối, rửa sạch với nước, để ráo sau đó chế biến</em></p></li><li><p><em>Đồ gia vị</em></p></li><li><p><em>Cách làm tôm rang me như sau:</em></p></li></ol><blockquote><p><em>Bắt đầu, cho nướng chảo, sau đó cho 1 muỗng dầu ăn vào. Phi đầu tôm lên, cho 1 muỗng nước bột đầu để tạo màu sắc. Đầu tiên, bắt đầu rây khoảng 2 – 3 phút là có thể tắt bếp. Hỗn hợp đầu có màu đỏ, mùi thơm.</em></p><p></p><p><em>thuan1d</em></p></blockquote><p></p><h3><strong>Tôm rang me được ngợi là món ăn đơn giản, dễ ăn và dễ chế biến. Vị ngọt từ tôm kết hợp với vị chua của me chính ngọt ngon của me, thêm chút nước mắm vừa miệng.</strong></h3><h1><em>Nguyên liệu cần chuẩn bị để thực hiện món tôm rang me bao gồm:</em></h1><ol><li><p><em>Tôm sú đã làm sạch</em></p></li><li><p><em>Me tươi</em></p></li><li><p><em>Hành lá, rau ăn</em></p></li><li><p><em>Những thành phần khác như nước mắm, dầu ăn, đường...</em></p></li><li><p><em>Cách sơ chế nguyên liệu chế biến:</em></p></li><li><p><em>Tôm rửa sạch, đánh vảy và cắt râu</em></p></li><li><p><em>Ngâm tôm với nước muối, rửa sạch với nước, để ráo sau đó chế biến</em></p></li><li><p><em>Đồ gia vị</em></p></li><li><p><em>Cách làm tôm rang me như sau:</em></p></li></ol><blockquote><p><em>Bắt đầu, cho nướng chảo, sau đó cho 1 muỗng dầu ăn vào. Phi đầu tôm lên, cho 1 muỗng nước bột đầu để tạo màu sắc. Đầu tiên, bắt đầu rây khoảng 2 – 3 phút là có thể tắt bếp. Hỗn hợp đầu có màu đỏ, mùi thơm.</em></p><p></p><p><em>thuan1d</em></p></blockquote><p></p><h3><strong>Tôm rang me được ngợi là món ăn đơn giản, dễ ăn và dễ chế biến. Vị ngọt từ tôm kết hợp với vị chua của me chính ngọt ngon của me, thêm chút nước mắm vừa miệng.</strong></h3><h1><em>Nguyên liệu cần chuẩn bị để thực hiện món tôm rang me bao gồm:</em></h1><ol><li><p><em>Tôm sú đã làm sạch</em></p></li><li><p><em>Me tươi</em></p></li><li><p><em>Hành lá, rau ăn</em></p></li><li><p><em>Những thành phần khác như nước mắm, dầu ăn, đường...</em></p></li><li><p><em>Cách sơ chế nguyên liệu chế biến:</em></p></li><li><p><em>Tôm rửa sạch, đánh vảy và cắt râu</em></p></li><li><p><em>Ngâm tôm với nước muối, rửa sạch với nước, để ráo sau đó chế biến</em></p></li><li><p><em>Đồ gia vị</em></p></li><li><p><em>Cách làm tôm rang me như sau:</em></p></li></ol><blockquote><p><em>Bắt đầu, cho nướng chảo, sau đó cho 1 muỗng dầu ăn vào. Phi đầu tôm lên, cho 1 muỗng nước bột đầu để tạo màu sắc. Đầu tiên, bắt đầu rây khoảng 2 – 3 phút là có thể tắt bếp. Hỗn hợp đầu có màu đỏ, mùi thơm.</em></p><p></p><p><em>thuan1d</em></p></blockquote><p></p><p></p><p></p>', 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1740820659/rqz8hoy9x354hpagbh1i.jpg', 1, '2025-03-01 08:33:42', '2025-03-01 08:33:42');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` int(11) NOT NULL,
  `quantity_sold` int(11) DEFAULT 0,
  `quantity` int(11) DEFAULT 0,
  `star` int(11) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  `category` varchar(255) NOT NULL DEFAULT 'fish',
  `hot` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `quantity_sold`, `quantity`, `star`, `status`, `category`, `hot`, `created_at`, `updated_at`) VALUES
(1, 'Ghẹ hấp xả', '<h3><strong>Tôm rang me được ngợi là món ăn đơn giản, dễ ăn và dễ chế biến. Vị ngọt từ tôm kết hợp với vị chua của me chính ngọt ngon của me, thêm chút nước mắm vừa miệng.</strong></h3><h1><em>Nguyên liệu cần chuẩn bị để thực hiện món tôm rang me bao gồm:</em></h1><ol><li><p><em>Tôm sú đã làm sạch</em></p></li><li><p><em>Me tươi</em></p></li><li><p><em>Hành lá, rau ăn</em></p></li><li><p><em>Những thành phần khác như nước mắm, dầu ăn, đường...</em></p></li><li><p><em>Cách sơ chế nguyên liệu chế biến:</em></p></li><li><p><em>Tôm rửa sạch, đánh vảy và cắt râu</em></p></li><li><p><em>Ngâm tôm với nước muối, rửa sạch với nước, để ráo sau đó chế biến</em></p></li><li><p><em>Đồ gia vị</em></p></li><li><p><em>Cách làm tôm rang me như sau:</em></p></li></ol><p></p><h3><strong>Tôm rang me được ngợi là món ăn đơn giản, dễ ăn và dễ chế biến. Vị ngọt từ tôm kết hợp với vị chua của me chính ngọt ngon của me, thêm chút nước mắm vừa miệng.</strong></h3><h1><em>Nguyên liệu cần chuẩn bị để thực hiện món tôm rang me bao gồm:</em></h1><ol><li><p><em>Tôm sú đã làm sạch</em></p></li><li><p><em>Me tươi</em></p></li><li><p><em>Hành lá, rau ăn</em></p></li><li><p><em>Những thành phần khác như nước mắm, dầu ăn, đường...</em></p></li><li><p><em>Cách sơ chế nguyên liệu chế biến:</em></p></li><li><p><em>Tôm rửa sạch, đánh vảy và cắt râu</em></p></li><li><p><em>Ngâm tôm với nước muối, rửa sạch với nước, để ráo sau đó chế biến</em></p></li><li><p><em>Đồ gia vị</em></p></li><li><p><em>Cách làm tôm rang me như sau:</em></p></li></ol><blockquote><p><em>Bắt đầu, cho nướng chảo, sau đó cho 1 muỗng dầu ăn vào. Phi đầu tôm lên, cho 1 muỗng nước bột đầu để tạo màu sắc. Đầu tiên, bắt đầu rây khoảng 2 – 3 phút là có thể tắt bếp. Hỗn hợp đầu có màu đỏ, mùi thơm.</em></p><p></p><p><em>thuan1d</em></p></blockquote><p></p><h3><strong>Tôm rang me được ngợi là món ăn đơn giản, dễ ăn và dễ chế biến. Vị ngọt từ tôm kết hợp với vị chua của me chính ngọt ngon của me, thêm chút nước mắm vừa miệng.</strong></h3><h1><em>Nguyên liệu cần chuẩn bị để thực hiện món tôm rang me bao gồm:</em></h1><ol><li><p><em>Tôm sú đã làm sạch</em></p></li><li><p><em>Me tươi</em></p></li><li><p><em>Hành lá, rau ăn</em></p></li><li><p><em>Những thành phần khác như nước mắm, dầu ăn, đường...</em></p></li><li><p><em>Cách sơ chế nguyên liệu chế biến:</em></p></li><li><p><em>Tôm rửa sạch, đánh vảy và cắt râu</em></p></li><li><p><em>Ngâm tôm với nước muối, rửa sạch với nước, để ráo sau đó chế biến</em></p></li><li><p><em>Đồ gia vị</em></p></li><li><p><em>Cách làm tôm rang me như sau:</em></p></li></ol><blockquote><p><em>Bắt đầu, cho nướng chảo, sau đó cho 1 muỗng dầu ăn vào. Phi đầu tôm lên, cho 1 muỗng nước bột đầu để tạo màu sắc. Đầu tiên, bắt đầu rây khoảng 2 – 3 phút là có thể tắt bếp. Hỗn hợp đầu có màu đỏ, mùi thơm.</em></p><p></p><p><em>thuan1d</em></p></blockquote><p></p><h3><strong>Tôm rang me được ngợi là món ăn đơn giản, dễ ăn và dễ chế biến. Vị ngọt từ tôm kết hợp với vị chua của me chính ngọt ngon của me, thêm chút nước mắm vừa miệng.</strong></h3><h1><em>Nguyên liệu cần chuẩn bị để thực hiện món tôm rang me bao gồm:</em></h1><ol><li><p><em>Tôm sú đã làm sạch</em></p></li><li><p><em>Me tươi</em></p></li><li><p><em>Hành lá, rau ăn</em></p></li><li><p><em>Những thành phần khác như nước mắm, dầu ăn, đường...</em></p></li><li><p><em>Cách sơ chế nguyên liệu chế biến:</em></p></li><li><p><em>Tôm rửa sạch, đánh vảy và cắt râu</em></p></li><li><p><em>Ngâm tôm với nước muối, rửa sạch với nước, để ráo sau đó chế biến</em></p></li><li><p><em>Đồ gia vị</em></p></li><li><p><em>Cách làm tôm rang me như sau:</em></p></li></ol><blockquote><p><em>Bắt đầu, cho nướng chảo, sau đó cho 1 muỗng dầu ăn vào. Phi đầu tôm lên, cho 1 muỗng nước bột đầu để tạo màu sắc. Đầu tiên, bắt đầu rây khoảng 2 – 3 phút là có thể tắt bếp. Hỗn hợp đầu có màu đỏ, mùi thơm.</em></p><p></p><p><em>thuan1d</em></p></blockquote><p></p><h3><strong>Tôm rang me được ngợi là món ăn đơn giản, dễ ăn và dễ chế biến. Vị ngọt từ tôm kết hợp với vị chua của me chính ngọt ngon của me, thêm chút nước mắm vừa miệng.</strong></h3><h1><em>Nguyên liệu cần chuẩn bị để thực hiện món tôm rang me bao gồm:</em></h1><ol><li><p><em>Tôm sú đã làm sạch</em></p></li><li><p><em>Me tươi</em></p></li><li><p><em>Hành lá, rau ăn</em></p></li><li><p><em>Những thành phần khác như nước mắm, dầu ăn, đường...</em></p></li><li><p><em>Cách sơ chế nguyên liệu chế biến:</em></p></li><li><p><em>Tôm rửa sạch, đánh vảy và cắt râu</em></p></li><li><p><em>Ngâm tôm với nước muối, rửa sạch với nước, để ráo sau đó chế biến</em></p></li><li><p><em>Đồ gia vị</em></p></li><li><p><em>Cách làm tôm rang me như sau:</em></p></li></ol><blockquote><p><em>Bắt đầu, cho nướng chảo, sau đó cho 1 muỗng dầu ăn vào. Phi đầu tôm lên, cho 1 muỗng nước bột đầu để tạo màu sắc. Đầu tiên, bắt đầu rây khoảng 2 – 3 phút là có thể tắt bếp. Hỗn hợp đầu có màu đỏ, mùi thơm.</em></p><p></p><p><em>thuan1d</em></p></blockquote><p></p><h3><strong>Tôm rang me được ngợi là món ăn đơn giản, dễ ăn và dễ chế biến. Vị ngọt từ tôm kết hợp với vị chua của me chính ngọt ngon của me, thêm chút nước mắm vừa miệng.</strong></h3><h1><em>Nguyên liệu cần chuẩn bị để thực hiện món tôm rang me bao gồm:</em></h1><ol><li><p><em>Tôm sú đã làm sạch</em></p></li><li><p><em>Me tươi</em></p></li><li><p><em>Hành lá, rau ăn</em></p></li><li><p><em>Những thành phần khác như nước mắm, dầu ăn, đường...</em></p></li><li><p><em>Cách sơ chế nguyên liệu chế biến:</em></p></li><li><p><em>Tôm rửa sạch, đánh vảy và cắt râu</em></p></li><li><p><em>Ngâm tôm với nước muối, rửa sạch với nước, để ráo sau đó chế biến</em></p></li><li><p><em>Đồ gia vị</em></p></li><li><p><em>Cách làm tôm rang me như sau:</em></p></li></ol><blockquote><p><em>Bắt đầu, cho nướng chảo, sau đó cho 1 muỗng dầu ăn vào. Phi đầu tôm lên, cho 1 muỗng nước bột đầu để tạo màu sắc. Đầu tiên, bắt đầu rây khoảng 2 – 3 phút là có thể tắt bếp. Hỗn hợp đầu có màu đỏ, mùi thơm.</em></p><p></p><p><em>thuan1d</em></p></blockquote><p></p><h3><strong>Tôm rang me được ngợi là món ăn đơn giản, dễ ăn và dễ chế biến. Vị ngọt từ tôm kết hợp với vị chua của me chính ngọt ngon của me, thêm chút nước mắm vừa miệng.</strong></h3><h1><em>Nguyên liệu cần chuẩn bị để thực hiện món tôm rang me bao gồm:</em></h1><ol><li><p><em>Tôm sú đã làm sạch</em></p></li><li><p><em>Me tươi</em></p></li><li><p><em>Hành lá, rau ăn</em></p></li><li><p><em>Những thành phần khác như nước mắm, dầu ăn, đường...</em></p></li><li><p><em>Cách sơ chế nguyên liệu chế biến:</em></p></li><li><p><em>Tôm rửa sạch, đánh vảy và cắt râu</em></p></li><li><p><em>Ngâm tôm với nước muối, rửa sạch với nước, để ráo sau đó chế biến</em></p></li><li><p><em>Đồ gia vị</em></p></li><li><p><em>Cách làm tôm rang me như sau:</em></p></li></ol><blockquote><p><em>Bắt đầu, cho nướng chảo, sau đó cho 1 muỗng dầu ăn vào. Phi đầu tôm lên, cho 1 muỗng nước bột đầu để tạo màu sắc. Đầu tiên, bắt đầu rây khoảng 2 – 3 phút là có thể tắt bếp. Hỗn hợp đầu có màu đỏ, mùi thơm.</em></p><p></p><p><em>thuan1d</em></p></blockquote><p></p><h3><strong>Tôm rang me được ngợi là món ăn đơn giản, dễ ăn và dễ chế biến. Vị ngọt từ tôm kết hợp với vị chua của me chính ngọt ngon của me, thêm chút nước mắm vừa miệng.</strong></h3><h1><em>Nguyên liệu cần chuẩn bị để thực hiện món tôm rang me bao gồm:</em></h1><ol><li><p><em>Tôm sú đã làm sạch</em></p></li><li><p><em>Me tươi</em></p></li><li><p><em>Hành lá, rau ăn</em></p></li><li><p><em>Những thành phần khác như nước mắm, dầu ăn, đường...</em></p></li><li><p><em>Cách sơ chế nguyên liệu chế biến:</em></p></li><li><p><em>Tôm rửa sạch, đánh vảy và cắt râu</em></p></li><li><p><em>Ngâm tôm với nước muối, rửa sạch với nước, để ráo sau đó chế biến</em></p></li><li><p><em>Đồ gia vị</em></p></li><li><p><em>Cách làm tôm rang me như sau:</em></p></li></ol><blockquote><p><em>Bắt đầu, cho nướng chảo, sau đó cho 1 muỗng dầu ăn vào. Phi đầu tôm lên, cho 1 muỗng nước bột đầu để tạo màu sắc. Đầu tiên, bắt đầu rây khoảng 2 – 3 phút là có thể tắt bếp. Hỗn hợp đầu có màu đỏ, mùi thơm.</em></p><p></p><p><em>thuan1d</em></p></blockquote><p></p><h3><strong>Tôm rang me được ngợi là món ăn đơn giản, dễ ăn và dễ chế biến. Vị ngọt từ tôm kết hợp với vị chua của me chính ngọt ngon của me, thêm chút nước mắm vừa miệng.</strong></h3><h1><em>Nguyên liệu cần chuẩn bị để thực hiện món tôm rang me bao gồm:</em></h1><ol><li><p><em>Tôm sú đã làm sạch</em></p></li><li><p><em>Me tươi</em></p></li><li><p><em>Hành lá, rau ăn</em></p></li><li><p><em>Những thành phần khác như nước mắm, dầu ăn, đường...</em></p></li><li><p><em>Cách sơ chế nguyên liệu chế biến:</em></p></li><li><p><em>Tôm rửa sạch, đánh vảy và cắt râu</em></p></li><li><p><em>Ngâm tôm với nước muối, rửa sạch với nước, để ráo sau đó chế biến</em></p></li><li><p><em>Đồ gia vị</em></p></li><li><p><em>Cách làm tôm rang me như sau:</em></p></li></ol><blockquote><p><em>Bắt đầu, cho nướng chảo, sau đó cho 1 muỗng dầu ăn vào. Phi đầu tôm lên, cho 1 muỗng nước bột đầu để tạo màu sắc. Đầu tiên, bắt đầu rây khoảng 2 – 3 phút là có thể tắt bếp. Hỗn hợp đầu có màu đỏ, mùi thơm.</em></p><p></p><p><em>thuan1d</em></p></blockquote><p></p><p></p><p></p>', 22000000, 0, 100, 5, 0, 'shrimp', 0, '2025-03-07 00:21:57', '2025-03-07 02:47:06'),
(2, 'thuan', '<h3><strong>Tôm rang me được ngợi là món ăn đơn giản, dễ ăn và dễ chế biến. Vị ngọt từ tôm kết hợp với vị chua của me chính ngọt ngon của me, thêm chút nước mắm vừa miệng.</strong></h3><h1><em>Nguyên liệu cần chuẩn bị để thực hiện món tôm rang me bao gồm:</em></h1><ol><li><p><em>Tôm sú đã làm sạch</em></p></li><li><p><em>Me tươi</em></p></li><li><p><em>Hành lá, rau ăn</em></p></li><li><p><em>Những thành phần khác như nước mắm, dầu ăn, đường...</em></p></li><li><p><em>Cách sơ chế nguyên liệu chế biến:</em></p></li><li><p><em>Tôm rửa sạch, đánh vảy và cắt râu</em></p></li><li><p><em>Ngâm tôm với nước muối, rửa sạch với nước, để ráo sau đó chế biến</em></p></li><li><p><em>Đồ gia vị</em></p></li><li><p><em>Cách làm tôm rang me như sau:</em></p></li></ol><p></p><h3><strong>Tôm rang me được ngợi là món ăn đơn giản, dễ ăn và dễ chế biến. Vị ngọt từ tôm kết hợp với vị chua của me chính ngọt ngon của me, thêm chút nước mắm vừa miệng.</strong></h3><h1><em>Nguyên liệu cần chuẩn bị để thực hiện món tôm rang me bao gồm:</em></h1><ol><li><p><em>Tôm sú đã làm sạch</em></p></li><li><p><em>Me tươi</em></p></li><li><p><em>Hành lá, rau ăn</em></p></li><li><p><em>Những thành phần khác như nước mắm, dầu ăn, đường...</em></p></li><li><p><em>Cách sơ chế nguyên liệu chế biến:</em></p></li><li><p><em>Tôm rửa sạch, đánh vảy và cắt râu</em></p></li><li><p><em>Ngâm tôm với nước muối, rửa sạch với nước, để ráo sau đó chế biến</em></p></li><li><p><em>Đồ gia vị</em></p></li><li><p><em>Cách làm tôm rang me như sau:</em></p></li></ol><blockquote><p><em>Bắt đầu, cho nướng chảo, sau đó cho 1 muỗng dầu ăn vào. Phi đầu tôm lên, cho 1 muỗng nước bột đầu để tạo màu sắc. Đầu tiên, bắt đầu rây khoảng 2 – 3 phút là có thể tắt bếp. Hỗn hợp đầu có màu đỏ, mùi thơm.</em></p><p></p><p><em>thuan1d</em></p></blockquote><p></p><h3><strong>Tôm rang me được ngợi là món ăn đơn giản, dễ ăn và dễ chế biến. Vị ngọt từ tôm kết hợp với vị chua của me chính ngọt ngon của me, thêm chút nước mắm vừa miệng.</strong></h3><h1><em>Nguyên liệu cần chuẩn bị để thực hiện món tôm rang me bao gồm:</em></h1><ol><li><p><em>Tôm sú đã làm sạch</em></p></li><li><p><em>Me tươi</em></p></li><li><p><em>Hành lá, rau ăn</em></p></li><li><p><em>Những thành phần khác như nước mắm, dầu ăn, đường...</em></p></li><li><p><em>Cách sơ chế nguyên liệu chế biến:</em></p></li><li><p><em>Tôm rửa sạch, đánh vảy và cắt râu</em></p></li><li><p><em>Ngâm tôm với nước muối, rửa sạch với nước, để ráo sau đó chế biến</em></p></li><li><p><em>Đồ gia vị</em></p></li><li><p><em>Cách làm tôm rang me như sau:</em></p></li></ol><blockquote><p><em>Bắt đầu, cho nướng chảo, sau đó cho 1 muỗng dầu ăn vào. Phi đầu tôm lên, cho 1 muỗng nước bột đầu để tạo màu sắc. Đầu tiên, bắt đầu rây khoảng 2 – 3 phút là có thể tắt bếp. Hỗn hợp đầu có màu đỏ, mùi thơm.</em></p><p></p><p><em>thuan1d</em></p></blockquote><p></p><h3><strong>Tôm rang me được ngợi là món ăn đơn giản, dễ ăn và dễ chế biến. Vị ngọt từ tôm kết hợp với vị chua của me chính ngọt ngon của me, thêm chút nước mắm vừa miệng.</strong></h3><h1><em>Nguyên liệu cần chuẩn bị để thực hiện món tôm rang me bao gồm:</em></h1><ol><li><p><em>Tôm sú đã làm sạch</em></p></li><li><p><em>Me tươi</em></p></li><li><p><em>Hành lá, rau ăn</em></p></li><li><p><em>Những thành phần khác như nước mắm, dầu ăn, đường...</em></p></li><li><p><em>Cách sơ chế nguyên liệu chế biến:</em></p></li><li><p><em>Tôm rửa sạch, đánh vảy và cắt râu</em></p></li><li><p><em>Ngâm tôm với nước muối, rửa sạch với nước, để ráo sau đó chế biến</em></p></li><li><p><em>Đồ gia vị</em></p></li><li><p><em>Cách làm tôm rang me như sau:</em></p></li></ol><blockquote><p><em>Bắt đầu, cho nướng chảo, sau đó cho 1 muỗng dầu ăn vào. Phi đầu tôm lên, cho 1 muỗng nước bột đầu để tạo màu sắc. Đầu tiên, bắt đầu rây khoảng 2 – 3 phút là có thể tắt bếp. Hỗn hợp đầu có màu đỏ, mùi thơm.</em></p><p></p><p><em>thuan1d</em></p></blockquote><p></p><h3><strong>Tôm rang me được ngợi là món ăn đơn giản, dễ ăn và dễ chế biến. Vị ngọt từ tôm kết hợp với vị chua của me chính ngọt ngon của me, thêm chút nước mắm vừa miệng.</strong></h3><h1><em>Nguyên liệu cần chuẩn bị để thực hiện món tôm rang me bao gồm:</em></h1><ol><li><p><em>Tôm sú đã làm sạch</em></p></li><li><p><em>Me tươi</em></p></li><li><p><em>Hành lá, rau ăn</em></p></li><li><p><em>Những thành phần khác như nước mắm, dầu ăn, đường...</em></p></li><li><p><em>Cách sơ chế nguyên liệu chế biến:</em></p></li><li><p><em>Tôm rửa sạch, đánh vảy và cắt râu</em></p></li><li><p><em>Ngâm tôm với nước muối, rửa sạch với nước, để ráo sau đó chế biến</em></p></li><li><p><em>Đồ gia vị</em></p></li><li><p><em>Cách làm tôm rang me như sau:</em></p></li></ol><blockquote><p><em>Bắt đầu, cho nướng chảo, sau đó cho 1 muỗng dầu ăn vào. Phi đầu tôm lên, cho 1 muỗng nước bột đầu để tạo màu sắc. Đầu tiên, bắt đầu rây khoảng 2 – 3 phút là có thể tắt bếp. Hỗn hợp đầu có màu đỏ, mùi thơm.</em></p><p></p><p><em>thuan1d</em></p></blockquote><p></p><h3><strong>Tôm rang me được ngợi là món ăn đơn giản, dễ ăn và dễ chế biến. Vị ngọt từ tôm kết hợp với vị chua của me chính ngọt ngon của me, thêm chút nước mắm vừa miệng.</strong></h3><h1><em>Nguyên liệu cần chuẩn bị để thực hiện món tôm rang me bao gồm:</em></h1><ol><li><p><em>Tôm sú đã làm sạch</em></p></li><li><p><em>Me tươi</em></p></li><li><p><em>Hành lá, rau ăn</em></p></li><li><p><em>Những thành phần khác như nước mắm, dầu ăn, đường...</em></p></li><li><p><em>Cách sơ chế nguyên liệu chế biến:</em></p></li><li><p><em>Tôm rửa sạch, đánh vảy và cắt râu</em></p></li><li><p><em>Ngâm tôm với nước muối, rửa sạch với nước, để ráo sau đó chế biến</em></p></li><li><p><em>Đồ gia vị</em></p></li><li><p><em>Cách làm tôm rang me như sau:</em></p></li></ol><blockquote><p><em>Bắt đầu, cho nướng chảo, sau đó cho 1 muỗng dầu ăn vào. Phi đầu tôm lên, cho 1 muỗng nước bột đầu để tạo màu sắc. Đầu tiên, bắt đầu rây khoảng 2 – 3 phút là có thể tắt bếp. Hỗn hợp đầu có màu đỏ, mùi thơm.</em></p><p></p><p><em>thuan1d</em></p></blockquote><p></p><h3><strong>Tôm rang me được ngợi là món ăn đơn giản, dễ ăn và dễ chế biến. Vị ngọt từ tôm kết hợp với vị chua của me chính ngọt ngon của me, thêm chút nước mắm vừa miệng.</strong></h3><h1><em>Nguyên liệu cần chuẩn bị để thực hiện món tôm rang me bao gồm:</em></h1><ol><li><p><em>Tôm sú đã làm sạch</em></p></li><li><p><em>Me tươi</em></p></li><li><p><em>Hành lá, rau ăn</em></p></li><li><p><em>Những thành phần khác như nước mắm, dầu ăn, đường...</em></p></li><li><p><em>Cách sơ chế nguyên liệu chế biến:</em></p></li><li><p><em>Tôm rửa sạch, đánh vảy và cắt râu</em></p></li><li><p><em>Ngâm tôm với nước muối, rửa sạch với nước, để ráo sau đó chế biến</em></p></li><li><p><em>Đồ gia vị</em></p></li><li><p><em>Cách làm tôm rang me như sau:</em></p></li></ol><blockquote><p><em>Bắt đầu, cho nướng chảo, sau đó cho 1 muỗng dầu ăn vào. Phi đầu tôm lên, cho 1 muỗng nước bột đầu để tạo màu sắc. Đầu tiên, bắt đầu rây khoảng 2 – 3 phút là có thể tắt bếp. Hỗn hợp đầu có màu đỏ, mùi thơm.</em></p><p></p><p><em>thuan1d</em></p></blockquote><p></p><h3><strong>Tôm rang me được ngợi là món ăn đơn giản, dễ ăn và dễ chế biến. Vị ngọt từ tôm kết hợp với vị chua của me chính ngọt ngon của me, thêm chút nước mắm vừa miệng.</strong></h3><h1><em>Nguyên liệu cần chuẩn bị để thực hiện món tôm rang me bao gồm:</em></h1><ol><li><p><em>Tôm sú đã làm sạch</em></p></li><li><p><em>Me tươi</em></p></li><li><p><em>Hành lá, rau ăn</em></p></li><li><p><em>Những thành phần khác như nước mắm, dầu ăn, đường...</em></p></li><li><p><em>Cách sơ chế nguyên liệu chế biến:</em></p></li><li><p><em>Tôm rửa sạch, đánh vảy và cắt râu</em></p></li><li><p><em>Ngâm tôm với nước muối, rửa sạch với nước, để ráo sau đó chế biến</em></p></li><li><p><em>Đồ gia vị</em></p></li><li><p><em>Cách làm tôm rang me như sau:</em></p></li></ol><blockquote><p><em>Bắt đầu, cho nướng chảo, sau đó cho 1 muỗng dầu ăn vào. Phi đầu tôm lên, cho 1 muỗng nước bột đầu để tạo màu sắc. Đầu tiên, bắt đầu rây khoảng 2 – 3 phút là có thể tắt bếp. Hỗn hợp đầu có màu đỏ, mùi thơm.</em></p><p></p><p><em>thuan1d</em></p></blockquote><p></p><h3><strong>Tôm rang me được ngợi là món ăn đơn giản, dễ ăn và dễ chế biến. Vị ngọt từ tôm kết hợp với vị chua của me chính ngọt ngon của me, thêm chút nước mắm vừa miệng.</strong></h3><h1><em>Nguyên liệu cần chuẩn bị để thực hiện món tôm rang me bao gồm:</em></h1><ol><li><p><em>Tôm sú đã làm sạch</em></p></li><li><p><em>Me tươi</em></p></li><li><p><em>Hành lá, rau ăn</em></p></li><li><p><em>Những thành phần khác như nước mắm, dầu ăn, đường...</em></p></li><li><p><em>Cách sơ chế nguyên liệu chế biến:</em></p></li><li><p><em>Tôm rửa sạch, đánh vảy và cắt râu</em></p></li><li><p><em>Ngâm tôm với nước muối, rửa sạch với nước, để ráo sau đó chế biến</em></p></li><li><p><em>Đồ gia vị</em></p></li><li><p><em>Cách làm tôm rang me như sau:</em></p></li></ol><blockquote><p><em>Bắt đầu, cho nướng chảo, sau đó cho 1 muỗng dầu ăn vào. Phi đầu tôm lên, cho 1 muỗng nước bột đầu để tạo màu sắc. Đầu tiên, bắt đầu rây khoảng 2 – 3 phút là có thể tắt bếp. Hỗn hợp đầu có màu đỏ, mùi thơm.</em></p><p></p><p><em>thuan1d</em></p></blockquote><p></p><p></p><p></p>', 22000000, 0, 100, 5, 0, 'fish', 0, '2025-03-07 00:22:41', '2025-03-07 03:46:18'),
(3, 'Ghẹ hấp xả', 'Ghẹ hấp xả là một món ăn được chế biến từ ghẹ, một loại hải sản phổ biến tại Việt Nam. Ghẹ được hấp với xả, tạo ra hương vị thơm ngon.', 22000000, 0, 100, 5, 0, 'shrimp', 0, '2025-03-07 00:22:41', '2025-03-07 02:47:13'),
(4, 'Ghẹ hấp xả', 'Ghẹ hấp xả là một món ăn được chế biến từ ghẹ, một loại hải sản phổ biến tại Việt Nam. Ghẹ được hấp với xả, tạo ra hương vị thơm ngon.', 22000000, 0, 100, 5, 0, 'shrimp', 0, '2025-03-07 00:22:43', '2025-03-07 02:47:11'),
(5, 'Ghẹ hấp xả', 'Ghẹ hấp xả là một món ăn được chế biến từ ghẹ, một loại hải sản phổ biến tại Việt Nam. Ghẹ được hấp với xả, tạo ra hương vị thơm ngon.', 22000000, 0, 100, 5, 0, 'shrimp', 0, '2025-03-07 00:22:46', '2025-03-07 02:47:09'),
(6, 'Ghẹ hấp xả', 'Ghẹ hấp xả là một món ăn được chế biến từ ghẹ, một loại hải sản phổ biến tại Việt Nam. Ghẹ được hấp với xả, tạo ra hương vị thơm ngon.', 22000000, 0, 100, 5, 0, 'fish', 0, '2025-03-07 03:20:08', '2025-03-07 03:20:08'),
(7, 'Ghẹ hấp xả', 'Ghẹ hấp xả là một món ăn được chế biến từ ghẹ, một loại hải sản phổ biến tại Việt Nam. Ghẹ được hấp với xả, tạo ra hương vị thơm ngon.', 22000000, 0, 100, 5, 0, 'fish', 0, '2025-03-07 03:20:10', '2025-03-07 03:20:10'),
(8, 'Ghẹ hấp xả', 'Ghẹ hấp xả là một món ăn được chế biến từ ghẹ, một loại hải sản phổ biến tại Việt Nam. Ghẹ được hấp với xả, tạo ra hương vị thơm ngon.', 22000000, 0, 100, 5, 0, 'fish', 0, '2025-03-07 03:20:12', '2025-03-07 03:20:12'),
(9, 'Ghẹ hấp xả', 'Ghẹ hấp xả là một món ăn được chế biến từ ghẹ, một loại hải sản phổ biến tại Việt Nam. Ghẹ được hấp với xả, tạo ra hương vị thơm ngon.', 22000000, 0, 100, 5, 0, 'fish', 0, '2025-03-07 03:20:15', '2025-03-07 03:20:15'),
(10, 'Ghẹ hấp xả', 'Ghẹ hấp xả là một món ăn được chế biến từ ghẹ, một loại hải sản phổ biến tại Việt Nam. Ghẹ được hấp với xả, tạo ra hương vị thơm ngon.', 22000000, 0, 100, 5, 0, 'fish', 0, '2025-03-07 03:20:17', '2025-03-07 03:20:17'),
(11, 'Ghẹ hấp xả', 'Ghẹ hấp xả là một món ăn được chế biến từ ghẹ, một loại hải sản phổ biến tại Việt Nam. Ghẹ được hấp với xả, tạo ra hương vị thơm ngon.', 22000000, 0, 100, 5, 0, 'fish', 0, '2025-03-07 03:20:19', '2025-03-07 03:20:19'),
(12, 'Ghẹ hấp xả', 'Ghẹ hấp xả là một món ăn được chế biến từ ghẹ, một loại hải sản phổ biến tại Việt Nam. Ghẹ được hấp với xả, tạo ra hương vị thơm ngon.', 22000000, 0, 100, 5, 0, 'fish', 0, '2025-03-07 03:20:21', '2025-03-07 03:20:21'),
(13, 'Ghẹ hấp xả', 'Ghẹ hấp xả là một món ăn được chế biến từ ghẹ, một loại hải sản phổ biến tại Việt Nam. Ghẹ được hấp với xả, tạo ra hương vị thơm ngon.', 22000000, 0, 100, 5, 0, 'fish', 0, '2025-03-07 03:20:23', '2025-03-07 03:20:23'),
(14, 'Ghẹ hấp xả', 'Ghẹ hấp xả là một món ăn được chế biến từ ghẹ, một loại hải sản phổ biến tại Việt Nam. Ghẹ được hấp với xả, tạo ra hương vị thơm ngon.', 22000000, 0, 100, 5, 0, 'fish', 0, '2025-03-07 03:20:25', '2025-03-07 03:20:25'),
(15, 'Ghẹ hấp xả', 'Ghẹ hấp xả là một món ăn được chế biến từ ghẹ, một loại hải sản phổ biến tại Việt Nam. Ghẹ được hấp với xả, tạo ra hương vị thơm ngon.', 22000000, 0, 100, 5, 0, 'fish', 0, '2025-03-07 03:20:27', '2025-03-07 03:20:27'),
(16, 'Ghẹ hấp xả', 'Ghẹ hấp xả là một món ăn được chế biến từ ghẹ, một loại hải sản phổ biến tại Việt Nam. Ghẹ được hấp với xả, tạo ra hương vị thơm ngon.', 22000000, 0, 100, 5, 0, 'fish', 0, '2025-03-07 03:20:28', '2025-03-07 03:20:28'),
(17, 'Ghẹ hấp xả', 'Ghẹ hấp xả là một món ăn được chế biến từ ghẹ, một loại hải sản phổ biến tại Việt Nam. Ghẹ được hấp với xả, tạo ra hương vị thơm ngon.', 22000000, 0, 100, 5, 0, 'fish', 0, '2025-03-07 03:20:29', '2025-03-07 03:20:29'),
(18, 'Ghẹ hấp xả', 'Ghẹ hấp xả là một món ăn được chế biến từ ghẹ, một loại hải sản phổ biến tại Việt Nam. Ghẹ được hấp với xả, tạo ra hương vị thơm ngon.', 22000000, 0, 100, 5, 0, 'fish', 0, '2025-03-07 03:20:31', '2025-03-07 03:20:31'),
(19, 'Ghẹ hấp xả', 'Ghẹ hấp xả là một món ăn được chế biến từ ghẹ, một loại hải sản phổ biến tại Việt Nam. Ghẹ được hấp với xả, tạo ra hương vị thơm ngon.', 22000000, 0, 100, 5, 0, 'fish', 0, '2025-03-07 03:20:31', '2025-03-07 03:20:31'),
(20, 'Ghẹ hấp xả', 'Ghẹ hấp xả là một món ăn được chế biến từ ghẹ, một loại hải sản phổ biến tại Việt Nam. Ghẹ được hấp với xả, tạo ra hương vị thơm ngon.', 22000000, 0, 100, 5, 0, 'fish', 0, '2025-03-07 03:20:32', '2025-03-07 03:20:32'),
(21, 'Ghẹ hấp xả', 'Ghẹ hấp xả là một món ăn được chế biến từ ghẹ, một loại hải sản phổ biến tại Việt Nam. Ghẹ được hấp với xả, tạo ra hương vị thơm ngon.', 22000000, 0, 100, 5, 0, 'fish', 0, '2025-03-07 03:20:37', '2025-03-07 03:20:37'),
(22, 'Ghẹ hấp xả', 'Ghẹ hấp xả là một món ăn được chế biến từ ghẹ, một loại hải sản phổ biến tại Việt Nam. Ghẹ được hấp với xả, tạo ra hương vị thơm ngon.', 22000000, 0, 100, 5, 0, 'fish', 0, '2025-03-07 03:20:37', '2025-03-07 03:20:37'),
(23, 'Ghẹ hấp xả', 'Ghẹ hấp xả là một món ăn được chế biến từ ghẹ, một loại hải sản phổ biến tại Việt Nam. Ghẹ được hấp với xả, tạo ra hương vị thơm ngon.', 22000000, 0, 100, 5, 0, 'fish', 0, '2025-03-07 03:20:39', '2025-03-07 03:20:39'),
(24, 'Ghẹ hấp xả', 'Ghẹ hấp xả là một món ăn được chế biến từ ghẹ, một loại hải sản phổ biến tại Việt Nam. Ghẹ được hấp với xả, tạo ra hương vị thơm ngon.', 22000000, 0, 100, 5, 0, 'fish', 0, '2025-03-07 03:20:39', '2025-03-07 03:20:39'),
(25, 'Ghẹ hấp xả', 'Ghẹ hấp xả là một món ăn được chế biến từ ghẹ, một loại hải sản phổ biến tại Việt Nam. Ghẹ được hấp với xả, tạo ra hương vị thơm ngon.', 22000000, 0, 100, 5, 0, 'fish', 0, '2025-03-07 03:20:41', '2025-03-07 03:20:41'),
(26, 'Ghẹ hấp xả', 'Ghẹ hấp xả là một món ăn được chế biến từ ghẹ, một loại hải sản phổ biến tại Việt Nam. Ghẹ được hấp với xả, tạo ra hương vị thơm ngon.', 22000000, 0, 100, 5, 0, 'fish', 0, '2025-03-07 03:20:41', '2025-03-07 03:20:41');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL DEFAULT 'https://picsum.photos/200',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_url`, `created_at`) VALUES
(1, 2, 'https://picsum.photos/200', '2025-03-07 00:21:57'),
(2, 2, 'https://picsum.photos/201', '2025-03-07 00:21:57'),
(3, 2, 'https://picsum.photos/202', '2025-03-07 00:21:57'),
(4, 2, 'https://picsum.photos/200', '2025-03-07 00:22:41'),
(5, 2, 'https://picsum.photos/201', '2025-03-07 00:22:41'),
(6, 2, 'https://picsum.photos/202', '2025-03-07 00:22:41'),
(7, 2, 'https://picsum.photos/200', '2025-03-07 00:22:41'),
(8, 3, 'https://picsum.photos/201', '2025-03-07 00:22:41'),
(9, 3, 'https://picsum.photos/202', '2025-03-07 00:22:41'),
(10, 4, 'https://picsum.photos/200', '2025-03-07 00:22:43'),
(11, 4, 'https://picsum.photos/201', '2025-03-07 00:22:43'),
(12, 4, 'https://picsum.photos/202', '2025-03-07 00:22:43'),
(13, 5, 'https://picsum.photos/200', '2025-03-07 00:22:46'),
(14, 5, 'https://picsum.photos/201', '2025-03-07 00:22:46'),
(15, 5, 'https://picsum.photos/202', '2025-03-07 00:22:46'),
(16, 6, 'https://picsum.photos/200', '2025-03-07 03:20:08'),
(17, 6, 'https://picsum.photos/201', '2025-03-07 03:20:08'),
(18, 6, 'https://picsum.photos/202', '2025-03-07 03:20:08'),
(19, 7, 'https://picsum.photos/200', '2025-03-07 03:20:10'),
(20, 7, 'https://picsum.photos/201', '2025-03-07 03:20:10'),
(21, 7, 'https://picsum.photos/202', '2025-03-07 03:20:10'),
(22, 8, 'https://picsum.photos/200', '2025-03-07 03:20:12'),
(23, 8, 'https://picsum.photos/201', '2025-03-07 03:20:12'),
(24, 8, 'https://picsum.photos/202', '2025-03-07 03:20:12'),
(25, 9, 'https://picsum.photos/200', '2025-03-07 03:20:15'),
(26, 9, 'https://picsum.photos/201', '2025-03-07 03:20:15'),
(27, 9, 'https://picsum.photos/202', '2025-03-07 03:20:15'),
(28, 10, 'https://picsum.photos/200', '2025-03-07 03:20:17'),
(29, 10, 'https://picsum.photos/201', '2025-03-07 03:20:17'),
(30, 10, 'https://picsum.photos/202', '2025-03-07 03:20:17'),
(31, 11, 'https://picsum.photos/200', '2025-03-07 03:20:19'),
(32, 11, 'https://picsum.photos/201', '2025-03-07 03:20:19'),
(33, 11, 'https://picsum.photos/202', '2025-03-07 03:20:19'),
(34, 12, 'https://picsum.photos/200', '2025-03-07 03:20:21'),
(35, 12, 'https://picsum.photos/201', '2025-03-07 03:20:21'),
(36, 12, 'https://picsum.photos/202', '2025-03-07 03:20:21'),
(37, 13, 'https://picsum.photos/200', '2025-03-07 03:20:23'),
(38, 13, 'https://picsum.photos/201', '2025-03-07 03:20:23'),
(39, 13, 'https://picsum.photos/202', '2025-03-07 03:20:23'),
(40, 14, 'https://picsum.photos/200', '2025-03-07 03:20:25'),
(41, 14, 'https://picsum.photos/201', '2025-03-07 03:20:25'),
(42, 14, 'https://picsum.photos/202', '2025-03-07 03:20:25'),
(43, 15, 'https://picsum.photos/200', '2025-03-07 03:20:27'),
(44, 15, 'https://picsum.photos/201', '2025-03-07 03:20:27'),
(45, 15, 'https://picsum.photos/202', '2025-03-07 03:20:27'),
(46, 16, 'https://picsum.photos/200', '2025-03-07 03:20:28'),
(47, 16, 'https://picsum.photos/201', '2025-03-07 03:20:28'),
(48, 16, 'https://picsum.photos/202', '2025-03-07 03:20:28'),
(49, 17, 'https://picsum.photos/200', '2025-03-07 03:20:29'),
(50, 17, 'https://picsum.photos/201', '2025-03-07 03:20:29'),
(51, 17, 'https://picsum.photos/202', '2025-03-07 03:20:29'),
(52, 18, 'https://picsum.photos/200', '2025-03-07 03:20:31'),
(53, 18, 'https://picsum.photos/201', '2025-03-07 03:20:31'),
(54, 18, 'https://picsum.photos/202', '2025-03-07 03:20:31'),
(55, 19, 'https://picsum.photos/200', '2025-03-07 03:20:31'),
(56, 19, 'https://picsum.photos/201', '2025-03-07 03:20:31'),
(57, 19, 'https://picsum.photos/202', '2025-03-07 03:20:31'),
(58, 20, 'https://picsum.photos/200', '2025-03-07 03:20:33'),
(59, 20, 'https://picsum.photos/201', '2025-03-07 03:20:33'),
(60, 20, 'https://picsum.photos/202', '2025-03-07 03:20:33'),
(61, 21, 'https://picsum.photos/200', '2025-03-07 03:20:37'),
(62, 21, 'https://picsum.photos/201', '2025-03-07 03:20:37'),
(63, 21, 'https://picsum.photos/202', '2025-03-07 03:20:37'),
(64, 22, 'https://picsum.photos/200', '2025-03-07 03:20:37'),
(65, 22, 'https://picsum.photos/201', '2025-03-07 03:20:37'),
(66, 22, 'https://picsum.photos/202', '2025-03-07 03:20:37'),
(67, 23, 'https://picsum.photos/200', '2025-03-07 03:20:39'),
(68, 23, 'https://picsum.photos/201', '2025-03-07 03:20:39'),
(69, 23, 'https://picsum.photos/202', '2025-03-07 03:20:39'),
(70, 24, 'https://picsum.photos/200', '2025-03-07 03:20:39'),
(71, 24, 'https://picsum.photos/201', '2025-03-07 03:20:39'),
(72, 24, 'https://picsum.photos/202', '2025-03-07 03:20:39'),
(73, 25, 'https://picsum.photos/200', '2025-03-07 03:20:41'),
(74, 25, 'https://picsum.photos/201', '2025-03-07 03:20:41'),
(75, 25, 'https://picsum.photos/202', '2025-03-07 03:20:41'),
(76, 26, 'https://picsum.photos/200', '2025-03-07 03:20:41'),
(77, 26, 'https://picsum.photos/201', '2025-03-07 03:20:41'),
(78, 26, 'https://picsum.photos/202', '2025-03-07 03:20:41');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `layout_benefit`
--
ALTER TABLE `layout_benefit`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `layout_commitment`
--
ALTER TABLE `layout_commitment`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `layout_contactsfooter`
--
ALTER TABLE `layout_contactsfooter`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `layout_copyright`
--
ALTER TABLE `layout_copyright`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `layout_customer_choose_item_section`
--
ALTER TABLE `layout_customer_choose_item_section`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `layout_customer_choose_section`
--
ALTER TABLE `layout_customer_choose_section`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `layout_customer_section`
--
ALTER TABLE `layout_customer_section`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `layout_customer_section_img`
--
ALTER TABLE `layout_customer_section_img`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `layout_introductionsfooter`
--
ALTER TABLE `layout_introductionsfooter`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `layout_introductionssection`
--
ALTER TABLE `layout_introductionssection`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `layout_navigation_menu`
--
ALTER TABLE `layout_navigation_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Chỉ mục cho bảng `layout_ordering_online`
--
ALTER TABLE `layout_ordering_online`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `layout_ordering_process`
--
ALTER TABLE `layout_ordering_process`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `layout_slide_header`
--
ALTER TABLE `layout_slide_header`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `layout_social_media_links`
--
ALTER TABLE `layout_social_media_links`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `platform` (`platform`);

--
-- Chỉ mục cho bảng `layout_space`
--
ALTER TABLE `layout_space`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `layout_story`
--
ALTER TABLE `layout_story`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `layout_website_brand`
--
ALTER TABLE `layout_website_brand`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT cho bảng `layout_benefit`
--
ALTER TABLE `layout_benefit`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `layout_commitment`
--
ALTER TABLE `layout_commitment`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `layout_contactsfooter`
--
ALTER TABLE `layout_contactsfooter`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `layout_copyright`
--
ALTER TABLE `layout_copyright`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `layout_customer_choose_item_section`
--
ALTER TABLE `layout_customer_choose_item_section`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `layout_customer_choose_section`
--
ALTER TABLE `layout_customer_choose_section`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `layout_customer_section`
--
ALTER TABLE `layout_customer_section`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT cho bảng `layout_customer_section_img`
--
ALTER TABLE `layout_customer_section_img`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `layout_introductionsfooter`
--
ALTER TABLE `layout_introductionsfooter`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `layout_introductionssection`
--
ALTER TABLE `layout_introductionssection`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `layout_navigation_menu`
--
ALTER TABLE `layout_navigation_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT cho bảng `layout_ordering_online`
--
ALTER TABLE `layout_ordering_online`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `layout_ordering_process`
--
ALTER TABLE `layout_ordering_process`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `layout_slide_header`
--
ALTER TABLE `layout_slide_header`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `layout_social_media_links`
--
ALTER TABLE `layout_social_media_links`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `layout_space`
--
ALTER TABLE `layout_space`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `layout_story`
--
ALTER TABLE `layout_story`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `layout_website_brand`
--
ALTER TABLE `layout_website_brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT cho bảng `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `layout_navigation_menu`
--
ALTER TABLE `layout_navigation_menu`
  ADD CONSTRAINT `layout_navigation_menu_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `layout_navigation_menu` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
