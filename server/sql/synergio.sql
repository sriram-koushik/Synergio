-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 06, 2015 at 02:44 AM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `synergio`
--

-- --------------------------------------------------------

--
-- Table structure for table `configdetails`
--

CREATE TABLE IF NOT EXISTS `configdetails` (
`ID` int(20) NOT NULL,
  `edirectoryIP` varchar(15) NOT NULL,
  `Username` varchar(75) NOT NULL,
  `Password` varchar(75) NOT NULL,
  `mail` varchar(25) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `configdetails`
--

INSERT INTO `configdetails` (`ID`, `edirectoryIP`, `Username`, `Password`, `mail`) VALUES
(1, '164.99.178.46', 'cn=hf1, ou=users, o=data', 'novell', 'hf1@novell.com');

-- --------------------------------------------------------

--
-- Table structure for table `monitoring_project_messages`
--

CREATE TABLE IF NOT EXISTS `monitoring_project_messages` (
`id` int(20) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `username` varchar(75) NOT NULL,
  `message` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `projectmembership`
--

CREATE TABLE IF NOT EXISTS `projectmembership` (
`MemberID` int(20) NOT NULL,
  `PName` varchar(50) NOT NULL,
  `UserDN` varchar(75) NOT NULL,
  `Role` varchar(25) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `projectmembership`
--

INSERT INTO `projectmembership` (`MemberID`, `PName`, `UserDN`, `Role`) VALUES
(1, 'Synergio', 'hf1', 'owner'),
(2, 'Monitoring', 'hf1', 'owner'),
(6, 'Synergio', 'hf2', 'member');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `PName` varchar(50) NOT NULL,
  `projectStatus` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`PName`, `projectStatus`) VALUES
('Monitoring', 'Active'),
('Synergio', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `synergio_project_messages`
--

CREATE TABLE IF NOT EXISTS `synergio_project_messages` (
`id` int(20) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `username` varchar(75) NOT NULL,
  `message` varchar(2000) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=82 ;

--
-- Dumping data for table `synergio_project_messages`
--

INSERT INTO `synergio_project_messages` (`id`, `timestamp`, `username`, `message`) VALUES
(3, '2015-07-03 21:04:00', 'hf1', 'weew'),
(4, '2015-07-03 21:06:25', 'hf1', 'fdgfdg'),
(5, '2015-07-03 21:06:34', 'hf1', 'fdgfdg'),
(6, '2015-07-03 21:06:34', 'hf1', 'fdgfdg'),
(7, '2015-07-03 21:06:35', 'hf1', 'fdgfdg'),
(8, '2015-07-03 21:06:35', 'hf1', 'fdgfdg'),
(9, '2015-07-03 21:06:35', 'hf1', 'fdgfdg'),
(10, '2015-07-03 21:25:58', 'hf1', 'asdsadsad'),
(11, '2015-07-03 21:32:56', 'hf1', 'asdsadsad'),
(12, '2015-07-03 21:32:57', 'hf1', 'asdsadsad'),
(13, '2015-07-03 21:32:57', 'hf1', 'asdsadsad'),
(14, '2015-07-03 21:32:57', 'hf1', 'asdsadsad'),
(15, '2015-07-03 21:38:50', 'hf1', 'asdsadsad'),
(16, '2015-07-03 21:38:50', 'hf1', 'asdsadsad'),
(17, '2015-07-03 21:38:50', 'hf1', 'asdsadsad'),
(18, '2015-07-03 21:38:50', 'hf1', 'asdsadsad'),
(19, '2015-07-03 21:38:50', 'hf1', 'asdsadsad'),
(20, '2015-07-03 21:38:50', 'hf1', 'asdsadsad'),
(21, '2015-07-03 21:38:50', 'hf1', 'asdsadsad'),
(22, '2015-07-03 21:38:51', 'hf1', 'asdsadsad'),
(23, '2015-07-03 21:38:51', 'hf1', 'asdsadsad'),
(24, '2015-07-03 21:38:54', 'hf1', 'asdsadsad'),
(25, '2015-07-03 21:39:02', 'hf1', 'asdsadsad'),
(26, '2015-07-03 22:26:23', 'hf1', 'sadsd'),
(27, '2015-07-03 22:26:25', 'hf1', 'sadsd'),
(28, '2015-07-03 22:30:24', 'hf1', 'asdsad'),
(29, '2015-07-03 22:30:25', 'hf1', 'asdsad'),
(30, '2015-07-03 22:30:25', 'hf1', 'asdsad'),
(31, '2015-07-03 22:31:18', 'hf1', 'sdad'),
(32, '2015-07-03 22:31:19', 'hf1', 'sdad'),
(33, '2015-07-03 22:31:19', 'hf1', 'sdad'),
(34, '2015-07-03 23:07:04', 'hf1', 'xasas'),
(35, '2015-07-03 23:07:40', 'hf1', 'xasasxz'),
(36, '2015-07-03 23:07:40', 'hf1', 'xasasxz'),
(37, '2015-07-03 23:07:41', 'hf1', 'xasasxz'),
(38, '2015-07-03 23:07:42', 'hf1', 'xasasxz'),
(39, '2015-07-03 23:11:02', 'hf1', 'sadasdsadsad'),
(40, '2015-07-03 23:34:55', 'hf1', 'zdfs'),
(41, '2015-07-03 23:34:56', 'hf1', 'zdfs'),
(42, '2015-07-03 23:34:56', 'hf1', 'zdfs'),
(43, '2015-07-03 23:34:56', 'hf1', 'zdfs'),
(44, '2015-07-04 00:53:53', 'hf1', 'sdfsdf'),
(45, '2015-07-04 00:54:51', 'hf1', 'sdfsdf'),
(46, '2015-07-04 01:00:46', 'hf2', 'from hf2'),
(47, '2015-07-04 01:01:40', 'hf1', 'from hf1'),
(48, '2015-07-04 03:59:43', 'hf1', 'hi'),
(49, '2015-07-04 04:00:03', 'hf1', 'hi'),
(50, '2015-07-04 04:00:23', 'hf1', 'vicky'),
(51, '2015-07-04 04:00:53', 'hf1', 'Rock'),
(52, '2015-07-04 04:01:06', 'hf1', 'this is sample'),
(53, '2015-07-04 04:01:36', 'hf1', 'this is sample'),
(54, '2015-07-04 04:04:19', 'hf1', 'gud mor'),
(55, '2015-07-04 04:04:33', 'hf1', 'gud mor'),
(56, '2015-07-04 04:10:30', 'hf1', 'new one'),
(57, '2015-07-04 04:21:52', 'hf1', 'new one'),
(58, '2015-07-04 04:22:38', 'hf1', 'hi'),
(59, '2015-07-04 04:28:12', 'hf1', 'hi'),
(60, '2015-07-04 04:28:57', 'hf1', 'bye'),
(61, '2015-07-04 04:29:47', 'hf1', 'bye'),
(62, '2015-07-04 04:31:11', 'hf1', 'Hi'),
(63, '2015-07-04 04:35:38', 'hf1', 'hi'),
(64, '2015-07-04 04:35:55', 'hf1', 'sai'),
(65, '2015-07-04 04:37:19', 'hf1', 'sai'),
(66, '2015-07-04 04:45:23', 'hf1', 'hai'),
(67, '2015-07-04 04:45:38', 'hf1', 'haijbk'),
(68, '2015-07-04 04:46:45', 'hf1', 'hi'),
(69, '2015-07-04 04:46:53', 'hf1', 'hi'),
(70, '2015-07-04 04:49:49', 'hf1', 'hi'),
(71, '2015-07-04 04:58:33', 'hf1', 'hi'),
(72, '2015-07-04 04:58:50', 'hf1', 'bye'),
(73, '2015-07-04 04:59:10', 'hf1', 'bye4'),
(74, '2015-07-04 12:10:14', 'hf1', 'hi'),
(75, '2015-07-04 13:28:36', 'hf1', 'hi'),
(76, '2015-07-04 13:45:08', 'hf1', 'hi'),
(77, '2015-07-04 13:45:18', 'hf1', 'how r u'),
(78, '2015-07-05 09:08:37', 'hf1', 'sadsad'),
(79, '2015-07-05 09:08:49', 'hf1', 'I am great'),
(80, '2015-07-05 16:57:14', 'hf1', 'hi vijay'),
(81, '2015-07-05 17:38:24', 'hf2', 'zxc');

-- --------------------------------------------------------

--
-- Table structure for table `taskdetails`
--

CREATE TABLE IF NOT EXISTS `taskdetails` (
`TID` int(20) NOT NULL,
  `PName` varchar(50) NOT NULL,
  `TaskName` varchar(50) NOT NULL,
  `Description` varchar(200) NOT NULL,
  `Status` varchar(20) NOT NULL,
  `AssignedUser` varchar(75) DEFAULT NULL,
  `Date` date DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `taskdetails`
--

INSERT INTO `taskdetails` (`TID`, `PName`, `TaskName`, `Description`, `Status`, `AssignedUser`, `Date`) VALUES
(5, 'Monitoring', 'second task', 'This is the second important task', 'open', 'hf2', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `UserDN` varchar(75) NOT NULL,
  `SynergIOAttribute` tinyint(1) NOT NULL,
  `mail` varchar(20) NOT NULL,
  `password` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserDN`, `SynergIOAttribute`, `mail`, `password`) VALUES
('hf1', 1, 'hf1@novell.com', 'novell'),
('hf2', 1, 'hf2@novell.com', 'novell');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `configdetails`
--
ALTER TABLE `configdetails`
 ADD PRIMARY KEY (`ID`), ADD UNIQUE KEY `Email` (`mail`), ADD KEY `ID` (`ID`), ADD KEY `ID_2` (`ID`);

--
-- Indexes for table `monitoring_project_messages`
--
ALTER TABLE `monitoring_project_messages`
 ADD PRIMARY KEY (`id`), ADD KEY `username` (`username`);

--
-- Indexes for table `projectmembership`
--
ALTER TABLE `projectmembership`
 ADD PRIMARY KEY (`MemberID`), ADD KEY `PName` (`PName`), ADD KEY `UserDN` (`UserDN`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
 ADD PRIMARY KEY (`PName`);

--
-- Indexes for table `synergio_project_messages`
--
ALTER TABLE `synergio_project_messages`
 ADD PRIMARY KEY (`id`), ADD KEY `username` (`username`);

--
-- Indexes for table `taskdetails`
--
ALTER TABLE `taskdetails`
 ADD PRIMARY KEY (`TID`), ADD KEY `PName` (`PName`), ADD KEY `AssignedUser` (`AssignedUser`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`UserDN`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `configdetails`
--
ALTER TABLE `configdetails`
MODIFY `ID` int(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `monitoring_project_messages`
--
ALTER TABLE `monitoring_project_messages`
MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `projectmembership`
--
ALTER TABLE `projectmembership`
MODIFY `MemberID` int(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `synergio_project_messages`
--
ALTER TABLE `synergio_project_messages`
MODIFY `id` int(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=82;
--
-- AUTO_INCREMENT for table `taskdetails`
--
ALTER TABLE `taskdetails`
MODIFY `TID` int(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `projectmembership`
--
ALTER TABLE `projectmembership`
ADD CONSTRAINT `PNameFK` FOREIGN KEY (`PName`) REFERENCES `projects` (`PName`),
ADD CONSTRAINT `UserDNFK` FOREIGN KEY (`UserDN`) REFERENCES `users` (`UserDN`);

--
-- Constraints for table `synergio_project_messages`
--
ALTER TABLE `synergio_project_messages`
ADD CONSTRAINT `usernameFK` FOREIGN KEY (`username`) REFERENCES `users` (`UserDN`);

--
-- Constraints for table `taskdetails`
--
ALTER TABLE `taskdetails`
ADD CONSTRAINT `ProductNameFK` FOREIGN KEY (`PName`) REFERENCES `projects` (`PName`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
