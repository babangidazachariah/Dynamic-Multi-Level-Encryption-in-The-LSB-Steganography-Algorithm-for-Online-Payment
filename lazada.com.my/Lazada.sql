-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 17, 2016 at 06:24 AM
-- Server version: 5.5.50-0+deb8u1
-- PHP Version: 5.6.24-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `Lazada`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblCustomerAccounts`
--

CREATE TABLE IF NOT EXISTS `tblCustomerAccounts` (
`customerID` int(11) NOT NULL,
  `customerRegisteredID` int(11) NOT NULL,
  `customerBank` varchar(30) NOT NULL,
  `customerAccountNumber` varchar(20) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblCustomerAccounts`
--

INSERT INTO `tblCustomerAccounts` (`customerID`, `customerRegisteredID`, `customerBank`, `customerAccountNumber`) VALUES
(1, 0, 'CIMB', '0987654321'),
(2, 0, 'CIMB', '1316134912'),
(3, 0, 'CIMB', '1247781221'),
(12, 0, 'CIMB', '2277408753'),
(11, 0, 'CIMB', '8155958197'),
(10, 0, 'CIMB', '7172641818177107'),
(9, 0, 'CIMB', '2148050380'),
(13, 0, 'CIMB', '4898332485'),
(14, 0, 'CIMB', '9710994755992812'),
(15, 0, 'CIMB', '2316490378'),
(16, 0, 'CIMB', '7617847930'),
(17, 0, 'CIMB', '9545868289');

-- --------------------------------------------------------

--
-- Table structure for table `tblItems`
--

CREATE TABLE IF NOT EXISTS `tblItems` (
`itemID` int(11) NOT NULL,
  `itemCode` varchar(10) NOT NULL,
  `itemName` varchar(60) NOT NULL,
  `itemDescription` varchar(100) NOT NULL,
  `itemPicture` varchar(15) NOT NULL,
  `itemUnitPrice` double NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblItems`
--

INSERT INTO `tblItems` (`itemID`, `itemCode`, `itemName`, `itemDescription`, `itemPicture`, `itemUnitPrice`) VALUES
(1, 'TPUBC99999', 'Samsung TPU Back Cover with Dreamcatcher Painting', 'Soft TPU Case With Clear Edge Side,Fit Smartphone.', 'TPUBC999991.jpg', 18.99),
(2, 'CVCS90773', 'Clear View Cover Case for Samsung Galaxy S7', 'Fashion transparent design makes you can see the screen content display on the cover.', 'CVCS907732.jpg', 43),
(3, 'FWCS96565', 'Flip Wallet Cover Case for Samsung Galaxy S7 ', 'Inside this Galaxy S7 Edge flip cover is a slot for storing a credit or debit card.', 'FWCS965653.jpg', 44),
(4, 'CCST887549', 'Cover Case for Samsung Galaxy Tab4 10.1 SM-T530', 'Provides excellent protection from scratches and bumps.', 'CCST8875494.jpg', 33.6),
(5, 'OSGC978484', 'Original Samsung Galaxy S7 Edge S Cover', 'Provides full-screen protection without additional bulk.', 'OSGC9784845.jpg', 219),
(6, 'IPSC988789', ' iPhone 6 6S Shell Ultra Thin Full Body Cover', 'Ultraprecise split-type design, have Aesthetic and Protect both.', 'IPSC9887896.jpg', 24.6),
(7, 'IPTC898547', ' iPhone 6 / 6S Transparent Ultra Thin Cover', 'Slim formfitting design with full access to all buttons and ports.', 'IPTC8985477.jpg', 10),
(8, 'TPUC90987', 'Crystal TPU Silicone Case Cover For iPhone 5', 'Protect your iPhone 5/5s from damage.', 'TPUC909878.jpg', 12.6),
(9, 'CAIP509987', ' Case for Apple iPhone 5 5S', ' Protection for your phone against shock, finger marks and dust.', 'CAIP509987.jpg', 19.9),
(10, 'TPUG508778', 'Ultra Thin Soft TPU Gel For iPhone 5', 'Fashion design, easy to put on and easy to take off.', 'TPUG508710.jpg', 18.9),
(11, 'MAPC500889', ' Moonmini Case for Apple iPhone 5 5S 5G', 'Absorbs shock for superior protection.', 'MAPC500811.jpg', 19.99);

-- --------------------------------------------------------

--
-- Table structure for table `tblPurchasedItems`
--

CREATE TABLE IF NOT EXISTS `tblPurchasedItems` (
`purchasedItemID` int(11) NOT NULL,
  `transactionID` int(11) NOT NULL,
  `itemCode` varchar(10) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=180 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblPurchasedItems`
--

INSERT INTO `tblPurchasedItems` (`purchasedItemID`, `transactionID`, `itemCode`, `quantity`) VALUES
(28, 12, 'CCST887549', 1),
(27, 11, 'CCST887549', 1),
(26, 11, 'CVCS90773', 1),
(25, 11, 'TPUBC99999', 1),
(24, 10, 'TPUG508778', 3),
(23, 10, 'CVCS90773', 1),
(22, 10, 'TPUBC99999', 2),
(21, 9, 'CVCS90773', 1),
(20, 9, 'TPUBC99999', 1),
(19, 8, 'CVCS90773', 1),
(18, 8, 'TPUBC99999', 1),
(17, 7, 'FWCS96565', 1),
(16, 7, 'CVCS90773', 1),
(15, 7, 'TPUBC99999', 2),
(29, 12, 'IPTC898547', 4),
(30, 13, 'IPTC898547', 4),
(31, 13, 'TPUC90987', 2),
(32, 13, 'CAIP509987', 1),
(33, 14, 'TPUBC99999', 1),
(34, 14, 'FWCS96565', 1),
(35, 14, 'IPSC988789', 1),
(36, 14, 'IPTC898547', 2),
(37, 14, 'TPUC90987', 2),
(38, 15, 'IPTC898547', 4),
(39, 15, 'TPUC90987', 1),
(40, 16, 'IPTC898547', 1),
(41, 16, 'TPUC90987', 1),
(42, 16, 'TPUG508778', 1),
(43, 17, 'IPTC898547', 2),
(44, 17, 'TPUG508778', 1),
(45, 17, 'MAPC500889', 1),
(46, 17, 'CAIP509987', 1),
(47, 18, 'CCST887549', 1),
(48, 18, 'IPSC988789', 1),
(49, 18, 'TPUBC99999', 1),
(50, 18, 'FWCS96565', 1),
(51, 19, 'IPSC988789', 1),
(52, 19, 'OSGC978484', 1),
(53, 19, 'CCST887549', 1),
(54, 20, 'IPTC898547', 3),
(55, 20, 'TPUC90987', 1),
(56, 20, 'TPUG508778', 1),
(57, 21, 'TPUBC99999', 1),
(58, 21, 'CVCS90773', 1),
(59, 21, 'FWCS96565', 1),
(60, 22, 'IPTC898547', 5),
(61, 23, 'MAPC500889', 1),
(62, 24, 'MAPC500889', 1),
(63, 25, 'MAPC500889', 1),
(64, 26, 'TPUBC99999', 1),
(65, 26, 'CVCS90773', 1),
(66, 26, 'FWCS96565', 1),
(67, 26, 'CCST887549', 1),
(68, 27, 'TPUBC99999', 1),
(69, 27, 'CVCS90773', 1),
(70, 27, 'FWCS96565', 1),
(71, 27, 'OSGC978484', 1),
(72, 27, 'CAIP509987', 1),
(73, 28, 'CVCS90773', 1),
(74, 28, 'IPTC898547', 2),
(75, 28, 'MAPC500889', 1),
(76, 29, 'FWCS96565', 1),
(77, 29, 'CVCS90773', 1),
(78, 30, 'CCST887549', 2),
(79, 30, 'TPUG508778', 1),
(80, 30, 'MAPC500889', 1),
(81, 31, 'TPUBC99999', 1),
(82, 31, 'CVCS90773', 1),
(83, 31, 'CCST887549', 1),
(84, 32, 'TPUBC99999', 3),
(85, 32, 'CVCS90773', 1),
(86, 32, 'FWCS96565', 1),
(87, 32, 'TPUC90987', 9),
(88, 33, 'TPUG508778', 4),
(89, 33, 'MAPC500889', 2),
(90, 33, 'IPTC898547', 12),
(91, 33, 'CAIP509987', 2),
(92, 33, 'TPUC90987', 3),
(93, 34, 'TPUBC99999', 1),
(94, 34, 'CVCS90773', 1),
(95, 34, 'FWCS96565', 1),
(96, 34, 'CCST887549', 1),
(97, 34, 'IPSC988789', 1),
(98, 35, 'TPUBC99999', 1),
(99, 35, 'CCST887549', 1),
(100, 35, 'FWCS96565', 1),
(101, 35, 'CVCS90773', 1),
(102, 35, 'IPSC988789', 1),
(103, 35, 'CAIP509987', 1),
(104, 35, 'IPTC898547', 1),
(105, 36, 'MAPC500889', 10),
(106, 36, 'TPUG508778', 1),
(107, 36, 'IPTC898547', 4),
(108, 36, 'CAIP509987', 1),
(109, 36, 'TPUC90987', 1),
(110, 37, 'TPUC90987', 3),
(111, 37, 'CAIP509987', 1),
(112, 37, 'IPTC898547', 3),
(113, 37, 'TPUG508778', 1),
(114, 37, 'MAPC500889', 1),
(115, 38, 'OSGC978484', 1),
(116, 38, 'CCST887549', 1),
(117, 38, 'TPUBC99999', 1),
(118, 38, 'CAIP509987', 1),
(119, 38, 'IPTC898547', 1),
(120, 39, 'CAIP509987', 1),
(121, 39, 'TPUC90987', 1),
(122, 39, 'IPTC898547', 1),
(123, 39, 'IPSC988789', 1),
(124, 39, 'MAPC500889', 1),
(125, 39, 'TPUG508778', 1),
(126, 40, 'TPUBC99999', 1),
(127, 40, 'CVCS90773', 2),
(128, 40, 'CCST887549', 1),
(129, 40, 'FWCS96565', 1),
(130, 40, 'IPSC988789', 1),
(131, 41, 'TPUBC99999', 1),
(132, 41, 'CVCS90773', 1),
(133, 41, 'FWCS96565', 1),
(134, 42, 'TPUBC99999', 1),
(135, 42, 'CVCS90773', 1),
(136, 42, 'FWCS96565', 1),
(137, 42, 'CCST887549', 1),
(138, 43, 'IPTC898547', 3),
(139, 43, 'CAIP509987', 1),
(140, 43, 'MAPC500889', 1),
(141, 44, 'TPUG508778', 2),
(142, 44, 'MAPC500889', 3),
(143, 44, 'IPTC898547', 3),
(144, 45, 'IPTC898547', 6),
(145, 45, 'TPUC90987', 1),
(146, 45, 'CAIP509987', 1),
(147, 45, 'IPSC988789', 1),
(148, 46, 'TPUBC99999', 4),
(149, 46, 'CVCS90773', 1),
(150, 46, 'FWCS96565', 1),
(151, 46, 'CCST887549', 1),
(152, 47, 'TPUBC99999', 1),
(153, 47, 'CVCS90773', 1),
(154, 47, 'FWCS96565', 1),
(155, 47, 'CCST887549', 1),
(156, 48, 'TPUBC99999', 6),
(157, 48, 'FWCS96565', 4),
(158, 48, 'CVCS90773', 2),
(159, 48, 'CCST887549', 2),
(160, 49, 'MAPC500889', 1),
(161, 49, 'TPUG508778', 1),
(162, 49, 'IPTC898547', 2),
(163, 49, 'TPUC90987', 1),
(164, 49, 'CAIP509987', 1),
(165, 50, 'CAIP509987', 1),
(166, 50, 'TPUC90987', 1),
(167, 50, 'IPTC898547', 1),
(168, 50, 'IPSC988789', 1),
(169, 50, 'CCST887549', 1),
(170, 51, 'TPUBC99999', 1),
(171, 51, 'CVCS90773', 1),
(172, 51, 'FWCS96565', 1),
(173, 51, 'CCST887549', 1),
(174, 51, 'IPSC988789', 1),
(175, 51, 'IPTC898547', 1),
(176, 51, 'TPUC90987', 1),
(177, 51, 'CAIP509987', 1),
(178, 51, 'TPUG508778', 1),
(179, 51, 'MAPC500889', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblRegisteredCustomers`
--

CREATE TABLE IF NOT EXISTS `tblRegisteredCustomers` (
`registredID` int(11) NOT NULL,
  `registeredEmail` varchar(20) NOT NULL,
  `registeredName` varchar(60) NOT NULL,
  `registeredDob` varchar(20) NOT NULL,
  `registeredGender` varchar(8) NOT NULL,
  `registeredLanguage` varchar(10) NOT NULL,
  `registerePassword` varchar(150) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblTransactions`
--

CREATE TABLE IF NOT EXISTS `tblTransactions` (
`transactionID` int(11) NOT NULL,
  `transactionDate` varchar(16) DEFAULT NULL,
  `transactionCustomerAccountID` int(11) DEFAULT NULL,
  `transactionClosed` varchar(4) DEFAULT NULL,
  `transactionCloseDate` varchar(16) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblTransactions`
--

INSERT INTO `tblTransactions` (`transactionID`, `transactionDate`, `transactionCustomerAccountID`, `transactionClosed`, `transactionCloseDate`) VALUES
(22, '08-06-16', 9, 'YES', '09-08-16'),
(21, '08-06-16', 9, 'No', NULL),
(20, '08-06-16', 9, 'YES', '06-08-16'),
(18, '08-02-16', 3, 'No', NULL),
(19, '08-06-16', 3, 'No', NULL),
(17, '08-02-16', 3, 'YES', '02-08-16'),
(23, '08-09-16', 10, 'No', NULL),
(24, '08-09-16', 10, 'No', NULL),
(25, '08-09-16', 11, 'YES', '09-08-16'),
(29, '08-10-16', 15, 'YES', '10-08-16'),
(28, '08-10-16', 14, 'No', NULL),
(30, '08-10-16', 16, 'YES', '10-08-16'),
(31, '08-10-16', 17, 'YES', '10-08-16'),
(51, '08-12-16', 9, 'No', NULL),
(50, '08-12-16', 9, 'No', NULL),
(49, '08-12-16', 9, 'YES', '12-08-16'),
(48, '08-12-16', 9, 'No', NULL),
(47, '08-12-16', 9, 'YES', '12-08-16'),
(46, '08-12-16', 9, 'YES', '12-08-16'),
(45, '08-12-16', 9, 'No', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblCustomerAccounts`
--
ALTER TABLE `tblCustomerAccounts`
 ADD PRIMARY KEY (`customerID`);

--
-- Indexes for table `tblItems`
--
ALTER TABLE `tblItems`
 ADD PRIMARY KEY (`itemID`);

--
-- Indexes for table `tblPurchasedItems`
--
ALTER TABLE `tblPurchasedItems`
 ADD PRIMARY KEY (`purchasedItemID`);

--
-- Indexes for table `tblRegisteredCustomers`
--
ALTER TABLE `tblRegisteredCustomers`
 ADD PRIMARY KEY (`registredID`);

--
-- Indexes for table `tblTransactions`
--
ALTER TABLE `tblTransactions`
 ADD PRIMARY KEY (`transactionID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblCustomerAccounts`
--
ALTER TABLE `tblCustomerAccounts`
MODIFY `customerID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `tblItems`
--
ALTER TABLE `tblItems`
MODIFY `itemID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `tblPurchasedItems`
--
ALTER TABLE `tblPurchasedItems`
MODIFY `purchasedItemID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=180;
--
-- AUTO_INCREMENT for table `tblRegisteredCustomers`
--
ALTER TABLE `tblRegisteredCustomers`
MODIFY `registredID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tblTransactions`
--
ALTER TABLE `tblTransactions`
MODIFY `transactionID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=52;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
