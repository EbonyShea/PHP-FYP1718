-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 01, 2018 at 11:00 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `logicportal`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `Ann_ID` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `Ann_Content` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `Ann_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `User_ID` char(10) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`Ann_ID`, `Ann_Content`, `Ann_Date`, `User_ID`) VALUES
('A000000003', 'Website is up and running! Will be conducting update weekly on Tuesday.', '2018-02-07 09:59:15', 'U000000001'),
('A000000004', 'Simulator bug fixed', '2018-02-07 09:59:32', 'U000000001'),
('A000000005', 'For future improvement, please do help provide feedback for us using the survey banner :) Thanks a lot', '2018-02-07 10:00:06', 'U000000001'),
('A000000006', 'Please note that no profanity is acceptable, please refrain from doing so or else your account will be blocked. Thank you.', '2018-02-07 10:00:56', 'U000000001'),
('A000000013', 'Today\\\'s the FYP Presentation day!', '2018-02-12 14:07:33', 'U000000001'),
('A000000015', 'Second day of FYP poster day!', '2018-02-13 03:54:48', 'U000000001');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `Comment_ID` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `Comment_Content` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `Comment_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Content_ID` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `User_ID` char(10) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`Comment_ID`, `Comment_Content`, `Comment_Date`, `Content_ID`, `User_ID`) VALUES
('C000000015', 'Update will be done weekly.', '2018-02-07 10:03:31', 'F000000011', 'U000000001'),
('C000000016', 'I hope there are more notes for other topic other than digital logic', '2018-02-07 10:53:44', 'F000000011', 'U000000022'),
('C000000017', 'Please post relevant topic title when posting. Thanks', '2018-02-07 10:55:28', 'F000000013', 'U000000001'),
('C000000018', 'We will post more on this topic in the future, for now google is your friend ;)', '2018-02-07 10:57:05', 'F000000012', 'U000000001'),
('C000000037', 'Please report problem to contact us as well', '2018-02-13 03:53:48', 'F000000011', 'U000000001');

-- --------------------------------------------------------

--
-- Table structure for table `content_ctr`
--

CREATE TABLE `content_ctr` (
  `Content_Type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `Counter` bigint(20) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `content_ctr`
--

INSERT INTO `content_ctr` (`Content_Type`, `Counter`) VALUES
('Announcement', 15),
('Carousel', 0),
('Comment', 37),
('Flashcard', 4),
('Forum', 34),
('Lesson', 0),
('Misc', 14),
('QA', 0),
('Quiz', 5),
('User', 39),
('Video', 56);

-- --------------------------------------------------------

--
-- Table structure for table `flashcard`
--

CREATE TABLE `flashcard` (
  `fc_ID` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `fc_Title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `fc_Desc` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `fc_Img` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fc_URL` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `fc_DL` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fc_File` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fc_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `User_ID` char(10) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `flashcard`
--

INSERT INTO `flashcard` (`fc_ID`, `fc_Title`, `fc_Desc`, `fc_Img`, `fc_URL`, `fc_DL`, `fc_File`, `fc_Date`, `User_ID`) VALUES
('FC00000001', 'Basics in Logic gates', 'Test your knowledge about the basics in logic gates', 'FC00000001_1.jpg', 'https://www.goconqr.com/en-US/p/10303617-Basics-in-Logic-gates-flash_card_decks', 'https://drive.google.com/open?id=1Be01fEJ6q0Ks2ySsDMSXi1I1XwdrLNSH', 'FC00000001.pdf', '2018-02-07 10:21:55', 'U000000001'),
('FC00000002', 'Logic Gates Boolean Algebra', 'Try to memorize Boolean Algebra with these flashcard notes.', 'FC00000002_2.jpg', 'http://www.cram.com/flashcards/logic-gates-boolean-algebra-8973430', 'https://drive.google.com/open?id=1QVGjCbFMSISqWj_BTjkaeotGTN_1lPwg', 'FC00000002.csv', '2018-02-07 10:25:46', 'U000000001'),
('FC00000003', 'Flip Flop', 'The notes about flip flops', 'FC00000003_3.jpg', 'http://www.cram.com/flashcards/flip-flop-9425022', 'https://drive.google.com/open?id=1_xP_7mZzX36P09khG09z4uLc8ZrHY_Wc', 'FC00000003.csv', '2018-02-07 10:26:33', 'U000000001');

-- --------------------------------------------------------

--
-- Table structure for table `forum`
--

CREATE TABLE `forum` (
  `Forum_ID` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `Forum_Title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Forum_Content` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `Forum_Comm` enum('1','0') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `Forum_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `User_ID` char(10) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `forum`
--

INSERT INTO `forum` (`Forum_ID`, `Forum_Title`, `Forum_Content`, `Forum_Comm`, `Forum_Date`, `User_ID`) VALUES
('F000000011', 'Problem reporting', 'If you have encountered any problem, please comment here or go to the help section and fill in the form. Thank you.', '0', '2018-02-07 10:03:07', 'U000000001'),
('F000000012', 'How do you construct Boolean Expressions?', 'There\\\'s no notes for this and I was wondering if anyone can explain to me in details or link me somewhere for the notes? ', '0', '2018-02-07 10:53:14', 'U000000022'),
('F000000013', 'Hey guys!', 'Anyone have any test papers for past years?', '0', '2018-02-07 10:54:42', 'U000000022'),
('F000000014', 'No cursing in forum', 'You will be blocked if found spreading profanity in the forum, Thank you.', '0', '2018-02-07 10:57:44', 'U000000001'),
('F000000027', 'Greetings all!', 'Please comment down below :D', '0', '2018-02-12 15:42:08', 'U000000025'),
('F000000033', 'Hello', 'Testing purpose', '0', '2018-02-13 07:48:04', 'U000000037'),
('F000000034', 'Testing', 'Yes', '0', '2018-02-13 07:59:39', 'U000000001');

-- --------------------------------------------------------

--
-- Table structure for table `misc`
--

CREATE TABLE `misc` (
  `Misc_ID` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `Misc_Title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Misc_Desc` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `Misc_Img` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Misc_URL` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Misc_DL` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Misc_File` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Misc_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `User_ID` char(10) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `misc`
--

INSERT INTO `misc` (`Misc_ID`, `Misc_Title`, `Misc_Desc`, `Misc_Img`, `Misc_URL`, `Misc_DL`, `Misc_File`, `Misc_Date`, `User_ID`) VALUES
('M000000008', 'Notes on Digital Circuits', 'Basic notes on Digital Circuits', 'M000000008_1.jpg', NULL, 'https://drive.google.com/open?id=1-62p2nSsbFATKQkDTONkO3BncqgUORu1', 'M000000008.pdf', '2018-02-07 10:37:02', 'U000000001'),
('M000000009', 'Introduction to Digital Logic and Boolean Algebra', 'Slideshow note for Digital Logic and Boolean Algebra', NULL, NULL, 'https://drive.google.com/open?id=1c5lhPiDh9Sgk4sbCag0L5hesDHOAkZki', 'M000000009.pdf', '2018-02-07 10:37:58', 'U000000001'),
('M000000010', 'Sequential Logic Circuits - Flip Flop', 'Slideshow notes on Sequential Logic Circuits', 'M000000010_2.jpg', NULL, 'https://drive.google.com/open?id=1qW4HPsRCDBjvlXc6PM6eaCGr-U5RpYce', 'M000000010.pdf', '2018-02-07 10:39:19', 'U000000001');

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `Quiz_ID` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `Quiz_Title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Quiz_Desc` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `Quiz_URL` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `Quiz_File` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Quiz_Img` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Quiz_DL` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Quiz_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `User_ID` char(10) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `quiz`
--

INSERT INTO `quiz` (`Quiz_ID`, `Quiz_Title`, `Quiz_Desc`, `Quiz_URL`, `Quiz_File`, `Quiz_Img`, `Quiz_DL`, `Quiz_Date`, `User_ID`) VALUES
('Q000000002', 'Boolean Logic & Logic Gates : The Basics', 'This is the quiz based on the video introducing the basics of Boolean logic and Logic Gates', 'https://edpuzzle.com/media/59b666770322a64aab510d49', NULL, 'Q000000002_1.jpg', NULL, '2018-02-07 10:29:40', 'U000000001'),
('Q000000003', 'Kahoot! Logic Gates', 'Play kahoot to straighten your knowledge about Logic Gate', 'https://create.kahoot.it/details/logic-gates-basics/10579611-51a1-4c15-934d-2cb8d5517d8d', NULL, 'Q000000003_2.jpg', NULL, '2018-02-07 10:33:18', 'U000000001');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `User_ID` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `First_Name` varchar(35) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Last_Name` varchar(35) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Password` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `Email` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `User_Img` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'default.png',
  `User_Type` enum('1','0') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `User_Status` enum('1','0') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `User_CreatedDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`User_ID`, `First_Name`, `Last_Name`, `Username`, `Password`, `Email`, `User_Img`, `User_Type`, `User_Status`, `User_CreatedDate`) VALUES
('U000000001', 'Huisi', 'Shea', 'Admin', '$2y$10$Dm41NXO1qVE6IjslL9lxY.PZ5f6Nyc5aYhbKva5phtsFxLmqfggve', 'CircuitFYP@gmail.com', 'U000000001.jpg', '1', '1', '2017-11-15 08:52:50'),
('U000000022', 'Normal', 'User', 'Basic', '$2y$10$3NBVSw7MQ3VWagmFI.ubfeCp5cmTYzYqX.yWnuRn76ZxRLU5uRxOy', 'Basic@gmail.com', 'U000000022.png', '0', '1', '2018-02-07 09:58:01'),
('U000000023', 'Kho', 'Chier', 'ViceAdmin', '$2y$10$KYc7IvbUablekbeub4AsfeRG7muiIeVl9xr2r5iyF1F942T7.5zRW', 'khochier1211@gmail.com', 'U000000023.jpg', '1', '1', '2018-02-11 13:11:54'),
('U000000024', 'John', 'Smith', 'JSmith', '$2y$10$2rXzW9zxDgHLankNgimoluf94tM3p01kJRVEBSQz744JYTvqkGf7m', 'JSmith@gmail.com', 'U000000024.png', '1', '1', '2018-02-12 14:02:39'),
('U000000025', 'Taylor', 'Swift', 'TaySway', '$2y$10$sdf2MKYZaQGAtv6zQtdFm.3QY7WHBeQD1bgnaFCu9rRGP2RbBgQgy', 'TaylorSwift@gmail.com', 'U000000025.png', '0', '1', '2018-02-12 15:41:18'),
('U000000029', 'Test', 'Admin', 'TestAdmin', '$2y$10$2rKXLS8H8pacH.YlyXWuu.gyoQHbKfvdA7IDNNOTlSlW.pGai2YeS', 'TestAdmin@gmail.com', 'default.png', '1', '1', '2018-02-12 22:17:57'),
('U000000034', 'New', 'User', 'NewUser', '$2y$10$jzy9h1yhdgINBYrF/jLWxeKgBxLbE3PnP2.0/.DBWjmP5Y2xZnoUu', 'Newuser@gmail.com', 'U000000034.png', '0', '1', '2018-02-13 03:54:21'),
('U000000035', 'Lecturer', 'Use', 'lecturer', '$2y$10$7LfxY41EvElVl98zf4R43OL1nQLuD4yjgb1xifoZ1zH5QHT7hrP5W', 'lect@gmail.com', 'default.png', '1', '1', '2018-02-13 06:40:38'),
('U000000036', 'tedt', 'yedf', 'tedttt', '$2y$10$5ePqJ2.sVhSWiTw/RA2AruE9NjYPfucIiIG9oKRGKe7ht.yzXrRJm', 'khor1211@gmail.com', 'default.png', '0', '1', '2018-02-13 07:39:40'),
('U000000037', 'John', 'Smith', 'JessieSmith', '$2y$10$guudiiyw9kpZMuiqcdajNu9Vt9ZLqMKkHxVACFO5q4ZAodZy.QzLW', 'JessieSmith@gmail.com', 'U000000037.png', '1', '1', '2018-02-13 07:45:49'),
('U000000038', 'Shea', 'Hui Si', 'SheaHuiSi', '$2y$10$kZi.j2FiM.TzxZ2NAx4esesMvYxwx4bhmOE/EjY4ulRHeRD4qmcIq', 'test@gmail.com', 'default.png', '0', '1', '2018-07-20 07:25:27'),
('U000000039', 'test', 'test', 'testtest', '$2y$10$8o42gxvi1s0rlyn2Hd1ApeAgG6wRR2gbI051p1RZ7EWsQJVGlyKz.', 'test12345@gmail.com', 'U000000039.jpg', '0', '1', '2018-07-26 03:18:31');

-- --------------------------------------------------------

--
-- Table structure for table `video`
--

CREATE TABLE `video` (
  `Video_ID` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `Video_Title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Video_Desc` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `Video_Img` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Video_DL` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'For drive upload',
  `Video_File` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'For local upload',
  `Video_URL` varchar(200) COLLATE utf8_unicode_ci NOT NULL COMMENT 'For YT link',
  `Video_Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `User_ID` char(10) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `video`
--

INSERT INTO `video` (`Video_ID`, `Video_Title`, `Video_Desc`, `Video_Img`, `Video_DL`, `Video_File`, `Video_URL`, `Video_Date`, `User_ID`) VALUES
('V000000038', 'Introduction to Digital Logic', 'This video will be introducing digital logic, the construction of Logic Tables and Basic logic gates.', 'V000000038_logo.png', 'https://drive.google.com/open?id=1T03LQQBT4VfukenpiJPG_1gaT03E-k9O', 'V000000038.mp4', 'https://www.youtube.com/watch?v=ebcOP9C8ojE&list=PLmXL-4X8eYaOeX8Oc65wWPHaXhtlCMGhv', '2018-02-07 10:07:00', 'U000000001'),
('V000000039', 'Boolean Logic & Logic Gates', 'With the just two states, on and off, the flow of electricity can be used to perform a number of logical operations.', 'V000000039_2.jpg', 'https://drive.google.com/open?id=18FMhGEicGG5dHMhFW4RTil9Cm7aT55Ah', 'V000000039.mp4', 'https://www.youtube.com/watch?v=gI-qXk7XojA&index=2&list=PLmXL-4X8eYaOeX8Oc65wWPHaXhtlCMGhv', '2018-02-07 10:09:18', 'U000000001'),
('V000000040', 'Representing Numbers and Letters with Binary', 'How computers use a stream of 1s and 0s to represent all of our data - fromrn text messages and photos to music and webpages.', 'V000000040_3.jpg', 'https://drive.google.com/open?id=1weSSEJRJf7YgAln5Zwdw_vhLRqEKf8Bb', 'V000000040.mp4', 'https://www.youtube.com/watch?v=1GSjbWt0c9M&list=PLmXL-4X8eYaOeX8Oc65wWPHaXhtlCMGhv&index=3', '2018-02-07 10:11:36', 'U000000001'),
('V000000041', 'Difference between Latch and Flip Flop', 'This video talk about difference between latch and flip flop', 'V000000041_4.jpg', 'https://drive.google.com/open?id=1Hp7E0PtY-4yt4GNA1esPfd9dEZLpEhMX', 'V000000041.mp4', 'https://www.youtube.com/watch?v=m1QBxTeVaNs&list=PLmXL-4X8eYaOeX8Oc65wWPHaXhtlCMGhv&index=4', '2018-02-07 10:14:25', 'U000000001'),
('V000000042', 'SR Latch | NOR and NAND SR Latch', 'This video talk about how to construct NOR and NAND SR Latch', 'V000000042_5.jpg', 'https://drive.google.com/open?id=1CXf1f6Xy5UAA2FxLFRO94SowNkdwJoky', 'V000000042.mp4', 'https://www.youtube.com/watch?v=kt8d3CYWGH4&list=PLmXL-4X8eYaOeX8Oc65wWPHaXhtlCMGhv&index=5', '2018-02-07 10:15:35', 'U000000001'),
('V000000043', 'Introduction to SR Flip Flop', 'This video will talk about constructing SR Flip Flop', 'V000000043_6.jpg', 'https://drive.google.com/open?id=1xXfr8_JsAhr9ahxLyKgspzlyQze8YWID', 'V000000043.mp4', 'https://www.youtube.com/watch?v=HZg7fNu-l24&index=6&list=PLmXL-4X8eYaOeX8Oc65wWPHaXhtlCMGhv', '2018-02-07 10:16:53', 'U000000001'),
('V000000044', 'Introduction to D flip flop', 'This video will teach you how to construct D Flip Flop', 'V000000044_7.jpg', 'https://drive.google.com/open?id=1BOE24jbieDsDpi7to9DWUNOaPVrHl2sH', 'V000000044.mp4', 'https://www.youtube.com/watch?v=dnfXXpW7tIw&list=PLmXL-4X8eYaOeX8Oc65wWPHaXhtlCMGhv&index=7', '2018-02-07 10:17:50', 'U000000001'),
('V000000045', 'Introduction to JK flip flop', 'This is edited', 'V000000045_8.jpg', 'https://drive.google.com/open?id=1C3a3fFQ-znWC_NyOQxTVO8L-0weuax4F', 'V000000045.mp4', 'https://www.youtube.com/watch?v=j6krFp511HA&list=PLmXL-4X8eYaOeX8Oc65wWPHaXhtlCMGhv&index=8', '2018-02-07 10:18:39', 'U000000001');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`Ann_ID`),
  ADD UNIQUE KEY `Ann_ID` (`Ann_ID`),
  ADD KEY `announcement_ibfk_1` (`User_ID`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`Comment_ID`),
  ADD UNIQUE KEY `Comment_ID` (`Comment_ID`),
  ADD KEY `comment_ibfk_1` (`User_ID`),
  ADD KEY `comment_ibfk_2` (`Content_ID`);

--
-- Indexes for table `content_ctr`
--
ALTER TABLE `content_ctr`
  ADD PRIMARY KEY (`Content_Type`),
  ADD UNIQUE KEY `Content_Type` (`Content_Type`);

--
-- Indexes for table `flashcard`
--
ALTER TABLE `flashcard`
  ADD PRIMARY KEY (`fc_ID`),
  ADD UNIQUE KEY `fc_ID` (`fc_ID`),
  ADD KEY `flashcard_ibfk_1` (`User_ID`);

--
-- Indexes for table `forum`
--
ALTER TABLE `forum`
  ADD PRIMARY KEY (`Forum_ID`),
  ADD UNIQUE KEY `Forum_ID` (`Forum_ID`),
  ADD KEY `forum_ibfk_1` (`User_ID`);

--
-- Indexes for table `misc`
--
ALTER TABLE `misc`
  ADD PRIMARY KEY (`Misc_ID`),
  ADD UNIQUE KEY `Misc_ID` (`Misc_ID`),
  ADD KEY `misc_ibfk_1` (`User_ID`);

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`Quiz_ID`),
  ADD UNIQUE KEY `Quiz_ID` (`Quiz_ID`),
  ADD KEY `quiz_ibfk_1` (`User_ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`User_ID`),
  ADD UNIQUE KEY `Username` (`Username`,`Email`),
  ADD UNIQUE KEY `User_ID` (`User_ID`);

--
-- Indexes for table `video`
--
ALTER TABLE `video`
  ADD PRIMARY KEY (`Video_ID`),
  ADD UNIQUE KEY `Video_ID` (`Video_ID`),
  ADD KEY `video_ibfk_1` (`User_ID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `announcement`
--
ALTER TABLE `announcement`
  ADD CONSTRAINT `announcement_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`Content_ID`) REFERENCES `forum` (`Forum_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `flashcard`
--
ALTER TABLE `flashcard`
  ADD CONSTRAINT `flashcard_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `forum`
--
ALTER TABLE `forum`
  ADD CONSTRAINT `forum_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `misc`
--
ALTER TABLE `misc`
  ADD CONSTRAINT `misc_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `quiz`
--
ALTER TABLE `quiz`
  ADD CONSTRAINT `quiz_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `video`
--
ALTER TABLE `video`
  ADD CONSTRAINT `video_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
