-- phpMyAdmin SQL Dump
-- version 3.5.8.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 08, 2017 at 05:16 PM
-- Server version: 5.6.11-log
-- PHP Version: 5.6.19

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `gsms`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`offtel`@`localhost` PROCEDURE `register_Facture`(IN `in_admin_id` BIGINT, IN `manualtrans_id` BIGINT, IN `userorderid` BIGINT, IN `insert_date` VARCHAR(20), IN `acceptorid` BIGINT, IN `description` VARCHAR(200) CHARSET utf8, IN `date_due` VARCHAR(20), IN `manualtrans_type_id` INT, OUT `result` BIGINT)
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
procedure_register_plan: begin

	declare admin_credit double default -10;
	declare admin_family VARCHAR(30) charset utf8;
        declare admin_mobile VARCHAR(30) charset utf8;


	declare totalAmountReceipt double default -10; 
	declare print_priceFacture double default -10;          declare service_priceFacture double default -10;          declare nameOrder VARCHAR(100) charset utf8;
	

	declare last_facture_id bigint default 0;	declare last_balance_id bigint default 0;	declare calculated_admin_credit double default 0;
	set names utf8;

		select `family` ,`credit`,`mobile`
		into admin_family , admin_credit,admin_mobile
		from `admin`
		where `admin_id` = in_admin_id;

		if admin_credit = -10 	then 
		set result = -2 ; 
				leave procedure_register_plan;
	end if;


	select `total_amount` 
		into totalAmountReceipt
		from `manualtransaction`
		where `id` = manualtrans_id;


 
	select `print_price`,`service_price`,`name` 
		into print_priceFacture,service_priceFacture,nameOrder
		from `userorder`
		where `id` = userorderid;



			
		set calculated_admin_credit = print_priceFacture + 

service_priceFacture;
START TRANSACTION;

	SET result = 0;


insert 
		into `balance`
		(
			`id`
			,`balance_type_id`
                         ,`description`
			,`insert_date`
			,`pay`
			,`recive`
			,`admin_id`
			,`intransactionid`
			,`untransactionid`
                        ,`userorderid`
			,`temp_credit`
			,`mobile`
            
			
		) 
		values
		(
			NULL,
			manualtrans_type_id,
			'Manual Transactions',
			insert_date,
			totalAmountReceipt ,
			0,
			in_admin_id,
			NULL,
			manualtrans_id,
              userorderid,
			totalAmountReceipt,
			admin_mobile 
		);
        
	SET last_balance_id = LAST_INSERT_ID();
     
		
	update  `admin`
	set 
			`Credit`=calculated_admin_credit
	where 	`admin_id`= in_admin_id;
	

UPDATE `manualtransaction`
SET `date_accept`=insert_date AND `acceptor_id`=acceptorid  AND `editor_id`=acceptorid AND`is_accept`=1 AND`date_edit`=insert_date
WHERE  `id`=manualtrans_id;


	insert into 
		`facture`
			(
				`id`, 
				`title`, 
				`description`, 
				`insert_date`,
				`total_amount`,
				`recieve`,
				`admin_id`,
				`intransactionid`,
				`untransactionid`,
				`userorderid`,
                                 `temp_credit`,            
                                `mobile`,
                                `isaccept`,
                                `isdelete`,
                                `acceptorid`,
                 `date_due`
				
			)
			values
			(
				NULL, 
				nameOrder, 
				description, 
				insert_date,
				calculated_admin_credit,
				totalAmountReceipt , 
				in_admin_id,
				NULL,
				manualtrans_id,
				userorderid,
                calculated_admin_credit,
			       admin_mobile, 
                                0,
                                0, 
                                acceptorid,
                date_due
				
			);
           
	SET last_facture_id = LAST_INSERT_ID();






	

	SET result = LAST_INSERT_ID();
     SELECT result;
	COMMIT;

END$$

CREATE DEFINER=`offtel`@`localhost` PROCEDURE `register_onFacture`(IN `in_admin_id` BIGINT, IN `balanceId` BIGINT, IN `userorderid` BIGINT, IN `insert_date` VARCHAR(20), IN `acceptorid` BIGINT(20), IN `description` VARCHAR(200) CHARSET utf8, IN `due_date` VARCHAR(20), OUT `result` BIGINT)
    MODIFIES SQL DATA
    SQL SECURITY INVOKER
procedure_register_plan: begin

	declare admin_credit double default -10;
	declare admin_family VARCHAR(30) charset utf8;
        declare admin_mobile VARCHAR(30) charset utf8;


	declare totalAmountReceipt double default -10; 
	declare print_priceFacture double default -10;          declare service_priceFacture double default -10;            declare nameOrder VARCHAR(100) charset utf8;
	
	
   declare intransactionid bigint default 0;	declare last_facture_id bigint default 0;	declare last_balance_id bigint default 0;	declare calculated_admin_credit double default 0;
	set names utf8;

		select `family` ,`credit`,`mobile`
		into admin_family , admin_credit,admin_mobile
		from `admin`
		where `admin_id` = in_admin_id;

		if admin_credit = -10 	then 
		set result = -2 ; 
				leave procedure_register_plan;
	end if;
    
    
	select `intransactionid` 
		into intransactionid
		from `balance`
		where `id` = balanceId;


	select `total_amount` 
		into totalAmountReceipt
		from `internet_transaction`
		where `id` = intransactionid;


 
	select `print_price`,`service_price` ,`name`
		into print_priceFacture,service_priceFacture,nameOrder
		from `userorder`
		where `id` = userorderid;



			
		set calculated_admin_credit = print_priceFacture +service_priceFacture;
START TRANSACTION;

	SET result = 0;


UPDATE `balance`
SET `userorderid`=userorderid

where `id`=balanceId; 
 

        
	SET last_balance_id = balanceId;
     
		
	update  `admin`
	set 
			`Credit`=calculated_admin_credit
	where 	`admin_id`= in_admin_id;
	



	insert into 
		`facture`
			(
				`id`, 
				`title`, 
				`description`, 
				`insert_date`,
				`total_amount`,
				`recieve`,
				`admin_id`,
				`intransactionid`,
				`untransactionid`,
				`userorderid`,
                                 `temp_credit`,            
                                `mobile`,
                                `isaccept`,
                                `isdelete`,
                                `acceptorid`,
                 `date_due`
                
				
			)
			values
			(
				NULL, 
				nameOrder, 
				description, 
				insert_date,
				calculated_admin_credit,
				totalAmountReceipt , 
				in_admin_id,
				intransactionid,
				NULL,
				userorderid,
                calculated_admin_credit,
			       admin_mobile, 
                                0,
                                0, 
                                acceptorid,
                due_date
				
			);
           
	SET last_facture_id = LAST_INSERT_ID();






	

	SET result = LAST_INSERT_ID();
     SELECT result;
	COMMIT;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `admin_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `family` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `melli` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL,
  `mail` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `username` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `description` text COLLATE utf8_persian_ci COMMENT 'توضیحات',
  `admin_type` bigint(20) unsigned DEFAULT '0' COMMENT 'آی دی والد . کسی که او را ایجاد کرده و توان تغییر او را دارد',
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
  `permission` varchar(100) COLLATE utf8_persian_ci DEFAULT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci COMMENT='جدول ثبت مدیران سیستم و اپراتور ها' AUTO_INCREMENT=5032 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `name`, `family`, `melli`, `mail`, `username`, `password`, `description`, `admin_type`, `mobile`, `date`, `insert_date`, `credit`, `home_address`, `work_address`, `home_postal_code`, `home_phone`, `title`, `google_x`, `google_y`, `work_postal_code`, `work_phone`, `ostan_id`, `shahr_id`, `creator_id`, `icon_picture_id`, `is_email_notic`, `is_sms_notic`, `permission`) VALUES
(5028, 'javad', 'gh', NULL, '', 'admin', 'na7Nbyy6SWRqw', 'pass is 123', 3, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 0, 0, 0, 0, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `admin_type`
--

CREATE TABLE IF NOT EXISTS `admin_type` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `description` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `permissions` text CHARACTER SET utf8,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_type_id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `admin_type`
--

INSERT INTO `admin_type` (`id`, `title`, `description`, `permissions`) VALUES
(1, 'مدیر کل', 'تمام دسترسی ها را داراست', ''),
(2, 'مشتری', 'user', ''),
(3, 'کارمند', 'employ', '');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `content` text CHARACTER SET utf8,
  `create_date` varchar(20) CHARACTER SET latin1 NOT NULL,
  `item_id` bigint(20) unsigned NOT NULL,
  `email` text CHARACTER SET utf8,
  `name` text CHARACTER SET utf8,
  `parent_id` bigint(20) unsigned DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `item_type` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `accepted` tinyint(11) NOT NULL DEFAULT '0',
  `readed` tinyint(4) NOT NULL DEFAULT '0',
  `softversion` int(11) unsigned DEFAULT NULL,
  `ip` varchar(191) COLLATE utf8_persian_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `option`
--

CREATE TABLE IF NOT EXISTS `option` (
  `option_id` bigint(20) NOT NULL,
  `key` varchar(100) CHARACTER SET utf8 NOT NULL,
  `value` varchar(1000) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`option_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `option`
--

INSERT INTO `option` (`option_id`, `key`, `value`) VALUES
(1, 'theme', 'blue_isar'),
(2, 'theme', 'default'),
(3, 'theme_active', 'blue_isar'),
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
(0, 'gift_min_value', '7000');

-- --------------------------------------------------------

--
-- Table structure for table `picture`
--

CREATE TABLE IF NOT EXISTS `picture` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(1000) NOT NULL,
  `description` text NOT NULL,
  `picture_path` varchar(1000) NOT NULL,
  `create_date` varchar(30) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `like_count` int(11) NOT NULL DEFAULT '0',
  `view_count` int(11) NOT NULL DEFAULT '0',
  `item_type` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=114 ;

--
-- Dumping data for table `picture`
--

INSERT INTO `picture` (`id`, `title`, `description`, `picture_path`, `create_date`, `user_id`, `item_id`, `like_count`, `view_count`, `item_type`) VALUES
(113, 'فايل مربوط يه سفارش :', 'فايل مربوط يه سفارش :', 'admin\\orders\\95_05_17\\speedicon.png', '1395-05-17 20:24:33', 5001, 2, 0, 0, 'shahedFile'),
(112, 'فايل مربوط يه سفارش :سفارش لیبل', 'فايل مربوط يه سفارش :سفارش لیبل', 'admin\\orders\\95_05_17\\internet-speed-test-34617-1.jpg', '1395-05-17 12:47:10', 5001, 1, 0, 0, 'orderFile');

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE IF NOT EXISTS `request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `description` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `admin_id` bigint(20) DEFAULT '0',
  `is_closed` tinyint(4) DEFAULT '0',
  `chat_id` varchar(30) COLLATE utf8_persian_ci NOT NULL,
  `telfile_id` bigint(20) DEFAULT NULL,
  `is_free` tinyint(4) DEFAULT '0',
  `plan_registered_id` bigint(20) DEFAULT NULL,
  `mobile` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL,
  `state` varchar(20) COLLATE utf8_persian_ci DEFAULT '',
  `user_first_name` varchar(100) COLLATE utf8_persian_ci DEFAULT NULL,
  `user_last_name` varchar(100) COLLATE utf8_persian_ci DEFAULT NULL,
  `user_name` varchar(100) COLLATE utf8_persian_ci DEFAULT NULL,
  `user_id` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL,
  `request_date` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=25 ;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`id`, `time`, `description`, `admin_id`, `is_closed`, `chat_id`, `telfile_id`, `is_free`, `plan_registered_id`, `mobile`, `state`, `user_first_name`, `user_last_name`, `user_name`, `user_id`, `request_date`) VALUES
(19, '08:02:07', NULL, 5004, 1, '118039455', 4, 1, 0, '', 'sendFile:8', 'ناصر', 'ن', 'nasservb', '118039455', '1394-11-20'),
(20, '08:04:51', NULL, NULL, 1, '118039455', 5, 1, 0, '', 'sendFile:8', 'ناصر', 'ن', 'nasservb', '118039455', '1394-11-20'),
(21, '08:12:22', NULL, NULL, 1, '118039455', 4, 1, 0, '', 'sendFile:8', 'ناصر', 'ن', 'nasservb', '118039455', '1394-11-20'),
(22, '10:43:38', NULL, 5004, 1, '118039455', 4, 1, 0, '', 'sendFile:8', 'ناصر', 'ن', 'nasservb', '118039455', '1394-11-20'),
(23, '14:09:03', NULL, NULL, 1, '68002207', 4, 1, 0, '', 'sendFile:8', 'f', 'noori', NULL, '68002207', '1394-11-20'),
(24, '15:53:39', NULL, NULL, 1, '118039455', 6, 1, 0, '', 'fileObjectNotFound:0', 'ناصر', 'ن', 'nasservb', '118039455', '1394-11-27');

-- --------------------------------------------------------

--
-- Table structure for table `sqlbug`
--

CREATE TABLE IF NOT EXISTS `sqlbug` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sqlbug_id` int(10) unsigned NOT NULL,
  `error_code` varchar(1024) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'کد خطا',
  `describe` varchar(1024) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'توضیحات',
  `time` varchar(30) COLLATE utf8_persian_ci NOT NULL,
  `file` varchar(20) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'داخل کدام فایل خطا رخ داده است',
  `sql` text COLLATE utf8_persian_ci COMMENT 'کد اس کیو ال که خطا داده است',
  `user_id` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL,
  `message` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'توضیحی در مورد عملیاتی که باعث خطا شده',
  `read` enum('yes','no') COLLATE utf8_persian_ci DEFAULT NULL,
  `username` varchar(64) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'چون ممکن است هنگام ورود بوزر آی دی در دسارس نباشد امکان ذخیره ی یوزر آی دی نیز باید در این جدول یاشد',
  `userip` varchar(64) COLLATE utf8_persian_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci COMMENT='خطاهای اس کیو ال در این جدول ثیت می شوند' AUTO_INCREMENT=23 ;

-- --------------------------------------------------------

--
-- Table structure for table `userorder`
--

CREATE TABLE IF NOT EXISTS `userorder` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(1000) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_persian_ci,
  `abstract_desc` text CHARACTER SET utf8 COLLATE utf8_persian_ci,
  `type_id` smallint(6) unsigned DEFAULT NULL,
  `title_id` smallint(5) unsigned DEFAULT '0',
  `status_id` smallint(5) unsigned DEFAULT '0',
  `service_id` varchar(500) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL,
  `order_file_id` bigint(20) DEFAULT '0',
  `create_date` varchar(25) DEFAULT NULL,
  `expire_date` varchar(25) DEFAULT NULL,
  `deliver_date` varchar(25) DEFAULT NULL,
  `create_balance_id` int(11) DEFAULT NULL,
  `is_started` tinyint(4) DEFAULT '0',
  `is_complete_order` tinyint(4) DEFAULT '0',
  `is_delivered` tinyint(4) DEFAULT '0',
  `admin_id` int(11) DEFAULT NULL,
  `is_deleted` tinyint(4) DEFAULT '0',
  `is_accepted` tinyint(4) DEFAULT '0',
  `is_vip` tinyint(4) DEFAULT '0',
  `is_paid` tinyint(4) DEFAULT '0',
  `is_canceled` tinyint(4) DEFAULT '0',
  `last_update` varchar(25) DEFAULT NULL,
  `print_price` double DEFAULT '0',
  `service_price` double DEFAULT '0',
  `ownerMobile` varchar(100) DEFAULT NULL,
  `admin_name` varchar(500) CHARACTER SET utf8 COLLATE utf8_persian_ci DEFAULT NULL,
  `count` bigint(20) DEFAULT '0',
  `paper_type` int(11) DEFAULT '0',
  `color_count` int(11) DEFAULT '0',
  `order_height` bigint(20) DEFAULT '0',
  `order_weidth` bigint(20) DEFAULT '0',
  `label_distance` int(11) DEFAULT '0',
  `label_material` varchar(500) DEFAULT NULL,
  `color1` varchar(500) DEFAULT '0',
  `color2` varchar(500) DEFAULT '0',
  `color3` varchar(500) DEFAULT '0',
  `color4` varchar(500) DEFAULT '0',
  `color5` varchar(500) DEFAULT '0',
  `color6` varchar(500) DEFAULT '0',
  `delivery_count` int(11) DEFAULT '0',
  `delivery_width` int(11) DEFAULT '0',
  `delivery_weight` int(11) DEFAULT '0',
  `shahed_pic_id` int(11) DEFAULT '0',
  `print_count` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `userorder`
--

INSERT INTO `userorder` (`id`, `name`, `description`, `abstract_desc`, `type_id`, `title_id`, `status_id`, `service_id`, `order_file_id`, `create_date`, `expire_date`, `deliver_date`, `create_balance_id`, `is_started`, `is_complete_order`, `is_delivered`, `admin_id`, `is_deleted`, `is_accepted`, `is_vip`, `is_paid`, `is_canceled`, `last_update`, `print_price`, `service_price`, `ownerMobile`, `admin_name`, `count`, `paper_type`, `color_count`, `order_height`, `order_weidth`, `label_distance`, `label_material`, `color1`, `color2`, `color3`, `color4`, `color5`, `color6`, `delivery_count`, `delivery_width`, `delivery_weight`, `shahed_pic_id`, `print_count`) VALUES
(1, 'سفارش لیبل1', 'کار خوب و با کیفیت', '', 4, 0, 1, '25,29,31', 112, '1395-05-17 12:47:10', '', '', 0, 1, 0, 0, 5001, 0, 0, 1, 0, 0, '', 0, 0, '09121234567', 'محمدی', 3243444, 1, 2, 3444, 5444, 23444, 'آهنی', 'قرمز', 'سفید', '', '', '', '', 3444, 3235, 345, 0, 0),
(2, 'سفارش لیبل 2', 'کامل چاپ شود', '', 0, 7, 1, '29', 0, '1395-05-17 20:15:57', '', '', 0, 0, 0, 0, 5001, 0, 0, 0, 0, 0, '', 0, 0, '09121234567', 'محمدی', 9900, 2, 1, 76878, 6778, 789989, 'پارچه', 'سیاه', '', '', '', '', '', 455, 343, 675, 113, 0),
(3, 'کارت ویزیت', 'سریع چاپ شود', '', 0, 1, 1, '0', 0, '1395-07-27 00:26:38', '', '', 0, 0, 0, 0, 5029, 0, 0, 0, 2, 0, '', 0, 0, '08128284576', 'احمدی', 45, 0, 0, 0, 0, 0, '0', '', '', '', '', '', '', 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `visit`
--

CREATE TABLE IF NOT EXISTS `visit` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
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
  `is_ads` int(11) unsigned DEFAULT NULL,
  `plan_registered_id` bigint(1) unsigned DEFAULT NULL,
  `price` int(11) unsigned DEFAULT NULL,
  `referrer` varchar(191) COLLATE utf8_persian_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=53 ;

--
-- Dumping data for table `visit`
--

INSERT INTO `visit` (`id`, `date`, `time`, `ip`, `device`, `screen`, `admin`, `os`, `browser`, `is_mobile`, `part`, `data`, `is_ads`, `plan_registered_id`, `price`, `referrer`) VALUES
(1, '1395-05-31', '20:40:20', '127.0.0.1', '', '', 0, 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '', b'1', 'indexindex', '', 0, 0, 0, ''),
(2, '1395-05-31', '20:40:29', '127.0.0.1', '', '', 0, 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '', b'1', 'loginregister', '', 0, 0, 0, ''),
(3, '1395-05-31', '20:40:41', '127.0.0.1', '', '', 0, 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '', b'1', 'indexindex', '', 0, 0, 0, ''),
(4, '1395-05-31', '20:41:25', '127.0.0.1', '', '', 0, 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '', b'1', 'loginregister', '', 0, 0, 0, ''),
(5, '1395-05-31', '20:41:41', '127.0.0.1', '', '', 0, 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36', '', b'1', 'indexindex', '', 0, 0, 0, ''),
(6, '1395-07-26', '19:48:22', '127.0.0.1', '', '', 0, 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '', b'1', 'indexindex', '', 0, 0, 0, ''),
(7, '1395-07-26', '19:48:26', '127.0.0.1', '', '', 0, 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '', b'1', 'loginregister', '', 0, 0, 0, ''),
(8, '1395-07-26', '19:54:04', '127.0.0.1', '', '', 0, 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '', b'1', 'user/indexindex', '', 0, 0, 0, ''),
(9, '1395-07-26', '19:54:16', '127.0.0.1', '', '', 0, 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '', b'1', 'user/ordersnewOrders', '', 0, 0, 0, ''),
(10, '1395-07-26', '19:54:46', '127.0.0.1', '', '', 0, 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '', b'1', 'user/ordersnewOrders', '', 0, 0, 0, ''),
(11, '1395-07-26', '19:54:58', '127.0.0.1', '', '', 0, 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '', b'1', 'user/ordersnewOrders', '', 0, 0, 0, ''),
(12, '1395-07-26', '19:55:15', '127.0.0.1', '', '', 0, 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '', b'1', 'user/ordersviewOrderDetail', '', 0, 0, 0, ''),
(13, '1395-07-26', '19:55:23', '127.0.0.1', '', '', 0, 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '', b'1', 'user/ordersnewOrders', '', 0, 0, 0, ''),
(14, '1395-07-26', '19:57:43', '127.0.0.1', '', '', 0, 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '', b'1', 'user/ordersnewOrders', '', 0, 0, 0, ''),
(15, '1395-07-26', '19:58:20', '127.0.0.1', '', '', 0, 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '', b'1', 'user/indexindex', '', 0, 0, 0, ''),
(16, '1395-07-26', '19:58:33', '127.0.0.1', '', '', 0, 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '', b'1', 'user/ordersregisterOrder', '', 0, 0, 0, ''),
(17, '1395-07-26', '19:58:37', '127.0.0.1', '', '', 0, 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '', b'1', 'user/indexindex', '', 0, 0, 0, ''),
(18, '1395-07-26', '19:59:38', '127.0.0.1', '', '', 0, 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '', b'1', 'indexindex', '', 0, 0, 0, ''),
(19, '1395-07-26', '20:00:01', '127.0.0.1', '', '', 0, 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '', b'1', 'loginregister', '', 0, 0, 0, ''),
(20, '1395-07-26', '20:00:07', '127.0.0.1', '', '', 0, 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '', b'1', 'employ/indexindex', '', 0, 0, 0, ''),
(21, '1395-07-26', '20:04:31', '127.0.0.1', '', '', 0, 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '', b'1', 'employ/ordersnewOrders', '', 0, 0, 0, ''),
(22, '1395-07-26', '20:41:39', '127.0.0.1', '', '', 0, 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '', b'1', 'employ/ordersnewOrders', '', 0, 0, 0, ''),
(23, '1395-07-26', '20:42:07', '127.0.0.1', '', '', 0, 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '', b'1', 'employ/indexindex', '', 0, 0, 0, ''),
(24, '1395-07-26', '20:51:22', '127.0.0.1', '', '', 0, 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko', '', b'1', 'indexindex', '', 0, 0, 0, ''),
(25, '1395-07-26', '20:51:27', '127.0.0.1', '', '', 0, 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko', '', b'1', 'loginregister', '', 0, 0, 0, ''),
(26, '1395-07-26', '20:51:42', '127.0.0.1', '', '', 0, 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko', '', b'1', 'admin/indexindex', '', 0, 0, 0, ''),
(27, '1395-07-26', '20:51:48', '127.0.0.1', '', '', 0, 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko', '', b'1', 'admin/ordersnewOrders', '', 0, 0, 0, ''),
(28, '1395-07-26', '20:51:54', '127.0.0.1', '', '', 0, 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko', '', b'1', 'admin/orderscurrentOrders', '', 0, 0, 0, ''),
(29, '1395-07-26', '20:51:59', '127.0.0.1', '', '', 0, 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko', '', b'1', 'admin/ordersordersArchive', '', 0, 0, 0, ''),
(30, '1395-07-26', '20:52:14', '127.0.0.1', '', '', 0, 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko', '', b'1', 'admin/ordersviewHistory', '', 0, 0, 0, ''),
(31, '1395-07-26', '20:52:21', '127.0.0.1', '', '', 0, 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko', '', b'1', 'admin/indexindex', '', 0, 0, 0, ''),
(32, '1395-07-26', '20:52:31', '127.0.0.1', '', '', 0, 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko', '', b'1', 'admin/orderscurrentOrders', '', 0, 0, 0, ''),
(33, '1395-07-26', '20:52:38', '127.0.0.1', '', '', 0, 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko', '', b'1', 'admin/ordersnewOrders', '', 0, 0, 0, ''),
(34, '1395-07-26', '20:53:17', '127.0.0.1', '', '', 0, 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko', '', b'1', 'indexindex', '', 0, 0, 0, ''),
(35, '1395-07-26', '20:53:21', '127.0.0.1', '', '', 0, 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko', '', b'1', 'loginregister', '', 0, 0, 0, ''),
(36, '1395-07-26', '20:55:20', '127.0.0.1', '', '', 0, 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko', '', b'1', 'user/indexindex', '', 0, 0, 0, ''),
(37, '1395-07-26', '20:56:09', '127.0.0.1', '', '', 0, 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko', '', b'1', 'user/ordersregisterOrder', '', 0, 0, 0, ''),
(38, '1395-07-26', '20:56:41', '127.0.0.1', '', '', 0, 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko', '', b'1', 'user/orderspaternRegister', '', 0, 0, 0, ''),
(39, '1395-07-26', '20:59:04', '127.0.0.1', '', '', 0, 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko', '', b'1', 'user/ordersreviewOrder', '', 0, 0, 0, ''),
(40, '1395-07-26', '20:59:14', '127.0.0.1', '', '', 0, 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko', '', b'1', 'user/ordersselectPayment', '', 0, 0, 0, ''),
(41, '1395-07-26', '20:59:23', '127.0.0.1', '', '', 0, 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko', '', b'1', 'user/ordersfinishPayment', '', 0, 0, 0, ''),
(42, '1395-07-26', '20:59:28', '127.0.0.1', '', '', 0, 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko', '', b'1', 'user/indexindex', '', 0, 0, 0, ''),
(43, '1395-07-26', '20:59:32', '127.0.0.1', '', '', 0, 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko', '', b'1', 'user/ordersnewOrders', '', 0, 0, 0, ''),
(44, '1395-07-26', '21:17:16', '127.0.0.1', '', '', 0, 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '', b'1', 'employ/orderscurrentOrders', '', 0, 0, 0, ''),
(45, '1395-07-26', '21:17:21', '127.0.0.1', '', '', 0, 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '', b'1', 'employ/indexindex', '', 0, 0, 0, ''),
(46, '1395-07-26', '21:17:45', '127.0.0.1', '', '', 0, 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko', '', b'1', 'user/ordersnewOrders', '', 0, 0, 0, ''),
(47, '1395-07-26', '21:29:31', '127.0.0.1', '', '', 0, 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko', '', b'1', 'user/ordersnewOrders', '', 0, 0, 0, ''),
(48, '1395-07-26', '21:31:22', '127.0.0.1', '', '', 0, 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko', '', b'1', 'user/ordersnewOrders', '', 0, 0, 0, ''),
(49, '1395-07-26', '21:32:00', '127.0.0.1', '', '', 0, 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko', '', b'1', 'user/indexindex', '', 0, 0, 0, ''),
(50, '1395-07-26', '21:32:16', '127.0.0.1', '', '', 0, 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko', '', b'1', 'user/ordersnewOrders', '', 0, 0, 0, ''),
(51, '1395-07-26', '21:32:32', '127.0.0.1', '', '', 0, 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '', b'1', 'employ/orderscurrentOrders', '', 0, 0, 0, ''),
(52, '1395-07-26', '21:34:32', '127.0.0.1', '', '', 0, 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36', '', b'1', 'employ/orderscurrentOrders', '', 0, 0, 0, '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
