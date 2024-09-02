
-- Adding Anandam NGO
-- ***********************************************
INSERT INTO `customer` (`cus_id`, `cus_userId`, `cus_name`, `cus_email`, `cus_phone`, `cus_pwd`, `cus_cpwd`, `cus_role`, `crtd_date`, `modi_date`, `status`, `flag`, `ngo_link`, `otp`, `verification_status`, `cus_contact_name`, `cus_address`, `cus_field_of_service`, `cus_image`, `resident_count`) VALUES
(379, 'NGO724', 'Anandam Old Age Home', 'anandamtrust2003@gmail.com', '9841819889', '782f82bca258130be976ad18dea6ab3d', 'anandam', 1, '2020-12-31 21:05:26', '2020-12-31 21:05:26', 1, '1', 'https://anandamoldagehome.org/', '4939', 1, 'jayanthi', 'Anna Street, Gangai Nagar, Kallikuppam,\r\nAmbattur, Chennai – 600 053', '6', 'http://igiver.org/ngoapp/ngo_logo/anandam.png', 105);

-- Add new table for NGO APP share Text and Images
-- ***********************************************
-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 31, 2020 at 04:55 PM
-- Server version: 5.6.41-84.1
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `igiver_ngoapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `ngo_social_share_msg_template`
--

CREATE TABLE `ngo_social_share_msg_template` (
  `id` int(11) NOT NULL,
  `ngo_userid` varchar(10) NOT NULL COMMENT 'NGO ID FK Customer',
  `ngo_name` varchar(100) NOT NULL,
  `share_text` varchar(500) NOT NULL,
  `share_image_url` varchar(200) NOT NULL,
  `share_link` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ngo_social_share_msg_template`
--

INSERT INTO `ngo_social_share_msg_template` (`id`, `ngo_userid`, `ngo_name`, `share_text`, `share_image_url`, `share_link`) VALUES
(3, 'NGO150', 'Aramporul', 'Dear Donor,  Our NGO is a part of iGiver family. iGiver is a new way to help us anonymously, directly by giving books, groceries, vegetables etc to our Home.I am personally requesting you to help us by giving Vegetables through this link.\r\n\r\n ', 'productImage/homeimage.png', 'https://igiver.org/product/veg300/'),
(4, 'NGO604', 'Sri Arunodayam', 'Dear Donor,  Our NGO is a part of iGiver family. iGiver is a new way to help us anonymously, directly by giving books, groceries, vegetables etc to our Home.I am personally requesting you to help us by giving Vegetables through this link.\r\n\r\n ', 'productImage/homeimage.png', 'https://igiver.org/product/veg300/'),
(5, 'NGO724', 'Anandam Old Age Home', 'Dear Donor,  Our NGO is a part of iGiver family. iGiver is a new way to help us anonymously, directly by giving books, groceries, vegetables etc to our Home.I am personally requesting you to help us by giving Vegetables through this link.\r\n\r\n ', 'productImage/homeimage.png', 'https://igiver.org/product/veg300/'),
(6, 'NGO107', 'Surabi Trust', 'Dear Donor,  Our NGO is a part of iGiver family. iGiver is a new way to help us anonymously, directly by giving books, groceries, vegetables etc to our Home.I am personally requesting you to help us by giving Vegetables through this link.\r\n\r\n ', 'productImage/homeimage.png', 'https://igiver.org/product/veg300/');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ngo_social_share_msg_template`
--
ALTER TABLE `ngo_social_share_msg_template`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ngo_social_share_msg_template`
--
ALTER TABLE `ngo_social_share_msg_template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;





-- Campaign Table
-- ***********************************************

-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 31, 2020 at 04:21 PM
-- Server version: 5.6.41-84.1
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `igiver_ngoapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `focus_campaigns`
--

CREATE TABLE `focus_campaigns` (
  `id` int(11) NOT NULL,
  `campaign_name` varchar(100) NOT NULL,
  `campaign_desc` varchar(500) NOT NULL,
  `retail_vendor` varchar(5) NOT NULL,
  `active` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `sku` varchar(50) NOT NULL,
  `target_units` int(11) NOT NULL,
  `update_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `focus_campaigns`
--

INSERT INTO `focus_campaigns` (`id`, `campaign_name`, `campaign_desc`, `retail_vendor`, `active`, `start_date`, `end_date`, `sku`, `target_units`, `update_date`) VALUES
(1, 'Veg300', 'Our Goal is to Donate \r\n300 KG vegetables \r\nto 3 NGO in Chennai \r\nin 21 Days!', 'OFM', 1, '2021-01-01', '2021-01-21', 'SKUTEMP', 300, '2020-12-30 19:07:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `focus_campaigns`
--
ALTER TABLE `focus_campaigns`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `focus_campaigns`
--
ALTER TABLE `focus_campaigns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


-- Campign Performance. To track shares
-- ***********************************************
-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 31, 2020 at 04:28 PM
-- Server version: 5.6.41-84.1
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `igiver_ngoapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `ngo_campaign_performance`
--

CREATE TABLE `ngo_campaign_performance` (
  `id` int(11) NOT NULL,
  `campaign_id` int(11) NOT NULL COMMENT 'FK focus_campaigns',
  `ngo_id` varchar(10) NOT NULL,
  `medium` int(11) NOT NULL COMMENT 'App share, FB share , Email etc',
  `share_count` int(11) NOT NULL,
  `upd_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ngo_campaign_performance`
--

INSERT INTO `ngo_campaign_performance` (`id`, `campaign_id`, `ngo_id`, `medium`, `share_count`, `upd_date`) VALUES
(1, 1, 'NGO107', 1, 0, '2020-12-31 16:26:09'),
(2, 1, 'NGO604', 1, 0, '2020-12-31 16:27:06'),
(3, 1, 'NGO724', 1, 0, '2020-12-31 16:27:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ngo_campaign_performance`
--
ALTER TABLE `ngo_campaign_performance`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ngo_campaign_performance`
--
ALTER TABLE `ngo_campaign_performance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
