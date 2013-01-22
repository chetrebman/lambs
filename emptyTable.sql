-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 22, 2013 at 02:49 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `lambs`
--

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE IF NOT EXISTS `course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Course_Code` text NOT NULL,
  `Instructor_Id` int(11) NOT NULL,
  `Name` text NOT NULL,
  `Homework` int(11) NOT NULL,
  `Quizzes` int(11) NOT NULL,
  `Tests` int(11) NOT NULL,
  `Extra_Credit` int(11) NOT NULL,
  `Classes` int(11) NOT NULL,
  `Written_Final` int(11) NOT NULL DEFAULT '0',
  `Practicum_Final` int(11) NOT NULL DEFAULT '0',
  `Projects` int(11) NOT NULL,
  `Total_Points` int(11) NOT NULL DEFAULT '1000',
  `Total_Hours` int(11) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `Course_Code`, `Instructor_Id`, `Name`, `Homework`, `Quizzes`, `Tests`, `Extra_Credit`, `Classes`, `Written_Final`, `Practicum_Final`, `Projects`, `Total_Points`, `Total_Hours`) VALUES
(1, 'AM', 2, 'American Massage', 1, 2, 3, 4, 5, 0, 1, 8, 1000, 80),
(2, 'AP', 2, 'Anatomy', 0, 0, 0, 0, 0, 0, 0, 0, 1000, 200),
(9, 'BM', 5, '', 5, 6, 7, 8, 9, 1, 1, 1, 1000, 50),
(10, 'FA', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 1000, 10),
(11, 'SM', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 1000, 60),
(12, 'PL', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 1000, 30),
(13, 'PA', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 1000, 50),
(14, 'MK', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 1000, 35),
(15, 'MR', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 1000, 30),
(16, 'TM', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 1000, 75);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
