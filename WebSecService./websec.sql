-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 18, 2025 at 08:31 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `websec`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `grade` varchar(255) NOT NULL,
  `credit_hours` int(11) NOT NULL,
  `term` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2023_10_01_000000_create_grades_table', 1),
(5, '2025_03_24_085039_create_products_table', 1),
(6, '2025_03_24_085050_add_credits_to_users', 1),
(7, '2025_03_24_085804_create_permission_tables', 1),
(8, '2025_03_24_093618_create_order_tables', 1),
(9, '2025_03_24_095804_create_roles_and_permissions', 1),
(10, '2024_05_10_000000_add_state_to_users_table', 2),
(11, '2023_05_15_000000_add_block_users_permission', 3),
(12, '2023_01_01_000000_create_password_reset_tokens_table', 4),
(13, '2024_04_13_create_password_reset_tokens_table', 5),
(14, '2025_04_21_191415_add_facebook_id_to_users_table', 6),
(15, '2025_04_21_191512_add_facebook_id_to_users_table', 6),
(16, '2025_04_25_150000_add_delete_comments_permission', 7);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 9),
(2, 'App\\Models\\User', 10),
(3, 'App\\Models\\User', 11),
(3, 'App\\Models\\User', 26),
(3, 'App\\Models\\User', 27),
(3, 'App\\Models\\User', 28),
(3, 'App\\Models\\User', 29),
(3, 'App\\Models\\User', 30),
(3, 'App\\Models\\User', 31),
(3, 'App\\Models\\User', 32),
(3, 'App\\Models\\User', 33),
(3, 'App\\Models\\User', 34),
(3, 'App\\Models\\User', 35),
(3, 'App\\Models\\User', 36),
(3, 'App\\Models\\User', 37),
(3, 'App\\Models\\User', 38),
(3, 'App\\Models\\User', 39),
(3, 'App\\Models\\User', 40),
(3, 'App\\Models\\User', 41),
(3, 'App\\Models\\User', 42),
(3, 'App\\Models\\User', 43),
(3, 'App\\Models\\User', 44),
(3, 'App\\Models\\User', 45),
(3, 'App\\Models\\User', 46),
(3, 'App\\Models\\User', 47),
(3, 'App\\Models\\User', 48),
(3, 'App\\Models\\User', 49),
(3, 'App\\Models\\User', 50),
(3, 'App\\Models\\User', 60),
(4, 'App\\Models\\User', 24),
(5, 'App\\Models\\User', 25);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `shipping_address` text DEFAULT NULL,
  `billing_address` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_amount`, `status`, `shipping_address`, `billing_address`, `created_at`, `updated_at`) VALUES
(26, 48, 1899.99, ' Completed', NULL, NULL, '2025-04-25 10:18:53', '2025-04-25 10:18:53'),
(27, 47, 2499.99, 'Purchase ', NULL, NULL, '2025-04-25 10:30:17', '2025-04-25 10:30:17'),
(28, 48, 2499.99, 'Purchase Completed', NULL, NULL, '2025-04-25 10:50:34', '2025-04-25 10:50:34'),
(29, 48, 2499.99, 'Purchase Completed', NULL, NULL, '2025-04-25 10:51:39', '2025-04-25 10:51:39'),
(30, 48, 2499.99, 'Purchase ', NULL, NULL, '2025-04-25 11:06:30', '2025-04-25 11:06:30'),
(31, 47, 1099.99, 'Purchase Completed', NULL, NULL, '2025-04-25 12:49:24', '2025-04-25 12:49:24'),
(32, 47, 22000.00, 'Purchase Completed', NULL, NULL, '2025-04-25 14:41:24', '2025-04-25 14:41:24');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(26, 26, 4, 1, 1899.99, '2025-04-25 10:18:53', '2025-04-25 10:18:53'),
(27, 27, 1, 1, 2499.99, '2025-04-25 10:30:17', '2025-04-25 10:30:17'),
(28, 28, 1, 1, 2499.99, '2025-04-25 10:50:34', '2025-04-25 10:50:34'),
(29, 29, 1, 1, 2499.99, '2025-04-25 10:51:39', '2025-04-25 10:51:39'),
(30, 30, 1, 1, 2499.99, '2025-04-25 11:06:30', '2025-04-25 11:06:30'),
(31, 31, 2, 1, 1099.99, '2025-04-25 12:49:24', '2025-04-25 12:49:24'),
(32, 32, 8, 1, 22000.00, '2025-04-25 14:41:24', '2025-04-25 14:41:24');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('employee@gmail.com', 'Z0ddeBVgNCiQpwYzqHDMB2WEVAXu8enpvddKRbPs26khaiv8sUCkXVj8R01uvo06', '2025-04-12 19:23:07'),
('hh1356890@gmail.com', '7uEBJs6z3U3DMhToip9qe6YP3ptQ5bGRAtN89TVPdwf4v8vKOdMDY6deMxS9bLSx', '2025-04-21 13:34:06');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `display_name` varchar(128) DEFAULT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `display_name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'show_users', NULL, 'web', '2025-03-24 07:30:21', '2025-03-24 07:30:21'),
(2, 'edit_users', NULL, 'web', '2025-03-24 07:30:21', '2025-03-24 07:30:21'),
(3, 'delete_users', NULL, 'web', '2025-03-24 07:30:21', '2025-03-24 07:30:21'),
(4, 'admin_users', NULL, 'web', '2025-03-24 07:30:21', '2025-03-24 07:30:21'),
(5, 'add_products', NULL, 'web', '2025-03-24 07:30:21', '2025-03-24 07:30:21'),
(6, 'edit_products', NULL, 'web', '2025-03-24 07:30:21', '2025-03-24 07:30:21'),
(7, 'delete_products', NULL, 'web', '2025-03-24 07:30:21', '2025-03-24 07:30:21'),
(8, 'list_products', NULL, 'web', '2025-03-24 07:30:21', '2025-03-24 07:30:21'),
(9, 'list_customers', NULL, 'web', '2025-03-24 07:30:21', '2025-03-24 07:30:21'),
(10, 'manage_employees', NULL, 'web', '2025-03-24 07:30:21', '2025-03-24 07:30:21'),
(11, 'place_order', NULL, 'web', '2025-03-24 07:30:21', '2025-03-24 07:30:21'),
(12, 'view_orders', NULL, 'web', '2025-03-24 07:30:21', '2025-03-24 07:30:21'),
(13, 'manage_orders', NULL, 'web', '2025-03-24 07:30:21', '2025-03-24 07:30:21'),
(15, 'block_users', NULL, 'web', '2025-04-09 10:17:46', '2025-04-09 10:17:46'),
(16, 'create_quiz', 'Create Quiz', 'web', '2025-03-23 22:48:19', '2025-03-23 22:48:19'),
(17, 'edit_quiz', 'Edit Quiz', 'web', '2025-03-23 22:48:19', '2025-03-23 22:48:19'),
(18, 'delete_quiz', 'Delete Quiz', 'web', '2025-03-23 22:48:19', '2025-03-23 22:48:19'),
(19, 'view_submissions', 'View Submissions', 'web', '2025-03-23 22:48:19', '2025-03-23 22:48:19'),
(20, 'grade_submissions', 'Grade Submissions', 'web', '2025-03-23 22:48:19', '2025-03-23 22:48:19'),
(21, 'take_quiz', 'Take Quiz', 'web', '2025-03-23 22:48:19', '2025-03-23 22:48:19'),
(22, 'view_available_quizzes', 'View Available Quizzes', 'web', '2025-03-23 22:48:19', '2025-03-23 22:48:19'),
(23, 'view_own_grades', 'View Own Grades', 'web', '2025-03-23 22:48:19', '2025-03-23 22:48:19'),
(24, 'delete_comments', NULL, 'web', '2025-04-25 10:59:09', '2025-04-25 10:59:09');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(32) NOT NULL,
  `name` varchar(128) NOT NULL,
  `model` varchar(256) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock_quantity` int(11) NOT NULL DEFAULT 0,
  `photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `code`, `name`, `model`, `description`, `price`, `stock_quantity`, `photo`, `created_at`, `updated_at`) VALUES
(1, 'LAPTOP-001', 'MacBook Pro 16\"', 'Apple MacBook Pro 2023', 'Powerful laptop with M2 Pro chip, 16GB RAM, 512GB SSD', 2499.99, 92, 'macbook.jpg', '2025-03-24 07:30:22', '2025-04-25 11:06:30'),
(2, 'PHONE-001', 'iPhone 15 Pro', 'Apple iPhone 15 Pro 256GB', 'Latest iPhone with A17 Pro chip, 256GB storage, and amazing camera system', 1099.99, 99, 'iphone.jpg', '2025-03-24 07:30:22', '2025-04-25 12:49:24'),
(3, 'TABLET-001', 'iPad Air', 'Apple iPad Air 2022', '256GB storage', 20000.00, 100, 'ipad.jpg', '2025-03-24 07:30:22', '2025-04-21 19:03:08'),
(4, 'LAPTOP-002', 'Dell XPS 15', 'Dell XPS 15 9530', 'Premium Windows laptop with 13th Gen Intel Core i7, 16GB RAM, 1TB SSD', 1899.99, 19, 'dell.jpg', '2025-03-24 07:30:22', '2025-04-25 10:18:53'),
(5, 'ACCESSORY-001', 'AirPods Pro', 'Apple AirPods Pro 2nd Gen', 'Wireless earbuds with active noise cancellation and spatial audio', 249.99, 0, 'airpods.jpg', '2025-03-24 07:30:22', '2025-04-21 13:57:51'),
(7, 'TV01', 'LG TV 50 Insh', 'LG8768787', 'Lorem ipsum dolor sit amet...', 28000.00, 50, 'lgtv50.jpg', NULL, '2025-02-25 04:40:56'),
(8, 'RF01', 'Toshipa Refrigerator 14\"', 'TS76634', 'Lorem ipsum dolor sit amet...', 22000.00, 49, 'tsrf50.jpg', NULL, '2025-04-25 14:41:24'),
(9, 'RF02', 'Toshipa Refrigerator 18\"', 'TS76634', 'Lorem ipsum dolor sit amet...', 28000.00, 50, 'rf2.jpg', NULL, NULL),
(10, 'RF03', 'Toshipa Refrigerator 19\"', 'TS76634', 'Lorem ipsum dolor sit amet...', 32000.00, 50, 'rf3.jpg', NULL, NULL),
(11, 'TV02', 'LG TV 55\"', 'LG8768787', 'Lorem ipsum dolor sit amet...', 23000.00, 0, 'tv2.jpg', NULL, '2025-04-21 13:57:43'),
(12, 'RF04', 'LG Refrigerator 14\"', 'TS76634', 'Lorem ipsum dolor sit amet...', 22000.00, 0, 'rf4.jpg', NULL, '2025-04-21 13:55:13'),
(13, 'TV03', 'LG TV 60\"', 'LG8768787', 'Lorem ipsum dolor sit amet...', 44000.00, 50, 'tv3.jpg', NULL, NULL),
(14, 'RF05', 'Toshipa Refrigerator 12\"', 'TS76634', 'Lorem ipsum dolor sit amet...', 10700.00, 0, 'rf5.jpg', NULL, '2025-04-21 13:55:41'),
(15, 'TV04', 'LG TV 99\"', 'LG8768787', 'Lorem ipsum dolor sit amet...', 108000.00, 0, 'tv4.jpg', NULL, '2025-04-21 13:55:22'),
(16, 'RF05', 'Toshipa Refrigerator 19\"', 'TS76634', 'شسيبلا', 1000.00, 12, 'rf4.jpg', '2025-02-25 01:18:04', '2025-04-25 12:24:12'),
(17, 'TV01', 'LG TV 50\"', 'LG8768787', 'Lorem ipsum dolor sit amet...', 18000.00, 0, 'lgtv50.jpg', '2025-02-25 01:24:04', '2025-04-21 13:55:27');

-- --------------------------------------------------------

--
-- Table structure for table `product_comments`
--

CREATE TABLE `product_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `comment` text NOT NULL,
  `rating` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_comments`
--

INSERT INTO `product_comments` (`id`, `product_id`, `user_id`, `comment`, `rating`, `created_at`, `updated_at`) VALUES
(2, 1, 48, 'على قد الغرض', 3, '2025-04-25 11:21:03', '2025-04-25 11:21:03'),
(4, 1, 47, 'work', 3, '2025-04-25 12:17:41', '2025-04-25 12:17:41'),
(5, 2, 47, 'جاااااامد', 5, '2025-04-25 12:49:56', '2025-04-25 12:49:56'),
(6, 8, 47, 'حلو اوي اوي اوي', 4, '2025-04-25 14:43:40', '2025-04-25 14:43:40');

-- --------------------------------------------------------

--
-- Table structure for table `product_likes`
--

CREATE TABLE `product_likes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `quiz_id` bigint(20) UNSIGNED NOT NULL,
  `question_text` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `quiz_id`, `question_text`, `created_at`, `updated_at`) VALUES
(1, 1, 'what is oop consent', '2025-03-23 19:02:54', '2025-03-23 19:02:54'),
(2, 2, 'what?', '2025-03-23 20:59:09', '2025-03-23 20:59:09'),
(3, 3, 'what is tcp/ip model', '2025-04-12 13:47:38', '2025-04-12 13:47:38');

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `instructor_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`id`, `title`, `description`, `instructor_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'oop', 'firt lab', 19, '2025-03-23 19:02:54', '2025-03-23 19:02:54', NULL),
(2, 'ph', 'new', 23, '2025-03-23 20:59:09', '2025-03-23 20:59:09', NULL),
(3, 'test', 'network', 24, '2025-04-12 13:47:38', '2025-04-12 13:47:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_submissions`
--

CREATE TABLE `quiz_submissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `quiz_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `answer_text` text NOT NULL,
  `score` int(3) DEFAULT NULL,
  `status` enum('pending','graded') NOT NULL DEFAULT 'pending',
  `instructor_feedback` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'web', '2025-03-24 07:30:21', '2025-03-24 07:30:21'),
(2, 'Employee', 'web', '2025-03-24 07:30:21', '2025-03-24 07:30:21'),
(3, 'Customer', 'web', '2025-03-24 07:30:21', '2025-03-24 07:30:21'),
(4, 'Instructor', 'web', '2025-03-23 22:48:19', '2025-03-23 22:48:19'),
(5, 'Student', 'web', '2025-03-23 22:48:19', '2025-03-23 22:48:19');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(2, 2),
(3, 1),
(4, 1),
(4, 2),
(5, 1),
(5, 2),
(6, 1),
(6, 2),
(7, 1),
(7, 2),
(8, 1),
(8, 2),
(8, 3),
(9, 1),
(9, 2),
(10, 1),
(11, 1),
(11, 3),
(12, 1),
(12, 2),
(13, 1),
(13, 2),
(15, 2),
(16, 4),
(17, 4),
(18, 4),
(19, 4),
(20, 4),
(21, 5),
(22, 5),
(23, 5),
(24, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('3col2OLqlUMOcRx2KsFDUjwd5Bvly7B3o5hGx231', NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNkJ3MkJlRnlEVEo3TlJQb3k5WDVaMk5OS2kwT3ZOemZaVFRRUE5WRCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly93ZWJzZWNzZXJ2aWNlLmxvY2FsaG9zdC9sb2dpbiI7fX0=', 1747549769),
('8nVJYalqn199C28NNk8Ha3vVf0t9kKT1uCOHBrWm', NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOUNWZ2FabE9lOUIyRVhEVW1SeUh5QWFvdHY3YTZlQ1B5YklyZVRpeCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTY2OiJodHRwOi8vd2Vic2Vjc2VydmljZS5sb2NhbGhvc3QvY3J5cHRvZ3JhcGh5P190b2tlbj05Q1ZnYVpsT2U5QjJFWERVbVJ5SHlBYW90djdhNmVDUHliSXJlVGl4JmFjdGlvbj1EZWNyeXB0JmRhdGE9WFBoSWhjUHN3Y3Y5N1ZxR3d1bXZnamh0VHBqU3Z5THZnMGZFZTlrVVNaRSZyZXN1bHQ9JTNEIjt9fQ==', 1747161967),
('dISpgUYcjKO9Sxqe9jJsyc1GftWwWImQn8HOySaz', NULL, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMGhuR1hZaXdQczBtSkhOakdZWWJMNDRSbE5TNzZoeWFGQUVDOGZ4QyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6ODU0OiJodHRwOi8vd2Vic2Vjc2VydmljZS5sb2NhbGhvc3QvY3J5cHRvZ3JhcGh5P190b2tlbj0waG5HWFlpd1BzMG1KSE5qR1lZYkw0NFJsTlM3Nmh5YUZBRUM4ZnhDJmFjdGlvbj1LZXlSZWNpdmUmZGF0YT1RMDRaM213RDI2UiUyQms3NGFRRkRuODNSb2FNTmklMkZVZDM4QVBSMHBFeGdlZFV5SiUyRmx3dXEzQkpQMTRVWTBLaU93bXV6N0VKOHAyTEM3UG11ZmJ4enVNZG9pQzNhJTJCWDVad2dBJTJGZkZ6MUtLYXdxN2dJQ1Rram04aExwVHYlMkZUWHpvNDdSMndBcW91d3R6TG1la2IzRHcwTHZnR0VkSUJBVkQzQkxldWFlTDFHdExRV29CNjhTZWpzVkM1aUVyRnRqQXEybFBubzFNcW1nT1p5WXVOWFdLYjFMdE1CSTBDcE5IQ1VaYiUyQmJya1hTNVR2NWZyODRrbyUyRm5vME5IY2pBRnVMQnVOaXRvTDZrNGI5NTBoZWdIYkFKRkJjcnQ2djUwbDZhZVJ6MlRzaFZpbFl0UVJld3djdHh1VnZEbElibVJKTVYlMkJHNFM0eFNOREtydEl3NmRtZmt2UUElM0QlM0QmcmVzdWx0PVEwNFozbXdEMjZSJTJCazc0YVFGRG44M1JvYU1OaSUyRlVkMzhBUFIwcEV4Z2VkVXlKJTJGbHd1cTNCSlAxNFVZMEtpT3dtdXo3RUo4cDJMQzdQbXVmYnh6dU1kb2lDM2ElMkJYNVp3Z0ElMkZmRnoxS0thd3E3Z0lDVGtqbThoTHBUdiUyRlRYem80N1Iyd0Fxb3V3dHpMbWVrYjNEdzBMdmdHRWRJQkFWRDNCTGV1YWVMMUd0TFFXb0I2OFNlanNWQzVpRXJGdGpBcTJsUG5vMU1xbWdPWnlZdU5YV0tiMUx0TUJJMENwTkhDVVpiJTJCYnJrWFM1VHY1ZnI4NGtvJTJGbm8wTkhjakFGdUxCdU5pdG9MNms0Yjk1MGhlZ0hiQUpGQmNydDZ2NTBsNmFlUnoyVHNoVmlsWXRRUmV3d2N0eHVWdkRsSWJtUkpNViUyQkc0UzR4U05ES3J0SXc2ZG1ma3ZRQSUzRCUzRCI7fX0=', 1746988041);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `credits` decimal(15,2) NOT NULL DEFAULT 12000.00,
  `state` varchar(255) NOT NULL DEFAULT 'active',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `facebook_id` int(11) DEFAULT NULL,
  `google_id` text DEFAULT NULL,
  `google_token` text DEFAULT NULL,
  `google_refresh_token` text DEFAULT NULL,
  `github_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `credits`, `state`, `remember_token`, `created_at`, `updated_at`, `facebook_id`, `google_id`, `google_token`, `google_refresh_token`, `github_id`) VALUES
(9, 'Ahmed_admin', 'admin@gmail.com', '2025-04-07 22:45:06', '$2y$12$BFBY0yAIVd//l7PcVpnbQuJDbH9sCiaw2yxsdu8lHG7k4OeZmJA5a', 1000.00, 'active', NULL, '2025-04-07 22:45:06', '2025-04-07 22:45:06', 0, NULL, NULL, NULL, NULL),
(10, 'Ahmed_Employee', 'employee@gmail.com', '2025-04-07 22:45:06', '$2y$12$mHCZDFltIlinz69cC700d.SrtJMjaKn4fzUfQCbtdn9UMvE32XO4O', 12000.00, 'active', NULL, '2025-04-07 22:48:01', '2025-04-07 22:48:01', 0, NULL, NULL, NULL, NULL),
(47, 'Ahmed Mohamed', 'ahmedabdallah14.2005@gmail.com', NULL, '$2y$12$mUrX3uXM3aZVc6/VsNELoO6QokhiRvtk7A/i4H4a9Hhwbh/Hryut2', 4986400.02, 'active', NULL, '2025-04-25 10:26:48', '2025-04-25 14:41:24', NULL, NULL, NULL, NULL, NULL),
(48, 'ahmed_customer', 'customer@gamil.com', '2025-04-20 18:53:23', '$2y$12$zz81VqwJVjSFYsKgrb/DFOU2YhatbXRbYRytLnPCOb6Y5jtQ1E/Ma', 91600.04, 'active', NULL, '2025-04-20 18:54:33', '2025-04-25 11:06:30', 0, NULL, NULL, NULL, NULL),
(60, 'Test user', 'useremail@domain.com', '2025-04-20 18:53:23', '$2y$12$x9disSDpD1GXABUJWOkRxuuP4xXTYGQpP2VJd7E.nD20rbScnYpP.', 1000.00, 'active', NULL, '2025-05-03 15:25:22', '2025-05-03 15:25:22', NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_comments`
--
ALTER TABLE `product_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `product_likes`
--
ALTER TABLE `product_likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_id` (`product_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `questions_quiz_id_foreign` (`quiz_id`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quizzes_instructor_id_foreign` (`instructor_id`);

--
-- Indexes for table `quiz_submissions`
--
ALTER TABLE `quiz_submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_submissions_quiz_id_foreign` (`quiz_id`),
  ADD KEY `quiz_submissions_student_id_foreign` (`student_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `product_comments`
--
ALTER TABLE `product_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `product_likes`
--
ALTER TABLE `product_likes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `quiz_submissions`
--
ALTER TABLE `quiz_submissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_comments`
--
ALTER TABLE `product_comments`
  ADD CONSTRAINT `product_comments_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_likes`
--
ALTER TABLE `product_likes`
  ADD CONSTRAINT `product_likes_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_likes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_quiz_id_foreign` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quiz_submissions`
--
ALTER TABLE `quiz_submissions`
  ADD CONSTRAINT `quiz_submissions_quiz_id_foreign` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quiz_submissions_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
