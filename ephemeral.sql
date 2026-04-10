-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Waktu pembuatan: 10 Apr 2026 pada 04.31
-- Versi server: 8.3.0
-- Versi PHP: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ephemeral`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `addresses`
--

DROP TABLE IF EXISTS `addresses`;
CREATE TABLE IF NOT EXISTS `addresses` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `recipient_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'RUMAH',
  `province` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `district` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postal_code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address_line` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `addresses_user_id_foreign` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `recipient_name`, `phone`, `label`, `province`, `city`, `district`, `postal_code`, `address_line`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 6, '1', '1', 'RUMAH', '1', '1', '1', '11', '1', 0, '2026-04-04 05:21:36', '2026-04-04 05:21:39'),
(2, 3, 'Ryo', '123221', 'RUMAH', 'pok', 'pok', 'pok', '212134', 'sadasafdfmfdkjhgkjh', 1, '2026-04-05 17:52:12', '2026-04-06 17:11:10'),
(3, 3, 'Ryo', '2132132321', 'KANTOR', 're', 'er', 'erre', '2132323', 'ddsfsfgfgfdgf', 0, '2026-04-05 18:32:51', '2026-04-06 17:11:10'),
(4, 8, 'ryo', '90090909', 'RUMAH', 'jabar', 'depok', 'beji', '12212', 'jk contoh no.1', 0, '2026-04-08 19:14:57', '2026-04-08 19:15:01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `backups`
--

DROP TABLE IF EXISTS `backups`;
CREATE TABLE IF NOT EXISTS `backups` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `file_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` int NOT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `backups_created_by_foreign` (`created_by`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `backups`
--

INSERT INTO `backups` (`id`, `file_name`, `file_path`, `size`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'backup_2026-04-06_00-31-47.sql', 'backups/backup_2026-04-06_00-31-47.sql', 13650, 1, '2026-04-05 17:31:47', '2026-04-05 17:31:47');

-- --------------------------------------------------------

--
-- Struktur dari tabel `carts`
--

DROP TABLE IF EXISTS `carts`;
CREATE TABLE IF NOT EXISTS `carts` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `carts_user_id_product_id_unique` (`user_id`,`product_id`),
  KEY `carts_product_id_foreign` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `product_id`, `quantity`, `created_at`, `updated_at`) VALUES
(7, 2, 1, 1, '2026-04-06 17:04:13', '2026-04-06 17:04:13'),
(17, 3, 4, 1, '2026-04-08 18:51:24', '2026-04-08 18:51:24');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2026_02_16_093037_create_users_table', 1),
(2, '2026_02_16_093232_create_products_table', 1),
(3, '2026_02_16_093246_create_carts_table', 1),
(4, '2026_02_16_093253_create_transactions_table', 1),
(5, '2026_02_16_093307_create_transaction_details_table', 1),
(6, '2026_02_16_093400_create_payments_table', 1),
(7, '2026_02_16_093407_create_shippings_table', 1),
(8, '2026_02_16_093417_create_backups_table', 1),
(9, '2026_03_20_120000_create_addresses_table', 1),
(10, '2026_03_26_090000_add_profile_photo_to_users_table', 1),
(11, '2026_04_07_090000_add_jenis_to_products_table', 2),
(12, '2026_04_09_090000_add_fields_to_payments_table', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `payments`
--

DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `transaction_id` bigint UNSIGNED NOT NULL,
  `payment_method` enum('bank_transfer','e_wallet','cash') COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `proof_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `confirmed_by` bigint UNSIGNED DEFAULT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `confirmed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `submitted_by` bigint UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payments_transaction_id_foreign` (`transaction_id`),
  KEY `payments_confirmed_by_foreign` (`confirmed_by`),
  KEY `payments_submitted_by_foreign` (`submitted_by`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `payments`
--

INSERT INTO `payments` (`id`, `transaction_id`, `payment_method`, `amount`, `proof_url`, `bank_name`, `account_number`, `account_name`, `payment_date`, `notes`, `confirmed_by`, `status`, `confirmed_at`, `created_at`, `updated_at`, `submitted_by`) VALUES
(1, 13, 'e_wallet', 10003.00, 'payments/OUmDFXZvVsfpkUx8fwaawyK0JDOrGw6IsncjNOTn.jpg', NULL, NULL, NULL, '2026-04-09', NULL, NULL, 'pending', NULL, '2026-04-08 18:30:58', '2026-04-08 18:30:58', 3),
(2, 14, 'e_wallet', 10004.00, 'payments/gm2Z7hAZYgGUDDDC1J7OeAecR0C1wjEG7cAMkcAX.jpg', NULL, NULL, NULL, '2026-04-09', NULL, NULL, 'pending', NULL, '2026-04-08 19:17:27', '2026-04-08 19:17:27', 8);

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(10,2) NOT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `isbn` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `publisher` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pages` int DEFAULT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_isbn_unique` (`isbn`),
  KEY `products_created_by_foreign` (`created_by`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `stock`, `image`, `jenis`, `isbn`, `author`, `publisher`, `pages`, `created_by`, `created_at`, `updated_at`) VALUES
(1, '1', '`Animal Farm menceritakan sekelompok hewan di Peternakan Manor yang memberontak terhadap pemilik manusia mereka, Tuan Jones, karena dianggap tidak peduli dan mengekang. Terinspirasi oleh orasi menggetarkan dari seekor babi tua bernama Old Major, hewan-hewan mulai membayangkan kehidupan baru yang terlepas dari penindasan manusia. Setelah Old Major wafat, dua babi terpandai Snowball dan Napoleon mengambil alih kekuasaan dan berhasil memobilisasi revolusi. Mereka mengusir Tuan Jones dan menguasai peternakan, yang kemudian mereka ganti namanya menjadi Animal Farm.', 1.00, 1, 'products/1775449879_WhatsApp Image 2026-01-21 at 07.21.49.jpeg', 'Komik', NULL, 'ryo', NULL, NULL, 2, '2026-04-04 01:52:10', '2026-04-08 18:27:27'),
(2, '2', 'sdad2', 2.00, 0, 'products/1775455575_9786239115111.jpg', 'Novel', NULL, '2', NULL, NULL, 2, '2026-04-05 23:06:15', '2026-04-07 19:57:47'),
(3, '3', '3hehe', 3.00, 1, 'products/1775520114_4v-x442kk1.jpg', 'Novel', NULL, '3', NULL, NULL, 2, '2026-04-06 17:01:54', '2026-04-08 18:30:52'),
(4, '4', 'Kalau beberapa tahun yang lalu Tuan datang ke kota kelahiranku dengan menumpang bis, Tuan\r\nakan berhenti di dekat pasar. Maka kira-kira sekilometer dari pasar akan sampailah Tuan di jalan\r\nkampungku. Pada simpang kecil ke kanan, simpang yang kelima, membeloklah ke jalan sempit itu.\r\nDan di ujung jalan nanti akan Tuan temui sebuah surau tua. Di depannya ada kolam ikan, yang\r\nairnya mengalir melalui empat buah pancuran mandi.', 4.00, 1, 'products/1775522964_kjf6cgigkomf6sy9o5qauu.jpg', 'Non-Fiksi', NULL, '4', NULL, NULL, 2, '2026-04-06 17:49:24', '2026-04-08 19:16:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `shippings`
--

DROP TABLE IF EXISTS `shippings`;
CREATE TABLE IF NOT EXISTS `shippings` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `transaction_id` bigint UNSIGNED NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `courier` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tracking_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipped_by` bigint UNSIGNED DEFAULT NULL,
  `shipped_at` timestamp NULL DEFAULT NULL,
  `delivered_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `shippings_transaction_id_foreign` (`transaction_id`),
  KEY `shippings_shipped_by_foreign` (`shipped_by`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `shippings`
--

INSERT INTO `shippings` (`id`, `transaction_id`, `address`, `courier`, `tracking_number`, `shipped_by`, `shipped_at`, `delivered_at`, `created_at`, `updated_at`) VALUES
(1, 9, 'sadasafdfmfdkjhgkjh, pok, pok, pok, 212134', 'J&T Express', 'jnjnjnjnjnjnjnj', 2, '2026-04-07 17:57:52', NULL, '2026-04-07 17:57:52', '2026-04-07 17:57:52'),
(2, 13, 'sadasafdfmfdkjhgkjh, pok, pok, pok, 212134', 'J&T Express', 'dfhdsjkfjkfhkfk', 2, '2026-04-08 19:05:50', NULL, '2026-04-08 19:05:50', '2026-04-08 19:05:50');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transactions`
--

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `invoice_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `shipping_cost` decimal(10,2) NOT NULL DEFAULT '0.00',
  `shipping_address` text COLLATE utf8mb4_unicode_ci,
  `shipping_courier` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','processing','completed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_status` enum('unpaid','paid','failed','refunded') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unpaid',
  `shipping_status` enum('packing','shipped','delivered') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `transactions_invoice_code_unique` (`invoice_code`),
  KEY `transactions_user_id_foreign` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `transactions`
--

INSERT INTO `transactions` (`id`, `invoice_code`, `user_id`, `total_amount`, `subtotal`, `shipping_cost`, `shipping_address`, `shipping_courier`, `status`, `payment_status`, `shipping_status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'INV/20260404/6/7659', 6, 10001.00, 1.00, 10000.00, '1, 1, 1, 1, 11', 'J&T Express', 'processing', 'paid', 'shipped', NULL, '2026-04-04 05:22:02', '2026-04-05 18:34:00'),
(2, 'INV/20260406/3/3443', 3, 10001.00, 1.00, 10000.00, 'sadasafdfmfdkjhgkjh, pok, pok, pok, 212134', 'J&T Express', 'processing', 'paid', 'packing', NULL, '2026-04-05 17:53:42', '2026-04-05 17:54:38'),
(3, 'INV/20260406/3/7423', 3, 10001.00, 1.00, 10000.00, 'ddsfsfgfgfdgf, erre, er, re, 2132323', 'J&T Express', 'cancelled', 'failed', 'packing', NULL, '2026-04-05 18:33:19', '2026-04-08 18:06:40'),
(4, 'INV/20260406/3/1152', 3, 10006.00, 6.00, 10000.00, 'ddsfsfgfgfdgf, erre, er, re, 2132323', 'J&T Express', 'pending', 'failed', 'packing', NULL, '2026-04-05 23:06:56', '2026-04-06 20:26:35'),
(5, '3563066', 3, 10001.00, 1.00, 10000.00, 'sadasafdfmfdkjhgkjh, pok, pok, pok, 212134', 'J&T Express', 'cancelled', 'failed', 'packing', NULL, '2026-04-06 17:11:15', '2026-04-06 17:24:49'),
(6, 'INV/20260407/0002', 3, 10002.00, 2.00, 10000.00, 'sadasafdfmfdkjhgkjh, pok, pok, pok, 212134', 'J&T Express', 'cancelled', 'failed', 'packing', NULL, '2026-04-06 17:14:33', '2026-04-06 17:15:49'),
(7, 'INV/20260407/6432', 3, 10002.00, 2.00, 10000.00, 'sadasafdfmfdkjhgkjh, pok, pok, pok, 212134', 'J&T Express', 'cancelled', 'failed', 'packing', NULL, '2026-04-06 17:16:07', '2026-04-06 17:26:14'),
(8, 'INV/20260407/6409', 3, 10003.00, 3.00, 10000.00, 'sadasafdfmfdkjhgkjh, pok, pok, pok, 212134', 'J&T Express', 'pending', 'unpaid', 'packing', NULL, '2026-04-06 17:16:53', '2026-04-06 17:16:53'),
(9, 'INV/20260407/0107', 3, 10004.00, 4.00, 10000.00, 'sadasafdfmfdkjhgkjh, pok, pok, pok, 212134', 'J&T Express', 'processing', 'paid', 'shipped', NULL, '2026-04-06 19:44:50', '2026-04-07 17:54:50'),
(10, 'INV/20260408/3678', 3, 10004.00, 4.00, 10000.00, 'sadasafdfmfdkjhgkjh, pok, pok, pok, 212134', 'J&T Express', 'pending', 'unpaid', 'packing', NULL, '2026-04-07 23:27:42', '2026-04-07 23:27:42'),
(11, 'INV/20260409/3377', 3, 10001.00, 1.00, 10000.00, 'sadasafdfmfdkjhgkjh, pok, pok, pok, 212134', 'J&T Express', 'pending', 'unpaid', 'packing', NULL, '2026-04-08 18:27:27', '2026-04-08 18:27:27'),
(12, 'INV/20260409/5408', 3, 10003.00, 3.00, 10000.00, 'sadasafdfmfdkjhgkjh, pok, pok, pok, 212134', 'J&T Express', 'cancelled', 'failed', 'packing', NULL, '2026-04-08 18:30:00', '2026-04-08 18:30:42'),
(13, 'INV/20260409/1201', 3, 10003.00, 3.00, 10000.00, 'sadasafdfmfdkjhgkjh, pok, pok, pok, 212134', 'J&T Express', 'completed', 'paid', 'delivered', NULL, '2026-04-08 18:30:52', '2026-04-08 19:05:45'),
(14, 'INV/20260409/4032', 8, 10004.00, 4.00, 10000.00, 'jk contoh no.1, beji, depok, jabar, 12212', 'J&T Express', 'pending', 'unpaid', 'packing', NULL, '2026-04-08 19:16:54', '2026-04-08 19:16:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaction_details`
--

DROP TABLE IF EXISTS `transaction_details`;
CREATE TABLE IF NOT EXISTS `transaction_details` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `transaction_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL,
  `price_at_time` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transaction_details_transaction_id_foreign` (`transaction_id`),
  KEY `transaction_details_product_id_foreign` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `transaction_details`
--

INSERT INTO `transaction_details` (`id`, `transaction_id`, `product_id`, `quantity`, `price_at_time`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1.00, 1.00, '2026-04-04 05:22:02', '2026-04-04 05:22:02'),
(2, 2, 1, 1, 1.00, 1.00, '2026-04-05 17:53:42', '2026-04-05 17:53:42'),
(3, 3, 1, 1, 1.00, 1.00, '2026-04-05 18:33:19', '2026-04-05 18:33:19'),
(4, 4, 1, 4, 1.00, 4.00, '2026-04-05 23:06:56', '2026-04-05 23:06:56'),
(5, 4, 2, 1, 2.00, 2.00, '2026-04-05 23:06:56', '2026-04-05 23:06:56'),
(6, 5, 1, 1, 1.00, 1.00, '2026-04-06 17:11:15', '2026-04-06 17:11:15'),
(7, 6, 2, 1, 2.00, 2.00, '2026-04-06 17:14:33', '2026-04-06 17:14:33'),
(8, 7, 2, 1, 2.00, 2.00, '2026-04-06 17:16:07', '2026-04-06 17:16:07'),
(9, 8, 3, 1, 3.00, 3.00, '2026-04-06 17:16:53', '2026-04-06 17:16:53'),
(10, 9, 4, 1, 4.00, 4.00, '2026-04-06 19:44:50', '2026-04-06 19:44:50'),
(11, 10, 4, 1, 4.00, 4.00, '2026-04-07 23:27:42', '2026-04-07 23:27:42'),
(12, 11, 1, 1, 1.00, 1.00, '2026-04-08 18:27:27', '2026-04-08 18:27:27'),
(13, 12, 3, 1, 3.00, 3.00, '2026-04-08 18:30:00', '2026-04-08 18:30:00'),
(14, 13, 3, 1, 3.00, 3.00, '2026-04-08 18:30:52', '2026-04-08 18:30:52'),
(15, 14, 4, 1, 4.00, 4.00, '2026-04-08 19:16:54', '2026-04-08 19:16:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','staff','customer') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'customer',
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `profile_photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `phone`, `address`, `profile_photo`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@ephemeral.com', '$2y$12$V13ujD/DgdLlZLSyT0DXC.SRm9WPsC/8bqrPiU8GKmNhCudCskCtO', 'admin', '081234567890', 'Jakarta', NULL, '2026-04-02 18:34:46', '2026-04-02 18:34:46'),
(2, 'Staff', 'staff@ephemeral.com', '$2y$12$y5J6SIQefxuaTUMLYASMY.y87j49kTXe7SKLWY.Xe1ieIWJyRH.aS', 'staff', '081234567891', 'Bandung', NULL, '2026-04-02 18:34:47', '2026-04-02 18:34:47'),
(3, 'Customer', 'customer@ephemeral.com', '$2y$12$Y1xjzNl9iXGk5Czcn6I/3O9tKEwWKoQnr3emnBUG/1PFs59KfWDMC', 'customer', '081234567892', 'Surabaya', 'profiles/FwJK3ZGP9mQyhboh0kdzRDoBbUI1hcYbpqpuz6G5.png', '2026-04-02 18:34:47', '2026-04-05 18:27:55'),
(4, 'Staff 2', 'staff2@ephemeral.com', '$2y$12$M7G64yJqTPNAYJPcAYC/p.1nONNCrv46/YiSzsSgev/sb0Tk1O15u', 'staff', '081234567893', NULL, NULL, '2026-04-02 18:34:47', '2026-04-02 18:34:47'),
(5, 'Customer 2', 'customer2@ephemeral.com', '$2y$12$1Hv0ikhPeV9rZHsq1Bb1Tu8TzXcDq5Thp37flZFzxl/O7qmnm5KLK', 'customer', '081234567894', 'Yogyakarta', NULL, '2026-04-02 18:34:48', '2026-04-02 18:34:48'),
(6, '1', '1@mail.com', '$2y$12$PmOT/VlgPC2tx8iBpIrI2.sQ7h8u5mQSJ19V325V2AIAGM3Y88VL6', 'customer', '11', NULL, NULL, '2026-04-04 05:21:07', '2026-04-04 05:21:07'),
(7, '2', '2@mail.com', '$2y$12$WX/oYldOnFh9Qs1DzvSO4OofBYl12eVkrVZXIY8/dA.i6YHv0jqju', 'staff', NULL, NULL, NULL, '2026-04-05 20:46:05', '2026-04-05 20:46:05'),
(8, 'naam', 'contoh@ephemeral.com', '$2y$12$uddOqih9nsYZQvAPBk2BB.ELenScCuqUkAcIbZvTymumEIHH22Vqq', 'customer', '0909090909090', NULL, NULL, '2026-04-08 19:13:09', '2026-04-08 19:13:09');

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `backups`
--
ALTER TABLE `backups`
  ADD CONSTRAINT `backups_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_confirmed_by_foreign` FOREIGN KEY (`confirmed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `payments_submitted_by_foreign` FOREIGN KEY (`submitted_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `payments_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `shippings`
--
ALTER TABLE `shippings`
  ADD CONSTRAINT `shippings_shipped_by_foreign` FOREIGN KEY (`shipped_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `shippings_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transaction_details`
--
ALTER TABLE `transaction_details`
  ADD CONSTRAINT `transaction_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaction_details_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
