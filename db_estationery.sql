-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 11, 2024 at 10:55 AM
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
-- Database: `db_estationery`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(10) UNSIGNED NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `full_name`, `username`, `password`) VALUES
(36, 'Admin', 'admin', '$2y$10$DuRB58CMxP5ZHpulEi619.Q72pQsJrdRdY4a/1i3CJgKG1j5k8dVy');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `featured` varchar(10) NOT NULL,
  `active` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`id`, `title`, `image_name`, `featured`, `active`) VALUES
(16, 'Office Supplies', 'Category_551.jpg', 'Yes', 'Yes'),
(17, 'Arts Supplies', 'Category_651.jpg', 'Yes', 'Yes'),
(21, 'Stationery', 'Category_8334.jpg', 'Yes', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_items`
--

CREATE TABLE `tbl_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `featured` varchar(10) NOT NULL,
  `active` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_items`
--

INSERT INTO `tbl_items` (`id`, `title`, `description`, `price`, `image_name`, `category_id`, `featured`, `active`) VALUES
(11, 'Plain Notebook', 'Whether you are in an office or going to school or just need a diary at home for your daily chores, this product will fulfil all your needs and will look fantastic while doing so.', 100.00, 'item-name-442.jpg', 21, 'Yes', 'Yes'),
(12, 'Ruled Notebook', 'Whether you are in an office or going to school or just need a diary at home for your daily chores, this product will fulfil all your needs and will look fantastic while doing so.', 100.00, 'item-name-8001.jpg', 21, 'Yes', 'Yes'),
(13, 'Gel pen', 'Sensitive Nib: The nib is incredibly sensitive, allowing for smooth and effortless writing and signing.\r\nDurable Body: Crafted from thick ABS plastic, the body of the Kaco pen is durable and resistant to breakage.\r\n', 25.00, 'item-name-7185.jpeg', 21, 'Yes', 'Yes'),
(14, 'Ink pen', 'Colour Blue, Red, Green and black\r\nPatented V-System for smooth ink flow with no scratching\r\nMedium nib writes in smooth', 180.00, 'item-name-7590.jpg', 21, 'Yes', 'Yes'),
(15, 'Sticky Notes', 'Slim header\r\nSize: 2.0 x 3.0 inches (50 x 7\r\nQuantity: 100pcs x 10pcs\r\nColor: White (with red line), Yellow, Blue, Pink, Green\r\nShape: Rectangular', 50.00, 'item-name-5698.jpg', 21, 'Yes', 'Yes'),
(16, 'Staplers', 'Staples approximately 7 sheets of copy paper\r\nStaple free stapler for paper binding\r\nMaterial: Zinc alloy', 55.00, 'item-name-5146.jpeg', 16, 'No', 'Yes'),
(17, 'Punchers', 'Kangaro Heavy Duty Punch is a premium quality product from Kangaro.\r\n', 100.00, 'item-name-5028.jpg', 16, 'No', 'Yes'),
(18, 'File', 'Lever Arch File\r\n3\'\' Spine\r\nFully coated cover with PP material\r\nCover and ring pack separately\r\nSteel-wrapped edge.', 150.00, 'item-name-9401.jpg', 16, 'No', 'Yes'),
(19, 'Clear Bag', '100% imported material\r\nButton lock, card holder.\r\nEasy opening and closing system thanks to high quality button.\r\nExpandable design for flexible file organization.', 50.00, 'item-name-5922.jpg', 16, 'No', 'Yes'),
(20, 'Pen holder', 'A pen stand that is an absolute must have for your desks.\r\nLooks smart & classy and can store more than just your many pens & pencils.\r\nMade of PU\r\nScratch Resistant\r\n', 50.00, 'item-name-7163.jpg', 16, 'No', 'Yes'),
(21, 'Water color', 'Brilliant shades with excellent tonal depth highly transparent colors intermixable colors with bright shades.\r\nIntensive and brilliant transparency\r\nCan be dissolved again once applied\r\nThe perfect mixability of bright and dark shades', 50.00, 'item-name-6847.jpg', 17, 'No', 'Yes'),
(22, 'Pencil color', 'Bright Colors: The pencils offer a wide range of vivid colors, perfect for adding depth and dimension to your artwork.\r\n4.0mm Bold Refill: The bold refill provides smooth, consistent lines, ideal for detailed work and shading.\r\nDurable Core: The core is designed to be break-resistant, allowing for uninterrupted use.', 60.00, 'item-name-1953.jpg', 17, 'No', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order`
--

CREATE TABLE `tbl_order` (
  `id` int(10) UNSIGNED NOT NULL,
  `item` varchar(150) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `qty` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `order_date` datetime NOT NULL,
  `status` varchar(50) NOT NULL,
  `customer_name` varchar(150) NOT NULL,
  `customer_contact` varchar(20) NOT NULL,
  `customer_email` varchar(150) NOT NULL,
  `customer_address` varchar(255) NOT NULL,
  `uid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `phone` bigint(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`user_id`, `full_name`, `username`, `phone`, `email`, `address`, `password`) VALUES
(10, 'Sabin Shrestha', 'admin', 9840033816, 'sabing@mail.com', 'Kirtipur', '$2y$10$..Xqo13NLHB4VG7W38mTlu2s2CbDKRCiAHdUYPLg3bpo4/IDEJza2'),
(13, 'Aayush Shrestha', 'aayush', 9811111111, 'aayush@gmail.com', 'Tanahu', '$2y$10$GcLBS668AElA.CreJDhXfeRR9qU9jgh8CFjXGwWkn1lQSs675068q'),
(14, 'Sabin Shrestha', 'sabin', 9808224685, 'sabin@gmail.com', 'Kirtipur', '$2y$10$kIP6jHU.2UuL3gSY4E64jOWAnHOZ6xhDjAW3mcoMbbE3ov3k7YMI2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_items`
--
ALTER TABLE `tbl_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tbl_items`
--
ALTER TABLE `tbl_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_items`
--
ALTER TABLE `tbl_items`
  ADD CONSTRAINT `tbl_items_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `tbl_category` (`id`);

--
-- Constraints for table `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD CONSTRAINT `tbl_order_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `tbl_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
