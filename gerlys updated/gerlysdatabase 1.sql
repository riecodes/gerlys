-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 04, 2024 at 09:25 AM
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
-- Database: `gerlysdatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `menu_id` int(11) NOT NULL,
  `menu_name` varchar(255) DEFAULT NULL,
  `menu_description` text DEFAULT NULL,
  `menu_price` decimal(10,2) DEFAULT NULL,
  `images` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`menu_id`, `menu_name`, `menu_description`, `menu_price`, `images`) VALUES
(1, 'Grilled Chicken Sandwich', 'A delicious grilled chicken sandwich with fresh lettuce, tomatoes, and mayonnaise on a toasted bun', 7.99, NULL),
(2, 'chicken and coke', 'dwadawdwa', 229.00, 'images/WIN_20241021_16_04_46_Pro.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `reservation_id` int(11) DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `payer_name` varchar(255) DEFAULT NULL,
  `payer_email` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `total_amount` varchar(255) DEFAULT NULL,
  `payment_status` varchar(50) DEFAULT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `reservation_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `reservation_date` datetime NOT NULL,
  `address` text NOT NULL,
  `status` enum('pending','confirmed','canceled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`reservation_id`, `user_id`, `service_id`, `menu_id`, `reservation_date`, `address`, `status`, `created_at`, `updated_at`) VALUES
(2, 2, 1, 1, '2024-10-26 17:25:00', 'naic', 'pending', '2024-10-26 09:25:40', '2024-10-26 09:25:40'),
(7, 9, 1, 1, '2024-11-11 07:32:00', 'san jose batangas', 'pending', '2024-11-01 19:32:39', '2024-11-01 19:32:39'),
(8, 9, 1, 1, '2024-11-14 08:30:00', 'san jose batangas', 'pending', '2024-11-03 15:29:23', '2024-11-03 15:29:23'),
(9, 9, 1, 1, '2024-10-31 23:34:00', '3232323', 'pending', '2024-11-03 15:30:37', '2024-11-03 15:30:37'),
(10, 8, 1, 1, '2024-11-13 23:37:00', 'lipa city', 'pending', '2024-11-03 15:33:45', '2024-11-03 15:33:45'),
(11, 8, 1, 1, '2024-11-15 04:22:00', 'quezon city', 'pending', '2024-11-03 20:20:58', '2024-11-03 20:20:58');

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `service_id` int(11) NOT NULL,
  `service_name` varchar(255) DEFAULT NULL,
  `service_description` text DEFAULT NULL,
  `service_price` decimal(10,2) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`service_id`, `service_name`, `service_description`, `service_price`, `price`) VALUES
(1, 'Weddings', 'Comprehensive wedding planning and coordination to make your special day memorable. Our team assists with venue selection, decor, catering, and guest management, ensuring a flawless celebration.', 1200.00, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(13) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `account_type` varchar(1) NOT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `microsoft_id` varchar(255) DEFAULT NULL,
  `attempt` varchar(255) NOT NULL,
  `log_time` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `phone`, `password`, `account_type`, `google_id`, `microsoft_id`, `attempt`, `log_time`) VALUES
(1, 'Gabriel', 'Yamsuan', 'gabriel3140@gmail.com', '0813', 'JdUKzl6b', '2', NULL, NULL, '', ''),
(2, 'Jastinne', 'Ilao', 'jastinnenicole@gmail.com', '0817', '65luTXU2', '2', NULL, NULL, '', ''),
(3, 'thea', 'Plata', 'gabgabr918@gmail.com', '09083296793', 'vCpdxT1U', '2', NULL, NULL, '', ''),
(4, 'Patric', 'Resma', 'patricresma@gmail.com', '09228128422', '5DyRpao1', '2', NULL, NULL, '', ''),
(5, 'Andrei', 'Tallado', 'andrei123@gmail.com', '08232554865', 'IH8Rprkc', '2', NULL, NULL, '', ''),
(6, 'Paula', 'Dechavez', 'pauladechavez@gmail.com', '08329679151', 'Ht2KLQNW', '2', NULL, NULL, '', ''),
(7, 'Admin', 'Admin', 'admin@gmail.com', '09124', 'admin123', '1', NULL, NULL, '', ''),
(8, 'Gabriel', 'Yamsuan', 'gabrielyamsuan13@gmail.com', '', NULL, '', '108055141184669602959', NULL, '', ''),
(9, 'gabriel', 'yamsuan', 'gabgabr918@gmail.com', '', NULL, '', '113567452025746649002', NULL, '', ''),
(10, 'Mark', 'Cortil', 'mark@gmail.com', '09228392115', '$2y$10$vis1wkYAT0J8UjtHmtFQdeeYFsIRSVM7mb5FPRGa3BG5iEOV1fiE6', '2', NULL, NULL, '1', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `reservation_id` (`reservation_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`reservation_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `service_id` (`service_id`),
  ADD KEY `menu_id` (`menu_id`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`reservation_id`);

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `service` (`service_id`),
  ADD CONSTRAINT `reservations_ibfk_3` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`menu_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
