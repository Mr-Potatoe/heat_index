-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 03, 2024 at 10:07 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = '+08:00';  -- Set time zone to Philippine time

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
(2, 'Farmers\'s Hall', 7.9471770, 123.5879210);

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
  MODIFY `alert_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `sensor_data`
--
ALTER TABLE `sensor_data`
  MODIFY `data_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `sensor_station`
--
ALTER TABLE `sensor_station`
  MODIFY `station_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
