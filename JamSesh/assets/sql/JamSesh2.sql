-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2020 at 11:48 PM
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
(2, 'barnev@rpi.edu'),
(24, 'virginiabarnes0825@gmail.com');

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
(1, 'virginiabarnes0825@gmail.com', '{\"names\":[\"Drums\",\"Viola\",\"Violin 1\",\"Violin 2\",\"Cello\"],\"files\":[\"studios/1/Drums.mp3\",\"studios/1/Viola.mp3\",\"studios/1/Violin 1.mp3\",\"studios/1/Violin 2.mp3\",\"studios/1/Cello.mp3\"]}', '{\"title\":\"Bad Guy!!!!\",\"visibility\":\"Public\",\"allowFork\":\"Yes\",\"description\":\"my attempt at being billy eilish\",\"genres\":[\"Jazz\"]}', 0),
(2, 'virginiabarnes0825@gmail.com', '{\"names\":[\"Cello\",\"Drums\",\"Viola\",\"Violin 1\",\"Violin 2\"],\"files\":[\"studios/1/Cello.mp3\",\"studios/1/Drums.mp3\",\"studios/1/Viola.mp3\",\"studios/1/Violin 1.mp3\",\"studios/1/Violin 2.mp3\"]}', '{\"title\":\"Bad Guy2\",\"visibility\":\"Public\",\"allowFork\":\"Yes\",\"description\":\"example description\",\"genres\":[]}', 0),
(13, 'virginiabarnes0825@gmail.com', '{\"names\":[\"Cello\"],\"files\":[\"studios/13/Cello.mp3\"]}', '{\"title\":\"Whatsup\",\"visibility\":\"Private\",\"allowFork\":\"No\",\"description\":\"This is a test!!!!\",\"genres\":[]}', 0),
(14, 'virginiabarnes0825@gmail.com', '{\"names\":[\"Oboe\",\"Cello\",\"Piano\",\"Guitar 1\",\"Guitar 2\"],\"files\":[\"studios/14/Oboe.mp3\",\"studios/14/Cello.mp3\",\"studios/14/Piano.mp3\",\"studios/14/Guitar 1.mp3\",\"studios/14/Guitar 2.mp3\"]}', '{ \"title\" : \"Take On Me\",\r\n                              \"visibility\" : \"Public\",\r\n                              \"allowFork\" : \"Yes\",\r\n                              \"description\" : \"a song by a-ha!\",\r\n                              \"genres\" : [] }', 0),
(15, 'test2@gmail.com', '{\"names\":[\"Cello\"],\"files\":[\"studios/15/Cello.mp3\"]}', '{ \"title\" : \"Take On Me\",\r\n                              \"visibility\" : \"Public\",\r\n                              \"allowFork\" : \"Yes\",\r\n                              \"description\" : \"yee yee\",\r\n                              \"genres\" : [] }', 0),
(31, 'virginiabarnes0825@gmail.com', '{\"names\":[\"Alto Sax\",\"Banjo\",\"Bass\",\"Cello\",\"Clarinet\",\"Drumset\",\"Euphonium\",\"Flute\",\"Honky Tonk Piano\",\"Horn\",\"Tenor Sax\",\"Trombone\",\"Trumpet 1\",\"Trumpet 2\",\"Tuba\",\"Viola\",\"Violin\"],\"files\":[\"studios/31/Alto Sax.mp3\",\"studios/31/Banjo.mp3\",\"studios/31/Bass.mp3\",\"studios/31/Cello.mp3\",\"studios/31/Clarinet.mp3\",\"studios/31/Drumset.mp3\",\"studios/31/Euphonium.mp3\",\"studios/31/Flute.mp3\",\"studios/31/Honky Tonk Piano.mp3\",\"studios/31/Horn.mp3\",\"studios/31/Tenor Sax.mp3\",\"studios/31/Trombone.mp3\",\"studios/31/Trumpet 1.mp3\",\"studios/31/Trumpet 2.mp3\",\"studios/31/Tuba.mp3\",\"studios/31/Viola.mp3\",\"studios/31/Violin.mp3\"]}', '{\"title\":\"Baby Shark Orchestra\",\"visibility\":\"Public\",\"allowFork\":\"Yes\",\"description\":\"do doo doo do do\",\"genres\":[]}', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
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

INSERT INTO `users` (`id`, `email`, `password`, `username`, `displayName`, `bio`, `profilePic`) VALUES
(1, 'virginiabarnes0825@gmail.com', '$2y$10$k2WzMzkOjGmZNaTC.Mw7l.swj..rbbefS5zVCYtZWnRgrwPx4uoIm', 'barnesv17', 'Virginia Barnes', 'this is my bio', 'assets/img/profile-pictures/profilepic3.jpg'),
(2, 'barnev@rpi.edu', '$2y$10$dJ2rG/KxcJGZ5bhsRpjkWuwwF85wLz61GtFRmMmFua.qmCFyCrczK', 'johne', 'Elton John', '', 'assets/img/profile-pictures/profilepic1.jpg'),
(4, 'test@gmail.com', '$2y$10$cMRFVJOuQrQ9U8ygAtTdS.lhB9hCKt6ZFFAFWbYwz6vWaEJGTXxca', 'random_username', 'FirstName LastName', '', 'assets/img/profile-pictures/blank-avatar.png');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
