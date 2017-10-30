-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 04, 2017 at 12:26 PM
-- Server version: 5.7.18-0ubuntu0.16.04.1
-- PHP Version: 5.6.31-1~ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `testchan`
--

-- --------------------------------------------------------

--
-- Table structure for table `Ban`
--

CREATE TABLE `Ban` (
  `id` int(10) UNSIGNED NOT NULL,
  `ip` int(10) UNSIGNED NOT NULL,
  `postId` int(10) UNSIGNED NOT NULL,
  `content` text,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `expire` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Board`
--

CREATE TABLE `Board` (
  `id` int(10) UNSIGNED NOT NULL,
  `ownerHash` char(60) NOT NULL,
  `flags` tinyint(3) UNSIGNED NOT NULL,
  `link` tinytext NOT NULL,
  `name` tinytext NOT NULL,
  `category` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `File`
--

CREATE TABLE `File` (
  `id` int(10) UNSIGNED NOT NULL,
  `postId` int(10) UNSIGNED NOT NULL,
  `name` tinytext,
  `mime` tinytext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Permit`
--

CREATE TABLE `Permit` (
  `userHash` char(60) NOT NULL,
  `boardId` int(10) UNSIGNED NOT NULL,
  `flags` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Post`
--

CREATE TABLE `Post` (
  `id` int(10) UNSIGNED NOT NULL,
  `parentId` int(10) UNSIGNED DEFAULT NULL,
  `ip` int(10) UNSIGNED NOT NULL,
  `flags` tinyint(3) UNSIGNED NOT NULL,
  `name` tinytext,
  `email` tinytext,
  `hash` char(60) DEFAULT NULL,
  `subject` tinytext,
  `content` text,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `boardId` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `hash` char(60) NOT NULL,
  `flags` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Ban`
--
ALTER TABLE `Ban`
  ADD PRIMARY KEY (`id`),
  ADD KEY `postId` (`postId`);

--
-- Indexes for table `Board`
--
ALTER TABLE `Board`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ownerHash` (`ownerHash`);

--
-- Indexes for table `File`
--
ALTER TABLE `File`
  ADD PRIMARY KEY (`id`),
  ADD KEY `postId` (`postId`);

--
-- Indexes for table `Permit`
--
ALTER TABLE `Permit`
  ADD PRIMARY KEY (`userHash`,`boardId`);

--
-- Indexes for table `Post`
--
ALTER TABLE `Post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `boardId` (`boardId`),
  ADD KEY `parentId` (`parentId`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`hash`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Ban`
--
ALTER TABLE `Ban`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Board`
--
ALTER TABLE `Board`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `File`
--
ALTER TABLE `File`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `Post`
--
ALTER TABLE `Post`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `Ban`
--
ALTER TABLE `Ban`
  ADD CONSTRAINT `Ban_ibfk_1` FOREIGN KEY (`postId`) REFERENCES `Post` (`id`);

--
-- Constraints for table `Board`
--
ALTER TABLE `Board`
  ADD CONSTRAINT `Board_ibfk_1` FOREIGN KEY (`ownerHash`) REFERENCES `User` (`hash`);

--
-- Constraints for table `File`
--
ALTER TABLE `File`
  ADD CONSTRAINT `File_ibfk_1` FOREIGN KEY (`postId`) REFERENCES `Post` (`id`);

--
-- Constraints for table `Post`
--
ALTER TABLE `Post`
  ADD CONSTRAINT `Post_ibfk_1` FOREIGN KEY (`boardId`) REFERENCES `Board` (`id`),
  ADD CONSTRAINT `Post_ibfk_2` FOREIGN KEY (`parentId`) REFERENCES `Post` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
