-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 10, 2025 at 05:33 PM
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
-- Database: `heartz`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `comment_text` text NOT NULL,
  `commented_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `followers`
--

CREATE TABLE `followers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `follower_id` bigint(20) UNSIGNED NOT NULL,
  `following_id` bigint(20) UNSIGNED NOT NULL,
  `followed_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `followers`
--

INSERT INTO `followers` (`id`, `follower_id`, `following_id`, `followed_at`) VALUES
(3, 13, 3, '2025-07-25 21:05:05'),
(6, 13, 14, '2025-07-26 16:41:05'),
(8, 14, 3, '2025-07-26 20:06:05'),
(9, 13, 15, '2025-07-26 21:08:30'),
(12, 14, 15, '2025-07-27 00:08:41'),
(13, 15, 13, '2025-07-27 16:04:37'),
(14, 15, 3, '2025-07-27 16:04:38'),
(15, 15, 14, '2025-07-27 16:04:39'),
(17, 3, 14, '2025-07-31 21:36:41'),
(19, 17, 13, '2025-08-07 03:54:06'),
(20, 17, 18, '2025-08-07 03:54:07'),
(21, 17, 16, '2025-08-07 03:54:09'),
(22, 17, 3, '2025-08-07 03:54:10'),
(23, 17, 14, '2025-08-07 03:54:13'),
(24, 17, 15, '2025-08-07 03:54:18'),
(25, 14, 18, '2025-08-07 03:58:21'),
(26, 14, 17, '2025-08-07 03:58:22'),
(27, 14, 16, '2025-08-07 03:58:23'),
(28, 16, 13, '2025-08-07 03:58:52'),
(29, 16, 18, '2025-08-07 03:58:53'),
(30, 16, 17, '2025-08-07 03:58:54'),
(31, 16, 3, '2025-08-07 03:58:55'),
(32, 16, 14, '2025-08-07 03:58:56'),
(33, 18, 13, '2025-08-07 03:59:17'),
(34, 18, 17, '2025-08-07 03:59:18'),
(35, 18, 16, '2025-08-07 03:59:19'),
(36, 18, 3, '2025-08-07 03:59:20'),
(37, 18, 14, '2025-08-07 03:59:22'),
(38, 19, 13, '2025-08-07 11:42:09'),
(39, 19, 18, '2025-08-07 11:42:10'),
(40, 19, 17, '2025-08-07 11:42:11'),
(41, 19, 16, '2025-08-07 11:42:12'),
(42, 19, 3, '2025-08-07 11:42:13'),
(43, 14, 19, '2025-08-07 11:42:30'),
(44, 17, 19, '2025-08-07 11:50:24'),
(45, 16, 19, '2025-08-07 12:30:25'),
(46, 3, 19, '2025-08-07 12:44:35'),
(47, 3, 16, '2025-08-07 12:46:37'),
(48, 14, 13, '2025-08-07 12:46:40'),
(49, 3, 13, '2025-08-07 12:47:01');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `liked_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`user_id`, `post_id`, `liked_at`) VALUES
(3, 10, '2025-08-07 12:43:32'),
(3, 11, '2025-08-07 12:42:52'),
(3, 12, '2025-08-07 12:42:54'),
(3, 13, '2025-08-07 12:42:49'),
(13, 4, '2025-07-27 13:56:43'),
(13, 5, '2025-07-27 13:56:05'),
(13, 6, '2025-07-27 13:56:02'),
(13, 8, '2025-07-27 15:03:11'),
(13, 9, '2025-07-27 14:25:11'),
(13, 11, '2025-08-06 18:40:46'),
(13, 12, '2025-08-01 22:35:11'),
(14, 8, '2025-08-01 22:03:55'),
(14, 9, '2025-07-30 04:10:29'),
(14, 10, '2025-07-30 04:10:24'),
(14, 11, '2025-07-30 04:10:16'),
(14, 14, '2025-08-07 04:06:26'),
(14, 15, '2025-08-07 04:06:24'),
(14, 16, '2025-08-07 04:06:21'),
(14, 17, '2025-08-07 04:06:19'),
(14, 18, '2025-08-07 04:06:10'),
(14, 19, '2025-08-07 11:42:42'),
(14, 20, '2025-08-07 12:45:18'),
(15, 4, '2025-07-27 13:58:11'),
(15, 5, '2025-07-27 14:23:48'),
(15, 6, '2025-07-27 14:01:09'),
(15, 7, '2025-07-27 13:58:19'),
(15, 8, '2025-07-27 14:01:15'),
(15, 9, '2025-07-27 14:22:53'),
(15, 10, '2025-07-27 15:05:02'),
(15, 11, '2025-07-27 15:15:38'),
(15, 13, '2025-08-06 13:49:00'),
(16, 16, '2025-08-07 03:51:03'),
(16, 19, '2025-08-07 13:38:41'),
(17, 9, '2025-08-07 12:50:02'),
(17, 12, '2025-08-07 03:54:47'),
(17, 13, '2025-08-07 03:54:44'),
(17, 14, '2025-08-07 03:54:42'),
(17, 15, '2025-08-07 03:54:40'),
(17, 17, '2025-08-07 03:53:49'),
(17, 19, '2025-08-07 12:47:15'),
(17, 20, '2025-08-07 12:47:14'),
(17, 21, '2025-08-07 12:47:12'),
(18, 14, '2025-08-07 03:47:57'),
(19, 20, '2025-08-07 13:42:35');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `message_id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED NOT NULL,
  `message_text` text NOT NULL,
  `sent_at` datetime NOT NULL DEFAULT current_timestamp(),
  `is_read` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `sender_id`, `receiver_id`, `message_text`, `sent_at`, `is_read`) VALUES
(2, 15, 3, 'hello', '2025-07-31 21:35:26', 0),
(3, 15, 13, 'hi', '2025-07-31 21:35:38', 0),
(4, 3, 15, 'hi', '2025-07-31 21:37:25', 0),
(5, 14, 13, 'hello', '2025-08-01 22:03:30', 0),
(6, 14, 13, 'hi', '2025-08-01 22:28:29', 0),
(7, 13, 14, 'how are you', '2025-08-01 22:28:42', 0),
(8, 14, 13, 'fine fine...!', '2025-08-01 22:29:09', 0),
(9, 14, 13, 'how are you...?', '2025-08-01 22:29:34', 0),
(10, 13, 14, 'fine fine...?', '2025-08-01 22:29:48', 0),
(11, 13, 14, 'Hi', '2025-08-06 18:41:07', 0),
(12, 14, 17, 'l/98x', '2025-08-07 11:29:35', 0),
(13, 17, 14, 'Hello..', '2025-08-07 11:29:57', 0),
(14, 14, 17, 'Hiiiiiiiiiiiiiiii', '2025-08-07 11:30:14', 0),
(15, 17, 14, 'Hello..', '2025-08-07 11:30:16', 0),
(16, 17, 14, 'How are you', '2025-08-07 11:30:41', 0),
(17, 14, 19, 'assalamualaikum sir', '2025-08-07 12:24:51', 0),
(18, 14, 19, 'assalamualaikum sir', '2025-08-07 12:27:27', 0),
(19, 16, 3, 'Ellow prantoooooooo', '2025-08-07 12:37:38', 0),
(20, 14, 3, 'Hello...!!', '2025-08-07 12:42:46', 0),
(21, 3, 14, 'how r u sunamoni', '2025-08-07 12:44:06', 0),
(23, 16, 3, 'hii', '2025-08-07 13:39:21', 0),
(24, 19, 3, 'hiiiiii', '2025-08-07 13:42:54', 0),
(25, 17, 19, 'Hello sir..we are in your room', '2025-08-07 13:43:24', 0),
(26, 19, 3, 'prantooo', '2025-08-07 13:49:02', 0);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `content` varchar(255) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `user_id`, `content`, `image_url`, `created_at`) VALUES
(4, 14, 'hi,how are you', NULL, '2025-07-26 14:54:42'),
(5, 14, 'Spending great time....', 'files/images/7.png', '2025-07-27 00:37:21'),
(6, 14, 'hello everyone...!!!', 'files/images/8.png', '2025-07-27 00:49:50'),
(7, 13, 'whats on my mind....?', 'files/images/9.png', '2025-07-27 02:24:15'),
(8, 13, 'hello......puk Boys', 'files/images/10.png', '2025-07-27 13:18:26'),
(9, 13, 'helloooo......Pokeis', 'files/images/11.jpg', '2025-07-27 13:21:12'),
(10, 15, 'hello', NULL, '2025-07-27 15:04:53'),
(11, 15, 'hikuwghe\r\n', NULL, '2025-07-27 15:15:33'),
(12, 14, 'gekko..!', 'files/images/12.png', '2025-08-01 22:33:32'),
(13, 14, 'i am palak..', 'files/images/13.jpg', '2025-08-06 13:47:36'),
(14, 18, 'Go to helllll.....!!!', 'files/images/17.jpg', '2025-08-07 03:45:07'),
(15, 16, 'early to bed....\r\nand early to rise....\r\nmakes a man healthy,wealthy and wise...!!!', 'files/images/18.jpg', '2025-08-07 03:49:38'),
(16, 16, 'be motivated...', NULL, '2025-08-07 03:50:32'),
(17, 17, 'What if the world is destroyed today...\r\nDoes this project matters anymore....?\r\n', 'files/images/19.jpg', '2025-08-07 03:53:43'),
(18, 3, 'Apa abar ashbe....!!!', 'files/images/20.jpg', '2025-08-07 04:05:25'),
(19, 19, 'Tomra tooh A+.....!!!', 'files/images/22.png', '2025-08-07 11:41:58'),
(20, 16, 'best motivator in your life is yourself ', NULL, '2025-08-07 12:31:56'),
(21, 14, 'Hi', NULL, '2025-08-07 12:45:39');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` bigint(11) UNSIGNED NOT NULL,
  `username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `bio` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password_hash`, `bio`, `profile_pic`, `created_at`) VALUES
(3, 'Pranto', 'assadurjamanpranto@gmail.com', '$2y$10$ZJ7gUvEx31lpLCZEQ/RshuS.a7BQ6AYxN5/jaGYyzjtLLm7Hz4sZ6', 'Ahh...Ahhh.Ahhh...!', 'files/images/3.png', '2025-07-26 20:25:34'),
(13, 'kk', 'tanvir@gmail.com', '$2y$10$TgUiNCszWYySwar76kgIHOHcSBKXLQ/0kKp.1pgVfBQvvqDAQeIdi', 'wdcx', 'files/images/1.png', '2025-07-25 23:00:17'),
(14, 'rafi', 'rafi@gmail.com', '$2y$10$EAIQ16epITmGMMhKro4GouRhYf0AaH65kxLYzKmRY7ogMgXRBIbCy', 'hello', 'files/images/11.jpg', '2025-08-07 03:56:43'),
(15, 'Z.Palak', 'junaid@gmail.com', '$2y$10$.nbjgG.z.vF8OQNINoeHFOYFTj/Ib8qQQa1Ofru4PMTgg6ZRw6ALy', 'Spank master', 'files/images/4.jpg', '2025-07-26 20:20:58'),
(16, 'Pakal', 'palak@gmail.com', '$2y$10$E95Y.zmb80DEk8cvmKM58evuRKeCDh8ANK9/MG7IJZwD6CKIl3FgG', 'it\'s Paalak', 'files/images/14.jpg', '2025-08-07 03:36:15'),
(17, 'Nazifa', 'nazifa@gmail.com', '$2y$10$8K3hiDsYinSqYLhPHAoTE.s1eOpltnjgy6zsjuv3srMZxtjEtAZJy', 'I know i am briliant...!', 'files/images/15.jpg', '2025-08-07 03:41:06'),
(18, 'Monira', 'monira@gmail.com', '$2y$10$W2SI89J9t4Qlx2jFoXPAReXEEJmXzyR2N8Ztj8288ZRMOgBcccv3i', 'I couldn\'t even revised my notes third time.my exAm preparation is bad....!!!', 'files/images/16.jpg', '2025-08-07 03:43:45'),
(19, 'Rakib H. Riyad', 'rakib@gmail.com', '$2y$10$gl.aZ9sbSiHgyoUBK8/gwuNF7OUyzsxUlwCHIeGX.J0atCIMF2atm', 'hello...!', 'files/images/21.png', '2025-08-07 11:40:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `followers`
--
ALTER TABLE `followers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_follow` (`follower_id`,`following_id`),
  ADD KEY `following_id` (`following_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`user_id`,`post_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `followers`
--
ALTER TABLE `followers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `followers`
--
ALTER TABLE `followers`
  ADD CONSTRAINT `followers_ibfk_1` FOREIGN KEY (`follower_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `followers_ibfk_2` FOREIGN KEY (`following_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
