-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 22, 2024 at 02:39 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `batch`
--

INSERT INTO `batch` (`id`, `year`, `created_at`) VALUES
(1, '2015 - 2016', '0000-00-00 00:00:00'),
(2, '2016 - 2017', '2024-08-17 20:22:37'),
(3, '2017 - 2018', '2024-08-17 20:22:48');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `children` int(11) DEFAULT NULL,
  `phone` varchar(16) DEFAULT NULL,
  `present_address` varchar(255) DEFAULT NULL,
  `work_address` varchar(255) DEFAULT NULL,
  `profile_pic` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `user_id`, `course`, `batch`, `firstname`, `lastname`, `birthdate`, `email`, `civil`, `graduated`, `children`, `phone`, `present_address`, `work_address`, `profile_pic`, `created_at`) VALUES
(1, 2, 2, 1, 'asda', 'dsad', '2001-08-14', 'asdas@sdad.sa', 'Single', '2024-06-14', 0, '092371826381', 'asdasd asdasdad', ' asda dadasdsa', '', '2024-08-14 19:32:43'),
(2, 3, 1, NULL, 'karl', 'karl', '0001-02-21', 'karl@karl.com', 'Single', '2023-05-03', 0, '092371862371', 'kjshbndkjadashasjkd asedas ', 'hajskdha jklhdsjka', '', '2024-08-14 19:33:43'),
(3, 4, 1, NULL, 'qwer', 'qwer', '2000-05-25', 'mark@mark.com', 'Married', '2020-06-21', 1, '09782376186', 'sdjakdasndkajsn akjsd asdnjak', ' askdn jkadnakjsdnaskjdas', '', '2024-08-15 14:18:43'),
(4, 5, 2, NULL, 'qwert', 'qwert', '1952-05-21', 'k@k.com', 'Single', '2000-05-21', 4, '0923817', 'askljdakshldahkj', 'akjsdhbajksdahsjka', '', '2024-08-15 14:28:26'),
(5, 6, 1, NULL, 'zxc', 'zxc', '1980-07-25', 'zxc@as.zx', 'Married', '2001-05-21', 2, '092371827', 'asdadasd adasdasd', 'a sd asda dsa', '', '2024-08-15 14:36:49'),
(6, 7, 1, NULL, 'x', 'x', '2001-01-21', 'x@x.x', 'Widow', '2023-02-02', 2, '09237182731', 'adkajdsak djaskdajk ', ' jkasdjk', '', '2024-08-15 14:42:20'),
(7, 8, 1, NULL, 'z', 'z', '0000-00-00', 'z@z.z', 'Single', '2022-02-02', 0, '092222222', '22', '222', '', '2024-08-15 14:47:49'),
(8, 9, 1, NULL, 'c', 'c', '2001-02-22', 'x@x.x', 'Single', '2024-02-27', 2, '0923189', 'jh', 'nj', '', '2024-08-15 15:00:41'),
(9, 10, 2, NULL, 'c', 'c', '1980-05-02', '2@s.s', 'Married', '2000-05-02', 2, '0978236816281', 'dhbasjbdajd ', 'ahjsbdhjasbdahjs', '', '2024-08-15 15:07:55'),
(10, 11, 1, NULL, 'a', 'a', '2000-02-21', '2@2.s', 'Single', '2023-04-21', 1, '09427841782', '7878hjkbnjk jkb ', 'bjkbjkbkj', '', '2024-08-15 15:42:51'),
(11, 12, 1, NULL, '2', '2', '2000-05-21', '2@2.s', 'Single', '2024-05-21', 2, '094271878', '878 asda dasd', '67d adasas', '', '2024-08-15 15:47:15'),
(12, 13, 1, NULL, '124', '543', '2000-06-21', '231@sa.sa', 'Single', '2023-05-21', 1, '0942871972381', 'asduiashdiu ahdasuid', 'anhsiudahsd iuasda', '', '2024-08-15 15:48:30'),
(13, 14, 1, NULL, '123', '123', '2000-12-03', '123@123.123', 'Single', '2023-12-03', 123, '09123123123', '123 123', '123', '', '2024-08-15 16:03:22'),
(14, 15, 1, NULL, 'xz', 'xz', '2000-02-23', '23@23.cs', 'Single', '2024-05-21', 2, '092318271', 'hkasjdjkas', 'sdfs', '', '2024-08-15 16:06:20'),
(15, 16, 1, NULL, 'zxc', 'zxc', '2001-04-21', 'asda@saxf.sa', 'Single', '2024-06-12', 1, '0924178y6', 'asda', 'asd', '', '2024-08-15 16:07:13'),
(16, 17, 1, NULL, 'a', 'a', '2000-04-21', '2@s.s', 'Single', '2024-05-21', 1, '029312', 'sdfds', 'sfsdfs', '', '2024-08-15 22:39:28'),
(17, 18, 1, NULL, 'haha', 'haha', '1921-05-21', 'haha@hgaha.sa', 'Single', '2000-05-21', 2, '4214', '24', '42', '', '2024-08-15 22:41:13'),
(18, 20, 1, NULL, 'po', 'po', '1990-07-05', 'po@po.po', 'Single', NULL, 0, '08', '4', '4', '', '2024-08-17 19:53:21'),
(19, 21, 1, 1, 'mimi', 'mimi', '1820-05-31', 'li@li.s', 'Single', NULL, 2, '2', 's', 's', '', '2024-08-17 20:13:56'),
(20, 22, 1, 3, 'v', 'v', '2000-04-21', '2@2.2', 'Single', NULL, 2, '092371827381', '2', '2', '', '2024-08-18 12:06:31'),
(21, 23, 2, 2, 'hehe', 'hehe', '1990-01-21', 'heh@hehe.he', 'Married', NULL, 1, '2', 'sda', 'dsa', '', '2024-08-18 13:10:00');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `type`, `status`, `qrcode`, `created_at`, `qrtext`) VALUES
(1, 'admin', '$2y$10$Ji46iYwWXaCUzP9.Gd5.IebzaefcCSDwNFtrmDlYC8Ry22tkM24Hq', 'administrator', 'approved', 'admin', '2024-08-14 19:25:32', ''),
(2, 'dsa', '$2y$10$mRJpXOcC0AiHKBQZVSE2o.a8qIlok2DGa/hkOBmW.FMsYqiA.SvqK', 'student', 'pending', '', '2024-08-14 19:32:43', ''),
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
(14, '123', '$2y$10$hDT8fy4Ki5BTl1uJlZ0muOcAV52ijebfIKWyUc1t5i8HkCdzY9xAm', 'student', 'pending', '', '2024-08-15 16:03:22', ''),
(15, 'xz', '$2y$10$aFqJcQC6mz2Zd0OVAUaAXeyhpdHJNmu8qAXN5pCPOc2ofeFj/ZQZO', 'student', 'pending', '', '2024-08-15 16:06:20', ''),
(16, 'xcz', '$2y$10$OowT4Nq9c8IdRZrUZNOoV.vhb86p8E1vFK/W7xTJ9GCnV9SrU0rJm', 'student', 'pending', '', '2024-08-15 16:07:13', ''),
(17, '1231', '$2y$10$Apx/RzqQKybqMBcqLFOwmeZCqw8A8w/KcYQ1.wOulGCXeMX/k7xmm', 'student', 'pending', '', '2024-08-15 22:39:28', ''),
(18, 'haha', '$2y$10$h7qdoCqyFVMHWCrwrxRGDevV.fucYlNn0jq9NSTjKxQ0XBS3ikibe', 'student', 'pending', '', '2024-08-15 22:41:13', ''),
(19, 's', '$2y$10$4IF3lmCfxqwJv/Jkew68tO8x8AQjBHclrki5kv4ioXw7tgdQxv5rC', 'student', 'pending', '', '2024-08-17 13:34:36', ''),
(20, 'po', '$2y$10$S/SjUS6ca8G58lfMgKXLn.5f/b11dgtPw7nVivgeFY4IBQVYFKmlK', 'student', 'pending', '', '2024-08-17 19:53:21', ''),
(21, 'mimi', '$2y$10$5vdNK9vrS335tLNpRY9M8e7pfNms0PyNT38Ah0UhRJv4wgyKZCGNa', 'student', 'pending', '', '2024-08-17 20:13:56', ''),
(22, 'v', '$2y$10$zY9n36Wr1wf4edFszpwB5OlykBNSZd3ozQyR1YCY3Pdd1tf8j8Gh.', 'student', 'pending', '', '2024-08-18 12:06:31', ''),
(23, 'hehe', '$2y$10$w5OeCMlc/T1lo.8pmEp5YeQhcdZxtqH1i5m0QOkdCujcguiMUQsFy', 'student', 'pending', '', '2024-08-18 13:10:00', '');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

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
