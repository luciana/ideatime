-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 08, 2012 at 05:39 PM
-- Server version: 5.5.9
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `_ideatime`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `body` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ideas_id` int(10) unsigned NOT NULL,
  `users_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_comments_ideas1` (`ideas_id`),
  KEY `fk_comments_users1` (`users_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `comments`
--


-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` VALUES(1, 'Founders Club', '2012-09-05 20:49:31');

-- --------------------------------------------------------

--
-- Table structure for table `group_access`
--

CREATE TABLE `group_access` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `groups_id` int(10) unsigned NOT NULL,
  `users_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`,`groups_id`),
  KEY `fk_group_access_groups1` (`groups_id`),
  KEY `fk_group_access_users1` (`users_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `group_access`
--


-- --------------------------------------------------------

--
-- Table structure for table `ideas`
--

CREATE TABLE `ideas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `good` int(2) NOT NULL DEFAULT '0',
  `bad` int(2) NOT NULL DEFAULT '0',
  `author` varchar(80) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `groups_id` int(10) unsigned NOT NULL,
  `status_id` int(11) NOT NULL DEFAULT '1',
  `users_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_ideas_groups1` (`groups_id`),
  KEY `fk_ideas_status1` (`status_id`),
  KEY `fk_ideas_users1` (`users_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `ideas`
--

INSERT INTO `ideas` VALUES(12, 'new idea', 0, 0, 'getSabotaged', '2012-09-08 17:00:12', 1, 1, 1);
INSERT INTO `ideas` VALUES(11, 'trying again', 0, 0, 'getSabotaged', '2012-09-08 13:27:51', 1, 1, 1);
INSERT INTO `ideas` VALUES(17, 'numba 6', 0, 0, 'getSabotaged', '2012-09-08 17:14:05', 1, 1, 1);
INSERT INTO `ideas` VALUES(16, 'numba 5', 0, 0, 'getSabotaged', '2012-09-08 17:13:44', 1, 1, 1);
INSERT INTO `ideas` VALUES(15, '4th diea', 0, 0, 'getSabotaged', '2012-09-08 17:06:24', 1, 1, 1);
INSERT INTO `ideas` VALUES(14, 'this is the 3rd idea', 0, 0, 'getSabotaged', '2012-09-08 17:04:49', 1, 1, 1);
INSERT INTO `ideas` VALUES(18, 'try this', 0, 0, 'getSabotaged', '2012-09-08 17:36:28', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_users`
--

CREATE TABLE `oauth_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `oauth_provider` varchar(10) DEFAULT NULL,
  `oauth_uid` text,
  `oauth_token` text,
  `oauth_secret` text,
  `username` text,
  `users_id` int(10) unsigned NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_oauth_users_users1` (`users_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `oauth_users`
--

INSERT INTO `oauth_users` VALUES(1, 'twitter', '434626592', '434626592-R4bRlzXUN4gcr03yb3fD2w4PeKmuwOg6AfrvNit5', 'L4j9GWakPnUIdGT8q0maSaw62LEiVqFrPpQXOqmL0g', 'getSabotaged', 1, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(30) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `status`
--

INSERT INTO `status` VALUES(1, 'New', '2012-09-05 20:48:56');
INSERT INTO `status` VALUES(2, 'Old', '2012-09-05 20:48:56');
INSERT INTO `status` VALUES(3, 'Follow Up', '2012-09-05 20:49:12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` text,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `admin` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` VALUES(1, 'getSabotaged', '2012-09-05 20:48:30', 1);

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `good` int(10) unsigned NOT NULL DEFAULT '0',
  `bad` int(10) unsigned NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ideas_id` int(10) unsigned NOT NULL,
  `users_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_votes_ideas1` (`ideas_id`),
  KEY `fk_votes_users1` (`users_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=117 ;

--
-- Dumping data for table `votes`
--

INSERT INTO `votes` VALUES(48, 1, 0, '2012-09-08 13:45:53', 11, 1);
INSERT INTO `votes` VALUES(96, 1, 0, '2012-09-08 14:32:34', 10, 1);
INSERT INTO `votes` VALUES(97, 1, 0, '2012-09-08 14:47:11', 7, 1);
INSERT INTO `votes` VALUES(98, 0, 1, '2012-09-08 14:47:13', 7, 1);
INSERT INTO `votes` VALUES(99, 0, 1, '2012-09-08 14:47:14', 7, 1);
INSERT INTO `votes` VALUES(100, 1, 0, '2012-09-08 14:47:16', 7, 1);
INSERT INTO `votes` VALUES(101, 1, 0, '2012-09-08 14:47:17', 7, 1);
INSERT INTO `votes` VALUES(102, 1, 0, '2012-09-08 14:47:20', 8, 1);
INSERT INTO `votes` VALUES(103, 0, 1, '2012-09-08 14:47:22', 8, 1);
INSERT INTO `votes` VALUES(104, 1, 0, '2012-09-08 14:47:23', 9, 1);
INSERT INTO `votes` VALUES(105, 1, 0, '2012-09-08 17:14:08', 16, 1);
INSERT INTO `votes` VALUES(106, 0, 1, '2012-09-08 17:14:09', 16, 1);
INSERT INTO `votes` VALUES(107, 1, 0, '2012-09-08 17:14:10', 17, 1);
INSERT INTO `votes` VALUES(108, 0, 1, '2012-09-08 17:14:11', 17, 1);
INSERT INTO `votes` VALUES(109, 1, 0, '2012-09-08 17:14:12', 15, 1);
INSERT INTO `votes` VALUES(110, 1, 0, '2012-09-08 17:14:12', 15, 1);
INSERT INTO `votes` VALUES(111, 1, 0, '2012-09-08 17:14:13', 15, 1);
INSERT INTO `votes` VALUES(112, 1, 0, '2012-09-08 17:14:13', 15, 1);
INSERT INTO `votes` VALUES(113, 1, 0, '2012-09-08 17:29:14', 14, 1);
INSERT INTO `votes` VALUES(114, 1, 0, '2012-09-08 17:29:15', 14, 1);
INSERT INTO `votes` VALUES(115, 1, 0, '2012-09-08 17:30:29', 12, 1);
INSERT INTO `votes` VALUES(116, 0, 1, '2012-09-08 17:36:30', 18, 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_comments_ideas1` FOREIGN KEY (`ideas_id`) REFERENCES `ideas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_comments_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `group_access`
--
ALTER TABLE `group_access`
  ADD CONSTRAINT `fk_group_access_groups1` FOREIGN KEY (`groups_id`) REFERENCES `groups` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_group_access_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
