-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 20, 2015 at 08:45 AM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

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
  `project_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`project_id`, `name`) VALUES
(1, 'xcvxcvxcv'),
(2, 'zxcd'),
(3, 'cvbcvb'),
(4, 'tie'),
(5, 'zxczxc'),
(6, 'tie'),
(7, 'pop'),
(8, 'fff111'),
(9, '23232'),
(10, 'my project 2');

-- --------------------------------------------------------

--
-- Table structure for table `sched`
--

CREATE TABLE IF NOT EXISTS `sched` (
  `sched_id` int(11) NOT NULL,
  `user_id` int(30) NOT NULL,
  `project_id` int(3) NOT NULL,
  `fromdate` datetime NOT NULL,
  `todate` datetime NOT NULL,
  `allocation` int(3) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sched`
--

INSERT INTO `sched` (`sched_id`, `user_id`, `project_id`, `fromdate`, `todate`, `allocation`) VALUES
(3, 2, 2, '2015-06-20 00:00:00', '2015-06-20 00:00:00', 50),
(4, 2, 2, '2015-06-30 00:00:00', '2015-08-30 00:00:00', 50),
(10, 2, 2, '2015-07-20 12:00:00', '2015-07-15 12:00:00', 30),
(14, 2, 2, '2015-07-21 12:00:00', '2015-07-25 12:00:00', 50),
(15, 3, 2, '2015-07-23 03:35:09', '2015-07-28 03:35:12', 100),
(16, 3, 2, '2015-08-06 04:44:49', '2015-07-07 04:44:51', 10),
(17, 3, 2, '2015-07-02 01:11:32', '2015-07-23 01:11:35', 50);

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE IF NOT EXISTS `teams` (
  `team_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`team_id`, `name`) VALUES
(1, 'Java'),
(2, 'Developer'),
(3, 'PHP'),
(4, 'Management'),
(5, 'Bulls'),
(6, 'Warriors'),
(7, 'Spurs'),
(8, 'sad');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `birthdate` datetime NOT NULL,
  `team_id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL,
  `access_token` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `birthdate`, `team_id`, `username`, `password`, `access_token`) VALUES
(2, 'wew', 'asd', '2015-08-08 00:00:00', 2, '', '0', ''),
(3, 'asdas', 'wew', '2015-07-25 12:00:00', 2, '', '0', ''),
(70, 'zxcsda', 'wewe', '2015-07-21 12:00:00', 1, '', '', ''),
(72, 'wa', 'we', '2015-07-10 00:00:00', 4, '', '', ''),
(74, 'qqqq', 'aaaaa', '2015-07-03 00:00:00', 3, '', '', ''),
(75, 'Edge', 'Edge', '2015-07-15 12:00:00', 6, '', '', ''),
(76, 'bbbb', 'eeeee', '2015-07-04 00:00:00', 4, '', '', ''),
(79, 'Edge', 'Coronado', '2015-07-22 01:04:34', 3, '', '', ''),
(80, 'lll', 'iii', '2015-07-04 03:56:08', 3, '', '', ''),
(81, 'Julius 1', 'Domingo 1', '2015-07-30 04:33:43', 4, '', '', ''),
(82, 'Kenshin', 'Hinigga', '2015-07-25 03:06:00', 3, '', '', ''),
(83, 'aa', 'aa', '2015-07-04 08:38:23', 2, '', '', ''),
(84, 'tttttttt', 'qqqqq', '2015-07-03 09:02:00', 3, '', 'temppassword', '84'),
(85, 'edd', 'eeeddd', '2015-07-10 09:10:58', 4, '', 'temppassword', '85'),
(86, 'wew', 'asd', '2015-07-03 09:15:22', 4, '', 'temppassword', '830336821fb3c54a3c2a08ac68a90f0d'),
(87, 'ezxczx', 'ezxczxd', '2015-06-30 09:17:46', 2, 'tempusername', 'temppassword', '3ba768b2178737ce1697a42c8908e955'),
(88, 'zxczxc', 'zxczcxc', '2015-06-13 09:17:46', 2, 'tempusername', '4f5f3c2adbcc', '08194dee04abb8ed7d766d1b0f7ce0b4'),
(89, 'edgeeee', 'asdasd', '2015-06-10 09:17:46', 1, 'tempusername', '4f5f3c2adbcc8752f1e2e4b81ea188c4', '18c971e705ff9b8c5f8d127c08e65d58'),
(90, 'Wewew', 'Dsds', '2015-07-09 01:12:23', 3, 'tempusername', '4f5f3c2adbcc8752f1e2e4b81ea188c4', 'd446249617eb30557c7e7d9a30b1899d'),
(91, 'Kuero', 'Baka', '2015-07-08 01:13:27', 3, 'tempusername', '4f5f3c2adbcc8752f1e2e4b81ea188c4', '3e4a90775873de07db961b9941a863f4');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `sched`
--
ALTER TABLE `sched`
  ADD PRIMARY KEY (`sched_id`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`team_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `sched`
--
ALTER TABLE `sched`
  MODIFY `sched_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `team_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=92;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
