-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 02, 2018 at 06:08 AM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `agrimate_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_account_title`
--

CREATE TABLE `tbl_account_title` (
  `AT_ID` int(11) NOT NULL,
  `AccountTitle` varchar(100) NOT NULL,
  `Deleted` varchar(5) NOT NULL DEFAULT 'NO'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_account_title`
--

INSERT INTO `tbl_account_title` (`AT_ID`, `AccountTitle`, `Deleted`) VALUES
(1, 'Expenses', 'NO'),
(2, 'Operation Expense', 'NO'),
(3, 'Travel Expenses 2', 'YES');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_actual_product`
--

CREATE TABLE `tbl_actual_product` (
  `ProductCode` varchar(200) NOT NULL,
  `ProductDesc` varchar(100) NOT NULL,
  `Packaging` varchar(100) NOT NULL,
  `Price` decimal(10,2) DEFAULT NULL,
  `CriticalLevel` int(11) DEFAULT NULL,
  `ProdCodeID` int(11) NOT NULL,
  `Deleted` varchar(5) NOT NULL DEFAULT 'NO'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_actual_product`
--

INSERT INTO `tbl_actual_product` (`ProductCode`, `ProductDesc`, `Packaging`, `Price`, `CriticalLevel`, `ProdCodeID`, `Deleted`) VALUES
('DIACOXIN SUSPENSION 3 KGS/CARTON', 'DIACOXIN SUSPENSION', '3 KGS/CARTON', NULL, NULL, 14, 'NO'),
('DIACOXIN SUSPENSION 7 KGS/CARTON', 'DIACOXIN SUSPENSION', '7 KGS/CARTON', NULL, NULL, 13, 'NO'),
('FRESTA F CONC (25kg) 100 ML/BOTTLE', 'FRESTA F CONC (25kg)', '100 ML/BOTTLE', NULL, NULL, 16, 'NO'),
('FRESTA F CONC (25kg) 5 KGS/BAG', 'FRESTA F CONC (25kg)', '5 KGS/BAG', NULL, NULL, 15, 'NO'),
('ROBISTAT 6.6% 10 KGS/CARTON', 'ROBISTAT 6.6%', '10 KGS/CARTON', '100.00', 100, 1, 'NO'),
('ROBISTAT 6.6% 25 KGS/BAG', 'ROBISTAT 6.6%', '25 KGS/BAG', NULL, NULL, 2, 'NO'),
('SUISHOT ALL RES 10 KGS/BAG', 'SUISHOT ALL RES', '10 KGS/BAG', NULL, NULL, 3, 'NO'),
('SUISHOT ALL RES 10 KGS/CARTON', 'SUISHOT ALL RES', '10 KGS/CARTON', NULL, NULL, 4, 'NO'),
('SUISHOT ALL RES 12 KGS/BAG', 'SUISHOT ALL RES', '12 KGS/BAG', NULL, NULL, 12, 'NO'),
('SUISHOT ALL RES 13 KGS/BAG', 'SUISHOT ALL RES', '13 KGS/BAG', NULL, NULL, 11, 'NO'),
('SUISHOT ALL RES 20 KGS/BAG', 'SUISHOT ALL RES', '20 KGS/BAG', NULL, NULL, 9, 'NO'),
('SUISHOT ALL RES 5 KGS/BAG', 'SUISHOT ALL RES', '5 KGS/BAG', NULL, NULL, 10, 'NO'),
('SUISHOT ALL RES GALLON', 'SUISHOT ALL RES', 'GALLON', '12.50', NULL, 5, 'NO'),
('SUISHOT APM-7 10 KGS/CARTON', 'SUISHOT APM-7', '10 KGS/CARTON', NULL, NULL, 6, 'NO'),
('SUISHOT APM-7 12 KGS/BUCKET', 'SUISHOT APM-7', '12 KGS/BUCKET', NULL, NULL, 7, 'NO'),
('SUISHOT APM-7 25 Doses x 10 Vials', 'SUISHOT APM-7', '25 Doses x 10 Vials', NULL, NULL, 8, 'YES');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_actual_prod_beg_inv`
--

CREATE TABLE `tbl_actual_prod_beg_inv` (
  `BegInvID` int(11) NOT NULL,
  `WarehouseID` int(11) NOT NULL,
  `ProductCode` varchar(100) NOT NULL,
  `CurrentStock` int(11) NOT NULL,
  `AsOfMonth` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_actual_prod_beg_inv`
--

INSERT INTO `tbl_actual_prod_beg_inv` (`BegInvID`, `WarehouseID`, `ProductCode`, `CurrentStock`, `AsOfMonth`) VALUES
(1, 1, 'ROBISTAT 6.6% 25 KGS/BAG', 10, 'November 2018'),
(2, 1, 'ROBISTAT 6.6% 10 KGS/CARTON', 30, 'November 2018'),
(3, 1, 'SUISHOT APM-7 10 KGS/CARTON', 0, 'November 2018'),
(4, 1, 'SUISHOT APM-7 12 KGS/BUCKET', 850, 'November 2018'),
(5, 1, 'SUISHOT ALL RES GALLON', 920, 'November 2018'),
(6, 2, 'ROBISTAT 6.6% 10 KGS/CARTON', 890, 'November 2018'),
(7, 5, 'ROBISTAT 6.6% 10 KGS/CARTON', 1000, 'November 2018'),
(8, 2, 'ROBISTAT 6.6% 25 KGS/BAG', 950, 'November 2018'),
(9, 5, 'SUISHOT APM-7 10 KGS/CARTON', 1000, 'November 2018'),
(10, 4, 'ROBISTAT 6.6% 10 KGS/CARTON', 900, 'November 2018'),
(11, 4, 'ROBISTAT 6.6% 25 KGS/BAG', 1000, 'November 2018'),
(12, 4, 'SUISHOT ALL RES GALLON', 1000, 'November 2018'),
(13, 1, 'SUISHOT ALL RES 10 KGS/BAG', 0, 'November 2018'),
(14, 1, 'SUISHOT ALL RES 10 KGS/CARTON', 1, 'November 2018'),
(15, 1, 'SUISHOT APM-7 25 Doses x 10 Vials', 1000, 'November 2018'),
(16, 3, 'SUISHOT APM-7 12 KGS/BUCKET', 6, 'November 2018'),
(17, 1, 'SUISHOT ALL RES 20 KGS/BAG', 20, 'November 2018'),
(18, 1, 'SUISHOT ALL RES 5 KGS/BAG', 10, 'November 2018'),
(19, 1, 'SUISHOT ALL RES 13 KGS/BAG', 0, 'November 2018'),
(20, 1, 'SUISHOT ALL RES 12 KGS/BAG', 10, 'November 2018'),
(21, 1, 'DIACOXIN SUSPENSION 7 KGS/CARTON', 0, 'November 2018'),
(22, 1, 'DIACOXIN SUSPENSION 3 KGS/CARTON', 4, 'November 2018'),
(23, 1, 'FRESTA F CONC (25kg) 5 KGS/BAG', 50, 'November 2018'),
(24, 1, 'FRESTA F CONC (25kg) 100 ML/BOTTLE', 1, 'November 2018');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ap`
--

CREATE TABLE `tbl_ap` (
  `AP_ID` int(11) NOT NULL,
  `APRefNumber` varchar(12) NOT NULL,
  `CheckNumber` varchar(20) NOT NULL,
  `Date` date NOT NULL,
  `Payee` int(11) NOT NULL,
  `Company` int(11) NOT NULL,
  `BIR` varchar(10) NOT NULL,
  `EWT` decimal(10,2) DEFAULT NULL,
  `Total` decimal(10,2) NOT NULL,
  `Status` varchar(15) NOT NULL DEFAULT 'PENDING'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_ap`
--

INSERT INTO `tbl_ap` (`AP_ID`, `APRefNumber`, `CheckNumber`, `Date`, `Payee`, `Company`, `BIR`, `EWT`, `Total`, `Status`) VALUES
(1, '201807271', '132123', '2018-07-27', 14, 2, 'Non-BIR', '0.00', '300.00', 'CONFIRMED'),
(2, '201807272', '1322143', '2018-07-27', 2, 1, 'BIR', '100.00', '1000.00', 'CONFIRMED'),
(3, '201810253', '7564', '2018-10-25', 2, 1, 'BIR', '100.00', '900.00', 'CANCELLED');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ap_particular`
--

CREATE TABLE `tbl_ap_particular` (
  `AP_ParticularID` int(11) NOT NULL,
  `AP_ID` int(11) NOT NULL,
  `Description` varchar(100) NOT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `AccountTitle` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_ap_particular`
--

INSERT INTO `tbl_ap_particular` (`AP_ParticularID`, `AP_ID`, `Description`, `Amount`, `AccountTitle`) VALUES
(1, 1, 'Electric bill', '100.00', 1),
(2, 1, 'Water bill', '100.00', 1),
(3, 1, 'Rent', '100.00', 2),
(4, 2, 'Electric bill', '1000.00', 1),
(5, 3, 'Internet', '1000.00', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_business_style`
--

CREATE TABLE `tbl_business_style` (
  `BS_ID` int(11) NOT NULL,
  `BusinessStyle` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_business_style`
--

INSERT INTO `tbl_business_style` (`BS_ID`, `BusinessStyle`) VALUES
(1, 'HOGS AND POULTRY'),
(2, 'AQUATIC'),
(3, 'SERVICES');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cmo`
--

CREATE TABLE `tbl_cmo` (
  `CMO_ID` int(11) NOT NULL,
  `FullName` varchar(200) NOT NULL,
  `Location` varchar(200) NOT NULL,
  `Status` varchar(10) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_cmo`
--

INSERT INTO `tbl_cmo` (`CMO_ID`, `FullName`, `Location`, `Status`) VALUES
(1, 'Sample Data1', 'Pasig', 'Active'),
(2, 'Sample Data2', 'Taguig', 'Inactive'),
(3, 'Sample Data3', 'Mandaluyong', 'Active'),
(4, 'Josiah Cavitana', 'Taguig', 'Active'),
(5, 'Vennise Manuel', 'Bulacan', 'Active'),
(6, 'Charisse Mapatac', '', 'Active'),
(7, 'Roxanne Correos', '', 'Active'),
(8, 'Jaron Austria', '', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cmo_cust`
--

CREATE TABLE `tbl_cmo_cust` (
  `CC_ID` int(11) NOT NULL,
  `CMO_ID` int(11) NOT NULL,
  `CustomerID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_cmo_cust`
--

INSERT INTO `tbl_cmo_cust` (`CC_ID`, `CMO_ID`, `CustomerID`) VALUES
(31, 4, 3),
(32, 6, 3),
(33, 8, 3),
(34, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_company`
--

CREATE TABLE `tbl_company` (
  `CompanyID` int(11) NOT NULL,
  `CompanyName` varchar(50) NOT NULL,
  `Address` varchar(100) DEFAULT NULL,
  `Deleted` varchar(5) NOT NULL DEFAULT 'NO'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_company`
--

INSERT INTO `tbl_company` (`CompanyID`, `CompanyName`, `Address`, `Deleted`) VALUES
(1, 'Agrimate', NULL, 'NO'),
(2, 'Josiah', NULL, 'NO'),
(3, 'Josiah Trading 2', NULL, 'YES');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_credit`
--

CREATE TABLE `tbl_credit` (
  `MemoNumber` int(11) NOT NULL,
  `SONumber` int(11) NOT NULL,
  `CreditDate` date NOT NULL,
  `Total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_credit`
--

INSERT INTO `tbl_credit` (`MemoNumber`, `SONumber`, `CreditDate`, `Total`) VALUES
(1, 2, '2018-07-22', '500.00'),
(2, 8, '2018-07-30', '1.00'),
(3, 8, '2018-08-09', '1.00'),
(4, 8, '2018-08-09', '1.00'),
(5, 8, '2018-08-09', '2.00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_credit_bd`
--

CREATE TABLE `tbl_credit_bd` (
  `CBD_ID` int(11) NOT NULL,
  `MemoNumber` int(11) NOT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `Description` varchar(200) NOT NULL,
  `UnitPrice` decimal(10,2) DEFAULT NULL,
  `Amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_credit_bd`
--

INSERT INTO `tbl_credit_bd` (`CBD_ID`, `MemoNumber`, `Quantity`, `Description`, `UnitPrice`, `Amount`) VALUES
(3, 1, 0, 'Adjustment', '0.00', '500.00'),
(4, 2, 0, 'Wala lang', '0.00', '1.00'),
(5, 3, 1, '131', '1.00', '1.00'),
(6, 4, 1, 'Wala lang', '1.00', '1.00'),
(7, 5, 0, 'Wala lang', '1.00', '2.00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customers`
--

CREATE TABLE `tbl_customers` (
  `CustomerID` int(11) NOT NULL,
  `CompanyName` varchar(200) NOT NULL,
  `CompanyAddress` varchar(500) NOT NULL,
  `BusinessStyle` int(11) DEFAULT NULL,
  `ContactPerson` varchar(200) DEFAULT NULL,
  `ContactNumber` varchar(20) DEFAULT NULL,
  `CreditLimit` double DEFAULT NULL,
  `TIN` varchar(15) DEFAULT NULL,
  `RemainingBalance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `Deleted` varchar(5) NOT NULL DEFAULT 'NO'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_customers`
--

INSERT INTO `tbl_customers` (`CustomerID`, `CompanyName`, `CompanyAddress`, `BusinessStyle`, `ContactPerson`, `ContactNumber`, `CreditLimit`, `TIN`, `RemainingBalance`, `Deleted`) VALUES
(1, '\"SAN MIGUEL FOODS, INC.\"', '23RD FLR.JMT CORP. CONDOMINIUM ADB AVE.', 1, 'DONIE V. LEAL  ', NULL, 20000000, NULL, '0.00', 'NO'),
(2, '\"STS VENTURES, INS.\"', '\"BAGBAGUIN, STA.MARIA BULACAN\"', 1, 'FERAIZA SANTOS', NULL, 10000, NULL, '0.00', 'NO'),
(3, 'PRIMO POULTRY FARM', '\"345 J. TEODORO ST., COR. 10TH AVE.CALOOCAN CITY\"', 1, 'FERAIZA M. SANTOS', NULL, 10000, NULL, '0.00', 'NO'),
(4, 'ORIENTAL FARM', '\"BAHAY PARI, MECAUYAN BULACAN\"', 1, 'FERAIZA C. SANTOS', NULL, 10000, NULL, '0.00', 'NO'),
(6, 'BOUNTY AGRO VENTURES INC', 'DOOR #5 BANYAN PLACE ALWANA COMPOUND CAGAYAN DE ORO CITY', 1, 'DONIE V. LEAL', NULL, NULL, '005 470 257', '0.00', 'NO'),
(7, '\"CLARC FEEDMILL, INC.\"', '\"BRGY. PINAGKAWITAN LIPA CITY, BATANGAS\"', 1, 'ROAN H.AGREGADO', NULL, NULL, NULL, '0.00', 'NO'),
(8, 'PHILIPPINE FOREMOST MILLING CORP.', '\"LOT 2 & 3, BLOCK 1 BONIFACIO V. ROMERO BLVD., MANILA HARBOUR CENTRE R-10 ROAD VITAS TONDO MANILA\"', 1, 'KATHREEN GEM R. VINARAO', NULL, NULL, '000 996 219 002', '0.00', 'NO'),
(9, 'MAGICORP FEEDMILL', '\"MATAAS NA KAHOY, BATANGAS CITY\"', 1, 'DON MCLAIN REMORAL', NULL, NULL, NULL, '0.00', 'NO'),
(11, 'RE-ORCINE ', '\"FRANCIA, IRIGAN CITY CAMARINES SUR\"', 1, 'JAYSON M. BAGWISA', NULL, NULL, NULL, '0.00', 'NO'),
(12, 'ELVINA FARM', '946 BUSILAC ST CORNER HINAHON MANDALUYONG CITY', 1, 'ERMI I. CATIBOG', NULL, NULL, NULL, '0.00', 'NO'),
(13, '\"BOUNTY FARMS, INC.\"', '\"179 MARIANO PONCE ST., CALOOCAN CITY\"', 1, 'DONIE V. LEAL', NULL, NULL, '000 926 897', '0.00', 'NO'),
(14, 'ROCKY FARM', 'BO.DALIG CIRCUMFERENTIAL RD. ANTIPOLO CITY', 1, 'MA.JANINE V. SALVADOR', NULL, NULL, '000 599 994 000', '0.00', 'NO'),
(15, '\"CLARC FEEDMILL, INC.\"', '\"BRGY. PINAGKAWITAN LIPA CITY, BATANGAS\"', 1, 'ROAN H.AGREGADO', NULL, NULL, NULL, '0.00', 'NO'),
(16, 'JERASENES FARM', '\"BALUA, CAGAYAN DE ORO CITY\"', 1, 'ROMEL C. BAYLEN', NULL, NULL, NULL, '0.00', 'NO'),
(17, 'HYPIG GENETICS', '\"GUIGUINTO, BULACAN\"', 1, 'DONIE V.LEAL', NULL, NULL, NULL, '0.00', 'NO'),
(18, 'CABSAN FARM', '\"OLINGO SAN RAFAEL, BULACAN\"', 1, 'RACHEL L. CORNELIO', NULL, NULL, NULL, '0.00', 'NO'),
(19, 'POLAR FARM', '\"SUNRISER VILLAGE, LLANO ROAD NOVALICHES KALOOKAN CITY\"', 1, 'RACHEL L. CORNELIO', NULL, NULL, NULL, '0.00', 'NO'),
(21, 'S & G Diversified Farm', '\"Purok Papaya Upper La Union Mankilam, Tagum city\"', 2, 'Adulfo Setosta', NULL, NULL, NULL, '0.00', 'NO'),
(22, 'Vetworks Inc.', '\"Banahaw Ricemill Compound, Brgy.Tibag Tarlac City\"', 1, NULL, NULL, NULL, NULL, '0.00', 'NO'),
(23, 'Progressive Farm', '\"Pallan, Tupi, South Cotabato\"', 1, NULL, NULL, NULL, NULL, '0.00', 'NO'),
(24, 'DRC Farm', '\"Opol, Misamis Occidental\"', 1, NULL, NULL, NULL, NULL, '0.00', 'NO'),
(25, 'Baron Panlilio Agro-Industrial Co.Ltd.', 'Pampanga/ Tarlac', 1, 'Josiah Cavitana', '09434202317', 100000, '123456789', '0.00', 'NO'),
(26, 'Mallari Piggery Farm', '\"Sitio Dalig, Matalatala, Mabitac, Laguna\"', 1, NULL, NULL, NULL, NULL, '0.00', 'NO'),
(27, 'Raymundo Farm', '\"Orion, Bataan\"', 1, NULL, NULL, NULL, NULL, '0.00', 'NO'),
(28, 'E.G.G. Farm Haus', '\"466 Brgy.Concepcion, Baliwag, Bulacan\"', 1, NULL, NULL, NULL, NULL, '0.00', 'NO'),
(29, 'Hypig Genetics Inc.', '\"Brgy.Dela Cruz Bamban, Tarlac\"', 1, NULL, NULL, NULL, NULL, '0.00', 'NO'),
(30, 'Domino Farm', '\"Brgy.Sto.Tomas, Binan Laguna\"', 1, NULL, NULL, NULL, NULL, '0.00', 'NO'),
(31, 'Marcela Farm', '\"Alturas Bldg., Agora Tagbilaran Bohol\"', 2, 'Mareza M. Ramos', NULL, NULL, NULL, '0.00', 'NO'),
(32, 'Josiah Agri Trade', 'Taguig', 1, 'Josiah Cavitana', '09434202317', 100000, '123456789', '0.00', 'NO'),
(33, 'Vennise Aquatic', 'Bulacan', 2, '', '', 0, '', '0.00', 'NO'),
(34, 'Hello', 'hello', NULL, NULL, NULL, NULL, NULL, '0.00', 'NO'),
(35, 'Josiah Trading', 'Taguig, Metro Manila', NULL, NULL, NULL, NULL, NULL, '0.00', 'NO');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_debit`
--

CREATE TABLE `tbl_debit` (
  `MemoNumber` int(11) NOT NULL,
  `SONumber` int(11) NOT NULL,
  `DebitDate` date NOT NULL,
  `Total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_debit`
--

INSERT INTO `tbl_debit` (`MemoNumber`, `SONumber`, `DebitDate`, `Total`) VALUES
(1, 2, '2018-07-22', '10.00'),
(2, 8, '2018-08-09', '1.00'),
(3, 8, '2018-08-09', '1.00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_debit_bd`
--

CREATE TABLE `tbl_debit_bd` (
  `DBD_ID` int(11) NOT NULL,
  `MemoNumber` int(11) NOT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `Description` varchar(200) NOT NULL,
  `UnitPrice` decimal(10,2) DEFAULT NULL,
  `Amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_debit_bd`
--

INSERT INTO `tbl_debit_bd` (`DBD_ID`, `MemoNumber`, `Quantity`, `Description`, `UnitPrice`, `Amount`) VALUES
(1, 1, 1, 'Adjustment', '10.00', '10.00'),
(2, 2, 0, 'Wala lang', '1.00', '1.00'),
(3, 3, 0, 'Wala lang', '1.00', '1.00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_importation`
--

CREATE TABLE `tbl_importation` (
  `ProformaInvNo` varchar(20) NOT NULL,
  `ProformaInvDate` date NOT NULL,
  `CommercialInvNo` varchar(20) DEFAULT NULL,
  `CommInvDate` date DEFAULT NULL,
  `SupplierID` int(11) NOT NULL,
  `PaymentTerm` int(11) NOT NULL,
  `Currency` varchar(10) NOT NULL,
  `ProformaInvAttachment` varchar(200) DEFAULT NULL,
  `SpecialReminders` varchar(500) NOT NULL,
  `DeliveryStatus` varchar(20) NOT NULL DEFAULT 'ORDERED',
  `DeliveredDate` date DEFAULT NULL,
  `Origin` int(11) NOT NULL,
  `ImportPermitNo` varchar(20) DEFAULT NULL,
  `Total` decimal(10,2) DEFAULT NULL,
  `Balance` decimal(10,2) NOT NULL,
  `StatusArchive` varchar(20) NOT NULL DEFAULT 'NO',
  `StatusBreakdown` varchar(20) NOT NULL DEFAULT 'NO',
  `StatusComplete` varchar(10) NOT NULL DEFAULT 'NO',
  `StatusDeduction` varchar(5) NOT NULL DEFAULT 'NO',
  `DeductedAmount` decimal(10,2) NOT NULL,
  `DateCreated` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_importation`
--

INSERT INTO `tbl_importation` (`ProformaInvNo`, `ProformaInvDate`, `CommercialInvNo`, `CommInvDate`, `SupplierID`, `PaymentTerm`, `Currency`, `ProformaInvAttachment`, `SpecialReminders`, `DeliveryStatus`, `DeliveredDate`, `Origin`, `ImportPermitNo`, `Total`, `Balance`, `StatusArchive`, `StatusBreakdown`, `StatusComplete`, `StatusDeduction`, `DeductedAmount`, `DateCreated`) VALUES
('1000', '2018-08-04', '', '0000-00-00', 25, 2, 'PHP', NULL, '', 'DELIVERED', '2018-10-20', 2, NULL, '10000.00', '9000.00', 'NO', 'YES', 'NO', 'YES', '500.00', '2018-08-04'),
('12345', '2018-08-04', '3456789', '2018-08-04', 25, 1, 'EURO', NULL, 'dfghjklfg', 'DELIVERED', '2018-10-20', 2, NULL, '20000.00', '20000.00', 'NO', 'NO', 'NO', 'NO', '0.00', '2018-08-04'),
('b', '2018-07-26', '', '0000-00-00', 2, 5, 'PHP', NULL, '', 'DELIVERED', '2018-10-30', 3, NULL, '10.00', '10.00', 'NO', 'NO', 'NO', 'NO', '0.00', '2018-10-30'),
('invoince1', '2018-12-31', 'invoice1', '2018-12-31', 25, 1, 'PHP', NULL, 'ghjkl', 'DELIVERED', '2018-10-20', 1, NULL, '100.00', '100.00', 'NO', 'YES', 'NO', 'NO', '0.00', '2018-10-25'),
('jhfhf', '2018-12-31', 'hfhfg', '2018-12-31', 1, 1, 'PHP', NULL, 'mhhf', 'ORDERED', NULL, 2, NULL, '100.00', '100.00', 'NO', 'NO', 'NO', 'NO', '0.00', '2018-10-25');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_imp_breakdown`
--

CREATE TABLE `tbl_imp_breakdown` (
  `ImpBD_ID` int(11) NOT NULL,
  `Imp_ProdID` int(11) NOT NULL,
  `ProductCode` varchar(100) NOT NULL,
  `Quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_imp_breakdown`
--

INSERT INTO `tbl_imp_breakdown` (`ImpBD_ID`, `Imp_ProdID`, `ProductCode`, `Quantity`) VALUES
(1, 90, 'FRESTA F CONC (25kg) 5 KGS/BAG', 50),
(2, 87, 'FRESTA F CONC (25kg) 100 ML/BOTTLE', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_imp_docs`
--

CREATE TABLE `tbl_imp_docs` (
  `ImpDocs_ID` int(11) NOT NULL,
  `ProformaInvNo` varchar(20) NOT NULL,
  `DocumentPath` varchar(200) NOT NULL,
  `FileTitle` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_imp_product`
--

CREATE TABLE `tbl_imp_product` (
  `ImpProd_ID` int(11) NOT NULL,
  `ProformaInvNo` varchar(20) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `PackagingID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Unit` varchar(10) NOT NULL,
  `Price` decimal(10,2) NOT NULL,
  `Total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_imp_product`
--

INSERT INTO `tbl_imp_product` (`ImpProd_ID`, `ProformaInvNo`, `ProductID`, `PackagingID`, `Quantity`, `Unit`, `Price`, `Total`) VALUES
(85, '12345', 7, 8, 100, 'N/A', '200.00', '20000.00'),
(87, '1000', 8, 4, 100, 'N/A', '100.00', '10000.00'),
(88, 'jhfhf', 1, 9, 10, 'N/A', '10.00', '100.00'),
(90, 'invoince1', 8, 1, 10, 'Vial', '10.00', '100.00'),
(91, 'b', 46, 22, 1, 'N/A', '10.00', '10.00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_misc`
--

CREATE TABLE `tbl_misc` (
  `MiscID` int(11) NOT NULL,
  `Description` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_misc`
--

INSERT INTO `tbl_misc` (`MiscID`, `Description`) VALUES
(1, 'Advances to Supplier'),
(2, 'Analysis Fee'),
(3, 'Deduction to Employee'),
(4, 'Laboratory Fee'),
(5, 'Loading Fee'),
(6, 'Miscellaneous Fee'),
(7, 'Truckscale'),
(8, 'Weighing Fee'),
(9, 'w/ EWT'),
(10, 'w/o EWT'),
(11, 'Others'),
(12, 'Others 1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_misc_payment`
--

CREATE TABLE `tbl_misc_payment` (
  `MiscPaymentID` int(11) NOT NULL,
  `MiscID` int(11) NOT NULL,
  `PaymentID` int(11) NOT NULL,
  `Amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_misc_payment`
--

INSERT INTO `tbl_misc_payment` (`MiscPaymentID`, `MiscID`, `PaymentID`, `Amount`) VALUES
(1, 1, 3, '3.00'),
(2, 12, 3, '2.00'),
(5, 7, 7, '10.00'),
(6, 1, 8, '100.00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_origin`
--

CREATE TABLE `tbl_origin` (
  `OriginID` int(11) NOT NULL,
  `Origin` varchar(100) NOT NULL,
  `Deleted` varchar(5) NOT NULL DEFAULT 'NO'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_origin`
--

INSERT INTO `tbl_origin` (`OriginID`, `Origin`, `Deleted`) VALUES
(1, 'Philippines', 'NO'),
(2, 'South Korea', 'NO'),
(3, 'China', 'NO'),
(4, 'New Zealand', 'NO'),
(5, 'Malaysia', 'YES'),
(6, 'Vietnam', 'NO');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_packaging`
--

CREATE TABLE `tbl_packaging` (
  `PackagingID` int(11) NOT NULL,
  `Packaging` varchar(100) NOT NULL,
  `Divisor` int(11) DEFAULT NULL,
  `Deleted` varchar(5) NOT NULL DEFAULT 'NO'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_packaging`
--

INSERT INTO `tbl_packaging` (`PackagingID`, `Packaging`, `Divisor`, `Deleted`) VALUES
(1, '25 KGS/BAG', 25, 'NO'),
(2, '10 KGS/BAG', 10, 'NO'),
(3, '10 KGS/CARTON', 10, 'NO'),
(4, 'DRUM', 100, 'NO'),
(5, 'GALLON', 4, 'NO'),
(6, '25 KGS/CARTON', 25, 'NO'),
(7, '12 KGS/BUCKET', 12, 'NO'),
(8, '1 TON IBC DRUM', 1000, 'NO'),
(9, 'LITER', 1, 'NO'),
(10, '100 ML/BOTTLE', 100, 'NO'),
(11, '20 KGS/BAG', 20, 'NO'),
(12, '50 ML/VIAL', 50, 'NO'),
(13, '25 KGS/PAIL', 25, 'NO'),
(14, 'KG', 1, 'NO'),
(15, '25 Doses x 10 Vials', 25, 'NO'),
(16, '60 x 100 ML BOTTLE/CTN', 60, 'NO'),
(17, '10 LITER/CARTON', 10, 'NO'),
(18, '1180 Kgs/IBC Drum', 1180, 'NO'),
(19, '25 KGS / BAG', 1, 'NO'),
(21, 'PACKAGING SAMPLE', 0, 'NO'),
(22, 'PACK SAMPLE', 0, 'NO'),
(23, 'PACKAGING SAMPLE 3', 0, 'NO'),
(24, 'Capsule', 0, 'NO'),
(25, 'carton', 100, 'YES'),
(27, '5 KGS/BAG', NULL, 'NO'),
(28, '13 KGS/BAG', NULL, 'NO'),
(29, '12 KGS/BAG', NULL, 'NO'),
(30, '7 KGS/CARTON', NULL, 'NO'),
(31, '3 KGS/CARTON', NULL, 'NO');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_paid`
--

CREATE TABLE `tbl_paid` (
  `PaidID` int(11) NOT NULL,
  `PayableID` int(11) NOT NULL,
  `DatePaid` date NOT NULL,
  `Bank` varchar(100) NOT NULL,
  `AmountPaid` decimal(10,2) NOT NULL,
  `BankCharges` decimal(10,2) NOT NULL,
  `Rate` decimal(10,2) NOT NULL,
  `PHPAmount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_paid`
--

INSERT INTO `tbl_paid` (`PaidID`, `PayableID`, `DatePaid`, `Bank`, `AmountPaid`, `BankCharges`, `Rate`, `PHPAmount`) VALUES
(13, 7, '2018-10-30', 'China Bank', '500.00', '500.00', '1.00', '1000.00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payables`
--

CREATE TABLE `tbl_payables` (
  `PayableID` int(11) NOT NULL,
  `ProformaInvNo` varchar(20) NOT NULL,
  `BankName` varchar(200) NOT NULL,
  `BankAddress` varchar(200) NOT NULL,
  `AccountNumber` varchar(50) NOT NULL,
  `SwiftCode` varchar(20) NOT NULL,
  `IVAN_Number` varchar(20) NOT NULL,
  `Reminder` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_payables`
--

INSERT INTO `tbl_payables` (`PayableID`, `ProformaInvNo`, `BankName`, `BankAddress`, `AccountNumber`, `SwiftCode`, `IVAN_Number`, `Reminder`) VALUES
(7, '1000', 'hjfh', 'fhfhf', 'hgfghf', 'ghfhg', 'hfhgf', 'ghfgh');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payable_deductions`
--

CREATE TABLE `tbl_payable_deductions` (
  `PD_ID` int(11) NOT NULL,
  `Description` varchar(200) NOT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `ProfInvNum` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_payable_deductions`
--

INSERT INTO `tbl_payable_deductions` (`PD_ID`, `Description`, `Amount`, `ProfInvNum`) VALUES
(1, 'Deduction 1', '500.00', '1000');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payee`
--

CREATE TABLE `tbl_payee` (
  `PayeeID` int(11) NOT NULL,
  `PayeeName` varchar(100) NOT NULL,
  `Deleted` varchar(5) NOT NULL DEFAULT 'NO'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_payee`
--

INSERT INTO `tbl_payee` (`PayeeID`, `PayeeName`, `Deleted`) VALUES
(1, '\"ROLE, ROMEO\"', 'NO'),
(2, 'PLDT', 'NO'),
(3, 'DIGITEL MOBILE', 'NO'),
(4, '\"BAAO, ALVIN\"', 'NO'),
(5, '\"ABELLA, RIA JOY\"', 'NO'),
(6, '\"ARANGCON, PETER PAUL\"', 'NO'),
(7, '\"ARRIESGADO, MARIA ROAN\"', 'NO'),
(8, '\"BADE, ALMA\"', 'NO'),
(9, '\"GLOBE TELECOM, INC.\"', 'NO'),
(10, 'MANILA ELECTRIC COMPANY', 'NO'),
(11, '\"ROMAN, CECILIA\"', 'NO'),
(12, 'CommLinked Inc.', 'YES'),
(13, 'Richmonde', 'NO'),
(14, 'CommLinked', 'NO');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payment`
--

CREATE TABLE `tbl_payment` (
  `PaymentID` int(11) NOT NULL,
  `SONumber` int(11) NOT NULL,
  `PR_Number` varchar(10) NOT NULL,
  `PR_Date` date NOT NULL,
  `CR_Number` varchar(10) NOT NULL,
  `CR_Date` date NOT NULL,
  `BankName` varchar(100) NOT NULL,
  `CheckNumber` varchar(50) NOT NULL,
  `CheckDate` date NOT NULL,
  `DateDeposited` date NOT NULL,
  `DateReceived` date NOT NULL,
  `AmountReceived` decimal(10,2) NOT NULL,
  `PostDated` varchar(5) NOT NULL DEFAULT 'NO',
  `Cleared` varchar(5) NOT NULL DEFAULT 'YES'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_payment`
--

INSERT INTO `tbl_payment` (`PaymentID`, `SONumber`, `PR_Number`, `PR_Date`, `CR_Number`, `CR_Date`, `BankName`, `CheckNumber`, `CheckDate`, `DateDeposited`, `DateReceived`, `AmountReceived`, `PostDated`, `Cleared`) VALUES
(3, 1, '12345', '2018-07-20', '12345', '2018-07-20', 'China Bank Savings', '12345', '2018-07-29', '2018-07-20', '2018-07-20', '5.00', 'NO', 'YES'),
(4, 2, '2313123', '2018-07-27', '4232534', '2018-07-27', 'China bank ', '3413544325243', '2018-07-27', '2018-07-17', '2018-07-19', '200.00', 'NO', 'YES'),
(5, 8, '156789', '2018-08-09', '45678', '2018-08-09', 'China bank ', '45678', '2018-08-09', '2018-08-09', '2018-08-09', '7.00', 'NO', 'YES'),
(7, 3, 'fghjk', '2018-11-02', 'fghjkl', '2018-11-02', 'gfhjkl', 'fghgh', '2018-11-01', '2018-11-01', '2018-11-01', '90.00', 'NO', 'YES'),
(8, 9, 'hfhg', '2018-11-02', 'fghfjk', '2018-11-02', 'hgfgh', 'vhfh', '2018-11-01', '2018-11-01', '2018-11-01', '3900.00', 'YES', 'YES'),
(9, 2, 'hfgh', '2018-11-02', 'asdsa', '2018-11-02', 'gfdfg', 'u7567567', '2018-11-01', '2018-11-01', '2018-11-01', '90.00', 'YES', 'YES');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payment_terms`
--

CREATE TABLE `tbl_payment_terms` (
  `PT_ID` int(11) NOT NULL,
  `PaymentTerms` varchar(100) NOT NULL,
  `Deleted` varchar(5) NOT NULL DEFAULT 'NO'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_payment_terms`
--

INSERT INTO `tbl_payment_terms` (`PT_ID`, `PaymentTerms`, `Deleted`) VALUES
(1, 'ADVANCED TELEGRAPHIC', 'NO'),
(2, '10 DAYS FROM DATE OF BILL OF LADING', 'NO'),
(3, '30 DAYS AFTER BILL OF LADING', 'NO'),
(4, '60 DAYS AFTER BILL OF LADING', 'NO'),
(5, 'D/P', 'NO'),
(6, '\"50% DOWNPAYMENT, BALANCE TO BE PAID AFTER 60 DAYS FROM B/L DATE\"', 'NO'),
(7, '10 DAYS UPON RECEIPT OF SHIPPING DOCUMENTS', 'NO'),
(8, 'T/T REMITTANCE AT SIGHT', 'NO'),
(9, 'DRAFT AGAINST ACCEPTANCE 60 DAYS', 'NO'),
(10, 'Kahit kelan mo gusto hehehe', 'YES'),
(11, 'Utang', 'NO');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product`
--

CREATE TABLE `tbl_product` (
  `ProductID` int(11) NOT NULL,
  `ProductName` varchar(200) NOT NULL,
  `Description` varchar(200) DEFAULT NULL,
  `ProductType` int(11) DEFAULT NULL,
  `ProductForm` int(11) DEFAULT NULL,
  `Deleted` varchar(5) NOT NULL DEFAULT 'NO'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_product`
--

INSERT INTO `tbl_product` (`ProductID`, `ProductName`, `Description`, `ProductType`, `ProductForm`, `Deleted`) VALUES
(1, 'BIOPOWDER', 'YUCCA SCHIDIGERA', 2, 4, 'NO'),
(2, 'BIOSTRONG 510 (25kg)', 'ESSENTIAL OILS', 2, 1, 'NO'),
(3, 'CO-BIND', 'TOXIN BINDER', 2, 1, 'NO'),
(4, 'NOPCOZYME II', 'ENZYME', 2, 1, 'NO'),
(5, 'NOPCOZYME BXBG', 'ENZYME', 2, 1, 'NO'),
(6, 'SUISHOT ALL RES', 'VACCINE ', 2, 2, 'NO'),
(7, 'SUISHOT APM-7', 'Vaccines (Biological)', 2, 2, 'NO'),
(8, 'FRESTA F CONC (25kg)', 'ESSENTIAL OILS', 2, 1, 'NO'),
(9, 'COLIMEIJI 10%', 'ANTIBACTERIAL', 2, 1, 'NO'),
(10, 'DIACOXIN SUSPENSION', 'ANTIBACTERIAL', 2, 5, 'NO'),
(11, 'PROPHORCE AC 299', 'ACIDIFIER', 2, 1, 'NO'),
(12, 'LORICAN 25%', 'ANTIBACTERIAL', 2, 2, 'NO'),
(13, 'CITROCLEAN-RM', 'CITREX LIQUID', 1, 2, 'NO'),
(14, 'BIOSTRONG FORTE', 'ESSENTIAL OIL', 2, 1, 'NO'),
(15, 'CHLORFAC 150', 'CTC-Ca Complex', 2, 1, 'NO'),
(16, 'CO-BIND A-Z', 'TOXIN BINDER', 2, 1, 'NO'),
(17, 'CTC 14.2% WS', '*', 2, 3, 'NO'),
(18, 'ENVIRO QS', '*', 2, 1, 'NO'),
(19, 'FLUMYCIN 10%', 'FLORFENICOL', 2, 1, 'NO'),
(20, 'GQ PLUS', '*', 2, 2, 'NO'),
(21, 'HYOSEPTIN 100', 'TIAMULIN 10%', 2, 4, 'NO'),
(22, 'LORICAN G200', 'TILMICOSIN 20%', 2, 1, 'NO'),
(23, 'NOPSTRESS TF', 'VITAMINS & ELECTROLYTES', 2, 3, 'NO'),
(24, 'PIF CHROME (PAIL)', 'CHROMIUM', 2, 1, 'NO'),
(25, 'PROPHORCE 710', '*', 2, 1, 'NO'),
(26, 'PROSID MI 509', '*', 2, 2, 'NO'),
(27, 'ROBISTAT 6.6%', 'ROBENIDINE HCL 6.6%', 2, 1, 'NO'),
(28, 'SALINOMYCIN', '*', 2, 1, 'NO'),
(29, 'SILO HEALTH 104 P', '*', 2, 1, 'NO'),
(30, 'SILO HEALTH 104 H', '*', 2, 2, 'NO'),
(31, 'SILO HEALTH 108 P', '*', 2, 1, 'NO'),
(32, 'TRIMOXAL 40 FG', 'TRIMETHOPRIM', 2, 1, 'NO'),
(33, 'CTC 15%', 'CTC-Ca Complex', 2, 1, 'NO'),
(34, 'CITROCLEAN', 'CITREX LIQUID', 2, 2, 'NO'),
(35, 'PIF CHROME (BAG)', 'CHROMIUM', 2, 1, 'NO'),
(36, 'SILO HEALTH 128 P', '*', 2, 1, 'NO'),
(37, 'BIOSTRONG 510 (10kg)', 'ESSENTIAL OILS', 2, 1, 'NO'),
(38, 'FRESTA F CONC (10kg)', 'ESSENTIAL OIL', 2, 1, 'NO'),
(45, 'PRODUCT SAMPLE', NULL, NULL, NULL, 'NO'),
(46, 'PRODUCT SAMPLE 2', NULL, NULL, NULL, 'NO'),
(47, 'PRODUCT SAMPLE 3', NULL, NULL, NULL, 'NO'),
(48, 'Paracetamol', NULL, NULL, NULL, 'NO'),
(49, 'Biogesic', 'Pantagal sakit ng ulo mo', NULL, NULL, 'YES');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_depot`
--

CREATE TABLE `tbl_product_depot` (
  `ProdDepot_ID` int(11) NOT NULL,
  `WarehouseID` int(11) NOT NULL,
  `ProductCode` varchar(100) NOT NULL,
  `CurrentStock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_product_depot`
--

INSERT INTO `tbl_product_depot` (`ProdDepot_ID`, `WarehouseID`, `ProductCode`, `CurrentStock`) VALUES
(14, 1, 'ROBISTAT 6.6% 25 KGS/BAG', 10),
(15, 1, 'ROBISTAT 6.6% 10 KGS/CARTON', 30),
(16, 1, 'SUISHOT APM-7 10 KGS/CARTON', 0),
(17, 1, 'SUISHOT APM-7 12 KGS/BUCKET', 850),
(18, 1, 'SUISHOT ALL RES GALLON', 920),
(19, 2, 'ROBISTAT 6.6% 10 KGS/CARTON', 890),
(20, 5, 'ROBISTAT 6.6% 10 KGS/CARTON', 1000),
(21, 2, 'ROBISTAT 6.6% 25 KGS/BAG', 950),
(22, 5, 'SUISHOT APM-7 10 KGS/CARTON', 1000),
(23, 4, 'ROBISTAT 6.6% 10 KGS/CARTON', 900),
(24, 4, 'ROBISTAT 6.6% 25 KGS/BAG', 1000),
(25, 4, 'SUISHOT ALL RES GALLON', 1000),
(26, 1, 'SUISHOT ALL RES 10 KGS/BAG', 0),
(27, 1, 'SUISHOT ALL RES 10 KGS/CARTON', 1),
(28, 1, 'SUISHOT APM-7 25 Doses x 10 Vials', 1000),
(29, 3, 'SUISHOT APM-7 12 KGS/BUCKET', 6),
(30, 1, 'SUISHOT ALL RES 20 KGS/BAG', 20),
(31, 1, 'SUISHOT ALL RES 5 KGS/BAG', 10),
(32, 1, 'SUISHOT ALL RES 13 KGS/BAG', 0),
(33, 1, 'SUISHOT ALL RES 12 KGS/BAG', 10),
(34, 1, 'DIACOXIN SUSPENSION 7 KGS/CARTON', 0),
(35, 1, 'DIACOXIN SUSPENSION 3 KGS/CARTON', 4),
(36, 1, 'FRESTA F CONC (25kg) 5 KGS/BAG', 50),
(37, 1, 'FRESTA F CONC (25kg) 100 ML/BOTTLE', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_form`
--

CREATE TABLE `tbl_product_form` (
  `ProductFormID` int(11) NOT NULL,
  `ProductForm` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_product_form`
--

INSERT INTO `tbl_product_form` (`ProductFormID`, `ProductForm`) VALUES
(1, 'POWDER'),
(2, 'LIQUID'),
(3, 'WATER SOLUBLE'),
(4, 'GRANULAR'),
(5, 'SUSPENSION');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_type`
--

CREATE TABLE `tbl_product_type` (
  `ProductTypeID` int(11) NOT NULL,
  `ProductType` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_product_type`
--

INSERT INTO `tbl_product_type` (`ProductTypeID`, `ProductType`) VALUES
(1, 'RAW MATERIALS'),
(2, 'FINISHED PRODUCTS');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rebate`
--

CREATE TABLE `tbl_rebate` (
  `RebateNumber` int(11) NOT NULL,
  `SONumber` int(11) NOT NULL,
  `RebateDate` date NOT NULL,
  `Total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_rebate`
--

INSERT INTO `tbl_rebate` (`RebateNumber`, `SONumber`, `RebateDate`, `Total`) VALUES
(1, 9, '2018-10-26', '1000.00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rebate_bd`
--

CREATE TABLE `tbl_rebate_bd` (
  `RBD_ID` int(11) NOT NULL,
  `RebateNumber` int(11) NOT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `Description` varchar(200) NOT NULL,
  `UnitPrice` decimal(10,2) DEFAULT NULL,
  `Amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_rebate_bd`
--

INSERT INTO `tbl_rebate_bd` (`RBD_ID`, `RebateNumber`, `Quantity`, `Description`, `UnitPrice`, `Amount`) VALUES
(1, 1, 10, 'Rebate', '100.00', '1000.00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_roles`
--

CREATE TABLE `tbl_roles` (
  `RoleID` int(11) NOT NULL,
  `RoleName` varchar(255) NOT NULL,
  `Redirection` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_roles`
--

INSERT INTO `tbl_roles` (`RoleID`, `RoleName`, `Redirection`) VALUES
(1, 'admin', 'records'),
(2, 'finance', ''),
(3, 'sales', ''),
(4, 'accounts and billing', ''),
(5, 'accounting', ''),
(6, 'importation', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sales_order`
--

CREATE TABLE `tbl_sales_order` (
  `SONumber` int(11) NOT NULL,
  `SI_Number` varchar(10) DEFAULT NULL,
  `DR_Number` varchar(10) DEFAULT NULL,
  `SI_Date` date DEFAULT NULL,
  `DR_Date` date DEFAULT NULL,
  `SI_Returned_Date` date DEFAULT NULL,
  `DR_Returned_Date` date DEFAULT NULL,
  `DR_Countered` date DEFAULT NULL,
  `CustomerID` int(11) NOT NULL,
  `Address` varchar(200) NOT NULL,
  `Terms` int(11) NOT NULL,
  `PONumber` varchar(10) NOT NULL,
  `DateCreated` date NOT NULL,
  `TotalAmount` decimal(10,2) NOT NULL,
  `Balance` decimal(10,2) DEFAULT '0.00',
  `DeliveryInstructions` varchar(300) NOT NULL,
  `WarehouseID` int(11) NOT NULL,
  `VerifiedStatus` varchar(5) NOT NULL DEFAULT 'NO',
  `Remarks` varchar(500) DEFAULT NULL,
  `NotedStatus` varchar(20) NOT NULL DEFAULT 'NO',
  `Reason` varchar(150) DEFAULT NULL,
  `ApprovedStatus` varchar(5) NOT NULL DEFAULT 'NO',
  `DeductedStatus` varchar(5) NOT NULL DEFAULT 'NO',
  `DeductedAmount` decimal(10,2) DEFAULT NULL,
  `DebitStatus` varchar(5) NOT NULL DEFAULT 'NO',
  `CreditStatus` varchar(5) NOT NULL DEFAULT 'NO',
  `DebitAmount` decimal(10,2) DEFAULT '0.00',
  `CreditAmount` decimal(10,2) DEFAULT '0.00',
  `BIRType` varchar(10) DEFAULT NULL,
  `RebateAmount` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_sales_order`
--

INSERT INTO `tbl_sales_order` (`SONumber`, `SI_Number`, `DR_Number`, `SI_Date`, `DR_Date`, `SI_Returned_Date`, `DR_Returned_Date`, `DR_Countered`, `CustomerID`, `Address`, `Terms`, `PONumber`, `DateCreated`, `TotalAmount`, `Balance`, `DeliveryInstructions`, `WarehouseID`, `VerifiedStatus`, `Remarks`, `NotedStatus`, `Reason`, `ApprovedStatus`, `DeductedStatus`, `DeductedAmount`, `DebitStatus`, `CreditStatus`, `DebitAmount`, `CreditAmount`, `BIRType`, `RebateAmount`) VALUES
(1, '12346', '12345', '2018-07-20', '2018-07-20', '2018-07-30', '2018-07-11', '2018-07-19', 1, '23RD FLR.JMT CORP. CONDOMINIUM ADB AVE.', 1, '', '2018-07-19', '10.00', '0.00', '', 1, 'YES', 'No balance...', 'YES', NULL, 'NO', 'NO', NULL, 'NO', 'NO', '0.00', '0.00', 'BIR', '0.00'),
(2, '7887', '8986689', '2018-07-20', '2018-07-20', '2018-07-30', '2018-07-30', '2018-07-01', 1, '23RD FLR.JMT CORP. CONDOMINIUM ADB AVE.', 1, '', '2018-07-20', '700.00', '0.00', '', 1, 'YES', 'No balance...', 'YES', NULL, 'NO', 'NO', NULL, 'YES', 'YES', '10.00', '500.00', 'Non BIR', '0.00'),
(3, '3123123', '213213', '2018-10-25', '2018-10-26', '2018-10-25', '2018-10-25', '2018-10-25', 1, '23RD FLR.JMT CORP. CONDOMINIUM ADB AVE.', 1, '', '2018-07-20', '100.00', '0.00', '', 1, 'YES', 'Done', 'YES', NULL, 'NO', 'NO', NULL, 'NO', 'NO', '0.00', '0.00', 'BIR', '0.00'),
(4, NULL, NULL, NULL, NULL, '0000-00-00', '0000-00-00', NULL, 1, '23RD FLR.JMT CORP. CONDOMINIUM ADB AVE.', 3, '', '2018-07-26', '10624.00', '0.00', '', 1, 'YES', 'check po ulet', 'NO', 'wala lang', 'NO', 'NO', NULL, 'NO', 'NO', '0.00', '0.00', NULL, '0.00'),
(5, NULL, NULL, NULL, NULL, '0000-00-00', '0000-00-00', NULL, 1, '23RD FLR.JMT CORP. CONDOMINIUM ADB AVE.', 2, '', '2018-07-26', '100.00', '0.00', '', 1, 'YES', 'Aging is 5 days', 'DISAPPROVED', 'Wala lang', 'NO', 'NO', NULL, 'NO', 'NO', '0.00', '0.00', NULL, '0.00'),
(6, NULL, NULL, NULL, NULL, '0000-00-00', '0000-00-00', NULL, 3, '345 J. TEODORO ST., COR. 10TH AVE.CALOOCAN CITY', 1, '', '2018-07-26', '100.00', '0.00', '', 1, 'NO', NULL, 'NO', NULL, 'NO', 'NO', NULL, 'NO', 'NO', '0.00', '0.00', NULL, '0.00'),
(7, NULL, NULL, NULL, NULL, '0000-00-00', '0000-00-00', NULL, 3, '345 J. TEODORO ST., COR. 10TH AVE.CALOOCAN CITY', 3, '', '2018-07-26', '1000.00', '0.00', '', 2, 'NO', NULL, 'NO', NULL, 'NO', 'NO', NULL, 'NO', 'NO', '0.00', '0.00', NULL, '0.00'),
(8, '234234', '3123213213', '2018-07-30', '2018-07-30', '2018-07-11', '2018-08-09', '2018-07-30', 3, '345 J. TEODORO ST., COR. 10TH AVE.CALOOCAN CITY', 2, '', '2018-07-30', '10.00', '0.00', '', 1, 'YES', 'Approved', 'YES', NULL, 'NO', 'NO', NULL, 'YES', 'YES', '2.00', '4.00', 'Non BIR', '0.00'),
(9, '23423', '1312312', '2018-10-25', '2018-10-25', NULL, NULL, '2018-10-25', 1, '23RD FLR.JMT CORP. CONDOMINIUM ADB AVE.', 1, 'asda', '2018-10-25', '5000.00', '0.00', '', 1, 'YES', 'Accept this', 'YES', NULL, 'NO', 'NO', NULL, 'NO', 'NO', '0.00', '0.00', 'BIR', '1000.00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_so_cmo`
--

CREATE TABLE `tbl_so_cmo` (
  `SO_CMOID` int(11) NOT NULL,
  `SONumber` int(11) NOT NULL,
  `CMO_Name` varchar(200) NOT NULL,
  `Share` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_so_cmo`
--

INSERT INTO `tbl_so_cmo` (`SO_CMOID`, `SONumber`, `CMO_Name`, `Share`) VALUES
(38, 1, 'Sample Data1', 0),
(39, 2, 'Sample Data1', 0),
(40, 3, 'Sample Data1', 0),
(41, 4, 'Sample Data1', 0),
(42, 5, 'Sample Data1', 20),
(43, 5, 'Charisse Mapatac', 20),
(44, 6, 'Josiah Cavitana', 5),
(45, 6, 'Charisse Mapatac', 5),
(46, 7, 'Jaron Austria', 0),
(47, 8, 'Josiah Cavitana', 0),
(48, 9, 'Sample Data1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_so_deductions`
--

CREATE TABLE `tbl_so_deductions` (
  `DeductionID` int(11) NOT NULL,
  `SO_ID` int(11) NOT NULL,
  `Description` varchar(50) NOT NULL,
  `Amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_so_product`
--

CREATE TABLE `tbl_so_product` (
  `SO_ProdID` int(11) NOT NULL,
  `SO_ID` int(11) NOT NULL,
  `ProductCode` varchar(100) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Price` decimal(10,2) NOT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `Remarks` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_so_product`
--

INSERT INTO `tbl_so_product` (`SO_ProdID`, `SO_ID`, `ProductCode`, `Quantity`, `Price`, `Amount`, `Remarks`) VALUES
(38, 1, 'SUISHOT APM-7 12 KGS/BUCKET', 1, '10.00', '10.00', NULL),
(39, 2, 'SUISHOT APM-7 12 KGS/BUCKET', 7, '100.00', '700.00', NULL),
(40, 3, 'SUISHOT APM-7 12 KGS/BUCKET', 10, '10.00', '100.00', NULL),
(41, 4, 'SUISHOT APM-7 25 Doses x 10 Vials', 332, '32.00', '10624.00', NULL),
(42, 5, 'SUISHOT ALL RES 13 KGS/BAG', 10, '10.00', '100.00', NULL),
(43, 6, 'DIACOXIN SUSPENSION 7 KGS/CARTON', 10, '10.00', '100.00', NULL),
(44, 7, 'ROBISTAT 6.6% 10 KGS/CARTON', 10, '100.00', '1000.00', NULL),
(45, 8, 'DIACOXIN SUSPENSION 3 KGS/CARTON', 1, '10.00', '10.00', NULL),
(46, 9, 'DIACOXIN SUSPENSION 3 KGS/CARTON', 5, '1000.00', '5000.00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_supplier`
--

CREATE TABLE `tbl_supplier` (
  `SupplierID` int(11) NOT NULL,
  `CompanyName` varchar(300) NOT NULL,
  `CompanyAddress` varchar(500) DEFAULT NULL,
  `ContactPerson` varchar(200) DEFAULT NULL,
  `ContactNumber` varchar(200) DEFAULT NULL,
  `Deleted` varchar(5) NOT NULL DEFAULT 'NO'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_supplier`
--

INSERT INTO `tbl_supplier` (`SupplierID`, `CompanyName`, `CompanyAddress`, `ContactPerson`, `ContactNumber`, `Deleted`) VALUES
(1, '\"BAJA AGRO INTERNATIONAL, S.A. DE C.V\"', '\"Privada Kino No. 100A-1 Parque Industrial, Mision, Ensanada, B.C. Mexico, B.C. Mexico 22830 \"', 'ALFREDO LOPERENA', '52-646-177-475', 'NO'),
(2, 'DIASHAM RESOURCES Pte. Ltd', '\"1 Gul Street 1, Jurong Singapore 629314\"', 'TUCK ON CHOW', '(65) 6861 2833', 'NO'),
(3, 'CHOONG ANG VACCINE LABORATORIES Co. Ltd', '\"1476-37 Yuseong-daero, Yuseong-gu, Daejeon, Republic of Korea\"', '\"Wonyoung (wonyoung@cavac.co.kr),  Rosa Gwak  (sggwak@cavac.co.kr)\"', 'TEL NO. +82 42 870 0537       FAX +82 42 870 0550', 'NO'),
(4, 'DELACON ', '\"Weissenwolstr.14  4221 Steyregg, Austria\"', 'Gina Medina', '9177232028', 'NO'),
(5, 'ARYSTA HEALTH & NUTRITION SCIENCES CORPORATION', '\"8-1, AKASHI-CHO, CHUO-KU, TOKYO, 104-6591 JAPAN\"', 'MAMIKO ', NULL, 'NO'),
(6, 'PERSTORP', '\"Perstorp Waspik BV, the Netherlands\"', 'ALLAN CAPSA', '+31 416 317 700', 'NO'),
(7, 'QILU ANIMAL HEALTH PRODUCTS CO. LTD', '\"No. 243 Gongye North Road, Jinan, Shandong, China\"', 'Anny Lee', '86-531-83127950', 'NO'),
(8, 'RHONE MALAYSIA Sdn Bhd', '\"Selangor, Malaysia\"', 'Dr. Hang Chern Lim', '0063 7873 7355', 'NO'),
(20, 'Josiah Trading', NULL, NULL, NULL, 'NO'),
(21, 'JOSIAH INTERNATIONAL TRADING', NULL, NULL, NULL, 'NO'),
(22, 'JOSIAH INTERNATIONAL TRADING PH', NULL, NULL, NULL, 'NO'),
(23, 'MJ Sarmiento', NULL, NULL, NULL, 'NO'),
(24, 'MJ Sarmient', 'Marikina', 'MJ Sarmiento', '09434202317', 'YES'),
(25, 'BAJA AGRO INTERNATIONAL, S.A. DE C.V', NULL, NULL, NULL, 'NO');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_terms`
--

CREATE TABLE `tbl_terms` (
  `Term_ID` int(11) NOT NULL,
  `DaysLabel` varchar(50) NOT NULL,
  `Days` int(11) DEFAULT NULL,
  `Deleted` varchar(5) NOT NULL DEFAULT 'NO'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_terms`
--

INSERT INTO `tbl_terms` (`Term_ID`, `DaysLabel`, `Days`, `Deleted`) VALUES
(1, '15 DAYS', 15, 'NO'),
(2, '30 DAYS', 30, 'NO'),
(3, '1 MONTH', 30, 'NO'),
(4, '2 WEEKS', 14, 'NO'),
(5, '60 DAYS', 60, 'NO'),
(6, '7 DAYS', 7, 'NO'),
(8, '8 DAYS', NULL, 'NO'),
(9, '1 YEAR', 365, 'NO'),
(10, '9 Days', 9, 'YES');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transfer`
--

CREATE TABLE `tbl_transfer` (
  `TransferID` int(11) NOT NULL,
  `TransferDate` date NOT NULL,
  `FromWarehouse` int(11) NOT NULL,
  `ToWarehouse` int(11) NOT NULL,
  `ShippingLine` varchar(50) DEFAULT NULL,
  `Remarks` varchar(5) NOT NULL DEFAULT 'NO'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_transfer`
--

INSERT INTO `tbl_transfer` (`TransferID`, `TransferDate`, `FromWarehouse`, `ToWarehouse`, `ShippingLine`, `Remarks`) VALUES
(5, '2018-06-08', 1, 4, NULL, 'YES'),
(6, '2018-06-08', 4, 1, NULL, 'YES'),
(7, '2018-06-15', 1, 2, NULL, 'YES'),
(9, '2018-07-18', 1, 3, 'Genesis', 'YES');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transferred_prod`
--

CREATE TABLE `tbl_transferred_prod` (
  `TP_ID` int(11) NOT NULL,
  `TransferID` int(11) NOT NULL,
  `ProductCode` varchar(100) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Remarks` varchar(100) DEFAULT NULL,
  `Action` varchar(30) DEFAULT NULL,
  `QuantityRem` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_transferred_prod`
--

INSERT INTO `tbl_transferred_prod` (`TP_ID`, `TransferID`, `ProductCode`, `Quantity`, `Remarks`, `Action`, `QuantityRem`) VALUES
(5, 5, 'ROBISTAT 6.6% 10 KGS/CARTON', 5, 'Spoiled', 'Disposed', 5),
(6, 5, 'ROBISTAT 6.6% 25 KGS/BAG', 20, 'Excess', 'Returned to Inventory', 10),
(7, 5, 'SUISHOT ALL RES GALLON', 10, NULL, NULL, NULL),
(8, 6, 'SUISHOT ALL RES GALLON', 5, 'Spoiled', 'Disposed', 5),
(9, 7, 'ROBISTAT 6.6% 10 KGS/CARTON', 930, 'Excess', 'Returned to Inventory', 30),
(10, 9, 'SUISHOT APM-7 12 KGS/BUCKET', 6, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `UserID` int(11) NOT NULL,
  `RoleID` int(11) NOT NULL,
  `LastName` varchar(100) NOT NULL,
  `FirstName` varchar(100) NOT NULL,
  `MiddleName` varchar(100) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `Deleted` varchar(5) NOT NULL DEFAULT 'NO'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`UserID`, `RoleID`, `LastName`, `FirstName`, `MiddleName`, `Username`, `Password`, `Deleted`) VALUES
(1, 1, 'RULE', 'EDGAR', 'R', 'edgar', 'NULL', 'NO'),
(2, 1, 'ROMAN', 'CECILIA', 'M', 'cecille', 'agrimate', 'NO'),
(3, 1, 'ABELLA', 'RIA JOY', 'BIALZA', 'eujyll', 'jtjbgwbo', 'NO'),
(4, 1, 'MORENO', 'ALMA', 'ALMASCO', 'alma', 'agrimate', 'NO'),
(5, 1, 'BIGAYAN', 'JEMELIE GEMMA', 'FLORES', 'jemeliegem', 'agrimate', 'NO'),
(6, 1, 'GALLARDO', 'MA. LUISA JAYJAY', 'VALERA', 'jayjay', 'agrimate', 'NO'),
(7, 1, 'DELA CRUZ', 'JOANNE', 'V', 'jhoanne', 'agrimate', 'NO'),
(8, 1, 'ADMIN', 'ADMIN', 'ADMIN', 'RNZ', 'ftd./71p', 'NO'),
(9, 1, 'ADMIN', 'ADMIN', 'ADMIN', 'marc', 'ecplc3223', 'NO'),
(10, 1, 'ROTINA', 'MELANIE', 'LLANDER', 'mhel', 'agrimate', 'NO'),
(11, 1, 'RULE-ORDONEZ', 'BERNADETTE', '', 'BEM', 'agrimate', 'NO'),
(12, 1, 'Cavitana', 'Josiah', 'Perez', 'josiah', 'josiah', 'NO');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_warehouse`
--

CREATE TABLE `tbl_warehouse` (
  `WarehouseID` int(11) NOT NULL,
  `WarehouseName` varchar(100) NOT NULL,
  `Location` varchar(200) NOT NULL,
  `Deleted` varchar(5) NOT NULL DEFAULT 'NO'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_warehouse`
--

INSERT INTO `tbl_warehouse` (`WarehouseID`, `WarehouseName`, `Location`, `Deleted`) VALUES
(1, 'MANILA', 'CALOOCAN CITY', 'NO'),
(2, 'BATANGAS', 'BATANGAS', 'NO'),
(3, 'CAGAYAN DE ORO', 'CAGAYAN DE ORO', 'NO'),
(4, 'CEBU', 'CEBU', 'NO'),
(5, 'GEN. SANTOS CITY', 'GEN. SANTOS CITY', 'NO'),
(6, 'Pasig City', 'Bambang, Pasig City', 'YES');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_account_title`
--
ALTER TABLE `tbl_account_title`
  ADD PRIMARY KEY (`AT_ID`);

--
-- Indexes for table `tbl_actual_product`
--
ALTER TABLE `tbl_actual_product`
  ADD PRIMARY KEY (`ProductCode`),
  ADD UNIQUE KEY `ProdCodeID` (`ProdCodeID`);

--
-- Indexes for table `tbl_actual_prod_beg_inv`
--
ALTER TABLE `tbl_actual_prod_beg_inv`
  ADD PRIMARY KEY (`BegInvID`),
  ADD KEY `WarehouseID` (`WarehouseID`),
  ADD KEY `ProductCode` (`ProductCode`);

--
-- Indexes for table `tbl_ap`
--
ALTER TABLE `tbl_ap`
  ADD PRIMARY KEY (`AP_ID`),
  ADD UNIQUE KEY `APRefNumber` (`APRefNumber`),
  ADD KEY `Payee` (`Payee`),
  ADD KEY `Company` (`Company`);

--
-- Indexes for table `tbl_ap_particular`
--
ALTER TABLE `tbl_ap_particular`
  ADD PRIMARY KEY (`AP_ParticularID`),
  ADD KEY `AccountTitle` (`AccountTitle`),
  ADD KEY `AP_ID` (`AP_ID`);

--
-- Indexes for table `tbl_business_style`
--
ALTER TABLE `tbl_business_style`
  ADD PRIMARY KEY (`BS_ID`);

--
-- Indexes for table `tbl_cmo`
--
ALTER TABLE `tbl_cmo`
  ADD PRIMARY KEY (`CMO_ID`);

--
-- Indexes for table `tbl_cmo_cust`
--
ALTER TABLE `tbl_cmo_cust`
  ADD PRIMARY KEY (`CC_ID`),
  ADD KEY `CMO_ID` (`CMO_ID`),
  ADD KEY `CustomerID` (`CustomerID`);

--
-- Indexes for table `tbl_company`
--
ALTER TABLE `tbl_company`
  ADD PRIMARY KEY (`CompanyID`);

--
-- Indexes for table `tbl_credit`
--
ALTER TABLE `tbl_credit`
  ADD PRIMARY KEY (`MemoNumber`),
  ADD KEY `SONumber` (`SONumber`);

--
-- Indexes for table `tbl_credit_bd`
--
ALTER TABLE `tbl_credit_bd`
  ADD PRIMARY KEY (`CBD_ID`),
  ADD KEY `MemoNumber` (`MemoNumber`);

--
-- Indexes for table `tbl_customers`
--
ALTER TABLE `tbl_customers`
  ADD PRIMARY KEY (`CustomerID`),
  ADD KEY `BusinessStyle` (`BusinessStyle`);

--
-- Indexes for table `tbl_debit`
--
ALTER TABLE `tbl_debit`
  ADD PRIMARY KEY (`MemoNumber`),
  ADD KEY `SONumber` (`SONumber`);

--
-- Indexes for table `tbl_debit_bd`
--
ALTER TABLE `tbl_debit_bd`
  ADD PRIMARY KEY (`DBD_ID`),
  ADD KEY `MemoNumber` (`MemoNumber`);

--
-- Indexes for table `tbl_importation`
--
ALTER TABLE `tbl_importation`
  ADD PRIMARY KEY (`ProformaInvNo`),
  ADD KEY `SupplierID` (`SupplierID`),
  ADD KEY `PaymentTerm` (`PaymentTerm`),
  ADD KEY `Origin` (`Origin`);

--
-- Indexes for table `tbl_imp_breakdown`
--
ALTER TABLE `tbl_imp_breakdown`
  ADD PRIMARY KEY (`ImpBD_ID`),
  ADD KEY `Imp_ProdID` (`Imp_ProdID`),
  ADD KEY `ProductCode` (`ProductCode`);

--
-- Indexes for table `tbl_imp_docs`
--
ALTER TABLE `tbl_imp_docs`
  ADD PRIMARY KEY (`ImpDocs_ID`),
  ADD KEY `ProformaInvNo` (`ProformaInvNo`);

--
-- Indexes for table `tbl_imp_product`
--
ALTER TABLE `tbl_imp_product`
  ADD PRIMARY KEY (`ImpProd_ID`),
  ADD KEY `ProformaInvNo` (`ProformaInvNo`),
  ADD KEY `ProductID` (`ProductID`),
  ADD KEY `PackagingID` (`PackagingID`);

--
-- Indexes for table `tbl_misc`
--
ALTER TABLE `tbl_misc`
  ADD PRIMARY KEY (`MiscID`);

--
-- Indexes for table `tbl_misc_payment`
--
ALTER TABLE `tbl_misc_payment`
  ADD PRIMARY KEY (`MiscPaymentID`),
  ADD KEY `MiscID` (`MiscID`),
  ADD KEY `PaymentID` (`PaymentID`);

--
-- Indexes for table `tbl_origin`
--
ALTER TABLE `tbl_origin`
  ADD PRIMARY KEY (`OriginID`);

--
-- Indexes for table `tbl_packaging`
--
ALTER TABLE `tbl_packaging`
  ADD PRIMARY KEY (`PackagingID`);

--
-- Indexes for table `tbl_paid`
--
ALTER TABLE `tbl_paid`
  ADD PRIMARY KEY (`PaidID`),
  ADD KEY `PayableID` (`PayableID`);

--
-- Indexes for table `tbl_payables`
--
ALTER TABLE `tbl_payables`
  ADD PRIMARY KEY (`PayableID`),
  ADD KEY `ProformaInvNo` (`ProformaInvNo`);

--
-- Indexes for table `tbl_payable_deductions`
--
ALTER TABLE `tbl_payable_deductions`
  ADD PRIMARY KEY (`PD_ID`),
  ADD KEY `ProfInvNum` (`ProfInvNum`);

--
-- Indexes for table `tbl_payee`
--
ALTER TABLE `tbl_payee`
  ADD PRIMARY KEY (`PayeeID`);

--
-- Indexes for table `tbl_payment`
--
ALTER TABLE `tbl_payment`
  ADD PRIMARY KEY (`PaymentID`),
  ADD KEY `SONumber` (`SONumber`);

--
-- Indexes for table `tbl_payment_terms`
--
ALTER TABLE `tbl_payment_terms`
  ADD PRIMARY KEY (`PT_ID`);

--
-- Indexes for table `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`ProductID`),
  ADD KEY `ProductForm` (`ProductForm`),
  ADD KEY `ProductType` (`ProductType`);

--
-- Indexes for table `tbl_product_depot`
--
ALTER TABLE `tbl_product_depot`
  ADD PRIMARY KEY (`ProdDepot_ID`),
  ADD KEY `WarehouseID` (`WarehouseID`),
  ADD KEY `ProductCode` (`ProductCode`);

--
-- Indexes for table `tbl_product_form`
--
ALTER TABLE `tbl_product_form`
  ADD PRIMARY KEY (`ProductFormID`);

--
-- Indexes for table `tbl_product_type`
--
ALTER TABLE `tbl_product_type`
  ADD PRIMARY KEY (`ProductTypeID`);

--
-- Indexes for table `tbl_rebate`
--
ALTER TABLE `tbl_rebate`
  ADD PRIMARY KEY (`RebateNumber`),
  ADD KEY `SONumber` (`SONumber`);

--
-- Indexes for table `tbl_rebate_bd`
--
ALTER TABLE `tbl_rebate_bd`
  ADD PRIMARY KEY (`RBD_ID`),
  ADD KEY `RebateNumber` (`RebateNumber`);

--
-- Indexes for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  ADD PRIMARY KEY (`RoleID`);

--
-- Indexes for table `tbl_sales_order`
--
ALTER TABLE `tbl_sales_order`
  ADD PRIMARY KEY (`SONumber`),
  ADD KEY `CustomerID` (`CustomerID`),
  ADD KEY `Terms` (`Terms`),
  ADD KEY `WarehouseID` (`WarehouseID`);

--
-- Indexes for table `tbl_so_cmo`
--
ALTER TABLE `tbl_so_cmo`
  ADD PRIMARY KEY (`SO_CMOID`),
  ADD KEY `SONumber` (`SONumber`),
  ADD KEY `CMO_ID` (`CMO_Name`) USING BTREE;

--
-- Indexes for table `tbl_so_deductions`
--
ALTER TABLE `tbl_so_deductions`
  ADD PRIMARY KEY (`DeductionID`),
  ADD KEY `SO_ID` (`SO_ID`);

--
-- Indexes for table `tbl_so_product`
--
ALTER TABLE `tbl_so_product`
  ADD PRIMARY KEY (`SO_ProdID`),
  ADD KEY `ProductCode` (`ProductCode`),
  ADD KEY `SO_ID` (`SO_ID`);

--
-- Indexes for table `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  ADD PRIMARY KEY (`SupplierID`);

--
-- Indexes for table `tbl_terms`
--
ALTER TABLE `tbl_terms`
  ADD PRIMARY KEY (`Term_ID`);

--
-- Indexes for table `tbl_transfer`
--
ALTER TABLE `tbl_transfer`
  ADD PRIMARY KEY (`TransferID`),
  ADD KEY `ToWarehouse` (`ToWarehouse`),
  ADD KEY `FromWarehouse` (`FromWarehouse`) USING BTREE;

--
-- Indexes for table `tbl_transferred_prod`
--
ALTER TABLE `tbl_transferred_prod`
  ADD PRIMARY KEY (`TP_ID`),
  ADD KEY `TransferID` (`TransferID`),
  ADD KEY `ProductCode` (`ProductCode`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`UserID`),
  ADD KEY `RoleID` (`RoleID`);

--
-- Indexes for table `tbl_warehouse`
--
ALTER TABLE `tbl_warehouse`
  ADD PRIMARY KEY (`WarehouseID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_account_title`
--
ALTER TABLE `tbl_account_title`
  MODIFY `AT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_actual_product`
--
ALTER TABLE `tbl_actual_product`
  MODIFY `ProdCodeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_actual_prod_beg_inv`
--
ALTER TABLE `tbl_actual_prod_beg_inv`
  MODIFY `BegInvID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tbl_ap`
--
ALTER TABLE `tbl_ap`
  MODIFY `AP_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_ap_particular`
--
ALTER TABLE `tbl_ap_particular`
  MODIFY `AP_ParticularID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_business_style`
--
ALTER TABLE `tbl_business_style`
  MODIFY `BS_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_cmo`
--
ALTER TABLE `tbl_cmo`
  MODIFY `CMO_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_cmo_cust`
--
ALTER TABLE `tbl_cmo_cust`
  MODIFY `CC_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `tbl_company`
--
ALTER TABLE `tbl_company`
  MODIFY `CompanyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_credit`
--
ALTER TABLE `tbl_credit`
  MODIFY `MemoNumber` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_credit_bd`
--
ALTER TABLE `tbl_credit_bd`
  MODIFY `CBD_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_customers`
--
ALTER TABLE `tbl_customers`
  MODIFY `CustomerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `tbl_debit`
--
ALTER TABLE `tbl_debit`
  MODIFY `MemoNumber` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_debit_bd`
--
ALTER TABLE `tbl_debit_bd`
  MODIFY `DBD_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_imp_breakdown`
--
ALTER TABLE `tbl_imp_breakdown`
  MODIFY `ImpBD_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_imp_docs`
--
ALTER TABLE `tbl_imp_docs`
  MODIFY `ImpDocs_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_imp_product`
--
ALTER TABLE `tbl_imp_product`
  MODIFY `ImpProd_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `tbl_misc`
--
ALTER TABLE `tbl_misc`
  MODIFY `MiscID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_misc_payment`
--
ALTER TABLE `tbl_misc_payment`
  MODIFY `MiscPaymentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_origin`
--
ALTER TABLE `tbl_origin`
  MODIFY `OriginID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_packaging`
--
ALTER TABLE `tbl_packaging`
  MODIFY `PackagingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `tbl_paid`
--
ALTER TABLE `tbl_paid`
  MODIFY `PaidID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_payables`
--
ALTER TABLE `tbl_payables`
  MODIFY `PayableID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_payable_deductions`
--
ALTER TABLE `tbl_payable_deductions`
  MODIFY `PD_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_payee`
--
ALTER TABLE `tbl_payee`
  MODIFY `PayeeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_payment`
--
ALTER TABLE `tbl_payment`
  MODIFY `PaymentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_payment_terms`
--
ALTER TABLE `tbl_payment_terms`
  MODIFY `PT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `tbl_product_depot`
--
ALTER TABLE `tbl_product_depot`
  MODIFY `ProdDepot_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `tbl_product_form`
--
ALTER TABLE `tbl_product_form`
  MODIFY `ProductFormID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_product_type`
--
ALTER TABLE `tbl_product_type`
  MODIFY `ProductTypeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_rebate`
--
ALTER TABLE `tbl_rebate`
  MODIFY `RebateNumber` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_rebate_bd`
--
ALTER TABLE `tbl_rebate_bd`
  MODIFY `RBD_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  MODIFY `RoleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_sales_order`
--
ALTER TABLE `tbl_sales_order`
  MODIFY `SONumber` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_so_cmo`
--
ALTER TABLE `tbl_so_cmo`
  MODIFY `SO_CMOID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `tbl_so_deductions`
--
ALTER TABLE `tbl_so_deductions`
  MODIFY `DeductionID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_so_product`
--
ALTER TABLE `tbl_so_product`
  MODIFY `SO_ProdID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  MODIFY `SupplierID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tbl_terms`
--
ALTER TABLE `tbl_terms`
  MODIFY `Term_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_transfer`
--
ALTER TABLE `tbl_transfer`
  MODIFY `TransferID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_transferred_prod`
--
ALTER TABLE `tbl_transferred_prod`
  MODIFY `TP_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_warehouse`
--
ALTER TABLE `tbl_warehouse`
  MODIFY `WarehouseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_actual_prod_beg_inv`
--
ALTER TABLE `tbl_actual_prod_beg_inv`
  ADD CONSTRAINT `tbl_actual_prod_beg_inv_ibfk_1` FOREIGN KEY (`WarehouseID`) REFERENCES `tbl_warehouse` (`WarehouseID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_actual_prod_beg_inv_ibfk_2` FOREIGN KEY (`ProductCode`) REFERENCES `tbl_actual_product` (`ProductCode`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_ap`
--
ALTER TABLE `tbl_ap`
  ADD CONSTRAINT `tbl_ap_ibfk_1` FOREIGN KEY (`Payee`) REFERENCES `tbl_payee` (`PayeeID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_ap_ibfk_2` FOREIGN KEY (`Company`) REFERENCES `tbl_company` (`CompanyID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_ap_particular`
--
ALTER TABLE `tbl_ap_particular`
  ADD CONSTRAINT `tbl_ap_particular_ibfk_1` FOREIGN KEY (`AccountTitle`) REFERENCES `tbl_account_title` (`AT_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_ap_particular_ibfk_2` FOREIGN KEY (`AP_ID`) REFERENCES `tbl_ap` (`AP_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_cmo_cust`
--
ALTER TABLE `tbl_cmo_cust`
  ADD CONSTRAINT `tbl_cmo_cust_ibfk_1` FOREIGN KEY (`CMO_ID`) REFERENCES `tbl_cmo` (`CMO_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_cmo_cust_ibfk_2` FOREIGN KEY (`CustomerID`) REFERENCES `tbl_customers` (`CustomerID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_credit`
--
ALTER TABLE `tbl_credit`
  ADD CONSTRAINT `tbl_credit_ibfk_1` FOREIGN KEY (`SONumber`) REFERENCES `tbl_sales_order` (`SONumber`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_credit_bd`
--
ALTER TABLE `tbl_credit_bd`
  ADD CONSTRAINT `tbl_credit_bd_ibfk_1` FOREIGN KEY (`MemoNumber`) REFERENCES `tbl_credit` (`MemoNumber`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_customers`
--
ALTER TABLE `tbl_customers`
  ADD CONSTRAINT `tbl_customers_ibfk_1` FOREIGN KEY (`BusinessStyle`) REFERENCES `tbl_business_style` (`BS_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_debit`
--
ALTER TABLE `tbl_debit`
  ADD CONSTRAINT `tbl_debit_ibfk_1` FOREIGN KEY (`SONumber`) REFERENCES `tbl_sales_order` (`SONumber`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_debit_bd`
--
ALTER TABLE `tbl_debit_bd`
  ADD CONSTRAINT `tbl_debit_bd_ibfk_1` FOREIGN KEY (`MemoNumber`) REFERENCES `tbl_debit` (`MemoNumber`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_importation`
--
ALTER TABLE `tbl_importation`
  ADD CONSTRAINT `tbl_importation_ibfk_1` FOREIGN KEY (`PaymentTerm`) REFERENCES `tbl_payment_terms` (`PT_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_importation_ibfk_2` FOREIGN KEY (`SupplierID`) REFERENCES `tbl_supplier` (`SupplierID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_importation_ibfk_3` FOREIGN KEY (`Origin`) REFERENCES `tbl_origin` (`OriginID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_imp_breakdown`
--
ALTER TABLE `tbl_imp_breakdown`
  ADD CONSTRAINT `tbl_imp_breakdown_ibfk_1` FOREIGN KEY (`Imp_ProdID`) REFERENCES `tbl_imp_product` (`ImpProd_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_imp_breakdown_ibfk_2` FOREIGN KEY (`ProductCode`) REFERENCES `tbl_actual_product` (`ProductCode`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_imp_docs`
--
ALTER TABLE `tbl_imp_docs`
  ADD CONSTRAINT `tbl_imp_docs_ibfk_1` FOREIGN KEY (`ProformaInvNo`) REFERENCES `tbl_importation` (`ProformaInvNo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_imp_product`
--
ALTER TABLE `tbl_imp_product`
  ADD CONSTRAINT `tbl_imp_product_ibfk_1` FOREIGN KEY (`ProformaInvNo`) REFERENCES `tbl_importation` (`ProformaInvNo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_imp_product_ibfk_2` FOREIGN KEY (`PackagingID`) REFERENCES `tbl_packaging` (`PackagingID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_imp_product_ibfk_3` FOREIGN KEY (`ProductID`) REFERENCES `tbl_product` (`ProductID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_misc_payment`
--
ALTER TABLE `tbl_misc_payment`
  ADD CONSTRAINT `tbl_misc_payment_ibfk_1` FOREIGN KEY (`MiscID`) REFERENCES `tbl_misc` (`MiscID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_misc_payment_ibfk_2` FOREIGN KEY (`PaymentID`) REFERENCES `tbl_payment` (`PaymentID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_paid`
--
ALTER TABLE `tbl_paid`
  ADD CONSTRAINT `tbl_paid_ibfk_1` FOREIGN KEY (`PayableID`) REFERENCES `tbl_payables` (`PayableID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_payables`
--
ALTER TABLE `tbl_payables`
  ADD CONSTRAINT `tbl_payables_ibfk_1` FOREIGN KEY (`ProformaInvNo`) REFERENCES `tbl_importation` (`ProformaInvNo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_payable_deductions`
--
ALTER TABLE `tbl_payable_deductions`
  ADD CONSTRAINT `tbl_payable_deductions_ibfk_1` FOREIGN KEY (`ProfInvNum`) REFERENCES `tbl_importation` (`ProformaInvNo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_payment`
--
ALTER TABLE `tbl_payment`
  ADD CONSTRAINT `tbl_payment_ibfk_1` FOREIGN KEY (`SONumber`) REFERENCES `tbl_sales_order` (`SONumber`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD CONSTRAINT `tbl_product_ibfk_1` FOREIGN KEY (`ProductForm`) REFERENCES `tbl_product_form` (`ProductFormID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_product_ibfk_2` FOREIGN KEY (`ProductType`) REFERENCES `tbl_product_type` (`ProductTypeID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_product_depot`
--
ALTER TABLE `tbl_product_depot`
  ADD CONSTRAINT `tbl_product_depot_ibfk_1` FOREIGN KEY (`WarehouseID`) REFERENCES `tbl_warehouse` (`WarehouseID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_product_depot_ibfk_2` FOREIGN KEY (`ProductCode`) REFERENCES `tbl_actual_product` (`ProductCode`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_rebate`
--
ALTER TABLE `tbl_rebate`
  ADD CONSTRAINT `tbl_rebate_ibfk_1` FOREIGN KEY (`SONumber`) REFERENCES `tbl_sales_order` (`SONumber`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_rebate_bd`
--
ALTER TABLE `tbl_rebate_bd`
  ADD CONSTRAINT `tbl_rebate_bd_ibfk_1` FOREIGN KEY (`RebateNumber`) REFERENCES `tbl_rebate` (`RebateNumber`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_sales_order`
--
ALTER TABLE `tbl_sales_order`
  ADD CONSTRAINT `tbl_sales_order_ibfk_1` FOREIGN KEY (`CustomerID`) REFERENCES `tbl_customers` (`CustomerID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_sales_order_ibfk_2` FOREIGN KEY (`Terms`) REFERENCES `tbl_terms` (`Term_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_sales_order_ibfk_3` FOREIGN KEY (`WarehouseID`) REFERENCES `tbl_warehouse` (`WarehouseID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_so_cmo`
--
ALTER TABLE `tbl_so_cmo`
  ADD CONSTRAINT `tbl_so_cmo_ibfk_2` FOREIGN KEY (`SONumber`) REFERENCES `tbl_sales_order` (`SONumber`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_so_deductions`
--
ALTER TABLE `tbl_so_deductions`
  ADD CONSTRAINT `tbl_so_deductions_ibfk_1` FOREIGN KEY (`SO_ID`) REFERENCES `tbl_sales_order` (`SONumber`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_so_product`
--
ALTER TABLE `tbl_so_product`
  ADD CONSTRAINT `tbl_so_product_ibfk_1` FOREIGN KEY (`ProductCode`) REFERENCES `tbl_actual_product` (`ProductCode`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_so_product_ibfk_2` FOREIGN KEY (`SO_ID`) REFERENCES `tbl_sales_order` (`SONumber`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_transfer`
--
ALTER TABLE `tbl_transfer`
  ADD CONSTRAINT `tbl_transfer_ibfk_1` FOREIGN KEY (`FromWarehouse`) REFERENCES `tbl_warehouse` (`WarehouseID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_transfer_ibfk_2` FOREIGN KEY (`ToWarehouse`) REFERENCES `tbl_warehouse` (`WarehouseID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_transferred_prod`
--
ALTER TABLE `tbl_transferred_prod`
  ADD CONSTRAINT `tbl_transferred_prod_ibfk_1` FOREIGN KEY (`ProductCode`) REFERENCES `tbl_actual_product` (`ProductCode`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_transferred_prod_ibfk_2` FOREIGN KEY (`TransferID`) REFERENCES `tbl_transfer` (`TransferID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD CONSTRAINT `tbl_users_ibfk_1` FOREIGN KEY (`RoleID`) REFERENCES `tbl_roles` (`RoleID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
