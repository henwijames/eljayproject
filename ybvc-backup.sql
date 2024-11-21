-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 26, 2024 at 05:56 PM
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
-- Database: `ybvc`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `description`, `created_at`) VALUES
(1, 'hey yow!', '2024-08-14 21:09:18');

-- --------------------------------------------------------

--
-- Table structure for table `batch`
--

CREATE TABLE `batch` (
  `id` int(11) NOT NULL,
  `year` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `batch`
--

INSERT INTO `batch` (`id`, `year`, `created_at`) VALUES
(1, '2015 - 2016', '0000-00-00 00:00:00'),
(2, '2016 - 2017', '2024-08-17 20:22:37'),
(3, '2017 - 2018', '2024-08-17 20:22:48'),
(5, '2019 - 2020', '2024-08-26 23:43:38'),
(6, '2020 - 2021', '2024-08-26 23:43:50'),
(7, '2021 - 2022', '2024-08-26 23:43:57'),
(8, '2022 - 2023', '2024-08-26 23:44:06');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `announcement_id` int(11) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `announcement_id`, `comment`, `created_at`) VALUES
(1, 3, 1, 'hahaha', '2024-08-14 21:11:41');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `name`, `created_at`) VALUES
(1, 'Bachelor of Science in Computer Science', '2024-08-14 19:31:38'),
(2, 'Bachelor of Science in Information Technology', '2024-08-14 19:31:42');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `batch` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `graduates`
--

CREATE TABLE `graduates` (
  `id` int(11) NOT NULL,
  `course` int(11) DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `graduated` date DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `course` int(11) DEFAULT NULL,
  `batch` int(11) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `civil` varchar(16) DEFAULT NULL,
  `graduated` date DEFAULT NULL,
  `phone` varchar(16) DEFAULT NULL,
  `present_address` varchar(255) DEFAULT NULL,
  `profile_pic` varchar(255) NOT NULL,
  `qrimage` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `user_id`, `course`, `batch`, `firstname`, `lastname`, `birthdate`, `email`, `civil`, `graduated`, `phone`, `present_address`, `profile_pic`, `qrimage`, `created_at`) VALUES
(1, 2, 2, 1, 'asda', 'dsad', '2001-08-14', 'asdas@sdad.sa', 'Single', '2024-06-14', '092371826381', 'asdasd asdasdad', '', '', '2024-08-14 19:32:43'),
(2, 3, 1, NULL, 'karl', 'karl', '0001-02-21', 'karl@karl.com', 'Single', '2023-05-03', '092371862371', 'kjshbndkjadashasjkd asedas ', 'images/66cc609369b03.png', '', '2024-08-14 19:33:43'),
(3, 4, 1, NULL, 'qwer', 'qwer', '2000-05-25', 'mark@mark.com', 'Married', '2020-06-21', '09782376186', 'sdjakdasndkajsn akjsd asdnjak', '', '', '2024-08-15 14:18:43'),
(4, 5, 2, NULL, 'qwert', 'qwert', '1952-05-21', 'k@k.com', 'Single', '2000-05-21', '0923817', 'askljdakshldahkj', '', '', '2024-08-15 14:28:26'),
(5, 6, 1, NULL, 'zxc', 'zxc', '1980-07-25', 'zxc@as.zx', 'Married', '2001-05-21', '092371827', 'asdadasd adasdasd', '', '', '2024-08-15 14:36:49'),
(6, 7, 1, NULL, 'x', 'x', '2001-01-21', 'x@x.x', 'Widow', '2023-02-02', '09237182731', 'adkajdsak djaskdajk ', '', '', '2024-08-15 14:42:20'),
(7, 8, 1, NULL, 'z', 'z', '0000-00-00', 'z@z.z', 'Single', '2022-02-02', '092222222', '22', '', '', '2024-08-15 14:47:49'),
(8, 9, 1, NULL, 'c', 'c', '2001-02-22', 'x@x.x', 'Single', '2024-02-27', '0923189', 'jh', '', '', '2024-08-15 15:00:41'),
(9, 10, 2, NULL, 'c', 'c', '1980-05-02', '2@s.s', 'Married', '2000-05-02', '0978236816281', 'dhbasjbdajd ', '', '', '2024-08-15 15:07:55'),
(10, 11, 1, NULL, 'a', 'a', '2000-02-21', '2@2.s', 'Single', '2023-04-21', '09427841782', '7878hjkbnjk jkb ', '', '', '2024-08-15 15:42:51'),
(11, 12, 1, NULL, '2', '2', '2000-05-21', '2@2.s', 'Single', '2024-05-21', '094271878', '878 asda dasd', '', '', '2024-08-15 15:47:15'),
(12, 13, 1, NULL, '124', '543', '2000-06-21', '231@sa.sa', 'Single', '2023-05-21', '0942871972381', 'asduiashdiu ahdasuid', '', '', '2024-08-15 15:48:30'),
(13, 14, 1, NULL, '123', '123', '2000-12-03', '123@123.123', 'Single', '2023-12-03', '09123123123', '123 123', '', '', '2024-08-15 16:03:22'),
(14, 15, 1, NULL, 'xz', 'xz', '2000-02-23', '23@23.cs', 'Single', '2024-05-21', '092318271', 'hkasjdjkas', '', '', '2024-08-15 16:06:20'),
(15, 16, 1, NULL, 'zxc', 'zxc', '2001-04-21', 'asda@saxf.sa', 'Single', '2024-06-12', '0924178y6', 'asda', '', '', '2024-08-15 16:07:13'),
(16, 17, 1, NULL, 'a', 'a', '2000-04-21', '2@s.s', 'Single', '2024-05-21', '029312', 'sdfds', '', '', '2024-08-15 22:39:28'),
(17, 18, 1, NULL, 'haha', 'haha', '1921-05-21', 'haha@hgaha.sa', 'Single', '2000-05-21', '4214', '24', '', '', '2024-08-15 22:41:13'),
(18, 20, 1, NULL, 'po', 'po', '1990-07-05', 'po@po.po', 'Single', NULL, '08', '4', '', '', '2024-08-17 19:53:21'),
(19, 21, 1, 1, 'mimi', 'mimi', '1820-05-31', 'li@li.s', 'Single', NULL, '2', 's', '', '', '2024-08-17 20:13:56'),
(20, 22, 1, 3, 'v', 'v', '2000-04-21', '2@2.2', 'Single', NULL, '092371827381', '2', '', '', '2024-08-18 12:06:31'),
(21, 23, 2, 2, 'hehe', 'hehe', '1990-01-21', 'heh@hehe.he', 'Married', NULL, '2', 'sda', '', '', '2024-08-18 13:10:00'),
(22, 25, 1, 1, '45', '45', '5232-02-04', '45@45.45', 'Single', NULL, '45', NULL, '', '', '2024-08-26 20:16:13'),
(23, 26, 1, 1, 'vvv', 'vvv', '1990-02-27', 'vv@VV.V', 'Single', NULL, '3242', NULL, '', '', '2024-08-26 20:25:04'),
(24, 29, 1, 1, 'veve', 'veve', '2000-03-01', 'veve@vve.ve', 'Single', NULL, '34324242', NULL, '', '1724676065.png', '2024-08-26 20:41:05'),
(25, 30, 1, 1, 'last na', 'last na', '1000-01-01', 'last@last.last', 'Single', NULL, '09867867864', NULL, '', '1724676345.png', '2024-08-26 20:45:45'),
(26, 31, 1, 1, 'bobo', 'bobo', '2000-03-02', 'bobo@bobo.bobo', 'Single', NULL, '564624234', NULL, '', '1724676535.png', '2024-08-26 20:48:55'),
(27, 32, 1, 1, 'hatdog', 'hatdog', '2001-02-02', 'hatdog@hatdog.sa', 'Single', NULL, '8797078086', NULL, '', '1724676722.png', '2024-08-26 20:52:02'),
(28, 33, 1, 2, 'nana', 'nana', '1980-03-09', 'nana@nana.nana', 'Single', NULL, '0979798700000078', 'haha', '66cc91da6b81d.png', '1724676998.png', '2024-08-26 20:56:38');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT 'student',
  `status` varchar(255) DEFAULT 'pending',
  `qrcode` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `qrtext` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `type`, `status`, `qrcode`, `created_at`, `qrtext`) VALUES
(1, 'admin', '$2y$10$Ji46iYwWXaCUzP9.Gd5.IebzaefcCSDwNFtrmDlYC8Ry22tkM24Hq', 'administrator', 'approved', 'admin', '2024-08-14 19:25:32', ''),
(2, 'dsa', '$2y$10$mRJpXOcC0AiHKBQZVSE2o.a8qIlok2DGa/hkOBmW.FMsYqiA.SvqK', 'student', 'approved', '', '2024-08-14 19:32:43', ''),
(3, 'karl', '$2y$10$EpkSv75hbGjbGK/yX3nToedKRhSRNLcwb7d.KV/CGowsI1vYaBOTS', 'student', 'approved', 'karl', '2024-08-14 19:33:43', ''),
(4, '1923781', '$2y$10$ZMhbwVY9n.YvvtT9p3.CvuL09/.CtNvO4DHV6hG.Bkyvv/3pTEWkG', 'student', 'pending', '', '2024-08-15 14:18:43', ''),
(5, '928391', '$2y$10$ve.rqieGus74hhPASAv0UudktsiObwshxPtmt6kaaoR3IU/Sytnhi', 'student', 'pending', '', '2024-08-15 14:28:26', ''),
(6, '992', '$2y$10$FTb7IDFj3mtvneu6udVtJOZWNVjsz/hbhuS4s2iBYhJ2H6Cu4xwJu', 'student', 'pending', '', '2024-08-15 14:36:49', ''),
(7, 'x', '$2y$10$xOedqubvV9fULvgE8T1K9OCFjVHnWDqhEL.wzU6nSxJJsF5bj22z.', 'student', 'pending', '', '2024-08-15 14:42:20', ''),
(8, 'z', '$2y$10$oNR0V/PQUkPDLtuK67jQlOScXBD5vTdC3Zez.fTRimHi9fuobGdui', 'student', 'pending', '', '2024-08-15 14:47:49', ''),
(9, 'xc', '$2y$10$OEytW6qZCocgnySGR2S3peTcVBk3arWXw9s8yUh4e7EcARqikLngS', 'student', 'pending', '', '2024-08-15 15:00:40', ''),
(10, 'c', '$2y$10$BfOjVQw/s/eBgT/vnuLfHuV8fcPqAqfjc9IyNXZdk8qUcSZHF1xJC', 'student', 'pending', '', '2024-08-15 15:07:55', ''),
(11, '231', '$2y$10$umP1BMcfdJUm7MA6xKy.Pujo8YxUILabzI/OrUxMSjVNkktj8qQBq', 'student', 'pending', '', '2024-08-15 15:42:51', ''),
(12, '2', '$2y$10$VakIzCBHTMVBHWojKXMoreecJPM/6P22ciPrabUmqbsT5Xe4l56Iy', 'student', 'pending', '', '2024-08-15 15:47:14', ''),
(13, 'xzx', '$2y$10$RNN4.kP2KV1t1tWmeIMqWeHQo.RoCHBYM6UWhV9xcQXV4tATIHdAO', 'student', 'approved', '', '2024-08-15 15:48:30', ''),
(14, '123', '$2y$10$hDT8fy4Ki5BTl1uJlZ0muOcAV52ijebfIKWyUc1t5i8HkCdzY9xAm', 'student', 'approved', '', '2024-08-15 16:03:22', ''),
(15, 'xz', '$2y$10$aFqJcQC6mz2Zd0OVAUaAXeyhpdHJNmu8qAXN5pCPOc2ofeFj/ZQZO', 'student', 'pending', '', '2024-08-15 16:06:20', ''),
(16, 'xcz', '$2y$10$OowT4Nq9c8IdRZrUZNOoV.vhb86p8E1vFK/W7xTJ9GCnV9SrU0rJm', 'student', 'pending', '', '2024-08-15 16:07:13', ''),
(17, '1231', '$2y$10$Apx/RzqQKybqMBcqLFOwmeZCqw8A8w/KcYQ1.wOulGCXeMX/k7xmm', 'student', 'pending', '', '2024-08-15 22:39:28', ''),
(18, 'haha', '$2y$10$h7qdoCqyFVMHWCrwrxRGDevV.fucYlNn0jq9NSTjKxQ0XBS3ikibe', 'student', 'pending', '', '2024-08-15 22:41:13', ''),
(19, 's', '$2y$10$4IF3lmCfxqwJv/Jkew68tO8x8AQjBHclrki5kv4ioXw7tgdQxv5rC', 'student', 'pending', '', '2024-08-17 13:34:36', ''),
(20, 'po', '$2y$10$S/SjUS6ca8G58lfMgKXLn.5f/b11dgtPw7nVivgeFY4IBQVYFKmlK', 'student', 'pending', '', '2024-08-17 19:53:21', ''),
(21, 'mimi', '$2y$10$5vdNK9vrS335tLNpRY9M8e7pfNms0PyNT38Ah0UhRJv4wgyKZCGNa', 'student', 'pending', '', '2024-08-17 20:13:56', ''),
(22, 'v', '$2y$10$zY9n36Wr1wf4edFszpwB5OlykBNSZd3ozQyR1YCY3Pdd1tf8j8Gh.', 'student', 'pending', '', '2024-08-18 12:06:31', ''),
(23, 'hehe', '$2y$10$w5OeCMlc/T1lo.8pmEp5YeQhcdZxtqH1i5m0QOkdCujcguiMUQsFy', 'student', 'approved', '', '2024-08-18 13:10:00', ''),
(25, '45', '$2y$10$toXjw9GS2bk9/uoqNWK3kO55.h7mY6DHrUM9XSQvQknx2X9gLlAlW', 'student', 'approved', '', '2024-08-26 20:16:13', ''),
(26, 'vvv', '$2y$10$eDXwSFdsu.1uugHvNCqGlO48MlURzwYEANyMFbG.VnvP.kvjyok76', 'student', 'pending', '', '2024-08-26 20:25:04', ''),
(27, 'last', '$2y$10$ODthVeNGTn/GZ3pitUjqzuHEvs7Ogt3fEojqj.IGj/HepI7mQ2.Ga', 'student', 'pending', '', '2024-08-26 20:28:09', ''),
(28, 'mm', '$2y$10$iSWcylQ8Ebe9HZd5c43l2uws0lh8GrvPW1ECaoiqtspq8fI074kIS', 'student', 'pending', '', '2024-08-26 20:35:21', ''),
(29, 'veve', '$2y$10$V.R3zTm7ytaODDd6yJiaMeZgWx/gNjTmXPNQUd1fV8Q18MneQjoai', 'student', 'pending', '', '2024-08-26 20:41:05', ''),
(30, 'last na', '$2y$10$IhxJbOTH/CYqEPYxe613m.dxB2uJ5UVanZAjhB.bcKujkWEuA4yq6', 'student', 'pending', '', '2024-08-26 20:45:45', ''),
(31, 'bobo', '$2y$10$b5Tyre.QQ5BZLS/IEyTh1uU53FPzJjvT9638jlll8gm2yKKBH/EBi', 'student', 'pending', '', '2024-08-26 20:48:55', ''),
(32, '90980980', 'hatdog', 'student', 'approved', '', '2024-08-26 20:52:02', ''),
(33, 'nana', '$2y$10$lbZuIvcUpODWbODDVOzJBOzc8dEphvpwMuFC4qlgBd0jy.KzJ6ZKW', 'student', 'approved', '', '2024-08-26 20:56:38', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `batch`
--
ALTER TABLE `batch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `announcement_id` (`announcement_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `batch` (`batch`);

--
-- Indexes for table `graduates`
--
ALTER TABLE `graduates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course` (`course`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course` (`course`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `batch` (`batch`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `batch`
--
ALTER TABLE `batch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `graduates`
--
ALTER TABLE `graduates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`announcement_id`) REFERENCES `announcements` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `gallery`
--
ALTER TABLE `gallery`
  ADD CONSTRAINT `gallery_ibfk_1` FOREIGN KEY (`batch`) REFERENCES `batch` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `graduates`
--
ALTER TABLE `graduates`
  ADD CONSTRAINT `graduates_ibfk_1` FOREIGN KEY (`course`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`course`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `students_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `students_ibfk_3` FOREIGN KEY (`batch`) REFERENCES `batch` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
