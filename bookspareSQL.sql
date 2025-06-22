-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3301
-- Generation Time: Jun 22, 2025 at 03:52 PM
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

--
-- Dumping data for table `book_record`
--

INSERT INTO `book_record` (`bookID`, `bookTitle`) VALUES
(1, 'Alice In The Wonderland'),
(2, 'Little Mermaid'),
(3, 'Rapunzal'),
(4, 'Coco'),
(5, 'Cinderella'),
(6, 'Mulan'),
(7, 'Tangle'),
(8, 'Beauty And The Beast'),
(9, 'Lion King'),
(10, 'Aladdin'),
(11, 'Harry Potter'),
(12, 'Love is everywhere, Snoopy!'),
(13, 'Toy Story 2');

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
  `dateComment` varchar(20) NOT NULL,
  `bookBorrowCode` int(11) DEFAULT NULL,
  `timeComment` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comment_rating`
--

INSERT INTO `comment_rating` (`commentCode`, `postCode`, `readerID`, `comment`, `dateComment`, `bookBorrowCode`, `timeComment`) VALUES
(1, 6, 1, 'Hello', 'Sunday, June 22, 202', NULL, '17:32:44'),
(2, 6, 1, 'Mulan is crazyyyyy!', 'Sunday, June 22, 202', NULL, '17:33:59'),
(3, 6, 1, 'Besttttttt story ever!', 'Sunday, June 22, 202', NULL, '17:35:46'),
(4, 18, 1, 'Snoopy is real cute hehe', 'Sunday, June 22, 202', NULL, '17:36:58'),
(5, 19, 1, 'Opps lmao', 'Sunday, June 22, 202', NULL, '18:05:50');

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
-- Table structure for table `notification`
--

DROP TABLE IF EXISTS `notification`;
CREATE TABLE `notification` (
  `notificationCode` int(11) NOT NULL,
  `postCode` int(11) DEFAULT NULL,
  `readerID` int(11) DEFAULT NULL,
  `commentCode` int(11) DEFAULT NULL,
  `nestedCommentCode` int(11) DEFAULT NULL,
  `status` char(8) DEFAULT NULL
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
  `synopsis` longtext DEFAULT NULL,
  `statusPhone` varchar(10) DEFAULT NULL,
  `author` varchar(50) DEFAULT NULL,
  `genre` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `post_review`
--

INSERT INTO `post_review` (`postCode`, `readerID`, `bookID`, `ownerOpinion`, `ownerRating`, `frontCover_img`, `backCover_img`, `synopsis`, `statusPhone`, `author`, `genre`) VALUES
(6, 1, 6, 'Mulan is an inspiring story that beautifully blends themes of courage, honor, and self-discovery. I was drawn in by the character of Mulan herself — a brave young woman who defies tradition and disguises herself as a man to take her father’s place in the army. Her journey is not just about fighting a war, but about proving her worth in a society that underestimates her because of her gender.\r\n\r\nWhat stood out to me the most was Mulan’s inner strength. She isn’t fearless — in fact, she has moments of doubt and fear — but she chooses to do the right thing anyway. That made her feel real and relatable. I also appreciated how the story emphasizes loyalty to family and the importance of staying true to yourself, even when the world expects something different.\r\n\r\nThe book has a good balance of action, emotion, and cultural depth. It ', 9.0, NULL, NULL, NULL, 'NO', 'Grace Lin', 'Action'),
(15, 1, 11, 'Passion and Nice', 9.0, 'bookUploads/img_685597a67a30b_harrypotter_frontCover.jpg', 'bookUploads/img_685597a67a411_harrypotter_backCover.jpg', 'Harry Potter, an orphan living with his cruel aunt and uncle, discovers on his eleventh birthday that he is a wizard. He\'s invited to attend Hogwarts School of Witchcraft and Wizardry, where he befriends Ron Weasley and Hermione Granger.\r\n\r\nAs Harry learns magic, he uncovers the truth about his past — how the dark wizard Lord Voldemort killed his parents and tried to kill him as a baby, leaving him with a lightning-shaped scar. While investigating a mysterious object hidden within the school — the Philosopher’s Stone, which grants immortality — Harry and his friends face magical challenges and confront Professor Quirrell, who is being controlled by Voldemort.\r\n\r\nHarry ultimately prevents Voldemort from obtaining the Stone, protecting it and the wizarding world. The story ends with Harry returning to his relatives for the summer, now aware of his true identity and purpose.', 'YES', 'JK Rowling', 'Mystery'),
(16, 1, 1, 'OMG', 7.0, NULL, NULL, NULL, 'NO', 'Lewis Carroll', 'Fantasy'),
(17, 1, 5, 'Lovely', 8.0, 'bookUploads/img_6856834e49f9b_cinderella_frontCover.jpg', 'bookUploads/img_6856834e4a1bd_cinderella_backCover.jpg', 'Cinderella is a timeless fairy tale about a kind-hearted young woman who is mistreated by her cruel stepmother and jealous stepsisters after the death of her father. Forced to work as a servant in her own home, Cinderella\'s life changes when her fairy godmother appears and magically prepares her for the royal ball. Dressed in a beautiful gown and glass slippers, she attends the ball where she captures the heart of the prince. But as the clock strikes midnight, the magic fades, leaving behind only a single glass slipper. Determined to find her, the prince searches the kingdom, and when the slipper fits Cinderella, her true identity is revealed, leading to a happily ever after.\r\n\r\n', 'NO', 'Charles Perrault', 'Romance'),
(18, 2, 12, 'Snoopy is cute!!!!', 10.0, 'bookUploads/img_6856c7e350cc7_snoopy_frontCover.jpg', 'bookUploads/img_6856c7e351308_snoopy_backCover.jpg', 'In Love Is Everywhere, Snoopy!, the beloved Peanuts gang returns to remind us that love is found in the most unexpected places — and sometimes in the most ordinary moments. As Valentine’s Day approaches, Charlie Brown once again wrestles with his nerves as he tries to express his feelings, while Lucy continues her determined (but often one-sided) efforts to win Schroeder’s heart. Meanwhile, Peppermint Patty and Marcie navigate the quirky ups and downs of friendship, and Linus clutches his blanket while quietly admiring his Sweet Babboo.\r\n\r\nAt the heart of it all is Snoopy — the imaginative, joyful beagle who sees the world with wide eyes and a loving spirit. Whether he\'s dancing with Woodstock, writing heartfelt letters atop his doghouse, or daydreaming of romantic adventures, Snoopy reminds everyone around him that love isn’t just about grand gestures or perfect timing — it’s about caring, connection, and showing up in little ways every day.\r\n\r\nFilled with gentle humor, sweet moments, and the timeless charm of Charles M. Schulz’s characters, Love Is Everywhere, Snoopy! is a warm and uplifting story that celebrates the many forms of love — romantic, friendly, and even silly. This book is a perfect reminder that love truly is all around us… if we just take the time to notice.', 'YES', 'Tina Gallo', 'Comedy'),
(19, 2, 13, 'They are cute and funny!', 10.0, 'bookUploads/img_6856c9a3ac0d4_toystory_frontCover.jpg', 'bookUploads/img_6856c9a3ac600_toystory_backCover.jpg', 'In Pixar’s heartwarming sequel Toy Story 2, Woody finds himself at the center of a high-stakes rescue mission that challenges what it means to be a toy. When Andy heads off to cowboy camp, Woody is accidentally damaged and left behind. While trying to save another toy, Woody is stolen by a greedy toy collector named Al, who plans to sell him to a museum in Japan.\r\n\r\nAt Al’s apartment, Woody discovers that he was once the star of a popular 1950s TV show, Woody’s Roundup, and meets a new set of toys: Jessie the cowgirl, Bullseye the horse, and Stinky Pete the Prospector. While Jessie and Bullseye are thrilled at the idea of being admired in a museum, Woody begins to question his destiny — should he return to Andy, who will one day grow up, or embrace a future of being preserved forever?\r\n\r\nBack at home, Buzz Lightyear and the rest of the gang — Rex, Hamm, Mr. Potato Head, and Slinky Dog — launch a daring mission to rescue Woody. Their journey is filled with humor, action, and touching moments, including Buzz’s hilarious encounter with a newer, delusional Buzz Lightyear model and Woody’s realization of the importance of friendship and being there for a child who loves you.\r\n\r\nWith unforgettable new characters, emotional depth, and Pixar’s signature charm, Toy Story 2 is a powerful story about loyalty, identity, and the true value of being loved.', 'NO', 'Tom Hanks', 'Comedy'),
(36, 1, 4, 'Their songs are nice!', 9.0, NULL, NULL, NULL, 'YES', 'Lee Unkrich', 'Fantasy');

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
(1, 'wanwan', 'wan@mail.com', '0122643499', 'Malaysia', '2005-04-23', '$2y$10$HNX9KP9WBi9vobIa3lthluZxFOAgnbvYy8RPBg/BoPqXVV3t9InGm', 'avatarUploads/img_68569347671d3_jingliu6_2.png'),
(2, 'Felicia', 'felicia@mail.com', '0127701533', 'Malaysia', '2005-09-05', '$2y$10$zFUF.SJlmskrOld7CLV6H.sTvPWbCsu0O1EUE6RCwoTTrHGjt7BBa', 'avatarUploads/img_6856c11202cd7_snoopy.jpg');

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
(12, 'legendary'),
(13, 'Women'),
(14, 'Ancient'),
(15, 'Harry'),
(16, 'Magic'),
(17, 'curiousity'),
(18, 'imagination'),
(19, 'glassShoe'),
(20, 'Princess'),
(21, 'Cute'),
(22, 'Cartoon'),
(23, 'Dog'),
(24, 'Childhood'),
(25, 'MiniFigure'),
(26, 'Pixar'),
(27, 'Disney'),
(28, 'Lovely');

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
-- Dumping data for table `thread_post`
--

INSERT INTO `thread_post` (`threadPostCode`, `postCode`, `threadID`) VALUES
(12, 15, 15),
(11, 15, 16),
(13, 16, 17),
(14, 16, 18),
(15, 17, 19),
(16, 17, 20),
(17, 18, 21),
(18, 18, 22),
(19, 18, 23),
(20, 18, 24),
(22, 19, 22),
(21, 19, 25),
(23, 19, 26),
(24, 19, 27),
(25, 36, 22),
(28, 36, 26),
(27, 36, 27),
(26, 36, 28);

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
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`notificationCode`),
  ADD KEY `postCode` (`postCode`,`readerID`,`commentCode`,`nestedCommentCode`),
  ADD KEY `readerID` (`readerID`),
  ADD KEY `commentCode` (`commentCode`),
  ADD KEY `nestedCommentCode` (`nestedCommentCode`);

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
  MODIFY `bookID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `comment_rating`
--
ALTER TABLE `comment_rating`
  MODIFY `commentCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `nested_comment_rating`
--
ALTER TABLE `nested_comment_rating`
  MODIFY `nestedCommentCode` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `notificationCode` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post_review`
--
ALTER TABLE `post_review`
  MODIFY `postCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `reader_user`
--
ALTER TABLE `reader_user`
  MODIFY `readerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `thread`
--
ALTER TABLE `thread`
  MODIFY `threadID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `thread_post`
--
ALTER TABLE `thread_post`
  MODIFY `threadPostCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

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
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`postCode`) REFERENCES `post_review` (`postCode`) ON DELETE CASCADE,
  ADD CONSTRAINT `notification_ibfk_2` FOREIGN KEY (`readerID`) REFERENCES `reader_user` (`readerID`) ON DELETE CASCADE,
  ADD CONSTRAINT `notification_ibfk_3` FOREIGN KEY (`commentCode`) REFERENCES `comment_rating` (`commentCode`) ON DELETE CASCADE,
  ADD CONSTRAINT `notification_ibfk_4` FOREIGN KEY (`nestedCommentCode`) REFERENCES `nested_comment_rating` (`nestedCommentCode`) ON DELETE CASCADE;

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
