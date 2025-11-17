-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 10, 2025 at 02:38 PM
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
-- Database: `attendance_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `2019_20`
--

CREATE TABLE `2019_20` (
  `student_id` char(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `department_id` int(11) NOT NULL,
  `batch_id` int(10) NOT NULL DEFAULT 1,
  `password` varchar(150) NOT NULL,
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `2019_20`
--

INSERT INTO `2019_20` (`student_id`, `email`, `name`, `department_id`, `batch_id`, `password`, `reset_token_hash`, `reset_token_expires_at`) VALUES
('2019t01101', 'alex.johnson@university.edu', 'Alex Johnson', 1, 1, '$2y$10$encrypted_password_hash1', NULL, NULL),
('2019t01105', 'sarah.williams@university.edu', 'Sarah Williams', 1, 1, '$2y$10$encrypted_password_hash2', NULL, NULL),
('2019t01110', 'michael.brown@university.edu', 'Michael Brown', 1, 1, '$2y$10$encrypted_password_hash3', NULL, NULL),
('2019t01115', 'emma.davis@university.edu', 'Emma Davis', 1, 1, '$2y$10$encrypted_password_hash4', NULL, NULL),
('2019t01301', 'david.miller@university.edu', 'David Miller', 3, 1, '$2y$10$encrypted_password_hash5', NULL, NULL),
('2019t01305', 'olivia.wilson@university.edu', 'Olivia Wilson', 3, 1, '$2y$10$encrypted_password_hash6', NULL, NULL),
('2019t01310', 'james.moore@university.edu', 'James Moore', 3, 1, '$2y$10$encrypted_password_hash7', NULL, NULL),
('2019t01315', 'sophia.taylor@university.edu', 'Sophia Taylor', 3, 1, '$2y$10$encrypted_password_hash8', NULL, NULL),
('2019t01401', 'william.anderson@university.edu', 'William Anderson', 4, 1, '$2y$10$encrypted_password_hash9', NULL, NULL),
('2019t01405', 'ava.thomas@university.edu', 'Ava Thomas', 4, 1, '$2y$10$encrypted_password_hash10', NULL, NULL),
('2019t01410', 'benjamin.jackson@university.edu', 'Benjamin Jackson', 4, 1, '$2y$10$encrypted_password_hash11', NULL, NULL),
('2019t01415', 'mia.white@university.edu', 'Mia White', 4, 1, '$2y$10$encrypted_password_hash12', NULL, NULL),
('2019t01501', 'ethan.harris@university.edu', 'Ethan Harris', 2, 1, '$2y$10$encrypted_password_hash13', NULL, NULL),
('2019t01505', 'charlotte.martin@university.edu', 'Charlotte Martin', 2, 1, '$2y$10$encrypted_password_hash14', NULL, NULL),
('2019t01510', 'lucas.garcia@university.edu', 'Lucas Garcia', 2, 1, '$2y$10$encrypted_password_hash15', NULL, NULL),
('2019t01515', 'amelia.rodriguez@university.edu', 'Amelia Rodriguez', 2, 1, '$2y$10$encrypted_password_hash16', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `2020_21`
--

CREATE TABLE `2020_21` (
  `student_id` char(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `department_id` int(11) NOT NULL,
  `batch_id` int(10) NOT NULL DEFAULT 2,
  `password` varchar(150) NOT NULL,
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `2020_21`
--

INSERT INTO `2020_21` (`student_id`, `email`, `name`, `department_id`, `batch_id`, `password`, `reset_token_hash`, `reset_token_expires_at`) VALUES
('2020t01101', 'jacob.thompson@university.edu', 'Jacob Thompson', 1, 2, '$2y$10$encrypted_password_hash17', NULL, NULL),
('2020t01105', 'isabella.clark@university.edu', 'Isabella Clark', 1, 2, '$2y$10$encrypted_password_hash18', NULL, NULL),
('2020t01110', 'mason.rodriguez@university.edu', 'Mason Rodriguez', 1, 2, '$2y$10$encrypted_password_hash19', NULL, NULL),
('2020t01115', 'sophia.lewis@university.edu', 'Sophia Lewis', 1, 2, '$2y$10$encrypted_password_hash20', NULL, NULL),
('2020t01301', 'noah.lee@university.edu', 'Noah Lee', 3, 2, '$2y$10$encrypted_password_hash21', NULL, NULL),
('2020t01305', 'harper.walker@university.edu', 'Harper Walker', 3, 2, '$2y$10$encrypted_password_hash22', NULL, NULL),
('2020t01310', 'liam.hall@university.edu', 'Liam Hall', 3, 2, '$2y$10$encrypted_password_hash23', NULL, NULL),
('2020t01315', 'evelyn.allen@university.edu', 'Evelyn Allen', 3, 2, '$2y$10$encrypted_password_hash24', NULL, NULL),
('2020t01401', 'henry.young@university.edu', 'Henry Young', 4, 2, '$2y$10$encrypted_password_hash25', NULL, NULL),
('2020t01405', 'abigail.hernandez@university.edu', 'Abigail Hernandez', 4, 2, '$2y$10$encrypted_password_hash26', NULL, NULL),
('2020t01410', 'alexander.king@university.edu', 'Alexander King', 4, 2, '$2y$10$encrypted_password_hash27', NULL, NULL),
('2020t01415', 'emily.wright@university.edu', 'Emily Wright', 4, 2, '$2y$10$encrypted_password_hash28', NULL, NULL),
('2020t01501', 'sebastian.lopez@university.edu', 'Sebastian Lopez', 2, 2, '$2y$10$encrypted_password_hash29', NULL, NULL),
('2020t01505', 'elizabeth.hill@university.edu', 'Elizabeth Hill', 2, 2, '$2y$10$encrypted_password_hash30', NULL, NULL),
('2020t01510', 'jack.scott@university.edu', 'Jack Scott', 2, 2, '$2y$10$encrypted_password_hash31', NULL, NULL),
('2020t01515', 'avery.green@university.edu', 'Avery Green', 2, 2, '$2y$10$encrypted_password_hash32', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `2021_22`
--

CREATE TABLE `2021_22` (
  `student_id` char(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `department_id` int(11) NOT NULL,
  `batch_id` int(10) NOT NULL DEFAULT 3,
  `password` varchar(150) NOT NULL,
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `2021_22`
--

INSERT INTO `2021_22` (`student_id`, `email`, `name`, `department_id`, `batch_id`, `password`, `reset_token_hash`, `reset_token_expires_at`) VALUES
('2021t01101', 'daniel.adams@university.edu', 'Daniel Adams', 1, 3, '$2y$10$encrypted_password_hash33', NULL, NULL),
('2021t01105', 'madison.baker@university.edu', 'Madison Baker', 1, 3, '$2y$10$encrypted_password_hash34', NULL, NULL),
('2021t01110', 'matthew.gonzalez@university.edu', 'Matthew Gonzalez', 1, 3, '$2y$10$encrypted_password_hash35', NULL, NULL),
('2021t01115', 'scarlett.nelson@university.edu', 'Scarlett Nelson', 1, 3, '$2y$10$encrypted_password_hash36', NULL, NULL),
('2021t01301', 'jackson.carter@university.edu', 'Jackson Carter', 3, 3, '$2y$10$encrypted_password_hash37', NULL, NULL),
('2021t01305', 'victoria.mitchell@university.edu', 'Victoria Mitchell', 3, 3, '$2y$10$encrypted_password_hash38', NULL, NULL),
('2021t01310', 'aiden.perez@university.edu', 'Aiden Perez', 3, 3, '$2y$10$encrypted_password_hash39', NULL, NULL),
('2021t01315', 'aria.roberts@university.edu', 'Aria Roberts', 3, 3, '$2y$10$encrypted_password_hash40', NULL, NULL),
('2021t01401', 'luke.turner@university.edu', 'Luke Turner', 4, 3, '$2y$10$encrypted_password_hash41', NULL, NULL),
('2021t01405', 'grace.phillips@university.edu', 'Grace Phillips', 4, 3, '$2y$10$encrypted_password_hash42', NULL, NULL),
('2021t01410', 'gabriel.campbell@university.edu', 'Gabriel Campbell', 4, 3, '$2y$10$encrypted_password_hash43', NULL, NULL),
('2021t01415', 'chloe.parker@university.edu', 'Chloe Parker', 4, 3, '$2y$10$encrypted_password_hash44', NULL, NULL),
('2021t01501', 'owen.evans@university.edu', 'Owen Evans', 2, 3, '$2y$10$encrypted_password_hash45', NULL, NULL),
('2021t01505', 'layla.edwards@university.edu', 'Layla Edwards', 2, 3, '$2y$10$encrypted_password_hash46', NULL, NULL),
('2021t01510', 'wyatt.collins@university.edu', 'Wyatt Collins', 2, 3, '$2y$10$encrypted_password_hash47', NULL, NULL),
('2021t01515', 'zoey.stewart@university.edu', 'Zoey Stewart', 2, 3, '$2y$10$encrypted_password_hash48', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `2022_23`
--

CREATE TABLE `2022_23` (
  `student_id` char(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `department_id` int(11) NOT NULL,
  `batch_id` int(10) NOT NULL DEFAULT 4,
  `password` varchar(150) NOT NULL,
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `2022_23`
--

INSERT INTO `2022_23` (`student_id`, `email`, `name`, `department_id`, `batch_id`, `password`, `reset_token_hash`, `reset_token_expires_at`) VALUES
('2022t01101', 'grayson.sanchez@university.edu', 'Grayson Sanchez', 1, 4, '$2y$10$encrypted_password_hash49', NULL, NULL),
('2022t01105', 'nora.morris@university.edu', 'Nora Morris', 1, 4, '$2y$10$encrypted_password_hash50', NULL, NULL),
('2022t01110', 'carter.rogers@university.edu', 'Carter Rogers', 1, 4, '$2y$10$encrypted_password_hash51', NULL, NULL),
('2022t01115', 'penelope.reed@university.edu', 'Penelope Reed', 1, 4, '$2y$10$encrypted_password_hash52', NULL, NULL),
('2022t01301', 'julian.cook@university.edu', 'Julian Cook', 3, 4, '$2y$10$encrypted_password_hash53', NULL, NULL),
('2022t01305', 'hazel.morgan@university.edu', 'Hazel Morgan', 3, 4, '$2y$10$encrypted_password_hash54', NULL, NULL),
('2022t01310', 'leo.bailey@university.edu', 'Leo Bailey', 3, 4, '$2y$10$encrypted_password_hash55', NULL, NULL),
('2022t01315', 'violet.rivera@university.edu', 'Violet Rivera', 3, 4, '$2y$10$encrypted_password_hash56', NULL, NULL),
('2022t01401', 'hudson.cooper@university.edu', 'Hudson Cooper', 4, 4, '$2y$10$encrypted_password_hash57', NULL, NULL),
('2022t01405', 'aurora.richardson@university.edu', 'Aurora Richardson', 4, 4, '$2y$10$encrypted_password_hash58', NULL, NULL),
('2022t01410', 'easton.cox@university.edu', 'Easton Cox', 4, 4, '$2y$10$encrypted_password_hash59', NULL, NULL),
('2022t01415', 'savannah.howard@university.edu', 'Savannah Howard', 4, 4, '$2y$10$encrypted_password_hash60', NULL, NULL),
('2022t01501', 'lincoln.ward@university.edu', 'Lincoln Ward', 2, 4, '$2y$10$encrypted_password_hash61', NULL, NULL),
('2022t01505', 'brooklyn.torres@university.edu', 'Brooklyn Torres', 2, 4, '$2y$10$encrypted_password_hash62', NULL, NULL),
('2022t01510', 'maverick.peterson@university.edu', 'Maverick Peterson', 2, 4, '$2y$10$encrypted_password_hash63', NULL, NULL),
('2022t01515', 'bella.gray@university.edu', 'Bella Gray', 2, 4, '$2y$10$encrypted_password_hash64', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `absences`
--

CREATE TABLE `absences` (
  `id` int(11) NOT NULL,
  `batch_year` varchar(8) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `student_id` varchar(10) NOT NULL,
  `date_of_absence` date NOT NULL,
  `reason` text NOT NULL,
  `proof_file_path` varchar(255) NOT NULL,
  `submission_date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` varchar(10) NOT NULL,
  `password` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `password`) VALUES
('administrator', 'SecurePass2025!');

-- --------------------------------------------------------

--
-- Table structure for table `ag_3101_attendance`
--

CREATE TABLE `ag_3101_attendance` (
  `ag_3101_attendance_id` int(11) NOT NULL,
  `scanned_Date` date NOT NULL,
  `scanned_Time` time NOT NULL,
  `Subject_id` int(11) NOT NULL DEFAULT 1,
  `Subject_Code` varchar(20) NOT NULL DEFAULT 'AG 3101',
  `student_id` char(10) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ag_3202_attendance`
--

CREATE TABLE `ag_3202_attendance` (
  `ag_3202_attendance_id` int(11) NOT NULL,
  `scanned_Date` date NOT NULL,
  `scanned_Time` time NOT NULL,
  `Subject_id` int(11) NOT NULL DEFAULT 2,
  `Subject_Code` varchar(20) NOT NULL DEFAULT 'AG 3202',
  `student_id` char(10) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `batch`
--

CREATE TABLE `batch` (
  `batch_id` int(11) NOT NULL,
  `year` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `batch`
--

INSERT INTO `batch` (`batch_id`, `year`) VALUES
(1, '2019_20'),
(2, '2020_21'),
(3, '2021_22'),
(4, '2022_23');

-- --------------------------------------------------------

--
-- Table structure for table `batch_subject`
--

CREATE TABLE `batch_subject` (
  `batch_subject_id` int(11) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `Subject_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `lecturer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `batch_subject`
--

INSERT INTO `batch_subject` (`batch_subject_id`, `batch_id`, `Subject_id`, `department_id`, `lecturer_id`) VALUES
(1, 1, 8, 2, 12),
(2, 1, 5, 1, 13),
(3, 2, 8, 2, 16),
(4, 2, 9, 2, 17),
(5, 3, 10, 4, 24),
(6, 3, 6, 1, 14),
(7, 4, 1, 3, 19),
(8, 4, 2, 3, 20),
(9, 1, 6, 1, 15),
(10, 2, 3, 3, 21);

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `department_id` int(11) NOT NULL,
  `department_name` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`department_id`, `department_name`) VALUES
(1, 'IAT'),
(2, 'ICT'),
(3, 'AT'),
(4, 'ET');

-- --------------------------------------------------------

--
-- Table structure for table `et_1302_attendance`
--

CREATE TABLE `et_1302_attendance` (
  `et_1302_attendance_id` int(11) NOT NULL,
  `scanned_Date` date NOT NULL,
  `scanned_Time` time NOT NULL,
  `Subject_id` int(11) NOT NULL DEFAULT 3,
  `Subject_Code` varchar(20) NOT NULL DEFAULT 'ET 1302',
  `student_id` char(10) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `et_1303_attendance`
--

CREATE TABLE `et_1303_attendance` (
  `et_1303_attendance_id` int(11) NOT NULL,
  `scanned_Date` date NOT NULL,
  `scanned_Time` time NOT NULL,
  `Subject_id` int(11) NOT NULL DEFAULT 4,
  `Subject_Code` varchar(20) NOT NULL DEFAULT 'ET 1303',
  `student_id` char(10) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `Event_Number` int(5) NOT NULL,
  `topic` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `venue` varchar(100) NOT NULL,
  `audience` varchar(100) NOT NULL,
  `document` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `Event_Number`, `topic`, `date`, `time`, `venue`, `audience`, `document`) VALUES
(1, 101, 'Technology Innovation Summit 2025', '2025-01-15', '09:00:00', 'Main Auditorium', 'All Students and Faculty', 'uploads/tech_summit_2025.pdf'),
(2, 102, 'Career Development Workshop', '2025-01-22', '14:00:00', 'Conference Hall A', 'Final Year Students', 'uploads/career_workshop.pdf'),
(3, 103, 'Research Symposium on AI and Machine Learning', '2025-02-05', '10:00:00', 'Science Building Auditorium', 'Graduate Students and Researchers', 'uploads/ai_symposium.pdf'),
(4, 104, 'Industry-Academia Collaboration Forum', '2025-02-18', '13:30:00', 'Business Center', 'Faculty and Industry Partners', 'uploads/industry_forum.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `events_attendance`
--

CREATE TABLE `events_attendance` (
  `events_attendance_id` int(11) NOT NULL,
  `scanned_Date` date NOT NULL,
  `scanned_Time` time NOT NULL,
  `event_id` int(11) NOT NULL,
  `Event_Number` int(5) NOT NULL,
  `student_id` char(10) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events_attendance`
--

INSERT INTO `events_attendance` (`events_attendance_id`, `scanned_Date`, `scanned_Time`, `event_id`, `Event_Number`, `student_id`, `batch_id`, `department_id`) VALUES
(1, '2025-01-15', '09:15:00', 1, 101, '2019t01501', 1, 2),
(2, '2025-01-15', '09:18:00', 1, 101, '2020t01101', 2, 1),
(3, '2025-01-15', '09:22:00', 1, 101, '2021t01101', 3, 1),
(4, '2025-01-15', '09:25:00', 1, 101, '2022t01101', 4, 1),
(5, '2025-01-22', '14:10:00', 2, 102, '2019t01101', 1, 1),
(6, '2025-01-22', '14:15:00', 2, 102, '2020t01301', 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `ft_1101_attendance`
--

CREATE TABLE `ft_1101_attendance` (
  `ft_1101_attendance_id` int(11) NOT NULL,
  `scanned_Date` date NOT NULL,
  `scanned_Time` time NOT NULL,
  `Subject_id` int(11) NOT NULL DEFAULT 5,
  `Subject_Code` varchar(20) NOT NULL DEFAULT 'FT 1101',
  `student_id` char(10) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ft_1101_attendance`
--

INSERT INTO `ft_1101_attendance` (`ft_1101_attendance_id`, `scanned_Date`, `scanned_Time`, `Subject_id`, `Subject_Code`, `student_id`, `batch_id`, `department_id`) VALUES
(1, '2025-01-08', '10:00:00', 5, 'FT 1101', '2019t01101', 1, 1),
(2, '2025-01-08', '10:02:00', 5, 'FT 1101', '2019t01105', 1, 1),
(3, '2025-01-10', '10:00:00', 5, 'FT 1101', '2019t01110', 1, 1),
(4, '2025-01-10', '10:05:00', 5, 'FT 1101', '2019t01115', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ia_4201_attendance`
--

CREATE TABLE `ia_4201_attendance` (
  `ia_4201_attendance_id` int(11) NOT NULL,
  `scanned_Date` date NOT NULL,
  `scanned_Time` time NOT NULL,
  `Subject_id` int(11) NOT NULL DEFAULT 6,
  `Subject_Code` varchar(20) NOT NULL DEFAULT 'IA 4201',
  `student_id` char(10) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ia_4202_attendance`
--

CREATE TABLE `ia_4202_attendance` (
  `ia_4202_attendance_id` int(11) NOT NULL,
  `scanned_Date` date NOT NULL,
  `scanned_Time` time NOT NULL,
  `Subject_id` int(11) NOT NULL DEFAULT 7,
  `Subject_Code` varchar(20) NOT NULL DEFAULT 'IA 4202',
  `student_id` char(10) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ic_2201_attendance`
--

CREATE TABLE `ic_2201_attendance` (
  `ic_2201_attendance` int(11) NOT NULL,
  `scanned_Date` date NOT NULL,
  `scanned_Time` time NOT NULL,
  `Subject_id` int(11) NOT NULL DEFAULT 8,
  `Subject_Code` varchar(20) NOT NULL DEFAULT 'IC 2201',
  `student_id` char(10) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ic_2201_attendance`
--

INSERT INTO `ic_2201_attendance` (`ic_2201_attendance`, `scanned_Date`, `scanned_Time`, `Subject_id`, `Subject_Code`, `student_id`, `batch_id`, `department_id`) VALUES
(1, '2025-01-10', '08:30:00', 8, 'IC 2201', '2019t01501', 1, 2),
(2, '2025-01-10', '08:32:00', 8, 'IC 2201', '2019t01505', 1, 2),
(3, '2025-01-10', '08:35:00', 8, 'IC 2201', '2019t01510', 1, 2),
(4, '2025-01-12', '08:30:00', 8, 'IC 2201', '2019t01501', 1, 2),
(5, '2025-01-12', '08:33:00', 8, 'IC 2201', '2019t01515', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `ic_2202_attendance`
--

CREATE TABLE `ic_2202_attendance` (
  `ic_2202_attendance_id` int(11) NOT NULL,
  `scanned_Date` date NOT NULL,
  `scanned_Time` time NOT NULL,
  `Subject_id` int(11) NOT NULL DEFAULT 9,
  `Subject_Code` varchar(20) NOT NULL DEFAULT 'IC 2202',
  `student_id` char(10) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ic_2203_attendance`
--

CREATE TABLE `ic_2203_attendance` (
  `ic_2203_attendance_id` int(11) NOT NULL,
  `scanned_Date` date NOT NULL,
  `scanned_Time` time NOT NULL,
  `Subject_id` int(11) NOT NULL DEFAULT 10,
  `Subject_Code` varchar(20) NOT NULL DEFAULT 'IC 2203',
  `student_id` char(10) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lecturer`
--

CREATE TABLE `lecturer` (
  `lecturer_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `department_id` int(11) NOT NULL,
  `password` varchar(150) NOT NULL,
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lecturer`
--

INSERT INTO `lecturer` (`lecturer_id`, `name`, `email`, `department_id`, `password`, `reset_token_hash`, `reset_token_expires_at`) VALUES
(12, 'Dr. Robert Chen', 'robert.chen@university.edu', 2, '$2y$10$hiXWN.DoiuBsc2PkKFItWuHY.M0Got2jf9w1g5on4G57XvWg077Bu', NULL, NULL),
(13, 'Prof. Maria Rodriguez', 'maria.rodriguez@university.edu', 1, '$2y$10$VEABA9deglPc95W1TLCOIO6Lm78lC2D7b7rc1fvVr6hQ4GB/pr6cG', NULL, NULL),
(14, 'Dr. Jennifer Smith', 'jennifer.smith@university.edu', 1, '$2y$10$vTtxnc9pwg0dFMPujJTu4OPNMQPJRGxI6z1wFo4h.OQ19Fl94ZMmq', NULL, NULL),
(15, 'Prof. Michael Johnson', 'michael.johnson@university.edu', 1, '$2y$10$Uu9QjKmKI1dIof9QXxqlaemPT7rOte74XtPz2ClO1VGzWhkiMILKe', NULL, NULL),
(16, 'Dr. Sarah Williams', 'sarah.williams@university.edu', 2, '$2y$10$ksaz047On1N4gNrGNmYw/ecO0BExxda0tWuziQEoGS284mzYp6kBq', NULL, NULL),
(17, 'Prof. Amanda Davis', 'amanda.davis@university.edu', 2, '$2y$10$ugeFbZlzbPSeERE6jW5zSuo.zpiO4o1MCDUU6tQpVuvv24VtMOkwy', NULL, NULL),
(18, 'Dr. Lisa Brown', 'lisa.brown@university.edu', 2, '$2y$10$mD7NPEWzMCqDLIo8UsuaSuOe0IvWicYFT8CbQAVP.a6IgNbJtkrB6', NULL, NULL),
(19, 'Prof. David Miller', 'david.miller@university.edu', 3, '$2y$10$bkh7qV0iXPGBvPJg9q9.weWh1IsN4A4hSPdn.SAiQlc.yB3GuDbB2', NULL, NULL),
(20, 'Dr. Karen Wilson', 'karen.wilson@university.edu', 3, '$2y$10$aHdNlxQ.tgzgrQB1YP7cE.xoKwOkmQoBfIDSsKn/RaNOV7wjzb8Q6', NULL, NULL),
(21, 'Prof. Jessica Moore', 'jessica.moore@university.edu', 3, '$2y$10$W543JdWpn7Lij/csGQcSOe.ct0gukMIuTVmcAKRgay6fdPuTQVZZi', NULL, NULL),
(22, 'Dr. Christopher Taylor', 'christopher.taylor@university.edu', 4, '$2y$10$LpJDzQUNUfL7hZS3s54P3uFDlWjvjISA5CpHEzZJLKJbl5QcPnEy2', NULL, NULL),
(23, 'Prof. Michelle Anderson', 'michelle.anderson@university.edu', 4, '$2y$10$MIz7y0sOZhMyj5IqhK3lheb3NAbro9.KzVi71ltT1E.7Gy2eVOZrC', NULL, NULL),
(24, 'Dr. Kevin Thompson', 'kevin.thompson@university.edu', 4, '$2y$10$AcqEynfQ.4vqOGbVDbNFwOKbyW5ItxXcwA1SBov6cGp1wtg8kN1Nq', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lectures`
--

CREATE TABLE `lectures` (
  `lecture_id` int(11) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `subject_id` varchar(10) NOT NULL,
  `title` varchar(100) NOT NULL,
  `instructor` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `venue` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lectures`
--

INSERT INTO `lectures` (`lecture_id`, `batch_id`, `department_id`, `subject_id`, `title`, `instructor`, `date`, `time`, `venue`) VALUES
(1, 1, 2, '8', 'Introduction to Database Design', 'Dr. Robert Chen', '2025-01-10', '08:30:00', 'Computer Lab 1'),
(2, 1, 2, '8', 'SQL Fundamentals and Queries', 'Dr. Robert Chen', '2025-01-12', '08:30:00', 'Computer Lab 1'),
(3, 1, 1, '5', 'Workshop Safety and Basic Tools', 'Prof. Maria Rodriguez', '2025-01-08', '10:00:00', 'Workshop Building'),
(4, 2, 1, '5', 'Advanced Manufacturing Techniques', 'Prof. Maria Rodriguez', '2025-01-09', '10:00:00', 'Workshop Building'),
(5, 3, 4, '10', 'Project Planning and Methodology', 'Dr. Kevin Thompson', '2025-01-11', '14:00:00', 'Lecture Hall B');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subject_id` int(11) NOT NULL,
  `subject_code` varchar(20) NOT NULL,
  `subject_name` varchar(100) NOT NULL,
  `total_lectures` int(11) NOT NULL,
  `table_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subject_id`, `subject_code`, `subject_name`, `total_lectures`, `table_name`) VALUES
(1, 'AG 3101 ', 'Biostatistics', 13, 'ag_3101_attendance'),
(2, 'AG 3202', 'Microbes and Agriculture\r\n\r\n', 12, 'ag_3202_attendance'),
(3, 'ET 1302', 'Basic Soil Science\r\n\r\n', 13, 'et_1302_attendance'),
(4, 'ET 1303', 'Chemicals in the Environment\r\n\r\n', 13, 'et_1303_attendance'),
(5, 'FT 1101', 'Workshop Practice\r\n\r\n', 10, 'ft_1101_attendance'),
(6, 'IA 4201', 'Power Electronics\r\n\r\n', 15, 'ia_4201_attendance'),
(7, 'IA 4202', 'Programmable Logic Controllers', 13, 'ia_4201_attendance'),
(8, 'IC 2201', 'Database Management Systems II\r\n\r\n', 13, 'ic_2201_attendance'),
(9, 'IC 2202', 'Discrete Mathematics\r\n\r\n', 14, 'ic_2202_attendance'),
(10, 'IC 2203', 'IT project Management\r\n\r\n', 14, 'ic_2203_attendance'),
(11, 'sub_Event', 'Event', 0, 'events_attendance');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `2019_20`
--
ALTER TABLE `2019_20`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `reset_token_hash` (`reset_token_hash`),
  ADD KEY `department_id` (`department_id`),
  ADD KEY `batch_id` (`batch_id`);

--
-- Indexes for table `2020_21`
--
ALTER TABLE `2020_21`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `reset_token_hash` (`reset_token_hash`),
  ADD KEY `department_id` (`department_id`),
  ADD KEY `batch_id` (`batch_id`);

--
-- Indexes for table `2021_22`
--
ALTER TABLE `2021_22`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `reset_token_hash` (`reset_token_hash`),
  ADD KEY `department_id` (`department_id`),
  ADD KEY `batch_id` (`batch_id`);

--
-- Indexes for table `2022_23`
--
ALTER TABLE `2022_23`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `reset_token_hash` (`reset_token_hash`),
  ADD KEY `department_id` (`department_id`),
  ADD KEY `batch_id` (`batch_id`);

--
-- Indexes for table `absences`
--
ALTER TABLE `absences`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ag_3101_attendance`
--
ALTER TABLE `ag_3101_attendance`
  ADD PRIMARY KEY (`ag_3101_attendance_id`),
  ADD KEY `Subject_id` (`Subject_id`),
  ADD KEY `batch_id` (`batch_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `ag_3202_attendance`
--
ALTER TABLE `ag_3202_attendance`
  ADD PRIMARY KEY (`ag_3202_attendance_id`),
  ADD KEY `Subject_id` (`Subject_id`),
  ADD KEY `batch_id` (`batch_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `batch`
--
ALTER TABLE `batch`
  ADD PRIMARY KEY (`batch_id`);

--
-- Indexes for table `batch_subject`
--
ALTER TABLE `batch_subject`
  ADD PRIMARY KEY (`batch_subject_id`),
  ADD KEY `batch_id` (`batch_id`),
  ADD KEY `department_id` (`department_id`),
  ADD KEY `Subject_id` (`Subject_id`),
  ADD KEY `lecturer_id` (`lecturer_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `et_1302_attendance`
--
ALTER TABLE `et_1302_attendance`
  ADD PRIMARY KEY (`et_1302_attendance_id`),
  ADD KEY `Subject_id` (`Subject_id`),
  ADD KEY `batch_id` (`batch_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `et_1303_attendance`
--
ALTER TABLE `et_1303_attendance`
  ADD PRIMARY KEY (`et_1303_attendance_id`),
  ADD KEY `Subject_id` (`Subject_id`),
  ADD KEY `batch_id` (`batch_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `events_attendance`
--
ALTER TABLE `events_attendance`
  ADD PRIMARY KEY (`events_attendance_id`),
  ADD KEY `batch_id` (`batch_id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `ft_1101_attendance`
--
ALTER TABLE `ft_1101_attendance`
  ADD PRIMARY KEY (`ft_1101_attendance_id`),
  ADD KEY `Subject_id` (`Subject_id`),
  ADD KEY `batch_id` (`batch_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `ia_4201_attendance`
--
ALTER TABLE `ia_4201_attendance`
  ADD PRIMARY KEY (`ia_4201_attendance_id`),
  ADD KEY `Subject_id` (`Subject_id`),
  ADD KEY `batch_id` (`batch_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `ia_4202_attendance`
--
ALTER TABLE `ia_4202_attendance`
  ADD PRIMARY KEY (`ia_4202_attendance_id`),
  ADD KEY `Subject_id` (`Subject_id`),
  ADD KEY `batch_id` (`batch_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `ic_2201_attendance`
--
ALTER TABLE `ic_2201_attendance`
  ADD PRIMARY KEY (`ic_2201_attendance`),
  ADD KEY `Subject_id` (`Subject_id`),
  ADD KEY `batch_id` (`batch_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `ic_2202_attendance`
--
ALTER TABLE `ic_2202_attendance`
  ADD PRIMARY KEY (`ic_2202_attendance_id`),
  ADD KEY `Subject_id` (`Subject_id`),
  ADD KEY `batch_id` (`batch_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `ic_2203_attendance`
--
ALTER TABLE `ic_2203_attendance`
  ADD PRIMARY KEY (`ic_2203_attendance_id`),
  ADD KEY `Subject_id` (`Subject_id`),
  ADD KEY `batch_id` (`batch_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `lecturer`
--
ALTER TABLE `lecturer`
  ADD PRIMARY KEY (`lecturer_id`),
  ADD UNIQUE KEY `reset_token_hash` (`reset_token_hash`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `lectures`
--
ALTER TABLE `lectures`
  ADD PRIMARY KEY (`lecture_id`),
  ADD KEY `batch_id` (`batch_id`),
  ADD KEY `department_id` (`department_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subject_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absences`
--
ALTER TABLE `absences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ag_3101_attendance`
--
ALTER TABLE `ag_3101_attendance`
  MODIFY `ag_3101_attendance_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ag_3202_attendance`
--
ALTER TABLE `ag_3202_attendance`
  MODIFY `ag_3202_attendance_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `batch`
--
ALTER TABLE `batch`
  MODIFY `batch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `batch_subject`
--
ALTER TABLE `batch_subject`
  MODIFY `batch_subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `et_1302_attendance`
--
ALTER TABLE `et_1302_attendance`
  MODIFY `et_1302_attendance_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `et_1303_attendance`
--
ALTER TABLE `et_1303_attendance`
  MODIFY `et_1303_attendance_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `events_attendance`
--
ALTER TABLE `events_attendance`
  MODIFY `events_attendance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ft_1101_attendance`
--
ALTER TABLE `ft_1101_attendance`
  MODIFY `ft_1101_attendance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ia_4201_attendance`
--
ALTER TABLE `ia_4201_attendance`
  MODIFY `ia_4201_attendance_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ia_4202_attendance`
--
ALTER TABLE `ia_4202_attendance`
  MODIFY `ia_4202_attendance_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ic_2201_attendance`
--
ALTER TABLE `ic_2201_attendance`
  MODIFY `ic_2201_attendance` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ic_2202_attendance`
--
ALTER TABLE `ic_2202_attendance`
  MODIFY `ic_2202_attendance_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ic_2203_attendance`
--
ALTER TABLE `ic_2203_attendance`
  MODIFY `ic_2203_attendance_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lecturer`
--
ALTER TABLE `lecturer`
  MODIFY `lecturer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `lectures`
--
ALTER TABLE `lectures`
  MODIFY `lecture_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=223;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `2019_20`
--
ALTER TABLE `2019_20`
  ADD CONSTRAINT `2019_20_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`),
  ADD CONSTRAINT `2019_20_ibfk_2` FOREIGN KEY (`batch_id`) REFERENCES `batch` (`batch_id`);

--
-- Constraints for table `2020_21`
--
ALTER TABLE `2020_21`
  ADD CONSTRAINT `2020_21_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`),
  ADD CONSTRAINT `2020_21_ibfk_2` FOREIGN KEY (`batch_id`) REFERENCES `batch` (`batch_id`);

--
-- Constraints for table `2021_22`
--
ALTER TABLE `2021_22`
  ADD CONSTRAINT `2021_22_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`),
  ADD CONSTRAINT `2021_22_ibfk_2` FOREIGN KEY (`batch_id`) REFERENCES `batch` (`batch_id`);

--
-- Constraints for table `2022_23`
--
ALTER TABLE `2022_23`
  ADD CONSTRAINT `2022_23_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`),
  ADD CONSTRAINT `2022_23_ibfk_2` FOREIGN KEY (`batch_id`) REFERENCES `batch` (`batch_id`);

--
-- Constraints for table `ag_3101_attendance`
--
ALTER TABLE `ag_3101_attendance`
  ADD CONSTRAINT `ag_3101_attendance_ibfk_1` FOREIGN KEY (`Subject_id`) REFERENCES `subjects` (`subject_id`),
  ADD CONSTRAINT `ag_3101_attendance_ibfk_2` FOREIGN KEY (`batch_id`) REFERENCES `batch` (`batch_id`),
  ADD CONSTRAINT `ag_3101_attendance_ibfk_3` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`);

--
-- Constraints for table `ag_3202_attendance`
--
ALTER TABLE `ag_3202_attendance`
  ADD CONSTRAINT `ag_3202_attendance_ibfk_1` FOREIGN KEY (`Subject_id`) REFERENCES `subjects` (`subject_id`),
  ADD CONSTRAINT `ag_3202_attendance_ibfk_2` FOREIGN KEY (`batch_id`) REFERENCES `batch` (`batch_id`),
  ADD CONSTRAINT `ag_3202_attendance_ibfk_3` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`);

--
-- Constraints for table `batch_subject`
--
ALTER TABLE `batch_subject`
  ADD CONSTRAINT `batch_subject_ibfk_1` FOREIGN KEY (`Subject_id`) REFERENCES `subjects` (`subject_id`),
  ADD CONSTRAINT `batch_subject_ibfk_2` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturer` (`lecturer_id`);

--
-- Constraints for table `et_1302_attendance`
--
ALTER TABLE `et_1302_attendance`
  ADD CONSTRAINT `et_1302_attendance_ibfk_1` FOREIGN KEY (`Subject_id`) REFERENCES `subjects` (`subject_id`),
  ADD CONSTRAINT `et_1302_attendance_ibfk_2` FOREIGN KEY (`batch_id`) REFERENCES `batch` (`batch_id`),
  ADD CONSTRAINT `et_1302_attendance_ibfk_3` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`);

--
-- Constraints for table `et_1303_attendance`
--
ALTER TABLE `et_1303_attendance`
  ADD CONSTRAINT `et_1303_attendance_ibfk_1` FOREIGN KEY (`Subject_id`) REFERENCES `subjects` (`subject_id`),
  ADD CONSTRAINT `et_1303_attendance_ibfk_2` FOREIGN KEY (`batch_id`) REFERENCES `batch` (`batch_id`),
  ADD CONSTRAINT `et_1303_attendance_ibfk_3` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`);

--
-- Constraints for table `events_attendance`
--
ALTER TABLE `events_attendance`
  ADD CONSTRAINT `events_attendance_ibfk_1` FOREIGN KEY (`batch_id`) REFERENCES `batch` (`batch_id`),
  ADD CONSTRAINT `events_attendance_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`);

--
-- Constraints for table `ft_1101_attendance`
--
ALTER TABLE `ft_1101_attendance`
  ADD CONSTRAINT `ft_1101_attendance_ibfk_1` FOREIGN KEY (`Subject_id`) REFERENCES `subjects` (`subject_id`),
  ADD CONSTRAINT `ft_1101_attendance_ibfk_2` FOREIGN KEY (`batch_id`) REFERENCES `batch` (`batch_id`),
  ADD CONSTRAINT `ft_1101_attendance_ibfk_3` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`);

--
-- Constraints for table `ia_4201_attendance`
--
ALTER TABLE `ia_4201_attendance`
  ADD CONSTRAINT `ia_4201_attendance_ibfk_1` FOREIGN KEY (`Subject_id`) REFERENCES `subjects` (`subject_id`),
  ADD CONSTRAINT `ia_4201_attendance_ibfk_2` FOREIGN KEY (`batch_id`) REFERENCES `batch` (`batch_id`),
  ADD CONSTRAINT `ia_4201_attendance_ibfk_3` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`);

--
-- Constraints for table `ia_4202_attendance`
--
ALTER TABLE `ia_4202_attendance`
  ADD CONSTRAINT `ia_4202_attendance_ibfk_1` FOREIGN KEY (`Subject_id`) REFERENCES `subjects` (`subject_id`),
  ADD CONSTRAINT `ia_4202_attendance_ibfk_2` FOREIGN KEY (`batch_id`) REFERENCES `batch` (`batch_id`),
  ADD CONSTRAINT `ia_4202_attendance_ibfk_3` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`);

--
-- Constraints for table `ic_2201_attendance`
--
ALTER TABLE `ic_2201_attendance`
  ADD CONSTRAINT `ic_2201_attendance_ibfk_1` FOREIGN KEY (`Subject_id`) REFERENCES `subjects` (`subject_id`),
  ADD CONSTRAINT `ic_2201_attendance_ibfk_2` FOREIGN KEY (`batch_id`) REFERENCES `batch` (`batch_id`),
  ADD CONSTRAINT `ic_2201_attendance_ibfk_3` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`);

--
-- Constraints for table `ic_2202_attendance`
--
ALTER TABLE `ic_2202_attendance`
  ADD CONSTRAINT `ic_2202_attendance_ibfk_1` FOREIGN KEY (`Subject_id`) REFERENCES `subjects` (`subject_id`),
  ADD CONSTRAINT `ic_2202_attendance_ibfk_2` FOREIGN KEY (`batch_id`) REFERENCES `batch` (`batch_id`),
  ADD CONSTRAINT `ic_2202_attendance_ibfk_3` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`);

--
-- Constraints for table `ic_2203_attendance`
--
ALTER TABLE `ic_2203_attendance`
  ADD CONSTRAINT `ic_2203_attendance_ibfk_1` FOREIGN KEY (`Subject_id`) REFERENCES `subjects` (`subject_id`),
  ADD CONSTRAINT `ic_2203_attendance_ibfk_2` FOREIGN KEY (`batch_id`) REFERENCES `batch` (`batch_id`),
  ADD CONSTRAINT `ic_2203_attendance_ibfk_3` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
