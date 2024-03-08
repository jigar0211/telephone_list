-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 03, 2024 at 03:38 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `teleplone_list`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(250) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `phone` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `photo` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `phone`, `password`, `photo`) VALUES
(60, 'demo1', 'demo1', 'demo1@gmail.com', '1234567890', '123', '../uploads/65e2042ee26571.png'),
(61, 'demo2 jk', 'demo2', 'demo2@gmail.com', '2345678901', 'demo2', '../uploads/65e3290f308372.png'),
(62, 'demo3', 'demo3', 'demo3@gmail.com', '3456789012', 'demo3', '../uploads/65e2044d68bf73.png'),
(63, 'demo4', 'demo4', 'demo4@gmail.com', '4567890123', 'demo4', '../uploads/65e2045e3addb4.png'),
(64, 'demo5', 'demo5', 'demo5@gmail.com', '5678901234', 'demo5', '../uploads/65e2046d2a6ca5.png'),
(65, 'demo6', 'demo6', 'demo6@gmail.com', '6789012345', 'demo6', '../uploads/65e2049d314d6logo3.png'),
(66, 'demo7', 'demo7', 'demo7@gmail.com', '7890123456', 'demo7', '../uploads/65e206537af75product-img-5.jpg'),
(67, 'demo8 jk', 'demo8', 'demo8@gmail.com', '8901234567', 'demo8', '../uploads/65e3292c0890fproduct-img-6.jpg'),
(68, 'demo9', 'demo9', 'demo9@gmail.com', '9012345678', 'demo9', '../uploads/65e32946e7d3fproduct-img-1.jpg'),
(69, 'demo10', 'demo10', 'demo10@gmail.com', '0123456789', 'demo10', '../uploads/65e2060ad64fbproduct-img-2.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
