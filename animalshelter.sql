-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 30, 2025 at 09:47 AM
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
-- Database: `animalshelter`
--

-- --------------------------------------------------------

--
-- Table structure for table `adoptions`
--

CREATE TABLE `adoptions` (
  `adoption_id` int(11) NOT NULL,
  `animal_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT NULL,
  `request_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adoptions`
--

INSERT INTO `adoptions` (`adoption_id`, `animal_id`, `user_id`, `status`, `request_date`) VALUES
(1, 1, 2, 'rejected', '2025-05-25 11:32:18'),
(2, 1, 5, 'approved', '2025-05-25 11:34:06'),
(3, 8, 6, 'approved', '2025-05-25 14:41:16'),
(4, 6, 6, 'approved', '2025-05-25 15:00:21'),
(5, 11, 7, 'approved', '2025-05-27 05:28:55'),
(6, 10, 6, 'approved', '2025-06-10 03:34:48');

-- --------------------------------------------------------

--
-- Table structure for table `adoption_requests`
--

CREATE TABLE `adoption_requests` (
  `request_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `animal_id` int(11) DEFAULT NULL,
  `request_date` date DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `message` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `animals`
--

CREATE TABLE `animals` (
  `animal_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `species` varchar(50) DEFAULT NULL,
  `breed` varchar(100) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` enum('jantan','betina') DEFAULT NULL,
  `status` enum('available','adopted') DEFAULT 'available',
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `animals`
--

INSERT INTO `animals` (`animal_id`, `name`, `species`, `breed`, `age`, `gender`, `status`, `description`, `image`, `date_added`) VALUES
(51, 'Oyen (Pet Of The Month)', 'Cat', 'Domestic short hair', 2, 'female', 'adopted', 'Three-legged (rear leg amputated)', 'Oyen (6th highlight).jpg', '2025-05-25 10:51:22'),
(52, 'Primogem', 'Cat', 'Domestic Medium Hair', 1, 'male', 'available', ' Cream with faint brown stripes', 'Primogem.jpg', '2025-05-25 13:26:36'),
(53, 'Jimin', 'Cat', 'Calico', 3, 'male', 'available', '', 'Jimin.jpg', '2025-05-25 13:27:00'),
(54, 'Megatron 3000', 'Cat', 'Domestic Short Hair', 3, 'female', 'available', '', 'Megatron 3000.jpg', '2025-05-25 14:17:20'),
(55, 'OOIIAAII', 'Cat', 'Tabby (Domestic Short Hair)', 2, 'male', 'adopted', '', 'OOIIAAII.jpg', '2025-05-25 14:17:45'),
(56, 'Princess MSG', 'Cat', 'Calico', 5, 'female', 'available', '', 'Princess MSG.jpg', '2025-05-26 07:10:55'),
(57, 'Bomboclat', 'Cat', 'Domestic Medium Hair', 8, 'male', 'adopted', '', 'Bomboclat.jpg', '2025-05-26 07:12:11'),
(58, 'Joonie', 'Dog', 'Labrador Retriever Mix', 7, 'male', 'adopted', '', 'Joonie.jpg', '2025-05-26 07:13:06'),
(59, 'Boolean', 'Dog', 'Mixed Breed (possible Border Collie mix)', 1.5, 'female', 'available', '', 'Boolean.jpg', '2025-05-26 07:14:46'),
(60, 'Milo Tin', 'Dog', 'Chihuahua Mix', 4, 'male', 'available', '', 'Milo Tin.jpg', '2025-05-26 07:16:58'),
(61, 'Bruno Mars', 'Dog', 'English Bulldog', 2, 'male', 'available', '', 'Bruno Mars.jpg', '2025-05-29 08:50:59'),
(62, 'Alpharay 5000', 'Dog', 'Siberian Husky',2.5, 'female', 'available', '', 'Alpharay 5000.jpg', '2025-05-29 08:51:30'),
(63, 'Bread Loaf', 'Dog', 'Shiba Inu', 1, 'male', 'available', '', 'Bread Loaf.jpg', '2025-05-29 08:52:01'),
(64, 'Anais Watterson', 'Bunny', 'Holland Lop', 10, 'female', 'available', '', 'Anais Watterson.jpg', '2025-05-29 08:52:32'),
(65, 'Cooky', 'Bunny', 'Flemish Giant Mix', 2, 'male', 'available', '', 'Cooky.jpg', '2025-05-29 08:53:03'),
(66, 'Laufey', 'Bunny', 'Lionhead', 1, 'female', 'available', '', 'Laufey.jpg', '2025-05-29 08:53:34'),
(67, 'Jooky', 'Bunny', 'Flemish Giant', 3, 'male', 'available', '', 'Jooky.jpg', '2025-05-29 08:54:05'),
(68, 'Miffy', 'Bunny', 'Netherland Dwarf', 0.9, 'male', 'available', '', 'Miffy.jpg', '2025-05-29 08:54:36'),
(69, 'Nini', 'Hamster', 'Syrian Hamster (Golden)', 0.6, 'male', 'available', '', 'Nini.jpg', '2025-05-29 08:55:07'),
(70, 'Expectopatronum', 'Hamster', "Campbell's Dwarf Hamster", 1, 'female', 'available', '', 'Expectopatronum.jpg', '2025-05-29 08:55:38'),
(71, 'Sunburned', 'Hamster', 'Roborovski Hamster', 0.4, 'male', 'available', '', 'Sunburned.jpg', '2025-05-29 08:56:09'),
(72, 'Glucose', 'Hamster', 'Winter White Dwarf Hamster', 0.10, 'female', 'available', '', 'Glucose.jpg', '2025-05-29 08:56:40'),
(73, 'Odeng', 'Sugar Glider', 'Classic Cream', 2, 'female', 'available', '', 'Odeng.jpg', '2025-05-29 08:57:11'),
(74, 'Eomuk', 'Sugar Glider', 'Leucistic (creamy white with black eyes)', 1.5, 'male', 'available', '', 'Eomuk.jpg', '2025-05-29 08:57:42'),
(75, 'Flying whale', 'Sugar Glider', 'Mosaic (gray and white patches with black markings)', 3, 'male', 'available', '', 'Flying whale.jpg', '2025-05-29 08:58:13'),
(76, 'Nightingale', 'Bird', 'Cockatiel', 3, 'male', 'available', '', 'Nightingale.jpg', '2025-05-29 08:58:44'),
(77, 'Mai', 'Bird', 'Lovebird', 2, 'female', 'available', '', 'Mai.jpg', '2025-05-29 08:59:15'),
(78, 'Rose', 'Hedgehog', 'African Pygmy Hedgehog', 1.5, 'female', 'available', '', 'Rose.jpg', '2025-05-29 08:59:46');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `announcement_id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `content` text NOT NULL,
  `posted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `posted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `setting_id` int(11) NOT NULL,
  `key_name` varchar(50) DEFAULT NULL,
  `value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `theme_preference` enum('light','dark') DEFAULT 'light',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `name`, `email`, `phone`, `role`, `theme_preference`, `created_at`) VALUES
(1, 'aswaazfar', '$2y$10$bdeK5T/f9/34Gmb.XYe62.009MGGbO52qoSrBHBIOhkF1TVZw7VWy', 'Mohamad Harith Azfar', NULL, '019-8299719', 'user', 'light', '2025-05-25 10:00:21'),
(2, 'test', '$2y$10$j6xE4eRPHvD565cveV1kcuwPrEBiB.NGRP53F8rYUs8OLusAILRpS', 'test', NULL, '02999288282', 'user', 'light', '2025-05-25 10:01:40'),
(3, 'admin', '$2y$10$9DFb7gYlC4XqSfaXMPgUpui9VjICk2OCCQx5E2XaA2Wh.9uGVaPni', 'Admin User', NULL, '0123456789', 'admin', 'light', '2025-05-25 10:15:02'),
(4, 'superadmin', '$2y$10$mYPtpYVXjQcbimO06v4GE.MsphR5TUuclGnu7zta2mHC5Q0Dp6bEG', 'admin', NULL, '00000010131', 'admin', 'light', '2025-05-25 10:16:20'),
(5, 'maisarah', '$2y$10$lNNhjkiHhNlSWYHTV5/6f.sJJ40dffXA5.kxL2ATy0C.n5O25vVmG', 'Maisarah', NULL, '01992838393', 'user', 'light', '2025-05-25 11:33:34'),
(6, 'syazlianarahman', '$2y$10$vX6tplvEMNkVApiV6LbB0.aASpZKqYJI.0CsOBIV1sx0kDwu/Amja', 'Nur Syazliana binti Abdul Rahman', NULL, '019-9920123', 'user', 'light', '2025-05-25 14:39:54'),
(7, 'raidenei', '$2y$10$M8erN.GzpV5E0J22djDNKuwfSD48RlIw999yq4d0MGJkmAHXRi7/6', 'Raiden', NULL, '000000000', 'user', 'light', '2025-05-27 05:27:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adoptions`
--
ALTER TABLE `adoptions`
  ADD PRIMARY KEY (`adoption_id`);

--
-- Indexes for table `adoption_requests`
--
ALTER TABLE `adoption_requests`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `animal_id` (`animal_id`);

--
-- Indexes for table `animals`
--
ALTER TABLE `animals`
  ADD PRIMARY KEY (`animal_id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`announcement_id`),
  ADD KEY `posted_by` (`posted_by`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`setting_id`),
  ADD UNIQUE KEY `key_name` (`key_name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adoptions`
--
ALTER TABLE `adoptions`
  MODIFY `adoption_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `adoption_requests`
--
ALTER TABLE `adoption_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `animals`
--
ALTER TABLE `animals`
  MODIFY `animal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `announcement_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `adoption_requests`
--
ALTER TABLE `adoption_requests`
  ADD CONSTRAINT `adoption_requests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `adoption_requests_ibfk_2` FOREIGN KEY (`animal_id`) REFERENCES `animals` (`animal_id`);

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcements_ibfk_1` FOREIGN KEY (`posted_by`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
