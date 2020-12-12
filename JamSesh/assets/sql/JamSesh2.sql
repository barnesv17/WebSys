-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2020 at 02:48 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.34

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
(14, 'barnev@rpi.edu'),
(51, 'root@rpi.edu');

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `email` varchar(50) NOT NULL,
  `studioID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`email`, `studioID`) VALUES
('root@rpi.edu', 52),
('root@rpi.edu', 57);

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
(50, 'Folk'),
(51, 'Religious'),
(52, 'Electronic');

-- --------------------------------------------------------

--
-- Table structure for table `studios`
--

CREATE TABLE `studios` (
  `id` int(11) NOT NULL,
  `owner` varchar(50) DEFAULT NULL,
  `instruments` mediumtext DEFAULT '',
  `title` varchar(50) NOT NULL DEFAULT 'Title',
  `visibility` varchar(10) NOT NULL DEFAULT 'Public',
  `allowFork` varchar(5) NOT NULL DEFAULT 'Yes',
  `description` varchar(2048) NOT NULL DEFAULT 'Description',
  `forks` int(10) NOT NULL DEFAULT 0,
  `isAFork` int(11) DEFAULT NULL,
  `favorites` int(255) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `studios`
--

INSERT INTO `studios` (`id`, `owner`, `instruments`, `title`, `visibility`, `allowFork`, `description`, `forks`, `isAFork`, `favorites`) VALUES
(14, 'virginiabarnes0825@gmail.com', '{\"names\":[\"Oboe\",\"Cello\",\"Piano\",\"Guitar 1\",\"Guitar 2\"],\"files\":[\"studios/14/Oboe.mp3\",\"studios/14/Cello.mp3\",\"studios/14/Piano.mp3\",\"studios/14/Guitar 1.mp3\",\"studios/14/Guitar 2.mp3\"]}', 'Title', 'Public', 'Yes', 'Description', 3, NULL, 0),
(31, 'virginiabarnes0825@gmail.com', '{\"names\":[\"Alto Sax\",\"Banjo\",\"Bass\",\"Cello\",\"Clarinet\",\"Drumset\",\"Euphonium\",\"Flute\",\"Honky Tonk Piano\",\"Horn\",\"Tenor Sax\",\"Trombone\",\"Trumpet 1\",\"Trumpet 2\",\"Tuba\",\"Viola\",\"Violin\"],\"files\":[\"studios/31/Alto Sax.mp3\",\"studios/31/Banjo.mp3\",\"studios/31/Bass.mp3\",\"studios/31/Cello.mp3\",\"studios/31/Clarinet.mp3\",\"studios/31/Drumset.mp3\",\"studios/31/Euphonium.mp3\",\"studios/31/Flute.mp3\",\"studios/31/Honky Tonk Piano.mp3\",\"studios/31/Horn.mp3\",\"studios/31/Tenor Sax.mp3\",\"studios/31/Trombone.mp3\",\"studios/31/Trumpet 1.mp3\",\"studios/31/Trumpet 2.mp3\",\"studios/31/Tuba.mp3\",\"studios/31/Viola.mp3\",\"studios/31/Violin.mp3\"]}', 'Title', 'Public', 'Yes', 'Description', 0, NULL, 0),
(40, 'barnev@rpi.edu', '{ \"names\" : [], \"files\" : [] }', 'Title', 'Public', 'Yes', 'Description', 0, NULL, 0),
(41, 'barnev@rpi.edu', '{ \"names\" : [], \"files\" : [] }', 'Title', 'Public', 'Yes', 'Description', 0, NULL, 0),
(42, 'barnev@rpi.edu', '{ \"names\" : [], \"files\" : [] }', 'Title', 'Public', 'Yes', 'Description', 0, NULL, 0),
(43, 'barnev@rpi.edu', '{ \"names\" : [], \"files\" : [] }', 'Title', 'Public', 'Yes', 'Description', 0, NULL, 0),
(45, 'virginiabarnes0825@gmail.com', '{ \"names\" : [], \"files\" : [] }', 'Title', 'Public', 'Yes', 'Description', 0, NULL, 0),
(48, 'virginiabarnes0825@gmail.com', '{\"names\":[\"Oboe\",\"Cello\",\"Piano\",\"Guitar 1\",\"Guitar 2\"],\"files\":[\"studios/14/Oboe.mp3\",\"studios/14/Cello.mp3\",\"studios/14/Piano.mp3\",\"studios/14/Guitar 1.mp3\",\"studios/14/Guitar 2.mp3\"]}', 'Title', 'Public', 'Yes', 'Description', 0, NULL, 0),
(50, 'qinz@rpi.edu', '{ \"names\" : [], \"files\" : [] }', 'Hanukkah Party', 'Public', 'Yes', 'We love Hanukkah', 0, NULL, 1),
(51, 'qinz@rpi.edu', '{ \"names\" : [], \"files\" : [] }', 'Cities on Flame with Jam and Sesh', 'Public', 'Yes', 'ft. Blue Oyster Heathens', 2, NULL, 0),
(52, 'qinz@rpi.edu', '{ \"names\" : [], \"files\" : [] }', 'Blade Runner', 'Public', 'Yes', 'ft. CyberBUNk', 0, NULL, 1),
(53, 'qinz@rpi.edu', '{\"names\":[\"Oboe\",\"Cello\",\"Piano\",\"Guitar 1\",\"Guitar 2\"],\"files\":[\"studios/14/Oboe.mp3\",\"studios/14/Cello.mp3\",\"studios/14/Piano.mp3\",\"studios/14/Guitar 1.mp3\",\"studios/14/Guitar 2.mp3\"]}', 'Title', 'Public', 'Yes', 'Description', 0, NULL, 0),
(54, 'root@rpi.edu', '{ \"names\" : [], \"files\" : [] }', 'Cities on Flame with Jam and Sesh', 'Public', 'Yes', 'ft. Blue Oyster Heathens', 0, NULL, 0),
(55, 'qinz@rpi.edu', '{\"names\":[\"Oboe\",\"Cello\",\"Piano\",\"Guitar 1\",\"Guitar 2\"],\"files\":[\"studios/14/Oboe.mp3\",\"studios/14/Cello.mp3\",\"studios/14/Piano.mp3\",\"studios/14/Guitar 1.mp3\",\"studios/14/Guitar 2.mp3\"]}', 'Title', 'Public', 'Yes', 'Description', 0, NULL, 0),
(56, 'root@rpi.edu', '{ \"names\" : [], \"files\" : [] }', 'Hanukkah Party', 'Public', 'Yes', 'We love Hanukkah', 0, NULL, 0),
(57, 'qinz@rpi.edu', '{ \"names\" : [], \"files\" : [] }', 'Enderman is alive', 'Public', 'Yes', 'ft. Hercraft', 0, NULL, 1);

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
  `profilePic` varchar(255) DEFAULT 'assets/img/profile-pictures/blank-avatar.png',
  `isAdmin` varchar(5) DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`email`, `password`, `username`, `displayName`, `bio`, `profilePic`, `isAdmin`) VALUES
('barnev@rpi.edu', '$2y$10$dJ2rG/KxcJGZ5bhsRpjkWuwwF85wLz61GtFRmMmFua.qmCFyCrczK', 'johne', 'Elton John', '', 'assets/img/profile-pictures/profilepic1.jpg', 'Yes'),
('qinz@rpi.edu', '$2y$10$2ksj0hI1a2Nm6r0MOOmX2OIGl2aEsZ/mPzKl9/bzbHM/t8bhRt3Dy', 'kylecccx', 'Kyle Qin', 'I used Nigua Hamooz on my burger king order yesterday', 'assets/img/profile-pictures/profilepic1.jpg', 'Yes'),
('root@rpi.edu', '$2y$10$u9I/eSTRGa0pN1m6kPLvlOwylGQRKHh2Bz8pSfujUt0FFBLg0uauG', 'root_test', 'FirstName LastName', '', 'assets/img/profile-pictures/blank-avatar.png', 'No'),
('virginiabarnes0825@gmail.com', '$2y$10$k2WzMzkOjGmZNaTC.Mw7l.swj..rbbefS5zVCYtZWnRgrwPx4uoIm', 'barnesv', 'John Legend', 'hello', 'assets/img/profile-pictures/profilepic3.jpg', 'Yes'),
('wildg@rpi.edu', '$2y$10$TnSWLoN7kq8KV6Ga3Zh6TeFyxCgCIP1WBPWE8THUBA.p6rYPfoSWq', 'wildg', 'FirstName LastName', '', 'assets/img/profile-pictures/blank-avatar.png', 'Yes');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

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
