-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 05, 2018 at 10:09 PM
-- Server version: 5.7.17
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `oms_chap`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `family` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `melli` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL,
  `mail` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `username` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `description` text COLLATE utf8_persian_ci COMMENT 'توضیحات',
  `admin_type` bigint(20) UNSIGNED DEFAULT '0' COMMENT 'آی دی والد . کسی که او را ایجاد کرده و توان تغییر او را دارد',
  `mobile` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL,
  `date` varchar(30) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'تاریخ ایجاد پروفایل',
  `insert_date` varchar(30) COLLATE utf8_persian_ci DEFAULT NULL,
  `credit` double NOT NULL DEFAULT '0',
  `home_address` varchar(1000) COLLATE utf8_persian_ci DEFAULT NULL,
  `work_address` varchar(1000) COLLATE utf8_persian_ci DEFAULT NULL,
  `home_postal_code` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL,
  `home_phone` varchar(30) COLLATE utf8_persian_ci DEFAULT NULL,
  `title` varchar(1000) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'حوزه فعالیت',
  `google_x` double DEFAULT '0',
  `google_y` double DEFAULT '0',
  `work_postal_code` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL,
  `work_phone` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL,
  `ostan_id` int(11) DEFAULT '0',
  `shahr_id` int(11) DEFAULT '0',
  `creator_id` bigint(20) DEFAULT '0',
  `icon_picture_id` bigint(20) DEFAULT '0',
  `is_email_notic` int(10) DEFAULT '0',
  `is_sms_notic` int(10) DEFAULT '0',
  `permission` varchar(100) COLLATE utf8_persian_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci COMMENT='جدول ثبت مدیران سیستم و اپراتور ها';

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `name`, `family`, `melli`, `mail`, `username`, `password`, `description`, `admin_type`, `mobile`, `date`, `insert_date`, `credit`, `home_address`, `work_address`, `home_postal_code`, `home_phone`, `title`, `google_x`, `google_y`, `work_postal_code`, `work_phone`, `ostan_id`, `shahr_id`, `creator_id`, `icon_picture_id`, `is_email_notic`, `is_sms_notic`, `permission`) VALUES
(5001, 'nasser niazy', ' pass is 123', '89758748653', 'nasservb@gmail.com', 'admin', 'na7Nbyy6SWRqw', 'kjkj\r\n\r\nnlkjkjkj\r\n\r\nkkljhlkjh\r\nkkljh', 1, '09189151266', '1395-05-12', '', 0, 'hgkjhgfhggh\r\nklhkjh\r\nh\r\nklklhlhklk', 'jfhnhgfhgkg\r\njgfkjhgfkh\r\nhjjhjhf', '64654765', '87774865654', '', 0, 0, '654654543', '3425424343', 0, 0, 5001, 111, 0, 0, ''),
(5028, 'محمد جوادعزیزی', ' pass is 123', '39926567898', 'test@yahoo.com', 'user', 'na7Nbyy6SWRqw', 'تولید کننده پروفیل های آلمینیوم', 2, '09122223658', '0000-00-00', '', 0, 'تهران-سعادت آباد -میدان کاج -کوچه بیست و هشتم - پلاک 12', 'تهران - خیابان گاندی -کوچه بیست و یکم -پلاک 8 - طبقه سوم -واحد 21', '14356566', '021-3456879', 'شرکت پویا سیستم', 35.716422378376, 51.465707165087, '234234', '021-34445667', 7, 71, 5028, 10, 1, 0, '0,1');

-- --------------------------------------------------------

--
-- Table structure for table `admin_type`
--

CREATE TABLE `admin_type` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `description` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `permissions` text CHARACTER SET utf8
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_type`
--

INSERT INTO `admin_type` (`id`, `title`, `description`, `permissions`) VALUES
(1, 'مدیر کل', 'تمام دسترسی ها را داراست', NULL),
(2, 'کاربر', '[user]', NULL),
(3, 'کارمند', '[employ]', NULL);

-- --------------------------------------------------------

-- --------------------------------------------------------

--
-- Table structure for table `option`
--

CREATE TABLE `option` (
  `option_id` bigint(20) NOT NULL,
  `key` varchar(100) CHARACTER SET utf8 NOT NULL,
  `value` varchar(1000) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `option`
--

INSERT INTO `option` (`option_id`, `key`, `value`) VALUES
(1, 'theme', 'blue_isar'),
(2, 'theme', 'material'),
(3, 'theme_active', 'material'),
(18, 'tags', 'مهد کودک'),
(23, 'photo_resize', 'on'),
(24, 'photo_archive_path', 'archive'),
(25, 'photo_width', '800'),
(26, 'photo_height', '600'),
(27, 'photo_small_width', '100'),
(28, 'photo_small_height', '80'),
(12, 'gift_value', '21'),
(13, 'management_value', '23'),
(11, 'ads_value', '63'),
(0, 'gift_min_value', '7000'),
(14, 'unit_name', 'کیلوگرم'),
(15, 'unit_name', 'عدد');

-- --------------------------------------------------------

-- --------------------------------------------------------

--
-- Table structure for table `picture`
--

CREATE TABLE `picture` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(1000) NOT NULL,
  `description` text NOT NULL,
  `picture_path` varchar(1000) NOT NULL,
  `create_date` varchar(30) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL COMMENT 'order id',
  `like_count` int(11) NOT NULL DEFAULT '0',
  `view_count` int(11) NOT NULL DEFAULT '0',
  `item_type` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `picture`
--

INSERT INTO `picture` (`id`, `title`, `description`, `picture_path`, `create_date`, `user_id`, `item_id`, `like_count`, `view_count`, `item_type`) VALUES
(13, 'فايل مربوط يه سفارش :98', 'فايل مربوط يه کاربر :user', 'user/97_03_11/72916.jpg', '1397-03-11 13:58:51', 5028, 98, 0, 0, 'orderFile'),
(2, 'فايل مربوط يه سفارش :92', 'فايل مربوط يه کاربر :user', 'user/97_03_09/91845.jpg', '1397-03-09 05:42:07', 5028, 92, 0, 0, 'orderFile'),
(3, 'فايل مربوط يه سفارش :92', 'فايل مربوط يه کاربر :user', 'user/97_03_09/24547.jpg', '1397-03-09 05:42:12', 5028, 92, 0, 0, 'orderFile');

-- --------------------------------------------------------

--
-- Table structure for table `poolport_status_log`
--


-- --------------------------------------------------------

--
-- Table structure for table `sqlbug`
--

CREATE TABLE `sqlbug` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sqlbug_id` int(10) UNSIGNED NOT NULL,
  `error_code` varchar(1024) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'کد خطا',
  `describe` varchar(1024) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'توضیحات',
  `time` varchar(30) COLLATE utf8_persian_ci NOT NULL,
  `file` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'داخل کدام فایل خطا رخ داده است',
  `sql` text COLLATE utf8_persian_ci COMMENT 'کد اس کیو ال که خطا داده است',
  `user_id` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL,
  `message` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'توضیحی در مورد عملیاتی که باعث خطا شده',
  `read` enum('yes','no') COLLATE utf8_persian_ci DEFAULT NULL,
  `username` varchar(64) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'چون ممکن است هنگام ورود بوزر آی دی در دسارس نباشد امکان ذخیره ی یوزر آی دی نیز باید در این جدول یاشد',
  `userip` varchar(64) COLLATE utf8_persian_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci COMMENT='خطاهای اس کیو ال در این جدول ثیت می شوند';

--
-- Dumping data for table `sqlbug`
--

INSERT INTO `sqlbug` (`id`, `sqlbug_id`, `error_code`, `describe`, `time`, `file`, `sql`, `user_id`, `message`, `read`, `username`, `userip`) VALUES
(23, 0, '1146', 'Table /old_offtel.Picture/ doesn/t exist', '1396-02-21 04:38:01', 'Picture.php', 'delete   from `Picture` where `id`=124', '5028', 'select requested Picture', '', 'user', '95.38.189.72'),
(24, 0, '1146', 'Table /old_offtel.Picture/ doesn/t exist', '1396-02-21 04:41:39', 'Picture.php', 'delete   from `Picture` where `id`=125', '5028', 'select requested Picture', '', 'user', '95.38.189.72'),
(25, 0, '1146', 'Table /old_offtel.Picture/ doesn/t exist', '1396-02-21 04:44:56', 'Picture.php', 'delete   from `Picture` where `id`=126', '5028', 'select requested Picture', '', 'user', '95.38.189.72'),
(26, 0, '1146', 'Table /old_offtel.Picture/ doesn/t exist', '1396-02-21 04:45:55', 'Picture.php', 'delete   from `Picture` where `id`=127', '5028', 'select requested Picture', '', 'user', '95.38.189.72'),
(27, 0, '1146', 'Table /old_offtel.Picture/ doesn/t exist', '1396-02-21 04:56:45', 'Picture.php', 'delete   from `Picture` where `id`=128', '5028', 'select requested Picture', '', 'user', '95.38.189.72');

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content` text CHARACTER SET utf8,
  `create_date` varchar(20) CHARACTER SET latin1 NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `email` text CHARACTER SET utf8,
  `name` text CHARACTER SET utf8,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `item_type` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `accepted` tinyint(11) NOT NULL DEFAULT '0',
  `readed` tinyint(4) NOT NULL DEFAULT '0',
  `softversion` int(11) UNSIGNED DEFAULT NULL,
  `ip` varchar(191) COLLATE utf8_persian_ci DEFAULT NULL,
  `owner_name` tinyint(1) UNSIGNED DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`id`, `content`, `create_date`, `item_id`, `email`, `name`, `parent_id`, `user_id`, `item_type`, `accepted`, `readed`, `softversion`, `ip`, `owner_name`) VALUES
(1, 'این تیکت برای تست سیستم می باشد.', '1396-03-16 18:03:18', 0, NULL, NULL, 0, 5028, 'ticket', 0, 1, NULL, '151.240.162.36', NULL),
(2, '  پاسخ داده شد  ', '1396-03-26 13:14:51', 0, NULL, ' علی', 1, 5029, 'ticket', 0, 0, NULL, '151.240.186.198', NULL),
(3, '  پاسخ داده شد  ', '1396-03-26 13:17:56', 0, NULL, ' علی', 1, 5029, 'ticket', 0, 0, NULL, '151.240.186.198', NULL),
(4, '  پاسخ داده شد  ', '1396-03-26 13:36:38', 0, NULL, ' علی', 1, 5029, 'ticket', 0, 0, NULL, '151.240.186.198', NULL);

-- --------------------------------------------------------

CREATE TABLE `visit` (
  `id` bigint(20) NOT NULL,
  `date` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL,
  `time` time DEFAULT NULL,
  `ip` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL,
  `device` varchar(100) COLLATE utf8_persian_ci DEFAULT NULL,
  `screen` varchar(100) COLLATE utf8_persian_ci DEFAULT NULL,
  `admin` bigint(20) DEFAULT NULL,
  `os` varchar(200) COLLATE utf8_persian_ci DEFAULT NULL,
  `browser` varchar(100) COLLATE utf8_persian_ci DEFAULT NULL,
  `is_mobile` bit(1) DEFAULT b'1',
  `part` varchar(100) COLLATE utf8_persian_ci DEFAULT NULL,
  `data` varchar(500) COLLATE utf8_persian_ci DEFAULT NULL,
  `is_ads` int(11) UNSIGNED DEFAULT NULL,
  `plan_registered_id` bigint(1) UNSIGNED DEFAULT NULL,
  `price` int(11) UNSIGNED DEFAULT NULL,
  `referrer` varchar(191) COLLATE utf8_persian_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `admin_type`
--
ALTER TABLE `admin_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_type_id` (`id`);

--
--
-- Indexes for table `option`
--
ALTER TABLE `option`
  ADD PRIMARY KEY (`option_id`);

--
--
-- Indexes for table `picture`
--
ALTER TABLE `picture`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sqlbug`
--
ALTER TABLE `sqlbug`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`id`);


--
-- Indexes for table `visit`
--
ALTER TABLE `visit`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5039;
--
-- AUTO_INCREMENT for table `admin_type`
--
ALTER TABLE `admin_type`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `facture`
--
--
-- AUTO_INCREMENT for table `picture`
--
ALTER TABLE `picture`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `sqlbug`
--
ALTER TABLE `sqlbug`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `visit`
--
ALTER TABLE `visit`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `work_history`
--



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
