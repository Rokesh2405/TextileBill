-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 28, 2022 at 11:48 AM
-- Server version: 10.3.34-MariaDB-0ubuntu0.20.04.1
-- PHP Version: 7.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restaurant`
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
(6, 1, NULL, '2022-03-26 10:53:19', NULL);

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
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(33) NOT NULL,
  `cusid` varchar(33) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `contact_person` varchar(122) DEFAULT NULL,
  `name` varchar(122) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `object` varchar(255) DEFAULT NULL,
  `mobileno` varchar(122) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `idproof` varchar(255) DEFAULT NULL,
  `quantity` varchar(255) DEFAULT NULL,
  `netweight` varchar(255) DEFAULT NULL,
  `amount` varchar(122) DEFAULT NULL,
  `interestpercent` varchar(122) DEFAULT NULL,
  `interest` varchar(122) DEFAULT NULL,
  `currentdate` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(1, 'Object Mgmt', 10, 'INSERT', 1, NULL, NULL, NULL, '2022-03-26 05:30:20');

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
(1, 'FISH STARTERS', 1),
(2, 'CHICKEN STARTERS', 1),
(3, 'VEG STARTERS', 1),
(4, 'Mutton starter', 1),
(5, 'Rice entries', 1),
(6, 'Noodles', 1),
(7, 'Briyani', 1),
(8, 'Main course veg', 1),
(9, 'Veg Soups', 1),
(10, 'Salads', 1),
(11, 'Rolls', 1),
(12, ' Grill', 1),
(13, 'Tandoori', 1),
(14, ' BBQ', 1),
(15, 'MAIN COURSE NON VEG', 1),
(16, 'ROTTI & NAAN', 1),
(17, 'NON VEG SOUPS', 1),
(18, 'DOSAI', 1),
(19, 'SALAD', 1),
(20, 'BEVERAGES ', 1),
(21, 'MEALS', 1),
(22, 'Beeda', 1),
(23, 'EGG STARTERS', 1),
(24, 'COMBO', 1);

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

INSERT INTO `manageprofile` (`pid`, `title`, `recoveryemail`, `phonenumber`, `Company_name`, `abn`, `tax`, `password`, `date`, `ip`, `update_by`, `image`, `firstname`, `uid`, `lastname`, `onlinestatus`, `Postcode`, `caddress`, `mail`, `bank_name`, `branch_name`, `account_name`, `account_no`, `ifsc_code`, `swift_code`, `branch_address`) VALUES
(1, 'Mr', 'hotel@gmail.com', '1234676', 'Hotel Billing', '234234', 1212, NULL, '2022-03-19 12:32:49', '157.49.240.182', 0, '1647692974.jpg', 'Hotel Billing', 1, 'M', NULL, NULL, 'fd', 1, 'gdf', 'gdfg', 'dg', '34234', '4234', '234', '434');

-- --------------------------------------------------------

--
-- Table structure for table `object`
--

CREATE TABLE `object` (
  `id` int(11) NOT NULL,
  `objectname` varchar(255) DEFAULT NULL,
  `productcode` varchar(122) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `subcategory` varchar(122) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `price` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `object`
--

INSERT INTO `object` (`id`, `objectname`, `productcode`, `category`, `subcategory`, `unit`, `price`, `status`) VALUES
(6, 'Fish chily ', NULL, '1', '2', '3', '120', 1),
(7, 'Fish tikka ', NULL, '1', '2', '3', '180', 1),
(8, 'GOBI 65', NULL, '3', '', '3', '60', 1),
(9, 'GOBI PEPPER', NULL, '3', '', '3', '80', 1),
(10, 'GOBI MINT', NULL, '3', '', '3', '80', 1),
(11, 'GOBI MANCHURIAN', NULL, '3', '', '3', '80', 1),
(12, 'GOBI CHILLI', NULL, '3', '', '3', '80', 1),
(13, '  BABY CORN CRISPY FRIED', NULL, '3', '', '3', '90', 1),
(14, 'BABY CORN CHILLI', NULL, '3', '', '3', '90', 1),
(15, 'BABY CORN 65', NULL, '3', '', '3', '90', 1),
(16, 'PANEER 65', NULL, '3', '', '3', '110', 1),
(17, 'PANEER MANJURIAN', NULL, '3', '', '3', '120', 1),
(18, 'PANEER CHILLI', NULL, '3', '', '3', '120', 1),
(19, 'PANEER MAJASTIC', NULL, '3', '', '3', '150', 1),
(20, 'MUTTON CHUKKA', NULL, '4', '', '3', '180', 1),
(21, 'MUTTON MANCHURIAN', NULL, '4', '', '3', '240', 1),
(22, 'SHRWAN MUTTON', NULL, '4', '', '3', '250', 1),
(23, 'GINGER MUTTON', NULL, '4', '', '3', '240', 1),
(24, 'MUTTON FRY', NULL, '4', '', '3', '240', 1),
(25, 'MUTTON CHILLI ', NULL, '4', '', '3', '250', 1),
(26, 'MUTTON KAJU FRY', NULL, '4', '', '3', '260', 1),
(27, 'MUTTON PEPPER', NULL, '4', '', '2', '250', 1),
(28, 'MUTTON GHEE ROAST', NULL, '4', '', '3', '270', 1),
(29, 'CHICKEN 65', NULL, '2', '', '3', '50', 1),
(30, 'CHICKEN BONELESS', NULL, '2', '', '3', '90', 1),
(31, 'GINGER CHICKEN', NULL, '2', '', '3', '120', 1),
(32, 'CHICKEN MANCHURIAN', NULL, '2', '', '3', '120', 1),
(33, 'CORIANDER CHICKEN', NULL, '2', '', '3', '130', 1),
(34, 'CHILLI CHICKEN', NULL, '2', '', '3', '120', 1),
(35, 'SCHEZWAN CHICKEN', NULL, '2', '', '3', '130', 1),
(36, 'CHICKEN BURANI', NULL, '2', '', '3', '130', 1),
(37, 'CHICKEN MAJESTIC', NULL, '2', '', '3', '150', 1),
(38, 'YOGA CHICKEN', NULL, '2', '', '3', '130', 1),
(39, 'CHICKEN LOLLIPOP (4 PIECES)', NULL, '2', '', '3', '90', 1),
(40, 'GREEN CHICKEN', NULL, '2', '', '3', '130', 1),
(41, 'METHI CHICKEN', NULL, '2', '', '3', '130', 1),
(42, 'CHICKEN SANGRILLA', NULL, '2', '', '3', '130', 1),
(43, 'CHICKEN 555', NULL, '2', '', '3', '130', 1),
(44, 'CHICKEN 85', NULL, '2', '', '3', '130', 1),
(45, 'CHICKEN 95', NULL, '2', '', '3', '130', 1),
(46, 'FISH CHILLI', NULL, '1', '', '3', '120', 1),
(47, 'FISH 65', NULL, '1', '', '3', '130', 1),
(48, 'GARLIC FISH', NULL, '1', '', '3', '130', 1),
(49, 'APOLLO FISH', NULL, '1', '', '3', '150', 1),
(50, 'ARABIAN FISH ', NULL, '1', '', '3', '150', 1),
(51, 'POMFRET FRY', NULL, '1', '', '3', '160', 1),
(52, 'PRAWNS CHILLI', NULL, '1', '', '3', '160', 1),
(53, 'GARLIC PRAWNS', NULL, '1', '', '3', '160', 1),
(54, 'PRAWNS MANCHURIAN', NULL, '1', '', '3', '160', 1),
(55, 'GOLDEN FRIED PRAWNS', NULL, '1', '', '3', '180', 1),
(56, 'LOOSE PRAWNS', NULL, '1', '', '3', '180', 1),
(57, 'PRAWNS CHUKKA', NULL, '1', '', '3', '180', 1),
(58, 'CURD RICE', NULL, '5', '', '3', '60', 1),
(59, 'SPECIAL CURD RICE', NULL, '5', '', '3', '80', 1),
(60, 'GHEE RICE', NULL, '5', '', '3', '90', 1),
(61, 'VEG FRIED RICE', NULL, '5', '', '3', '70', 1),
(62, 'SCHEZWAN VEG FRIED RICE', NULL, '5', '', '3', '90', 1),
(63, 'PANEER FRIED RICE', NULL, '5', '', '3', '110', 1),
(64, 'BABY CORN FRIED RICE', NULL, '5', '', '3', '110', 1),
(65, 'EGG FRIED RICE ', NULL, '5', '', '3', '80', 1),
(66, 'SCHEZWAN EGG FRIED RICE', NULL, '5', '', '3', '90', 1),
(67, 'CHICKEN FRIED RICE', NULL, '5', '', '3', '90', 1),
(68, 'SCHEZWAN CHICKEN FRIED RICE', NULL, '5', '', '3', '100', 1),
(69, 'MUTTON FRIED RICE', NULL, '5', '', '3', '160', 1),
(70, 'MIXED FRIED RICE', NULL, '5', '', '3', '180', 1),
(71, 'VEG NOODLES', NULL, '6', '', '3', '70', 1),
(72, 'SCHEZWAN VEG NOODLES', NULL, '6', '', '3', '80', 1),
(73, 'BABY CORN NOODLES', NULL, '6', '', '3', '110', 1),
(74, 'PANEER NOODLES', NULL, '6', '', '3', '110', 1),
(75, 'SCHEZWAN PANEER NOODLES', NULL, '6', '', '3', '120', 1),
(76, 'BABY CORN SCHEZWAN NOODLES', NULL, '6', '', '3', '120', 1),
(77, 'EGG NOODLES', NULL, '6', '', '3', '80', 1),
(78, 'SCHEZWAN EGG NOODLES', NULL, '6', '', '3', '90', 1),
(79, 'CHICKEN NOODLES', NULL, '6', '', '3', '90', 1),
(80, 'SCHEZWAN CHICKEN NOODLES', NULL, '6', '', '3', '100', 1),
(81, 'MIXED NOODLES', NULL, '6', '', '3', '180', 1),
(82, 'TOMATO CURRY ', NULL, '8', '', '3', '80', 1),
(83, 'DHAL FRY', NULL, '8', '', '3', '90', 1),
(84, 'GREEN PEAS CURRY', NULL, '8', '', '3', '130', 1),
(85, 'GREEN PEAS MASALA', NULL, '8', '', '3', '130', 1),
(86, 'KADAAI VEG', NULL, '8', '', '3', '130', 1),
(87, 'MIXED VEG CURRY', NULL, '8', '', '3', '140', 1),
(88, 'KADAAI PANEER', NULL, '8', '', '3', '150', 1),
(89, 'VEG CHAT PAT', NULL, '8', '', '3', '150', 1),
(90, 'PANEER BUTTER MASALA', NULL, '8', '', '3', '160', 1),
(91, 'KAJU PANEER', NULL, '8', '', '3', '180', 1),
(92, 'PANEER CHAT PAT', NULL, '8', '', '3', '160', 1),
(93, 'MALAAI KOFTA', NULL, '8', '', '3', '160', 1),
(94, 'CHICKEN CURRY', NULL, '15', '', '3', '140', 1),
(95, 'PUNJABI CHICKEN', NULL, '15', '', '3', '180', 1),
(96, 'CHICKEN MASALA', NULL, '15', '', '3', '160', 1),
(97, 'BUTTER CHICKEN', NULL, '15', '', '3', '160', 1),
(98, 'DUMKA CHICKEN', NULL, '15', '', '3', '160', 1),
(99, 'GINGER CHICKEN', NULL, '15', '', '3', '160', 1),
(100, 'MUGHALAI CHICKEN', 'MC', '15', '', '3', '220', 1),
(101, 'KADAAI CHICKEN', NULL, '15', '', '3', '170', 1),
(102, 'CHICKEN KOLA PURI', NULL, '15', '', '3', '180', 1),
(103, 'AFGHANI CHICKEN', NULL, '15', '', '3', '180', 1),
(104, 'KHAJU CHICKEN', NULL, '15', '', '3', '180', 1),
(105, 'CHICKEN NAWABI', NULL, '15', '', '3', '180', 1),
(106, 'CHICKEN PATIYALA', NULL, '15', '', '3', '190', 1),
(107, 'ANDHRA CHICKEN', NULL, '15', '', '3', '160', 1),
(108, 'CHICKEN MAHARAJA ', NULL, '15', '', '3', '180', 1),
(109, 'PEPPER CHICKEN', NULL, '15', '', '3', '160', 1),
(110, 'CHETTINAD CHICKEN ', NULL, '15', '', '3', '160', 1),
(111, 'MUTTON CURRY', NULL, '15', '', '3', '220', 1),
(112, 'MUTTON MASALA', NULL, '15', '', '3', '220', 1),
(113, 'BUTTER MUTTON', NULL, '14', '', '3', '250', 1),
(114, 'PUNJABI MUTTON', NULL, '15', '', '3', '250', 1),
(115, 'KADAAI MUTTON', NULL, '15', '', '3', '240', 1),
(116, 'MUTTON KHEEMA CURRY  ', NULL, '15', '', '3', '250', 1),
(117, 'MUTTON ROGAN JOSH', NULL, '15', '', '3', '230', 1),
(118, 'FISH CURRY  ', NULL, '15', '', '3', '160', 1),
(119, 'FISH MASALA', NULL, '15', '', '3', '180', 1),
(120, 'FISH  HYDERABADI', NULL, '15', '', '3', '190', 1),
(121, 'PRAWNS MASALA', NULL, '15', '', '3', '210', 1),
(122, 'GINGER PRAWNS MASALA', NULL, '15', '', '3', '210', 1),
(123, 'EGG CURRY', NULL, '15', '', '3', '70', 1),
(124, 'EGG MASALA', NULL, '15', '', '3', '70', 1),
(125, 'PLAIN ROTTI', NULL, '16', '', '3', '20', 1),
(126, 'BUTTER ROTTI', NULL, '16', '', '3', '25', 1),
(127, 'GARLIC ROTTI', NULL, '16', '', '3', '40', 1),
(128, 'KULCHA ', NULL, '16', '', '3', '60', 1),
(129, 'AALOO PARATHA', NULL, '16', '', '3', '50', 1),
(130, 'TANDOORI PARATHA', NULL, '16', '', '3', '40', 1),
(131, 'PLAIN NAAN', NULL, '16', '', '3', '20', 1),
(132, 'BUTTER NAAN ', NULL, '16', '', '3', '25', 1),
(133, 'GARLIC NAAN', NULL, '16', '', '3', '40', 1),
(134, 'HYDERABADI CHICKEN BIRIYANI', NULL, '7', '', '3', '150', 1),
(135, 'PB SPECIAL CHICKEN BIRIYANI', NULL, '16', '', '3', '180', 1),
(136, 'PLAIN BIRIYANI', NULL, '16', '', '3', '120', 1),
(137, 'HYDRABADI MUTTON BIRIYANI', NULL, '7', '', '3', '240', 1),
(138, 'PB SPECIAL DUM BIRIYANI', NULL, '7', '', '3', '280', 1),
(140, 'MUTTON FAMILY PACK BIRIYANI', NULL, '7', '', '3', '880', 1),
(141, 'HOT AND SOUR SOUP', NULL, '9', '', '3', '50', 1),
(142, 'SWEET CORN SOUP', NULL, '9', '', '3', '50', 1),
(143, 'CLEAR SOUP', NULL, '9', '', '3', '50', 1),
(144, 'HOT AND SOUR CHICKEN SOUP', NULL, '17', '', '3', '80', 1),
(145, 'SWEET CORN CHICKEN SOUP', NULL, '17', '', '3', '80', 1),
(146, 'CLEAR CHICKEN SOUP', NULL, '17', '', '3', '80', 1),
(147, 'CHICKEN PEPPER SOUP', NULL, '17', '', '3', '80', 1),
(148, 'CLASSIC SHAWARMA', NULL, '11', '', '3', '90', 1),
(149, 'SWEET AND SALT SHAWARMA', NULL, '11', '', '3', '90', 1),
(150, 'CHEESE SHAWARMA', NULL, '11', '', '3', '120', 1),
(151, 'SPECIAL SHAWARMA', NULL, '11', '', '3', '120', 1),
(152, 'PLATE SHAWARMA ', NULL, '11', '', '3', '120', 1),
(153, 'DOUBLE MAYONNAISE SHAWARMA', NULL, '11', '', '3', '110', 1),
(154, 'JUMBO SHAWARMA', NULL, '11', '', '3', '120', 1),
(155, 'PANEER SHAWARMA', NULL, '11', '', '3', '120', 1),
(156, 'PANEER PLATE SHAWARMA', NULL, '11', '', '3', '130', 1),
(157, 'SPICY GRILL FULL', NULL, '12', '', '3', '300', 1),
(158, 'SPICY GRILL HALF', NULL, '12', '', '3', '150', 1),
(159, 'FIRE GRILL FULL', NULL, '12', '', '3', '330', 1),
(160, 'FIRE GRILL HALF', NULL, '12', '', '3', '170', 1),
(161, 'MINT GRILL FULL', NULL, '12', '', '3', '320', 1),
(162, 'MINT GRILL HALF', NULL, '12', '', '3', '160', 1),
(163, 'CHAT PAT GRILL FULL', NULL, '12', '', '3', '320', 1),
(164, 'TANDOORI CHICKEN QUARTER', NULL, '13', '', '3', '100', 1),
(165, 'TANDOORI CHICKEN HALF', NULL, '13', '', '3', '200', 1),
(166, 'TANDOORI CHICKEN FULL', NULL, '13', '', '3', '380', 1),
(167, 'FISH TIKKA', NULL, '13', '', '3', '180', 1),
(168, 'PAHADI TIKKA', NULL, '13', '', '3', '180', 1),
(169, 'KALMI KEBAB', NULL, '13', '', '3', '180', 1),
(170, 'RESHMI KEBAB ', NULL, '13', '', '3', '180', 1),
(171, 'MONGALAYI KEBAB', NULL, '13', '', '3', '180', 1),
(172, 'AANCHARI KEBAB', NULL, '13', '', '3', '180', 1),
(173, 'VEG HARA BHAMA KEBAB', NULL, '13', '', '3', '150', 1),
(174, 'ARABIAN BBQ QUARTER', NULL, '14', '', '3', '110', 1),
(175, 'ARABIAN BBQ HALF', NULL, '14', '', '3', '200', 1),
(176, 'ARABIAN BBQ FULL', NULL, '14', '', '3', '380', 1),
(177, 'PEPPER BBQ QUARTER', NULL, '14', '', '3', '120', 1),
(178, 'PEPPER BBQ HALF', NULL, '14', '', '3', '220', 1),
(179, 'PEPPER BBQ FULL', NULL, '14', '', '3', '400', 1),
(180, 'ALBHAM BBQ HALF', NULL, '14', '', '3', '240', 1),
(181, 'ALPHAM BBQ FULL', NULL, '14', '', '3', '480', 1),
(182, 'FISH BBQ', NULL, '14', '', '3', '200', 1),
(183, 'PRAWNS BBQ', NULL, '14', '', '3', '230', 1),
(184, 'POMFRET BBQ', NULL, '14', '', '3', '220', 1),
(185, 'CHICKEN DOSAI ', NULL, '18', '', '3', '120', 1),
(186, 'MUTTON DOSAI', NULL, '18', '', '3', '150', 1),
(187, 'EGG DOSAI', NULL, '18', '', '3', '45', 1),
(188, 'PODI DOSAI', NULL, '18', '', '3', '40', 1),
(189, 'GHEE ROAST', NULL, '18', '', '3', '60', 1),
(190, 'ONION DOSAI', NULL, '18', '', '3', '60', 1),
(191, 'GREEN SALAD', NULL, '10', '', '3', '60', 1),
(192, 'MOJITO ', NULL, '20', '', '3', '70', 1),
(193, 'LIME MINT', NULL, '20', '', '3', '40', 1),
(194, 'MUTTON MEALS', NULL, '21', '', '3', '120', 1),
(195, 'Sprite', NULL, '20', '', '3', '20', 1),
(196, 'Paner Soda', NULL, '20', '', '3', '10', 1),
(197, 'Limca', NULL, '20', '', '3', '15', 1),
(198, 'Aquafina', NULL, '20', '', '3', '20', 1),
(199, 'Lemon mint', NULL, '20', '', '3', '40', 1),
(200, 'White rice', NULL, '5', '', '3', '20', 1),
(201, 'Corn BBQ', NULL, '14', '', '3', '90', 1),
(202, 'family pack hyderabadi chicken briyani', NULL, '7', '', '3', '540', 1),
(203, 'SPECIAL PLATE SHAWARMA', NULL, '11', '', '3', '140', 1),
(204, 'chicken tikka masala', NULL, '2', '', '3', '170', 1),
(205, 'Sweet beeda', NULL, '22', '', '3', '10', 1),
(206, 'Crispy Bright Chicken', NULL, '2', '', '3', '140', 1),
(207, 'Coco Cola', NULL, '20', '', '3', '20', 1),
(208, 'Hyderabadi turkey padi briyani', NULL, '7', '', '3', '2900', 1),
(209, 'Hyderabadi Turkey dum briyani', NULL, '7', '', '3', '180', 1),
(210, 'Hyderabadi mushroom dum briyani                                                                                              ', NULL, '7', '', '3', '140', 1),
(211, 'Mushroom 65', NULL, '3', '', '3', '80', 1),
(212, 'Mushroom hyderabadi bucket briyani', NULL, '7', '', '3', '500', 1),
(213, 'classic grill half', NULL, '12', '', '3', '150', 1),
(214, 'classic grill full', NULL, '12', '', '3', '300', 1),
(215, 'Chicken Lollipop Manchurian', NULL, '2', '', '3', '120', 1),
(216, 'Spicy Shawarma', NULL, '11', '', '3', '110', 1),
(217, 'PRAWNS RICE', NULL, '5', '', '3', '130', 1),
(218, 'FISH FINGERS', NULL, '1', '', '3', '180', 1),
(219, 'BOILED EGG', NULL, '23', '', '3', '10', 1),
(220, 'Chicken Chukka', NULL, '2', '', '3', '120', 1),
(221, 'MUTTER PANEER', NULL, '8', '', '3', '180', 1),
(222, 'EGG BURGY', NULL, '23', '', '3', '30', 1),
(223, 'CRAB LOLIPOP', 'CL', '15', '', '3', '200', 1),
(224, 'FAMILY COMBO', NULL, '24', '', '3', '530', 1),
(225, 'SINGLES COMBO', NULL, '24', '', '3', '199', 1),
(226, 'BACHELOR COMBO', NULL, '24', '', '3', '460', 1),
(227, 'MNI MEALS', '1', '21', '', '3', '60', 1),
(228, 'EXTRA WHITE RICE', '0', '21', '', '3', '30', 1),
(229, 'EGG HYDERABADI DUM BRIYANI ', '2', '7', '', '3', '130', 1),
(230, 'MAJURA CHICKEN', '3', '2', '', '3', '120', 1),
(231, 'GOLDEN CHICKEN', '4', '2', '', '3', '140', 1),
(232, 'PEPPER CHICKEN DRY', '5', '2', '', '3', '130', 1),
(233, 'MUSHROOM CHILI', 'M', '3', '', '3', '120', 1),
(234, 'ALPHAM BBQ HALF', 'AB', '14', '', '3', '200', 1),
(235, 'MUSHROOM MASALA', 'MM', '8', '', '3', '160', 1),
(236, 'MUSHROOM RICE', 'MR', '5', '', '3', '120', 1),
(237, 'DRAGON CHICKEN', 'DC', '2', '', '3', '130', 1),
(238, 'TANDOORI MINT QUARTER', 'MT', '13', '', '3', '110', 1),
(239, 'TANDOORI MINT HALF', 'MNT', '13', '', '3', '220', 1),
(240, 'CHICKEN PLATR', 'CP', '2', '', '3', '240', 1),
(241, 'AMBUR BRIYANI', 'AB', '7', '', '3', '150', 1),
(242, 'CLASSICAL BUTTER SAHAWARMA', 'CB', '11', '', '3', '110', 1),
(243, 'KID\'S CARAMELLO', 'KC', '11', '', '3', '110', 1),
(244, 'FIERY MEXICAN', 'FM', '11', '', '3', '110', 1),
(245, 'RED HOT PERI PERI SHAWARMA', 'RHB', '11', '', '3', '110', 1),
(246, 'FIERY SPECIAL MEXICAN SHAWARMA', 'SM', '11', '', '3', '130', 1),
(247, 'TANDOORI MINT FULL', 'MTF', '13', '', '3', '420', 1),
(248, 'HYDERABADI CHICKEN GRAVY', 'HCG', '15', '', '3', '220', 1),
(249, 'GARLIC CHICKEN GRAVY', 'GCGC', '15', '', '3', '120', 1),
(250, 'GOBI MASALA', 'GM', '8', '', '3', '140', 1),
(251, 'KINLEY', 'KW', '20', '', '3', '20', 1),
(252, 'SHAWARMA MINI', 'MS', '11', '', '3', '70', 1),
(253, 'PRAWNS NOODLES', 'PN', '6', '', '3', '140', 1),
(254, 'HALF PLAIN BRIYANI', 'HPB', '7', '', '3', '60', 1),
(255, 'CHAPPATHI', 'CC', '16', '', '3', '15', 1),
(256, 'KUBBUS', 'K', '16', '', '3', '10', 1),
(257, 'AMBUR EGG BRIANI', 'AEB', '7', '', '3', '130', 1),
(258, 'EGG CHAPPATTI', 'EC', '16', '', '3', '40', 1),
(259, 'OMELETTE', 'EO', '23', '', '3', '20', 1),
(260, 'EGG SPECIAL DOSAI', 'ESD', '18', '', '3', '55', 1),
(261, 'CHICKEN PADI BRIYANI', 'PB', '7', '', '3', '2200', 1),
(262, 'PLAIN OMLETTE', 'PO', '23', '', '3', '15', 1),
(263, 'HALF BOIL', 'HB', '23', '', '3', '15', 1),
(264, 'CHEESE PLATE SHAWARMA', 'CP', '11', '', '3', '140', 1),
(265, 'KALAKKI', 'KK', '23', '', '3', '25', 1),
(266, 'DOUBLE MYO PLATE SHAWARMA', 'DMPS', '11', '', '3', '140', 1),
(267, 'CHAT PAT GRILL HALF', 'CPG', '12', '', '3', '160', 1),
(268, 'FANTA MINI', 'FM', '20', '', '3', '15', 1),
(269, 'Selfie', 'Tlascs', '18', '', '3', '99', 1);

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
  `createdby` varchar(122) DEFAULT NULL,
  `created_id` varchar(122) DEFAULT NULL,
  `cudate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `online_order_deatils`
--

CREATE TABLE `online_order_deatils` (
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

-- --------------------------------------------------------

--
-- Table structure for table `purchasereturn`
--

CREATE TABLE `purchasereturn` (
  `id` int(11) NOT NULL,
  `supplier_name` varchar(225) DEFAULT NULL,
  `silver_object` varchar(225) DEFAULT NULL,
  `purchase_date` varchar(225) DEFAULT NULL,
  `reson_return` varchar(225) DEFAULT NULL,
  `total_quantity` varchar(225) DEFAULT NULL,
  `return_quantity` varchar(225) DEFAULT NULL,
  `remaining_quantity` varchar(225) DEFAULT NULL,
  `return_date` varchar(225) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_object_detail`
--

CREATE TABLE `purchase_object_detail` (
  `id` int(11) NOT NULL,
  `object` longtext DEFAULT NULL,
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
-- Table structure for table `salesreturn`
--

CREATE TABLE `salesreturn` (
  `id` int(11) NOT NULL,
  `Customer_name` varchar(225) DEFAULT NULL,
  `silver_object` varchar(225) DEFAULT NULL,
  `sales_date` varchar(225) DEFAULT NULL,
  `reson_return` varchar(225) DEFAULT NULL,
  `total_quantity` varchar(225) DEFAULT NULL,
  `return_quantity` varchar(225) DEFAULT NULL,
  `remaining_quantity` varchar(225) DEFAULT NULL,
  `return_date` varchar(225) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(2, 1, 'sub1', 1),
(3, 1, 'sub2', 1);

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
(1, 'kg', 1),
(2, 'liter', 1),
(3, 'qty', 1);

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
-- Indexes for table `pawnview`
--
ALTER TABLE `pawnview`
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
-- Indexes for table `purchasereturn`
--
ALTER TABLE `purchasereturn`
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
-- Indexes for table `sendgrid`
--
ALTER TABLE `sendgrid`
  ADD PRIMARY KEY (`sgid`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  MODIFY `id` int(33) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(33) NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `hid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hotel_categories`
--
ALTER TABLE `hotel_categories`
  MODIFY `category_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=270;

--
-- AUTO_INCREMENT for table `object_detail`
--
ALTER TABLE `object_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `online_order`
--
ALTER TABLE `online_order`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `online_order_deatils`
--
ALTER TABLE `online_order_deatils`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT for table `pawnview`
--
ALTER TABLE `pawnview`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(33) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchasereturn`
--
ALTER TABLE `purchasereturn`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_object_detail`
--
ALTER TABLE `purchase_object_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT for table `salesreturn`
--
ALTER TABLE `salesreturn`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_object_detail`
--
ALTER TABLE `sales_object_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT for table `sendgrid`
--
ALTER TABLE `sendgrid`
  MODIFY `sgid` int(255) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(33) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
