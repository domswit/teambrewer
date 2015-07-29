-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 29, 2015 at 04:52 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mydb`
--

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `project_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  PRIMARY KEY (`project_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`project_id`, `name`) VALUES
(11, 'ABG DDM'),
(12, 'ABG EMEA UK'),
(13, 'ABG EMEA EXTEND');

-- --------------------------------------------------------

--
-- Table structure for table `sched`
--

CREATE TABLE IF NOT EXISTS `sched` (
  `sched_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(30) NOT NULL,
  `project_id` int(3) NOT NULL,
  `fromdate` datetime NOT NULL,
  `todate` datetime NOT NULL,
  `allocation` int(3) NOT NULL,
  PRIMARY KEY (`sched_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `sched`
--

INSERT INTO `sched` (`sched_id`, `user_id`, `project_id`, `fromdate`, `todate`, `allocation`) VALUES
(19, 92, 11, '2015-06-06 01:45:39', '2015-09-16 01:45:43', 40),
(20, 92, 11, '2015-06-04 01:45:39', '2015-09-25 01:45:43', 20),
(21, 92, 11, '2015-06-09 01:45:39', '2015-09-07 01:45:43', 30),
(22, 92, 11, '2015-06-06 01:45:39', '2015-10-05 01:45:43', 40),
(23, 93, 11, '2015-06-10 01:45:39', '2015-10-14 01:45:43', 30),
(24, 93, 12, '2015-06-15 01:45:39', '2015-11-10 01:45:43', 40),
(25, 93, 12, '2015-07-16 01:45:39', '2015-12-08 01:45:43', 40),
(26, 93, 11, '2015-07-01 01:45:39', '2015-08-25 01:45:43', 70),
(27, 94, 13, '2015-06-22 09:03:09', '2015-09-17 09:03:13', 10),
(28, 94, 13, '2015-07-13 09:03:09', '2016-07-14 09:03:13', 30),
(29, 94, 13, '2015-06-21 09:03:09', '2015-12-04 09:03:13', 60);

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE IF NOT EXISTS `teams` (
  `team_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`team_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`team_id`, `name`) VALUES
(1, 'Java'),
(2, 'Developer'),
(3, 'PHP'),
(4, 'Management');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(50) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `birthdate` datetime NOT NULL,
  `team_id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL,
  `access_token` varchar(50) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=95 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `fullname`, `first_name`, `last_name`, `birthdate`, `team_id`, `username`, `password`, `access_token`) VALUES
(92, 'Edge Coronado', 'Edge', 'Coronado', '1994-10-01 01:23:13', 2, 'tempusername', '4f5f3c2adbcc8752f1e2e4b81ea188c4', 'f989e70a97f3870d1e1f92ce7d0ff0fc'),
(93, 'Keneth Batac', 'Keneth', 'Batac', '1994-12-21 01:23:13', 2, 'tempusername', '4f5f3c2adbcc8752f1e2e4b81ea188c4', '912da4cbbc0e1d9d016f873878ac70aa'),
(94, 'Aron Santos', 'Aron', 'Santos', '1995-07-24 09:02:26', 2, 'tempusername', '4f5f3c2adbcc8752f1e2e4b81ea188c4', '086ab3e9a597e29bf0a04fdb99234cad');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
