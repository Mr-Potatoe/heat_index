-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 17, 2024 at 06:57 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `heat_indices`
--

-- --------------------------------------------------------

--
-- Table structure for table `alerts`
--

CREATE TABLE `alerts` (
  `alert_id` int(11) NOT NULL,
  `station_id` int(11) DEFAULT NULL,
  `data_id` int(11) DEFAULT NULL,
  `alert_type` varchar(50) DEFAULT NULL,
  `alert_message` varchar(255) DEFAULT NULL,
  `alert_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alerts`
--

INSERT INTO `alerts` (`alert_id`, `station_id`, `data_id`, `alert_type`, `alert_message`, `alert_time`) VALUES
(41, 1, 126, 'Extreme Danger', 'Heat index exceeds 54Â°C. Extreme danger, heat stroke highly likely.', '2024-09-17 03:27:50'),
(42, 2, 127, 'Danger', 'Heat index is between 41Â°C and 54Â°C. Danger, heat cramps and heat exhaustion are likely, heat stroke is possible.', '2024-09-17 03:27:50'),
(43, 1, 128, 'Extreme Caution', 'Heat index is between 32Â°C and 41Â°C. Extreme caution, heat cramps and heat exhaustion are possible.', '2024-09-17 03:27:56'),
(44, 2, 129, 'Caution', 'Heat index is between 27Â°C and 32Â°C. Caution, fatigue is possible with prolonged exposure and activity.', '2024-09-17 03:27:56'),
(45, 1, 130, 'Extreme Caution', 'Heat index is between 32Â°C and 41Â°C. Extreme caution, heat cramps and heat exhaustion are possible.', '2024-09-17 03:27:57'),
(46, 1, 132, 'Danger', 'Heat index is between 41Â°C and 54Â°C. Danger, heat cramps and heat exhaustion are likely, heat stroke is possible.', '2024-09-17 03:27:58'),
(47, 1, 134, 'Extreme Caution', 'Heat index is between 32Â°C and 41Â°C. Extreme caution, heat cramps and heat exhaustion are possible.', '2024-09-17 03:27:59'),
(48, 2, 135, 'Extreme Caution', 'Heat index is between 32Â°C and 41Â°C. Extreme caution, heat cramps and heat exhaustion are possible.', '2024-09-17 03:27:59'),
(49, 1, 136, 'Extreme Caution', 'Heat index is between 32Â°C and 41Â°C. Extreme caution, heat cramps and heat exhaustion are possible.', '2024-09-17 03:28:00'),
(50, 2, 137, 'Caution', 'Heat index is between 27Â°C and 32Â°C. Caution, fatigue is possible with prolonged exposure and activity.', '2024-09-17 03:28:00'),
(51, 1, 138, 'Danger', 'Heat index is between 41Â°C and 54Â°C. Danger, heat cramps and heat exhaustion are likely, heat stroke is possible.', '2024-09-17 03:28:01'),
(52, 2, 139, 'Extreme Caution', 'Heat index is between 32Â°C and 41Â°C. Extreme caution, heat cramps and heat exhaustion are possible.', '2024-09-17 03:28:01'),
(53, 1, 140, 'Caution', 'Heat index is between 27Â°C and 32Â°C. Caution, fatigue is possible with prolonged exposure and activity.', '2024-09-17 03:28:02'),
(54, 2, 141, 'Caution', 'Heat index is between 27Â°C and 32Â°C. Caution, fatigue is possible with prolonged exposure and activity.', '2024-09-17 03:28:02'),
(55, 1, 142, 'Extreme Caution', 'Heat index is between 32Â°C and 41Â°C. Extreme caution, heat cramps and heat exhaustion are possible.', '2024-09-17 03:28:04'),
(56, 2, 143, 'Caution', 'Heat index is between 27Â°C and 32Â°C. Caution, fatigue is possible with prolonged exposure and activity.', '2024-09-17 03:28:04'),
(57, 2, 145, 'Extreme Caution', 'Heat index is between 32Â°C and 41Â°C. Extreme caution, heat cramps and heat exhaustion are possible.', '2024-09-17 03:28:05'),
(58, 1, 146, 'Caution', 'Heat index is between 27Â°C and 32Â°C. Caution, fatigue is possible with prolonged exposure and activity.', '2024-09-17 03:28:06'),
(59, 2, 147, 'Caution', 'Heat index is between 27Â°C and 32Â°C. Caution, fatigue is possible with prolonged exposure and activity.', '2024-09-17 03:28:06'),
(60, 1, 148, 'Caution', 'Heat index is between 27Â°C and 32Â°C. Caution, fatigue is possible with prolonged exposure and activity.', '2024-09-17 03:28:07'),
(61, 1, 152, 'Caution', 'Heat index is between 27Â°C and 32Â°C. Caution, fatigue is possible with prolonged exposure and activity.', '2024-09-17 03:28:09'),
(62, 2, 153, 'Extreme Caution', 'Heat index is between 32Â°C and 41Â°C. Extreme caution, heat cramps and heat exhaustion are possible.', '2024-09-17 03:28:09'),
(63, 2, 157, 'Extreme Caution', 'Heat index is between 32Â°C and 41Â°C. Extreme caution, heat cramps and heat exhaustion are possible.', '2024-09-17 03:28:11'),
(64, 2, 159, 'Caution', 'Heat index is between 27Â°C and 32Â°C. Caution, fatigue is possible with prolonged exposure and activity.', '2024-09-17 03:28:12'),
(65, 2, 161, 'Danger', 'Heat index is between 41Â°C and 54Â°C. Danger, heat cramps and heat exhaustion are likely, heat stroke is possible.', '2024-09-17 03:28:13'),
(66, 2, 163, 'Extreme Caution', 'Heat index is between 32Â°C and 41Â°C. Extreme caution, heat cramps and heat exhaustion are possible.', '2024-09-17 03:28:14'),
(67, 1, 164, 'Extreme Caution', 'Heat index is between 32Â°C and 41Â°C. Extreme caution, heat cramps and heat exhaustion are possible.', '2024-09-17 03:28:15'),
(68, 2, 169, 'Extreme Caution', 'Heat index is between 32Â°C and 41Â°C. Extreme caution, heat cramps and heat exhaustion are possible.', '2024-09-17 03:28:18'),
(69, 2, 171, 'Extreme Caution', 'Heat index is between 32Â°C and 41Â°C. Extreme caution, heat cramps and heat exhaustion are possible.', '2024-09-17 03:28:19'),
(70, 1, 172, 'Extreme Caution', 'Heat index is between 32Â°C and 41Â°C. Extreme caution, heat cramps and heat exhaustion are possible.', '2024-09-17 03:28:20'),
(71, 2, 173, 'Extreme Caution', 'Heat index is between 32Â°C and 41Â°C. Extreme caution, heat cramps and heat exhaustion are possible.', '2024-09-17 03:28:20'),
(72, 1, 174, 'Caution', 'Heat index is between 27Â°C and 32Â°C. Caution, fatigue is possible with prolonged exposure and activity.', '2024-09-17 03:28:21'),
(73, 2, 175, 'Caution', 'Heat index is between 27Â°C and 32Â°C. Caution, fatigue is possible with prolonged exposure and activity.', '2024-09-17 03:28:21'),
(74, 1, 176, 'Extreme Caution', 'Heat index is between 32Â°C and 41Â°C. Extreme caution, heat cramps and heat exhaustion are possible.', '2024-09-17 03:28:22'),
(75, 2, 177, 'Extreme Caution', 'Heat index is between 32Â°C and 41Â°C. Extreme caution, heat cramps and heat exhaustion are possible.', '2024-09-17 03:28:22'),
(76, 1, 178, 'Extreme Caution', 'Heat index is between 32Â°C and 41Â°C. Extreme caution, heat cramps and heat exhaustion are possible.', '2024-09-17 03:28:23'),
(77, 2, 181, 'Extreme Caution', 'Heat index is between 32Â°C and 41Â°C. Extreme caution, heat cramps and heat exhaustion are possible.', '2024-09-17 03:28:24'),
(78, 2, 183, 'Extreme Caution', 'Heat index is between 32Â°C and 41Â°C. Extreme caution, heat cramps and heat exhaustion are possible.', '2024-09-17 03:28:25'),
(79, 2, 185, 'Extreme Caution', 'Heat index is between 32Â°C and 41Â°C. Extreme caution, heat cramps and heat exhaustion are possible.', '2024-09-17 03:28:26'),
(80, 1, 186, 'Extreme Caution', 'Heat index is between 32Â°C and 41Â°C. Extreme caution, heat cramps and heat exhaustion are possible.', '2024-09-17 03:28:27'),
(81, 2, 187, 'Extreme Caution', 'Heat index is between 32Â°C and 41Â°C. Extreme caution, heat cramps and heat exhaustion are possible.', '2024-09-17 03:28:27'),
(82, 1, 188, 'Caution', 'Heat index is between 27Â°C and 32Â°C. Caution, fatigue is possible with prolonged exposure and activity.', '2024-09-17 03:28:28'),
(83, 2, 189, 'Danger', 'Heat index is between 41Â°C and 54Â°C. Danger, heat cramps and heat exhaustion are likely, heat stroke is possible.', '2024-09-17 03:28:28'),
(84, 1, 190, 'Extreme Caution', 'Heat index is between 32Â°C and 41Â°C. Extreme caution, heat cramps and heat exhaustion are possible.', '2024-09-17 03:28:29'),
(85, 1, 194, 'Danger', 'Heat index is between 41Â°C and 54Â°C. Danger, heat cramps and heat exhaustion are likely, heat stroke is possible.', '2024-09-17 03:28:31'),
(86, 2, 195, 'Extreme Caution', 'Heat index is between 32Â°C and 41Â°C. Extreme caution, heat cramps and heat exhaustion are possible.', '2024-09-17 03:28:31'),
(87, 2, 197, 'Extreme Caution', 'Heat index is between 32Â°C and 41Â°C. Extreme caution, heat cramps and heat exhaustion are possible.', '2024-09-17 03:28:33'),
(88, 1, 198, 'Caution', 'Heat index is between 27Â°C and 32Â°C. Caution, fatigue is possible with prolonged exposure and activity.', '2024-09-17 03:28:34'),
(89, 1, 220, 'Extreme Caution', 'Heat index is between 32Â°C and 41Â°C. Extreme caution, heat cramps and heat exhaustion are possible.', '2024-09-17 04:51:28'),
(90, 2, 221, 'Extreme Caution', 'Heat index is between 32Â°C and 41Â°C. Extreme caution, heat cramps and heat exhaustion are possible.', '2024-09-17 04:51:28'),
(91, 4, 223, 'Extreme Caution', 'Heat index is between 32Â°C and 41Â°C. Extreme caution, heat cramps and heat exhaustion are possible.', '2024-09-17 04:51:28'),
(92, 5, 224, 'Caution', 'Heat index is between 27Â°C and 32Â°C. Caution, fatigue is possible with prolonged exposure and activity.', '2024-09-17 04:51:28'),
(93, 6, 225, 'Extreme Caution', 'Heat index is between 32Â°C and 41Â°C. Extreme caution, heat cramps and heat exhaustion are possible.', '2024-09-17 04:51:28'),
(94, 7, 226, 'Danger', 'Heat index is between 41Â°C and 54Â°C. Danger, heat cramps and heat exhaustion are likely, heat stroke is possible.', '2024-09-17 04:51:28'),
(95, 10, 229, 'Extreme Caution', 'Heat index is between 32Â°C and 41Â°C. Extreme caution, heat cramps and heat exhaustion are possible.', '2024-09-17 04:51:28'),
(96, 11, 230, 'Extreme Caution', 'Heat index is between 32Â°C and 41Â°C. Extreme caution, heat cramps and heat exhaustion are possible.', '2024-09-17 04:51:28'),
(97, 12, 231, 'Extreme Caution', 'Heat index is between 32Â°C and 41Â°C. Extreme caution, heat cramps and heat exhaustion are possible.', '2024-09-17 04:51:28'),
(98, 14, 233, 'Danger', 'Heat index is between 41Â°C and 54Â°C. Danger, heat cramps and heat exhaustion are likely, heat stroke is possible.', '2024-09-17 04:51:28'),
(99, 3, 236, 'Extreme Caution', 'Heat index is between 32Â°C and 41Â°C. Extreme caution, heat cramps and heat exhaustion are possible.', '2024-09-17 04:52:02'),
(100, 5, 238, 'Extreme Caution', 'Heat index is between 32Â°C and 41Â°C. Extreme caution, heat cramps and heat exhaustion are possible.', '2024-09-17 04:52:02'),
(101, 6, 239, 'Danger', 'Heat index is between 41Â°C and 54Â°C. Danger, heat cramps and heat exhaustion are likely, heat stroke is possible.', '2024-09-17 04:52:02'),
(102, 8, 241, 'Extreme Caution', 'Heat index is between 32Â°C and 41Â°C. Extreme caution, heat cramps and heat exhaustion are possible.', '2024-09-17 04:52:02'),
(103, 9, 242, 'Caution', 'Heat index is between 27Â°C and 32Â°C. Caution, fatigue is possible with prolonged exposure and activity.', '2024-09-17 04:52:02'),
(104, 12, 245, 'Caution', 'Heat index is between 27Â°C and 32Â°C. Caution, fatigue is possible with prolonged exposure and activity.', '2024-09-17 04:52:03'),
(105, 14, 247, 'Caution', 'Heat index is between 27Â°C and 32Â°C. Caution, fatigue is possible with prolonged exposure and activity.', '2024-09-17 04:52:03'),
(106, 1, 248, 'Extreme Caution', 'Heat index is between 32Â°C and 41Â°C. Extreme caution, heat cramps and heat exhaustion are possible.', '2024-09-17 04:52:23'),
(107, 2, 249, 'Caution', 'Heat index is between 27Â°C and 32Â°C. Caution, fatigue is possible with prolonged exposure and activity.', '2024-09-17 04:52:23'),
(108, 3, 250, 'Extreme Caution', 'Heat index is between 32Â°C and 41Â°C. Extreme caution, heat cramps and heat exhaustion are possible.', '2024-09-17 04:52:23'),
(109, 4, 251, 'Extreme Caution', 'Heat index is between 32Â°C and 41Â°C. Extreme caution, heat cramps and heat exhaustion are possible.', '2024-09-17 04:52:23'),
(110, 6, 253, 'Extreme Caution', 'Heat index is between 32Â°C and 41Â°C. Extreme caution, heat cramps and heat exhaustion are possible.', '2024-09-17 04:52:23'),
(111, 7, 254, 'Caution', 'Heat index is between 27Â°C and 32Â°C. Caution, fatigue is possible with prolonged exposure and activity.', '2024-09-17 04:52:23'),
(112, 8, 255, 'Extreme Caution', 'Heat index is between 32Â°C and 41Â°C. Extreme caution, heat cramps and heat exhaustion are possible.', '2024-09-17 04:52:23'),
(113, 10, 257, 'Danger', 'Heat index is between 41Â°C and 54Â°C. Danger, heat cramps and heat exhaustion are likely, heat stroke is possible.', '2024-09-17 04:52:23'),
(114, 11, 258, 'Extreme Caution', 'Heat index is between 32Â°C and 41Â°C. Extreme caution, heat cramps and heat exhaustion are possible.', '2024-09-17 04:52:23'),
(115, 12, 259, 'Extreme Caution', 'Heat index is between 32Â°C and 41Â°C. Extreme caution, heat cramps and heat exhaustion are possible.', '2024-09-17 04:52:23'),
(116, 13, 260, 'Extreme Caution', 'Heat index is between 32Â°C and 41Â°C. Extreme caution, heat cramps and heat exhaustion are possible.', '2024-09-17 04:52:23'),
(117, 14, 261, 'Extreme Caution', 'Heat index is between 32Â°C and 41Â°C. Extreme caution, heat cramps and heat exhaustion are possible.', '2024-09-17 04:52:23');

-- --------------------------------------------------------

--
-- Table structure for table `sensor_data`
--

CREATE TABLE `sensor_data` (
  `data_id` int(11) NOT NULL,
  `station_id` int(11) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `temperature` decimal(5,2) DEFAULT NULL,
  `humidity` decimal(5,2) DEFAULT NULL,
  `heat_index` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sensor_data`
--

INSERT INTO `sensor_data` (`data_id`, `station_id`, `timestamp`, `temperature`, `humidity`, `heat_index`) VALUES
(1, 1, '2024-09-16 03:25:40', 25.50, 60.20, 27.80),
(2, 1, '2024-09-16 04:25:40', 26.20, 59.50, 28.30),
(3, 1, '2024-09-16 05:25:40', 27.10, 58.80, 28.90),
(4, 1, '2024-09-16 06:25:40', 26.80, 59.30, 28.50),
(5, 1, '2024-09-16 07:25:40', 25.90, 60.10, 27.70),
(6, 1, '2024-09-16 08:25:40', 25.20, 60.80, 27.20),
(7, 1, '2024-09-16 09:25:40', 26.40, 59.70, 28.00),
(8, 1, '2024-09-16 10:25:40', 27.30, 58.90, 28.60),
(9, 1, '2024-09-16 11:25:40', 27.90, 58.30, 29.10),
(10, 1, '2024-09-16 12:25:40', 28.50, 57.60, 29.70),
(11, 1, '2024-09-16 13:25:40', 29.10, 57.00, 30.20),
(12, 1, '2024-09-16 14:25:40', 29.70, 56.40, 30.80),
(13, 1, '2024-09-16 15:25:40', 30.20, 55.80, 31.30),
(14, 1, '2024-09-16 16:25:40', 30.60, 55.20, 31.70),
(15, 1, '2024-09-16 17:25:40', 30.90, 54.60, 32.10),
(16, 1, '2024-09-16 18:25:40', 31.20, 54.00, 32.40),
(17, 1, '2024-09-16 19:25:40', 31.40, 53.50, 32.60),
(18, 1, '2024-09-16 20:25:40', 31.50, 53.00, 32.80),
(19, 1, '2024-09-16 21:25:40', 31.60, 52.50, 32.90),
(20, 1, '2024-09-16 22:25:40', 31.60, 52.00, 33.00),
(21, 1, '2024-09-16 23:25:40', 31.50, 51.50, 32.90),
(22, 1, '2024-09-17 00:25:40', 31.40, 51.00, 32.80),
(23, 1, '2024-09-17 01:25:40', 31.20, 50.50, 32.60),
(24, 1, '2024-09-17 02:25:40', 30.90, 50.00, 32.30),
(25, 1, '2024-09-17 03:25:40', 30.50, 49.50, 31.90),
(101, 2, '2024-09-16 03:25:40', 26.80, 61.30, 28.10),
(102, 2, '2024-09-16 04:25:40', 27.40, 60.60, 28.70),
(103, 2, '2024-09-16 05:25:40', 28.20, 59.90, 29.40),
(104, 2, '2024-09-16 06:25:40', 27.90, 60.20, 29.00),
(105, 2, '2024-09-16 07:25:40', 27.10, 60.90, 28.40),
(106, 2, '2024-09-16 08:25:40', 26.40, 61.70, 27.80),
(107, 2, '2024-09-16 09:25:40', 27.60, 60.60, 28.60),
(108, 2, '2024-09-16 10:25:40', 28.50, 59.80, 29.20),
(109, 2, '2024-09-16 11:25:40', 29.10, 59.20, 29.70),
(110, 2, '2024-09-16 12:25:40', 29.70, 58.50, 30.30),
(111, 2, '2024-09-16 13:25:40', 30.20, 57.90, 30.80),
(112, 2, '2024-09-16 14:25:40', 30.70, 57.30, 31.20),
(113, 2, '2024-09-16 15:25:40', 31.10, 56.70, 31.60),
(114, 2, '2024-09-16 16:25:40', 31.50, 56.10, 31.90),
(115, 2, '2024-09-16 17:25:40', 31.80, 55.50, 32.20),
(116, 2, '2024-09-16 18:25:40', 32.00, 54.90, 32.40),
(117, 2, '2024-09-16 19:25:40', 32.10, 54.30, 32.60),
(118, 2, '2024-09-16 20:25:40', 32.10, 53.70, 32.70),
(119, 2, '2024-09-16 21:25:40', 32.00, 53.10, 32.70),
(120, 2, '2024-09-16 22:25:40', 31.80, 52.50, 32.70),
(121, 2, '2024-09-16 23:25:40', 31.50, 51.90, 32.50),
(122, 2, '2024-09-17 00:25:40', 31.10, 51.30, 32.30),
(123, 2, '2024-09-17 01:25:40', 30.60, 50.70, 31.90),
(124, 2, '2024-09-17 02:25:40', 30.00, 50.10, 31.50),
(125, 2, '2024-09-17 03:25:40', 29.30, 49.50, 30.90),
(126, 1, '2024-09-17 03:27:50', 36.02, 68.19, 60.04),
(127, 2, '2024-09-17 03:27:50', 25.25, 71.23, 42.83),
(128, 1, '2024-09-17 03:27:56', 31.94, 57.86, 38.91),
(129, 2, '2024-09-17 03:27:56', 34.42, 47.13, 29.84),
(130, 1, '2024-09-17 03:27:57', 31.93, 52.11, 32.35),
(131, 2, '2024-09-17 03:27:57', 34.40, 43.68, 26.20),
(132, 1, '2024-09-17 03:27:58', 32.03, 59.81, 41.39),
(133, 2, '2024-09-17 03:27:58', 31.14, 44.47, 23.82),
(134, 1, '2024-09-17 03:27:59', 31.14, 57.50, 37.32),
(135, 2, '2024-09-17 03:27:59', 33.43, 50.42, 32.32),
(136, 1, '2024-09-17 03:28:00', 34.22, 53.44, 36.80),
(137, 2, '2024-09-17 03:28:00', 32.74, 47.99, 28.91),
(138, 1, '2024-09-17 03:28:01', 34.58, 58.19, 43.25),
(139, 2, '2024-09-17 03:28:01', 31.85, 59.56, 40.81),
(140, 1, '2024-09-17 03:28:02', 31.36, 49.91, 29.34),
(141, 2, '2024-09-17 03:28:02', 31.88, 51.15, 31.26),
(142, 1, '2024-09-17 03:28:04', 31.56, 52.87, 32.71),
(143, 2, '2024-09-17 03:28:04', 31.50, 50.73, 30.36),
(144, 1, '2024-09-17 03:28:05', 34.79, 41.43, 24.30),
(145, 2, '2024-09-17 03:28:05', 32.89, 51.38, 32.74),
(146, 1, '2024-09-17 03:28:06', 31.27, 49.72, 29.05),
(147, 2, '2024-09-17 03:28:06', 34.88, 44.42, 27.43),
(148, 1, '2024-09-17 03:28:07', 33.33, 47.38, 28.93),
(149, 2, '2024-09-17 03:28:07', 30.70, 46.18, 24.97),
(150, 1, '2024-09-17 03:28:08', 34.88, 42.86, 25.81),
(151, 2, '2024-09-17 03:28:08', 34.04, 42.83, 25.01),
(152, 1, '2024-09-17 03:28:09', 34.32, 45.58, 28.08),
(153, 2, '2024-09-17 03:28:09', 31.45, 56.56, 36.68),
(154, 1, '2024-09-17 03:28:10', 30.42, 47.00, 25.46),
(155, 2, '2024-09-17 03:28:10', 30.24, 47.83, 26.04),
(156, 1, '2024-09-17 03:28:11', 33.53, 44.58, 26.26),
(157, 2, '2024-09-17 03:28:11', 31.05, 54.60, 33.93),
(158, 1, '2024-09-17 03:28:12', 30.64, 46.83, 25.52),
(159, 2, '2024-09-17 03:28:12', 34.62, 44.54, 27.29),
(160, 1, '2024-09-17 03:28:13', 33.21, 40.56, 22.09),
(161, 2, '2024-09-17 03:28:13', 32.38, 59.79, 41.92),
(162, 1, '2024-09-17 03:28:14', 32.75, 45.03, 25.93),
(163, 2, '2024-09-17 03:28:14', 33.84, 50.35, 32.73),
(164, 1, '2024-09-17 03:28:15', 31.18, 56.95, 36.75),
(165, 2, '2024-09-17 03:28:15', 31.67, 40.95, 21.13),
(166, 1, '2024-09-17 03:28:16', 32.23, 44.56, 24.96),
(167, 2, '2024-09-17 03:28:16', 30.19, 45.19, 23.54),
(168, 1, '2024-09-17 03:28:17', 30.99, 42.92, 22.28),
(169, 2, '2024-09-17 03:28:18', 32.24, 52.85, 33.55),
(170, 1, '2024-09-17 03:28:19', 30.23, 45.51, 23.88),
(171, 2, '2024-09-17 03:28:19', 32.23, 53.67, 34.47),
(172, 1, '2024-09-17 03:28:20', 34.54, 52.95, 36.64),
(173, 2, '2024-09-17 03:28:20', 31.60, 52.64, 32.52),
(174, 1, '2024-09-17 03:28:21', 34.99, 45.00, 28.15),
(175, 2, '2024-09-17 03:28:21', 32.70, 50.19, 31.20),
(176, 1, '2024-09-17 03:28:22', 31.15, 53.07, 32.41),
(177, 2, '2024-09-17 03:28:22', 31.27, 54.11, 33.70),
(178, 1, '2024-09-17 03:28:23', 31.36, 52.70, 32.27),
(179, 2, '2024-09-17 03:28:23', 30.25, 40.22, 19.32),
(180, 1, '2024-09-17 03:28:24', 34.74, 40.40, 23.25),
(181, 2, '2024-09-17 03:28:24', 33.97, 50.22, 32.74),
(182, 1, '2024-09-17 03:28:25', 30.09, 48.40, 26.43),
(183, 2, '2024-09-17 03:28:25', 31.40, 59.87, 40.48),
(184, 1, '2024-09-17 03:28:26', 32.62, 42.91, 23.76),
(185, 2, '2024-09-17 03:28:26', 31.04, 54.90, 34.25),
(186, 1, '2024-09-17 03:28:27', 30.98, 54.60, 33.84),
(187, 2, '2024-09-17 03:28:27', 30.34, 54.78, 33.18),
(188, 1, '2024-09-17 03:28:28', 30.68, 51.60, 30.27),
(189, 2, '2024-09-17 03:28:28', 34.92, 56.20, 41.19),
(190, 1, '2024-09-17 03:28:29', 34.10, 53.79, 37.06),
(191, 2, '2024-09-17 03:28:29', 33.43, 41.73, 23.38),
(192, 1, '2024-09-17 03:28:30', 30.84, 42.17, 21.47),
(193, 2, '2024-09-17 03:28:30', 34.20, 40.70, 23.08),
(194, 1, '2024-09-17 03:28:31', 34.40, 57.45, 42.02),
(195, 2, '2024-09-17 03:28:31', 32.26, 54.40, 35.33),
(196, 1, '2024-09-17 03:28:32', 33.93, 40.43, 22.59),
(197, 2, '2024-09-17 03:28:33', 33.09, 54.65, 36.73),
(198, 1, '2024-09-17 03:28:34', 33.24, 46.03, 27.43),
(199, 2, '2024-09-17 03:28:34', 30.88, 44.60, 23.68),
(200, 3, '2024-09-17 00:00:00', 30.50, 60.00, 32.10),
(201, 3, '2024-09-17 01:00:00', 31.00, 58.00, 33.00),
(202, 4, '2024-09-17 00:00:00', 29.00, 65.00, 30.00),
(203, 4, '2024-09-17 01:00:00', 29.50, 63.00, 30.50),
(204, 5, '2024-09-17 00:00:00', 28.00, 70.00, 28.50),
(205, 5, '2024-09-17 01:00:00', 28.50, 68.00, 29.00),
(206, 6, '2024-09-17 00:00:00', 32.00, 55.00, 34.50),
(207, 6, '2024-09-17 01:00:00', 32.50, 54.00, 35.00),
(208, 7, '2024-09-17 00:00:00', 30.00, 60.00, 32.00),
(209, 7, '2024-09-17 01:00:00', 30.50, 59.00, 32.50),
(210, 8, '2024-09-17 00:00:00', 27.00, 75.00, 26.00),
(211, 8, '2024-09-17 01:00:00', 27.50, 73.00, 26.50),
(212, 9, '2024-09-17 00:00:00', 31.00, 60.00, 33.00),
(213, 9, '2024-09-17 01:00:00', 31.50, 58.00, 33.50),
(214, 10, '2024-09-17 00:00:00', 29.50, 62.00, 31.00),
(215, 10, '2024-09-17 01:00:00', 30.00, 61.00, 31.50),
(216, 11, '2024-09-17 00:00:00', 28.00, 68.00, 29.00),
(217, 11, '2024-09-17 01:00:00', 28.50, 67.00, 29.50),
(218, 12, '2024-09-17 00:00:00', 30.00, 64.00, 31.50),
(219, 12, '2024-09-17 01:00:00', 30.50, 62.00, 32.00),
(220, 1, '2024-09-17 04:51:28', 34.08, 50.76, 33.49),
(221, 2, '2024-09-17 04:51:28', 33.71, 53.17, 35.81),
(222, 3, '2024-09-17 04:51:28', 30.56, 42.58, 21.59),
(223, 4, '2024-09-17 04:51:28', 32.37, 53.56, 34.52),
(224, 5, '2024-09-17 04:51:28', 32.82, 49.39, 30.49),
(225, 6, '2024-09-17 04:51:28', 33.46, 57.04, 40.12),
(226, 7, '2024-09-17 04:51:28', 34.79, 56.34, 41.17),
(227, 8, '2024-09-17 04:51:28', 32.00, 41.58, 21.97),
(228, 9, '2024-09-17 04:51:28', 30.61, 46.91, 25.56),
(229, 10, '2024-09-17 04:51:28', 30.04, 58.53, 36.89),
(230, 11, '2024-09-17 04:51:28', 34.12, 52.41, 35.45),
(231, 12, '2024-09-17 04:51:28', 32.32, 57.46, 38.98),
(232, 13, '2024-09-17 04:51:28', 32.74, 44.41, 25.31),
(233, 14, '2024-09-17 04:51:28', 33.80, 59.78, 44.11),
(234, 1, '2024-09-17 04:52:02', 30.99, 44.13, 23.36),
(235, 2, '2024-09-17 04:52:02', 30.37, 42.23, 21.12),
(236, 3, '2024-09-17 04:52:02', 33.69, 49.89, 32.05),
(237, 4, '2024-09-17 04:52:02', 34.47, 42.14, 24.71),
(238, 5, '2024-09-17 04:52:02', 30.95, 56.15, 35.51),
(239, 6, '2024-09-17 04:52:02', 34.31, 57.01, 41.33),
(240, 7, '2024-09-17 04:52:02', 31.32, 43.17, 22.80),
(241, 8, '2024-09-17 04:52:02', 30.36, 59.88, 38.90),
(242, 9, '2024-09-17 04:52:02', 34.15, 44.71, 27.00),
(243, 10, '2024-09-17 04:52:03', 32.54, 45.03, 25.72),
(244, 11, '2024-09-17 04:52:03', 32.16, 43.19, 23.60),
(245, 12, '2024-09-17 04:52:03', 31.64, 48.55, 28.29),
(246, 13, '2024-09-17 04:52:03', 31.36, 42.41, 22.16),
(247, 14, '2024-09-17 04:52:03', 34.24, 46.39, 28.86),
(248, 1, '2024-09-17 04:52:23', 32.38, 57.16, 38.70),
(249, 2, '2024-09-17 04:52:23', 31.49, 50.56, 30.17),
(250, 3, '2024-09-17 04:52:23', 32.90, 52.20, 33.66),
(251, 4, '2024-09-17 04:52:23', 33.20, 56.20, 38.73),
(252, 5, '2024-09-17 04:52:23', 31.80, 45.00, 24.96),
(253, 6, '2024-09-17 04:52:23', 32.99, 55.07, 37.09),
(254, 7, '2024-09-17 04:52:23', 32.68, 49.74, 30.70),
(255, 8, '2024-09-17 04:52:23', 32.93, 52.09, 33.58),
(256, 9, '2024-09-17 04:52:23', 34.06, 41.88, 24.09),
(257, 10, '2024-09-17 04:52:23', 34.00, 57.95, 42.08),
(258, 11, '2024-09-17 04:52:23', 31.44, 54.04, 33.83),
(259, 12, '2024-09-17 04:52:23', 32.50, 58.42, 40.41),
(260, 13, '2024-09-17 04:52:23', 34.92, 50.90, 34.68),
(261, 14, '2024-09-17 04:52:23', 30.40, 56.30, 34.92);

-- --------------------------------------------------------

--
-- Table structure for table `sensor_station`
--

CREATE TABLE `sensor_station` (
  `station_id` int(11) NOT NULL,
  `location` varchar(100) DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sensor_station`
--

INSERT INTO `sensor_station` (`station_id`, `location`, `latitude`, `longitude`) VALUES
(1, 'BSIS Building', 7.9469980, 123.5875620),
(2, 'Farmers\'s Hall', 7.9471770, 123.5879210),
(3, 'First location near guardhouse', 7.9473004, 123.5876167),
(4, 'Second location near main building right side', 7.9480162, 123.5881823),
(5, '3rd location behind main hall', 7.9476420, 123.5881160),
(6, '4th location near Akasya tree (left)', 7.9482380, 123.5885240),
(7, '5th location near Akasya tree (right)', 7.9481550, 123.5886940),
(8, '6th location front yard Oasis', 7.9480310, 123.5889620),
(9, '7th location behind Crim building', 7.9476180, 123.5883540),
(10, '8th location Agri place', 7.9472520, 123.5882730),
(11, '9th location Agri place behind Farmers Hall', 7.9469680, 123.5881530),
(12, '10th location near ROTC office', 7.9462340, 123.5871250),
(13, '11th location Pundol basketball court', 7.9456080, 123.5876410),
(14, '12th location near ROTC office', 7.9461940, 123.5869550);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', 'admin_password', 'admin'),
(2, 'user', 'user_password', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alerts`
--
ALTER TABLE `alerts`
  ADD PRIMARY KEY (`alert_id`),
  ADD KEY `station_id` (`station_id`),
  ADD KEY `data_id` (`data_id`);

--
-- Indexes for table `sensor_data`
--
ALTER TABLE `sensor_data`
  ADD PRIMARY KEY (`data_id`),
  ADD KEY `station_id` (`station_id`);

--
-- Indexes for table `sensor_station`
--
ALTER TABLE `sensor_station`
  ADD PRIMARY KEY (`station_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alerts`
--
ALTER TABLE `alerts`
  MODIFY `alert_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT for table `sensor_data`
--
ALTER TABLE `sensor_data`
  MODIFY `data_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=262;

--
-- AUTO_INCREMENT for table `sensor_station`
--
ALTER TABLE `sensor_station`
  MODIFY `station_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alerts`
--
ALTER TABLE `alerts`
  ADD CONSTRAINT `alerts_ibfk_1` FOREIGN KEY (`station_id`) REFERENCES `sensor_station` (`station_id`),
  ADD CONSTRAINT `alerts_ibfk_2` FOREIGN KEY (`data_id`) REFERENCES `sensor_data` (`data_id`);

--
-- Constraints for table `sensor_data`
--
ALTER TABLE `sensor_data`
  ADD CONSTRAINT `sensor_data_ibfk_1` FOREIGN KEY (`station_id`) REFERENCES `sensor_station` (`station_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
