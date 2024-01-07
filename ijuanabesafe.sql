-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2024 at 07:49 PM
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
-- Database: `ijuanabesafe`
--

-- --------------------------------------------------------

--
-- Table structure for table `coordinators`
--

CREATE TABLE `coordinators` (
  `coorID` varchar(100) NOT NULL,
  `coorFirstname` varchar(255) NOT NULL,
  `coorLastname` varchar(255) NOT NULL,
  `coorCampus` varchar(255) NOT NULL,
  `coorEmail` varchar(255) NOT NULL,
  `coorPassword` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coordinators`
--

INSERT INTO `coordinators` (`coorID`, `coorFirstname`, `coorLastname`, `coorCampus`, `coorEmail`, `coorPassword`) VALUES
('COOR_URD', 'Henry', 'Cavill', 'Urdaneta', 'coordinator_urd@psu.edu.ph', 'coordinator_urd');

-- --------------------------------------------------------

--
-- Table structure for table `report_comments`
--

CREATE TABLE `report_comments` (
  `commentID` int(11) NOT NULL,
  `reportID` int(11) NOT NULL,
  `commenterEmail` varchar(255) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `commentDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_registration`
--

CREATE TABLE `student_registration` (
  `studentID` varchar(100) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `studentEmail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `campus` varchar(255) NOT NULL,
  `program` varchar(255) NOT NULL,
  `yearLevel` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_registration`
--

INSERT INTO `student_registration` (`studentID`, `firstname`, `lastname`, `studentEmail`, `password`, `campus`, `program`, `yearLevel`) VALUES
('21-UR-0245', 'Monica', 'Ave', 'mave_21u0245@psu.edu.ph', 'cb28e00ef51374b841fb5c189b2b91c9', 'Urdaneta', 'BS Information Technology', '3rd Year');

-- --------------------------------------------------------

--
-- Table structure for table `student_reports`
--

CREATE TABLE `student_reports` (
  `reportID` int(11) NOT NULL,
  `studentEmail` varchar(255) NOT NULL,
  `reportAbout` varchar(255) NOT NULL,
  `reportDescription` text DEFAULT NULL,
  `location` varchar(255) NOT NULL,
  `pic_path` varchar(255) NOT NULL,
  `reportDate` datetime NOT NULL,
  `postAnonymous` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `coordinators`
--
ALTER TABLE `coordinators`
  ADD PRIMARY KEY (`coorID`);

--
-- Indexes for table `report_comments`
--
ALTER TABLE `report_comments`
  ADD PRIMARY KEY (`commentID`),
  ADD KEY `forKey1` (`commenterEmail`),
  ADD KEY `forKey2` (`reportID`);

--
-- Indexes for table `student_registration`
--
ALTER TABLE `student_registration`
  ADD PRIMARY KEY (`studentEmail`);

--
-- Indexes for table `student_reports`
--
ALTER TABLE `student_reports`
  ADD PRIMARY KEY (`reportID`),
  ADD KEY `fk1` (`studentEmail`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `report_comments`
--
ALTER TABLE `report_comments`
  MODIFY `commentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `student_reports`
--
ALTER TABLE `student_reports`
  MODIFY `reportID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `report_comments`
--
ALTER TABLE `report_comments`
  ADD CONSTRAINT `forKey1` FOREIGN KEY (`commenterEmail`) REFERENCES `student_registration` (`studentEmail`),
  ADD CONSTRAINT `forKey2` FOREIGN KEY (`reportID`) REFERENCES `student_reports` (`reportID`);

--
-- Constraints for table `student_reports`
--
ALTER TABLE `student_reports`
  ADD CONSTRAINT `fk1` FOREIGN KEY (`studentEmail`) REFERENCES `student_registration` (`studentEmail`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
