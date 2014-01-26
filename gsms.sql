-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2012 at 12:38 PM
-- Server version: 5.5.25a-log
-- PHP Version: 5.3.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `gsms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `admin_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8_persian_ci NOT NULL,
  `family` varchar(20) COLLATE utf8_persian_ci NOT NULL,
  `mail` varchar(20) COLLATE utf8_persian_ci NOT NULL,
  `username` varchar(20) COLLATE utf8_persian_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `describe` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'توضیحات',
  `parent_id` int(10) unsigned DEFAULT '0' COMMENT 'آی دی والد . کسی که او را ایجاد کرده و توان تغییر او را دارد',
  `mobile` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL,
  `date` datetime DEFAULT NULL COMMENT 'تاریخ ایجاد پروفایل',
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci COMMENT='جدول ثبت مدیران سیستم و اپراتور ها' AUTO_INCREMENT=4 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `name`, `family`, `mail`, `username`, `password`, `describe`, `parent_id`, `mobile`, `date`) VALUES
(1, 'ناصر', 'نیازی مبصر', 'nasser@niazy.ir', 'nasservb', 'nahoGYl7yWWyE', 'مدیر برنامه نویسی سیستم', 0, '', '1391-02-12 16:44:41'),
(3, 'omin', 'agha', 'omid@gmail.com', 'omid', 'na6hP213Vhq5Q', 'omid agha', 1, '0000', '1391-09-16 12:17:12');

-- --------------------------------------------------------

--
-- Table structure for table `sqlbug`
--

CREATE TABLE IF NOT EXISTS `sqlbug` (
  `sqlbug_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `error_code` varchar(1024) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'کد خطا',
  `describe` varchar(1024) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'توضیحات',
  `time` datetime NOT NULL,
  `file` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'داخل کدام فایل خطا رخ داده است',
  `sql` text COLLATE utf8_persian_ci COMMENT 'کد اس کیو ال که خطا داده است',
  `user_id` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL,
  `message` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'توضیحی در مورد عملیاتی که باعث خطا شده',
  `read` enum('yes','no') COLLATE utf8_persian_ci DEFAULT NULL,
  `username` varchar(64) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'چون ممکن است هنگام ورود بوزر آی دی در دسارس نباشد امکان ذخیره ی یوزر آی دی نیز باید در این جدول یاشد',
  `userip` varchar(64) COLLATE utf8_persian_ci DEFAULT NULL,
  PRIMARY KEY (`sqlbug_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci COMMENT='خطاهای اس کیو ال در این جدول ثیت می شوند' AUTO_INCREMENT=31 ;

--
-- Dumping data for table `sqlbug`
--

INSERT INTO `sqlbug` (`sqlbug_id`, `error_code`, `describe`, `time`, `file`, `sql`, `user_id`, `message`, `read`, `username`, `userip`) VALUES
(30, '1110', 'Column /describe/ specified twice', '1391-02-19 10:41:09', 'admin.php', 'INSERT INTO `admin` \n							(\n								`admin_id` ,\n								`name` ,\n								`describe` ,\n								`family`,\n								`mail`,\n								`username`,\n								`password`,\n								`describe`,\n								`parent_id`,\n								`mobile`,\n								`date`\n							)\n							VALUES \n							(\n								NULL ,  \n								/علیرضا/, \n								/مدیر  سیستم/,  \n								/جوانبختی/,\n								/gooyaweb@gmail.com/,\n								/alireza/,\n								/23502350/,\n								/مدیر  سیستم/,\n								/1/,\n								/09181117211/,\n								/1391-02-19 10:41:09/\n								)', '1', 'insert admin', '', 'nasservb', '127.0.0.1'),
(29, '1110', 'Column /describe/ specified twice', '1391-02-19 10:40:10', 'admin.php', 'INSERT INTO `admin` \r\n							(\r\n								`admin_id` ,\r\n								`name` ,\r\n								`describe` ,\r\n								`family`,\r\n								`mail`,\r\n								`username`,\r\n								`password`,\r\n								`describe`,\r\n								`parent_id`,\r\n								`mobile`,\r\n								`date`\r\n							)\r\n							VALUES \r\n							(\r\n								NULL ,  \r\n								/علیرضا/, \r\n								/مدیر  سیستم/,  \r\n								/جوانبختی/,\r\n								/gooyaweb@gmail.com/,\r\n								/alireza/,\r\n								//,\r\n								/مدیر  سیستم/,\r\n								/1/,\r\n								/09181117211/,\r\n								/1391-02-19 10:40:10/\r\n								)', '1', 'insert admin', '', 'nasservb', '127.0.0.1'),
(28, '1110', 'Column /describe/ specified twice', '1391-02-19 10:38:03', 'admin.php', 'INSERT INTO `admin` \r\n							(\r\n								`admin_id` ,\r\n								`name` ,\r\n								`describe` ,\r\n								`family`,\r\n								`mail`,\r\n								`username`,\r\n								`password`,\r\n								`describe`,\r\n								`parent_id`,\r\n								`mobile`,\r\n								`date`\r\n							)\r\n							VALUES \r\n							(\r\n								NULL ,  \r\n								/علیرضا/, \r\n								/مدیر  سیستم/,  \r\n								/جوانبختی/,\r\n								/gooyaweb@gmail.com/,\r\n								//,\r\n								//,\r\n								/مدیر  سیستم/,\r\n								/1/,\r\n								/09181117211/,\r\n								/1391-02-19 10:38:03/\r\n								)', '1', 'insert admin', '', 'nasservb', '127.0.0.1');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;