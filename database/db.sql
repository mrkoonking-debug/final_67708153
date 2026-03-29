-- Create database for member management system
CREATE DATABASE IF NOT EXISTS `final_db_67108153`;
USE `final_db_67108153`;

-- Table structure for table `members`
CREATE TABLE IF NOT EXISTS `members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` varchar(20) NOT NULL COMMENT 'รหัสนักศึกษา/บุคลากร',
  `fullname` varchar(150) NOT NULL COMMENT 'ชื่อ-นามสกุล',
  `faculty` varchar(100) NOT NULL COMMENT 'คณะต้นสังกัด',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP COMMENT 'วันที่เพิ่มข้อมูล',
  PRIMARY KEY (`id`),
  UNIQUE KEY `member_id` (`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `members`
INSERT INTO `members` (`member_id`, `fullname`, `faculty`, `created_at`) VALUES
('41970334', 'อ.ศรทัศน์ อินทรบุตร', 'คณะเทคโนโลยีสารสนเทศ', CURRENT_TIMESTAMP),
('41970389', 'อ.สิทธิพงษ์ พุทธวงษ์', 'คณะเทคโนโลยีสารสนเทศ', CURRENT_TIMESTAMP);
