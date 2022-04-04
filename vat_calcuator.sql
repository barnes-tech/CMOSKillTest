-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 04, 2022 at 06:36 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vat_calcuator`
--

-- --------------------------------------------------------

--
-- Table structure for table `calculation`
--

DROP TABLE IF EXISTS `calculation`;
CREATE TABLE IF NOT EXISTS `calculation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cost` decimal(12,2) NOT NULL,
  `rate` decimal(4,2) NOT NULL,
  `vat` decimal(12,2) NOT NULL,
  `total` decimal(13,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `calculation`
--

INSERT INTO `calculation` (`id`, `cost`, `rate`, `vat`, `total`) VALUES
(17, '100.00', '20.00', '20.00', '120.00');

-- --------------------------------------------------------

--
-- Table structure for table `country_tax`
--

DROP TABLE IF EXISTS `country_tax`;
CREATE TABLE IF NOT EXISTS `country_tax` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate` decimal(4,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `country_tax`
--

INSERT INTO `country_tax` (`id`, `country`, `rate`) VALUES
(1, 'United Kingdom ', '20.00'),
(3, 'uruguay', '22.00'),
(4, 'chile', '19.00');

-- --------------------------------------------------------

--
-- Table structure for table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
