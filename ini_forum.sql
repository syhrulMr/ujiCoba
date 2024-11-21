-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2024 at 08:29 AM
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
-- Database: `ini_forum`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'Teknologi', 'Diskusi tentang teknologi terbaru dan inovasi.', '2024-11-11 06:25:34'),
(2, 'Sains', 'Diskusi tentang ilmu pengetahuan dan penemuan.', '2024-11-11 06:25:34'),
(3, 'Musik', 'Diskusi tentang musik, genre, dan musisi favorit.', '2024-11-11 06:25:34'),
(4, 'Olahraga', 'Diskusi tentang olahraga, pertandingan, dan atlet.', '2024-11-11 06:25:34'),
(5, 'Film', 'Diskusi tentang film, aktor, dan industri perfilman.', '2024-11-11 06:25:34');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `parent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `topic_id`, `user_id`, `content`, `created_at`, `parent_id`) VALUES
(1, 7, 1, ',,', '2024-11-11 07:43:52', NULL),
(2, 7, 1, 'nnn', '2024-11-11 07:43:56', NULL),
(3, 6, 1, 'asa', '2024-11-11 07:46:03', NULL),
(4, 12, 1, 'sas', '2024-11-11 11:48:31', NULL),
(5, 13, 1, 'sa', '2024-11-11 14:54:16', NULL),
(6, 13, 1, 'sa', '2024-11-11 14:56:36', 5),
(7, 13, 1, 'sa', '2024-11-11 14:56:38', 5),
(8, 13, 1, 'dssw', '2024-11-11 14:56:43', 5),
(9, 13, 1, 'dsdwa', '2024-11-11 14:56:47', NULL),
(10, 13, 1, 'lol', '2024-11-11 14:56:51', 9),
(11, 13, 1, 'sa', '2024-11-11 15:03:29', 5),
(12, 14, 1, 'as', '2024-11-11 15:15:26', NULL),
(13, 9, 1, 'dsdw', '2024-11-11 15:27:44', NULL),
(14, 9, 1, 'sas', '2024-11-11 15:28:45', NULL),
(15, 9, 1, 'sas', '2024-11-11 15:28:48', 14),
(16, 9, 1, 'sas', '2024-11-11 15:28:53', 14),
(17, 9, 1, 'sasa', '2024-11-11 15:30:36', 13),
(18, 9, 1, 'sasa', '2024-11-11 15:30:38', NULL),
(19, 9, 1, 'sas', '2024-11-11 15:31:09', 13),
(20, 9, 1, 'sas', '2024-11-11 15:31:12', 18),
(21, 9, 1, 'sas', '2024-11-11 15:31:15', NULL),
(22, 9, 1, 'sas', '2024-11-11 15:31:21', NULL),
(23, 9, 1, 'sa', '2024-11-11 15:32:32', 13),
(24, 15, 14, 'a', '2024-11-11 15:34:20', NULL),
(25, 15, 1, 'asas', '2024-11-11 15:34:27', 24),
(26, 15, 14, 'sa', '2024-11-11 15:34:29', NULL),
(27, 15, 14, 'sdwa', '2024-11-11 15:34:32', NULL),
(28, 14, 14, 'asa', '2024-11-11 15:38:43', NULL),
(29, 14, 1, 'as', '2024-11-11 15:47:37', 12),
(30, 14, 1, 'sdwas', '2024-11-11 15:47:39', 12),
(31, 14, 14, 'sdw', '2024-11-11 15:47:42', NULL),
(32, 14, 1, 'aswwwww', '2024-11-11 15:47:50', 12),
(33, 14, 1, 'dsads', '2024-11-11 15:47:57', 31),
(34, 14, 1, 'a', '2024-11-11 15:49:01', 12),
(35, 14, 1, 'sas', '2024-11-11 15:50:34', 12),
(36, 14, 1, 'aaaaaa', '2024-11-11 15:50:36', 12),
(37, 14, 2, 'sasas', '2024-11-11 15:50:42', NULL),
(38, 14, 1, 'sas', '2024-11-11 15:50:46', 37),
(39, 17, 2, 'sas', '2024-11-11 15:58:22', NULL),
(40, 17, 2, 'sd', '2024-11-11 15:58:24', 39),
(41, 17, 2, 'sdw', '2024-11-11 15:58:25', 39),
(42, 17, 16, 'asa', '2024-11-11 16:00:04', 39),
(43, 17, 16, 'saas', '2024-11-11 16:00:08', NULL),
(44, 18, 16, 'sasas', '2024-11-11 16:00:32', NULL),
(45, 18, 16, 'sasa', '2024-11-11 16:00:34', 44),
(46, 18, 14, 'asdwk\r\n', '2024-11-11 16:01:00', 44),
(47, 18, 14, 'dwa', '2024-11-11 16:01:03', 44),
(48, 19, 17, 'apa itu?\r\n', '2024-11-12 03:00:06', NULL),
(49, 19, 17, 'nd tauka?..', '2024-11-12 03:00:25', 48),
(50, 19, 17, 'haa..\r\n', '2024-11-12 03:01:08', 48),
(51, 19, 14, 'lol', '2024-11-12 03:02:25', 48),
(52, 18, 14, 'wae', '2024-11-12 05:17:35', 44),
(53, 18, 14, 'coto\r\n', '2024-11-12 05:17:39', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`id`, `user_id`, `category_id`, `title`, `content`, `created_at`) VALUES
(1, 1, 5, 'kana', 'kanja bad\r\n', '2024-11-11 06:40:04'),
(2, 1, 1, 'as', 'as', '2024-11-11 07:12:45'),
(3, 1, 1, 'a', 'aa', '2024-11-11 07:12:54'),
(4, 1, 1, 'asa', 'aas', '2024-11-11 07:13:36'),
(5, 1, 1, 'asa', 'aas', '2024-11-11 07:13:37'),
(6, 1, 4, 'diskusi 1', 'lari lari', '2024-11-11 07:21:29'),
(7, 1, 1, 'wqw', 'wqwqqas', '2024-11-11 07:30:42'),
(8, 1, 1, 'asas', 'asasa', '2024-11-11 07:52:38'),
(9, 1, 1, 'sldw', 'as', '2024-11-11 10:03:12'),
(10, 1, 1, 'a', 'as', '2024-11-11 10:29:59'),
(11, 1, 1, 'asa', 'sas\r\n', '2024-11-11 11:42:07'),
(12, 1, 3, 'mengapa', 'lol', '2024-11-11 11:48:26'),
(13, 1, 1, 'politik', 'menurut anda isi politik itu apa', '2024-11-11 13:57:11'),
(14, 1, 1, 'sa', 'sa', '2024-11-11 15:04:20'),
(15, 1, 1, 'sa', 'sas', '2024-11-11 15:22:45'),
(16, 1, 1, 'sas', 'sa', '2024-11-11 15:24:26'),
(17, 2, 1, 'sasa', 'sasa', '2024-11-11 15:58:14'),
(18, 16, 1, 'lsdow', 'lol', '2024-11-11 16:00:19'),
(19, 17, 2, 'kuasalitas', 'sebab akibat', '2024-11-12 02:59:42');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'user0', 'ini@gok.com', 'lol', '2024-11-11 06:37:41'),
(2, 'a', 'a@gok.com', '$2y$10$m2E4Cm5SyCGI/Pu20MLdaeULz1uc51.HnV9vHLlExsgOgxx5QptJa', '2024-11-11 10:26:47'),
(5, 'b', 'b@gok.com', '$2y$10$O/5oV04.D9FWIDPBBjrchOWUnz6nDxZdCu02QaIlYFlAj8fkVTAbG', '2024-11-11 10:28:41'),
(8, 'caca', 'caca@gok.com', '$2y$10$ZFmU3stdnik3Fg4P5XJXq.v2T/SVVicQRgJVRK1dNZVS7MYvD4k3W', '2024-11-11 10:29:14'),
(9, 'allu', 'allu@gmail.com', '$2y$10$MG7V98Bb./qPQQCAqoQdSeWoYis0am4WLvCAwiIxZh3qoJp6/dVwS', '2024-11-11 10:31:02'),
(10, 'sas', '', '$2y$10$O/QWGomD0nWJJSJZ.KPaxOt59oaMaUbPXRN6tbzFrSUbJk0.lk.v2', '2024-11-11 15:07:48'),
(14, 'aku', 'aku@gak.com', '$2y$10$86opEwhyUq4pxvvGJc6mR.ZZ31wFaDpfJKLne7/ms60blTKTGO04C', '2024-11-11 15:15:01'),
(16, 'ekki', 'ekki@gak.com', '$2y$10$/Ti3p7Se2VNBp9rg1StZ.uYcIB.bKL.lBi0lk7gx853vAZWguL2Mu', '2024-11-11 15:59:36'),
(17, 'qq', 'qq@gak.com', '$2y$10$/T87yigjqlLz6wud08SZ2.QW49BoueMFyjPPatPDwmEGA4YtCwE6q', '2024-11-12 02:59:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `topic_id` (`topic_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `topics`
--
ALTER TABLE `topics`
  ADD CONSTRAINT `topics_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `topics_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
