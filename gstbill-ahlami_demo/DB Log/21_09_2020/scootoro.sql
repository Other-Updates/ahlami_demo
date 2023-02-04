-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 21, 2020 at 06:46 AM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `scootoro`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `user_data` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('2f5bed647f847cc53f11b1d2e788f303', '::1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.102 Safari/537.36', 1600663209, 'a:2:{s:9:\"user_data\";s:0:\"\";s:8:\"scootero\";s:2176:\"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\";}');

-- --------------------------------------------------------

--
-- Table structure for table `scoo_customers`
--

CREATE TABLE `scoo_customers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `mobile_number` varchar(20) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` int(2) NOT NULL DEFAULT '0' COMMENT '1-Male,2-Female',
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(30) DEFAULT NULL,
  `plain_password` varchar(20) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `is_deleted` int(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `scoo_customers`
--

INSERT INTO `scoo_customers` (`id`, `name`, `mobile_number`, `dob`, `gender`, `email`, `password`, `plain_password`, `status`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Kalai', '9789416188', '1995-07-09', 2, 'kalai@gmail.com', '827ccb0eea8a706c4c34a16891f84e', '12345', 1, 0, '2020-09-07 11:09:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `scoo_feedback`
--

CREATE TABLE `scoo_feedback` (
  `id` int(12) NOT NULL,
  `scootoro_id` int(12) NOT NULL DEFAULT '0',
  `trip_id` int(12) NOT NULL DEFAULT '0',
  `feedback` varchar(100) DEFAULT NULL,
  `ratings` varchar(100) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '1-Active,0-InActive',
  `is_deleted` int(1) NOT NULL DEFAULT '0' COMMENT '1-Deleted,0-Not Deleted',
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `scoo_feedback`
--

INSERT INTO `scoo_feedback` (`id`, `scootoro_id`, `trip_id`, `feedback`, `ratings`, `status`, `is_deleted`, `created_date`, `updated_date`) VALUES
(1, 2, 2, 'Good', 'Slow', 1, 0, '2020-09-09 00:00:00', '2020-09-09 01:46:49');

-- --------------------------------------------------------

--
-- Table structure for table `scoo_general_setting`
--

CREATE TABLE `scoo_general_setting` (
  `id` int(11) NOT NULL,
  `contact_mail` varchar(35) NOT NULL,
  `from_mail` varchar(100) DEFAULT NULL,
  `sms_gateway_username` varchar(50) DEFAULT NULL,
  `sms_gateway_password` varchar(50) DEFAULT NULL,
  `payment_gateway_username` varchar(50) DEFAULT NULL,
  `payment_gateway_password` varchar(50) DEFAULT NULL,
  `unlock_charge` varchar(20) DEFAULT NULL,
  `vatt` int(20) DEFAULT NULL,
  `copy_right` varchar(25) NOT NULL,
  `site_address` varchar(150) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `scoo_general_setting`
--

INSERT INTO `scoo_general_setting` (`id`, `contact_mail`, `from_mail`, `sms_gateway_username`, `sms_gateway_password`, `payment_gateway_username`, `payment_gateway_password`, `unlock_charge`, `vatt`, `copy_right`, `site_address`, `updated_date`) VALUES
(22, 'f2ftesting@gmail.com', 'test@gmail.com', 'test', 'test', 'test', 'test', '5', 4, '2019 Events', '', '2020-09-09 06:31:43');

-- --------------------------------------------------------

--
-- Table structure for table `scoo_increment`
--

CREATE TABLE `scoo_increment` (
  `id` int(11) NOT NULL,
  `type` varchar(30) DEFAULT NULL,
  `code` varchar(10) DEFAULT NULL,
  `prefix` varchar(50) DEFAULT NULL,
  `last_increment_id` varchar(10) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `scoo_increment`
--

INSERT INTO `scoo_increment` (`id`, `type`, `code`, `prefix`, `last_increment_id`) VALUES
(1, 'user_code', 'USER', NULL, '9'),
(2, 'member_code', 'MEMBER', NULL, '6'),
(3, 'scootero_serial_number_code', 'SCOO', NULL, '5'),
(4, 'scootero_trip_code', 'TRP', NULL, '3'),
(5, 'scootero_invoice_code', 'INV', NULL, '3');

-- --------------------------------------------------------

--
-- Table structure for table `scoo_payment_details`
--

CREATE TABLE `scoo_payment_details` (
  `id` int(11) NOT NULL,
  `customer_id` int(12) NOT NULL DEFAULT '0',
  `payment_method` int(1) NOT NULL DEFAULT '0' COMMENT '1-Apple,2-Credit,3-Debit,4-Wallet',
  `payment_data` text,
  `pay_amount` varchar(12) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '1-Success,0-Fail',
  `is_deleted` int(1) NOT NULL DEFAULT '0' COMMENT '1-Deleted,0-Not Deleted',
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `scoo_payment_details`
--

INSERT INTO `scoo_payment_details` (`id`, `customer_id`, `payment_method`, `payment_data`, `pay_amount`, `status`, `is_deleted`, `created_date`, `updated_date`) VALUES
(1, 1, 2, 'a:5:{s:4:\"name\";s:5:\"kalai\";s:11:\"card_number\";s:19:\"4242 4242 4242 4242\";s:11:\"expire_year\";s:4:\"2021\";s:12:\"expire_month\";s:2:\"12\";s:3:\"cvv\";s:3:\"123\";}', '100', 1, 0, '2020-09-09 11:44:46', NULL),
(2, 1, 3, 'a:13:{s:4:\"name\";s:5:\"kalai\";s:5:\"email\";s:0:\"\";s:8:\"card_num\";s:19:\"4242 4242 4242 4242\";s:8:\"card_cvc\";N;s:14:\"card_exp_month\";s:2:\"12\";s:13:\"card_exp_year\";s:4:\"2021\";s:6:\"amount\";s:5:\"28.75\";s:19:\"item_price_currency\";s:3:\"SAR\";s:11:\"paid_amount\";s:5:\"28.75\";s:20:\"paid_amount_currency\";s:3:\"SAR\";s:14:\"payment_status\";s:7:\"Success\";s:10:\"created_by\";i:1;s:12:\"created_date\";s:19:\"2020-09-09 13:01:16\";}', '28.75', 1, 0, '2020-09-09 01:01:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `scoo_scootero`
--

CREATE TABLE `scoo_scootero` (
  `id` int(11) NOT NULL,
  `serial_number` varchar(50) DEFAULT NULL,
  `battery_life` int(30) NOT NULL DEFAULT '0',
  `qr_code` text,
  `lock_status` int(1) NOT NULL DEFAULT '0' COMMENT '0-Lock,1-Unlock',
  `status` int(1) NOT NULL DEFAULT '1',
  `is_deleted` int(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `scoo_scootero`
--

INSERT INTO `scoo_scootero` (`id`, `serial_number`, `battery_life`, `qr_code`, `lock_status`, `status`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'SCOO001', 80, '12345', 1, 1, 0, NULL, '2020-09-09 09:55:55'),
(2, 'SCOO002', 70, 'dsfsd3233', 0, 1, 0, NULL, '2020-09-09 01:25:51'),
(3, 'SCOO003', 24, 'xsds42323', 0, 1, 0, NULL, '2020-09-09 09:56:10'),
(4, 'SCOO004', 98, 'vbcvb45435', 0, 1, 0, '2020-09-01 13:55:30', '2020-09-09 09:56:18');

-- --------------------------------------------------------

--
-- Table structure for table `scoo_subscriptions`
--

CREATE TABLE `scoo_subscriptions` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `mins` int(11) DEFAULT '0',
  `amount` varchar(20) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `is_deleted` int(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `scoo_subscriptions`
--

INSERT INTO `scoo_subscriptions` (`id`, `name`, `mins`, `amount`, `status`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Subscriptions 1', 10, '20', 1, 0, '2020-09-01 09:31:29', '2020-09-09 07:45:00'),
(2, 'Subscriptions 2', 20, '40', 1, 0, '2020-09-09 07:45:16', NULL),
(3, 'Subscriptions 3', 30, '50', 1, 0, '2020-09-09 07:45:37', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `scoo_trip`
--

CREATE TABLE `scoo_trip` (
  `id` int(11) NOT NULL,
  `trip_number` varchar(20) DEFAULT NULL,
  `invoice_number` varchar(20) DEFAULT NULL,
  `customer_id` int(12) NOT NULL DEFAULT '0',
  `scooter_id` int(12) NOT NULL DEFAULT '0',
  `subscription_id` int(12) NOT NULL DEFAULT '0',
  `payment_id` int(12) NOT NULL DEFAULT '0',
  `ride_start` datetime DEFAULT NULL,
  `ride_end` datetime DEFAULT NULL,
  `ride_distance` int(12) NOT NULL DEFAULT '0',
  `ride_mins` time DEFAULT NULL,
  `total_ride_amt` int(12) NOT NULL DEFAULT '0',
  `unlock_charge` int(12) NOT NULL DEFAULT '0',
  `sub_total` int(12) NOT NULL DEFAULT '0',
  `vat_charge` int(12) NOT NULL DEFAULT '0',
  `grand_total` int(12) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '1-Active,0-InActive',
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `scoo_trip`
--

INSERT INTO `scoo_trip` (`id`, `trip_number`, `invoice_number`, `customer_id`, `scooter_id`, `subscription_id`, `payment_id`, `ride_start`, `ride_end`, `ride_distance`, `ride_mins`, `total_ride_amt`, `unlock_charge`, `sub_total`, `vat_charge`, `grand_total`, `status`, `created_date`, `updated_date`) VALUES
(1, 'TRP001', 'INV001', 1, 1, 0, 1, '2020-09-09 11:44:46', NULL, 0, '00:00:00', 0, 0, 0, 0, 0, 1, '2020-09-09 11:44:46', NULL),
(2, 'TRP002', 'INV002', 1, 2, 1, 2, '2020-09-09 01:01:16', '2020-09-09 01:25:51', 2, '00:00:10', 20, 5, 25, 4, 29, 1, '2020-09-09 01:01:16', '2020-09-09 01:25:51');

-- --------------------------------------------------------

--
-- Table structure for table `scoo_users`
--

CREATE TABLE `scoo_users` (
  `id` int(11) NOT NULL,
  `user_id` varchar(50) DEFAULT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `dob` date DEFAULT NULL,
  `email_address` varchar(100) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `mobile_number` varchar(20) DEFAULT NULL,
  `address` mediumtext,
  `company_name` varchar(25) NOT NULL,
  `profile_image` varchar(150) DEFAULT NULL,
  `user_location` text,
  `latitude` varchar(150) DEFAULT NULL,
  `longitude` varchar(150) DEFAULT NULL,
  `user_type_id` int(5) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) DEFAULT '0',
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `scoo_users`
--

INSERT INTO `scoo_users` (`id`, `user_id`, `firstname`, `lastname`, `username`, `password`, `dob`, `email_address`, `gender`, `mobile_number`, `address`, `company_name`, `profile_image`, `user_location`, `latitude`, `longitude`, `user_type_id`, `status`, `is_deleted`, `created_date`, `updated_date`) VALUES
(1, 'USER-0001', 'admin', 'event', 'admin', '81dc9bdb52d04dc20036dbd8313ed055', '2011-01-06', 'admin@gmail.com', '', '9888489779', 'cbe', '', 'http://demo.f2fsolutions.co.in/events_v2/attachments/profile_image/PI_016686787.png', '48,<br> Arunachalam St', '11.0283189', '76.94947259999999', 1, 1, 0, '2019-06-18 18:05:51', '2020-09-21 04:40:11'),
(2, 'USER-0002', 'accounts', 'event', 'accounts', 'fcea920f7412b5da7be0cf42b8c93759', '1990-06-08', 'accounts@gmail.com', '', '9877878787', '', '', NULL, '', '', '', 1, 0, 0, '2019-06-18 18:08:12', '2019-06-27 06:22:23'),
(6, 'USER-0006', 'Kalai', 'T', 'kalai', 'e10adc3949ba59abbe56e057f20f883e', '2010-07-08', 'f2ftesting@gmail.com', '', '9789416199', 'test', '', NULL, '', '', '', 1, 1, 0, '2019-07-02 15:54:55', '2019-08-19 04:58:32');

-- --------------------------------------------------------

--
-- Table structure for table `scoo_user_modules`
--

CREATE TABLE `scoo_user_modules` (
  `id` int(11) NOT NULL,
  `user_module_name` varchar(100) NOT NULL,
  `user_module_key` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `scoo_user_modules`
--

INSERT INTO `scoo_user_modules` (`id`, `user_module_name`, `user_module_key`, `status`, `created_date`, `updated_date`) VALUES
(1, 'Dashboard', 'dashboard', 1, '2017-08-04 18:37:39', NULL),
(2, 'Masters', 'masters', 1, '2017-08-04 18:37:39', NULL),
(3, 'Users', 'users', 1, '2017-08-04 18:37:39', NULL),
(7, 'ScooterO', 'scooterO', 1, '2020-08-31 17:23:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `scoo_user_sections`
--

CREATE TABLE `scoo_user_sections` (
  `id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `user_section_name` varchar(100) NOT NULL,
  `user_section_key` varchar(100) NOT NULL,
  `acc_view` int(1) NOT NULL DEFAULT '0' COMMENT '0-Disabled, 1-Enabled',
  `acc_add` int(1) NOT NULL DEFAULT '0' COMMENT '0-Disabled, 1-Enabled',
  `acc_edit` int(1) NOT NULL DEFAULT '0' COMMENT '0-Disabled, 1-Enabled',
  `acc_delete` int(1) DEFAULT '0' COMMENT '0-Disabled, 1-Enabled',
  `status` tinyint(1) DEFAULT '1',
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `scoo_user_sections`
--

INSERT INTO `scoo_user_sections` (`id`, `module_id`, `user_section_name`, `user_section_key`, `acc_view`, `acc_add`, `acc_edit`, `acc_delete`, `status`, `created_date`, `updated_date`) VALUES
(1, 1, 'Dashboard', 'dashboard', 1, 0, 0, 0, 1, '2017-08-04 19:13:30', NULL),
(3, 3, 'Manage Users', 'users', 1, 1, 1, 1, 1, '2017-08-04 19:13:31', NULL),
(4, 3, 'Manage User Types', 'user_types', 1, 1, 1, 1, 1, '2017-08-04 19:13:31', NULL),
(5, 3, 'Manage User Modules', 'user_modules', 1, 1, 1, 1, 1, '2017-08-04 19:13:31', NULL),
(6, 3, 'Manage User Sections', 'user_sections', 1, 1, 1, 1, 1, '2017-08-04 19:13:31', NULL),
(13, 2, 'General Settings', 'setting', 1, 1, 1, 1, 1, '2019-06-27 17:12:12', NULL),
(14, 2, 'Manage ScooterO', 'scooterO', 1, 1, 1, 1, 1, '2020-08-31 17:24:59', NULL),
(15, 2, 'Manage Subscriptions', 'subscriptions', 1, 1, 1, 1, 1, '2020-09-01 12:31:17', NULL),
(16, 2, 'Manage Customers', 'customers', 1, 0, 0, 0, 1, '2020-09-01 14:36:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `scoo_user_types`
--

CREATE TABLE `scoo_user_types` (
  `id` int(11) NOT NULL,
  `user_type_name` varchar(50) NOT NULL,
  `grand_all` int(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1-deleted,0-not deleted',
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `scoo_user_types`
--

INSERT INTO `scoo_user_types` (`id`, `user_type_name`, `grand_all`, `status`, `is_deleted`, `created_date`, `updated_date`) VALUES
(1, 'Admin', 1, 1, 0, '2017-01-25 13:47:25', '2020-09-01 11:07:54'),
(2, 'Member', 0, 1, 0, '2017-04-20 16:04:36', '2019-06-27 06:18:27');

-- --------------------------------------------------------

--
-- Table structure for table `scoo_user_type_permissions`
--

CREATE TABLE `scoo_user_type_permissions` (
  `id` int(11) NOT NULL,
  `user_type_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `acc_all` int(1) NOT NULL COMMENT '0-Disabled, 1-Enabled',
  `acc_view` int(1) NOT NULL COMMENT '0-Disabled, 1-Enabled',
  `acc_add` int(1) NOT NULL COMMENT '0-Disabled, 1-Enabled',
  `acc_edit` int(1) NOT NULL COMMENT '0-Disabled, 1-Enabled',
  `acc_delete` int(1) NOT NULL COMMENT '0-Disabled, 1-Enabled',
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `scoo_user_type_permissions`
--

INSERT INTO `scoo_user_type_permissions` (`id`, `user_type_id`, `module_id`, `section_id`, `acc_all`, `acc_view`, `acc_add`, `acc_edit`, `acc_delete`, `created_date`, `updated_date`) VALUES
(129, 4, 1, 1, 1, 1, 0, 0, 0, '2019-06-03 04:51:15', NULL),
(130, 4, 2, 2, 1, 1, 1, 1, 1, '2019-06-03 04:51:15', NULL),
(131, 4, 3, 3, 1, 1, 1, 1, 1, '2019-06-03 04:51:15', NULL),
(132, 4, 3, 4, 1, 1, 1, 1, 1, '2019-06-03 04:51:15', NULL),
(141, 2, 1, 1, 1, 1, 0, 0, 0, '2019-06-27 06:18:27', NULL),
(173, 1, 1, 1, 1, 1, 0, 0, 0, '2020-09-01 11:07:55', NULL),
(174, 1, 2, 13, 1, 1, 1, 1, 1, '2020-09-01 11:07:55', NULL),
(175, 1, 2, 14, 1, 1, 1, 1, 1, '2020-09-01 11:07:55', NULL),
(176, 1, 2, 15, 1, 1, 1, 1, 1, '2020-09-01 11:07:55', NULL),
(177, 1, 2, 16, 1, 1, 1, 1, 1, '2020-09-01 11:07:55', NULL),
(178, 1, 3, 3, 1, 1, 1, 1, 1, '2020-09-01 11:07:55', NULL),
(179, 1, 3, 4, 1, 1, 1, 1, 1, '2020-09-01 11:07:55', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `last_activity_idx` (`last_activity`);

--
-- Indexes for table `scoo_customers`
--
ALTER TABLE `scoo_customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scoo_feedback`
--
ALTER TABLE `scoo_feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `scootoro_id` (`scootoro_id`),
  ADD KEY `trip_id` (`trip_id`);

--
-- Indexes for table `scoo_general_setting`
--
ALTER TABLE `scoo_general_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scoo_increment`
--
ALTER TABLE `scoo_increment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scoo_payment_details`
--
ALTER TABLE `scoo_payment_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scoo_scootero`
--
ALTER TABLE `scoo_scootero`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scoo_subscriptions`
--
ALTER TABLE `scoo_subscriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scoo_trip`
--
ALTER TABLE `scoo_trip`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `scooter_id` (`scooter_id`),
  ADD KEY `payment_id` (`payment_id`);

--
-- Indexes for table `scoo_users`
--
ALTER TABLE `scoo_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scoo_user_modules`
--
ALTER TABLE `scoo_user_modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scoo_user_sections`
--
ALTER TABLE `scoo_user_sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scoo_user_types`
--
ALTER TABLE `scoo_user_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scoo_user_type_permissions`
--
ALTER TABLE `scoo_user_type_permissions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `scoo_customers`
--
ALTER TABLE `scoo_customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `scoo_feedback`
--
ALTER TABLE `scoo_feedback`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `scoo_general_setting`
--
ALTER TABLE `scoo_general_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `scoo_increment`
--
ALTER TABLE `scoo_increment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `scoo_payment_details`
--
ALTER TABLE `scoo_payment_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `scoo_scootero`
--
ALTER TABLE `scoo_scootero`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `scoo_subscriptions`
--
ALTER TABLE `scoo_subscriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `scoo_trip`
--
ALTER TABLE `scoo_trip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `scoo_users`
--
ALTER TABLE `scoo_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `scoo_user_modules`
--
ALTER TABLE `scoo_user_modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `scoo_user_sections`
--
ALTER TABLE `scoo_user_sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `scoo_user_types`
--
ALTER TABLE `scoo_user_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `scoo_user_type_permissions`
--
ALTER TABLE `scoo_user_type_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=180;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `scoo_feedback`
--
ALTER TABLE `scoo_feedback`
  ADD CONSTRAINT `scoo_feedback_ibfk_1` FOREIGN KEY (`scootoro_id`) REFERENCES `scoo_scootero` (`id`),
  ADD CONSTRAINT `scoo_feedback_ibfk_2` FOREIGN KEY (`trip_id`) REFERENCES `scoo_trip` (`id`);

--
-- Constraints for table `scoo_trip`
--
ALTER TABLE `scoo_trip`
  ADD CONSTRAINT `scoo_trip_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `scoo_customers` (`id`),
  ADD CONSTRAINT `scoo_trip_ibfk_2` FOREIGN KEY (`scooter_id`) REFERENCES `scoo_scootero` (`id`),
  ADD CONSTRAINT `scoo_trip_ibfk_3` FOREIGN KEY (`payment_id`) REFERENCES `scoo_payment_details` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
