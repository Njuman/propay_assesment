-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.6.10-log - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for propay
CREATE DATABASE IF NOT EXISTS `propay` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `propay`;

-- Dumping structure for table propay.interests
CREATE TABLE IF NOT EXISTS `interests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `interest` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Dumping data for table propay.interests: ~2 rows (approximately)
/*!40000 ALTER TABLE `interests` DISABLE KEYS */;
INSERT INTO `interests` (`id`, `interest`, `created_at`, `updated_at`) VALUES
	(1, 'Video Gaming', '2017-06-08 23:45:26', '2017-06-08 23:45:53'),
	(2, 'Paint something beautiful', '2017-06-08 23:45:39', '2017-06-08 23:45:55'),
	(3, 'Upcycle everything you own', '2017-06-08 23:45:51', '2017-06-08 23:45:57');
/*!40000 ALTER TABLE `interests` ENABLE KEYS */;

-- Dumping structure for table propay.interests_users
CREATE TABLE IF NOT EXISTS `interests_users` (
  `users_id` int(11) NOT NULL,
  `interests_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `FK_interest_user_users` (`users_id`),
  KEY `FK_interest_user_interests` (`interests_id`),
  CONSTRAINT `FK_interest_user_interests` FOREIGN KEY (`interests_id`) REFERENCES `interests` (`id`),
  CONSTRAINT `FK_interest_user_users` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table propay.interests_users: ~3 rows (approximately)
/*!40000 ALTER TABLE `interests_users` DISABLE KEYS */;
INSERT INTO `interests_users` (`users_id`, `interests_id`, `created_at`) VALUES
	(1, 2, '2017-06-12 08:26:12'),
	(1, 3, '2017-06-12 08:26:12'),
	(9, 2, '2017-06-12 08:28:40');
/*!40000 ALTER TABLE `interests_users` ENABLE KEYS */;

-- Dumping structure for table propay.languages
CREATE TABLE IF NOT EXISTS `languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- Dumping data for table propay.languages: ~11 rows (approximately)
/*!40000 ALTER TABLE `languages` DISABLE KEYS */;
INSERT INTO `languages` (`id`, `language`, `created_at`, `updated_at`) VALUES
	(1, 'English', '2017-06-08 11:57:07', '2017-06-08 11:57:11'),
	(2, 'Afrikaans', '2017-06-08 11:57:26', '2017-06-08 11:57:31'),
	(3, 'Zulu', '2017-06-08 11:58:43', '2017-06-08 11:59:02'),
	(4, 'Xhosa', '2017-06-08 11:58:41', '2017-06-08 11:59:01'),
	(5, 'Tswana', '2017-06-08 11:58:45', '2017-06-08 11:59:00'),
	(6, 'Swati', '2017-06-08 11:58:44', '2017-06-08 11:58:59'),
	(7, 'Tsonga', '2017-06-08 11:58:49', '2017-06-08 11:58:58'),
	(8, 'Venda', '2017-06-08 11:58:46', '2017-06-08 11:58:56'),
	(9, 'Ndebele', '2017-06-08 11:58:48', '2017-06-08 11:58:55'),
	(10, 'Southern Sotho', '2017-06-08 11:58:51', '2017-06-08 11:58:54'),
	(11, 'Northern Sotho', '2017-06-08 11:58:52', '2017-06-08 11:58:53');
/*!40000 ALTER TABLE `languages` ENABLE KEYS */;

-- Dumping structure for table propay.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table propay.migrations: ~2 rows (approximately)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Dumping structure for table propay.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table propay.password_resets: ~0 rows (approximately)
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- Dumping structure for table propay.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `language` int(11) DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_username` (`username`),
  KEY `foreign_key` (`language`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table propay.users: ~2 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `surname`, `username`, `password`, `id_number`, `mobile_no`, `birth_date`, `language`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Cyril', 'Nxumalo', 'njuman', '$2y$10$WQDcesSHBrinACCIoxeSyuRG3Vt5EoBh8NbGpnaT1lgfrLyTMrnXu', '9001295438084', '0765417572', '1990-01-29', 3, '$2y$10$WQDcesSHBrinACCIoxeSyuRG3Vt5EoBh8NbGpnaT1lgfrLyTMrnXu', '2017-06-05 09:27:05', '2017-06-05 09:27:05'),
	(9, 'Brad', 'Pitt', 'smith', '$2y$10$Z2lJhreAOQfh8CKmjeMSOOiz0lJz6BYjLYwoj0Ic4FgMPXJuIlzny', '131321231232', '0831312211', '1967-04-29', 1, NULL, NULL, NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
