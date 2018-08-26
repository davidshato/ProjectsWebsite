-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 11, 2018 at 10:10 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `details`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `ID` varchar(20) NOT NULL,
  `city` varchar(50) NOT NULL,
  `street` varchar(50) NOT NULL,
  `number` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`ID`, `city`, `street`, `number`) VALUES
('308328749', 'hifa', 'lahish', '12'),
('123', 'hifa', 'hifa', '2'),
('145', 'hifa', 'hifa St', '2'),
('159', 'tel', 'hifa', '2'),
('147', 'hifa', 'hifa', '2'),
('745', 'hifa', 'hifa St', '2'),
('123456', 'hifa', 'hifa St', '2');

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE `person` (
  `ID` varchar(25) NOT NULL DEFAULT '',
  `firstname` varchar(25) NOT NULL,
  `lastname` varchar(25) NOT NULL,
  `password` varchar(256) NOT NULL,
  `phoneNumber` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `Admin` varchar(25) NOT NULL,
  `picture` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`ID`, `firstname`, `lastname`, `password`, `phoneNumber`, `email`, `Admin`, `picture`) VALUES
('123', 'David', 'Sato', '$2y$10$S1zj9Qog2ILqB6kUeOW.qeoKh.kX/u5iAogv2zfih6XWqGukYYKy2', '0502774414', 'David0302@gmail.com', '0', ''),
('123456', 'david', 'da', '$2y$10$6DqIYX.MGNZ0LB7H/fxxXujwd8a.rmtiWB3mMnizG1WHG8IL9tlui', '0552288749', 'David0302@gmail.com', '1', 'uploads/Mona_Lisa.jpg'),
('145', 'alon', 'alon', '$2y$10$7fapLs4kcB9/3HZoSyaeNeDweBilWL1jdO8RUENuF/M244iunH2rS', '056666666', 'David0302@gmail.com', '0', 'uploads/Mona_Lisa.jpg'),
('147', 'avi', 'shato', '$2y$10$MeG97qkKqLIR9YwignsUCe5XxefB7PuhxLrqfw12yFFUWh0EuRvSu', '0552288749', 'David0302@gmail.com', '0', 'uploads/Mona_Lisa.jpg'),
('159', 'moshe', 'asd', '$2y$10$zDTCSgB5gFDoTwh698lmWuBW1gBxQyLcPuERnHSJDznA5FIQJ4B5.', '0552288749', 'David0302@gmail.com', '0', ''),
('308328749', 'moshe', 'shato', '$2y$10$xgESnCkO.JKy/cON..btIeVKHmJIoEI0DgqgPeVSJyXJLWxcP1J6e', '0558822034', 'David0302@gmail.com', '0', ''),
('745', 'moshe ', 'David', '$2y$10$tBPstu8IZvC01M2REwh8weU9Ow2T/Cp7.QasuwRGZMD4A1HGqGkP2', '0552288749', 'David0302@gmail.com', '0', 'uploads/Mona_Lisa.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `picture` varchar(50) NOT NULL,
  `proj_date` date NOT NULL,
  `art_name` varchar(50) NOT NULL,
  `projectName` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `picture`, `proj_date`, `art_name`, `projectName`, `country`) VALUES
(0, 'images/Mona_Lisa.jpg', '2007-05-18', 'David Shato', 'david', 'israel'),
(4, 'images\\LEVIA.jpg', '2018-06-09', 'shai', 'LEVIA', 'romania'),
(12, 'images/dog.jpg', '2007-11-18', 'A', 'A', 'israel'),
(123, 'images/liones.jpg', '2007-11-18', 'David Shato', 'A', 'israel'),
(502774414, 'images/Mona_Lisa.jpg', '2007-10-18', 'David Shato', 'moshe', 'israel');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD KEY `ID` (`ID`);

--
-- Indexes for table `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `address_ibfk_1` FOREIGN KEY (`ID`) REFERENCES `person` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
