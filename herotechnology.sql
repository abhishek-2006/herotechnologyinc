-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 21, 2026 at 12:53 PM
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
-- Database: `herotechnology`
--

-- --------------------------------------------------------

--
-- Table structure for table `corporate_clients`
--

CREATE TABLE `corporate_clients` (
  `client_id` int(11) NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `industry_sector` varchar(100) DEFAULT 'General Engineering',
  `is_featured` tinyint(1) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `corporate_clients`
--

INSERT INTO `corporate_clients` (`client_id`, `client_name`, `industry_sector`, `is_featured`, `status`, `created_at`) VALUES
(1, 'AT&T', 'General Engineering', 1, 'active', '2026-01-18 05:07:31'),
(2, 'Pfizer', 'General Engineering', 1, 'active', '2026-01-18 05:07:31'),
(3, 'GMAC', 'General Engineering', 0, 'active', '2026-01-18 05:07:31'),
(4, 'Texas Instruments', 'General Engineering', 1, 'active', '2026-01-18 05:07:31'),
(5, 'Citigroup', 'General Engineering', 1, 'active', '2026-01-18 05:07:31'),
(6, 'Armstrong', 'General Engineering', 0, 'active', '2026-01-18 05:07:31'),
(7, 'Nestle', 'General Engineering', 1, 'active', '2026-01-18 05:07:31'),
(8, 'HYLSAOMEX', 'General Engineering', 0, 'active', '2026-01-18 05:07:31'),
(9, 'MINOLTA', 'General Engineering', 0, 'active', '2026-01-18 05:07:31'),
(10, 'Johnson', 'General Engineering', 0, 'active', '2026-01-18 05:07:31'),
(11, 'BASF', 'General Engineering', 1, 'active', '2026-01-18 05:07:31'),
(12, 'Heineken', 'General Engineering', 0, 'active', '2026-01-18 05:07:31'),
(13, 'Bayer', 'General Engineering', 1, 'active', '2026-01-18 05:07:31'),
(14, 'RANBAXY', 'General Engineering', 0, 'active', '2026-01-18 05:07:31'),
(15, 'BOSCH', 'General Engineering', 1, 'active', '2026-01-18 05:07:31'),
(16, 'STONGGLY', 'General Engineering', 0, 'active', '2026-01-18 05:07:31'),
(17, 'FannieMae', 'General Engineering', 1, 'active', '2026-01-18 05:07:31'),
(18, 'WebMD', 'General Engineering', 0, 'active', '2026-01-18 05:07:31'),
(19, 'Wellmark', 'General Engineering', 0, 'active', '2026-01-18 05:07:31'),
(20, 'CISCO', 'General Engineering', 1, 'active', '2026-01-18 05:07:31'),
(21, 'Genentech', 'General Engineering', 0, 'active', '2026-01-18 05:07:31'),
(22, 'Capital Group', 'General Engineering', 0, 'active', '2026-01-18 05:07:31'),
(23, 'RCI', 'General Engineering', 0, 'active', '2026-01-18 05:07:31'),
(24, 'WELLS FARGO', 'General Engineering', 1, 'active', '2026-01-18 05:07:31'),
(25, 'Imagination', 'General Engineering', 0, 'active', '2026-01-18 05:07:31'),
(26, 'mxenergy', 'General Engineering', 0, 'active', '2026-01-18 05:07:31'),
(27, 'JCPenney', 'General Engineering', 0, 'active', '2026-01-18 05:07:31'),
(28, 'BT', 'General Engineering', 1, 'active', '2026-01-18 05:07:31'),
(29, 'Hitachi', 'General Engineering', 1, 'active', '2026-01-18 05:07:31'),
(30, 'Autodesk', 'General Engineering', 1, 'active', '2026-01-18 05:07:31'),
(31, 'Energizer', 'General Engineering', 0, 'active', '2026-01-18 05:07:31'),
(32, 'Citi', 'General Engineering', 1, 'active', '2026-01-18 05:07:31'),
(33, 'Verizon', 'General Engineering', 1, 'active', '2026-01-18 05:07:31'),
(34, 'babycenter', 'General Engineering', 0, 'active', '2026-01-18 05:07:31'),
(35, 'Bea', 'General Engineering', 0, 'active', '2026-01-18 05:07:31'),
(36, 'NaviSite', 'General Engineering', 0, 'active', '2026-01-18 05:07:31');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `instructor_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `video_url` text DEFAULT NULL,
  `video_file` varchar(255) DEFAULT NULL,
  `demo_video_url` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `status` enum('publish','draft') DEFAULT 'publish',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `category_id`, `instructor_id`, `title`, `description`, `video_url`, `video_file`, `demo_video_url`, `price`, `thumbnail`, `status`, `created_at`) VALUES
(1, 1, 1, 'Mastering C Programming', 'Complete C course from basics to advanced', 'https://www.youtube.com/watch?v=xND0t1pr3KY', '', 'https://www.youtube.com/watch?v=xND0t1pr3KY', 1999.00, 'c.jpg', 'publish', '2026-01-01 06:06:05'),
(2, 2, 1, 'Full Stack Web Dev', 'HTML CSS JS PHP MySQL complete journey', '', '', NULL, 4999.00, 'web.jpg', 'publish', '2026-01-01 06:06:05'),
(3, 1, 1, 'Full-Stack Web Development with PHP & MySQL', 'Learn to build dynamic websites with PHP and MySQL from scratch', '', '', NULL, 3999.00, 'php_fullstack.png', 'publish', '2026-01-01 13:58:14'),
(4, 5, 1, 'AI & Machine Learning Mastery: From Zero to Real-World Models', 'Learn how modern AI systems actually work — not just theory. This course takes you from core Machine Learning concepts to hands-on model building using real datasets. You’ll understand algorithms, train models, evaluate performance, and deploy basic AI solutions used in industry today.', 'https://www.youtube.com/watch?v=wnqkfpCpK1g', '', NULL, 5999.00, '1768717592_ai_ml.png', 'publish', '2026-01-18 06:26:32');

-- --------------------------------------------------------

--
-- Table structure for table `course_category`
--

CREATE TABLE `course_category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_category`
--

INSERT INTO `course_category` (`category_id`, `category_name`, `status`) VALUES
(1, 'Programming', 'active'),
(2, 'Web Development', 'active'),
(3, 'UI/UX Design', 'active'),
(4, 'Cyber Security', 'active'),
(5, 'Artificial Intelligence & Machine Learning', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `course_progress`
--

CREATE TABLE `course_progress` (
  `progress_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `lesson_id` int(11) DEFAULT NULL,
  `is_completed` tinyint(1) DEFAULT 0,
  `completed_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course_reviews`
--

CREATE TABLE `course_reviews` (
  `review_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `review` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_reviews`
--

INSERT INTO `course_reviews` (`review_id`, `user_id`, `course_id`, `rating`, `review`, `created_at`) VALUES
(1, 2, 1, 5, 'Amazing course! Loved it.', '2026-01-01 06:10:14'),
(2, 3, 2, 4, 'Very helpful for beginners.', '2026-01-01 06:10:14');

-- --------------------------------------------------------

--
-- Table structure for table `course_sections`
--

CREATE TABLE `course_sections` (
  `section_id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `section_title` varchar(255) DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_sections`
--

INSERT INTO `course_sections` (`section_id`, `course_id`, `section_title`, `sort_order`) VALUES
(1, 1, 'Introduction to C', 1),
(2, 1, 'Pointers & Memory', 2),
(3, 2, 'Frontend Basics', 1),
(4, 2, 'Backend with PHP', 2);

-- --------------------------------------------------------

--
-- Table structure for table `demo_usage_logs`
--

CREATE TABLE `demo_usage_logs` (
  `log_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `device_fingerprint` varchar(255) DEFAULT NULL,
  `course_id` int(11) NOT NULL,
  `minutes_watched` float DEFAULT 0,
  `last_access` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `enrollment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `enrolled_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','active','completed','cancelled') DEFAULT 'pending',
  `txnid` varchar(100) DEFAULT NULL,
  `activated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `lesson_id` int(11) NOT NULL,
  `section_id` int(11) DEFAULT NULL,
  `lesson_title` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`lesson_id`, `section_id`, `lesson_title`, `video_url`, `duration`) VALUES
(1, 1, 'What is C Programming?', 'intro_c.mp4', 10),
(2, 1, 'Variables & Data Types', 'variables.mp4', 15),
(3, 3, 'HTML Basics', 'html.mp4', 20);

-- --------------------------------------------------------

--
-- Table structure for table `login_tracking`
--

CREATE TABLE `login_tracking` (
  `login_tracking_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `is_online` enum('online','offline') DEFAULT NULL,
  `tracking_datetime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `enrollment_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_status` enum('success','failed','pending') DEFAULT 'success',
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_method` enum('Cash','UPI','Card','NetBanking','Wallet') NOT NULL DEFAULT 'Cash',
  `transaction_id` varchar(100) NOT NULL,
  `error_log` varchar(100) DEFAULT NULL,
  `gateway_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `security_questions`
--

CREATE TABLE `security_questions` (
  `id` int(11) NOT NULL,
  `question_text` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `security_questions`
--

INSERT INTO `security_questions` (`id`, `question_text`) VALUES
(1, 'What was the name of your first pet?'),
(2, 'What is your mother\'s maiden name?'),
(3, 'What was the name of your first car?'),
(4, 'What was the name of your elementary school?'),
(5, 'In which city were you born?'),
(6, 'Which is your favorite city?'),
(7, 'Which is your favorite country?'),
(8, 'Who is your favorite actor?'),
(9, 'Which is your favorite movie?'),
(10, 'What was the first company you ever worked for?'),
(11, 'Where did you go for your first international trip?'),
(12, 'What was your dream job when you were a child?');

-- --------------------------------------------------------

--
-- Table structure for table `user_master`
--

CREATE TABLE `user_master` (
  `user_id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `gender` enum('male','female','other') NOT NULL,
  `password` varchar(50) DEFAULT NULL,
  `role` enum('student','admin','manager') DEFAULT 'student',
  `datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('publish','draft') DEFAULT 'publish'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_master`
--

INSERT INTO `user_master` (`user_id`, `name`, `username`, `phone`, `email`, `gender`, `password`, `role`, `datetime`, `status`) VALUES
(1, 'Abhishek', 'abs123', '1203456789', 'abhishek@hero.com', 'male', '202cb962ac59075b964b07152d234b70', 'admin', '2026-02-14 07:06:20', 'publish'),
(2, 'Test', 'test1', '3012456987', 'test@gmail.com', 'male', '202cb962ac59075b964b07152d234b70', 'student', '2026-02-14 12:01:16', 'publish'),
(3, 'Mina', 'mbshah12', '1230457896', 'mina@gmail.com', 'female', '81dc9bdb52d04dc20036dbd8313ed055', 'student', '2026-02-14 07:06:28', 'publish'),
(4, 'Demo', 'demo1', '1234567890', 'demo@gmail.com', 'male', '202cb962ac59075b964b07152d234b70', 'student', '2026-02-14 11:48:55', 'publish');

-- --------------------------------------------------------

--
-- Table structure for table `user_security_answers`
--

CREATE TABLE `user_security_answers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_security_answers`
--

INSERT INTO `user_security_answers` (`id`, `user_id`, `question_id`, `answer_hash`, `created_at`) VALUES
(1, 4, 2, 'c286b9545aaf7fdedebee6e2c526bf14', '2026-02-14 11:53:53'),
(2, 4, 5, '9ed244e30701f591f8859cde5ee71b8c', '2026-02-14 11:53:53'),
(3, 4, 9, '95ff712b4813b5376c1757b2e634eaae', '2026-02-14 11:53:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `corporate_clients`
--
ALTER TABLE `corporate_clients`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `instructor_id` (`instructor_id`);

--
-- Indexes for table `course_category`
--
ALTER TABLE `course_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `course_progress`
--
ALTER TABLE `course_progress`
  ADD PRIMARY KEY (`progress_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `lesson_id` (`lesson_id`);

--
-- Indexes for table `course_reviews`
--
ALTER TABLE `course_reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `course_sections`
--
ALTER TABLE `course_sections`
  ADD PRIMARY KEY (`section_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `demo_usage_logs`
--
ALTER TABLE `demo_usage_logs`
  ADD PRIMARY KEY (`log_id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`course_id`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`enrollment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`lesson_id`),
  ADD KEY `section_id` (`section_id`);

--
-- Indexes for table `login_tracking`
--
ALTER TABLE `login_tracking`
  ADD PRIMARY KEY (`login_tracking_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `fk_payment_enrollment` (`enrollment_id`);

--
-- Indexes for table `security_questions`
--
ALTER TABLE `security_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_master`
--
ALTER TABLE `user_master`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- Indexes for table `user_security_answers`
--
ALTER TABLE `user_security_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `question_id` (`question_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `corporate_clients`
--
ALTER TABLE `corporate_clients`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `course_category`
--
ALTER TABLE `course_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `course_progress`
--
ALTER TABLE `course_progress`
  MODIFY `progress_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `course_reviews`
--
ALTER TABLE `course_reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `course_sections`
--
ALTER TABLE `course_sections`
  MODIFY `section_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `demo_usage_logs`
--
ALTER TABLE `demo_usage_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `enrollment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `lesson_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `login_tracking`
--
ALTER TABLE `login_tracking`
  MODIFY `login_tracking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `security_questions`
--
ALTER TABLE `security_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user_master`
--
ALTER TABLE `user_master`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_security_answers`
--
ALTER TABLE `user_security_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `course_category` (`category_id`),
  ADD CONSTRAINT `courses_ibfk_2` FOREIGN KEY (`instructor_id`) REFERENCES `user_master` (`user_id`);

--
-- Constraints for table `course_progress`
--
ALTER TABLE `course_progress`
  ADD CONSTRAINT `course_progress_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_master` (`user_id`),
  ADD CONSTRAINT `course_progress_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`),
  ADD CONSTRAINT `course_progress_ibfk_3` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`lesson_id`);

--
-- Constraints for table `course_reviews`
--
ALTER TABLE `course_reviews`
  ADD CONSTRAINT `course_reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_master` (`user_id`),
  ADD CONSTRAINT `course_reviews_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`);

--
-- Constraints for table `course_sections`
--
ALTER TABLE `course_sections`
  ADD CONSTRAINT `course_sections_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`);

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_master` (`user_id`),
  ADD CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`);

--
-- Constraints for table `lessons`
--
ALTER TABLE `lessons`
  ADD CONSTRAINT `lessons_ibfk_1` FOREIGN KEY (`section_id`) REFERENCES `course_sections` (`section_id`);

--
-- Constraints for table `login_tracking`
--
ALTER TABLE `login_tracking`
  ADD CONSTRAINT `login_tracking_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_master` (`user_id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `fk_payment_enrollment` FOREIGN KEY (`enrollment_id`) REFERENCES `enrollments` (`enrollment_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_master` (`user_id`),
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`);

--
-- Constraints for table `user_security_answers`
--
ALTER TABLE `user_security_answers`
  ADD CONSTRAINT `user_security_answers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_master` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_security_answers_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `security_questions` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
