-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 19, 2023 at 06:40 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bank_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `branch_id` int(4) NOT NULL,
  `branch_name` varchar(30) NOT NULL,
  `branch_code` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`branch_id`, `branch_name`, `branch_code`) VALUES
(1, ' ALIPORE', '000001'),
(2, 'BAGHAJATIN ', '000002'),
(3, 'BALLYGUNGE', '000003'),
(4, 'BARASAT', '000004'),
(5, 'CHOWRINGHEE', '000005'),
(6, 'JADAVPUR', '000006'),
(7, 'GARIA', '000007'),
(8, 'AMTALA', '000008'),
(9, 'CANNING', '000009'),
(10, 'DIAMOND HARBOUR', '000010'),
(11, 'RAJPUR', '000011'),
(12, 'BARUIPUR', '000012'),
(13, 'RAJARHAT', '000013'),
(14, 'BIDHANNAGAR', '000014'),
(15, 'SALT LAKE', '000015');

-- --------------------------------------------------------

--
-- Table structure for table `clientaccounts`
--

CREATE TABLE `clientaccounts` (
  `id` int(4) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `dob` date NOT NULL,
  `balance` double NOT NULL,
  `aadhaar_no` bigint(50) NOT NULL,
  `contact_no` bigint(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `district` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `pincode` int(50) NOT NULL,
  `address` varchar(255) NOT NULL,
  `source` varchar(50) NOT NULL,
  `account_no` bigint(50) NOT NULL,
  `account_type` varchar(50) NOT NULL,
  `branch_id` int(50) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clientaccounts`
--

INSERT INTO `clientaccounts` (`id`, `email`, `password`, `first_name`, `last_name`, `gender`, `dob`, `balance`, `aadhaar_no`, `contact_no`, `state`, `district`, `city`, `pincode`, `address`, `source`, `account_no`, `account_type`, `branch_id`, `date`) VALUES
(2, 'sayantan@gmail.com', '$2y$10$6b1Ex0anzH9bbTWyAlNuXuD7tJH1s9sBCwiKDbAmbzlWjYgTyKCzO', 'SAYANTAN', 'DAS', 'MALE', '1980-10-20', 10201, 789432164562, 9874563214, 'WEST BENGAL', 'SOUTH 24 PARGANAS', 'JADAVPUR', 700144, 'MOHON CHANDRA ROAD', 'NIL', 456177852, 'CURRENT', 6, '2000-07-21 17:25:45'),
(3, 'supratim@gmail.com', '$2y$10$F5mvJRQl0b6Eh7LYHOHs7.SwinCDG5HfLJGvenQiATn8OvcbdCgPS', 'SUPRATIM', 'HALDAR', 'MALE', '1998-05-15', 11837, 623343454787, 9874563214, 'WEST BENGAL', 'SOUTH 24 PARGANAS', 'BARUIPUR', 700144, 'SONALI SONGO', 'NIL', 324025345, 'CURRENT', 1, '2019-12-26 13:44:21'),
(31, 'suman@gmail.com', '$2y$10$M47csi1h2sRO8YsiinRCJepaJsNDWB.AdPywXZL1SHSZPj75qb88m', 'SUMAN', 'DEBNATH', 'MALE', '1999-07-07', 47486.6, 323456789012, 9874563214, 'WEST BENGAL', 'SOUTH 24 PARGANAS', 'BARUIPUR', 700144, 'MADARAT ROAD, BARUIPUR, KOLKATA 700144', 'NIL', 695510391, 'SAVINGS', 12, '2010-05-12 10:16:34'),
(33, 'dummy@dummy', '$2y$10$/8KaXk9htRDrZ.mo72ROnO9yzMVHZJc2NHXwezkedbXsQvQ/7XykC', 'DUMMY', 'DUMMY', 'DUMMY', '2021-03-15', 500, 789456, 789456, 'GUJARAT', 'DUMMY', 'DUMMY', 700144, 'DUMMY', 'DUMMY', 695510392, 'CURRENT', 12, '2022-12-05 17:20:54');

-- --------------------------------------------------------

--
-- Table structure for table `employeeaccounts`
--

CREATE TABLE `employeeaccounts` (
  `id` int(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `contact_no` bigint(50) NOT NULL,
  `aadhaar_no` bigint(50) NOT NULL,
  `dob` date NOT NULL,
  `address` varchar(255) NOT NULL,
  `emp_id` bigint(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `district` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employeeaccounts`
--

INSERT INTO `employeeaccounts` (`id`, `first_name`, `last_name`, `email`, `password`, `contact_no`, `aadhaar_no`, `dob`, `address`, `emp_id`, `city`, `district`, `state`, `date`) VALUES
(1, 'SONYA', 'MEHETA', 'sonya@gmail.com', '$2y$10$ztLwKxx18uDQQiPPhLf4COCbN2PcDxZFweAVZeAHR0rXsy3x8yw5S', 789456123, 12365478963, '1989-07-21', 'MADARAT ROAD', 789021, 'BARUIPUR', 'SOUTH 24 PARGANAS', 'WEST BENGAL', '2018-11-09 11:44:16'),
(2, 'RAHUL', 'ROY', 'rahul@gmail.com', '$2y$10$xDvq9NJbqVfrbnH2bMW14uFiZbF/ZwGqhpTskvZ5OwniuYn2Vl98m', 789456247, 963852147789, '1995-06-30', 'MOHON ROAD', 910821, 'CANNING', 'SOUTH 24 PARGANAS', 'HIMACHAL PRADESH', '2011-03-16 13:19:11');

-- --------------------------------------------------------

--
-- Table structure for table `managerlogin`
--

CREATE TABLE `managerlogin` (
  `id` int(4) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `managerlogin`
--

INSERT INTO `managerlogin` (`id`, `first_name`, `last_name`, `email`, `password`) VALUES
(1, 'RAVI', 'SHARMA', 'ravi@gmail.com', '$2y$10$PxwaGqCHE29uxBygYO1Bk.mt8.yZx9iNLv0sdUt/YPdkm/WygWt.O');

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

CREATE TABLE `state` (
  `state_id` int(50) NOT NULL,
  `state_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `state`
--

INSERT INTO `state` (`state_id`, `state_name`) VALUES
(1, 'ANDHRA PARDESH'),
(2, 'ARUNACHAL PRADESH'),
(3, 'ASSAM'),
(4, 'BIHAR'),
(5, 'CHHATTISGARH'),
(6, 'GOA'),
(7, 'GUJARAT'),
(8, 'HARYANA'),
(9, 'HIMACHAL PRADESH'),
(10, 'JHARKHAND'),
(11, 'KARNATAKA'),
(12, 'KERELA'),
(13, 'MADHYA PRADESH'),
(14, 'MAHARASHTRA'),
(15, 'MANIPUR'),
(16, 'MEGHALAYA'),
(17, 'MIZORAM'),
(18, 'NAGALAND'),
(19, 'ODISHA'),
(20, 'PUNJAB'),
(21, 'RAJASTHAN'),
(22, 'SIKKIM'),
(23, 'TAMIL NADU'),
(24, 'TELENGANA'),
(25, 'TRIPURA'),
(26, 'UTTARAKHAND'),
(27, 'UTTAR PRADESH'),
(28, 'WEST BENGAL');

-- --------------------------------------------------------

--
-- Table structure for table `transclient`
--

CREATE TABLE `transclient` (
  `trans_id` int(50) NOT NULL,
  `action` varchar(50) NOT NULL,
  `from_name` varchar(255) NOT NULL,
  `from_ifsc` varchar(11) NOT NULL,
  `to_name` varchar(255) NOT NULL,
  `to_ifsc` varchar(11) NOT NULL,
  `from_account` bigint(50) NOT NULL,
  `to_account` bigint(50) NOT NULL,
  `trans_amount` bigint(50) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transclient`
--

INSERT INTO `transclient` (`trans_id`, `action`, `from_name`, `from_ifsc`, `to_name`, `to_ifsc`, `from_account`, `to_account`, `trans_amount`, `date`) VALUES
(36, 'transfer', 'SUPRATIM HALDAR', 'RTHB0000001', 'SUMAN DEBNATH', 'RTHB0000012', 324025345, 695510391, 120, '2021-07-21 16:41:56'),
(37, 'transfer', 'SUMAN DEBNATH', 'RTHB0000012', 'SUMAN DEBNATH', 'RTHB0000012', 695510391, 695510391, 200, '2021-07-21 16:41:59'),
(38, 'transfer', 'SUMAN DEBNATH', 'RTHB0000012', 'SUPRATIM HALDAR', 'RTHB0000001', 695510391, 324025345, 1000, '2021-07-21 16:41:40'),
(39, 'transfer', 'SUPRATIM HALDAR', 'RTHB0000001', 'SUMAN DEBNATH', 'RTHB0000012', 324025345, 695510391, 999, '2021-07-21 16:42:01'),
(40, 'deposit', '', '', '', '', 0, 324025345, 100, '2021-07-21 16:40:03'),
(41, 'withdraw', '', '', '', '', 32425345, 0, 1, '2021-07-09 10:28:11'),
(42, 'deposit', '', '', '', '', 0, 456177852, 10, '2021-07-09 11:51:56'),
(43, 'deposit', '', '', '', '', 0, 456177852, 10, '2021-07-09 11:53:35'),
(44, 'deposit', '', '', '', '', 0, 456177852, 100, '2021-07-09 11:53:50'),
(45, 'withdraw', '', '', '', '', 456177852, 0, 1000, '2021-07-09 11:55:20'),
(46, 'transfer', 'SAYANTAN DAS', 'RTHB0000006', 'SUMAN DEBNATH', 'RTHB0000012', 456177852, 695510391, 100000, '2021-07-21 16:42:07'),
(48, 'withdraw', '', '', '', '', 456177852, 0, 10, '2021-07-09 12:00:06'),
(49, 'withdraw', '', '', '', '', 32425345, 0, 10, '2021-07-09 12:00:53'),
(50, 'transfer', 'SAYANTAN DAS', 'RTHB0000006', 'SUPRATIM HALDAR', 'RTHB0000001', 456177852, 324025345, 9999, '2021-07-21 16:40:37'),
(51, 'withdraw', '', '', '', '', 32425345, 0, 10, '2021-07-09 16:41:27'),
(52, 'transfer', 'SUMAN DEBNATH', 'RTHB0000012', 'SUPRATIM HALDAR', 'RTHB0000001', 695510391, 324025345, 10, '2021-07-21 16:41:32'),
(53, 'transfer', 'SUMAN DEBNATH', 'RTHB0000012', 'SUPRATIM HALDAR', 'RTHB0000001', 695510391, 324025345, 1, '2021-07-21 16:41:14'),
(54, 'deposit', '', '', '', '', 0, 695510391, 1200, '2021-07-21 16:41:53'),
(55, 'withdraw', '', '', '', '', 69551391, 0, 110, '2021-07-19 10:17:25'),
(56, 'transfer', 'SUPRATIM HALDAR', 'RTHB0000001', 'SAYANTAN DAS', 'RTHB0000006', 324025345, 456177852, 12, '2021-07-21 16:40:16'),
(57, 'transfer', 'SUMAN DEBNATH', 'RTHB0000012', 'SAYANTAN DAS', 'RTHB0000006', 695510391, 456177852, 12, '2021-07-21 16:41:20'),
(58, 'transfer', 'SUMAN DEBNATH', 'RTHB0000012', 'SAYANTAN DAS', 'RTHB0000006', 695510391, 456177852, 12, '2021-07-21 16:41:22'),
(59, 'transfer', 'SUMAN DEBNATH', 'RTHB0000012', 'SAYANTAN DAS', 'RTHB0000006', 695510391, 456177852, 12, '2021-07-21 16:41:25'),
(60, 'transfer', 'SUMAN DEBNATH', 'RTHB0000012', 'SAYANTAN DAS', 'RTHB0000006', 695510391, 456177852, 12, '2021-07-21 16:41:27'),
(61, 'transfer', 'SUMAN DEBNATH', 'RTHB0000012', 'SAYANTAN DAS', 'RTHB0000006', 695510391, 456177852, 12, '2021-07-21 16:41:29'),
(62, 'transfer', 'SUMAN DEBNATH', 'RTHB0000012', 'SUPRATIM HALDAR', 'RTHB0000001', 695510391, 324025345, 100, '2021-07-21 16:41:34'),
(63, 'transfer', 'SAYANTAN DAS', 'RTHB0000006', 'SUMAN DEBNATH', 'RTHB0000012', 456177852, 695510391, 100, '2021-07-21 16:42:03'),
(64, 'transfer', 'SUMAN DEBNATH', 'RTHB0000012', 'SAYANTAN DAS', 'RTHB0000006', 695510391, 456177852, 1000, '2021-07-21 16:41:45'),
(65, 'transfer', 'SUMAN DEBNATH', 'RTHB0000012', 'SUPRATIM HALDAR', 'RTHB0000001', 695510391, 324025345, 150, '2021-07-21 16:41:17'),
(66, 'transfer', 'SUPRATIM HALDAR', 'RTHB0000001', 'SUMAN DEBNATH', 'RTHB0000012', 324025345, 695510391, 150, '2021-07-21 16:42:09'),
(67, 'transfer', 'SUMAN DEBNATH', 'RTHB0000012', 'SAYANTAN DAS', 'RTHB0000006', 695510391, 456177852, 34, '2021-07-21 16:41:48'),
(68, 'transfer', 'SUMAN DEBNATH', 'RTHB0000012', 'SUPRATIM HALDAR', 'RTHB0000001', 695510391, 324025345, 500, '2021-07-22 07:40:22'),
(69, 'deposit', '', '', '', '', 0, 456177852, 1000, '2021-07-22 15:52:48'),
(70, 'withdraw', '', '', '', '', 324025345, 0, 1500, '2021-07-22 15:53:56'),
(73, 'transfer', 'SAYANTAN DAS', 'RTHB0000006', 'DELETED ACCOUNT', 'PUNB0692900', 456177852, 695510392, 100, '2021-07-22 16:38:18'),
(74, 'transfer', 'DELETED ACCOUNT', 'PUNB0692900', 'SAYANTAN DAS', 'RTHB0000006', 695510392, 456177852, 50, '2021-07-22 16:38:34'),
(75, 'transfer', 'SUMAN DEBNATH', 'RTHB0000012', 'DELETED ACCOUNT', 'PUNB0692900', 695510391, 695510392, 230, '2021-07-23 19:07:19'),
(76, 'transfer', 'SUMAN DEBNATH', 'RTHB0000012', 'DELETED ACCOUNT', 'PUNB0692900', 695510391, 695510392, 50, '2021-07-23 19:08:38'),
(77, 'transfer', 'SUMAN DEBNATH', 'RTHB0000012', 'DELETED ACCOUNT', 'PUNB0692900', 695510391, 695510392, 20, '2021-07-23 19:08:53'),
(78, 'transfer', 'DELETED ACCOUNT', 'PUNB0692900', 'SUMAN DEBNATH', 'RTHB0000012', 695510392, 695510391, 67, '2021-07-23 19:10:13'),
(79, 'transfer', 'SAYANTAN DAS', 'RTHB0000006', 'SUPRATIM HALDAR', 'RTHB0000001', 456177852, 324025345, 1816, '2021-07-24 11:17:35'),
(80, 'transfer', 'SUMAN DEBNATH', 'RTHB0000012', 'SAYANTAN DAS', 'RTHB0000006', 695510391, 456177852, 120, '2021-07-28 08:48:39'),
(81, 'deposit', '', '', 'DELETED ACCOUNT', '', 0, 695510392, 100, '2021-07-28 09:14:18'),
(82, 'withdraw', '', '', '', '', 695510392, 0, 200, '2021-07-28 09:17:16'),
(83, 'transfer', 'SUMAN DEBNATH', 'RTHB0000012', 'MEHETAB MONDAL', 'SBIN0132288', 695510391, 456174352, 100, '2021-08-02 13:32:59'),
(84, 'transfer', 'SUMAN DEBNATH', 'RTHB0000012', 'MEHETAB MONDAL', 'SBIN0132288', 695510391, 456174352, 156, '2021-08-02 13:55:59'),
(85, 'transfer', 'SUMAN DEBNATH', 'RTHB0000012', 'MEHETAB MONDAL ', 'SBIN0132288', 695510391, 456174352, 78, '2021-08-14 06:48:43'),
(86, 'transfer', 'SUMAN DEBNATH', 'RTHB0000012', 'SAYANTAN DAS', 'RTHB0000006', 695510391, 456177852, 458, '2021-08-14 07:18:52'),
(87, 'transfer', 'SUMAN DEBNATH', 'RTHB0000012', 'SUPRATIM HALDAR', 'RTHB0000001', 695510391, 324025345, 234, '2021-08-14 08:32:36'),
(112, 'deposit', '', '', 'SAYANTAN DAS', 'RTHB0000006', 0, 456177852, 100, '2021-08-14 13:55:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`branch_id`);

--
-- Indexes for table `clientaccounts`
--
ALTER TABLE `clientaccounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employeeaccounts`
--
ALTER TABLE `employeeaccounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `managerlogin`
--
ALTER TABLE `managerlogin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `state`
--
ALTER TABLE `state`
  ADD PRIMARY KEY (`state_id`);

--
-- Indexes for table `transclient`
--
ALTER TABLE `transclient`
  ADD PRIMARY KEY (`trans_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clientaccounts`
--
ALTER TABLE `clientaccounts`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `employeeaccounts`
--
ALTER TABLE `employeeaccounts`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transclient`
--
ALTER TABLE `transclient`
  MODIFY `trans_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
