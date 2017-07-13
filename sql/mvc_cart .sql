-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 16, 2017 at 01:17 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mvc_cart`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
`order_id` int(11) NOT NULL,
  `order_date` datetime NOT NULL,
  `order_product_id` int(11) NOT NULL,
  `order_user_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_date`, `order_product_id`, `order_user_id`) VALUES
(1, '2017-06-14 00:00:00', 1, 1),
(2, '2017-06-16 13:14:54', 1, 2),
(3, '2017-06-16 13:14:55', 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
`product_id` int(11) NOT NULL,
  `product_image` varchar(80) NOT NULL,
  `product_title` varchar(80) NOT NULL,
  `product_desc` varchar(255) NOT NULL,
  `product_price` double NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_image`, `product_title`, `product_desc`, `product_price`) VALUES
(1, 'img/ahr0cdovl2ltywdlcy5py2vjyxquyml6l2ltzy9nywxszxj5lzmymda2mzu5xzcxoduuanbn.jpg', 'HP 250 G5', '25.60", HD, Intel Pentium N3710, 4GB, SSD', 329),
(2, 'img/X0N33EA-ABD_2_1750x1285.jpg', 'HP 250 G5', '15.60", HD, Intel Core i5-7200U, 8GB, SSD', 599);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`user_id` int(11) NOT NULL,
  `user_username` varchar(32) NOT NULL,
  `user_password` varchar(80) NOT NULL,
  `user_email` varchar(32) NOT NULL,
  `user_hash` varchar(80) NOT NULL,
  `user_active` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_username`, `user_password`, `user_email`, `user_hash`, `user_active`) VALUES
(1, 'hash', '$2y$10$1RmDHF9O7iDivZVi2aCQLuXLQz1YAsU8gy1IqWeb6lC4KxcmiAFVS', 'user@gmail.com', '25b2822c2f5a3230abfadd476e8b04c9', 1),
(2, 'hashs', '$2y$10$664y.4vAp.QQHeIWnVKMy.XJhPBqjvL8SjWbvgeK7hJNlDFHOeXpK', 'email@gmail.com', '093f65e080a295f8076b1c5722a46aa2', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
 ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
 ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
