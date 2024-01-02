-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 20, 2022 at 09:17 AM
-- Server version: 10.3.34-MariaDB-0ubuntu0.20.04.1
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `billing`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_history`
--

CREATE TABLE `admin_history` (
  `id` int(11) NOT NULL,
  `admin_uid` int(11) DEFAULT NULL,
  `ip` varchar(25) DEFAULT NULL,
  `checkintime` datetime DEFAULT NULL,
  `checkouttime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_history`
--

INSERT INTO `admin_history` (`id`, `admin_uid`, `ip`, `checkintime`, `checkouttime`) VALUES
(1, 1, NULL, '2022-03-19 18:24:02', NULL),
(2, 1, NULL, '2022-03-19 18:25:16', NULL),
(3, 1, NULL, '2022-03-20 09:29:36', NULL),
(4, 1, NULL, '2022-03-26 08:33:32', NULL),
(5, 1, NULL, '2022-03-26 08:41:12', NULL),
(6, 1, NULL, '2022-03-26 10:53:19', NULL),
(7, 1, NULL, '2022-03-29 13:20:48', '2022-03-29 13:22:09'),
(8, 1, NULL, '2022-03-29 13:22:29', '2022-03-29 13:23:04'),
(9, 1, NULL, '2022-03-29 13:23:08', NULL),
(10, 1, NULL, '2022-06-22 04:41:13', '2022-06-22 04:41:56'),
(11, 1, NULL, '2022-06-22 04:43:54', NULL),
(12, 1, NULL, '2022-06-22 04:54:20', '2022-06-22 05:07:11'),
(13, 1, NULL, '2022-06-22 05:05:18', '2022-06-22 05:07:04'),
(14, 1, NULL, '2022-06-22 05:12:42', NULL),
(15, 1, NULL, '2022-06-27 06:48:36', NULL),
(16, 1, NULL, '2022-06-27 07:08:06', '2022-06-27 07:18:55'),
(17, 1, NULL, '2022-06-27 07:19:05', NULL),
(18, 1, NULL, '2022-06-27 09:57:56', '2022-06-27 14:32:20'),
(19, 1, NULL, '2022-06-27 14:41:51', NULL),
(20, 1, NULL, '2022-06-28 11:40:21', '2022-06-28 12:59:51'),
(21, 1, NULL, '2022-06-28 12:59:55', NULL),
(22, 1, NULL, '2022-06-28 14:09:49', '2022-06-28 14:54:10'),
(23, 1, NULL, '2022-06-29 08:21:13', '2022-06-29 08:53:42'),
(24, 1, NULL, '2022-06-29 11:59:31', '2022-06-29 13:31:08'),
(25, 1, NULL, '2022-06-29 13:32:08', '2022-06-29 13:57:49'),
(26, 1, NULL, '2022-06-29 14:06:42', '2022-06-29 14:50:34'),
(27, 1, NULL, '2022-06-29 14:50:40', NULL),
(28, 1, NULL, '2022-06-30 08:27:21', '2022-06-30 08:37:37'),
(29, 1, NULL, '2022-06-30 08:40:37', '2022-06-30 08:38:01'),
(30, 1, NULL, '2022-06-30 09:54:40', NULL),
(31, 1, NULL, '2022-06-30 11:27:13', '2022-06-30 11:42:30'),
(32, 1, NULL, '2022-06-30 12:15:09', NULL),
(33, 1, NULL, '2022-06-30 13:21:31', '2022-06-30 13:24:41'),
(34, 1, NULL, '2022-06-30 13:24:44', '2022-06-30 13:36:07'),
(35, 1, NULL, '2022-07-01 06:43:23', '2022-07-01 06:47:00'),
(36, 1, NULL, '2022-07-02 06:48:53', '2022-07-02 07:36:45'),
(37, 1, NULL, '2022-07-05 12:37:57', NULL),
(38, 1, NULL, '2022-07-13 09:17:47', '2022-07-13 09:18:45'),
(39, 1, NULL, '2022-07-13 09:19:12', NULL),
(40, 1, NULL, '2022-07-13 11:00:25', '2022-07-13 11:00:33'),
(41, 1, NULL, '2022-07-13 11:02:34', '2022-07-13 11:06:29'),
(42, 1, NULL, '2022-07-13 11:14:47', '2022-07-13 11:15:26'),
(43, 1, NULL, '2022-07-13 11:21:03', '2022-07-13 11:37:16'),
(44, 1, NULL, '2022-07-13 11:22:34', NULL),
(45, 1, NULL, '2022-07-13 11:56:18', NULL),
(46, 1, NULL, '2022-07-20 12:53:18', NULL),
(47, 1, NULL, '2022-07-20 12:55:48', '2022-07-20 12:57:36'),
(48, 1, NULL, '2022-07-23 03:27:09', NULL),
(49, 1, NULL, '2022-07-23 05:04:20', NULL),
(50, 1, NULL, '2022-07-23 08:58:48', NULL),
(51, 1, NULL, '2022-07-27 12:49:45', '2022-07-27 14:36:33'),
(52, 1, NULL, '2022-07-27 14:57:33', NULL),
(53, 1, NULL, '2022-07-28 06:20:42', NULL),
(54, 1, NULL, '2022-07-30 10:01:14', '2022-07-30 10:49:43'),
(55, 1, NULL, '2022-07-30 12:21:33', NULL),
(56, 1, NULL, '2022-08-01 07:53:25', NULL),
(57, 1, NULL, '2022-08-01 09:57:48', '2022-08-01 14:10:43'),
(58, 1, NULL, '2022-08-01 14:16:44', '2022-08-01 15:13:34'),
(59, 1, NULL, '2022-08-05 06:40:31', NULL),
(60, 1, NULL, '2022-08-09 12:38:10', '2022-08-09 12:53:26'),
(61, 1, NULL, '2022-08-09 13:17:42', '2022-08-09 13:36:41'),
(62, 1, NULL, '2022-08-11 05:57:58', '2022-08-11 07:37:04'),
(63, 1, NULL, '2022-08-11 07:45:35', '2022-08-11 08:02:17'),
(64, 1, NULL, '2022-08-11 08:33:40', '2022-08-11 09:58:13'),
(65, 1, NULL, '2022-08-11 10:41:28', '2022-08-11 10:58:37'),
(66, 1, NULL, '2022-08-12 06:49:59', NULL),
(67, 1, NULL, '2022-08-12 10:59:58', '2022-08-12 11:10:07'),
(68, 1, NULL, '2022-08-12 11:11:03', '2022-08-12 11:21:07'),
(69, 1, NULL, '2022-08-12 11:41:14', NULL),
(70, 1, NULL, '2022-08-12 12:39:26', '2022-08-12 12:57:42'),
(71, 1, NULL, '2022-08-12 13:38:10', NULL),
(72, 1, NULL, '2022-08-16 09:12:13', '2022-08-16 11:36:36'),
(73, 1, NULL, '2022-08-16 11:52:13', '2022-08-16 12:31:02'),
(74, 1, NULL, '2022-08-16 13:54:36', '2022-08-16 14:20:06'),
(75, 1, NULL, '2022-08-16 14:23:17', '2022-08-16 14:50:35'),
(76, 1, NULL, '2022-08-16 14:51:35', '2022-08-16 15:10:31'),
(77, 1, NULL, '2022-08-17 15:21:29', NULL),
(78, 1, NULL, '2022-08-18 08:14:45', NULL),
(79, 1, NULL, '2022-08-19 07:02:45', '2022-08-19 12:16:24'),
(80, 1, NULL, '2022-08-19 12:57:08', NULL),
(81, 1, NULL, '2022-08-20 06:18:45', '2022-08-20 06:45:48'),
(82, 1, NULL, '2022-08-22 06:28:54', '2022-08-22 09:10:34'),
(83, 1, NULL, '2022-08-22 09:14:54', '2022-08-22 09:46:27'),
(84, 1, NULL, '2022-08-22 09:46:47', '2022-08-22 10:02:42'),
(85, 1, NULL, '2022-08-22 10:40:02', NULL),
(86, 1, NULL, '2022-08-23 06:35:24', '2022-08-23 08:02:46'),
(87, 1, NULL, '2022-08-23 08:35:59', '2022-08-23 08:58:37'),
(88, 1, NULL, '2022-08-23 08:59:59', '2022-08-23 10:38:50'),
(89, 1, NULL, '2022-08-23 11:05:04', '2022-08-23 12:15:11'),
(90, 1, NULL, '2022-08-23 12:15:14', NULL),
(91, 1, NULL, '2022-08-24 06:29:20', NULL),
(92, 1, NULL, '2022-08-24 06:26:30', '2022-08-24 06:54:19'),
(93, 1, NULL, '2022-08-24 06:54:28', NULL),
(94, 1, NULL, '2022-08-25 02:03:32', NULL),
(95, 1, NULL, '2022-08-25 05:38:43', NULL),
(96, 1, NULL, '2022-08-25 06:24:20', NULL),
(97, 1, NULL, '2022-08-25 06:56:11', NULL),
(98, 1, NULL, '2022-08-25 06:59:36', '2022-08-25 07:44:37'),
(99, 1, NULL, '2022-08-25 10:14:02', '2022-08-25 10:41:33'),
(100, 1, NULL, '2022-09-08 07:28:12', NULL),
(101, 1, NULL, '2022-09-16 13:02:49', NULL),
(102, 1, NULL, '2022-09-18 07:43:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bankpawn`
--

CREATE TABLE `bankpawn` (
  `id` int(11) NOT NULL,
  `year` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `month` varchar(255) DEFAULT NULL,
  `pagesize` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bankstatus`
--

CREATE TABLE `bankstatus` (
  `id` int(11) NOT NULL,
  `receiptno` varchar(255) DEFAULT NULL,
  `loanno` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `cus_amount` varchar(255) DEFAULT NULL,
  `bankname` varchar(255) DEFAULT NULL,
  `no_of_days` varchar(255) DEFAULT NULL,
  `dateofpawn` varchar(255) DEFAULT NULL,
  `totalquantity` varchar(255) DEFAULT NULL,
  `object` varchar(255) DEFAULT NULL,
  `weight` varchar(255) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `interestpercent` varchar(255) DEFAULT NULL,
  `interest` varchar(255) DEFAULT NULL,
  `month` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `totalamount` varchar(255) DEFAULT NULL,
  `returndate` varchar(255) DEFAULT NULL,
  `currentdate` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bank_object_detail`
--

CREATE TABLE `bank_object_detail` (
  `id` int(11) NOT NULL,
  `object` varchar(255) DEFAULT NULL,
  `quantity` varchar(255) DEFAULT NULL,
  `object_image` varchar(255) DEFAULT NULL,
  `object_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bill_settings`
--

CREATE TABLE `bill_settings` (
  `id` int(11) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `prefix` varchar(100) DEFAULT NULL,
  `format` int(11) NOT NULL DEFAULT 1,
  `current_value` int(11) NOT NULL DEFAULT 0,
  `inserted_by` int(11) NOT NULL DEFAULT 0 COMMENT '1 is user',
  `inserted_user_id` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `credit_history`
--

CREATE TABLE `credit_history` (
  `id` int(33) NOT NULL,
  `type` varchar(122) DEFAULT NULL,
  `purchase_id` int(33) DEFAULT NULL,
  `supplier_id` varchar(122) DEFAULT NULL,
  `billno` varchar(122) DEFAULT NULL,
  `purchase_amt` varchar(122) DEFAULT NULL,
  `advance_amt` varchar(122) DEFAULT NULL,
  `balance_amt` varchar(122) DEFAULT NULL,
  `current_amt` varchar(122) DEFAULT NULL,
  `inputamt` varchar(122) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `credit_payment`
--

CREATE TABLE `credit_payment` (
  `id` int(33) NOT NULL,
  `type` varchar(122) DEFAULT NULL,
  `purchase_id` int(33) DEFAULT NULL,
  `supplier_id` varchar(122) DEFAULT NULL,
  `billno` varchar(122) DEFAULT NULL,
  `purchase_amt` varchar(122) DEFAULT NULL,
  `advance_amt` varchar(122) DEFAULT NULL,
  `balance_amt` varchar(122) DEFAULT NULL,
  `current_amt` varchar(122) DEFAULT NULL,
  `inputamt` varchar(122) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `credit_payment`
--

INSERT INTO `credit_payment` (`id`, `type`, `purchase_id`, `supplier_id`, `billno`, `purchase_amt`, `advance_amt`, `balance_amt`, `current_amt`, `inputamt`, `date`) VALUES
(1, 'sales', 1, '', '1', '251500', '1500', '250000', NULL, NULL, '2022-08-24 12:13:09'),
(2, 'sales', 2, '', '2', '196788', '15000', '181788', NULL, NULL, '2022-08-24 12:13:41'),
(3, 'sales', NULL, '', '', '144000', '1500', '58500', NULL, NULL, '2022-08-24 12:15:21'),
(4, 'purchase', 1, '1', '11', '520000', '1212', '268556', NULL, NULL, '2022-08-24 12:16:09'),
(5, 'purchase', 1, '1', '11', '520000', '1212', '268556', NULL, NULL, '2022-08-24 12:16:21');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(33) NOT NULL,
  `cusid` varchar(33) DEFAULT NULL,
  `emailid` varchar(122) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `contact_person` varchar(122) DEFAULT NULL,
  `name` varchar(122) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `area` varchar(122) DEFAULT NULL,
  `object` varchar(255) DEFAULT NULL,
  `mobileno` varchar(122) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `city` varchar(122) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `pincode` varchar(255) DEFAULT NULL,
  `gst` varchar(255) DEFAULT NULL,
  `amount` varchar(122) DEFAULT NULL,
  `interestpercent` varchar(122) DEFAULT NULL,
  `interest` varchar(122) DEFAULT NULL,
  `currentdate` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `cusid`, `emailid`, `date`, `contact_person`, `name`, `address`, `area`, `object`, `mobileno`, `image`, `city`, `state`, `pincode`, `gst`, `amount`, `interestpercent`, `interest`, `currentdate`, `status`) VALUES
(1, NULL, NULL, NULL, NULL, 'hariprasath', 'madurai', NULL, 'madurai', '9843916916', NULL, NULL, 'madurai', NULL, NULL, NULL, NULL, NULL, '2022-06-22 04:44:49', 1),
(3, NULL, NULL, NULL, NULL, 'uyuyuiy', 'testsstts', 'madurai', NULL, '23123123', NULL, 'madurai', NULL, NULL, NULL, NULL, NULL, NULL, '2022-07-30 10:42:50', 1);

-- --------------------------------------------------------

--
-- Table structure for table `daily_expense`
--

CREATE TABLE `daily_expense` (
  `id` int(33) NOT NULL,
  `date` varchar(122) DEFAULT NULL,
  `type` varchar(122) DEFAULT NULL,
  `amount` varchar(122) DEFAULT NULL,
  `billno` varchar(122) DEFAULT NULL,
  `comment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `emailtemplate`
--

CREATE TABLE `emailtemplate` (
  `eid` int(11) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `ip` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `expense_type`
--

CREATE TABLE `expense_type` (
  `id` int(33) NOT NULL,
  `type` varchar(122) DEFAULT NULL,
  `status` int(33) NOT NULL DEFAULT 0,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `generalsettings`
--

CREATE TABLE `generalsettings` (
  `generalid` int(11) NOT NULL,
  `heading1` text DEFAULT NULL,
  `heading2` text DEFAULT NULL,
  `content1` text DEFAULT NULL,
  `content2` text DEFAULT NULL,
  `content3` text DEFAULT NULL,
  `map` text DEFAULT NULL,
  `Footer_Block` text DEFAULT NULL,
  `Facebook_script` longtext DEFAULT NULL,
  `Before_Head` text DEFAULT NULL,
  `After_Body` text DEFAULT NULL,
  `Copyrights` text DEFAULT NULL,
  `OG_Tag` text DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `updated_id` int(11) DEFAULT NULL,
  `updated_type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `generalsettings`
--

INSERT INTO `generalsettings` (`generalid`, `heading1`, `heading2`, `content1`, `content2`, `content3`, `map`, `Footer_Block`, `Facebook_script`, `Before_Head`, `After_Body`, `Copyrights`, `OG_Tag`, `ip`, `date`, `status`, `updated_id`, `updated_type`) VALUES
(1, '<a href=\"tel:+ (91) 452 3244185\"><i class=\"fa fa-phone\" aria-hidden=\"true\"></i>  + (91) 452 3244185</a>', '<a href=\"mailto:reservations@heritagemadurai.com\"> <i class=\"fa fa-envelope\" aria-hidden=\"true\"></i> reservations@heritagemadurai.com</a>', '<a target=\"_blank\" href=\"https://www.tripadvisor.in/Hotel_Review-g297677-d1229352-Reviews-Heritage_Madurai-Madurai_Madurai_District_Tamil_Nadu.html\"><img src=\"http://www.nbayjobs.com/heritage/images/tripadvisor.png\" alt=\"TripAdvisor\" /></a>', '<strong>Heritage Madurai,\r\n                                11, Melakkal Main Road, Kochadai,<br>\r\n                                Madurai 625 016, India.<br>\r\n                                Tel : + (91) 452 2385455, + (91) 452 3244185 <br>   Fax : + (91) 452 2383001 </strong>', '09.00 hrs to 18.00 hrs  mon - Fri <br>09.00hrs to 13.00 hrs Saturday. <br>Sunday holiday. <br>', '<iframe data-cfasync=\"true\" src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15720.06639703362!2d78.09640507012342!3d9.932575236357472!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x783a43e7763b997e!2sHeritage+Madurai!5e0!3m2!1sen!2sin!4v1515252442774\" width=\"100%\" height=\"260\"  frameborder=\"0\" style=\"border:0\" allowfullscreen=\"\"></iframe>', 'Heritage Madurai was built in 1923 as the residence for the British officers of the Madura coats a pioneering textile company, that went on to build brands such a Louise Philippe and Van Husen. In the 1970s the renowned Srilankan architect Geoffery Bawa built the club house on the grounds of the officer’s bungalows. Using honey colored granite, materials and artisans from within 20 miles of Madurai he created a landmark Bawa structure. Today this building functions as our restaurant and coffee shop.', '<div id=\"fb-root\"></div>\r\n                        <script>(function (d, s, id) {\r\n                                var js, fjs = d.getElementsByTagName(s)[0];\r\n                                if (d.getElementById(id))\r\n                                    return;\r\n                                js = d.createElement(s);\r\n                                js.id = id;\r\n                                js.src = \"//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3\";\r\n                                fjs.parentNode.insertBefore(js, fjs);\r\n                            }(document, \'script\', \'facebook-jssdk\'));</script>\r\n                        <div class=\"fb-page\" data-href=\"https://www.facebook.com/Heritagemadurairesort/\" data-hide-cover=\"false\" data-show-facepile=\"true\" data-show-posts=\"false\">\r\n                            <div class=\"fb-xfbml-parse-ignore\">\r\n                                <blockquote cite=\"https://www.facebook.com/Heritagemadurairesort/\">\r\n                                    <a href=\"https://www.facebook.com/Heritagemadurairesort/\">Facebook</a>\r\n                                </blockquote>\r\n                            </div>\r\n                        </div>', '', '', 'Copyright © 2016 Grandluxe Hotels India. All Rights Reserved.', '<meta property=\"og:type\" content=\"website\" /> \r\n<meta property=\"og:locale\" content=\"en-IN\" /> \r\n<meta property=\"og:twitter:site\" content=\"@Heritagemadurai\" /> \r\n<meta property=\"og:copyrights\" content=\"\" /> \r\n<meta property=\"og:author\" content=\"\" /> \r\n<meta property=\"og:publisher\" content=\"\" /> \r\n<meta property=\"og:summary\" content=\"\" />', '192.168.1.18', '2017-08-22', 1, 1, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `gst`
--

CREATE TABLE `gst` (
  `id` int(33) NOT NULL,
  `gst` varchar(122) DEFAULT NULL,
  `status` int(33) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gst`
--

INSERT INTO `gst` (`id`, `gst`, `status`) VALUES
(1, '12', 1),
(2, '10', 1),
(3, '20', 1);

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `hid` int(11) NOT NULL,
  `page` varchar(255) DEFAULT NULL,
  `pageid` int(11) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `ip` varchar(55) DEFAULT NULL,
  `actionid` int(11) DEFAULT NULL,
  `info` text DEFAULT NULL,
  `datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`hid`, `page`, `pageid`, `action`, `userid`, `ip`, `actionid`, `info`, `datetime`) VALUES
(1, 'Object Mgmt', 10, 'INSERT', 1, NULL, NULL, NULL, '2022-03-26 05:30:20'),
(2, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:03'),
(3, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:03'),
(4, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:03'),
(5, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:03'),
(6, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:03'),
(7, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:03'),
(8, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:03'),
(9, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:03'),
(10, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:03'),
(11, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:03'),
(12, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:10'),
(13, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:10'),
(14, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:10'),
(15, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:10'),
(16, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:10'),
(17, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:10'),
(18, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:10'),
(19, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:10'),
(20, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:10'),
(21, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:10'),
(22, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:16'),
(23, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:16'),
(24, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:16'),
(25, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:16'),
(26, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:16'),
(27, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:16'),
(28, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:16'),
(29, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:16'),
(30, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:16'),
(31, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:16'),
(32, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:23'),
(33, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:23'),
(34, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:23'),
(35, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:23'),
(36, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:23'),
(37, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:23'),
(38, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:23'),
(39, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:23'),
(40, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:23'),
(41, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:23'),
(42, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:30'),
(43, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:30'),
(44, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:30'),
(45, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:30'),
(46, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:30'),
(47, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:30'),
(48, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:30'),
(49, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:30'),
(50, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:30'),
(51, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:30'),
(52, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:39'),
(53, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:39'),
(54, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:39'),
(55, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:39'),
(56, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:39'),
(57, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:39'),
(58, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:39'),
(59, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:39'),
(60, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:39'),
(61, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:39'),
(62, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:51'),
(63, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:51'),
(64, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:51'),
(65, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:51'),
(66, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:51'),
(67, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:51'),
(68, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:51'),
(69, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:51'),
(70, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:51'),
(71, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:51'),
(72, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:57'),
(73, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:57'),
(74, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:57'),
(75, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:57'),
(76, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:57'),
(77, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:57'),
(78, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:57'),
(79, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:57'),
(80, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:57'),
(81, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:49:57'),
(82, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:08'),
(83, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:08'),
(84, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:08'),
(85, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:08'),
(86, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:08'),
(87, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:08'),
(88, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:08'),
(89, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:08'),
(90, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:08'),
(91, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:08'),
(92, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:14'),
(93, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:14'),
(94, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:14'),
(95, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:14'),
(96, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:14'),
(97, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:14'),
(98, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:14'),
(99, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:14'),
(100, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:14'),
(101, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:14'),
(102, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:20'),
(103, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:20'),
(104, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:20'),
(105, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:20'),
(106, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:20'),
(107, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:20'),
(108, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:20'),
(109, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:20'),
(110, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:20'),
(111, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:20'),
(112, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:28'),
(113, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:28'),
(114, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:28'),
(115, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:28'),
(116, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:28'),
(117, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:28'),
(118, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:28'),
(119, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:28'),
(120, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:28'),
(121, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:28'),
(122, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:33'),
(123, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:33'),
(124, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:33'),
(125, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:33'),
(126, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:33'),
(127, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:33'),
(128, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:33'),
(129, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:33'),
(130, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:33'),
(131, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:33'),
(132, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:39'),
(133, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:39'),
(134, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:39'),
(135, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:39'),
(136, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:39'),
(137, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:39'),
(138, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:39'),
(139, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:39'),
(140, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:39'),
(141, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:39'),
(142, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:45'),
(143, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:45'),
(144, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:45'),
(145, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:45'),
(146, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:45'),
(147, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:45'),
(148, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:45'),
(149, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:45'),
(150, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:45'),
(151, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:45'),
(152, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:50'),
(153, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:50'),
(154, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:50'),
(155, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:50'),
(156, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:50'),
(157, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:50'),
(158, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:50'),
(159, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:50'),
(160, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:50'),
(161, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:50'),
(162, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:55'),
(163, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:55'),
(164, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:55'),
(165, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:55'),
(166, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:55'),
(167, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:55'),
(168, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:55'),
(169, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:55'),
(170, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:55'),
(171, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:50:55'),
(172, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:01'),
(173, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:01'),
(174, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:01'),
(175, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:01'),
(176, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:01'),
(177, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:01'),
(178, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:01'),
(179, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:01'),
(180, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:01'),
(181, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:01'),
(182, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:06'),
(183, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:06'),
(184, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:06'),
(185, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:06'),
(186, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:06'),
(187, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:06'),
(188, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:06'),
(189, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:06'),
(190, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:06'),
(191, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:06'),
(192, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:13'),
(193, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:13'),
(194, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:13'),
(195, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:13'),
(196, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:13'),
(197, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:13'),
(198, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:13'),
(199, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:13'),
(200, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:13'),
(201, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:13'),
(202, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:19'),
(203, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:19'),
(204, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:19'),
(205, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:19'),
(206, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:19'),
(207, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:19'),
(208, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:19'),
(209, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:19'),
(210, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:19'),
(211, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:19'),
(212, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:25'),
(213, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:25'),
(214, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:25'),
(215, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:25'),
(216, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:25'),
(217, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:25'),
(218, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:25'),
(219, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:25'),
(220, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:25'),
(221, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:25'),
(222, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:31'),
(223, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:31'),
(224, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:31'),
(225, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:31'),
(226, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:31'),
(227, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:31'),
(228, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:31'),
(229, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:31'),
(230, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:31'),
(231, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:31'),
(232, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:40'),
(233, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:40'),
(234, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:40'),
(235, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:40'),
(236, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:40'),
(237, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:40'),
(238, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:40'),
(239, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:40'),
(240, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:40'),
(241, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:51:40'),
(242, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:52:19'),
(243, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:52:19'),
(244, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:52:19'),
(245, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:52:19'),
(246, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:52:19'),
(247, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:52:19'),
(248, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:52:19'),
(249, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:52:19'),
(250, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:52:19'),
(251, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:52:19'),
(252, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:52:27'),
(253, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:52:27'),
(254, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:52:27'),
(255, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:52:27'),
(256, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:52:27'),
(257, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:52:27'),
(258, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:52:27'),
(259, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:52:27'),
(260, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:52:27'),
(261, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:52:27'),
(262, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:52:33'),
(263, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:52:33'),
(264, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:52:33'),
(265, 'Customer Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:53:10'),
(266, 'Customer Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:53:10'),
(267, 'Customer Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:53:10'),
(268, 'Customer Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:53:10'),
(269, 'Customer Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:53:10'),
(270, 'Customer Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:53:10'),
(271, 'Customer Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:53:10'),
(272, 'Customer Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:53:10'),
(273, 'Customer Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:53:10'),
(274, 'Customer Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:53:10'),
(275, 'Customer Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:53:17'),
(276, 'Customer Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:53:17'),
(277, 'Customer Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:53:17'),
(278, 'Customer Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:53:17'),
(279, 'Customer Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:53:18'),
(280, 'Customer Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:53:18'),
(281, 'Customer Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:53:18'),
(282, 'Customer Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:53:18'),
(283, 'Customer Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:53:18'),
(284, 'Customer Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:53:18'),
(285, 'Customer Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:53:22'),
(286, 'Customer Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:53:22'),
(287, 'Customer Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:53:22'),
(288, 'Customer Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:53:22'),
(289, 'Customer Mgmt', 10, 'INSERT', 1, NULL, NULL, NULL, '2022-06-27 06:53:40'),
(290, 'Customer Mgmt', 10, 'UPDATE', 1, NULL, 3, NULL, '2022-06-27 06:54:14'),
(291, 'Customer Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:54:24'),
(292, 'Customer Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:56:05'),
(293, 'Customer Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-27 06:56:05'),
(294, 'Customer Mgmt', 10, 'UPDATE', 1, NULL, 3, NULL, '2022-06-27 06:56:11'),
(295, 'Customer Mgmt', 10, 'UPDATE', 1, NULL, 3, NULL, '2022-06-27 06:56:21'),
(296, 'Customer Mgmt', 10, 'UPDATE', 1, NULL, 3, NULL, '2022-06-27 06:56:23'),
(297, 'Object Mgmt', 10, 'INSERT', 1, NULL, NULL, NULL, '2022-06-27 07:00:19'),
(298, 'Object Mgmt', 10, 'UPDATE', 1, NULL, 270, NULL, '2022-06-27 10:54:55'),
(299, 'Object Mgmt', 10, 'UPDATE', 1, NULL, 270, NULL, '2022-06-27 13:04:57'),
(300, 'Customer Mgmt', 10, 'INSERT', 1, NULL, NULL, NULL, '2022-06-29 10:41:29'),
(301, 'Customer Mgmt', 10, 'UPDATE', 1, NULL, 3, NULL, '2022-06-29 10:41:51'),
(302, 'Customer Mgmt', 10, 'UPDATE', 1, NULL, 3, NULL, '2022-06-29 10:42:08'),
(303, 'Customer Mgmt', 10, 'UPDATE', 1, NULL, 3, NULL, '2022-06-29 10:44:36'),
(304, 'Customer Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-06-29 10:45:45'),
(305, 'Object Mgmt', 10, 'UPDATE', 1, NULL, 270, NULL, '2022-06-29 12:12:09'),
(306, 'Object Mgmt', 10, 'UPDATE', 1, NULL, 270, NULL, '2022-06-29 12:12:16'),
(307, 'Object Mgmt', 10, 'UPDATE', 1, NULL, 270, NULL, '2022-06-29 12:13:57'),
(308, 'Customer Mgmt', 10, 'INSERT', 1, NULL, NULL, NULL, '2022-06-30 12:44:53'),
(309, 'Customer Mgmt', 10, 'INSERT', 1, NULL, NULL, NULL, '2022-06-30 12:45:09'),
(310, 'Object Mgmt', 10, 'INSERT', 1, NULL, NULL, NULL, '2022-06-30 12:46:35'),
(311, 'Salesman Mgmt', 10, 'INSERT', 1, NULL, NULL, NULL, '2022-07-27 12:25:00'),
(312, 'Customer Mgmt', 10, 'UPDATE', 1, NULL, 1, NULL, '2022-07-27 13:00:33'),
(313, 'purchase Mgmt', 10, 'INSERT', 1, NULL, NULL, NULL, '2022-08-12 12:52:18'),
(314, 'purchase Mgmt', 10, 'INSERT', 1, NULL, NULL, NULL, '2022-08-16 07:14:48'),
(315, 'purchase Mgmt', 10, 'INSERT', 1, NULL, NULL, NULL, '2022-08-16 08:03:43'),
(316, 'purchase Mgmt', 10, 'INSERT', 1, NULL, NULL, NULL, '2022-08-16 08:45:43'),
(317, 'purchase Mgmt', 10, 'INSERT', 1, NULL, NULL, NULL, '2022-08-16 12:53:07'),
(318, 'purchase Mgmt', 10, 'INSERT', 1, NULL, NULL, NULL, '2022-08-16 12:54:30'),
(319, 'purchase Mgmt', 10, 'INSERT', 1, NULL, NULL, NULL, '2022-08-19 05:05:45'),
(320, 'purchase Mgmt', 10, 'INSERT', 1, NULL, NULL, NULL, '2022-08-19 05:06:23'),
(321, 'purchase Mgmt', 10, 'INSERT', 1, NULL, NULL, NULL, '2022-08-22 08:58:49'),
(322, 'purchase Mgmt', 10, 'INSERT', 1, NULL, NULL, NULL, '2022-08-22 09:24:57'),
(323, 'purchase Mgmt', 10, 'INSERT', 1, NULL, NULL, NULL, '2022-08-23 11:58:57'),
(324, 'purchase Mgmt', 10, 'INSERT', 1, NULL, NULL, NULL, '2022-08-23 12:21:00'),
(325, 'purchase Mgmt', 10, 'INSERT', 1, NULL, NULL, NULL, '2022-08-23 12:38:35'),
(326, 'purchase Mgmt', 10, 'INSERT', 1, NULL, NULL, NULL, '2022-08-23 13:00:54'),
(327, 'purchase Mgmt', 10, 'INSERT', 1, NULL, NULL, NULL, '2022-08-24 06:46:09'),
(328, 'purchase Mgmt', 10, 'INSERT', 1, NULL, NULL, NULL, '2022-08-24 06:46:21'),
(329, 'Customer Mgmt', 10, 'INSERT', 1, NULL, NULL, NULL, '2022-08-25 05:41:52'),
(330, 'Customer Mgmt', 10, 'INSERT', 1, NULL, NULL, NULL, '2022-08-25 05:42:14'),
(331, 'Object Mgmt', 10, 'INSERT', 1, NULL, NULL, NULL, '2022-08-25 05:43:03'),
(332, 'Customer Mgmt', 10, 'INSERT', 1, NULL, NULL, NULL, '2022-08-25 07:01:06'),
(333, 'Customer Mgmt', 10, 'INSERT', 1, NULL, NULL, NULL, '2022-08-25 07:01:16'),
(334, 'Customer Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-08-25 07:01:31'),
(335, 'Customer Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-08-25 07:01:31'),
(336, 'Customer Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-08-25 07:01:31'),
(337, 'Customer Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-08-25 07:01:48'),
(338, 'Customer Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-08-25 07:01:48'),
(339, 'Customer Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-08-25 07:01:48'),
(340, 'Customer Mgmt', 10, 'INSERT', 1, NULL, NULL, NULL, '2022-08-25 07:04:14'),
(341, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-08-25 07:04:29'),
(342, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-08-25 07:04:29'),
(343, 'Object Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-08-25 07:04:29'),
(344, 'Object Mgmt', 10, 'INSERT', 1, NULL, NULL, NULL, '2022-08-25 07:06:32'),
(345, 'Customer Mgmt', 10, 'DELETE', 1, NULL, NULL, NULL, '2022-09-08 08:07:27'),
(346, 'Customer Mgmt', 10, 'UPDATE', 1, NULL, 1, NULL, '2022-09-16 13:04:07');

-- --------------------------------------------------------

--
-- Table structure for table `hotel_categories`
--

CREATE TABLE `hotel_categories` (
  `category_id` int(255) NOT NULL,
  `category_name` varchar(255) DEFAULT NULL,
  `status` int(33) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hotel_categories`
--

INSERT INTO `hotel_categories` (`category_id`, `category_name`, `status`) VALUES
(28, 'parle _g', 1),
(29, 'unibic', 1);

-- --------------------------------------------------------

--
-- Table structure for table `hotel_users`
--

CREATE TABLE `hotel_users` (
  `user_id` int(255) NOT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `user_mobile` varchar(255) DEFAULT NULL,
  `user_usertype` varchar(255) DEFAULT NULL,
  `user_username` varchar(255) DEFAULT NULL,
  `user_password` varchar(255) DEFAULT NULL,
  `user_profile_photo` varchar(255) DEFAULT NULL,
  `user_address` varchar(255) DEFAULT NULL,
  `user_created` varchar(255) DEFAULT NULL,
  `status` int(33) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `idsettings`
--

CREATE TABLE `idsettings` (
  `id` int(11) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `prefix` varchar(100) DEFAULT NULL,
  `format` int(11) NOT NULL DEFAULT 1,
  `current_value` int(11) NOT NULL DEFAULT 0,
  `inserted_by` int(11) NOT NULL DEFAULT 0 COMMENT '1 is user',
  `inserted_user_id` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `id_proof`
--

CREATE TABLE `id_proof` (
  `id` int(11) NOT NULL,
  `proofname` varchar(255) DEFAULT NULL,
  `proof` varchar(255) DEFAULT NULL,
  `object_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `imageup`
--

CREATE TABLE `imageup` (
  `aiid` int(11) NOT NULL,
  `image_alt` varchar(255) DEFAULT NULL,
  `image_name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `ip` varchar(55) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_type` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_order`
--

CREATE TABLE `invoice_order` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `order_receiver_name` varchar(250) NOT NULL,
  `order_receiver_address` text NOT NULL,
  `order_total_before_tax` decimal(10,2) NOT NULL,
  `order_total_tax` decimal(10,2) NOT NULL,
  `order_tax_per` varchar(250) NOT NULL,
  `order_total_after_tax` double(10,2) NOT NULL,
  `order_amount_paid` decimal(10,2) NOT NULL,
  `order_total_amount_due` decimal(10,2) NOT NULL,
  `note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_order_item`
--

CREATE TABLE `invoice_order_item` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `item_code` varchar(250) NOT NULL,
  `item_name` varchar(250) NOT NULL,
  `order_item_quantity` decimal(10,2) NOT NULL,
  `order_item_price` decimal(10,2) NOT NULL,
  `order_item_final_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_user`
--

CREATE TABLE `invoice_user` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `mobile` bigint(20) NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `loan`
--

CREATE TABLE `loan` (
  `id` int(33) NOT NULL,
  `cusid` varchar(33) DEFAULT NULL,
  `customerid` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `valueofitem` varchar(255) DEFAULT NULL,
  `receipt_no` varchar(122) DEFAULT NULL,
  `name` varchar(122) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `object` varchar(255) DEFAULT NULL,
  `totalquantity` varchar(255) DEFAULT NULL,
  `mobileno` varchar(122) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `idproof` varchar(255) DEFAULT NULL,
  `quantity` varchar(255) DEFAULT NULL,
  `netweight` varchar(255) DEFAULT NULL,
  `amount` varchar(122) DEFAULT NULL,
  `interestpercent` varchar(122) DEFAULT NULL,
  `interest` varchar(122) DEFAULT NULL,
  `currentdate` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `returnstatus` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `manageprofile`
--

CREATE TABLE `manageprofile` (
  `pid` int(11) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `recoveryemail` varchar(255) DEFAULT NULL,
  `phonenumber` text DEFAULT NULL,
  `Company_name` varchar(255) DEFAULT NULL,
  `abn` varchar(255) DEFAULT NULL,
  `tax` int(33) NOT NULL DEFAULT 0,
  `password` varchar(255) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ip` varchar(30) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `image` varchar(50) DEFAULT NULL,
  `footer_content` text DEFAULT NULL,
  `terms` text DEFAULT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `onlinestatus` int(11) DEFAULT NULL,
  `Postcode` varchar(255) DEFAULT NULL,
  `caddress` text NOT NULL,
  `mail` int(11) NOT NULL DEFAULT 1,
  `bank_name` varchar(255) DEFAULT NULL,
  `branch_name` varchar(255) DEFAULT NULL,
  `account_name` varchar(255) DEFAULT NULL,
  `account_no` varchar(255) DEFAULT NULL,
  `ifsc_code` varchar(255) DEFAULT NULL,
  `swift_code` varchar(255) DEFAULT NULL,
  `branch_address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `manageprofile`
--

INSERT INTO `manageprofile` (`pid`, `title`, `recoveryemail`, `phonenumber`, `Company_name`, `abn`, `tax`, `password`, `date`, `ip`, `update_by`, `image`, `footer_content`, `terms`, `firstname`, `uid`, `lastname`, `onlinestatus`, `Postcode`, `caddress`, `mail`, `bank_name`, `branch_name`, `account_name`, `account_no`, `ifsc_code`, `swift_code`, `branch_address`) VALUES
(1, NULL, 'info@thanvitechnologies.com', '+91 84381 64916', 'Thanvi Technologies', '234234', 1212, NULL, '2022-06-30 13:49:20', '49.37.195.163', 0, '1656588568.png', '                                                                                 www.thanvitechnologies.com ', '1.No payments are refundable.\r\n2.The above cost and timeline are only for the design development of the applications and don’t include SEO/SMO/Digital Marketing etc. \r\n3.All assets like images, logos, content, icons, etc. are to be provided by the client.\r\n4.Any other third party integration is to be borne by the client\r\n5.All the required information and queries should be resolved promptly. Thanvi Technologies will not 6.be responsible if there is any delay in delivering the project because of the delay in query resolution 7.from the client.\r\n8.This contract does not cover graphic design of any kind and data entry tasks.\r\n9.Any major change in requirements including the integration of external systems shall be treated as a 10.task and its efforts in terms of time and remuneration shall be provided separately. Please note 11.that some changes may seem small but can take significant efforts to implement, Thanvi 12.Technologies will provide efforts for them after thoroughly evaluating them.\r\n13.Free maintenance of 45 working days will be provided after the project deployment wherein bugs and issues will be fixed. Any change request raised during or after this period will be treated as a task and its efforts will be provided. We can come up with an AMC if required after this period ends.\r\n', 'TT Billing', 1, 'M', NULL, NULL, 'No.20-A, 1st Floor, Sathyamoorthy Nagar,<br>\r\nThamos Road Bypass Road, Madurai - 625010', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `object`
--

CREATE TABLE `object` (
  `id` int(11) NOT NULL,
  `mrp_price` varchar(122) DEFAULT NULL,
  `objectname` varchar(255) DEFAULT NULL,
  `unit_per_pack` varchar(122) DEFAULT NULL,
  `barcode` varchar(122) DEFAULT NULL,
  `in_stock` int(33) DEFAULT NULL,
  `productcode` varchar(122) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `subcategory` varchar(122) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `gst` varchar(122) DEFAULT NULL,
  `hsn` varchar(122) DEFAULT NULL,
  `price` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `object`
--

INSERT INTO `object` (`id`, `mrp_price`, `objectname`, `unit_per_pack`, `barcode`, `in_stock`, `productcode`, `category`, `subcategory`, `unit`, `gst`, `hsn`, `price`, `status`) VALUES
(273, NULL, 'hide-seek mrp 10', '1', '', 1, '777 ', '28', '6', '3', '1', '19059020', '26', 1);

-- --------------------------------------------------------

--
-- Table structure for table `object_detail`
--

CREATE TABLE `object_detail` (
  `id` int(11) NOT NULL,
  `object` varchar(255) DEFAULT NULL,
  `quantity` varchar(255) DEFAULT NULL,
  `object_image` varchar(255) DEFAULT NULL,
  `object_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `online_order`
--

CREATE TABLE `online_order` (
  `id` int(255) NOT NULL,
  `customer_id` varchar(255) DEFAULT NULL,
  `gsttype` varchar(122) DEFAULT NULL,
  `gstvalue` varchar(122) DEFAULT NULL,
  `order_method` varchar(122) DEFAULT NULL,
  `order_type` varchar(255) DEFAULT NULL,
  `salesman` varchar(122) DEFAULT NULL,
  `billtype` varchar(122) DEFAULT NULL,
  `billtypemast` varchar(122) DEFAULT NULL,
  `bill_advanceamt` varchar(122) DEFAULT NULL,
  `bill_balanceamt` varchar(122) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `bill_number` varchar(255) DEFAULT NULL,
  `given_amnt` varchar(255) DEFAULT NULL,
  `balance_amnt` varchar(255) DEFAULT NULL,
  `sub_tot` varchar(255) DEFAULT NULL,
  `discount` varchar(255) DEFAULT NULL,
  `packing_charges` varchar(255) DEFAULT NULL,
  `delivery_charges` varchar(255) DEFAULT NULL,
  `total_amnt` varchar(255) DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `payment_mode` varchar(122) DEFAULT NULL,
  `createdby` varchar(122) DEFAULT NULL,
  `created_id` varchar(122) DEFAULT NULL,
  `cudate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `online_order`
--

INSERT INTO `online_order` (`id`, `customer_id`, `gsttype`, `gstvalue`, `order_method`, `order_type`, `salesman`, `billtype`, `billtypemast`, `bill_advanceamt`, `bill_balanceamt`, `date`, `bill_number`, `given_amnt`, `balance_amnt`, `sub_tot`, `discount`, `packing_charges`, `delivery_charges`, `total_amnt`, `customer_name`, `payment_mode`, `createdby`, `created_id`, `cudate`) VALUES
(2, '1', '2', '0', '4', NULL, NULL, NULL, NULL, '', '', '25-08-2022', '2', '', '', '26', '', NULL, NULL, '26', NULL, NULL, 'admin', '1', '2022-08-25 12:41:55'),
(3, '2', '2', '0', '4', NULL, NULL, NULL, NULL, '', '', '25-08-2022', '3', '', '', '26', '', NULL, NULL, '26', NULL, NULL, 'admin', '1', '2022-08-25 12:48:27'),
(4, '', '2', '0', '4', NULL, NULL, NULL, NULL, '', '', '25-08-2022', '4', '', '', '26', '', NULL, NULL, '26', NULL, NULL, 'admin', '1', '2022-08-25 13:05:40');

-- --------------------------------------------------------

--
-- Table structure for table `online_order_deatils`
--

CREATE TABLE `online_order_deatils` (
  `id` int(255) NOT NULL,
  `object_id` varchar(255) DEFAULT NULL,
  `hsn` varchar(122) DEFAULT NULL,
  `gstresult` varchar(122) DEFAULT NULL,
  `bill_no` varchar(255) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `qty` varchar(255) DEFAULT NULL,
  `rate` varchar(255) DEFAULT NULL,
  `total` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `online_order_deatils`
--

INSERT INTO `online_order_deatils` (`id`, `object_id`, `hsn`, `gstresult`, `bill_no`, `product_name`, `qty`, `rate`, `total`) VALUES
(3, '2', '19059020', '', '2', 'hide-seek mrp 10', '1', '26', '26'),
(4, '3', '19059020', '', '3', 'hide-seek mrp 10', '1', '26', '26'),
(5, '4', '19059020', '', '4', 'hide-seek mrp 10', '1', '26', '26');

-- --------------------------------------------------------

--
-- Table structure for table `online_order_old`
--

CREATE TABLE `online_order_old` (
  `id` int(255) NOT NULL,
  `customer_id` varchar(255) DEFAULT NULL,
  `order_method` varchar(122) DEFAULT NULL,
  `order_type` varchar(255) DEFAULT NULL,
  `billtype` varchar(122) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `bill_number` varchar(255) DEFAULT NULL,
  `given_amnt` varchar(255) DEFAULT NULL,
  `balance_amnt` varchar(255) DEFAULT NULL,
  `sub_tot` varchar(255) DEFAULT NULL,
  `discount` varchar(255) DEFAULT NULL,
  `packing_charges` varchar(255) DEFAULT NULL,
  `delivery_charges` varchar(255) DEFAULT NULL,
  `total_amnt` varchar(255) DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `payment_mode` varchar(122) DEFAULT NULL,
  `cudate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `online_store_order`
--

CREATE TABLE `online_store_order` (
  `id` int(255) NOT NULL,
  `customer_id` varchar(255) DEFAULT NULL,
  `order_type` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `bill_number` varchar(255) DEFAULT NULL,
  `given_amnt` varchar(255) DEFAULT NULL,
  `balance_amnt` varchar(255) DEFAULT NULL,
  `sub_tot` varchar(255) DEFAULT NULL,
  `discount` varchar(255) DEFAULT NULL,
  `packing_charges` varchar(255) DEFAULT NULL,
  `delivery_charges` varchar(255) DEFAULT NULL,
  `total_amnt` varchar(255) DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `payment_mode` varchar(122) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `online_store_order_deatils`
--

CREATE TABLE `online_store_order_deatils` (
  `id` int(255) NOT NULL,
  `object_id` varchar(255) DEFAULT NULL,
  `bill_no` varchar(255) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `qty` varchar(255) DEFAULT NULL,
  `rate` varchar(255) DEFAULT NULL,
  `total` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ordertype`
--

CREATE TABLE `ordertype` (
  `id` int(33) NOT NULL,
  `ordertype` varchar(122) DEFAULT NULL,
  `status` int(33) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ordertype`
--

INSERT INTO `ordertype` (`id`, `ordertype`, `status`) VALUES
(4, 'Online Lead ', 1),
(5, 'Reference lead', 1),
(6, 'Direct lead ', 1),
(7, 'Old customer ', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pawnview`
--

CREATE TABLE `pawnview` (
  `id` int(11) NOT NULL,
  `noofpawn` varchar(255) DEFAULT NULL,
  `noofreturn` varchar(255) DEFAULT NULL,
  `noofcancel` varchar(255) DEFAULT NULL,
  `totalbill` varchar(255) DEFAULT NULL,
  `receiptno` varchar(255) DEFAULT NULL,
  `year` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `customerid` varchar(255) DEFAULT NULL,
  `month` varchar(255) DEFAULT NULL,
  `pagesize` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `paymentmode`
--

CREATE TABLE `paymentmode` (
  `id` int(33) NOT NULL,
  `paymentmode` varchar(122) DEFAULT NULL,
  `status` int(33) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `paymentmode`
--

INSERT INTO `paymentmode` (`id`, `paymentmode`, `status`) VALUES
(1, 'Cash Payment', 1),
(2, 'Card Payment', 1),
(3, 'UPI Payment', 1);

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE `permission` (
  `perid` int(30) NOT NULL,
  `user_id` int(30) DEFAULT NULL,
  `pername` varchar(150) DEFAULT NULL,
  `datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` varchar(30) DEFAULT NULL,
  `created_type` varchar(30) DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_type` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `com_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `permission_details`
--

CREATE TABLE `permission_details` (
  `perd` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `perm_id` int(11) DEFAULT NULL,
  `page_id` int(11) DEFAULT NULL,
  `padd` enum('0','1') DEFAULT NULL,
  `pedit` enum('0','1') DEFAULT NULL,
  `pview` enum('0','1') DEFAULT NULL,
  `pdelete` enum('0','1') DEFAULT NULL,
  `com_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `id` int(33) NOT NULL,
  `supplierid` varchar(33) DEFAULT NULL,
  `customerid` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `valueofitem` varchar(255) DEFAULT NULL,
  `bill_number` varchar(122) DEFAULT NULL,
  `name` varchar(122) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `object` varchar(255) DEFAULT NULL,
  `mobileno` varchar(122) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `advance_amount` varchar(255) DEFAULT NULL,
  `quantity` varchar(255) DEFAULT NULL,
  `sub_total` varchar(255) DEFAULT NULL,
  `tot_amt` varchar(255) DEFAULT NULL,
  `balance_amount` varchar(122) DEFAULT NULL,
  `interestpercent` varchar(122) DEFAULT NULL,
  `interest` varchar(122) DEFAULT NULL,
  `discount` varchar(255) NOT NULL,
  `payment_type` varchar(255) DEFAULT NULL,
  `advance_amnt` varchar(255) DEFAULT NULL,
  `currentdate` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(11) DEFAULT NULL,
  `returnstatus` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`id`, `supplierid`, `customerid`, `date`, `valueofitem`, `bill_number`, `name`, `address`, `object`, `mobileno`, `image`, `advance_amount`, `quantity`, `sub_total`, `tot_amt`, `balance_amount`, `interestpercent`, `interest`, `discount`, `payment_type`, `advance_amnt`, `currentdate`, `status`, `returnstatus`) VALUES
(1, '1', NULL, '2022-08-24', NULL, '11', NULL, NULL, NULL, NULL, NULL, '1212', NULL, '270000', '269768', '268556', NULL, NULL, '232', '0', NULL, '2022-08-24 06:46:09', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `purchaseorder`
--

CREATE TABLE `purchaseorder` (
  `id` int(33) NOT NULL,
  `supplierid` varchar(33) DEFAULT NULL,
  `customerid` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `valueofitem` varchar(255) DEFAULT NULL,
  `bill_number` varchar(122) DEFAULT NULL,
  `name` varchar(122) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `object` varchar(255) DEFAULT NULL,
  `mobileno` varchar(122) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `advance_amount` varchar(255) DEFAULT NULL,
  `quantity` varchar(255) DEFAULT NULL,
  `sub_total` varchar(255) DEFAULT NULL,
  `tot_amt` varchar(255) DEFAULT NULL,
  `balance_amount` varchar(122) DEFAULT NULL,
  `interestpercent` varchar(122) DEFAULT NULL,
  `interest` varchar(122) DEFAULT NULL,
  `discount` varchar(255) NOT NULL,
  `payment_type` varchar(255) DEFAULT NULL,
  `advance_amnt` varchar(255) DEFAULT NULL,
  `currentdate` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(11) DEFAULT NULL,
  `returnstatus` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchaseorder`
--

INSERT INTO `purchaseorder` (`id`, `supplierid`, `customerid`, `date`, `valueofitem`, `bill_number`, `name`, `address`, `object`, `mobileno`, `image`, `advance_amount`, `quantity`, `sub_total`, `tot_amt`, `balance_amount`, `interestpercent`, `interest`, `discount`, `payment_type`, `advance_amnt`, `currentdate`, `status`, `returnstatus`) VALUES
(1, '1', NULL, '2022-08-24', NULL, '11', NULL, NULL, NULL, NULL, NULL, '1212', NULL, '520000', '520000', '268556', NULL, NULL, '232', '0', NULL, '2022-08-24 06:46:21', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `purchaseorder_object_detail`
--

CREATE TABLE `purchaseorder_object_detail` (
  `id` int(11) NOT NULL,
  `object` longtext DEFAULT NULL,
  `bill_no` varchar(122) DEFAULT NULL,
  `hsn` varchar(122) DEFAULT NULL,
  `productid` varchar(33) DEFAULT NULL,
  `pquantity` longtext DEFAULT NULL,
  `rate` varchar(255) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `object_image` longtext DEFAULT NULL,
  `object_id` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `pdate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchaseorder_object_detail`
--

INSERT INTO `purchaseorder_object_detail` (`id`, `object`, `bill_no`, `hsn`, `productid`, `pquantity`, `rate`, `amount`, `object_image`, `object_id`, `status`, `pdate`) VALUES
(1, 'website ', NULL, '1234', '270', '18', '15000', '270000', NULL, '1', 1, '2022-08-24 06:46:21'),
(2, 'digital marketing', NULL, '24567831', '271', '25', '10000', '250000', NULL, '1', 1, '2022-08-24 06:46:50');

-- --------------------------------------------------------

--
-- Table structure for table `purchasereturn`
--

CREATE TABLE `purchasereturn` (
  `id` int(33) NOT NULL,
  `supplierid` varchar(33) DEFAULT NULL,
  `customerid` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `valueofitem` varchar(255) DEFAULT NULL,
  `bill_number` varchar(122) DEFAULT NULL,
  `name` varchar(122) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `object` varchar(255) DEFAULT NULL,
  `mobileno` varchar(122) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `advance_amount` varchar(255) DEFAULT NULL,
  `quantity` varchar(255) DEFAULT NULL,
  `sub_total` varchar(255) DEFAULT NULL,
  `tot_amt` varchar(255) DEFAULT NULL,
  `balance_amount` varchar(122) DEFAULT NULL,
  `interestpercent` varchar(122) DEFAULT NULL,
  `interest` varchar(122) DEFAULT NULL,
  `discount` varchar(255) NOT NULL,
  `payment_type` varchar(255) DEFAULT NULL,
  `advance_amnt` varchar(255) DEFAULT NULL,
  `currentdate` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(11) DEFAULT NULL,
  `returnstatus` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `purchasereturn_object_detail`
--

CREATE TABLE `purchasereturn_object_detail` (
  `id` int(11) NOT NULL,
  `object` longtext DEFAULT NULL,
  `bill_no` varchar(122) DEFAULT NULL,
  `hsn` varchar(122) DEFAULT NULL,
  `productid` varchar(33) DEFAULT NULL,
  `pquantity` longtext DEFAULT NULL,
  `rate` varchar(255) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `object_image` longtext DEFAULT NULL,
  `object_id` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `pdate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_object_detail`
--

CREATE TABLE `purchase_object_detail` (
  `id` int(11) NOT NULL,
  `object` longtext DEFAULT NULL,
  `bill_no` varchar(122) DEFAULT NULL,
  `hsn` varchar(122) DEFAULT NULL,
  `productid` varchar(33) DEFAULT NULL,
  `pquantity` longtext DEFAULT NULL,
  `rate` varchar(255) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `object_image` longtext DEFAULT NULL,
  `object_id` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `pdate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchase_object_detail`
--

INSERT INTO `purchase_object_detail` (`id`, `object`, `bill_no`, `hsn`, `productid`, `pquantity`, `rate`, `amount`, `object_image`, `object_id`, `status`, `pdate`) VALUES
(1, 'website ', NULL, '1234', '270', '18', '15000', '270000', NULL, '1', 1, '2022-08-24 06:46:09');

-- --------------------------------------------------------

--
-- Table structure for table `remainder`
--

CREATE TABLE `remainder` (
  `id` int(11) NOT NULL,
  `bankid` varchar(255) DEFAULT NULL,
  `dateofpawn` varchar(255) DEFAULT NULL,
  `currentdate` varchar(255) DEFAULT NULL,
  `countdays` varchar(22) DEFAULT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `return`
--

CREATE TABLE `return` (
  `id` int(33) NOT NULL,
  `customerid` varchar(122) DEFAULT NULL,
  `customeridname` varchar(255) DEFAULT NULL,
  `object` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `loanid` varchar(122) DEFAULT NULL,
  `receipt_no` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `name` varchar(122) DEFAULT NULL,
  `mobileno` varchar(122) DEFAULT NULL,
  `netweight` varchar(122) DEFAULT NULL,
  `amount` varchar(122) DEFAULT NULL,
  `interestpercent` varchar(122) DEFAULT NULL,
  `interest` varchar(122) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `pawndays` varchar(255) DEFAULT NULL,
  `currentdate` varchar(255) DEFAULT NULL,
  `totalinterest` varchar(255) DEFAULT NULL,
  `pamount` varchar(255) DEFAULT NULL,
  `finalpay` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `returnview`
--

CREATE TABLE `returnview` (
  `id` int(11) NOT NULL,
  `noofpawn` varchar(255) DEFAULT NULL,
  `noofreturn` varchar(255) DEFAULT NULL,
  `noofcancel` varchar(255) DEFAULT NULL,
  `totalbill` varchar(255) DEFAULT NULL,
  `receiptno` varchar(255) DEFAULT NULL,
  `year` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `customerid` varchar(255) DEFAULT NULL,
  `month` varchar(255) DEFAULT NULL,
  `pagesize` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(33) NOT NULL,
  `supplierid` varchar(33) DEFAULT NULL,
  `customerid` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `valueofitem` varchar(255) DEFAULT NULL,
  `receipt_no` varchar(122) DEFAULT NULL,
  `name` varchar(122) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `object` varchar(255) DEFAULT NULL,
  `mobileno` varchar(122) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `idproof` varchar(255) DEFAULT NULL,
  `quantity` varchar(255) DEFAULT NULL,
  `totalquantity` varchar(255) DEFAULT NULL,
  `netweight` varchar(255) DEFAULT NULL,
  `amount` varchar(122) DEFAULT NULL,
  `interestpercent` varchar(122) DEFAULT NULL,
  `interest` varchar(122) DEFAULT NULL,
  `currentdate` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(11) DEFAULT NULL,
  `returnstatus` varchar(11) DEFAULT NULL,
  `bill_no` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `salesman`
--

CREATE TABLE `salesman` (
  `id` int(33) NOT NULL,
  `cusid` varchar(33) DEFAULT NULL,
  `salescode` varchar(122) DEFAULT NULL,
  `emailid` varchar(122) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `contact_person` varchar(122) DEFAULT NULL,
  `name` varchar(122) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `object` varchar(255) DEFAULT NULL,
  `mobileno` varchar(122) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `city` varchar(122) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `pincode` varchar(255) DEFAULT NULL,
  `gst` varchar(255) DEFAULT NULL,
  `amount` varchar(122) DEFAULT NULL,
  `interestpercent` varchar(122) DEFAULT NULL,
  `interest` varchar(122) DEFAULT NULL,
  `currentdate` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `salesman`
--

INSERT INTO `salesman` (`id`, `cusid`, `salescode`, `emailid`, `date`, `contact_person`, `name`, `address`, `object`, `mobileno`, `image`, `city`, `state`, `pincode`, `gst`, `amount`, `interestpercent`, `interest`, `currentdate`, `status`) VALUES
(1, NULL, 'lk', '', NULL, 'lk', 'kumar', 'etts', NULL, '13121222', NULL, 'k', 'l', 'kl', 'kl', NULL, NULL, NULL, '2022-07-27 12:24:59', 0);

-- --------------------------------------------------------

--
-- Table structure for table `salesreturn`
--

CREATE TABLE `salesreturn` (
  `id` int(255) NOT NULL,
  `customer_id` varchar(255) DEFAULT NULL,
  `gsttype` varchar(122) DEFAULT NULL,
  `gstvalue` varchar(122) DEFAULT NULL,
  `order_method` varchar(122) DEFAULT NULL,
  `order_type` varchar(255) DEFAULT NULL,
  `billtype` varchar(122) DEFAULT NULL,
  `billtypemast` varchar(122) DEFAULT NULL,
  `bill_advanceamt` varchar(122) DEFAULT NULL,
  `bill_balanceamt` varchar(122) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `bill_number` varchar(255) DEFAULT NULL,
  `given_amnt` varchar(255) DEFAULT NULL,
  `balance_amnt` varchar(255) DEFAULT NULL,
  `sub_tot` varchar(255) DEFAULT NULL,
  `discount` varchar(255) DEFAULT NULL,
  `packing_charges` varchar(255) DEFAULT NULL,
  `delivery_charges` varchar(255) DEFAULT NULL,
  `total_amnt` varchar(255) DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `payment_mode` varchar(122) DEFAULT NULL,
  `createdby` varchar(122) DEFAULT NULL,
  `created_id` varchar(122) DEFAULT NULL,
  `cudate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sales_object_detail`
--

CREATE TABLE `sales_object_detail` (
  `id` int(11) NOT NULL,
  `object` longtext DEFAULT NULL,
  `squantity` longtext DEFAULT NULL,
  `object_image` longtext DEFAULT NULL,
  `object_id` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `sdate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sales_order`
--

CREATE TABLE `sales_order` (
  `id` int(255) NOT NULL,
  `customer_id` varchar(255) DEFAULT NULL,
  `gsttype` varchar(122) DEFAULT NULL,
  `gstvalue` varchar(122) DEFAULT NULL,
  `order_method` varchar(122) DEFAULT NULL,
  `order_type` varchar(255) DEFAULT NULL,
  `salesman` varchar(122) DEFAULT NULL,
  `billtype` varchar(122) DEFAULT NULL,
  `billtypemast` varchar(122) DEFAULT NULL,
  `bill_advanceamt` varchar(122) DEFAULT NULL,
  `bill_balanceamt` varchar(122) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `bill_number` varchar(255) DEFAULT NULL,
  `given_amnt` varchar(255) DEFAULT NULL,
  `balance_amnt` varchar(255) DEFAULT NULL,
  `sub_tot` varchar(255) DEFAULT NULL,
  `discount` varchar(255) DEFAULT NULL,
  `packing_charges` varchar(255) DEFAULT NULL,
  `delivery_charges` varchar(255) DEFAULT NULL,
  `total_amnt` varchar(255) DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `payment_mode` varchar(122) DEFAULT NULL,
  `createdby` varchar(122) DEFAULT NULL,
  `created_id` varchar(122) DEFAULT NULL,
  `cudate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sales_order`
--

INSERT INTO `sales_order` (`id`, `customer_id`, `gsttype`, `gstvalue`, `order_method`, `order_type`, `salesman`, `billtype`, `billtypemast`, `bill_advanceamt`, `bill_balanceamt`, `date`, `bill_number`, `given_amnt`, `balance_amnt`, `sub_tot`, `discount`, `packing_charges`, `delivery_charges`, `total_amnt`, `customer_name`, `payment_mode`, `createdby`, `created_id`, `cudate`) VALUES
(1, '', '1', '31500', '5', NULL, NULL, NULL, '2', '1212', '250288', '24-08-2022', '1', '1500', '250000', '225000', '5000', NULL, NULL, '251500', NULL, '2', 'admin', '1', '2022-08-24 12:13:09'),
(2, '', '1', '18000', '4', NULL, NULL, NULL, '2', '1212', '195576', '25-08-2022', '2', '15000', '181788', '180000', '1212', NULL, NULL, '196788', NULL, '2', 'admin', '1', '2022-08-24 12:13:41');

-- --------------------------------------------------------

--
-- Table structure for table `sales_order_details`
--

CREATE TABLE `sales_order_details` (
  `id` int(255) NOT NULL,
  `object_id` varchar(255) DEFAULT NULL,
  `hsn` varchar(122) DEFAULT NULL,
  `gstresult` varchar(122) DEFAULT NULL,
  `bill_no` varchar(255) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `qty` varchar(255) DEFAULT NULL,
  `rate` varchar(255) DEFAULT NULL,
  `total` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sales_order_details`
--

INSERT INTO `sales_order_details` (`id`, `object_id`, `hsn`, `gstresult`, `bill_no`, `product_name`, `qty`, `rate`, `total`) VALUES
(1, '1', '1234', '10', '1', 'website ', '1', '15000', '15000'),
(2, '1', '24567831', '10', '1', 'digital marketing', '21', '10000', '210000'),
(3, '2', '1234', '10', '2', 'website ', '12', '15000', '180000');

-- --------------------------------------------------------

--
-- Table structure for table `sales_purchase`
--

CREATE TABLE `sales_purchase` (
  `id` int(33) NOT NULL,
  `supplierid` varchar(33) DEFAULT NULL,
  `customerid` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `valueofitem` varchar(255) DEFAULT NULL,
  `receipt_no` varchar(122) DEFAULT NULL,
  `name` varchar(122) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `object` varchar(255) DEFAULT NULL,
  `mobileno` varchar(122) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `idproof` varchar(255) DEFAULT NULL,
  `quantity` varchar(255) DEFAULT NULL,
  `totalquantity` varchar(255) DEFAULT NULL,
  `netweight` varchar(255) DEFAULT NULL,
  `amount` varchar(122) DEFAULT NULL,
  `interestpercent` varchar(122) DEFAULT NULL,
  `interest` varchar(122) DEFAULT NULL,
  `discount` varchar(255) NOT NULL,
  `payment_type` varchar(255) DEFAULT NULL,
  `advance_amnt` varchar(255) DEFAULT NULL,
  `currentdate` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(11) DEFAULT NULL,
  `returnstatus` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sales_purchase_object_detail`
--

CREATE TABLE `sales_purchase_object_detail` (
  `id` int(11) NOT NULL,
  `object` longtext DEFAULT NULL,
  `pquantity` longtext DEFAULT NULL,
  `rate` varchar(255) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `object_image` longtext DEFAULT NULL,
  `object_id` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `pdate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sales_return`
--

CREATE TABLE `sales_return` (
  `id` int(255) NOT NULL,
  `customer_id` varchar(255) DEFAULT NULL,
  `gsttype` varchar(122) DEFAULT NULL,
  `gstvalue` varchar(122) DEFAULT NULL,
  `order_method` varchar(122) DEFAULT NULL,
  `order_type` varchar(255) DEFAULT NULL,
  `billtype` varchar(122) DEFAULT NULL,
  `billtypemast` varchar(122) DEFAULT NULL,
  `bill_advanceamt` varchar(122) DEFAULT NULL,
  `bill_balanceamt` varchar(122) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `bill_number` varchar(255) DEFAULT NULL,
  `given_amnt` varchar(255) DEFAULT NULL,
  `balance_amnt` varchar(255) DEFAULT NULL,
  `sub_tot` varchar(255) DEFAULT NULL,
  `discount` varchar(255) DEFAULT NULL,
  `packing_charges` varchar(255) DEFAULT NULL,
  `delivery_charges` varchar(255) DEFAULT NULL,
  `total_amnt` varchar(255) DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `payment_mode` varchar(122) DEFAULT NULL,
  `createdby` varchar(122) DEFAULT NULL,
  `created_id` varchar(122) DEFAULT NULL,
  `cudate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sales_return`
--

INSERT INTO `sales_return` (`id`, `customer_id`, `gsttype`, `gstvalue`, `order_method`, `order_type`, `billtype`, `billtypemast`, `bill_advanceamt`, `bill_balanceamt`, `date`, `bill_number`, `given_amnt`, `balance_amnt`, `sub_tot`, `discount`, `packing_charges`, `delivery_charges`, `total_amnt`, `customer_name`, `payment_mode`, `createdby`, `created_id`, `cudate`) VALUES
(1, '', '1', '84000', '5', NULL, NULL, '2', '1212', '58788', '24-08-2022', '', '1500', '58500', '65000', '5000', NULL, NULL, '144000', NULL, '2', 'admin', '1', '2022-08-24 12:14:05');

-- --------------------------------------------------------

--
-- Table structure for table `sales_return_details`
--

CREATE TABLE `sales_return_details` (
  `id` int(255) NOT NULL,
  `object_id` varchar(255) DEFAULT NULL,
  `hsn` varchar(122) DEFAULT NULL,
  `gstresult` varchar(122) DEFAULT NULL,
  `bill_no` varchar(255) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `qty` varchar(255) DEFAULT NULL,
  `rate` varchar(255) DEFAULT NULL,
  `total` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sales_return_details`
--

INSERT INTO `sales_return_details` (`id`, `object_id`, `hsn`, `gstresult`, `bill_no`, `product_name`, `qty`, `rate`, `total`) VALUES
(1, '1', '1234', '10', '', 'website ', '1', '15000', '15000'),
(2, '1', '24567831', '10', '', 'digital marketing', '5', '10000', '50000');

-- --------------------------------------------------------

--
-- Table structure for table `sendgrid`
--

CREATE TABLE `sendgrid` (
  `sgid` int(255) NOT NULL,
  `api_key` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `semail` varchar(255) DEFAULT NULL,
  `saddress` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `ip` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(33) NOT NULL,
  `setting_name` varchar(122) DEFAULT NULL,
  `setting_value` varchar(122) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `setting_name`, `setting_value`) VALUES
(1, 'Salesprint', '2');

-- --------------------------------------------------------

--
-- Table structure for table `silverobject`
--

CREATE TABLE `silverobject` (
  `id` int(11) NOT NULL,
  `objectname` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` int(11) NOT NULL,
  `key` varchar(255) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `purid` int(11) DEFAULT NULL,
  `pur_reid` int(11) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `billno` varchar(100) DEFAULT NULL,
  `ledid` int(11) DEFAULT NULL,
  `supplier_id` varchar(255) DEFAULT NULL,
  `object_name` varchar(255) DEFAULT NULL,
  `weight` varchar(100) DEFAULT NULL,
  `qty` varchar(222) DEFAULT NULL,
  `pur_rate` float DEFAULT NULL,
  `sal_rate` float DEFAULT NULL,
  `tax` int(11) DEFAULT NULL,
  `taxid` int(11) NOT NULL DEFAULT 0,
  `taxableamt` double NOT NULL DEFAULT 0,
  `taxamt` double NOT NULL DEFAULT 0,
  `stocktype` char(1) DEFAULT NULL,
  `barcode` varchar(100) DEFAULT NULL,
  `unitperpack` int(11) DEFAULT NULL,
  `total_qty` varchar(100) DEFAULT NULL,
  `itemdesc` text DEFAULT NULL,
  `ip` varchar(100) DEFAULT NULL,
  `createdby` int(11) NOT NULL DEFAULT 0,
  `modifiedby` int(11) NOT NULL DEFAULT 0,
  `created_date` datetime DEFAULT NULL,
  `modified_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `discount` float DEFAULT NULL,
  `discountamt` double DEFAULT NULL,
  `rate` double DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `opening_stock` int(11) NOT NULL DEFAULT 0,
  `inserted_by` int(11) NOT NULL DEFAULT 0 COMMENT '1 is user',
  `inserted_user_id` int(11) NOT NULL DEFAULT 0,
  `company_id` int(11) DEFAULT 0,
  `status` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stock_product`
--

CREATE TABLE `stock_product` (
  `id` int(11) NOT NULL,
  `objectname` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `subcategory` varchar(122) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `price` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stock_usage`
--

CREATE TABLE `stock_usage` (
  `id` int(33) NOT NULL,
  `product` varchar(122) DEFAULT NULL,
  `quantity` varchar(122) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `cudate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subcategory`
--

CREATE TABLE `subcategory` (
  `id` int(33) NOT NULL,
  `category` int(33) DEFAULT NULL,
  `subcategory` varchar(122) DEFAULT NULL,
  `status` int(33) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subcategory`
--

INSERT INTO `subcategory` (`id`, `category`, `subcategory`, `status`) VALUES
(6, 28, 'parle _g ', 1);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `date` varchar(255) DEFAULT NULL,
  `invoiceno` varchar(255) DEFAULT NULL,
  `suppliercode` varchar(255) DEFAULT NULL,
  `suppliername` varchar(255) DEFAULT NULL,
  `shopname` varchar(255) DEFAULT NULL,
  `mobileno` varchar(255) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `date`, `invoiceno`, `suppliercode`, `suppliername`, `shopname`, `mobileno`, `area`, `status`, `ip`) VALUES
(1, '2022-07-13', NULL, NULL, 'godaddy ', 'godaddy', '12345', 'india', '1', '49.37.193.111');

-- --------------------------------------------------------

--
-- Table structure for table `temp_purchase_detail`
--

CREATE TABLE `temp_purchase_detail` (
  `id` int(11) NOT NULL,
  `object` longtext DEFAULT NULL,
  `bill_no` varchar(122) DEFAULT NULL,
  `hsn` varchar(122) DEFAULT NULL,
  `productid` varchar(33) DEFAULT NULL,
  `pquantity` longtext DEFAULT NULL,
  `rate` varchar(255) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `object_image` longtext DEFAULT NULL,
  `object_id` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `pdate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `temp_sales_details`
--

CREATE TABLE `temp_sales_details` (
  `id` int(255) NOT NULL,
  `object_id` varchar(255) DEFAULT NULL,
  `hsn` varchar(122) DEFAULT NULL,
  `gstresult` varchar(122) DEFAULT NULL,
  `bill_no` varchar(255) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `qty` varchar(255) DEFAULT NULL,
  `rate` varchar(255) DEFAULT NULL,
  `total` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `temp_sales_details`
--

INSERT INTO `temp_sales_details` (`id`, `object_id`, `hsn`, `gstresult`, `bill_no`, `product_name`, `qty`, `rate`, `total`) VALUES
(1, '2', '1234', '10', '3', 'website ', '12', '15000', '180000'),
(2, '3', '19059020', '', '4', 'hide-seek mrp 10', '1', '26', '26');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` int(33) NOT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `status` int(33) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `unit`, `status`) VALUES
(3, 'Nos', 1);

-- --------------------------------------------------------

--
-- Table structure for table `usermaster`
--

CREATE TABLE `usermaster` (
  `uid` int(33) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `changepwd` varchar(20) NOT NULL,
  `userid` varchar(255) NOT NULL,
  `merchant` int(33) DEFAULT NULL,
  `permissiongroup` int(30) NOT NULL,
  `status` int(11) NOT NULL,
  `ip` varchar(25) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `sitelocid` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `val1` varchar(100) NOT NULL,
  `val2` varchar(100) NOT NULL,
  `val3` int(11) NOT NULL,
  `usergroup` int(11) DEFAULT NULL,
  `usertype` varchar(122) DEFAULT NULL,
  `merchant` int(33) DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `val1`, `val2`, `val3`, `usergroup`, `usertype`, `merchant`, `date`) VALUES
(1, '', 'admin', 'fcea920f7412b5da7be0cf42b8c93759', 1, 0, NULL, NULL, '2016-01-19'),
(2, 'newuser', 'newuser', '0354d89c28ec399c00d3cb2d094cf093', 1, NULL, 'subuser', 4, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_history`
--
ALTER TABLE `admin_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bankpawn`
--
ALTER TABLE `bankpawn`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bankstatus`
--
ALTER TABLE `bankstatus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank_object_detail`
--
ALTER TABLE `bank_object_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bill_settings`
--
ALTER TABLE `bill_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `credit_history`
--
ALTER TABLE `credit_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `credit_payment`
--
ALTER TABLE `credit_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daily_expense`
--
ALTER TABLE `daily_expense`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emailtemplate`
--
ALTER TABLE `emailtemplate`
  ADD PRIMARY KEY (`eid`);

--
-- Indexes for table `expense_type`
--
ALTER TABLE `expense_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `generalsettings`
--
ALTER TABLE `generalsettings`
  ADD PRIMARY KEY (`generalid`);

--
-- Indexes for table `gst`
--
ALTER TABLE `gst`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`hid`);

--
-- Indexes for table `hotel_categories`
--
ALTER TABLE `hotel_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `hotel_users`
--
ALTER TABLE `hotel_users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `idsettings`
--
ALTER TABLE `idsettings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `id_proof`
--
ALTER TABLE `id_proof`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `imageup`
--
ALTER TABLE `imageup`
  ADD PRIMARY KEY (`aiid`);

--
-- Indexes for table `invoice_order`
--
ALTER TABLE `invoice_order`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `invoice_order_item`
--
ALTER TABLE `invoice_order_item`
  ADD PRIMARY KEY (`order_item_id`);

--
-- Indexes for table `invoice_user`
--
ALTER TABLE `invoice_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loan`
--
ALTER TABLE `loan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manageprofile`
--
ALTER TABLE `manageprofile`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `object`
--
ALTER TABLE `object`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `object_detail`
--
ALTER TABLE `object_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `online_order`
--
ALTER TABLE `online_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `online_order_deatils`
--
ALTER TABLE `online_order_deatils`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `online_order_old`
--
ALTER TABLE `online_order_old`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `online_store_order`
--
ALTER TABLE `online_store_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `online_store_order_deatils`
--
ALTER TABLE `online_store_order_deatils`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ordertype`
--
ALTER TABLE `ordertype`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pawnview`
--
ALTER TABLE `pawnview`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paymentmode`
--
ALTER TABLE `paymentmode`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`perid`);

--
-- Indexes for table `permission_details`
--
ALTER TABLE `permission_details`
  ADD PRIMARY KEY (`perd`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchaseorder`
--
ALTER TABLE `purchaseorder`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchaseorder_object_detail`
--
ALTER TABLE `purchaseorder_object_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchasereturn`
--
ALTER TABLE `purchasereturn`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchasereturn_object_detail`
--
ALTER TABLE `purchasereturn_object_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_object_detail`
--
ALTER TABLE `purchase_object_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `remainder`
--
ALTER TABLE `remainder`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `return`
--
ALTER TABLE `return`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `returnview`
--
ALTER TABLE `returnview`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salesman`
--
ALTER TABLE `salesman`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salesreturn`
--
ALTER TABLE `salesreturn`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_object_detail`
--
ALTER TABLE `sales_object_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_order`
--
ALTER TABLE `sales_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_order_details`
--
ALTER TABLE `sales_order_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_purchase`
--
ALTER TABLE `sales_purchase`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_purchase_object_detail`
--
ALTER TABLE `sales_purchase_object_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_return`
--
ALTER TABLE `sales_return`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_return_details`
--
ALTER TABLE `sales_return_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sendgrid`
--
ALTER TABLE `sendgrid`
  ADD PRIMARY KEY (`sgid`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `silverobject`
--
ALTER TABLE `silverobject`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_product`
--
ALTER TABLE `stock_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_usage`
--
ALTER TABLE `stock_usage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subcategory`
--
ALTER TABLE `subcategory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temp_purchase_detail`
--
ALTER TABLE `temp_purchase_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temp_sales_details`
--
ALTER TABLE `temp_sales_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usermaster`
--
ALTER TABLE `usermaster`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_history`
--
ALTER TABLE `admin_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `bankpawn`
--
ALTER TABLE `bankpawn`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bankstatus`
--
ALTER TABLE `bankstatus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bank_object_detail`
--
ALTER TABLE `bank_object_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bill_settings`
--
ALTER TABLE `bill_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `credit_history`
--
ALTER TABLE `credit_history`
  MODIFY `id` int(33) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `credit_payment`
--
ALTER TABLE `credit_payment`
  MODIFY `id` int(33) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(33) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `daily_expense`
--
ALTER TABLE `daily_expense`
  MODIFY `id` int(33) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emailtemplate`
--
ALTER TABLE `emailtemplate`
  MODIFY `eid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expense_type`
--
ALTER TABLE `expense_type`
  MODIFY `id` int(33) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `generalsettings`
--
ALTER TABLE `generalsettings`
  MODIFY `generalid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `gst`
--
ALTER TABLE `gst`
  MODIFY `id` int(33) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `hid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=347;

--
-- AUTO_INCREMENT for table `hotel_categories`
--
ALTER TABLE `hotel_categories`
  MODIFY `category_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `hotel_users`
--
ALTER TABLE `hotel_users`
  MODIFY `user_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `idsettings`
--
ALTER TABLE `idsettings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `id_proof`
--
ALTER TABLE `id_proof`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `imageup`
--
ALTER TABLE `imageup`
  MODIFY `aiid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_order`
--
ALTER TABLE `invoice_order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_order_item`
--
ALTER TABLE `invoice_order_item`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_user`
--
ALTER TABLE `invoice_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan`
--
ALTER TABLE `loan`
  MODIFY `id` int(33) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `manageprofile`
--
ALTER TABLE `manageprofile`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `object`
--
ALTER TABLE `object`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=274;

--
-- AUTO_INCREMENT for table `object_detail`
--
ALTER TABLE `object_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `online_order`
--
ALTER TABLE `online_order`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `online_order_deatils`
--
ALTER TABLE `online_order_deatils`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `online_order_old`
--
ALTER TABLE `online_order_old`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `online_store_order`
--
ALTER TABLE `online_store_order`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `online_store_order_deatils`
--
ALTER TABLE `online_store_order_deatils`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ordertype`
--
ALTER TABLE `ordertype`
  MODIFY `id` int(33) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pawnview`
--
ALTER TABLE `pawnview`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `paymentmode`
--
ALTER TABLE `paymentmode`
  MODIFY `id` int(33) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `permission`
--
ALTER TABLE `permission`
  MODIFY `perid` int(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permission_details`
--
ALTER TABLE `permission_details`
  MODIFY `perd` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `id` int(33) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `purchaseorder`
--
ALTER TABLE `purchaseorder`
  MODIFY `id` int(33) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `purchaseorder_object_detail`
--
ALTER TABLE `purchaseorder_object_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `purchasereturn`
--
ALTER TABLE `purchasereturn`
  MODIFY `id` int(33) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchasereturn_object_detail`
--
ALTER TABLE `purchasereturn_object_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_object_detail`
--
ALTER TABLE `purchase_object_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `remainder`
--
ALTER TABLE `remainder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `return`
--
ALTER TABLE `return`
  MODIFY `id` int(33) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `returnview`
--
ALTER TABLE `returnview`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(33) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `salesman`
--
ALTER TABLE `salesman`
  MODIFY `id` int(33) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `salesreturn`
--
ALTER TABLE `salesreturn`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_object_detail`
--
ALTER TABLE `sales_object_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_order`
--
ALTER TABLE `sales_order`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sales_order_details`
--
ALTER TABLE `sales_order_details`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sales_purchase`
--
ALTER TABLE `sales_purchase`
  MODIFY `id` int(33) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_purchase_object_detail`
--
ALTER TABLE `sales_purchase_object_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_return`
--
ALTER TABLE `sales_return`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sales_return_details`
--
ALTER TABLE `sales_return_details`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sendgrid`
--
ALTER TABLE `sendgrid`
  MODIFY `sgid` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(33) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `silverobject`
--
ALTER TABLE `silverobject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_product`
--
ALTER TABLE `stock_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_usage`
--
ALTER TABLE `stock_usage`
  MODIFY `id` int(33) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subcategory`
--
ALTER TABLE `subcategory`
  MODIFY `id` int(33) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `temp_purchase_detail`
--
ALTER TABLE `temp_purchase_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `temp_sales_details`
--
ALTER TABLE `temp_sales_details`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` int(33) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `usermaster`
--
ALTER TABLE `usermaster`
  MODIFY `uid` int(33) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
