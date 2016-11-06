-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 06, 2016 at 07:10 AM
-- Server version: 5.7.16-0ubuntu0.16.04.1
-- PHP Version: 7.0.12-1+deb.sury.org~xenial+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hostellife`
--

-- --------------------------------------------------------

--
-- Table structure for table `bucketList`
--

CREATE TABLE `bucketList` (
  `bucket_id` int(11) NOT NULL,
  `bucket_name` varchar(200) NOT NULL,
  `userID` int(11) NOT NULL,
  `createDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bucketList`
--

INSERT INTO `bucketList` (`bucket_id`, `bucket_name`, `userID`, `createDate`) VALUES
(13, 'TRAVEL', 1, '2016-11-05 21:00:06'),
(17, 'ADVENTURE', 1, '2016-11-06 00:44:22'),
(18, 'SPORT', 1, '2016-11-06 01:06:29'),
(19, 'CODING', 2, '2016-11-06 01:34:31');

-- --------------------------------------------------------

--
-- Table structure for table `bucketPost`
--

CREATE TABLE `bucketPost` (
  `post_id` int(11) NOT NULL,
  `post_title` varchar(200) NOT NULL,
  `post_description` tinytext NOT NULL,
  `post_image` varchar(100) NOT NULL,
  `bucket_name` varchar(150) NOT NULL,
  `userID` int(11) NOT NULL,
  `post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bucketPost`
--

INSERT INTO `bucketPost` (`post_id`, `post_title`, `post_description`, `post_image`, `bucket_name`, `userID`, `post_date`) VALUES
(1, 'To create a tag chip just add an close icon inside with the class close', 'To create a tag chip just add an close icon inside with the class close', '10896949_739241589505567_84890284170995638_n.jpg', 'TRAVEL', 1, '2016-11-06 00:22:18'),
(2, 'Together we can fulfill each other\'s dreams', '"Someday" isn\'t enough, let\'s prioritize and set some dates. Define HOW MUCH do you want it and WHEN do you want it.\r\n\r\nNot just "Before I die..."', '14570372_593887684117006_8958889741009380299_n.jpg', 'TRAVEL', 1, '2016-11-06 00:25:50'),
(3, 'You have created new bucket!', 'Follow the instructions to embed the icon font in your site and learn how to style your icons using CSS.', 'pic01.jpg', 'TRAVEL', 1, '2016-11-06 00:42:49'),
(4, 'Funnt Sports', 'Add the Tooltipped class to your element and add either top, bottom, left, right on data-tooltip to control the position.', '1.jpg', 'SPORT', 1, '2016-11-06 01:07:32'),
(5, 'Hi! This is my first post on this bucket list application', 'Happy Coding!!', 'Screenshot from 2016-09-28 18-56-46.png', 'CODING', 2, '2016-11-06 01:35:45');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `userID` int(11) NOT NULL,
  `userName` varchar(100) NOT NULL,
  `userEmail` varchar(100) NOT NULL,
  `userPass` varchar(100) NOT NULL,
  `userStatus` enum('Y','N') NOT NULL DEFAULT 'N',
  `tokenCode` varchar(100) NOT NULL,
  `profilePic` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`userID`, `userName`, `userEmail`, `userPass`, `userStatus`, `tokenCode`, `profilePic`) VALUES
(1, 'Sugam Malviya', 'sugam0030@gmail.com', '6c2fdd3c2d6cafebad6675c52e54b8a7', 'Y', '3a26b23480a18994269e7ccd8da3536c', 'male.png'),
(2, 'Subhankar Raj', 'subhankar.rj@gmail.com', '25f9e794323b453885f5181f1b624d0b', 'Y', '8fa425bb05eb807b023adf2b2b7a9ac3', 'male.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bucketList`
--
ALTER TABLE `bucketList`
  ADD PRIMARY KEY (`bucket_id`);

--
-- Indexes for table `bucketPost`
--
ALTER TABLE `bucketPost`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `userEmail` (`userEmail`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bucketList`
--
ALTER TABLE `bucketList`
  MODIFY `bucket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `bucketPost`
--
ALTER TABLE `bucketPost`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
