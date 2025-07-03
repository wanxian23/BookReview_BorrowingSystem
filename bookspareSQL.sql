-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 02, 2025 at 12:42 PM
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
-- Database: `student_bookspare`
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
(2, 'cwx', '$2y$10$2klv99v/PSU9u6uaRqwxH.XDognDuALaYVYZlwiR4qt3GezKcXU/6', 'cwx@mail.com', '01234567892', 'avatarUploads/img_6863cc522d85b_duck.jpg');

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
(1, 4, 1, 'abcabc', '123321123333', 'abccabc@gmail.com', 'abc', '2029-09-29 00:00:00', '2030-09-24 00:00:00', '', 'APPROVED', '2025-06-29 21:24:01', 'Meet In Person'),
(3, 8, 5, 'Fur Fur', '0125687740', 'furfur@gmail.com', 'johor bahru', '2025-07-01 00:00:00', '2026-07-01 00:00:00', 'cause i want to remember me lalalala', 'APPROVED', '2025-06-29 22:25:34', 'Meet In Person'),
(5, 1, 8, 'wanwan', '0122643499', 'wan@mail.com', 'Selangor', '2025-07-10 00:00:00', '2025-08-30 00:00:00', '我真的很喜欢女主角，快点借给我！', 'APPROVED', '2025-06-29 23:06:25', 'Postal Delivery'),
(6, 10, 7, 'WAWA', '0154567895', 'NOEMAIL@gmail.com', '1245', '2025-06-21 00:00:00', '2025-06-23 00:00:00', '我要看', 'APPROVED', '2025-06-29 23:10:20', 'Postal Delivery'),
(7, 10, 5, 'WAWA', '0154567895', 'NOEMAIL@gmail.com', '1245', '2025-06-21 00:00:00', '2025-06-24 00:00:00', '少管我🌹', 'APPROVED', '2025-06-29 23:24:39', 'Postal Delivery'),
(8, 9, 5, 'GAO XIAO', '0127100322', 'puiyic888@gmail.com', '我的家', '2025-06-30 00:00:00', '2026-06-22 00:00:00', '我能借你这本书嘛 感觉好有趣哦 我是coco的粉丝 可是我没有钱买他的书 所以只好借咯', 'APPROVED', '2025-06-29 23:27:54', 'Meet In Person'),
(9, 10, 1, 'WAWA', '0154567895', 'NOEMAIL@gmail.com', '1245', '2025-06-19 00:00:00', '2025-06-28 00:00:00', '盗版的哈利珀特 我要看 不给我我就报警', 'APPROVED', '2025-06-29 23:46:16', 'Postal Delivery'),
(10, 9, 2, 'GAO XIAO', '0127100322', 'puiyic888@gmail.com', '我家', '2025-07-07 00:00:00', '2025-07-08 00:00:00', '我想看看玻璃鞋子', 'APPROVED', '2025-06-29 23:49:48', 'Meet In Person'),
(11, 1, 19, '', '', NULL, 'Selangor', '0025-02-17 00:00:00', '2025-08-30 00:00:00', '我喜欢排球，所以借给我吧！', 'REJECTED', '2025-06-30 00:13:04', 'Postal Delivery'),
(12, 1, 22, '', '', NULL, 'Selangor', '2025-07-01 00:00:00', '2025-07-15 00:00:00', '别说了，借给我！', 'REJECTED', '2025-06-30 00:14:35', 'Meet In Person'),
(13, 1, 24, 'Chong WANWAN', '0122643499', 'wan@mail.com', 'Seri Kembangan, Selangor', '2025-07-15 00:00:00', '2025-08-01 00:00:00', '怎么那么哲学！我来借借看 :)', 'APPROVED', '2025-06-30 01:00:58', 'Meet In Person'),
(15, 11, 23, 'Orange', '0129876543', 'orange@mail.com', 'Selangor', '2025-07-17 00:00:00', '2025-07-30 00:00:00', 'Borrow!!!!!', 'APPROVED', '2025-06-30 03:18:57', 'Meet In Person'),
(16, 9, 20, 'GAO XIAO', '0127100322', 'puiyic888@gmail.com', 'Selangor', '2025-07-17 00:00:00', '2025-07-20 00:00:00', '我要看鬼故事！', 'APPROVED', '2025-06-30 04:00:28', 'Meet In Person'),
(17, 11, 20, '', '', NULL, 'Selangor', '2025-07-20 00:00:00', '2025-07-25 00:00:00', 'borrow me!', 'REJECTED', '2025-06-30 04:01:24', 'Postal Delivery'),
(18, 9, 23, 'GAO XIAO', '0127100322', 'puiyic888@gmail.com', 'Selangor', '2025-07-20 00:00:00', '2025-07-30 00:00:00', '我还要借买这本!', 'APPROVED', '2025-06-30 04:03:02', 'Postal Delivery'),
(19, 7, 22, '', '', NULL, 'melaka', '2025-06-05 00:00:00', '2025-07-03 00:00:00', '', 'PENDING', '2025-06-30 17:16:43', 'Meet In Person'),
(23, 2, 20, '', '', NULL, 'puchong', '2025-07-01 00:00:00', '2025-07-31 00:00:00', '你管我 leileileibubu', 'APPROVED', '2025-07-01 23:47:00', 'Postal Delivery'),
(24, 1, 26, '', '', NULL, 'Selangor', '2025-07-10 00:00:00', '2025-07-20 00:00:00', '借给我快点', 'REJECTED', '2025-07-02 00:20:28', 'Meet In Person'),
(25, 19, 12, '', '', NULL, 'Taman Tasik Utama', '2025-07-05 00:00:00', '2025-08-02 00:00:00', '', 'PENDING', '2025-07-02 11:38:58', 'Postal Delivery'),
(26, 15, 20, '', '', NULL, 'DT486 Taman Bukit Tambun Perdana Melaka', '2025-07-03 00:00:00', '2025-07-31 00:00:00', 'this book is interesting', 'PENDING', '2025-07-02 15:43:46', 'Postal Delivery'),
(27, 1, 28, '', '', NULL, 'Selangor', '2025-07-20 00:00:00', '2025-07-30 00:00:00', 'Hey yo! Please share me this book, nak tengok!! dont reject sankyou :)', 'APPROVED', '2025-07-02 15:45:53', 'Postal Delivery'),
(28, 1, 29, '', '', NULL, 'Selangor', '2025-07-15 00:00:00', '2025-07-20 00:00:00', 'This book is boring, but I still need it..', 'PENDING', '2025-07-02 16:06:21', 'Postal Delivery');

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
(1, 'Harry Potter'),
(2, 'Cinderella'),
(3, 'kanna'),
(4, 'bob si bodoh'),
(5, 'Coco'),
(6, 'APA U MAU?!!!!!'),
(7, '火箭狗'),
(8, 'Yōjo Senki'),
(9, 'CHIIKAWA'),
(10, 'Hello Kitty'),
(11, '德恒高中谋杀档案'),
(12, '课室杀人案'),
(13, 'GOOD MORNING'),
(14, 'The Complete Manual of Suicide'),
(15, 'Diary of a Wimpy Kid'),
(16, 'Civilizing Torture'),
(17, '早餐'),
(18, 'The Torture Letters: Reckoning with Police Violence'),
(19, 'Haikyū!!'),
(20, '听说学校有那个'),
(21, '听说我家有那个'),
(22, '听说宿舍有那个'),
(23, 'Classroom Murder'),
(24, 'Durham High School Murder Files'),
(25, 'I heard that there is one in the dormitory'),
(26, 'Rocket Dog'),
(27, '早餐breakfast'),
(28, 'Tangled'),
(29, '想为你的深夜放一束烟火'),
(30, 'F1: THE JOURNEY'),
(31, '夫人 你马甲又掉了'),
(32, 'Xxx Xxx Xxx Xxxxxx'),
(33, 'The Mermaid'),
(34, 'Ikigai'),
(35, 'Data Structure and Algorithm DITP2113');

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
  `statusComment` char(20) DEFAULT NULL,
  `reasonBan` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comment_rating`
--

INSERT INTO `comment_rating` (`commentCode`, `postCode`, `readerID`, `comment`, `dateComment`, `timeComment`, `rating`, `statusComment`, `reasonBan`) VALUES
(1, 1, 4, '123', 'Sunday, June 29, 202', '21:26:25', 10, 'APPROVED', NULL),
(2, 2, 5, 'nostalgic', 'Sunday, June 29, 202', '21:33:25', 8, 'APPROVED', NULL),
(3, 1, 5, 'too fictional', 'Sunday, June 29, 202', '21:34:14', -6, 'APPROVED', NULL),
(4, 2, 6, 'i cried reading it i love u cinderalla 👯👯👯👯', 'Sunday, June 29, 202', '21:36:44', 9, 'APPROVED', NULL),
(5, 1, 6, 'its so boring i couldnt finish it', 'Sunday, June 29, 202', '21:37:51', 1, 'APPROVED', NULL),
(6, 1, 6, 'its so boring i couldnt finish it', 'Sunday, June 29, 202', '21:38:09', 1, 'APPROVED', NULL),
(7, 2, 7, 'cinderella is THAT girl!', 'Sunday, June 29, 202', '21:43:23', 8, 'APPROVED', NULL),
(8, 2, 2, 'good', 'Sunday, June 29, 202', '21:43:56', 8, 'APPROVED', NULL),
(10, 4, 7, 'HAHAHAHAHAHAHA', 'Sunday, June 29, 202', '22:01:45', 1, 'APPROVED', NULL),
(11, 2, 8, 'remember me lalala', 'Sunday, June 29, 202', '22:02:55', 10, 'APPROVED', NULL),
(12, 3, 8, 'konichiwaaa', 'Sunday, June 29, 202', '22:09:17', 9, 'APPROVED', NULL),
(13, 5, 6, 'her nenek so cute 👯👯👯👯', 'Sunday, June 29, 202', '22:12:16', 7, 'APPROVED', NULL),
(16, 7, 1, '笑死！', 'Sunday, June 29, 202', '22:42:57', 1, 'APPROVED', NULL),
(17, 7, 10, '好看好看', 'Sunday, June 29, 202', '23:09:32', 10, 'APPROVED', NULL),
(18, 13, 10, '与人为善🌹 从早安开始散播正能量🌹支持支持🌹🌹', 'Sunday, June 29, 202', '23:22:53', 10, 'APPROVED', NULL),
(19, 13, 1, '为什么你是第一名！！！', 'Sunday, June 29, 202', '23:58:39', 5, 'APPROVED', NULL),
(20, 20, 1, '我必须满分！', 'Sunday, June 29, 202', '23:58:52', 10, 'APPROVED', NULL),
(21, 14, 1, 'Cruellllll!!!!!', 'Sunday, June 29, 202', '23:59:22', 9, 'APPROVED', NULL),
(22, 22, 1, '有被冒犯到！！！！', 'Monday, June 30, 202', '00:02:10', 1, 'APPROVED', NULL),
(23, 22, 10, '代入感强👍', 'Monday, June 30, 202', '00:05:02', 10, 'APPROVED', NULL),
(24, 20, 9, '没分', 'Monday, June 30, 202', '00:05:27', 1, 'APPROVED', NULL),
(25, 20, 10, 'too horror', 'Monday, June 30, 202', '00:06:09', 1, 'APPROVED', NULL),
(27, 3, 9, 'o', 'Monday, June 30, 202', '00:07:51', 10, 'APPROVED', NULL),
(28, 13, 10, '早安是一种人与人交际的态度与表达友好  上去👍', 'Monday, June 30, 202', '00:08:23', 10, 'APPROVED', NULL),
(29, 2, 9, '没分', 'Monday, June 30, 202', '00:08:57', 1, 'APPROVED', NULL),
(30, 13, 10, '不要让有心之人得逞 上去👍', 'Monday, June 30, 202', '00:09:04', 10, 'APPROVED', NULL),
(31, 14, 9, '好看', 'Monday, June 30, 202', '00:09:29', 9, 'APPROVED', NULL),
(32, 13, 10, '加油 上去', 'Monday, June 30, 202', '00:09:38', 10, 'APPROVED', NULL),
(33, 22, 10, '宿舍 上去', 'Monday, June 30, 202', '00:10:06', 10, 'APPROVED', NULL),
(34, 17, 9, '好吃', 'Monday, June 30, 202', '00:10:09', 10, 'APPROVED', NULL),
(35, 7, 10, '火箭狗上去', 'Monday, June 30, 202', '00:10:24', 10, 'APPROVED', NULL),
(37, 7, 10, '上去', 'Monday, June 30, 202', '00:11:02', 10, 'APPROVED', NULL),
(38, 17, 9, '超级好吃', 'Monday, June 30, 202', '00:11:23', 10, 'APPROVED', NULL),
(39, 13, 10, '早安 你一定要上去啊！！', 'Monday, June 30, 202', '00:11:29', 10, 'APPROVED', NULL),
(40, 17, 9, '卖相很好', 'Monday, June 30, 202', '00:11:50', 10, 'APPROVED', NULL),
(41, 13, 10, '加油 早安 你可以的！！', 'Monday, June 30, 202', '00:11:51', 10, 'APPROVED', NULL),
(42, 13, 10, '永支持', 'Monday, June 30, 202', '00:12:12', 10, 'APPROVED', NULL),
(43, 13, 10, '这世界不能没有早安', 'Monday, June 30, 202', '00:12:27', 10, 'APPROVED', NULL),
(44, 12, 9, '感动', 'Monday, June 30, 202', '00:12:27', 9, 'APPROVED', NULL),
(45, 13, 10, '上去', 'Monday, June 30, 202', '00:12:35', 10, 'APPROVED', NULL),
(46, 13, 10, '上', 'Monday, June 30, 202', '00:12:51', 10, 'APPROVED', NULL),
(47, 13, 10, '1', 'Monday, June 30, 202', '00:13:00', 10, 'APPROVED', NULL),
(48, 13, 10, '111', 'Monday, June 30, 202', '00:13:07', 10, 'APPROVED', NULL),
(49, 13, 10, '1', 'Monday, June 30, 202', '00:13:14', 10, 'APPROVED', NULL),
(50, 13, 9, '早安', 'Monday, June 30, 202', '00:13:16', 10, 'APPROVED', NULL),
(51, 13, 10, '1', 'Monday, June 30, 202', '00:13:25', 10, 'APPROVED', NULL),
(52, 13, 9, '早安啊', 'Monday, June 30, 202', '00:13:35', 10, 'APPROVED', NULL),
(53, 13, 10, '1', 'Monday, June 30, 202', '00:14:22', 10, 'APPROVED', NULL),
(54, 13, 10, '1', 'Monday, June 30, 202', '00:14:28', 10, 'APPROVED', NULL),
(55, 17, 10, '给早安让路', 'Monday, June 30, 202', '00:14:50', 8, 'APPROVED', NULL),
(56, 11, 9, '很浪漫', 'Monday, June 30, 202', '00:14:56', 9, 'APPROVED', NULL),
(57, 7, 10, '可爱', 'Monday, June 30, 202', '00:16:30', 10, 'APPROVED', NULL),
(58, 7, 10, '你也上去', 'Monday, June 30, 202', '00:16:41', 10, 'APPROVED', NULL),
(59, 7, 10, '1', 'Monday, June 30, 202', '00:16:53', 10, 'APPROVED', NULL),
(60, 7, 10, '1', 'Monday, June 30, 202', '00:17:02', 10, 'APPROVED', NULL),
(61, 7, 10, '1', 'Monday, June 30, 202', '00:17:12', 10, 'APPROVED', NULL),
(62, 7, 10, '1', 'Monday, June 30, 202', '00:17:19', 10, 'APPROVED', NULL),
(63, 7, 10, '1', 'Monday, June 30, 202', '00:17:25', 10, 'APPROVED', NULL),
(64, 7, 10, '1', 'Monday, June 30, 202', '00:17:32', 10, 'APPROVED', NULL),
(65, 7, 10, '1', 'Monday, June 30, 202', '00:17:41', 10, 'APPROVED', NULL),
(66, 7, 10, '1', 'Monday, June 30, 202', '00:17:49', 10, 'APPROVED', NULL),
(67, 7, 9, '好看', 'Monday, June 30, 202', '00:17:49', 10, 'APPROVED', NULL),
(68, 12, 10, '1', 'Monday, June 30, 202', '00:18:01', 10, 'APPROVED', NULL),
(69, 7, 9, '真可爱', 'Monday, June 30, 202', '00:18:02', 10, 'APPROVED', NULL),
(70, 12, 10, '1', 'Monday, June 30, 202', '00:18:07', 10, 'APPROVED', NULL),
(71, 7, 9, '看到我都会飞', 'Monday, June 30, 202', '00:18:26', 10, 'APPROVED', NULL),
(72, 7, 9, '飞', 'Monday, June 30, 202', '00:18:40', 10, 'APPROVED', NULL),
(73, 14, 10, '你也上去', 'Monday, June 30, 202', '00:19:14', 10, 'APPROVED', NULL),
(74, 2, 10, '什么东西 你下去', 'Monday, June 30, 202', '00:19:48', 1, 'APPROVED', NULL),
(75, 5, 10, '你也下去', 'Monday, June 30, 202', '00:20:01', 1, 'APPROVED', NULL),
(76, 7, 9, '热狗', 'Monday, June 30, 202', '00:20:16', 10, 'APPROVED', NULL),
(77, 20, 12, '这本还没看捏', 'Monday, June 30, 202', '00:41:31', 8, 'APPROVED', NULL),
(78, 2, 12, 'mana rapunzel', 'Monday, June 30, 202', '00:43:32', 7, 'APPROVED', NULL),
(79, 15, 1, 'wowwwwwwwwww', 'Monday, June 30, 202', '00:50:05', 9, 'APPROVED', NULL),
(80, 23, 12, 'nice2', 'Monday, June 30, 202', '01:01:08', 10, 'APPROVED', NULL),
(81, 23, 10, 'Too fantasy', 'Monday, June 30, 202', '01:15:52', 1, 'APPROVED', NULL),
(82, 23, 1, 'Repunzelll!!!!', 'Monday, June 30, 202', '01:16:16', 10, 'APPROVED', NULL),
(83, 9, 10, 'cute', 'Monday, June 30, 202', '01:16:47', 10, 'APPROVED', NULL),
(84, 22, 10, 'up', 'Monday, June 30, 202', '01:17:13', 10, 'APPROVED', NULL),
(85, 1, 1, 'FULL MARK OK!! HARRY!', 'Monday, June 30, 202', '10:46:39', 10, 'APPROVED', NULL),
(86, 25, 1, 'Full markssssssssss', 'Tuesday, July 1, 202', '21:19:58', 10, 'APPROVED', NULL),
(87, 22, 2, '好恐怖 感觉冒犯到我了', 'Tuesday, July 1, 202', '23:49:45', 1, 'APPROVED', NULL),
(88, 8, 15, 'w', 'Wednesday, July 2, 2', '12:38:35', 10, 'APPROVED', NULL);

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
  `statusNestedComment` char(20) DEFAULT NULL,
  `reasonBan` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nested_comment_rating`
--

INSERT INTO `nested_comment_rating` (`nestedCommentCode`, `comment`, `dateComment`, `readerID`, `commentCode`, `timeComment`, `statusNestedComment`, `reasonBan`) VALUES
(4, 'Ur name  cuter than THAT girl!!', 'Sunday, June 29, 202', 1, 7, '21:54:11', 'APPROVED', NULL),
(7, '你干嘛！', 'Monday, June 30, 202', 1, 28, '00:08:53', 'APPROVED', NULL),
(9, '那是你的问题 不是我的🌹自己反思', 'Monday, June 30, 202', 10, 22, '00:59:18', 'APPROVED', NULL),
(13, '我也还没 :)', 'Monday, June 30, 202', 1, 77, '03:11:59', 'APPROVED', NULL),
(14, '你怎么这样！！', 'Monday, June 30, 202', 1, 81, '03:12:41', 'APPROVED', NULL),
(15, '你好，哈哈哈哈！', 'Monday, June 30, 202', 1, 8, '03:14:16', 'APPROVED', NULL),
(16, 'Hohoho', 'Monday, June 30, 202', 1, 2, '03:14:33', 'APPROVED', NULL),
(17, 'Hahahahaha', 'Monday, June 30, 202', 1, 4, '03:14:56', 'APPROVED', NULL),
(18, '你hou啊！我等下就post remember me！', 'Monday, June 30, 202', 1, 11, '03:15:30', 'APPROVED', NULL),
(19, 'YESSS!', 'Monday, June 30, 202', 11, 82, '03:16:45', 'APPROVED', NULL),
(20, 'thankyou, the author is actually me :)) #fact', 'Tuesday, July 1, 202', 7, 86, '21:27:51', 'APPROVED', NULL),
(21, '支持\r\n', 'Tuesday, July 1, 202', 2, 22, '23:50:23', 'APPROVED', NULL),
(22, '好假', 'Tuesday, July 1, 202', 2, 23, '23:50:44', 'APPROVED', NULL),
(23, 'bla bla bla ble ble ble blu blu blu', 'Wednesday, July 2, 2', 15, 86, '12:53:11', 'APPROVED', NULL),
(24, 'Good bok\r\n', 'Wednesday, July 2, 2', 15, 86, '12:53:52', 'APPROVED', NULL);

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
(2, 1, 4, NULL, NULL, 'UNREAD', 1, NULL),
(6, 5, 8, NULL, NULL, 'UNREAD', 3, NULL),
(8, 8, 1, NULL, NULL, 'UNREAD', 5, NULL),
(9, 7, 10, NULL, NULL, 'UNREAD', 6, NULL),
(10, 5, 10, NULL, NULL, 'UNREAD', 7, NULL),
(11, 5, 9, NULL, NULL, 'UNREAD', 8, NULL),
(12, 1, 10, NULL, NULL, 'UNREAD', 9, NULL),
(13, 2, 9, NULL, NULL, 'UNREAD', 10, NULL),
(14, 20, NULL, NULL, NULL, 'UNREAD', NULL, '2025-06-30 00:00:05'),
(15, 19, 1, NULL, NULL, 'UNREAD', 11, NULL),
(16, 22, 1, NULL, NULL, 'UNREAD', 12, NULL),
(17, 24, 1, NULL, NULL, 'UNREAD', 13, NULL),
(18, 20, 1, NULL, 13, 'UNREAD', NULL, NULL),
(19, 23, 1, NULL, 14, 'UNREAD', NULL, NULL),
(20, 2, 1, NULL, 15, 'UNREAD', NULL, NULL),
(21, 2, 1, NULL, 16, 'UNREAD', NULL, NULL),
(22, 2, 1, NULL, 17, 'UNREAD', NULL, NULL),
(23, 2, 1, NULL, 18, 'UNREAD', NULL, NULL),
(24, 23, 11, NULL, 19, 'UNREAD', NULL, NULL),
(26, 23, 11, NULL, NULL, 'UNREAD', 15, NULL),
(27, 20, 9, NULL, NULL, 'UNREAD', 16, NULL),
(28, 20, 11, NULL, NULL, 'UNREAD', 17, NULL),
(29, 23, 9, NULL, NULL, 'UNREAD', 18, NULL),
(30, 22, 7, NULL, NULL, 'UNREAD', 19, NULL),
(34, 25, 7, NULL, 20, 'UNREAD', NULL, NULL),
(35, 20, 2, NULL, NULL, 'UNREAD', 23, NULL),
(36, 22, 2, NULL, 21, 'UNREAD', NULL, NULL),
(37, 22, 2, NULL, 22, 'UNREAD', NULL, NULL),
(38, 26, 1, NULL, NULL, 'UNREAD', 24, NULL),
(39, 12, 19, NULL, NULL, 'UNREAD', 25, NULL),
(40, 25, 15, NULL, 23, 'UNREAD', NULL, NULL),
(41, 25, 15, NULL, 23, 'UNREAD', NULL, NULL),
(42, 20, 15, NULL, NULL, 'UNREAD', 26, NULL),
(43, 28, 1, NULL, NULL, 'UNREAD', 27, NULL),
(44, 29, 1, NULL, NULL, 'UNREAD', 28, NULL);

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
(1, 'inappropriate', 'So Bad!!!!', 4, 1, '2025-06-29 22:01:52'),
(2, 'hate', '', 4, 7, '2025-06-29 22:02:29'),
(3, 'inappropriate', 'APA DU', 6, 9, '2025-06-29 22:53:08'),
(4, 'inappropriate', 'i dont want see kanna', 3, 10, '2025-06-29 23:08:54'),
(5, 'inappropriate', '', 14, 12, '2025-06-30 01:17:07'),
(6, 'offTopic', 'test', 23, 9, '2025-06-30 03:25:27'),
(7, 'inappropriate', 'test', 23, 9, '2025-06-30 03:54:49'),
(8, 'spam', '', 24, 7, '2025-07-01 16:52:20'),
(9, 'harassment', 'very disturbing', 6, 7, '2025-07-01 21:26:36'),
(10, 'hate', '', 7, 2, '2025-07-02 00:12:52'),
(11, 'inappropriate', '', 13, 1, '2025-07-02 04:08:44');

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
(1, 1, 1, 'bookUploads/img_68613854d3dc5_harrypotter_frontCover.jpg', 'Harry Potter is a fantasy book and film series written by J.K. Rowling. It follows the story of a young orphaned boy, Harry Potter, who discovers on his 11th birthday that he is a wizard. He is invited to attend Hogwarts School of Witchcraft and Wizardry, where he learns about magic, friendship, and his mysterious past.\r\n\r\nAt Hogwarts, Harry makes close friends—Ron Weasley and Hermione Granger—and uncovers the truth about his parents’ death. They were murdered by the dark wizard Lord Voldemort, who failed to kill baby Harry and mysteriously lost his powers instead. As the series progresses, Harry becomes Voldemort’s greatest threat, with their final battle culminating in the defeat of evil.\r\n\r\nThe series explores themes of bravery, loyalty, friendship, good vs. evil, and self-discovery, and is spread across seven books and eight films, starting with Harry Potter and the Philosopher’s Stone and ending with Harry Potter and the Deathly Hallows.', 'JK Rowling', 'Mystery', '2025-06-29 20:57:56', 'NO', 'APPROVED', NULL),
(2, 1, 2, 'bookUploads/img_686139ab870fd_cinderella_frontCover.jpg', 'Cinderella is a timeless fairy tale about a kind-hearted young woman who is mistreated by her wicked stepmother and stepsisters after her father\'s death. Forced into servitude, Cinderella remains gentle and hopeful despite her hardships.\r\n\r\nOne day, the royal palace announces a grand ball where the prince will choose a bride. Cinderella longs to attend, but her stepfamily prevents her. With the magical help of her Fairy Godmother, Cinderella is transformed—dressed in a beautiful gown and glass slippers—and attends the ball. She captivates the prince, but must flee before midnight, when the magic ends, leaving behind a single glass slipper.\r\n\r\nThe prince searches the kingdom for the girl whose foot fits the slipper. Despite her stepfamily’s attempts to hide her, Cinderella is found and the slipper fits. She and the prince are reunited, and they live happily ever after.', 'Charles Perrault', 'Fantasy', '2025-06-29 21:03:39', 'NO', 'APPROVED', NULL),
(3, 4, 3, 'bookUploads/img_68614328a37d7_images.jpg', 'kanna kawwaiii', 'ahaha', 'Action', '2025-06-29 21:44:08', 'NO', 'APPROVED', ''),
(4, 6, 4, 'bookUploads/img_686146b3bcd9f_20250629_120539.jpg', 'bodo betul bob ni serabut #pergimampos', 'kasim abdullah', 'Thriller', '2025-06-29 21:59:15', 'NO', 'BANNED', 'BADDD!!! HAAHHAA'),
(5, 1, 5, 'bookUploads/img_686149391a1fb_coco_frontCover.jpg', 'Coco is a heartwarming animated film by Pixar Animation Studios and released by Walt Disney Pictures.\r\n\r\nThe story follows Miguel Rivera, a 12-year-old boy who dreams of becoming a musician like his idol Ernesto de la Cruz, despite his family’s generations-old ban on music. On Día de los Muertos (the Day of the Dead), Miguel accidentally finds himself in the Land of the Dead, where he meets his deceased relatives and a charming trickster named Héctor.\r\n\r\nTogether, Miguel and Héctor embark on a journey to uncover the truth about Miguel’s family history, break the curse, and restore music to his life. Along the way, the film beautifully explores themes of family, memory, identity, and the importance of honoring ancestors.', 'Lee Unkrich', 'Fantasy', '2025-06-29 22:10:01', 'NO', 'APPROVED', NULL),
(6, 1, 6, 'bookUploads/img_68614dd3b5a21_meme.jpg', 'APPAPAPPAP U MAU!!!', 'hahaha', 'Fantasy', '2025-06-29 22:29:39', 'NO', 'BANNED', 'Not Relevant !!'),
(7, 9, 26, 'bookUploads/img_686150d0118f9_7555763280_5a68f2bfdf.jpg', '一只小狗变成火箭一样腾空而起，底部喷出火焰和烟雾 飞去外太空 小狗闭着眼睛 享受着，看起来十分可爱 狗屁喷火  A puppy turns into a rocket and flies into the sky, with flames and smoke coming out of the bottom. It flies into outer space. The puppy closes his eyes and enjoys it, looking very cute. Dog Shit Spraying Fire', 'cpy', 'Comedy', '2025-06-29 22:42:24', 'NO', 'SUSPICIOUS', NULL),
(8, 9, 8, 'bookUploads/img_686154db33617_7ccc7e99690bc8d79c722a4ff45ab36c.jpg', 'In 2013 of modern-era Tokyo, an unnamed atheist Japanese salaryman, in the moment of being murdered by a disgruntled subordinate whom he had fired due to poor performance at work, is confronted by an entity that declares itself to be God who condemns the salaryman for not having \'faith\'. The salaryman disbelieves in its existence, criticises its various statements from his perspective as an atheist and mockingly terms it as \'Being X\'. The entity decides to reincarnate the salaryman into a world where he would face sufficiently difficult circumstances to turn to Being X for help.\r\n\r\nThe salaryman is reborn as Tanya Degurechaff, an orphaned girl in an alternate universe\'s equivalent of Imperial Germany, known as the Empire, in which World War I has been delayed until the 1920s and where magic has been incorporated into the military. According to Being X, if Tanya either does not die a natural death or refuses to have faith in it, her soul will leave the cycle of reincarnation and will be sent to hell for the countless sins that Tanya has committed in her previous life. In search for an escape, Tanya decides to join the Empire\'s Mage Corps and fight in the war, hoping to reach a high enough rank as fast as possible to remain far from the battlefield, and in this way avoid the risk of being killed. Even if she\'s now forced to speak with a young girl\'s lips, Tanya soon turns into a ruthless soldier who prioritizes efficiency and her own career over anything else, even the lives of those beneath her, especially those that get on her bad side.', 'Carlo Zen', 'Crime', '2025-06-29 22:59:39', 'NO', 'APPROVED', NULL),
(9, 9, 9, 'bookUploads/img_6861578cb7269_33f3b2c35fa2adb466b56aa8168d97da.jpg', 'Chiikawa (ちいかわ), also known as Nanka Chiisakute Kawaii Yatsu (なんか小さくてかわいいやつ; \'literally translated to: Something Small and Cute\'), is a Japanese manga series written and illustrated by Nagano. It follows the daily adventures of the titular protagonist, along with a series of animal-inspired characters.\r\n\r\nThe series has been serialized online via X (formerly Twitter) since January 2020 and has been collected in seven tankōbon volumes by Kodansha, as of November 2024. An anime television series adaptation was produced by Doga Kobo and premiered in April 2022. The first season aired in Japan from April 2022 to March 2025, with the second season scheduled to premiere in July of that year.[1][2] By November 2024, Chiikawa had sold over 3.6 million copies, including digital versions in circulation', 'Takenori Mihara', 'Comedy', '2025-06-29 23:11:08', 'YES', 'APPROVED', NULL),
(10, 9, 10, 'bookUploads/img_686158927610b_e3a88b3f0333128bf9cbaa4d477a3a20.jpg', 'There have been several different animated series starring Hello Kitty. The first was Hello Kitty\'s Furry Tale Theater, an animated television series with 13 22-minute episodes that premiered in 1987.[53] The next, an OVA titled Hello Kitty and Friends, spanned 30 entries originally released in Japan between 1989 and 1994. Hello Kitty\'s Paradise came out in 1999 and was 16 episodes long. Hello Kitty\'s Stump Village came out in 2005, and The Adventures of Hello Kitty & Friends came out in 2008 and has aired 52 episodes. A crossover series under the name Kiss Hello Kitty (that paired animated versions of the members of the rock band KISS with Hello Kitty) was announced in March 2013. Produced by Gene Simmons, this show was supposed to air on The Hub Network (now Discovery Family),[54] but it never came to fruition.', '清水裕子', 'Comedy', '2025-06-29 23:15:30', 'YES', 'APPROVED', NULL),
(11, 10, 24, 'bookUploads/img_686158aa519f6_images.jpg', 'This is a unique branch interactive novel. Seventeen children in T City disappeared mysteriously within three months, and the son of Sun Zhiliang, a teacher at Deheng High School, was one of them. Sun Zhiliang asked the young detective Yi Tian to help investigate. After Yi Tian went deep into Deheng High School, he was involved in a series of murders. First, the principal Ping Yaohai was killed in the classroom of the teaching building. The bodies of the murderer \"Mr. Moon Night\" and Ping Yaohai disappeared within three minutes. Then the teachers related to the children\'s disappearances were killed one after another, and even the female student who accidentally learned the identity of the murderer was killed.', '-', 'Crime', '2025-06-29 23:15:54', 'YES', 'APPROVED', NULL),
(12, 10, 23, 'bookUploads/img_68615987d5907_查询书籍信息.png', 'Under the tranquility of the campus, a bloody killing broke the peace of the classroom. A strict teacher made students dissatisfied with his excessive disciplinary methods. These suppressed emotions broke out one day, and a student killed the teacher on impulse. After the case, the school fell into panic and chaos. The police intervened in the investigation. As clues gradually surfaced, the truth behind it was the students\' long-term psychological pressure and resistance to the education method. This tragedy is not only an individual\'s impulsive act, but also a profound reflection on the education system and the relationship between teachers and students. It warns people to pay attention to students\' mental health and reasonable education methods.', '-', 'Crime', '2025-06-29 23:19:35', 'YES', 'APPROVED', NULL),
(13, 9, 13, 'bookUploads/img_686159f1194ac_pngtree-good-morning-hello-day-sign-simple-little-fresh-dream-poster-14-png-image_7319756.png', '早安 早上好 你好 你们都好 好好笑 早安不只是打招呼 还是一个早安', 'CPY', 'Comedy', '2025-06-29 23:21:21', 'YES', 'APPROVED', ''),
(14, 10, 14, 'bookUploads/img_68615c56687af_download.jpg', 'Please note that the content of this book primarily consists of articles available from Wikipedia or other free sources online. The Complete Manual of Suicide (Kanzen Jisatsu Manyuaru, lit. Complete Suicide Manual) is a Japanese book written by Wataru Tsurumi. It was first published on July 4, 1993 and sold more than one million copies. This 198 page book provides explicit descriptions and analysis on a wide range of suicide methods such as overdosing, hanging, jumping, and carbon monoxide poisoning. It is not a suicide manual for the terminally ill. There is no preference shown for painless or dignified ways of ending one\'s life. The book provides matter-of-fact assessment of each method in terms of the pain it causes, effort of preparation required, the appearance of the body and lethality. Since the book was intended to be a manual, the author did not spend too much space on discussing the reasons and philosophy behind suicide. Although he does rhetorically pose the question Why must one live? Wataru simply lays out the methods of suicide one by one and then analyzes each of them in detail.', 'Frederic P. Miller, Agnes F. Vandome, McBrewster J', 'Educational', '2025-06-29 23:31:34', 'YES', 'BANNED', 'Too violent!!!!'),
(15, 5, 15, 'bookUploads/img_68615d4d57895_front1.png', 'Diary of a Wimpy Kid\" is a humorous novel series written from the perspective of Greg Heffley, a middle school student who chronicles his daily life in a diary (which he insists is a journal) filled with his thoughts, experiences, and attempts to navigate the social complexities of middle school. The series follows Greg\'s misadventures as he deals with his family, friends, and the ups and downs of school life, often with humorous and relatable outcomes. ', 'Jeff Kinney', 'Comedy', '2025-06-29 23:35:41', 'NO', 'APPROVED', NULL),
(16, 10, 16, 'bookUploads/img_68615d8c31ca1_9780674244702.jpg', '“A sobering history of how American communities and institutions have relied on torture in various forms since before the United States was founded.”\r\n—Los Angeles Times\r\n\r\n“That Americans as a people and a nation-state are violent is indisputable. That we are also torturers, domestically and internationally, is not so well established. The myth that we are not torturers will persist, but Civilizing Torture will remain a powerful antidote in confronting it.”\r\n—Lawrence Wilkerson, former Chief of Staff to Secretary of State Colin Powell\r\n\r\n“Remarkable…A searing analysis of America’s past that helps make sense of its bewildering present.”\r\n—David Garland, author of Peculiar Institution\r\n\r\nMost Americans believe that a civilized state does not torture, but that belief has repeatedly been challenged in moments of crisis at home and abroad. From the Indian wars to Vietnam, from police interrogation to the War on Terror, US institutions have proven far more amenable to torture than the nation’s commitment to liberty would suggest.\r\n\r\nCivilizing Torture traces the history of debates about the efficacy of torture and reveals a recurring struggle to decide what limits to impose on the power of the state. At a time of escalating rhetoric aimed at cleansing the nation of the undeserving and an erosion of limits on military power, the debate over torture remains critical and unresolved.', 'W. Fitzhugh Brundage is William B. Umstead Profess', 'Educational', '2025-06-29 23:36:44', 'YES', 'APPROVED', NULL),
(17, 9, 27, 'bookUploads/img_68615dee34367_Image_20250629233532.png', '早餐是一天中的第一餐，通常在早晨起床后食用。它的主要功能是为身体提供经过一夜休息后所需的能量和营养，帮助人们开始新的一天。合理的早餐有助于维持血糖稳定、提高注意力和记忆力、增强免疫力，并对控制体重、保护肠胃也有积极作用。一个均衡的早餐通常包括碳水化合物、蛋白质、维生素和适量脂肪等营养成分。\r\n\r\nBreakfast is the first meal of the day and is usually eaten in the morning after getting up. Its main function is to provide the body with the energy and nutrition it needs after a night\'s rest and help people start a new day. A reasonable breakfast helps maintain blood sugar stability, improves concentration and memory, enhances immunity, and also has a positive effect on weight control and gastrointestinal protection. A balanced breakfast usually includes nutrients such as carbohydrates, proteins, vitamins and a moderate amount of fat.', 'cpy', 'Educational', '2025-06-29 23:38:22', 'YES', 'APPROVED', NULL),
(18, 10, 18, 'bookUploads/img_68615df41fb76_9780226650098.jpg', 'Torture is an open secret in Chicago. Nobody in power wants to acknowledge this grim reality, but everyone knows it happens—and that the torturers are the police. Three to five new claims are submitted to the Torture Inquiry and Relief Commission of Illinois each week. Four hundred cases are currently pending investigation. Between 1972 and 1991, at least 125 black suspects were tortured by Chicago police officers working under former Police Commander Jon Burge. As the more recent revelations from the Homan Square “black site” show, that brutal period is far from a historical anomaly. For more than fifty years, police officers who took an oath to protect and serve have instead beaten, electrocuted, suffocated, and raped hundreds—perhaps thousands—of Chicago residents.\r\n \r\nIn The Torture Letters, Laurence Ralph chronicles the history of torture in Chicago, the burgeoning activist movement against police violence, and the American public’s complicity in perpetuating torture at home and abroad. Engaging with a long tradition of epistolary meditations on racism in the United States, from James Baldwin’s The Fire Next Time to Ta-Nehisi Coates’s Between the World and Me, Ralph offers in this book a collection of open letters written to protesters, victims, students, and others. Through these moving, questing, enraged letters, Ralph bears witness to police violence that began in Burge’s Area Two and follows the city’s networks of torture to the global War on Terror. From Vietnam to Geneva to Guantanamo Bay—Ralph’s story extends as far as the legacy of American imperialism. Combining insights from fourteen years of research on torture with testimonies of victims of police violence, retired officers, lawyers, and protesters, this is a powerful indictment of police violence and a fierce challenge to all Americans to demand an end to the systems that support it.\r\n \r\nWith compassion and careful skill, Ralph uncovers the tangled connections among law enforcement, the political machine, and the courts in Chicago, amplifying the voices of torture victims who are still with us—and lending a voice to those long deceased.', 'Laurence Ralph', 'Educational', '2025-06-29 23:38:28', 'YES', 'APPROVED', NULL),
(19, 9, 19, 'bookUploads/img_68615f11da0ab_9b97ab3b0b0781c310b8512e31400df3.jpg', 'Junior high school student, Shoyo Hinata, becomes obsessed with volleyball after catching a glimpse of Karasuno High School playing in the Nationals on TV. Of short stature himself, Hinata is inspired by a player the commentators nickname \'The Little Giant\', Karasuno\'s short but talented wing spiker. Though inexperienced, Hinata is athletic and has an impressive vertical jump. He joins his school\'s volleyball club—only to find he is its sole member, forcing him to spend the next two years trying to convince other students to help him practice.\r\n\r\nIn the third and final year of junior high, some of Hinata\'s friends agree to join the club so he can compete in a tournament. In his first official game ever, they suffer a crushing defeat to the team favored to win the tournament—that included third-year Tobio Kageyama, a prodigy setter nicknamed \'The King of the Court\' for both his skill and his brutal play style. The two spark a short rivalry, and after the game, Hinata vows to defeat Kageyama in high school.\r\n\r\nHinata studies and is accepted to Karasuno, the same high school the \"Little Giant\" played for, but is shocked to discover that Kageyama has also chosen to attend Karasuno. Karasuno is revealed to have lost its reputation as a powerhouse school following the era of the Little Giant, often being referred to as \'The Wingless Crows\' by other local teams. However, by combining Kageyama\'s genius setting skills with Hinata\'s remarkable athleticism, the duo create an explosive new volleyball tactic and develop an unexpected but powerful setter-spiker partnership.\r\n\r\nAlong the way, Hinata and Kageyama push each other into reaching their full potential, and Hinata develops relationships with his first real team, thus beginning Karasuno\'s journey of redemption to restore their reputation and make it to the Nationals.\r\n\r\nBoth Hinata and Kageyama aspire to be professional volleyball players, and make a promise to one another after they graduate from high school that no matter what, they will both play on the same court again. They have a remarkable bond and devote their lives to each other and the sport of volleyball.', 'Haruichi Furudate', 'Action', '2025-06-29 23:43:13', 'YES', 'APPROVED', NULL),
(20, 1, 20, 'bookUploads/img_6861f8b551cdc_听说学校有哪个_frontCover.jpg', '这是一部结合校园悬疑与青春成长元素的小说，讲述了一所普通高中里流传着一个神秘传言：“学校里有那个。”\r\n\r\n所谓“那个”，没人说得清是什么，但它似乎总在深夜现身于教学楼的尽头，被目睹的人不是发疯，就是突然退学。故事围绕五名性格迥异的学生展开——他们因好奇而组成“校内调查小队”，试图揭开“那个”的真相，却逐渐卷入了学校三十年前未解的秘密与禁忌。\r\n\r\n在追查过程中，他们不仅面对未知的恐惧，也逐渐揭露彼此隐藏的心事与过往。而“那个”到底是超自然的存在，还是人心深处的投影？谜底等待他们自己去揭晓。\r\n\r\n本书融合惊悚与温情，描绘了青春期的不安、友情的考验以及对真实与勇气的追寻。\r\n\r\n', '张义方', 'Horror', '2025-06-29 23:56:15', 'YES', 'APPROVED', NULL),
(21, 9, 21, 'bookUploads/img_686162fb583e0_14778754382634400_a700xH.jpg', '自从我搬进新家后，意外发现家中存在“不可见的住客”——鬼魂。随着与这些灵异存在的互动逐渐加深，一连串令人毛骨悚然又耐人寻味的事件也随之展开。本作在惊悚氛围中巧妙穿插温情与幽默，揭示了鬼魂背后的秘密与人与人之间的情感联系', 'me', 'Horror', '2025-06-29 23:59:55', 'YES', 'APPROVED', NULL),
(22, 10, 25, 'bookUploads/img_6861631610136_查询书籍信息.png', 'The school was on a long vacation, and my roommates left the school one after another, dragging their suitcases and looking forward to home. The whole dormitory building gradually became empty. I stayed alone for various reasons. In the quiet dormitory, loneliness came over me like a tide. But just as the night fell, a rustling sound suddenly came from the darkness. I pricked up my ears, and my heartbeat suddenly accelerated - the whole dormitory area was so deserted that it seemed like no one was there, so how could there be a sound? Where did this sound come from? Was it someone who had not left the school yet, or...', '-', 'Horror', '2025-06-30 00:00:22', 'YES', 'APPROVED', NULL),
(23, 1, 28, 'bookUploads/img_6861703663a84_tangled_frontCover.jpg', 'Tangled is a heartwarming animated adventure from Disney that reimagines the classic tale of Rapunzel. The story follows Rapunzel, a spirited young woman with 70 feet of magical golden hair who has spent her entire life locked away in a secluded tower by Mother Gothel, who uses Rapunzel’s hair to stay young.\r\n\r\nOn the eve of her 18th birthday, Rapunzel longs to leave the tower and see the mysterious floating lanterns that appear every year on her birthday. Her life takes an unexpected turn when she meets Flynn Rider, a charming and witty thief on the run. Together, they embark on a thrilling journey filled with humor, discovery, and self-realization.\r\n\r\nAs Rapunzel learns the truth about her past and her identity as the lost princess, she discovers the strength and courage to reclaim her life and follow her dreams.\r\n\r\nTangled is a vibrant tale about freedom, love, and the power of believing in yourself.', 'Dan Fogelman', 'Fantasy', '2025-06-30 00:56:22', 'NO', 'APPROVED', ''),
(24, 12, 29, 'bookUploads/img_68617111c9a38_LiuBook.jpg', '刘同2022全新作品，书写23个疗愈心灵的故事，暗处亦有光亮，深夜亦可疗伤。 在本书中，刘同用120%的真诚，记录了人生中最狼狈、最尴尬、最不想面对的23个深夜时刻，也同时记录了身边人一次次鼓舞自己的23个烟火瞬间。每个人都会经历那种深夜难熬、白日难眠的日子。但要知道，人生不光只有白天或艳阳，也有深夜与烟火。纵有起落，冲要冲得无畏，丧要丧得热烈！ 祝你深夜快乐。 刘同想对读者说的话—— ·为什么书名叫《想为你的深夜放一束烟火》？ 写这本书时都在深夜，常常写完一个故事，自己也被治愈了。 每一个字、每一句话都像深夜里盛开的烟火，抚慰了我。 因此也希望它能安慰到每一位读者。 ·你希望读者能从中读出什么？ 作为写作者，我只能尽可能在文字里将自己剖析， 以毫不伪装的真实面貌与读者相见。 我希望当你拿起这本书时， 读一小段便能感觉到平静，有想继续交流的欲望。 对我而言，这就很安慰了。 ·什么样的读者适合看这本书？ 书里有一句话——人生不只有白天和艳阳，还有深夜与烟火。 如果你也在深夜里一个人独处，思量过未来的路， 也曾希望在黑暗中，遇见一个懂自己的人， 那这本书或许就能给到你一些抚慰。 ·你想对这本书的读者说些什么？ 谢谢你拿起这本书，希望你想翻开它。 谢谢你翻开这本书，希望它能陪伴你。', '刘同', 'Romance', '2025-06-30 00:59:07', 'NO', 'APPROVED', ''),
(25, 7, 30, 'bookUploads/img_68628cab31cda_f1_the journey.jpg', '12 drivers fighting each other in a car', 'Jenson Button', 'Action', '2025-06-30 21:10:03', 'YES', 'APPROVED', NULL),
(26, 2, 31, 'bookUploads/img_686405626d1a4_小说.jfif', '【腹黑慵懒巨有钱男主vs高岭之花藏得深女主】秦苒，从小在乡下长大，高三失踪一年，休学一年。一年后，她被亲生母亲接到云城一中借读。母亲说你后爸是名门之后，你大哥自小就是天才，你妹妹是一中尖子生，你不要丢他们的脸。**京城有身份的人暗地里都收到程家隽爷的一份警告隽爷老婆是乡下人，不懂圈子不懂时势不懂金融行情……脾气还差的很，总之，大家多担待。直到一天，隽爷调查某个大佬时，他的手下望着不小心扒出来的据说什么都不懂的小嫂子的其中一个马甲……陷入迷之沉默。大概就是两个大佬为了不让对方自卑，互相隐藏马甲的故事。', '一路烦花', 'Mystery', '2025-07-01 23:57:22', 'YES', 'APPROVED', NULL),
(27, 19, 33, 'bookUploads/img_6864aab6dc7c2_Logo-FTMK.png', 'This is about a mermaid in far away island. ', 'XYZ', 'Fantasy', '2025-07-02 11:42:46', 'YES', 'APPROVED', NULL),
(28, 15, 34, 'bookUploads/img_6864b550adea3_image_2025-07-02_122756185.png', 'Ikigai, a Japanese concept, translates to \"a reason for being\" or \"a reason to wake up in the morning\". It embodies the idea of finding joy and purpose in life, leading to a long and happy life, particularly among the people of Okinawa, Japan. Discovering one\'s ikigai involves identifying what you love, what you\'re good at, what the world needs, and what you can be paid for. ', 'Hector Garcia', 'Educational', '2025-07-02 12:28:00', 'YES', 'APPROVED', NULL),
(29, 15, 35, 'bookUploads/img_6864e84f0d70d_image_2025-07-02_160530224.png', 'True definition of horror.', 'Lecturer UTeM', 'Horror', '2025-07-02 16:05:35', 'YES', 'APPROVED', NULL);

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
(1, 'wanwan', 'wan@mail.com', '0122643499', 'Malaysia', '2005-04-23', '$2y$10$LWLPEFZ/bYmNMhdddGjhvuli7PjX/yfBMRTU1CF.41tV2CoNMlRJi', 'avatarUploads/img_6861381eb521d_jingliu6_2.png'),
(2, '白天姐姐', 'abcdacc@gmail.com', '0135542860', 'Malaysia', '2000-11-29', '$2y$10$vVEvHdFrwt8fCT96Uu.7q.CEyi4EcUubM8XUaYCVbJZhUqY49Coxe', 'avatarUploads/img_68640428f290f_头像.png'),
(3, 'abc', 'abc@gmail.com', '123321123112', 'Indonesia', '2025-06-02', '$2y$10$v3HS6QDbPofjUHcTEfcwTeRo9dMkHySZn3YTyx4GFj7IvVo3ij8fq', NULL),
(4, 'abcabc', 'abccabc@gmail.com', '123321123333', 'Indonesia', '2025-06-03', '$2y$10$NBziVuGWwuxBTSXEC2pwLevuvtp/wVdbfjTKsbSWQ7Oi09zoURhgK', NULL),
(5, 'sarah', 'cantik@gmail.com', '0102543219', 'Malaysia', '2005-04-11', '$2y$10$rwkUPieSYTbaikZS/G1PWugnk9b6g8h68Pfahqw/IUlir9QLoiU5C', 'avatarUploads/img_68613f909d0c6_photo1.jpg'),
(6, 'min', 'hanyabergurau@gmail.com', '0162373766', 'Vietnam', '2025-06-04', '$2y$10$4hLiu0QfL9.UcFzKzL187e9X4Fd6lEQ6h2stKnZVW6Tk5gRLyGqqy', 'avatarUploads/img_6861418999bfa_1000247929.jpg'),
(7, 'loopy', 'nrnis@gmail.com', '9392989203', 'Malaysia', '2025-03-05', '$2y$10$VO/VjIuiQPJstAp6IeAaiOlSK88gJF0AVpJMQyq2/AdgHF4n/4rsa', NULL),
(8, 'Fur Fur', 'furfur@gmail.com', '0125687740', 'Taiwan', '2005-09-05', '$2y$10$PPzX9uvA22B6w/axBMn7vuNxyPYH4dO9UEM/F6tDtAUCb0Pr./ehi', NULL),
(9, 'GAO XIAO', 'puiyic888@gmail.com', '0127100322', 'Malaysia', '2005-03-22', '$2y$10$XEQzT3ManTR/LlWfl1aDk.VwNXm1//xl1cco3QEHKgyBiof5YIdaS', 'avatarUploads/img_686152e3d729a_rat.png'),
(10, 'WAWA', 'NOEMAIL@gmail.com', '0154567895', 'Taiwan', '2025-06-25', '$2y$10$zyv2ylX19.2X2Z1WJOpz8eRsOm/wn3ZyE68hBKDeDia6/Usi05PIq', NULL),
(11, 'Orange', 'orange@mail.com', '0129876543', 'Malaysia', '2005-01-01', '$2y$10$rsDUg8XkgHlgj89Fa.o90.De7joPwy9vaK4ljA6XSBnPVLC61a2.2', 'avatarUploads/img_68615cbf2aa0d_orange2.jpg'),
(12, 'MeiMei', 'my@gmail.com', '0183872005', 'Malaysia', '2005-07-18', '$2y$10$pDOj.xAXpo0Sp8ZV5RmGV.NTljcFDb9ibUg7GDpiz/hraHtLK/KAy', NULL),
(14, 'nys', 'kopi@gmail.com', '1234565434', 'Malaysia', '2025-06-05', '$2y$10$HcIoyQqjLFyA4ttUVIZ3ge..GDauflq9JsveQY1ZcA0dFeUO7Hu4K', NULL),
(15, 'Aniel', 'anthanielaniel05@gmail.com', '0198059651', 'Malaysia', '2005-02-27', '$2y$10$BGa0RK82VNvzGGOWfZKAnu8uZ1Gw/MPP48BEsjDfjr1/GAPANewUy', 'avatarUploads/img_6864e0d4eee0d_shabi_cat.png'),
(18, 'wan123', 'wan123@mail.com', '0198756243', 'Thailand', '2005-11-11', '$2y$10$U09kMGf6D2z3WdsyuyEry.Ev.3DWUkKi/MpnYzpNSKwEgRgRA/Ptu', 'avatarUploads/img_68643bbf0ed09_duck.jpg'),
(19, 'aniza', 'aniza.othman@googlemail.com', '0196707499', 'Malaysia', '1969-11-30', '$2y$10$lqPuMQZLRbDVmbz75uxWSegfVtH1pf0T6I1e.KUJV1mg/XQu3Vg5W', NULL);

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
(1, 'Magic'),
(2, 'Harry'),
(3, 'Handsome'),
(4, 'Childhood'),
(5, 'Disney'),
(6, 'Princess'),
(7, 'GlassShoe'),
(8, '123'),
(9, '#whatthehelly'),
(10, 'Coco'),
(11, 'Remember Me'),
(12, 'NiceSong'),
(13, 'Lovely'),
(14, 'Family'),
(15, 'hahaha'),
(16, 'dog'),
(17, 'ANIME'),
(18, 'MANGA'),
(19, 'KAWAI'),
(20, 'NO'),
(21, 'funny'),
(22, 'food'),
(23, 'history'),
(24, 'Torture'),
(25, 'Comic'),
(26, 'Ghost'),
(27, 'Horror'),
(28, '恐怖'),
(29, 'Repunzel'),
(30, 'LongHair'),
(31, 'I See The Light'),
(32, 'Healing Fiction'),
(33, 'Modern Fiction'),
(34, '大女主'),
(35, '男强女强');

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
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 2, 4),
(6, 2, 5),
(7, 2, 6),
(8, 2, 7),
(9, 3, 8),
(10, 4, 9),
(11, 5, 5),
(12, 5, 10),
(13, 5, 11),
(14, 5, 12),
(15, 5, 13),
(16, 5, 14),
(17, 6, 15),
(18, 7, 16),
(19, 8, 17),
(20, 8, 18),
(22, 9, 17),
(21, 9, 19),
(23, 10, 20),
(24, 15, 21),
(29, 16, 23),
(28, 16, 24),
(25, 17, 22),
(26, 18, 23),
(27, 18, 24),
(31, 19, 17),
(30, 19, 18),
(36, 20, 4),
(32, 20, 18),
(33, 20, 25),
(34, 20, 26),
(35, 20, 27),
(37, 21, 28),
(41, 23, 4),
(38, 23, 5),
(39, 23, 6),
(40, 23, 29),
(42, 23, 30),
(43, 23, 31),
(44, 24, 32),
(45, 24, 33),
(46, 26, 34),
(47, 26, 35);

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
  MODIFY `bookBorrowCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `book_record`
--
ALTER TABLE `book_record`
  MODIFY `bookID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `comment_rating`
--
ALTER TABLE `comment_rating`
  MODIFY `commentCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `nested_comment_rating`
--
ALTER TABLE `nested_comment_rating`
  MODIFY `nestedCommentCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `notificationCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `post_report`
--
ALTER TABLE `post_report`
  MODIFY `reportCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `post_review`
--
ALTER TABLE `post_review`
  MODIFY `postCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `reader_user`
--
ALTER TABLE `reader_user`
  MODIFY `readerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `thread`
--
ALTER TABLE `thread`
  MODIFY `threadID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `thread_post`
--
ALTER TABLE `thread_post`
  MODIFY `threadPostCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

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
