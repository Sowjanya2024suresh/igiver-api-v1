-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 01, 2021 at 03:33 PM
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
-- Table structure for table `delivery_dist_matrix`
--

DROP TABLE IF EXISTS `delivery_dist_matrix`;
CREATE TABLE `delivery_dist_matrix` (
  `id` int(11) NOT NULL,
  `cus_id` int(11) NOT NULL DEFAULT '0',
  `cus_userId` varchar(200) NOT NULL,
  `cus_name` varchar(255) NOT NULL,
  `latitude` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `longitude` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `retail_code` varchar(5) NOT NULL,
  `location_lat_long` varchar(100) NOT NULL,
  `delivery_rad_km` decimal(10,0) NOT NULL,
  `distance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `delivery_y_n` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `delivery_dist_matrix`
--

INSERT INTO `delivery_dist_matrix` (`id`, `cus_id`, `cus_userId`, `cus_name`, `latitude`, `longitude`, `retail_code`, `location_lat_long`, `delivery_rad_km`, `distance`, `delivery_y_n`) VALUES
(1, 6, 'NGO287', 'Sky foundation', '12.6055267', '79.9198331', 'OFM', '13.08972581661508, 80.19329463316126', 10, 68.02, '0'),
(2, 6, 'NGO287', 'Sky foundation', '12.6055267', '79.9198331', 'NAL', '12.947965304220148, 80.19379018408405', 10, 54.50, '0'),
(3, 6, 'NGO287', 'Sky foundation', '12.6055267', '79.9198331', 'ACK', '19.36092225543336, 72.88190419733871', 0, 1344.86, '1'),
(4, 6, 'NGO287', 'Sky foundation', '12.6055267', '79.9198331', 'PRA', '13.075629575982685, 77.66068046297134', 0, 308.95, '1'),
(8, 6, 'NGO287', 'Sky foundation', '12.6055267', '79.9198331', 'ABK', '13.03069966406199, 80.25667781799422', 10, 65.85, '0'),
(9, 8, 'NGO403', 'Cheshire home india chennai', '12.9894876', '80.251285', 'OFM', '13.08972581661508, 80.19329463316126', 10, 18.09, '0'),
(10, 8, 'NGO403', 'Cheshire home india chennai', '12.9894876', '80.251285', 'NAL', '12.947965304220148, 80.19379018408405', 10, 11.12, '0'),
(11, 8, 'NGO403', 'Cheshire home india chennai', '12.9894876', '80.251285', 'ACK', '19.36092225543336, 72.88190419733871', 0, 1363.28, '1'),
(12, 8, 'NGO403', 'Cheshire home india chennai', '12.9894876', '80.251285', 'PRA', '13.075629575982685, 77.66068046297134', 0, 327.37, '1'),
(16, 8, 'NGO403', 'Cheshire home india chennai', '12.9894876', '80.251285', 'ABK', '13.03069966406199, 80.25667781799422', 10, 7.02, '1'),
(17, 23, 'NGO741', 'Sevalaya', '13.042896', '80.26396', 'OFM', '13.08972581661508, 80.19329463316126', 10, 11.95, '0'),
(18, 23, 'NGO741', 'Sevalaya', '13.042896', '80.26396', 'NAL', '12.947965304220148, 80.19379018408405', 10, 18.33, '0'),
(19, 23, 'NGO741', 'Sevalaya', '13.042896', '80.26396', 'ACK', '19.36092225543336, 72.88190419733871', 0, 1364.86, '1'),
(20, 23, 'NGO741', 'Sevalaya', '13.042896', '80.26396', 'PRA', '13.075629575982685, 77.66068046297134', 0, 328.95, '1'),
(24, 23, 'NGO741', 'Sevalaya', '13.042896', '80.26396', 'ABK', '13.03069966406199, 80.25667781799422', 10, 2.20, '1'),
(25, 25, 'NGO760', 'Share and care children welfare society', '13.101106', '80.238031', 'OFM', '13.08972581661508, 80.19329463316126', 10, 7.35, '1'),
(26, 25, 'NGO760', 'Share and care children welfare society', '13.101106', '80.238031', 'NAL', '12.947965304220148, 80.19379018408405', 10, 22.60, '0'),
(27, 25, 'NGO760', 'Share and care children welfare society', '13.101106', '80.238031', 'ACK', '19.36092225543336, 72.88190419733871', 0, 1363.39, '1'),
(28, 25, 'NGO760', 'Share and care children welfare society', '13.101106', '80.238031', 'PRA', '13.075629575982685, 77.66068046297134', 0, 327.48, '1'),
(32, 25, 'NGO760', 'Share and care children welfare society', '13.101106', '80.238031', 'ABK', '13.03069966406199, 80.25667781799422', 10, 10.31, '0'),
(33, 29, 'NGO321', 'Aram home for special children', '13.148583', '80.205861', 'OFM', '13.08972581661508, 80.19329463316126', 10, 8.82, '1'),
(34, 29, 'NGO321', 'Aram home for special children', '13.148583', '80.205861', 'NAL', '12.947965304220148, 80.19379018408405', 10, 32.51, '0'),
(35, 29, 'NGO321', 'Aram home for special children', '13.148583', '80.205861', 'ACK', '19.36092225543336, 72.88190419733871', 0, 1364.15, '1'),
(36, 29, 'NGO321', 'Aram home for special children', '13.148583', '80.205861', 'PRA', '13.075629575982685, 77.66068046297134', 0, 328.24, '1'),
(40, 29, 'NGO321', 'Aram home for special children', '13.148583', '80.205861', 'ABK', '13.03069966406199, 80.25667781799422', 10, 19.53, '0'),
(41, 36, 'NGO007', 'Communication action dvlpt liberative and education', '10.380525', '78.816793', 'OFM', '13.08972581661508, 80.19329463316126', 10, 376.16, '0'),
(42, 36, 'NGO007', 'Communication action dvlpt liberative and education', '10.380525', '78.816793', 'NAL', '12.947965304220148, 80.19379018408405', 10, 362.64, '0'),
(43, 36, 'NGO007', 'Communication action dvlpt liberative and education', '10.380525', '78.816793', 'ACK', '19.36092225543336, 72.88190419733871', 0, 1410.11, '1'),
(44, 36, 'NGO007', 'Communication action dvlpt liberative and education', '10.380525', '78.816793', 'PRA', '13.075629575982685, 77.66068046297134', 0, 416.87, '1'),
(48, 36, 'NGO007', 'Communication action dvlpt liberative and education', '10.380525', '78.816793', 'ABK', '13.03069966406199, 80.25667781799422', 10, 373.99, '0'),
(49, 37, 'NGO707', 'Vanavil Trust', '10.7492701', '79.784245', 'OFM', '13.08972581661508, 80.19329463316126', 10, 316.16, '0'),
(50, 37, 'NGO707', 'Vanavil Trust', '10.7492701', '79.784245', 'NAL', '12.947965304220148, 80.19379018408405', 10, 296.53, '0'),
(51, 37, 'NGO707', 'Vanavil Trust', '10.7492701', '79.784245', 'ACK', '19.36092225543336, 72.88190419733871', 0, 1486.93, '1'),
(52, 37, 'NGO707', 'Vanavil Trust', '10.7492701', '79.784245', 'PRA', '13.075629575982685, 77.66068046297134', 0, 493.69, '1'),
(56, 37, 'NGO707', 'Vanavil Trust', '10.7492701', '79.784245', 'ABK', '13.03069966406199, 80.25667781799422', 10, 299.85, '0'),
(57, 82, 'NGO563', 'The Akshayapatra Foundation', '12.9819347', '80.242739', 'OFM', '13.08972581661508, 80.19329463316126', 10, 20.38, '0'),
(58, 82, 'NGO563', 'The Akshayapatra Foundation', '12.9819347', '80.242739', 'NAL', '12.947965304220148, 80.19379018408405', 10, 7.71, '1'),
(59, 82, 'NGO563', 'The Akshayapatra Foundation', '12.9819347', '80.242739', 'ACK', '19.36092225543336, 72.88190419733871', 0, 1362.81, '1'),
(60, 82, 'NGO563', 'The Akshayapatra Foundation', '12.9819347', '80.242739', 'PRA', '13.075629575982685, 77.66068046297134', 0, 326.90, '1'),
(64, 82, 'NGO563', 'The Akshayapatra Foundation', '12.9819347', '80.242739', 'ABK', '13.03069966406199, 80.25667781799422', 10, 9.30, '1'),
(65, 83, 'NGO150', 'Aramporul', '13.04905', '80.217434', 'OFM', '13.08972581661508, 80.19329463316126', 10, 6.49, '1'),
(66, 83, 'NGO150', 'Aramporul', '13.04905', '80.217434', 'NAL', '12.947965304220148, 80.19379018408405', 10, 14.70, '0'),
(67, 83, 'NGO150', 'Aramporul', '13.04905', '80.217434', 'ACK', '19.36092225543336, 72.88190419733871', 0, 1359.61, '1'),
(68, 83, 'NGO150', 'Aramporul', '13.04905', '80.217434', 'PRA', '13.075629575982685, 77.66068046297134', 0, 323.71, '1'),
(72, 83, 'NGO150', 'Aramporul', '13.04905', '80.217434', 'ABK', '13.03069966406199, 80.25667781799422', 10, 6.08, '1'),
(73, 95, 'NGO318', 'Abode of joy', '12.8530692', '80.0530026', 'OFM', '13.08972581661508, 80.19329463316126', 10, 37.12, '0'),
(74, 95, 'NGO318', 'Abode of joy', '12.8530692', '80.0530026', 'NAL', '12.947965304220148, 80.19379018408405', 10, 23.60, '0'),
(75, 95, 'NGO318', 'Abode of joy', '12.8530692', '80.0530026', 'ACK', '19.36092225543336, 72.88190419733871', 0, 1346.15, '1'),
(76, 95, 'NGO318', 'Abode of joy', '12.8530692', '80.0530026', 'PRA', '13.075629575982685, 77.66068046297134', 0, 310.24, '1'),
(80, 95, 'NGO318', 'Abode of joy', '12.8530692', '80.0530026', 'ABK', '13.03069966406199, 80.25667781799422', 10, 34.95, '0'),
(81, 187, 'NGO030', 'Annai theresa disability trust', '11.5573094', '79.5525357', 'OFM', '13.08972581661508, 80.19329463316126', 10, 202.04, '0'),
(82, 187, 'NGO030', 'Annai theresa disability trust', '11.5573094', '79.5525357', 'NAL', '12.947965304220148, 80.19379018408405', 10, 188.51, '0'),
(83, 187, 'NGO030', 'Annai theresa disability trust', '11.5573094', '79.5525357', 'ACK', '19.36092225543336, 72.88190419733871', 0, 1386.18, '1'),
(84, 187, 'NGO030', 'Annai theresa disability trust', '11.5573094', '79.5525357', 'PRA', '13.075629575982685, 77.66068046297134', 0, 392.94, '1'),
(88, 187, 'NGO030', 'Annai theresa disability trust', '11.5573094', '79.5525357', 'ABK', '13.03069966406199, 80.25667781799422', 10, 200.26, '0'),
(89, 222, 'NGO799', 'Child voice', '10.164806', '77.850889', 'OFM', '13.08972581661508, 80.19329463316126', 10, 461.17, '0'),
(90, 222, 'NGO799', 'Child voice', '10.164806', '77.850889', 'NAL', '12.947965304220148, 80.19379018408405', 10, 447.65, '0'),
(91, 222, 'NGO799', 'Child voice', '10.164806', '77.850889', 'ACK', '19.36092225543336, 72.88190419733871', 0, 1420.18, '1'),
(92, 222, 'NGO799', 'Child voice', '10.164806', '77.850889', 'PRA', '13.075629575982685, 77.66068046297134', 0, 426.94, '1'),
(96, 222, 'NGO799', 'Child voice', '10.164806', '77.850889', 'ABK', '13.03069966406199, 80.25667781799422', 10, 459.00, '0'),
(97, 273, 'NGO604', 'Sri Arunodayam', '13.1246008', '80.2005151', 'OFM', '13.08972581661508, 80.19329463316126', 10, 4.84, '1'),
(98, 273, 'NGO604', 'Sri Arunodayam', '13.1246008', '80.2005151', 'NAL', '12.947965304220148, 80.19379018408405', 10, 23.82, '0'),
(99, 273, 'NGO604', 'Sri Arunodayam', '13.1246008', '80.2005151', 'ACK', '19.36092225543336, 72.88190419733871', 0, 1360.89, '1'),
(100, 273, 'NGO604', 'Sri Arunodayam', '13.1246008', '80.2005151', 'PRA', '13.075629575982685, 77.66068046297134', 0, 324.98, '1'),
(104, 273, 'NGO604', 'Sri Arunodayam', '13.1246008', '80.2005151', 'ABK', '13.03069966406199, 80.25667781799422', 10, 16.63, '0'),
(105, 274, 'NGO888', 'tanker foundation', '13.0249595', '80.1342521', 'OFM', '13.08972581661508, 80.19329463316126', 10, 13.58, '0'),
(106, 274, 'NGO888', 'tanker foundation', '13.0249595', '80.1342521', 'NAL', '12.947965304220148, 80.19379018408405', 10, 16.89, '0'),
(107, 274, 'NGO888', 'tanker foundation', '13.0249595', '80.1342521', 'ACK', '19.36092225543336, 72.88190419733871', 0, 1349.04, '1'),
(108, 274, 'NGO888', 'tanker foundation', '13.0249595', '80.1342521', 'PRA', '13.075629575982685, 77.66068046297134', 0, 313.13, '1'),
(112, 274, 'NGO888', 'tanker foundation', '13.0249595', '80.1342521', 'ABK', '13.03069966406199, 80.25667781799422', 10, 18.71, '0'),
(113, 278, 'NGO161', 'Sankalp Beautiful World', '13.1211552579', '80.2097362418', 'OFM', '13.08972581661508, 80.19329463316126', 10, 6.14, '1'),
(114, 278, 'NGO161', 'Sankalp Beautiful World', '13.1211552579', '80.2097362418', 'NAL', '12.947965304220148, 80.19379018408405', 10, 25.12, '0'),
(115, 278, 'NGO161', 'Sankalp Beautiful World', '13.1211552579', '80.2097362418', 'ACK', '19.36092225543336, 72.88190419733871', 0, 1362.18, '1'),
(116, 278, 'NGO161', 'Sankalp Beautiful World', '13.1211552579', '80.2097362418', 'PRA', '13.075629575982685, 77.66068046297134', 0, 326.28, '1'),
(120, 278, 'NGO161', 'Sankalp Beautiful World', '13.1211552579', '80.2097362418', 'ABK', '13.03069966406199, 80.25667781799422', 10, 14.72, '0'),
(121, 205, 'NGO320', 'Golden butterflies', '13.086045345', '80.2322722264', 'OFM', '13.08972581661508, 80.19329463316126', 10, 4.94, '1'),
(122, 205, 'NGO320', 'Golden butterflies', '13.086045345', '80.2322722264', 'NAL', '12.947965304220148, 80.19379018408405', 10, 20.88, '0'),
(123, 205, 'NGO320', 'Golden butterflies', '13.086045345', '80.2322722264', 'ACK', '19.36092225543336, 72.88190419733871', 0, 1360.09, '1'),
(124, 205, 'NGO320', 'Golden butterflies', '13.086045345', '80.2322722264', 'PRA', '13.075629575982685, 77.66068046297134', 0, 324.19, '1'),
(128, 205, 'NGO320', 'Golden butterflies', '13.086045345', '80.2322722264', 'ABK', '13.03069966406199, 80.25667781799422', 10, 8.59, '1'),
(129, 379, 'NGO724', 'Anandam Old Age Home', '13.1312357984', '80.1750596264', 'OFM', '13.08972581661508, 80.19329463316126', 10, 7.98, '1'),
(130, 379, 'NGO724', 'Anandam Old Age Home', '13.1312357984', '80.1750596264', 'NAL', '12.947965304220148, 80.19379018408405', 10, 26.96, '0'),
(131, 379, 'NGO724', 'Anandam Old Age Home', '13.1312357984', '80.1750596264', 'ACK', '19.36092225543336, 72.88190419733871', 0, 1360.48, '1'),
(132, 379, 'NGO724', 'Anandam Old Age Home', '13.1312357984', '80.1750596264', 'PRA', '13.075629575982685, 77.66068046297134', 0, 324.57, '1'),
(136, 379, 'NGO724', 'Anandam Old Age Home', '13.1312357984', '80.1750596264', 'ABK', '13.03069966406199, 80.25667781799422', 10, 19.77, '0'),
(137, 380, 'NGO915', 'Health and Education Amelioration for Rural Trust', '13.062611', '80.2753293', 'OFM', '13.08972581661508, 80.19329463316126', 10, 11.61, '0'),
(138, 380, 'NGO915', 'Health and Education Amelioration for Rural Trust', '13.062611', '80.2753293', 'NAL', '12.947965304220148, 80.19379018408405', 10, 18.90, '0'),
(139, 380, 'NGO915', 'Health and Education Amelioration for Rural Trust', '13.062611', '80.2753293', 'ACK', '19.36092225543336, 72.88190419733871', 0, 1364.52, '1'),
(140, 380, 'NGO915', 'Health and Education Amelioration for Rural Trust', '13.062611', '80.2753293', 'PRA', '13.075629575982685, 77.66068046297134', 0, 328.61, '1'),
(144, 380, 'NGO915', 'Health and Education Amelioration for Rural Trust', '13.062611', '80.2753293', 'ABK', '13.03069966406199, 80.25667781799422', 10, 5.15, '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `delivery_dist_matrix`
--
ALTER TABLE `delivery_dist_matrix`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `delivery_dist_matrix`
--
ALTER TABLE `delivery_dist_matrix`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


ALTER TABLE `customer` ADD `reminderid` VARCHAR(256) NOT NULL DEFAULT '0' ;


-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 01, 2021 at 03:49 PM
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


INSERT INTO `settings` (`id`, `name`, `value`, `status`) VALUES
(4, 'campaign_image_url', 'productImage/homeimage.png', '1'),
(5, 'campaign_redirect_url', 'https://igiver.org/product/veg300/', '1');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 01, 2021 at 04:39 PM
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
-- Table structure for table `retail_vendor`
--

DROP TABLE IF EXISTS `retail_vendor`;
CREATE TABLE `retail_vendor` (
  `id` int(11) NOT NULL,
  `retail_code` varchar(5) NOT NULL,
  `retail_name` varchar(100) NOT NULL,
  `authcode` varchar(10) NOT NULL,
  `website` varchar(50) NOT NULL,
  `contact_person` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `active` int(1) NOT NULL,
  `payment_gateway` varchar(5) NOT NULL COMMENT 'SELF/INST',
  `client_id` varchar(100) NOT NULL COMMENT 'INSTA Value',
  `client_secret` varchar(200) NOT NULL COMMENT 'INSTA Value',
  `upddate` datetime NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `logo_image` varchar(200) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `location_lat_long` varchar(100) NOT NULL,
  `delivery_rad_km` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `retail_vendor`
--

INSERT INTO `retail_vendor` (`id`, `retail_code`, `retail_name`, `authcode`, `website`, `contact_person`, `email`, `mobile`, `active`, `payment_gateway`, `client_id`, `client_secret`, `upddate`, `category`, `logo_image`, `description`, `location_lat_long`, `delivery_rad_km`) VALUES
(1, 'OFM', 'Organic Farmers Market', '1234567890', 'www.ofmtn.in', 'Nagaraj', 'nagas1980@gmail.com', '9094718909', 1, 'INST', 'yto5sGYbn5jNRcQGeYTTLKbDEWj3ZHO3xCtvYYHo', 'lJMYT5BrgmsN0tAzKFvXvhHJ2ejXvFF5gFWM09tS1baz7PHO1XdEIKwipocBhjLyRqlepOFgu03wU8vhdQ8L03tNMBL9UnuiAvEsApfkVmZ5nZBjw93Lqzig4INM0VPl', '2020-10-15 16:55:25', 'Groceries', 'donorreatilorders/product_images/retail_partner_logo/ofm.png', 'OFM is a collective initiative by a group of organic farming enthusiasts with the aim to Guarantee consistent, continuous availability of safe food and ensure fair pricing of organic products for both, the farmers and the consumers', '13.08972581661508, 80.19329463316126', 10),
(2, 'NAL', 'Nala Catering', '7396732400', 'https://www.nala.co.in/', 'Mr Giri', 'raghav@lokas.info', '9790840599', 1, 'INST', 'JSUrqxp7KtaMcOrm60SfjJd9kUAqpqvNN9Ba6615', 'Vb2gjbBoVKQkrzRgIFT6GU3WtAu0O1Qo86j0oqENbryIYCWiv1PLmALQSiG9BRchc85ms5pl8wqg8GJgbrqakSpuKhejDV0k7bkxw0kWXfLuIzjzBEMijtsiS8NAvHGA', '2020-10-30 20:12:32', 'Catering', 'donorreatilorders/product_images/retail_partner_logo/nala.png', 'We are the best when it comes to cooking tasty food and we prepare it with care & passion. Experience our unique ‘Nala Bhaga’ specially made for our Gods and Taste Happiness with Nala.', '12.947965304220148, 80.19379018408405', 10),
(5, 'ACK', 'Amar Chitra Katha', '7200011175', 'https://www.amarchitrakatha.com/', 'Valentio', 'nidhishanker.modi@sunarctechnologies.com', '9860407979', 1, 'SELF', '', '', '2020-11-27 18:56:14', 'Books', 'donorreatilorders/product_images/retail_partner_logo/ack.jpg', 'Amar Chitra Katha, is an Indian publisher of graphic novels and comics. Most of them are based on religious legends and epics, historical figures and biographies, folktales and cultural stories. The company was founded in 1967 by Anant Pai. ', '19.36092225543336, 72.88190419733871', 0),
(6, 'PRA', 'Pratham Bookss', '7200011123', 'https://prathambooks.org/', 'Vivek', 'info@igiver.org', '9620483634', 1, 'INST', 'ciVcNd2M4gJSWUGGkPSFh6aAmraCSVLuq8J5hTcY', 'AeozwHgSu6qMwnNkzFv8S6wHhewYR34vShMwcyd7egTZyQDz812hlLJ87VaYwe94yhcJAb1qlzhE2sFwswl96XhAh9H9Vt7gZzpt1AqLxENqTr77cR8R0FPclWbK2j2t', '2020-11-27 18:56:14', 'Books', 'donorreatilorders/product_images/retail_partner_logo/pratam.png', 'Pratham Books is a leading nonprofit bringing storybooks to children across India in their mother tongue languages. Learn more, donate, and get involved.', '13.075629575982685, 77.66068046297134', 0),
(10, 'ABK', 'Ambika Appalam Depot', '1234567890', 'http://ambikaappalamdepot.com/', 'Ramdas', 'Luzambikaappalamdepotluzambika@gmail.com', '7200011175', 1, 'INST', 'PgKqAOkPR0KrADTO7cSXtmnFolIdxEapC070dR3T', 'kphIP2jvQppM5sWGPQFurh6aXTA0KzTMRBJXrWT77adDQCfecQ1qBIfz8Nn8gpnD0sxk1Q79eOSeF2McBcKSeEgoEQtzsD1hTFWaMN0AOuDah47oB8BD9kBToP9aVx4e', '2020-10-15 16:55:25', 'Groceries', 'donorreatilorders/product_images/retail_partner_logo/amb.png', 'Staying true to our love for the Indian tradition, we blend authentic flavours with a homely touch that reminds people of flavourful hearty meals cooked by their mother. ', '13.03069966406199, 80.25667781799422', 10);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `retail_vendor`
--
ALTER TABLE `retail_vendor`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `retail_vendor`
--
ALTER TABLE `retail_vendor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
