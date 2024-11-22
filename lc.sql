-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 22, 2024 at 08:27 AM
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
-- Database: `lc`
--

-- --------------------------------------------------------

--
-- Table structure for table `achievements`
--

CREATE TABLE `achievements` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `achievements`
--

INSERT INTO `achievements` (`id`, `name`, `created_at`) VALUES
(1, 'Magna Cum Laude', '2024-09-27 21:34:23'),
(2, 'Summa Cum Laude', '2024-09-27 21:34:23'),
(3, 'Cum Laude', '2024-09-27 21:34:23');

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
(2, '2016 - 2017', '2024-08-17 20:22:37'),
(3, '2017 - 2018', '2024-08-17 20:22:48'),
(5, '2019 - 2020', '2024-08-26 23:43:38'),
(6, '2020 - 2021', '2024-08-26 23:43:50'),
(7, '2021 - 2022', '2024-08-26 23:43:57'),
(8, '2022 - 2023', '2024-08-26 23:44:06'),
(9, '2003 - 2004', '2024-09-14 10:57:57');

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
(2, 'Bachelor of Science in Information Technology', '2024-08-14 19:31:42'),
(5, 'Bachelor of Science in Information System', '2024-09-18 12:24:17'),
(6, 'hahaaha', '2024-09-22 12:58:24');

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
-- Table structure for table `majors`
--

CREATE TABLE `majors` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `major_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `majors`
--

INSERT INTO `majors` (`id`, `course_id`, `major_name`) VALUES
(7, 5, 'Networking'),
(8, 5, 'CSS'),
(9, 6, '');

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
  `phone` varchar(16) DEFAULT NULL,
  `present_address` varchar(255) DEFAULT NULL,
  `file` varchar(255) NOT NULL,
  `profile_pic` varchar(255) NOT NULL,
  `qrimage` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `major_id` int(11) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'inactive',
  `work` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `motto` varchar(255) DEFAULT NULL,
  `achievement_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `user_id`, `course`, `batch`, `firstname`, `lastname`, `birthdate`, `email`, `civil`, `phone`, `present_address`, `file`, `profile_pic`, `qrimage`, `created_at`, `major_id`, `status`, `work`, `company`, `motto`, `achievement_id`) VALUES
(34, 41, 1, 9, 'jusko12', 'jusko12', '1990-02-02', 'jusko12@jusko.jusko', 'Single', '0928317847', 'sa may kanto', 'Screenshot 2024-09-09 145621.png', '66e94107c2dcf.png', '1726500280.png', '2024-09-16 23:24:40', NULL, 'inactive', NULL, NULL, NULL, 1),
(36, 44, 1, 9, 'totoo na', 'totoo na', '2100-04-03', 'karl.ilao18@gmail.com', 'Single', '02931823176', NULL, 'Screenshot 2024-09-05 140522.png', '66f3dc7e65e12_WIN_20240824_12_23_40_Pro.jpg', '1726629195.png', '2024-09-18 11:13:15', NULL, 'inactive', NULL, NULL, NULL, 1),
(38, 46, 5, 9, 'karl', 'karl', '3101-02-09', 'karl@karl.karl', 'Single', '90348923942', 'kanto', 'Screenshot 2024-09-04 140029.png', '66f6aa7b43765.png', '1726715553.png', '2024-09-19 11:12:33', 8, 'inactive', 'tambay', 'dine lang', NULL, 1),
(55, 61, 5, 2, 'Eljay', 'Rosal', '2010-11-01', 'rosaleljay@gmail.com', 'Married', '09876543567', NULL, '376518229_689386399351681_7185754624885538493_n__2_-removebg-preview (1).png', '../../assets/img/person.png', '1732228396.png', '2024-11-22 06:33:16', 7, 'inactive', NULL, NULL, NULL, NULL),
(56, 63, 2, 2, 'John Lester', 'Osabel', '2024-11-22', NULL, NULL, NULL, 'Dulangan, San Luis', '', '376518229_689386399351681_7185754624885538493_n__2_-removebg-preview.png', '', '2024-11-22 06:42:18', NULL, 'active', NULL, NULL, 'e Relax mo lang', 1);

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
(30, 'last na', '$2y$10$IhxJbOTH/CYqEPYxe613m.dxB2uJ5UVanZAjhB.bcKujkWEuA4yq6', 'student', 'approved', '', '2024-08-26 20:45:45', ''),
(41, 'jusko12', '$2y$10$cajKRkqFUnPJxgWyKbMggO3DxieWkUcw6cOrMg7zeYI2KgZRHrwpe', 'student', 'pending', '', '2024-09-16 23:24:40', ''),
(44, 'gegegege', '$2y$10$C6HjKu8z8dsDuOsTb4Ffa.URDvb1LsVGAZ.b3VwenCAl0MtngZfXC', 'student', 'declined', '', '2024-09-18 11:13:15', ''),
(46, 'karl', '$2y$10$0TjeeOl3E3x5Y0lOgZYJce/KOOuTH7YZnNDo8sFarpY8wND0s2FLK', 'student', 'approved', '', '2024-09-19 11:12:33', ''),
(47, '123456', '$2y$10$qbg/HjiNyHYcE4oOOtvlge/IGMmykcn/CYMPuiJQ5du..2bAKAw1e', 'student', 'approved', '', '2024-09-19 11:27:56', ''),
(61, '8383453', '$2y$10$9h6VgznJdWTRcThs/mJsSuJC0n61OVLo5unz9KsWlMWtk4MzG.Dq6', 'student', 'approved', '', '2024-11-22 06:33:16', ''),
(62, 'john lester.osabel683', '$2y$10$Tk3EtqZMxxU/hnfklKAkxulF6pLWlv66pnwsPX6eVK94gz9G2KU/y', 'student', 'pending', '', '2024-11-22 06:41:13', ''),
(63, '1234', '$2y$10$PJ8XC4lRlbpuin.7Kb9l7uRQoz5tvctpmDsbu13mX5.lHS01o0stS', 'student', 'pending', '', '2024-11-22 06:42:18', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `achievements`
--
ALTER TABLE `achievements`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `majors`
--
ALTER TABLE `majors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course` (`course`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `batch` (`batch`),
  ADD KEY `fk_major` (`major_id`),
  ADD KEY `fk_achievement_id` (`achievement_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `achievements`
--
ALTER TABLE `achievements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `batch`
--
ALTER TABLE `batch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
-- AUTO_INCREMENT for table `majors`
--
ALTER TABLE `majors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

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
-- Constraints for table `majors`
--
ALTER TABLE `majors`
  ADD CONSTRAINT `majors_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `fk_achievement_id` FOREIGN KEY (`achievement_id`) REFERENCES `achievements` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_major` FOREIGN KEY (`major_id`) REFERENCES `majors` (`id`),
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`course`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `students_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `students_ibfk_3` FOREIGN KEY (`batch`) REFERENCES `batch` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
