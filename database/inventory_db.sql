-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 23, 2025 at 10:08 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblcart`
--

CREATE TABLE `tblcart` (
  `id` int NOT NULL,
  `invoiceno` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(20,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;

--
-- Dumping data for table `tblcart`
--

INSERT INTO `tblcart` (`id`, `invoiceno`, `user_id`, `product_id`, `quantity`, `price`) VALUES
(203, '20250518P865420', 2, 6, 3, '200.00'),
(204, '20250518P865420', 2, 14, 2, '200.00'),
(205, '20250518P865420', 2, 8, 1, '1500.00'),
(206, '20250518P865420', 2, 2, 1, '300.00'),
(207, '20250518P865420', 2, 11, 1, '300.00'),
(208, '20250518Y54217', 2, 6, 3, '200.00'),
(209, '20250518Y54217', 2, 9, 3, '200.00'),
(210, '20250518Y54217', 2, 14, 4, '200.00'),
(211, '20250518Y54217', 2, 8, 2, '1500.00'),
(212, '20250518Y54217', 2, 11, 2, '300.00'),
(213, '20250518Y54217', 2, 2, 2, '300.00'),
(214, '20250518Z750', 2, 7, 1, '300.00'),
(215, '20250518Z750', 2, 10, 2, '300.00'),
(216, '20250518Z750', 2, 14, 1, '200.00'),
(217, '20250620T198673', 2, 3, 1, '400.00'),
(218, '20250620T198673', 2, 2, 1, '300.00'),
(219, '20250620T198673', 2, 14, 3, '200.00'),
(220, '20250620T198673', 2, 6, 3, '200.00'),
(221, '20250620T198673', 2, 11, 1, '300.00'),
(222, '20250620T198673', 2, 15, 1, '2000.00'),
(223, '20250620T198673', 2, 7, 1, '300.00'),
(224, '20250620T198673', 2, 5, 1, '400.00');

-- --------------------------------------------------------

--
-- Table structure for table `tblcategory`
--

CREATE TABLE `tblcategory` (
  `cat_id` bigint NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;

--
-- Dumping data for table `tblcategory`
--

INSERT INTO `tblcategory` (`cat_id`, `name`, `created_date`, `updated_date`) VALUES
(1, 'soft drinks', '2025-05-18 17:52:02', NULL),
(2, 'foreign dish', '2025-05-18 17:52:21', NULL),
(3, 'local dish', '2025-05-18 17:52:32', NULL),
(4, 'beers', '2025-05-18 17:52:44', NULL),
(5, 'others', '2025-05-18 17:52:55', NULL),
(6, 'snacks', '2025-05-18 17:53:06', NULL),
(7, 'bbq', '2025-05-18 17:53:18', NULL),
(8, 'water', '2025-05-18 17:54:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblexpense`
--

CREATE TABLE `tblexpense` (
  `expense_id` int NOT NULL,
  `title` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblpayment`
--

CREATE TABLE `tblpayment` (
  `id` bigint NOT NULL,
  `invoiceno` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `total` decimal(20,2) NOT NULL,
  `paytype` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `payment_status` int NOT NULL,
  `amount_paid` decimal(20,2) NOT NULL,
  `_change` decimal(20,2) NOT NULL,
  `date_paid` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;

--
-- Dumping data for table `tblpayment`
--

INSERT INTO `tblpayment` (`id`, `invoiceno`, `total`, `paytype`, `payment_status`, `amount_paid`, `_change`, `date_paid`) VALUES
(1, '20250518P865420', '3100.00', 'card', 1, '3500.00', '400.00', '2025-05-18 18:25:15'),
(3, '20250518Y54217', '6200.00', 'card', 1, '7000.00', '800.00', '2025-05-18 18:42:25'),
(4, '20250518Z750', '1100.00', 'cash', 1, '1500.00', '400.00', '2025-05-18 18:45:34'),
(5, '20250620T198673', '4900.00', 'cash', 1, '5000.00', '100.00', '2025-06-20 14:01:53');

-- --------------------------------------------------------

--
-- Table structure for table `tblproduct`
--

CREATE TABLE `tblproduct` (
  `product_id` bigint NOT NULL,
  `product_code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `product_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `barcode` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `supplier_id` int NOT NULL,
  `category_id` int NOT NULL,
  `buying_price` decimal(20,2) NOT NULL,
  `selling_price` decimal(20,2) NOT NULL,
  `quantity` int NOT NULL,
  `unit` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `product_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `reorder_level` int NOT NULL,
  `status` int NOT NULL,
  `description` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci,
  `manufacture_date` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci DEFAULT NULL,
  `expiry_date` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;

--
-- Dumping data for table `tblproduct`
--

INSERT INTO `tblproduct` (`product_id`, `product_code`, `product_name`, `barcode`, `supplier_id`, `category_id`, `buying_price`, `selling_price`, `quantity`, `unit`, `product_image`, `reorder_level`, `status`, `description`, `manufacture_date`, `expiry_date`, `created_date`, `updated_date`) VALUES
(1, 'A84162', 'coca cola bottle', '6346734764376', 1, 1, '150.00', '200.00', 40, 'piece', 'PRO20250518558633CA.jpg', 10, 1, '&lt;p&gt;N/A&lt;/p&gt;', '2025-05-05', '2025-06-07', '2025-05-18 17:55:38', '2025-05-18 18:24:05'),
(2, 'U621805', 'coca cola can', '8843934948493', 1, 1, '300.00', '300.00', 46, 'unit', 'PRO2025051856E3B092.png', 10, 1, '&lt;p&gt;N/A&lt;/p&gt;', '2025-05-01', '2025-06-09', '2025-05-18 17:56:51', '2025-06-23 09:17:10'),
(3, 'E05348', 'coca cola plastic', '7263989438973', 1, 1, '300.00', '400.00', 49, 'unit', 'PRO2025051859E12D6F.jpg', 10, 1, '&lt;p&gt;N/A&lt;/p&gt;', '', '', '2025-05-18 17:59:11', '2025-06-20 13:55:49'),
(4, 'P2503', 'fried rice', '3647634784384', 1, 3, '300.00', '300.00', 100, 'size', 'PRO2025051800870CB9.jpg', 20, 1, '&lt;p&gt;N/A&lt;/p&gt;', '', '', '2025-05-18 18:00:25', NULL),
(5, 'J639570', 'pepsi can', '5366666666666', 1, 1, '350.00', '400.00', 49, 'piece', 'PRO20250518014F793C.jpg', 10, 1, '&lt;p&gt;N/A&lt;/p&gt;', '', '', '2025-05-18 18:01:27', '2025-06-20 13:56:48'),
(6, 'Z46807', 'eba', '3566377882398', 1, 3, '200.00', '200.00', 91, 'unit', 'PRO2025051802B71C15.jpg', 20, 1, '&lt;p&gt;N/A&lt;/p&gt;', '', '', '2025-05-18 18:02:32', '2025-06-20 13:56:21'),
(7, 'Q0734', 'pepsi plastic', '3637847348438', 1, 1, '250.00', '300.00', 98, 'unit', 'PRO2025051803E7A31A.jpg', 20, 1, '&lt;p&gt;N/A&lt;/p&gt;', '', '', '2025-05-18 18:03:39', '2025-06-20 13:56:47'),
(8, 'G5783', 'bbq chicken', '4784585849458', 1, 7, '1300.00', '1500.00', 17, 'unit', 'PRO2025051804E01C79.jpg', 15, 1, '&lt;p&gt;N/A&lt;/p&gt;', '', '', '2025-05-18 18:04:34', '2025-05-18 18:41:59'),
(9, 'H5467', 'fufu', '2352368238238', 1, 3, '200.00', '200.00', 97, 'unit', 'PRO2025051805CCC562.jpg', 10, 1, '&lt;p&gt;N/A&lt;/p&gt;', '', '', '2025-05-18 18:05:29', '2025-05-18 18:41:45'),
(10, 'M496507', 'pounded yam', '3764376437847', 1, 3, '300.00', '300.00', 98, 'unit', 'PRO20250518063BA2C6.jpg', 20, 1, '&lt;p&gt;N/A&lt;/p&gt;', '', '', '2025-05-18 18:06:28', '2025-06-20 13:56:57'),
(11, 'Q2389', 'eva water', '9373333873333', 1, 8, '250.00', '300.00', 46, 'unit', 'PRO202505180721C436.png', 10, 1, '&lt;p&gt;N/A&lt;/p&gt;', '', '', '2025-05-18 18:07:24', '2025-06-20 13:56:19'),
(12, 'V8670', 'burger', '6436747643783', 1, 6, '2500.00', '2700.00', 30, 'unit', 'PRO2025051810F8CE92.webp', 5, 1, '&lt;p&gt;N/A&lt;/p&gt;', '', '', '2025-05-18 18:10:25', NULL),
(13, 'V917846', 'hamburger', '2356362723783', 1, 6, '1500.00', '1800.00', 30, 'kg', 'PRO2025051811CEEABF.webp', 5, 1, '&lt;p&gt;N/A&lt;/p&gt;', '', '', '2025-05-18 18:11:24', NULL),
(14, 'X752063', 'efo riro', '0823777777777', 1, 3, '200.00', '200.00', 90, 'unit', 'PRO20250518138E70D0.jpeg', 20, 1, '&lt;p&gt;N/A&lt;/p&gt;', '', '', '2025-05-18 18:13:10', '2025-06-20 13:56:00'),
(15, 'F4351', 'amala and ewedu', '7478575785785', 1, 3, '1800.00', '2000.00', 49, 'pack', 'PRO2025051814D24FE5.jpg', 10, 1, '&lt;p&gt;N/A&lt;/p&gt;', '', '', '2025-05-18 18:14:26', '2025-06-20 13:56:40'),
(16, 'O259', 'special toast bread', '3434747478478', 1, 6, '1300.00', '1300.00', 30, 'unit', 'PRO202505181500B437.webp', 5, 1, '&lt;p&gt;N/A&lt;/p&gt;', '', '', '2025-05-18 18:15:43', NULL),
(17, 'I185497', 'jollof rice', '6436347634734', 1, 3, '300.00', '300.00', 50, 'unit', 'PRO2025051816B28005.jpg', 5, 1, '&lt;p&gt;N/A&lt;/p&gt;', '', '', '2025-05-18 18:16:56', NULL),
(18, 'N965342', 'shawarma one hot dog', '4534563897486', 1, 6, '2500.00', '2500.00', 20, 'kg', 'PRO202505181875C862.jpg', 4, 1, '&lt;p&gt;N/A&lt;/p&gt;', '', '', '2025-05-18 18:18:06', NULL),
(19, 'H205', 'jollof spag', '3451282937374', 1, 3, '1500.00', '1500.00', 30, 'unit', 'PRO2025051819075B66.jpg', 4, 1, '&lt;p&gt;N/A&lt;/p&gt;', '', '', '2025-05-18 18:19:05', NULL),
(20, 'O032965', 'white spag', '6435437634734', 1, 3, '1500.00', '2000.00', 30, 'unit', 'PRO202505183952B2EF.webp', 5, 1, '&lt;p&gt;N/A&lt;/p&gt;', '', '', '2025-05-18 18:39:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblsettings`
--

CREATE TABLE `tblsettings` (
  `name` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci DEFAULT NULL,
  `phone` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci DEFAULT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci DEFAULT NULL,
  `address` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci,
  `motto` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;

--
-- Dumping data for table `tblsettings`
--

INSERT INTO `tblsettings` (`name`, `phone`, `email`, `address`, `motto`) VALUES
('temidayo mini store', '08090949669', 'afolabi8120@gmail.com', 'Lagos State', 'lower prices always');

-- --------------------------------------------------------

--
-- Table structure for table `tblstockadjustment`
--

CREATE TABLE `tblstockadjustment` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `action` int NOT NULL,
  `reasons` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `adjusted_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblsupplier`
--

CREATE TABLE `tblsupplier` (
  `supplier_id` int NOT NULL,
  `fullname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `phone` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;

--
-- Dumping data for table `tblsupplier`
--

INSERT INTO `tblsupplier` (`supplier_id`, `fullname`, `email`, `phone`, `address`, `created_date`, `updated_date`) VALUES
(1, 'james temitope ema', 'james@gmail.com', '08090949669', 'No 5 Ayinke Agbetoba Street', '2023-11-10 17:48:53', '2023-11-10 17:56:28');

-- --------------------------------------------------------

--
-- Table structure for table `tbluser`
--

CREATE TABLE `tbluser` (
  `user_id` int NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `fullname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `phone` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `usertype` enum('a','u') CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;

--
-- Dumping data for table `tbluser`
--

INSERT INTO `tbluser` (`user_id`, `username`, `fullname`, `email`, `phone`, `password`, `usertype`, `created_date`, `updated_date`) VALUES
(1, 'afolabi', 'afolabi temidayo timothy', 'afolabi8120@gmail.com', '08090949669', '$2y$10$AWQsdjqR556PvKb8G4dMAuLJsIzIqTxvsPqUKyoFeL2V.JWkXZ0sG', 'a', '2023-11-10 16:48:17', '2023-11-14 16:59:43'),
(2, 'albert', 'albert faith segun', 'albert@gmail.com', '08090949660', '$2y$10$AWQsdjqR556PvKb8G4dMAuLJsIzIqTxvsPqUKyoFeL2V.JWkXZ0sG', 'u', '2023-11-10 16:48:45', '2025-05-14 20:31:06'),
(3, 'elonx', 'elon musk', 'elon.musk@spacex.com', '14470917282', '$2y$10$7.rD7G0L.tq8DKkSYEsYwuUvUvqQzAQvVwtMeJSilApxDxA4oCT4.', 'u', '2023-11-10 17:22:39', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblcart`
--
ALTER TABLE `tblcart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblcategory`
--
ALTER TABLE `tblcategory`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `tblexpense`
--
ALTER TABLE `tblexpense`
  ADD PRIMARY KEY (`expense_id`);

--
-- Indexes for table `tblpayment`
--
ALTER TABLE `tblpayment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblproduct`
--
ALTER TABLE `tblproduct`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `tblstockadjustment`
--
ALTER TABLE `tblstockadjustment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblsupplier`
--
ALTER TABLE `tblsupplier`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `tbluser`
--
ALTER TABLE `tbluser`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblcart`
--
ALTER TABLE `tblcart`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=225;

--
-- AUTO_INCREMENT for table `tblcategory`
--
ALTER TABLE `tblcategory`
  MODIFY `cat_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tblexpense`
--
ALTER TABLE `tblexpense`
  MODIFY `expense_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblpayment`
--
ALTER TABLE `tblpayment`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tblproduct`
--
ALTER TABLE `tblproduct`
  MODIFY `product_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tblstockadjustment`
--
ALTER TABLE `tblstockadjustment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tblsupplier`
--
ALTER TABLE `tblsupplier`
  MODIFY `supplier_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbluser`
--
ALTER TABLE `tbluser`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
