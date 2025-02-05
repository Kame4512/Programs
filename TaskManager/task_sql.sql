-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 12, 2024 at 07:53 PM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `task_sql`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `CategoryID` int NOT NULL,
  `CategoryName` enum('Work','Study','Professional') NOT NULL,
  `TaskID` int DEFAULT NULL,
  PRIMARY KEY (`CategoryID`),
  KEY `UserID` (`TaskID`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`CategoryID`, `CategoryName`, `TaskID`) VALUES
(1, 'Work', 1),
(2, 'Study', 1),
(3, 'Professional', 2),
(4, '', 3);

-- --------------------------------------------------------

--
-- Table structure for table `collaborators`
--

DROP TABLE IF EXISTS `collaborators`;
CREATE TABLE IF NOT EXISTS `collaborators` (
  `CollaboratorID` int NOT NULL AUTO_INCREMENT,
  `UserID` int DEFAULT NULL,
  `TaskID` int DEFAULT NULL,
  `Role` enum('Viewer','Editor') NOT NULL,
  PRIMARY KEY (`CollaboratorID`),
  UNIQUE KEY `UserID` (`UserID`,`TaskID`),
  KEY `TaskID` (`TaskID`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `collaborators`
--

INSERT INTO `collaborators` (`CollaboratorID`, `UserID`, `TaskID`, `Role`) VALUES
(5, 7, 19, 'Viewer'),
(4, 3, 1, 'Viewer'),
(3, 1, 3, 'Viewer');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `CommentID` int NOT NULL AUTO_INCREMENT,
  `Content` text NOT NULL,
  `Timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `UserID` int DEFAULT NULL,
  `TaskID` int DEFAULT NULL,
  PRIMARY KEY (`CommentID`),
  KEY `UserID` (`UserID`),
  KEY `TaskID` (`TaskID`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`CommentID`, `Content`, `Timestamp`, `UserID`, `TaskID`) VALUES
(1, 'This assignment is really tough, need some extra time!', '2024-11-21 15:00:00', 1, 1),
(2, 'I think we should adjust the presentation slides to include more data', '2024-11-21 16:30:00', 2, 2),
(3, 'I will start working on the bug fix today.', '2024-11-21 17:45:00', 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `progressupdates`
--

DROP TABLE IF EXISTS `progressupdates`;
CREATE TABLE IF NOT EXISTS `progressupdates` (
  `UpdateID` int NOT NULL AUTO_INCREMENT,
  `UpdateText` text NOT NULL,
  `Timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `TaskID` int DEFAULT NULL,
  PRIMARY KEY (`UpdateID`),
  KEY `TaskID` (`TaskID`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `progressupdates`
--

INSERT INTO `progressupdates` (`UpdateID`, `UpdateText`, `Timestamp`, `TaskID`) VALUES
(1, 'Started working on the assignment', '2024-11-21 14:00:00', 1),
(2, 'Created first draft of the presentation slides', '2024-11-21 16:00:00', 2),
(3, 'Identified the root cause of the bug', '2024-11-21 17:30:00', 3);

-- --------------------------------------------------------

--
-- Table structure for table `reminders`
--

DROP TABLE IF EXISTS `reminders`;
CREATE TABLE IF NOT EXISTS `reminders` (
  `ReminderID` int NOT NULL AUTO_INCREMENT,
  `Time` datetime NOT NULL,
  `Message` text NOT NULL,
  `UserID` int DEFAULT NULL,
  `TaskID` int DEFAULT NULL,
  PRIMARY KEY (`ReminderID`),
  KEY `UserID` (`UserID`),
  KEY `TaskID` (`TaskID`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `reminders`
--

INSERT INTO `reminders` (`ReminderID`, `Time`, `Message`, `UserID`, `TaskID`) VALUES
(1, '2024-12-07 09:00:00', 'Reminder to complete the assignment', 1, 1),
(2, '2024-11-24 08:00:00', 'Reminder for client presentation preparation', 2, 2),
(3, '2024-11-22 10:00:00', 'Reminder to start fixing the website bug', 3, 3),
(4, '2024-12-13 14:40:00', 'please Finish reading', 5, 19),
(6, '2024-12-20 16:08:00', 'right on', 5, 20);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE IF NOT EXISTS `tasks` (
  `TaskID` int NOT NULL AUTO_INCREMENT,
  `Title` varchar(255) NOT NULL,
  `Description` text,
  `DueDate` date DEFAULT NULL,
  `Priority` enum('Low','Medium','High') NOT NULL,
  `Status` enum('Pending','In Progress','Completed') NOT NULL,
  `UserID` int DEFAULT NULL,
  `CategoryID` int DEFAULT NULL,
  PRIMARY KEY (`TaskID`),
  KEY `UserID` (`UserID`),
  KEY `FK_CategoryID` (`CategoryID`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`TaskID`, `Title`, `Description`, `DueDate`, `Priority`, `Status`, `UserID`, `CategoryID`) VALUES
(23, 'Take Final Exam', 'Take the Final Exam for Web Services', '2024-12-11', 'High', 'Completed', 5, 1),
(19, 'Read Percy Jackson', 'Read Percy Jackson volumes', '2024-12-01', 'Medium', 'In Progress', 5, 1),
(20, 'Computer Science Homework', 'Finish Computer Science homework', '2024-12-12', 'High', 'In Progress', 5, 1),
(22, 'Apply for Spring Semester', 'Register for classes for spring semester', '2024-12-19', 'High', 'In Progress', 5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `UserId` int NOT NULL AUTO_INCREMENT,
  `Username` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Role` enum('student','Professional','Freelancer') NOT NULL,
  PRIMARY KEY (`UserId`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserId`, `Username`, `Email`, `Password`, `Role`) VALUES
(1, 'josh_green', 'joshgreen@gmail.com', 'password123', 'student'),
(2, 'derek_hosh', 'derekhosh@gmail.com', 'password456', 'Professional'),
(3, 'alice_williams', 'alicewilliams@gmail.com', 'password789', 'Freelancer'),
(5, 'kam', 'kameron@gmail.com', 'kam', 'student'),
(7, 'kameron', 'kamer@gmail.com', 'kam', 'student'),
(8, 'roy', 'Roy@gmail.com', 'roy', 'student');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
