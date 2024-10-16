-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 08, 2024 at 09:18 PM
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
-- Database: `vehicle_auction`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(50) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`) VALUES
(1, 'admin@gmail.com', '123');

-- --------------------------------------------------------

--
-- Table structure for table `auctions`
--

CREATE TABLE `auctions` (
  `id` int(50) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `current_bid` decimal(10,2) DEFAULT NULL,
  `featured` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `email` varchar(255) DEFAULT 'Post By System'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `auctions`
--

INSERT INTO `auctions` (`id`, `title`, `image_url`, `current_bid`, `featured`, `created_at`, `email`) VALUES
(1, '2015 Ford Mustang', 'images/mustang.jpg', 15000.00, 1, '2024-09-29 20:44:04', 'Post By System'),
(2, '2018 Tesla Model S', 'images/tesla.jpg', 45000.00, 1, '2024-09-29 20:44:04', 'Post By System'),
(3, '2020 BMW X5', 'images/bmw.jpg', 55000.00, 0, '2024-09-29 20:44:04', 'Post By System'),
(4, '2017 Audi A4', 'images/audi.jpg', 25000.00, 1, '2024-09-29 20:44:04', 'Post By System'),
(6, '2019 Chevrolet Camaro', 'images/camaro.jpg', 30000.00, 1, '2024-09-30 03:46:31', 'Post By System'),
(7, '2021 Mercedes-Benz C-Class', 'images/mercedes.jpg', 40000.00, 1, '2024-09-30 03:46:31', 'Post By System'),
(8, '2016 Honda Accord', 'images/accord.jpg', 18000.00, 0, '2024-09-30 03:46:31', 'Post By System'),
(9, '2019 Porsche 911', 'images/porsche.jpg', 90000.00, 1, '2024-09-30 03:46:31', 'Post By System'),
(10, '2020 Lexus RX', 'images/lexus.jpg', 45000.00, 0, '2024-09-30 03:46:31', 'Post By System');

-- --------------------------------------------------------

--
-- Table structure for table `bids`
--

CREATE TABLE `bids` (
  `id` int(50) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `bid_amount` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `vehicle_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bids`
--

INSERT INTO `bids` (`id`, `email`, `bid_amount`, `created_at`, `vehicle_name`) VALUES
(6, 'IT2364636@my.sliit.lk', '234', '2024-09-30 09:31:14', '2015 Ford Mustang'),
(7, 'IT2364636@my.sliit.lk', '2143', '2024-09-30 09:36:08', '2015 Ford Mustang'),
(8, 'vehanrajintha17@gmail.com', '5000', '2024-09-30 18:54:15', '2015 Ford Mustang'),
(9, 'IT2364636@my.sliit.lk', '100', '2024-09-30 19:03:43', '2015 Ford Mustang'),
(10, 'IT2364636@my.sliit.lk', '5555', '2024-09-30 19:04:34', '2015 Ford Mustang'),
(11, 'IT2364636@my.sliit.lk', '10000', '2024-09-30 19:05:44', '2015 Ford Mustang'),
(12, 'IT2364636@my.sliit.lk', '10500', '2024-09-30 19:06:42', '2018 Tesla Model S'),
(13, 'kukula@gmail.com', '5000', '2024-10-01 13:57:45', '2015 Ford Mustang'),
(14, 'vehanrajintha17@gmail.com', '444444', '2024-10-01 16:17:16', '2018 Tesla Model S'),
(15, 'vehanrajintha17@gmail.com', '4325', '2024-10-01 16:49:35', '2017 Audi A4'),
(16, 'vehanrajintha17@gmail.com', '234', '2024-10-08 19:06:48', '2017 Audi A4');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mnumber` varchar(255) DEFAULT NULL,
  `profilepic` varchar(250) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `email`, `mnumber`, `profilepic`, `password`, `id`) VALUES
('Vehan Rajintha123', 'vehanrajintha17@gmail.com', '0713910417', 'uploads/Screenshot 2024-09-30 232154.png', '234', 6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auctions`
--
ALTER TABLE `auctions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bids`
--
ALTER TABLE `bids`
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
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `auctions`
--
ALTER TABLE `auctions`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `bids`
--
ALTER TABLE `bids`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
