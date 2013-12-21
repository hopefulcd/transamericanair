-- phpMyAdmin SQL Dump
-- version 4.0.4.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Server version: 5.1.70-cll
-- PHP Version: 5.3.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cs416_project`
--
CREATE DATABASE IF NOT EXISTS `cs416_project` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `cs416_project`;

-- --------------------------------------------------------

--
-- Table structure for table `City`
--

CREATE TABLE IF NOT EXISTS `City` (
  `cityid` int(11) NOT NULL AUTO_INCREMENT,
  `title` char(50) NOT NULL,
  `state` char(2) NOT NULL,
  PRIMARY KEY (`cityid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `City`
--

INSERT INTO `City` (`cityid`, `title`, `state`) VALUES
(0, 'Belmont', 'MA'),
(1, 'Charleston', 'NC'),
(2, 'Downer''s Grove', 'IL'),
(3, 'New York', 'NY'),
(4, 'Los Angeles', 'CA'),
(5, 'Chicago', 'IL'),
(6, 'Houston', 'TX'),
(7, 'Phoenix', 'AZ'),
(8, 'Philadelphia', 'PA'),
(9, 'San Antonio', 'TX'),
(10, 'San Diego', 'CA'),
(11, 'Dallas', 'TX'),
(12, 'San Jose', 'CA'),
(13, 'Detroit', 'MI'),
(14, 'San Francisco', 'CA'),
(15, 'Jacksonville', 'FL'),
(16, 'Indianapolis', 'IN'),
(17, 'Austin', 'TX'),
(18, 'Columbus', 'OH'),
(19, 'Fort Worth', 'TX'),
(20, 'Charlotte', 'NC'),
(21, 'Memphis', 'TN'),
(22, 'Boston', 'MA'),
(23, 'Baltimore', 'MD'),
(24, 'El Paso', 'TX'),
(25, 'Seattle', 'WA'),
(26, 'Denver', 'CO'),
(27, 'Nashville', 'TN'),
(28, 'Milwaukee', 'WI'),
(29, 'Washington', 'DC'),
(30, 'Las Vegas', 'NV'),
(31, 'Louisville', 'KY'),
(32, 'Portland', 'OR');

-- --------------------------------------------------------

--
-- Table structure for table `Customer`
--

CREATE TABLE IF NOT EXISTS `Customer` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `cfirstname` text NOT NULL,
  `clastname` text NOT NULL,
  `email` char(40) NOT NULL,
  `address` char(200) DEFAULT NULL,
  `city` text NOT NULL,
  `state` text NOT NULL,
  `zip` text NOT NULL,
  `phone` text NOT NULL,
  `password` char(16) NOT NULL,
  PRIMARY KEY (`cid`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `Customer`
--

INSERT INTO `Customer` (`cid`, `cfirstname`, `clastname`, `email`, `address`, `city`, `state`, `zip`, `phone`, `password`) VALUES
(1, 'John', 'Sanders', 'johnsanders123@fakeemail.com', '123 Fake St -- Hammond, IN -- 46323', '', '', '', '', '1fakepassword'),
(3, 'Bethany', 'Greer', 'bethany@nope.com', '8923 Jokers Ave', '', '', '', '', 'nope'),
(4, 'Charlie', 'Dyke', 'hopefulcd@sbcglobal.net', '3912 Wirth Rd', 'Highland', 'IN', '46322', '2196782588', 'nope'),
(5, 'Hello', 'World', 'hi@newsite.com', '123 New St. Hopeland, FL 30212', '', '', '', '', 'nope'),
(6, 'John', 'Doe', 'johndoe@somewebsite.com', '123 New St. Hopeland, FL 30212', '', '', '', '', 'hope'),
(11, 'Bob', 'Dole', 'hopefulcd@gmail.com', '123 Never Ave', 'Summers', 'Iowa', '23541', '1234567811', 'sure');

-- --------------------------------------------------------

--
-- Table structure for table `Flight`
--

CREATE TABLE IF NOT EXISTS `Flight` (
  `fid` int(11) NOT NULL AUTO_INCREMENT,
  `fnumber` int(11) DEFAULT NULL,
  `fdate` date NOT NULL,
  `ftime` time NOT NULL,
  `price` double NOT NULL,
  `class` int(11) NOT NULL,
  `capacity` int(11) NOT NULL,
  `available` int(11) NOT NULL,
  `orig` int(11) NOT NULL,
  `dest` int(11) NOT NULL,
  PRIMARY KEY (`fid`),
  KEY `orig` (`orig`),
  KEY `dest` (`dest`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `Flight`
--

INSERT INTO `Flight` (`fid`, `fnumber`, `fdate`, `ftime`, `price`, `class`, `capacity`, `available`, `orig`, `dest`) VALUES
(0, 151, '2013-12-21', '21:00:00', 300, 1, 50, 25, 12, 24),
(1, 413, '2013-12-21', '21:00:00', 300, 1, 50, 25, 24, 12),
(2, 32, '2013-12-21', '02:00:00', 500, 1, 50, 6, 7, 18),
(3, 52, '2013-12-28', '02:00:00', 599.79, 1, 50, 3, 18, 7),
(4, 234, '2013-12-28', '04:00:00', 400, 1, 50, 15, 18, 7),
(5, 563, '2013-12-28', '14:00:00', 499.99, 1, 50, 8, 18, 7),
(6, 482, '2013-12-21', '08:00:00', 499.99, 1, 50, 40, 7, 18),
(7, 313, '2013-12-21', '23:00:00', 399.99, 1, 50, 8, 7, 18),
(8, 321, '2013-12-28', '12:00:00', 229.99, 1, 50, 13, 7, 18),
(9, 76, '2013-12-28', '18:00:00', 399.99, 1, 50, 19, 7, 18),
(10, 238, '2013-12-28', '11:00:00', 199.99, 1, 50, 5, 7, 18),
(11, 631, '2013-12-28', '14:00:00', 269.99, 1, 50, 21, 7, 18);

-- --------------------------------------------------------

--
-- Table structure for table `Reservation`
--

CREATE TABLE IF NOT EXISTS `Reservation` (
  `ordernum` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL,
  `dfid` int(11) NOT NULL,
  `rfid` int(11) DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `cardnum` char(16) NOT NULL,
  `cardmonth` int(11) NOT NULL,
  `cardyear` int(11) NOT NULL,
  `order_date` date DEFAULT NULL,
  PRIMARY KEY (`ordernum`),
  KEY `cid` (`cid`),
  KEY `dfid` (`dfid`),
  KEY `rfid` (`rfid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=62 ;

--
-- Dumping data for table `Reservation`
--

INSERT INTO `Reservation` (`ordernum`, `cid`, `dfid`, `rfid`, `qty`, `cardnum`, `cardmonth`, `cardyear`, `order_date`) VALUES
(28, 6, 4, 8, 7, '2343243284923874', 4, 2012, '2010-12-16'),
(52, 4, 2, 4, 3, '1212121212121334', 5, 2014, '2013-09-03'),
(58, 4, 6, 4, 1, '1212121212121334', 9, 2015, '2013-09-03'),
(55, 4, 6, 4, 1, '1212121212121334', 4, 2017, '2013-09-03'),
(59, 11, 6, 4, 1, '1212121212121334', 4, 2015, '2013-09-03'),
(60, 4, 6, 4, 3, '1234565434567898', 2, 2016, '2013-09-04'),
(57, 4, 6, 4, 1, '1212121212121334', 9, 2015, '2013-09-03'),
(56, 4, 6, 4, 1, '1212121212121334', 9, 2015, '2013-09-03'),
(61, 4, 6, 3, 2, '1234565434567898', 4, 2014, '2013-09-04');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
