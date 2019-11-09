-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 09, 2019 at 06:16 PM
-- Server version: 5.7.27-0ubuntu0.18.04.1
-- PHP Version: 7.2.24-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nrsa`
--

-- --------------------------------------------------------

--
-- Table structure for table `junak`
--

CREATE TABLE `junak` (
  `id` int(11) NOT NULL,
  `ime` varchar(255) COLLATE utf8_slovenian_ci NOT NULL,
  `vsebina` text COLLATE utf8_slovenian_ci NOT NULL,
  `datum` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Dumping data for table `junak`
--

INSERT INTO `junak` (`id`, `ime`, `vsebina`, `datum`) VALUES
(2, 'Martin Krpan z Vrha', 'Martin Krpan z Vrha (krajše Martin Krpan) je slovenska umetna pripovedka, ki jo je napisal Fran Levstik leta 1858, in je bila objavljena v Slovenskem glasniku.', '2019-10-04 22:39:40'),
(3, 'Mojca Pokrajculja', 'Mojca Pokrajculja je naslov koroške ljudske pripovedke in ime glavnega lika.', '2019-10-04 22:39:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `junak`
--
ALTER TABLE `junak`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `junak`
--
ALTER TABLE `junak`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
