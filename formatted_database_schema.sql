
-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2021 at 12:42 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pms`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `getProjectDetails` ()  SELECT t_projects.project_id,t_projects.project_name,t_departments.dep_name,
t_projects.subcounty,t_projects.start_date,t_projects.end_date
,t_projects.budget,t_financial_year.year_name,t_projects.status FROM t_projects JOIN t_departments ON t_projects.dep_fk = t_departments.dep_id JOIN t_financial_year ON t_projects.f_year = t_financial_year.year_id ORDER BY t_projects.project_id DESC$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE IF NOT EXISTS `departments` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `dep_name` VARCHAR(255) NOT NULL,
  `status` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`dep_name`, `status`) VALUES
('Information & Technology', 'active'),
('Finance and Economic Planning', 'active'),
('Agriculture, Livestock & Fisheries', 'active'),
('County Public Service & Solid Waste Management', 'active'),
('Health Services', 'active'),
('Transport, Public Works, Infrastructure & Energy', 'active'),
('Land, Housing and Urban Development', 'active'),
('Water, Irrigation, Environment and Climate Change', 'active'),
('Gender, Youth and Social Services', 'active'),
('Trade, Tourism, Culture and Cooperative Development', 'active'),
('Education & Sports', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE IF NOT EXISTS `staff` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `names` VARCHAR(255) NOT NULL,
  `dep_id` INT NOT NULL,
  `id_number` VARCHAR(255) NOT NULL,
  `mobile_no` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `status` VARCHAR(255) NOT NULL,
  `user_type` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`names`, `dep_id`, `id_number`, `mobile_no`, `email`, `password`, `status`, `user_type`) VALUES
('John Waweru', 1, '3265478', '0729299382', 'jw@msn.com', 'e10adc3949ba59abbe56e057f20f883e', 'active', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `sub_counties`
--

CREATE TABLE IF NOT EXISTS `sub_counties` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `sub_name` VARCHAR(255) NOT NULL,
  `ward` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_activity`
--

CREATE TABLE IF NOT EXISTS `user_activity` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `staff_id` INT NOT NULL,
  `user_type` VARCHAR(255) NOT NULL,
  `description` TEXT NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `financial_years`
--

CREATE TABLE IF NOT EXISTS `financial_years` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `year_name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `financial_years`
--

INSERT INTO `financial_years` (`year_name`) VALUES
('2020/2021'),
('2021/2022'),
('2022/2023'),
('2023/2024');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `project_name` VARCHAR(255) NOT NULL,
  `staff_id` INT NOT NULL,
  `dep_id` INT NOT NULL,
  `sub_id` INT NOT NULL,
  `year_id` INT NOT NULL,
  `budget` DECIMAL(10, 2) NOT NULL,
  `pr_status` VARCHAR(255) NOT NULL DEFAULT 'pending',
  `start_date` DATE NOT NULL,
  `end_date` DATE NOT NULL,
  `remarks` TEXT NULL,
  `reasons` TEXT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE IF NOT EXISTS `tasks` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `task_name` VARCHAR(255) NOT NULL,
  `proj_id` INT NOT NULL,
  `description` TEXT NULL,
  `budget` DECIMAL(10, 2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user_activity`
--
ALTER TABLE `user_activity`
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD KEY `staff_id` (`staff_id`),
  ADD KEY `dep_id` (`dep_id`),
  ADD KEY `sub_id` (`sub_id`),
  ADD KEY `year_id` (`year_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD KEY `proj_id` (`proj_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD KEY `dep_id` (`dep_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_activity`
--
ALTER TABLE `user_activity`
  ADD CONSTRAINT `user_activity_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff`(`id`) ON UPDATE CASCADE;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff`(`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `projects_ibfk_2` FOREIGN KEY (`dep_id`) REFERENCES `departments`(`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `projects_ibfk_3` FOREIGN KEY (`sub_id`) REFERENCES `sub_counties`(`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `projects_ibfk_4` FOREIGN KEY (`year_id`) REFERENCES `financial_years`(`id`) ON UPDATE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`proj_id`) REFERENCES `projects`(`id`) ON UPDATE CASCADE;

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_ibfk_1` FOREIGN KEY (`dep_id`) REFERENCES `departments`(`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
