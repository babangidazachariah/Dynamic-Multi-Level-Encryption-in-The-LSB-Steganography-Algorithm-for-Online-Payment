-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 17, 2016 at 06:23 AM
-- Server version: 5.5.50-0+deb8u1
-- PHP Version: 5.6.24-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `MobilePayment`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblAccounts`
--

CREATE TABLE IF NOT EXISTS `tblAccounts` (
`accountID` int(11) NOT NULL,
  `accountNumber` varchar(20) NOT NULL,
  `accountName` varchar(60) NOT NULL,
  `accountType` varchar(10) NOT NULL,
  `accountAddress` varchar(70) NOT NULL,
  `accountBalance` double NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblAccounts`
--

INSERT INTO `tblAccounts` (`accountID`, `accountNumber`, `accountName`, `accountType`, `accountAddress`, `accountBalance`) VALUES
(1, '0987654321', 'Babangida Zachariah', 'Savings', 'Kaduna', 1234567890),
(2, '1234567890', 'Ladaza', 'Savings', 'Malaysia', 1242035.05),
(3, '1045026102', 'BABANGIDA ZACHARIAH', 'Savings', 'BUKIT JALIL', 1000),
(4, '1247781221', 'BABANGIDA ZACHARIAH AHMADU', 'Savings', 'BUKIT JALIL', 19228.29),
(5, '1174623190', 'James Ankuma', 'Savings', 'Kaduna', 1000),
(6, '1169217054', 'Ephraim Bernard', 'Current', 'Abuja', 1000),
(7, '123455663331', 'Babangida Zachariah', 'Savings', 'Kaduna', 1000),
(8, '1108961166', 'Juliana Jatau', 'Savings', 'Kaduna', 1000),
(9, '1908554273', 'Isaac Grace', 'Savings', 'Kurmin Jatau', 1000),
(10, '2064522024', 'John Nok', 'Savings', 'Nok Kaduna', 1000),
(11, '2148050380', 'Babangida Zachariah Ahmadu', 'Savings', '9 Zambia Crescent Barnawa Kaduna', 93799522.96),
(12, '3601783379', 'Sodangi John', 'Savings', 'Kano', 1000),
(13, '7085972701', 'guy man', 'Savings', 'sungai besi', 1000),
(14, '9518955599', 'Patience Ndang ', 'Savings', 'Kaduna State ', 1000000),
(15, '6755440170', 'Patience Ndang ', 'Savings', 'Kaduna State ', 1000000),
(16, '8155958197', 'abdu jamilu', 'Savings', 'A-7-14 arena green', 29980.01),
(17, '2277408753', 'Nandom Milaham James', 'Savings', 'FTMS Global College,Malaysia, Cyberjaya Campus.', 100000),
(18, '4898332485', 'Bernard Ephraim ', 'Savings', 'A2-3-3 Vista Komanwel A condominium bukit jalil Malaysia ', 1000),
(19, '3048328274', 'Bernard Ephraim ', 'Savings', 'A2-3-3 Vista Komanwel A condominium bukit jalil Malaysia ', 1000),
(20, '2115359202', 'Samson', 'Savings', 'Block A1 arena green', 1000),
(21, '2359844368', 'Samson', 'Savings', 'Block A1 arena green', 1000),
(22, '2316490378', 'Badamasi Yusuf', 'Savings', 'Arena green, Bukit Jalil Malaysia', 913),
(23, '7617847930', 'Ahmed Bello', 'Savings', 'Arena Green Apartment, Bukit Jail', 893.91),
(24, '9545868289', 'Kabiru Saadu ', 'Savings', 'Bukit Jalil', 904.41),
(25, '6641909592', 'Juliana Jatau', 'Savings', 'Kaduna', 1000);

-- --------------------------------------------------------

--
-- Table structure for table `tblCards`
--

CREATE TABLE IF NOT EXISTS `tblCards` (
`cardID` int(11) NOT NULL,
  `cardType` varchar(10) NOT NULL,
  `cardAccountID` int(11) NOT NULL,
  `cardNumber` varchar(20) NOT NULL,
  `cardExperyMonth` varchar(2) NOT NULL,
  `cardExperyYear` varchar(2) NOT NULL,
  `cardCVC` varchar(3) NOT NULL,
  `cardPin` varchar(6) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblCards`
--

INSERT INTO `tblCards` (`cardID`, `cardType`, `cardAccountID`, `cardNumber`, `cardExperyMonth`, `cardExperyYear`, `cardCVC`, `cardPin`) VALUES
(2, 'Master', 4, '1316134912', '07', '20', '907', '3496'),
(3, 'Master', 8, '1316134912', '04', '20', '706', '8209'),
(4, 'Master', 9, '6459034865949541', '12', '19', '724', '5712'),
(5, 'Verve', 10, '6842760374930412', '', '20', '439', '1293'),
(6, 'Master', 11, '2328825551947739', '02', '20', '740', '3560'),
(7, 'Master', 12, '6240318634293793', '08', '18', '419', '2973'),
(8, 'Master', 13, '1379076625522760', '', '20', '041', '9520'),
(9, 'Master', 14, '6536356949242612', '10', '19', '926', '0532'),
(10, 'Master', 15, '1970076166986758', '04', '20', '943', '5943'),
(11, 'Master', 16, '7172641818177107', '12', '18', '581', '8635'),
(12, 'Master', 17, '6172237177206783', '05', '20', '367', '3206'),
(13, 'Master', 18, '5841372828693666', '02', '20', '845', '7964'),
(14, 'Master', 19, '7723438381616549', '05', '18', '672', '6593'),
(15, 'Master', 20, '9244031606888976', '04', '20', '350', '4572'),
(16, 'Master', 21, '9710994755992812', '12', '18', '128', '2197'),
(17, 'Master', 22, '6090655201149534', '03', '19', '874', '8492'),
(18, 'Master', 23, '4860625285983224', '10', '20', '125', '9032'),
(19, 'Master', 24, '4388605715151053', '10', '18', '970', '5803'),
(20, 'Master', 25, '2237368829676218', '04', '18', '059', '9628');

-- --------------------------------------------------------

--
-- Table structure for table `tblCronJobTest`
--

CREATE TABLE IF NOT EXISTS `tblCronJobTest` (
`recID` int(11) NOT NULL,
  `exeTime` varchar(35) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblLogin`
--

CREATE TABLE IF NOT EXISTS `tblLogin` (
`loginID` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(120) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblLogin`
--

INSERT INTO `tblLogin` (`loginID`, `username`, `password`) VALUES
(2, 'daddy', '$2y$10$RbBXt0OaDA/Flr8b3gEPmOnqaxsx3I4Ze8ozV.gxZ3gtUgaiEvBOG'),
(3, 'daddonyone', '$2y$10$TGKTBd.PDiVPECH5ij.OYeRztPiTC3zNCLEOOuYWju/231nNMoPJm'),
(4, 'patience', '$2y$10$1UeqRCuNwZK/7FvCcCecCudG4RBL7NcZD9NLEodWeIc/UwltGKYBC'),
(5, 'awai4u', '$2y$10$270KL/kqEjdcMjKq0e5OZO6sWrucB7TqRwX4Dbp4uh7TYsdAgXoOO'),
(6, 'milahamnan', '$2y$10$FDZu6VgQ/Lg6Dz9lp1NnEO.K.b6JhWdFwslWGiDETaVg9Wxqx14aW'),
(7, 'Ephraim', '$2y$10$4ezHUgf24lq58uCLu3z5cemTcoQeiHix78Z2fAatnCUalBCxLlhti'),
(8, 'samson', '$2y$10$68gZYL2gXnOc.Ae51VBhj.WPkaFdC/vG2.m74Vgiiez1c2XoZgy9e'),
(9, 'badamasi', '$2y$10$am9R1FA/gqPLcXrE1hfJkenpyIlAZW9AepPT1dtMaPBtAVatpEvn.'),
(10, 'ahmed', '$2y$10$S/k3fTQhSkAXZEYe5LtSQem1Ij.DvIjsz6W/CgiqImJOuJTX9teKe'),
(11, 'saadu', '$2y$10$9Q9EaNMN63JloE0RRzvnHOi.0tOKO079nuykTqzILxNA43gUZiVh.');

-- --------------------------------------------------------

--
-- Table structure for table `tblMerchantInfo`
--

CREATE TABLE IF NOT EXISTS `tblMerchantInfo` (
`merchantID` int(11) NOT NULL,
  `merchantAccountID` int(11) NOT NULL,
  `merchantName` varchar(50) NOT NULL,
  `merchantTheme` varchar(100) NOT NULL,
  `merchantUrl` varchar(100) NOT NULL,
  `merchantLogo` varchar(50) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblMerchantInfo`
--

INSERT INTO `tblMerchantInfo` (`merchantID`, `merchantAccountID`, `merchantName`, `merchantTheme`, `merchantUrl`, `merchantLogo`) VALUES
(6, 2, 'LAZADA', 'Effortless Shopping With Exclusive Deals and Offers!!!', 'http://146.148.55.110/lazada.com.my', 'www.lazada.com.my5.png'),
(7, 0, 'JUMIA', 'Flexible Sales and Daily Offers', 'www.jumia.com.ng', 'www.jumia.com.ng7.png'),
(8, 0, 'LELONG', 'Best Online Phone Shoping', 'www.lelong.com.my', 'www.lelong.com.my8.png'),
(9, 0, 'FONEHOUSE', 'Great Mobile Phone Deals', 'www.fonehouse.co.uk', 'www.fonehouse.co.uk9.png'),
(10, 0, 'ZAPPOS', 'Fun and a Little Weird', 'www.zappos.com', 'www.zappos.com10.png'),
(11, 0, 'MOBILESHOP', 'Mobiles For All', 'www.mobilshop.com.my', 'www.mobilshop.com.my11.png'),
(12, 0, 'SuperBuy', 'Buy All With Convenience!!!', 'www.superbuy.my', 'www.superbuy.my12.png'),
(13, 0, 'SatuGadgets', 'All Generation Gadgets!!!', 'www.satugadget.com', 'www.satugadget.com13.png');

-- --------------------------------------------------------

--
-- Table structure for table `tblMerchants`
--

CREATE TABLE IF NOT EXISTS `tblMerchants` (
`merchantID` int(11) NOT NULL,
  `merchantAccountID` int(11) NOT NULL,
  `merchantUrl` varchar(20) NOT NULL,
  `merchantTheme` varchar(50) NOT NULL,
  `merchantLogo` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblRegisteredClients`
--

CREATE TABLE IF NOT EXISTS `tblRegisteredClients` (
`registredID` int(11) NOT NULL,
  `registeredDeviceID` varchar(250) NOT NULL,
  `registeredAccountID` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblRegisteredClients`
--

INSERT INTO `tblRegisteredClients` (`registredID`, `registeredDeviceID`, `registeredAccountID`) VALUES
(3, 'eOxATHfqEzA:APA91bGkCSahBVmbqyzOyToquEP0BPpWHVBxII9Ovf5ED9BjentWiwiiWR-IGvPq8sCfDAjp7MnJ89hkVS30Laob-jyRK9k9QPa9pqT0zruEw-XeiTLw9MhIzW_kgYnxYms9o2AL1LaV', 4),
(4, 'erqkUFy24Nc:APA91bGuESQ7FKI-cxacfpvAGbLydQIG_Y1BXXC7aVzQ1aywmcFoIewhh6Nx-B_D7ZaVlbc0I0aKJPkZAHDak8rflzDd2qu5yGTARrJ0MstYVaMfPNmpma7tHRZ17aGgjtiVPPwKrq4J', 11),
(5, 'fEVF7_tzD-Y:APA91bFCQHDAYgyx8qD7OiNiQFRsxnXd4bsQx1vX_OsdOaaBDAQ5sx2Ci84lE8qSHOAvNzOYqU7qH9JhNo9i_ekPTnj5Fi5NzM5CHY0OQV5NFNOWC9HwcqbmHQ50DFUGllJMUFlMvjaB', 16),
(6, 'eTsSW9TVYPM:APA91bFWvjE5AhYEN4z3NIKHR1ov_rF6v_mCGbIhQrmLgaanNRsEDVUg0MRR33bYpsz_j-7WwY6BkD2kYkHbhZM4ykhdeGwi19_WQfOXIeXNO771VudFecm5OV6mFeFk2js8JYVzC2Yn', 18),
(7, 'cu-ydwmm6WU:APA91bGfSjgnymBtDReJlMZhKqJKengIi2hSbK1sx468BuQ_rQrU-VKj3oK4QTI6dfW0iPXNInzyfqq1htdC4sPWBuaMamg3GJOumkcmcIQyhP8kd0Y6omAME0eX27utTKRNl2ZtgSUT', 22),
(8, 'en3vr_o4trI:APA91bHSOED4ad1U2Zx6UDV4jUa8j-kWsJ4vxSXjpVY7f2AjL85jZ-OfE5YZxRO8Wj5HV6V7j4cLE4r33UAFAMe_rUhgSt-pyURcI9Xv_Fybp1k2VAXmsWotglu5xZBHnCaBXrU45pbj', 23),
(9, 'dU_Ou0uGd08:APA91bEH2pZ6mWmNgQK4Sef5r4a_ahts88Tw6bTdvW7bRebtWd0yfT1BJJ8TJrq7YOABqvoUT3ttGZyExhUUq1SqDUgne9mtWv9lFSOuKJE6vHnu5dzaIBq6UCVAB40B4xKs0NmCVvHj', 24);

-- --------------------------------------------------------

--
-- Table structure for table `tblTransactions`
--

CREATE TABLE IF NOT EXISTS `tblTransactions` (
`bTransactionID` int(11) NOT NULL,
  `mTransactionID` int(11) NOT NULL,
  `customerAccountID` int(11) NOT NULL,
  `merchantAccountID` int(11) NOT NULL,
  `transactionOtp` varchar(120) NOT NULL,
  `transactionCaptcha` varchar(8) NOT NULL,
  `transactionOtek` varchar(16) NOT NULL,
  `transactionDate` varchar(25) NOT NULL,
  `transactionTotalAmount` double NOT NULL,
  `transactionClosed` varchar(4) NOT NULL,
  `transactionCloseDate` varchar(25) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblTransactions`
--

INSERT INTO `tblTransactions` (`bTransactionID`, `mTransactionID`, `customerAccountID`, `merchantAccountID`, `transactionOtp`, `transactionCaptcha`, `transactionOtek`, `transactionDate`, `transactionTotalAmount`, `transactionClosed`, `transactionCloseDate`) VALUES
(19, 22, 11, 2, '$2y$10$mR/GmFSFSMP.54xJXxmaJ.Zs2NDAAuKgYcV.bgP2xadrSxnOxV2zq', '9jCIavr1', 'xfFSe', '06-08-16', 50, 'YES', '2016-08-09 07:34:45'),
(24, 30, 23, 2, '$2y$10$q5ZlLN2mVSMMrOZtEwTJnegw9JN27nnLOAZrJGnzHSAuPaiIC0QW6', 'VPOz5nod', 's04Ih', '2016-08-10 06:39:19', 106.09, 'YES', '2016-08-10 06:41:10'),
(25, 31, 24, 2, '$2y$10$MWTi1gumEZaMwFTnN7AWfOOExI8uApH956J1Jpp.CUjHd2M5AFtFu', 'DeGKNyR5', '6pTwi', '2016-08-10 07:02:24', 95.59, 'YES', '2016-08-10 07:03:31'),
(17, 20, 11, 2, '$2y$10$64jx9zwNAVsxR.NKwS8k..ysjuvpkFef/vxREkLlxW8IOb5jQBOEm', 'LqozDMQd', 'jZth4', '06-08-2016 09:00:00', 61.5, 'YES', '06-08-2016 09:00:00'),
(14, 17, 4, 2, '$2y$10$mDAeMQVrhg7VpYjg/Id6KuQjigq7jNN6Av7m88WwCnNvzMpjKo/4.', 'hltafNU5', 'Gu4KW', '02-08-16', 78.79, 'YES', '02-08-16'),
(20, 25, 16, 2, '$2y$10$MI2EBbRVjjo.Us9IzFH1duxIaJbn2GSLh/0xG9EMYsyUl0ygmzQ.m', '2o8MmeL4', 'pNSYI', '2016-08-09 07:25:57', 19.99, 'YES', '2016-08-09 07:36:59'),
(23, 29, 22, 2, '$2y$10$1ZJ2LrsapPTvv3JySnKPcegsG7Qn5acoF22ZLs3YTcI5/oTvFfrDm', 'sdAhQRnw', 'uU8aL', '2016-08-10 06:34:15', 87, 'YES', '2016-08-10 06:36:23'),
(45, 51, 11, 2, '$2y$10$WF1CSkNDv3uV898.SXOTx.Byywpf0oszV65KiXZ2V2MGxRjJYHQfi', 'DXxipZkh', 'm71nW', '2016-08-12 17:18:46', 245.58, 'No', NULL),
(44, 50, 11, 2, '$2y$10$IEtPSxihAt4DJxOnzI21tePBFQjVkoi7c2dRSU/lpLlgy1betqC8S', 'Ef3QhAsu', 'wCHbm', '2016-08-12 17:18:07', 100.7, 'No', NULL),
(43, 49, 11, 2, '$2y$10$jbm9.CQ6.B.tzmHNHBTaTOYdV5gC1AaZInUm12uF1fqafMUVROJ82', 'Lh1ug0P8', 'ezTZW', '2016-08-12 17:17:35', 91.39, 'YES', '2016-08-12 17:35:55'),
(42, 48, 11, 2, '$2y$10$mCEmJTrfP2IGw/8wr2mlpeyliM52OLwlAgupdhmCCTi7bnhfzoSFq', '54J73CXk', 'UIwOW', '2016-08-12 17:17:08', 443.14, 'No', NULL),
(41, 47, 11, 2, '$2y$10$BDfPCTSfSrjwoC5bMr7FM.Uz49MSrVfdwwA0ow/St1wBev4FhIT3G', 'HsxjQrFP', 'yW5KA', '2016-08-12 17:16:39', 139.59, 'YES', '2016-08-12 17:29:51'),
(40, 46, 11, 2, '$2y$10$qEYZsbBbLrp1zp6HUZ26E.z0zvU0rHCP9ED6.HC0QV5BdRqhfbW1m', 'ks3vVBh5', 'oIUNc', '2016-08-12 17:16:19', 196.56, 'YES', '2016-08-12 17:27:50'),
(39, 45, 11, 2, '$2y$10$fSf1eGBxvzT/S7CO77z6e.v0mz9e0h5nk4hO8HlLETeJfv17FrRpK', 'Wml4bAz3', 'eyCZt', '2016-08-12 17:15:53', 117.1, 'No', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblAccounts`
--
ALTER TABLE `tblAccounts`
 ADD PRIMARY KEY (`accountID`), ADD KEY `accountID` (`accountID`);

--
-- Indexes for table `tblCards`
--
ALTER TABLE `tblCards`
 ADD PRIMARY KEY (`cardID`), ADD KEY `cardAccountID` (`cardAccountID`);

--
-- Indexes for table `tblCronJobTest`
--
ALTER TABLE `tblCronJobTest`
 ADD PRIMARY KEY (`recID`);

--
-- Indexes for table `tblLogin`
--
ALTER TABLE `tblLogin`
 ADD PRIMARY KEY (`loginID`);

--
-- Indexes for table `tblMerchantInfo`
--
ALTER TABLE `tblMerchantInfo`
 ADD PRIMARY KEY (`merchantID`);

--
-- Indexes for table `tblMerchants`
--
ALTER TABLE `tblMerchants`
 ADD PRIMARY KEY (`merchantID`);

--
-- Indexes for table `tblRegisteredClients`
--
ALTER TABLE `tblRegisteredClients`
 ADD PRIMARY KEY (`registredID`), ADD KEY `registeredAccountID` (`registeredAccountID`);

--
-- Indexes for table `tblTransactions`
--
ALTER TABLE `tblTransactions`
 ADD PRIMARY KEY (`bTransactionID`), ADD KEY `customerAccountID` (`customerAccountID`,`merchantAccountID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblAccounts`
--
ALTER TABLE `tblAccounts`
MODIFY `accountID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `tblCards`
--
ALTER TABLE `tblCards`
MODIFY `cardID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `tblCronJobTest`
--
ALTER TABLE `tblCronJobTest`
MODIFY `recID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=72;
--
-- AUTO_INCREMENT for table `tblLogin`
--
ALTER TABLE `tblLogin`
MODIFY `loginID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `tblMerchantInfo`
--
ALTER TABLE `tblMerchantInfo`
MODIFY `merchantID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `tblMerchants`
--
ALTER TABLE `tblMerchants`
MODIFY `merchantID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tblRegisteredClients`
--
ALTER TABLE `tblRegisteredClients`
MODIFY `registredID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `tblTransactions`
--
ALTER TABLE `tblTransactions`
MODIFY `bTransactionID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=46;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
