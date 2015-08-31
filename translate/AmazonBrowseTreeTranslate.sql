-- phpMyAdmin SQL Dump
-- version 4.2.12deb2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 29, 2015 at 03:53 PM
-- Server version: 5.6.25-0ubuntu0.15.04.1
-- PHP Version: 5.6.4-4ubuntu6.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `translate`
--

-- --------------------------------------------------------

--
-- Table structure for table `AmazonBrowseTreeTranslate`
--

CREATE TABLE IF NOT EXISTS `AmazonBrowseTreeTranslate` (
`id` int(11) NOT NULL,
  `country` varchar(255) NOT NULL,
  `node-id` bigint(11) NOT NULL,
  `node-path` varchar(255) NOT NULL,
  `node_path_hash` varchar(16) NOT NULL,
  `node-enpoint` varchar(255) NOT NULL,
  `target-lang` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `AmazonBrowseTreeTranslate`
--
ALTER TABLE `AmazonBrowseTreeTranslate`
 ADD PRIMARY KEY (`id`), ADD KEY `node_path_hash` (`node_path_hash`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `AmazonBrowseTreeTranslate`
--
ALTER TABLE `AmazonBrowseTreeTranslate`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
