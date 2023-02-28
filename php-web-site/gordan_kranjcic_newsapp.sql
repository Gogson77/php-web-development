-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 07, 2022 at 03:08 PM
-- Server version: 5.7.29-log
-- PHP Version: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gordan_kranjcic_newsapp`
--
CREATE DATABASE IF NOT EXISTS `gordan_kranjcic_newsapp` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `gordan_kranjcic_newsapp`;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `categories_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `categories_name` varchar(15) NOT NULL,
  PRIMARY KEY (`categories_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`categories_id`, `categories_name`) VALUES
(1, 'Zabava'),
(2, 'Sport'),
(3, 'Svet'),
(4, 'Kultura'),
(5, 'Hronika');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `comments_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `comments_body` text NOT NULL,
  `comments_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `users_id` int(11) NOT NULL,
  `news_id` int(11) NOT NULL,
  `aproved` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`comments_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Stand-in structure for view `comments_view`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `comments_view`;
CREATE TABLE IF NOT EXISTS `comments_view` (
`users_id` int(10) unsigned
,`comments_id` int(10) unsigned
,`news_id` int(10) unsigned
,`users_name` varchar(20)
,`users_lastname` varchar(30)
,`users_email` varchar(50)
,`comments_body` text
,`comments_created` timestamp
,`aproved` tinyint(1)
);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
CREATE TABLE IF NOT EXISTS `news` (
  `news_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `news_title` varchar(300) NOT NULL,
  `news_body` text NOT NULL,
  `news_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `users_id` int(11) NOT NULL,
  `categories_id` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`news_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`news_id`, `news_title`, `news_body`, `news_created`, `users_id`, `categories_id`, `active`) VALUES
(8, 'EVO ŠTA JE ISTINA: Italijani pišu o revolucionarnoj promeni pravila na Mundijalu, FIFA odmah odgovorila \"na glasine\"', 'Ugledni italijanski list “Korijere delo Sport” objavio je kako će predstojeće Svetsko prvenstvo u Kataru biti specifično po novom pravilu.\r\nIstraživanja, naime, pokazuju kako je od 90 minuta utakmice zapravo tek pedesetak minuta aktivno, pa se, navodno, traži novo rešenje, a deo problema je i povećanje broja izmena sa tri na pet, što će takođe uticati na “krađu” vremena.\r\n\r\nMeđutim, FIFA je objavom na službenom Tviter profilu tu informaciju demantovala, prenosi Index.hr.\r\n\r\n- Nakon glasina koje kruže FIFA želi da potvrdi da neće biti promena u pravilima trajanja fudbalskih utakmica na Svetskom prvenstvu u Kataru ili u bilo kom drugom takmičenju”.\r\n\r\nPodsetimo, na Mundijalu u Kataru biće uvedena nova tehnologija pomoću koje bi se ofsajd “detektovao” mnogo brže nego što je to slučaj sada sa VAR-om.', '2022-04-07 14:43:26', 1, 2, 1);

-- --------------------------------------------------------

--
-- Stand-in structure for view `news_view`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `news_view`;
CREATE TABLE IF NOT EXISTS `news_view` (
`users_id` int(10) unsigned
,`users_name` varchar(20)
,`users_lastname` varchar(30)
,`categories_id` int(10) unsigned
,`categories_name` varchar(15)
,`news_id` int(10) unsigned
,`news_title` varchar(300)
,`news_body` text
,`news_created` timestamp
,`active` tinyint(1)
);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `users_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `users_name` varchar(20) NOT NULL,
  `users_lastname` varchar(30) NOT NULL,
  `users_email` varchar(50) NOT NULL,
  `users_password` varchar(30) NOT NULL,
  `users_repassword` varchar(30) NOT NULL,
  `users_status` varchar(20) NOT NULL,
  `users_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`users_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`users_id`, `users_name`, `users_lastname`, `users_email`, `users_password`, `users_repassword`, `users_status`, `users_created`) VALUES
(1, 'Gordan', 'Kranjcic', 'gordan@gmail.com', 'gordan', 'gordan', 'Administrator', '2022-04-07 14:17:35');

-- --------------------------------------------------------

--
-- Structure for view `comments_view`
--
DROP TABLE IF EXISTS `comments_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `comments_view`  AS  select `users`.`users_id` AS `users_id`,`comments`.`comments_id` AS `comments_id`,`news`.`news_id` AS `news_id`,`users`.`users_name` AS `users_name`,`users`.`users_lastname` AS `users_lastname`,`users`.`users_email` AS `users_email`,`comments`.`comments_body` AS `comments_body`,`comments`.`comments_created` AS `comments_created`,`comments`.`aproved` AS `aproved` from ((`comments` join `users` on((`comments`.`users_id` = `users`.`users_id`))) join `news` on((`comments`.`news_id` = `news`.`news_id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `news_view`
--
DROP TABLE IF EXISTS `news_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `news_view`  AS  select `users`.`users_id` AS `users_id`,`users`.`users_name` AS `users_name`,`users`.`users_lastname` AS `users_lastname`,`categories`.`categories_id` AS `categories_id`,`categories`.`categories_name` AS `categories_name`,`news`.`news_id` AS `news_id`,`news`.`news_title` AS `news_title`,`news`.`news_body` AS `news_body`,`news`.`news_created` AS `news_created`,`news`.`active` AS `active` from ((`news` join `users` on((`news`.`users_id` = `users`.`users_id`))) join `categories` on((`news`.`categories_id` = `categories`.`categories_id`))) ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
