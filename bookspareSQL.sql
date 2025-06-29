-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3301
-- Generation Time: Jun 29, 2025 at 12:34 PM
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
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `adminID` int(11) NOT NULL,
  `adminUsername` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `adminEmail` varchar(75) NOT NULL,
  `adminPhone` varchar(15) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminID`, `adminUsername`, `password`, `adminEmail`, `adminPhone`, `avatar`) VALUES
(1, 'cwx', '$2y$10$G.4wbPv1woK/RhXCH.BcKuxyDyZ1meaAWGOflnI2k4pprQNy.QP9u', 'cwxxx@mail.com', '0132521452', 'avatarUploads/img_6860cb20de336_mickeyMouse.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `book_borrowed`
--

DROP TABLE IF EXISTS `book_borrowed`;
CREATE TABLE `book_borrowed` (
  `bookBorrowCode` int(11) NOT NULL,
  `readerID` int(11) DEFAULT NULL,
  `postCode` int(11) DEFAULT NULL,
  `fullname` varchar(50) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(75) DEFAULT NULL,
  `address` varchar(100) NOT NULL,
  `borrowDate` datetime NOT NULL,
  `expectedReturnDate` datetime NOT NULL,
  `reasonBorrow` longtext DEFAULT NULL,
  `statusBorrow` char(15) DEFAULT NULL,
  `dateRequestSent` datetime NOT NULL,
  `deliveryMethod` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `book_borrowed`
--

INSERT INTO `book_borrowed` (`bookBorrowCode`, `readerID`, `postCode`, `fullname`, `phone`, `email`, `address`, `borrowDate`, `expectedReturnDate`, `reasonBorrow`, `statusBorrow`, `dateRequestSent`, `deliveryMethod`) VALUES
(51, 2, 67, 'Felicia', '0127701533', 'felicia@mail.com', 'Johor', '2025-06-30 00:00:00', '2025-07-17 00:00:00', '', 'APPROVED', '2025-06-29 14:53:47', 'Meet In Person'),
(54, 5, 65, 'Conan', '0135469875', 'conan@mail.com', 'Selangor', '2025-07-10 00:00:00', '2025-07-30 00:00:00', 'Cool', 'APPROVED', '2025-06-29 15:41:54', 'Meet In Person'),
(55, 5, 63, 'Conan', '0135469875', 'conan@mail.com', 'Selangor', '2025-07-23 00:00:00', '2025-08-30 00:00:00', 'Cute', 'APPROVED', '2025-06-29 16:05:33', 'Meet In Person'),
(57, 1, 69, 'wanwan', '0122643499', 'wan@mail.com', 'Selangor', '2025-07-20 00:00:00', '2025-07-25 00:00:00', '', 'APPROVED', '2025-06-29 16:29:31', 'Meet In Person'),
(58, 2, 69, 'Felicia', '0127701533', 'felicia@mail.com', 'Johor', '2025-07-20 00:00:00', '2025-07-30 00:00:00', '', 'APPROVED', '2025-06-29 16:34:09', 'Meet In Person'),
(59, 5, 68, '', '', NULL, 'Selangor', '2025-07-12 00:00:00', '2025-07-20 00:00:00', '', 'APPROVED', '2025-06-29 16:47:46', 'Meet In Person'),
(60, 5, 58, '', '', NULL, 'Selangor', '2025-07-11 00:00:00', '2025-07-20 00:00:00', '', 'APPROVED', '2025-06-29 16:48:03', 'Meet In Person');

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
(13, 'Toy Story 2'),
(16, 'test'),
(17, 'test2'),
(18, 'Minions Little Golden Book'),
(19, '福尔摩斯'),
(20, 'Mickey Mouse'),
(21, 'Spiderman (2002)'),
(22, 'Tangled'),
(23, 'The Lion King'),
(24, 'Aladdin (1992)');

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
  `timeComment` time DEFAULT NULL,
  `rating` int(10) DEFAULT NULL,
  `statusComment` char(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comment_rating`
--

INSERT INTO `comment_rating` (`commentCode`, `postCode`, `readerID`, `comment`, `dateComment`, `timeComment`, `rating`, `statusComment`) VALUES
(30, 56, 2, 'Hello!', 'Friday, June 27, 202', '01:06:52', 9, 'APPROVED'),
(31, 56, 5, 'Nice!', 'Friday, June 27, 202', '23:10:47', 8, 'APPROVED'),
(32, 58, 1, 'Cute!!!', 'Saturday, June 28, 2', '00:05:03', 10, 'APPROVED'),
(33, 63, 1, 'This is comment', 'Saturday, June 28, 2', '14:42:27', 10, 'APPROVED'),
(34, 67, 5, 'My Childhood!', 'Sunday, June 29, 202', '01:53:49', 9, 'APPROVED'),
(35, 63, 5, 'OK', 'Sunday, June 29, 202', '12:42:09', 8, 'APPROVED');

-- --------------------------------------------------------

--
-- Table structure for table `nested_comment_rating`
--

DROP TABLE IF EXISTS `nested_comment_rating`;
CREATE TABLE `nested_comment_rating` (
  `nestedCommentCode` int(11) NOT NULL,
  `comment` longtext NOT NULL,
  `dateComment` varchar(20) NOT NULL,
  `readerID` int(11) DEFAULT NULL,
  `commentCode` int(11) DEFAULT NULL,
  `timeComment` time DEFAULT NULL,
  `statusNestedComment` char(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nested_comment_rating`
--

INSERT INTO `nested_comment_rating` (`nestedCommentCode`, `comment`, `dateComment`, `readerID`, `commentCode`, `timeComment`, `statusNestedComment`) VALUES
(35, 'owhhyeah', 'Friday, June 27, 202', 2, 30, '01:07:20', 'APPROVED'),
(36, 'Hihi', 'Friday, June 27, 202', 5, 30, '21:07:41', 'APPROVED');

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
  `status` char(8) DEFAULT NULL,
  `bookBorrowCode` int(11) DEFAULT NULL,
  `notificationDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`notificationCode`, `postCode`, `readerID`, `commentCode`, `nestedCommentCode`, `status`, `bookBorrowCode`, `notificationDate`) VALUES
(80, 67, 2, NULL, NULL, 'UNREAD', 51, NULL),
(83, 65, 5, NULL, NULL, 'UNREAD', 54, NULL),
(84, 63, 5, NULL, NULL, 'UNREAD', 55, NULL),
(86, 69, 1, NULL, NULL, 'UNREAD', 57, NULL),
(87, 69, 2, NULL, NULL, 'UNREAD', 58, NULL),
(88, 68, 5, NULL, NULL, 'UNREAD', 59, NULL),
(89, 58, 5, NULL, NULL, 'UNREAD', 60, NULL),
(90, 58, NULL, NULL, NULL, 'UNREAD', NULL, '2025-06-29 17:43:45');

-- --------------------------------------------------------

--
-- Table structure for table `post_report`
--

DROP TABLE IF EXISTS `post_report`;
CREATE TABLE `post_report` (
  `reportCode` int(11) NOT NULL,
  `reason` varchar(50) NOT NULL,
  `extraReason` longtext DEFAULT NULL,
  `postCode` int(11) DEFAULT NULL,
  `readerID` int(11) DEFAULT NULL,
  `reportDateTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `post_report`
--

INSERT INTO `post_report` (`reportCode`, `reason`, `extraReason`, `postCode`, `readerID`, `reportDateTime`) VALUES
(2, 'inappropriate', '', 59, 2, '2025-06-28 17:54:32'),
(4, 'falseInfo', 'SHmmmm', 59, 1, '2025-06-28 18:56:15'),
(5, 'hate', '', 59, 1, '2025-06-28 19:34:51');

-- --------------------------------------------------------

--
-- Table structure for table `post_review`
--

DROP TABLE IF EXISTS `post_review`;
CREATE TABLE `post_review` (
  `postCode` int(11) NOT NULL,
  `readerID` int(11) DEFAULT NULL,
  `bookID` int(11) DEFAULT NULL,
  `frontCover_img` varchar(255) DEFAULT NULL,
  `synopsis` longtext DEFAULT NULL,
  `author` varchar(50) DEFAULT NULL,
  `genre` varchar(50) DEFAULT NULL,
  `datePosted` datetime DEFAULT NULL,
  `statusPostBorrow` varchar(10) DEFAULT NULL,
  `statusApprove` char(20) DEFAULT NULL,
  `statusApproveMessage` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `post_review`
--

INSERT INTO `post_review` (`postCode`, `readerID`, `bookID`, `frontCover_img`, `synopsis`, `author`, `genre`, `datePosted`, `statusPostBorrow`, `statusApprove`, `statusApproveMessage`) VALUES
(56, 1, 11, 'bookUploads/img_685d6c57f3fc3_harrypotter_frontCover.jpg', 'Eleven-year-old Harry Potter has lived a miserable life with his cruel aunt and uncle. But everything changes when he learns he is a wizard—and not just any wizard, but the orphaned son of two powerful wizards who were killed by the dark lord Voldemort.\r\n\r\nInvited to attend Hogwarts School of Witchcraft and Wizardry, Harry enters a hidden world of spells, magical creatures, and enchanted objects. At Hogwarts, he makes loyal friends, discovers his true heritage, and uncovers a dark secret hidden within the school: the Philosopher’s Stone, a magical object granting immortality, is under threat.\r\n\r\nAs Harry, Ron, and Hermione work together to protect the Stone, they face dangerous trials and ultimately confront a hidden enemy. In the end, Harry learns that love, courage, and friendship are more powerful than dark magic.\r\n\r\n', 'JK Rowling', 'Mystery', '2025-06-26 23:50:48', 'NO', 'APPROVED', ''),
(57, 1, 20, 'bookUploads/img_685d72a00a6f2_mickey_frontCover.jpg', 'Mickey Mouse is a cheerful and adventurous anthropomorphic mouse who has become one of the most iconic and beloved characters in animation history. Created by Walt Disney and Ub Iwerks in 1928, Mickey first appeared in Steamboat Willie and quickly rose to fame as the face of the Walt Disney Company.\r\n\r\nWith his trademark red shorts, yellow shoes, and big round ears, Mickey is known for his optimistic personality, quick thinking, and unwavering loyalty to his friends. Whether he\'s outsmarting foes like Pete, exploring strange lands, or solving comical problems with his friends—Minnie Mouse, Donald Duck, Goofy, and Pluto—Mickey always approaches life with courage and a smile.\r\n\r\nOver the decades, Mickey has evolved from a mischievous troublemaker into a symbol of joy, creativity, and childhood wonder, starring in countless films, TV shows, comics, and theme park attractions.', 'Ub Iwerks', 'Comedy', '2025-06-27 00:17:36', 'YES', 'APPROVED', ''),
(58, 2, 12, 'bookUploads/img_685d756237d4f_snoopy_frontCover.jpg', 'In Love is Everywhere, Snoopy!, everyone’s favorite beagle sets out on a heartwarming adventure to discover what love truly means. Whether it\'s the affection between friends, the kindness of sharing, or the thrill of a crush, Snoopy begins to notice that love surrounds him in more ways than he imagined.\r\n\r\nAs Valentine\'s Day nears, Charlie Brown frets over whether he’ll receive a valentine, while Lucy pines for Schroeder’s attention and Linus hopes his heartfelt gift for his teacher is just right. Meanwhile, Snoopy—ever the romantic dreamer—puts on his best writer’s hat to craft the perfect love letter... even if he doesn\'t quite know who to send it to!\r\n\r\nFilled with the gentle humor and timeless charm of the Peanuts gang, Love is Everywhere, Snoopy! is a celebration of love in all its forms—friendship, loyalty, and the little acts of caring that make life sweeter.', 'Charles Monroe', 'Fantasy', '2025-06-27 00:29:22', 'YES', 'APPROVED', ''),
(59, 5, 6, 'bookUploads/img_685e380fec8e5_mulan_frontCover.jpg', 'In ancient China, the country faces invasion from a ruthless enemy. When the Emperor issues a decree that one man from each family must serve in the imperial army, a brave and determined young woman named Mulan disguises herself as a man to take her ailing father\'s place. Under the name \"Ping,\" she joins the ranks of the soldiers and undergoes intense training, facing challenges that test her courage, intelligence, and determination.\r\n\r\nAs the army marches into battle, Mulan proves her strength and ingenuity, ultimately playing a key role in saving the Emperor and all of China. Through her journey, she not only earns the respect of her fellow soldiers but also discovers her own identity and power.\r\n\r\nMulan is a story of honor, bravery, and self-discovery, celebrating the strength of a woman who defies tradition to protect her family and her country.', 'Grace Lin', 'Action', '2025-06-27 14:19:59', 'NO', 'APPROVED', ''),
(62, 1, 16, 'bookUploads/img_685ea250abdc6_monkey.jpg', 'test', 'test', 'Action', '2025-06-27 21:53:20', 'NO', 'BANNED', 'Monkey is not a book!'),
(63, 2, 13, 'bookUploads/img_685eb0221a989_toystory_frontCover.jpg', 'Toy Story 2 follows Woody, Buzz Lightyear, and the rest of Andy’s beloved toys as they face a new adventure beyond the bedroom. When Woody is stolen by a greedy toy collector, he discovers he\'s actually a rare and valuable collectible from a 1950s TV show. While being tempted by the idea of immortality in a museum, Woody meets new friends—Jessie the cowgirl, Bullseye the horse, and Stinky Pete the Prospector—who’ve never known the joy of being played with.\r\n\r\nMeanwhile, Buzz and the gang set off on a daring mission to rescue Woody. As the toys confront tough choices about loyalty, identity, and what it means to be loved, Woody must decide between staying with his new family or returning to Andy, the boy who loves him.\r\n\r\nHeartwarming, funny, and full of action, Toy Story 2 is a story about friendship, purpose, and the enduring bond between toys and their children.', 'John Lasseter', 'Fantasy', '2025-06-27 22:52:18', 'NO', 'APPROVED', ''),
(64, 1, 21, 'bookUploads/img_685ec11f0bc91_spiderman_frontCover.webp', 'After being bitten by a genetically modified spider during a school field trip, awkward high school student Peter Parker gains superhuman strength, agility, and the ability to cling to surfaces. As he explores his newfound powers, tragedy strikes when his beloved Uncle Ben is killed by a criminal Peter could have stopped. Haunted by the loss and driven by Uncle Ben\'s words — \"With great power comes great responsibility\" — Peter dons a red-and-blue suit and becomes the masked hero, Spider-Man.\r\n\r\nAs Peter balances his double life, he faces his greatest challenge yet: the Green Goblin, a powerful and unstable villain who threatens the city and those Peter loves most. Caught between duty and desire, Peter must make sacrifices to protect New York and accept the true burden of being a hero.', 'Sam Raimi', 'Action', '2025-06-28 00:04:47', 'NO', 'APPROVED', NULL),
(65, 1, 4, 'bookUploads/img_685ec21f2e032_coco_frontCover.jpg', 'In the vibrant town of Santa Cecilia, 12-year-old Miguel dreams of becoming a musician like his idol, Ernesto de la Cruz. But there\'s one problem: his family has banned music for generations due to a mysterious tragedy in their past. Desperate to prove his talent, Miguel finds himself magically transported to the colorful and spirited Land of the Dead during Día de los Muertos.\r\n\r\nThere, he meets charming trickster Héctor and uncovers the long-lost history of his family. As Miguel journeys to find his great-great-grandfather and receive his blessing to return home, he learns powerful lessons about love, memory, and the importance of family. Coco is a heartwarming celebration of culture, music, and the bonds that connect us across generations.\r\n\r\n', 'Lee Unkrich', 'Fantasy', '2025-06-28 00:09:03', 'NO', 'APPROVED', NULL),
(66, 1, 22, 'bookUploads/img_685ec2972c216_tangled_frontCover.jpg', '“Tangled” is a vibrant retelling of the classic Rapunzel fairy tale. The story follows Rapunzel, a spirited young woman with 70 feet of magical golden hair who has spent her entire life locked away in a tower by the deceitful Mother Gothel, who exploits Rapunzel’s hair to stay young.\r\n\r\nCurious about the world and drawn to mysterious floating lanterns that appear every year on her birthday, Rapunzel seizes the opportunity for adventure when she crosses paths with Flynn Rider, a charming thief on the run. Together, they embark on a thrilling journey filled with daring escapes, comedic mishaps, and heartfelt discovery.\r\n\r\nAs Rapunzel uncovers the truth about her royal heritage and the power within her, she reclaims her freedom and finds her place in the world — with love, courage, and a frying pan or two.', 'Glen Keane', 'Fantasy', '2025-06-28 00:11:03', 'NO', 'APPROVED', NULL),
(67, 1, 23, 'bookUploads/img_685ec37e89444_lionking_frontCover.jpg', '“The Lion King” is an epic coming-of-age tale set in the heart of the African savanna. The story follows Simba, a young lion prince destined to succeed his father, King Mufasa, as ruler of the Pride Lands. However, when a tragic event orchestrated by Simba’s treacherous uncle Scar forces Simba into exile, he must find the strength to reclaim his rightful place as king.\r\n\r\nGuided by his childhood friend Nala, the wise baboon Rafiki, and his carefree companions Timon and Pumbaa, Simba embarks on a powerful journey of self-discovery. Along the way, he learns about responsibility, courage, and the true meaning of leadership in the great “Circle of Life.”\r\n\r\n', 'Brenda Chapman', 'Action', '2025-06-28 00:14:54', 'NO', 'APPROVED', ''),
(68, 1, 24, 'bookUploads/img_685ec3d4d157f_aladdin_frontCover.jpg', 'Walt Disney Pictures\r\n\r\nAladdin is a magical tale of adventure, love, and self-discovery set in the vibrant city of Agrabah. The story follows Aladdin, a kind-hearted but poor “diamond in the rough” who dreams of a better life. His world changes forever when he discovers a magic lamp that houses a wisecracking Genie capable of granting three wishes.\r\n\r\nWith the Genie’s help, Aladdin tries to win the heart of Princess Jasmine, who longs for freedom and equality. But they must outwit the villainous Jafar, the Sultan’s power-hungry advisor, who will stop at nothing to get the lamp and rule Agrabah.\r\n\r\nPacked with humor, romance, and unforgettable music, Aladdin is a timeless journey that reminds us it\'s what\'s inside that truly counts.', 'Roger Allers', 'Fantasy', '2025-06-28 00:16:20', 'YES', 'APPROVED', NULL),
(69, 5, 11, 'bookUploads/img_6860bd3431a91_harrypotter_frontCover2.jpg', 'The Harry Potter series by J.K. Rowling follows the journey of a young orphaned boy, Harry Potter, who discovers on his 11th birthday that he is a wizard. Invited to attend Hogwarts School of Witchcraft and Wizardry, Harry enters a hidden world of magic, friendship, and danger.\r\n\r\nAt Hogwarts, Harry forms close bonds with his friends Ron Weasley and Hermione Granger, uncovers secrets about his past, and learns about the dark wizard Lord Voldemort, who murdered his parents. As the series unfolds across seven years, Harry battles not only magical creatures and curses but also the weight of his destiny — to confront and defeat Voldemort once and for all.\r\n\r\nBlending fantasy, mystery, and coming-of-age themes, Harry Potter is a tale of bravery, loyalty, love, and the enduring power of good over evil.\r\n\r\n', 'J.K Rowling', 'Mystery', '2025-06-29 12:12:36', 'NO', 'APPROVED', NULL),
(70, 2, 5, 'bookUploads/img_6861023fb8cbd_cinderella_frontCover.jpg', 'Cinderella is a classic fairy tale about a kind and gentle young woman who is mistreated by her wicked stepmother and jealous stepsisters after the death of her father. Forced to live in rags and do all the household chores, Cinderella remains hopeful despite her hardships.\r\n\r\nWhen the king announces a royal ball to find a bride for the prince, Cinderella wishes to attend but is forbidden by her stepfamily. With the help of her Fairy Godmother, who magically transforms her rags into a beautiful gown and gives her a carriage, Cinderella attends the ball — but must return before midnight, when the magic fades.\r\n\r\nAt the ball, the prince is enchanted by her, but she flees at midnight, leaving behind a glass slipper. Determined to find her, the prince searches the kingdom, trying the slipper on every maiden. When it fits Cinderella, her true identity is revealed, and they marry, living happily ever after.', 'Charles Perrault', 'Fantasy', '2025-06-29 17:07:11', 'NO', 'APPROVED', NULL);

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
(1, 'wanwan', 'wan@mail.com', '0122643499', 'Malaysia', '2005-04-23', '$2y$10$HNX9KP9WBi9vobIa3lthluZxFOAgnbvYy8RPBg/BoPqXVV3t9InGm', 'avatarUploads/img_68580df4b87c8_jingliu6_2.png'),
(2, 'Felicia', 'felicia@mail.com', '0127701533', 'Malaysia', '2005-09-05', '$2y$10$zFUF.SJlmskrOld7CLV6H.sTvPWbCsu0O1EUE6RCwoTTrHGjt7BBa', 'avatarUploads/img_6856c11202cd7_snoopy.jpg'),
(3, 'orange', 'orange@mail.com', '0147172688', 'Malaysia', '2005-12-11', '$2y$10$d1I9ZuYjbl0OmQLMXL9eDONFTU4TWr79ZLikRxnI0n5nS.IXiIf5K', NULL),
(4, 'MeiYeang', 'my@gmail.com', '0183872005', 'Malaysia', '2005-07-18', '$2y$10$xVUS.4NT/FVRnQ0cPE4JUOHwGDSobtcGyQu9tj9nFpbWgS0/QxZMe', 'avatarUploads/img_6858af42321e4_minion.jpg'),
(5, 'Conan', 'conan@mail.com', '0135469875', 'Malaysia', '2005-10-11', '$2y$10$7SqgZcn77WIO43cJEf6.KuoWsCSlUF2DPdIBDnFIaezBfcHls7iwi', NULL);

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
(28, 'Lovely'),
(29, 'test'),
(30, 'test2'),
(31, 'girlPower'),
(32, 'independent'),
(33, 'brave'),
(34, 'banana'),
(35, 'Illumination'),
(36, 'despicable me'),
(37, 'detective'),
(38, 'Gryffindor'),
(39, 'Hufflepuff'),
(40, 'Ravenclaw'),
(41, 'Slytherin'),
(42, 'mickey'),
(43, 'mouse'),
(44, 'Strong'),
(45, 'toy'),
(46, 'spiderman'),
(47, 'marvel'),
(48, 'superhero'),
(49, 'avenger'),
(50, 'tom holand'),
(51, 'Peter Parker'),
(52, 'Repunzel'),
(53, 'lion'),
(54, 'Mufasa'),
(55, 'Aladdin'),
(56, 'A Whole New World');

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
(75, 56, 15),
(74, 56, 16),
(76, 56, 24),
(77, 56, 38),
(78, 56, 39),
(79, 56, 40),
(80, 56, 41),
(85, 57, 21),
(82, 57, 22),
(81, 57, 24),
(83, 57, 42),
(84, 57, 43),
(88, 58, 21),
(87, 58, 22),
(86, 58, 24),
(92, 59, 27),
(89, 59, 31),
(91, 59, 33),
(90, 59, 44),
(99, 63, 21),
(98, 63, 24),
(101, 63, 25),
(97, 63, 26),
(100, 63, 45),
(102, 64, 46),
(103, 64, 47),
(104, 64, 48),
(105, 64, 49),
(106, 64, 50),
(107, 64, 51),
(110, 65, 24),
(109, 65, 26),
(108, 65, 27),
(112, 66, 24),
(111, 66, 27),
(113, 66, 52),
(115, 67, 24),
(114, 67, 27),
(116, 67, 53),
(117, 67, 54),
(119, 68, 27),
(118, 68, 55),
(120, 68, 56),
(121, 69, 15),
(122, 69, 16),
(125, 70, 19),
(124, 70, 24),
(123, 70, 27);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminID`);

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
  ADD KEY `postCode` (`postCode`,`readerID`),
  ADD KEY `readerID` (`readerID`);

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
  ADD KEY `nestedCommentCode` (`nestedCommentCode`),
  ADD KEY `bookBorrowCode` (`bookBorrowCode`);

--
-- Indexes for table `post_report`
--
ALTER TABLE `post_report`
  ADD PRIMARY KEY (`reportCode`),
  ADD KEY `postCode` (`postCode`,`readerID`),
  ADD KEY `readerID` (`readerID`);

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
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `adminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `book_borrowed`
--
ALTER TABLE `book_borrowed`
  MODIFY `bookBorrowCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `book_record`
--
ALTER TABLE `book_record`
  MODIFY `bookID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `comment_rating`
--
ALTER TABLE `comment_rating`
  MODIFY `commentCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `nested_comment_rating`
--
ALTER TABLE `nested_comment_rating`
  MODIFY `nestedCommentCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `notificationCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `post_report`
--
ALTER TABLE `post_report`
  MODIFY `reportCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `post_review`
--
ALTER TABLE `post_review`
  MODIFY `postCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `reader_user`
--
ALTER TABLE `reader_user`
  MODIFY `readerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `thread`
--
ALTER TABLE `thread`
  MODIFY `threadID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `thread_post`
--
ALTER TABLE `thread_post`
  MODIFY `threadPostCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

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
  ADD CONSTRAINT `comment_rating_ibfk_2` FOREIGN KEY (`postCode`) REFERENCES `post_review` (`postCode`) ON DELETE CASCADE;

--
-- Constraints for table `nested_comment_rating`
--
ALTER TABLE `nested_comment_rating`
  ADD CONSTRAINT `nested_comment_rating_ibfk_2` FOREIGN KEY (`readerID`) REFERENCES `reader_user` (`readerID`) ON DELETE CASCADE,
  ADD CONSTRAINT `nested_comment_rating_ibfk_3` FOREIGN KEY (`commentCode`) REFERENCES `comment_rating` (`commentCode`) ON DELETE CASCADE;

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`postCode`) REFERENCES `post_review` (`postCode`) ON DELETE CASCADE,
  ADD CONSTRAINT `notification_ibfk_2` FOREIGN KEY (`readerID`) REFERENCES `reader_user` (`readerID`) ON DELETE CASCADE,
  ADD CONSTRAINT `notification_ibfk_3` FOREIGN KEY (`commentCode`) REFERENCES `comment_rating` (`commentCode`) ON DELETE CASCADE,
  ADD CONSTRAINT `notification_ibfk_4` FOREIGN KEY (`nestedCommentCode`) REFERENCES `nested_comment_rating` (`nestedCommentCode`) ON DELETE CASCADE,
  ADD CONSTRAINT `notification_ibfk_5` FOREIGN KEY (`bookBorrowCode`) REFERENCES `book_borrowed` (`bookBorrowCode`) ON DELETE CASCADE;

--
-- Constraints for table `post_report`
--
ALTER TABLE `post_report`
  ADD CONSTRAINT `post_report_ibfk_1` FOREIGN KEY (`readerID`) REFERENCES `reader_user` (`readerID`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_report_ibfk_2` FOREIGN KEY (`postCode`) REFERENCES `post_review` (`postCode`) ON DELETE CASCADE;

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
