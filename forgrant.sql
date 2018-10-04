-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 04, 2018 at 07:13 AM
-- Server version: 5.7.23
-- PHP Version: 7.1.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `forgrant`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Товары'),
(2, 'Продукты'),
(3, 'цифровой контент');

-- --------------------------------------------------------

--
-- Table structure for table `condition_search`
--

CREATE TABLE `condition_search` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL DEFAULT 'Last update',
  `condition_search` varchar(256) NOT NULL DEFAULT 'price.update_date'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `condition_search`
--

INSERT INTO `condition_search` (`id`, `name`, `condition_search`) VALUES
(1, 'Last update', 'price.update_date'),
(2, 'MIN Time Value', '(price.to_date - price.from_date)');

-- --------------------------------------------------------

--
-- Table structure for table `price`
--

CREATE TABLE `price` (
  `id` int(11) NOT NULL,
  `id_position` int(11) NOT NULL,
  `price` float NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `update_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `price`
--

INSERT INTO `price` (`id`, `id_position`, `price`, `from_date`, `to_date`, `update_date`) VALUES
(1, 1, 50.75, '2018-10-01', '2018-10-09', '2018-10-02 13:36:19'),
(2, 1, 5000, '2018-10-05', '2018-10-06', '2018-10-03 13:36:19'),
(3, 1, 100, '2018-10-01', '2018-10-31', '2018-10-01 13:36:19');

-- --------------------------------------------------------

--
-- Table structure for table `price_condition`
--

CREATE TABLE `price_condition` (
  `id_position` int(11) NOT NULL,
  `id_condition_search` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `price_condition`
--

INSERT INTO `price_condition` (`id_position`, `id_condition_search`) VALUES
(1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `sales_positions`
--

CREATE TABLE `sales_positions` (
  `id` int(11) NOT NULL,
  `id_category` int(11) NOT NULL,
  `name_position` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sales_positions`
--

INSERT INTO `sales_positions` (`id`, `id_category`, `name_position`) VALUES
(1, 2, 'Школьная форма'),
(2, 2, 'Вечерние туфли');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `condition_search`
--
ALTER TABLE `condition_search`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `price`
--
ALTER TABLE `price`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_position` (`id_position`);

--
-- Indexes for table `price_condition`
--
ALTER TABLE `price_condition`
  ADD KEY `id_positions` (`id_position`),
  ADD KEY `id_conditions` (`id_condition_search`);

--
-- Indexes for table `sales_positions`
--
ALTER TABLE `sales_positions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_category` (`id_category`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `condition_search`
--
ALTER TABLE `condition_search`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `price`
--
ALTER TABLE `price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sales_positions`
--
ALTER TABLE `sales_positions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `price`
--
ALTER TABLE `price`
  ADD CONSTRAINT `id_position` FOREIGN KEY (`id_position`) REFERENCES `sales_positions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `price_condition`
--
ALTER TABLE `price_condition`
  ADD CONSTRAINT `id_conditions` FOREIGN KEY (`id_condition_search`) REFERENCES `condition_search` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `id_positions` FOREIGN KEY (`id_position`) REFERENCES `sales_positions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sales_positions`
--
ALTER TABLE `sales_positions`
  ADD CONSTRAINT `id_category` FOREIGN KEY (`id_category`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
