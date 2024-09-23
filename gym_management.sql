-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 23, 2024 at 04:29 PM
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
-- Database: `gym_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `duration` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `class_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `name`, `description`, `duration`, `price`, `class_name`) VALUES
(1, 'Yoga', 'Relaxing and stretching exercises', 4, 2000.00, 'Yoga'),
(2, 'Zumba', 'Dance fitness class', 4, 2500.00, 'Zumba'),
(3, 'Weight Training', 'Strength training with weights', 6, 3000.00, 'Weight Training'),
(4, 'Pilates', 'Core strengthening and flexibility', 4, 2200.00, 'Pilates'),
(5, 'HIIT', 'High-intensity interval training', 4, 2800.00, 'HIIT'),
(6, 'Cardio', 'Aerobic exercises for heart health', 4, 1500.00, 'Cardio'),
(7, 'Sauna', 'A room to experience dry or wet heat sessions.', 0, 1000.00, 'Sauna');

-- --------------------------------------------------------

--
-- Table structure for table `memberships`
--

CREATE TABLE `memberships` (
  `id` int(11) NOT NULL,
  `type` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `duration` varchar(20) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `membership_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `memberships`
--

INSERT INTO `memberships` (`id`, `type`, `description`, `duration`, `price`, `membership_date`) VALUES
(1, 'Basic', 'Access to gym facilities only', '1 Month', 1500.00, NULL),
(2, 'Standard', 'Access to gym facilities and classes', '1 Month', 2500.00, NULL),
(3, 'Premium', 'Access to all facilities, classes, and personal trainer', '1 Month', 5000.00, NULL),
(4, 'Annual', 'Yearly membership with discounts', '12 Months', 25000.00, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `user_id`, `amount`, `date`) VALUES
(1, 3, 66500.00, '2024-09-23 12:05:27'),
(2, 1, 6000.00, '2024-09-23 13:49:01'),
(3, 1, 6000.00, '2024-09-23 13:58:17'),
(4, 1, 6000.00, '2024-09-23 13:59:14'),
(5, 1, 6000.00, '2024-09-23 14:01:20'),
(6, 1, 6000.00, '2024-09-23 14:05:53'),
(7, 1, 6000.00, '2024-09-23 14:15:34'),
(8, 1, 6000.00, '2024-09-23 14:15:39'),
(9, 1, 26000.00, '2024-09-23 14:15:54'),
(10, 1, 26000.00, '2024-09-23 14:15:57'),
(11, 1, 0.00, '2024-09-23 14:16:26'),
(12, 1, 0.00, '2024-09-23 14:25:42');

-- --------------------------------------------------------

--
-- Table structure for table `time_tracking`
--

CREATE TABLE `time_tracking` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `time_in` datetime NOT NULL,
  `time_out` datetime DEFAULT NULL,
  `duration` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `time_tracking`
--

INSERT INTO `time_tracking` (`id`, `user_id`, `time_in`, `time_out`, `duration`) VALUES
(1, 3, '2024-09-23 12:32:45', '2024-09-23 13:13:18', 0),
(2, 3, '2024-09-23 12:32:47', '2024-09-23 13:15:02', 0),
(3, 3, '2024-09-23 12:32:48', '2024-09-23 13:16:54', 0),
(4, 3, '2024-09-23 12:32:48', '2024-09-23 13:18:09', 0),
(5, 3, '2024-09-23 12:32:48', '2024-09-23 13:19:01', 0),
(6, 3, '2024-09-23 12:32:49', '2024-09-23 14:01:49', 73),
(7, 3, '2024-09-23 12:32:49', '2024-09-23 15:49:35', 90),
(8, 3, '2024-09-23 12:32:49', '2024-09-23 15:56:23', 90),
(9, 3, '2024-09-23 12:32:50', NULL, 0),
(10, 3, '2024-09-23 12:32:52', '2024-09-23 12:32:52', 0),
(11, 3, '2024-09-23 12:32:53', NULL, 0),
(12, 3, '2024-09-23 12:32:54', NULL, 0),
(13, 3, '2024-09-23 12:32:55', NULL, 0),
(14, 3, '2024-09-23 12:37:59', NULL, 0),
(15, 3, '2024-09-23 12:38:06', NULL, 0),
(16, 3, '2024-09-23 12:38:08', '2024-09-23 12:38:10', 0),
(17, 3, '2024-09-23 13:18:09', NULL, 0),
(18, 3, '2024-09-23 13:19:01', NULL, 0),
(19, 3, '2024-09-23 13:20:36', NULL, 0),
(20, 1, '2024-09-23 13:21:01', '2024-09-23 14:11:03', 40),
(21, 1, '2024-09-23 13:22:39', '2024-09-23 15:49:10', 90),
(22, 1, '2024-09-23 13:25:25', '2024-09-23 15:49:19', 90),
(23, 2, '2024-09-23 13:25:27', '2024-09-23 15:49:28', 90),
(24, 1, '2024-09-23 13:25:29', '2024-09-23 13:50:19', 0),
(25, 3, '2024-09-23 13:25:31', NULL, 0),
(26, 1, '2024-09-23 13:46:26', '2024-09-23 13:46:28', 0),
(27, 2, '2024-09-23 13:46:33', NULL, 0),
(28, 3, '2024-09-23 13:46:37', NULL, 0),
(29, 1, '2024-09-23 14:01:08', '2024-09-23 14:01:13', 0),
(30, 3, '2024-09-23 14:01:49', NULL, 0),
(31, 1, '2024-09-23 14:11:03', '2024-09-23 14:30:05', 0),
(32, 1, '2024-09-23 14:28:48', '2024-09-23 14:28:52', 0),
(33, 1, '2024-09-23 15:49:10', NULL, 21),
(34, 1, '2024-09-23 15:49:19', NULL, 0),
(35, 2, '2024-09-23 15:49:28', NULL, 0),
(36, 3, '2024-09-23 15:49:35', NULL, 0),
(37, 1, '2024-09-23 15:49:46', NULL, 0),
(38, 3, '2024-09-23 15:56:23', NULL, 0),
(39, 1, '2024-09-23 16:10:57', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', '$2y$10$BAQge0r7inLOV2k200PGtONu.M6y01RzTH3bfg7znVZ.BL9vvMOv2', 'admin'),
(2, 'testuser', 'admin123', 'admin'),
(3, 'testuser1', '$2y$10$RK11ELyhDLB4juqXlVGUi.W6GUERmR1KbS5Api1EcD8cKt4JDnRAe', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `user_classes`
--

CREATE TABLE `user_classes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_classes`
--

INSERT INTO `user_classes` (`id`, `user_id`, `class_id`) VALUES
(1, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_memberships`
--

CREATE TABLE `user_memberships` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `membership_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_memberships`
--

INSERT INTO `user_memberships` (`id`, `user_id`, `membership_id`) VALUES
(1, 3, 1),
(2, 3, 4),
(5, 3, 3),
(6, 3, 4),
(7, 3, 1),
(8, 3, 2),
(9, 3, 1),
(10, 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_times`
--

CREATE TABLE `user_times` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `time_in` datetime DEFAULT NULL,
  `time_out` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `memberships`
--
ALTER TABLE `memberships`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `time_tracking`
--
ALTER TABLE `time_tracking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `user_classes`
--
ALTER TABLE `user_classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `user_memberships`
--
ALTER TABLE `user_memberships`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `membership_id` (`membership_id`);

--
-- Indexes for table `user_times`
--
ALTER TABLE `user_times`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `memberships`
--
ALTER TABLE `memberships`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `time_tracking`
--
ALTER TABLE `time_tracking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_classes`
--
ALTER TABLE `user_classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `user_memberships`
--
ALTER TABLE `user_memberships`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `user_times`
--
ALTER TABLE `user_times`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `time_tracking`
--
ALTER TABLE `time_tracking`
  ADD CONSTRAINT `time_tracking_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_classes`
--
ALTER TABLE `user_classes`
  ADD CONSTRAINT `user_classes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_classes_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`);

--
-- Constraints for table `user_memberships`
--
ALTER TABLE `user_memberships`
  ADD CONSTRAINT `user_memberships_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_memberships_ibfk_2` FOREIGN KEY (`membership_id`) REFERENCES `memberships` (`id`);

--
-- Constraints for table `user_times`
--
ALTER TABLE `user_times`
  ADD CONSTRAINT `user_times_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
