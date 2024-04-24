-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 24, 2024 at 10:05 AM
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
-- Database: `poms1`
--

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `id` int(10) NOT NULL,
  `po_number` varchar(20) NOT NULL,
  `supplier` varchar(30) NOT NULL,
  `employee` varchar(20) NOT NULL,
  `payment_date` varchar(20) NOT NULL,
  `payment_method` varchar(20) NOT NULL,
  `recipient_bank` varchar(50) NOT NULL,
  `currency` varchar(10) NOT NULL,
  `amount` int(20) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`id`, `po_number`, `supplier`, `employee`, `payment_date`, `payment_method`, `recipient_bank`, `currency`, `amount`, `status`) VALUES
(13, 'PO0000000001', 'PT. Supplier 02', 'Sheren', '2024-04-24', 'Bank', '8392 7643 0922 - Mandiri', 'IDR', 771150, 'Paid'),
(14, 'PO0000000002', 'PT. Supplier 01', 'Eva', '2024-04-24', 'Bank', '8392 7643 0922 - Mandiri', 'IDR', 1019200, 'Paid');

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` bigint(20) NOT NULL,
  `status` varchar(11) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`id`, `name`, `description`, `price`, `status`, `date_created`) VALUES
(4, 'Lamp', 'White lamp', 5000, 'Active', '2024-04-23 20:37:08'),
(5, 'Chair', 'A white chair', 500000, 'Active', '2024-04-23 23:36:07');

-- --------------------------------------------------------

--
-- Table structure for table `item_po`
--

CREATE TABLE `item_po` (
  `id` int(11) NOT NULL,
  `po_number` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `item` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` bigint(20) NOT NULL,
  `total` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item_po`
--

INSERT INTO `item_po` (`id`, `po_number`, `qty`, `unit`, `item`, `description`, `price`, `total`) VALUES
(13, 'PO0000000004', 3, 'pcs', 'Lamp', 'White lamp', 5000, 15000),
(14, 'PO0000000005', 6, 'pcs', 'Chair', 'A white chair', 500000, 3000000),
(15, 'PO0000000005', 7, 'pcs', 'Lamp', 'White lamp', 5000, 35000),
(16, 'PO0000000006', 6, 'pcs', 'Lamp', 'White lamp', 5000, 30000);

-- --------------------------------------------------------

--
-- Table structure for table `po`
--

CREATE TABLE `po` (
  `id` int(11) NOT NULL,
  `po_number` varchar(255) NOT NULL,
  `supplier` varchar(255) NOT NULL,
  `status` varchar(10) NOT NULL,
  `subTotal` bigint(20) NOT NULL,
  `percentDiscount` int(11) NOT NULL,
  `priceDiscount` bigint(20) NOT NULL,
  `percentTaxInclusive` int(11) NOT NULL,
  `priceTaxInclusive` bigint(20) NOT NULL,
  `totalAll` bigint(20) NOT NULL,
  `note` text NOT NULL,
  `date_created` datetime NOT NULL,
  `created_by` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `po`
--

INSERT INTO `po` (`id`, `po_number`, `supplier`, `status`, `subTotal`, `percentDiscount`, `priceDiscount`, `percentTaxInclusive`, `priceTaxInclusive`, `totalAll`, `note`, `date_created`, `created_by`) VALUES
(10, 'PO0000000004', 'WITS', 'Approved', 15000, 0, 0, 0, 0, 15000, '', '2024-04-24 00:59:53', 'Felicia Evangelica'),
(11, 'PO0000000005', 'WITS', 'Approved', 3035000, 0, 0, 0, 0, 3035000, '', '2024-04-24 01:02:03', 'Felicia Evangelica'),
(12, 'PO0000000006', 'WITS', 'Approved', 30000, 0, 0, 0, 0, 30000, '', '2024-04-24 01:03:30', 'Emelyn Hadasa');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `cp` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `status` varchar(11) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `name`, `cp`, `phone`, `address`, `status`, `date_created`) VALUES
(4, 'WITS', 'Luis', '0862727272', 'Dan Mogot', 'Active', '2024-04-23 20:36:23');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `last_login` datetime NOT NULL,
  `role` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `username`, `password`, `last_login`, `role`, `date_added`, `date_updated`) VALUES
(4, 'Sheren Yang', 'sheren', '$2y$10$WQgfQ0w9ZdZkFWGqwq9h.u7HHrdEGhe88rhHHMN2EPbCDg0oUnPcO', '2024-04-24 00:37:35', 2, '2024-04-23 16:40:33', '0000-00-00 00:00:00'),
(5, 'Emelyn Hadasa', 'emel', '$2y$10$a27oStrQD87ovXL6r9NVZe8eG9622cQXS0yruDYF2AlVihICSE8f.', '2024-04-24 01:03:06', 1, '2024-04-23 20:13:13', '0000-00-00 00:00:00'),
(6, 'Felicia Evangelica', 'eva', '$2y$10$um9i4lTuLNoRmqcMpN9qAOR2bGPv4huiUGitBJM9VForEtlwZvdJW', '2024-04-24 00:34:35', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 'Luis Darmawan', 'luis', '$2y$10$OyB5SubHI3x9MuyX6.qXieVD.WdZAFdPAMq/2dlLWgCmGvvCkTI5m', '2024-04-24 00:34:00', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_po`
--
ALTER TABLE `item_po`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `po`
--
ALTER TABLE `po`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `item_po`
--
ALTER TABLE `item_po`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `po`
--
ALTER TABLE `po`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
