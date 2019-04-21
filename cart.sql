-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.37-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             10.1.0.5464
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for cart
CREATE DATABASE IF NOT EXISTS `cart` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `cart`;

-- Dumping structure for table cart.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `sub_total` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `shipping_fee` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `total_paid` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `previous_balance` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `shipping_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'PENDING',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `IDX_E52FFDEEA76ED395` (`user_id`),
  CONSTRAINT `FK_E52FFDEEA76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table cart.orders: ~2 rows (approximately)
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT IGNORE INTO `orders` (`id`, `user_id`, `sub_total`, `shipping_fee`, `total_paid`, `previous_balance`, `shipping_type`, `status`, `created_at`, `updated_at`) VALUES
	(1, 1, 100.0000, 0.0000, 100.0000, 999685.0000, 'PICK_UP', 'PENDING', '2019-04-21 04:39:16', '2019-04-21 04:39:16'),
	(2, 1, 900.0000, 5.0000, 905.0000, 999585.0000, 'UPS', 'PENDING', '2019-04-21 13:15:18', '2019-04-21 13:15:18');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;

-- Dumping structure for table cart.order_lines
CREATE TABLE IF NOT EXISTS `order_lines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `qty` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_CC9FF86B8D9F6D38` (`order_id`),
  KEY `IDX_CC9FF86B4584665A` (`product_id`),
  CONSTRAINT `FK_CC9FF86B4584665A` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `FK_CC9FF86B8D9F6D38` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table cart.order_lines: ~2 rows (approximately)
/*!40000 ALTER TABLE `order_lines` DISABLE KEYS */;
INSERT IGNORE INTO `order_lines` (`id`, `product_id`, `order_id`, `name`, `price`, `qty`) VALUES
	(1, 1, 1, 'Cheese (1 KG)', 100.0000, 1),
	(2, 1, 2, 'Cheese (1 KG)', 100.0000, 9);
/*!40000 ALTER TABLE `order_lines` ENABLE KEYS */;

-- Dumping structure for table cart.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(15,4) NOT NULL DEFAULT '0.0000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table cart.products: ~3 rows (approximately)
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT IGNORE INTO `products` (`id`, `name`, `price`) VALUES
	(1, 'Cheese (1 KG)', 100.0000),
	(2, 'Beer (1L)', 201.0000),
	(3, 'Coke (1L)', 1.0000);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;

-- Dumping structure for table cart.product_ratings
CREATE TABLE IF NOT EXISTS `product_ratings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `rate` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1F6F1C79A76ED395` (`user_id`),
  KEY `IDX_1F6F1C794584665A` (`product_id`),
  CONSTRAINT `FK_1F6F1C794584665A` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `FK_1F6F1C79A76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table cart.product_ratings: ~13 rows (approximately)
/*!40000 ALTER TABLE `product_ratings` DISABLE KEYS */;
INSERT IGNORE INTO `product_ratings` (`id`, `user_id`, `product_id`, `rate`) VALUES
	(1, 1, 1, 5),
	(2, 1, 2, 5),
	(3, 1, 1, 5),
	(4, 1, 1, 5),
	(5, 1, 1, 5),
	(6, 1, 2, 4),
	(7, 1, 2, 4),
	(8, 1, 2, 5),
	(9, 1, 2, 1),
	(10, 1, 1, 1),
	(11, 1, 2, 5),
	(12, 1, 2, 5),
	(13, 1, 1, 5);
/*!40000 ALTER TABLE `product_ratings` ENABLE KEYS */;

-- Dumping structure for table cart.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `balance` decimal(15,4) NOT NULL DEFAULT '0.0000',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1483A5E9E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table cart.users: ~1 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT IGNORE INTO `users` (`id`, `name`, `email`, `password`, `balance`) VALUES
	(1, 'Vienzent', 'vienzent.0000@gmail.com', 'P@$$w0rd', 998680.0000);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
