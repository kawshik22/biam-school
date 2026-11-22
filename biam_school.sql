-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 21, 2026 at 07:37 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12
SET
  SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;

SET
  time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */
;

/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */
;

/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */
;

/*!40101 SET NAMES utf8mb4 */
;

--
-- Database: `biam_school`
--
CREATE DATABASE IF NOT EXISTS `biam_school` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE `biam_school`;

-- --------------------------------------------------------
--
-- Table structure for table `admins`
--
CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(80) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--
INSERT INTO
  `admins` (`id`, `username`, `password_hash`, `created_at`)
VALUES
  (
    1,
    'kawshik22',
    '$2y$10$/qJ5EliVPfeDZ1tZsfBXXemT.LZVXuTeqlFcOISBqjwGKu9bPlAAe',
    '2026-11-16 08:05:28'
  );

-- --------------------------------------------------------
--
-- Table structure for table `admissions`
--
CREATE TABLE `admissions` (
  `id` int(11) NOT NULL,
  `student_name` varchar(160) NOT NULL,
  `class_name` varchar(80) NOT NULL,
  `guardian_name` varchar(160) NOT NULL,
  `mobile` varchar(30) NOT NULL,
  `email` varchar(160) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------
--
-- Table structure for table `messages`
--
CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `name` varchar(160) NOT NULL,
  `email` varchar(160) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------
--
-- Table structure for table `notices`
--
CREATE TABLE `notices` (
  `id` int(11) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `title_bn` varchar(255) NOT NULL DEFAULT '',
  `body_en` text DEFAULT NULL,
  `body_bn` text DEFAULT NULL,
  `publish_date` date NOT NULL,
  `is_published` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Dumping data for table `notices`
--
INSERT INTO
  `notices` (
    `id`,
    `title_en`,
    `title_bn`,
    `body_en`,
    `body_bn`,
    `publish_date`,
    `is_published`,
    `created_at`
  )
VALUES
  (
    1,
    'Welcome to BIAM Laboratory School',
    'বিয়াম ল্যাবরেটরি স্কুলে স্বাগতম',
    'Welcome to the official school website.',
    'বিদ্যালয়ের অফিসিয়াল ওয়েবসাইটে স্বাগতম।',
    '2026-11-16',
    1,
    '2026-11-16 08:16:35'
  );

-- --------------------------------------------------------
--
-- Table structure for table `page_content`
--
CREATE TABLE `page_content` (
  `id` int(11) NOT NULL,
  `page_key` varchar(100) NOT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `title_bn` varchar(255) DEFAULT NULL,
  `body_en` longtext DEFAULT NULL,
  `body_bn` longtext DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------
--
-- Table structure for table `results`
--
CREATE TABLE `results` (
  `id` int(11) NOT NULL,
  `student_id` varchar(80) NOT NULL,
  `student_name` varchar(160) NOT NULL,
  `class_name` varchar(80) DEFAULT NULL,
  `exam_name` varchar(160) NOT NULL,
  `academic_year` varchar(10) NOT NULL,
  `marks` varchar(30) DEFAULT NULL,
  `grade` varchar(20) DEFAULT NULL,
  `remarks` text DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------
--
-- Table structure for table `settings`
--
CREATE TABLE `settings` (
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--
INSERT INTO
  `settings` (`setting_key`, `setting_value`)
VALUES
  ('address', 'Please update official address'),
  ('email', 'Please update official email address'),
  ('office_hours', 'Please update office hours'),
  ('phone', 'Please update official phone number'),
  ('school_name', 'BIAM LABORATORY SCHOOL');

-- --------------------------------------------------------
--
-- Table structure for table `staff`
--
CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `name_en` varchar(160) NOT NULL,
  `name_bn` varchar(160) DEFAULT '',
  `designation_en` varchar(160) DEFAULT '',
  `designation_bn` varchar(160) DEFAULT '',
  `bio_en` text DEFAULT NULL,
  `bio_bn` text DEFAULT NULL,
  `photo` varchar(255) DEFAULT '',
  `category` enum('leadership', 'teacher') DEFAULT 'teacher',
  `is_published` tinyint(1) DEFAULT 1,
  `sort_order` int(11) DEFAULT 0
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--
--
-- Indexes for table `admins`
--
ALTER TABLE
  `admins`
ADD
  PRIMARY KEY (`id`),
ADD
  UNIQUE KEY `username` (`username`);

--
-- Indexes for table `admissions`
--
ALTER TABLE
  `admissions`
ADD
  PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE
  `messages`
ADD
  PRIMARY KEY (`id`);

--
-- Indexes for table `notices`
--
ALTER TABLE
  `notices`
ADD
  PRIMARY KEY (`id`);

--
-- Indexes for table `page_content`
--
ALTER TABLE
  `page_content`
ADD
  PRIMARY KEY (`id`),
ADD
  UNIQUE KEY `page_key` (`page_key`);

--
-- Indexes for table `results`
--
ALTER TABLE
  `results`
ADD
  PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE
  `settings`
ADD
  PRIMARY KEY (`setting_key`);

--
-- Indexes for table `staff`
--
ALTER TABLE
  `staff`
ADD
  PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--
--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE
  `admins`
MODIFY
  `id` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 2;

--
-- AUTO_INCREMENT for table `admissions`
--
ALTER TABLE
  `admissions`
MODIFY
  `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE
  `messages`
MODIFY
  `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notices`
--
ALTER TABLE
  `notices`
MODIFY
  `id` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 2;

--
-- AUTO_INCREMENT for table `page_content`
--
ALTER TABLE
  `page_content`
MODIFY
  `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE
  `results`
MODIFY
  `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE
  `staff`
MODIFY
  `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Database: `library`
--
CREATE DATABASE IF NOT EXISTS `library` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

USE `library`;

--
-- Database: `library_managmen_sytem`
--
CREATE DATABASE IF NOT EXISTS `library_managmen_sytem` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

USE `library_managmen_sytem`;

--
-- Database: `phpmyadmin`
--
CREATE DATABASE IF NOT EXISTS `phpmyadmin` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;

USE `phpmyadmin`;

-- --------------------------------------------------------
--
-- Table structure for table `pma__bookmark`
--
CREATE TABLE `pma__bookmark` (
  `id` int(10) UNSIGNED NOT NULL,
  `dbase` varchar(255) NOT NULL DEFAULT '',
  `user` varchar(255) NOT NULL DEFAULT '',
  `label` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `query` text NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin COMMENT = 'Bookmarks';

-- --------------------------------------------------------
--
-- Table structure for table `pma__central_columns`
--
CREATE TABLE `pma__central_columns` (
  `db_name` varchar(64) NOT NULL,
  `col_name` varchar(64) NOT NULL,
  `col_type` varchar(64) NOT NULL,
  `col_length` text DEFAULT NULL,
  `col_collation` varchar(64) NOT NULL,
  `col_isNull` tinyint(1) NOT NULL,
  `col_extra` varchar(255) DEFAULT '',
  `col_default` text DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin COMMENT = 'Central list of columns';

-- --------------------------------------------------------
--
-- Table structure for table `pma__column_info`
--
CREATE TABLE `pma__column_info` (
  `id` int(5) UNSIGNED NOT NULL,
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `column_name` varchar(64) NOT NULL DEFAULT '',
  `comment` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `mimetype` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `transformation` varchar(255) NOT NULL DEFAULT '',
  `transformation_options` varchar(255) NOT NULL DEFAULT '',
  `input_transformation` varchar(255) NOT NULL DEFAULT '',
  `input_transformation_options` varchar(255) NOT NULL DEFAULT ''
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin COMMENT = 'Column information for phpMyAdmin';

-- --------------------------------------------------------
--
-- Table structure for table `pma__designer_settings`
--
CREATE TABLE `pma__designer_settings` (
  `username` varchar(64) NOT NULL,
  `settings_data` text NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin COMMENT = 'Settings related to Designer';

-- --------------------------------------------------------
--
-- Table structure for table `pma__export_templates`
--
CREATE TABLE `pma__export_templates` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL,
  `export_type` varchar(10) NOT NULL,
  `template_name` varchar(64) NOT NULL,
  `template_data` text NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin COMMENT = 'Saved export templates';

-- --------------------------------------------------------
--
-- Table structure for table `pma__favorite`
--
CREATE TABLE `pma__favorite` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin COMMENT = 'Favorite tables';

-- --------------------------------------------------------
--
-- Table structure for table `pma__history`
--
CREATE TABLE `pma__history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db` varchar(64) NOT NULL DEFAULT '',
  `table` varchar(64) NOT NULL DEFAULT '',
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp(),
  `sqlquery` text NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin COMMENT = 'SQL history for phpMyAdmin';

-- --------------------------------------------------------
--
-- Table structure for table `pma__navigationhiding`
--
CREATE TABLE `pma__navigationhiding` (
  `username` varchar(64) NOT NULL,
  `item_name` varchar(64) NOT NULL,
  `item_type` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin COMMENT = 'Hidden items of navigation tree';

-- --------------------------------------------------------
--
-- Table structure for table `pma__pdf_pages`
--
CREATE TABLE `pma__pdf_pages` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `page_nr` int(10) UNSIGNED NOT NULL,
  `page_descr` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ''
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin COMMENT = 'PDF relation pages for phpMyAdmin';

-- --------------------------------------------------------
--
-- Table structure for table `pma__recent`
--
CREATE TABLE `pma__recent` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin COMMENT = 'Recently accessed tables';

--
-- Dumping data for table `pma__recent`
--
INSERT INTO
  `pma__recent` (`username`, `tables`)
VALUES
  (
    'root',
    '[{\"db\":\"mysql\",\"table\":\"user\"},{\"db\":\"student_profile_db\",\"table\":\"students\"}]'
  );

-- --------------------------------------------------------
--
-- Table structure for table `pma__relation`
--
CREATE TABLE `pma__relation` (
  `master_db` varchar(64) NOT NULL DEFAULT '',
  `master_table` varchar(64) NOT NULL DEFAULT '',
  `master_field` varchar(64) NOT NULL DEFAULT '',
  `foreign_db` varchar(64) NOT NULL DEFAULT '',
  `foreign_table` varchar(64) NOT NULL DEFAULT '',
  `foreign_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin COMMENT = 'Relation table';

-- --------------------------------------------------------
--
-- Table structure for table `pma__savedsearches`
--
CREATE TABLE `pma__savedsearches` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `search_name` varchar(64) NOT NULL DEFAULT '',
  `search_data` text NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin COMMENT = 'Saved searches';

-- --------------------------------------------------------
--
-- Table structure for table `pma__table_coords`
--
CREATE TABLE `pma__table_coords` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `pdf_page_number` int(11) NOT NULL DEFAULT 0,
  `x` float UNSIGNED NOT NULL DEFAULT 0,
  `y` float UNSIGNED NOT NULL DEFAULT 0
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin COMMENT = 'Table coordinates for phpMyAdmin PDF output';

-- --------------------------------------------------------
--
-- Table structure for table `pma__table_info`
--
CREATE TABLE `pma__table_info` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `display_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin COMMENT = 'Table information for phpMyAdmin';

-- --------------------------------------------------------
--
-- Table structure for table `pma__table_uiprefs`
--
CREATE TABLE `pma__table_uiprefs` (
  `username` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `prefs` text NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin COMMENT = 'Tables'' UI preferences';

-- --------------------------------------------------------
--
-- Table structure for table `pma__tracking`
--
CREATE TABLE `pma__tracking` (
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `version` int(10) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `schema_snapshot` text NOT NULL,
  `schema_sql` text DEFAULT NULL,
  `data_sql` longtext DEFAULT NULL,
  `tracking`
  set
(
      'UPDATE',
      'REPLACE',
      'INSERT',
      'DELETE',
      'TRUNCATE',
      'CREATE DATABASE',
      'ALTER DATABASE',
      'DROP DATABASE',
      'CREATE TABLE',
      'ALTER TABLE',
      'RENAME TABLE',
      'DROP TABLE',
      'CREATE INDEX',
      'DROP INDEX',
      'CREATE VIEW',
      'ALTER VIEW',
      'DROP VIEW'
    ) DEFAULT NULL,
    `tracking_active` int(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin COMMENT = 'Database changes tracking for phpMyAdmin';

-- --------------------------------------------------------
--
-- Table structure for table `pma__userconfig`
--
CREATE TABLE `pma__userconfig` (
  `username` varchar(64) NOT NULL,
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `config_data` text NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin COMMENT = 'User preferences storage for phpMyAdmin';

--
-- Dumping data for table `pma__userconfig`
--
INSERT INTO
  `pma__userconfig` (`username`, `timevalue`, `config_data`)
VALUES
  (
    'root',
    '2026-11-21 18:22:48',
    '{\"Console\\/Mode\":\"collapse\"}'
  );

-- --------------------------------------------------------
--
-- Table structure for table `pma__usergroups`
--
CREATE TABLE `pma__usergroups` (
  `usergroup` varchar(64) NOT NULL,
  `tab` varchar(64) NOT NULL,
  `allowed` enum('Y', 'N') NOT NULL DEFAULT 'N'
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin COMMENT = 'User groups with configured menu items';

-- --------------------------------------------------------
--
-- Table structure for table `pma__users`
--
CREATE TABLE `pma__users` (
  `username` varchar(64) NOT NULL,
  `usergroup` varchar(64) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin COMMENT = 'Users and their assignments to user groups';

--
-- Indexes for dumped tables
--
--
-- Indexes for table `pma__bookmark`
--
ALTER TABLE
  `pma__bookmark`
ADD
  PRIMARY KEY (`id`);

--
-- Indexes for table `pma__central_columns`
--
ALTER TABLE
  `pma__central_columns`
ADD
  PRIMARY KEY (`db_name`, `col_name`);

--
-- Indexes for table `pma__column_info`
--
ALTER TABLE
  `pma__column_info`
ADD
  PRIMARY KEY (`id`),
ADD
  UNIQUE KEY `db_name` (`db_name`, `table_name`, `column_name`);

--
-- Indexes for table `pma__designer_settings`
--
ALTER TABLE
  `pma__designer_settings`
ADD
  PRIMARY KEY (`username`);

--
-- Indexes for table `pma__export_templates`
--
ALTER TABLE
  `pma__export_templates`
ADD
  PRIMARY KEY (`id`),
ADD
  UNIQUE KEY `u_user_type_template` (`username`, `export_type`, `template_name`);

--
-- Indexes for table `pma__favorite`
--
ALTER TABLE
  `pma__favorite`
ADD
  PRIMARY KEY (`username`);

--
-- Indexes for table `pma__history`
--
ALTER TABLE
  `pma__history`
ADD
  PRIMARY KEY (`id`),
ADD
  KEY `username` (`username`, `db`, `table`, `timevalue`);

--
-- Indexes for table `pma__navigationhiding`
--
ALTER TABLE
  `pma__navigationhiding`
ADD
  PRIMARY KEY (
    `username`,
    `item_name`,
    `item_type`,
    `db_name`,
    `table_name`
  );

--
-- Indexes for table `pma__pdf_pages`
--
ALTER TABLE
  `pma__pdf_pages`
ADD
  PRIMARY KEY (`page_nr`),
ADD
  KEY `db_name` (`db_name`);

--
-- Indexes for table `pma__recent`
--
ALTER TABLE
  `pma__recent`
ADD
  PRIMARY KEY (`username`);

--
-- Indexes for table `pma__relation`
--
ALTER TABLE
  `pma__relation`
ADD
  PRIMARY KEY (`master_db`, `master_table`, `master_field`),
ADD
  KEY `foreign_field` (`foreign_db`, `foreign_table`);

--
-- Indexes for table `pma__savedsearches`
--
ALTER TABLE
  `pma__savedsearches`
ADD
  PRIMARY KEY (`id`),
ADD
  UNIQUE KEY `u_savedsearches_username_dbname` (`username`, `db_name`, `search_name`);

--
-- Indexes for table `pma__table_coords`
--
ALTER TABLE
  `pma__table_coords`
ADD
  PRIMARY KEY (`db_name`, `table_name`, `pdf_page_number`);

--
-- Indexes for table `pma__table_info`
--
ALTER TABLE
  `pma__table_info`
ADD
  PRIMARY KEY (`db_name`, `table_name`);

--
-- Indexes for table `pma__table_uiprefs`
--
ALTER TABLE
  `pma__table_uiprefs`
ADD
  PRIMARY KEY (`username`, `db_name`, `table_name`);

--
-- Indexes for table `pma__tracking`
--
ALTER TABLE
  `pma__tracking`
ADD
  PRIMARY KEY (`db_name`, `table_name`, `version`);

--
-- Indexes for table `pma__userconfig`
--
ALTER TABLE
  `pma__userconfig`
ADD
  PRIMARY KEY (`username`);

--
-- Indexes for table `pma__usergroups`
--
ALTER TABLE
  `pma__usergroups`
ADD
  PRIMARY KEY (`usergroup`, `tab`, `allowed`);

--
-- Indexes for table `pma__users`
--
ALTER TABLE
  `pma__users`
ADD
  PRIMARY KEY (`username`, `usergroup`);

--
-- AUTO_INCREMENT for dumped tables
--
--
-- AUTO_INCREMENT for table `pma__bookmark`
--
ALTER TABLE
  `pma__bookmark`
MODIFY
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__column_info`
--
ALTER TABLE
  `pma__column_info`
MODIFY
  `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__export_templates`
--
ALTER TABLE
  `pma__export_templates`
MODIFY
  `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__history`
--
ALTER TABLE
  `pma__history`
MODIFY
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__pdf_pages`
--
ALTER TABLE
  `pma__pdf_pages`
MODIFY
  `page_nr` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__savedsearches`
--
ALTER TABLE
  `pma__savedsearches`
MODIFY
  `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Database: `student_demo_db`
--
CREATE DATABASE IF NOT EXISTS `student_demo_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

USE `student_demo_db`;

-- --------------------------------------------------------
--
-- Table structure for table `students`
--
CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `department` varchar(100) NOT NULL,
  `semester` varchar(30) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--
-- Dumping data for table `students`
--
INSERT INTO
  `students` (
    `id`,
    `full_name`,
    `email`,
    `department`,
    `semester`,
    `created_at`
  )
VALUES
  (
    1,
    'Rahim Ahmed',
    'rahim@example.com',
    'CSE',
    '8th',
    '2026-10-12 12:16:55'
  ),
  (
    2,
    'Karim Hasan',
    'karim@example.com',
    'EEE',
    '6th',
    '2026-10-12 12:16:55'
  ),
  (
    3,
    'Nusrat Jahan',
    'nusrat@example.com',
    'BBA',
    '4th',
    '2026-10-12 12:16:55'
  );

--
-- Indexes for dumped tables
--
--
-- Indexes for table `students`
--
ALTER TABLE
  `students`
ADD
  PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--
--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE
  `students`
MODIFY
  `id` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 4;

--
-- Database: `student_profile_db`
--
CREATE DATABASE IF NOT EXISTS `student_profile_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE `student_profile_db`;

-- --------------------------------------------------------
--
-- Table structure for table `students`
--
CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `department` varchar(100) DEFAULT NULL,
  `semester` varchar(30) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--
INSERT INTO
  `students` (
    `id`,
    `full_name`,
    `email`,
    `department`,
    `semester`,
    `created_at`
  )
VALUES
  (
    1,
    'Rahim Ahmed',
    'rahim@example.com',
    'CSE',
    '8th',
    '2026-10-11 19:18:18'
  ),
  (
    2,
    'Karim Hasan',
    'karim@example.com',
    'EEE',
    '6th',
    '2026-10-11 19:18:18'
  ),
  (
    3,
    'Nusrat Jahan',
    'nusrat@example.com',
    'BBA',
    '4th',
    '2026-10-11 19:18:18'
  ),
  (
    4,
    'Crazy1 xyz',
    'teststudent@example.com',
    'CIVIL',
    '8th',
    '2026-10-11 19:33:08'
  ),
  (
    5,
    'DIP ROY',
    'dip1@gmail.com',
    'English',
    '9th',
    '2026-10-11 19:36:46'
  ),
  (
    6,
    'dflgwkrgm',
    'dflkbekwdk@gmail.com',
    'Bangla',
    '1st',
    '2026-10-11 19:46:53'
  ),
  (
    7,
    'Rahim Ahmed',
    'rahim@example.com',
    'CSE',
    '8th',
    '2026-10-12 12:10:34'
  ),
  (
    8,
    'Karim Hasan',
    'karim@example.com',
    'EEE',
    '6th',
    '2026-10-12 12:10:34'
  ),
  (
    9,
    'Nusrat Jahan',
    'nusrat@example.com',
    'BBA',
    '4th',
    '2026-10-12 12:10:34'
  );

--
-- Indexes for dumped tables
--
--
-- Indexes for table `students`
--
ALTER TABLE
  `students`
ADD
  PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--
--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE
  `students`
MODIFY
  `id` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 10;

--
-- Database: `test`
--
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;

USE `test`;

--
-- Database: `zxdkjzj`
--
CREATE DATABASE IF NOT EXISTS `zxdkjzj` DEFAULT CHARACTER SET dec8 COLLATE dec8_swedish_nopad_ci;

USE `zxdkjzj`;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */
;

/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */
;

/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */
;