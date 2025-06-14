-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3301
-- Generation Time: Jun 04, 2025 at 06:59 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookspare`
--

-- --------------------------------------------------------

--
-- Table structure for table `book_borrowed`
--

DROP TABLE IF EXISTS `book_borrowed`;
CREATE TABLE `book_borrowed` (
  `bookBorrowCode` int(11) NOT NULL,
  `readerID` int(11) DEFAULT NULL,
  `postCode` int(11) DEFAULT NULL,
  `ratingFeedback` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `book_record`
--

DROP TABLE IF EXISTS `book_record`;
CREATE TABLE `book_record` (
  `bookID` int(11) NOT NULL,
  `bookTitle` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `comment_rating`
--

DROP TABLE IF EXISTS `comment_rating`;
CREATE TABLE `comment_rating` (
  `commentCode` int(11) NOT NULL,
  `postCode` int(11) DEFAULT NULL,
  `readerID` int(11) DEFAULT NULL,
  `comment` longtext NOT NULL,
  `dateComment` date NOT NULL,
  `bookBorrowCode` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `nested_comment_rating`
--

DROP TABLE IF EXISTS `nested_comment_rating`;
CREATE TABLE `nested_comment_rating` (
  `nestedCommentCode` int(11) NOT NULL,
  `comment` longtext NOT NULL,
  `dateComment` date NOT NULL,
  `readerID` int(11) DEFAULT NULL,
  `commentCode` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `post_review`
--

DROP TABLE IF EXISTS `post_review`;
CREATE TABLE `post_review` (
  `postCode` int(11) NOT NULL,
  `readerID` int(11) DEFAULT NULL,
  `bookID` int(11) DEFAULT NULL,
  `ownerOpinion` longtext NOT NULL,
  `ownerRating` decimal(3,1) NOT NULL,
  `frontCover_img` varchar(255) DEFAULT NULL,
  `backCover_img` varchar(255) DEFAULT NULL,
  `synopsis` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `reader_user`
--

DROP TABLE IF EXISTS `reader_user`;
CREATE TABLE `reader_user` (
  `readerID` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(70) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `country` varchar(75) NOT NULL,
  `dateOfBirth` date NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reader_user`
--

INSERT INTO `reader_user` (`readerID`, `username`, `email`, `phone`, `country`, `dateOfBirth`, `password`, `avatar`) VALUES
(1, 'wanwan', 'wan@mail.com', '0122643499', 'Malaysia', '2005-04-23', '$2y$10$HNX9KP9WBi9vobIa3lthluZxFOAgnbvYy8RPBg/BoPqXVV3t9InGm', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `thread`
--

DROP TABLE IF EXISTS `thread`;
CREATE TABLE `thread` (
  `threadID` int(11) NOT NULL,
  `thread` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `thread`
--

INSERT INTO `thread` (`threadID`, `thread`) VALUES
(1, 'personalfav'),
(2, 'romcom'),
(3, 'badstory'),
(4, 'famousauthor'),
(5, 'omgoftheweek'),
(6, 'underratedauthor'),
(7, 'personalworst'),
(8, 'recommend'),
(9, 'booktodiefor'),
(10, 'mustread'),
(11, 'mustavoid'),
(12, 'legendary');

-- --------------------------------------------------------

--
-- Table structure for table `thread_post`
--

DROP TABLE IF EXISTS `thread_post`;
CREATE TABLE `thread_post` (
  `threadPostCode` int(11) NOT NULL,
  `postCode` int(11) DEFAULT NULL,
  `threadID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `book_borrowed`
--
ALTER TABLE `book_borrowed`
  ADD PRIMARY KEY (`bookBorrowCode`),
  ADD KEY `readerID` (`readerID`,`postCode`),
  ADD KEY `postCode` (`postCode`);

--
-- Indexes for table `book_record`
--
ALTER TABLE `book_record`
  ADD PRIMARY KEY (`bookID`);

--
-- Indexes for table `comment_rating`
--
ALTER TABLE `comment_rating`
  ADD PRIMARY KEY (`commentCode`),
  ADD KEY `postCode` (`postCode`,`readerID`,`bookBorrowCode`),
  ADD KEY `readerID` (`readerID`),
  ADD KEY `bookBorrowCode` (`bookBorrowCode`);

--
-- Indexes for table `nested_comment_rating`
--
ALTER TABLE `nested_comment_rating`
  ADD PRIMARY KEY (`nestedCommentCode`),
  ADD KEY `readerID` (`readerID`,`commentCode`),
  ADD KEY `commentCode` (`commentCode`);

--
-- Indexes for table `post_review`
--
ALTER TABLE `post_review`
  ADD PRIMARY KEY (`postCode`),
  ADD KEY `readerID` (`readerID`,`bookID`),
  ADD KEY `bookID` (`bookID`);

--
-- Indexes for table `reader_user`
--
ALTER TABLE `reader_user`
  ADD PRIMARY KEY (`readerID`);

--
-- Indexes for table `thread`
--
ALTER TABLE `thread`
  ADD PRIMARY KEY (`threadID`);

--
-- Indexes for table `thread_post`
--
ALTER TABLE `thread_post`
  ADD PRIMARY KEY (`threadPostCode`),
  ADD KEY `postCode` (`postCode`,`threadID`),
  ADD KEY `threadID` (`threadID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `book_borrowed`
--
ALTER TABLE `book_borrowed`
  MODIFY `bookBorrowCode` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `book_record`
--
ALTER TABLE `book_record`
  MODIFY `bookID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comment_rating`
--
ALTER TABLE `comment_rating`
  MODIFY `commentCode` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nested_comment_rating`
--
ALTER TABLE `nested_comment_rating`
  MODIFY `nestedCommentCode` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post_review`
--
ALTER TABLE `post_review`
  MODIFY `postCode` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reader_user`
--
ALTER TABLE `reader_user`
  MODIFY `readerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `thread`
--
ALTER TABLE `thread`
  MODIFY `threadID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `thread_post`
--
ALTER TABLE `thread_post`
  MODIFY `threadPostCode` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `book_borrowed`
--
ALTER TABLE `book_borrowed`
  ADD CONSTRAINT `book_borrowed_ibfk_1` FOREIGN KEY (`readerID`) REFERENCES `reader_user` (`readerID`),
  ADD CONSTRAINT `book_borrowed_ibfk_2` FOREIGN KEY (`postCode`) REFERENCES `post_review` (`postCode`) ON DELETE CASCADE;

--
-- Constraints for table `comment_rating`
--
ALTER TABLE `comment_rating`
  ADD CONSTRAINT `comment_rating_ibfk_1` FOREIGN KEY (`readerID`) REFERENCES `reader_user` (`readerID`) ON DELETE CASCADE,
  ADD CONSTRAINT `comment_rating_ibfk_2` FOREIGN KEY (`postCode`) REFERENCES `post_review` (`postCode`) ON DELETE CASCADE,
  ADD CONSTRAINT `comment_rating_ibfk_3` FOREIGN KEY (`bookBorrowCode`) REFERENCES `book_borrowed` (`bookBorrowCode`);

--
-- Constraints for table `nested_comment_rating`
--
ALTER TABLE `nested_comment_rating`
  ADD CONSTRAINT `nested_comment_rating_ibfk_1` FOREIGN KEY (`commentCode`) REFERENCES `comment_rating` (`commentCode`) ON DELETE CASCADE,
  ADD CONSTRAINT `nested_comment_rating_ibfk_2` FOREIGN KEY (`readerID`) REFERENCES `reader_user` (`readerID`) ON DELETE CASCADE;

--
-- Constraints for table `post_review`
--
ALTER TABLE `post_review`
  ADD CONSTRAINT `post_review_ibfk_1` FOREIGN KEY (`readerID`) REFERENCES `reader_user` (`readerID`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_review_ibfk_2` FOREIGN KEY (`bookID`) REFERENCES `book_record` (`bookID`);

--
-- Constraints for table `thread_post`
--
ALTER TABLE `thread_post`
  ADD CONSTRAINT `thread_post_ibfk_1` FOREIGN KEY (`threadID`) REFERENCES `thread` (`threadID`),
  ADD CONSTRAINT `thread_post_ibfk_2` FOREIGN KEY (`postCode`) REFERENCES `post_review` (`postCode`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
