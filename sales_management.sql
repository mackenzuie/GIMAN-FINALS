-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 14, 2025 at 07:19 AM
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
-- Database: `sales_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `inventory_log`
--

CREATE TABLE `inventory_log` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory_log`
--

INSERT INTO `inventory_log` (`id`, `product_id`, `description`, `date`) VALUES
(1, 1, 'Test Log Entry', '2025-03-12 18:02:40'),
(3, 1, 'Stock updated to 100 on 2025-03-12 19:09:07', '2025-03-12 18:09:07'),
(4, 1, 'Stock updated to 100 on 2025-03-12 19:09:08', '2025-03-12 18:09:08'),
(5, 1, 'Stock updated to 100 on 2025-03-12 19:09:08', '2025-03-12 18:09:08'),
(6, 1, 'Stock updated to 100 on 2025-03-12 19:09:08', '2025-03-12 18:09:08'),
(7, 1, 'Stock updated to 100 on 2025-03-12 19:09:09', '2025-03-12 18:09:09'),
(8, 4, 'Stock updated to 100 on 2025-03-12 19:09:10', '2025-03-12 18:09:10'),
(9, 4, 'Stock updated to 100 on 2025-03-12 19:09:11', '2025-03-12 18:09:11'),
(10, 4, 'Stock updated to 100 on 2025-03-12 19:09:11', '2025-03-12 18:09:11'),
(11, 1, 'Stock updated to 100 on 2025-03-12 19:09:12', '2025-03-12 18:09:12'),
(12, 2, 'Stock updated to 100 on 2025-03-12 19:09:13', '2025-03-12 18:09:13'),
(13, 2, 'Stock updated to 100 on 2025-03-12 19:09:14', '2025-03-12 18:09:14'),
(14, 4, 'Stock updated to 100 on 2025-03-12 19:09:17', '2025-03-12 18:09:17'),
(15, 4, 'Stock updated to 97 on 2025-03-12 19:09:19', '2025-03-12 18:09:19'),
(16, 4, 'Stock updated to 97 on 2025-03-12 19:09:19', '2025-03-12 18:09:19'),
(17, 2, 'Stock updated to 95 on 2025-03-12 19:09:21', '2025-03-12 18:09:21'),
(18, 2, 'Stock updated to 95 on 2025-03-12 19:09:22', '2025-03-12 18:09:22'),
(19, 2, 'Stock updated to 89 on 2025-03-12 19:09:24', '2025-03-12 18:09:24'),
(20, 1, '3 item(s) of product ID 1 sold. Stock decreased by 3.', '2025-03-12 18:18:44'),
(21, 1, '6 item(s) of product ID 1 sold. Stock decreased by 6.', '2025-03-12 18:19:17'),
(22, 1, '2 item(s) of product ID 1 sold. Stock decreased by 2.', '2025-03-12 18:53:51'),
(23, 1, '5 item(s) of product ID 1 sold. Stock decreased by 5.', '2025-03-12 19:11:57'),
(24, 2, '2 item(s) of Zagu sold. Stock decreased by 2.', '0000-00-00 00:00:00'),
(25, 2, '2 item(s) of Zagu sold. Stock decreased by 2.', '0000-00-00 00:00:00'),
(26, 2, '3 item(s) of Zagu sold. Stock decreased by 3.', '0000-00-00 00:00:00'),
(27, 2, '4 item(s) of Zagu sold. Stock decreased by 4.', '2025-03-13 20:37:50'),
(28, 5, '3 item(s) of Pizza sold. Stock decreased by 3.', '2025-03-13 22:09:11');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `last_restock_date` date DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `reorder_level` int(11) NOT NULL DEFAULT 0,
  `stock` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `last_restock_date`, `expiry_date`, `reorder_level`, `stock`, `quantity`) VALUES
(1, 'Shawarma', 'Delicious beef wrap', 50.00, '2025-03-12', '2025-12-31', 10, 84, 0),
(2, 'Zagu', 'Refreshing pearl shake', 40.00, '2025-03-12', '2025-12-31', 10, 73, 0),
(4, 'Shawarma Rice', 'Shawarma with rice', 100.00, '2025-03-12', '2025-12-31', 10, 92, 0),
(5, 'Pizza', NULL, 150.00, '2025-03-13', '2025-04-13', 10, 96, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `quantity` int(11) NOT NULL DEFAULT 0,
  `price_per_unit` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `product_id`, `total_amount`, `created_at`, `quantity`, `price_per_unit`) VALUES
(10, 1, 150.00, '2025-03-12 17:48:40', 3, 50.00),
(11, 2, 160.00, '2025-03-12 17:49:05', 4, 40.00),
(12, 1, 150.00, '2025-03-12 17:54:52', 3, 50.00),
(13, 1, 150.00, '2025-03-12 17:59:48', 3, 50.00),
(14, 2, 40.00, '2025-03-12 18:06:41', 1, 40.00),
(15, 2, 120.00, '2025-03-12 18:16:14', 3, 40.00),
(16, 1, 150.00, '2025-03-12 18:18:44', 3, 50.00),
(17, 1, 300.00, '2025-03-12 18:19:17', 6, 50.00),
(18, 1, 100.00, '2025-03-12 18:53:51', 2, 50.00),
(19, 1, 250.00, '2025-03-12 19:11:57', 5, 50.00),
(20, 2, 120.00, '2025-03-13 20:20:53', 3, 40.00),
(21, 5, 150.00, '2025-03-13 20:21:23', 1, 150.00),
(22, 4, 500.00, '2025-03-13 20:26:02', 5, 100.00),
(23, 2, 80.00, '2025-03-13 20:26:40', 2, 40.00),
(24, 2, 80.00, '2025-03-13 20:30:02', 2, 40.00),
(25, 2, 80.00, '2025-03-13 20:30:12', 2, 40.00),
(26, 2, 120.00, '2025-03-13 20:34:50', 3, 40.00),
(27, 2, 160.00, '2025-03-13 20:37:50', 4, 40.00),
(28, 5, 450.00, '2025-03-13 22:09:11', 3, 150.00);

-- --------------------------------------------------------

--
-- Table structure for table `sales_items`
--

CREATE TABLE `sales_items` (
  `id` int(11) NOT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `contact_number` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `first_name`, `last_name`, `role`, `username`, `password`, `contact_number`, `email`) VALUES
(1, 'Admin', 'User', 'Administrator', 'admin', '0192023a7bbd73250516f069df18b500', '09123456789', 'admin@example.com'),
(2, 'Mac', 'Line', 'hehe', 'mjtp', '$2y$10$PSa1flw0prX.ws7cPkMZaujekrimd9jiIDjY/JQOcjDxxy19V8Nxu', '091609160916', 'hehehe@gmail.com'),
(3, 'wo ai ni', 'Teerak', 'sawadeekah', 'wowo', '$2y$10$lnYxwb8jTcKSfANGoxtI4u6OX0dh1Rrg2qxvBwChBcBsjDMQKvpla', '09123456789', 'wowoaini@gmail.com'),
(4, 'hakdog', 'life', 'ruler', 'straight', '$2y$10$t1.p5IVHuSDhQGfTjnJUXOEux0LIoDGLtK06/PQbjGQ7wsxcoj4Ta', '09123456799', 'ruler@gmail.com'),
(5, 'ritz', 'mabuluk', 'wala', 'ritz', '$2y$10$ZUkqngMi.NB31ckEkrkmjuBvCNdAco0PTk0x7G3KY//0zdPmkdQSK', '0912345678765', 'ritztitz@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `stock_movements`
--

CREATE TABLE `stock_movements` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `change_in_stock` int(11) NOT NULL,
  `movement_type` enum('IN','OUT') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inventory_log`
--
ALTER TABLE `inventory_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sales_product` (`product_id`);

--
-- Indexes for table `sales_items`
--
ALTER TABLE `sales_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_id` (`sale_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `stock_movements`
--
ALTER TABLE `stock_movements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inventory_log`
--
ALTER TABLE `inventory_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `sales_items`
--
ALTER TABLE `sales_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `stock_movements`
--
ALTER TABLE `stock_movements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `inventory_log`
--
ALTER TABLE `inventory_log`
  ADD CONSTRAINT `inventory_log_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `fk_sales_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sales_items`
--
ALTER TABLE `sales_items`
  ADD CONSTRAINT `sales_items_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sales_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stock_movements`
--
ALTER TABLE `stock_movements`
  ADD CONSTRAINT `stock_movements_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
