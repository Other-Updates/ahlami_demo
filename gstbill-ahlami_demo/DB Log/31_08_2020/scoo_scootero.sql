-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 31, 2020 at 02:46 PM
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
-- Table structure for table `scoo_scootero`
--

CREATE TABLE `scoo_scootero` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `number` varchar(50) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `is_deleted` int(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `scoo_scootero`
--

INSERT INTO `scoo_scootero` (`id`, `name`, `number`, `status`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'ScooterO11', 'M100', 1, 0, '2020-08-31 12:14:46', '2020-08-31 12:14:46'),
(2, 'ScooterO12', 'M109', 1, 0, '2020-08-31 12:18:42', '2020-08-31 12:18:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `scoo_scootero`
--
ALTER TABLE `scoo_scootero`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `scoo_scootero`
--
ALTER TABLE `scoo_scootero`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
