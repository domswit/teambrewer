-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2015 at 02:20 AM
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
-- Table structure for table `sched`
--

CREATE TABLE IF NOT EXISTS `sched` (
  `sched_id` int(11) NOT NULL,
  `user_id` int(30) NOT NULL,
  `fromdate` datetime NOT NULL,
  `todate` datetime NOT NULL,
  `allocation` int(3) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sched`
--

INSERT INTO `sched` (`sched_id`, `user_id`, `fromdate`, `todate`, `allocation`) VALUES
(2, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 90),
(3, 3, '0015-06-20 00:00:00', '0015-06-20 00:00:00', 100),
(4, 2, '2015-06-30 00:00:00', '0015-06-11 00:00:00', 50),
(5, 0, '2015-07-02 00:00:00', '2015-07-09 00:00:00', 6),
(6, 0, '2015-07-01 00:00:00', '0015-06-12 00:00:00', 3),
(7, 0, '2015-07-06 00:00:00', '2015-07-23 00:00:00', 50),
(8, 0, '2015-07-09 00:00:00', '2015-07-22 00:00:00', 100),
(9, 0, '2015-07-09 00:00:00', '2015-07-22 00:00:00', 100),
(10, 79, '2015-07-20 12:00:00', '2015-07-15 12:00:00', 40),
(11, 0, '2015-07-03 00:00:00', '2015-07-18 00:00:00', 10),
(12, 0, '2015-07-04 00:00:00', '2015-07-11 00:00:00', 90),
(13, 0, '2015-07-04 00:00:00', '2015-07-11 00:00:00', 90),
(14, 1, '2015-07-15 00:00:00', '0015-06-08 00:00:00', 100),
(15, 1, '2015-06-06 03:35:09', '2015-06-06 03:35:12', 100),
(16, 2, '2015-08-06 04:44:49', '2015-07-07 04:44:51', 90);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sched`
--
ALTER TABLE `sched`
  ADD PRIMARY KEY (`sched_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sched`
--
ALTER TABLE `sched`
  MODIFY `sched_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
