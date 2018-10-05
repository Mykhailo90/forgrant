-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 06, 2018 at 12:40 AM
-- Server version: 10.1.34-MariaDB-0ubuntu0.18.04.1
-- PHP Version: 7.2.10-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
(1, 1, 50.75, '2017-10-01', '2018-03-09', '2018-10-02 13:36:19'),
(2, 1, 5000, '2018-10-01', '2018-10-06', '2018-10-03 13:36:19'),
(3, 1, 100, '2016-10-01', '2017-10-31', '2018-10-01 13:36:19'),
(4, 2, 1500, '2018-10-05', '2018-10-31', '2018-10-04 21:00:00'),
(5, 2, 2000, '2018-10-05', '2038-01-18', '2018-09-30 21:00:00'),
(6, 1, 3400, '2018-10-05', '2038-01-18', '2018-10-04 21:00:00'),
(7, 2, 1111, '2018-10-05', '2018-10-06', '2018-10-05 07:01:52'),
(8, 1, 22222, '2018-10-05', '2038-01-18', '2018-10-05 07:01:05'),
(11, 1, 999, '2018-10-05', '2038-01-18', '2018-10-05 08:01:25'),
(12, 2, 777, '2018-10-05', '2038-01-18', '2018-10-05 08:01:37'),
(13, 2, 777, '2018-10-05', '2038-01-18', '2018-10-05 08:01:07'),
(14, 2, 1000, '2018-10-05', '2038-01-18', '2018-10-05 08:01:20'),
(15, 2, 29922, '2018-10-05', '2038-01-18', '2018-10-05 08:01:23'),
(16, 2, 18, '2018-10-05', '2038-01-18', '2018-10-05 20:47:54'),
(17, 1, 25, '2018-10-05', '2038-01-18', '2018-10-05 20:48:11'),
(18, 3, 10, '2018-10-01', '2018-10-27', '2018-10-05 21:25:32'),
(19, 4, 12, '2018-09-01', '2018-10-25', '2018-10-05 21:25:32'),
(20, 5, 111, '2018-09-04', '2018-10-10', '2018-10-05 21:26:50'),
(21, 6, 0, '2018-09-01', '2018-10-27', '2018-10-05 21:26:50'),
(22, 7, 23, '2018-09-04', '2018-10-27', '2018-10-05 21:28:01'),
(23, 8, 55, '2018-09-01', '2018-10-27', '2018-10-05 21:28:01'),
(24, 9, 555, '2018-09-04', '2018-10-27', '2018-10-05 21:28:36'),
(25, 10, 555, '2018-09-01', '2018-10-27', '2018-10-05 21:28:36');

-- --------------------------------------------------------

--
-- Table structure for table `price_condition`
--

CREATE TABLE `price_condition` (
  `id_position` int(11) NOT NULL,
  `id_condition_search` int(11) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `price_condition`
--

INSERT INTO `price_condition` (`id_position`, `id_condition_search`, `id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 1, 8),
(4, 1, 9),
(5, 2, 10),
(6, 2, 11),
(7, 1, 12),
(8, 2, 13),
(9, 2, 14),
(10, 1, 15);

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
(2, 2, 'Вечерние туфли'),
(3, 3, 'Флешки'),
(4, 3, 'Видео'),
(5, 3, 'Аудио'),
(6, 3, 'Дискеты'),
(7, 1, 'Спортивное питание'),
(8, 1, 'Правильное питание'),
(9, 2, 'Мягкие игрушки'),
(10, 2, 'Детские платья');

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
  ADD PRIMARY KEY (`id`),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `price_condition`
--
ALTER TABLE `price_condition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `sales_positions`
--
ALTER TABLE `sales_positions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
