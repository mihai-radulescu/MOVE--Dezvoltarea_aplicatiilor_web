-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 09, 2020 at 02:53 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `move_db_v1`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `userId` int(11) NOT NULL,
  `addressId` int(11) NOT NULL,
  `country` varchar(100) NOT NULL,
  `region` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `street` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`userId`, `addressId`, `country`, `region`, `city`, `street`) VALUES
(1, 1, 'Romania', 'Arges', 'Pitesti', 'str. Popa Sapca, nr 11'),
(3, 3, 'Romania', 'Bucuresti', 'sector 6', 'blv. Iuliu Maniu, nr 10'),
(1, 5, 'Romania', 'Valcea', 'Ramnicu Valcea', 'ceva strada'),
(1, 9, 'Peru', 'hello', 'efwcs', 'I am not good at geography'),
(3, 11, 'ho', 'ho', 'ho', 'ho'),
(1, 13, 'Peru', 'peru2', 'peru3', 'peru4');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `userAddressId` int(11) NOT NULL,
  `code` varchar(100) NOT NULL,
  `weight` int(2) NOT NULL,
  `date` datetime(6) NOT NULL,
  `clientName` varchar(100) NOT NULL,
  `clientPhone` int(10) NOT NULL,
  `clientEmail` varchar(100) NOT NULL,
  `clientStreet` varchar(200) NOT NULL,
  `courierId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orderId`, `userId`, `userAddressId`, `code`, `weight`, `date`, `clientName`, `clientPhone`, `clientEmail`, `clientStreet`, `courierId`) VALUES
(1, 1, 1, 'co2xW1mw9ozdWkG', 2, '2020-12-09 11:59:00.000000', 'me', 123456789, 'a@b.com', 'ceva', NULL),
(2, 1, 9, 'dq35JcHU4W7X5aF', 10, '2020-12-09 13:55:00.000000', 'test', 123456789, 'mpopescu20@exemplu.mail.com', 'abc', NULL),
(3, 3, 3, 'NeFuiAqDvEjyzVB', 7, '2020-12-09 14:25:00.000000', 'ddd', 123456789, 'a@b.com', 'ceva', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userId` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userId`, `username`, `password`, `name`, `email`, `phone_number`) VALUES
(1, 'popescu_marian', '123', 'Popescu Marian', 'mpopescu20@exemplu.mail.com', 755443322),
(3, 'vsl', 'vsl', 'Laurentiu Vasile', 'vsl@exemplu.mail.com', 4856494),
(5, 'jdoe', '$2y$10$Jovg2mTZbPV2qnyLiRWTFuSyzYDk6AF09BX3aJY1JcCiD/J0GSDTS', 'John Doe', 'john_doe@exemplu.mail.com', 123456789);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`addressId`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderId`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `addressId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orderId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
