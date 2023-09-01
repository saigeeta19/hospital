-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 29, 2016 at 12:14 PM
-- Server version: 5.6.16
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `jaharaexpress`
--
CREATE DATABASE IF NOT EXISTS `jaharaexpress` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `jaharaexpress`;

-- --------------------------------------------------------

--
-- Table structure for table `je_orders`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=54 ;

--
-- Dumping data for table `je_orders`
--

INSERT INTO `je_orders` (`id`, `product`, `qty`, `confirmation`, `total`, `design`, `note`, `date`, `status`) VALUES
(1, 'Magic Mug', 1000, 'TKE-KMS', '150000', 'design/wire_transfer_256.png', 'rewewe', '2016-09-01 00:00:00', 0),
(2, 'Mug', 5, 'DSO-4CH', '500', 'design/', 'small', '2016-09-02 00:00:00', 0),
(3, 'Magic Mug', 1111, 'TKE-KMS', '166650', 'design/ownerpic.png', 'ewewewe', '2016-09-03 00:00:00', 0),
(4, 'Magic Mug', 2222, 'TKE-KMS', '333300', 'design/ownerpic.png', 'sdsdsdsd', '2016-09-04 00:00:00', 0),
(6, 'Magic Mug', 22222, 'HXF-MII', '3333300', 'design/New Picture.png', 'eweewe', '2016-09-05 00:00:00', 0),
(8, 'Echo Bag', 8, 'RUO-FQX', '200', 'design/', 'wallet size', '2016-09-06 00:00:00', 0),
(9, 'Thumbler', 4, 'KSD-BYN', '360', 'design/', 'small', '2016-09-07 00:00:00', 0),
(10, 'Thumbler', 100, 'OQF-6YC', '9000', 'design/hAnNah018.jpg', '', '2016-09-08 00:00:00', 0),
(11, 'keychain', 90, 'QMJ-HRX', '2250', 'design/hAnNah018.jpg', 'butterfly', '2016-09-09 00:00:00', 0),
(12, 'Mug', 9, 'QY-FJ3', '900', 'design/hAnNah018.jpg', '', '2016-09-09 00:00:00', 0),
(13, 'T-shirt', 100, 'WYQW-5OZ', '18000', 'design/wire_transfer_256.png', 'small, black 100', '2016-09-10 00:00:00', 0),
(16, 'Magic Mug', 143, 'IUJ-B44', '21450', 'design/ownerpic.png', '', '2016-09-14 00:00:00', 0),
(17, 'Mug', 1, 'GLM-VO3', '100', 'design/537484_234955419971298_1129768462_n.jpg', '', '2016-09-12 00:00:00', 0),
(19, 'keychain', 1, 'AS-TED', '25', 'design/ownerpic.png', 'heart', '2016-09-14 00:00:00', 0),
(43, 'Keychain', 3, 'TMD-B2Y', '75', '', '', '2016-09-29 12:27:06', 2),
(44, 'test Product 1', 2, 'TMD-B2Y', '71', '', '', '2016-09-29 12:36:28', 2),
(45, 'Magic Mug', 1, 'TMD-B2Y', '150', '', '', '2016-09-29 12:38:09', 2),
(46, 'Magic Mug', 2, 'DKT-P2S', '300', '', '', '2016-09-29 12:39:08', 2),
(47, 'Thumbler', 3, 'DKT-P2S', '270', '', '', '2016-09-29 12:39:36', 0),
(48, 'test Product', 3, 'DKT-P2S', '90', '', '', '2016-09-29 12:39:46', 1),
(49, 'test Product', 10, 'SOS-K5T', '300', '', '', '2016-09-29 15:14:12', 2),
(50, 'test Product', 6, 'MB-6BJ', '180', '', '', '2016-09-29 16:32:14', 0),
(51, 'Keychain', 0, 'OQCE-JLN', '25', '', '', '2016-09-29 16:33:59', 0),
(52, 'Thumbler', 1, 'ZHJU-4FI', '90', '', '', '2016-09-29 16:41:13', 0),
(53, 'test Product', 2, 'ZHJU-4FI', '60', '', '', '2016-09-29 16:41:19', 0);

-- --------------------------------------------------------

--
-- Table structure for table `je_products`
--

CREATE TABLE IF NOT EXISTS `je_products` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `img` varchar(32) COLLATE utf8_unicode_ci DEFAULT '',
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `price` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `img` (`img`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=31 ;

--
-- Dumping data for table `je_products`
--

INSERT INTO `je_products` (`id`, `img`, `name`, `description`, `price`) VALUES
(13, 'banner-2.jpg', 'Magic Mug', 'greats as souvenirs or giveaways for birthday, weddings, reunions or any event *can also be used as campaign or promotional material Personalized White Mugs, 11 oz. It is good as Company giveaways and souvenirs, also for special occasions like Birthday, Debut, Weddings and even Baptismal/ Dedication giveaways. ', 150),
(28, 'partnerships.jpg', 'test Product', 'sdfsfsdf', 30),
(15, 'tt7.jpg', 'Thumbler', 'great as souvenirs or giveaways for birthday, weddings, reunions or any event *can also be used as campaign or promotional material ', 90),
(20, 'k3.jpg', 'Keychain', 'great as souvenirs or giveaways for birthday;in bags and cellphone decoration', 25),
(29, '', 'test Product 1', 'test test', 35.5),
(30, 'dummy', 'Burger', 'chicken burger', 60);

-- --------------------------------------------------------

--
-- Table structure for table `je_user`
--

CREATE TABLE IF NOT EXISTS `je_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `position` varchar(45) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `je_user`
--

INSERT INTO `je_user` (`user_id`, `username`, `password`, `position`) VALUES
(1, 'admin', 'admin', 'front desk');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
