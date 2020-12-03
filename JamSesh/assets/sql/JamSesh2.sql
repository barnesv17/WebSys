-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2020 at 07:18 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jamsesh2`
--

-- --------------------------------------------------------

--
-- Table structure for table `studios`
--

CREATE TABLE `studios` (
  `id` int(11) NOT NULL,
  `owner` varchar(50) DEFAULT NULL,
  `instruments` mediumtext DEFAULT '',
  `settings` mediumtext DEFAULT '',
  `forks` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `studios`
--

INSERT INTO `studios` (`id`, `owner`, `instruments`, `settings`, `forks`) VALUES
(1, 'virginiabarnes0825@gmail.com', '{\"names\":[\"Drums\",\"Viola\",\"Violin 1\",\"Violin 2\",\"Cello\"],\"files\":[\"studios/1/Drums.mp3\",\"studios/1/Viola.mp3\",\"studios/1/Violin 1.mp3\",\"studios/1/Violin 2.mp3\",\"studios/1/Cello.mp3\"]}', '{\"title\":\"Bad Guy!!!!\",\"visibility\":\"Public\",\"allowFork\":\"Yes\",\"description\":\"example description\",\"genres\":[\"Jazz\",\"Jazz\",\"Jazz\"]}', 0),
(2, 'virginiabarnes0825@gmail.com', '{ \"names\": [ \"Cello\", \"Drums\", \"Viola\", \"Violin 1\", \"Violin 2\" ], \"files\" : [ \"studios/1/Cello.mp3\", \"studios/1/Drums.mp3\", \"studios/1/Viola.mp3\", \"studios/1/Violin 1.mp3\", \"studios/1/Violin 2.mp3\" ] }', '{\"title\":\"Bad Guy2\",\"visibility\":\"Public\",\"allowFork\":\"Yes\",\"description\":\"example description\",\"genres\":[]}', 0),
(13, 'virginiabarnes0825@gmail.com', '{\"names\":[\"Cello\"],\"files\":[\"studios/13/Cello.mp3\"]}', '{\"title\":\"Whatsup\",\"visibility\":\"Private\",\"allowFork\":\"No\",\"description\":\"This is a test!!!!\",\"genres\":[]}', 0),
(14, 'virginiabarnes0825@gmail.com', '{\"names\":[\"Oboe\",\"Cello\",\"Piano\",\"Guitar 1\",\"Guitar 2\"],\"files\":[\"studios/14/Oboe.mp3\",\"studios/14/Cello.mp3\",\"studios/14/Piano.mp3\",\"studios/14/Guitar 1.mp3\",\"studios/14/Guitar 2.mp3\"]}', '{ \"title\" : \"Take On Me\",\r\n                              \"visibility\" : \"Public\",\r\n                              \"allowFork\" : \"Yes\",\r\n                              \"description\" : \"a song by a-ha!\",\r\n                              \"genres\" : [] }', 0),
(15, 'test2@gmail.com', '{\"names\":[\"Cello\"],\"files\":[\"studios/15/Cello.mp3\"]}', '{ \"title\" : \"Take On Me\",\r\n                              \"visibility\" : \"Public\",\r\n                              \"allowFork\" : \"Yes\",\r\n                              \"description\" : \"yee yee\",\r\n                              \"genres\" : [] }', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `studios`
--
ALTER TABLE `studios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner` (`owner`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `studios`
--
ALTER TABLE `studios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
