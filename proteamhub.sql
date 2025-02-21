-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 07, 2025 at 01:01 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `proteamhub`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$9AEBjFZ4gs.LNe2WXFRUrOSbiCJiJdM3nDT4JvOYrbHHzmh3OtaEK');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `company_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `company_name` varchar(255) NOT NULL,
  `company_address` varchar(255) DEFAULT NULL,
  `company_phone` varchar(20) DEFAULT NULL,
  `website_url` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `img` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`company_id`, `user_id`, `company_name`, `company_address`, `company_phone`, `website_url`, `bio`, `img`) VALUES
(8, 21, 'بيء', 'بلا', '01040922321', '', 'بر', 'img_67a532ea87a601.92723862.png');

-- --------------------------------------------------------

--
-- Table structure for table `cvs`
--

CREATE TABLE `cvs` (
  `cv_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `cv_file` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cvs`
--

INSERT INTO `cvs` (`cv_id`, `user_id`, `cv_file`, `description`, `created_at`) VALUES
(13, 6, 'cv_6749b1951bf4c6.35656800.pdf', 'fgv', '2024-11-29 11:20:37'),
(14, 6, 'cv_6749b4e9656a35.59867443.pdf', '', '2024-11-29 11:34:49'),
(15, 6, 'cv_6749b90e5f3394.52344907.pdf', 'قي', '2024-11-29 11:52:30'),
(16, 6, 'cv_6749bc005de725.76853192.pdf', '', '2024-11-29 12:05:04'),
(17, 18, 'cv_679495ef819bc4.29183633.pdf', '', '2025-01-25 06:42:39'),
(18, 19, 'cv_67a50b8e87a694.94631045.pdf', '', '2025-02-06 18:20:46');

-- --------------------------------------------------------

--
-- Table structure for table `experts`
--

CREATE TABLE `experts` (
  `expert_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `expertise_area` varchar(255) NOT NULL,
  `portfolio_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` varchar(2555) NOT NULL,
  `id` int(11) NOT NULL,
  `rebry` varchar(2555) NOT NULL,
  `user_id` int(255) NOT NULL,
  `ip_address` int(255) NOT NULL,
  `a2` int(11) NOT NULL,
  `a3` int(11) NOT NULL,
  `a4` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`username`, `email`, `message`, `id`, `rebry`, `user_id`, `ip_address`, `a2`, `a3`, `a4`) VALUES
('BlackCrow', 'sarhanmuhammad584@gmail.com', 'hello world', 1, 'no', 6, 0, 0, 0, 0),
('BlackCrow', 'sarhanmuhammad584@gmail.com', 'hello', 2, '', 6, 0, 0, 0, 0),
('BlackCrow', 'sarhanmuhammad584@gmail.com', 'jnnik', 3, '', 6, 0, 0, 0, 0),
('BlackCrow', 'sarhanmuhammad584@gmail.com', 'hello world', 4, '', 6, 0, 0, 0, 0),
('BlackCrow', 'sarhanmuhammad584@gmail.com', '', 5, '', 6, 0, 0, 0, 0),
('', 'sarhanmuhammad584@gmail.com', '', 6, '', 6, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `userid` int(255) NOT NULL,
  `idpost` int(255) NOT NULL,
  `ej` int(11) NOT NULL,
  `df` int(11) NOT NULL,
  `g` int(11) NOT NULL,
  `fd,` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `userid`, `idpost`, `ej`, `df`, `g`, `fd,`) VALUES
(39, 6, 8, 0, 0, 0, 0),
(40, 6, 9, 0, 0, 0, 0),
(41, 18, 11, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `member_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `skills` text DEFAULT NULL,
  `experience` text DEFAULT NULL,
  `img` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`member_id`, `user_id`, `skills`, `experience`, `img`) VALUES
(7, 6, 'صشيص', 'ثيلقث', 'img_6749b90e60e178.95769453.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `user_id` int(255) NOT NULL,
  `username` varchar(2555) NOT NULL,
  `new` varchar(2555) NOT NULL,
  `img` varchar(2555) NOT NULL,
  `id` int(11) NOT NULL,
  `like` varchar(2555) NOT NULL,
  `img_user` varchar(255) NOT NULL,
  `amd1` int(11) NOT NULL,
  `ad2` int(11) NOT NULL,
  `amd3` int(11) NOT NULL,
  `amd4` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`user_id`, `username`, `new`, `img`, `id`, `like`, `img_user`, `amd1`, `ad2`, `amd3`, `amd4`) VALUES
(6, 'BlackCrow', 'pormfg mdnfe oij sioefj o josdifj ei j sejfgsojp\'foh;dsefjdhdsod jsdpofjoisaejd ps OJf osjidfp pofj dsfp pods jfpo efoidjsfoik ojimio esjf wsd fdks foigj psroejp oejfkre ijgp jwo gkffwrj;gjajr\' pwjak frej; gtjrwgi rgj pworj gork ege;rkg\'ijrewkjrgjfkerjrefkjtoerwkf  rwkgo erjkfw jg ej ;gj pewofj orjkg[wpeoj opfk gworijekp gfwk fegrwojk wfeogrhg jep wjreo pweowrg ej;e owrrlew gvjfej lwa sjlwefjldjpeofrspofjers %hello%', '../../login/uploads/img_677821e774ab90.74046824.png', 8, '', 'img/default.png', 0, 0, 0, 0),
(6, 'BlackCrow', 'hello', '../../login/uploads/img_678040fbb82903.39829197.png', 9, '', 'img/default.png', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `notviation`
--

CREATE TABLE `notviation` (
  `id` int(11) NOT NULL,
  `text` varchar(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `from` varchar(255) NOT NULL,
  `Description` varchar(2555) NOT NULL,
  `img` varchar(255) NOT NULL,
  `active` int(11) NOT NULL,
  `img_not` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

CREATE TABLE `register` (
  `ID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `CodeV` varchar(255) NOT NULL,
  `verification` tinyint(1) NOT NULL DEFAULT 0,
  `phone_number` varchar(20) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `user_type` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `bio` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`ID`, `Username`, `email`, `Password`, `CodeV`, `verification`, `phone_number`, `profile_picture`, `user_type`, `created_at`, `updated_at`, `bio`) VALUES
(6, '123', 'sarhanmuhammad@gmail.com', 'nt9KiG1ar7S3V0V6P7JZ6ui31m7eIJ9G16z2lnVo7qY=', 'e130cf04543e02cd1fb386d3570efe27', 1, '201040922321', '../../login/uploads/6794882e915fc_image-removebg-preview.png', 'organizer', '2024-11-29 12:17:47', '2025-01-25 06:43:58', 'يس'),
(7, 'user1', 'user1@example.com', 'password123', 'code123', 1, '1234567890', 'profile1.jpg', 'expert', '2024-11-29 13:11:50', '2024-11-29 13:11:50', 'Bio for user1'),
(8, 'user2', 'user2@example.com', 'password123', 'code124', 1, '1234567891', 'profile2.jpg', 'expert', '2024-11-29 13:11:50', '2024-11-29 13:11:50', 'Bio for user2'),
(9, 'user3', 'user3@example.com', 'password123', 'code125', 1, '1234567892', 'profile3.jpg', 'expert', '2024-11-29 13:11:50', '2024-11-29 13:11:50', 'Bio for user3'),
(10, 'user4', 'user4@example.com', 'password123', 'code126', 1, '1234567893', 'profile4.jpg', 'expert', '2024-11-29 13:11:50', '2024-11-29 13:11:50', 'Bio for user4'),
(11, 'user5', 'user5@example.com', 'password123', 'code127', 1, '1234567894', 'profile5.jpg', 'expert', '2024-11-29 13:11:50', '2024-11-29 13:11:50', 'Bio for user5'),
(12, 'user6', 'user6@example.com', 'password123', 'code128', 1, '1234567895', 'profile6.jpg', 'expert', '2024-11-29 13:11:50', '2024-11-29 13:11:50', 'Bio for user6'),
(13, 'user7', 'user7@example.com', 'password123', 'code129', 1, '1234567896', 'profile7.jpg', 'expert', '2024-11-29 13:11:50', '2024-11-29 13:11:50', 'Bio for user7'),
(14, 'user8', 'user8@example.com', 'password123', 'code130', 1, '1234567897', 'profile8.jpg', 'expert', '2024-11-29 13:11:50', '2024-11-29 13:11:50', 'Bio for user8'),
(15, 'user9', 'user9@example.com', 'password123', 'code131', 1, '1234567898', 'profile9.jpg', 'expert', '2024-11-29 13:11:50', '2024-11-29 13:11:50', 'Bio for user9'),
(16, 'user10', 'user10@example.com', 'password123', 'code132', 1, '1234567899', 'profile10.jpg', 'expert', '2024-11-29 13:11:50', '2024-11-29 13:11:50', 'Bio for user10'),
(17, 'mohamed', 'sarhanmuhammad584@gmail.com', '1668014737c6a13aef6d4a14d06ab6fc', '9a7d45fc146ed5274a4dd2a1800aab5a', 1, '201040922321', NULL, '', '2025-01-25 00:54:55', '2025-01-25 00:58:38', NULL),
(18, 'mohamed', 'sarhanmuhammad5@gmail.com', 'WKXMx0Oxx1OSfXMreIaNXA==', 'dRBbAIj5mTE3pcrBY5EAGQ==', 1, '201040922321', '../../login/uploads/img_679495ef8398d4.94776324.png', 'organizer', '2025-01-25 07:21:52', '2025-01-25 07:42:39', 'hello'),
(19, 'Hacker', 'lagirar415@minduls.com', 'WKXMx0Oxx1OSfXMreIaNXA==', 'BUNRCR02h4k6EFrHcS1mog==', 1, '201040922321', '../../login/uploads/C:\\xampp\\tmp\\phpA057.tmp', 'expert', '2025-02-06 18:17:24', '2025-02-06 20:19:01', 'hh'),
(20, 'shadowww', 'boyinew959@intady.com', '46hXtiZ0/LqYNt6Ux2mXkAxXp7S5QksbKx/tFHoeVCg=', 'fDXHBqDEPqUvp0YUvEFnRg==', 1, '201040922321', '../../login/uploads/67a527dbc865bScreenshot 2025-01-27 200524.png', 'expert', '2025-02-06 20:25:07', '2025-02-06 21:21:31', 'بلف'),
(21, 'fdvn', 'lifokix716@minduls.com', 'VO77baqDlC1zYr6I3JD3nL4AUlY0PJEyjioVjERHXfI=', '8rjjCueAUweIOXqoIBnwmA==', 1, '201040922321', '../../login/uploads/img_67a532ea87a601.92723862.png', 'company', '2025-02-06 21:24:36', '2025-02-06 22:09:31', '1');

-- --------------------------------------------------------

--
-- Table structure for table `team_founders`
--

CREATE TABLE `team_founders` (
  `founder_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `team_name` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `img` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team_founders`
--

INSERT INTO `team_founders` (`founder_id`, `user_id`, `team_name`, `role`, `img`) VALUES
(9, 6, 'hello', 'Programming', 'img_6749bc005f7515.34602613.jpg'),
(11, 18, 'hamed', 'nrswf', 'img_679495ef8398d4.94776324.png'),
(13, 19, 'dfg', 'gfvb', 'img_67a50b8e8b3168.82415271.png');

-- --------------------------------------------------------

--
-- Table structure for table `user_chat`
--

CREATE TABLE `user_chat` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `chat_platform` varchar(50) DEFAULT NULL,
  `chat_username` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_chat`
--

INSERT INTO `user_chat` (`id`, `user_id`, `chat_platform`, `chat_username`) VALUES
(12, 20, 'fgn', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`company_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `cvs`
--
ALTER TABLE `cvs`
  ADD PRIMARY KEY (`cv_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `experts`
--
ALTER TABLE `experts`
  ADD PRIMARY KEY (`expert_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`member_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notviation`
--
ALTER TABLE `notviation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `team_founders`
--
ALTER TABLE `team_founders`
  ADD PRIMARY KEY (`founder_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_chat`
--
ALTER TABLE `user_chat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `cvs`
--
ALTER TABLE `cvs`
  MODIFY `cv_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `experts`
--
ALTER TABLE `experts`
  MODIFY `expert_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `notviation`
--
ALTER TABLE `notviation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `register`
--
ALTER TABLE `register`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `team_founders`
--
ALTER TABLE `team_founders`
  MODIFY `founder_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user_chat`
--
ALTER TABLE `user_chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `companies`
--
ALTER TABLE `companies`
  ADD CONSTRAINT `companies_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `register` (`ID`);

--
-- Constraints for table `cvs`
--
ALTER TABLE `cvs`
  ADD CONSTRAINT `cvs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `register` (`ID`);

--
-- Constraints for table `experts`
--
ALTER TABLE `experts`
  ADD CONSTRAINT `experts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `register` (`ID`);

--
-- Constraints for table `members`
--
ALTER TABLE `members`
  ADD CONSTRAINT `members_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `register` (`ID`);

--
-- Constraints for table `team_founders`
--
ALTER TABLE `team_founders`
  ADD CONSTRAINT `team_founders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `register` (`ID`);

--
-- Constraints for table `user_chat`
--
ALTER TABLE `user_chat`
  ADD CONSTRAINT `user_chat_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `register` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
