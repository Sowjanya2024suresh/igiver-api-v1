-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 18, 2020 at 12:37 PM
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
-- Table structure for table `retail_vendor_products`
--

DROP TABLE IF EXISTS `retail_vendor_products`;
CREATE TABLE `retail_vendor_products` (
  `id` int(11) NOT NULL,
  `retail_code` varchar(5) NOT NULL,
  `sku` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `unit_price` varchar(10) NOT NULL,
  `image_url` varchar(200) NOT NULL,
  `updatedate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `retail_vendor_products`
--

INSERT INTO `retail_vendor_products` (`id`, `retail_code`, `sku`, `name`, `description`, `unit_price`, `image_url`, `updatedate`) VALUES
(1, 'OFM', 'SKUIGIVER89', 'Combo Kit 1', 'Vegetables Kit', '9', 'http://igiver.org//ngoapp/donorreatilorders/product_images/skuigiver89.png\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n', '2020-10-15 17:36:18'),
(2, 'OFM', 'SKUIGIVER88', 'Combo Kit 2', 'Groceries and Vegetables Kit', '10', 'http://igiver.org//ngoapp/donorreatilorders/product_images/skuigiver88.png', '2020-10-15 17:36:18'),
(3, 'OFM', 'SKUIGIVER87', 'Combo Kit 3', 'Groceries and Vegetables Kit', '11', 'http://igiver.org//ngoapp/donorreatilorders/product_images/skuigiver87.png', '2020-10-15 17:36:18'),
(4, 'OFM', 'SKUIGIVER86', 'Combo Kit 4', 'Groceries and Vegetables Kit', '12', 'http://igiver.org//ngoapp/donorreatilorders/product_images/skuigiver86.png', '2020-10-15 17:36:18'),
(5, 'NAL', 'SKUIGIVER1', 'Breakfast Option 1', 'Idly 3 Nos, Vada 1 Nos, Sambar & Chutney', '9', 'http://igiver.org//ngoapp/donorreatilorders/product_images/breakfast50.jpg', '2020-10-15 17:36:18'),
(6, 'NAL', 'SKUIGIVER2', 'Breakfast Option 2', 'Pongal, Vada, Sambar & Chutneys', '10', 'http://igiver.org//ngoapp/donorreatilorders/product_images/breakfast70.jpg', '2020-10-15 17:36:18'),
(7, 'NAL', 'SKUIGIVER3', 'Breakfast Option 3', 'Sweet, Idly, Pongal, Vada, sambar and Chutneys', '11', 'http://igiver.org//ngoapp/donorreatilorders/product_images/maha-and-ramayana.png\r\n', '2020-10-15 17:36:18'),
(5090, 'ACK', '11661', 'Mahabharata and Valmikis Ramayana ', 'Mahabharata (3 vol set) + Valmikis Ramayana (6 vol set)', '3949\r\n', 'http://igiver.org/ngoapp/donorreatilorders/product_images/maha-and-ramayana.png\r\n\r\n\r\n', '2020-10-15 17:36:18'),
(5091, 'ACK', '11669', 'Tinkle Trio Collection', 'Tinkle Trio Collection (Suppandi + Shambu + Tantri Essential Packs)', '2986\r\n', 'http://igiver.org/ngoapp/donorreatilorders/product_images/trio-collection.jpg', '2020-10-15 17:36:18'),
(5092, 'ACK', '11673', 'Tinkle Origins (Pack of 5)', 'Tinkle Origins (Pack of 5)', '1284', 'http://igiver.org/ngoapp/donorreatilorders/product_images/origins-pack-of-5.jpg', '2020-10-15 17:36:18'),
(5093, 'ACK', '11674', 'New Releases (Tinkle Gold, Tinkle Holiday Special & Vikram Sarabhai)', 'New Releases (Tinkle Gold, Tinkle Holiday Special & Vikram Sarabhai)', '502', 'http://igiver.org/ngoapp/donorreatilorders/product_images/latest-releases.png', '2020-10-15 17:36:18'),
(5094, 'ACK', '11676', '3-in1 Assorted Pack of 24', '3-in1 Assorted Pack of 24', '1781', 'http://igiver.org/ngoapp/donorreatilorders/product_images/3-in-1-Pack-of-12-Assorted.jpg', '2020-10-15 17:36:18'),
(5095, 'PRA', 'SKUIGIVER99', 'English Book set', '7-10 books in English across genres and reading levels', '9', 'http://igiver.org//ngoapp/donorreatilorders/product_images/Englishbookset.jpg', '2020-10-15 17:36:18'),
(5096, 'PRA', 'SKUIGIVER98', 'Tamil Book set', '7-10 books in Tamil actoss genres and reading levels', '9', 'http://igiver.org//ngoapp/donorreatilorders/product_images/Tamilbookset.jpg', '2020-10-15 17:36:18'),
(5097, 'PRA', 'SKUIGIVER97', 'English Early Literacy Box', '20 Level-1 English Storybooks, 10 small Story Cards, 5 big Story Cards, 5 Wordless Story Cards and 2 Poster Books', '9', 'http://igiver.org//ngoapp/donorreatilorders/product_images/Earlyliteracybox.jpg', '2020-10-15 17:36:18'),
(5098, 'PRA', 'SKUIGIVER96', 'Library in a Classroom kit', '90-100 Books in English and Tamil across genres and reading levels packaged in a portable collapsible kit', '9', 'http://igiver.org//ngoapp/donorreatilorders/product_images/LibraryinaClassroomkit.jpg', '2020-10-15 17:36:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `retail_vendor_products`
--
ALTER TABLE `retail_vendor_products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `retail_vendor_products`
--
ALTER TABLE `retail_vendor_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5099;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
