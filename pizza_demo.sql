-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 16, 2022 at 07:12 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pizza_demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `delivery_driver`
--

DROP TABLE IF EXISTS `delivery_driver`;
CREATE TABLE IF NOT EXISTS `delivery_driver` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `employee_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delivery_driver`
--

INSERT INTO `delivery_driver` (`id`, `first_name`, `last_name`, `employee_id`) VALUES
(1, 'David', 'Smith', 1),
(2, 'Barry', 'Davis', 2),
(3, 'Mark', 'Jones', 3);

-- --------------------------------------------------------

--
-- Table structure for table `delivery_method`
--

DROP TABLE IF EXISTS `delivery_method`;
CREATE TABLE IF NOT EXISTS `delivery_method` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `method_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('eat_in','pick_up','delivery') COLLATE utf8mb4_unicode_ci NOT NULL,
  `cost` decimal(4,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delivery_method`
--

INSERT INTO `delivery_method` (`id`, `method_name`, `type`, `cost`) VALUES
(1, 'Table 1', 'eat_in', '0.00'),
(2, 'Table 2', 'eat_in', '0.00'),
(3, 'Just Eat delivery', 'delivery', '3.00'),
(4, 'UberEats delivery', 'delivery', '3.50'),
(5, 'Collection', 'pick_up', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20220114162749', '2022-01-14 16:29:07', 471);

-- --------------------------------------------------------

--
-- Table structure for table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `delivery_method_id_id` int(11) DEFAULT NULL,
  `delivery_driver_id_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `UNIQ_E52FFDEE59BD6720` (`delivery_method_id_id`) USING BTREE,
  KEY `UNIQ_E52FFDEE6045AA7E` (`delivery_driver_id_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `delivery_method_id_id`, `delivery_driver_id_id`) VALUES
(1, NULL, NULL),
(2, NULL, NULL),
(3, NULL, NULL),
(4, 3, NULL),
(5, 4, NULL),
(6, 3, 1),
(7, 4, 2),
(8, NULL, 3),
(9, NULL, 2),
(10, NULL, 3),
(11, NULL, 3),
(12, NULL, 2),
(13, 3, 3),
(14, 3, NULL),
(15, 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id_id` int(11) NOT NULL,
  `order_item_type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_item_pizza_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_62809DB0FCDAEAAA` (`order_id_id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id_id`, `order_item_type`, `order_item_pizza_id`) VALUES
(1, 1, 'pizza', 3),
(2, 1, 'extra', 4),
(3, 1, 'pizza', 8),
(4, 2, 'pizza', 7),
(5, 2, 'pizza', 10),
(6, 2, 'pizza', 3),
(7, 2, 'extra', 6),
(8, 3, 'pizza', 3),
(9, 3, 'extra', 6),
(10, 4, 'pizza', 4),
(11, 4, 'extra', 6),
(12, 4, 'extra', 8),
(13, 5, 'pizza', 7),
(14, 5, 'pizza', 10),
(15, 5, 'pizza', 2),
(16, 6, 'pizza', 3),
(17, 6, 'pizza', 7),
(18, 6, 'pizza', 10),
(19, 6, 'extra', 12),
(20, 7, 'pizza', 2),
(21, 7, 'pizza', 7),
(22, 7, 'pizza', 10),
(23, 7, 'extra', 7),
(24, 13, 'extra', 8),
(25, 13, 'pizza', 7),
(26, 13, 'pizza', 9),
(27, 13, 'extra', 8),
(28, 15, 'pizza', 3),
(29, 15, 'pizza', 8),
(30, 15, 'extra', 6),
(31, 15, 'extra', 13);

-- --------------------------------------------------------

--
-- Table structure for table `pizza`
--

DROP TABLE IF EXISTS `pizza`;
CREATE TABLE IF NOT EXISTS `pizza` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pizza`
--

INSERT INTO `pizza` (`id`, `name`) VALUES
(1, 'Bondi'),
(2, 'Neapolitano'),
(3, 'The Coney Island'),
(4, 'Constantine'),
(5, 'Makena'),
(6, 'Echo (V)'),
(7, 'Mothecombe'),
(8, 'Bantham'),
(9, 'Royan (V)'),
(10, 'Atrani');

-- --------------------------------------------------------

--
-- Table structure for table `pizza_ingredients`
--

DROP TABLE IF EXISTS `pizza_ingredients`;
CREATE TABLE IF NOT EXISTS `pizza_ingredients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `extra_cost` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pizza_ingredients`
--

INSERT INTO `pizza_ingredients` (`id`, `name`, `extra_cost`) VALUES
(1, 'fior di latte', '0.50'),
(2, 'Devon honey roast ham', '1.00'),
(3, 'mushrooms', '0.50'),
(4, 'Kalamata olives', '0.75'),
(5, 'Red onion', '0.50'),
(6, 'crushed walnuts', '0.50'),
(7, 'honey roast pork sausage', '1.00'),
(8, 'pear chutney', '0.50'),
(9, 'fresh baby spinach', '0.50'),
(10, 'pineapple', '0.50'),
(11, 'dry smoked pepperoni', '1.00'),
(12, 'anchovies', '1.00'),
(13, 'capers', '0.50'),
(14, 'fresh basil', '0.50'),
(15, 'chili flakes', '0.50'),
(16, 'piquante peppers', '0.50'),
(17, 'oregano', '0.50'),
(18, 'Cornish spianata salami', '1.00');

-- --------------------------------------------------------

--
-- Table structure for table `pizza_price_list`
--

DROP TABLE IF EXISTS `pizza_price_list`;
CREATE TABLE IF NOT EXISTS `pizza_price_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pizza_id_id` int(11) DEFAULT NULL,
  `item_cost` decimal(4,2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_3DC3B2ED89359C8F` (`pizza_id_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pizza_price_list`
--

INSERT INTO `pizza_price_list` (`id`, `pizza_id_id`, `item_cost`) VALUES
(1, 1, '7.00'),
(2, 2, '9.00'),
(3, 3, '9.00'),
(4, 4, '9.00'),
(5, 5, '8.00'),
(6, 6, '7.00'),
(7, 7, '10.00'),
(8, 8, '10.00'),
(9, 9, '9.00'),
(10, 10, '9.00');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `FK_E52FFDEE59BD6720` FOREIGN KEY (`delivery_method_id_id`) REFERENCES `delivery_method` (`id`),
  ADD CONSTRAINT `FK_E52FFDEE6045AA7E` FOREIGN KEY (`delivery_driver_id_id`) REFERENCES `delivery_driver` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `FK_62809DB0FCDAEAAA` FOREIGN KEY (`order_id_id`) REFERENCES `orders` (`id`);

--
-- Constraints for table `pizza_price_list`
--
ALTER TABLE `pizza_price_list`
  ADD CONSTRAINT `FK_3DC3B2ED89359C8F` FOREIGN KEY (`pizza_id_id`) REFERENCES `pizza` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
