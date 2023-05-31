-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2023 at 02:32 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `asset_tracking`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(10) NOT NULL,
  `admin_type` enum('ADMIN','STORE') NOT NULL,
  `store` varchar(150) NOT NULL,
  `store_address` text NOT NULL,
  `store_mng_name` varchar(150) DEFAULT NULL,
  `store_m_phone` varchar(150) DEFAULT NULL,
  `Admin_Profile_Image_Path` varchar(100) NOT NULL,
  `Admin_Profile_Image` varchar(100) NOT NULL,
  `username` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL,
  `status` varchar(10) NOT NULL,
  `u_create_d` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `admin_type`, `store`, `store_address`, `store_mng_name`, `store_m_phone`, `Admin_Profile_Image_Path`, `Admin_Profile_Image`, `username`, `password`, `status`, `u_create_d`) VALUES
(1, 'ADMIN', 'admin', '', NULL, NULL, 'assets/uploads/admin/', 'xq7uka86dmkxpgowt58k.png', 'admin@gmail.com', '123456', '0', '2023-05-31 05:17:43'),
(11, 'STORE', 'Chaigram Acropolis', '0, Rajdanga Main Road, Kasba, Kolkata : 700107', 'Debdutta Mondal', '9674045597', '', '', 'chaigram_acropolis@gmail.com', 'chaigram123', '1', '2023-05-27 06:30:44'),
(12, 'STORE', 'Chaigram Kiosk (Avani Riverside Mall)', 'Avani Riverside Mall,32 Jagat Banerjee Ghat, Howrah-711102', 'Nausad Ansari', '', '', '', 'chaigramkiosk_avani@mail.com', 'chaigram123', '1', '2023-05-27 06:30:47'),
(13, 'STORE', 'The 99 Thali Shop (Avani Mall)', '3rd Floor Avani Riverside Mall, 32 Jagat Banerjee Ghar Road, Howrah-711102', 'Sanjoy Banerjee', '7003866274', '', '', '99_avani@gmail.com', 'chaigram@123', '1', '2023-05-27 06:30:50'),
(15, 'STORE', 'check storedf', 'dsf hksdhf jf osdf osdof sdfios dsf s dss ss d\r\n', 'test name dss', '1254125412212', '', '', 'check@gmail.comddd', '12345678', '1', '2023-05-27 06:30:53'),
(16, 'STORE', 'New store Kolkata', 'Kolkata Naktala', 'Milon Das', '9876543210', '', '', 'sukalyanstore@gmail.com', '123456', '1', '2023-05-31 05:17:39'),
(17, 'STORE', 'Naktala Store', 'test address', 'Anindita ', '9876543210', '', '', 'anindita', '123456', '1', '2023-05-31 05:41:44');

-- --------------------------------------------------------

--
-- Table structure for table `asset_movement_timeline`
--

CREATE TABLE `asset_movement_timeline` (
  `amt_id` bigint(20) NOT NULL,
  `amt_type` enum('INCOMMING','OUTGOING','REQUEST','REQUEST_REJECTION','REQUEST_DELETE','REQUEST_CANCELLATION','REQUESTED_QTY_UPDATE') NOT NULL,
  `amt_log_paragraph` text NOT NULL,
  `amt_FK_main_category_id` bigint(20) NOT NULL COMMENT 'primary key of `tbl_category`',
  `amt_FK_sub_category_id` bigint(20) NOT NULL COMMENT 'primary key of `tbl_subcategory`',
  `amt_FK_asset_id` bigint(20) NOT NULL COMMENT 'Primary key of `product_incomming_general_information`',
  `amt_FK_Store_id` bigint(20) DEFAULT NULL COMMENT 'Default Null. Primary key of `admin` table',
  `amt_dateTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `asset_movement_timeline`
--

INSERT INTO `asset_movement_timeline` (`amt_id`, `amt_type`, `amt_log_paragraph`, `amt_FK_main_category_id`, `amt_FK_sub_category_id`, `amt_FK_asset_id`, `amt_FK_Store_id`, `amt_dateTime`) VALUES
(1, 'REQUEST', 'The 99 Thali Shop (Avani Mall) submitted a request to provide 6 Vaccum cleaner philips on 2023-05-30 18:58:13, and is currently awaiting approval from the administration.', 1, 179, 2, NULL, '2023-05-30 18:58:13'),
(2, 'OUTGOING', 'The store named The 99 Thali Shop (Avani Mall) requested 6  laptops belonging to the category \"Office Equipment\"\" and subcategory \"Vacuum Cleaner\" on 2023-05-30 18:58:13. The approval for 5 units of the requested item was granted on 2023-05-30 18:59:27', 1, 179, 2, NULL, '2023-05-30 18:59:27'),
(3, 'REQUEST', 'The 99 Thali Shop (Avani Mall) submitted a request to provide 3 Vaccum cleaner philips on 2023-05-31 10:03:20, and is currently awaiting approval from the administration.', 1, 179, 2, NULL, '2023-05-31 10:03:20'),
(4, 'REQUEST_REJECTION', 'Asset request reference no. ASREQ1 has been rejected at 2023-05-31 10:05:51 for the quantity of 3 of Vaccum cleaner philips', 1, 179, 2, NULL, '2023-05-31 10:05:51'),
(5, 'REQUEST_DELETE', 'A store named \"The 99 Thali Shop (Avani Mall)\" was submitted a request for \"3\" units of product named \"Vaccum cleaner philips\", falling under the category of \"Office Equipment\" with a specific subcategory of \"Vacuum Cleaner\". The reference ID associated with this request is \"ASREQ1\". However, this request has been rejected and deleted. Rendering further inquiries via the reference ID unattainable.', 1, 179, 2, NULL, '2023-05-31 10:08:36'),
(6, 'INCOMMING', 'A new asset referred to as the TP Link with a total quantity of 1 units was successfully incorporated into the system on 31st May 2023 at precisely 10:34 am. This asset falls under the main category of IT Equipment, specifically classified as a Router within the subcategory hierarchy.', 2, 11, 5, NULL, '2023-05-31 10:34:31'),
(7, 'REQUEST', 'The 99 Thali Shop (Avani Mall) submitted a request to provide 1 TP Link on 2023-05-31 10:40:05, and is currently awaiting approval from the administration.', 2, 11, 5, NULL, '2023-05-31 10:40:05'),
(8, 'OUTGOING', 'The store named The 99 Thali Shop (Avani Mall) requested 1  laptops belonging to the category \"IT Equipment\"\" and subcategory \"Router\" on 2023-05-31 10:40:05. The approval for 1 units of the requested item was granted on 2023-05-31 10:43:07', 2, 11, 5, NULL, '2023-05-31 10:43:07'),
(9, 'REQUEST', 'Naktala Store submitted a request to provide 3 Godrej Wooden chair on 2023-05-31 11:16:26, and is currently awaiting approval from the administration.', 3, 135, 1, 17, '2023-05-31 11:16:26'),
(10, 'INCOMMING', 'A new asset referred to as the One plus LED TV with a total quantity of 1 units was successfully incorporated into the system on 31st May 2023 at precisely 11:18 am. This asset falls under the main category of Office Equipment, specifically classified as a TV within the subcategory hierarchy.', 1, 180, 6, NULL, '2023-05-31 11:18:23'),
(11, 'REQUEST', 'Naktala Store submitted a request to provide 50 One plus LED TV on 2023-05-31 11:24:23, and is currently awaiting approval from the administration.', 1, 180, 6, 17, '2023-05-31 11:24:23'),
(12, 'REQUEST_CANCELLATION', 'The store \"Naktala Store\" has submitted a request for 3 Godrej Wooden chair categorized under \"Furniture & Fixture\" with a subcategory of \"Wooden Chair\" on 31st May 2023, at 11:16 AM. And the reference no. was ASREQ1. However, it appears that this order was either placed in error or is no longer required. Therefore, as of 31st May 2023, at 12:33 PM, the store has taken the initiative to cancel the procurement request themselves. Rendering further inquiries via the reference ID unattainable.', 3, 135, 1, 17, '2023-05-31 12:33:06'),
(13, '', 'The store named \"Naktala Store\" submitted an asset procurement request for \"50 One plus LED TV\", categorized as \"Office Equipment\" with a subcategory of \"TV\" on \"31st May 2023\", at \"11:24 AM\". The reference number assigned to this request is \"ASREQ6\". However, it seems there may have been an error in the requested quantity, as the updated quantity is now \"52\". This request, updated by themselves, was last modified on \"31st May 2023\" at \"02:05 PM\". This request is currently awaiting administrative approval.', 1, 180, 6, 17, '2023-05-31 14:05:32'),
(14, '', 'The store named \"Naktala Store\" submitted an asset procurement request for \"52 One plus LED TV\", categorized as \"Office Equipment\" with a subcategory of \"TV\" on \"31st May 2023\", at \"11:24 AM\". The reference number assigned to this request is \"ASREQ6\". However, it seems there may have been an error in the requested quantity, as the updated quantity is now \"41\". This request, updated by themselves, was last modified on \"31st May 2023\" at \"02:05 PM\". This request is currently awaiting administrative approval.', 1, 180, 6, 17, '2023-05-31 14:05:42'),
(15, '', 'The requested quantity is updated by Naktala Store for the procurement fererence no. ASREQ6. The updated quantity is now 45 and the action was taken on the date of 31st May 2023 at 02:09 PM', 1, 180, 6, 17, '2023-05-31 14:09:33'),
(16, 'INCOMMING', 'A new asset referred to as the Realme 32 inch android smart TV with a total quantity of 15 units was successfully incorporated into the system on 31st May 2023 at precisely 05:20 pm. This asset falls under the main category of Office Equipment, specifically classified as a TV within the subcategory hierarchy.', 1, 180, 7, NULL, '2023-05-31 17:20:22');

-- --------------------------------------------------------

--
-- Table structure for table `asset_requests`
--

CREATE TABLE `asset_requests` (
  `ar_id` bigint(20) NOT NULL,
  `ar_serial_number` varchar(100) NOT NULL COMMENT 'Auto generated',
  `ar_FK_store_id` bigint(20) NOT NULL COMMENT 'primary key of `admin` table',
  `ar_FK_main_category_id` bigint(20) NOT NULL COMMENT 'primary key of `tbl_category` table',
  `ar_FK_sub_category_id` bigint(20) NOT NULL COMMENT 'primary key of `tbl_subcategory` table',
  `ar_FK_asset_id` bigint(20) NOT NULL COMMENT 'primary key of `incomming_assets` table',
  `ar_requested_qty` float NOT NULL,
  `ar_remarks` text DEFAULT NULL,
  `ar_admin_remarks` text DEFAULT NULL,
  `ar_requested_datetime` datetime NOT NULL COMMENT 'No Default, Inserting current datetime',
  `ar_admin_rejected_datetime` datetime DEFAULT NULL,
  `ar_status` enum('P','R') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `asset_requests`
--

INSERT INTO `asset_requests` (`ar_id`, `ar_serial_number`, `ar_FK_store_id`, `ar_FK_main_category_id`, `ar_FK_sub_category_id`, `ar_FK_asset_id`, `ar_requested_qty`, `ar_remarks`, `ar_admin_remarks`, `ar_requested_datetime`, `ar_admin_rejected_datetime`, `ar_status`) VALUES
(6, 'ASREQ6', 17, 1, 180, 6, 45, 'Urgent', NULL, '2023-05-31 11:24:23', NULL, 'P');

-- --------------------------------------------------------

--
-- Table structure for table `company_profile`
--

CREATE TABLE `company_profile` (
  `comp_id` int(11) NOT NULL,
  `comp_name` text DEFAULT NULL,
  `comp_show_name` text DEFAULT NULL,
  `comp_contact_no` text DEFAULT NULL,
  `comp_whats_app_no` text DEFAULT NULL,
  `comp_email` text DEFAULT NULL,
  `comp_logo_path` text DEFAULT NULL,
  `comp_logo` text NOT NULL,
  `comp_favicon` text DEFAULT NULL,
  `comp_copyright` text DEFAULT NULL,
  `comp_develop_by` text DEFAULT NULL,
  `comp_develop_by_link` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `company_profile`
--

INSERT INTO `company_profile` (`comp_id`, `comp_name`, `comp_show_name`, `comp_contact_no`, `comp_whats_app_no`, `comp_email`, `comp_logo_path`, `comp_logo`, `comp_favicon`, `comp_copyright`, `comp_develop_by`, `comp_develop_by_link`) VALUES
(1, 'EFF N BEE MARKETINGsadasdasdsad', 'EFF N BEE MARKETING', '8250425793', '8250425793', 'example@gmail.com', 'assets/uploads/dynamic_page/company_profile/', 'xt8ik4u4q7d5nydhhyj6.png', '52ar1hcgg4yeduof1q7n.jpg', '© Copyright 2020 EFF N BEE MARKETING Website. All Rights Reserved.', 'Sukalyan', '#');

-- --------------------------------------------------------

--
-- Table structure for table `outgoing_assets`
--

CREATE TABLE `outgoing_assets` (
  `oa_id` bigint(20) NOT NULL,
  `oa_FK_asset_id` bigint(20) NOT NULL COMMENT 'Primary key of `product_incomming_general_information` table',
  `oa_FK_store_id` bigint(20) NOT NULL COMMENT 'Primary key of `admin` table',
  `oa_FK_main_category_id` bigint(20) NOT NULL COMMENT 'Primary key of `tbl_category` table',
  `oa_FK_sub_category_id` bigint(20) NOT NULL COMMENT 'Primary key of `tbl_subcategory` table',
  `oa_FK_reference_id` varchar(100) NOT NULL COMMENT 'Field `ar_serial_number` of `asset_requests` table',
  `oa_requested_qty` float NOT NULL,
  `oa_provided_qty` float NOT NULL,
  `oa_admin_remarks` text NOT NULL,
  `oa_approved_datetime` datetime NOT NULL,
  `oa_operaional_status` enum('OPS','NON-OPS') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `outgoing_assets`
--

INSERT INTO `outgoing_assets` (`oa_id`, `oa_FK_asset_id`, `oa_FK_store_id`, `oa_FK_main_category_id`, `oa_FK_sub_category_id`, `oa_FK_reference_id`, `oa_requested_qty`, `oa_provided_qty`, `oa_admin_remarks`, `oa_approved_datetime`, `oa_operaional_status`) VALUES
(1, 2, 13, 1, 179, 'ASREQ1', 6, 5, 'Ok niye nao', '2023-05-30 18:59:27', 'OPS'),
(2, 5, 13, 2, 11, 'ASREQ1', 1, 1, 'hgdfkhsd', '2023-05-31 10:43:07', 'OPS');

-- --------------------------------------------------------

--
-- Table structure for table `product_incomming_general_information`
--

CREATE TABLE `product_incomming_general_information` (
  `pigi_id` bigint(20) NOT NULL,
  `pigi_main_cat_id` bigint(20) NOT NULL COMMENT 'primary key of `tbl_category`',
  `pigi_sub_cat_id` bigint(20) NOT NULL COMMENT 'primary key of `tbl_subcategory`',
  `pigi_product_name` text NOT NULL,
  `pigi_product_description` text NOT NULL,
  `pigi_product_barcode` varchar(200) NOT NULL,
  `pigi_created_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_incomming_general_information`
--

INSERT INTO `product_incomming_general_information` (`pigi_id`, `pigi_main_cat_id`, `pigi_sub_cat_id`, `pigi_product_name`, `pigi_product_description`, `pigi_product_barcode`, `pigi_created_datetime`) VALUES
(1, 3, 135, 'Godrej Wooden chair', 'test test', 'CHAIGRAM001', '2023-05-30 17:15:21'),
(2, 1, 179, 'Vaccum cleaner philips', 'khkhkhkhkh', 'CHAIGRAM002', '2023-05-30 17:17:44'),
(3, 1, 178, 'MTNL mobile phone', 'dsfsfdsdfdsf', 'CHAIGRAM003', '2023-05-30 17:25:05'),
(4, 2, 158, 'Lenovo mouse', 'dfsdfsd sdf zsf zf zf ', 'CHAIGRAM004', '2023-05-30 18:50:02'),
(5, 2, 11, 'TP Link', 'sdfsdf sd fsfs dfsd d fsdf ', 'CHAIGRAM005', '2023-05-31 10:34:31'),
(6, 1, 180, 'One plus LED TV', 'test test test', 'CHAIGRAM006', '2023-05-31 11:18:23'),
(7, 1, 180, 'Realme 32 inch android smart TV', 'dsfsdfsdfsdfsdfsdf', 'CHAIGRAM007', '2023-05-31 17:20:22');

-- --------------------------------------------------------

--
-- Table structure for table `product_incomming_stock`
--

CREATE TABLE `product_incomming_stock` (
  `pis_id` bigint(20) NOT NULL,
  `pis_FK_asset_id` bigint(20) NOT NULL COMMENT 'Primary key of `incomming_assets` table',
  `pis_FK_main_category_id` bigint(20) NOT NULL COMMENT 'Primary key of `tbl_category` table',
  `pis_FK_sub_category_id` bigint(20) NOT NULL COMMENT 'Primary key of `tbl_subcategoy` table',
  `pis_qty` float NOT NULL,
  `pis_product_original_cost` float NOT NULL,
  `pis_serial_number` varchar(100) NOT NULL,
  `pis_purchase_date` date DEFAULT NULL,
  `pis_is_retired` enum('Y','N') NOT NULL,
  `pis_retired_date` date DEFAULT NULL,
  `pis_depriciation_rate` float NOT NULL,
  `pis_vendor_name` varchar(200) NOT NULL,
  `pis_vendor_phone` varchar(15) NOT NULL,
  `pis_vendor_address` text NOT NULL,
  `pis_invoice_type` enum('pdf','image','doc') NOT NULL,
  `pis_invoice_file_name` varchar(100) NOT NULL,
  `pis_invoice_uploaded_path` text NOT NULL,
  `pis_is_generate_qr` enum('Y','N') NOT NULL,
  `pis_generated_qr_filename` varchar(100) NOT NULL,
  `pis_generated_qr_path` text NOT NULL,
  `pis_closing_asset_value` float NOT NULL,
  `pis_remarks` text NOT NULL,
  `pis_added_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_incomming_stock`
--

INSERT INTO `product_incomming_stock` (`pis_id`, `pis_FK_asset_id`, `pis_FK_main_category_id`, `pis_FK_sub_category_id`, `pis_qty`, `pis_product_original_cost`, `pis_serial_number`, `pis_purchase_date`, `pis_is_retired`, `pis_retired_date`, `pis_depriciation_rate`, `pis_vendor_name`, `pis_vendor_phone`, `pis_vendor_address`, `pis_invoice_type`, `pis_invoice_file_name`, `pis_invoice_uploaded_path`, `pis_is_generate_qr`, `pis_generated_qr_filename`, `pis_generated_qr_path`, `pis_closing_asset_value`, `pis_remarks`, `pis_added_datetime`) VALUES
(1, 1, 3, 135, 52, 150000, 'CHISR001', '2023-05-30', 'N', NULL, 1, 'Sukalyan', '9876543210', 'test test', '', '66732220230530051521.png', 'http://localhost/third_law/asset_tracking/assets/vimg/66732220230530051521.png', 'Y', '68914520230530171521.png', 'http://localhost/third_law/asset_tracking/global/tmp/qr_codes/68914520230530171521.png', 148500, 'eee remarks', '2023-05-30 17:15:21'),
(2, 2, 1, 179, 20, 215000, 'CHISR002', '2023-05-30', 'Y', '2023-05-30', 1, 'Milon Da', '9876543210', 'sadasdasdasd', 'pdf', '87257020230530051744.pdf', 'http://localhost/third_law/asset_tracking/assets/vimg/87257020230530051744.pdf', 'Y', '67037820230530171744.png', 'http://localhost/third_law/asset_tracking/global/tmp/qr_codes/67037820230530171744.png', 212850, '', '2023-05-30 17:17:44'),
(3, 3, 1, 178, 36, 254100, 'CHISR003', '2023-05-30', 'Y', '2023-05-26', 2, 'Milon Da', '9876543210', 'asdasdasd', 'pdf', '28692220230530052504.pdf', 'http://localhost/third_law/asset_tracking/assets/vimg/28692220230530052504.pdf', 'Y', '89012720230530172504.png', 'http://localhost/third_law/asset_tracking/global/tmp/qr_codes/89012720230530172504.png', 249018, '', '2023-05-30 17:25:05'),
(4, 3, 1, 178, 56, 100, 'CHISR004', '2023-05-30', 'Y', '2023-05-31', 0, 'Test vendor', '9876543210', 'asdsadasdsad', 'pdf', '69614320230530053127.pdf', 'http://localhost/third_law/asset_tracking/assets/vimg/69614320230530053127.pdf', 'Y', '24970620230530173127.png', 'http://localhost/third_law/asset_tracking/global/tmp/qr_codes/24970620230530173127.png', 0, 'ddddd', '2023-05-30 17:31:27'),
(5, 4, 2, 158, 26, 21000, 'CHISR005', '2023-05-30', 'N', NULL, 0, 'Flipkart', '', 'hgfghh', 'pdf', '66004320230530065002.pdf', 'http://localhost/third_law/asset_tracking/assets/vimg/66004320230530065002.pdf', 'Y', '40157120230530185002.png', 'http://localhost/third_law/asset_tracking/global/tmp/qr_codes/40157120230530185002.png', 0, 'ghfghgf', '2023-05-30 18:50:02'),
(6, 5, 2, 11, 1, 2300, 'CHISR006', '2023-05-31', 'Y', '0000-00-00', 1, 'Flipkart', '2145212220', 'erwerwer', '', '19545020230531103431.jpg', 'http://localhost/third_law/asset_tracking/assets/vimg/19545020230531103431.jpg', 'Y', '17129420230531103431.png', 'http://localhost/third_law/asset_tracking/global/tmp/qr_codes/17129420230531103431.png', 2277, '', '2023-05-31 10:34:31'),
(7, 6, 1, 180, 1, 20000, 'CHISR007', '2023-05-31', 'N', NULL, 0, 'Milon Da', '2145212220', 'sdfsdfsdf', 'pdf', '11683920230531111822.pdf', 'http://localhost/third_law/asset_tracking/assets/vimg/11683920230531111822.pdf', 'Y', '11760520230531111822.png', 'http://localhost/third_law/asset_tracking/global/tmp/qr_codes/11760520230531111822.png', 0, 'fsdfsdf', '2023-05-31 11:18:23'),
(8, 7, 1, 180, 15, 201000, 'CHISR008', '2023-05-31', 'N', NULL, 1, 'Flipkart', '9876543210', 'asdasdasd', 'pdf', '91264020230531052022.pdf', 'http://localhost/third_law/asset_tracking/assets/vimg/91264020230531052022.pdf', 'Y', '22548120230531172022.png', 'http://localhost/third_law/asset_tracking/global/tmp/qr_codes/22548120230531172022.png', 198990, 'sad', '2023-05-31 17:20:22');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `cid` int(10) NOT NULL,
  `cname` varchar(150) NOT NULL,
  `cat_has_barcode` enum('Y','N') NOT NULL,
  `cat_has_closing_asset_value` enum('Y','N') NOT NULL,
  `cat_has_depriciation` enum('Y','N') NOT NULL,
  `cat_has_qr_code` enum('Y','N') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`cid`, `cname`, `cat_has_barcode`, `cat_has_closing_asset_value`, `cat_has_depriciation`, `cat_has_qr_code`) VALUES
(1, 'Office Equipment', 'Y', 'Y', 'Y', 'Y'),
(2, 'IT Equipment', 'Y', 'Y', 'Y', 'Y'),
(3, 'Furniture & Fixture', 'Y', 'Y', 'Y', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product`
--

CREATE TABLE `tbl_product` (
  `pid` int(10) NOT NULL,
  `cid` int(10) NOT NULL,
  `scid` int(10) NOT NULL,
  `pname` varchar(150) NOT NULL,
  `pdesc` text DEFAULT NULL,
  `pqty` varchar(10) NOT NULL,
  `pstock` varchar(10) NOT NULL,
  `barcode` varchar(150) NOT NULL,
  `productqrimg` varchar(150) NOT NULL,
  `p_create_d` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_product`
--

INSERT INTO `tbl_product` (`pid`, `cid`, `scid`, `pname`, `pdesc`, `pqty`, `pstock`, `barcode`, `productqrimg`, `p_create_d`) VALUES
(1, 10, 5, 'Sealing Machine', 'Sealing Machine', '1', '1', '', 'images/63f0a28bafa70.png', '2023-02-18 10:03:55'),
(2, 10, 5, 'Mobile', 'Realme Mobile', '1', '1', 'CHAIGRAM002', 'images/63f0a4496edee.png', '2023-02-18 10:11:21'),
(3, 10, 5, 'LG fridge', 'Frost Free Fridge 471 Litre', '1', '1', 'CHAIGRAM003', 'images/63f0a4f22fc8f.png', '2023-02-18 10:14:10'),
(4, 10, 8, 'Panasonic Microwave', 'Panasonic Microwave', '1', '1', 'CHAIGRAM004', 'images/63f8603a7ec4f.png', '2023-02-24 06:59:06'),
(5, 10, 8, 'IFB Microwave', 'IFB Microwave', '1', '1', 'CHAIGRAM005', 'images/63f860cc4318d.png', '2023-02-24 07:01:32'),
(6, 10, 8, 'IFB Microwave', 'sgsfgfsg', '1', '1', 'CHAIGRAM006', 'images/63f8ad662884c.png', '2023-02-24 12:28:22'),
(7, 10, 8, 'IFB Microwave', 'abcd', '1', '1', 'CHAIGRAM007', 'images/63f8ae0d83dd1.png', '2023-02-24 12:31:09'),
(8, 12, 7, 'demo', 'desc', '100', '100', 'CHAIGRAM008', 'images/63f97ecf6e280.png', '2023-02-25 03:21:51'),
(9, 10, 5, 'demo', 'desc', '100', '100', 'CHAIGRAM009', 'images/63f8b1b6d3899.png', '2023-02-24 12:46:46'),
(10, 10, 5, 'rrr12', 'rrr description', '1', '1', 'CHAIGRAM0010', 'images/63f97e77829a2.png', '2023-02-25 03:20:23'),
(11, 10, 5, 'aa23', 'Made with Silver', '1', '1', 'CHAIGRAM0011', 'images/63f9a587c4223.png', '2023-02-25 06:07:03'),
(12, 10, 5, 'aa23', 'Made with Silver', '1', '1', 'CHAIGRAM0012', 'images/63f9a5dc31a62.png', '2023-02-25 06:08:28'),
(13, 10, 8, 'IFB Microwave', 'IFB Microwave', '1', '1', 'CHAIGRAM0013', 'images/63f9d4fb3461a.png', '2023-02-25 09:29:31'),
(14, 10, 8, 'IFB Microwave', 'IFB Microwave', '1', '1', 'CHAIGRAM0014', 'images/63f9d5c5a0062.png', '2023-02-25 09:32:53'),
(15, 10, 8, 'IFB Microwave', 'IFB Microwave', '1', '1', 'CHAIGRAM0015', 'images/63f9df1d1de3a.png', '2023-02-25 10:12:45'),
(16, 10, 11, 'LG Frost Free Fridge', 'LG Frost Free Fridge 471 Litre', '1', '1', 'CHAIGRAM0016', 'images/63fd9ec8271a9.png', '2023-02-28 06:27:20'),
(17, 10, 11, 'Kelvinator Frost Free Fridge', 'Kelvinator Frost Free Fridge 471 Litre', '1', '0', 'CHAIGRAM0017', 'images/63fdacfe114d0.png', '2023-02-28 07:34:53'),
(18, 10, 11, 'Voltas Frost Free Fride', 'Voltas 470 Litre Fridge', '1', '1', 'CHAIGRAM0018', 'images/63fdad5fdd266.png', '2023-02-28 07:29:35'),
(19, 10, 11, 'Whirlpool Frost Free Fridge', 'Whirlpool Frost Free Fridge', '1', '1', 'CHAIGRAM0019', 'images/63fdadd5cb40f.png', '2023-02-28 07:31:33'),
(20, 10, 11, 'Voltas Frost Free Fridge', 'Voltas Frost Free Fridge', '1', '1', 'CHAIGRAM0020', 'images/63fdae303f93b.png', '2023-02-28 07:33:04'),
(21, 10, 11, 'Whirlpool Frost Free Fridge', 'Whirlpool Frost Free Fridge', '1', '1', 'CHAIGRAM0021', 'images/63fdae7176b93.png', '2023-02-28 07:34:09');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_add`
--

CREATE TABLE `tbl_product_add` (
  `paid` int(10) NOT NULL,
  `pid` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `paqty` varchar(10) NOT NULL,
  `barcode` varchar(150) NOT NULL,
  `serial_no` varchar(20) DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `original_cost` varchar(10) DEFAULT NULL,
  `retired` varchar(10) DEFAULT NULL,
  `retired_date` date DEFAULT NULL,
  `depriciation` varchar(10) DEFAULT NULL,
  `closing_value` varchar(10) DEFAULT NULL,
  `vendor_name` varchar(150) DEFAULT NULL,
  `vendor_phone` varchar(50) DEFAULT NULL,
  `vendor_address` text DEFAULT NULL,
  `product_img` varchar(150) DEFAULT NULL,
  `productqrimg` varchar(150) NOT NULL,
  `remarks` text DEFAULT NULL,
  `pastatus` varchar(10) NOT NULL COMMENT '0=pending,1=approved,2=rejected,4=addQTy\r\n',
  `pa_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_product_add`
--

INSERT INTO `tbl_product_add` (`paid`, `pid`, `uid`, `paqty`, `barcode`, `serial_no`, `purchase_date`, `original_cost`, `retired`, `retired_date`, `depriciation`, `closing_value`, `vendor_name`, `vendor_phone`, `vendor_address`, `product_img`, `productqrimg`, `remarks`, `pastatus`, `pa_date`) VALUES
(1, 1, 0, '1', '', '', '1969-12-31', '', 'No', '1969-12-31', '', '0', 'Pankaj', '9903319229', 'Bramhapur, Garia', 'vimg/', 'images/63f0a28bafa70.png', '', '4', '2023-02-18 10:03:55'),
(2, 2, 0, '1', 'CHAIGRAM002', 'RMX3231', '1969-12-31', '', 'No', '1969-12-31', '', '', 'EFF N BEE MARKETING PVT LTD', '', '', 'vimg/', 'images/63f0a4496edee.png', '', '4', '2023-02-18 10:11:21'),
(3, 3, 0, '1', 'CHAIGRAM003', 'GLT502APZY/2022', '1969-12-31', '', 'No', '1969-12-31', '', '', 'EFF N BEE MARKETING PVT LTD', '', '', 'vimg/', 'images/63f0a4f22fc8f.png', '', '4', '2023-02-18 10:14:10'),
(4, 4, 0, '1', 'CHAIGRAM004', '214PULCWU20248', '1969-12-31', '', 'No', '1969-12-31', '', '', '', '', '', 'vimg/', 'images/63f8603a7ec4f.png', '', '4', '2023-02-24 06:59:06'),
(5, 5, 0, '1', 'CHAIGRAM005', 'K1490960037470', '1969-12-31', '', 'No', '1969-12-31', '', '', '', '', '', 'vimg/', 'images/63f860cc4318d.png', '', '4', '2023-02-24 07:01:32'),
(6, 6, 0, '1', 'CHAIGRAM006', 'sfgsfg', '1969-12-31', '200', 'No', '1969-12-31', '', '0', '', '', 'sfgsfg', 'vimg/', 'images/63f8ad662884c.png', 'sfgg', '4', '2023-02-24 12:52:55'),
(7, 7, 0, '1', 'CHAIGRAM007', '123355', '1969-12-31', '500', 'No', '1969-12-31', '', '0', '', '554154', '', 'vimg/', 'images/63f8ae0d83dd1.png', 'sfgsfgfg', '4', '2023-02-24 12:33:07'),
(8, 8, 0, '100', 'CHAIGRAM008', '2113212', '2023-02-25', '50', 'Yes', '1969-12-31', '2', '49', 'safik', '7363926939', 'Address', 'vimg/Cool-Wallpapers-For-Boys-HD-Wallpaper-Smurai.jpg', 'images/63f97ecf6e280.png', '', '4', '2023-02-25 03:21:51'),
(9, 9, 0, '100', 'CHAIGRAM009', '2113212', '2023-02-24', '50', 'Yes', '2023-02-24', '2', '49', 'safik', '7363926939', 'Address', 'vimg/Cool-Wallpapers-For-Boys-HD-Wallpaper-Smurai.jpg', 'images/63f8b1b6d3899.png', '', '4', '2023-02-24 12:46:46'),
(10, 10, 0, '1', 'CHAIGRAM0010', '123355', '2023-02-25', '', 'Yes', '1969-12-31', '', '', 'hfjhfj', '23232', 'Bhuthnath chakraborty sarani', 'vimg/', 'images/63f97e77829a2.png', 'rrr', '4', '2023-02-25 03:20:23'),
(11, 11, 0, '1', 'CHAIGRAM0011', '23232323', '1969-12-31', '', 'No', '1969-12-31', '', '', '', '', '23232323', 'vimg/', 'images/63f9a587c4223.png', '', '4', '2023-02-25 06:07:03'),
(12, 12, 0, '1', 'CHAIGRAM0012', 'CHISR0012', '1969-12-31', '', 'No', '1969-12-31', '', '', '', '', '', 'vimg/', 'images/63f9a5dc31a62.png', '', '4', '2023-02-25 06:08:28'),
(13, 13, 0, '1', 'CHAIGRAM0013', '', '1969-12-31', '', 'No', '1969-12-31', '', '', '', '', '', 'vimg/', 'images/63f9d4fb3461a.png', '', '4', '2023-02-25 09:29:31'),
(14, 14, 0, '1', 'CHAIGRAM0014', 'CHISR0014', '1969-12-31', '', 'No', '1969-12-31', '', '', '', '', '', 'vimg/', 'images/63f9d5c5a0062.png', '', '4', '2023-02-25 09:32:53'),
(15, 15, 0, '1', 'CHAIGRAM0015', 'CHISR0015', '1969-12-31', '', 'No', '1969-12-31', '', '', '', '', '', 'vimg/', 'images/63f9df1d1de3a.png', '', '4', '2023-02-25 10:12:45'),
(16, 16, 0, '1', 'CHAIGRAM0016', 'GLT502APZY/2022', '1969-12-31', '', 'No', '1969-12-31', '', '', '', '', '', 'vimg/', 'images/63fd9ec8271a9.png', '', '4', '2023-02-28 06:27:20'),
(17, 17, 0, '1', 'CHAIGRAM0017', '340C1524301120511800', '1969-12-31', '', 'No', '1969-12-31', '', '', '', '', '', 'vimg/', 'images/63fdacfe114d0.png', '', '4', '2023-02-28 07:27:58'),
(18, 18, 0, '1', 'CHAIGRAM0018', '8700000369-211008640', '1969-12-31', '', 'No', '1969-12-31', '', '', '', '', '', 'vimg/', 'images/63fdad5fdd266.png', '', '4', '2023-02-28 07:29:35'),
(19, 19, 0, '1', 'CHAIGRAM0019', 'W11101251222113123', '1969-12-31', '', 'No', '1969-12-31', '', '', '', '', '', 'vimg/', 'images/63fdadd5cb40f.png', '', '4', '2023-02-28 07:31:33'),
(20, 20, 0, '1', 'CHAIGRAM0020', 'CHISR0020', '1969-12-31', '', 'No', '1969-12-31', '', '', '', '', '', 'vimg/', 'images/63fdae303f93b.png', '', '4', '2023-02-28 07:33:04'),
(21, 21, 0, '1', 'CHAIGRAM0021', 'K2071110096913', '1969-12-31', '', 'No', '1969-12-31', '', '', '', '', '', 'vimg/', 'images/63fdae7176b93.png', '', '4', '2023-02-28 07:34:09'),
(22, 17, 13, '1', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '1', '2023-02-28 07:34:53');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pro_store`
--

CREATE TABLE `tbl_pro_store` (
  `psid` int(10) NOT NULL,
  `pid` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `psqty` int(10) NOT NULL,
  `ps_stock` int(10) NOT NULL,
  `ps_status` int(10) NOT NULL COMMENT '0=pending,1=approved,2=rejected',
  `ps_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_pro_store`
--

INSERT INTO `tbl_pro_store` (`psid`, `pid`, `uid`, `psqty`, `ps_stock`, `ps_status`, `ps_date`) VALUES
(1, 17, 13, 1, 1, 1, '2023-02-28 07:34:53');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subcategory`
--

CREATE TABLE `tbl_subcategory` (
  `scid` int(10) NOT NULL,
  `cid` int(10) NOT NULL,
  `scname` varchar(150) NOT NULL,
  `scqty` varchar(50) DEFAULT NULL,
  `scstock` varchar(50) DEFAULT NULL,
  `sccreat_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_subcategory`
--

INSERT INTO `tbl_subcategory` (`scid`, `cid`, `scname`, `scqty`, `scstock`, `sccreat_date`) VALUES
(1, 1, 'Food Display Cabinet', NULL, NULL, '2023-05-26 13:40:42'),
(2, 1, 'Microwave', NULL, NULL, '2023-05-26 13:40:52'),
(3, 1, 'Griller', NULL, NULL, '2023-05-26 13:40:55'),
(4, 1, 'TAB', NULL, NULL, '2023-05-26 13:40:58'),
(6, 1, 'Boiler', NULL, NULL, '2023-05-26 13:41:44'),
(7, 1, 'Wall Fan', NULL, NULL, '2023-05-26 13:41:47'),
(8, 1, 'Card Swipe Machine', NULL, NULL, '2023-05-26 13:41:50'),
(9, 1, 'Receipt Printer', NULL, NULL, '2023-05-26 13:41:53'),
(10, 1, 'CCTV Camera', NULL, NULL, '2023-05-26 13:41:56'),
(11, 2, 'Router', NULL, NULL, '2023-05-26 13:42:09'),
(12, 1, 'Bainmarie', NULL, NULL, '2023-05-26 13:42:18'),
(13, 2, 'Laptop', NULL, NULL, '2023-05-26 13:42:26'),
(14, 1, 'Fridge', NULL, NULL, '2023-05-26 13:42:38'),
(15, 1, 'Sealing Machine', NULL, NULL, '2023-05-26 13:42:49'),
(16, 1, 'Fryer', NULL, NULL, '2023-05-26 13:43:05'),
(17, 1, 'Faber Chimney', NULL, NULL, '2023-05-26 13:43:14'),
(18, 1, 'Industrial Induction', NULL, NULL, '2023-05-26 13:43:30'),
(19, 3, 'Kitchen Table', NULL, NULL, '2023-05-26 13:43:49'),
(20, 3, 'Billing Table', NULL, NULL, '2023-05-26 13:43:58'),
(21, 3, 'Plastic Tool', NULL, NULL, '2023-05-26 13:44:06'),
(22, 1, 'Biriyani Bainmarie', NULL, NULL, '2023-05-26 13:44:54'),
(23, 1, 'Sandwich Maker', NULL, NULL, '2023-05-26 13:45:04'),
(24, 1, 'Realme Mobile C30S', NULL, NULL, '2023-05-26 13:45:31'),
(25, 1, 'Mouse', NULL, NULL, '2023-05-26 13:45:38'),
(26, 3, 'Wooden Table', NULL, NULL, '2023-05-26 13:45:47'),
(27, 3, 'Office Chair', NULL, NULL, '2023-05-26 13:45:54'),
(28, 1, '1.5 ton Whirpool AC', NULL, NULL, '2023-05-26 13:46:04'),
(29, 1, '1.5 ton Hitachi AC', NULL, NULL, '2023-05-26 13:46:08'),
(30, 1, '1.5 ton Samsung AC', NULL, NULL, '2023-05-26 13:46:11'),
(31, 1, 'White Board', NULL, NULL, '2023-05-26 13:46:21'),
(35, 1, 'Bajaj Majestry Induction Cooker', NULL, NULL, '2023-05-26 13:47:04'),
(36, 1, 'Upscale Hot Water Dispenser', NULL, NULL, '2023-05-26 13:47:16'),
(37, 1, 'Oreva Wall Clock', NULL, NULL, '2023-05-27 04:49:54'),
(38, 1, 'Cordless Panasonic Phone', NULL, NULL, '2023-05-27 04:50:02'),
(39, 2, 'Lenovo Mouse', NULL, NULL, '2023-05-27 04:50:11'),
(40, 2, 'EPSON I Card Printer', NULL, NULL, '2023-05-27 04:50:23'),
(41, 1, 'Samsung AC Outdoor', NULL, NULL, '2023-05-27 04:50:35'),
(42, 1, 'Tea Price List Board', NULL, NULL, '2023-05-27 04:50:53'),
(43, 1, 'Ingenico POS Machine', NULL, NULL, '2023-05-27 04:51:06'),
(44, 1, 'prestige grinder machine', NULL, NULL, '2023-05-27 04:51:21'),
(45, 1, 'Local made mixer grtinder', NULL, NULL, '2023-05-27 04:55:35'),
(46, 1, 'ibell electric kettle', NULL, NULL, '2023-05-27 04:55:43'),
(47, 2, 'HP Laseret Printer', NULL, NULL, '2023-05-27 04:55:52'),
(48, 1, 'Prestige Induction', NULL, NULL, '2023-05-27 05:04:35'),
(49, 3, 'Roll Table', NULL, NULL, '2023-05-27 05:04:44'),
(50, 3, 'Temp control food display cabinet', NULL, NULL, '2023-05-27 05:04:52'),
(51, 3, 'Wall Hanging Storage', NULL, NULL, '2023-05-27 05:05:06'),
(52, 1, 'Stainless Steel Tandori Oven', NULL, NULL, '2023-05-27 05:05:28'),
(53, 1, 'Steel Sink', NULL, NULL, '2023-05-27 05:05:35'),
(54, 1, 'Backlit Menu Board', NULL, NULL, '2023-05-27 05:05:47'),
(55, 1, 'Backlit Signboard', NULL, NULL, '2023-05-27 05:05:55'),
(56, 1, 'Chopper Table', NULL, NULL, '2023-05-27 05:06:06'),
(57, 1, 'Exhaust Hood', NULL, NULL, '2023-05-27 05:06:15'),
(58, 2, 'Intex Mouse', NULL, NULL, '2023-05-27 05:06:25'),
(59, 1, 'Thermal Receipt Printer', NULL, NULL, '2023-05-27 05:06:37'),
(60, 1, 'PayTM audio scanner', NULL, NULL, '2023-05-27 05:06:46'),
(61, 1, 'Double Burner Chinese Range', NULL, NULL, '2023-05-27 05:06:56'),
(62, 1, 'realme C11 Mobile', NULL, NULL, '2023-05-27 05:07:02'),
(63, 1, 'Fan', NULL, NULL, '2023-05-27 05:07:09'),
(64, 1, 'Steel Rack', NULL, NULL, '2023-05-27 05:07:16'),
(65, 2, 'Laptop Charger', NULL, NULL, '2023-05-27 05:07:27'),
(66, 1, 'Realme Mobile', NULL, NULL, '2023-05-27 05:07:34'),
(67, 1, 'Mobile Charger', NULL, NULL, '2023-05-27 05:07:40'),
(68, 1, 'Safepro Fire Extinguisher', NULL, NULL, '2023-05-27 05:07:49'),
(69, 1, 'HOIN Receipt Printer', NULL, NULL, '2023-05-27 05:07:58'),
(70, 1, 'Tandori Bhatti', NULL, NULL, '2023-05-27 05:08:08'),
(71, 1, 'Exhaust Fan', NULL, NULL, '2023-05-27 05:08:22'),
(72, 1, 'Glass Cabinet', NULL, NULL, '2023-05-27 05:08:30'),
(73, 3, 'Stainless Steel Table', NULL, NULL, '2023-05-27 05:08:38'),
(74, 1, 'Philips Mixer Grinder', NULL, NULL, '2023-05-27 05:08:48'),
(75, 1, 'Haier Deep Freezer', NULL, NULL, '2023-05-27 05:08:56'),
(76, 1, 'Signboard', NULL, NULL, '2023-05-27 05:09:04'),
(77, 1, '3KG Gas', NULL, NULL, '2023-05-27 05:09:15'),
(78, 1, 'Philips Weight Machine', NULL, NULL, '2023-05-27 05:09:30'),
(79, 3, 'Glass Display Cabinet', NULL, NULL, '2023-05-27 05:09:38'),
(80, 1, 'HOIN 58MM Receipt Printer', NULL, NULL, '2023-05-27 05:09:54'),
(81, 1, 'Price Display Board', NULL, NULL, '2023-05-27 05:10:03'),
(82, 1, 'Bajaj Mixer Grinder', NULL, NULL, '2023-05-27 05:10:14'),
(83, 1, 'Western Deep Freezer', NULL, NULL, '2023-05-27 05:10:25'),
(84, 1, '2 Burner Indian Range', NULL, NULL, '2023-05-27 05:10:59'),
(85, 3, 'Chair', NULL, NULL, '2023-05-27 05:15:39'),
(86, 3, 'Table', NULL, NULL, '2023-05-27 05:15:44'),
(87, 1, 'Single Burner Range', NULL, NULL, '2023-05-27 05:15:56'),
(88, 1, '1 Burner Indian Range', NULL, NULL, '2023-05-27 05:16:13'),
(89, 1, 'Stand Fan', NULL, NULL, '2023-05-27 05:16:21'),
(90, 1, 'Iron Rack', NULL, NULL, '2023-05-27 05:16:28'),
(91, 1, 'CCTV', NULL, NULL, '2023-05-27 05:16:35'),
(92, 1, 'Display Cabinet', NULL, NULL, '2023-05-27 05:16:42'),
(93, 1, 'Benmarie', NULL, NULL, '2023-05-27 05:16:51'),
(94, 2, 'Computer Monitor', NULL, NULL, '2023-05-27 05:17:04'),
(95, 3, 'Storage', NULL, NULL, '2023-05-27 05:17:20'),
(96, 3, 'Round Food Table', NULL, NULL, '2023-05-27 05:20:31'),
(97, 3, 'Steel Table', NULL, NULL, '2023-05-27 05:20:38'),
(98, 3, 'Masala Table', NULL, NULL, '2023-05-27 05:20:45'),
(99, 1, 'CCTV Charger', NULL, NULL, '2023-05-27 05:20:52'),
(100, 1, 'Backlit Display Board', NULL, NULL, '2023-05-27 05:20:59'),
(101, 1, 'Wall Fan', NULL, NULL, '2023-05-27 05:21:15'),
(102, 3, 'Steel Rack for Kitchen', NULL, NULL, '2023-05-27 05:21:26'),
(103, 1, 'Blue Star Deep Freezer', NULL, NULL, '2023-05-27 05:21:34'),
(104, 1, '2 Burner Chinese Range', NULL, NULL, '2023-05-27 05:21:44'),
(105, 1, '30Kg Weight Machine', NULL, NULL, '2023-05-27 05:21:58'),
(106, 1, 'Seating Tool', NULL, NULL, '2023-05-27 05:22:12'),
(107, 1, 'Bluetooth Thermal Receipt Printer', NULL, NULL, '2023-05-27 05:22:27'),
(108, 1, 'Narzo50i Smart Phone', NULL, NULL, '2023-05-27 05:22:34'),
(109, 1, 'LG 1 Ton AC', NULL, NULL, '2023-05-27 05:22:43'),
(110, 1, 'Mixer Grinder', NULL, NULL, '2023-05-27 05:22:49'),
(111, 1, 'RO Water Purifier', NULL, NULL, '2023-05-27 05:22:57'),
(112, 2, 'Zebronics Mouse', NULL, NULL, '2023-05-27 05:23:04'),
(113, 1, 'ABC Fire Extinguisher', NULL, NULL, '2023-05-27 05:23:11'),
(114, 1, '40 Inch LED', NULL, NULL, '2023-05-27 05:23:24'),
(115, 1, '65 Inch LED', NULL, NULL, '2023-05-27 05:23:31'),
(116, 1, 'CCTV Adaptor', NULL, NULL, '2023-05-27 05:23:38'),
(117, 1, 'Shawarma Grill Machine', NULL, NULL, '2023-05-27 05:23:45'),
(118, 3, 'Steel Masala Table', NULL, NULL, '2023-05-27 05:24:00'),
(119, 3, 'Storage Table', NULL, NULL, '2023-05-27 05:24:08'),
(120, 3, 'Steel Basin', NULL, NULL, '2023-05-27 05:24:15'),
(121, 1, 'Celfrost Deep Freezer', NULL, NULL, '2023-05-27 05:24:22'),
(122, 1, '3 Burner Indian Range', NULL, NULL, '2023-05-27 05:25:08'),
(123, 1, '3 Burner Chinese Range', NULL, NULL, '2023-05-27 05:25:17'),
(124, 1, '3 Ton Blue Star AC', NULL, NULL, '2023-05-27 05:25:27'),
(125, 1, '8.5 Ton Blue Star AC', NULL, NULL, '2023-05-27 05:25:34'),
(126, 1, 'MetnxItalia LPG Gas Meter', NULL, NULL, '2023-05-27 05:25:51'),
(127, 1, 'LPG Gas Regulator', NULL, NULL, '2023-05-27 05:25:58'),
(128, 1, 'Pressure Gauge for LPG Gas Line', NULL, NULL, '2023-05-27 05:26:07'),
(129, 1, 'Steel Sink at Washing Area', NULL, NULL, '2023-05-27 05:26:18'),
(130, 1, 'Steel Water Valve', NULL, NULL, '2023-05-27 05:26:26'),
(131, 1, 'Small Bainmarie', NULL, NULL, '2023-05-27 05:26:36'),
(132, 1, 'Food Trolley', NULL, NULL, '2023-05-27 05:26:43'),
(133, 3, 'Wooden Glass Top Table', NULL, NULL, '2023-05-27 05:26:51'),
(134, 3, 'Wooden Bench', NULL, NULL, '2023-05-27 05:26:55'),
(135, 3, 'Wooden Chair', NULL, NULL, '2023-05-27 05:26:58'),
(136, 1, 'Cross Flow Air Curtain', NULL, NULL, '2023-05-27 05:27:08'),
(137, 1, 'Cross Air Air Curtain', NULL, NULL, '2023-05-27 05:27:12'),
(139, 1, 'HP Mouse', NULL, NULL, '2023-05-27 05:27:33'),
(140, 1, 'Borosil Jumbo Grill', NULL, NULL, '2023-05-27 05:27:42'),
(141, 1, 'Bamboo Cane Glasstop Table', NULL, NULL, '2023-05-27 05:27:59'),
(142, 1, 'Bamboo Cane Small Chair', NULL, NULL, '2023-05-27 05:28:04'),
(143, 1, 'Fuchka Cart', NULL, NULL, '2023-05-27 05:28:11'),
(144, 1, 'Tea Cart', NULL, NULL, '2023-05-27 05:28:14'),
(145, 1, 'Ghugni Cart', NULL, NULL, '2023-05-27 05:28:21'),
(146, 1, 'Ceiling Fan', NULL, NULL, '2023-05-27 05:28:28'),
(147, 1, 'Vijaypack Wrapping Machine', NULL, NULL, '2023-05-27 05:28:41'),
(148, 1, 'BOSCH Tape Dispencer Gun', NULL, NULL, '2023-05-27 05:28:53'),
(149, 1, 'Sumojay 200K Weight Machine', NULL, NULL, '2023-05-27 05:29:02'),
(150, 1, 'Orpat Electric Kettle', NULL, NULL, '2023-05-27 05:29:10'),
(151, 1, 'Small Weight Machine', NULL, NULL, '2023-05-27 05:29:13'),
(152, 2, 'Computer Printer', NULL, NULL, '2023-05-27 05:37:29'),
(153, 3, 'Iron and ACP made store', NULL, NULL, '2023-05-27 05:29:32'),
(154, 1, 'Panasonic LED', NULL, NULL, '2023-05-27 05:29:41'),
(155, 1, 'Prestige Electric Kettle', NULL, NULL, '2023-05-27 05:29:49'),
(156, 1, 'Temp Control Food Display Cabinet', NULL, NULL, '2023-05-27 05:29:56'),
(157, 2, 'Computer CPU', NULL, NULL, '2023-05-27 05:30:09'),
(158, 2, 'Computer Mouse', NULL, NULL, '2023-05-27 05:30:12'),
(159, 2, 'Computer Keyboard', NULL, NULL, '2023-05-27 05:30:14'),
(160, 2, 'Power Cord', NULL, NULL, '2023-05-27 05:30:22'),
(161, 1, 'Steel made standing food Table', NULL, NULL, '2023-05-27 05:30:37'),
(162, 1, 'Chaigram Standy', NULL, NULL, '2023-05-27 05:30:44'),
(163, 1, 'Voltas Deep Freezer', NULL, NULL, '2023-05-27 05:30:57'),
(164, 1, 'Phillips Weight Machine', NULL, NULL, '2023-05-27 05:31:03'),
(165, 1, 'VC Cooler', NULL, NULL, '2023-05-27 05:31:09'),
(166, 1, '200KG Weight Machine', NULL, NULL, '2023-05-27 05:31:16'),
(167, 2, 'HP Ink Tank Wireless 419 Printer', NULL, NULL, '2023-05-27 05:31:24'),
(168, 1, 'Pigeon Electric Kettle', NULL, NULL, '2023-05-27 05:31:36'),
(169, 1, 'Wall fan', NULL, NULL, '2023-05-27 05:31:47'),
(170, 1, 'Steel water container', NULL, NULL, '2023-05-27 05:31:55'),
(171, 1, 'Small Glass Cabinet', NULL, NULL, '2023-05-27 05:32:05'),
(172, 1, 'Hoin Thermal Printer', NULL, NULL, '2023-05-27 05:33:40'),
(173, 1, 'Electric Kettle', NULL, NULL, '2023-05-27 05:33:48'),
(174, 1, 'AC', NULL, NULL, '2023-05-27 05:33:55'),
(175, 1, 'Induction cooktop', NULL, NULL, '2023-05-27 05:34:02'),
(176, 1, 'Telephone', NULL, NULL, '2023-05-27 05:34:13'),
(177, 2, 'Scanner', NULL, NULL, '2023-05-27 05:34:20'),
(178, 1, 'Smart Phone', NULL, NULL, '2023-05-27 05:34:31'),
(179, 1, 'Vacuum Cleaner', NULL, NULL, '2023-05-27 05:34:43'),
(180, 1, 'TV', NULL, NULL, '2023-05-27 05:34:48'),
(181, 1, 'UPS', NULL, NULL, '2023-05-27 05:34:56'),
(182, 1, 'Fire Extinguisher', NULL, NULL, '2023-05-27 05:35:06'),
(186, 2, 'Beetel GSM Fixed Wireless Phone', NULL, NULL, '2023-05-27 05:35:41'),
(187, 2, 'Glass Door Lock', NULL, NULL, '2023-05-27 05:35:52'),
(188, 2, 'Tab Charger', NULL, NULL, '2023-05-27 05:35:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `asset_movement_timeline`
--
ALTER TABLE `asset_movement_timeline`
  ADD PRIMARY KEY (`amt_id`);

--
-- Indexes for table `asset_requests`
--
ALTER TABLE `asset_requests`
  ADD PRIMARY KEY (`ar_id`);

--
-- Indexes for table `company_profile`
--
ALTER TABLE `company_profile`
  ADD PRIMARY KEY (`comp_id`);

--
-- Indexes for table `outgoing_assets`
--
ALTER TABLE `outgoing_assets`
  ADD PRIMARY KEY (`oa_id`);

--
-- Indexes for table `product_incomming_general_information`
--
ALTER TABLE `product_incomming_general_information`
  ADD PRIMARY KEY (`pigi_id`);

--
-- Indexes for table `product_incomming_stock`
--
ALTER TABLE `product_incomming_stock`
  ADD PRIMARY KEY (`pis_id`);

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `tbl_product_add`
--
ALTER TABLE `tbl_product_add`
  ADD PRIMARY KEY (`paid`);

--
-- Indexes for table `tbl_pro_store`
--
ALTER TABLE `tbl_pro_store`
  ADD PRIMARY KEY (`psid`);

--
-- Indexes for table `tbl_subcategory`
--
ALTER TABLE `tbl_subcategory`
  ADD PRIMARY KEY (`scid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `asset_movement_timeline`
--
ALTER TABLE `asset_movement_timeline`
  MODIFY `amt_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `asset_requests`
--
ALTER TABLE `asset_requests`
  MODIFY `ar_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `company_profile`
--
ALTER TABLE `company_profile`
  MODIFY `comp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `outgoing_assets`
--
ALTER TABLE `outgoing_assets`
  MODIFY `oa_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_incomming_general_information`
--
ALTER TABLE `product_incomming_general_information`
  MODIFY `pigi_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `product_incomming_stock`
--
ALTER TABLE `product_incomming_stock`
  MODIFY `pis_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `cid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_product_add`
--
ALTER TABLE `tbl_product_add`
  MODIFY `paid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tbl_subcategory`
--
ALTER TABLE `tbl_subcategory`
  MODIFY `scid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=189;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
