-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 07, 2022 at 10:39 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `testing`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_follow`
--

CREATE TABLE `tbl_follow` (
  `follow_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_follow`
--

INSERT INTO `tbl_follow` (`follow_id`, `sender_id`, `receiver_id`) VALUES
(33, 1, 2),
(39, 2, 1),
(43, 1, 3),
(44, 2, 3),
(50, 5, 6);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_samples_post`
--

CREATE TABLE `tbl_samples_post` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_content` text NOT NULL,
  `post_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_samples_post`
--

INSERT INTO `tbl_samples_post` (`post_id`, `user_id`, `post_content`, `post_datetime`) VALUES
(1, 1, 'hello this is test ', '2022-10-07 07:20:44'),
(2, 2, 'hello this test 2', '2022-10-07 07:21:02'),
(11, 5, 'hello test', '2022-10-07 10:33:18'),
(12, 6, 'hello test2', '2022-10-07 10:33:32');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_twitter_user`
--

CREATE TABLE `tbl_twitter_user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL,
  `name` varchar(150) NOT NULL,
  `profile_image` varchar(150) NOT NULL,
  `bio` text NOT NULL,
  `follower_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_twitter_user`
--

INSERT INTO `tbl_twitter_user` (`user_id`, `username`, `password`, `name`, `profile_image`, `bio`, `follower_number`) VALUES
(5, 'test01', '$2y$10$jlY4UsBMDlsIYy3SEpv0FOM114pFgAK3sXYLRoYGR2wODfDJ/MXTS', '', '', '', 1),
(6, 'test02', '$2y$10$OKLlX.KGkpfnAqA4rAEnAuSKAtwXI4AjKrXcUKiyyYtNXOT7ZbwBa', '', '', '', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_follow`
--
ALTER TABLE `tbl_follow`
  ADD PRIMARY KEY (`follow_id`);

--
-- Indexes for table `tbl_samples_post`
--
ALTER TABLE `tbl_samples_post`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `tbl_twitter_user`
--
ALTER TABLE `tbl_twitter_user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_follow`
--
ALTER TABLE `tbl_follow`
  MODIFY `follow_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `tbl_samples_post`
--
ALTER TABLE `tbl_samples_post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_twitter_user`
--
ALTER TABLE `tbl_twitter_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
