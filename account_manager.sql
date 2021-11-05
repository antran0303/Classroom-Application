-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2020 at 03:11 PM
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
-- Database: `account_manager`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `activate` int(11) NOT NULL,
  `activate_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `isGV` bit(1) DEFAULT NULL,
  `isAdmin` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`firstname`, `lastname`, `email`, `password`, `activate`, `activate_token`, `isGV`, `isAdmin`) VALUES
('Tran', 'Van An', 'antoan03031999@gmail.com', '$2y$10$muEqhbLW7xaL5u06Gi6SKOBeS6aP.Zvo4W4Ole3hmkISuoiBzCtw6', 1, '', b'0', NULL),
('An', 'Tran', 'antranttl0303@gmail.com', '$2y$10$xBH8TMgmal1Cfj.1faG//eP3fsC0y0M6Ee9cXhWyyfaloSZZJrT56', 1, '', b'1', b'0'),
('Khanh', 'Duy', 'khanhduynguyen170900@gmail.com', '$2y$10$/ELge07fKRFGwjv9soZ8MedHorHd8LSAi4QKdTuHin.RfdSxTKveW', 1, '', b'1', b'0'),
('Hoc', 'Sinh', 'khanhduynguyen17092000@gmail.com', '$2y$10$WaQnLeo3aZFEZCHCmZZiaeVtsqOP8xmw0xvWmIP6bwNNQcYS547Q.', 1, '', b'0', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `classroom`
--

CREATE TABLE `classroom` (
  `id` int(11) NOT NULL,
  `classname` varchar(50) NOT NULL,
  `room` varchar(10) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `emailteacher` varchar(255) DEFAULT NULL,
  `imageclass` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `classroom`
--

INSERT INTO `classroom` (`id`, `classname`, `room`, `subject`, `emailteacher`, `imageclass`) VALUES
(56, 'HK1_2020_Lập Trình Web Và Ứng Dụng', 'A0609', 'Mai Văn Mạnh - N5T2 - T2C2', 'antranttl0303@gmail.com', 'download1.jpg'),
(57, 'HK1_2020_Lập trình web và ứng dụng', 'E505', 'Đặng Minh Thắng-N5-Thu5-Ca4', 'antranttl0303@gmail.com', 'images6.jpg'),
(58, 'English 3 IELTS (001203) - Group 149 CLC', 'E308', 'shift 3', 'antranttl0303@gmail.com', 'download3.jpg'),
(59, 'HK1_2020_Công nghệ phần mềm', 'C406', 'Trần Thanh Phước', 'antranttl0303@gmail.com', 'download2.jpg'),
(60, 'K1_2020_Phát triển ứng dụng di động ', 'F706', 'Nguyễn Thanh Phước', 'antranttl0303@gmail.com', 'images6.jpg'),
(61, 'HK1_2020_Software Engineering', 'E505', 'Le Ngoc Thach', 'antranttl0303@gmail.com', 'download1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `classwork`
--

CREATE TABLE `classwork` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `classID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `classwork`
--

INSERT INTO `classwork` (`id`, `title`, `content`, `classID`) VALUES
(31, 'Video bài Giảng', 'Lab 7', 56),
(32, 'Hướng dẫn thực Hành', 'Tuần 7', 56);

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `emailuser` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `feedID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `emailuser`, `content`, `feedID`) VALUES
(4, 'khanhduynguyen170900@gmail.com', '???', 7),
(5, 'khanhduynguyen170900@gmail.com', '???', 1),
(116, 'antranttl0303@gmail.com', 'thầy ơi đồ án cuối kì không có viết báo cáo đúng ko thầy?', 83);

-- --------------------------------------------------------

--
-- Table structure for table `feed`
--

CREATE TABLE `feed` (
  `id` int(11) NOT NULL,
  `content` varchar(10000) NOT NULL,
  `classID` int(11) NOT NULL,
  `file` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `feed`
--

INSERT INTO `feed` (`id`, `content`, `classID`, `file`) VALUES
(83, 'Các em nộp bài đồ án cuối kì ở đây. Cơ sở dữ liệu các em export ra thành 1 file .sql bỏ vào thư mục chứa mã nguồn. Sau đó nén thư mục chứa mã nguồn thành 1 file .zip đặt theo mã số sinh viên các thành viên trong nhóm, VD: 5180001_5180002_5180003.zip\r\n\r\nDo có nhiều em xin gia hạn, nên thầy gia hạn deadline đến hết ngày 02/12/2020.', 56, ''),
(84, 'DANH SÁCH CẤM THI.\r\n\r\nCác em kiểm tra tên mình trong danh sách cấm thi. Mọi phản hồi các em liên hệ với thầy qua email (dangminhthang@tdtu.edu.vn) trước ngày 29/11/2020. Mọi lý do như em đau bụng, em bị ngộ độc, xe em bị hư, gia đình có công việc, v.v... đều không được giải quyết. Chỉ giải quyết các trường hợp đặc biệt có kèm minh chứng cụ thể.', 56, ''),
(85, 'Thầy đã mở form đăng kí nhóm làm đồ án cuối kì và danh sách bài tiểu luận. Các em điền thông tin nhóm của mình, mỗi nhóm từ 2-4 sinh viên, và chọn đề tài tiểu luận cho nhóm.\r\nĐồ án cuối kì: chiếm 50% tổng điểm môn học.\r\nBài tiểu luận: điểm quá trình 2, chiếm 20% tổng điểm môn học.\r\n\r\nHạn chót đăng kí: 26/9/2020\r\nHạn chót nộp bài: 30/11/2020\r\nTuần chấm bài: 30/11/2020 - 05/12/2020\r\n\r\nMọi thắc mắc liên quan đến đồ án cuối kì, các em trao đổi với giáo viên lý thuyết. Mọi thắc mắc liên quan đến bài tiểu luận, các em trao đổi với giáo viên thực hành.', 57, ''),
(86, 'Nội dung thi giữa kì:\r\n1. Tạo bảng (table) trong HTML và những thuộc tính liên quan đến bảng (colspan, rowspan, border, v.v...). Tạo form và các thành phần trong form (input, radio, checkbox, button, select, textarea, v.v..).\r\n2. Các thuộc tính CSS liên quan đến color, text-decoration, text-align, hover, padding, margin, list-style-type, display (block, inline, inline-block), float.\r\n3. Xử lý các sự kiện trong Javascript (onclick, onsubmit), ẩn/hiện các thành phần HTML bằng Javascript, thay đổi nội dung một thành phần HTML bằng Javascript, xác thực form hợp lệ bằng Javascript.\r\n\r\nĐề thi chỉ có HTML, CSS và Javascript. Không có Bootstrap, không có jQuery. Sinh viên được phép mang tài liệu giấy vào phòng thi.\r\n\r\nĐọc kĩ đề, một số câu hỏi sẽ được cung cấp trước các file HTML, sinh viên làm việc trên các file HTML đó.', 57, ''),
(87, 'Thầy đã mở form đăng kí nhóm làm đồ án cuối kì và danh sách bài tiểu luận. Các em điền thông tin nhóm của mình, mỗi nhóm từ 2-4 sinh viên, và chọn đề tài tiểu luận cho nhóm.\r\nĐồ án cuối kì: chiếm 50% tổng điểm môn học.\r\nBài tiểu luận: điểm quá trình 2, chiếm 20% tổng điểm môn học.\r\n\r\nHạn chót đăng kí: 26/9/2020\r\nHạn chót nộp bài: 30/11/2020\r\nTuần chấm bài: 30/11/2020 - 05/12/2020\r\n\r\nMọi thắc mắc liên quan đến đồ án cuối kì, các em trao đổi với giáo viên lý thuyết. Mọi thắc mắc liên quan đến bài tiểu luận, các em trao đổi với giáo viên thực hành.', 57, ''),
(88, 'Chào mọi người... hiện nhóm mình có 3 thành viên là mình, Tài và Hữu Khang. Mình còn thiếu 1 bạn vào làm chung.. bạn nào chưa có nhóm có thể cmt vào bên dưới để vào nhóm làm chung với tụi mình. Thank you\r\n', 58, 'download5.jpg'),
(89, 'Để chia cột trong bootstrap, tạo một div có class=\"row\", sau đó trong div này tạo các div có class=\"col-?\", trong đó ? nhận các giá trị từ 1->12. Ví dụ:\r\n                <div class=\"container\">\r\n			<div class=\"row\">\r\n				<div class=\"col-3\">\r\n				</div>\r\n				<div class=\"col-9\">\r\n				</div>\r\n			</div>\r\n		</div>', 56, 'exercise1.html'),
(95, 'THÔNG BÁO: Theo qui định của nhà trường, từ tuần sau lớp chúng ta học tập trung tại trường tại phòng học theo thời khóa biểu của trường.', 56, 'Lab03-Guide.pdf'),
(96, 'THÔNG BÁO: Theo qui định của nhà trường, từ tuần sau lớp chúng ta học tập trung tại trường tại phòng học theo thời khóa biểu của trường.', 61, 'Lab03-Guide.pdf'),
(97, 'Link học trực tuyến cho ngày 20/8/2020 là như sau:', 61, 'Lab03-Guide.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `reset_token`
--

CREATE TABLE `reset_token` (
  `email` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `expire_on` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `reset_token`
--

INSERT INTO `reset_token` (`email`, `token`, `expire_on`) VALUES
('antoan03031999@gmail.com', 'df081d1b1c1debe3546dccbd594b1f29', 1604578513),
('khanhduynguyen170900@gmail.com', '0da92ae765ada391e104b01167c516b1', 1604819777),
('mvmanh@gmail.com', '', 0),
('mvmanh@it.tdt.edu.vn', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `studentofclass`
--

CREATE TABLE `studentofclass` (
  `id` int(11) NOT NULL,
  `studentemail` varchar(255) NOT NULL,
  `classID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `studentofclass`
--

INSERT INTO `studentofclass` (`id`, `studentemail`, `classID`) VALUES
(2, 'antoan03031999@gmail.com', 51),
(6, 'antoan03031999@gmail.com', 56),
(7, 'khanhduynguyen17092000@gmail.com', 56),
(8, 'antoan03031999@gmail.com', 57),
(9, 'khanhduynguyen17092000@gmail.com', 57),
(10, 'antoan03031999@gmail.com', 61);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `classroom`
--
ALTER TABLE `classroom`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classwork`
--
ALTER TABLE `classwork`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feed`
--
ALTER TABLE `feed`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reset_token`
--
ALTER TABLE `reset_token`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `studentofclass`
--
ALTER TABLE `studentofclass`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `classroom`
--
ALTER TABLE `classroom`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `classwork`
--
ALTER TABLE `classwork`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT for table `feed`
--
ALTER TABLE `feed`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `studentofclass`
--
ALTER TABLE `studentofclass`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
