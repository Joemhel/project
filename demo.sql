-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 13, 2022 at 04:08 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `salary` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `address`, `salary`) VALUES
(19, 'spotify', '2022-01-20', 1333);

-- --------------------------------------------------------

--
-- Table structure for table `subscription`
--

CREATE TABLE `subscription` (
  `id` int(150) NOT NULL,
  `SocialPlatform` varchar(200) NOT NULL,
  `DueDate` date NOT NULL,
  `SubscriptionFee` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(4, 'ome', '$2y$10$keBZG2QjpRzR0N0F5.cU4.Nrno6p0aClV35Hs3k42.2wZ.gzivN36', '2022-12-04 19:21:10'),
(5, 'omewa', '$2y$10$RWWdSpLK39A1q4C0Q.gKX.Jjni4N..QS8H2uzS2lLo3ZtRcnPTjeK', '2022-12-05 11:57:38'),
(6, 'omeome', '$2y$10$Hn2hIsSew567nvr/.fh5L.j0xcSTntQb617nB7iQPWbPL9x3HIyR.', '2022-12-06 13:27:20'),
(7, 'yowme', '$2y$10$bWA/4apubKIBRoiR8UcPmORdh6IxFQOh/jweCIu7BWcB5pAX5AUtG', '2022-12-06 13:30:41'),
(8, 'yowjoe', '$2y$10$1x5pnb623CTNaKyJDBnA.eerqtbkHcEE3231afkVAhDbH7rwPe/mq', '2022-12-11 12:09:10'),
(9, 'Joemhel', '$2y$10$FP0QWRDREAz0/8nNZZJ1XOk1wKeJ9VuRx54kiU07242azCtnZYW.u', '2022-12-12 21:09:49'),
(10, 'Errol', '$2y$10$fSJsCbPP8E66UJHnIwYFtuie.e2mgoScwQfXWzBZZCFedxcyCu8KC', '2022-12-13 22:28:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscription`
--
ALTER TABLE `subscription`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `subscription`
--
ALTER TABLE `subscription`
  MODIFY `id` int(150) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
