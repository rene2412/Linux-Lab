-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 02, 2025 at 12:59 AM
-- Server version: 10.11.11-MariaDB-0ubuntu0.24.04.2
-- PHP Version: 8.3.6

-- Create and select the database
CREATE DATABASE IF NOT EXISTS `Linux_Lab`;
USE `Linux_Lab`;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Drop existing tables if they exist
DROP TABLE IF EXISTS `user_global_comments`;
DROP TABLE IF EXISTS `user_lessons`;
DROP TABLE IF EXISTS `user_progress`;
DROP TABLE IF EXISTS `lessons`;
DROP TABLE IF EXISTS `users`;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Linux_Lab`
--

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `id` int(11) NOT NULL,
  `lesson_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`id`, `lesson_name`) VALUES
(1, 'The Command Line'),
(2, 'The Filesystem'),
(3, 'echo'),
(4, 'date'),
(5, 'pwd'),
(6, 'ls'),
(7, 'cd'),
(8, 'cat'),
(9, 'cd ..'),
(10, 'cd path/to/source'),
(11, 'Knowledge Check #1'),
(12, 'Knowledge Check #2'),
(13, 'Knowledge Check #3'),
(14, 'touch'),
(15, 'mkdir'),
(16, 'rm'),
(17, 'rmdir'),
(18, 'rm -rf'),
(19, 'mv'),
(20, 'mv'),
(21, 'mv'),
(22, 'Knowledge Check #4'),
(23, 'Knowledge Check #5'),
(24, 'Knowledge Check #6'),
(25, 'Knowledge Check #7'),
(26, 'Knowledge Check #8'),
(27, 'Knowledge Check #9'),
(28, 'Knowledge Check #10'),
(29, 'Searching & Filtering'),
(30, 'grep'),
(31, 'grep \"pattern\" file'),
(32, 'grep -n \"pattern\" file'),
(33, 'grep -c \"pattern\" file'),
(34, 'wildcard*'),
(35, 'find'),
(36, 'find path/to/source -name filename.txt'),
(37, 'find path/to/source -name directory'),
(38, 'The Output Redirection Operators: \'>\', \'>>\''),
(39, 'The Overwrite Operator: \'>\''),
(40, 'The Appending Operator: \'>>\''),
(41, 'Knowledge Check #11'),
(42, 'Knowledge Check #12'),
(43, 'Knowledge Check #13'),
(44, 'Knowledge Check #14'),
(45, 'Knowledge Check #15'),
(46, 'Lab #5'),
(47, 'Lab #6'),
(48, 'Lab #7'),
(49, 'Lab #8'),
(50, 'Lab #9'),
(51, 'Permissions In Linux'),
(52, 'ls -l'),
(53, 'chmod'),
(54, 'sudo'),
(55, 'chmod: change user permissions'),
(56, 'chmod: change group permissions'),
(57, 'chown'),
(58, 'chowm: change owner of a file'),
(59, 'Knowledge Check'),
(60, 'Knowledge Check #16'),
(61, 'Knowledge Check #17'),
(62, 'Knowledge Check #18'),
(63, 'Knowledge Check 19'),
(64, 'Lab #10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `is_logged_in` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `pwd`, `is_logged_in`) VALUES
(1, 'rene2412', 'hrene2412@gmail.com', '$2y$12$8blXBTmQ/Iqf7EF7jrYjY.JYXPsHxV/FLqlU03ZgirJ64MW3/TyCu', 1),
(2, 'herb1', 'herbart@mail.fresnostate.edu', '$2y$12$zOP8ZjexXrmAQDginFT7Te.eA4ULZ.4xTdfDen96q1QuzvPSAM00y', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_global_comments`
--

CREATE TABLE `user_global_comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `modified` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_lessons`
--

CREATE TABLE `user_lessons` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `completed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_progress`
--

CREATE TABLE `user_progress` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `lessons_completed` int(11) NOT NULL,
  `current_lesson` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_global_comments`
--
ALTER TABLE `user_global_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_lessons`
--
ALTER TABLE `user_lessons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `lesson_id` (`lesson_id`);

--
-- Indexes for table `user_progress`
--
ALTER TABLE `user_progress`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_global_comments`
--
ALTER TABLE `user_global_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_lessons`
--
ALTER TABLE `user_lessons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `user_progress`
--
ALTER TABLE `user_progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_global_comments`
--
ALTER TABLE `user_global_comments`
  ADD CONSTRAINT `user_global_comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_lessons`
--
ALTER TABLE `user_lessons`
  ADD CONSTRAINT `user_lessons_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_lessons_ibfk_2` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_progress`
--
ALTER TABLE `user_progress`
  ADD CONSTRAINT `user_progress_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET CHARACTER_SET_CONNECTION=@OLD_COLLATION_CONNECTION */;