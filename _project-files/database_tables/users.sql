-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2015 at 05:34 AM
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
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `birthdate`, `team_id`, `username`, `password`) VALUES
(1, 'Ken', 'Nigga', '2015-07-10 03:06:00', 5, 'myuser', 'pass123'),
(2, 'wew', 'asd', '2015-08-08 00:00:00', 6, '', '0'),
(3, 'asdas', 'wew', '2015-07-25 12:00:00', 4, '', '0'),
(70, 'zxcsda', 'wewe', '2015-07-21 12:00:00', 1, '', ''),
(72, 'wa', 'we', '2015-07-10 00:00:00', 4, '', ''),
(74, 'qqqq', 'aaaaa', '2015-07-03 00:00:00', 3, '', ''),
(75, 'Edge', 'Edge', '2015-07-15 12:00:00', 6, '', ''),
(76, 'bbbb', 'eeeee', '2015-07-04 00:00:00', 4, '', ''),
(79, 'Edge', 'Coronado', '2015-07-22 01:04:34', 3, '', ''),
(80, 'lll', 'iii', '2015-07-04 03:56:08', 3, '', ''),
(81, 'Julius 1', 'Domingo 1', '2015-07-30 04:33:43', 4, '', ''),
(82, 'Kenshin', 'Hinigga', '2015-07-25 03:06:00', 3, '', '');

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
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=83;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
