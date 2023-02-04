-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 31, 2020 at 07:18 AM
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
-- Database: `events_v2`
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
('57649ca44b928733d02ee3b3f760bfd5', '::1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36', 1598850214, 'a:2:{s:9:\"user_data\";s:0:\"\";s:6:\"events\";s:2988:\"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\";}'),
('ed26c93c6d0cc7e2b6fd7c12295038bc', '::1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36', 1598850188, ''),
('66b4dfe0b6ae69accce85c215bc88370', '::1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36', 1598850189, ''),
('5d71a8a73d697aee70b79f86e2b1ccc8', '::1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36', 1598850392, 'a:2:{s:9:\"user_data\";s:0:\"\";s:6:\"events\";s:2988:\"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\";}'),
('04f3979db4ac482e1cba29df1a5abf02', '::1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36', 1598850522, ''),
('3cd2e89cdc787aa10851f0210b6903ff', '::1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36', 1598850546, 'a:2:{s:9:\"user_data\";s:0:\"\";s:6:\"events\";s:2988:\"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\";}');

-- --------------------------------------------------------

--
-- Table structure for table `eve_contacts`
--

CREATE TABLE `eve_contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `phone_number` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `message` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `eve_contacts`
--

INSERT INTO `eve_contacts` (`id`, `name`, `phone_number`, `email`, `message`, `created_date`) VALUES
(1, 'Bumrah', '9626315874', 'gogulbui2k19@gmail.com', 'test', '2019-06-20 11:44:39'),
(2, 'Rahamat', '7452635210', 'rahamat@gmail.com', 'test', '2019-07-04 10:52:51');

-- --------------------------------------------------------

--
-- Table structure for table `eve_events`
--

CREATE TABLE `eve_events` (
  `id` int(11) NOT NULL,
  `event_type_id` varchar(50) NOT NULL,
  `event_name` varchar(50) NOT NULL,
  `from_date` datetime NOT NULL,
  `to_date` datetime NOT NULL,
  `latitude` varchar(50) NOT NULL,
  `longitude` varchar(50) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_type_id` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `approved_status` int(1) NOT NULL DEFAULT '2' COMMENT '0-Rejected,1-approved,2-pending',
  `can_notify_event` int(2) NOT NULL DEFAULT '0' COMMENT '1-notify to members,0-Not notify',
  `is_deleted` tinyint(1) DEFAULT '0' COMMENT '1-deleted,0-not deleted',
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `eve_events`
--

INSERT INTO `eve_events` (`id`, `event_type_id`, `event_name`, `from_date`, `to_date`, `latitude`, `longitude`, `user_id`, `user_type_id`, `status`, `approved_status`, `can_notify_event`, `is_deleted`, `created_date`, `updated_date`) VALUES
(1, '1', 'test', '2019-07-02 16:06:00', '2019-07-02 16:06:00', '8.565985', '78.12379299999998', 6, 1, 1, 1, 1, 0, '2019-07-02 16:07:10', NULL),
(2, '1', 'test2', '2019-07-02 16:07:00', '2019-07-02 16:07:00', '8.565985', '78.12379299999998', 7, 2, 1, 1, 1, 1, '2019-07-02 16:08:21', NULL),
(3, '1', 'test3', '2019-07-02 16:09:00', '2019-07-02 16:09:00', '8.565985', '78.12379299999998', 7, 2, 1, 1, 1, 0, '2019-07-02 16:10:55', NULL),
(4, '1', 'TEST -Event', '2019-07-03 19:00:00', '2019-07-03 21:00:00', '8.565985', '78.12379299999998', 1, 1, 1, 1, 1, 0, '2019-07-03 15:14:26', NULL),
(5, '1', 'Birthday event', '2019-07-05 16:00:00', '2019-07-05 19:00:00', '8.565985', '78.12379299999998', 1, 1, 1, 1, 1, 0, '2019-07-04 10:35:57', NULL),
(6, '2', 'Romeo&Juliet;', '2019-07-04 11:01:00', '2019-07-04 17:01:00', '8.565985', '78.12379299999998', 1, 1, 1, 1, 1, 1, '2019-07-04 11:03:36', '2019-07-04 05:35:21'),
(7, '2', 'function', '2019-07-06 11:07:00', '2019-07-06 22:07:00', '8.565985', '78.12379299999998', 2, 2, 1, 2, 0, 0, '2019-07-04 11:08:05', NULL),
(8, '2', 'Couples forever', '2019-07-04 11:08:00', '2019-07-04 18:08:00', '8.565985', '78.12379299999998', 1, 1, 1, 1, 1, 1, '2019-07-04 11:09:21', '2019-07-04 05:40:59'),
(9, '2', 'Couples forever', '2019-07-04 11:14:00', '2019-07-04 19:14:00', '8.565985', '78.12379299999998', 3, 2, 1, 1, 1, 0, '2019-07-04 11:16:09', '2019-07-04 05:47:18'),
(10, '2', 'Ranveer wed Deepika', '2019-07-04 11:29:00', '2019-07-04 11:29:00', '8.565985', '78.12379299999998', 3, 2, 1, 2, 0, 1, '2019-07-04 11:30:49', NULL),
(11, '2', 'Marriage', '2019-07-04 11:33:00', '2019-07-04 19:33:00', '8.565985', '78.12379299999998', 3, 2, 1, 1, 1, 0, '2019-07-04 11:34:01', '2019-07-04 06:04:46'),
(12, '1', 'Teens party', '2019-07-04 11:46:00', '2019-07-04 15:46:00', '8.564160220842885', '78.11714112164304', 3, 2, 1, 0, 1, 0, '2019-07-04 11:47:17', '2019-07-04 06:33:14'),
(13, '3', 'Music', '2019-07-04 12:27:00', '2019-07-04 18:27:00', '8.565985', '78.12379299999998', 3, 2, 1, 1, 1, 0, '2019-07-04 12:28:46', '2019-07-04 07:01:02'),
(14, '2', 'Reception', '2019-07-04 15:30:00', '2019-07-04 15:30:00', '8.565985', '78.12379299999998', 3, 2, 1, 2, 0, 1, '2019-07-04 15:31:24', NULL),
(15, '1', 'test', '2019-07-04 15:35:00', '2019-07-04 15:35:00', '8.565985', '78.12379299999998', 3, 2, 1, 2, 0, 1, '2019-07-04 15:36:11', NULL),
(16, '2', 'Marriage', '2019-07-04 15:38:00', '2019-07-04 15:38:00', '8.565985', '78.12379299999998', 3, 2, 1, 2, 0, 1, '2019-07-04 15:39:41', NULL),
(17, '2', 'Marriage', '2019-07-04 15:43:00', '2019-07-04 17:43:00', '8.565985', '78.12379299999998', 3, 2, 1, 1, 1, 0, '2019-07-04 15:44:04', '2019-07-04 10:14:43'),
(18, '1', 'Party', '2019-07-11 09:00:00', '2019-07-11 13:00:00', '8.565985', '78.12379299999998', 1, 1, 1, 1, 1, 0, '2019-07-09 11:53:04', '2019-07-09 06:39:24'),
(19, '1', 'test birthday', '2019-07-12 12:09:00', '2019-07-12 20:09:00', '8.565985', '78.12379299999998', 2, 2, 1, 2, 0, 0, '2019-07-09 12:10:33', '2019-07-09 06:41:12'),
(20, '2', 'WEDDINGS', '2019-07-29 19:21:00', '2019-07-29 21:19:00', '8.56194750000001', '78.12731640625', 2, 0, 1, 2, 0, 0, '2019-07-29 19:23:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `eve_event_actions`
--

CREATE TABLE `eve_event_actions` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `post_user_id` int(11) NOT NULL,
  `family_id` int(20) NOT NULL,
  `street_id` int(20) NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0-rejected,1-approved',
  `comments` varchar(150) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `eve_event_dynamic_values`
--

CREATE TABLE `eve_event_dynamic_values` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `event_type_id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `value` text NOT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `eve_event_dynamic_values`
--

INSERT INTO `eve_event_dynamic_values` (`id`, `event_id`, `event_type_id`, `field_id`, `value`, `created_date`, `updated_date`) VALUES
(1, 1, 1, 2, 'design-3.jpg', '2019-07-02 16:07:10', NULL),
(2, 1, 1, 1, 'Cbe', '2019-07-02 16:07:10', NULL),
(3, 1, 1, 3, '05/07/2019', '2019-07-02 16:07:10', NULL),
(4, 2, 1, 2, 'add11.jpg', '2019-07-02 16:08:21', NULL),
(5, 2, 1, 1, 'test1', '2019-07-02 16:08:21', NULL),
(6, 2, 1, 3, '06/07/2019', '2019-07-02 16:08:21', NULL),
(7, 3, 1, 1, 'Cbe', '2019-07-02 16:10:55', NULL),
(8, 3, 1, 3, '05/07/2019', '2019-07-02 16:10:55', NULL),
(9, 4, 1, 2, 'gst-cart2.jpg', '2019-07-03 15:14:27', NULL),
(10, 4, 1, 1, 'TEST', '2019-07-03 15:14:27', NULL),
(11, 4, 1, 3, '31/07/2019', '2019-07-03 15:14:27', NULL),
(12, 5, 1, 2, 'photo-1518953789413-9598f0909795.jpg', '2019-07-04 10:35:57', NULL),
(13, 5, 1, 1, 'test', '2019-07-04 10:35:57', NULL),
(14, 5, 1, 3, '17/10/2019', '2019-07-04 10:35:57', NULL),
(15, 6, 2, 5, 'Tulips.jpg', '2019-07-04 11:03:36', NULL),
(16, 6, 2, 4, 'VIRAT WEDS ANUSHKA', '2019-07-04 11:03:36', '2019-07-04 11:05:21'),
(17, 6, 2, 6, '', '2019-07-04 11:03:36', '2019-07-04 11:05:21'),
(18, 6, 2, 7, '', '2019-07-04 11:03:36', '2019-07-04 11:05:21'),
(19, 6, 2, 8, '', '2019-07-04 11:03:36', '2019-07-04 11:05:21'),
(20, 7, 2, 5, 'pexels-photo-931176.jpeg', '2019-07-04 11:08:05', NULL),
(21, 7, 2, 4, 'test', '2019-07-04 11:08:05', NULL),
(22, 7, 2, 6, '56456456546', '2019-07-04 11:08:05', NULL),
(23, 7, 2, 7, '26/04/2019', '2019-07-04 11:08:05', NULL),
(24, 7, 2, 8, 'test', '2019-07-04 11:08:05', NULL),
(25, 8, 2, 5, 'Tulips.jpg', '2019-07-04 11:09:21', NULL),
(26, 8, 2, 4, 'VIRAT WEDS ANUSHKA', '2019-07-04 11:09:21', '2019-07-04 11:10:59'),
(27, 8, 2, 6, '', '2019-07-04 11:09:21', '2019-07-04 11:10:59'),
(28, 8, 2, 7, '', '2019-07-04 11:09:21', '2019-07-04 11:10:59'),
(29, 8, 2, 8, '', '2019-07-04 11:09:21', '2019-07-04 11:10:59'),
(30, 9, 2, 5, 'Tulips.jpg', '2019-07-04 11:16:09', NULL),
(31, 9, 2, 4, 'VIRAT WEDS ANUSHKA', '2019-07-04 11:16:09', '2019-07-04 11:17:18'),
(32, 9, 2, 6, '', '2019-07-04 11:16:09', '2019-07-04 11:17:18'),
(33, 9, 2, 7, '', '2019-07-04 11:16:09', '2019-07-04 11:17:18'),
(34, 9, 2, 8, '', '2019-07-04 11:16:09', '2019-07-04 11:17:18'),
(35, 10, 2, 5, 'Tulips.jpg', '2019-07-04 11:30:49', NULL),
(36, 10, 2, 4, 'Ranveer weds deepika', '2019-07-04 11:30:49', NULL),
(37, 10, 2, 6, '', '2019-07-04 11:30:49', NULL),
(38, 10, 2, 7, '', '2019-07-04 11:30:49', NULL),
(39, 10, 2, 8, '', '2019-07-04 11:30:49', NULL),
(40, 11, 2, 5, 'Tulips.jpg', '2019-07-04 11:34:01', NULL),
(41, 11, 2, 4, 'Ranveer weds Deepika', '2019-07-04 11:34:01', '2019-07-04 11:34:46'),
(42, 11, 2, 6, '', '2019-07-04 11:34:01', '2019-07-04 11:34:46'),
(43, 11, 2, 7, '', '2019-07-04 11:34:01', '2019-07-04 11:34:46'),
(44, 11, 2, 8, '', '2019-07-04 11:34:01', '2019-07-04 11:34:46'),
(45, 12, 1, 2, 'Jellyfish.jpg', '2019-07-04 11:47:17', NULL),
(46, 12, 1, 1, '', '2019-07-04 11:47:17', '2019-07-04 12:03:14'),
(47, 12, 1, 3, '', '2019-07-04 11:47:17', '2019-07-04 12:03:14'),
(48, 13, 3, 9, 'Chennai', '2019-07-04 12:28:46', '2019-07-04 12:31:02'),
(49, 13, 3, 10, '04/07/2019', '2019-07-04 12:28:46', '2019-07-04 12:31:02'),
(50, 13, 3, 12, 'Team A,Team B', '2019-07-04 12:28:46', '2019-07-04 12:31:02'),
(51, 14, 2, 4, '', '2019-07-04 15:31:24', NULL),
(52, 14, 2, 6, '', '2019-07-04 15:31:24', NULL),
(53, 14, 2, 7, '', '2019-07-04 15:31:24', NULL),
(54, 14, 2, 8, '', '2019-07-04 15:31:24', NULL),
(55, 15, 1, 1, '', '2019-07-04 15:36:11', NULL),
(56, 15, 1, 3, '', '2019-07-04 15:36:11', NULL),
(57, 16, 2, 4, '', '2019-07-04 15:39:41', NULL),
(58, 16, 2, 6, '', '2019-07-04 15:39:41', NULL),
(59, 16, 2, 7, '', '2019-07-04 15:39:41', NULL),
(60, 16, 2, 8, '', '2019-07-04 15:39:41', NULL),
(61, 17, 2, 5, 'Anniversary-8.jpg', '2019-07-04 15:44:04', NULL),
(62, 17, 2, 4, '', '2019-07-04 15:44:04', '2019-07-04 15:44:43'),
(63, 17, 2, 6, '', '2019-07-04 15:44:04', '2019-07-04 15:44:43'),
(64, 17, 2, 7, '', '2019-07-04 15:44:04', '2019-07-04 15:44:43'),
(65, 17, 2, 8, '', '2019-07-04 15:44:04', '2019-07-04 15:44:43'),
(66, 18, 1, 31, 'pexels-photo-269887.jpeg', '2019-07-09 11:53:04', NULL),
(67, 18, 1, 30, '8789787879', '2019-07-09 11:53:04', '2019-07-09 12:09:25'),
(68, 18, 1, 32, '22/03/2019', '2019-07-09 11:53:04', '2019-07-09 12:09:25'),
(69, 18, 1, 33, 'Option 3', '2019-07-09 11:53:04', '2019-07-09 12:09:25'),
(70, 18, 1, 34, 'Option 1', '2019-07-09 11:53:04', '2019-07-09 12:09:25'),
(71, 18, 1, 35, 'Option 3', '2019-07-09 11:53:04', '2019-07-09 12:09:25'),
(72, 19, 1, 31, 'photo-1515934751635-c81c6bc9a2d8.jpg', '2019-07-09 12:10:34', NULL),
(73, 19, 1, 30, '', '2019-07-09 12:10:34', '2019-07-09 12:11:13'),
(74, 19, 1, 32, '', '2019-07-09 12:10:34', '2019-07-09 12:11:13'),
(75, 19, 1, 33, 'Option 1', '2019-07-09 12:10:34', '2019-07-09 12:11:13'),
(76, 19, 1, 34, 'Option 1', '2019-07-09 12:10:34', '2019-07-09 12:11:13'),
(77, 19, 1, 35, 'Option 2', '2019-07-09 12:10:34', '2019-07-09 12:11:13'),
(78, 20, 2, 5, '', '2019-07-17 19:23:25', NULL),
(79, 20, 2, 4, 'TEXT', '2019-07-17 19:23:25', NULL),
(80, 20, 2, 6, '', '2019-07-17 19:23:25', NULL),
(81, 20, 2, 7, '', '2019-07-17 19:23:25', NULL),
(82, 20, 2, 8, '', '2019-07-17 19:23:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `eve_event_invitations`
--

CREATE TABLE `eve_event_invitations` (
  `id` int(11) NOT NULL,
  `event_id` int(10) NOT NULL,
  `file_name` varchar(100) NOT NULL,
  `img_path` varchar(150) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `eve_event_invitations`
--

INSERT INTO `eve_event_invitations` (`id`, `event_id`, `file_name`, `img_path`, `created_date`) VALUES
(1, 4, 'favicone.png', 'http://demo.f2fsolutions.co.in/events_v2/attachments/events/invitations/favicone.png', '2019-07-03 09:44:27'),
(2, 5, 'pexels-photo-206358.jpeg', 'http://demo.f2fsolutions.co.in/events_v2/attachments/events/invitations/pexels-photo-206358.jpeg', '2019-07-04 05:05:57'),
(3, 6, 'kohli-anushka-7591.jpg', 'http://demo.f2fsolutions.co.in/events_v2/attachments/events/invitations/kohli-anushka-7591.jpg', '2019-07-04 05:33:36'),
(4, 7, 'photo-1515934751635-c81c6bc9a2d8_(1).jpg', 'http://demo.f2fsolutions.co.in/events_v2/attachments/events/invitations/photo-1515934751635-c81c6bc9a2d8_(1).jpg', '2019-07-04 05:38:05'),
(5, 8, 'kohli-anushka-75911.jpg', 'http://demo.f2fsolutions.co.in/events_v2/attachments/events/invitations/kohli-anushka-75911.jpg', '2019-07-04 05:39:21'),
(6, 9, 'kohli-anushka-75912.jpg', 'http://demo.f2fsolutions.co.in/events_v2/attachments/events/invitations/kohli-anushka-75912.jpg', '2019-07-04 05:46:09'),
(7, 10, 'Deepika-Padukone-and-Ranveer-Singh-wedding-i-in-Lake-Como-22.jpg', 'http://demo.f2fsolutions.co.in/events_v2/attachments/events/invitations/Deepika-Padukone-and-Ranveer-Singh-wedding-i-in-Lake-Como-22.jpg', '2019-07-04 06:00:49'),
(8, 11, 'Deepika-Padukone-and-Ranveer-Singh-wedding-i-in-Lake-Como-221.jpg', 'http://demo.f2fsolutions.co.in/events_v2/attachments/events/invitations/Deepika-Padukone-and-Ranveer-Singh-wedding-i-in-Lake-Como-221.jpg', '2019-07-04 06:04:02'),
(9, 12, 'Tulips.jpg', 'http://demo.f2fsolutions.co.in/events_v2/attachments/events/invitations/Tulips.jpg', '2019-07-04 06:17:17'),
(10, 13, 'ert.jpg', 'http://demo.f2fsolutions.co.in/events_v2/attachments/events/invitations/ert.jpg', '2019-07-04 06:58:46'),
(11, 14, 'raina_4.jpg', 'http://demo.f2fsolutions.co.in/events_v2/attachments/events/invitations/raina_4.jpg', '2019-07-04 10:01:24'),
(12, 15, 'Anniversary-8.jpg', 'http://demo.f2fsolutions.co.in/events_v2/attachments/events/invitations/Anniversary-8.jpg', '2019-07-04 10:06:11'),
(13, 16, 'Anniversary-81.jpg', 'http://demo.f2fsolutions.co.in/events_v2/attachments/events/invitations/Anniversary-81.jpg', '2019-07-04 10:09:41'),
(14, 17, 'raina_41.jpg', 'http://demo.f2fsolutions.co.in/events_v2/attachments/events/invitations/raina_41.jpg', '2019-07-04 10:14:04'),
(15, 18, 'pexels-photo-2063581.jpeg', 'http://demo.f2fsolutions.co.in/events_v2/attachments/events/invitations/pexels-photo-2063581.jpeg', '2019-07-09 06:23:04'),
(16, 19, 'pexels-photo-2649021.jpeg', 'http://demo.f2fsolutions.co.in/events_v2/attachments/events/invitations/pexels-photo-2649021.jpeg', '2019-07-09 06:40:34');

-- --------------------------------------------------------

--
-- Table structure for table `eve_event_invited_members`
--

CREATE TABLE `eve_event_invited_members` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `total_invited_members` int(11) NOT NULL,
  `invited_members` mediumtext NOT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `eve_event_invited_members`
--

INSERT INTO `eve_event_invited_members` (`id`, `event_id`, `total_invited_members`, `invited_members`, `created_date`, `updated_date`) VALUES
(1, 1, 1, '[1]', '2019-07-02 16:07:10', NULL),
(2, 2, 1, '[1]', '2019-07-02 16:08:21', NULL),
(3, 3, 1, '[1]', '2019-07-02 16:10:55', NULL),
(4, 4, 2, '[1,2]', '2019-07-03 15:14:26', NULL),
(5, 5, 2, '[1,2]', '2019-07-04 10:35:57', NULL),
(6, 6, 1, '[3]', '2019-07-04 11:03:36', '2019-07-04 11:05:21'),
(7, 7, 3, '[1,2,3]', '2019-07-04 11:08:05', NULL),
(8, 8, 2, '[1,3]', '2019-07-04 11:09:21', '2019-07-04 11:10:59'),
(9, 9, 3, '[1,2,3]', '2019-07-04 11:16:09', '2019-07-04 11:17:18'),
(10, 10, 4, '[1,2,3,4]', '2019-07-04 11:30:49', NULL),
(11, 11, 4, '[1,2,3,4]', '2019-07-04 11:34:01', '2019-07-04 11:34:46'),
(12, 12, 4, '[1,2,3,4]', '2019-07-04 11:47:17', '2019-07-04 12:03:14'),
(13, 13, 2, '[2,3]', '2019-07-04 12:28:46', '2019-07-04 12:31:02'),
(14, 14, 2, '[2,3]', '2019-07-04 15:31:24', NULL),
(15, 15, 3, '[1,2,3]', '2019-07-04 15:36:11', NULL),
(16, 16, 1, '[3]', '2019-07-04 15:39:41', NULL),
(17, 17, 2, '[2,3]', '2019-07-04 15:44:04', '2019-07-04 15:44:43'),
(18, 18, 2, '[4,5]', '2019-07-09 11:53:04', '2019-07-09 12:09:24'),
(19, 19, 3, '[1,2,3]', '2019-07-09 12:10:33', '2019-07-09 12:11:13'),
(20, 20, 3, '[\"40\",\"41\",\"39\"]', '2019-07-17 19:23:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `eve_event_types`
--

CREATE TABLE `eve_event_types` (
  `id` int(11) NOT NULL,
  `event_type_name` varchar(50) NOT NULL,
  `form_data` longtext,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1-deleted,0-not deleted',
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `eve_event_types`
--

INSERT INTO `eve_event_types` (`id`, `event_type_name`, `form_data`, `status`, `is_deleted`, `created_date`, `updated_date`) VALUES
(1, 'Birthday', '[{\"type\":\"text\",\"label\":\"Text Field\",\"className\":\"form-control\",\"name\":\"text-1562063712657\",\"subtype\":\"text\"},{\"type\":\"file\",\"label\":\"File Upload\",\"className\":\"form-control\",\"name\":\"file-1562063713629\",\"subtype\":\"file\"},{\"type\":\"date\",\"label\":\"Date Field\",\"className\":\"form-control\",\"name\":\"date-1562063715637\",\"value\":\"2019-05-07\"},{\"type\":\"select\",\"required\":true,\"label\":\"Select\",\"className\":\"form-control\",\"name\":\"select-1562570011583\",\"values\":[{\"label\":\"Option 1\",\"value\":\"option-1\",\"selected\":true},{\"label\":\"Option 2\",\"value\":\"option-2\"},{\"label\":\"Option 3\",\"value\":\"option-3\"}]},{\"type\":\"checkbox-group\",\"required\":true,\"label\":\"Checkbox Group\",\"name\":\"checkbox-group-1562570012322\",\"values\":[{\"label\":\"Option 1\",\"value\":\"option-1\"}]},{\"type\":\"radio-group\",\"required\":true,\"label\":\"Radio Group\",\"name\":\"radio-group-1562570058873\",\"values\":[{\"label\":\"Option 1\",\"value\":\"option-1\"},{\"label\":\"Option 2\",\"value\":\"option-2\"},{\"label\":\"Option 3\",\"value\":\"option-3\"}]}]', 1, 0, '2019-07-02 16:06:17', '2019-07-08 12:44:30'),
(2, 'wedding', '[{\"type\":\"text\",\"label\":\"Text Field\",\"className\":\"form-control\",\"name\":\"text-1562155248760\",\"subtype\":\"text\"},{\"type\":\"file\",\"label\":\"File Upload\",\"className\":\"form-control\",\"name\":\"file-1562155249269\",\"subtype\":\"file\"},{\"type\":\"number\",\"label\":\"Number\",\"className\":\"form-control\",\"name\":\"number-1562155249709\"},{\"type\":\"date\",\"label\":\"Date Field\",\"className\":\"form-control\",\"name\":\"date-1562155250149\"},{\"type\":\"textarea\",\"label\":\"Text Area\",\"className\":\"form-control\",\"name\":\"textarea-1562155250565\",\"subtype\":\"textarea\"}]', 1, 0, '2019-07-03 17:30:57', '2019-07-29 15:42:35'),
(3, 'START MUSiC', '[{\"type\":\"text\",\"required\":true,\"label\":\"Location\",\"className\":\"form-control\",\"name\":\"text-1562223274085\",\"subtype\":\"text\"},{\"type\":\"date\",\"required\":true,\"label\":\"Date&nbsp;\",\"className\":\"form-control\",\"name\":\"date-1562223297855\"},{\"type\":\"file\",\"label\":\"Image Upload\",\"className\":\"form-control\",\"name\":\"file-1562223314550\",\"subtype\":\"file\"},{\"type\":\"checkbox-group\",\"label\":\"TEAM MEMBERS\",\"name\":\"checkbox-group-1562223328622\",\"values\":[{\"label\":\"Team A\",\"value\":\"\"},{\"label\":\"Team B\",\"value\":\"\"}]}]', 1, 0, '2019-07-04 12:26:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `eve_event_type_dynamic_fields`
--

CREATE TABLE `eve_event_type_dynamic_fields` (
  `id` int(11) NOT NULL,
  `event_type_id` int(11) NOT NULL,
  `field_name` text NOT NULL,
  `field_type` enum('text','file','number','date','textarea','select','checkbox-group','radio-group') NOT NULL,
  `field_label` varchar(150) NOT NULL,
  `field_data` text,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `eve_event_type_dynamic_fields`
--

INSERT INTO `eve_event_type_dynamic_fields` (`id`, `event_type_id`, `field_name`, `field_type`, `field_label`, `field_data`, `status`, `is_deleted`, `created_date`, `updated_date`) VALUES
(9, 3, 'text-1562223274085', 'text', 'Location', '{\"type\":\"text\",\"required\":true,\"label\":\"Location\",\"className\":\"form-control\",\"name\":\"text-1562223274085\",\"subtype\":\"text\"}', 1, 0, '2019-07-04 12:26:40', NULL),
(10, 3, 'date-1562223297855', 'date', 'Date&nbsp;', '{\"type\":\"date\",\"required\":true,\"label\":\"Date&nbsp;\",\"className\":\"form-control\",\"name\":\"date-1562223297855\"}', 1, 0, '2019-07-04 12:26:40', NULL),
(11, 3, 'file-1562223314550', 'file', 'Image Upload', '{\"type\":\"file\",\"label\":\"Image Upload\",\"className\":\"form-control\",\"name\":\"file-1562223314550\",\"subtype\":\"file\"}', 1, 0, '2019-07-04 12:26:40', NULL),
(12, 3, 'checkbox-group-1562223328622', 'checkbox-group', 'TEAM MEMBERS', '{\"type\":\"checkbox-group\",\"label\":\"TEAM MEMBERS\",\"name\":\"checkbox-group-1562223328622\",\"values\":[{\"label\":\"Team A\",\"value\":\"\"},{\"label\":\"Team B\",\"value\":\"\"}]}', 1, 0, '2019-07-04 12:26:40', NULL),
(30, 1, 'text-1562063712657', 'text', 'Text Field', '{\"type\":\"text\",\"label\":\"Text Field\",\"className\":\"form-control\",\"name\":\"text-1562063712657\",\"subtype\":\"text\"}', 1, 0, '2019-07-08 12:44:30', '2019-07-08 12:44:30'),
(31, 1, 'file-1562063713629', 'file', 'File Upload', '{\"type\":\"file\",\"label\":\"File Upload\",\"className\":\"form-control\",\"name\":\"file-1562063713629\",\"subtype\":\"file\"}', 1, 0, '2019-07-08 12:44:30', '2019-07-08 12:44:30'),
(32, 1, 'date-1562063715637', 'date', 'Date Field', '{\"type\":\"date\",\"label\":\"Date Field\",\"className\":\"form-control\",\"name\":\"date-1562063715637\",\"value\":\"2019-05-07\"}', 1, 0, '2019-07-08 12:44:30', '2019-07-08 12:44:30'),
(33, 1, 'select-1562570011583', 'select', 'Select', '{\"type\":\"select\",\"required\":true,\"label\":\"Select\",\"className\":\"form-control\",\"name\":\"select-1562570011583\",\"values\":[{\"label\":\"Option 1\",\"value\":\"option-1\",\"selected\":true},{\"label\":\"Option 2\",\"value\":\"option-2\"},{\"label\":\"Option 3\",\"value\":\"option-3\"}]}', 1, 0, '2019-07-08 12:44:30', '2019-07-08 12:44:30'),
(34, 1, 'checkbox-group-1562570012322', 'checkbox-group', 'Checkbox Group', '{\"type\":\"checkbox-group\",\"required\":true,\"label\":\"Checkbox Group\",\"name\":\"checkbox-group-1562570012322\",\"values\":[{\"label\":\"Option 1\",\"value\":\"option-1\"}]}', 1, 0, '2019-07-08 12:44:30', '2019-07-08 12:44:30'),
(35, 1, 'radio-group-1562570058873', 'radio-group', 'Radio Group', '{\"type\":\"radio-group\",\"required\":true,\"label\":\"Radio Group\",\"name\":\"radio-group-1562570058873\",\"values\":[{\"label\":\"Option 1\",\"value\":\"option-1\"},{\"label\":\"Option 2\",\"value\":\"option-2\"},{\"label\":\"Option 3\",\"value\":\"option-3\"}]}', 1, 0, '2019-07-08 12:44:30', '2019-07-08 12:44:30'),
(41, 2, 'text-1562155248760', 'text', 'Text Field', '{\"type\":\"text\",\"label\":\"Text Field\",\"className\":\"form-control\",\"name\":\"text-1562155248760\",\"subtype\":\"text\"}', 1, 0, '2019-07-29 15:42:35', '2019-07-29 15:42:35'),
(42, 2, 'file-1562155249269', 'file', 'File Upload', '{\"type\":\"file\",\"label\":\"File Upload\",\"className\":\"form-control\",\"name\":\"file-1562155249269\",\"subtype\":\"file\"}', 1, 0, '2019-07-29 15:42:35', '2019-07-29 15:42:35'),
(43, 2, 'number-1562155249709', 'number', 'Number', '{\"type\":\"number\",\"label\":\"Number\",\"className\":\"form-control\",\"name\":\"number-1562155249709\"}', 1, 0, '2019-07-29 15:42:35', '2019-07-29 15:42:35'),
(44, 2, 'date-1562155250149', 'date', 'Date Field', '{\"type\":\"date\",\"label\":\"Date Field\",\"className\":\"form-control\",\"name\":\"date-1562155250149\"}', 1, 0, '2019-07-29 15:42:35', '2019-07-29 15:42:35'),
(45, 2, 'textarea-1562155250565', 'textarea', 'Text Area', '{\"type\":\"textarea\",\"label\":\"Text Area\",\"className\":\"form-control\",\"name\":\"textarea-1562155250565\",\"subtype\":\"textarea\"}', 1, 0, '2019-07-29 15:42:35', '2019-07-29 15:42:35');

-- --------------------------------------------------------

--
-- Table structure for table `eve_features`
--

CREATE TABLE `eve_features` (
  `id` int(11) NOT NULL,
  `pricing_id` int(11) NOT NULL,
  `features` varchar(150) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `eve_features`
--

INSERT INTO `eve_features` (`id`, `pricing_id`, `features`, `created_date`, `updated_date`) VALUES
(1, 1, '25% Cashback', '2019-06-20 11:45:53', NULL),
(2, 1, 'Unlimted Downloads', '2019-06-20 11:45:53', NULL),
(3, 2, '100% Cashback', '2019-06-21 04:23:11', NULL),
(4, 2, 'Unlimited', '2019-06-21 04:23:11', NULL),
(5, 3, '10% Cashback', '2019-07-04 10:58:09', NULL),
(6, 3, 'Limited downloads', '2019-07-04 10:58:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `eve_general_setting`
--

CREATE TABLE `eve_general_setting` (
  `id` int(11) NOT NULL,
  `contact_mail` varchar(35) NOT NULL,
  `copy_right` varchar(25) NOT NULL,
  `site_address` varchar(150) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `eve_general_setting`
--

INSERT INTO `eve_general_setting` (`id`, `contact_mail`, `copy_right`, `site_address`, `updated_date`) VALUES
(22, 'f2ftesting@gmail.com', '2019 Events', '', '2020-01-18 11:43:17');

-- --------------------------------------------------------

--
-- Table structure for table `eve_groups`
--

CREATE TABLE `eve_groups` (
  `id` int(11) NOT NULL,
  `group_name` varchar(50) NOT NULL,
  `city` int(1) NOT NULL,
  `street_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1-deleted,0-not deleted',
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `eve_groups`
--

INSERT INTO `eve_groups` (`id`, `group_name`, `city`, `street_id`, `status`, `is_deleted`, `created_date`, `updated_date`) VALUES
(1, 'aasath family', 1, 2, 1, 0, '2019-06-20 16:24:28', '2019-07-04 10:53:10'),
(2, '1st family', 2, 77, 1, 0, '2019-06-20 16:30:14', NULL),
(3, 'Shakshi family', 1, 35, 1, 0, '2019-06-20 16:38:25', '2019-06-20 16:38:55'),
(4, 'dio  Family', 2, 83, 1, 0, '2019-06-20 16:40:11', '2019-06-27 13:37:32'),
(5, 'kayal family', 1, 99, 1, 0, '2019-06-28 18:33:35', '2019-06-28 18:35:20'),
(6, 'test - s', 1, 101, 1, 0, '2019-07-02 16:02:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `eve_increment`
--

CREATE TABLE `eve_increment` (
  `id` int(11) NOT NULL,
  `type` varchar(30) DEFAULT NULL,
  `code` varchar(10) DEFAULT NULL,
  `prefix` varchar(50) DEFAULT NULL,
  `last_increment_id` varchar(10) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `eve_increment`
--

INSERT INTO `eve_increment` (`id`, `type`, `code`, `prefix`, `last_increment_id`) VALUES
(1, 'user_code', 'USER', NULL, '9'),
(2, 'member_code', 'MEMBER', NULL, '6');

-- --------------------------------------------------------

--
-- Table structure for table `eve_members`
--

CREATE TABLE `eve_members` (
  `id` int(11) NOT NULL,
  `member_id` varchar(50) DEFAULT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `city` int(1) NOT NULL COMMENT '1-kayal,2-others',
  `city_name` varchar(20) NOT NULL,
  `street_id` varchar(50) NOT NULL,
  `family_id` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `dob` date DEFAULT NULL,
  `age` int(5) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `email_address` varchar(100) NOT NULL,
  `mobile_number` varchar(20) DEFAULT NULL,
  `on_kayalpattinam` enum('temporary','permanent','out_of_kayalpattinam') NOT NULL,
  `duration_from` datetime DEFAULT NULL,
  `duration_to` datetime DEFAULT NULL,
  `relation` enum('parent','children','siblings','relatives','others') DEFAULT NULL,
  `address_line_1` varchar(150) DEFAULT NULL,
  `address_line_2` varchar(150) NOT NULL,
  `profile_image` varchar(150) DEFAULT NULL,
  `user_type_id` int(11) NOT NULL,
  `approved_status` int(1) NOT NULL COMMENT '1-approved,2-hold,0-rejected,',
  `user_location` text,
  `latitude` varchar(150) DEFAULT NULL,
  `longitude` varchar(150) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) DEFAULT '0' COMMENT '1-deleted,0-not deleted',
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `eve_members`
--

INSERT INTO `eve_members` (`id`, `member_id`, `firstname`, `lastname`, `username`, `city`, `city_name`, `street_id`, `family_id`, `password`, `dob`, `age`, `gender`, `email_address`, `mobile_number`, `on_kayalpattinam`, `duration_from`, `duration_to`, `relation`, `address_line_1`, `address_line_2`, `profile_image`, `user_type_id`, `approved_status`, `user_location`, `latitude`, `longitude`, `status`, `is_deleted`, `created_date`, `updated_date`) VALUES
(1, 'MEMBER-0001', 'kalai member', 'm', 'kalaimem', 1, 'Kayalpattinam', '101', 6, '4297f44b13955235245b2497399d7a93', '1995-07-25', 24, 'female', 'testmem@gmail.com', '9789526288', 'permanent', NULL, NULL, 'children', 'Kalyalpattinam,Tamilnadu', '', NULL, 2, 1, NULL, NULL, NULL, 1, 0, '2019-07-02 16:02:49', '2019-08-19 04:57:36'),
(2, 'MEMBER-0002', 'james', 'bond', 'james', 1, 'Kayalpattinam', '2', 1, 'e10adc3949ba59abbe56e057f20f883e', '1984-01-25', 0, 'female', 'james@gmail.com', '8787878787', 'permanent', NULL, NULL, 'children', 'Kalyalpattinam,Tamilnadu', '', NULL, 2, 1, '', '', '', 1, 0, '2019-07-02 16:28:43', '2020-02-20 09:10:20'),
(3, 'MEMBER-0003', 'Babar', 'Azam', 'Babar', 1, 'Kayalpattinam', '2', 1, 'e10adc3949ba59abbe56e057f20f883e', '1993-01-14', 26, 'male', 'test@gmail.com', '9652634152', 'permanent', NULL, NULL, 'children', 'Kalyalpattinam,Tamilnadu', '', NULL, 2, 1, '', '', '', 1, 0, '2019-07-04 10:46:52', '2019-08-19 04:57:08'),
(4, 'MEMBER-0004', 'MEMBER', '', 'MEMBER', 2, 'Others', '77', 2, 'e10adc3949ba59abbe56e057f20f883e', '1993-10-27', 26, 'child', 'MEMBER@gmail.com', '9887545489', 'permanent', NULL, NULL, 'others', 'Kalyalpattinam,Tamilnadu', '', NULL, 2, 1, NULL, NULL, NULL, 1, 0, '2019-07-04 11:28:50', '2019-07-04 11:38:12'),
(5, 'MEMBER-0005', 'Ajith', 'kumar', 'test', 2, 'Others', '77', 2, 'e10adc3949ba59abbe56e057f20f883e', '1989-01-26', 0, 'male', 'ajith@gmail.com', '8596415263', 'temporary', '2019-07-04 00:00:00', '2020-03-20 00:00:00', 'parent', 'Kalyalpattinam,Tamilnadu', 'coimbatore', '', 2, 1, NULL, NULL, NULL, 1, 0, '2019-07-04 16:48:52', '2020-02-11 07:02:30');

-- --------------------------------------------------------

--
-- Table structure for table `eve_member_location`
--

CREATE TABLE `eve_member_location` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `latitude` varchar(50) NOT NULL,
  `longitude` varchar(50) NOT NULL,
  `location` varchar(50) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `eve_member_location`
--

INSERT INTO `eve_member_location` (`id`, `user_id`, `latitude`, `longitude`, `location`, `created_date`, `updated_date`) VALUES
(80, 1, '11.0282804', '76.9494255', 'Kuppakonam Pudur,Coimbatore', '2019-06-24 19:29:02', NULL),
(87, 2, '11.0187345', '76.966735', 'Gandhipuram,Coimbatore', '2019-10-08 17:02:06', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `eve_pricing`
--

CREATE TABLE `eve_pricing` (
  `id` int(11) NOT NULL,
  `plan_name` varchar(50) NOT NULL,
  `plan_amount` float(10,2) NOT NULL DEFAULT '0.00',
  `plan_duration` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `eve_pricing`
--

INSERT INTO `eve_pricing` (`id`, `plan_name`, `plan_amount`, `plan_duration`, `status`, `is_deleted`, `created_date`, `updated_date`) VALUES
(1, 'Summer offer', 250.00, 2, 1, 0, '2019-06-20 11:45:53', NULL),
(2, 'Jio Dhan Dhana offer', 350.00, 1, 1, 0, '2019-06-21 04:23:11', NULL),
(3, 'Basic scheme', 25.00, 2, 1, 0, '2019-07-04 10:58:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `eve_relation`
--

CREATE TABLE `eve_relation` (
  `id` int(11) NOT NULL,
  `relation` varchar(150) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `eve_streets`
--

CREATE TABLE `eve_streets` (
  `id` int(11) NOT NULL,
  `street_name` varchar(100) NOT NULL,
  `city` int(1) NOT NULL COMMENT '1-kayal,2-others',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1-deleted,0-not deleted',
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `eve_streets`
--

INSERT INTO `eve_streets` (`id`, `street_name`, `city`, `status`, `is_deleted`, `created_date`, `updated_date`) VALUES
(1, 'Aarampalli Street', 1, 0, 0, '2018-10-26 14:42:20', '2019-06-13 11:23:32'),
(2, 'Aasath Street', 1, 1, 0, '2018-10-26 14:43:28', '2019-06-19 04:50:28'),
(3, 'Akbarshaa Street KPM', 1, 1, 0, '2018-10-26 14:44:03', NULL),
(4, 'Aliyar Street', 1, 1, 0, '2018-10-26 14:44:47', NULL),
(5, 'Ambalamarika Street', 1, 1, 0, '2018-10-26 14:45:12', '2018-10-26 14:51:10'),
(6, 'Appapalli Street', 1, 1, 0, '2018-10-26 14:45:32', '2018-10-26 15:01:07'),
(7, 'Aram Palli Street', 1, 1, 0, '2018-10-26 14:46:09', NULL),
(8, 'Arumuganeri', 1, 1, 0, '2018-10-26 14:48:26', '2018-10-26 14:49:09'),
(9, 'Asath Street', 1, 1, 0, '2018-10-26 15:00:28', NULL),
(10, 'Bargar Colony', 1, 1, 0, '2018-10-26 15:01:40', NULL),
(11, 'Beach', 1, 1, 0, '2018-10-26 15:02:09', NULL),
(12, 'Beach Road', 1, 1, 0, '2018-10-26 15:38:11', NULL),
(13, 'Beach St', 1, 1, 0, '2018-10-26 15:38:56', NULL),
(14, 'Big Street', 1, 1, 0, '2018-10-26 15:39:14', NULL),
(15, 'Buharry Sharif Backside', 1, 1, 0, '2018-10-26 15:39:42', NULL),
(16, 'ByPass Road', 1, 1, 0, '2018-10-26 15:40:04', NULL),
(17, 'Chinna Neasavu St', 1, 1, 0, '2018-10-26 15:40:29', NULL),
(18, 'Cross Street', 1, 1, 0, '2018-10-26 15:40:55', NULL),
(19, 'Customs Road', 1, 1, 0, '2018-10-26 15:41:56', NULL),
(20, 'Deevu Street', 1, 1, 0, '2018-10-26 15:42:31', NULL),
(21, 'Driver Colony', 1, 1, 0, '2018-10-26 16:00:52', NULL),
(22, 'Earal', 1, 1, 0, '2018-10-26 16:01:09', NULL),
(23, 'Esaki Amman Kovil St', 1, 1, 0, '2018-10-26 16:02:31', NULL),
(24, 'Garden', 1, 1, 0, '2018-10-26 16:02:55', NULL),
(25, 'Haji Appa Thaika St', 1, 1, 0, '2018-10-26 16:03:43', NULL),
(26, 'HAT Street', 1, 1, 0, '2018-10-26 16:04:04', NULL),
(27, 'Javiya', 1, 1, 0, '2018-10-26 16:04:40', NULL),
(28, 'Kaatuthaika Street', 1, 1, 0, '2018-10-26 16:05:42', NULL),
(29, 'Kadaipalli Street', 1, 1, 0, '2018-10-26 16:06:08', NULL),
(30, 'Kayalpatnam', 1, 1, 0, '2018-10-26 16:08:00', NULL),
(31, 'Keela Nainar Street', 1, 1, 0, '2018-10-26 16:08:27', NULL),
(32, 'Keelakarai', 1, 1, 0, '2018-10-26 16:09:21', NULL),
(33, 'Keezha Sittan St KPM', 1, 1, 0, '2018-10-26 16:10:28', NULL),
(34, 'KMK St.', 1, 1, 0, '2018-10-26 16:11:01', NULL),
(35, 'KMT Nagar', 1, 1, 0, '2018-10-26 16:11:17', NULL),
(36, 'Kochiyar St', 1, 1, 0, '2018-10-26 16:12:07', NULL),
(37, 'Kolakadai Bazar', 1, 1, 0, '2018-10-26 16:12:35', NULL),
(38, 'Koman Middle St', 1, 1, 0, '2018-10-26 16:13:12', NULL),
(39, 'KTM Street', 1, 1, 0, '2018-10-26 16:13:51', NULL),
(40, 'Kuruvi Thurai Palli', 1, 1, 0, '2018-10-26 16:14:32', NULL),
(41, 'Kuthukal Street', 1, 1, 0, '2018-10-26 16:14:58', NULL),
(42, 'LF Road Street', 1, 1, 0, '2018-10-26 16:15:19', NULL),
(43, 'Maatukulam', 1, 1, 0, '2018-10-26 16:15:46', NULL),
(44, 'Mahalra Nagar', 1, 1, 0, '2018-10-26 16:21:49', NULL),
(45, 'Main Road KPM', 1, 1, 0, '2018-10-26 16:22:53', NULL),
(46, 'Mangalavadi', 1, 1, 0, '2018-10-26 16:23:47', NULL),
(47, 'Mohudhoom Street', 1, 1, 0, '2018-10-26 16:28:21', '2018-10-26 16:28:41'),
(48, 'Muthuraman Street', 1, 1, 0, '2018-10-26 16:29:48', NULL),
(49, 'Nainar Street', 1, 1, 0, '2018-10-26 16:30:29', NULL),
(50, 'Nesavu Street', 1, 1, 0, '2018-10-26 16:31:00', NULL),
(51, 'New Bazar Street', 1, 1, 0, '2018-10-26 16:31:25', NULL),
(52, 'Odakarai', 1, 1, 0, '2018-10-26 16:31:46', NULL),
(53, 'Panchayat Road', 1, 1, 0, '2018-10-26 16:33:07', NULL),
(54, 'Periya Nesavu Street', 1, 1, 0, '2018-10-26 16:33:26', NULL),
(55, 'Pudukadai', 1, 1, 0, '2018-10-26 16:33:52', NULL),
(56, 'QMN Street', 1, 1, 0, '2018-10-26 16:34:13', '2018-10-26 16:36:14'),
(57, 'QMN 1st Street', 1, 1, 0, '2018-10-26 16:34:31', NULL),
(58, 'QMN 6th Street', 1, 1, 0, '2018-10-26 16:34:59', NULL),
(59, 'Rathinapuri', 1, 1, 0, '2018-10-26 16:36:38', NULL),
(60, 'Rathnapuri Kayalpatnam', 1, 1, 0, '2018-10-26 16:37:01', NULL),
(61, 'Sadukai Street', 1, 1, 0, '2018-10-26 16:37:33', '2018-10-26 16:43:21'),
(62, 'Santhanamari Amman Kovil Street', 1, 1, 0, '2018-10-26 16:38:01', NULL),
(63, 'Seethakathi Nagar', 1, 1, 0, '2018-10-26 16:38:20', NULL),
(64, 'Sittan Street', 1, 1, 0, '2018-10-26 16:40:03', NULL),
(65, 'Sulaiman Nagar', 1, 1, 0, '2018-10-26 16:40:33', NULL),
(66, 'Thaika Street', 1, 1, 0, '2018-10-26 16:40:55', NULL),
(67, 'Thevu Street', 1, 1, 1, '2018-10-26 16:41:13', NULL),
(68, 'V.Patnam', 1, 1, 0, '2018-10-26 16:41:34', NULL),
(77, '1st Street', 2, 1, 0, '2019-02-14 11:17:48', '2019-06-19 10:33:35'),
(78, '2nd Street', 2, 1, 0, '2019-02-14 11:18:01', '2019-06-14 08:54:18'),
(80, '3rd Street', 2, 1, 0, '2019-02-14 11:19:03', '2019-06-14 07:58:27'),
(83, 'South Street', 2, 1, 0, '2019-02-16 09:55:25', '2019-02-20 14:29:31'),
(90, 'test-kayal', 1, 1, 0, '2019-02-26 18:55:02', NULL),
(91, 'Test-Others', 2, 1, 1, '2019-02-26 18:55:18', '2019-07-02 10:23:17'),
(93, 'north-street', 2, 1, 1, '2019-03-06 11:05:12', '2019-05-14 17:04:29'),
(94, 'North-East', 2, 0, 1, '2019-05-14 17:01:21', '2019-06-19 09:56:47'),
(95, 'North-street', 1, 0, 1, '2019-06-03 09:12:35', '2019-06-13 11:33:58'),
(96, 'Test-kayal', 1, 1, 1, '2019-06-03 12:31:00', '2019-06-03 12:31:19'),
(97, '$$$', 1, 1, 1, '2019-06-11 08:48:16', NULL),
(98, 'North-street', 2, 1, 1, '2019-06-11 08:58:33', NULL),
(99, '1st Street ', 1, 1, 0, '2019-06-18 12:33:55', '2019-07-04 10:12:15'),
(100, 'North-East', 1, 1, 1, '2019-06-19 05:07:25', NULL),
(101, 'test', 1, 1, 0, '2019-07-02 10:21:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `eve_users`
--

CREATE TABLE `eve_users` (
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
-- Dumping data for table `eve_users`
--

INSERT INTO `eve_users` (`id`, `user_id`, `firstname`, `lastname`, `username`, `password`, `dob`, `email_address`, `gender`, `mobile_number`, `address`, `company_name`, `profile_image`, `user_location`, `latitude`, `longitude`, `user_type_id`, `status`, `is_deleted`, `created_date`, `updated_date`) VALUES
(1, 'USER-0001', 'admin', 'event', 'admin', '81dc9bdb52d04dc20036dbd8313ed055', '2011-01-06', 'admin@gmail.com', '', '9888489779', 'cbe', '', 'http://demo.f2fsolutions.co.in/events_v2/attachments/profile_image/PI_016686787.png', '', '', '', 1, 1, 0, '2019-06-18 18:05:51', '2020-08-31 05:09:40'),
(2, 'USER-0002', 'accounts', 'event', 'accounts', 'fcea920f7412b5da7be0cf42b8c93759', '1990-06-08', 'accounts@gmail.com', '', '9877878787', '', '', NULL, '', '', '', 1, 0, 0, '2019-06-18 18:08:12', '2019-06-27 06:22:23'),
(3, 'USER-0003', 'test', 'k', 'test', '50877d309d8fe55830bb76ec84eaaec4', '2010-06-04', 'test@gmail.com', '', '9898779444', '', '', NULL, '', '', '', 2, 1, 0, '2019-06-18 18:10:46', '2020-07-07 13:27:24'),
(4, 'USER-0004', 'Gogul', 'f2f', 'Goguf2f', 'e10adc3949ba59abbe56e057f20f883e', '1993-01-15', 'gogulbui2k19@gmail.com', '', '9626315874', '', '', NULL, NULL, NULL, NULL, 1, 1, 1, '2019-06-18 18:21:00', '2019-06-19 04:03:38'),
(5, 'USER-0005', 'Shakshi', 'Tanwar', 'Shakshi', 'e10adc3949ba59abbe56e057f20f883e', '1994-06-15', 'shakshi@gmail.com', '', '9626315876', '', '', NULL, '', '', '', 1, 1, 0, '2019-06-19 09:46:52', '2019-06-20 10:53:11'),
(6, 'USER-0006', 'Kalai', 'T', 'kalai', 'e10adc3949ba59abbe56e057f20f883e', '2010-07-08', 'f2ftesting@gmail.com', '', '9789416199', 'test', '', NULL, '', '', '', 1, 1, 0, '2019-07-02 15:54:55', '2019-08-19 04:58:32'),
(7, 'USER-0007', 'Kalai Mem', 'Raj', 'kalai_mem', 'e10adc3949ba59abbe56e057f20f883e', '2010-07-07', 'kalaimem@gmail.com', '', '9789526299', 'test', '', NULL, '', '', '', 2, 1, 1, '2019-07-02 15:56:59', '2019-07-02 10:27:26'),
(8, 'USER-0008', 'Kuldeep', 'yadav', 'kuldeep', 'e10adc3949ba59abbe56e057f20f883e', '1993-07-08', 'Kuldeepyadav@gmail.com', '', '8696524152', '', '', NULL, '', '', '', 1, 1, 0, '2019-07-04 10:11:16', '2019-07-04 04:44:07');

-- --------------------------------------------------------

--
-- Table structure for table `eve_user_modules`
--

CREATE TABLE `eve_user_modules` (
  `id` int(11) NOT NULL,
  `user_module_name` varchar(100) NOT NULL,
  `user_module_key` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `eve_user_modules`
--

INSERT INTO `eve_user_modules` (`id`, `user_module_name`, `user_module_key`, `status`, `created_date`, `updated_date`) VALUES
(1, 'Dashboard', 'dashboard', 1, '2017-08-04 18:37:39', NULL),
(2, 'Masters', 'masters', 1, '2017-08-04 18:37:39', NULL),
(3, 'Users', 'users', 1, '2017-08-04 18:37:39', NULL),
(4, 'Members', 'members', 1, '2018-10-31 12:37:40', NULL),
(5, 'Events', 'events', 1, '2018-10-31 12:40:57', NULL),
(6, 'Site CMS', 'site_cms', 1, '2017-08-04 18:37:39', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `eve_user_sections`
--

CREATE TABLE `eve_user_sections` (
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
-- Dumping data for table `eve_user_sections`
--

INSERT INTO `eve_user_sections` (`id`, `module_id`, `user_section_name`, `user_section_key`, `acc_view`, `acc_add`, `acc_edit`, `acc_delete`, `status`, `created_date`, `updated_date`) VALUES
(1, 1, 'Dashboard', 'dashboard', 1, 0, 0, 0, 1, '2017-08-04 19:13:30', NULL),
(2, 2, 'Manage Streets', 'streets', 1, 1, 1, 1, 1, '2017-08-04 19:13:30', NULL),
(3, 3, 'Manage Users', 'users', 1, 1, 1, 1, 1, '2017-08-04 19:13:31', NULL),
(4, 3, 'Manage User Types', 'user_types', 1, 1, 1, 1, 1, '2017-08-04 19:13:31', NULL),
(5, 3, 'Manage User Modules', 'user_modules', 1, 1, 1, 1, 1, '2017-08-04 19:13:31', NULL),
(6, 3, 'Manage User Sections', 'user_sections', 1, 1, 1, 1, 1, '2017-08-04 19:13:31', NULL),
(7, 4, 'Manage Members', 'members', 1, 1, 1, 1, 1, '2018-10-31 12:38:26', NULL),
(8, 4, 'Manage Groups', 'groups', 1, 1, 1, 1, 1, '2018-10-31 12:38:51', NULL),
(9, 5, 'Manage Events', 'events', 1, 1, 1, 1, 1, '2018-10-31 12:41:47', NULL),
(10, 5, 'Manage Event Types', 'event_types', 1, 1, 1, 1, 1, '2018-10-31 12:42:37', NULL),
(11, 6, 'Manage Contacts', 'contacts', 1, 1, 1, 1, 1, '2018-12-10 13:09:35', NULL),
(12, 6, 'Manage Pricing and Plans', 'pricing', 1, 1, 1, 1, 1, '2018-12-10 13:10:39', NULL),
(13, 2, 'General Settings', 'setting', 1, 1, 1, 1, 1, '2019-06-27 17:12:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `eve_user_types`
--

CREATE TABLE `eve_user_types` (
  `id` int(11) NOT NULL,
  `user_type_name` varchar(50) NOT NULL,
  `grand_all` int(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1-deleted,0-not deleted',
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `eve_user_types`
--

INSERT INTO `eve_user_types` (`id`, `user_type_name`, `grand_all`, `status`, `is_deleted`, `created_date`, `updated_date`) VALUES
(1, 'Admin', 1, 1, 0, '2017-01-25 13:47:25', '2019-10-10 10:29:58'),
(2, 'Member', 0, 1, 0, '2017-04-20 16:04:36', '2019-06-27 06:18:27'),
(10, 'teds', 0, 1, 1, '2019-06-13 11:12:23', NULL),
(11, 'admin2', 0, 1, 1, '2019-06-14 12:20:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `eve_user_type_permissions`
--

CREATE TABLE `eve_user_type_permissions` (
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
-- Dumping data for table `eve_user_type_permissions`
--

INSERT INTO `eve_user_type_permissions` (`id`, `user_type_id`, `module_id`, `section_id`, `acc_all`, `acc_view`, `acc_add`, `acc_edit`, `acc_delete`, `created_date`, `updated_date`) VALUES
(129, 4, 1, 1, 1, 1, 0, 0, 0, '2019-06-03 04:51:15', NULL),
(130, 4, 2, 2, 1, 1, 1, 1, 1, '2019-06-03 04:51:15', NULL),
(131, 4, 3, 3, 1, 1, 1, 1, 1, '2019-06-03 04:51:15', NULL),
(132, 4, 3, 4, 1, 1, 1, 1, 1, '2019-06-03 04:51:15', NULL),
(133, 4, 4, 7, 1, 1, 1, 1, 1, '2019-06-03 04:51:15', NULL),
(134, 4, 4, 8, 1, 1, 1, 1, 1, '2019-06-03 04:51:15', NULL),
(135, 4, 5, 9, 1, 1, 1, 1, 1, '2019-06-03 04:51:15', NULL),
(136, 4, 5, 10, 1, 1, 1, 1, 1, '2019-06-03 04:51:15', NULL),
(137, 4, 6, 11, 1, 1, 1, 1, 1, '2019-06-03 04:51:15', NULL),
(138, 4, 6, 12, 1, 1, 1, 1, 1, '2019-06-03 04:51:15', NULL),
(141, 2, 1, 1, 1, 1, 0, 0, 0, '2019-06-27 06:18:27', NULL),
(142, 2, 4, 7, 1, 1, 1, 1, 1, '2019-06-27 06:18:27', NULL),
(143, 2, 5, 9, 1, 1, 1, 1, 1, '2019-06-27 06:18:27', NULL),
(144, 1, 1, 1, 1, 1, 0, 0, 0, '2019-06-27 06:18:40', NULL),
(145, 1, 2, 2, 1, 1, 1, 1, 1, '2019-06-27 06:18:40', NULL),
(146, 1, 3, 3, 1, 1, 1, 1, 1, '2019-06-27 06:18:40', NULL),
(147, 1, 3, 4, 1, 1, 1, 1, 1, '2019-06-27 06:18:40', NULL),
(148, 1, 4, 7, 1, 1, 1, 1, 1, '2019-06-27 06:18:40', NULL),
(149, 1, 4, 8, 1, 1, 1, 1, 1, '2019-06-27 06:18:40', NULL),
(150, 1, 5, 9, 1, 1, 1, 1, 1, '2019-06-27 06:18:40', NULL),
(151, 1, 5, 10, 1, 1, 1, 1, 1, '2019-06-27 06:18:40', NULL),
(152, 1, 6, 11, 1, 1, 1, 1, 1, '2019-06-27 06:18:40', NULL),
(153, 1, 6, 12, 1, 1, 1, 1, 1, '2019-06-27 06:18:40', NULL),
(155, 1, 2, 13, 1, 1, 1, 1, 1, '2019-06-27 17:13:18', NULL);

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
-- Indexes for table `eve_contacts`
--
ALTER TABLE `eve_contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `eve_events`
--
ALTER TABLE `eve_events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `eve_event_actions`
--
ALTER TABLE `eve_event_actions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `eve_event_dynamic_values`
--
ALTER TABLE `eve_event_dynamic_values`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `eve_event_invitations`
--
ALTER TABLE `eve_event_invitations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `eve_event_invited_members`
--
ALTER TABLE `eve_event_invited_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `eve_event_types`
--
ALTER TABLE `eve_event_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `eve_event_type_dynamic_fields`
--
ALTER TABLE `eve_event_type_dynamic_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `eve_features`
--
ALTER TABLE `eve_features`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `eve_general_setting`
--
ALTER TABLE `eve_general_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `eve_groups`
--
ALTER TABLE `eve_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `eve_increment`
--
ALTER TABLE `eve_increment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `eve_members`
--
ALTER TABLE `eve_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `eve_member_location`
--
ALTER TABLE `eve_member_location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `eve_pricing`
--
ALTER TABLE `eve_pricing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `eve_relation`
--
ALTER TABLE `eve_relation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `eve_streets`
--
ALTER TABLE `eve_streets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `eve_users`
--
ALTER TABLE `eve_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `eve_user_modules`
--
ALTER TABLE `eve_user_modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `eve_user_sections`
--
ALTER TABLE `eve_user_sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `eve_user_types`
--
ALTER TABLE `eve_user_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `eve_user_type_permissions`
--
ALTER TABLE `eve_user_type_permissions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `eve_contacts`
--
ALTER TABLE `eve_contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `eve_events`
--
ALTER TABLE `eve_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `eve_event_actions`
--
ALTER TABLE `eve_event_actions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `eve_event_dynamic_values`
--
ALTER TABLE `eve_event_dynamic_values`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `eve_event_invitations`
--
ALTER TABLE `eve_event_invitations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `eve_event_invited_members`
--
ALTER TABLE `eve_event_invited_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `eve_event_types`
--
ALTER TABLE `eve_event_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `eve_event_type_dynamic_fields`
--
ALTER TABLE `eve_event_type_dynamic_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `eve_features`
--
ALTER TABLE `eve_features`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `eve_general_setting`
--
ALTER TABLE `eve_general_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `eve_groups`
--
ALTER TABLE `eve_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `eve_increment`
--
ALTER TABLE `eve_increment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `eve_members`
--
ALTER TABLE `eve_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `eve_member_location`
--
ALTER TABLE `eve_member_location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `eve_pricing`
--
ALTER TABLE `eve_pricing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `eve_relation`
--
ALTER TABLE `eve_relation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `eve_streets`
--
ALTER TABLE `eve_streets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `eve_users`
--
ALTER TABLE `eve_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `eve_user_modules`
--
ALTER TABLE `eve_user_modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `eve_user_sections`
--
ALTER TABLE `eve_user_sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `eve_user_types`
--
ALTER TABLE `eve_user_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `eve_user_type_permissions`
--
ALTER TABLE `eve_user_type_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
