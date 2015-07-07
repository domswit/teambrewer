-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 03, 2015 at 07:08 AM
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
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `birthdate` datetime NOT NULL,
  `team_id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(12) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `birthdate`, `team_id`, `username`, `password`) VALUES
(1, 'Edge', 'asdzxc', '2015-06-24 00:00:00', 0, 'myuser', 'pass123'),
(2, 'Ken', 'Nigga', '2015-06-03 00:00:00', 0, '', '0'),
(3, 'Oll', 'Ske', '2015-06-25 00:00:00', 0, '', '0'),
(66, 'Edge', 'Coronado', '1994-01-10 00:00:00', 0, '', ''),
(67, 'ju', 'ji', '0000-00-00 00:00:00', 0, '', ''),
(68, 'Jull', 'Munn', '0000-00-00 00:00:00', 0, '', ''),
(69, '', '', '0000-00-00 00:00:00', 0, '', ''),
(70, 'zxcsda', 'wewe', '0000-00-00 00:00:00', 0, '', ''),
(71, 'asda', 'sdasd', '2222-11-23 00:00:00', 2, '', ''),
(72, 'wa', 'we', '2015-07-10 05:00:57', 4, '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=73;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
