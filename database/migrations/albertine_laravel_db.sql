-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 29, 2017 at 09:55 AM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `albertine_laravel_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Ricko', 'rickos89@gmail.com', '$2y$10$/vJ33G5ZYqpeGPw.E8uIEeKojNYA7VjyAfhjpgWJvEzR4/dkf8xk6', '7EGN5YDJ8VwE2RLhBbnRDj1qcAF24LfOVmNv2QTJO1o0rTp1obAFbOMkLUef', NULL, '2017-06-27 21:10:49');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_by` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_by` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `is_active`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Sandal edited', 0, 'rickos89@gmail.com', 'rickos89@gmail.com', '2017-06-27 23:51:18', '2017-06-28 02:32:31'),
(2, 'Heel', 0, 'rickos89@gmail.com', 'rickos89@gmail.com', '2017-06-27 23:51:28', '2017-06-27 23:51:28'),
(3, 'Stiletto', 1, 'rickos89@gmail.com', 'rickos89@gmail.com', '2017-06-27 23:51:41', '2017-06-27 23:51:41'),
(4, 'Test 1', 1, 'rickos89@gmail.com', 'rickos89@gmail.com', '2017-06-28 02:11:20', '2017-06-28 02:11:20'),
(5, 'Test 2', 0, 'rickos89@gmail.com', 'rickos89@gmail.com', '2017-06-28 02:12:05', '2017-06-28 02:12:05'),
(6, 'Test 3', 1, 'rickos89@gmail.com', 'rickos89@gmail.com', '2017-06-28 02:12:22', '2017-06-28 02:12:22');

-- --------------------------------------------------------

--
-- Table structure for table `colours`
--

CREATE TABLE IF NOT EXISTS `colours` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_by` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `colours`
--

INSERT INTO `colours` (`id`, `name`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Red', 'rickos89@gmail.com', 'rickos89@gmail.com', '2017-06-29 07:04:09', '2017-06-29 07:04:09'),
(2, 'Blue', 'rickos89@gmail.com', 'rickos89@gmail.com', '2017-06-29 07:04:22', '2017-06-29 07:04:22'),
(3, 'Yellow', 'rickos89@gmail.com', 'rickos89@gmail.com', '2017-06-29 07:14:11', '2017-06-29 07:14:11');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2017_06_28_032332_create_admins_table', 1),
(5, '2017_06_28_063639_create_categories_table', 2),
(6, '2017_06_28_110829_create_sizes_table', 3),
(7, '2017_06_29_140105_create_colours_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE IF NOT EXISTS `sizes` (
  `id` int(10) unsigned NOT NULL,
  `size_metric` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size_value` decimal(5,2) NOT NULL,
  `created_by` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_by` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`id`, `size_metric`, `size_value`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'EU', '36.00', 'rickos89@gmail.com', 'rickos89@gmail.com', '2017-06-28 04:16:24', '2017-06-28 13:54:12'),
(2, 'EU', '37.00', 'rickos89@gmail.com', 'rickos89@gmail.com', '2017-06-28 04:16:32', '2017-06-28 04:16:32'),
(3, 'EU', '38.00', 'rickos89@gmail.com', 'rickos89@gmail.com', '2017-06-28 04:16:40', '2017-06-28 04:16:40'),
(5, 'EU', '40.00', 'rickos89@gmail.com', 'rickos89@gmail.com', '2017-06-28 06:32:48', '2017-06-28 06:32:48'),
(6, 'US', '36.00', 'rickos89@gmail.com', 'rickos89@gmail.com', '2017-06-28 06:49:05', '2017-06-28 06:49:05'),
(7, 'EU', '41.00', 'rickos89@gmail.com', 'rickos89@gmail.com', '2017-06-28 06:49:22', '2017-06-28 06:49:22'),
(8, 'EU', '42.00', 'rickos89@gmail.com', 'rickos89@gmail.com', '2017-06-28 13:51:04', '2017-06-28 13:51:04');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Ricko', 'rickos89@gmail.com', '$2y$10$h.eBKWXHMBLEwRHbQ3x40.ETUnltwXRCzDr4RXIX/PFOSPCwfsLKG', 'mJlrK0oO3v0NXEsM4xelkY0yP8UBGwEdv1ZOuFZ7ykMB3PQ7EtElzJJYml6c', '2017-06-27 20:32:39', '2017-06-27 20:32:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_name_unique` (`name`);

--
-- Indexes for table `colours`
--
ALTER TABLE `colours`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `colours_name_unique` (`name`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `colours`
--
ALTER TABLE `colours`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
