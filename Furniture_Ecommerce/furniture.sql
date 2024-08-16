-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 11, 2024 at 07:01 AM
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
-- Database: `furniture`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(1, 'Sofa'),
(2, 'Chair'),
(3, 'Table'),
(4, 'Bed'),
(5, 'Rug'),
(6, 'Mattress'),
(7, 'Lamp'),
(8, 'Shelf');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `payment_type` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(100) NOT NULL DEFAULT 'Processing'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `payment_type`, `address`, `order_date`, `status`) VALUES
(1, 4, 'MPU', 'hledan', '2024-05-12 03:45:43', 'Cancelled'),
(2, 4, 'Cash', 'sanchaung', '2024-05-02 17:49:35', 'Pending'),
(3, 4, 'Cash', 'hledan', '2024-05-02 17:49:35', 'Pending'),
(4, 4, 'MPU', 'hledan', '2024-05-01 03:30:20', 'Delivered'),
(5, 4, 'MPU', 'latha', '2024-05-11 03:30:33', 'Shipped'),
(6, 4, 'Visa', 'abcdef', '2024-05-11 03:30:41', 'Cancelled'),
(7, 4, 'MPU', 'hledan', '2024-05-05 03:30:50', 'Processing'),
(8, 4, 'Cash', 'hlaing', '2024-05-08 03:48:11', 'Processing'),
(9, 4, 'Cash', 'hledan', '2024-05-11 04:44:22', 'Processing');

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`id`, `order_id`, `product_id`, `quantity`) VALUES
(1, 1, 1, 2),
(2, 1, 8, 5),
(3, 1, 2, 4),
(4, 2, 7, 3),
(5, 3, 12, 1),
(6, 4, 12, 1),
(7, 4, 4, 1),
(8, 4, 5, 1),
(9, 5, 11, 1),
(10, 6, 4, 2),
(11, 6, 10, 2),
(12, 6, 2, 3),
(13, 7, 1, 1),
(14, 7, 6, 1),
(15, 7, 4, 1),
(16, 7, 11, 1),
(17, 8, 12, 5),
(18, 8, 9, 1),
(19, 8, 10, 1),
(20, 8, 8, 1),
(21, 9, 10, 1),
(22, 9, 8, 1),
(23, 9, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `product_name` varchar(225) NOT NULL,
  `product_brand` varchar(225) NOT NULL,
  `product_description` text NOT NULL,
  `product_price` double NOT NULL,
  `product_stock` int(11) NOT NULL,
  `product_image` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `category_id`, `product_name`, `product_brand`, `product_description`, `product_price`, `product_stock`, `product_image`) VALUES
(1, 1, 'Comfy Sofa', 'IKEA', 'A comfortable sofa for your living room', 599.99, 20, 'assets/img/armchair.jpg'),
(2, 2, 'Modern Chair', 'IKEA', 'Sleek and modern chair for your home office', 149.99, 15, 'assets/img/product8.jpg'),
(3, 3, 'Wooden Table', 'IKEA', 'Sturdy wooden table for dining or working', 249.99, 10, 'assets/img/product6.jpg'),
(4, 4, 'King-size Bed', 'SB', 'Luxurious king-size bed for a good night\'s sleep', 799.99, 8, 'assets/img/product4.jpg'),
(5, 5, 'Soft Rug', 'SB', 'Soft and cozy rug to complement your decor', 99.99, 25, 'assets/img/product1.jpg'),
(6, 6, 'Memory Foam Mattress', 'DreamSleep', 'High-quality memory foam mattress for ultimate comfort', 699.99, 12, 'assets/img/product3.jpg'),
(7, 7, 'Soft Sofa', 'IKEA', 'Adjustable desk lamp for reading or working', 39.99, 30, 'assets/img/sofa.jpg'),
(8, 8, 'Settee', 'SpaceSavers', 'Minimalist floating shelf for stylish storage', 29.99, 18, 'assets/img/product12.jpg'),
(9, 1, 'Sectional Sofa', 'IKEA', 'Spacious sectional sofa for family gatherings', 899.99, 15, 'assets/img/product2.jpg'),
(10, 2, 'Accent Chair', 'Frontgate', 'Stylish accent chair to elevate your decor', 179.99, 20, 'assets/img/product10.jpg'),
(11, 3, 'Round Dining Table', 'Frontgate', 'Elegant round dining table for intimate dinners', 349.99, 10, 'assets/img/product5.jpg'),
(12, 4, 'Bunk Bed', 'SB', 'Space-saving bunk bed perfect for kids\' rooms', 599.99, 5, 'assets/img/product7.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` int(13) NOT NULL,
  `uname` varchar(125) NOT NULL,
  `upass` varchar(125) NOT NULL,
  `uemail` varchar(125) NOT NULL,
  `uph` varchar(125) NOT NULL,
  `uaddress` varchar(125) NOT NULL,
  `utype` varchar(125) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `uname`, `upass`, `uemail`, `uph`, `uaddress`, `utype`) VALUES
(4, 'test', '$2y$10$oR6MxbelANoeEo3PY2ZqMezxPDI.aa3XGt0Ht4kxx/Bse3GkyqiCO', 'test@gmail.com', '2313123123123', 'hledan', 'Admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `cat` (`category_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `category_id_2` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(13) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`uid`);

--
-- Constraints for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `order_detail_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_detail_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `cat` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
