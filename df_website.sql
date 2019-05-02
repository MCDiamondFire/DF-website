-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 02, 2019 at 01:50 PM
-- Server version: 5.5.56-MariaDB
-- PHP Version: 5.6.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `df_website`
--
CREATE DATABASE IF NOT EXISTS `df_website` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `df_website`;

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `username` varchar(16) NOT NULL,
  `rank` enum('WebDev','Owner','Admin','Mod','JrMod','Expert','Helper','JrHelper','Overlord','Mythic','Emperor','Noble','') NOT NULL,
  `uuid` varchar(64) NOT NULL,
  `password` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `code` varchar(8) NOT NULL,
  `stayLoggedInCode` varchar(32) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `authKey` varchar(64) DEFAULT NULL,
  `authKeyExpires` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Used to store the created accounts for the Website.';

-- --------------------------------------------------------

--
-- Table structure for table `api_keys`
--

CREATE TABLE IF NOT EXISTS `api_keys` (
  `api_key` varchar(32) NOT NULL,
  `owner` varchar(32) DEFAULT '',
  `access_level` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE IF NOT EXISTS `devices` (
  `device_unique` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `stayLoggedIn` int(11) NOT NULL DEFAULT '0',
  `loginTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `device` text NOT NULL,
  `browser` text NOT NULL,
  `version` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dfuAnalytics`
--

CREATE TABLE IF NOT EXISTS `dfuAnalytics` (
  `id` int(11) NOT NULL,
  `type` varchar(64) NOT NULL,
  `data` text,
  `uuid` varchar(64) NOT NULL,
  `version` varchar(16) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `forums`
--

CREATE TABLE IF NOT EXISTS `forums` (
  `forum_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `creator` int(11) DEFAULT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `threads` int(11) DEFAULT '0',
  `posts` int(11) DEFAULT '0',
  `latest` int(11) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pinned` int(11) NOT NULL DEFAULT '0',
  `locked` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Forums that sit in forum categories';

-- --------------------------------------------------------

--
-- Table structure for table `forum_categories`
--

CREATE TABLE IF NOT EXISTS `forum_categories` (
  `category_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `creator` int(11) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Organized forum categories for forums';

-- --------------------------------------------------------

--
-- Table structure for table `offenses`
--

CREATE TABLE IF NOT EXISTS `offenses` (
  `case_id` int(11) NOT NULL,
  `user_id` varchar(32) DEFAULT NULL,
  `action` varchar(16) DEFAULT NULL,
  `reason` varchar(128) DEFAULT NULL,
  `expires` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `replies`
--

CREATE TABLE IF NOT EXISTS `replies` (
  `reply_id` int(11) NOT NULL,
  `thread_id` int(11) NOT NULL,
  `content` longtext NOT NULL,
  `likes` int(11) NOT NULL DEFAULT '0',
  `creator` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Used to store the created replies for the Website.';

-- --------------------------------------------------------

--
-- Table structure for table `replyLikes`
--

CREATE TABLE IF NOT EXISTS `replyLikes` (
  `reply_id` int(11) NOT NULL,
  `user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `threadLikes`
--

CREATE TABLE IF NOT EXISTS `threadLikes` (
  `thread_id` int(11) NOT NULL,
  `user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `threads`
--

CREATE TABLE IF NOT EXISTS `threads` (
  `thread_id` int(11) NOT NULL,
  `forum_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `content` longtext NOT NULL,
  `replies` int(11) NOT NULL DEFAULT '0',
  `views` int(11) NOT NULL DEFAULT '0',
  `latest` int(11) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pinned` int(11) NOT NULL DEFAULT '0',
  `locked` int(11) NOT NULL DEFAULT '0',
  `creator` int(11) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Used to store the created forums for the Website.';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `UUID` (`uuid`);

--
-- Indexes for table `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`device_unique`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `dfuAnalytics`
--
ALTER TABLE `dfuAnalytics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forums`
--
ALTER TABLE `forums`
  ADD PRIMARY KEY (`forum_id`),
  ADD KEY `forum_category` (`category_id`) USING BTREE,
  ADD KEY `creator` (`creator`) USING BTREE;

--
-- Indexes for table `forum_categories`
--
ALTER TABLE `forum_categories`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `UserID` (`creator`);

--
-- Indexes for table `offenses`
--
ALTER TABLE `offenses`
  ADD PRIMARY KEY (`case_id`);

--
-- Indexes for table `replies`
--
ALTER TABLE `replies`
  ADD PRIMARY KEY (`reply_id`),
  ADD KEY `UserID` (`creator`),
  ADD KEY `thread_id` (`thread_id`);

--
-- Indexes for table `replyLikes`
--
ALTER TABLE `replyLikes`
  ADD KEY `userConnector` (`user`) USING BTREE,
  ADD KEY `replyConnector` (`reply_id`) USING BTREE;

--
-- Indexes for table `threadLikes`
--
ALTER TABLE `threadLikes`
  ADD KEY `userConnector` (`user`) USING BTREE,
  ADD KEY `thread_id` (`thread_id`);

--
-- Indexes for table `threads`
--
ALTER TABLE `threads`
  ADD PRIMARY KEY (`thread_id`),
  ADD KEY `UserID` (`creator`),
  ADD KEY `ForumID` (`forum_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `devices`
--
ALTER TABLE `devices`
  MODIFY `device_unique` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `dfuAnalytics`
--
ALTER TABLE `dfuAnalytics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `forums`
--
ALTER TABLE `forums`
  MODIFY `forum_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `forum_categories`
--
ALTER TABLE `forum_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `offenses`
--
ALTER TABLE `offenses`
  MODIFY `case_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `replies`
--
ALTER TABLE `replies`
  MODIFY `reply_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `threads`
--
ALTER TABLE `threads`
  MODIFY `thread_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `devices`
--
ALTER TABLE `devices`
  ADD CONSTRAINT `UC` FOREIGN KEY (`user_id`) REFERENCES `accounts` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `forums`
--
ALTER TABLE `forums`
  ADD CONSTRAINT `FCC1` FOREIGN KEY (`category_id`) REFERENCES `forum_categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `UC2` FOREIGN KEY (`creator`) REFERENCES `accounts` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `forum_categories`
--
ALTER TABLE `forum_categories`
  ADD CONSTRAINT `UC3` FOREIGN KEY (`creator`) REFERENCES `accounts` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `replies`
--
ALTER TABLE `replies`
  ADD CONSTRAINT `TC1` FOREIGN KEY (`thread_id`) REFERENCES `threads` (`thread_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `UC6` FOREIGN KEY (`creator`) REFERENCES `accounts` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `replyLikes`
--
ALTER TABLE `replyLikes`
  ADD CONSTRAINT `RC` FOREIGN KEY (`reply_id`) REFERENCES `replies` (`reply_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `UC7` FOREIGN KEY (`user`) REFERENCES `accounts` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `threadLikes`
--
ALTER TABLE `threadLikes`
  ADD CONSTRAINT `TC` FOREIGN KEY (`thread_id`) REFERENCES `threads` (`thread_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `UC5` FOREIGN KEY (`user`) REFERENCES `accounts` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `threads`
--
ALTER TABLE `threads`
  ADD CONSTRAINT `FC` FOREIGN KEY (`forum_id`) REFERENCES `forums` (`forum_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `UC4` FOREIGN KEY (`creator`) REFERENCES `accounts` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
