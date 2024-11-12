-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2024 at 11:05 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `iot_modules`
--

-- --------------------------------------------------------

--
-- Table structure for table `iot_modules`
--

CREATE TABLE `iot_modules` (
  `id` int(11) NOT NULL,
  `module_name` varchar(255) DEFAULT NULL,
  `measurement_type` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive','faulty') DEFAULT NULL,
  `final_measured_value` float DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `iot_modules`
--

INSERT INTO `iot_modules` (`id`, `module_name`, `measurement_type`, `status`, `final_measured_value`, `created_date`) VALUES
(2, 'harpreet kaur', 'temperature', 'active', 32, '2024-11-12 07:46:02'),
(3, 'HARPREET', 'speed', 'active', 52, '2024-11-12 07:47:27'),
(4, 'HARPREET', 'temperature', 'active', 25, '2024-11-12 10:02:58');

-- --------------------------------------------------------

--
-- Table structure for table `iot_modules_history`
--

CREATE TABLE `iot_modules_history` (
  `id` int(11) NOT NULL,
  `module_id` int(11) DEFAULT NULL,
  `measured_value` float DEFAULT NULL,
  `operating_time` int(11) DEFAULT NULL,
  `no_of_items_sent` int(11) DEFAULT NULL,
  `status` enum('active','faulty','inactive') DEFAULT NULL,
  `history_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `measurement_unit` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `iot_modules_history`
--

INSERT INTO `iot_modules_history` (`id`, `module_id`, `measured_value`, `operating_time`, `no_of_items_sent`, `status`, `history_date`, `measurement_unit`) VALUES
(1, 2, 32, 5, 0, 'active', '2024-11-12 07:46:02', '°C'),
(3, 3, 52, 5, 0, 'active', '2024-11-12 07:47:27', 'km/h'),
(6, NULL, 39, NULL, 274, 'active', '2024-11-12 07:55:20', '°C'),
(7, NULL, 87, NULL, 581, 'active', '2024-11-12 07:55:50', 'km/h'),
(8, 3, 49, NULL, 198, 'faulty', '2024-11-12 07:57:27', 'km/h'),
(9, 2, 92, NULL, 754, 'active', '2024-11-12 07:57:30', 'km/h'),
(10, 2, 43, NULL, 240, 'faulty', '2024-11-12 07:57:34', '°C'),
(11, 2, 50, NULL, 296, 'active', '2024-11-12 07:57:49', 'km/h'),
(12, NULL, 47, NULL, 782, 'active', '2024-11-12 07:59:00', '°C'),
(13, 3, 58, NULL, 628, 'active', '2024-11-12 08:01:33', '°C'),
(14, 4, 25, 5, 0, 'active', '2024-11-12 10:02:58', '°C');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `iot_modules`
--
ALTER TABLE `iot_modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `iot_modules_history`
--
ALTER TABLE `iot_modules_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `module_id` (`module_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `iot_modules`
--
ALTER TABLE `iot_modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `iot_modules_history`
--
ALTER TABLE `iot_modules_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `iot_modules_history`
--
ALTER TABLE `iot_modules_history`
  ADD CONSTRAINT `iot_modules_history_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `iot_modules` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
