-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 18, 2026 at 02:04 PM
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
-- Table structure for table `contact_inquiries`
--

CREATE TABLE `contact_inquiries` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` enum('unread','read','replied') DEFAULT 'unread',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 'AT&T', 'General Engineering', 1, 'active', '2026-01-17 23:37:31'),
(2, 'Pfizer', 'General Engineering', 1, 'active', '2026-01-17 23:37:31'),
(3, 'GMAC', 'General Engineering', 0, 'active', '2026-01-17 23:37:31'),
(4, 'Texas Instruments', 'General Engineering', 1, 'active', '2026-01-17 23:37:31'),
(5, 'Citigroup', 'General Engineering', 1, 'active', '2026-01-17 23:37:31'),
(6, 'Armstrong', 'General Engineering', 0, 'active', '2026-01-17 23:37:31'),
(7, 'Nestle', 'General Engineering', 1, 'active', '2026-01-17 23:37:31'),
(8, 'HYLSAOMEX', 'General Engineering', 0, 'active', '2026-01-17 23:37:31'),
(9, 'MINOLTA', 'General Engineering', 0, 'active', '2026-01-17 23:37:31'),
(10, 'Johnson', 'General Engineering', 0, 'active', '2026-01-17 23:37:31'),
(11, 'BASF', 'General Engineering', 1, 'active', '2026-01-17 23:37:31'),
(12, 'Heineken', 'General Engineering', 0, 'active', '2026-01-17 23:37:31'),
(13, 'Bayer', 'General Engineering', 1, 'active', '2026-01-17 23:37:31'),
(14, 'RANBAXY', 'General Engineering', 0, 'active', '2026-01-17 23:37:31'),
(15, 'BOSCH', 'General Engineering', 1, 'active', '2026-01-17 23:37:31'),
(16, 'STONGGLY', 'General Engineering', 0, 'active', '2026-01-17 23:37:31'),
(17, 'FannieMae', 'General Engineering', 1, 'active', '2026-01-17 23:37:31'),
(18, 'WebMD', 'General Engineering', 0, 'active', '2026-01-17 23:37:31'),
(19, 'Wellmark', 'General Engineering', 0, 'active', '2026-01-17 23:37:31'),
(20, 'CISCO', 'General Engineering', 1, 'active', '2026-01-17 23:37:31'),
(21, 'Genentech', 'General Engineering', 0, 'active', '2026-01-17 23:37:31'),
(22, 'Capital Group', 'General Engineering', 0, 'active', '2026-01-17 23:37:31'),
(23, 'RCI', 'General Engineering', 0, 'active', '2026-01-17 23:37:31'),
(24, 'WELLS FARGO', 'General Engineering', 1, 'active', '2026-01-17 23:37:31'),
(25, 'Imagination', 'General Engineering', 0, 'active', '2026-01-17 23:37:31'),
(26, 'mxenergy', 'General Engineering', 0, 'active', '2026-01-17 23:37:31'),
(27, 'JCPenney', 'General Engineering', 0, 'active', '2026-01-17 23:37:31'),
(28, 'BT', 'General Engineering', 1, 'active', '2026-01-17 23:37:31'),
(29, 'Hitachi', 'General Engineering', 1, 'active', '2026-01-17 23:37:31'),
(30, 'Autodesk', 'General Engineering', 1, 'active', '2026-01-17 23:37:31'),
(31, 'Energizer', 'General Engineering', 0, 'active', '2026-01-17 23:37:31'),
(32, 'Citi', 'General Engineering', 1, 'active', '2026-01-17 23:37:31'),
(33, 'Verizon', 'General Engineering', 1, 'active', '2026-01-17 23:37:31'),
(34, 'babycenter', 'General Engineering', 0, 'active', '2026-01-17 23:37:31'),
(35, 'Bea', 'General Engineering', 0, 'active', '2026-01-17 23:37:31'),
(36, 'NaviSite', 'General Engineering', 0, 'active', '2026-01-17 23:37:31');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `tutor_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `summary` varchar(500) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `video_url` text DEFAULT NULL,
  `video_file` varchar(255) DEFAULT NULL,
  `demo_video_url` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `rating` decimal(3,2) DEFAULT 0.00,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('publish','draft') NOT NULL DEFAULT 'publish',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `category_id`, `tutor_id`, `title`, `slug`, `summary`, `description`, `duration`, `video_url`, `video_file`, `demo_video_url`, `price`, `thumbnail`, `rating`, `is_featured`, `status`, `created_at`) VALUES
(3, 2, 1, 'Full-Stack Web Development with PHP & MySQL', 'full-stack-web-development-with-php-and-mysql', 'PHP Language', 'Learn to build dynamic websites with PHP and MySQL from scratch', 360, 'https://www.youtube.com/watch?v=1SnPKhCdlsU&t=571s', '', NULL, 3999.00, 'php_fullstack.png', 0.00, 0, 'publish', '2026-01-01 08:28:14'),
(4, 5, 1, 'AI & Machine Learning Mastery: From Zero to Real-World Models', 'ai-and-machine-learning-mastery-from-zero-to-real-world-models', 'AI/ML Course', 'Learn how modern AI systems actually work — not just theory. This course takes you from core Machine Learning concepts to hands-on model building using real datasets. You’ll understand algorithms, train models, evaluate performance, and deploy basic AI solutions used in industry today.', 480, 'https://www.youtube.com/watch?v=wnqkfpCpK1g', '', NULL, 5999.00, '1768717592_ai_ml.png', 0.00, 1, 'publish', '2026-01-18 00:56:32'),
(6, 4, 1, 'Advanced Cyber Defense & Infrastructure Hardening', 'advanced-cyber-defense-infrastructure-hardening', 'Master the art of ethical hacking and infrastructure security by deploying advanced defense mechanisms against modern threat vectors in local and cloud environments.', '<p><strong style=\"font-size: inherit;\">Hero Tech Security Node: Defensive Operations</strong></p><p>This track is designed to transition technical personnel into <strong>Security Operations Center (SOC)</strong> roles. You will work with industrial-grade tools to perform <strong>vulnerability assessments</strong> and implement <strong><em>Zero Trust Architecture</em></strong>.</p><hr><h2><strong>Core Intelligence Modules</strong></h2><ul><li><p><strong>Module 01:</strong> Network Reconnaissance and Penetration Testing using <em>Kali Linux</em> environments.</p></li><li><p><strong>Module 02:</strong> Hardening <strong>Linux/Windows Servers</strong> and securing <strong>Dockerized microservices</strong>.</p></li><li><p><strong>Module 03:</strong> <strong>Incident Response protocols</strong> — Detecting and neutralizing <em>SQL Injection</em> and <em>Cross-Site Scripting (XSS)</em>.</p></li><li><p><strong>Module 04:</strong> <strong>Cloud Security</strong> — IAM configuration and encrypted data dispatches on <strong>Hero Tech Cloud</strong>.</p></li></ul><hr><h2><strong>Strategic Prerequisites</strong></h2><blockquote><p><em>“Defensive architecture requires a baseline mastery of <strong>TCP/IP protocols</strong> and foundational <strong>command-line operations</strong>.”</em></p></blockquote><hr><h2><strong>Security Operations Framework</strong></h2><table><thead><tr><th><strong>Security Layer</strong></th><th><strong>Toolchain</strong></th><th><strong>Operational Goal</strong></th></tr></thead><tbody><tr><td><strong>Network</strong></td><td>Wireshark &amp; Nmap</td><td>Traffic Synchronization</td></tr><tr><td><strong>Application</strong></td><td>Burp Suite</td><td>Vulnerability Neutralization</td></tr></tbody></table><hr><p><em><strong>System Protocol:</strong> This course includes <strong>12 hands-on lab modules</strong> and a <strong>final capstone</strong> on enterprise-level hardening.</em></p>', 120, '', 'advanced-cyber-defense-infrastructure-hardening.mp4', NULL, 5999.00, '1773472954_cybersecurity.png', 5.00, 1, 'publish', '2026-03-14 01:52:34');

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
(5, 'Artificial Intelligence & Machine Learning', 'active'),
(7, 'Cloud Computing', 'active');

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
(1, 4, 6, 5, 'It was a amazing Course!!', '2026-04-18 06:26:01');

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

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`enrollment_id`, `user_id`, `course_id`, `enrolled_at`, `status`, `txnid`, `activated_at`) VALUES
(16, 4, 4, '2026-04-04 07:02:16', 'cancelled', 'HT_1775286136_4', '2026-04-04 07:02:16'),
(17, 4, 6, '2026-04-04 07:39:37', 'completed', 'HT_1775288377_4', '2026-04-04 07:39:37'),
(18, 4, 4, '2026-04-04 07:42:05', 'active', 'HT_1775288525_4', '2026-04-04 07:42:05');

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

--
-- Dumping data for table `login_tracking`
--

INSERT INTO `login_tracking` (`login_tracking_id`, `user_id`, `ip_address`, `content`, `is_online`, `tracking_datetime`) VALUES
(46, 1, '::1', 'Admin Logged In', 'online', '2026-04-18 05:38:35'),
(47, 4, '::1', 'Student Logged In', 'online', '2026-04-18 05:55:58'),
(48, 1, '::1', 'Admin Logged In', 'online', '2026-04-18 07:00:17'),
(49, 1, '::1', 'Admin Logged In', 'online', '2026-04-18 11:30:14');

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
  `payment_status` enum('success','failed','pending') DEFAULT 'pending',
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_method` enum('Cash','UPI','Card','NetBanking','Wallet') NOT NULL DEFAULT 'Cash',
  `transaction_id` varchar(100) DEFAULT NULL,
  `error_log` text DEFAULT NULL,
  `gateway_id` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `enrollment_id`, `user_id`, `course_id`, `amount`, `payment_status`, `payment_date`, `payment_method`, `transaction_id`, `error_log`, `gateway_id`) VALUES
(5, 17, 4, 6, 5999.00, 'success', '2026-04-04 07:40:18', 'Card', 'HT_1775288377_4', NULL, '403993715537136957'),
(9, 18, 4, 4, 5999.00, 'success', '2026-04-04 07:42:24', 'UPI', 'HT_1775288525_4', NULL, '403993715537136970');

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
(12, 'What was your dream job when you were a child?'),
(13, 'Who is your favorite cricketer?'),
(14, 'Who is your idol?'),
(15, 'Which is your favorite color?');

-- --------------------------------------------------------

--
-- Table structure for table `tutors`
--

CREATE TABLE `tutors` (
  `tutor_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `bio` text DEFAULT NULL,
  `expertise` varchar(255) DEFAULT NULL,
  `qualification` varchar(255) DEFAULT NULL,
  `experience_years` int(11) DEFAULT 0,
  `profile_image` varchar(255) NOT NULL,
  `linkedin_url` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive','suspended') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutors`
--

INSERT INTO `tutors` (`tutor_id`, `name`, `email`, `bio`, `expertise`, `qualification`, `experience_years`, `profile_image`, `linkedin_url`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Abhishek Shah', 'shahabhishek051@gmail.com', 'Gained hands on experience from MNC and build own websites too.', 'Web Development', 'Diploma', 0, 'tutor_abhishek-shah.jpg', 'https://linkedin.com/in/abhishekshah-dev/', 'active', '2026-03-08 00:27:39', '2026-04-18 12:00:59');

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
  `gender` enum('male','female','other','') NOT NULL,
  `password` varchar(50) DEFAULT NULL,
  `role` enum('student','admin','manager') DEFAULT 'student',
  `datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('publish','draft') DEFAULT 'publish'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_master`
--

INSERT INTO `user_master` (`user_id`, `name`, `username`, `phone`, `email`, `gender`, `password`, `role`, `datetime`, `status`) VALUES
(1, 'Abhishek', 'abs123', '1203456789', 'abhishek@hero.com', 'male', '202cb962ac59075b964b07152d234b70', 'admin', '2026-02-14 01:36:20', 'publish'),
(2, 'Test', 'test1', '3012456987', 'test@gmail.com', 'male', '202cb962ac59075b964b07152d234b70', 'student', '2026-02-14 06:31:16', 'publish'),
(3, 'Mina', 'mbshah12', '1230457896', 'mina@gmail.com', 'female', '81dc9bdb52d04dc20036dbd8313ed055', 'student', '2026-02-14 01:36:28', 'publish'),
(4, 'Demo', 'demo1', '1234567890', 'demo@gmail.com', 'male', '202cb962ac59075b964b07152d234b70', 'student', '2026-02-21 07:15:45', 'publish'),
(12, 'Sandip Mistry', 'sandi009', '8488982013', 'itsoulinfotech@gmail.com', 'male', '6d071901727aec1ba6d8e2497ef5b709', 'student', '2026-03-07 00:15:12', 'publish');

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
(1, 4, 2, 'c286b9545aaf7fdedebee6e2c526bf14', '2026-02-14 06:23:53'),
(2, 4, 5, '9ed244e30701f591f8859cde5ee71b8c', '2026-02-14 06:23:53'),
(3, 4, 9, '95ff712b4813b5376c1757b2e634eaae', '2026-02-14 06:23:53'),
(7, 12, 5, '4568a803478957719bf3ca27b73ca0cd', '2026-03-07 00:16:00'),
(8, 12, 6, '9ed244e30701f591f8859cde5ee71b8c', '2026-03-07 00:16:00'),
(9, 12, 13, '6d659c8e177098f5a39c03d0a52e5ba3', '2026-03-07 00:16:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact_inquiries`
--
ALTER TABLE `contact_inquiries`
  ADD PRIMARY KEY (`id`);

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
  ADD UNIQUE KEY `slug` (`slug`),
  ADD UNIQUE KEY `slug_2` (`slug`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `tutor_id` (`tutor_id`) USING BTREE;

--
-- Indexes for table `course_category`
--
ALTER TABLE `course_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `course_reviews`
--
ALTER TABLE `course_reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD UNIQUE KEY `unique_user_course_review` (`user_id`,`course_id`),
  ADD KEY `user_id` (`user_id`),
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
  ADD KEY `course_id` (`course_id`),
  ADD KEY `idx_txnid` (`txnid`),
  ADD KEY `idx_status` (`status`);

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
  ADD UNIQUE KEY `transaction_id` (`transaction_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `fk_payment_enrollment` (`enrollment_id`);

--
-- Indexes for table `security_questions`
--
ALTER TABLE `security_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tutors`
--
ALTER TABLE `tutors`
  ADD PRIMARY KEY (`tutor_id`);

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
-- AUTO_INCREMENT for table `contact_inquiries`
--
ALTER TABLE `contact_inquiries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `corporate_clients`
--
ALTER TABLE `corporate_clients`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `course_category`
--
ALTER TABLE `course_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `course_reviews`
--
ALTER TABLE `course_reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `demo_usage_logs`
--
ALTER TABLE `demo_usage_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `enrollment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `login_tracking`
--
ALTER TABLE `login_tracking`
  MODIFY `login_tracking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `security_questions`
--
ALTER TABLE `security_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tutors`
--
ALTER TABLE `tutors`
  MODIFY `tutor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_master`
--
ALTER TABLE `user_master`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user_security_answers`
--
ALTER TABLE `user_security_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `course_category` (`category_id`),
  ADD CONSTRAINT `courses_ibfk_2` FOREIGN KEY (`tutor_id`) REFERENCES `tutors` (`tutor_id`),
  ADD CONSTRAINT `courses_ibfk_3` FOREIGN KEY (`tutor_id`) REFERENCES `tutors` (`tutor_id`),
  ADD CONSTRAINT `fk_course_instructor` FOREIGN KEY (`tutor_id`) REFERENCES `tutors` (`tutor_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `course_reviews`
--
ALTER TABLE `course_reviews`
  ADD CONSTRAINT `course_reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_master` (`user_id`),
  ADD CONSTRAINT `course_reviews_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`);

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_master` (`user_id`),
  ADD CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`);

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
