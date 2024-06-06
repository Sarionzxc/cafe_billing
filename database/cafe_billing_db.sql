-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 27, 2024 at 09:19 AM
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
-- Database: `cafe_billing_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `batch_lot`
--

CREATE TABLE `batch_lot` (
  `id` int(11) NOT NULL,
  `item_name` varchar(50) NOT NULL,
  `quantity` int(50) NOT NULL,
  `date_arrival` varchar(11) NOT NULL,
  `expiration_date` varchar(50) NOT NULL,
  `supplier_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `batch_lot`
--

INSERT INTO `batch_lot` (`id`, `item_name`, `quantity`, `date_arrival`, `expiration_date`, `supplier_name`) VALUES
(5, 'Espresso', 4, '2024-04-05', '2024-04-12', 'Janine Lanuza'),
(10, 'Macchiato', 20, '2024-04-09', '2024-09-01', 'Janine Lanuza'),
(14, 'Latte', 25, '2024-04-11', '2024-07-12', 'Janine Lanuza'),
(23, 'Latte V2', 20, '2024-04-12', '2024-06-20', 'Janine Lanuza'),
(24, 'Americano/Brewed', 15, '2024-04-13', '2024-05-13', 'Janine Lanuza'),
(25, 'Full cream milk', 15, '2024-04-13', '2024-04-27', 'Janine Lanuza');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(30) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`) VALUES
(4, 'Coffee', 'Iced/Hot/Frappe');

-- --------------------------------------------------------

--
-- Table structure for table `deleted_orders`
--

CREATE TABLE `deleted_orders` (
  `id` int(11) NOT NULL,
  `date_deleted` timestamp NOT NULL DEFAULT current_timestamp(),
  `ref_no` varchar(50) DEFAULT NULL,
  `order_number` varchar(50) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deleted_orders`
--

INSERT INTO `deleted_orders` (`id`, `date_deleted`, `ref_no`, `order_number`, `total_amount`) VALUES
(4, '2024-04-12 00:09:00', '466521580748', '7', 50.00),
(5, '2024-04-12 00:09:05', '356903219359', '15', 60.00),
(15, '2024-04-12 00:46:53', '470487935894', '14', 65.00),
(16, '2024-04-12 00:47:51', '323728185295', '54', 50.00),
(17, '2024-04-12 00:50:06', '918733456582', '6', 100.00),
(18, '2024-04-12 00:50:40', '852929858492', '6', 50.00),
(23, '2024-04-12 01:12:29', '209279562665', '12', 305.00),
(25, '2024-04-12 01:15:55', '538040087864', '24040424', 295.00),
(27, '2024-04-12 01:21:10', '558953549799', '11', 70.00),
(30, '2024-04-15 04:13:33', '189286800434', '28', 150.00),
(31, '2024-04-27 07:18:00', '232756563285', '80', 50.00);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `ref_no` varchar(50) NOT NULL,
  `total_amount` float NOT NULL,
  `amount_tendered` float NOT NULL,
  `order_number` int(30) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `ref_no`, `total_amount`, `amount_tendered`, `order_number`, `date_created`) VALUES
(4, '113598082200', 70, 70, 2, '2023-06-26 17:55:50'),
(5, '909018320952', 15, 20, 3, '2023-06-26 17:57:00'),
(6, '080147268588', 230, 250, 1, '2023-06-27 15:36:48'),
(8, '961293212393', 210, 220, 4, '2023-06-27 16:22:10'),
(9, '199317380378', 160, 150, 5, '2023-06-27 16:23:26'),
(11, '001726403285', 225, 225, 6, '2023-06-27 16:28:12'),
(12, '411534528225', 250, 1000, 7, '2023-06-27 16:29:09'),
(13, '372047911148', 230, 250, 8, '2023-06-27 16:34:21'),
(14, '820601596509', 175, 175, 9, '2023-06-27 16:40:28'),
(15, '874631055670', 90, 100, 10, '2023-06-27 16:43:00'),
(18, '815052522941', 100, 1000, 13, '2023-06-27 16:48:09'),
(21, '744321218257', 100, 100, 16, '2023-06-27 19:12:20'),
(23, '126675881071', 215, 215, 18, '2023-06-27 19:32:48'),
(27, '000000000000', 175, 200, 24200222, '2024-02-20 20:15:25'),
(121, '387781826321', 50, 50, 73, '2024-04-12 09:05:49'),
(127, '394536172192', 50, 50, 350, '2024-04-12 16:11:48'),
(129, '210471402654', 250, 250, 78, '2024-04-21 00:36:33'),
(130, '519632900353', 50, 50, 453, '2024-04-21 00:40:29'),
(131, '201033515208', 350, 350, 186, '2024-04-21 00:40:56'),
(132, '051223096045', 50, 50, 339, '2024-04-21 00:46:44'),
(133, '721928723273', 45, 45, 231, '2024-04-23 14:18:26'),
(134, '907207182518', 50, 50, 309, '2024-04-23 14:32:57'),
(135, '120838034001', 50, 50, 392, '2024-04-23 14:46:39'),
(136, '389945033526', 50, 50, 246, '2024-04-23 14:46:59'),
(137, '117537231375', 50, 50, 12, '2024-04-23 15:08:10'),
(138, '999566183092', 50, 50, 233, '2024-04-23 15:09:14'),
(139, '658152884146', 50, 50, 63, '2024-04-23 15:09:58'),
(140, '214540297681', 50, 50, 459, '2024-04-23 15:10:11'),
(141, '665150154480', 50, 50, 417, '2024-04-23 15:14:21'),
(142, '247943604493', 50, 50, 340, '2024-04-23 15:16:16'),
(143, '017401301501', 250, 250, 321, '2024-04-23 15:47:36'),
(144, '759092536868', 50, 50, 108, '2024-04-23 15:49:19'),
(145, '949739465368', 50, 50, 202, '2024-04-23 15:55:34'),
(146, '329752357831', 50, 50, 239, '2024-04-23 16:49:58'),
(147, '601992599858', 150, 150, 372, '2024-04-25 04:12:47');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(30) NOT NULL,
  `order_id` int(30) NOT NULL,
  `product_id` int(30) NOT NULL,
  `qty` int(30) NOT NULL,
  `price` float NOT NULL,
  `amount` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `qty`, `price`, `amount`) VALUES
(5, 3, 4, 1, 70, 70),
(6, 3, 2, 1, 15, 15),
(7, 4, 4, 1, 70, 70),
(8, 5, 2, 1, 15, 15),
(9, 6, 29, 1, 115, 115),
(10, 6, 9, 1, 50, 50),
(11, 6, 17, 1, 40, 40),
(12, 6, 23, 1, 25, 25),
(13, 7, 29, 1, 115, 115),
(14, 7, 30, 1, 115, 115),
(15, 7, 25, 1, 70, 70),
(16, 8, 9, 1, 50, 50),
(17, 8, 21, 1, 60, 60),
(18, 8, 5, 1, 50, 50),
(19, 8, 14, 1, 50, 50),
(20, 9, 21, 1, 60, 60),
(21, 9, 9, 1, 50, 50),
(22, 9, 13, 1, 50, 50),
(25, 11, 27, 1, 115, 115),
(32, 13, 18, 2, 115, 230),
(33, 14, 27, 1, 115, 115),
(34, 14, 21, 1, 60, 60),
(35, 15, 16, 1, 40, 40),
(36, 15, 13, 1, 50, 50),
(37, 16, 25, 1, 70, 70),
(38, 17, 27, 1, 115, 115),
(39, 17, 23, 1, 25, 25),
(40, 17, 29, 1, 115, 115),
(41, 17, 13, 1, 50, 50),
(42, 18, 14, 1, 50, 50),
(43, 18, 15, 1, 50, 50),
(44, 19, 23, 1, 25, 25),
(45, 19, 16, 1, 40, 40),
(46, 20, 21, 1, 60, 60),
(47, 21, 21, 1, 60, 60),
(48, 21, 22, 1, 40, 40),
(53, 23, 28, 1, 115, 115),
(54, 23, 15, 1, 50, 50),
(55, 23, 12, 1, 50, 50),
(72, 27, 21, 1, 60, 60),
(73, 27, 27, 1, 115, 115),
(75, 29, 37, 1, 45, 45),
(76, 29, 6, 5, 50, 250),
(82, 33, 5, 1, 50, 50),
(83, 34, 9, 1, 50, 50),
(84, 34, 6, 1, 50, 50),
(85, 35, 9, 1, 50, 50),
(120, 70, 6, 1, 50, 50),
(121, 71, 37, 1, 45, 45),
(122, 72, 6, 1, 50, 50),
(123, 73, 6, 1, 50, 50),
(124, 74, 6, 1, 50, 50),
(125, 75, 7, 1, 50, 50),
(126, 76, 6, 1, 50, 50),
(127, 77, 9, 3, 50, 150),
(128, 78, 6, 1, 50, 50),
(129, 79, 5, 1, 50, 50),
(130, 80, 6, 1, 50, 50),
(132, 82, 7, 1, 50, 50),
(145, 95, 5, 3, 50, 150),
(152, 100, 37, 1, 45, 45),
(158, 116, 6, 1, 50, 50),
(159, 121, 9, 1, 50, 50),
(160, 125, 5, 3, 50, 150),
(161, 127, 5, 1, 50, 50),
(162, 129, 8, 5, 50, 250),
(163, 130, 6, 1, 50, 50),
(164, 131, 9, 7, 50, 350),
(165, 132, 9, 1, 50, 50),
(166, 133, 37, 1, 45, 45),
(167, 134, 9, 1, 50, 50),
(168, 135, 9, 1, 50, 50),
(169, 136, 7, 1, 50, 50),
(170, 137, 9, 1, 50, 50),
(171, 138, 9, 1, 50, 50),
(172, 139, 5, 1, 50, 50),
(173, 140, 5, 1, 50, 50),
(174, 141, 6, 1, 50, 50),
(175, 142, 5, 1, 50, 50),
(176, 143, 9, 5, 50, 250),
(177, 144, 7, 1, 50, 50),
(178, 145, 9, 1, 50, 50),
(179, 146, 5, 1, 50, 50),
(180, 147, 9, 3, 50, 150),
(181, 148, 9, 1, 50, 50);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(30) NOT NULL,
  `category_id` int(30) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `price` float NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0=Unavailable,1=Available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `status`) VALUES
(5, 4, 'Cappuccino', 'is a coffee drink made with espresso, steamed milk, and foamed milk', 50, 1),
(6, 4, 'Macchiato', 'is a coffee drink made with espresso and a small amount of steamed milk', 50, 1),
(7, 4, 'Moćha', 'is a coffee drink made with espresso, steamed milk, chocolate syrup, and foamed milk', 50, 1),
(8, 4, 'Latte', 'is a coffee drink made with espresso and steamed milk', 50, 1),
(9, 4, 'Americano/Brewed', 'is a coffee drink made with espresso and hot water', 50, 1),
(37, 4, 'Latte V2', ' is a coffee drink made with espresso and steamed milk v2', 45, 1);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `contact_no` varchar(50) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `address`, `contact_no`, `price`) VALUES
(11, 'Franz Natayada', 'Polomolok, South Cotabato', '09774200495', 555.00),
(12, 'Janine Lanuza', 'Polomolok, South Cotabato', '09112344567', 765.00),
(13, 'Roemar John Sarion', 'Koronadal City', '09295763893', 850.00);

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `cover_img` text NOT NULL,
  `about_content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`id`, `name`, `email`, `contact`, `cover_img`, `about_content`) VALUES
(1, 'Simple Cafe Billing System', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 3 COMMENT '1=Admin,2=Staff'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `type`) VALUES
(1, 'admin', 'admin', '0192023a7bbd73250516f069df18b500', 1),
(6, 'Roemar John', 'sar^', 'b8bef378f900b92d13a3a5460182aaff', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `batch_lot`
--
ALTER TABLE `batch_lot`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deleted_orders`
--
ALTER TABLE `deleted_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `batch_lot`
--
ALTER TABLE `batch_lot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `deleted_orders`
--
ALTER TABLE `deleted_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=182;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
