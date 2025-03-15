-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 12, 2025 at 06:40 AM
-- Server version: 10.6.21-MariaDB-ubu2204
-- PHP Version: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `haisan`
--

-- --------------------------------------------------------
-- Modify table structure to add mobile_image_url field
CREATE TABLE `layout_ads` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `image_url` longtext NOT NULL,
  `mobile_image_url` longtext DEFAULT NULL,
  `title` varchar(255) DEFAULT '',
  `is_active` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert sample data with both desktop and mobile images
INSERT INTO `layout_ads` (`id`, `image_url`, `mobile_image_url`, `title`, `is_active`, `created_at`, `updated_at`) 
VALUES (
  1, 
  'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741669336/efkmzxfkbubimvqab44l.jpg', 
  'https://res.cloudinary.com/dsoj3y7wu/image/upload/c_scale,w_600/v1741669336/efkmzxfkbubimvqab44l.jpg', 
  'ads 1', 
  1, 
  '2025-03-12 06:40:36', 
  '2025-03-12 06:40:36'
);
--
--
-- Table structure for table `blacklisted_tokens`
--

CREATE TABLE `blacklisted_tokens` (
  `id` int(11) NOT NULL,
  `token` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



-- Dumping data for table `blacklisted_tokens`
--

INSERT INTO `blacklisted_tokens` (`id`, `token`, `created_at`) VALUES
(18, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjozLCJlbWFpbCI6InRodWFuMTgwOTIwMDNAZ21haWwuY29tIiwiaWF0IjoxNzQxNzU4MDE0LCJleHAiOjE3NDE3NjE2MTR9.NmM8w2OTe7iiRqhNEuntZD415yYeYYNN34N0QJpTezw', '2025-03-12 05:47:30'),
(19, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjozLCJlbWFpbCI6InRodWFuMTgwOTIwMDNAZ21haWwuY29tIiwiaWF0IjoxNzQxNzYwNTk3LCJleHAiOjE3NDE3NjQxOTd9.xHAzXJq9Yjs1Nyov1JIa3Me6Udff-ikoBLrvv6AMqlc', '2025-03-12 06:30:24');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
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
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `content`, `gmail`, `title`, `is_read`, `is_sent`, `created_at`, `updated_at`) VALUES
(2, 'thuan   ', 'thuan', 'thuan18092003@gmail.com', 'thuan', 1, 0, '2025-03-10 04:59:49', '2025-03-10 05:01:13'),
(3, 'thuan   ', 'thuan', 'thuan18092003@gmail.com', 'thuan', 1, 0, '2025-03-10 05:16:34', '2025-03-10 07:01:27'),
(4, 'Nguyễn Minh Thuận', 'hàng ngon mỗi tội không cho nước chấm ', 'thuan18092003@gmail.com', 'mua hàng', 1, 0, '2025-03-11 04:48:09', '2025-03-11 04:48:49');

-- --------------------------------------------------------

--
-- Table structure for table `layout_benefit`
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
-- Dumping data for table `layout_benefit`
--

INSERT INTO `layout_benefit` (`id`, `icon`, `title`, `description`, `created_at`, `updated_at`) VALUES
(1, 'ShoppingBag', 'Chất Lượng ', 'Cam kết sử dụng hải sản tươi sống 100%', '2025-03-03 16:48:42', '2025-03-09 16:20:10'),
(2, 'Target', 'Đa Dạng', 'Thực đơn phong phú với hơn 100 món ăn', '2025-03-03 16:48:42', '2025-03-05 07:30:04'),
(4, 'ThumbsUp', 'Uy Tín', '20 năm kinh nghiệm phục vụ', '2025-03-03 16:48:42', '2025-03-03 16:48:42'),
(10, 'Server', 'Phục Vụ', 'Đội ngũ nhân viên chuyên nghiệp, thân thiện', '2025-03-05 07:09:55', '2025-03-05 07:09:55');

-- --------------------------------------------------------

--
-- Table structure for table `layout_commitment`
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
-- Dumping data for table `layout_commitment`
--

INSERT INTO `layout_commitment` (`id`, `title`, `description_one`, `description_two`, `description_three`, `description_four`, `created_at`, `updated_at`) VALUES
(1, 'Cam Kết Của Chúng Tôi ', 'Đảm bảo chất lượng món ăn từ nhà hàng ', 'Giao hàng đúng giờ, đúng địa chỉ', 'Đổi trả miễn phí nếu món ăn không đúng yêu cầu', 'Nhân viên giao hàng chuyên nghiệp, thân thiện', '2025-03-03 23:45:43', '2025-03-10 04:48:09');

-- --------------------------------------------------------

--
-- Table structure for table `layout_contactsfooter`
--

CREATE TABLE `layout_contactsfooter` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `icon` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `layout_contactsfooter`
--

INSERT INTO `layout_contactsfooter` (`id`, `icon`, `type`, `created_at`, `updated_at`) VALUES
(1, 'Map', '123 Đường ABC, Quận XYZ', '2025-02-22 22:01:47', '2025-03-09 16:02:52'),
(2, 'Phone', '(123) 456-7890', '2025-02-22 22:01:47', '2025-02-22 22:01:47'),
(3, 'Mail', 'info@example.com', '2025-02-22 22:01:47', '2025-02-22 22:01:47'),
(4, 'CalendarCheck2', 'Thứ 2 - Thứ 5: 11:00 - 22:00; Thứ 6 - Chủ Nhật: 11:00 - 23:00', '2025-02-22 22:01:47', '2025-02-22 22:01:47');

-- --------------------------------------------------------

--
-- Table structure for table `layout_copyright`
--

CREATE TABLE `layout_copyright` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `text` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `layout_copyright`
--

INSERT INTO `layout_copyright` (`id`, `text`, `created_at`, `updated_at`) VALUES
(1, '2025 MINHTHUAN. Bản quyền được bảo lưu . ', '2025-02-23 05:01:47', '2025-02-26 14:32:05');

-- --------------------------------------------------------

--
-- Table structure for table `layout_customer_choose_item_section`
--

CREATE TABLE `layout_customer_choose_item_section` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `icon` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `layout_customer_choose_item_section`
--

INSERT INTO `layout_customer_choose_item_section` (`id`, `icon`, `title`, `description`) VALUES
(2, 'Utensils', 'Duy trì hương vị và chất lượng ', 'thực phẩm ngon nhất '),
(3, 'Check', 'Món ăn được chế biến phong phú', 'và đa dạng'),
(4, 'ThumbsUp', 'Giá cả ổn định, phong cách phục vụ', 'chuyên nghiệp'),
(5, 'Cookie', 'Thực phẩm sạch, tươi ngon nhất ', 'được lựa chọn kỹ càng');

-- --------------------------------------------------------

--
-- Table structure for table `layout_customer_choose_section`
--

CREATE TABLE `layout_customer_choose_section` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `image_url` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `layout_customer_choose_section`
--

INSERT INTO `layout_customer_choose_section` (`id`, `title`, `image_url`) VALUES
(1, 'Đây là lý do khách hàng thường chọn chúng tôi ', 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741669336/efkmzxfkbubimvqab44l.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `layout_customer_section`
--

CREATE TABLE `layout_customer_section` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image_url` longtext NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `layout_customer_section`
--

INSERT INTO `layout_customer_section` (`id`, `name`, `image_url`, `description`) VALUES
(8, 'Nguyễn Minh Thuận ', 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741669180/ixnkmyctuxxxkwgktgjq.jpg', 'Nhà hàng có không gian thoáng đãng, món ăn chế biến tinh tế và nhân viên phục vụ chu đáo. Đặc biệt là các món hải sản tươi ngon khiến tôi muốn quay lại lần nữa.'),
(11, 'Nguyễn Huy Chiến', 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741669092/yt4ol6ahu72nopbike2l.jpg', 'Vừa bước vào nhà hàng Minh Thuận, tôi đã bị cuốn hút bởi không gian ấm cúng, sạch sẽ và có chút gì đó rất gần gũi. Mùi hương của những món ăn thơm lừng lan tỏa trong không khí khiến bụng tôi sôi lên réo rắt.\n\nTôi nhanh chóng gọi vài món đặc trưng của quán. Khi đĩa thức ăn được mang ra, tôi không thể không trầm trồ: trình bày đẹp mắt, hương thơm quyến rũ. Cắn một miếng, vị giác như bùng nổ! Gia vị nêm nếm vừa miệng, nguyên liệu tươi ngon, từng miếng thịt mềm tan trong miệng, nước sốt đậm đà, đúng chuẩn \"cực phẩm nhân gian\".'),
(12, 'Lò Tiến Anh', 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741669102/mopckte6vqoypckwkowz.jpg', 'Nhà hàng có không gian thoáng đãng, món ăn chế biến tinh tế và nhân viên phục vụ chu đáo. Đặc biệt là các món hải sản tươi ngon khiến tôi muốn quay lại lần nữa.'),
(13, 'Pham Văn Hiếu', 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741669112/pt8iegycnjdangc4uatj.jpg', 'Nhà hàng có không gian thoáng đãng, món ăn chế biến tinh tế và nhân viên phục vụ chu đáo. Đặc biệt là các món hải sản tươi ngon khiến tôi muốn quay lại lần nữa.'),
(14, 'Nguyễn Thanh Nam', 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741669170/iidjp3kd6voacdwi4py2.jpg', 'Ngồi xuống bàn, anh không ngần ngại gọi ngay những món đặc trưng của nhà hàng. Khi đĩa thức ăn được bưng ra, mắt anh sáng rực như tìm thấy kho báu. Mỗi miếng ăn đưa vào miệng đều là sự hòa quyện hoàn hảo giữa hương vị và cách nêm nếm tinh tế, khiến anh không thể ngừng lại. Đặc biệt, món \"đặc sản Minh Thuận\" với lớp vỏ giòn rụm, nhân mềm thơm đã khiến anh phải gật gù tán thưởng.\n\nKhông chỉ đồ ăn ngon, thái độ phục vụ cũng khiến anh hài lòng. Nhân viên nhanh nhẹn, niềm nở, sẵn sàng đáp ứng mọi yêu cầu của khách. Càng ăn,Máy Đớp càng cảm thấy mình đã tìm đúng nơi để thỏa mãn niềm đam mê ẩm thực.'),
(15, 'Đinh Thế Long', 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741669122/hfypozpxh1vdla5vnkbm.jpg', 'Nhà hàng có không gian thoáng đãng, món ăn chế biến tinh tế và nhân viên phục vụ chu đáo. Đặc biệt là các món hải sản tươi ngon khiến tôi muốn quay lại lần nữa.'),
(18, 'Nguyễn Thị Ánh', 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741669142/j3wh7flkptqezocjuxer.jpg', 'Nhà hàng có không gian thoáng đãng, món ăn chế biến tinh tế và nhân viên phục vụ chu đáo. Đặc biệt là các món hải sản tươi ngon khiến tôi muốn quay lại lần nữa.'),
(19, 'Vũ Quang Huy', 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741669160/ousliun0o73hypblr82a.jpg', 'Nhà hàng có không gian thoáng đãng, món ăn chế biến tinh tế và nhân viên phục vụ chu đáo. Đặc biệt là các món hải sản tươi ngon khiến tôi muốn quay lại lần nữa.');

-- --------------------------------------------------------

--
-- Table structure for table `layout_customer_section_img`
--

CREATE TABLE `layout_customer_section_img` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image_url` longtext NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `layout_customer_section_img`
--

INSERT INTO `layout_customer_section_img` (`id`, `image_url`, `title`) VALUES
(1, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741669296/ko7hwee0xeyudqnskodx.webp', 'Khách hàng nói về chùng tôi ');

-- --------------------------------------------------------

--
-- Table structure for table `layout_introductionsfooter`
--

CREATE TABLE `layout_introductionsfooter` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `layout_introductionsfooter`
--

INSERT INTO `layout_introductionsfooter` (`id`, `title`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Giới thiệu ', 'Là một nhà hàng sang trọng với không gian ấm cúng và phong cách hiện đại. Chúng tôi phục vụ các món ăn đặc sắc được chế biến từ những nguyên liệu tươi ngon nhất cùng đồ uống chất lượng cao.', '2025-02-23 05:01:47', '2025-03-10 04:04:48');

-- --------------------------------------------------------

--
-- Table structure for table `layout_introductionssection`
--

CREATE TABLE `layout_introductionssection` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `content` text NOT NULL,
  `image_url` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `layout_introductionssection`
--

INSERT INTO `layout_introductionssection` (`id`, `title`, `description`, `content`, `image_url`) VALUES
(1, 'Minh Thuận', 'Nhà hàng hải sản Minh Thuận là điểm đến lý tưởng cho những tín đồ yêu thích hải sản tươi sống. Tọa lạc ngay sát bờ biển Bình Thuận, Minh Thuận tự hào mang đến nguồn hải sản tươi ngon nhất, được đánh bắt trực tiếp mỗi ngày. Với hơn 50 loại hải sản phong phú, chế biến theo công thức đặc biệt, chúng tôi mang đến những món ăn thơm ngon, đậm đà hương vị biển cả, khiến thực khách nhớ mãi không quên.', 'Tận hưởng hải sản chất lượng mà không phải lo về giá cả. Chúng tôi cam kết mang đến những sản phẩm tươi sạch, an toàn với mức giá hợp lý, cùng dịch vụ tận tâm.', 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741669356/mcoywgpg6ixhteapp7uq.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `layout_navigation_menu`
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
-- Dumping data for table `layout_navigation_menu`
--

INSERT INTO `layout_navigation_menu` (`id`, `name`, `url`, `parent_id`, `order_position`, `is_active`, `is_visible`) VALUES
(11, 'Trang Chủ', '/', NULL, 1, 0, 1),
(14, 'Sản Phẩm', '/products', NULL, 2, 0, 1),
(15, 'Liên hệ', '/contact', NULL, 4, 0, 1),
(16, 'Giới thiệu', '/about', NULL, 3, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `layout_ordering_online`
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
-- Dumping data for table `layout_ordering_online`
--

INSERT INTO `layout_ordering_online` (`id`, `icon`, `title`, `description_one`, `description_two`, `description_three`, `description_four`, `created_at`, `updated_at`) VALUES
(1, 'Truck', 'Giao Hàng Tận Nơi', ' Phạm vi giao hàng: 10km từ nhà hàng', 'Thời gian giao hàng: 30-45 phút', 'Đóng gói cẩn thận, giữ nhiệt tốt', 'Miễn phí giao hàng cho đơn từ 500.000đ', '2025-03-03 23:42:46', '2025-03-10 04:43:45'),
(2, 'Clock', 'Thời Gian Phục Vụ', 'Nhà hàng: 10:00 - 22:00', 'Đặt hàng online: 10:00 - 21:00', 'Phục vụ tất cả các ngày trong tuần', 'Hotline đặt hàng: 0123 456 789', '2025-03-03 23:42:46', '2025-03-05 12:07:12');

-- --------------------------------------------------------

--
-- Table structure for table `layout_ordering_process`
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
-- Dumping data for table `layout_ordering_process`
--

INSERT INTO `layout_ordering_process` (`id`, `icon`, `title`, `description`, `created_at`, `updated_at`) VALUES
(1, 'ShoppingBag', 'Chọn món', 'Dễ dàng đặt hàng qua website hoặc gọi điện trực tiếp', '2025-03-03 16:31:02', '2025-03-03 16:31:02'),
(2, 'CreditCard', 'Thanh Toán', 'Đa dạng phương thức thanh toán: tiền mặt, chuyển khoản, ví điện tử', '2025-03-03 16:31:02', '2025-03-03 16:31:02'),
(3, 'Truck', 'Giao Hàng', 'Giao hàng nhanh chóng, đảm bảo chất lượng món ăn', '2025-03-03 16:31:02', '2025-03-03 16:31:02');

-- --------------------------------------------------------

--
-- Table structure for table `layout_slide_header`
--

CREATE TABLE `layout_slide_header` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `layout_slide_header`
--

INSERT INTO `layout_slide_header` (`id`, `image_url`, `title`, `description`) VALUES
(2, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741669032/dph9ofthzvznzimuwy2v.jpg', 'MINH THUẬN ', 'Chào mừng bạn đến với nhà hàng của chúng tôi !'),
(3, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741669043/mug3rqyluk84nq1gqwa4.jpg', 'Hải Sản Minh Thuận ', 'Chào mừng bạn đến với nhà hàng của chúng tôi !'),
(10, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741669403/jpvwpp9rl9rxnditeuq8.jpg', 'MINH THUẬN', 'Chào mừng bạn đến với nhà hàng của chúng tôi !');

-- --------------------------------------------------------

--
-- Table structure for table `layout_social_media_links`
--

CREATE TABLE `layout_social_media_links` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `platform` varchar(50) NOT NULL,
  `url` varchar(255) NOT NULL,
  `target` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `layout_social_media_links`
--

INSERT INTO `layout_social_media_links` (`id`, `platform`, `url`, `target`, `created_at`, `updated_at`) VALUES
(1, 'Facebook', 'https://facebook.com/minhthuan', '_blank', '2025-02-22 15:01:47', '2025-03-10 04:48:40'),
(2, 'Instagram', 'https://instagram.com/minhthuan', '_blank', '2025-02-22 15:01:47', '2025-02-22 15:01:47'),
(3, 'Youtube', 'https://youtube.com/minhthuan', '_blank', '2025-02-22 15:01:47', '2025-02-22 15:01:47');

-- --------------------------------------------------------

--
-- Table structure for table `layout_space`
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
-- Dumping data for table `layout_space`
--

INSERT INTO `layout_space` (`id`, `icon`, `title`, `description_one`, `description_two`, `description_three`, `description_four`, `created_at`, `updated_at`) VALUES
(3, 'ChefHat', 'Khu Vực Bếp Chuyên Nghiệp ', 'Nhân viên bếp được đào tạo bài bản', 'Trang thiết bị hiện đại, đảm bảo vệ sinh an toàn thực phẩm', 'Khu vực sơ chế và chế biến thực phẩm', 'Hệ thống làm mát và thông gió đạt chuẩn', '2025-03-05 11:49:57', '2025-03-10 03:16:45'),
(4, 'Cookie', 'Đội Ngũ Bếp ', 'Đội ngũ bếp trưởng với hơn 15 năm kinh nghiệm', 'Rất nhiều món ăn đặc sắc được chế biến', 'Quy trình chế biến chuẩn mực', 'Kiểm soát chất lượng nghiêm ngặt', '2025-03-05 11:49:57', '2025-03-05 11:50:33');

-- --------------------------------------------------------

--
-- Table structure for table `layout_story`
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
-- Dumping data for table `layout_story`
--

INSERT INTO `layout_story` (`id`, `title`, `description_one`, `description_two`, `created_at`, `updated_at`) VALUES
(1, 'Câu Chuyện Của Chúng Tôi', 'Nhà hàng Hải Sản Minh Thuận được thành lập từ năm 2003, khởi đầu là một quán ăn nhỏ với tâm huyết mang đến những món hải sản tươi ngon nhất cho thực khách. Qua hơn 20 năm phát triển, chúng tôi đã trở thành một trong những nhà hàng hải sản uy tín nhất trong khu vực.', 'Với sự phát triển của công nghệ, chúng tôi đã mở rộng dịch vụ sang mảng đặt hàng trực tuyến và giao hàng tận nơi, giúp thực khách có thể thưởng thức các món ăn ngon của nhà hàng ngay tại nhà.', '2025-03-03 23:09:07', '2025-03-12 06:00:55');

-- --------------------------------------------------------

--
-- Table structure for table `layout_website_brand`
--

CREATE TABLE `layout_website_brand` (
  `id` int(11) NOT NULL,
  `logo_url` longtext NOT NULL,
  `brand_name` varchar(100) NOT NULL,
  `alt_text` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `layout_website_brand`
--

INSERT INTO `layout_website_brand` (`id`, `logo_url`, `brand_name`, `alt_text`) VALUES
(1, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741760619/xqbnpja3oyl5hirtozfg.png', 'Cá Xanh ', 'hải sản');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `image_url` longtext NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `description`, `image_url`, `status`, `created_at`, `updated_at`) VALUES
(29, 'thuan3dsdfsdfsdfsafd', '<h3><strong>Tôm rang me được ngợi là món ăn đơn giản, dễ ăn và dễ chế biến. Vị ngọt từ tôm kết hợp với vị chua của me chính ngọt ngon của me, thêm chút nước mắm vừa miệng.</strong></h3><h1><em>Nguyên liệu cần chuẩn bị để thực hiện món tôm rang me bao gồm:</em></h1><ol><li><p><em>Tôm sú đã làm sạch</em></p></li><li><p><em>Me tươi</em></p></li><li><p><em>Hành lá, rau ăn</em></p></li><li><p><em>Những thành phần khác như nước mắm, dầu ăn, đường...</em></p></li><li><p><em>Cách sơ chế nguyên liệu chế biến:</em></p></li><li><p><em>Tôm rửa sạch, đánh vảy và cắt râu</em></p></li><li><p><em>Ngâm tôm với nước muối, rửa sạch với nước, để ráo sau đó chế biến</em></p></li><li><p><em>Đồ gia vị</em></p></li><li><p><em>Cách làm tôm rang me như sau:</em></p></li></ol><p></p><h3><strong>Tôm rang me được ngợi là món ăn đơn giản, dễ ăn và dễ chế biến. Vị ngọt từ tôm kết hợp với vị chua của me chính ngọt ngon của me, thêm chút nước mắm vừa miệng.</strong></h3><h1><em>Nguyên liệu cần chuẩn bị để thực hiện món tôm rang me bao gồm:</em></h1><ol><li><p><em>Tôm sú đã làm sạch</em></p></li><li><p><em>Me tươi</em></p></li><li><p><em>Hành lá, rau ăn</em></p></li><li><p><em>Những thành phần khác như nước mắm, dầu ăn, đường...</em></p></li><li><p><em>Cách sơ chế nguyên liệu chế biến:</em></p></li><li><p><em>Tôm rửa sạch, đánh vảy và cắt râu</em></p></li><li><p><em>Ngâm tôm với nước muối, rửa sạch với nước, để ráo sau đó chế biến</em></p></li><li><p><em>Đồ gia vị</em></p></li><li><p><em>Cách làm tôm rang me như sau:</em></p></li></ol><blockquote><p><em>Bắt đầu, cho nướng chảo, sau đó cho 1 muỗng dầu ăn vào. Phi đầu tôm lên, cho 1 muỗng nước bột đầu để tạo màu sắc. Đầu tiên, bắt đầu rây khoảng 2 – 3 phút là có thể tắt bếp. Hỗn hợp đầu có màu đỏ, mùi thơm.</em></p><p></p><p><em>thuan1d</em></p></blockquote><p></p><h3><strong>Tôm rang me được ngợi là món ăn đơn giản, dễ ăn và dễ chế biến. Vị ngọt từ tôm kết hợp với vị chua của me chính ngọt ngon của me, thêm chút nước mắm vừa miệng.</strong></h3><h1><em>Nguyên liệu cần chuẩn bị để thực hiện món tôm rang me bao gồm:</em></h1><ol><li><p><em>Tôm sú đã làm sạch</em></p></li><li><p><em>Me tươi</em></p></li><li><p><em>Hành lá, rau ăn</em></p></li><li><p><em>Những thành phần khác như nước mắm, dầu ăn, đường...</em></p></li><li><p><em>Cách sơ chế nguyên liệu chế biến:</em></p></li><li><p><em>Tôm rửa sạch, đánh vảy và cắt râu</em></p></li><li><p><em>Ngâm tôm với nước muối, rửa sạch với nước, để ráo sau đó chế biến</em></p></li><li><p><em>Đồ gia vị</em></p></li><li><p><em>Cách làm tôm rang me như sau:</em></p></li></ol><blockquote><p><em>Bắt đầu, cho nướng chảo, sau đó cho 1 muỗng dầu ăn vào. Phi đầu tôm lên, cho 1 muỗng nước bột đầu để tạo màu sắc. Đầu tiên, bắt đầu rây khoảng 2 – 3 phút là có thể tắt bếp. Hỗn hợp đầu có màu đỏ, mùi thơm.</em></p><p></p><p><em>thuan1d</em></p></blockquote><p></p><h3><strong>Tôm rang me được ngợi là món ăn đơn giản, dễ ăn và dễ chế biến. Vị ngọt từ tôm kết hợp với vị chua của me chính ngọt ngon của me, thêm chút nước mắm vừa miệng.</strong></h3><h1><em>Nguyên liệu cần chuẩn bị để thực hiện món tôm rang me bao gồm:</em></h1><ol><li><p><em>Tôm sú đã làm sạch</em></p></li><li><p><em>Me tươi</em></p></li><li><p><em>Hành lá, rau ăn</em></p></li><li><p><em>Những thành phần khác như nước mắm, dầu ăn, đường...</em></p></li><li><p><em>Cách sơ chế nguyên liệu chế biến:</em></p></li><li><p><em>Tôm rửa sạch, đánh vảy và cắt râu</em></p></li><li><p><em>Ngâm tôm với nước muối, rửa sạch với nước, để ráo sau đó chế biến</em></p></li><li><p><em>Đồ gia vị</em></p></li><li><p><em>Cách làm tôm rang me như sau:</em></p></li></ol><blockquote><p><em>Bắt đầu, cho nướng chảo, sau đó cho 1 muỗng dầu ăn vào. Phi đầu tôm lên, cho 1 muỗng nước bột đầu để tạo màu sắc. Đầu tiên, bắt đầu rây khoảng 2 – 3 phút là có thể tắt bếp. Hỗn hợp đầu có màu đỏ, mùi thơm.</em></p><p></p><p><em>thuan1d</em></p></blockquote><p></p><h3><strong>Tôm rang me được ngợi là món ăn đơn giản, dễ ăn và dễ chế biến. Vị ngọt từ tôm kết hợp với vị chua của me chính ngọt ngon của me, thêm chút nước mắm vừa miệng.</strong></h3><h1><em>Nguyên liệu cần chuẩn bị để thực hiện món tôm rang me bao gồm:</em></h1><ol><li><p><em>Tôm sú đã làm sạch</em></p></li><li><p><em>Me tươi</em></p></li><li><p><em>Hành lá, rau ăn</em></p></li><li><p><em>Những thành phần khác như nước mắm, dầu ăn, đường...</em></p></li><li><p><em>Cách sơ chế nguyên liệu chế biến:</em></p></li><li><p><em>Tôm rửa sạch, đánh vảy và cắt râu</em></p></li><li><p><em>Ngâm tôm với nước muối, rửa sạch với nước, để ráo sau đó chế biến</em></p></li><li><p><em>Đồ gia vị</em></p></li><li><p><em>Cách làm tôm rang me như sau:</em></p></li></ol><blockquote><p><em>Bắt đầu, cho nướng chảo, sau đó cho 1 muỗng dầu ăn vào. Phi đầu tôm lên, cho 1 muỗng nước bột đầu để tạo màu sắc. Đầu tiên, bắt đầu rây khoảng 2 – 3 phút là có thể tắt bếp. Hỗn hợp đầu có màu đỏ, mùi thơm.</em></p><p></p><p><em>thuan1d</em></p></blockquote><p></p><h3><strong>Tôm rang me được ngợi là món ăn đơn giản, dễ ăn và dễ chế biến. Vị ngọt từ tôm kết hợp với vị chua của me chính ngọt ngon của me, thêm chút nước mắm vừa miệng.</strong></h3><h1><em>Nguyên liệu cần chuẩn bị để thực hiện món tôm rang me bao gồm:</em></h1><ol><li><p><em>Tôm sú đã làm sạch</em></p></li><li><p><em>Me tươi</em></p></li><li><p><em>Hành lá, rau ăn</em></p></li><li><p><em>Những thành phần khác như nước mắm, dầu ăn, đường...</em></p></li><li><p><em>Cách sơ chế nguyên liệu chế biến:</em></p></li><li><p><em>Tôm rửa sạch, đánh vảy và cắt râu</em></p></li><li><p><em>Ngâm tôm với nước muối, rửa sạch với nước, để ráo sau đó chế biến</em></p></li><li><p><em>Đồ gia vị</em></p></li><li><p><em>Cách làm tôm rang me như sau:</em></p></li></ol><blockquote><p><em>Bắt đầu, cho nướng chảo, sau đó cho 1 muỗng dầu ăn vào. Phi đầu tôm lên, cho 1 muỗng nước bột đầu để tạo màu sắc. Đầu tiên, bắt đầu rây khoảng 2 – 3 phút là có thể tắt bếp. Hỗn hợp đầu có màu đỏ, mùi thơm.</em></p><p></p><p><em>thuan1d</em></p></blockquote><p></p><h3><strong>Tôm rang me được ngợi là món ăn đơn giản, dễ ăn và dễ chế biến. Vị ngọt từ tôm kết hợp với vị chua của me chính ngọt ngon của me, thêm chút nước mắm vừa miệng.</strong></h3><h1><em>Nguyên liệu cần chuẩn bị để thực hiện món tôm rang me bao gồm:</em></h1><ol><li><p><em>Tôm sú đã làm sạch</em></p></li><li><p><em>Me tươi</em></p></li><li><p><em>Hành lá, rau ăn</em></p></li><li><p><em>Những thành phần khác như nước mắm, dầu ăn, đường...</em></p></li><li><p><em>Cách sơ chế nguyên liệu chế biến:</em></p></li><li><p><em>Tôm rửa sạch, đánh vảy và cắt râu</em></p></li><li><p><em>Ngâm tôm với nước muối, rửa sạch với nước, để ráo sau đó chế biến</em></p></li><li><p><em>Đồ gia vị</em></p></li><li><p><em>Cách làm tôm rang me như sau:</em></p></li></ol><blockquote><p><em>Bắt đầu, cho nướng chảo, sau đó cho 1 muỗng dầu ăn vào. Phi đầu tôm lên, cho 1 muỗng nước bột đầu để tạo màu sắc. Đầu tiên, bắt đầu rây khoảng 2 – 3 phút là có thể tắt bếp. Hỗn hợp đầu có màu đỏ, mùi thơm.</em></p><p></p><p><em>thuan1d</em></p></blockquote><p></p><h3><strong>Tôm rang me được ngợi là món ăn đơn giản, dễ ăn và dễ chế biến. Vị ngọt từ tôm kết hợp với vị chua của me chính ngọt ngon của me, thêm chút nước mắm vừa miệng.</strong></h3><h1><em>Nguyên liệu cần chuẩn bị để thực hiện món tôm rang me bao gồm:</em></h1><ol><li><p><em>Tôm sú đã làm sạch</em></p></li><li><p><em>Me tươi</em></p></li><li><p><em>Hành lá, rau ăn</em></p></li><li><p><em>Những thành phần khác như nước mắm, dầu ăn, đường...</em></p></li><li><p><em>Cách sơ chế nguyên liệu chế biến:</em></p></li><li><p><em>Tôm rửa sạch, đánh vảy và cắt râu</em></p></li><li><p><em>Ngâm tôm với nước muối, rửa sạch với nước, để ráo sau đó chế biến</em></p></li><li><p><em>Đồ gia vị</em></p></li><li><p><em>Cách làm tôm rang me như sau:</em></p></li></ol><blockquote><p><em>Bắt đầu, cho nướng chảo, sau đó cho 1 muỗng dầu ăn vào. Phi đầu tôm lên, cho 1 muỗng nước bột đầu để tạo màu sắc. Đầu tiên, bắt đầu rây khoảng 2 – 3 phút là có thể tắt bếp. Hỗn hợp đầu có màu đỏ, mùi thơm.</em></p><p></p><p><em>thuan1d</em></p></blockquote><p></p><h3><strong>Tôm rang me được ngợi là món ăn đơn giản, dễ ăn và dễ chế biến. Vị ngọt từ tôm kết hợp với vị chua của me chính ngọt ngon của me, thêm chút nước mắm vừa miệng.</strong></h3><h1><em>Nguyên liệu cần chuẩn bị để thực hiện món tôm rang me bao gồm:</em></h1><ol><li><p><em>Tôm sú đã làm sạch</em></p></li><li><p><em>Me tươi</em></p></li><li><p><em>Hành lá, rau ăn</em></p></li><li><p><em>Những thành phần khác như nước mắm, dầu ăn, đường...</em></p></li><li><p><em>Cách sơ chế nguyên liệu chế biến:</em></p></li><li><p><em>Tôm rửa sạch, đánh vảy và cắt râu</em></p></li><li><p><em>Ngâm tôm với nước muối, rửa sạch với nước, để ráo sau đó chế biến</em></p></li><li><p><em>Đồ gia vị</em></p></li><li><p><em>Cách làm tôm rang me như sau:</em></p></li></ol><blockquote><p><em>Bắt đầu, cho nướng chảo, sau đó cho 1 muỗng dầu ăn vào. Phi đầu tôm lên, cho 1 muỗng nước bột đầu để tạo màu sắc. Đầu tiên, bắt đầu rây khoảng 2 – 3 phút là có thể tắt bếp. Hỗn hợp đầu có màu đỏ, mùi thơm.</em></p><p></p><p><em>thuan1d</em></p></blockquote><p></p><p></p><p></p>', 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1740820659/rqz8hoy9x354hpagbh1i.jpg', 1, '2025-03-01 08:33:42', '2025-03-01 08:33:42'),
(31, 'ádfsdafasdfsadfasdfasd', '<p>zxcvàdsafsdafádfsadfsadfsadđ</p>', 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741576063/jfcukbjp8ajwu78k0wqu.png', 1, '2025-03-10 03:07:43', '2025-03-10 03:07:43');

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE `permission` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission`
--

INSERT INTO `permission` (`id`, `name`) VALUES
(2, 'get_user'),
(3, 'post_user'),
(4, 'put_user'),
(5, 'delete_user'),
(6, 'get_new'),
(7, 'post_new'),
(8, 'put_new'),
(9, 'delete_new'),
(10, 'put_product'),
(11, 'post_product'),
(12, 'delete_product'),
(13, 'put_footer'),
(14, 'post_footer'),
(15, 'delete_footer'),
(16, 'put_about'),
(17, 'post_about'),
(18, 'delete_about'),
(19, 'put_header'),
(20, 'post_header'),
(21, 'delete_header'),
(22, 'post_nav_logo'),
(23, 'put_nav_logo'),
(24, 'delete_nav_logo'),
(25, 'post_role'),
(26, 'put_role'),
(27, 'delete_role'),
(28, 'get_role'),
(29, 'get_contacts'),
(30, 'delete_contacts'),
(31, 'get_discount'),
(32, 'post_discount'),
(33, 'put_discount'),
(34, 'delete_discount'),
(35, 'get_order'),
(36, 'post_order'),
(37, 'put_order'),
(38, 'delete_order');

-- --------------------------------------------------------

--
-- Table structure for table `products`
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
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `quantity_sold`, `quantity`, `star`, `status`, `category`, `hot`, `created_at`, `updated_at`) VALUES
(2, 'thuan', '<h3><strong>Tôm rang me được ngợi là món ăn đơn giản, dễ ăn và dễ chế biến. Vị ngọt từ tôm kết hợp với vị chua của me chính ngọt ngon của me, thêm chút nước mắm vừa miệng.</strong></h3><h1><em>Nguyên liệu cần chuẩn bị để thực hiện món tôm rang me bao gồm:</em></h1><ol><li><p><em>Tôm sú đã làm sạch</em></p></li><li><p><em>Me tươi</em></p></li><li><p><em>Hành lá, rau ăn</em></p></li><li><p><em>Những thành phần khác như nước mắm, dầu ăn, đường...</em></p></li><li><p><em>Cách sơ chế nguyên liệu chế biến:</em></p></li><li><p><em>Tôm rửa sạch, đánh vảy và cắt râu</em></p></li><li><p><em>Ngâm tôm với nước muối, rửa sạch với nước, để ráo sau đó chế biến</em></p></li><li><p><em>Đồ gia vị</em></p></li><li><p><em>Cách làm tôm rang me như sau:</em></p></li></ol><p></p><h3><strong>Tôm rang me được ngợi là món ăn đơn giản, dễ ăn và dễ chế biến. Vị ngọt từ tôm kết hợp với vị chua của me chính ngọt ngon của me, thêm chút nước mắm vừa miệng.</strong></h3><h1><em>Nguyên liệu cần chuẩn bị để thực hiện món tôm rang me bao gồm:</em></h1><ol><li><p><em>Tôm sú đã làm sạch</em></p></li><li><p><em>Me tươi</em></p></li><li><p><em>Hành lá, rau ăn</em></p></li><li><p><em>Những thành phần khác như nước mắm, dầu ăn, đường...</em></p></li><li><p><em>Cách sơ chế nguyên liệu chế biến:</em></p></li><li><p><em>Tôm rửa sạch, đánh vảy và cắt râu</em></p></li><li><p><em>Ngâm tôm với nước muối, rửa sạch với nước, để ráo sau đó chế biến</em></p></li><li><p><em>Đồ gia vị</em></p></li><li><p><em>Cách làm tôm rang me như sau:</em></p></li></ol><blockquote><p><em>Bắt đầu, cho nướng chảo, sau đó cho 1 muỗng dầu ăn vào. Phi đầu tôm lên, cho 1 muỗng nước bột đầu để tạo màu sắc. Đầu tiên, bắt đầu rây khoảng 2 – 3 phút là có thể tắt bếp. Hỗn hợp đầu có màu đỏ, mùi thơm.</em></p><p></p><p><em>thuan1d</em></p></blockquote><p></p><h3><strong>Tôm rang me được ngợi là món ăn đơn giản, dễ ăn và dễ chế biến. Vị ngọt từ tôm kết hợp với vị chua của me chính ngọt ngon của me, thêm chút nước mắm vừa miệng.</strong></h3><h1><em>Nguyên liệu cần chuẩn bị để thực hiện món tôm rang me bao gồm:</em></h1><ol><li><p><em>Tôm sú đã làm sạch</em></p></li><li><p><em>Me tươi</em></p></li><li><p><em>Hành lá, rau ăn</em></p></li><li><p><em>Những thành phần khác như nước mắm, dầu ăn, đường...</em></p></li><li><p><em>Cách sơ chế nguyên liệu chế biến:</em></p></li><li><p><em>Tôm rửa sạch, đánh vảy và cắt râu</em></p></li><li><p><em>Ngâm tôm với nước muối, rửa sạch với nước, để ráo sau đó chế biến</em></p></li><li><p><em>Đồ gia vị</em></p></li><li><p><em>Cách làm tôm rang me như sau:</em></p></li></ol><blockquote><p><em>Bắt đầu, cho nướng chảo, sau đó cho 1 muỗng dầu ăn vào. Phi đầu tôm lên, cho 1 muỗng nước bột đầu để tạo màu sắc. Đầu tiên, bắt đầu rây khoảng 2 – 3 phút là có thể tắt bếp. Hỗn hợp đầu có màu đỏ, mùi thơm.</em></p><p></p><p><em>thuan1d</em></p></blockquote><p></p><h3><strong>Tôm rang me được ngợi là món ăn đơn giản, dễ ăn và dễ chế biến. Vị ngọt từ tôm kết hợp với vị chua của me chính ngọt ngon của me, thêm chút nước mắm vừa miệng.</strong></h3><h1><em>Nguyên liệu cần chuẩn bị để thực hiện món tôm rang me bao gồm:</em></h1><ol><li><p><em>Tôm sú đã làm sạch</em></p></li><li><p><em>Me tươi</em></p></li><li><p><em>Hành lá, rau ăn</em></p></li><li><p><em>Những thành phần khác như nước mắm, dầu ăn, đường...</em></p></li><li><p><em>Cách sơ chế nguyên liệu chế biến:</em></p></li><li><p><em>Tôm rửa sạch, đánh vảy và cắt râu</em></p></li><li><p><em>Ngâm tôm với nước muối, rửa sạch với nước, để ráo sau đó chế biến</em></p></li><li><p><em>Đồ gia vị</em></p></li><li><p><em>Cách làm tôm rang me như sau:</em></p></li></ol><blockquote><p><em>Bắt đầu, cho nướng chảo, sau đó cho 1 muỗng dầu ăn vào. Phi đầu tôm lên, cho 1 muỗng nước bột đầu để tạo màu sắc. Đầu tiên, bắt đầu rây khoảng 2 – 3 phút là có thể tắt bếp. Hỗn hợp đầu có màu đỏ, mùi thơm.</em></p><p></p><p><em>thuan1d</em></p></blockquote><p></p><h3><strong>Tôm rang me được ngợi là món ăn đơn giản, dễ ăn và dễ chế biến. Vị ngọt từ tôm kết hợp với vị chua của me chính ngọt ngon của me, thêm chút nước mắm vừa miệng.</strong></h3><h1><em>Nguyên liệu cần chuẩn bị để thực hiện món tôm rang me bao gồm:</em></h1><ol><li><p><em>Tôm sú đã làm sạch</em></p></li><li><p><em>Me tươi</em></p></li><li><p><em>Hành lá, rau ăn</em></p></li><li><p><em>Những thành phần khác như nước mắm, dầu ăn, đường...</em></p></li><li><p><em>Cách sơ chế nguyên liệu chế biến:</em></p></li><li><p><em>Tôm rửa sạch, đánh vảy và cắt râu</em></p></li><li><p><em>Ngâm tôm với nước muối, rửa sạch với nước, để ráo sau đó chế biến</em></p></li><li><p><em>Đồ gia vị</em></p></li><li><p><em>Cách làm tôm rang me như sau:</em></p></li></ol><blockquote><p><em>Bắt đầu, cho nướng chảo, sau đó cho 1 muỗng dầu ăn vào. Phi đầu tôm lên, cho 1 muỗng nước bột đầu để tạo màu sắc. Đầu tiên, bắt đầu rây khoảng 2 – 3 phút là có thể tắt bếp. Hỗn hợp đầu có màu đỏ, mùi thơm.</em></p><p></p><p><em>thuan1d</em></p></blockquote><p></p><h3><strong>Tôm rang me được ngợi là món ăn đơn giản, dễ ăn và dễ chế biến. Vị ngọt từ tôm kết hợp với vị chua của me chính ngọt ngon của me, thêm chút nước mắm vừa miệng.</strong></h3><h1><em>Nguyên liệu cần chuẩn bị để thực hiện món tôm rang me bao gồm:</em></h1><ol><li><p><em>Tôm sú đã làm sạch</em></p></li><li><p><em>Me tươi</em></p></li><li><p><em>Hành lá, rau ăn</em></p></li><li><p><em>Những thành phần khác như nước mắm, dầu ăn, đường...</em></p></li><li><p><em>Cách sơ chế nguyên liệu chế biến:</em></p></li><li><p><em>Tôm rửa sạch, đánh vảy và cắt râu</em></p></li><li><p><em>Ngâm tôm với nước muối, rửa sạch với nước, để ráo sau đó chế biến</em></p></li><li><p><em>Đồ gia vị</em></p></li><li><p><em>Cách làm tôm rang me như sau:</em></p></li></ol><blockquote><p><em>Bắt đầu, cho nướng chảo, sau đó cho 1 muỗng dầu ăn vào. Phi đầu tôm lên, cho 1 muỗng nước bột đầu để tạo màu sắc. Đầu tiên, bắt đầu rây khoảng 2 – 3 phút là có thể tắt bếp. Hỗn hợp đầu có màu đỏ, mùi thơm.</em></p><p></p><p><em>thuan1d</em></p></blockquote><p></p><h3><strong>Tôm rang me được ngợi là món ăn đơn giản, dễ ăn và dễ chế biến. Vị ngọt từ tôm kết hợp với vị chua của me chính ngọt ngon của me, thêm chút nước mắm vừa miệng.</strong></h3><h1><em>Nguyên liệu cần chuẩn bị để thực hiện món tôm rang me bao gồm:</em></h1><ol><li><p><em>Tôm sú đã làm sạch</em></p></li><li><p><em>Me tươi</em></p></li><li><p><em>Hành lá, rau ăn</em></p></li><li><p><em>Những thành phần khác như nước mắm, dầu ăn, đường...</em></p></li><li><p><em>Cách sơ chế nguyên liệu chế biến:</em></p></li><li><p><em>Tôm rửa sạch, đánh vảy và cắt râu</em></p></li><li><p><em>Ngâm tôm với nước muối, rửa sạch với nước, để ráo sau đó chế biến</em></p></li><li><p><em>Đồ gia vị</em></p></li><li><p><em>Cách làm tôm rang me như sau:</em></p></li></ol><blockquote><p><em>Bắt đầu, cho nướng chảo, sau đó cho 1 muỗng dầu ăn vào. Phi đầu tôm lên, cho 1 muỗng nước bột đầu để tạo màu sắc. Đầu tiên, bắt đầu rây khoảng 2 – 3 phút là có thể tắt bếp. Hỗn hợp đầu có màu đỏ, mùi thơm.</em></p><p></p><p><em>thuan1d</em></p></blockquote><p></p><h3><strong>Tôm rang me được ngợi là món ăn đơn giản, dễ ăn và dễ chế biến. Vị ngọt từ tôm kết hợp với vị chua của me chính ngọt ngon của me, thêm chút nước mắm vừa miệng.</strong></h3><h1><em>Nguyên liệu cần chuẩn bị để thực hiện món tôm rang me bao gồm:</em></h1><ol><li><p><em>Tôm sú đã làm sạch</em></p></li><li><p><em>Me tươi</em></p></li><li><p><em>Hành lá, rau ăn</em></p></li><li><p><em>Những thành phần khác như nước mắm, dầu ăn, đường...</em></p></li><li><p><em>Cách sơ chế nguyên liệu chế biến:</em></p></li><li><p><em>Tôm rửa sạch, đánh vảy và cắt râu</em></p></li><li><p><em>Ngâm tôm với nước muối, rửa sạch với nước, để ráo sau đó chế biến</em></p></li><li><p><em>Đồ gia vị</em></p></li><li><p><em>Cách làm tôm rang me như sau:</em></p></li></ol><blockquote><p><em>Bắt đầu, cho nướng chảo, sau đó cho 1 muỗng dầu ăn vào. Phi đầu tôm lên, cho 1 muỗng nước bột đầu để tạo màu sắc. Đầu tiên, bắt đầu rây khoảng 2 – 3 phút là có thể tắt bếp. Hỗn hợp đầu có màu đỏ, mùi thơm.</em></p><p></p><p><em>thuan1d</em></p></blockquote><p></p><h3><strong>Tôm rang me được ngợi là món ăn đơn giản, dễ ăn và dễ chế biến. Vị ngọt từ tôm kết hợp với vị chua của me chính ngọt ngon của me, thêm chút nước mắm vừa miệng.</strong></h3><h1><em>Nguyên liệu cần chuẩn bị để thực hiện món tôm rang me bao gồm:</em></h1><ol><li><p><em>Tôm sú đã làm sạch</em></p></li><li><p><em>Me tươi</em></p></li><li><p><em>Hành lá, rau ăn</em></p></li><li><p><em>Những thành phần khác như nước mắm, dầu ăn, đường...</em></p></li><li><p><em>Cách sơ chế nguyên liệu chế biến:</em></p></li><li><p><em>Tôm rửa sạch, đánh vảy và cắt râu</em></p></li><li><p><em>Ngâm tôm với nước muối, rửa sạch với nước, để ráo sau đó chế biến</em></p></li><li><p><em>Đồ gia vị</em></p></li><li><p><em>Cách làm tôm rang me như sau:</em></p></li></ol><blockquote><p><em>Bắt đầu, cho nướng chảo, sau đó cho 1 muỗng dầu ăn vào. Phi đầu tôm lên, cho 1 muỗng nước bột đầu để tạo màu sắc. Đầu tiên, bắt đầu rây khoảng 2 – 3 phút là có thể tắt bếp. Hỗn hợp đầu có màu đỏ, mùi thơm.</em></p><p></p><p><em>thuan1d</em></p></blockquote><p></p><p></p><p></p>', 22000000, 0, 100, 5, 0, 'fish', 0, '2025-03-06 17:22:41', '2025-03-06 20:46:18'),
(3, 'Ghẹ hấp xả', 'Ghẹ hấp xả là một món ăn được chế biến từ ghẹ, một loại hải sản phổ biến tại Việt Nam. Ghẹ được hấp với xả, tạo ra hương vị thơm ngon.', 22000000, 0, 100, 5, 0, 'shrimp', 0, '2025-03-06 17:22:41', '2025-03-06 19:47:13'),
(4, 'Ghẹ hấp xả', 'Ghẹ hấp xả là một món ăn được chế biến từ ghẹ, một loại hải sản phổ biến tại Việt Nam. Ghẹ được hấp với xả, tạo ra hương vị thơm ngon.', 22000000, 0, 100, 5, 0, 'shrimp', 0, '2025-03-06 17:22:43', '2025-03-06 19:47:11'),
(15, 'Ghẹ hấp xả', 'Ghẹ hấp xả là một món ăn được chế biến từ ghẹ, một loại hải sản phổ biến tại Việt Nam. Ghẹ được hấp với xả, tạo ra hương vị thơm ngon.', 22000000, 0, 100, 5, 0, 'fish', 0, '2025-03-06 20:20:27', '2025-03-06 20:20:27'),
(28, 's', 'd', 2, 0, 2, 0, 0, 'shrimp', 1, '2025-03-12 06:32:27', '2025-03-12 06:33:07');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_url`, `created_at`) VALUES
(1, 2, 'https://picsum.photos/200', '2025-03-06 17:21:57'),
(2, 2, 'https://picsum.photos/201', '2025-03-06 17:21:57'),
(3, 2, 'https://picsum.photos/202', '2025-03-06 17:21:57'),
(4, 2, 'https://picsum.photos/200', '2025-03-06 17:22:41'),
(5, 2, 'https://picsum.photos/201', '2025-03-06 17:22:41'),
(6, 2, 'https://picsum.photos/202', '2025-03-06 17:22:41'),
(7, 2, 'https://picsum.photos/200', '2025-03-06 17:22:41'),
(8, 3, 'https://picsum.photos/201', '2025-03-06 17:22:41'),
(9, 3, 'https://picsum.photos/202', '2025-03-06 17:22:41'),
(10, 4, 'https://picsum.photos/200', '2025-03-06 17:22:43'),
(11, 4, 'https://picsum.photos/201', '2025-03-06 17:22:43'),
(12, 4, 'https://picsum.photos/202', '2025-03-06 17:22:43'),
(43, 15, 'https://picsum.photos/200', '2025-03-06 20:20:27'),
(44, 15, 'https://picsum.photos/201', '2025-03-06 20:20:27'),
(45, 15, 'https://picsum.photos/202', '2025-03-06 20:20:27'),
(81, 28, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741761147/pxvxswszjbp0rsibmm98.jpg', '2025-03-12 06:32:27');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2025-03-09 20:18:21', '2025-03-09 20:18:21'),
(2, 'user', '2025-03-09 20:18:21', '2025-03-09 20:18:21'),
(3, 'super_admin', '2025-03-09 20:18:21', '2025-03-09 20:18:21'),
(28, 'nhan_vien1', '2025-03-09 20:27:31', '2025-03-09 20:27:31'),
(29, 'thu_ngan', '2025-03-09 20:58:39', '2025-03-09 20:58:39');

-- --------------------------------------------------------

--
-- Table structure for table `role_permission`
--

CREATE TABLE `role_permission` (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role_permission`
--

INSERT INTO `role_permission` (`role_id`, `permission_id`) VALUES
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(3, 2),
(3, 3),
(3, 4),
(3, 5),
(3, 6),
(3, 7),
(3, 8),
(3, 9),
(3, 10),
(3, 11),
(3, 12),
(3, 13),
(3, 14),
(3, 15),
(3, 16),
(3, 17),
(3, 18),
(3, 19),
(3, 20),
(3, 21),
(3, 22),
(3, 23),
(3, 24),
(3, 25),
(3, 26),
(3, 27),
(3, 28),
(3, 29),
(3, 30),
(28, 2),
(29, 11);



CREATE TABLE `discount` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `discount_percent` int(11) NOT NULL,
  `start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `quantity` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `end_time` timestamp NOT NULL DEFAULT '2038-01-01 00:00:00',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    name VARCHAR(255),
    phone VARCHAR(20),
    address TEXT,
    data_product JSON,  -- Lưu danh sách sản phẩm dưới dạng JSON
    discount_code VARCHAR(50),
    discount_percent INT,
    final_total INT,  
    free_of_charge INT,  
    payment_method ENUM('cod', 'online'),
    note TEXT,
    status ENUM('pending', 'processing', 'completed', 'canceled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO orders (user_id, name, phone, address, data_product, discount_code, discount_percent, final_total, free_of_charge, payment_method, status)
VALUES (17, 'home', '0325397255', 'nhà 40 hà nội', JSON_ARRAY(37, 36), 'QMCVYVGM', 20, 265200, 30000, 'cod', 'pending');


CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
CREATE TABLE `address` (
  `status` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
CREATE TABLE `address` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `address` VARCHAR(255) NOT NULL,
  `phone` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `user`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `address` (`user_id`, `name`, `address`, `phone`, `created_at`, `updated_at`) VALUES
(32, 'home', '123 Main St, City, Country', '1234567890', '2025-03-14 10:00:00', '2025-03-14 10:00:00');
--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `fullName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `fullName`, `email`, `avatar`, `password`, `role_id`, `status`, `created_at`, `updated_at`) VALUES
(3, 'Nguyễn Minh Thuận', 'thuan18092003@gmail.com', 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741501590/vjnmoh9gpo4mgdzabi5x.jpg', '$2y$10$StIjaXQgqcfafCqVwM2.G.OtuIdX605W93NpBDuUYVrIHaj.6TUGC', 3, 0, '2025-03-09 16:10:52', '2025-03-09 16:15:51'),
(16, 'admin1', 'admin@gmail.com', 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741501590/vjnmoh9gpo4mgdzabi5x.jpg', '$2y$10$OCZQbh7fL0gQuJ9C.5.tEuCudPUpZxoDEw2AFfU4HI7oldv34BDf6', 29, 0, '2025-03-09 22:50:47', '2025-03-11 04:49:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blacklisted_tokens`
--
ALTER TABLE `blacklisted_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `layout_benefit`
--
ALTER TABLE `layout_benefit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `layout_contactsfooter`
--
ALTER TABLE `layout_contactsfooter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `layout_customer_choose_item_section`
--
ALTER TABLE `layout_customer_choose_item_section`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `layout_customer_section`
--
ALTER TABLE `layout_customer_section`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `layout_navigation_menu`
--
ALTER TABLE `layout_navigation_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `layout_ordering_process`
--
ALTER TABLE `layout_ordering_process`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `layout_slide_header`
--
ALTER TABLE `layout_slide_header`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `layout_social_media_links`
--
ALTER TABLE `layout_social_media_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_permission`
--
ALTER TABLE `role_permission`
  ADD PRIMARY KEY (`role_id`,`permission_id`),
  ADD KEY `fk_role_permission_permission` (`permission_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_user_role` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blacklisted_tokens`
--
ALTER TABLE `blacklisted_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `layout_benefit`
--
ALTER TABLE `layout_benefit`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `layout_contactsfooter`
--
ALTER TABLE `layout_contactsfooter`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `layout_customer_choose_item_section`
--
ALTER TABLE `layout_customer_choose_item_section`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `layout_customer_section`
--
ALTER TABLE `layout_customer_section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `layout_navigation_menu`
--
ALTER TABLE `layout_navigation_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `layout_ordering_process`
--
ALTER TABLE `layout_ordering_process`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `layout_slide_header`
--
ALTER TABLE `layout_slide_header`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `layout_social_media_links`
--
ALTER TABLE `layout_social_media_links`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `permission`
--
ALTER TABLE `permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_permission`
--
ALTER TABLE `role_permission`
  ADD CONSTRAINT `fk_role_permission_permission` FOREIGN KEY (`permission_id`) REFERENCES `permission` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_role_permission_role` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_role` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
