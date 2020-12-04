-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 04, 2020 at 06:44 AM
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
(13, 'virginiabarnes0825@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `email` varchar(50) NOT NULL,
  `studioID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `studioID` int(11) NOT NULL,
  `genre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`studioID`, `genre`) VALUES
(2, 'Comedy'),
(37, 'Children\'s'),
(37, 'Classical'),
(37, 'Electronic');

-- --------------------------------------------------------

--
-- Table structure for table `studios`
--

CREATE TABLE `studios` (
  `id` int(11) NOT NULL,
  `owner` varchar(50) DEFAULT NULL,
  `instruments` mediumtext DEFAULT '',
  `settings` mediumtext DEFAULT '',
  `forks` int(10) NOT NULL DEFAULT 0,
  `isAFork` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `studios`
--

INSERT INTO `studios` (`id`, `owner`, `instruments`, `settings`, `forks`, `isAFork`) VALUES
(1, 'virginiabarnes0825@gmail.com', '{\"names\":[\"Drums\",\"Viola\",\"Violin 1\",\"Violin 2\",\"Cello\"],\"files\":[\"studios/1/Drums.mp3\",\"studios/1/Viola.mp3\",\"studios/1/Violin 1.mp3\",\"studios/1/Violin 2.mp3\",\"studios/1/Cello.mp3\"]}', '{\"title\":\"Bad Guy!!!!\",\"visibility\":\"Public\",\"allowFork\":\"Yes\",\"description\":\"my attempt at being billy eilish\",\"genres\":[\"Jazz\"]}', 0, NULL),
(2, 'virginiabarnes0825@gmail.com', '{\"names\":[\"Cello\",\"Drums\",\"Viola\",\"Violin 1\",\"Violin 2\"],\"files\":[\"studios/1/Cello.mp3\",\"studios/1/Drums.mp3\",\"studios/1/Viola.mp3\",\"studios/1/Violin 1.mp3\",\"studios/1/Violin 2.mp3\"]}', '{\"title\":\"Bad Guy2\",\"visibility\":\"Public\",\"allowFork\":\"Yes\",\"description\":\"example description\",\"genres\":[]}', 0, NULL),
(13, 'virginiabarnes0825@gmail.com', '{\"names\":[\"Cello\"],\"files\":[\"studios/13/Cello.mp3\"]}', '{\"title\":\"Whatsup\",\"visibility\":\"Private\",\"allowFork\":\"No\",\"description\":\"This is a test!!!!\",\"genres\":[]}', 0, NULL),
(14, 'virginiabarnes0825@gmail.com', '{\"names\":[\"Oboe\",\"Cello\",\"Piano\",\"Guitar 1\",\"Guitar 2\"],\"files\":[\"studios/14/Oboe.mp3\",\"studios/14/Cello.mp3\",\"studios/14/Piano.mp3\",\"studios/14/Guitar 1.mp3\",\"studios/14/Guitar 2.mp3\"]}', '{ \"title\" : \"Take On Me\",\r\n                              \"visibility\" : \"Public\",\r\n                              \"allowFork\" : \"Yes\",\r\n                              \"description\" : \"a song by a-ha!\",\r\n                              \"genres\" : [] }', 0, NULL),
(31, 'virginiabarnes0825@gmail.com', '{\"names\":[\"Alto Sax\",\"Banjo\",\"Bass\",\"Cello\",\"Clarinet\",\"Drumset\",\"Euphonium\",\"Flute\",\"Honky Tonk Piano\",\"Horn\",\"Tenor Sax\",\"Trombone\",\"Trumpet 1\",\"Trumpet 2\",\"Tuba\",\"Viola\",\"Violin\"],\"files\":[\"studios/31/Alto Sax.mp3\",\"studios/31/Banjo.mp3\",\"studios/31/Bass.mp3\",\"studios/31/Cello.mp3\",\"studios/31/Clarinet.mp3\",\"studios/31/Drumset.mp3\",\"studios/31/Euphonium.mp3\",\"studios/31/Flute.mp3\",\"studios/31/Honky Tonk Piano.mp3\",\"studios/31/Horn.mp3\",\"studios/31/Tenor Sax.mp3\",\"studios/31/Trombone.mp3\",\"studios/31/Trumpet 1.mp3\",\"studios/31/Trumpet 2.mp3\",\"studios/31/Tuba.mp3\",\"studios/31/Viola.mp3\",\"studios/31/Violin.mp3\"]}', '{\"title\":\"Baby Shark Orchestra\",\"visibility\":\"Public\",\"allowFork\":\"Yes\",\"description\":\"do doo doo do do\",\"genres\":[]}', 0, NULL),
(32, 'wildg@rpi.edu', '{ \"names\" : [], \"files\" : [] }', '{\"title\":\"My Studio\",\"visibility\":\"Public\",\"allowFork\":\"Yes\",\"description\":\"Description\",\"genres\":[]}', 0, NULL),
(37, 'test@email.com', '{ \"names\" : [], \"files\" : [] }', '{\"title\":\"My Studio\",\"visibility\":\"Public\",\"allowFork\":\"No\",\"description\":\"Description\",\"genres\":[]}', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT 'random_username',
  `displayName` varchar(255) DEFAULT 'FirstName LastName',
  `bio` varchar(255) DEFAULT '',
  `profilePic` varchar(255) DEFAULT 'assets/img/profile-pictures/blank-avatar.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`email`, `password`, `username`, `displayName`, `bio`, `profilePic`) VALUES
('barnev@rpi.edu', '$2y$10$dJ2rG/KxcJGZ5bhsRpjkWuwwF85wLz61GtFRmMmFua.qmCFyCrczK', 'johne', 'Elton John', '', 'assets/img/profile-pictures/profilepic1.jpg'),
('test@email.com', '$2y$10$.4b4av6PVS18iz.zMD1HcOk/Yr.HLLiI.1Ux5NiyqBVjijyZdqX1.', 'test3', 'My Name', 'kjhalkjhdflskjh', 'assets/img/profile-pictures/profilepic2.jpg'),
('test@gmail.com', '$2y$10$cMRFVJOuQrQ9U8ygAtTdS.lhB9hCKt6ZFFAFWbYwz6vWaEJGTXxca', 'random_username', 'FirstName LastName', '', 'assets/img/profile-pictures/blank-avatar.png'),
('test@mail.com', '$2y$10$f2zOx2whq9RzX/bC54M2aO5xQzP70tP8IILgwyK3NmbnoMgMyo.qG', 'test', 'FirstName LastName', '', 'assets/img/profile-pictures/blank-avatar.png'),
('virginiabarnes0825@gmail.com', '$2y$10$k2WzMzkOjGmZNaTC.Mw7l.swj..rbbefS5zVCYtZWnRgrwPx4uoIm', 'barnesv17', 'Virginia Barnes', 'this is my bio', 'assets/img/profile-pictures/profilepic3.jpg'),
('wildg@rpi.edu', '$2y$10$TnSWLoN7kq8KV6Ga3Zh6TeFyxCgCIP1WBPWE8THUBA.p6rYPfoSWq', 'wildg', 'FirstName LastName', '', 'assets/img/profile-pictures/blank-avatar.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `collaborators`
--
ALTER TABLE `collaborators`
  ADD PRIMARY KEY (`studioID`,`email`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`email`,`studioID`),
  ADD KEY `studioID` (`studioID`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`studioID`,`genre`);

--
-- Indexes for table `studios`
--
ALTER TABLE `studios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner` (`owner`),
  ADD KEY `isAFork` (`isAFork`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `studios`
--
ALTER TABLE `studios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `collaborators`
--
ALTER TABLE `collaborators`
  ADD CONSTRAINT `collaborators_ibfk_1` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `collaborators_ibfk_2` FOREIGN KEY (`studioID`) REFERENCES `studios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`studioID`) REFERENCES `studios` (`id`);

--
-- Constraints for table `genres`
--
ALTER TABLE `genres`
  ADD CONSTRAINT `genres_ibfk_1` FOREIGN KEY (`studioID`) REFERENCES `studios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `studios`
--
ALTER TABLE `studios`
  ADD CONSTRAINT `studios_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `users` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `studios_ibfk_2` FOREIGN KEY (`isAFork`) REFERENCES `studios` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;