-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 06, 2026 at 12:54 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_1`
--

-- --------------------------------------------------------

--
-- Table structure for table `call_logs`
--

CREATE TABLE `call_logs` (
  `call_id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL COMMENT '1 = connected; 0 = not connected',
  `tag_id` int(11) DEFAULT NULL,
  `follow_up_date` date DEFAULT NULL,
  `is_follow_up` tinyint(4) DEFAULT NULL,
  `remark` text DEFAULT NULL,
  `call_datetime` datetime DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `is_delete` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `call_logs`
--

INSERT INTO `call_logs` (`call_id`, `client_id`, `status`, `tag_id`, `follow_up_date`, `is_follow_up`, `remark`, `call_datetime`, `created_by`, `is_delete`) VALUES
(1, 1, 1, 6, NULL, NULL, '11', '2026-07-06 04:22:21', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `client_id` int(11) NOT NULL,
  `client_name` text NOT NULL,
  `client_comp_name` text DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `mob` varchar(13) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `expected_revenue` decimal(11,2) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `register_date` datetime DEFAULT current_timestamp(),
  `register_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `is_delete` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`client_id`, `client_name`, `client_comp_name`, `company_id`, `mob`, `email`, `dob`, `expected_revenue`, `address`, `register_date`, `register_by`, `updated_date`, `updated_by`, `is_active`, `is_delete`) VALUES
(1, 'Atharv', NULL, 2, '8446932227', 'atharvthakur910@gmail.com', '2026-07-02', 97800.00, 'afsc', '2026-07-03 21:30:59', 1, NULL, NULL, 1, 0),
(2, 'Raj', NULL, 1, '8446932227', 'atharvthakur910@gmail.com', '2026-07-04', 22222.00, 'szfsfsaf', '2026-07-03 21:33:08', 1, NULL, NULL, 1, 1),
(3, 'Vaibhav', NULL, 1, '9699726506', 'v@gmail.com', '2009-09-19', 6700.00, 'ranjankhar,alibag,', '2026-07-05 11:05:03', 1, NULL, NULL, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `company_id` int(11) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL COMMENT '1 = Active; 0 = Inactive',
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `is_delete` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`company_id`, `company_name`, `status`, `created_by`, `created_at`, `is_delete`) VALUES
(1, 'Mutual Fund', 1, 1, '2026-07-01 22:42:47', 0),
(2, 'Bajaj Finance', 1, 1, '2026-07-01 22:44:57', 0),
(3, 'Test', 1, 1, '2026-07-02 21:48:17', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `tag_id` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT NULL COMMENT '1 = connected, 0 = not connected',
  `tag_name` varchar(255) DEFAULT NULL,
  `is_delete` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`tag_id`, `status`, `tag_name`, `is_delete`) VALUES
(1, 0, 'Busy', 0),
(2, 0, 'No Answer', 0),
(3, 0, 'Switched Off', 0),
(4, 0, 'Call Rejected', 0),
(5, 0, 'Wrong Number', 0),
(6, 1, 'Interested', 0),
(7, 1, 'Follow-up', 0),
(8, 1, 'Meeting Scheduled', 0),
(9, 1, 'Not Interested', 0),
(10, 1, 'Callback', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `password` text DEFAULT NULL,
  `decrypt_password` varchar(255) DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(10) DEFAULT NULL,
  `remember_token` text DEFAULT NULL,
  `is_delete` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `user_name`, `password`, `decrypt_password`, `is_active`, `email`, `phone`, `remember_token`, `is_delete`) VALUES
(1, 'Atharv', 'admin', '$2y$12$peT5rtG.HMCJftqo4UL.New9zk5btGEE6TODFwb23Qp9aE2A0gY3.', 'asdf', 1, 'atharvthakur910@gmail.com', '1234567890', 'BvF1cEx4FRLH19J0iSETZOEaP4gG2wH2bdh3FUvwxlt5aAqFXUdTv4PBAT6j', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `call_logs`
--
ALTER TABLE `call_logs`
  ADD PRIMARY KEY (`call_id`),
  ADD KEY `client_id` (`client_id`,`tag_id`,`created_by`),
  ADD KEY `tag_id` (`tag_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`client_id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `companies_relation` (`company_id`),
  ADD KEY `register_by` (`register_by`,`updated_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`company_id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`tag_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `call_logs`
--
ALTER TABLE `call_logs`
  MODIFY `call_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `call_logs`
--
ALTER TABLE `call_logs`
  ADD CONSTRAINT `call_logs_ibfk_1` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`tag_id`),
  ADD CONSTRAINT `call_logs_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `clients` (`client_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `call_logs_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_ibfk_1` FOREIGN KEY (`register_by`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `clients_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `companies_relation` FOREIGN KEY (`company_id`) REFERENCES `companies` (`company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `companies`
--
ALTER TABLE `companies`
  ADD CONSTRAINT `companies_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
