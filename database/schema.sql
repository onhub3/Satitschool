-- Database: satitschool_db

CREATE DATABASE IF NOT EXISTS satitschool_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE satitschool_db;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL COMMENT 'รหัสประจำตัว/Username',
  `password_hash` varchar(255) NOT NULL,
  `role` enum('admin','teacher','student') NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--
-- Passwords are all 'password123' (hashed with bcrypt)
--

INSERT INTO `users` (`username`, `password_hash`, `role`, `first_name`, `last_name`, `status`) VALUES
('admin', '$2y$10$B.HemX7ht919Ntum6o1CkeKsUHPr3B3R6hDERrqzSs96SGIumK/c2', 'admin', 'ผู้ดูแลระบบ', 'ส่วนกลาง', 'active'),
('T1001', '$2y$10$B.HemX7ht919Ntum6o1CkeKsUHPr3B3R6hDERrqzSs96SGIumK/c2', 'teacher', 'สมชาย', 'ใจดี', 'active'),
('S69001', '$2y$10$B.HemX7ht919Ntum6o1CkeKsUHPr3B3R6hDERrqzSs96SGIumK/c2', 'student', 'สมปอง', 'ใฝ่เรียน', 'active'),
('ad123', '$2y$10$6tSbCdEXhLCVC7GXW/tZruYevPROPeVEH3Gr00VJQZAJgKb4.5TNe', 'admin', 'แอดมิน', 'ทดสอบ', 'active');

--
-- Table structure for table `teachers`
--

CREATE TABLE IF NOT EXISTS `teachers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `teacher_code` varchar(20) NOT NULL COMMENT 'รหัสประจำตัวครู (Username)',
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `line_id` varchar(50) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL COMMENT 'หมวดวิชาที่สังกัด',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `teacher_code` (`teacher_code`),
  UNIQUE KEY `user_id` (`user_id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert mock teacher
INSERT INTO `teachers` (`user_id`, `teacher_code`, `first_name`, `last_name`, `phone`, `department`) VALUES
(2, 'T1001', 'สมชาย', 'ใจดี', '0812345678', 'คณิตศาสตร์');
