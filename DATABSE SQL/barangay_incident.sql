-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 15, 2024 at 11:07 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `barangay_incident`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_account`
--

CREATE TABLE `admin_account` (
  `id` int(11) NOT NULL,
  `uniqueID` varchar(200) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `complete_address` varchar(300) NOT NULL,
  `phone_number` varchar(13) NOT NULL,
  `admin_email` varchar(200) NOT NULL,
  `admin_password` varchar(200) NOT NULL,
  `admin_profile_picture` varchar(500) NOT NULL,
  `verification_code` int(8) NOT NULL,
  `verify_status` varchar(80) NOT NULL DEFAULT 'Not Verified',
  `longitude` varchar(100) NOT NULL,
  `latitude` varchar(100) NOT NULL,
  `online_offlineStatus` varchar(50) NOT NULL DEFAULT 'Offline'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_account`
--

INSERT INTO `admin_account` (`id`, `uniqueID`, `first_name`, `middle_name`, `last_name`, `complete_address`, `phone_number`, `admin_email`, `admin_password`, `admin_profile_picture`, `verification_code`, `verify_status`, `longitude`, `latitude`, `online_offlineStatus`) VALUES
(1, '65521c30c732e6795', 'Ramon', 'G', 'Gwapo', 'new york', '09652314574', 'romanoespiritu146@gmail.com', '202cb962ac59075b964b07152d234b70', '../imageFiles/65521c30c7331-thumb-152589.jpg', 486638, 'Verified', '121.9317159', '16.994171', 'Online');

-- --------------------------------------------------------

--
-- Table structure for table `admin_systemnotification`
--

CREATE TABLE `admin_systemnotification` (
  `id` int(11) NOT NULL,
  `admin_id` int(12) NOT NULL,
  `logs` varchar(200) NOT NULL,
  `logs_date` varchar(50) NOT NULL,
  `logs_time` varchar(50) NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'Unread'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `calamities`
--

CREATE TABLE `calamities` (
  `id` int(11) NOT NULL,
  `calamity_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `calamities`
--

INSERT INTO `calamities` (`id`, `calamity_name`) VALUES
(1, 'Fire'),
(2, 'Earthquake'),
(3, 'Flood'),
(4, 'Health Emergencies'),
(5, 'Traffic Accidents'),
(6, 'Criminal Activities'),
(7, 'Environmental Incidents');

-- --------------------------------------------------------

--
-- Table structure for table `chat_system`
--

CREATE TABLE `chat_system` (
  `id` int(11) NOT NULL,
  `sender_id` varchar(200) NOT NULL,
  `receiver_id` varchar(200) NOT NULL,
  `messages` text NOT NULL,
  `date_only` varchar(100) NOT NULL,
  `time_only` varchar(100) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Sent'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `incident_reports`
--

CREATE TABLE `incident_reports` (
  `id` int(11) NOT NULL,
  `resident_id` int(12) NOT NULL,
  `dateOFSubmit` varchar(50) NOT NULL,
  `timeOfSubmit` varchar(80) NOT NULL,
  `monthOfSubmit` varchar(100) NOT NULL,
  `calamities_incident` varchar(100) NOT NULL,
  `description` varchar(2000) NOT NULL,
  `incident_picture` varchar(700) NOT NULL,
  `longitude` varchar(800) NOT NULL,
  `latitude` varchar(700) NOT NULL,
  `report_status` varchar(50) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `residents_data`
--

CREATE TABLE `residents_data` (
  `id` int(11) NOT NULL,
  `uniqueID` varchar(200) NOT NULL,
  `first_name` varchar(70) NOT NULL,
  `middle_name` varchar(70) NOT NULL,
  `last_name` varchar(70) NOT NULL,
  `b_day` varchar(50) NOT NULL,
  `age` int(3) NOT NULL,
  `gender` varchar(300) NOT NULL,
  `complete_address` varchar(200) NOT NULL,
  `phone_number` varchar(12) NOT NULL,
  `resident_email` varchar(200) NOT NULL,
  `resident_password` varchar(200) NOT NULL,
  `profile_picture` varchar(200) NOT NULL,
  `verification_code` int(8) NOT NULL,
  `verify_status` varchar(80) NOT NULL DEFAULT 'Not Verified',
  `latitude` varchar(80) NOT NULL,
  `longitude` varchar(80) NOT NULL,
  `online_offlineStatus` varchar(80) NOT NULL DEFAULT 'Offline'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `residents_data`
--

INSERT INTO `residents_data` (`id`, `uniqueID`, `first_name`, `middle_name`, `last_name`, `b_day`, `age`, `gender`, `complete_address`, `phone_number`, `resident_email`, `resident_password`, `profile_picture`, `verification_code`, `verify_status`, `latitude`, `longitude`, `online_offlineStatus`) VALUES
(1, '65521cd2ddf356266', 'Naruto', 'Hokage', 'Uzumaki', '2001-05-13', 22, 'male', 'new york', '09652314574', 'ramonespiritu85@gmail.com', '202cb962ac59075b964b07152d234b70', '../imageFiles/65521cd2ddf38-images.jpeg', 817235, 'Verified', '16.9942031', '121.9317094', 'Offline'),
(2, '659e3d7817ab74893', 'Naruto', 'Uzumaki', 'Hokage', '2001-01-10', 23, 'male', 'dsajiduaisduaisdui', '09653216512', 'romanoespiritu146@gmail.com', '202cb962ac59075b964b07152d234b70', '../imageFiles/659e3d7817abe-Picture1.png', 445251, 'Verified', '16.994232', '121.9317026', 'Online');

-- --------------------------------------------------------

--
-- Table structure for table `system_notification`
--

CREATE TABLE `system_notification` (
  `id` int(11) NOT NULL,
  `resident_id` int(12) NOT NULL,
  `logs` varchar(200) NOT NULL,
  `logs_date` varchar(50) NOT NULL,
  `logs_time` varchar(50) NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'Unread'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_account`
--
ALTER TABLE `admin_account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_systemnotification`
--
ALTER TABLE `admin_systemnotification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `calamities`
--
ALTER TABLE `calamities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chat_system`
--
ALTER TABLE `chat_system`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `incident_reports`
--
ALTER TABLE `incident_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `residents_data`
--
ALTER TABLE `residents_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_notification`
--
ALTER TABLE `system_notification`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_account`
--
ALTER TABLE `admin_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_systemnotification`
--
ALTER TABLE `admin_systemnotification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `calamities`
--
ALTER TABLE `calamities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `chat_system`
--
ALTER TABLE `chat_system`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `incident_reports`
--
ALTER TABLE `incident_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `residents_data`
--
ALTER TABLE `residents_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `system_notification`
--
ALTER TABLE `system_notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
