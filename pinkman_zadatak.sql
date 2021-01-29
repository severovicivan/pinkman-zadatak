-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 29, 2021 at 12:06 AM
-- Server version: 8.0.21
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pinkman_zadatak`
--

-- --------------------------------------------------------

--
-- Table structure for table `countries_transactions`
--

DROP TABLE IF EXISTS `countries_transactions`;
CREATE TABLE IF NOT EXISTS `countries_transactions` (
  `Country` varchar(2) CHARACTER SET utf8 COLLATE utf8_croatian_ci NOT NULL,
  `Amount` double NOT NULL,
  `Currency` varchar(3) CHARACTER SET utf8 COLLATE utf8_croatian_ci NOT NULL,
  `Count` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

--
-- Dumping data for table `countries_transactions`
--

INSERT INTO `countries_transactions` (`Country`, `Amount`, `Currency`, `Count`) VALUES
('HR', 836.7718, 'EUR', 15),
('BG', 194.4596, 'EUR', 5),
('MT', 202.7836, 'EUR', 5);

-- --------------------------------------------------------

--
-- Table structure for table `user_feb_transactions`
--

DROP TABLE IF EXISTS `user_feb_transactions`;
CREATE TABLE IF NOT EXISTS `user_feb_transactions` (
  `User` text COLLATE utf8_croatian_ci NOT NULL,
  `Amount` double NOT NULL,
  `Currency` varchar(3) COLLATE utf8_croatian_ci NOT NULL,
  `Count` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

--
-- Dumping data for table `user_feb_transactions`
--

INSERT INTO `user_feb_transactions` (`User`, `Amount`, `Currency`, `Count`) VALUES
('denis', 0, 'EUR', 0),
('vasko', 0, 'EUR', 0),
('dino', 12.07, 'EUR', 1),
('mar', 0, 'EUR', 0),
('martin', 0, 'EUR', 0),
('andrea', 0, 'EUR', 0),
('miro', 0, 'EUR', 0),
('irena', 0, 'EUR', 0),
('marija', 0, 'EUR', 0),
('marko', 0, 'EUR', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_jul_transactions`
--

DROP TABLE IF EXISTS `user_jul_transactions`;
CREATE TABLE IF NOT EXISTS `user_jul_transactions` (
  `User` text COLLATE utf8_croatian_ci NOT NULL,
  `Amount` double NOT NULL,
  `Currency` varchar(3) COLLATE utf8_croatian_ci NOT NULL,
  `Count` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

--
-- Dumping data for table `user_jul_transactions`
--

INSERT INTO `user_jul_transactions` (`User`, `Amount`, `Currency`, `Count`) VALUES
('denis', 446.68, 'EUR', 6),
('vasko', 119.33, 'EUR', 3),
('dino', 55.96, 'EUR', 2),
('mar', 158.6436, 'EUR', 4),
('martin', 75.1296, 'EUR', 2),
('andrea', 175.22, 'EUR', 2),
('miro', 90.7118, 'EUR', 2),
('irena', 44.14, 'EUR', 1),
('marija', 26.78, 'EUR', 1),
('marko', 29.35, 'EUR', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
