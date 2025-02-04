-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 30, 2022 at 05:56 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rudiment_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `mname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `cid` int(11) NOT NULL,
  `admissiondate` date NOT NULL,
  `aadhar` varchar(16) NOT NULL,
  `contact1` varchar(15) NOT NULL,
  `contact2` varchar(15) NOT NULL,
  `tuitionfee` int(11) NOT NULL,
  `book` int(11) NOT NULL,
  `dress` int(11) NOT NULL,
  `father` text NOT NULL,
  `mother` text NOT NULL,
  `temp_address` text NOT NULL,
  `remarks` text NOT NULL,
  `dt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `fname`, `mname`, `lname`, `dob`, `cid`, `admissiondate`, `aadhar`, `contact1`, `contact2`, `tuitionfee`, `book`, `dress`, `father`, `mother`, `temp_address`, `remarks`, `dt`) VALUES
(21, 'Trisha ', 'Shankar', 'Pandit', '2017-12-31', 4, '2022-10-12', '12234479672', '18787877', '18787877', 788668, 1561, 16155, 'jkjkjk', 'kjbjkb', 'kjbkjb', 'kjbkj', '2022-10-29 14:27:16'),
(22, 'Rakhi', 'Pramod', 'Kumari', '2015-06-09', 5, '2022-10-29', '', '98726525', '', 32500, 1890, 2350, 'Father is a security Guard', 'Housewife ', 'Bharne Basti', 'ihzgyuaxgyuaxg', '2022-10-29 14:29:04'),
(23, 'Avni', 'Pramod', 'Parkhi', '2019-01-01', 3, '2022-10-20', '', '9178176786', '', 32500, 2222, 1111, 'Jkjskjb', 'bjbjhbj', 'jhbjhbj', 'lnkhk', '2022-10-29 14:34:17'),
(25, 'Aryan', '', 'Pote', '2019-01-01', 1, '2022-10-29', '', '9155950740', '', 32000, 1890, 2355, 'Papa chjant hai ', 'jkjkb', 'bkibkjb', 'jhbjbjkhb', '2022-10-29 21:12:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
