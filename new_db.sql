-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 01, 2020 at 01:33 AM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `new_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

CREATE TABLE `banks` (
  `bk_id` int(10) NOT NULL,
  `bank_name` varchar(150) NOT NULL,
  `account_number` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `banks`
--

INSERT INTO `banks` (`bk_id`, `bank_name`, `account_number`) VALUES
(1, 'Zenith bank', '2102910981'),
(2, 'First bank', '3278928712'),
(3, 'Union bank', '0012342767');

-- --------------------------------------------------------

--
-- Table structure for table `cash_inflow`
--

CREATE TABLE `cash_inflow` (
  `inflow_id` int(10) NOT NULL,
  `inflow_date` date NOT NULL,
  `income_type_id` int(10) NOT NULL,
  `document_ref` text NOT NULL,
  `receiving_bank` int(10) NOT NULL,
  `account_number` varchar(20) NOT NULL,
  `income_source` varchar(255) NOT NULL,
  `amount` int(30) NOT NULL,
  `currency` int(10) NOT NULL,
  `costcentre_id` int(10) NOT NULL,
  `inv_ref` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cash_inflow`
--

INSERT INTO `cash_inflow` (`inflow_id`, `inflow_date`, `income_type_id`, `document_ref`, `receiving_bank`, `account_number`, `income_source`, `amount`, `currency`, `costcentre_id`, `inv_ref`) VALUES
(12, '2020-07-18', 3, '', 0, '0', '3', 1000, 1, 0, 9977),
(13, '2020-07-18', 3, '', 0, '0', '3', 1000, 1, 0, 9977),
(14, '2020-07-25', 3, '', 0, '0', '3', 1000, 2, 0, 9977),
(15, '2020-07-25', 3, '', 0, '0', '3', 1000, 2, 0, 9977),
(16, '2020-07-25', 3, '', 0, '0', '3', 1000, 2, 0, 9977),
(17, '2020-07-12', 3, '', 0, '0', '3', 1000, 2, 0, 9977),
(18, '2020-07-12', 3, '', 0, '0', '3', 1000, 2, 0, 9977),
(19, '2020-07-12', 3, '', 0, '0', '3', 1000, 2, 0, 9977),
(20, '0000-00-00', 3, '', 0, '0', '3', 1000, 2, 0, 9977),
(21, '0000-00-00', 3, '', 0, '0', '3', 1000, 2, 0, 9977),
(22, '0000-00-00', 3, '', 0, '0', '3', 1000, 2, 0, 9977),
(23, '2020-07-18', 3, '', 0, '0', '3', 1000, 2, 0, 9977),
(24, '2020-07-18', 3, '', 0, '0', '3', 1000, 2, 0, 9977),
(25, '2020-07-18', 3, '', 0, '0', '3', 1000, 2, 0, 9977),
(26, '0000-00-00', 3, '', 0, '0', '3', 1100, 0, 0, 8823),
(27, '0000-00-00', 3, '', 0, '0', '3', 1100, 0, 0, 18),
(28, '2020-07-12', 3, '', 0, '0', '3', 1000, 2, 0, 18),
(29, '2020-07-12', 3, '', 0, '0', '3', 1000, 2, 0, 18),
(30, '2020-07-08', 3, '', 0, '0', '3', 1100, 2, 0, 9977),
(31, '2020-07-12', 3, '', 0, '0', '3', 600, 2, 0, 9977),
(32, '2020-07-12', 3, '', 0, '0', '3', 400, 2, 0, 9977),
(33, '2020-07-26', 3, '', 0, '0', 'Capital oil', 1000, 2, 0, 18),
(34, '2020-07-24', 3, '', 0, '0', 'Capital oil', 500, 2, 0, 9977),
(35, '2020-07-24', 3, '', 0, '0', 'Capital oil', 1500, 2, 0, 9977),
(36, '2020-07-24', 3, '', 0, '0', 'Capital oil', 1000, 2, 0, 9977),
(37, '2020-07-18', 3, '', 0, '0', 'Capital oil', 1000, 2, 0, 18),
(38, '2020-07-25', 3, '', 0, '0', 'Capital oil', 1000, 2, 0, 8823),
(39, '2020-07-19', 3, '', 0, '0', 'Capital oil', 156, 2, 0, 8823),
(40, '2020-07-31', 3, '', 0, '0', 'Capital oil', 500, 2, 0, 9977),
(41, '2020-07-31', 3, '', 0, '0', 'Capital oil', 500, 2, 0, 9977),
(42, '2020-07-25', 3, '', 0, '0', 'Capital oil', 500, 2, 0, 9977),
(43, '2020-07-25', 3, '', 0, '0', 'Capital oil', 500, 2, 0, 9977),
(44, '2020-07-25', 3, '', 0, '0', 'Capital oil', 500, 2, 0, 9977),
(45, '2020-07-25', 3, '', 0, '0', 'Capital oil', 500, 2, 0, 9977),
(46, '2020-07-30', 3, 'google.com', 1, '0', 'Capital oil', 121, 2, 0, 9977),
(47, '2020-07-30', 3, 'google.com', 1, '0', 'Capital oil', 500, 2, 0, 9977),
(48, '2020-07-30', 3, 'google.com', 1, '0', 'Capital oil', 500, 2, 0, 9977),
(49, '2020-07-30', 3, 'google.com', 1, '0', 'Capital oil', 100, 2, 0, 18),
(50, '2020-07-31', 3, 'link.jtg', 1, '0', 'Capital oil', 50, 2, 0, 18),
(51, '2020-07-24', 1, 'google.com', 2, '0', 'federal government', 43250, 2, 1, 0),
(52, '2020-07-24', 3, 'google.com', 2, '0', 'Capital oil', 500, 2, 0, 9977),
(53, '2020-07-24', 4, 'abcd.xyz', 1, '0', 'Bank of Agriculture', 1000, 2, 1, 0),
(54, '2020-07-26', 6, 'asdg.lkj', 1, '0', 'Mr. Akano', 1000, 2, 0, 0),
(55, '2020-07-25', 1, 'google.com', 1, '0', 'federal government', 1000, 2, 1, 0),
(56, '2020-07-18', 3, 'nbhn.lkj', 1, '2102910982', 'Capital oil', 100, 1, 0, 8823),
(57, '2020-07-23', 1, 'nbhbnj.lmk', 1, '2102910982', 'State government', 200, 2, 1, 0),
(58, '2020-07-26', 4, 'nhndjd.lmn', 2, '3278928712', 'Bank of Industry', 750, 2, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `income_types`
--

CREATE TABLE `income_types` (
  `income_type_id` int(10) NOT NULL,
  `income_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `income_types`
--

INSERT INTO `income_types` (`income_type_id`, `income_type`) VALUES
(1, 'Grants'),
(3, 'Services'),
(4, 'Loan'),
(6, 'Others');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`bk_id`);

--
-- Indexes for table `cash_inflow`
--
ALTER TABLE `cash_inflow`
  ADD PRIMARY KEY (`inflow_id`);

--
-- Indexes for table `income_types`
--
ALTER TABLE `income_types`
  ADD PRIMARY KEY (`income_type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `bk_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cash_inflow`
--
ALTER TABLE `cash_inflow`
  MODIFY `inflow_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `income_types`
--
ALTER TABLE `income_types`
  MODIFY `income_type_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
