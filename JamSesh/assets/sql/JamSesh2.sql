-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 03, 2020 at 05:07 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `JamSesh2`
--

-- --------------------------------------------------------

--
-- Table structure for table `collaborators`
--

CREATE TABLE `collaborators` (
  `studioID` int(11) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `collaborators`
--

INSERT INTO `collaborators` (`studioID`, `email`) VALUES
(1, 'barnev@rpi.edu');

-- --------------------------------------------------------

--
-- Table structure for table `studios`
--

CREATE TABLE `studios` (
  `id` int(11) NOT NULL,
  `owner` varchar(50) DEFAULT NULL,
  `instruments` mediumtext DEFAULT '',
  `settings` mediumtext DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `studios`
--

INSERT INTO `studios` (`id`, `owner`, `instruments`, `settings`) VALUES
(1, 'virginiabarnes0825@gmail.com', '{\"names\":[\"Drums\",\"Viola\",\"Violin 1\",\"Violin 2\",\"Cello\"],\"files\":[\"studios/1/Drums.mp3\",\"studios/1/Viola.mp3\",\"studios/1/Violin 1.mp3\",\"studios/1/Violin 2.mp3\",\"studios/1/Cello.mp3\"]}', '{\"title\":\"Bad Guy!!!!\",\"visibility\":\"Public\",\"allowFork\":\"Yes\",\"description\":\"example description\",\"genres\":[\"indie\",\"alternative\"]}'),
(2, 'virginiabarnes0825@gmail.com', '{ \"names\": [ \"Cello\", \"Drums\", \"Viola\", \"Violin 1\", \"Violin 2\" ], \"files\" : [ \"studios/1/Cello.mp3\", \"studios/1/Drums.mp3\", \"studios/1/Viola.mp3\", \"studios/1/Violin 1.mp3\", \"studios/1/Violin 2.mp3\" ] }', '{ \"title\" : \"Bad Guy2\",\r\n        \"visibility\" : \"Public\",\r\n        \"allowFork\" : \"Yes\",\r\n        \"description\" : \"example description\",\r\n        \"genres\" : [ \"indie\", \"alternative\" ] }'),
(13, 'virginiabarnes0825@gmail.com', '{\"names\":[\"Cello\"],\"files\":[\"studios/13/Cello.mp3\"]}', '{\"title\":\"Whatsup\",\"visibility\":\"Private\",\"allowFork\":\"No\",\"description\":\"This is a test!!!!\",\"genres\":[\"Pop\",\"INDIE\"]}'),
(14, 'virginiabarnes0825@gmail.com', '{\"names\":[\"Oboe\",\"Cello\",\"Piano\",\"Guitar 1\",\"Guitar 2\"],\"files\":[\"studios/14/Oboe.mp3\",\"studios/14/Cello.mp3\",\"studios/14/Piano.mp3\",\"studios/14/Guitar 1.mp3\",\"studios/14/Guitar 2.mp3\"]}', '{ \"title\" : \"Take On Me\",\r\n                              \"visibility\" : \"Public\",\r\n                              \"allowFork\" : \"Yes\",\r\n                              \"description\" : \"a song by a-ha!\",\r\n                              \"genres\" : [] }');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT '""',
  `displayName` varchar(255) DEFAULT '""',
  `bio` varchar(255) DEFAULT '',
  `profilePic` varchar(255) DEFAULT 'assets/img/profile-pictures/blank-avatar.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `username`, `displayName`, `bio`, `profilePic`) VALUES
(1, 'virginiabarnes0825@gmail.com', '$2y$10$k2WzMzkOjGmZNaTC.Mw7l.swj..rbbefS5zVCYtZWnRgrwPx4uoIm', 'barnesv17', 'Virginia Barnes', 'this is my bio', 'assets/img/profile-pictures/profilepic3.jpg'),
(2, 'barnev@rpi.edu', '$2y$10$dJ2rG/KxcJGZ5bhsRpjkWuwwF85wLz61GtFRmMmFua.qmCFyCrczK', 'random_username', 'FirstName LastName', '', 'assets/img/profile-pictures/blank-avatar.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `collaborators`
--
ALTER TABLE `collaborators`
  ADD PRIMARY KEY (`studioID`,`email`);

--
-- Indexes for table `studios`
--
ALTER TABLE `studios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner` (`owner`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `studios`
--
ALTER TABLE `studios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `studios`
--
ALTER TABLE `studios`
  ADD CONSTRAINT `studios_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `users` (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;