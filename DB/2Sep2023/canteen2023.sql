-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 02, 2023 at 12:24 PM
-- Server version: 5.7.36
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `canteen2023`
--

-- --------------------------------------------------------

--
-- Table structure for table `je_orders`
--

DROP TABLE IF EXISTS `je_orders`;
CREATE TABLE IF NOT EXISTS `je_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product` varchar(100) NOT NULL,
  `qty` int(11) NOT NULL,
  `confirmation` varchar(30) NOT NULL,
  `total` varchar(100) NOT NULL,
  `design` varchar(300) NOT NULL,
  `note` varchar(500) NOT NULL,
  `date` datetime NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `je_products`
--

DROP TABLE IF EXISTS `je_products`;
CREATE TABLE IF NOT EXISTS `je_products` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `mode` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `price` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=61 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `je_products`
--

INSERT INTO `je_products` (`id`, `name`, `mode`, `description`, `price`) VALUES
(38, 'nutrition-1-general', 'admitpat', '1 patient + 1 attender', 250),
(39, 'nutrition-2-icu', 'admitpat', '1 attender + ICU diet', 300),
(40, 'nutrition-3-semisolid', 'admitpat', 'semi solid + 1 attender', 250),
(41, 'nutrition-4-private-ward', 'admitpat', '1 attendar special + 1 patient diet', 500),
(43, 'tea', 'canteen', 'milk tea', 5),
(44, 'nutrition-nicu', 'admitpat', '1 attender + patient', 150),
(45, 'economic thali', 'admitpat', 'simple rice, daal,roti ,sabzi', 30),
(46, 'special thali', 'admitpat', 'two sabzi,daal, rice ,roti salad', 60),
(47, 'poha/upma', 'admitpat', 'poha/upma', 15),
(48, 'cofee', 'admitpat', 'with milk', 10),
(49, 'packedge water', 'admitpat', '1 lit', 20),
(50, 'packedge water', 'admitpat', '500ml', 10),
(51, 'packedge water', 'admitpat', '200ml', 5),
(52, 'Staff Pass Breakast', 'admitpat', 'for 1 month', 1700),
(53, 'Staff Pass Lunch and Dinner', 'admitpat', 'for 1 month', 1500),
(54, 'Staff Pass Breakfast Lunch and Dinner', 'admitpat', 'for 1 month', 3000),
(55, 'Staff Pass Thali', 'admitpat', 'for 1 month', 750),
(56, 'Staff Pass Thali with Breakfast', 'admitpat', 'for 1 month', 1000),
(57, 'NUTRITION', 'admitpat', '0', 1000),
(58, 'Smart-Thali', 'admitpat', 'for smart card patient', 150),
(59, 'Breakfast combo', 'canteen', 'breakfast', 100),
(60, 'Covid Nutrition', 'admitpat', 'admit patients', 1000);

-- --------------------------------------------------------

--
-- Table structure for table `je_user`
--

DROP TABLE IF EXISTS `je_user`;
CREATE TABLE IF NOT EXISTS `je_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `position` varchar(45) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `je_user`
--

INSERT INTO `je_user` (`user_id`, `username`, `password`, `position`) VALUES
(1, 'admin', 'terminal', 'front desk');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
