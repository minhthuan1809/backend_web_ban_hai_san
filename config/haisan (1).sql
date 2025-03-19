-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 19, 2025 lúc 05:01 AM
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
-- Cấu trúc bảng cho bảng `address`
--

CREATE TABLE `address` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `address`
--

INSERT INTO `address` (`id`, `user_id`, `name`, `address`, `phone`, `created_at`, `updated_at`) VALUES
(4, 23, 'Nhà', 'Nhà 41 ngõ 12 Thanh Xuân', '0325475384', '2025-03-16 07:29:31', '2025-03-16 07:29:31'),
(5, 24, 'nahf', 'dsfg', '32423423423', '2025-03-16 07:41:53', '2025-03-16 07:41:53');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `blacklisted_tokens`
--

CREATE TABLE `blacklisted_tokens` (
  `id` int(11) NOT NULL,
  `token` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `blacklisted_tokens`
--

INSERT INTO `blacklisted_tokens` (`id`, `token`, `created_at`) VALUES
(54, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjozLCJlbWFpbCI6InRodWFuMTgwOTIwMDNAZ21haWwuY29tIiwiaWF0IjoxNzQyMzQ1NDg4LCJleHAiOjE3NDIzNjcwODh9.HZlSU6jvWJimsKGo0tW_97I4dxdmnCIY8k3ZSdObrsM', '2025-03-19 03:24:07'),
(55, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoyMywiZW1haWwiOiIwMy5udGFuaEBnbWFpbC5jb20iLCJpYXQiOjE3NDIzNTQ2NTgsImV4cCI6MTc0MjM3NjI1OH0.afgRM1agNBf63q5gqzmoiqlG1JXy4j-M3Ew6M3BjfzU', '2025-03-19 03:24:46'),
(56, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjozLCJlbWFpbCI6InRodWFuMTgwOTIwMDNAZ21haWwuY29tIiwiaWF0IjoxNzQyMzU0Njk3LCJleHAiOjE3NDIzNzYyOTd9.15dMhnY_jYhhqH17kNGxT3Sqq1vinTo4v9b6fO7ffqE', '2025-03-19 03:32:49'),
(57, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjozLCJlbWFpbCI6InRodWFuMTgwOTIwMDNAZ21haWwuY29tIiwiaWF0IjoxNzQyMzU2NjUyLCJleHAiOjE3NDIzNzgyNTJ9.5bgauD48hfZy9aMgnwPBzK_1mTa7i38aeVNiJWq7LBk', '2025-03-19 03:58:36');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(2, 'thuan   ', 'thuan', 'thuan18092003@gmail.com', 'thuan', 1, 0, '2025-03-10 04:59:49', '2025-03-10 05:01:13'),
(3, 'thuan   ', 'thuan', 'thuan18092003@gmail.com', 'thuan', 1, 0, '2025-03-10 05:16:34', '2025-03-10 07:01:27'),
(4, 'Nguyễn Minh Thuận', 'hàng ngon mỗi tội không cho nước chấm ', 'thuan18092003@gmail.com', 'mua hàng', 1, 0, '2025-03-11 04:48:09', '2025-03-11 04:48:49');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `discount`
--

CREATE TABLE `discount` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `discount_percent` int(11) NOT NULL,
  `start_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `quantity` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `end_time` timestamp NOT NULL DEFAULT '2037-12-31 17:00:00',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `discount`
--

INSERT INTO `discount` (`id`, `name`, `code`, `discount_percent`, `start_time`, `quantity`, `status`, `end_time`, `created_at`, `updated_at`) VALUES
(10, 'Giảm giá 20%', 'UAQOTBXA', 20, '2025-02-28 17:00:00', 999, 1, '2025-04-29 17:00:00', '2025-03-18 06:47:50', '2025-03-19 01:22:06'),
(12, 'Giảm giá 10%', 'GROCOBWH', 20, '2025-02-28 17:00:00', 8, 1, '2025-03-30 17:00:00', '2025-03-18 08:56:30', '2025-03-19 00:59:32');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `discount_history`
--

CREATE TABLE `discount_history` (
  `id` int(11) NOT NULL,
  `discount_id` int(11) NOT NULL,
  `order_history_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `discount_history`
--

INSERT INTO `discount_history` (`id`, `discount_id`, `order_history_id`, `created_at`, `updated_at`) VALUES
(7, 10, 52, '2025-03-18 06:55:53', '2025-03-18 06:55:53'),
(9, 10, 54, '2025-03-18 07:01:31', '2025-03-18 07:01:31'),
(11, 12, 55, '2025-03-19 00:47:16', '2025-03-19 00:47:16'),
(13, 12, 58, '2025-03-19 00:59:37', '2025-03-19 00:59:37'),
(15, 10, 59, '2025-03-19 01:22:28', '2025-03-19 01:22:28');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `email_history`
--

CREATE TABLE `email_history` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `gmail` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `history_orders`
--

CREATE TABLE `history_orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `data_product` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data_product`)),
  `discount_code` varchar(50) DEFAULT NULL,
  `discount_percent` int(11) DEFAULT NULL,
  `final_total` int(11) DEFAULT NULL,
  `free_of_charge` int(11) DEFAULT NULL,
  `payment_method` enum('cod','bank') DEFAULT NULL,
  `note` text DEFAULT NULL,
  `status` enum('completed','canceled') DEFAULT 'completed',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `reason` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `history_orders`
--

INSERT INTO `history_orders` (`id`, `user_id`, `name`, `phone`, `address`, `data_product`, `discount_code`, `discount_percent`, `final_total`, `free_of_charge`, `payment_method`, `note`, `status`, `created_at`, `updated_at`, `reason`) VALUES
(46, 23, 'Nhà', '0325475384', 'Nhà 41 ngõ 12 Thanh Xuân', '[{\"product_id\":36,\"quantity\":\"5\"},{\"product_id\":38,\"quantity\":\"2\"},{\"product_id\":39,\"quantity\":\"1\"},{\"product_id\":35,\"quantity\":\"6\"},{\"product_id\":34,\"quantity\":\"6\"},{\"product_id\":33,\"quantity\":\"8\"},{\"product_id\":30,\"quantity\":\"6\"},{\"product_id\":41,\"quantity\":\"6\"}]', '', 0, 23429000, 30000, 'cod', '', 'canceled', '2025-03-18 05:11:11', '2025-03-18 05:11:11', 'thuan'),
(47, 23, 'Nhà', '0325475384', 'Nhà 41 ngõ 12 Thanh Xuân', '[{\"product_id\":40,\"quantity\":\"2\"}]', '', 0, 520000, 30000, 'cod', 'ád', 'canceled', '2025-03-18 05:23:54', '2025-03-18 05:23:54', 'thuan'),
(48, 23, 'Nhà', '0325475384', 'Nhà 41 ngõ 12 Thanh Xuân', '[{\"product_id\":40,\"quantity\":\"1\"}]', '', 0, 275000, 30000, 'cod', '', 'canceled', '2025-03-18 05:26:42', '2025-03-18 05:26:42', 'không muốn mua nữa'),
(49, 23, 'Nhà', '0325475384', 'Nhà 41 ngõ 12 Thanh Xuân', '[{\"product_id\":36,\"quantity\":\"3\"}]', '', 0, 690000, 30000, 'cod', '', 'completed', '2025-03-18 05:27:07', '2025-03-18 05:27:07', NULL),
(50, 23, 'Nhà', '0325475384', 'Nhà 41 ngõ 12 Thanh Xuân', '[{\"product_id\":40,\"quantity\":\"1\"}]', 'QMCVYVGM', 20, 226000, 30000, 'cod', '', 'completed', '2025-03-18 06:44:41', '2025-03-18 06:44:41', NULL),
(51, 23, 'Nhà', '0325475384', 'Nhà 41 ngõ 12 Thanh Xuân', '[{\"product_id\":40,\"quantity\":\"1\"}]', 'UAQOTBXA', 30, 201500, 30000, 'cod', '', 'canceled', '2025-03-18 06:53:06', '2025-03-18 06:53:06', NULL),
(52, 23, 'Nhà', '0325475384', 'Nhà 41 ngõ 12 Thanh Xuân', '[{\"product_id\":41,\"quantity\":\"4\"}]', 'UAQOTBXA', 30, 223200, 30000, 'cod', '', 'completed', '2025-03-18 06:55:53', '2025-03-18 06:55:53', NULL),
(53, 23, 'Nhà', '0325475384', 'Nhà 41 ngõ 12 Thanh Xuân', '[{\"product_id\":29,\"quantity\":\"1\"},{\"product_id\":30,\"quantity\":\"3\"},{\"product_id\":31,\"quantity\":\"3\"},{\"product_id\":35,\"quantity\":\"5\"},{\"product_id\":34,\"quantity\":\"8\"},{\"product_id\":40,\"quantity\":\"5\"}]', '', 0, 11226000, 30000, 'cod', '', 'completed', '2025-03-18 06:55:54', '2025-03-18 06:55:54', NULL),
(54, 23, 'Nhà', '0325475384', 'Nhà 41 ngõ 12 Thanh Xuân', '[{\"product_id\":41,\"quantity\":\"2\"},{\"product_id\":42,\"quantity\":\"3\"}]', 'UAQOTBXA', 30, 250500, 30000, 'cod', '', 'completed', '2025-03-18 07:01:31', '2025-03-18 07:01:31', NULL),
(55, 24, 'nahf', '32423423423', 'dsfg', '[{\"product_id\":35,\"quantity\":\"1\"},{\"product_id\":43,\"quantity\":\"1\"},{\"product_id\":38,\"quantity\":\"2\"},{\"product_id\":40,\"quantity\":\"2\"},{\"product_id\":29,\"quantity\":\"2\"},{\"product_id\":41,\"quantity\":\"2\"},{\"product_id\":42,\"quantity\":\"2\"},{\"product_id\":37,\"quantity\":\"1\"}]', 'GROCOBWH', 20, 6736400, 30000, 'cod', '', 'completed', '2025-03-19 00:47:16', '2025-03-19 00:47:16', NULL),
(56, 24, 'nahf', '32423423423', 'dsfg', '[{\"product_id\":41,\"quantity\":\"1\"}]', '', 0, 99000, 30000, 'cod', '', 'completed', '2025-03-19 00:47:17', '2025-03-19 00:47:17', NULL),
(57, 24, 'nahf', '32423423423', 'dsfg', '[{\"product_id\":42,\"quantity\":\"1\"},{\"product_id\":41,\"quantity\":\"1\"}]', '', 0, 158000, 30000, 'bank', '', 'completed', '2025-03-19 00:58:18', '2025-03-19 00:58:18', NULL),
(58, 24, 'nahf', '32423423423', 'dsfg', '[{\"product_id\":42,\"quantity\":\"1\"},{\"product_id\":41,\"quantity\":\"1\"}]', 'GROCOBWH', 20, 132400, 30000, 'cod', '', 'completed', '2025-03-19 00:59:37', '2025-03-19 00:59:37', NULL),
(59, 24, 'nahf', '32423423423', 'dsfg', '[{\"product_id\":43,\"quantity\":\"1\"},{\"product_id\":42,\"quantity\":\"1\"},{\"product_id\":41,\"quantity\":\"1\"},{\"product_id\":40,\"quantity\":\"1\"},{\"product_id\":36,\"quantity\":\"1\"},{\"product_id\":37,\"quantity\":\"1\"},{\"product_id\":38,\"quantity\":\"1\"},{\"product_id\":39,\"quantity\":\"1\"},{\"product_id\":35,\"quantity\":\"1\"},{\"product_id\":34,\"quantity\":\"1\"},{\"product_id\":33,\"quantity\":\"1\"},{\"product_id\":32,\"quantity\":\"1\"},{\"product_id\":29,\"quantity\":\"1\"},{\"product_id\":30,\"quantity\":\"1\"},{\"product_id\":31,\"quantity\":\"1\"}]', 'UAQOTBXA', 20, 8349200, 30000, 'bank', '', 'completed', '2025-03-19 01:22:28', '2025-03-19 01:22:28', NULL),
(60, 23, 'Nhà', '0325475384', 'Nhà 41 ngõ 12 Thanh Xuân', '[{\"product_id\":40,\"quantity\":\"2\"}]', '', 0, 520000, 30000, 'cod', '', 'completed', '2025-03-19 03:25:42', '2025-03-19 03:25:42', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `layout_ads`
--

CREATE TABLE `layout_ads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image_url` longtext NOT NULL,
  `mobile_image_url` longtext DEFAULT NULL,
  `title` varchar(255) DEFAULT '',
  `is_active` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `layout_ads`
--

INSERT INTO `layout_ads` (`id`, `image_url`, `mobile_image_url`, `title`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1742198459/bwj4xvppc8j8ynblttib.webp', NULL, 'quảng cáo 1', 1, '2025-03-17 08:01:00', '2025-03-17 12:01:20'),
(3, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1742212874/co44lim7wtjtbwxdlxxm.jpg', NULL, 'quảng cáo 2', 1, '2025-03-17 12:01:14', '2025-03-17 12:01:14'),
(4, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1742212950/urc7yuzg38ps9owjolap.webp', NULL, 'quảng cáo 3', 1, '2025-03-17 12:02:30', '2025-03-17 12:02:30');

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
(1, 'ShoppingBag', 'Chất Lượng ', 'Cam kết sử dụng hải sản tươi sống 100%', '2025-03-03 16:48:42', '2025-03-09 16:20:10'),
(2, 'Target', 'Đa Dạng', 'Thực đơn phong phú với hơn 100 món ăn', '2025-03-03 16:48:42', '2025-03-05 07:30:04'),
(4, 'ThumbsUp', 'Uy Tín', '20 năm kinh nghiệm phục vụ', '2025-03-03 16:48:42', '2025-03-03 16:48:42'),
(10, 'Server', 'Phục Vụ', 'Đội ngũ nhân viên chuyên nghiệp, thân thiện', '2025-03-05 07:09:55', '2025-03-05 07:09:55');

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
(1, 'Cam Kết Của Chúng Tôi ', 'Đảm bảo chất lượng món ăn từ nhà hàng ', 'Giao hàng đúng giờ, đúng địa chỉ', 'Đổi trả miễn phí nếu món ăn không đúng yêu cầu', 'Nhân viên giao hàng chuyên nghiệp, thân thiện', '2025-03-03 23:45:43', '2025-03-10 04:48:09');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `layout_contactsfooter`
--

CREATE TABLE `layout_contactsfooter` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `icon` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `layout_contactsfooter`
--

INSERT INTO `layout_contactsfooter` (`id`, `icon`, `type`, `created_at`, `updated_at`) VALUES
(1, 'Map', '123 Đường ABC, Quận XYZ', '2025-02-22 22:01:47', '2025-03-09 16:02:52'),
(2, 'Phone', '(123) 456-7890', '2025-02-22 22:01:47', '2025-02-22 22:01:47'),
(3, 'Mail', 'info@example.com', '2025-02-22 22:01:47', '2025-02-22 22:01:47'),
(4, 'CalendarCheck2', 'Thứ 2 - Thứ 5: 11:00 - 22:00; Thứ 6 - Chủ Nhật: 11:00 - 23:00', '2025-02-22 22:01:47', '2025-02-22 22:01:47');

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
(2, 'Utensils', 'Duy trì hương vị và chất lượng ', 'thực phẩm ngon nhất '),
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
(1, 'Đây là lý do khách hàng thường chọn chúng tôi ', 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741669336/efkmzxfkbubimvqab44l.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `layout_customer_section`
--

CREATE TABLE `layout_customer_section` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image_url` longtext NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `layout_customer_section`
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
(1, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741669296/ko7hwee0xeyudqnskodx.webp', 'Khách hàng nói về chùng tôi ');

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
(1, 'Giới thiệu ', 'Là một nhà hàng sang trọng với không gian ấm cúng và phong cách hiện đại. Chúng tôi phục vụ các món ăn đặc sắc được chế biến từ những nguyên liệu tươi ngon nhất cùng đồ uống chất lượng cao.', '2025-02-23 05:01:47', '2025-03-10 04:04:48');

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
(1, 'Minh Thuận', 'Nhà hàng hải sản Minh Thuận là điểm đến lý tưởng cho những tín đồ yêu thích hải sản tươi sống. Tọa lạc ngay sát bờ biển Bình Thuận, Minh Thuận tự hào mang đến nguồn hải sản tươi ngon nhất, được đánh bắt trực tiếp mỗi ngày. Với hơn 50 loại hải sản phong phú, chế biến theo công thức đặc biệt, chúng tôi mang đến những món ăn thơm ngon, đậm đà hương vị biển cả, khiến thực khách nhớ mãi không quên.', 'Tận hưởng hải sản chất lượng mà không phải lo về giá cả. Chúng tôi cam kết mang đến những sản phẩm tươi sạch, an toàn với mức giá hợp lý, cùng dịch vụ tận tâm.', 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741669356/mcoywgpg6ixhteapp7uq.jpg');

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
(14, 'Sản Phẩm', '/products', NULL, 2, 0, 1),
(15, 'Liên hệ', '/contact', NULL, 4, 0, 1),
(16, 'Giới thiệu', '/about', NULL, 3, 0, 1),
(22, 'Tin Tức', '/news', NULL, 5, 0, 1);

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
(1, 'Truck', 'Giao Hàng Tận Nơi', ' Phạm vi giao hàng: 10km từ nhà hàng', 'Thời gian giao hàng: 30-45 phút', 'Đóng gói cẩn thận, giữ nhiệt tốt', 'Miễn phí giao hàng cho đơn từ 500.000đ', '2025-03-03 23:42:46', '2025-03-10 04:43:45'),
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
(1, 'ShoppingBag', 'Chọn món', 'Dễ dàng đặt hàng qua website hoặc gọi điện trực tiếp', '2025-03-03 16:31:02', '2025-03-03 16:31:02'),
(2, 'CreditCard', 'Thanh Toán', 'Đa dạng phương thức thanh toán: tiền mặt, chuyển khoản, ví điện tử', '2025-03-03 16:31:02', '2025-03-03 16:31:02'),
(3, 'Truck', 'Giao Hàng', 'Giao hàng nhanh chóng, đảm bảo chất lượng món ăn', '2025-03-03 16:31:02', '2025-03-03 16:31:02');

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
(2, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741669032/dph9ofthzvznzimuwy2v.jpg', 'MINH THUẬN ', 'Chào mừng bạn đến với nhà hàng của chúng tôi !'),
(3, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741669043/mug3rqyluk84nq1gqwa4.jpg', 'Hải Sản Minh Thuận ', 'Chào mừng bạn đến với nhà hàng của chúng tôi !'),
(10, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741669403/jpvwpp9rl9rxnditeuq8.jpg', 'MINH THUẬN', 'Chào mừng bạn đến với nhà hàng của chúng tôi !');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `layout_social_media_links`
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
-- Đang đổ dữ liệu cho bảng `layout_social_media_links`
--

INSERT INTO `layout_social_media_links` (`id`, `platform`, `url`, `target`, `created_at`, `updated_at`) VALUES
(1, 'Facebook', 'https://facebook.com/minhthuan', '_blank', '2025-02-22 15:01:47', '2025-03-10 04:48:40'),
(2, 'Instagram', 'https://instagram.com/minhthuan', '_blank', '2025-02-22 15:01:47', '2025-02-22 15:01:47'),
(3, 'Youtube', 'https://youtube.com/minhthuan', '_blank', '2025-02-22 15:01:47', '2025-02-22 15:01:47');

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
(3, 'ChefHat', 'Khu Vực Bếp Chuyên Nghiệp ', 'Nhân viên bếp được đào tạo bài bản', 'Trang thiết bị hiện đại, đảm bảo vệ sinh an toàn thực phẩm', 'Khu vực sơ chế và chế biến thực phẩm', 'Hệ thống làm mát và thông gió đạt chuẩn', '2025-03-05 11:49:57', '2025-03-10 03:16:45'),
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
(1, 'Câu Chuyện Của Chúng Tôi', 'Nhà hàng Hải Sản Minh Thuận được thành lập từ năm 2003, khởi đầu là một quán ăn nhỏ với tâm huyết mang đến những món hải sản tươi ngon nhất cho thực khách. Qua hơn 20 năm phát triển, chúng tôi đã trở thành một trong những nhà hàng hải sản uy tín nhất trong khu vực.', 'Với sự phát triển của công nghệ, chúng tôi đã mở rộng dịch vụ sang mảng đặt hàng trực tuyến và giao hàng tận nơi, giúp thực khách có thể thưởng thức các món ăn ngon của nhà hàng ngay tại nhà.', '2025-03-03 23:09:07', '2025-03-12 06:00:55');

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
(1, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741760619/xqbnpja3oyl5hirtozfg.png', 'Cá Xanh ', 'hải sản');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `news`
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
-- Đang đổ dữ liệu cho bảng `news`
--

INSERT INTO `news` (`id`, `title`, `description`, `image_url`, `status`, `created_at`, `updated_at`) VALUES
(29, 'CHÀO MỪNG NGÀY 30/4 & 1/5', '<h1>🎉 CHÀO MỪNG ĐẠI LỄ 30/4 &amp; 1/5 – THƯỞNG THỨC HẢI SẢN TƯƠI NGON CÙNG HẢI SẢN MINH THUẬN! 🦀🐟</h1><p>Tháng Tư lịch sử lại về, đánh dấu một trong những cột mốc quan trọng nhất của dân tộc – <strong>Ngày Giải phóng miền Nam, thống nhất đất nước (30/4/1975)</strong>. Đây không chỉ là dịp để nhìn lại trang sử hào hùng của dân tộc mà còn là thời gian để sum họp, quây quần bên gia đình, cùng nhau tận hưởng những phút giây thư giãn và những bữa ăn ngon.</p><p>Ngay sau đó là <strong>Ngày Quốc tế Lao động 1/5</strong>, ngày tôn vinh những người lao động, những con người cống hiến hết mình vì sự phát triển của xã hội. Đây là dịp nghỉ lễ tuyệt vời để bạn tự thưởng cho bản thân và gia đình những món ăn ngon, bổ dưỡng, nạp lại năng lượng sau những ngày làm việc vất vả.</p><p>💖 <strong>Hãy để Hải Sản Minh Thuận mang đến cho bạn và gia đình những món ăn tươi ngon, chất lượng nhất trong kỳ nghỉ này!</strong><br>🦐 HẢI SẢN TƯƠI NGON – LỰA CHỌN HOÀN HẢO CHO KỲ NGHỈ LỄ</p><p>🎊 Dịp lễ dài ngày chính là thời điểm lý tưởng để tổ chức những bữa tiệc sum vầy, từ những bữa ăn ấm cúng bên gia đình đến những buổi liên hoan cùng bạn bè.</p><p>👉 Còn gì tuyệt vời hơn khi <strong>cả nhà quây quần bên nồi lẩu hải sản nóng hổi</strong>, hay cùng nhau thưởng thức <strong>những món nướng thơm lừng từ tôm, cua, ghẹ, cá nướng</strong>?</p><p>🎉 <strong>Hải Sản Minh Thuận tự hào mang đến những sản phẩm chất lượng cao, tươi sống 100%, được đánh bắt trực tiếp từ biển khơi và bảo quản theo tiêu chuẩn nghiêm ngặt.</strong></p><p>🌊 <strong>DANH MỤC HẢI SẢN ĐƯỢC ƯA CHUỘNG NHẤT TẠI MINH THUẬN</strong> 🌊</p><p>✅ <strong>Tôm hùm, tôm càng xanh, tôm sú</strong> – thịt chắc, vị ngọt tự nhiên<br>✅ <strong>Cua biển, ghẹ xanh, ghẹ thịt</strong> – giàu dinh dưỡng, chắc thịt<br>✅ <strong>Hàu sữa, sò điệp, nghêu, ốc hương</strong> – béo ngậy, thơm ngon<br>✅ <strong>Mực trứng, mực lá, bạch tuộc, cá hồi, cá mú</strong> – tươi ngon, phù hợp mọi cách chế biến<br>✅ <strong>Combo hải sản lẩu &amp; nướng</strong> – tiện lợi, sẵn sàng chế biến ngay</p><p>🔥 <strong>CAM KẾT CHẤT LƯỢNG</strong> 🔥<br>✔️ Hải sản tươi sống 100% – đảm bảo độ tươi ngon, không chất bảo quản<br>✔️ Quy trình bảo quản nghiêm ngặt – giữ trọn vị tươi ngon của biển cả<br>✔️ Giao hàng tận nơi, nhanh chóng trong vòng <strong>2 giờ</strong><br>✔️ <strong>Hoàn tiền 100% nếu sản phẩm không đạt chất lượng</strong></p><hr><h2>🎁 ƯU ĐÃI CỰC HẤP DẪN NHÂN DỊP 30/4 &amp; 1/5 🎁</h2><p>🎊 <strong>GIẢM NGAY 10%</strong> cho đơn hàng từ <strong>500K</strong><br>🎊 <strong>TẶNG 1 PHẦN NƯỚC CHẤM HẢI SẢN ĐẶC BIỆT</strong> cho đơn từ <strong>300K</strong><br>🎊 <strong>MUA 1KG TÔM – TẶNG 200GR HÀU SỮA</strong> cho đơn hàng từ <strong>600K</strong><br>🎊 <strong>MIỄN PHÍ VẬN CHUYỂN NỘI THÀNH</strong> cho đơn từ <strong>300K</strong></p><p>📅 <strong>Chương trình khuyến mãi áp dụng từ ngày 28/4 – 2/5</strong>. Hãy nhanh tay đặt hàng để tận hưởng những ưu đãi hấp dẫn!</p><hr><h2>🍽️ GỢI Ý NHỮNG MÓN HẢI SẢN NGON TUYỆT CHO KỲ NGHỈ LỄ</h2><p>🎯 <strong>Lẩu hải sản thập cẩm</strong> – nước dùng chua cay đậm đà, kết hợp hải sản tươi ngon và rau xanh tạo nên hương vị hoàn hảo.<br>🎯 <strong>Tôm hùm nướng bơ tỏi</strong> – vị béo ngậy của bơ kết hợp với tôm hùm chắc thịt, thơm lừng khó cưỡng.<br>🎯 <strong>Ghẹ hấp bia</strong> – giữ nguyên vị ngọt tự nhiên của ghẹ, kết hợp với bia tạo nên món ăn hấp dẫn.<br>🎯 <strong>Mực nướng sa tế</strong> – cay nồng, giòn sật, hoàn hảo cho những buổi tụ họp cùng bạn bè.<br>🎯 <strong>Cá hồi sốt cam</strong> – bổ dưỡng, thơm ngon, phù hợp cho mọi thành viên trong gia đình.</p><p>💡 <strong>Không có thời gian nấu nướng?</strong> Đừng lo! <strong>Hải Sản Minh Thuận cung cấp dịch vụ sơ chế và chế biến theo yêu cầu</strong>, giúp bạn tiết kiệm thời gian nhưng vẫn có bữa ăn ngon đúng chuẩn nhà hàng!</p><hr><h2>📌 ĐẶT HÀNG NHANH CHÓNG – GIAO HÀNG TẬN NƠI</h2><p>🔹 <strong>Chỉ cần nhấc máy lên và gọi</strong>, đội ngũ Minh Thuận sẽ tư vấn tận tình, giúp bạn lựa chọn những sản phẩm phù hợp nhất!<br>🔹 <strong>Cam kết giao hàng nhanh trong vòng 2 giờ</strong>, đảm bảo hải sản tươi sống khi đến tay khách hàng.<br>🔹 <strong>Hoàn tiền 100% nếu sản phẩm không đạt yêu cầu</strong>, Minh Thuận luôn đặt chất lượng lên hàng đầu!</p><p>📞 <strong>Hotline/Zalo:</strong> 093xxx6789<br>🌐 <strong>Website:</strong> haisan.minhthuan.site</p><p>🎊 <strong>ĐẶT HÀNG NGAY ĐỂ NHẬN ƯU ĐÃI CỰC HẤP DẪN!</strong> 🎊</p><p>💙 <strong>HẢI SẢN MINH THUẬN – TƯƠI NGON MỖI NGÀY, TRỌN VẸN HƯƠNG VỊ BIỂN CẢ!</strong> 🦐🐠🦀</p>', 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1742294067/sqedcaadlyqxlahygetj.jpg', 1, '2025-03-01 08:33:42', '2025-03-01 08:33:42'),
(31, 'Mừng Ngày Quốc tế Phụ nữ 8/3', '<p><strong>Mừng Ngày Quốc tế Phụ nữ 8/3 - Giảm ngay 10% cho tất cả hải sản tươi sống!</strong></p><p>Chào mừng Ngày Quốc tế Phụ nữ 8/3, hải sản Minh Thuận<strong> </strong>gửi đến các chị em món quà đặc biệt – chương trình khuyến mãi hấp dẫn giảm ngay <strong>10%</strong> cho tất cả các mặt hàng <strong>hải sản tươi sống</strong>! Đây là cơ hội tuyệt vời để bạn và gia đình thưởng thức những món ăn ngon, bổ dưỡng với mức giá ưu đãi nhất.<br>Nhập ngày : \"<strong>GROCOBWH\"</strong></p><p>🎉 <strong>Thời gian áp dụng:</strong> Từ ngày <strong>05/03</strong> đến hết ngày <strong>20/03</strong> 🎉 <strong>Sản phẩm áp dụng:</strong> Tất cả các mặt hàng hải sản tươi sống như <strong>tôm, cua, ghẹ, mực, cá, sò điệp…</strong> 🎉 <strong>Hình thức ưu đãi:</strong> Giảm trực tiếp <strong>10%</strong> trên hóa đơn</p><p>💝 <strong>Lời tri ân đến một nửa thế giới</strong> 💝 Ngày Quốc tế Phụ nữ là dịp để tôn vinh và tri ân những người phụ nữ tuyệt vời trong cuộc sống của chúng ta. Nhân dịp này, GROCOBWH mong muốn mang đến những món ăn ngon, tươi sạch giúp bữa cơm gia đình thêm tròn vị, ấm áp.</p><p>📌 <strong>Đừng bỏ lỡ cơ hội này!</strong> Hãy đến ngay cửa hàng hoặc đặt hàng online để tận hưởng ưu đãi đặc biệt dành riêng cho phái đẹp.</p><p>📍 <strong>Địa chỉ:</strong> [Thêm địa chỉ cửa hàng] 📞 <strong>Hotline:</strong> [Thêm số liên hệ] 🌐 <strong>Website:</strong> [Thêm website nếu có]</p><p>Hãy nhanh tay đặt hàng và dành tặng những người phụ nữ thân yêu của bạn một bữa ăn ngon lành và ý nghĩa nhé! 💖</p>', 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1742289198/zcakjrgwfs614thzxkzh.jpg', 1, '2025-03-10 03:07:43', '2025-03-10 03:07:43');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `data_product` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data_product`)),
  `discount_code` varchar(50) DEFAULT NULL,
  `discount_percent` int(11) DEFAULT NULL,
  `final_total` int(11) DEFAULT NULL,
  `free_of_charge` int(11) DEFAULT NULL,
  `payment_method` enum('cod','bank') DEFAULT NULL,
  `note` text DEFAULT NULL,
  `status` enum('pending','processing','completed','canceled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `discount_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `permission`
--

CREATE TABLE `permission` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `permission`
--

INSERT INTO `permission` (`id`, `name`) VALUES
(2, 'get_user'),
(3, 'post_user'),
(4, 'put_user'),
(5, 'delete_user'),
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
(38, 'delete_order'),
(39, 'get_discount'),
(40, 'post_discount'),
(41, 'put_discount'),
(42, 'delete_discount'),
(43, 'get_stats');

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
(29, 'Tôm Hùm Alaska Nhỏ', '<p>So với các loại tôm hùm nội ngoại địa khác thì tôm hùm Alaska baby size nhỏ đang được Đảo Hải Sản nhập khẩu về, đây là dòng sản phẩm được ưa chuộng nhất hiện nay tại Tp Hồ Chí Minh và các tỉnh lân cận. Nếu chúng ta so sánh giá trong tầm 2.000.000đ ngoài những sản phẩm tôm hùm Việt Nam ra thì khách hàng còn có sự lựa chọn tôm hùm alaska size 450gr - 520gr</p><p><br><strong>Giới thiệu Tôm Hùm Alaska Nhỏ tại ĐẢO HẢI SẢN</strong></p><p>Những bãi đá ngầm, san hô, nước ở đáy trong xanh, rất lạnh là nơi sinh s.ống lý tưởng của tôm hùm Alaska.&nbsp;Tôm hùm Alaska được Đảo Hải Sản nhập theo đúng quy trình đảm bảo tôm hùm luôn sống khỏe.<br><br><strong>Tôm hùm Alaska 500g &nbsp;có giá bao nhiêu?</strong></p><p>Do nhu cầu sử dụng loại hải sản cao cấp này của khách hàng ngày càng tăng cao nên trên thị trường hiện nay có rất nhiều địa chỉ bán tôm hùm Alaska. Đồng thời tuỳ vào thời điểm, mùa vụ của tôm hùm Alaska size nhỏ nên giá của chúng sẽ khác nhau. Hiện tại giá đã được cập nhật trực tiếp trên sản phẩm bạn có thể thêm vào giỏ hàng ngay nhé!<br><strong>Tôm hùm Alaska size nhỏ được bao nhiêu con 1kg?</strong></p><p>Thường tôm hùm Alaska size nhỏ tại Đảo Hải Sản chúng tôi sẽ chọn những tôm hùm alaska có size 500g 1 con tương đương với 2 con cho 1kg. Size này chúng tôi thấy phù hợp với gia đình 2 - 3 người dùng.<br><strong>Giá trị dinh dưỡng</strong></p><p>Tôm hùm Alaska được quy định đánh bắt đúng kích thước, trọng lương nên tôm ở đây phát triển to. Đến lúc đánh bắt thì tôm đã trưởng thành nên thịt tôm săn chắc, giòn ngọt theo từng khối và rất thơm ngon. Thịt tôm Hùm Alaska nổi tiếng giàu dinh dưỡng, canxi thích hợp với người già, trẻ em hay người cần bổ sung chất dinh dưỡng.<br><strong>Mua tôm hùm Alaska 500g ở đâu tươi ngon?</strong></p><p>Nhu cầu sử dụng tôm hùm alaska 500g ngày càng tăng chính vì có có rất nhiều cơ sở kinh doanh tôm hùm size nhỏ. Tại Đảo Hải Sản tôm hùm alaska size nhỏ được nuôi tại cửa hàng dưới những tư vấn kỹ thuật nuôi, tạo môi trường s.ống như tự nhiên bởi các chuyên gia. Chính vì thế những sản phẩm tôm hùm Alaska nhỏ khi nhận hàng là sản phẩm tươi s.ống.</p><p></p>', 599000, 110, 9890, 0, 0, 'shrimp', 0, '2025-03-14 09:31:03', '2025-03-19 01:22:28'),
(30, 'Tôm Hùm Bông Sống 500-700g/con', '<h2><strong>1. Giới thiệu Tôm Hùm Bông tại Đảo Hải Sản</strong></h2><p><strong>Tôm hùm bông&nbsp;</strong>là loại tôm hùm đặc sản nổi tiếng của vùng biển Cam Ranh. Sở dĩ với tên gọi là \"tôm hùm bông\" bởi vì thân hình tôm hùm này có những đường nét, họa tiết đốm hoa văn.</p><p>Hiện nay trên thị trường có rất nhiều nơi bán tôm hùm bông. Nhưng để tìm thấy được nơi bán tôm hùm bông chất lượng mà giá cả lại phải chăng thì không hề dễ!</p><p>ĐẢO HẢI SẢN là nơi bạn có thể hoàn toàn yên tâm khi sử dụng tôm hùm bông của Đảo. Những chú tôm hùm bông được Đảo nhập trực tiếp từ Cam Ranh với quy trình vận chuyển tiêu chuẩn nên tôm hùm s.ống khỏe, đảm bảo chất lượng đến tay khách hàng.<br><strong>2. Giá trị dinh dưỡng của tôm hùm bông</strong></p><p><strong>Tôm hùm bông</strong> chứa axit béo Omega-3&nbsp;có hàm lượng canxi và đạm cao, rất phù hợp với những người có thể chất yếu cần bồi bổ thêm, đồng thời cũng có lợi với những trường hợp hay bị hạ đường huyết hay bị suy dĩnh dưỡng, huyết áp thấp. Với tôm hùm bạn có thể chế biến rất nhiều món ăn ngon, bắt mắt và cực kỳ hấp dẫn.</p><h2><strong>3. Tôm hùm bông nấu món gì ngon?</strong></h2><ul><li><p>Nướng phô mai :<strong> tôm hùm bông</strong> mua về chẻ đôi , chuẩn bị nước sốt phô mai bao gồm : bơ , pho mai, sữa tươi trộn đều rồi phết đều lên tôm . Khi nướng hương thơm lan tỏa, cắn 1 miếng.</p></li><li><p>Tôm hùm bông nướng than thơm ngon và hấp dẫn, từng sớ thịt săn chắc và nhai sần sật, ngọt béo hòa vào lẫn nhau, đậm đà hương vị biển.</p></li><li><p>Tôm hùm bông nấu cháo giàu dinh dưỡng, ăn nóng ăn ngon hơn. Khách mua về nấu ăn sáng hoặc ăn trước khi buổi cơm tối.</p></li></ul><p><br></p>', 745000, 11, 989, 0, 0, 'shrimp', 0, '2025-03-14 09:40:31', '2025-03-19 01:22:28'),
(31, 'Chả Ram Tôm Đất', '<p><span>Chả ram tôm đất là một trong những món ăn truyền thống của Việt Nam và cũng là đặc sản của vùng đất võ Quy Nhơn-Bình Định. Chả ram tôm đất Việt Nam còn được tạp chí CNN bình chọn là 1 trong 50 món ăn ngon nhất trên thế giới.</span></p><p><span>Sản phẩm \"Chả ram tôm đất\" của Đảo Hải Sản là một món ngon độc đáo mang hương vị tươi ngon và đặc trưng của Bình Định, Việt Nam. Sản phẩm này đã được ưa chuộng rộng rãi trong bữa ăn của nhiều gia đình. Hãy cùng Đảo Hải Sản tìm hiểu về sản phẩm này nhé!</span></p><p></p><p><span><em>Chả ram tôm đất Việt Nam còn được tạp chí CNN bình chọn</em></span></p><h2><span><strong>Nguồn gốc xuất xứ</strong></span></h2><p><span>Chất lượng bắt đầu từ nguồn gốc, Chả ram tôm đất Đảo Hải Sản không phải là ngoại lệ. Chả ram tôm đất Đảo Hải Sản, hay còn được gọi là chả giò tôm đất, một sản phẩm cho bữa ăn gia đình được ưa chuộng hiện nay.</span></p><p><span>Chả ram tôm đất Bình Định tại tphcm được Đảo Hải Sản nhập đông lạnh trực tiếp từ Bình Định, nơi nổi tiếng với nguồn nguyên liệu biển tươi ngon. Điều này đảm bảo rằng mỗi viên chả giò tôm đất mang trong mình hương vị tự nhiên và độ tươi ngon hoàn hảo nhất đến tay khách hàng.</span></p><h2><span><strong>Quy trình sản xuất chả ram tôm đất Đảo Hải Sản</strong></span></h2><p><span>Chả ram tôm đất Bình Định tại Đảo Hải Sản được nhập trực tiếp từ Bình Định - Việt Nam. Từ lúc hoàn thành khâu sản xuất, đóng gói vẫn luôn được bảo quản trong nhiệt độ -18 độ C, kể cả khi vận chuyển vào Sài Gòn nhằm đảm bảo chả ram tôm đất không bị hư tổn bởi thời tiết hay ảnh hưởng bởi các yếu tố bên ngoài.</span></p><p></p><p><span><em>Chả ram tôm đất Bình Định tại Đảo Hải Sản có gì đặc biệt</em></span></p><p><span>Chả ram Bình Định mà Đảo Hải Sản cung cấp và phân phối cho các thực khách rất dễ bảo quản, chất lượng rất khó để bị sụt giảm vì bao bì đóng gói có chất lượng rất cao, hơn nữa với công nghệ hiện đại và vật liệu sản xuất có chất lượng đã thỏa mãn được tiêu chí đóng gói khắt khe.</span></p><p></p><p><span><em>Chả ram Bình Định mà Đảo Hải Sản cung cấp và phân phối cho các thực khách rất dễ bảo quản</em></span></p><p><span>Miếng chả ram tôm đất tại ĐẢO, khi chiên lên giòn tan do lớp bánh tráng mỏng cuốn bên ngoài, bên trong là thịt tôm mọng nước, đậm vị mùi tôm, ngậy ngậy của thịt heo, làm cho thực khách ăn hoài mà vẫn không biết ngán. Hương vị hấp dẫn, cuốn hút khiến thực khách đặc biệt nghiện, lúc nào cũng mua thêm chả ram tôm đất này về nhà để dành thưởng thức.</span></p><p></p><p><span><em>Miếng chả ram tôm đất tại ĐẢO, khi chiên lên giòn tan</em></span></p><h2><span><strong>Giá trị dinh dưỡng của Chả ram Bình Định</strong></span></h2><p><span>Về mặt giá trị dinh dưỡng, chả ram Bình Định cung cấp cho chúng ta protein là chính, chủ yếu là protein đến từ tôm và thịt heo. Nếu bạn chưa biết thì protein là chất dinh dưỡng cung cấp năng lượng cho cơ thể, giúp tăng cường và bảo vệ cơ bắp và các mô tế bào của chúng ta.</span></p><p></p><p><span>Bên cạnh đó thì chả ram tôm đất còn cung cấp cho chúng ta chất béo. Chất béo mặc dù được khuyến cáo là nên tiêu thụ có định mức nhưng chúng cũng là chất cung cấp năng lượng hoạt động cho cơ thể của con người ta. Hơn nữa, chả ram còn cung cấp cho cơ thể chúng ta một lượng vitamin B12, vitamin B6 và khoáng chất như: sắt, kẽm, magie, cùng với một lượng nhỏ chất xơ mà cơ thể chúng ta cần.</span></p><h2><span><strong>Nguyên liệu chả ram tại Đảo Hải Sản</strong></span></h2><p><span>Nguyên liệu trong chả ram tại Đảo Hải Sản có: 80% tôm đất, 20% còn lại sẽ bao gồm: thịt heo, bánh tráng, hành, đường, bột ngọt, muối, tiêu và các gia vị khác.&nbsp;</span></p><p><span>Tôm đất chiếm phần lớn tỷ lệ nguyên liệu cho thấy rằng ĐẢO luôn lắng khách hàng khi nhận thấy phần lớn mọi người sẽ lựa chọn địa điểm kinh doanh các sản phẩm chất lượng cao có chứa thành phần chủ yếu hải sản tự nhiên như thịt tôm tươi.</span></p><p></p><p><span><em>Nguyên liệu chả ram tại Đảo Hải Sản</em></span></p><p><span>Bên cạnh đó, bánh tráng là lớp ngoài cùng dùng để cuốn, cố định các nguyên liệu thành phần bên trong và cũng dùng để tăng độ giòn cho chả ram được lấy chính gốc bánh tráng bình định. Điều này đã tạo nên sự đặc trưng cho món ăn này.&nbsp;</span></p><p><span>Thịt heo được dùng để tăng thêm vị ngậy, tăng một xíu độ béo cho chả. Cuối cùng là các gia vị nêm, dùng để cân bằng các nguyên liệu, để phù hợp với khẩu vị chung của quý thực khách để ai ai cũng có thể thưởng thức được.&nbsp;</span></p><h2><span><strong>Chả ram tôm đất giá bao nhiêu?</strong></span></h2><p><span>Trung bình ở Thành Phố Hồ Chí Minh thì 1 bịch chả ram trọng lượng 500g sẽ có giá giao động từ 100.000đ đến 200.000đ. Nhưng còn tùy vào size chả ram, thành phần, chất lượng mà sẽ có nhiều khung giá khác nhau.</span></p><p><span>Nếu bạn đang tìm mua Chả ram tôm tphcm chất lượng, an toàn VSTTP với xuất xứ rõ ràng, hãy truy cập ngay website daohaisan.vn hoặc liên hệ số 1900.0098 hoặc liên hệ trực tiếp qua fanpage để được nhân viên hỗ trợ và tư vấn nhiệt tình. Ở Đảo Hải Sản, đơn vị phân phối, cung cấp, bán lẻ hải sản hàng đầu, chả ram tôm đất đang có giá là 125,000 cho 500g, là giá thành hiện đang phải chăng nhất thị trường.</span></p><p><br></p>', 79000, 11, 9988, 0, 0, 'shrimp', 0, '2025-03-14 09:44:57', '2025-03-19 01:22:28'),
(32, 'Tôm Càng Xanh Sống', '<p><strong>Tôm Càng Xanh</strong> là một loài tôm biển thường được săn bắt để sử dụng làm thực phẩm. Loài tôm này được tìm thấy ở vùng biển nhiệt đới và cận nhiệt đới của Ấn Độ Dương và Thái Bình Dương.</p><p>Tôm Càng Xanh sở hữu thân hình hơi cong với lớp vỏ màu xanh nhạt. Loại tôm này có kích thước trung bình từ 20 đến 30cm, tuy nhiên có thể lên đến 40cm. Cặp càng lớn và mạnh mẽ ở phía trước cơ thể của loài tôm này được sử dụng để bảo vệ chúng khỏi các kẻ thù tự nhiên và săn mồi. Chúng thường sống trong hang động, hốc đá hoặc những vùng san hô, tạo ra môi trường sống và ẩn nấp cho chúng.&nbsp;</p><p></p><p><em>Tôm càng xanh tươi sống trong hồ của Đảo Hải Sản</em></p><p><strong>Tôm Càng Xanh</strong> Loại To là loại tôm có giá trị kinh tế cao được ưa chuộng trong việc chế biến món ăn tại nhiều nơi trên thế giới. Ngoài ra, giá trị dinh dưỡng mà loài tôm này mang lại vô cùng dồi dào, chúng chứa nhiều chất đạm, chất béo, các vitamin và khoáng chất quan trọng cho sức khỏe con người.&nbsp;</p><p></p><p><em>&nbsp;Tôm càng xanh to tươi sống chất lượng</em></p><p>Chất đạm của tôm giúp hỗ trợ tăng trưởng và phục hồi cơ bắp, cũng như giúp duy trì sự hoạt động của các tế bào. Ngoài ra, chất đạm còn giúp tăng cường hệ miễn dịch và hỗ trợ quá trình phục hồi sau chấn thương.&nbsp;</p><p>Chất béo trong <strong>Tôm Càng Xanh</strong> cung cấp năng lượng cho cơ thể và giúp hỗ trợ sự phát triển và hoạt động của não bộ.&nbsp;</p><p></p><p><em>Tôm càng xanh tươi roi rói có nhiều chất dinh dưỡng</em></p><p>Ngoài ra, trong tôm cũng chứa nhiều chất chống oxy hóa, như astaxanthin, giúp bảo vệ tế bào khỏi sự tổn thương do các gốc tự do và giảm thiểu nguy cơ các bệnh liên quan đến sự lão hóa.</p><p>Tuy nhiên, như với bất kỳ loại thực phẩm nào, việc tiêu thụ <strong>Tôm Càng Xanh</strong> nên được cân nhắc và phối hợp với một chế độ ăn uống và lối sống lành mạnh để tận dụng những lợi ích dinh dưỡng mà chúng mang lại.</p><p><strong>🤗 Đảo Gợi Ý Sốt Chế Biến Ngon, Nước Chấm Cực Kì Bắt Vị</strong></p><p></p><p></p><h3>[ YOChef ] Sốt Bơ Cay</h3><p><strong>39,000đ/ Túi 200g</strong></p><h3>[ YOChef ] Sốt Bơ Tỏi</h3><p><strong>39,000đ/ Túi 200g</strong></p><h3>[ YOChef ] Muối Ớt Xanh</h3><p><strong>29,000đ/ Chai 300ml</strong></p><h3>[ YOChef ] Sốt Bơ Cay</h3><p><strong>39,000đ/ Túi 200g</strong></p><h3>[ YOChef ] Sốt Bơ Tỏi</h3><p><strong>39,000đ/ Túi 200g</strong></p><h3>[ YOChef ] Muối Ớt Xanh</h3><p><strong>29,000đ/ Chai 300ml</strong></p><h3>[ YOChef ] Sốt Bơ Cay</h3><p><strong>39,000đ/ Túi 200g</strong></p><h3>[ YOChef ] Sốt Bơ Tỏi</h3><p><strong>39,000đ/ Túi 200g</strong></p><h3>[ YOChef ] Muối Ớt Xanh</h3><p><strong>29,000đ/ Chai 300ml</strong></p><p></p><p></p><h2><strong>Giá trị dinh dưỡng của tôm càng xanh</strong></h2><p>Tôm càng xanh được nhiều thực khách ưa chuộng và đánh giá là một trong những loại tôm nước ngọt ngon vì sự ngọt mềm của thịt tôm và giá trị dinh dưỡng vượt trội:</p><ul><li><p>Tôm càng xanh phù hợp để giảm cân: Theo nghiên cứu, trong 100gr tôm càng xanh chỉ chứa 109 kcal, không có các dạng tinh bột và carbohydrate gây tăng cân. Hàm lượng các chất trong tôm càng chủ yếu bao gồm 11,4gr protein, 0,6gr các chất béo tốt và 30mg canxi. Chính vì thế, sản phẩm phù hợp với khách hàng đang theo chế độ low-carb</p></li><li><p>Tôm càng xanh tốt cho não bộ: Trong tôm có chứa axit béo là Omega 3-6, các khoáng chất có lợi cho hoạt động của não, cải thiện trí nhớ.</p></li></ul><p></p><p></p><p><em>Tôm càng xanh tươi sống trong hồ đảm bảo được nguồn dưỡng chất vốn có</em></p><p></p><h2><strong>Đặc điểm tôm càng xanh ở Đảo</strong></h2><p>Tôm càng xanh tại Đảo được lựa chọn kỹ những con có kích thước đạt tiêu chuẩn, size từ 12-13 con/kg, tôm khỏe, không có hiện tượng gãy càng, chết yếu. Đảo nhập tôm hàng ngày để đảm bảo được chất lượng của tôm khi giao đến tay khách hàng.</p><p></p><p></p><p><em>Tôm càng xanh tươi sống khoẻ đảm bảo càng nguyên vẹn</em></p><p></p><p></p><h2><strong>Giá tôm càng xanh sống loại 1 hôm nay?</strong></h2><p>Giá của Tôm Càng Xanh Loại 1 có thể thay đổi tùy thuộc vào nơi bán, thời điểm mua và số lượng mua. Thông thường, giá <strong>Tôm Càng Xanh</strong> Tươi Sống có giá cao hơn so với các loại tôm khác với giá dao động từ 300.000 - 600.000 đồng/Kg.&nbsp;</p><p>Cần lưu ý rằng, giá của Tôm Càng Xanh Loại To chỉ là tham khảo và có thể thay đổi theo thời gian. Người tiêu dùng cần cân nhắc kỹ trước khi mua hàng ở bất cứ đâu để có được sản phẩm chất lượng tốt và giá cả hợp lý.</p><p>Khi mua Tôm Càng Xanh, bạn nên chú ý đến chất lượng sản phẩm, đảm bảo <strong>Tôm Càng Xanh</strong> tươi, không bị vỡ càng , không bị nát, và không có mùi hôi tanh. Ngoài ra, bạn cũng nên tham khảo ý kiến của người bán để biết thêm thông tin về nguồn gốc và cách chế biến tôm càng xanh.</p><p></p><h2><strong>Cách chọn tôm càng xanh ngon</strong></h2><p></p><p>&nbsp;✅ Quan sát chuyển động của tôm&nbsp;✅ Càng và chân tôm còn đầy đủ&nbsp;✅ Màu sắc vỏ tôm&nbsp;✅ Đuôi tôm màu xanh đậm</p><p></p><p></p><p></p><p><strong><em>Quan sát tôm bơi và khớp nối trên thân tôm</em></strong></p><p>Đối với tôm còn sống, thực khách có thể trực tiếp mua thì hãy quan sát chuyển động của tôm, chọn con bơi khỏe, nhanh nhẹn.</p><p>Đối với tôm đông lạnh, thực khách hãy quan sát khớp nối giữa phần đầu và thân tôm, hãy chọn những con không có hoặc ít có khoảng cách giữa đầu và thân tôm.</p><h3><strong><em>Màu sắc vỏ tôm</em></strong></h3><p>Thực khách hãy kiểm tra trước màu sắc của vỏ tôm, những con tươi ngon thường có vỏ màu xanh hơi ánh xám hoặc có màu nâu xám, có những vệt sọc ngang màu xanh đậm. Khi quan sát sẽ thấy vỏ bóng loáng và khi cầm vào không có vết nhớt.</p><p><strong><em>Càng và chân tôm</em></strong></p><p>Tôm càng xanh có đặc điểm đặc trưng là có 2 càng dài màu xanh đậm, nên thực khách hãy chọn những con tôm có đủ càng, vẫn còn khớp chân đầy đủ và chắc chắn.&nbsp;</p><h3><strong><em>Hình dáng đuôi tôm</em></strong></h3><p>Thực khách cũng có thể quan sát đuôi tôm càng xanh, hãy chọn những con có đuôi màu xanh đậm, xếp gọn, tránh những con bị đứt đuôi hoặc có màu nhạt.&nbsp;</p><h2><strong>Mua tôm càng xanh ở đâu tại TPHCM?</strong></h2><p>Tôm Càng Xanh là loại hải sản phổ biến và có thể mua ở nhiều nơi. Ta có thể đến tìm mua tại các chợ hải sản , các cửa hàng hoặc hiện nay phổ biến với việc mua sắm hải sản trực tuyến trên các nền tảng mạng xã hội.&nbsp;</p><p>Tại ĐẢO HẢI SẢN có cung cấp Tôm Càng Xanh với giá rẻ nhất thị trường với chất lượng tôm vô cùng tươi ngon, trở thành sự lựa chọn hàng đầu của nhiều khách hàng yêu thích hải sản. Giá <strong>Tôm Càng Xanh</strong> tại ĐẢO chỉ dao động từ 300.000 đến 450.000 trên 1Kg.</p><p>Nếu bạn muốn tiết kiệm thời gian và công sức, bạn có thể mua Tôm Càng Xanh trực tuyến tại website hoặc các ứng dụng mua sắm trực tuyến (GrabFood, Baemin,...) hoặc đặt hàng qua Hotline và nhận hàng tận tay hàng đặt trong vòng chưa đến 2H đồng hồ.</p><h2><strong>Chính sách thanh toán &amp; giao hàng tại Đảo Hải Sản?</strong></h2><p>ĐẢO HẢI SẢN luôn hướng đến chất lượng và sự tiện lợi cho khách hàng. Mua hàng tại ĐẢO, bạn sẽ không phải chờ đợi quá 2 tiếng kể từ khi xác nhận thành công đơn hàng đến khi nhận hàng tận tay.</p><p>ĐẢO cung cấp đa dạng phương thức thanh toán và giao hàng cho đơn hàng từ nội thành đến ngoại thành nhằm nâng cao chất lượng dịch vụ.&nbsp;</p><p>Khách hàng sẽ nhận được những chính sách Freeship cho các đơn hàng với giá trị tối thiểu tương ứng để được áp dụng chương trình. Để biết thêm thông tin chi tiết về các chính sách thanh toán và giao hàng, quý khách hàng có thể truy cập website hoặc liên hệ trực tiếp qua Hotline để được nhận tư vấn trực tiếp từ các tổng đài viên.</p>', 339000, 5, 994, 0, 0, 'shrimp', 0, '2025-03-14 09:49:14', '2025-03-19 01:22:28'),
(33, 'Tôm Hùm Xanh Sống', '<p>Tôm hùm xanh sống hay còn được gọi tôm hùm baby tại Việt Nam được xem là “King” của các loại hải sản vì chất lượng thịt tôm hùm chắc dai, ngọt ăn vào nghe tiếng có cảm giác dai giòn sừng sực bởi những thớ thịt và gân xem lẫn nhau. Ngoài ra tôm hùm xanh Việt Nam còn được biết đến là một nguồn cung cấp Protein, Omega-3 chất lượng và không chứa chất béo bão hoà, nên rất an toàn cho tất cả mọi đối tượng.</p><h2><strong>Giới thiệu Tôm Hùm Xanh Baby tại ĐẢO HẢI SẢN</strong></h2><p><strong>Tôm hùm xanh (Size baby) </strong>tại Đảo size vừa ăn từ 300 - 400g/ con. Phù hợp cho 1 người ăn. Sở dĩ có tên là tôm hùm Baby bởi đây là loại tôm hùm có kích thước nhỏ, và tôm hùm baby xanh là loại tôm phổ biến với hàm lượng dinh dưỡng cao và được nhiều thực khách ưa chuộng.</p><p>Tôm được Đảo Hải Sản giao sống tận nơi trong 2H, sản phẩm đảm bảo tươi sống và cam kết chất lượng. Đây là một trong những sản phẩm bán chạy nhất tại Đảo.</p><p><em>Tôm hùm xanh tươi ngon tại Đảo Hải Sản</em></p><p>Tôm hùm xanh baby được&nbsp;nuôi tại bè ở Đảo Bình Hưng, tỉnh Cam Ranh, thành phố Nha Trang&nbsp;hoàn toàn tự nhiên. Đây là khu vực có nguồn nước sạch cùng hệ sinh thái tốt giúp tôm hùm nơi đây luôn có chất lượng vượt trội và thịt luôn dai ngon, săn chắc.</p><p><em>Tôm Hùm Xanh mùa thu hoạch tại Đảo Hải Sản của bà con</em></p><p>Tôm Hùm Xanh&nbsp;được ngư dân tại đây&nbsp;chăm sóc và nuôi cẩn thận. Thức ăn chủ yếu là các loại ngao sò ốc và các loại cá nhỏ khác.&nbsp;Ngư dân kiểm tra chất lượng tôm hùm kĩ để đảm bảo được chất lượng và xưng với danh hiệu tôm hùm ngon nhất Cam Ranh.</p><p><strong>Tôm hùm xanh&nbsp;</strong>bán rất chạy tại ĐẢO&nbsp;được rất nhiều Khách Hàng yêu thích lựa chọn để chế biến những món ngon cho tiệc hải sản tại nhà. Vừa đảm bảo tôm ngon chất lượng mà giá hợp lý.</p><blockquote><p><strong>🤗 Đảo Gợi Ý Sốt Chế Biến Ngon,&nbsp;Cực Kì Bắt Vị</strong></p></blockquote><h2><strong>Giá mua tôm hùm xanh baby tại Đảo Hải Sản?</strong></h2><p>Hiện nay tôm hùm Nha Trang Việt Nam được rất ưa chuộng trong các buổi cơm gia đình Việt hoặc các nhà hàng cao cấp bởi những giá trị của tôm hùm xanh baby đem lại. Vậy giá mua tôm hùm xanh baby là bao nhiêu?.&nbsp;</p><p>Trên thực tế tôm hùm xanh baby là loại sản phẩm mang lại giá trị kinh tế cao và kỹ thuật nuôi trồng yêu cầu cũng khắt khe chính vì thế giá thành của chúng cũng không thấp mà cũng không cao.</p><p><em>Giá mua tôm hùm xanh baby tại Đảo Hải Sản?</em></p><p>Đồng thời giá của tôm hùm xanh baby cũng sẽ phụ thuộc vào mùa vụ và trọng lượng của tôm nữa, ở đây Đảo Hải Sản sẽ phân loại trọng lượng trung bình tại Đảo bạn có thể tham khảo nhé! Còn giá sản phẩm Đảo luôn cập nhật ở phía trên sản phẩm.</p><p>&nbsp;🦞 Loại tôm hùm xanh nhỏ size&nbsp;👉 350g&nbsp;🦞 Loại tôm hùm baby size&nbsp;👉 1kg&nbsp;🦞 Loại tôm hùm xanh baby size&nbsp;👉 3 con 1kg1</p><h2><strong>Giá trị dinh dưỡng của tôm hùm baby xanh</strong></h2><p>Giống với những loại tôm hùm khác, tôm hùm xanh baby cung cấp hàm lượng dinh dưỡng lớn phù hợp với các chế độ dinh dưỡng giàu đạm. Với mỗi 100gr thịt tôm hùm xanh baby cung cấp:</p><ul><li><p>98 calo</p></li><li><p>21gr protein (đạm)</p></li><li><p>Chất béo</p></li><li><p>0.6gr axit béo</p></li><li><p>Vitamin B12, Vitamin A, Vitamin E</p></li><li><p>Các nhóm chất khoáng, sắt, kẽm, Canxi</p></li><li><p>Omega 3</p></li></ul><p><em>Giá trị dinh dưỡng của tôm hùm baby xanh</em></p><p>Bên cạnh đó, tôm hùm xanh baby còn giúp cải thiện sức khỏe và có những công dụng tuyệt vời trong việc:</p><ul><li><p>Cung cấp hàm lượng Protein cao (không béo) phù hợp cho người tập Gym</p></li><li><p>Cải thiện tình trạng rối loạn nhịp tim</p></li><li><p>Giảm nồng độ chất béo trung tính trong máu</p></li><li><p>Điều trị tình trạng xơ vữa động mạnh</p></li><li><p>Giúp cả thiện tình trạng bệnh lý liên quan đến tim mạch, huyết áp</p></li></ul><h2><strong>Tôm hùm xanh dưới góc nhìn y học &amp; dinh dưỡng</strong></h2><p>Tôm hùm xanh baby Việt Nam được xem là loại Hải Sản chứa nhiều chất dinh dưỡng chính vì thế dưới góc nhìn của y học và dinh dưỡng nó được xem là sản phẩm rất tốt cho sức khỏe của người.&nbsp;Theo tài liệu nghiên cứu của các nhà khoa học tại Mỹ cho ra khuyến cáo rằng nên dùng tôm hùm trong thực đơn vào những bữa ăn hàng tháng bởi chúng rất tốt cho hệ tim mạch, thần kinh và xương khớp.</p><p><em>Tôm Hùm Xanh mang lại nhiều giá trị dinh dưỡng</em></p><h3><strong><em>Tôm hùm xanh nguồn đạm dồi dào cho cơ thể</em></strong></h3><p>Tôm hùm xanh baby được xem là nguồn cung cấp dưỡng chất tốt giúp cho cơ thể duy trì hoạt động tốt bởi chứa đến 27.55g protein cho con 100g tôm hùm.</p><h3><strong><em>Hỗ trợ sự phát triển của não bộ</em></strong></h3><p>Trong tôm hùm xanh baby có rất nhiều vitamin và khoáng chất chẳng hạn như vitamin B12, vitamin E, Omega-3,....</p><p>Các dòng khoáng chất này được biết đến là hỗ trợ sự phát triển não bộ của con người, nếu trong gia đình bạn có người lớn tuổi và trẻ nhỏ nên quan tâm sản phẩm này nên có trong thực đơn của gia đình bạn.</p><h3><strong><em>Tôm hùm baby tốt cho tim mạch</em></strong></h3><p>Thành phần DHA và EPA là 2 dưỡng chất rất cần thiết cho tim mạch, hỗ trợ làm giảm nguy cơ đột quỵ, xơ vỡ động mạch và các căn bệnh liên quan đến tim.</p><p><em>Tôm Hùm Xanh mang lại nhiều giá trị dinh dưỡng</em></p><h2><strong>Một số câu hỏi thường gặp ở Tôm Hùm Xanh Baby?</strong></h2><h3><strong><em>Bé 6 tháng tuổi có ăn được tôm hùm không?</em></strong></h3><p>Nhiều chị em lần đầu làm mẹ thường có những lo lắng không biết là cho bé ăn tôm hùm xanh có được hay không? Vì có nhiều trường hợp các con bị dị ứng tôm hùm sau khi ăn. Bạn đừng quá lo lắng nếu cha mẹ không có dị ứng với tôm hoặc hải sản thì đảm bảo bé sẽ ăn được nè, nhưng phải chế biến món ăn phù hợp với từng độ tuổi của các bé nhé mẹ!</p><p>Dưới đây là một vài gợi ý trọng lượng dành cho từng giai đoạn của bé:</p><ul><li><p>Bé từ 6 - 12 tháng tuổi: mỗi bữa ăn từ 20 - 30g chỉ cho bé ăn từ 3 - 4 buổi ăn trong 1 tuần.</p></li><li><p>Bé từ &nbsp;12 - 36 tháng tuổi: &nbsp;30 - 40g mỗi bữa, 1 tuần nên ăn 3 - 4 bữa</p></li><li><p>Bé từ 4 tuổi trở lên: 50 - 60g cho 1 bữa ăn.</p></li></ul><p>Mẹ có thể tham khảo nhé! Kiến thức trên được lấy từ những lời khuyên của các chuyên gia dinh dưỡng.</p><p><em>Bé 6 tháng tuổi có ăn được tôm hùm không?</em></p><h3><strong><em>Đang Mang thai có ăn được tôm hùm xanh baby được hay không?</em></strong></h3><p>Như ở trên Đảo Hải Sản đã liệt kê tôm hùm xanh rất tốt cho tim mạch, hệ thần kinh và duy trì hoạt động hàng ngày của con người, xương khớp chính vì thế bà bầu nếu không có dị ứng với tôm thì nên bổ sung tôm hùm vào bữa ăn của mình.</p><p>Tuy nhiên trong tôm có chứa thuỷ ngân với một hàm lượng nhất định không đáng kể cho nên mẹ bầu phải cân chỉnh ăn với lượng vừa đủ, để hỗ trợ tốt cho mẹ và bé trong quá trình mang thai.</p><p>Lưu ý không nên ăn quá nhiều dẫn đến tình trạng ngộ độc, rất ảnh hưởng và có thể nguy hiểm cho mẹ trong thời kỳ mang thai.</p><p><em>Tôm hùm xanh được chế biến rất cầu kỳ dành cho các mẹ bầu</em></p><h3><strong><em>Tôm hùm xanh baby chế biến món gì ngon nhất?</em></strong></h3><p>Là một trong top các nhóm hải sản dinh dưỡng cao, tôm hùm xanh baby được chế biến thành nhiều món ngon chinh phục được những thực khách khó tính nhất. Dưới đây ĐẢO sẽ gợi ý cho Quý Khách một số món ngon từ tôm hùm xanh mà Khách yêu không thể không một lần thử</p><ul><li><p><strong>Tôm Hùm Xanh</strong>&nbsp;hấp bia, hấp sả.</p></li><li><p>Tôm hùm baby nướng phô mai</p></li><li><p>Cơm chiên tôm hùm</p></li><li><p>Tôm hùm baby rang muối</p></li><li><p>Tôm hùm hấp bia</p></li><li><p>Tiết canh tôm hùm baby</p></li><li><p>Tôm hùm Baby hấp nước dừa</p></li></ul><p>ĐẢO mời khách xem ngay sản phẩm tôm hùm baby đã qua chế biến tại ĐẢO HẢI SẢN!</p><p><em>Tôm hùm xanh được chế biến không cầu kỳ nhưng vẫn&nbsp;hấp dẫn</em></p><h2><strong>Mua tôm hùm xanh baby ở đâu? Chọn ĐẢO HẢI SẢN giá tốt, lại còn được giao nhanh 2h</strong></h2><p>ĐẢO HẢI SẢN là nhà cung cấp hải sản nói chung và tôm hùm baby nói riêng hàng đầu Việt Nam. Bên cạnh có mức giá cực kỳ tốt do ĐẢO liên kết trực tiếp với các hộ chăn nuôi tôm hùm, tạo điều kiện tốt nhất cho khách hàng thưởng thức món ngon mà không cần phải bỏ ra quá nhiều tiền.</p><p>Bên cạnh hải sản tươi sống được nhập mới mỗi ngày, ĐẢO HẢI SẢN còn ghi điểm với tính năng giao nhanh trong 2h, Khách yêu không phải chờ đợi lâu để được thưởng thức món ăn ngon</p>', 1290000, 3, 997, 0, 0, 'shrimp', 0, '2025-03-14 09:52:44', '2025-03-19 01:22:28'),
(34, 'Tôm Hùm Đất Chín', '<p>Tôm Hùm Đất&nbsp;(Crawfish) là một tôm nhỏ sống ở nước ngọt, đặc biệt là ở các con sông và hồ miền Nam nước Mỹ. Loài tôm này là thường được săn bắt vào mùa xuân và hè.&nbsp;Tôm hùm đất là một loài tôm có lớp vỏ ngoài cứng, bên trong là thịt tôm mềm mọng, ngọt, được chào đón ở tất cả các nền ẩm thực trên thế giới.</p><p>Crawfish / Tôm Hùm Đất</p><h2><strong>Giới thiệu về Tôm Hùm Đất&nbsp;(Crawfish)</strong></h2><p>Crawfish hay còn được gọi là tôm hùm đất thường có chiều dài từ 7-12 cm, có màu xanh qua tới nâu. Loài tôm này sống ở nước ngọt và ưa thích các hang động hay các ổ đất sâu ở đáy sông. Trong ẩm thực, tôm hùm đất&nbsp;thường được dùng để nướng, hấp, xào, hay các món salad. Ngoài ra, tôm hùm đất còn được sử dụng để giảm đau, chống viêm trong y học truyền thống.</p><h2><strong>Giá trị dinh dưỡng của Tôm Hùm Đất (Crawfish)</strong></h2><p>Tôm hùm đất là một nguồn cung cấp dinh dưỡng đáng kể trong cơ thể. Thịt tôm có chứa nhiều protein, vitamin, khoáng chất tốt cho sức khoẻ con người. Dưới đây là các chất dinh dưỡng chính có trong tôm hùm đất:&nbsp;</p><ul><li><p>Protein: Thịt tôm hùm đất có chứa lượng protein cao, cung cấp cho chúng ta một nguồn protein dồi dào để duy trì sức khoẻ, tăng cường và hôi phục cơ bắp.&nbsp;</p></li><li><p>Vitamin B12: có tác dụng hổ trợ sức khoẻ, tế bào máu, hệ thần kinh, giúp não bộ hoạt động bình thường, giúp xương chắc khoẻ, ngăn ngừa loãng xương.&nbsp;</p></li><li><p>Selen: chứa một nguồn selen dồi dào, một khoáng chất có tác dụng chống ôxy hoá, tăng cường miễn dịch, ngăn chặn sự thâm nhập của các tác nhân gây bệnh như vi khuẩn, virus, và tăng cường sức khoẻ tim mạch.&nbsp;</p></li><li><p>Đồng: tôm hùm đất còn chứa đồng, có tác dụng chống oxy hoá, tăng cường sức khoẻ tim mạch, dẫn truyền tín hiệu thần kinh, giữ vững hệ miễn dịch, sản xuất collagen và estalin, loãng xương.</p></li><li><p>Kẽm: tôm hùm đất cũng chứa kẽm, một khoáng chất giúp tăng cường sức khoẻ cho da, tóc và móng. Ngoài ra còn giúp điểu trị mụn, tăng tốc chữa lành vết thương. Hỗ trợ sức khỏe sinh lí cho cánh mày râu và cải thiện trí nhớ.</p></li></ul><h2><strong>Tôm hùm đất đông lạnh bao nhiêu 1kg? Giá crawfish ở Sài Gòn thực tế?</strong></h2><p>Giá tôm hùm đất dông lạnh ở Sài Gòn đang có giá dao động trong khoảng 250.000-380.000/kg nhưng còn tuỳ vào địa điểm bán, mùa vụ, kích thước và chất lượng sản phẩm.</p><p>Tôm hùm đất đông lạnh bao nhiêu 1kg? Giá crawfish ở Sài Gòn thực tế?</p><p>Hiện tại ở Đảo tôm hùm đất đông lạnh đang có giá là 780.000/2,5kg, suy ra chỉ có 312.000/kg nhưng có chất lượng cao. Tôm hùm đất của đảo được xử lí sạch sẽ, đưa qua máy xông nhiệt chín rồi tiếp tục đưa vào hệ thống đông lạnh để mạ một lớp băng tuyết bên ngoài rồi mới đóng thùng di chuyển về Việt Nam. Tôm hùm đất đông lạnh không kém chất lượng như bạn nghĩ, vì xuyên suốt quá trình đóng gói, vận chuyển về Việt Nam, tôm được bảo quản rất tốt, gần như nguyên vẹn với thịt tươi và mùi vị nguyên thuỷ.</p><h2><strong>Địa điểm bán tôm hùm đất đông lạnh tại TPHCM</strong></h2><p>Ở thành phố Hồ Chí Minh cũng có rất nhiều địa điểm bán tôm hùm đất như ở các siêu thị lớn và các địa điểm bán chuyên hải sản như: Siêu thị Winmart, siêu thị Co.opmart</p><p>Nhưng nếu bạn muốn chọn một địa điểm uy tín để mua tôm hùm đất chất lượng và đảm bảo an toàn vệ sinh thực phẩm thì hãy đến Đảo Hải Sản, hay có thể mua hàng tại trang web daohaisan.vn, bạn cũng có thể liên hệ qua facebook Đảo Hải Sản để được tư vấn và mua hàng.</p><h2><strong>Gợi ý một số món ăn từ tôm hùm đất (crawfish)</strong></h2><p>Tôm hùm đất có thể dùng để được chế biến đa dạng món ăn từ phong cách tây theo phong cách á. Bạn có thể tham khảo các món ăn làm từ tôm dưới đây:&nbsp; Tôm hùm đất sốt bơ tỏi, Tôm hùm đất sốt cajun, Tôm hùm đất sốt me, Tôm hùm đất xào cay, Tôm hùm đất phô mai đút lò, Tôm hùm đất nướng phô mai trứng muối, Tôm hùm đất sốt tiêu đen,....</p><p></p><p></p><p><br></p>', 750000, 9, 991, 0, 0, 'shrimp', 0, '2025-03-14 09:58:04', '2025-03-19 01:22:28'),
(35, 'Hàu Sữa Giống Pháp (30 Con)', '<p>Hàu sữa giống&nbsp;Pháp vỏ mỏng, mềm, ruột hàu nhiều sữa vừa ngon lại vừa dễ tách. Hàu sữa giống&nbsp;Pháp con nhỏ vừa ăn, không lớn như hàu đá, nhưng sữa thơm, béo thanh mát, không dễ gây ngán, phù hợp cho những nhà hàng có phong cách thiết kế kiểu Tây, và những người sành ăn, đặc biệt là dùng cho ăn sống kết hợp với rượu vang, và những người mong muốn có buổi tiệc độc đáo.</p><h2><strong>Giới thiệu về hàu sữa giống&nbsp;Pháp</strong></h2><p>Hàu Sữa Giống&nbsp;Pháp có phân bố tự nhiên ở phía Bắc của Nhật Bản, nơi chúng được gọi là “Một trong những loại hàu lớn nhất thế giới” và có tên khoa học là Crassostrea gigas. Từ đó, chúng được phân bố rộng rãi nhờ nuôi trồng trên toàn thế giới như Pháp, Anh, Mexico…Và đặc biệt tại Pháp.&nbsp;</p><p>Sau khi trưởng thành, các con Hàu Tươi Sống sẽ được đem vào các trại nuôi để tiếp tục phát triển và trở thành nguồn cung cấp Hàu Sữa&nbsp;Pháp cho thị trường nội địa và xuất khẩu.</p><p><em>Hàu Giống&nbsp;Pháp Sữa tươi ngon tại Đảo Hải Sản</em></p><p>Hàu sữa giống&nbsp;Pháp nổi tiếng với hương vị thơm ngon và thịt giàu dinh dưỡng, là một trong những loại hải sản được ưa chuộng trên thế giới. Hàu có vỏ màu đen xanh hoặc xám, có kích thước lớn và cơ thể được bao bọc bởi 2 vỏ cứng chắc. Hàu Sống thường bám cố định trên bất kỳ vật thể cứng như đá, võ hàu…Cụ thể, Hàu Sữa có tính chất sống đám đông, do đó chúng thường sẽ bám vào nhau để hỗ trợ cho nhau trong quá trình phát triển và sinh sản.</p><p>Đặc biệt, Hàu Sữa là loài có khả năng tự thay đổi giới tính, chúng có thể thay đổi giới tính từ cái sang đực và ngược lại, tùy thuộc vào điều kiện môi trường sống. Ngoài ra, Hàu có tập tính lọc nước, chúng có khả năng lọc các chất dinh dưỡng và các hạt bụi trong nước để lấy thức ăn.</p><p><em>Hàu Pháp Sữa tươi ngon tại Đảo Hải Sản</em></p><h2><strong>Giá Hàu sữa giống&nbsp;Pháp hôm nay bao nhiêu 1 kg?</strong></h2><p>Giá Hàu Sữa Giống&nbsp;Pháp có thể khác nhau tùy thuộc vào vị trí địa lý, mùa vụ, kích thước và chất lượng của chúng. Thông thường, giá thành của Hàu Giống&nbsp;Pháp tươi sẽ cao hơn so với các loại hàu khác vì chúng được coi là có hương vị tinh túy và độc đáo hơn.</p><p>Vì sự phân bố của Hàu Giống&nbsp;Pháp đã trở nên rộng rãi và phổ biến hơn nên giá thành của Hàu Sữa khá rẻ tại thị trường hải sản Việt Nam, đặc biệt là TP.HCM từ khoảng 95.000đ - 120.000đ/Kg tùy thuộc vào từng Size Hàu. Cụ thể hơn là giá sẽ phụ thuộc vào nhu cầu tiêu dùng của thực khách, sẽ có những sự lựa chọn khác nhau đồng nghĩa với việc giá thành cũng sẽ dao động phụ thuộc vào độ to, nhỏ và chất lượng của Hàu.</p><h2><strong>Hàu sữa giống&nbsp;Pháp tươi sống mua ở đâu TPHCM</strong></h2><p>Bạn nên chọn lựa những địa điểm uy tín tại khu vực địa phương để chọn mua Hàu Sữa Pháp Size 30 Con với giá phải chăng kèm chất lượng đạt chuẩn Hàu Tươi Sống.&nbsp;</p><p>Bạn đang lo ngại về việc mua Hàu Sữa Pháp Tươi Sống ở đâu? Hãy đến với ĐẢO HẢI SẢN để trải nghiệm những loại hải sản tươi ngon và rẻ nhất thị trường. Ngoài ra, bạn sẽ được nhận được những lợi ích mua hàng mà chỉ tại ĐẢO mới có. Cụ thể là, ĐẢO có chính sách cam kết chất lượng, đảm bảo 1 đổi 1 nếu Hàu không được chất lượng như khách hàng mong muốn.&nbsp;</p><p>Sự tiện lợi và nhanh chóng tại ĐẢO luôn là lý do nhiều khách hàng thân quen vẫn tin tưởng và sử dụng dịch vụ tại đây. Cùng với sự nhiệt tình của đội ngũ tư vấn tại các kênh bán hàng đã luôn hỗ trợ khách hàng trong suốt quá trình chọn mua đến khi nhận được hàng đã tạo nên thương hiệu ĐẢO HẢI SẢN - Nhà bán lẻ hải sản hàng đầu.</p><p>Tất cả các sản phẩm từ hải sản tươi sống đến thực phẩm đã chế biến sẽ được đảm bảo chất lượng tốt nhất bằng cách giữ nóng hoặc giữ lạnh tùy thuộc vào loại sản phẩm đặt hàng khi đến tay khách hàng.&nbsp;</p><h2><strong>Giá trị dinh dưỡng của Hàu Sữa tươi sống</strong></h2><p>Hàu Sữa Giống&nbsp;Pháp là một nguồn thực phẩm giàu dinh dưỡng và đem lại rất nhiều lợi ích cho sức khỏe. Đặc biệt là tăng cường chức năng tim mạch vì chúng có chứa Omega-3, một dưỡng chất có khả năng bảo vệ hệ tim mạch như giảm nguy cơ rối loạn nhịp tim, đột quỵ hay giảm nguy cơ mắc các bệnh lý về tim mạch.</p><p>Hàu Sống Tươi giúp tăng cường sức đề kháng vì Hàu là một nguồn giàu kẽm và selen, hỗ trợ tăng cường hệ miễn dịch của cơ thể và giảm nguy cơ mắc các bệnh nhiễm trùng.</p><p>Hàu Giống&nbsp;Pháp chứa nhiều chất dinh dưỡng như axit folic, canxi và sắt rất tốt cho sức khỏe của phụ nữ mang thai, đặc biệt giảm nguy cơ sinh non.</p><p>Hệ thần kinh cũng được cải thiện và phát triển khi sử dụng Hàu vì nó có chứa lượng lớn choline, chất dinh dưỡng giúp cải thiện khả năng ghi nhớ và năng lực tư duy.</p><p><em>Từng lớp sữa căng mọng ăn béo và ngọt.</em></p><h2><strong>Những câu hỏi thường gặp về hàu sữa</strong></h2><h3><strong>Hàu có nhiều đạm, canxi không?</strong></h3><p>Hàu Sữa là một nguồn tuyệt vời cho việc cung cấp protein và canxi, nhưng lượng chúng có thể khác nhau tùy vào loại Hàu và từng địa điểm nuôi trồng.</p><p>Tuy nhiên, theo bảng dinh dưỡng của Cơ quan Quản lý Thực phẩm và Dược phẩm Hoa Kỳ (FDA), mỗi 100g Hàu có chứa khoảng 9g Protein và 56mg Canxi. Do đó, Hàu có thể được coi là một nguồn protein và canxi tốt cho sức khỏe của con người.</p><p><em>Hàu sữa giống&nbsp;pháp tại Đảo Hải Sản to gần bàn tay của vị khách hàng</em></p><p>Ngoài ra, Hàu cũng chứa nhiều chất dinh dưỡng khác như magie, sắt, kẽm, photpho, selen, vitamin B12 và Omega-3, giúp cung cấp năng lượng và tăng cường sức khỏe chung của cơ thể. Tuy nhiên, việc tiêu thụ hàu cần nên cân nhắc kỹ vì chúng cũng có thể chứa các độc tố và vi khuẩn, đặc biệt là khi được chế biến và lưu trữ không đúng cách.</p><h3><strong>Ăn Hàu có tốt cho sức khoẻ không?</strong></h3><p>Hàu Sữa có thể mang lại lợi ích sức khỏe cho nhiều đối tượng khác nhau, nhưng cần được tiêu thụ với đủ lượng và cẩn thận. Dưới đây là một số nhóm đối tượng có thể bổ sung hàu vào chế độ ăn giúp cải thiện tình trạng sức khỏe:</p><ul><li><p>Người bị thiếu sắt: Hàu chứa lượng sắt cao, là một nguồn dinh dưỡng tuyệt vời cho những người có thiếu sắt, đặc biệt là phụ nữ sau sinh, trẻ em và người cao tuổi</p></li><li><p>Người tập thể dục: Hàu cung cấp một lượng lớn protein và các chất dinh dưỡng khác, giúp cơ thể phục hồi và tăng cường sức mạnh cơ bắp</p></li><li><p>Người muốn giảm cân: Người muốn giảm cân: Hàu là thực phẩm có ít chất béo và calo, giúp giảm cân một cách hiệu quả nếu được tiêu thụ đúng lượng &nbsp;</p></li><li><p>Người bị loãng xương: Người bị loãng xương: Hàu chứa nhiều canxi, là một loại thực phẩm tuyệt vời cho sức khỏe xương</p></li><li><p>Người muốn tăng cường hệ miễn dịch: Người muốn tăng cường hệ miễn dịch: Hàu cung cấp một lượng lớn kẽm và selen, hai chất dinh dưỡng được biết đến để tăng cường hệ miễn dịch của cơ thể</p></li></ul><p>Tuy nhiên, những người có tiền sử dị ứng thủy sản hoặc các vấn đề về sức khỏe như bệnh tăng huyết áp, bệnh tiểu đường, hoặc bệnh thận nên tham khảo ý kiến của bác sĩ trước khi sử dụng Hàu .</p><h3><strong>Hàu sữa giống&nbsp;Pháp có bao nhiêu calo?</strong></h3><p>Hàu Sữa Tươi có lượng calo thấp, khoảng 70-100 calo cho mỗi 100g Hàu. Với lượng calo mà Hàu cung cấp, món ăn này rất phù hợp cho một số người ăn kiêng và có kiểm soát chế độ ăn.&nbsp;</p><p>Tuy nhiên, nếu Hàu được chế biến với các loại gia vị, nước sốt hoặc chiên giòn thì lượng calo có thể tăng lên tùy theo cách chế biến của mỗi món ăn.</p><p>Do đó, nếu bạn đang theo dõi lượng calo hàng ngày, hãy chọn các phương pháp chế biến hàu đơn giản như nướng, hấp hoặc ăn sống để tận hưởng lợi ích dinh dưỡng của hàu mà không cần lo lắng về lượng calo quá cao.</p><h3><strong>Hàu sữa làm món gì ngon?</strong></h3><p>Có rất nhiều món ăn ngon hấp dẫn được chế biến từ Hàu Sữa Giống&nbsp;Pháp mà chúng ta có thể thấy khá thường xuyên ở các quán ăn hoặc ở những bữa tiệc tự chuẩn bị. Sau đây, ĐẢO mách bạn một số món ăn có thể bạn sẽ thích và muốn trải nghiệm các món ăn với nguyên liệu chính là Hàu Giống&nbsp;Pháp nguyên con: Hàu nướng phô mai, Hàu nướng mỡ hành, Hàu hấp sả,&nbsp;Hàu sống dùng với sốt chanh dây,&nbsp;Hàu áp chảo,&nbsp;Cháo Hàu,&nbsp;Salad Hàu,&nbsp;Sashimi Hàu,....</p>', 180000, 17, 983, 0, 0, 'oysters', 0, '2025-03-14 10:03:05', '2025-03-19 01:22:28'),
(36, 'Ngao Hai Cồi Sống Nha Trang', '<p>Ngao 2 Cồi là một loại hải sản rất được ưa chuộng tại Việt Nam, đặc biệt là trong hầu hết các bữa tiệc hay thậm chí là món chính trong bữa ăn hàng ngày của người Việt.&nbsp; Ngoài cái tên Ngao 2 Cồi hay còn được biết với tên gọi khác như Nghêu 2 Cùi, tuỳ thuộc vào từng khu vực, vùng miền mà loại hải sản này có các tên gọi khác nhau.</p><p></p><p></p><p><em>Ngao 2 cồi Nha Trang nhưng bán tại TPHCM bạn có tin?</em></p><h2><strong>Giới thiệu về Ngao 2 cồi sống Nha Trang</strong></h2><p>Ngao 2 Cồi Sống là động vật thân mềm có thân dài, hình dạng giống nhưng ống nhưng không có van, có 2 cồi đầu nhọn là đặc trưng của loài sinh vật này.&nbsp; Đặc điểm đáng chú ý của Ngao 2 Cồi là chúng sống ở vùng biển nhiệt đới và ôn đới, đặc biệt là ở vùng biển miền Trung Việt Nam, từ Nha Trang đến Quảng Ngãi. Chúng thường sống ở độ sâu từ 1 - 15 mét trên thềm đáy biển, bám nhiều trên các mỏm đá hoặc các bờ cát ven biển.</p><p></p><p><em>Môi trường sống ổn định cùng sự cân bằng giữa nhiệt độ và độ pH</em></p><p>Nghêu 2 Cùi phù hợp với môi trường sống ổn định cùng 2 yếu tố quan trọng là sự cân bằng giữa nhiệt độ và độ pH. Vì vậy, nếu môi trường bị nhiễm bẩn hoặc bị ô nhiễm hoặc có sự thay đổi 1 trong 2 yếu tố trên sẽ ảnh hưởng trực tiếp đến chất lượng của ngao.</p><h2><strong>Giá trị dinh dưỡng của ngao 2 cồi đại dương</strong></h2><p>Ngao 2 Cồi là một loại hải sản đến từ đại dương có chứa rất nhiều giá trị dinh dưỡng cao và khoáng chất cần thiết cho cơ thể con người. Thịt ngao là nguồn cung cấp protein dồi dào, chất béo không bão hoà, các axit và vitamin nhóm B.&nbsp;Chất đạm trong ngao 2 cùi tươi có hàm lượng cao hơn so với thịt bò, thịt gà, cua, tôm…Đồng thời, nó cũng chứa rất ít chất béo và cholesterol. Nên việc bổ sung các loại ngao thường xuyên cũng rất tốt với sức khoẻ chúng ta và giúp ngăn ngừa nguy cơ mắc các bệnh về tim mạch.</p><p></p><p><em>Ngao 2 cồi Nha Trang có chứa rất nhiều giá trị dinh dưỡng cao</em></p><p>Ngoài ra, Ngao 2 cồi cũng chứa các khoáng chất như canxi, sắt, kẽm, mangan, magie và đồng. Canxi trong ngao 2 cồi giúp tăng cường sức khỏe xương, sắt giúp cải thiện sự trao đổi chất và giảm nguy cơ thiếu máu. Và đặc biệt, loài ngao này còn chứa các chất chống oxy hóa, giúp ngăn ngừa các bệnh liên quan đến lão hóa và ung thư.&nbsp;</p><p>Tuy nhiên, khi sử dụng ngao 2 cồi, cần lưu ý và cân nhắc về mức độ sử dụng và cách chế biến để đảm bảo không ảnh hưởng đến sức khỏe. Trong trường hợp các bạn có các bệnh liên quan đến vấn đề tiêu hóa hoặc dị ứng thì nên hạn chế sử dụng loại thực phẩm này hoặc có thể tư vấn ý kiến của bác sĩ chuyên môn.</p><p></p><h2><strong>Giá nghêu 2 cồi Nha Trang hôm nay bao nhiêu 1kg?</strong></h2><p>Tùy thuộc vào kích cỡ của Ngao 2 Cồi Nha Trang mà có giá khác nhau tương ứng với mỗi loại. Ngoài ra, giá thành của sản phẩm còn phụ thuộc vào các yếu tố khác như khu vực, thời điểm mùa ngao, nguồn cung cầu trên thị trường, các loại chi phí vận chuyển và điều kiện thị trường.&nbsp;</p><p>Thông thường, giá bán của Ngao 2 Cồi Nha Trang tại TP.HCM sẽ dao động từ 150.000đ - 350.000đ tùy vào quy cách bán. Bạn nên tìm hiểu thị trường hải sản bằng các phương tiện truyền thông hoặc đến các địa điểm buôn bán hải sản uy tín để đảm bảo mua hàng với chất lượng uy tín với giá hợp lý.</p><h2><strong>Mua Ngao 2 cồi sống tươi ở đâu TPHCM?</strong></h2><p>Khi lựa chọn ngao 2 cồi sống, bạn nên chọn và kiểm tra kỹ để tránh mua phải hải sản kém chất lượng hoặc thậm chí những con ngao không còn sống. Cụ thể, Ngao Sống không được phép có mùi hôi và màu sắc đen hoặc xám đen, điều này chứng tỏ sản phẩm không đủ tiêu chuẩn để bán cho người tiêu dùng.&nbsp;</p><p>Vì vậy, bạn nên đến những nơi chuyên cung cấp hải sản tươi sống uy tín tại địa phương để đảm bảo sức khỏe của chính bạn và người trong gia đình.&nbsp;</p><p><em>Ngao 2 cồi Nha Trang to tươi sống tại Đảo Hải Sản</em></p><p>ĐẢO HẢI SẢN là một trong những nhà bán lẻ hải sản hàng đầu tại TP.HCM với 3 Cửa Hàng Chính nhằm phục vụ mua bán, cung cấp hải sản tươi ngon cho thực khách. Quý khách sẽ có trải nghiệm tuyệt vời khi ghé thăm nhà ĐẢO để có thể thấy trực tiếp và mua tận tay các sản phẩm tươi mới, sạch sẽ và chất lượng tại đây.&nbsp;</p><p><em>Ngao 2 cồi Nha Trang to tươi sống tại Đảo Hải Sản</em></p><p><em>Ngao 2 cồi Nha Trang to tươi sống tại Đảo Hải Sản</em></p><p>Ngoài ra, quý khách có thể tham khảo giá và thông tin chi tiết của sản phẩm trên Website rồi tiến hành các thao tác mua hàng vô cùng dễ dàng và tiện lợi</p><h2><strong>Ngao 2 cồi vàng to làm món gì ngon?</strong></h2><p>Những món ăn sau đây cả nhà có thể tham khảo cho việc lựa chọn món ăn trong thực đơn đãi tiệc được dễ dàng hơn.</p><ul><li><p>Ngao 2 Cồi xào tỏi</p></li><li><p>Nước Chấm Ngao 2 Cồi</p></li><li><p>Ngao hấp sả ớt</p></li><li><p>Ngao 2 Cồi Chiên Giòn</p></li><li><p>Súp Ngao 2 Cồi</p></li></ul><p><em>Ngao 2 cồi Nha Trang Hấp thái</em></p><p><em>Ngao 2 cồi Nha Trang Hấp thái</em></p><p><em>Ngao 2 cồi Nha Trang Hấp thái</em></p><p><em>Ngao 2 cồi Nha Trang hấp? xả</em></p><p></p>', 220000, 8, 992, 0, 0, 'other', 0, '2025-03-14 10:09:33', '2025-03-19 01:22:28');
INSERT INTO `products` (`id`, `name`, `description`, `price`, `quantity_sold`, `quantity`, `star`, `status`, `category`, `hot`, `created_at`, `updated_at`) VALUES
(37, 'Cua Hoàng Đế - King Crab Đỏ Sống', '<p><strong>Cua King&nbsp;Đỏ (King Crab)&nbsp;</strong>hay còn được gọi với cái tên <strong>Cua Hoàng Đế</strong> là loại cua biển rất nổi tiếng trên thế giới. Ở Việt Nam, Cua Hoàng Đế luôn nằm trong top các loại hải sản, loại cua ngon nhất nằm trong thực đơn của các nhà hàng nổi tiếng, các quán ăn lớn.</p><p></p><h2><strong>Cua King Crab là cua gì?</strong></h2><p>Cua King Crab hay còn được biết là cua hoàng đế hay một cái tên khác Cua Alaska thuộc họ cua biển được đánh bắt ở vùng biển Alaska, chất lượng thịt thuộc đứng top thượng hạng, chính vì thế chúng có giá trị kinh tế rất cao.</p><p>Đây là loại cua lớn nhất, cua trưởng thành mai có thể đạt đến 17 cm. Trung bình một con Cua Hoàng Đế ngày nay có trọng lượng khoảng từ 2kg - 4kg.&nbsp;&nbsp;Được đánh bắt tại vùng biển sâu và lạnh ở biển Bắc Thái Bình Dương, vùng biển Alaska.</p><p></p><p><em>Cua hoàng đế tại Đảo Hải Sản</em></p><p>Với vùng biển khí hậu lạnh giá và sâu như vậy thì đó là nơi sinh sống lý tưởng của loại cua này.&nbsp;Cua Hoàng Đế có nhiều thịt chắc ngon ngọt đặc trưng mà chỉ có ở loại cua này. Đặc biệt thịt cua tập trung nhiều ở chân. Thịt chứa nhiều chất dinh dưỡng, đạm, canxi rất tốt cho cơ thể.</p><h2><strong>Cua hoàng đế tại Đảo Hải Sản có đặc điểm gì?</strong></h2><p>Cua Hoàng Đế được Đảo đóng thùng xốp + đá khô (miễn phí) để giao sống đến tận tay cho Khách. Quy trình vận chuyển tiêu chuẩn nên King Crab khi đến tay khách vẫn&nbsp;khỏe như đang ở trong bể.&nbsp;Thường thì king crab cái vào mùa mới có nên thuộc hàng hiếm bán chạy. Cùng Đảo Hải Sản xem đặc điểm cua hoàng đế có gì nổi bật mà thu hút nhiều khách săn mua nha:</p><p></p><p><em>Cua hoàng đế King Crab tươi sống tại hồ Đảo Hải Sản</em></p><p>Cua hoàng đế nhiều nơi gọi là cua nhện, nổi bật những cặp chân dài nhiều gai nhưng bên trong chứa nhiều thịt trắng tuyết rất là thơm ngon. Đây là loại cua lớn nhất, cua trưởng thành mai có thể đạt đến 17 cm. Trung bình một con Cua Hoàng Đế ngày nay có trọng lượng khoảng từ 2kg - 4kg.</p><p>Cua hoàng đế sống ở nhiệt với độ sâu 200-400m ở vùng biển Alaska, độ mặn và độ lạnh khoảng dưới 5 độ. Được đánh bắt tại vùng biển sâu và lạnh ở biển Bắc Thái Bình Dương, vùng biển Alaska. Với vùng biển khí hậu lạnh giá và sâu như vậy thì đó là nơi sinh sống lý tưởng của loại cua này.</p><blockquote><p><strong>🤗 Đảo Gợi Ý Nước Chấm Ngon, Sốt Chế Biến Cực Kì Bắt Vị</strong></p><p></p></blockquote><h2><strong>Giá cua hàng đế hôm nay bao nhiêu?</strong></h2><p></p><p>Thường khách hàng sẽ đặt ra những câu hỏi riêng cho mình như: cua hoàng đế bao nhiêu tiền, cua hoàng đế giá bao nhiêu 1kg, cua hoàng đế giá bao nhiêu 1 con nhưng thật chất là tại Đảo Hải Sản đang bán với những biến thể giá cua Alaska như sau:</p><p>Tham khảo giá hiện tại vào thời điểm cuối năm tháng 12/2023 trên thị trường Cua Hoàng Đế đang có giá cụ thể Giá cua hoàng đế đỏ đực được bán tại Đảo Hải Sản là:</p><p>- Size Cua King Crab (cua hoàng đế) &nbsp;&lt;2kg giá 1850k/kg</p><p>- Size Cua King Crab (cua hoàng đế) &gt; 2kg giá 1990k/kg</p><p><em>Để chính xác hơn bạn có thể xem giá trực tiếp bên trên, vì Đảo sẽ cập nhật giá tốt nhất mỗi ngày cho khách hàng.</em></p><p></p><p>&nbsp;Ngoài giá cực tốt ra Đảo có chính sách cam kết đổi trả hàng dành riêng cho Cua hoàng đế đực&nbsp;đỏ (king crab đỏ):&nbsp;\"Chính sách&nbsp; kết Cua Hoàng Đế tại Đảo Hải Sản\":&nbsp;</p><p>&nbsp;🦀 Tỷ lệ thịt &lt; 80% - 90%&nbsp;🌟 Mức hỗ trợ từ 10% - 20%&nbsp;🦀 Tỷ lệ thịt dưới 80%&nbsp;&nbsp;🌟 Mức hỗ trợ từ 30% - 50%&nbsp;🦀 Cua nhiều nước vượt mức bình thường&nbsp;🌟 Cân nhắc hỗ trợ 10 - 15%</p><h2><strong>Giá trị dinh dưỡng của cua hoàng đế</strong></h2><p>Cua hoàng đế có hàm lượng Canxi cao rất tốt cho sự phát triển của trẻ, người lớn tuổi. Đặc biệt hàm lượng đạm, một số khoáng chất khác rất có lợi.&nbsp;Cua khi nấu chín có vị ngọt, hơi béo, mùi thơm lan toả gian bếp. Từng sớ thịt đầy và chắc từng que.</p><p></p><p><em>Cua khi nấu chín có vị ngọt, hơi béo, mùi thơm lan toả gian bếp. Từng sớ thịt đầy và chắc từng que.</em></p><h2><strong>Cua hoàng đế mua ở đâu tại TPHCM</strong></h2><p>Để cảm nhận được vị tươi ngon đẳng cấp của Cua Hoàng Đế bạn phải chọn mua cua còn tươi sống, do đó bạn hãy tìm những nơi bán hải sản uy tín có hồ chứa cua hoàng đế, giấy phép nhập khẩu rõ ràng. Cua hoàng đế luôn có quanh năm nhưng rơi vào mùa khai thác chính yếu &nbsp;khoảng tháng 10 và tháng 11 thì giá của Cua sẽ rẻ hơn những tháng khác trong năm.</p><p></p><p><em>Cua Hoàng Đế về ngập hồ Đảo Hải Sản</em></p><p>Nếu quý khách đang tìm mua Cua Hoàng Đếtươi sống chất lượng tại Tp. HCM thì nhớ ghé ĐẢO nhé. ĐẢO HẢI SẢN là đơn vị cung cấp Cua Hoàng Đế giá sỉ chất lượng giao nhanh 2h tại Tp. HCM.&nbsp;Cua tại ĐẢO được chọn lọc kỹ càng và luôn đảm bảo chất lượng khi giao đến tay Khách hàng.</p><p></p><p><em>ĐẢO HẢI SẢN cung cấp Cua Hoàng Đế chất lượng giao nhanh 2h tại Tp. HCM</em></p><p>Hãy an tâm tin dùng tại Đảo Hải Sản bởi vì:</p><ul><li><p>Giao sống tận nơi&nbsp;</p></li><li><p>Được kiểm tra hàng trước khi nhận&nbsp;</p></li><li><p>Sản phẩm an toàn, có nguồn gốc rõ ràng</p></li><li><p>Nguồn hải sản phong phú với hơn 300 loại.</p></li></ul><p></p><h2><strong>Chính sách giao hàng và đổi trả tại TPHCM và các tỉnh&nbsp;</strong></h2><p></p><p></p><p>ĐẢO HẢI SẢN luôn mong muốn Quý Khách hài lòng khi sử dụng Cua Hoàng Đế.&nbsp;Nếu trong quá trình sử dụng Cua Hoàng Đế có bất cứ vấn đề nào về chất lượng, vui lòng chụp ảnh/quay video sản phẩm gồm PHẦN CHÂN + THÂN + SỐ SEAL (nếu có) khi dùng và phản hồi bên em trong vòng 12h.</p><p></p><h2><strong>Hình thức thanh toán đối với khách hàng ở Tỉnh hoặc TPHCM</strong></h2><p>Cua king crab có thể s.ống khỏe được từ 4-6 tiếng kể từ lúc giao hàng nên rất phù hợp cho biếu tặng hoặc mang đi xa. Khách hàng ở tỉnh Đảo sẽ cân hàng gửi khách xem hình hoặc vi deo trọng lượng số kg bao nhiêu và gửi kèm bill có tổng tiền chính xác. Hình thức thanh toán chuyển khoản ngân hàng, quét QR Momo hoặc Vn Pay.</p><h2><strong>Cua Hoàng Đế King Crab chế biến món gì ngon?</strong></h2><p>Cua King Crab chế biến được nhiều món ngon, Đảo gợi ý 7&nbsp;cách chế biến đơn giản nhất nhưng giữ được hương vị thuần túy đặc trưng của cua hoàng đế Alaska này. Cua King Crab sau khi hấp chín có màu đỏ cam rất bắt mắt, mùi thơm đặc trưng.</p><h3><strong>Cua hoàng đế nướng sốt bơ tỏi</strong></h3><p>Món này sẽ dễ dàng chinh phục được nhiều thực khách từ trẻ tuổi tới lớn tuổi. Món sốt bơ tỏi sẽ khiến không gian bữa ăn trở nên thơm và gắn kết với nhau.&nbsp;</p><p>Sốt bơ thơm đặc trưng kết hợp vị nồng &nbsp;thơm từ tỏi, khi hòa quyện với cua hoàng đế tươi sống, chắc chắn sẽ làm bạn bùng nổ vị giác</p><p></p><h3><strong>Cua hoàng đế sốt cajun&nbsp;</strong></h3><p>Vị cay nhẹ nhẹ, như 1 chất kích thích dành cho các tín đồ mê hải sản. Loại sốt nằm trong TOP sự kết hợp hoàn hảo dành cho hải sản.&nbsp;</p><p>Tưởng tượng xem 1 con cua King Crab với thịt càng ú ụ thấm đầy sốt. Khi ăn bạn sẽ cảm nhận rõ vị sốt, sau đó sẽ là lớp thịt cua dày và ngọt tươi từ hải sản.</p><p></p><h3><strong>Cua hoàng đế sốt ngũ vị&nbsp;</strong></h3><p>Ngũ vị thường được dùng nhiều trong các món ăn Việt gồm các hương vị đặc trưng gồm : cay, mặn, the, nồng, chua,.. Nhưng nếu kết hợp với 1 loại hải sản nhập khẩu sẽ thế nào nhỉ ?&nbsp;</p><p>Ẩm thực là 1 chuyến phiêu lưu nâng tầm trải nghiệm khẩu vị của từng thực khách, vì thế hãy thử trải nghiệm sự kết hợp gia vị Việt và hải sản nhập khẩu này nhé !</p><p></p><p><strong>Cua hoàng đế nướng mỡ hành</strong></p><p>Cách chế biến vô cùng đơn giản và thân thuộc khi khách chẳng biết sẽ nấu món gì cho ngon - nhanh - gọn thì chỉ với 4 nguyên liệu gồm : muối, đường, hành lá, dầu ăn.</p><p>Thế là đã có chén mỡ hành ngon ngất ngây, nướng cùng cua King Crab. Đơn giản nhưng vị không tầm thường đâu nhá.</p><p></p><p><strong>Cua hoàng đế chiên cơm</strong></p><p>Ăn uống thì không thể bỏ qua cơm, món ăn quốc gia của người Việt.</p><p>Bạn hãy tách lấy 1 ít thịt ở chân cua, chiên với cơm kèm 1 ít gia vị, nhớ tận dụng mai cua để trang trí. Thế là món ăn với phong cách bàn tiệc siêu xịn ra đời.</p>', 4900000, 38, 62, 0, 0, 'crab', 0, '2025-03-14 10:18:03', '2025-03-19 01:22:28'),
(38, 'Ghẹ Xanh Sống Size 4-5 Con/kg', '<p><strong>Ghẹ xanh</strong> là một loài hải sản được nhiều người ưa thích. Mặc dù có nhiều loại như ghẹ hoa, ghẹ đỏ, ghẹ ba chấm... nhưng ghẹ xanh được đánh giá là có giá trị hơn cả vì to và cho thịt ngọt, thơm.</p><p><strong>Ghẹ xanh</strong> của ĐẢO là ghẹ xanh chất lượng tại Việt Nam bởi nó là ghẹ từ vùng biển Phan Thiết. Có thể bạn sẽ hỏi là tại sao là ngon nhất Việt Nam? Đó là vì ghẹ xanh đạt chất lượng tốt nhất ở vùng biển có độ mặn từ 25-31%, ở vùng nước sâu từ 4-10m, có đáy là cát, cát bùn, cát bùn có san hô chết. Nên là ghẹ xanh Phan thiết có thể nói là loại ghẹ ngon nhất trên toàn đất nước cờ đỏ sao vàng chúng ta</p><p><strong>Ghẹ xanh</strong>&nbsp;với đặc điểm càng to, sống khỏe cho nên thịt ghẹ rất chắc, ngọt, thanh mát.</p><p>Ở nước ta, ghẹ s.ống chủ yếu phân bố nhiều ở các vùng biển và đảo xa bờ, đặc biệt là vùng biển Phan Thiết, Nha Trang.&nbsp;</p><p><strong>Ghẹ xanh</strong>&nbsp;có tới 15g protein, tương đương với 30% trong thành phần dinh dưỡng trong một ngày mà con người cần phải đảm bảo mỗi ngày. Ngoài ra còn có&nbsp;axit béo omega-3 tự nhiên rất tốt cho sức khỏe.</p><p>Thịt ghẹ sống<strong>&nbsp;</strong>có vị ngọt, mặn, tính bình, không độc, có tác dụng thanh nhiệt, sinh huyết, tán ứ, giảm đau, thông kinh lạc, bổ xương tủy, rất tốt cho cơ thể đang phát triển ở trẻ nhỏ và tình trạng suy yếu ở người cao tuổi.</p><h2><strong>Đảo Hải Sản đơn vị bán ghẹ sống chất lượng tại TPHCM</strong></h2><p>Nếu bạn có nhu cầu mua ghẹ xanh chất lượng tại thành phố Hồ Chí Minh, đừng ngại hãy tự tin nhấc máy gọi, nhắn ngay cho Đảo, hoặc có thể order ngay trên website của Đảo. Đảo Hải Sản chúng tôi tự tin là đơn vị bán ghẹ sống chất lượng tại TPHCM. Nếu sản phẩm được giao tới tay quý khách kém chất lượng, Đảo cam kết đổi 1-1 cho tất cả khách hàng.</p><h2><strong>Chính sách giao hàng và đổi trả tại TPHCM và các tỉnh</strong></h2><p>ĐẢO HẢI SẢN chuyên cung cấp hải sản dưới nhiều hình thức tùy vào khoảng cách giữa các khu vực trong hay ngoài trung tâm TP.HCM.&nbsp;</p><p>Nội thành: Miễn phí vận chuyển cho đơn hàng từ 700.000đ áp dụng với các quận 1, 3, 4, 5, 6,7, 10, 11, Tân Bình, Phú Nhuận, Bình Thạnh, Gò Vấp.&nbsp;</p><p>Các quận xa trung tâm: Ngoài các quận trên, bộ phận tư vấn khách hàng sẽ xác nhận với khách hàng trước khi tiến hành xử lý đơn hàng. Đối với các khu vực xa trung tâm TP.HCM, phí vận chuyển sẽ từ 30.000đ hoặc hơn tùy vào từng khu vực giao hàng. Mỗi khu vực sẽ có chính sách giao hàng khác nhau, để biết thêm thông tin chi tiết, bạn có thể đặt câu hỏi với các nhân viên tư vấn để giải đáp mọi thắc mắc.</p><p>Giao hàng tại các tỉnh: có các hình thức giao hàng như gửi hàng bằng xe khách (chỉ nhận giao hàng từ đơn hàng 1,5 triệu trở lên) hoặc gửi hàng bằng đường hàng không (chỉ nhận giao hàng từ 2 triệu trở lên). Khi gửi bằng các hình thức dưới đây, quý khách nên trao đổi thật kỹ với nhân viên tư vấn để biết rõ thông tin giao nhận hàng và các chi phí vận chuyển bằng cách liên hệ qua hotline hoặc inbox trực tiếp trên fanpage (Facebook).</p><h2><strong>Hình thức thanh toán đối với khách hàng ở Tỉnh hoặc TP.HCM</strong></h2><p>Đối với các đơn hàng không nhận tại TP.HCM, quý khách cần thanh toán trước 100% hóa đơn để ĐẢO tiến hành quá trình giao hàng.</p><p>Một số món ăn ngon từ ghẹ xanh Phan Thiết:</p><p>Với ghẹ sống Phan Thiết chắc thịt được ĐHS giao tận nhà, sẽ giúp bạn nấu món Bánh canh Ghẹ đãi gia đình tuyệt ngon.</p><p>Hoặc bạn có thể làm những món nhậu đơn giản như ghẹ hấp bia, ghẹ nướng đều ngon tuyệt. Bạn sẽ cảm thấy ngay vị tươi, vị chắc của thịt ghẹ và trứng, gạch ghẹ béo ngậy.</p>', 650000, 25, 975, 0, 0, 'crab', 0, '2025-03-14 10:26:44', '2025-03-19 01:22:28'),
(39, 'Cua Thịt Cà Mau Sống', '<h2><strong>Cua Cà Mau</strong></h2><p>Cua Thịt Cà Mau là loại cua nổi tiếng ở nước ta. Cua được Đảo Hải Sản thu mua chính gốc tại Cà Mau được vận chuyển lên trực tiếp trong ngày hàng, cam kết chất lượng và tươi ngon từ nguồn bà con nông dân nuôi trồng. Cua thịt là một trong những loại hải sản dinh dưỡng được yêu thích bậc nhất tại vùng đất Cà Mau bởi chất thịt ngọt, chắc và đầy dinh dưỡng.</p><p>Cua Cà mau hiện nay thì có rất nhiều nguồn nhập nên giá cả trên thị trường đôi lúc sẽ hỗn loạn, nhưng ở Đảo không thế, Đảo nhập hàng chất lượng từ nguồn với giá bán đầu ra tốt nhất khi đến tay khách hàng. Cua chất lượng thì không thể có giá xoàng xoàng vài chục ngàn, ở đây Đảo sẽ giữ mọi thứ ở mức cân bằng để khi tung ra thị trường khách hàng sẽ luôn dễ dàng đón nhận nhất.</p><p><strong>Cua thịt nhà Đảo gửi đến khách sẽ trông như thế này, đảm bảo uy tín cho Cua sống tươi rói chưa ạ ?</strong></p><h2><strong>Thế nào là Cua thịt Cà mau ngon ?</strong></h2><p><strong>Vỏ ngoài cứng, màu sắc đậm</strong>: Những con cua thịt ngon thường có vỏ ngoài cứng cáp, màu sắc xanh đậm. Cua vỏ cứng và càng to thường có nhiều thịt, chắc và ngọt hơn.</p><p><strong>Càng cua chắc, có màu đục</strong>: Càng cua đầy, màu đục và không có vết nứt là dấu hiệu cua khỏe và nhiều thịt.</p><p><strong>Chân cua cử động linh hoạt</strong>: Cua ngon thường cử động linh hoạt, phần chân chắc và khỏe khi sờ vào. Nếu cua còn sống, càng và chân chắc chắn, không mềm hoặc rũ.</p><p><strong>Yếm cua đầy đặn</strong>: Yếm cua (phần dưới bụng) dày và chắc chứng tỏ cua đã tích lũy được nhiều thịt. Cua có yếm tam giác, không bị lõm thường chứa lượng thịt cao và ngọt tự nhiên.</p><p><strong>Trọng lượng cua nặng tay</strong>: Cua thịt ngon sẽ có trọng lượng nặng so với kích thước, cho thấy cua đầy thịt và không bị óp. Khi cầm cua lên, cua chắc tay và không rỗng là một dấu hiệu cua nhiều thịt.</p><p><strong>Cua thịt Cà Mau bao bì mới, chất lượng không đổi</strong></p><p><strong>5 TIPS chọn Cua thịt ngon</strong>&nbsp;</p><ul><li><p><strong>Quan sát yếm cua</strong>: Chọn cua có yếm (phần bụng dưới) to, tròn và đầy đặn. Yếm càng dày chứng tỏ cua đã tích lũy nhiều thịt, thịt cua sẽ chắc và ngọt hơn.</p></li><li><p><strong>Kiểm tra vỏ cua</strong>: Nên chọn cua có vỏ ngoài cứng, màu xanh đậm, đặc biệt là phần càng và mai. Cua với lớp vỏ cứng thường là cua trưởng thành, chứa lượng thịt cao.</p></li><li><p><strong>Thử ấn vào thân và càng cua</strong>: Cua thịt ngon sẽ có phần thịt ở thân chắc, khi ấn vào không bị lõm. Càng cua đầy đặn và có màu đục là dấu hiệu cua nhiều thịt.</p></li><li><p><strong>Kiểm tra chân và càng cua</strong>: Chọn cua có chân và càng chắc chắn, cử động linh hoạt nếu là cua sống. Cua có chân và càng rũ thường là cua yếu hoặc thịt ít.</p></li><li><p><strong>Cầm cua lên để cảm nhận trọng lượng</strong>: Cua thịt ngon thường nặng tay hơn so với kích thước, cho thấy cua đầy thịt và không bị rỗng.</p></li></ul><p>Khách hàng nên lựa chọn nơi bán uy tín đi cùng chất lượng để đảm bảo được sức khỏe của cả gia đình. Lưu ý khi mua cua, hãy chọn những con còn sống khỏe. Vì cua chết, trên cơ thể của chúng chứa nhiều vi khuẩn độc hại sẽ xâm nhập với phần thịt cua làm cho người dùng bị ngộ độc có biểu hiện như đau bụng, buồn nôn, đi ngoài nhiều. Cho dù cua mang lại nhiều chất dinh dưỡng tốt nhưng vẫn hạn chế ăn quá nhiều vì sẽ làm đầy bụng và tuyệt đối không được dùng những còn đã chết</p>', 215000, 14, 986, 0, 0, 'crab', 0, '2025-03-14 10:30:04', '2025-03-19 01:22:28'),
(40, 'Ốc Hương Sống (Size 100 - 110 con)', '<p>Ốc Hương Cồ Sống là một trong những loại ốc hương được biết đến với hình dáng hơi dài và mỏng hơn so với ốc hương thông thường. Vỏ của Ốc Hương có màu nâu sáng và có đường gân màu sẫm chạy dọc theo vỏ. Thịt của Ốc Hương có màu trắng sữa, giòn và ngọt đặc trưng có thể chế biến thành nhiều món ăn hấp dẫn</p><p>Ốc Hương size lớn là loại hải sản được ưa chuộng trong ẩm thực Việt Nam. Ốc Hương loại 1&nbsp;có kích thước to, bự, sống nguyên con được đánh bắt từ thiên nhiên. Đây là nguyên liệu không thể thiếu trong các điểm bán hoặc nhà hàng kinh doanh hải sản.</p><p><em>Size ốc hương trong hình 100-110con/kg</em></p><h2><strong>Giá trị dinh dưỡng của Ốc Hương size lớn&nbsp;</strong></h2><p>Ốc Hương Cồ Sống có hàm lượng dinh dưỡng cao, bao gồm các loại vitamin, khoáng chất và các dinh dưỡng quan trọng khác. Ốc Hương chứa một lượng lớn protein, cung cấp cho cơ thể các axit amin cần thiết giúp cải thiện các tế bào trong cơ thể.</p><p>Canxi có trong Ốc Hương rất tốt cho cấu trúc xương và răng của chúng ta. Sắt trong ốc hương là một khoáng chất cần thiết cho quá trình sản xuất hồng cầu, giúp cung cấp oxy đến các tế bào trong cơ thể.</p><p>Ốc Hương cũng chứa một lượng nhất định của các axit béo omega-3 có lợi cho sức khỏe tim mạch, giảm cholesterol và có khả năng giảm nguy cơ mắc các bệnh về tim mạch. Ngoài ra, Ốc Hương cung cấp cho cơ thể một lượng tốt các chất xơ cần thiết cho cơ thể, giúp hỗ trợ quá trình tiêu hóa.</p><p><em>Ốc hương ăn ngọt và thơm , làm nhiều món ăn ngon hấp dẫn và giàu dinh dưỡng</em></p><h2><strong>Ăn Ốc Hương Cồ Sống Nhiều Có Tốt Không?</strong></h2><p>Với giá trị dinh dưỡng cao, Ốc Hương là một nguồn thực phẩm khá tốt để bổ sung các chất dinh dưỡng cần thiết cho cơ thể. Tuy nhiên, như với bất kỳ loại thực phẩm nào, người tiêu dùng nên sử dụng Ốc Hương với mức độ hợp lý và kết hợp với một chế độ ăn uống lành mạnh và cân bằng.&nbsp;</p><h2><strong>Ốc Hương bao nhiêu 1kg Size to khủng loại 1</strong></h2><p>Giá của Ốc Hương Loại 1 có thể thay đổi tùy vào địa điểm, mùa vụ và nguồn cung cấp. Tuy nhiên, trung bình giá của Ốc Hương loại 1 thường dao động từ 500.000 - 700.000 đồng cho 1 kg. Để biết giá chính xác vào thời điểm hiện tại, bạn có thể liên hệ với các địa điểm bán hải sản uy tín tại địa phương để biết thêm thông tin giá.</p><p><em>Ốc Hương tươi sống tại Đảo Hải Sản</em></p><p>Gợi ý một số món ăn hấp dẫn từ Ốc Hương Loại 1: Vì có kích thước lớn nên khi chế biến cùng các món ăn, sẽ giúp làm tăng thêm hương vị đặc trưng của Ốc Hương. Ngoài các món ăn ta thường thấy ở các quán ăn hay thậm chí tại những mâm cơm gia đình, món ăn Ốc Hương hấp sả hay nướng mọi luôn là lựa chọn tốt và an toàn để thưởng thức.&nbsp;</p><p>Sau đây là một số món ăn từ Ốc Hương mà mọi người có thể trải nghiệm thử: Ốc Hương nướng mỡ hành, Ốc, Hương xào sốt phô mai, Ốc Hương xào sốt trứng muối, Ốc Hương xào me, Ốc Hương xào bơ&nbsp;bắp, Ốc Hương rang muối.</p>', 245000, 36, 964, 0, 0, 'scallop', 0, '2025-03-14 10:33:25', '2025-03-19 03:25:42'),
(41, 'Bào Ngư Hàn Quốc Sống', '<p><em>Bào ngư là một lọai hải sản nổi tiếng vì độ thơm ngon bổ dưỡng, và nguồn dinh dưỡng quý giá mà chúng mang lại. Vậy đặc điểm của bào ngư, công dụng và cũng như giá thành hiện nay của bào ngư như thế nào, hãy cùng Đảo tìm hiểm qua bài viết sau.</em></p><h2><strong>Bào ngư Hàn Quốc</strong></h2><p>Nhắc đến bào ngư, mọi người đều liên tưởng đến những món ăn cao cấp. xa xỉ thường xuất hiện trong các bữa tiệc của các bậc vua chúa, vương giả thời xa xưa. Hiên nay bào ngư đã trở nên phổ biến hơn, do sự phát triển thuận lơi của đánh bắt, nuôi trồng, sản phẩm trở nên đa dang mức giá, cho khách hàng có nhiều lựa chọn.</p><h2><strong>Đặc điểm của bào ngư Hàn Quốc</strong></h2><p>Bào ngư Hàn Quốc là một dạng động vật thân mềm, thuộc dòng họ nhà ốc. Chúng sống bám ở các vác đá ven, nơi các vùng nước sâu có mặn cao từ 2-3%, nhiệt độ nước từ 26 -300 C là môi trường thuận lợi cho bào ngư phát triển.</p><p><em>Bào ngư Hàn Quốc tươi sống tại Đảo Hải Sản</em></p><p>Ở những nơi càng sâu và độ lạnh càng thấp thì thịt bào ngư càng giòn, ngọt và chắc hơn. Khi bào ngư phát triển lớn hơn, chúng sẽ bò ra xa bờ hơn, trốn thật sâu trong các vách đá. Vì thế những bào ngư kích thước lớn thường có giá thành cao do rất khó đánh bắt, đòi hỏi sự khéo léo, kiên trì của người thợ.</p><p>Ở Hàn Quốc, bào ngư thuộc đảo Jeju được xem là đặc sản nổi tiếng, được nhiều người biết đến , với môi trường ở đảo Jeju mát quanh năm nên vô cùng thuận lợi cho bào ngư phát triển.</p><h2><strong>Dinh dưỡng và lợi ích của bào ngư</strong></h2><h3><strong><em>Dinh dưỡng từ bào ngư Hàn</em></strong></h3><p>Bào ngư có chứa nhiều thành phần gồm chất đạm, đường, chất béo, cholesterol, vitamin B1, B2, A, K… và các khoáng chất (canxi, kẽm, sắt). Lượng cholesterol trong bào ngư khá cao nhưng không gây ảnh hưởng nhiều cho cơ thể do có sự cân bằng trong các thành phần dinh dưỡng khác.</p><p><em>Bào ngư Hàn Quốc sống chất lượng tại Đảo Hải Sản</em></p><p>Chất đạm cũng có đủ 19 loại axit amin thiết yếu cho cơ thể như Threonin; Isoleucin; Valin ; axit glutamic.</p><h3><strong><em>Bào ngư đem lại nhiều lợi ích cho cơ thể:</em></strong></h3><ul><li><p>Hỗ trợ chức năng trao đổi chất của gan, ngăn ngừa các tổn thương do bia rượu gây nên.</p></li><li><p>Giúp tăng cường hệ miễn dịch nhờ hàm lượng axit béo cao, tăng cường hoạt động của các tế bào bạch cầu từ đó làm tăng phản ứng miễn dịch của cơ thể.</p></li><li><p>Hỗ trợ lưu thông máu, giảm năng lượng, hạn chế mệt mỏi</p></li><li><p>Hàm lương vitamin A dồi dào giúp đôi mắt sáng, khỏe, ngăn ngừa một số bệnh về mắt như quáng gà, đục thủy tinh thể,....</p></li><li><p>Làm giảm đau khớp, viêm, hao mòn xương khớp do tuổi tác.</p></li></ul><h2><strong>Giá bào ngư Hàn Quốc</strong></h2><p>Trên thị trường hiện nay bào ngư có nhiều loại: bào ngư Việt Nam, bào ngư Úc, bào ngư Hàn Quốc, nhưng ngon và rẻ nhất hiện nay phải kể đến bào ngư Hàn Quốc – loại bào ngư được ưu chuộng nhất hiện nay.</p><p>Tùy theo size , nguồn nhập giá bào ngư Hàn Quốc trên thị trường có thể dao động từ 1,1 tr đến 1,4 tr/kg, đây là mức giá trung bình phù &nbsp;hợp với nhu cầu hải sản hiện nay, size bào ngư Hàn Quốc có thể đa dạng trong khoản 10 - 12, 13 -15 hoặc 16 -18 con/kg , khung size đa dạng nên mức giá sản phẩm cũng có sự chênh lệch.</p><p>Hiện nay trên thị trường có rất nhiều nơi bán bào ngư với mức giá rẻ, tuy nhiên bên cạnh đó khách hàng cần chú trọng hơn hết chính là chất lượng của sản phẩm, nên tìm hiểu kĩ những điểm bán uy tín, mua về những sản phẩm thật chất lượng cho gia đình.</p><p>Đảo Hải Sản là một gợi ý phù hợp cho khách hàng muốn tìm kiêm một nơi mua hàng úy tín, chất lượng. Khách hàng luôn yên tâm vì các sản phẩm có giấy tờ nhập khẩu đầy đủ, cùng nhiều cam kết rõ ràng , giao hàng tươi sống trong 2H, giờ đây khách không cần đi xa nhưng vẫn có thể thưởng thức hải sản tuơi ngon.</p><p><em>Video Bào ngư tươi sống tại các cửa hàng trên TPHCM của Đảo Hải Sản</em></p><h2><strong>Hướng dẫn sơ chế bào ngư sống Hàn Quốc</strong></h2><p>Dùng bàn chải đánh răng sạch là tốt nhất, chà xung quanh mép bào ngư, sau đó dùng dao nhọn tách vỏ bào ngư ra và cắt phần ruột đen phía dưới bỏ đi. Rửa sạch lại một lần nữa bằng nước là xong.</p><p><em>Sau khi bào ngư được sơ chế sạch</em></p><p><strong>Bảo quản :</strong>&nbsp;Nếu sử dụng không hết cho một lần, bạn nên để<strong> Bào ngư</strong> vào ngăn đá tủ lạnh. Sản phẩm sẽ bảo quản được 30 ngày thì chất lượng dinh dưỡng không thay đổi.</p><p><em>Bào ngư Hàn Quốc tươi sống tại nhiều cửa hàng</em></p><p><strong>Bào ngư Hàn Quốc</strong>&nbsp;khi mua về có thể chế biến thành nhiều món khác nhau như: Sashimi, sốt dầu hào, cháo, soup bào ngư, các món hầm với bào ngư, nướng mỡ hành, nướng phô mai,..</p><p>Video hướng dẫn Sơ chế Bào Ngư đơn giản tại nhà</p><h2><strong>Những món ăn ngon từ bào ngư</strong></h2><p>Khi đã có được nguồn nguyên liệu tươi ngon, thì việc chế biến được các món ăn ngon cũng là điều quan tâm không kém của khách.</p><p>Món đầu tiên phải kể đến là sashimi bào ngư, khi mua về chúng ta sử dụng bàn chải đánh răng sạch chà xung quanh mép bào ngư, sau đó dùng dao nhọn tách vỏ bào ngư ra và cắt phần ruột đen phía dưới bỏ đi. rửa sạch và cắt lát từng miêng chấm kèm tương Nhật và wasabi.</p><p>Với những chia sẻ chi tiết về bào ngư, và giá trị của sản phẩm, hi vọng khách hàng có thêm nhiều thông tin về sản phẩm cũng như đã cập nhật thêm một nơi bán hải sản, và thật sự an tâm khi lựa chọn cho gia đình, người thân.</p><h3><strong><em>Một số hình ảnh món ăn được chế biến từ Bào Ngư Hàn Quốc:</em></strong></h3><p><strong><em>Cháo Bào Ngư&nbsp; bổ dưỡng và tốt cho sức khỏe</em></strong></p><p><strong><em>Soup Bào Ngư Hàn Quốc bổ dưỡng và tốt cho sức khỏe</em></strong></p><p><strong><em>Bào ngư Hàn Quốc hấp chấm muối xanh ăn ngon, thịt tươi giòn sần sật</em></strong></p>', 69000, 52, 948, 0, 0, 'abalone', 0, '2025-03-14 10:36:01', '2025-03-19 01:22:28'),
(42, 'Vẹm Xanh Sống', '<p>Vẹm xanh là loài hải sản tốt cho sức khỏe, đây là loài hải sản khá xa lạ với nhiều người nên vì vậy có rất nhiều câu hỏi về vẹm xanh như cách lựa vem xanh ngon, cách sơ chế vẹm xanh. Lợi ích của vẹm xanh là gì ? và còn nhiều câu hỏi khác nữa cùng Đảo đi tìm hiểu về loài hải sản này nhé!</p><h2><strong>Vẹm xanh là con gì ?</strong></h2><p>Vẹm xanh có tên khoa học là Perna Viridis. Nó thuộc họ nhuyễn thể bao gồm hai mảnh và có mặt hầu hết ở khắp các vùng biển trên thế giới. Loại vẹm xanh này thường được tìm thấy ở các vùng biển Thái Bình Dương, nhưng lại thường rất phổ biến ở New Zealand.</p><p>Vẹm xanh trông giống họ nhà Nghêu nhưng lại có kích thước dài hơn nghêu. Giống với tên gọi Vẹm xanh sẽ thường có màu xanh dương hoặc xanh lá. Khi lớn sẽ có màu đen ánh nâu.</p><p>Ngoài ra, vẹm xanh thường phát trưởng ở các vùng nước lợ với độ sâu từ 10m, sống thành chùm bám vào các rạn đá, sỏi, gỗ hay cụm san hô.</p><h2><strong>Các loại vẹm xanh</strong></h2><p>Ở trong nước nổi tiếng với vẹm xanh Đồ Sơn, còn các loại vẹm xanh nhập khẩu có thể kể đến như vẹm xanh Chile, vẹm xanh New Zealand,....</p><h3><strong><em>Vẹm xanh Chile</em></strong></h3><p>Có thịt khá dày và sạch ít cát, thịt ngọt và độ béo tự nhiên nên rất được ưa chuộng ở các nhà hàng.</p><h3><strong><em>Vẹm xanh New Zealand</em></strong></h3><p>Vẹm xanh New Zealand to và rất nổi tiếng, thường được bảo quản bằng cách tách 1 bên vỏ và cấp đông.</p><h3><strong><em>Vẹm xanh Đồ Sơn</em></strong></h3><p>Rất được ưa chuộng vì là loài đánh bắt tự nhiên, thịt rất ngọt vị tự nhiên, do là đánh bắt theo mùa nên có giá cao.</p><h2><strong>Con vẹm mang lại lợi ích về cho con người&nbsp;</strong></h2><h3><strong><em>Hỗ trợ điều trị xương khớp&nbsp;</em></strong></h3><p>Vẹm xanh có một công dụng rất tốt là trị bệnh xương khớp. Có một vài nghiên cứu được thử nghiệm trên người bị viêm xương khớp cho ra kết quả, sau khi dùng vẹm xanh đều đặn trong 1 tháng, có hơn 1 nửa số người bệnh có dấu hiệu giảm và tăng chức năng vận động của xương khớp.</p><h3><strong><em>Phòng chống nguy cơ loãng xương</em></strong></h3><p>Thường xuyên sử dụng vẹm xanh sẽ giúp phòng chống được nguy cơ loãng xương. Ở bên trong vẹm xanh có rất nhiều chất dinh dưỡng và hợp chất hữu cơ tốt cho cơ thể. Không những giúp phòng ngừa loãng xương mà còn làm xương chắc khỏe.</p><h3><strong><em>Tăng cường sức đề kháng&nbsp;</em></strong></h3><p>Tác dụng khác của vẹm xanh còn giúp cải thiện sức đề kháng của cơ thể. Vẹm xanh có nhiều chất kháng khuẩn tự nhiên giúp cơ thể hình thành kháng thể. Vì vậy, ăn vẹm xanh thường xuyên hệ miễn dịch sẽ hoạt động mạnh mẽ hơn.</p><h3><strong><em>Cải thiện làn da&nbsp;</em></strong></h3><h3><strong>Ngoài các công dụng trên vẹm xanh còn giúp cải thiện sức khỏe da, tóc, móng… Vì vẹm xanh có chứa nhiều vitamin, khoáng chất và omega-3 tốt cho sức khỏe.</strong></h3><h3><strong><em>Lựa chọn vẹm xanh đúng cách</em></strong></h3><p>Để chọn những con vẹm xanh ngon, bạn cần chú ý đến phần vỏ của vẹm xanh nên chọn những con vẹm đang còn nguyên vẹm vỏ không bị sứt mẻ gì.</p><p>&nbsp;Khi thấy vẹm mở vỏ có thể lấy tay đụng vào miệng vỏ nếu nó đóng vỏ lại thì chứng tỏ con vẹm đó còn rất tươi ngon.<br>Nếu muốn mua vẹm tươi ngon có thể ghé nhà Đảo hoặc đến các cửa hàng hải sản uy tín.</p><h3><strong><em>Tuyệt chiêu sơ chế vẹm xanh</em></strong></h3><p>Cách sơ chế đơn giản đối với vẹm xanh, đem con vẹm đi ngâm với nước lạnh và cho một ít muối vào. Sau khi ngâm nước dùng bàn chải chà lên phần vỏ của con vẹm để loại bỏ cát bụi.</p><p>Sau khi đã chà sạch vỏ, đem vẹm xanh đi ngâm với nước và bỏ thêm một vài lát ớt để vẹm có thể nhả hết cát trong vẹm. Và rửa lại vẹm thêm một lần nữa với nước sạch.</p><h2><strong>Giá vẹm xanh bao nhiêu ? Mua ở Đâu ?</strong></h2><p>Giá con vẹm xanh bao nhiêu tiền? Mua vẹm xanh ở đâu thì tươi ngon và uy tín? Giá con vẹm xanh có cao không? Đây là những câu hỏi mà Đảo thường gặp nhất và hôm nay Đảo sẽ giải đáp thắc mắc của mọi người.</p><p>Giá con vẹm xanh này không quá cao, đây là loài hải sản có giá thành khá ổn đối với mặt bằng chung, giá vẹm xanh Đồ Sơn dao động trung bình khoảng 70.000 - 90.000 đồng/Kg. Còn đối với các loài vẹm xanh nhập khẩu khác như vẹm xanh New Zealand giá vẹm xanh có thể lên tới 250.000 - 320.000 đồng/Kg, đối với giá vẹm xanh Chile rơi vào 170.000 - 250.000 đồng/Kg.</p><p>Đảo Hải Sản là nơi cung cấp vẹm xanh tươi ngon trên thị trường và là nơi uy tín chất lượng. Mọi người sẽ yên tâm mua ở đây vì chất lượng sẽ được đảm bảo có chính sách cam kết đổi trả nếu hàng kém chất lượng.</p><h2><strong>Gợi ý các món ngon từ vẹm xanh</strong></h2><p>Hôm nay Đảo sẽ giới thiệu cho cả nhà một vài món ngon từ vẹm xanh, cả nhà cùng tham khảo nhé !</p><h3><strong><em>Vẹm nướng mỡ hành</em></strong></h3><p>Nhắc đến nướng mỡ hành thì đây là cách làm rất phù hợp với các loài hải sản. Vẹm xanh cũng thế, vẹm nướng mỡ hành có hương vị rất thơm thịt ngọt và có độ béo của mỡ hành hòa quyện với nhau làm cho món ăn rất ngon.</p><h3><strong><em>Con vẹm hấp sả</em></strong></h3><p>Khi nhắc đến Vẹm không thể bỏ qua món hấp sả vì hương thơm nồng nàn của sả kết hợp cùng với vị ngọt từ thịt con vẹm làm cho người ăn khó mà cưỡng lại.</p><h3><strong><em>Vẹm hấp thái</em></strong></h3><p>Nếu mọi người muốn có sự chua chua cay cay thì cũng có thể thử món vẹm hấp thái, khi hấp thái món ăn sẽ có vị chua cay nhẹ hòa quyện với vị ngọt của vẹm tạo nên món ăn tuyệt vời.</p><p>Vậy là Đảo đa giới thiệu cho mọi người một vài món ngon chế biến từ vẹm mọi người có thể áp dụng và chế biến tại nhà cho cả nhà cùng ăn nhé !</p><h2><strong>Cách bảo quản vẹm xanh tại nhà</strong></h2><p>Bên dưới ĐẢO sẽ gợi ý cho Khách yêu các món ăn ngon từ Vẹm xanh tươi. Nhưng trước hết, hãy cùng ĐẢO tìm hiểu cách bảo quản vẹm xanh qua đêm dễ dàng ngay tại nhà nhé!</p><p>Để bảo quản vẹm thì cực kỳ đơn giản, Khách yêu cho vẹm vào túi zip và lưu trữ trong ngăn đông tủ lạnh. Một lưu ý quan trọng khi bảo quản vẹm luôn được thơm ngon, đó là Khách yêu nhỉ nên rã đông lượng vẹm vừa đủ để chế biến món ăn.</p><p>Việc rã đông toàn bộ vẹm, sau đó lại lưu trữ ngăn đông khiến thịt vẹm bị nhớt, mềm, mất đi sự đàn hồi, dai ngon vốn có của con vẹm.</p>', 59000, 41, 959, 0, 0, 'other', 0, '2025-03-14 10:40:47', '2025-03-19 01:22:28'),
(43, 'Ốc Chip Chip - Sò Lụa Sống', '<h2><strong>Ốc Chip Chip</strong></h2><p>&nbsp;</p><p></p><p></p><p></p><p>Ốc Chip Chip s.ống ở vùng đáy cát ven bờ, có hình dạng giống oval dài vỏ ngoài trơn láng có vân hình chữ chi khắp mặt vỏ, vỏ mỏng nhẹ.</p><p></p><blockquote><p><strong>🤗 Sốt Chế Biến Ngon Thường Được Mua Cùng Sò Lụa</strong></p><p></p><h3>Sốt Bơ Cay</h3><p><strong>39,000đ/ Túi 200g</strong></p><h3>Sốt Bơ Tỏi</h3><p><strong>39,000đ/ Túi 200g</strong></p><h3>]Muối Ớt Xanh</h3><p><strong>29,000đ/ Chai 300ml</strong></p><h3>Sốt Bơ Cay</h3><p><strong>39,000đ/ Túi 200g</strong></p><h3>Sốt Bơ Tỏi</h3><p><strong>39,000đ/ Túi 200g</strong></p><h3>[Muối Ớt Xanh</h3><p><strong>29,000đ/ Chai 300ml</strong></p><h3>Sốt Bơ Cay</h3><p><strong>39,000đ/ Túi 200g</strong></p><h3>Sốt Bơ Tỏi</h3><p><strong>39,000đ/ Túi 200g</strong></p><h3>Muối Ớt Xanh</h3><p><strong>29,000đ/ Chai 300ml</strong></p><p></p></blockquote><p>Ốc Chip Chip có tính hàn mát phù hợp với mọi lứa tuổi, thịt ốc có màu trắng vàng cùng hương vị thơm ngon đặc trưng, thịt ốc ngọt giòn ăn rất ngon. Ốc Chip Chip chế biến vừa chín tới là ngon nhất, nếu chín quá thì dễ bị teo thịt và hơi dai. Ốc Chip Chip chế biến những món đơn giản như hấp thái, hấp sả, xóc tỏi, rang me,</p>', 59000, 18, 982, 0, 0, 'scallop', 0, '2025-03-14 10:47:02', '2025-03-19 01:22:28');

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
(82, 29, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741944655/de5nsc67ah56ljuqx6wy.jpg', '2025-03-14 09:31:03'),
(83, 29, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741944660/sl5wlfvnlch6f8kpg0zh.webp', '2025-03-14 09:31:03'),
(84, 29, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741944661/j2jne3bpn1pzkxaqefbn.webp', '2025-03-14 09:31:03'),
(85, 29, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741944662/fozcqgkynzymotbka0vx.webp', '2025-03-14 09:31:03'),
(86, 30, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741945228/ubcnviobvakrtbjphbdz.webp', '2025-03-14 09:40:31'),
(87, 30, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741945226/vmzfy38utzlxvbnnqa3g.jpg', '2025-03-14 09:40:31'),
(88, 30, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741945228/svba4gynakbo03h3awmx.webp', '2025-03-14 09:40:31'),
(89, 30, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741945225/zlchxv2ybzvh9p9g3jso.jpg', '2025-03-14 09:40:31'),
(90, 31, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741945496/lchrumykauhqbq4jfaya.webp', '2025-03-14 09:44:57'),
(91, 31, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741945494/nmmlv0q24vs3muygc2bx.webp', '2025-03-14 09:44:57'),
(92, 31, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741945494/thbgkt2xxefvsl9pnfpx.jpg', '2025-03-14 09:44:57'),
(93, 32, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741945750/qlncps0ihksqwglhlzhc.jpg', '2025-03-14 09:49:14'),
(94, 32, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741945751/ncm7s4owbn0w3njthbui.webp', '2025-03-14 09:49:14'),
(95, 32, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741945752/j5vrsf7g9td9u2jxfir1.jpg', '2025-03-14 09:49:14'),
(96, 32, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741945753/qzsiugpybw3hsabbupgp.webp', '2025-03-14 09:49:14'),
(97, 33, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741945964/xvwnx22zotuht7zppuse.webp', '2025-03-14 09:52:44'),
(98, 33, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741945956/zslidywgu2snhcnbk894.jpg', '2025-03-14 09:52:44'),
(99, 33, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741945955/vr6ymqj9qiv8asxarq4q.jpg', '2025-03-14 09:52:44'),
(100, 33, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741945955/wrtdyfh7f55kl8qv9oer.jpg', '2025-03-14 09:52:44'),
(101, 34, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741946281/eaawm0ybakn5igtk5qdf.jpg', '2025-03-14 09:58:04'),
(102, 34, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741946281/vql3pjqi4hoca12rbuli.jpg', '2025-03-14 09:58:04'),
(103, 34, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741946283/xhxarnkxacf0f29cxktu.jpg', '2025-03-14 09:58:04'),
(104, 34, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741946282/xzcpm8unphzbuizyzyzo.jpg', '2025-03-14 09:58:04'),
(105, 35, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741946582/sfyeefm3unxydrndgdiy.jpg', '2025-03-14 10:03:05'),
(106, 35, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741946583/f9axjristtgufvekphzh.jpg', '2025-03-14 10:03:05'),
(107, 35, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741946582/mpu4xhu5uzr9hq0ecdzt.webp', '2025-03-14 10:03:05'),
(108, 35, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741946583/gceecmhu9bwuzzh8xb0l.jpg', '2025-03-14 10:03:05'),
(109, 36, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741946966/sivoqvgrbokhoiixdrrb.jpg', '2025-03-14 10:09:33'),
(110, 36, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741946972/xs0mszjjoprk8fkar83b.webp', '2025-03-14 10:09:33'),
(111, 36, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741946971/b5xuvjsb8mbg4ysla6sr.webp', '2025-03-14 10:09:33'),
(112, 36, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741946966/h15p2tisp86xi6ydeoav.webp', '2025-03-14 10:09:33'),
(113, 37, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741947477/tmeo2fbcfhgszebvqgeo.webp', '2025-03-14 10:18:03'),
(114, 37, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741947482/cbzn4mbj9ev3uhby5bpe.webp', '2025-03-14 10:18:03'),
(115, 37, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741947477/b9rz5sjyyuuetxhhgy6p.jpg', '2025-03-14 10:18:03'),
(116, 37, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741947478/k7exh2xhztdj58k4t3jf.webp', '2025-03-14 10:18:03'),
(117, 38, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741947998/ydnkqsyzpj4tz9qzntqm.webp', '2025-03-14 10:26:44'),
(118, 38, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741948002/txsc4fg0tbvpri19crmg.webp', '2025-03-14 10:26:44'),
(119, 38, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741947998/dhfwjhs7clueohizxc1k.jpg', '2025-03-14 10:26:44'),
(120, 38, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741947998/mckjtp0laazsaaacecqp.jpg', '2025-03-14 10:26:44'),
(121, 39, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741948199/ojh1pftkdbn2omqt0tri.jpg', '2025-03-14 10:30:04'),
(122, 39, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741948202/torp4zj6ieheob6ds1im.webp', '2025-03-14 10:30:04'),
(123, 39, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741948203/b4ivaw8wzbclbuuc4de6.webp', '2025-03-14 10:30:04'),
(124, 39, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741948202/odbnfrqnafwqx9u0c7qw.webp', '2025-03-14 10:30:04'),
(125, 40, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741948401/p5a1vj40viayo4wvlnbj.jpg', '2025-03-14 10:33:25'),
(126, 40, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741948402/uqv1ogkdpgsuolbzveig.webp', '2025-03-14 10:33:25'),
(127, 40, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741948402/huulwoahpxsk56defxtj.jpg', '2025-03-14 10:33:25'),
(128, 40, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741948404/v2epvcddbkvvuxb0gx6n.webp', '2025-03-14 10:33:25'),
(129, 41, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741948558/yoea48mbfqngalldbecs.jpg', '2025-03-14 10:36:01'),
(130, 41, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741948557/bqpr1ed2ifra06mgsywv.jpg', '2025-03-14 10:36:01'),
(131, 41, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741948559/glgjykqdqixfyrdoplxn.webp', '2025-03-14 10:36:01'),
(132, 41, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741948558/vlph3lzpmvyr5ccvt5vm.jpg', '2025-03-14 10:36:01'),
(133, 42, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741948845/od4chfqegm0fzeuzkt1d.jpg', '2025-03-14 10:40:47'),
(134, 42, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741948845/yx45puykkfir6qus06lr.jpg', '2025-03-14 10:40:47'),
(135, 42, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741948846/uct5hpdifmhk0bowm1ep.webp', '2025-03-14 10:40:47'),
(136, 42, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741948846/emxxce2ilq4v8t05xipa.jpg', '2025-03-14 10:40:47'),
(137, 43, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741949213/j6c0xmxov0u0he7whknf.jpg', '2025-03-14 10:47:02'),
(138, 43, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741949220/ndppwo1q8wbmpi3r8k8s.webp', '2025-03-14 10:47:02'),
(139, 43, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741949213/b0yn9muzt35ghpvvoeww.jpg', '2025-03-14 10:47:02'),
(140, 43, 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741949213/eim1qg2xqjflbq2oyroh.webp', '2025-03-14 10:47:02');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reset_password_codes`
--

CREATE TABLE `reset_password_codes` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `code` varchar(6) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `role`
--

INSERT INTO `role` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2025-03-09 20:18:21', '2025-03-09 20:18:21'),
(2, 'user', '2025-03-09 20:18:21', '2025-03-09 20:18:21'),
(3, 'super_admin', '2025-03-09 20:18:21', '2025-03-09 20:18:21'),
(28, 'nhan_vien1', '2025-03-09 20:27:31', '2025-03-09 20:27:31'),
(29, 'thu_ngan', '2025-03-09 20:58:39', '2025-03-09 20:58:39');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `role_permission`
--

CREATE TABLE `role_permission` (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `role_permission`
--

INSERT INTO `role_permission` (`role_id`, `permission_id`) VALUES
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(1, 14),
(1, 15),
(1, 16),
(1, 17),
(1, 18),
(1, 19),
(1, 20),
(1, 21),
(1, 22),
(1, 23),
(1, 24),
(1, 25),
(1, 26),
(1, 27),
(1, 28),
(1, 29),
(1, 30),
(1, 35),
(1, 36),
(1, 37),
(1, 38),
(1, 39),
(1, 40),
(1, 41),
(1, 42),
(1, 43),
(3, 2),
(3, 3),
(3, 4),
(3, 5),
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
(3, 31),
(3, 32),
(3, 33),
(3, 34),
(3, 35),
(3, 36),
(3, 37),
(3, 38),
(3, 39),
(3, 40),
(3, 41),
(3, 42),
(3, 43),
(28, 2),
(28, 3),
(28, 4),
(28, 5),
(28, 7),
(28, 8),
(28, 9),
(28, 10),
(28, 11),
(28, 12),
(28, 13),
(28, 14),
(28, 15),
(28, 16),
(28, 17),
(28, 18),
(28, 19),
(28, 20),
(28, 21),
(28, 22),
(28, 23),
(28, 24),
(28, 25),
(28, 26),
(28, 27),
(28, 28),
(28, 29),
(28, 30),
(28, 35),
(29, 2),
(29, 35),
(29, 37),
(29, 38),
(29, 39),
(29, 43);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
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
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`id`, `fullName`, `email`, `avatar`, `password`, `role_id`, `status`, `created_at`, `updated_at`) VALUES
(3, 'Nguyễn Minh Thuận', 'thuan18092003@gmail.com', 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1742001194/mqoodm3nt4m42hhlq49a.jpg', '$2y$10$9AxVFVLEhqcRlXhs/9w88.H4bFr5bJzWF9IrhxPWwcuMXs6zhRp4q', 3, 0, '2025-03-09 16:10:52', '2025-03-15 02:05:00'),
(22, 'Anh hoàng', 'anh924571@gmail.com', 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1741809317/whwfvrte2bozdtxbeg0m.jpg', '$2y$10$CWlu2nvw.evnwmmSmjGFHORi5h9dtBkPRLDQbUjXpXxW0MDYq7yV.', 2, 0, '2025-03-13 09:48:43', '2025-03-13 09:48:43'),
(23, 'Nguyễn Thị Ánh', '03.ntanh@gmail.com', 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1742015676/c8rpqw6wk8edghzxo4xg.jpg', '$2y$10$zfLdz4VJTkCeMmZukYg5tet/bC2KGgtxomKTFbY85nJbBcuH/cIEG', 2, 0, '2025-03-16 07:28:11', '2025-03-16 07:28:41'),
(24, '20210533@eaut.edu.vn', '20210533@eaut.edu.vn', 'https://res.cloudinary.com/dsoj3y7wu/image/upload/v1742015676/c8rpqw6wk8edghzxo4xg.jpg', '$2y$10$QXp.7KY8k.gir/oANPVPNu/BK32HIwVy2lqRnPsDA3dC5UIAIkKlW', 29, 0, '2025-03-16 07:41:04', '2025-03-19 03:21:16');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `verification_codes`
--

CREATE TABLE `verification_codes` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `code` varchar(6) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `blacklisted_tokens`
--
ALTER TABLE `blacklisted_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `discount`
--
ALTER TABLE `discount`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `discount_history`
--
ALTER TABLE `discount_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_history_id` (`order_history_id`);

--
-- Chỉ mục cho bảng `email_history`
--
ALTER TABLE `email_history`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `history_orders`
--
ALTER TABLE `history_orders`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `layout_ads`
--
ALTER TABLE `layout_ads`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `layout_benefit`
--
ALTER TABLE `layout_benefit`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `layout_contactsfooter`
--
ALTER TABLE `layout_contactsfooter`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `layout_customer_choose_item_section`
--
ALTER TABLE `layout_customer_choose_item_section`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `layout_customer_section`
--
ALTER TABLE `layout_customer_section`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `layout_navigation_menu`
--
ALTER TABLE `layout_navigation_menu`
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
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `permission`
--
ALTER TABLE `permission`
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
-- Chỉ mục cho bảng `reset_password_codes`
--
ALTER TABLE `reset_password_codes`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `role_permission`
--
ALTER TABLE `role_permission`
  ADD PRIMARY KEY (`role_id`,`permission_id`),
  ADD KEY `fk_role_permission_permission` (`permission_id`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_user_role` (`role_id`);

--
-- Chỉ mục cho bảng `verification_codes`
--
ALTER TABLE `verification_codes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `blacklisted_tokens`
--
ALTER TABLE `blacklisted_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=222;

--
-- AUTO_INCREMENT cho bảng `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `discount`
--
ALTER TABLE `discount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `discount_history`
--
ALTER TABLE `discount_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `email_history`
--
ALTER TABLE `email_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `history_orders`
--
ALTER TABLE `history_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT cho bảng `layout_ads`
--
ALTER TABLE `layout_ads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `layout_benefit`
--
ALTER TABLE `layout_benefit`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `layout_contactsfooter`
--
ALTER TABLE `layout_contactsfooter`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `layout_customer_choose_item_section`
--
ALTER TABLE `layout_customer_choose_item_section`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `layout_customer_section`
--
ALTER TABLE `layout_customer_section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT cho bảng `layout_navigation_menu`
--
ALTER TABLE `layout_navigation_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT cho bảng `layout_ordering_process`
--
ALTER TABLE `layout_ordering_process`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `layout_slide_header`
--
ALTER TABLE `layout_slide_header`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `layout_social_media_links`
--
ALTER TABLE `layout_social_media_links`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `permission`
--
ALTER TABLE `permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT cho bảng `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT cho bảng `reset_password_codes`
--
ALTER TABLE `reset_password_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `verification_codes`
--
ALTER TABLE `verification_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `address_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `discount_history`
--
ALTER TABLE `discount_history`
  ADD CONSTRAINT `discount_history_ibfk_1` FOREIGN KEY (`order_history_id`) REFERENCES `history_orders` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `role_permission`
--
ALTER TABLE `role_permission`
  ADD CONSTRAINT `fk_role_permission_permission` FOREIGN KEY (`permission_id`) REFERENCES `permission` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_role_permission_role` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_role` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
