-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Mar 06, 2023 at 06:29 AM
-- Server version: 5.7.39
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ratchet`
--

-- --------------------------------------------------------

--
-- Table structure for table `PersonalChat`
--

CREATE TABLE `PersonalChat` (
  `ChatId` int(11) NOT NULL,
  `FromUser` int(11) NOT NULL,
  `ToUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `PersonalChat`
--

INSERT INTO `PersonalChat` (`ChatId`, `FromUser`, `ToUser`) VALUES
(1, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `PersonalChatRecord`
--

CREATE TABLE `PersonalChatRecord` (
  `Connection` int(11) NOT NULL,
  `SentBy` varchar(30) NOT NULL,
  `Message` varchar(255) NOT NULL,
  `Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `PersonalChatRecord`
--

INSERT INTO `PersonalChatRecord` (`Connection`, `SentBy`, `Message`, `Date`) VALUES
(1, 'John Smith', 'hi', '2023-03-06 06:09:30'),
(1, 'Jane Doe', 'hi', '2023-03-06 06:10:14'),
(1, 'John Smith', 'hi', '2023-03-06 06:10:44'),
(1, 'Jane Doe', 'hi', '2023-03-06 06:12:08'),
(1, 'Jane Doe', 'sn', '2023-03-06 06:13:02'),
(1, 'John Smith', 'dhd', '2023-03-06 06:13:41');

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `UserId` int(11) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Username` varchar(30) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`UserId`, `Name`, `Username`, `Password`) VALUES
(1, 'John Smith', 'john', '1234'),
(2, 'Jane Doe', 'jane', '1234'),
(3, 'Sam Smith', 'sam', '1234');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `PersonalChat`
--
ALTER TABLE `PersonalChat`
  ADD PRIMARY KEY (`ChatId`),
  ADD KEY `FromUser` (`FromUser`),
  ADD KEY `ToUser` (`ToUser`);

--
-- Indexes for table `PersonalChatRecord`
--
ALTER TABLE `PersonalChatRecord`
  ADD PRIMARY KEY (`Connection`,`Date`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`UserId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `PersonalChat`
--
ALTER TABLE `PersonalChat`
  MODIFY `ChatId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `UserId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `PersonalChat`
--
ALTER TABLE `PersonalChat`
  ADD CONSTRAINT `personalchat_ibfk_1` FOREIGN KEY (`FromUser`) REFERENCES `User` (`UserId`),
  ADD CONSTRAINT `personalchat_ibfk_2` FOREIGN KEY (`ToUser`) REFERENCES `User` (`UserId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
