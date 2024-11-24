-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 24, 2024 at 08:43 PM
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

-- --------------------------------------------------------

--
-- Table structure for table `alumnigallery`
--

CREATE TABLE `alumnigallery` (
  `ID` int(11) NOT NULL,
  `FIRSTNAME` varchar(255) NOT NULL,
  `MIDDLENAME` varchar(255) NOT NULL,
  `LASTNAME` varchar(255) NOT NULL,
  `BIRTHDATE` varchar(255) NOT NULL,
  `ADDRESS` varchar(255) NOT NULL,
  `COURSE` varchar(255) NOT NULL,
  `BATCHDATE` varchar(255) NOT NULL,
  `MOTTO` varchar(255) NOT NULL,
  `IMAGE` text NOT NULL,
  `ACHIEVEMENT_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alumnigallery`
--

INSERT INTO `alumnigallery` (`ID`, `FIRSTNAME`, `MIDDLENAME`, `LASTNAME`, `BIRTHDATE`, `ADDRESS`, `COURSE`, `BATCHDATE`, `MOTTO`, `IMAGE`, `ACHIEVEMENT_ID`) VALUES
(12, 'Eljay', 'Pogi', 'Rosal', '2001-11-11', 'Sta. Cruz Agoncillo Batangas', '2', '8', 'Lulu lang', 'ssrs.png', 1),
(13, 'Eljay', 'Salsal', 'Rosal', '2001-11-11', 'Bangin San Nicolas Batangas', '2', '8', 'Lulu lang', 'ssrs.png', 2),
(14, 'Eljay', 'Salsal', 'Rosal', '2001-11-11', 'Bangin San Nicolas Batangas', '2', '8', 'Lulu lang', 'ssrs.png', 2),
(15, 'Eljay', 'Salsal', 'Rosal', '2001-11-11', 'Bangin San Nicolas Batangas', '2', '8', 'Lulu lang', 'ssrs.png', 2),
(16, 'Eljay', 'Pogi', 'Rosal', '2001-11-11', 'Sta. Cruz Agoncillo Batangas', '2', '8', 'Lulu lang', 'ssrs.png', 1),
(17, 'Eljay', 'Salsal', 'Rosal', '2001-11-11', 'Bangin San Nicolas Batangas', '2', '8', 'Lulu lang', 'ssrs.png', 2),
(18, 'Eljay', 'Salsal', 'Rosal', '2001-11-11', 'Bangin San Nicolas Batangas', '2', '8', 'Lulu lang', 'ssrs.png', 2),
(19, 'Eljay', 'Salsal', 'Rosal', '2001-11-11', 'Bangin San Nicolas Batangas', '2', '8', 'Lulu lang', 'ssrs.png', 2);

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
(11, '2022-2023', '2024-11-25 03:36:47');

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
(5, 'Bachelor of Science in Information System', '2024-09-18 12:24:17');

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
(12, 1, '');

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
  `achievement_id` int(11) DEFAULT NULL,
  `middlename` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(65, 'admin', '$2y$10$dulIPhgcWde7BlR2uEg7k.WeFybBx/c9T1Z78Dt0m3XY8.mDNTKqa', 'administrator', 'approved', '', '2024-11-24 21:18:10', ''),
(66, '202011084', '$2y$10$vHGz6xzwyc5NGfzYbi7DR.xE/uYgy/fZH0yHbinAEHHYepJJKTgNm', 'student', 'approved', '', '2024-11-24 21:18:11', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `achievements`
--
ALTER TABLE `achievements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `alumnigallery`
--
ALTER TABLE `alumnigallery`
  ADD PRIMARY KEY (`ID`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `alumnigallery`
--
ALTER TABLE `alumnigallery`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `batch`
--
ALTER TABLE `batch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

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
