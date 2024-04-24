-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2024 at 06:39 AM
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
-- Database: `shop_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `exp`
--

CREATE TABLE `exp` (
  `id` int(100) NOT NULL,
  `date` date NOT NULL,
  `category` text NOT NULL,
  `amount` int(30) NOT NULL,
  `pay_method` text NOT NULL,
  `pic` text NOT NULL,
  `dept` text NOT NULL,
  `invoice_num` varchar(100) NOT NULL,
  `approval` text NOT NULL,
  `tax_inf` varchar(100) NOT NULL,
  `notes` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exp`
--

INSERT INTO `exp` (`id`, `date`, `category`, `amount`, `pay_method`, `pic`, `dept`, `invoice_num`, `approval`, `tax_inf`, `notes`) VALUES
(1, '0000-00-00', ' Raw material', 7000, 'Cash', 'Dhea', 'Procurement', '123', 'Pending', '-', '0'),
(2, '2004-01-11', ' Raw material', 7000, 'Cash', 'Dhea', 'Procurement', '123', 'Pending', '123', 'abc');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `exp`
--
ALTER TABLE `exp`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `exp`
--
ALTER TABLE `exp`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
