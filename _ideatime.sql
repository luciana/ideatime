-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 30, 2012 at 11:45 PM
-- Server version: 5.5.9
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `_ideatime`
--

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` VALUES(1, 'The Founders Club');
INSERT INTO `groups` VALUES(2, 'test group 2');

-- --------------------------------------------------------

--
-- Table structure for table `ideas`
--

CREATE TABLE `ideas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `good` int(2) DEFAULT '0',
  `bad` int(2) NOT NULL DEFAULT '0',
  `author` varchar(80) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=152 ;

--
-- Dumping data for table `ideas`
--

INSERT INTO `ideas` VALUES(15, 'Marriage Insurance', 6, 0, 'skoscho');
INSERT INTO `ideas` VALUES(2, 'Keep My Change', 1, 0, 'luciana123_2002');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `oauth_provider` varchar(10) DEFAULT NULL,
  `oauth_uid` text,
  `oauth_token` text,
  `oauth_secret` text,
  `username` text,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` VALUES(7, 'twitter', '39792346', '39792346-w053ALPlJ3vddwja2mYCNWR58UjcLK6GLeJn3eOlg', 'pi9AVldkXsTznTfptlGMRAFrCuSLXhRL2hyZfpNtOV4', 'luciana123_2002', 1);
INSERT INTO `users` VALUES(8, 'twitter', '320236200', '320236200-efD0A9naQ4vj3pGIrPRda0UOht2ed0RLpH87waAC', 'gSRRtMulGDH9iGxaZX8eHFwjmCjZHEpeQnDYFaQKc', 'MyDomainList', 1);
INSERT INTO `users` VALUES(9, 'twitter', '17811921', '17811921-ndK3DgbEnYWUy6YJpqEKMCmwbpJesAqtQ4UPvigOA', 'mRomOynPucERxTBGexfXdXv3WtGXgzEhDsVTeJ4', 'DailyPush', 1);
INSERT INTO `users` VALUES(10, 'twitter', '5940422', '5940422-OtnUSDTrEUSSzRemAhfnDXUy9MipOklHT3ACl89ihI', 'MSfF5iT3WCDdmuSvCNpuLdAMitrWWRQ2hV6Uun4', 'clevelandrachel', 1);
INSERT INTO `users` VALUES(11, 'twitter', '613758825', '613758825-RtjUgoeOguzuVMowl99I9idfF1eukmphO0qb389A', '7Ztv9bQXnqbddgPu8if0yrWOgvigeu3LTBretE', 'JeneticCode', 1);
INSERT INTO `users` VALUES(12, 'twitter', '434626592', '434626592-R4bRlzXUN4gcr03yb3fD2w4PeKmuwOg6AfrvNit5', 'L4j9GWakPnUIdGT8q0maSaw62LEiVqFrPpQXOqmL0g', 'getSabotaged', 1);
INSERT INTO `users` VALUES(13, 'twitter', '109142418', '109142418-oveyBGxtiiWkWAabLNT48EMA1tUSQ41uC5gevkM', 'huvlfbaIP85AlRhHCCnHOlqhb8XXBJTWl6WYaqI9M', 'skoscho', 1);
INSERT INTO `users` VALUES(14, 'twitter', '54058772', '54058772-VecXAJorUyaaAH4yjz5CMiazEgxfVDPq0rUY6C6TE', 'PD2SiYAPCFRJ83WdThZt6qvYa18vacStCL5up2U90', 'MightyAnger', 1);
INSERT INTO `users` VALUES(15, 'twitter', '51091005', '51091005-QSR1TKHCnH1coR4OrHdrtlujXKw4ydmnM7PzEfYZ5', 'ygNUMiQJ0aDs701VJo2luuPZ7Q6M9yYp7OUjr0JY', 'tjhadley15', 1);
INSERT INTO `users` VALUES(16, 'twitter', '18357809', '18357809-uD0YAJadH1DJ4188a5oX6yhzLGxLhsqdc44wOfBqi', 'prVIcktbhDs95tiOMmyylXE2wATMXiAx14cKCZkqY', 'bsurtz', 1);
INSERT INTO `users` VALUES(17, 'twitter', '17476319', '17476319-h8VUjxoF5v2kQhRJbM8S13sEh1LXf8goepTpBLHps', 'Re3YUfOKyichaFFBmRUhKIXlXaPHoiw4qU8HrPP8', 'jessicaenglund', 1);
INSERT INTO `users` VALUES(18, 'twitter', '755117858', '755117858-mxiV2wgwFstEK0yAiI9a2mjuQabh7mowCOrzPToG', 'dh42G2hlM3ZTYWjO1MU3Bg3bgWLH552skqbMvA2w', 'JPierceCU', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users_whitelist`
--

CREATE TABLE `users_whitelist` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `users_whitelist`
--

INSERT INTO `users_whitelist` VALUES(1, 'luciana123_2002');
INSERT INTO `users_whitelist` VALUES(2, 'MightyAnger');
INSERT INTO `users_whitelist` VALUES(3, 'pawanpoudel');
INSERT INTO `users_whitelist` VALUES(4, 'TheeRealDG');
INSERT INTO `users_whitelist` VALUES(5, 'vladtoader');
INSERT INTO `users_whitelist` VALUES(6, 'bradphilips');
INSERT INTO `users_whitelist` VALUES(7, 'JeneticCode');
INSERT INTO `users_whitelist` VALUES(8, 'clevelandrachel');
INSERT INTO `users_whitelist` VALUES(9, 'dailypush');
INSERT INTO `users_whitelist` VALUES(10, 'obas614');
INSERT INTO `users_whitelist` VALUES(11, 'skoscho');
INSERT INTO `users_whitelist` VALUES(12, 'tjhadley15');
INSERT INTO `users_whitelist` VALUES(13, 'astroteg');
INSERT INTO `users_whitelist` VALUES(14, 'bsurtz');