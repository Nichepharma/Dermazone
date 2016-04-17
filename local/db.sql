-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 22, 2015 at 07:48 PM
-- Server version: 5.5.44-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `crm_empty`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE IF NOT EXISTS `account` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `email` text,
  `address` varchar(255) DEFAULT NULL,
  `image` varchar(30) DEFAULT NULL,
  `fax` varchar(150) DEFAULT NULL,
  `section_id` smallint(5) unsigned NOT NULL,
  `type_id` smallint(5) unsigned NOT NULL,
  `industry_id` smallint(5) unsigned NOT NULL,
  `managed_by` smallint(5) unsigned NOT NULL,
  `website` varchar(255) DEFAULT NULL,
  `facebook` varchar(100) DEFAULT NULL,
  `twitter` varchar(100) DEFAULT NULL,
  `linkedin` varchar(100) DEFAULT NULL,
  `youtube` varchar(150) NOT NULL,
  `country_id` int(9) NOT NULL DEFAULT '65',
  `favourite` tinyint(1) NOT NULL DEFAULT '0',
  `tags` text,
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(9) DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(9) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `skype` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `account_expense`
--

CREATE TABLE IF NOT EXISTS `account_expense` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `main_type_id` int(10) unsigned NOT NULL,
  `type_id` int(10) unsigned NOT NULL,
  `invoice_id` int(11) DEFAULT '0',
  `amount` decimal(12,2) NOT NULL,
  `date` date NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `updated_by` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `account_expense`
--

INSERT INTO `account_expense` (`id`, `main_type_id`, `type_id`, `invoice_id`, `amount`, `date`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 1, 2, 11, 3300.00, '2015-03-18', '0000-00-00 00:00:00', '2015-03-18 14:04:53', 1, 1),
(2, 1, 2, 12, 3277.00, '2015-03-18', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(3, 1, 2, 13, 222.00, '2015-03-18', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0),
(4, 1, 2, 15, 34201.00, '2015-03-16', '0000-00-00 00:00:00', '2015-03-18 12:41:09', 1, 1),
(5, 1, 2, 16, 223.00, '2015-03-12', '2015-03-18 12:20:34', '2015-03-18 12:46:08', 1, 1),
(6, 1, 2, 0, 500.00, '2015-03-21', '2015-03-21 12:27:00', '2015-03-21 12:27:00', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `account_expense_type`
--

CREATE TABLE IF NOT EXISTS `account_expense_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `account_expense_type`
--

INSERT INTO `account_expense_type` (`id`, `title`, `parent_id`) VALUES
(1, 'Expense Type Parent1', 0),
(2, 'child2', 1),
(4, 'Expense Type Parent2', 0);

-- --------------------------------------------------------

--
-- Table structure for table `account_invoice`
--

CREATE TABLE IF NOT EXISTS `account_invoice` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `number` int(1) unsigned DEFAULT NULL,
  `vendor_id` int(10) unsigned DEFAULT NULL,
  `main_type_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `operation` int(11) NOT NULL DEFAULT '1' COMMENT '1->expense, 2->revenue',
  `date` date DEFAULT NULL,
  `total_amount` decimal(12,2) NOT NULL,
  `discount` decimal(12,2) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `account_invoice`
--

INSERT INTO `account_invoice` (`id`, `number`, `vendor_id`, `main_type_id`, `type_id`, `operation`, `date`, `total_amount`, `discount`, `created_at`, `updated_at`) VALUES
(15, 234234, 3, 1, 2, 1, '2015-03-16', 34233.00, 32.00, '2015-03-18 00:00:00', '2015-03-18 13:55:33');

-- --------------------------------------------------------

--
-- Table structure for table `account_invoice_item`
--

CREATE TABLE IF NOT EXISTS `account_invoice_item` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `invoice_id` int(10) unsigned NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `total` decimal(12,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `account_invoice_item`
--

INSERT INTO `account_invoice_item` (`id`, `invoice_id`, `name`, `qty`, `price`, `total`) VALUES
(1, 0, 'sdsdf', 0, 0.00, 234.00);

-- --------------------------------------------------------

--
-- Table structure for table `account_revenue`
--

CREATE TABLE IF NOT EXISTS `account_revenue` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `main_type_id` int(10) unsigned NOT NULL,
  `type_id` int(10) unsigned NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `date` date NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `updated_by` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `account_revenue`
--

INSERT INTO `account_revenue` (`id`, `main_type_id`, `type_id`, `amount`, `date`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 1, 3, 120.00, '2015-03-15', '2015-03-17 09:54:13', '2015-03-21 12:30:20', 1, 1),
(7, 1, 2, 10000.00, '2015-03-21', '2015-03-21 12:33:44', '2015-03-21 12:33:44', 1, 0),
(4, 1, 2, 75.00, '2015-03-17', '2015-03-17 11:36:16', '2015-03-18 10:17:41', 1, 1),
(5, 1, 2, 22.00, '2015-03-17', '2015-03-17 13:01:02', '2015-03-17 13:01:02', 1, 0),
(6, 1, 2, 95.00, '2015-03-17', '2015-03-17 14:54:38', '2015-03-17 14:54:38', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `account_revenue_type`
--

CREATE TABLE IF NOT EXISTS `account_revenue_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `account_revenue_type`
--

INSERT INTO `account_revenue_type` (`id`, `title`, `parent_id`) VALUES
(1, 'Revenue Type Parent1', 0),
(3, 'revenue child', 1),
(4, 'revenue child2', 1);

-- --------------------------------------------------------

--
-- Table structure for table `account_treasury`
--

CREATE TABLE IF NOT EXISTS `account_treasury` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NOT NULL COMMENT '0=revnue, 1=expense',
  `operation_id` int(10) unsigned NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `date` date NOT NULL DEFAULT '0000-00-00',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `account_treasury`
--

INSERT INTO `account_treasury` (`id`, `type`, `operation_id`, `amount`, `date`, `created_at`, `updated_at`) VALUES
(1, 0, 1, 120.00, '2015-03-15', '2015-03-17 00:00:00', '2015-03-21 12:30:20'),
(2, 1, 2, 50.00, '2015-03-17', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 0, 6, 500.00, '2015-03-21', '2015-03-21 12:27:00', '2015-03-21 12:27:00'),
(4, 0, 4, 75.00, '2015-03-17', '2015-03-17 11:36:16', '2015-03-18 10:17:41'),
(5, 0, 5, 22.00, '2015-03-17', '2015-03-17 13:01:02', '2015-03-17 13:01:02'),
(6, 0, 6, 95.00, '2015-03-17', '2015-03-17 14:54:38', '2015-03-17 14:54:38'),
(8, 0, 7, 10000.00, '2015-03-21', '2015-03-21 12:33:44', '2015-03-21 12:33:44');

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE IF NOT EXISTS `activity` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL COMMENT '0=task, 1=call, 2=meeting',
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `managed_by` mediumint(8) unsigned DEFAULT NULL,
  `start` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `end` datetime NOT NULL,
  `allDay` tinyint(1) NOT NULL DEFAULT '1',
  `backgroundColor` varchar(30) DEFAULT NULL,
  `borderColor` varchar(30) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `remind_after` smallint(5) unsigned DEFAULT NULL COMMENT '(x) min',
  `with` tinyint(1) NOT NULL COMMENT '0=contact, 1=account',
  `with_id` mediumint(8) unsigned NOT NULL,
  `call_type` tinyint(1) unsigned NOT NULL COMMENT 'Incomming/Outgoing call',
  `status` tinyint(1) unsigned NOT NULL COMMENT '0=Pending/ 1=Completed',
  `priority` tinyint(1) unsigned NOT NULL COMMENT '0=low/ 1=average/ 2=high',
  `where` varchar(255) NOT NULL,
  `updated_by` mediumint(9) DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(9) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=45 ;

--
-- Dumping data for table `activity`
--

INSERT INTO `activity` (`id`, `type`, `name`, `description`, `active`, `managed_by`, `start`, `end`, `allDay`, `backgroundColor`, `borderColor`, `deleted`, `remind_after`, `with`, `with_id`, `call_type`, `status`, `priority`, `where`, `updated_by`, `updated_at`, `created_by`, `created_at`) VALUES
(1, 1, 'ssssssssss', '', 1, 33, '2015-07-08 12:30:00', '2015-07-08 12:00:00', 0, '#3c8dbc', '#3c8dbc', 0, NULL, 0, 0, 0, 1, 0, '', NULL, '2015-07-12 08:31:14', NULL, '2015-07-09 11:07:25'),
(2, 1, 'aaaaaaaaaaaaaaaaaaaaa', 'aaaaaaaa', 1, 1, '2015-07-09 06:00:00', '2015-07-09 12:30:00', 0, '#3c8dbc', '#3c8dbc', 1, NULL, 0, 0, 0, 0, 0, '', NULL, '2015-07-09 12:12:55', NULL, '2015-07-09 11:07:33'),
(38, 0, 'new', '', 0, 1, '2015-07-16 09:22:37', '0000-00-00 00:00:00', 1, 'rgb(240, 18, 190)', 'rgb(240, 18, 190)', 0, NULL, 0, 0, 0, 0, 0, '', NULL, '2015-07-16 09:22:37', NULL, '2015-07-16 09:22:37'),
(39, 0, 'rr', '', 0, 1, '2015-07-16 09:24:49', '0000-00-00 00:00:00', 1, 'rgb(79, 193, 233)', 'rgb(79, 193, 233)', 0, NULL, 0, 0, 0, 0, 0, '', NULL, '2015-07-16 09:24:49', NULL, '2015-07-16 09:24:49'),
(40, 0, 'sas', 'as', 0, 1, '2015-07-16 09:29:10', '0000-00-00 00:00:00', 1, '#3c8dbc', '#3c8dbc', 0, NULL, 0, 0, 0, 0, 0, '', NULL, '2015-07-16 09:29:10', NULL, '2015-07-16 09:29:10'),
(7, 1, 'new', 'tttttttt', 1, 1, '2015-07-28 10:00:00', '2015-07-26 12:00:00', 1, NULL, '', 0, NULL, 0, 0, 0, 0, 1, '', NULL, '2015-07-14 11:44:27', NULL, '2015-07-13 08:55:02'),
(41, 0, 's', 'ss', 1, 1, '2015-07-03 10:00:00', '2015-07-03 12:00:00', 1, 'rgb(72, 207, 173)', 'rgb(72, 207, 173)', 0, NULL, 0, 0, 0, 0, 0, '', NULL, '2015-07-16 12:16:33', NULL, '2015-07-16 09:30:33'),
(42, 0, 'test', '', 0, 1, '2015-07-16 07:38:02', '0000-00-00 00:00:00', 1, 'rgb(0, 31, 63)', 'rgb(0, 31, 63)', 0, NULL, 0, 0, 0, 0, 0, '', NULL, '2015-07-16 09:38:02', NULL, '2015-07-16 09:38:02'),
(43, 0, 'sasa', '', 0, 1, '2015-07-21 07:08:46', '0000-00-00 00:00:00', 1, 'rgb(1, 255, 112)', 'rgb(1, 255, 112)', 0, NULL, 0, 0, 0, 0, 0, '', NULL, '2015-07-21 09:08:46', NULL, '2015-07-21 09:08:46'),
(44, 0, '11111111111111', '', 0, 1, '2015-07-21 07:08:51', '0000-00-00 00:00:00', 1, '#3c8dbc', '#3c8dbc', 0, NULL, 0, 0, 0, 0, 0, '', NULL, '2015-07-21 09:08:51', NULL, '2015-07-21 09:08:51'),
(17, 1, 'Call', 'tttttttt', 1, 1, '2015-07-07 10:00:00', '1970-01-01 00:00:00', 1, NULL, '', 0, NULL, 0, 0, 0, 0, 1, 'undefined', NULL, '2015-07-21 09:23:02', NULL, '2015-07-13 09:16:31'),
(18, 1, 'new', 'tttttttt', 1, 1, '0000-00-00 00:00:00', '2015-07-15 05:00:00', 1, NULL, '', 0, NULL, 0, 0, 0, 0, 1, '', NULL, '2015-07-13 10:36:00', NULL, '2015-07-13 09:17:27'),
(20, 1, '111new', 'tttttttt', 1, 1, '0000-00-00 00:00:00', '1970-01-01 00:00:00', 1, NULL, '', 0, NULL, 0, 0, 0, 0, 1, 'undefined', NULL, '2015-07-16 09:20:28', NULL, '2015-07-13 09:18:09'),
(21, 1, 'new22', 'tttttttt', 1, 1, '2015-06-30 10:00:00', '1970-01-01 00:00:00', 1, NULL, '', 0, NULL, 0, 0, 0, 1, 2, 'undefined', NULL, '2015-07-16 09:19:10', NULL, '2015-07-13 09:19:12'),
(26, 0, 'test', 'ddd', 1, 31, '2015-07-13 11:49:00', '2015-07-13 11:49:00', 1, NULL, '', 0, NULL, 0, 0, 0, 0, 0, '', NULL, '2015-07-13 12:29:57', NULL, '2015-07-13 09:50:13'),
(27, 0, 'test gamal', 'ffffffffffff', 1, 1, '2015-07-06 10:00:00', '2015-07-07 12:00:00', 1, NULL, '', 0, NULL, 0, 0, 0, 1, 0, '', NULL, '2015-07-14 11:43:31', NULL, '2015-07-13 09:51:13'),
(28, 0, 'asa', 'sdadas', 1, 1, '2015-07-14 08:10:00', '2015-07-14 17:10:00', 1, NULL, '', 0, NULL, 0, 0, 0, 0, 2, '', NULL, '2015-07-14 08:14:30', NULL, '2015-07-14 08:11:08'),
(29, 1, 'sssss', 'dddddddddd', 1, 32, '2015-07-14 06:40:00', '1970-01-01 00:00:00', 1, NULL, '', 0, NULL, 0, 0, 0, 0, 2, '', NULL, '2015-07-14 08:42:24', NULL, '2015-07-14 08:42:24'),
(30, 0, 'sss', 'ddd', 1, 31, '2015-07-14 08:50:00', '1970-01-01 00:00:00', 1, NULL, '', 0, NULL, 0, 0, 0, 1, 2, '', NULL, '2015-07-14 08:50:43', NULL, '2015-07-14 08:50:33'),
(31, 1, 'ff', 'ff', 1, 1, '2015-07-14 09:51:00', '1970-01-01 00:00:00', 1, NULL, '', 0, NULL, 0, 0, 0, 1, 2, '', NULL, '2015-07-14 08:57:24', NULL, '2015-07-14 08:51:26'),
(32, 1, 'sss', 'ddd', 1, 1, '2015-07-14 08:25:00', '1970-01-01 00:00:00', 1, NULL, '', 0, NULL, 0, 0, 1, 1, 1, '', NULL, '2015-07-14 10:14:30', NULL, '2015-07-14 10:14:30'),
(33, 1, 'ggggggg', '', 1, 0, '2015-07-14 08:18:00', '1970-01-01 00:00:00', 1, NULL, '', 0, NULL, 1, 0, 0, 0, 0, '', NULL, '2015-07-14 13:02:16', NULL, '2015-07-14 10:18:15'),
(34, 1, 'sss', 'dddddd', 1, 1, '2015-07-14 08:18:00', '1970-01-01 00:00:00', 1, NULL, '', 0, NULL, 0, 40, 1, 1, 1, '', NULL, '2015-07-14 13:01:57', NULL, '2015-07-14 10:19:00'),
(35, 0, 'sa', 'sa', 1, 1, '2015-07-01 10:00:00', '2015-07-01 12:00:00', 1, 'rgb(96, 92, 168)', 'rgb(96, 92, 168)', 0, NULL, 0, 0, 0, 0, 0, '', NULL, '2015-07-14 13:00:13', NULL, '2015-07-14 11:38:57'),
(36, 0, 'ggg', 'aa', 1, 1, '2015-06-29 10:00:00', '2015-06-29 12:00:00', 1, '#3c8dbc', '#3c8dbc', 0, NULL, 0, 0, 0, 0, 1, 'undefined', NULL, '2015-07-16 09:17:42', NULL, '2015-07-14 11:44:43'),
(37, 2, 'Subject', 'Subject', 1, 33, '2015-07-15 09:50:00', '1970-01-01 00:00:00', 1, NULL, '', 0, NULL, 1, 3, 0, 0, 2, 'Some where', NULL, '2015-07-16 08:13:13', NULL, '2015-07-14 11:51:16');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL,
  UNIQUE KEY `cache_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE IF NOT EXISTS `contact` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) DEFAULT NULL,
  `arabic_name` varchar(255) DEFAULT NULL,
  `title` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0=Mr, 1=Miss',
  `title_text` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `personal_email` varchar(250) DEFAULT NULL,
  `account_id` int(8) unsigned NOT NULL DEFAULT '0',
  `position_id` int(8) unsigned DEFAULT NULL,
  `country_id` int(9) NOT NULL DEFAULT '65',
  `image` varchar(30) DEFAULT NULL,
  `favourite` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(9) DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(9) DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `section_id` int(8) unsigned DEFAULT '0',
  `type_id` smallint(5) unsigned NOT NULL COMMENT 'type table',
  `status` tinyint(4) DEFAULT NULL COMMENT '1=lead, 2=Opportunity, 3=Contact',
  `facebook` varchar(200) DEFAULT NULL,
  `twitter` varchar(200) DEFAULT NULL,
  `linkedin` varchar(200) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `skype` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE IF NOT EXISTS `country` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL DEFAULT '',
  `calling_code` varchar(8) DEFAULT NULL,
  `LAT` varchar(10) DEFAULT NULL,
  `LNG` varchar(10) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=251 ;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `name`, `calling_code`, `LAT`, `LNG`, `deleted`) VALUES
(1, 'Afghanistan', '93', '33.00', '65.00', 0),
(2, 'Aland Islands', '358', NULL, NULL, 0),
(3, 'Albania', '355', '41.00', '20.00', 0),
(4, 'Algeria', '213', '28.00', '3.00', 0),
(5, 'American Samoa', '1+684', '14.20', '170.00', 0),
(6, 'Andorra', '376', '42.30', '1.30', 0),
(7, 'Angola', '244', '12.30', '18.30', 0),
(8, 'Anguilla', '1+264', '18.15', '63.10', 0),
(9, 'Antarctica', '672', '90.00', '0.00', 0),
(10, 'Antigua and Barbuda', '1+268', '17.03', '61.48', 0),
(11, 'Argentina', '54', '34.00', '64.00', 0),
(12, 'Armenia', '374', '40.00', '45.00', 0),
(13, 'Aruba', '297', '12.30', '69.58', 0),
(14, 'Australia', '61', '27.00', '133.00', 0),
(15, 'Austria', '43', '47.20', '13.20', 0),
(16, 'Azerbaijan', '994', '40.30', '47.30', 0),
(17, 'Bahamas', '1+242', NULL, NULL, 0),
(18, 'Bahrain', '973', '26.00', '50.33', 0),
(19, 'Bangladesh', '880', '24.00', '90.00', 0),
(20, 'Barbados', '1+246', '13.10', '59.32', 0),
(21, 'Belarus', '375', '53.00', '28.00', 0),
(22, 'Belgium', '32', '50.50', '4.00', 0),
(23, 'Belize', '501', '17.15', '88.45', 0),
(24, 'Benin', '229', '9.30', '2.15', 0),
(25, 'Bermuda', '1+441', '32.20', '64.45', 0),
(26, 'Bhutan', '975', '27.30', '90.30', 0),
(27, 'Bolivia', '591', '17.00', '65.00', 0),
(28, 'Bonaire, Sint Eustatius and Saba', '599', NULL, NULL, 0),
(29, 'Bosnia and Herzegovina', '387', '44.00', '18.00', 0),
(30, 'Botswana', '267', '22.00', '24.00', 0),
(31, 'Bouvet Island', 'NONE', '54.26', '3.24', 0),
(32, 'Brazil', '55', '10.00', '55.00', 0),
(33, 'British Indian Ocean Territory', '246', '6.00', '71.30', 0),
(34, 'Brunei', '673', '4.30', '114.40', 0),
(35, 'Bulgaria', '359', '43.00', '25.00', 0),
(36, 'Burkina Faso', '226', '13.00', '2.00', 0),
(37, 'Burundi', '257', '3.30', '30.00', 0),
(38, 'Cambodia', '855', '13.00', '105.00', 0),
(39, 'Cameroon', '237', '6.00', '12.00', 0),
(40, 'Canada', '1', '60.00', '95.00', 0),
(41, 'Cape Verde', '238', '16.00', '24.00', 0),
(42, 'Cayman Islands', '1+345', '19.30', '80.30', 0),
(43, 'Central African Republic', '236', '7.00', '21.00', 0),
(44, 'Chad', '235', '15.00', '19.00', 0),
(45, 'Chile', '56', '30.00', '71.00', 0),
(46, 'China', '86', '35.00', '105.00', 0),
(47, 'Christmas Island', '61', '10.30', '105.40', 0),
(48, 'Cocos (Keeling) Islands', '61', '12.30', '96.50', 0),
(49, 'Colombia', '57', '4.00', '72.00', 0),
(50, 'Comoros', '269', '12.10', '44.15', 0),
(51, 'Congo', '242', NULL, NULL, 0),
(52, 'Cook Islands', '682', '21.14', '159.46', 0),
(53, 'Costa Rica', '506', '10.00', '84.00', 0),
(54, 'Cote d''ivoire (Ivory Coast)', '225', NULL, NULL, 0),
(55, 'Croatia', '385', '45.10', '15.30', 0),
(56, 'Cuba', '53', '21.30', '80.00', 0),
(57, 'Curacao', '599', NULL, NULL, 0),
(58, 'Cyprus', '357', '35.00', '33.00', 0),
(59, 'Czech Republic', '420', '49.45', '15.30', 0),
(60, 'Democratic Republic of the Congo', '243', NULL, NULL, 0),
(61, 'Denmark', '45', '56.00', '10.00', 0),
(62, 'Djibouti', '253', '11.30', '43.00', 0),
(63, 'Dominica', '1+767', '15.25', '61.20', 0),
(64, 'Dominican Republic', '1+809, 8', '19.00', '70.40', 0),
(65, 'Ecuador', '593', '2.00', '77.30', 0),
(66, 'Egypt', '20', '27.00', '30.00', 0),
(67, 'El Salvador', '503', '13.50', '88.55', 0),
(68, 'Equatorial Guinea', '240', '2.00', '10.00', 0),
(69, 'Eritrea', '291', '15.00', '39.00', 0),
(70, 'Estonia', '372', '59.00', '26.00', 0),
(71, 'Ethiopia', '251', '8.00', '38.00', 0),
(72, 'Falkland Islands (Malvinas)', '500', NULL, NULL, 0),
(73, 'Faroe Islands', '298', '62.00', '7.00', 0),
(74, 'Fiji', '679', '18.00', '175.00', 0),
(75, 'Finland', '358', '64.00', '26.00', 0),
(76, 'France', '33', NULL, NULL, 0),
(77, 'French Guiana', '594', '4.00', '53.00', 0),
(78, 'French Polynesia', '689', '15.00', '140.00', 0),
(79, 'French Southern Territories', NULL, NULL, NULL, 0),
(80, 'Gabon', '241', '1.00', '11.45', 0),
(81, 'Gambia', '220', NULL, NULL, 0),
(82, 'Georgia', '995', '42.00', '43.30', 0),
(83, 'Germany', '49', '51.00', '9.00', 0),
(84, 'Ghana', '233', '8.00', '2.00', 0),
(85, 'Gibraltar', '350', '36.08', '5.21', 0),
(86, 'Greece', '30', '39.00', '22.00', 0),
(87, 'Greenland', '299', '72.00', '40.00', 0),
(88, 'Grenada', '1+473', '12.07', '61.40', 0),
(89, 'Guadaloupe', '590', NULL, NULL, 0),
(90, 'Guam', '1+671', '13.28', '144.47', 0),
(91, 'Guatemala', '502', '15.30', '90.15', 0),
(92, 'Guernsey', '44', '49.28', '2.35', 0),
(93, 'Guinea', '224', '11.00', '10.00', 0),
(94, 'Guinea-Bissau', '245', '12.00', '15.00', 0),
(95, 'Guyana', '592', '5.00', '59.00', 0),
(96, 'Haiti', '509', '19.00', '72.25', 0),
(97, 'Heard Island and McDonald Islands', 'NONE', '53.06', '72.31', 0),
(98, 'Honduras', '504', '15.00', '86.30', 0),
(99, 'Hong Kong', '852', '22.15', '114.10', 0),
(100, 'Hungary', '36', '47.00', '20.00', 0),
(101, 'Iceland', '354', '65.00', '18.00', 0),
(102, 'India', '91', '20.00', '77.00', 0),
(103, 'Indonesia', '62', '5.00', '120.00', 0),
(104, 'Iran', '98', '32.00', '53.00', 0),
(105, 'Iraq', '964', '33.00', '44.00', 0),
(106, 'Ireland', '353', '53.00', '8.00', 0),
(107, 'Isle of Man', '44', NULL, NULL, 0),
(108, 'Israel', '972', '31.30', '34.45', 0),
(109, 'Italy', '39', '42.50', '12.50', 0),
(110, 'Jamaica', '1+876', '18.15', '77.30', 0),
(111, 'Japan', '81', '36.00', '138.00', 0),
(112, 'Jersey', '44', '49.15', '2.10', 0),
(113, 'Jordan', '962', '31.00', '36.00', 0),
(114, 'Kazakhstan', '7', '48.00', '68.00', 0),
(115, 'Kenya', '254', '1.00', '38.00', 0),
(116, 'Kiribati', '686', '1.25', '173.00', 0),
(117, 'Kosovo', '381', NULL, NULL, 0),
(118, 'Kuwait', '965', '29.30', '45.45', 0),
(119, 'Kyrgyzstan', '996', '41.00', '75.00', 0),
(120, 'Laos', '856', '18.00', '105.00', 0),
(121, 'Latvia', '371', '57.00', '25.00', 0),
(122, 'Lebanon', '961', '33.50', '35.50', 0),
(123, 'Lesotho', '266', '29.30', '28.30', 0),
(124, 'Liberia', '231', '6.30', '9.30', 0),
(125, 'Libya', '218', '25.00', '17.00', 0),
(126, 'Liechtenstein', '423', '47.16', '9.32', 0),
(127, 'Lithuania', '370', '56.00', '24.00', 0),
(128, 'Luxembourg', '352', '49.45', '6.10', 0),
(129, 'Macao', '853', NULL, NULL, 0),
(130, 'Macedonia', '389', NULL, NULL, 0),
(131, 'Madagascar', '261', '20.00', '47.00', 0),
(132, 'Malawi', '265', '13.30', '34.00', 0),
(133, 'Malaysia', '60', '2.30', '112.30', 0),
(134, 'Maldives', '960', '3.15', '73.00', 0),
(135, 'Mali', '223', '17.00', '4.00', 0),
(136, 'Malta', '356', '35.50', '14.35', 0),
(137, 'Marshall Islands', '692', '9.00', '168.00', 0),
(138, 'Martinique', '596', '14.40', '61.00', 0),
(139, 'Mauritania', '222', '20.00', '12.00', 0),
(140, 'Mauritius', '230', '20.17', '57.33', 0),
(141, 'Mayotte', '262', '12.50', '45.10', 0),
(142, 'Mexico', '52', '23.00', '102.00', 0),
(143, 'Micronesia', '691', NULL, NULL, 0),
(144, 'Moldava', '373', NULL, NULL, 0),
(145, 'Monaco', '377', '43.44', '7.24', 0),
(146, 'Mongolia', '976', '46.00', '105.00', 0),
(147, 'Montenegro', '382', '42.30', '19.18', 0),
(148, 'Montserrat', '1+664', '16.45', '62.12', 0),
(149, 'Morocco', '212', '32.00', '5.00', 0),
(150, 'Mozambique', '258', '18.15', '35.00', 0),
(151, 'Myanmar (Burma)', '95', NULL, NULL, 0),
(152, 'Namibia', '264', '22.00', '17.00', 0),
(153, 'Nauru', '674', '0.32', '166.55', 0),
(154, 'Nepal', '977', '28.00', '84.00', 0),
(155, 'Netherlands', '31', '52.30', '5.45', 0),
(156, 'New Caledonia', '687', '21.30', '165.30', 0),
(157, 'New Zealand', '64', '41.00', '174.00', 0),
(158, 'Nicaragua', '505', '13.00', '85.00', 0),
(159, 'Niger', '227', '16.00', '8.00', 0),
(160, 'Nigeria', '234', '10.00', '8.00', 0),
(161, 'Niue', '683', '19.02', '169.52', 0),
(162, 'Norfolk Island', '672', '29.02', '167.57', 0),
(163, 'North Korea', '850', NULL, NULL, 0),
(164, 'Northern Mariana Islands', '1+670', '15.12', '145.45', 0),
(165, 'Norway', '47', '62.00', '10.00', 0),
(166, 'Oman', '968', '21.00', '57.00', 0),
(167, 'Pakistan', '92', '30.00', '70.00', 0),
(168, 'Palau', '680', '7.30', '134.30', 0),
(169, 'Palestine', '970', NULL, NULL, 0),
(170, 'Panama', '507', '9.00', '80.00', 0),
(171, 'Papua New Guinea', '675', '6.00', '147.00', 0),
(172, 'Paraguay', '595', '23.00', '58.00', 0),
(173, 'Peru', '51', '10.00', '76.00', 0),
(174, 'Phillipines', '63', NULL, NULL, 0),
(175, 'Pitcairn', 'NONE', NULL, NULL, 0),
(176, 'Poland', '48', '52.00', '20.00', 0),
(177, 'Portugal', '351', '39.30', '8.00', 0),
(178, 'Puerto Rico', '1+939', '18.15', '66.30', 0),
(179, 'Qatar', '974', '25.30', '51.15', 0),
(180, 'Reunion', '262', '21.06', '55.36', 0),
(181, 'Romania', '40', '46.00', '25.00', 0),
(182, 'Russia', '7', '60.00', '100.00', 0),
(183, 'Rwanda', '250', '2.00', '30.00', 0),
(184, 'Saint Barthelemy', '590', '17.90', '62.85', 0),
(185, 'Saint Helena', '290', '15.56', '5.42', 0),
(186, 'Saint Kitts and Nevis', '1+869', '17.20', '62.45', 0),
(187, 'Saint Lucia', '1+758', '13.53', '60.58', 0),
(188, 'Saint Martin', '590', '18.05', '63.57', 0),
(189, 'Saint Pierre and Miquelon', '508', '46.50', '56.20', 0),
(190, 'Saint Vincent and the Grenadines', '1+784', '13.15', '61.12', 0),
(191, 'Samoa', '685', '13.35', '172.20', 0),
(192, 'San Marino', '378', '43.46', '12.25', 0),
(193, 'Sao Tome and Principe', '239', '1.00', '7.00', 0),
(194, 'Saudi Arabia', '966', '25.00', '45.00', 0),
(195, 'Senegal', '221', '14.00', '14.00', 0),
(196, 'Serbia', '381', NULL, NULL, 0),
(197, 'Seychelles', '248', '4.35', '55.40', 0),
(198, 'Sierra Leone', '232', '8.30', '11.30', 0),
(199, 'Singapore', '65', '1.22', '103.48', 0),
(200, 'Sint Maarten', '1+721', NULL, NULL, 0),
(201, 'Slovakia', '421', '48.40', '19.30', 0),
(202, 'Slovenia', '386', '46.07', '14.49', 0),
(203, 'Solomon Islands', '677', '8.00', '159.00', 0),
(204, 'Somalia', '252', '10.00', '49.00', 0),
(205, 'South Africa', '27', '29.00', '24.00', 0),
(206, 'South Georgia and the South Sandwich Islands', '500', '54.30', '37.00', 0),
(207, 'South Korea', '82', NULL, NULL, 0),
(208, 'South Sudan', '211', NULL, NULL, 0),
(209, 'Spain', '34', '40.00', '4.00', 0),
(210, 'Sri Lanka', '94', '7.00', '81.00', 0),
(211, 'Sudan', '249', '15.00', '30.00', 0),
(212, 'Suriname', '597', '4.00', '56.00', 0),
(213, 'Svalbard and Jan Mayen', '47', NULL, NULL, 0),
(214, 'Swaziland', '268', '26.30', '31.30', 0),
(215, 'Sweden', '46', '62.00', '15.00', 0),
(216, 'Switzerland', '41', '47.00', '8.00', 0),
(217, 'Syria', '963', '35.00', '38.00', 0),
(218, 'Taiwan', '886', '23.30', '121.00', 0),
(219, 'Tajikistan', '992', '39.00', '71.00', 0),
(220, 'Tanzania', '255', '6.00', '35.00', 0),
(221, 'Thailand', '66', '15.00', '100.00', 0),
(222, 'Timor-Leste (East Timor)', '670', NULL, NULL, 0),
(223, 'Togo', '228', '8.00', '1.10', 0),
(224, 'Tokelau', '690', '9.00', '172.00', 0),
(225, 'Tonga', '676', '20.00', '175.00', 0),
(226, 'Trinidad and Tobago', '1+868', '11.00', '61.00', 0),
(227, 'Tunisia', '216', '34.00', '9.00', 0),
(228, 'Turkey', '90', '39.00', '35.00', 0),
(229, 'Turkmenistan', '993', '40.00', '60.00', 0),
(230, 'Turks and Caicos Islands', '1+649', '21.45', '71.35', 0),
(231, 'Tuvalu', '688', '8.00', '178.00', 0),
(232, 'Uganda', '256', '1.00', '32.00', 0),
(233, 'Ukraine', '380', '49.00', '32.00', 0),
(234, 'United Arab Emirates', '971', '24.00', '54.00', 0),
(235, 'United Kingdom', '44', '54.00', '2.00', 0),
(236, 'United States', '1', '38.00', '97.00', 0),
(237, 'United States Minor Outlying Islands', 'NONE', NULL, NULL, 0),
(238, 'Uruguay', '598', '33.00', '56.00', 0),
(239, 'Uzbekistan', '998', '41.00', '64.00', 0),
(240, 'Vanuatu', '678', '16.00', '167.00', 0),
(241, 'Vatican City', '39', NULL, NULL, 0),
(242, 'Venezuela', '58', '8.00', '66.00', 0),
(243, 'Vietnam', '84', '16.00', '106.00', 0),
(244, 'Virgin Islands, British', '1+284', NULL, NULL, 0),
(245, 'Virgin Islands, US', '1+340', NULL, NULL, 0),
(246, 'Wallis and Futuna', '681', '13.18', '176.12', 0),
(247, 'Western Sahara', '212', '24.30', '13.00', 0),
(248, 'Yemen', '967', '15.00', '48.00', 0),
(249, 'Zambia', '260', '15.00', '30.00', 0),
(250, 'Zimbabwe', '263', '20.00', '30.00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `crm_account_message`
--

CREATE TABLE IF NOT EXISTS `crm_account_message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(8) unsigned DEFAULT NULL,
  `message_id` int(9) DEFAULT NULL COMMENT 'in case sent message',
  `received_message_id` int(10) unsigned DEFAULT NULL COMMENT 'in case received message',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=Mail, 1=SMS',
  `user_id` int(8) unsigned DEFAULT NULL COMMENT 'the system sender id (in case sent message)',
  `inbox` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=inbox,  0=sent',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `crm_contact_message`
--

CREATE TABLE IF NOT EXISTS `crm_contact_message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `contact_id` int(8) unsigned DEFAULT NULL,
  `message_id` int(9) DEFAULT NULL COMMENT 'in case sent message',
  `received_message_id` int(10) unsigned DEFAULT NULL COMMENT 'in case received message',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=Mail, 1=SMS',
  `user_id` int(8) unsigned DEFAULT NULL COMMENT 'the system sender id (in case sent message)',
  `inbox` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=inbox,  0=sent',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `crm_mail_template`
--

CREATE TABLE IF NOT EXISTS `crm_mail_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `content` text,
  `reply_to` varchar(150) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` int(8) unsigned DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(8) unsigned DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `crm_message`
--

CREATE TABLE IF NOT EXISTS `crm_message` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `content` text,
  `reply_to` varchar(150) DEFAULT NULL,
  `contacts_number` int(11) DEFAULT '1' COMMENT 'receivers number',
  `user_id` int(9) NOT NULL COMMENT 'the sender id',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=Mail, 1=SMS',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `important` tinyint(1) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `crm_received_message`
--

CREATE TABLE IF NOT EXISTS `crm_received_message` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `content` text,
  `contact_email` varchar(200) DEFAULT NULL,
  `user_email` varchar(200) DEFAULT NULL COMMENT 'the mail that contact sent to',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `important` tinyint(1) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `crm_section`
--

CREATE TABLE IF NOT EXISTS `crm_section` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `subof` int(9) NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(9) DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(9) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `crm_sms_template`
--

CREATE TABLE IF NOT EXISTS `crm_sms_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `content` text,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` int(8) unsigned DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(8) unsigned DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE IF NOT EXISTS `currency` (
  `id` smallint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT NULL,
  `code` char(3) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_currency_name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=168 ;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`id`, `name`, `code`, `deleted`) VALUES
(1, 'Andorran Peseta', 'ADP', 0),
(2, 'United Arab Emirates Dirham', 'AED', 0),
(3, 'Afghanistan Afghani', 'AFA', 0),
(4, 'Albanian Lek', 'ALL', 0),
(5, 'Netherlands Antillian Guilder', 'ANG', 0),
(6, 'Angolan Kwanza', 'AOK', 0),
(7, 'Argentine Peso', 'ARS', 0),
(9, 'Australian Dollar', 'AUD', 0),
(10, 'Aruban Florin', 'AWG', 0),
(11, 'Barbados Dollar', 'BBD', 0),
(12, 'Bangladeshi Taka', 'BDT', 0),
(14, 'Bulgarian Lev', 'BGN', 0),
(15, 'Bahraini Dinar', 'BHD', 0),
(16, 'Burundi Franc', 'BIF', 0),
(17, 'Bermudian Dollar', 'BMD', 0),
(18, 'Brunei Dollar', 'BND', 0),
(19, 'Bolivian Boliviano', 'BOB', 0),
(20, 'Brazilian Real', 'BRL', 0),
(21, 'Bahamian Dollar', 'BSD', 0),
(22, 'Bhutan Ngultrum', 'BTN', 0),
(23, 'Burma Kyat', 'BUK', 0),
(24, 'Botswanian Pula', 'BWP', 0),
(25, 'Belize Dollar', 'BZD', 0),
(26, 'Canadian Dollar', 'CAD', 0),
(27, 'Swiss Franc', 'CHF', 0),
(28, 'Chilean Unidades de Fomento', 'CLF', 0),
(29, 'Chilean Peso', 'CLP', 0),
(30, 'Yuan (Chinese) Renminbi', 'CNY', 0),
(31, 'Colombian Peso', 'COP', 0),
(32, 'Costa Rican Colon', 'CRC', 0),
(33, 'Czech Republic Koruna', 'CZK', 0),
(34, 'Cuban Peso', 'CUP', 0),
(35, 'Cape Verde Escudo', 'CVE', 0),
(36, 'Cyprus Pound', 'CYP', 0),
(40, 'Danish Krone', 'DKK', 0),
(41, 'Dominican Peso', 'DOP', 0),
(42, 'Algerian Dinar', 'DZD', 0),
(43, 'Ecuador Sucre', 'ECS', 0),
(44, 'Egyptian Pound', 'EGP', 0),
(45, 'Estonian Kroon (EEK)', 'EEK', 0),
(46, 'Ethiopian Birr', 'ETB', 0),
(47, 'Euro', 'EUR', 0),
(49, 'Fiji Dollar', 'FJD', 0),
(50, 'Falkland Islands Pound', 'FKP', 0),
(52, 'British Pound', 'GBP', 0),
(53, 'Ghanaian Cedi', 'GHC', 0),
(54, 'Gibraltar Pound', 'GIP', 0),
(55, 'Gambian Dalasi', 'GMD', 0),
(56, 'Guinea Franc', 'GNF', 0),
(58, 'Guatemalan Quetzal', 'GTQ', 0),
(59, 'Guinea-Bissau Peso', 'GWP', 0),
(60, 'Guyanan Dollar', 'GYD', 0),
(61, 'Hong Kong Dollar', 'HKD', 0),
(62, 'Honduran Lempira', 'HNL', 0),
(63, 'Haitian Gourde', 'HTG', 0),
(64, 'Hungarian Forint', 'HUF', 0),
(65, 'Indonesian Rupiah', 'IDR', 0),
(66, 'Irish Punt', 'IEP', 0),
(67, 'Israeli Shekel', 'ILS', 0),
(68, 'Indian Rupee', 'INR', 0),
(69, 'Iraqi Dinar', 'IQD', 0),
(70, 'Iranian Rial', 'IRR', 0),
(73, 'Jamaican Dollar', 'JMD', 0),
(74, 'Jordanian Dinar', 'JOD', 0),
(75, 'Japanese Yen', 'JPY', 0),
(76, 'Kenyan Schilling', 'KES', 0),
(77, 'Kampuchean (Cambodian) Riel', 'KHR', 0),
(78, 'Comoros Franc', 'KMF', 0),
(79, 'North Korean Won', 'KPW', 0),
(80, '(South) Korean Won', 'KRW', 0),
(81, 'Kuwaiti Dinar', 'KWD', 0),
(82, 'Cayman Islands Dollar', 'KYD', 0),
(83, 'Lao Kip', 'LAK', 0),
(84, 'Lebanese Pound', 'LBP', 0),
(85, 'Sri Lanka Rupee', 'LKR', 0),
(86, 'Liberian Dollar', 'LRD', 0),
(87, 'Lesotho Loti', 'LSL', 0),
(89, 'Libyan Dinar', 'LYD', 0),
(90, 'Moroccan Dirham', 'MAD', 0),
(91, 'Malagasy Franc', 'MGF', 0),
(92, 'Mongolian Tugrik', 'MNT', 0),
(93, 'Macau Pataca', 'MOP', 0),
(94, 'Mauritanian Ouguiya', 'MRO', 0),
(95, 'Maltese Lira', 'MTL', 0),
(96, 'Mauritius Rupee', 'MUR', 0),
(97, 'Maldive Rufiyaa', 'MVR', 0),
(98, 'Malawi Kwacha', 'MWK', 0),
(99, 'Mexican Peso', 'MXP', 0),
(100, 'Malaysian Ringgit', 'MYR', 0),
(101, 'Mozambique Metical', 'MZM', 0),
(102, 'Namibian Dollar', 'NAD', 0),
(103, 'Nigerian Naira', 'NGN', 0),
(104, 'Nicaraguan Cordoba', 'NIO', 0),
(105, 'Norwegian Kroner', 'NOK', 0),
(106, 'Nepalese Rupee', 'NPR', 0),
(107, 'New Zealand Dollar', 'NZD', 0),
(108, 'Omani Rial', 'OMR', 0),
(109, 'Panamanian Balboa', 'PAB', 0),
(110, 'Peruvian Nuevo Sol', 'PEN', 0),
(111, 'Papua New Guinea Kina', 'PGK', 0),
(112, 'Philippine Peso', 'PHP', 0),
(113, 'Pakistan Rupee', 'PKR', 0),
(114, 'Polish Zloty', 'PLN', 0),
(116, 'Paraguay Guarani', 'PYG', 0),
(117, 'Qatari Rial', 'QAR', 0),
(118, 'Romanian Leu', 'RON', 0),
(119, 'Rwanda Franc', 'RWF', 0),
(120, 'Saudi Arabian Riyal', 'SAR', 0),
(121, 'Solomon Islands Dollar', 'SBD', 0),
(122, 'Seychelles Rupee', 'SCR', 0),
(123, 'Sudanese Pound', 'SDP', 0),
(124, 'Swedish Krona', 'SEK', 0),
(125, 'Singapore Dollar', 'SGD', 0),
(126, 'St. Helena Pound', 'SHP', 0),
(127, 'Sierra Leone Leone', 'SLL', 0),
(128, 'Somali Schilling', 'SOS', 0),
(129, 'Suriname Guilder', 'SRG', 0),
(130, 'Sao Tome and Principe Dobra', 'STD', 0),
(131, 'Russian Ruble', 'RUB', 0),
(132, 'El Salvador Colon', 'SVC', 0),
(133, 'Syrian Potmd', 'SYP', 0),
(134, 'Swaziland Lilangeni', 'SZL', 0),
(135, 'Thai Baht', 'THB', 0),
(136, 'Tunisian Dinar', 'TND', 0),
(137, 'Tongan Paanga', 'TOP', 0),
(138, 'East Timor Escudo', 'TPE', 0),
(139, 'Turkish Lira', 'TRY', 0),
(140, 'Trinidad and Tobago Dollar', 'TTD', 0),
(141, 'Taiwan Dollar', 'TWD', 0),
(142, 'Tanzanian Schilling', 'TZS', 0),
(143, 'Uganda Shilling', 'UGX', 0),
(144, 'US Dollar', 'USD', 0),
(145, 'Uruguayan Peso', 'UYU', 0),
(146, 'Venezualan Bolivar', 'VEF', 0),
(147, 'Vietnamese Dong', 'VND', 0),
(148, 'Vanuatu Vatu', 'VUV', 0),
(149, 'Samoan Tala', 'WST', 0),
(150, 'CommunautÃ© FinanciÃ¨re Africaine BEAC, Francs', 'XAF', 0),
(151, 'Silver, Ounces', 'XAG', 0),
(152, 'Gold, Ounces', 'XAU', 0),
(153, 'East Caribbean Dollar', 'XCD', 0),
(154, 'International Monetary Fund (IMF) Special Drawing Rights', 'XDR', 0),
(155, 'CommunautÃ© FinanciÃ¨re Africaine BCEAO - Francs', 'XOF', 0),
(156, 'Palladium Ounces', 'XPD', 0),
(157, 'Comptoirs FranÃ§ais du Pacifique Francs', 'XPF', 0),
(158, 'Platinum, Ounces', 'XPT', 0),
(159, 'Democratic Yemeni Dinar', 'YDD', 0),
(160, 'Yemeni Rial', 'YER', 0),
(161, 'New Yugoslavia Dinar', 'YUD', 0),
(162, 'South African Rand', 'ZAR', 0),
(163, 'Zambian Kwacha', 'ZMK', 0),
(164, 'Zaire Zaire', 'ZRZ', 0),
(165, 'Zimbabwe Dollar', 'ZWD', 0),
(166, 'Slovak Koruna', 'SKK', 0),
(167, 'Armenian Dram', 'AMD', 0);

-- --------------------------------------------------------

--
-- Table structure for table `element_list_value`
--

CREATE TABLE IF NOT EXISTS `element_list_value` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `form_element_id` int(5) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `file`
--

CREATE TABLE IF NOT EXISTS `file` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `module` varchar(30) DEFAULT NULL,
  `record_id` int(10) unsigned NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=image, 1=document',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `form_element`
--

CREATE TABLE IF NOT EXISTS `form_element` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `form_name` varchar(100) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` enum('text','textarea','list') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `form_name` (`form_name`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `industry`
--

CREATE TABLE IF NOT EXISTS `industry` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(9) DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(9) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2013_03_17_131246_verify_init', 1),
('2013_05_11_082613_use_soft_delete', 1),
('2015_04_09_123324_add_cache_controller', 2);

-- --------------------------------------------------------

--
-- Table structure for table `note`
--

CREATE TABLE IF NOT EXISTS `note` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `record_id` mediumint(8) unsigned DEFAULT NULL,
  `module` varchar(50) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `details` text,
  `created_at` datetime NOT NULL,
  `created_by` int(8) unsigned DEFAULT NULL,
  `updated_by` int(8) unsigned DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `important` tinyint(1) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE IF NOT EXISTS `permission` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `action` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `module` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `permissions_name_index` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=187 ;

--
-- Dumping data for table `permission`
--

INSERT INTO `permission` (`id`, `action`, `module`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'index', 'users', 'users.index', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(2, 'create', 'users', 'users.create', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(3, 'store', 'users', 'users.store', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(4, 'edit', 'users', 'users.edit', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(5, 'update', 'users', 'users.update', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(6, 'destroy', 'users', 'users.destroy', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(7, 'change_status', 'users', 'users.change_status', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(8, 'multiaction', 'users', 'users.multiaction', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(9, 'index', 'mail_templates', 'mail_templates.index', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(10, 'create', 'mail_templates', 'mail_templates.create', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(11, 'store', 'mail_templates', 'mail_templates.store', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(12, 'edit', 'mail_templates', 'mail_templates.edit', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(13, 'update', 'mail_templates', 'mail_templates.update', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(14, 'destroy', 'mail_templates', 'mail_templates.destroy', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(15, 'change_status', 'mail_templates', 'mail_templates.change_status', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(16, 'multiaction', 'mail_templates', 'mail_templates.multiaction', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(17, 'index', 'sms_templates', 'sms_templates.index', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(18, 'create', 'sms_templates', 'sms_templates.create', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(19, 'store', 'sms_templates', 'sms_templates.store', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(20, 'edit', 'sms_templates', 'sms_templates.edit', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(21, 'update', 'sms_templates', 'sms_templates.update', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(22, 'destroy', 'sms_templates', 'sms_templates.destroy', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(23, 'change_status', 'sms_templates', 'sms_templates.change_status', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(24, 'multiaction', 'sms_templates', 'sms_templates.multiaction', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(25, 'index', 'roles', 'roles.index', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(26, 'create', 'roles', 'roles.create', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(27, 'store', 'roles', 'roles.store', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(28, 'edit', 'roles', 'roles.edit', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(29, 'update', 'roles', 'roles.update', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(30, 'destroy', 'roles', 'roles.destroy', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(31, 'change_status', 'roles', 'roles.change_status', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(32, 'multiaction', 'roles', 'roles.multiaction', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(33, 'index', 'contacts', 'contacts.index', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(34, 'create', 'contacts', 'contacts.create', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(35, 'store', 'contacts', 'contacts.store', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(36, 'edit', 'contacts', 'contacts.edit', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(37, 'update', 'contacts', 'contacts.update', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(38, 'destroy', 'contacts', 'contacts.destroy', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(39, 'change_status', 'contacts', 'contacts.change_status', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(40, 'multiaction', 'contacts', 'contacts.multiaction', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(41, 'index', 'forget_password', 'forget_password.index', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(42, 'create', 'forget_password', 'forget_password.create', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(43, 'store', 'forget_password', 'forget_password.store', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(44, 'edit', 'forget_password', 'forget_password.edit', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(45, 'update', 'forget_password', 'forget_password.update', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(46, 'destroy', 'forget_password', 'forget_password.destroy', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(47, 'change_status', 'forget_password', 'forget_password.change_status', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(48, 'multiaction', 'forget_password', 'forget_password.multiaction', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(49, 'index', 'reset_password', 'reset_password.index', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(50, 'create', 'reset_password', 'reset_password.create', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(51, 'store', 'reset_password', 'reset_password.store', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(52, 'edit', 'reset_password', 'reset_password.edit', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(53, 'update', 'reset_password', 'reset_password.update', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(54, 'destroy', 'reset_password', 'reset_password.destroy', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(55, 'change_status', 'reset_password', 'reset_password.change_status', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(56, 'multiaction', 'reset_password', 'reset_password.multiaction', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(57, 'index', 'types', 'types.index', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(58, 'create', 'types', 'types.create', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(59, 'store', 'types', 'types.store', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(60, 'edit', 'types', 'types.edit', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(61, 'update', 'types', 'types.update', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(62, 'destroy', 'types', 'types.destroy', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(63, 'change_status', 'types', 'types.change_status', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(64, 'multiaction', 'types', 'types.multiaction', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(65, 'index', 'sections', 'sections.index', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(66, 'create', 'sections', 'sections.create', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(67, 'store', 'sections', 'sections.store', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(68, 'edit', 'sections', 'sections.edit', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(69, 'update', 'sections', 'sections.update', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(70, 'destroy', 'sections', 'sections.destroy', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(71, 'change_status', 'sections', 'sections.change_status', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(72, 'multiaction', 'sections', 'sections.multiaction', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(73, 'index', 'messages', 'messages.index', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(74, 'create', 'messages', 'messages.create', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(75, 'store', 'messages', 'messages.store', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(76, 'edit', 'messages', 'messages.edit', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(77, 'update', 'messages', 'messages.update', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(78, 'destroy', 'messages', 'messages.destroy', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(79, 'change_status', 'messages', 'messages.change_status', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(80, 'multiaction', 'messages', 'messages.multiaction', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(81, 'index', 'received_messages', 'received_messages.index', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(82, 'create', 'received_messages', 'received_messages.create', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(83, 'store', 'received_messages', 'received_messages.store', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(84, 'edit', 'received_messages', 'received_messages.edit', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(85, 'update', 'received_messages', 'received_messages.update', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(86, 'destroy', 'received_messages', 'received_messages.destroy', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(87, 'change_status', 'received_messages', 'received_messages.change_status', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(88, 'multiaction', 'received_messages', 'received_messages.multiaction', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(89, 'index', 'contact_messages', 'contact_messages.index', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(90, 'create', 'contact_messages', 'contact_messages.create', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(91, 'store', 'contact_messages', 'contact_messages.store', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(92, 'edit', 'contact_messages', 'contact_messages.edit', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(93, 'update', 'contact_messages', 'contact_messages.update', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(94, 'destroy', 'contact_messages', 'contact_messages.destroy', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(95, 'change_status', 'contact_messages', 'contact_messages.change_status', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(96, 'multiaction', 'contact_messages', 'contact_messages.multiaction', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(97, 'index', 'accounts', 'accounts.index', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(98, 'create', 'accounts', 'accounts.create', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(99, 'store', 'accounts', 'accounts.store', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(100, 'edit', 'accounts', 'accounts.edit', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(101, 'update', 'accounts', 'accounts.update', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(102, 'destroy', 'accounts', 'accounts.destroy', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(103, 'change_status', 'accounts', 'accounts.change_status', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(104, 'multiaction', 'accounts', 'accounts.multiaction', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(105, 'index', 'projects', 'projects.index', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(106, 'create', 'projects', 'projects.create', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(107, 'store', 'projects', 'projects.store', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(108, 'edit', 'projects', 'projects.edit', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(109, 'update', 'projects', 'projects.update', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(110, 'destroy', 'projects', 'projects.destroy', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(111, 'change_status', 'projects', 'projects.change_status', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(112, 'multiaction', 'projects', 'projects.multiaction', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(113, 'index', 'departments', 'departments.index', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(114, 'create', 'departments', 'departments.create', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(115, 'store', 'departments', 'departments.store', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(116, 'edit', 'departments', 'departments.edit', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(117, 'update', 'departments', 'departments.update', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(118, 'destroy', 'departments', 'departments.destroy', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(119, 'change_status', 'departments', 'departments.change_status', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(120, 'multiaction', 'departments', 'departments.multiaction', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(121, 'index', 'positions', 'positions.index', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(122, 'create', 'positions', 'positions.create', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(123, 'store', 'positions', 'positions.store', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(124, 'edit', 'positions', 'positions.edit', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(125, 'update', 'positions', 'positions.update', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(126, 'destroy', 'positions', 'positions.destroy', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(127, 'change_status', 'positions', 'positions.change_status', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(128, 'multiaction', 'positions', 'positions.multiaction', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(129, 'index', 'notes', 'notes.index', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(130, 'create', 'notes', 'notes.create', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(131, 'store', 'notes', 'notes.store', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(132, 'edit', 'notes', 'notes.edit', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(133, 'update', 'notes', 'notes.update', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(134, 'destroy', 'notes', 'notes.destroy', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(135, 'change_status', 'notes', 'notes.change_status', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(136, 'multiaction', 'notes', 'notes.multiaction', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(137, 'index', 'activities', 'activities.index', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(138, 'create', 'activities', 'activities.create', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(139, 'store', 'activities', 'activities.store', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(140, 'edit', 'activities', 'activities.edit', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(141, 'update', 'activities', 'activities.update', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(142, 'destroy', 'activities', 'activities.destroy', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(143, 'change_status', 'activities', 'activities.change_status', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(144, 'multiaction', 'activities', 'activities.multiaction', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(145, 'index', 'forms', 'forms.index', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(146, 'create', 'forms', 'forms.create', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(147, 'store', 'forms', 'forms.store', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(148, 'edit', 'forms', 'forms.edit', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(149, 'update', 'forms', 'forms.update', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(150, 'destroy', 'forms', 'forms.destroy', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(151, 'change_status', 'forms', 'forms.change_status', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(152, 'multiaction', 'forms', 'forms.multiaction', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(153, 'index', 'permissions', 'permissions.index', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(154, 'create', 'permissions', 'permissions.create', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(155, 'store', 'permissions', 'permissions.store', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(156, 'edit', 'permissions', 'permissions.edit', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(157, 'update', 'permissions', 'permissions.update', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(158, 'destroy', 'permissions', 'permissions.destroy', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(159, 'change_status', 'permissions', 'permissions.change_status', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(160, 'multiaction', 'permissions', 'permissions.multiaction', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(161, 'index', 'settings', 'settings.index', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(162, 'create', 'settings', 'settings.create', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(163, 'store', 'settings', 'settings.store', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(164, 'edit', 'settings', 'settings.edit', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(165, 'update', 'settings', 'settings.update', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(166, 'destroy', 'settings', 'settings.destroy', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(167, 'change_status', 'settings', 'settings.change_status', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(168, 'multiaction', 'settings', 'settings.multiaction', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(169, 'get_files', 'users', 'users.get_files', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(170, 'add_files', 'users', 'users.add_files', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(171, 'messages_history', 'contacts', 'contacts.messages_history', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(172, 'products_history', 'contacts', 'contacts.products_history', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(173, 'add_service', 'contacts', 'contacts.add_service', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(174, 'send_mail', 'contacts', 'contacts.send_mail', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(175, 'send_sms', 'contacts', 'contacts.send_sms', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(176, 'view_notes', 'contacts', 'contacts.view_notes', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(177, 'get_files', 'contacts', 'contacts.get_files', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(178, 'update_favourite', 'contacts', 'contacts.update_favourite', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(179, 'add_files', 'contacts', 'contacts.add_files', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(180, 'products', 'contacts', 'contacts.products', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(181, 'mails', 'messages', 'messages.mails', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(182, 'sms', 'messages', 'messages.sms', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(183, 'show_sms', 'messages', 'messages.show_sms', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(184, 'store_ajax', 'companies', 'companies.store_ajax', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(185, 'store_ajax', 'departments', 'departments.store_ajax', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04'),
(186, 'delete', 'files', 'files.delete', NULL, '2015-07-14 08:10:04', '2015-07-14 08:10:04');

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE IF NOT EXISTS `permission_role` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`permission_id`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2015-01-28 13:37:12', '2015-01-28 13:37:12'),
(2, 1, '2015-01-28 13:39:23', '2015-01-28 13:39:23'),
(3, 1, '2015-01-28 13:39:23', '2015-01-28 13:39:23'),
(4, 1, '2015-01-28 13:39:23', '2015-01-28 13:39:23'),
(5, 1, '2015-01-28 13:39:23', '2015-01-28 13:39:23'),
(6, 1, '2015-01-28 13:39:23', '2015-01-28 13:39:23'),
(7, 1, '2015-01-28 13:39:23', '2015-01-28 13:39:23'),
(8, 1, '2015-01-28 13:39:23', '2015-01-28 13:39:23'),
(9, 1, '2015-01-28 13:39:23', '2015-01-28 13:39:23'),
(10, 1, '2015-01-28 13:39:23', '2015-01-28 13:39:23'),
(11, 1, '2015-01-28 13:39:23', '2015-01-28 13:39:23'),
(12, 1, '2015-01-28 13:39:23', '2015-01-28 13:39:23'),
(13, 1, '2015-01-28 13:39:23', '2015-01-28 13:39:23'),
(14, 1, '2015-01-28 13:39:23', '2015-01-28 13:39:23'),
(15, 1, '2015-01-28 13:39:23', '2015-01-28 13:39:23'),
(16, 1, '2015-01-28 13:39:24', '2015-01-28 13:39:24'),
(17, 1, '2015-01-28 13:39:24', '2015-01-28 13:39:24'),
(18, 1, '2015-01-28 13:39:24', '2015-01-28 13:39:24'),
(19, 1, '2015-01-28 13:39:24', '2015-01-28 13:39:24'),
(20, 1, '2015-01-28 13:39:24', '2015-01-28 13:39:24'),
(21, 1, '2015-01-28 13:39:24', '2015-01-28 13:39:24'),
(22, 1, '2015-01-28 13:39:24', '2015-01-28 13:39:24'),
(23, 1, '2015-01-28 13:39:24', '2015-01-28 13:39:24'),
(24, 1, '2015-01-28 13:39:24', '2015-01-28 13:39:24'),
(25, 1, '2015-01-28 13:39:24', '2015-01-28 13:39:24'),
(26, 1, '2015-01-28 13:39:24', '2015-01-28 13:39:24'),
(27, 1, '2015-01-28 13:39:24', '2015-01-28 13:39:24'),
(28, 1, '2015-01-28 13:39:24', '2015-01-28 13:39:24'),
(29, 1, '2015-01-28 13:39:24', '2015-01-28 13:39:24'),
(30, 1, '2015-01-28 13:39:24', '2015-01-28 13:39:24'),
(37, 1, '2015-01-28 15:42:17', '2015-01-28 15:42:17'),
(38, 1, '2015-01-28 15:42:18', '2015-01-28 15:42:18'),
(39, 1, '2015-01-28 15:42:18', '2015-01-28 15:42:18'),
(40, 1, '2015-01-28 15:42:18', '2015-01-28 15:42:18'),
(2, 5, '2015-02-09 15:45:44', '2015-02-09 15:45:44'),
(31, 2, '2015-02-09 17:24:20', '2015-02-09 17:24:20'),
(32, 2, '2015-02-09 17:24:20', '2015-02-09 17:24:20'),
(33, 2, '2015-02-09 17:24:20', '2015-02-09 17:24:20'),
(34, 2, '2015-02-09 17:24:20', '2015-02-09 17:24:20'),
(35, 2, '2015-02-09 17:24:48', '2015-02-09 17:24:48'),
(36, 2, '2015-02-09 17:24:48', '2015-02-09 17:24:48'),
(31, 1, '2015-02-11 09:40:12', '2015-02-11 09:40:12'),
(32, 1, '2015-02-11 09:40:12', '2015-02-11 09:40:12'),
(33, 1, '2015-02-11 09:40:12', '2015-02-11 09:40:12'),
(34, 1, '2015-02-11 09:40:12', '2015-02-11 09:40:12'),
(35, 1, '2015-02-11 09:40:12', '2015-02-11 09:40:12'),
(36, 1, '2015-02-11 09:40:12', '2015-02-11 09:40:12'),
(51, 1, '2015-02-11 09:40:12', '2015-02-11 09:40:12'),
(54, 1, '2015-02-11 09:40:12', '2015-02-11 09:40:12'),
(55, 1, '2015-02-11 09:40:12', '2015-02-11 09:40:12'),
(56, 1, '2015-02-11 09:40:12', '2015-02-11 09:40:12'),
(57, 1, '2015-02-11 09:40:12', '2015-02-11 09:40:12'),
(58, 1, '2015-02-11 09:40:13', '2015-02-11 09:40:13'),
(59, 1, '2015-02-11 09:40:13', '2015-02-11 09:40:13'),
(60, 1, '2015-02-11 09:40:13', '2015-02-11 09:40:13'),
(61, 1, '2015-02-11 09:40:13', '2015-02-11 09:40:13'),
(62, 1, '2015-02-11 09:40:13', '2015-02-11 09:40:13'),
(63, 1, '2015-02-11 09:40:13', '2015-02-11 09:40:13'),
(64, 1, '2015-02-11 09:40:13', '2015-02-11 09:40:13'),
(65, 1, '2015-02-11 09:40:13', '2015-02-11 09:40:13'),
(66, 1, '2015-02-11 09:40:13', '2015-02-11 09:40:13'),
(67, 1, '2015-02-11 09:40:13', '2015-02-11 09:40:13'),
(68, 1, '2015-02-11 09:40:13', '2015-02-11 09:40:13'),
(69, 1, '2015-02-11 09:40:13', '2015-02-11 09:40:13'),
(70, 1, '2015-02-11 09:40:13', '2015-02-11 09:40:13'),
(84, 2, '2015-02-11 09:54:02', '2015-02-11 09:54:02'),
(87, 2, '2015-02-11 09:54:02', '2015-02-11 09:54:02'),
(81, 2, '2015-02-11 09:55:10', '2015-02-11 09:55:10'),
(82, 2, '2015-02-11 09:55:10', '2015-02-11 09:55:10'),
(83, 2, '2015-02-11 09:55:10', '2015-02-11 09:55:10'),
(85, 2, '2015-02-11 09:55:10', '2015-02-11 09:55:10'),
(86, 2, '2015-02-11 09:55:10', '2015-02-11 09:55:10'),
(88, 2, '2015-02-11 09:55:10', '2015-02-11 09:55:10'),
(50, 1, '2015-02-11 11:27:34', '2015-02-11 11:27:34'),
(52, 1, '2015-02-11 11:27:34', '2015-02-11 11:27:34'),
(53, 1, '2015-02-11 11:27:35', '2015-02-11 11:27:35'),
(71, 1, '2015-02-11 11:27:35', '2015-02-11 11:27:35'),
(72, 1, '2015-02-11 11:27:35', '2015-02-11 11:27:35'),
(73, 1, '2015-02-11 11:27:35', '2015-02-11 11:27:35'),
(74, 1, '2015-02-11 11:27:35', '2015-02-11 11:27:35'),
(75, 1, '2015-02-11 11:27:35', '2015-02-11 11:27:35'),
(76, 1, '2015-02-11 11:27:35', '2015-02-11 11:27:35'),
(77, 1, '2015-02-11 11:27:35', '2015-02-11 11:27:35'),
(78, 1, '2015-02-11 11:27:35', '2015-02-11 11:27:35'),
(79, 1, '2015-02-11 11:27:35', '2015-02-11 11:27:35'),
(80, 1, '2015-02-11 11:27:35', '2015-02-11 11:27:35'),
(81, 1, '2015-02-11 11:27:35', '2015-02-11 11:27:35'),
(82, 1, '2015-02-11 11:27:35', '2015-02-11 11:27:35'),
(83, 1, '2015-02-11 11:27:35', '2015-02-11 11:27:35'),
(84, 1, '2015-02-11 11:27:35', '2015-02-11 11:27:35'),
(85, 1, '2015-02-11 11:27:35', '2015-02-11 11:27:35'),
(86, 1, '2015-02-11 11:27:35', '2015-02-11 11:27:35'),
(87, 1, '2015-02-11 11:27:35', '2015-02-11 11:27:35'),
(88, 1, '2015-02-11 11:27:35', '2015-02-11 11:27:35'),
(89, 1, '2015-02-11 11:27:35', '2015-02-11 11:27:35'),
(90, 1, '2015-02-11 11:27:35', '2015-02-11 11:27:35'),
(91, 1, '2015-02-11 11:27:35', '2015-02-11 11:27:35'),
(92, 1, '2015-02-11 11:27:35', '2015-02-11 11:27:35'),
(93, 1, '2015-02-11 11:27:35', '2015-02-11 11:27:35'),
(94, 1, '2015-02-11 11:27:35', '2015-02-11 11:27:35'),
(95, 1, '2015-02-11 11:27:35', '2015-02-11 11:27:35'),
(96, 1, '2015-02-11 11:27:35', '2015-02-11 11:27:35'),
(97, 1, '2015-02-11 11:27:35', '2015-02-11 11:27:35'),
(98, 1, '2015-02-11 11:27:35', '2015-02-11 11:27:35'),
(99, 1, '2015-02-11 11:27:35', '2015-02-11 11:27:35'),
(100, 1, '2015-02-11 11:27:35', '2015-02-11 11:27:35'),
(101, 1, '2015-02-11 11:27:35', '2015-02-11 11:27:35'),
(25, 2, '2015-02-11 11:33:09', '2015-02-11 11:33:09'),
(26, 2, '2015-02-11 11:33:09', '2015-02-11 11:33:09'),
(27, 2, '2015-02-11 11:33:09', '2015-02-11 11:33:09'),
(28, 2, '2015-02-11 11:33:09', '2015-02-11 11:33:09'),
(92, 2, '2015-02-11 11:33:09', '2015-02-11 11:33:09'),
(93, 2, '2015-02-11 11:33:09', '2015-02-11 11:33:09'),
(94, 2, '2015-02-11 11:33:09', '2015-02-11 11:33:09'),
(95, 2, '2015-02-11 11:33:09', '2015-02-11 11:33:09'),
(96, 2, '2015-02-11 11:33:09', '2015-02-11 11:33:09'),
(97, 2, '2015-02-11 11:33:09', '2015-02-11 11:33:09'),
(98, 2, '2015-02-11 11:33:09', '2015-02-11 11:33:09'),
(99, 2, '2015-02-11 11:33:09', '2015-02-11 11:33:09'),
(100, 2, '2015-02-11 11:33:09', '2015-02-11 11:33:09'),
(101, 2, '2015-02-11 11:33:09', '2015-02-11 11:33:09'),
(29, 2, '2015-02-11 11:35:11', '2015-02-11 11:35:11'),
(30, 2, '2015-02-11 11:35:11', '2015-02-11 11:35:11'),
(37, 2, '2015-02-11 11:35:11', '2015-02-11 11:35:11'),
(38, 2, '2015-02-11 11:35:11', '2015-02-11 11:35:11'),
(39, 2, '2015-02-11 11:35:11', '2015-02-11 11:35:11'),
(40, 2, '2015-02-11 11:35:11', '2015-02-11 11:35:11'),
(89, 2, '2015-02-11 11:35:12', '2015-02-11 11:35:12'),
(90, 2, '2015-02-11 11:35:12', '2015-02-11 11:35:12'),
(91, 2, '2015-02-11 11:35:12', '2015-02-11 11:35:12'),
(102, 2, '2015-02-11 11:35:12', '2015-02-11 11:35:12'),
(103, 2, '2015-02-11 11:35:12', '2015-02-11 11:35:12'),
(104, 2, '2015-02-11 11:35:12', '2015-02-11 11:35:12'),
(49, 1, '2015-02-11 11:48:16', '2015-02-11 11:48:16'),
(102, 1, '2015-02-11 11:48:16', '2015-02-11 11:48:16'),
(103, 1, '2015-02-11 11:48:16', '2015-02-11 11:48:16'),
(104, 1, '2015-02-11 11:48:16', '2015-02-11 11:48:16'),
(105, 1, '2015-02-11 11:48:16', '2015-02-11 11:48:16'),
(106, 1, '2015-02-11 11:48:16', '2015-02-11 11:48:16'),
(107, 1, '2015-02-11 11:48:16', '2015-02-11 11:48:16'),
(108, 1, '2015-02-11 11:48:16', '2015-02-11 11:48:16'),
(109, 1, '2015-02-11 11:48:17', '2015-02-11 11:48:17'),
(110, 1, '2015-02-11 11:48:17', '2015-02-11 11:48:17'),
(111, 1, '2015-02-11 11:48:17', '2015-02-11 11:48:17'),
(112, 1, '2015-02-11 11:48:17', '2015-02-11 11:48:17'),
(113, 1, '2015-02-11 11:48:17', '2015-02-11 11:48:17'),
(114, 1, '2015-02-11 11:48:17', '2015-02-11 11:48:17'),
(115, 1, '2015-02-11 11:48:17', '2015-02-11 11:48:17'),
(116, 1, '2015-02-11 11:48:17', '2015-02-11 11:48:17'),
(117, 1, '2015-02-11 11:48:17', '2015-02-11 11:48:17'),
(118, 1, '2015-02-11 11:48:17', '2015-02-11 11:48:17'),
(119, 1, '2015-02-11 11:48:17', '2015-02-11 11:48:17'),
(140, 2, '2015-02-15 11:48:49', '2015-02-15 11:48:49'),
(141, 2, '2015-02-15 11:48:49', '2015-02-15 11:48:49'),
(129, 2, '2015-02-15 12:05:30', '2015-02-15 12:05:30'),
(130, 2, '2015-02-15 12:05:30', '2015-02-15 12:05:30'),
(131, 2, '2015-02-15 12:05:30', '2015-02-15 12:05:30'),
(132, 2, '2015-02-15 12:05:30', '2015-02-15 12:05:30'),
(133, 2, '2015-02-15 12:05:30', '2015-02-15 12:05:30'),
(134, 2, '2015-02-15 12:05:30', '2015-02-15 12:05:30'),
(135, 2, '2015-02-15 12:05:30', '2015-02-15 12:05:30'),
(136, 2, '2015-02-15 12:05:30', '2015-02-15 12:05:30'),
(137, 2, '2015-02-15 12:05:30', '2015-02-15 12:05:30'),
(138, 2, '2015-02-15 12:05:30', '2015-02-15 12:05:30'),
(139, 2, '2015-02-15 12:05:30', '2015-02-15 12:05:30'),
(142, 2, '2015-02-15 12:05:30', '2015-02-15 12:05:30'),
(143, 2, '2015-02-15 12:05:30', '2015-02-15 12:05:30'),
(1, 2, '2015-02-19 12:00:26', '2015-02-19 12:00:26'),
(2, 2, '2015-02-19 12:00:26', '2015-02-19 12:00:26'),
(3, 2, '2015-02-19 12:00:26', '2015-02-19 12:00:26'),
(4, 2, '2015-02-19 12:00:26', '2015-02-19 12:00:26'),
(5, 2, '2015-02-19 12:00:26', '2015-02-19 12:00:26'),
(6, 2, '2015-02-19 12:00:26', '2015-02-19 12:00:26'),
(7, 2, '2015-02-19 12:00:26', '2015-02-19 12:00:26'),
(8, 2, '2015-02-19 12:00:26', '2015-02-19 12:00:26'),
(113, 5, '2015-02-22 09:29:49', '2015-02-22 09:29:49'),
(114, 5, '2015-02-22 09:29:49', '2015-02-22 09:29:49'),
(115, 5, '2015-02-22 09:29:49', '2015-02-22 09:29:49'),
(116, 5, '2015-02-22 09:29:49', '2015-02-22 09:29:49'),
(117, 5, '2015-02-22 09:29:49', '2015-02-22 09:29:49'),
(118, 5, '2015-02-22 09:29:49', '2015-02-22 09:29:49'),
(119, 5, '2015-02-22 09:29:49', '2015-02-22 09:29:49'),
(120, 5, '2015-02-22 09:29:49', '2015-02-22 09:29:49'),
(145, 2, '2015-03-02 12:51:48', '2015-03-02 12:51:48'),
(146, 2, '2015-03-02 12:51:48', '2015-03-02 12:51:48'),
(147, 2, '2015-03-02 12:51:48', '2015-03-02 12:51:48'),
(148, 2, '2015-03-02 12:51:48', '2015-03-02 12:51:48'),
(149, 2, '2015-03-02 12:51:48', '2015-03-02 12:51:48'),
(150, 2, '2015-03-02 12:51:48', '2015-03-02 12:51:48'),
(151, 2, '2015-03-02 12:51:48', '2015-03-02 12:51:48'),
(129, 1, '2015-03-05 12:05:22', '2015-03-05 12:05:22'),
(130, 1, '2015-03-05 12:05:22', '2015-03-05 12:05:22'),
(131, 1, '2015-03-05 12:05:22', '2015-03-05 12:05:22'),
(132, 1, '2015-03-05 12:05:22', '2015-03-05 12:05:22'),
(133, 1, '2015-03-05 12:05:22', '2015-03-05 12:05:22'),
(134, 1, '2015-03-05 12:05:22', '2015-03-05 12:05:22'),
(135, 1, '2015-03-05 12:05:22', '2015-03-05 12:05:22'),
(136, 1, '2015-03-05 12:05:22', '2015-03-05 12:05:22'),
(137, 1, '2015-03-05 12:05:22', '2015-03-05 12:05:22'),
(138, 1, '2015-03-05 12:05:22', '2015-03-05 12:05:22'),
(139, 1, '2015-03-05 12:05:22', '2015-03-05 12:05:22'),
(140, 1, '2015-03-05 12:05:22', '2015-03-05 12:05:22'),
(141, 1, '2015-03-05 12:05:22', '2015-03-05 12:05:22'),
(142, 1, '2015-03-05 12:05:22', '2015-03-05 12:05:22'),
(143, 1, '2015-03-05 12:05:22', '2015-03-05 12:05:22'),
(144, 1, '2015-03-05 12:05:22', '2015-03-05 12:05:22'),
(145, 1, '2015-03-05 12:05:22', '2015-03-05 12:05:22'),
(146, 1, '2015-03-05 12:05:22', '2015-03-05 12:05:22'),
(147, 1, '2015-03-05 12:05:22', '2015-03-05 12:05:22'),
(148, 1, '2015-03-05 12:05:22', '2015-03-05 12:05:22'),
(149, 1, '2015-03-05 12:05:22', '2015-03-05 12:05:22'),
(150, 1, '2015-03-05 12:05:22', '2015-03-05 12:05:22'),
(151, 1, '2015-03-05 12:05:22', '2015-03-05 12:05:22'),
(152, 1, '2015-03-05 12:05:23', '2015-03-05 12:05:23'),
(153, 1, '2015-03-05 12:05:23', '2015-03-05 12:05:23'),
(154, 1, '2015-03-05 12:05:23', '2015-03-05 12:05:23'),
(155, 1, '2015-03-05 12:05:23', '2015-03-05 12:05:23'),
(156, 1, '2015-03-05 12:05:23', '2015-03-05 12:05:23'),
(157, 1, '2015-03-05 12:05:23', '2015-03-05 12:05:23'),
(158, 1, '2015-03-05 12:05:23', '2015-03-05 12:05:23'),
(159, 1, '2015-03-05 12:05:23', '2015-03-05 12:05:23'),
(1, 5, '2015-03-10 11:36:28', '2015-03-10 11:36:28'),
(3, 5, '2015-03-10 11:36:29', '2015-03-10 11:36:29'),
(4, 5, '2015-03-10 11:36:29', '2015-03-10 11:36:29'),
(5, 5, '2015-03-10 11:36:29', '2015-03-10 11:36:29'),
(6, 5, '2015-03-10 11:36:29', '2015-03-10 11:36:29'),
(7, 5, '2015-03-10 11:36:29', '2015-03-10 11:36:29'),
(8, 5, '2015-03-10 11:36:29', '2015-03-10 11:36:29'),
(9, 5, '2015-03-10 11:36:29', '2015-03-10 11:36:29'),
(10, 5, '2015-03-10 11:36:29', '2015-03-10 11:36:29'),
(11, 5, '2015-03-10 11:36:29', '2015-03-10 11:36:29'),
(12, 5, '2015-03-10 11:36:29', '2015-03-10 11:36:29'),
(13, 5, '2015-03-10 11:36:29', '2015-03-10 11:36:29'),
(14, 5, '2015-03-10 11:36:29', '2015-03-10 11:36:29'),
(15, 5, '2015-03-10 11:36:29', '2015-03-10 11:36:29'),
(16, 5, '2015-03-10 11:36:29', '2015-03-10 11:36:29'),
(17, 5, '2015-03-10 11:36:29', '2015-03-10 11:36:29'),
(18, 5, '2015-03-10 11:36:29', '2015-03-10 11:36:29'),
(19, 5, '2015-03-10 11:36:29', '2015-03-10 11:36:29'),
(20, 5, '2015-03-10 11:36:29', '2015-03-10 11:36:29'),
(21, 5, '2015-03-10 11:36:29', '2015-03-10 11:36:29'),
(22, 5, '2015-03-10 11:36:29', '2015-03-10 11:36:29'),
(23, 5, '2015-03-10 11:36:29', '2015-03-10 11:36:29'),
(24, 5, '2015-03-10 11:36:29', '2015-03-10 11:36:29'),
(25, 5, '2015-03-10 11:36:29', '2015-03-10 11:36:29'),
(26, 5, '2015-03-10 11:36:29', '2015-03-10 11:36:29'),
(27, 5, '2015-03-10 11:36:29', '2015-03-10 11:36:29'),
(28, 5, '2015-03-10 11:36:29', '2015-03-10 11:36:29'),
(29, 5, '2015-03-10 11:36:29', '2015-03-10 11:36:29'),
(30, 5, '2015-03-10 11:36:29', '2015-03-10 11:36:29'),
(31, 5, '2015-03-10 11:36:29', '2015-03-10 11:36:29'),
(32, 5, '2015-03-10 11:36:29', '2015-03-10 11:36:29'),
(33, 5, '2015-03-10 11:36:29', '2015-03-10 11:36:29'),
(34, 5, '2015-03-10 11:36:29', '2015-03-10 11:36:29'),
(35, 5, '2015-03-10 11:36:29', '2015-03-10 11:36:29'),
(36, 5, '2015-03-10 11:36:29', '2015-03-10 11:36:29'),
(37, 5, '2015-03-10 11:36:29', '2015-03-10 11:36:29'),
(38, 5, '2015-03-10 11:36:29', '2015-03-10 11:36:29'),
(39, 5, '2015-03-10 11:36:30', '2015-03-10 11:36:30'),
(40, 5, '2015-03-10 11:36:30', '2015-03-10 11:36:30'),
(41, 5, '2015-03-10 11:36:30', '2015-03-10 11:36:30'),
(42, 5, '2015-03-10 11:36:30', '2015-03-10 11:36:30'),
(43, 5, '2015-03-10 11:36:30', '2015-03-10 11:36:30'),
(44, 5, '2015-03-10 11:36:30', '2015-03-10 11:36:30'),
(45, 5, '2015-03-10 11:36:30', '2015-03-10 11:36:30'),
(46, 5, '2015-03-10 11:36:30', '2015-03-10 11:36:30'),
(47, 5, '2015-03-10 11:36:30', '2015-03-10 11:36:30'),
(48, 5, '2015-03-10 11:36:30', '2015-03-10 11:36:30'),
(49, 5, '2015-03-10 11:36:30', '2015-03-10 11:36:30'),
(50, 5, '2015-03-10 11:36:30', '2015-03-10 11:36:30'),
(51, 5, '2015-03-10 11:36:30', '2015-03-10 11:36:30'),
(52, 5, '2015-03-10 11:36:30', '2015-03-10 11:36:30'),
(53, 5, '2015-03-10 11:36:30', '2015-03-10 11:36:30'),
(54, 5, '2015-03-10 11:36:30', '2015-03-10 11:36:30'),
(55, 5, '2015-03-10 11:36:30', '2015-03-10 11:36:30'),
(56, 5, '2015-03-10 11:36:30', '2015-03-10 11:36:30'),
(57, 5, '2015-03-10 11:36:30', '2015-03-10 11:36:30'),
(58, 5, '2015-03-10 11:36:30', '2015-03-10 11:36:30'),
(59, 5, '2015-03-10 11:36:30', '2015-03-10 11:36:30'),
(60, 5, '2015-03-10 11:36:30', '2015-03-10 11:36:30'),
(61, 5, '2015-03-10 11:36:30', '2015-03-10 11:36:30'),
(62, 5, '2015-03-10 11:36:30', '2015-03-10 11:36:30'),
(63, 5, '2015-03-10 11:36:30', '2015-03-10 11:36:30'),
(64, 5, '2015-03-10 11:36:30', '2015-03-10 11:36:30'),
(65, 5, '2015-03-10 11:36:30', '2015-03-10 11:36:30'),
(66, 5, '2015-03-10 11:36:30', '2015-03-10 11:36:30'),
(67, 5, '2015-03-10 11:36:30', '2015-03-10 11:36:30'),
(68, 5, '2015-03-10 11:36:30', '2015-03-10 11:36:30'),
(69, 5, '2015-03-10 11:36:30', '2015-03-10 11:36:30'),
(70, 5, '2015-03-10 11:36:30', '2015-03-10 11:36:30'),
(71, 5, '2015-03-10 11:36:30', '2015-03-10 11:36:30'),
(72, 5, '2015-03-10 11:36:31', '2015-03-10 11:36:31'),
(73, 5, '2015-03-10 11:36:31', '2015-03-10 11:36:31'),
(74, 5, '2015-03-10 11:36:31', '2015-03-10 11:36:31'),
(75, 5, '2015-03-10 11:36:31', '2015-03-10 11:36:31'),
(76, 5, '2015-03-10 11:36:31', '2015-03-10 11:36:31'),
(77, 5, '2015-03-10 11:36:31', '2015-03-10 11:36:31'),
(78, 5, '2015-03-10 11:36:31', '2015-03-10 11:36:31'),
(79, 5, '2015-03-10 11:36:31', '2015-03-10 11:36:31'),
(80, 5, '2015-03-10 11:36:31', '2015-03-10 11:36:31'),
(81, 5, '2015-03-10 11:36:31', '2015-03-10 11:36:31'),
(82, 5, '2015-03-10 11:36:31', '2015-03-10 11:36:31'),
(83, 5, '2015-03-10 11:36:31', '2015-03-10 11:36:31'),
(84, 5, '2015-03-10 11:36:31', '2015-03-10 11:36:31'),
(85, 5, '2015-03-10 11:36:31', '2015-03-10 11:36:31'),
(86, 5, '2015-03-10 11:36:31', '2015-03-10 11:36:31'),
(87, 5, '2015-03-10 11:36:31', '2015-03-10 11:36:31'),
(88, 5, '2015-03-10 11:36:31', '2015-03-10 11:36:31'),
(89, 5, '2015-03-10 11:36:31', '2015-03-10 11:36:31'),
(90, 5, '2015-03-10 11:36:31', '2015-03-10 11:36:31'),
(91, 5, '2015-03-10 11:36:31', '2015-03-10 11:36:31'),
(92, 5, '2015-03-10 11:36:31', '2015-03-10 11:36:31'),
(93, 5, '2015-03-10 11:36:31', '2015-03-10 11:36:31'),
(94, 5, '2015-03-10 11:36:31', '2015-03-10 11:36:31'),
(95, 5, '2015-03-10 11:36:31', '2015-03-10 11:36:31'),
(96, 5, '2015-03-10 11:36:31', '2015-03-10 11:36:31'),
(97, 5, '2015-03-10 11:36:31', '2015-03-10 11:36:31'),
(98, 5, '2015-03-10 11:36:31', '2015-03-10 11:36:31'),
(99, 5, '2015-03-10 11:36:31', '2015-03-10 11:36:31'),
(100, 5, '2015-03-10 11:36:31', '2015-03-10 11:36:31'),
(101, 5, '2015-03-10 11:36:31', '2015-03-10 11:36:31'),
(102, 5, '2015-03-10 11:36:31', '2015-03-10 11:36:31'),
(103, 5, '2015-03-10 11:36:31', '2015-03-10 11:36:31'),
(104, 5, '2015-03-10 11:36:31', '2015-03-10 11:36:31'),
(105, 5, '2015-03-10 11:36:31', '2015-03-10 11:36:31'),
(106, 5, '2015-03-10 11:36:31', '2015-03-10 11:36:31'),
(107, 5, '2015-03-10 11:36:31', '2015-03-10 11:36:31'),
(108, 5, '2015-03-10 11:36:31', '2015-03-10 11:36:31'),
(109, 5, '2015-03-10 11:36:31', '2015-03-10 11:36:31'),
(110, 5, '2015-03-10 11:36:32', '2015-03-10 11:36:32'),
(111, 5, '2015-03-10 11:36:32', '2015-03-10 11:36:32'),
(112, 5, '2015-03-10 11:36:32', '2015-03-10 11:36:32'),
(121, 5, '2015-03-10 11:36:32', '2015-03-10 11:36:32'),
(122, 5, '2015-03-10 11:36:32', '2015-03-10 11:36:32'),
(123, 5, '2015-03-10 11:36:32', '2015-03-10 11:36:32'),
(124, 5, '2015-03-10 11:36:32', '2015-03-10 11:36:32'),
(125, 5, '2015-03-10 11:36:32', '2015-03-10 11:36:32'),
(126, 5, '2015-03-10 11:36:32', '2015-03-10 11:36:32'),
(127, 5, '2015-03-10 11:36:32', '2015-03-10 11:36:32'),
(128, 5, '2015-03-10 11:36:32', '2015-03-10 11:36:32'),
(129, 5, '2015-03-10 11:36:32', '2015-03-10 11:36:32'),
(130, 5, '2015-03-10 11:36:32', '2015-03-10 11:36:32'),
(131, 5, '2015-03-10 11:36:32', '2015-03-10 11:36:32'),
(132, 5, '2015-03-10 11:36:32', '2015-03-10 11:36:32'),
(133, 5, '2015-03-10 11:36:32', '2015-03-10 11:36:32'),
(134, 5, '2015-03-10 11:36:32', '2015-03-10 11:36:32'),
(135, 5, '2015-03-10 11:36:32', '2015-03-10 11:36:32'),
(136, 5, '2015-03-10 11:36:32', '2015-03-10 11:36:32'),
(137, 5, '2015-03-10 11:36:32', '2015-03-10 11:36:32'),
(138, 5, '2015-03-10 11:36:32', '2015-03-10 11:36:32'),
(139, 5, '2015-03-10 11:36:32', '2015-03-10 11:36:32'),
(140, 5, '2015-03-10 11:36:32', '2015-03-10 11:36:32'),
(141, 5, '2015-03-10 11:36:32', '2015-03-10 11:36:32'),
(142, 5, '2015-03-10 11:36:32', '2015-03-10 11:36:32'),
(143, 5, '2015-03-10 11:36:32', '2015-03-10 11:36:32'),
(144, 5, '2015-03-10 11:36:32', '2015-03-10 11:36:32'),
(145, 5, '2015-03-10 11:36:32', '2015-03-10 11:36:32'),
(146, 5, '2015-03-10 11:36:32', '2015-03-10 11:36:32'),
(147, 5, '2015-03-10 11:36:32', '2015-03-10 11:36:32'),
(148, 5, '2015-03-10 11:36:32', '2015-03-10 11:36:32'),
(149, 5, '2015-03-10 11:36:32', '2015-03-10 11:36:32'),
(150, 5, '2015-03-10 11:36:32', '2015-03-10 11:36:32'),
(151, 5, '2015-03-10 11:36:32', '2015-03-10 11:36:32'),
(2, 7, '2015-03-10 12:27:57', '2015-03-10 12:27:57'),
(41, 2, '2015-03-16 15:08:41', '2015-03-16 15:08:41'),
(42, 2, '2015-03-16 15:08:41', '2015-03-16 15:08:41'),
(43, 2, '2015-03-16 15:08:41', '2015-03-16 15:08:41'),
(44, 2, '2015-03-16 15:08:41', '2015-03-16 15:08:41'),
(45, 2, '2015-03-16 15:08:41', '2015-03-16 15:08:41'),
(46, 2, '2015-03-16 15:08:41', '2015-03-16 15:08:41'),
(47, 2, '2015-03-16 15:08:41', '2015-03-16 15:08:41'),
(48, 2, '2015-03-16 15:08:41', '2015-03-16 15:08:41'),
(155, 2, '2015-03-16 15:08:41', '2015-03-16 15:08:41'),
(156, 2, '2015-03-16 15:08:41', '2015-03-16 15:08:41'),
(157, 2, '2015-03-16 15:08:41', '2015-03-16 15:08:41'),
(158, 2, '2015-03-16 15:08:41', '2015-03-16 15:08:41'),
(159, 2, '2015-03-16 15:08:41', '2015-03-16 15:08:41'),
(9, 2, '2015-04-09 10:50:36', '2015-04-09 10:50:36'),
(105, 8, '2015-05-05 12:44:22', '2015-05-05 12:44:22'),
(1, 8, '2015-05-05 12:45:26', '2015-05-05 12:45:26'),
(146, 8, '2015-05-14 08:46:30', '2015-05-14 08:46:30'),
(145, 8, '2015-05-14 09:55:05', '2015-05-14 09:55:05');

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE IF NOT EXISTS `position` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(9) DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(9) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`id`, `name`, `description`, `active`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted`) VALUES
(1, 'Manager', 'position', 1, '2015-04-29 11:24:17', 1, '2015-04-29 11:24:17', NULL, 0),
(2, 'Developer', 'Developer', 1, '2015-06-15 13:58:44', 1, '2015-06-15 13:59:02', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE IF NOT EXISTS `project` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `revenue` decimal(12,2) NOT NULL,
  `currency_id` smallint(5) unsigned NOT NULL,
  `probability` tinyint(1) NOT NULL,
  `start_date` date NOT NULL,
  `closing_date` date NOT NULL,
  `contact_id` mediumint(8) unsigned NOT NULL,
  `account_id` mediumint(8) unsigned NOT NULL,
  `type_id` mediumint(8) unsigned NOT NULL,
  `favourite` tinyint(1) NOT NULL DEFAULT '0',
  `tags` text,
  `details` text,
  `managed_by` mediumint(8) unsigned NOT NULL,
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(9) DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(9) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `level` int(6) NOT NULL DEFAULT '1',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`, `description`, `level`, `active`, `created_at`, `updated_at`, `deleted`) VALUES
(1, 'Super Admin', 'Super Admin Description.', 10, 1, '2015-01-27 12:30:06', '2015-02-11 14:58:37', 0);

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE IF NOT EXISTS `role_user` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `role_user_user_id_index` (`user_id`),
  KEY `role_user_role_id_index` (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=26 ;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`user_id`, `role_id`, `created_at`, `updated_at`, `id`) VALUES
(1, 1, '2015-02-14 12:59:55', '2015-02-14 12:59:55', 9);

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE IF NOT EXISTS `setting` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `name`, `value`) VALUES
(1, 'currency', 'EGP');

-- --------------------------------------------------------

--
-- Table structure for table `type`
--

CREATE TABLE IF NOT EXISTS `type` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `module` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(9) DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(9) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `type`
--

INSERT INTO `type` (`id`, `name`, `description`, `module`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted`) VALUES
(2, 'Type 1', NULL, 'accounts', '2015-06-24 11:11:41', 1, '2015-06-24 11:11:41', NULL, 0),
(4, 'opportunity', 'opportunity', 'contacts', '2015-07-01 09:55:34', 1, '2015-07-01 15:29:13', 1, 0),
(5, 'Website', 'Website', 'projects', '2015-07-01 15:24:50', 1, '2015-07-16 09:55:48', 1, 0),
(6, 'accounts type', 'accounts type', 'accounts', '2015-07-01 15:25:26', 1, '2015-07-01 15:25:26', NULL, 0),
(7, 'Client', '', 'contacts', '2015-07-01 15:28:25', 1, '2015-07-01 15:28:25', NULL, 0),
(8, 'Web App', '', 'projects', '2015-07-16 09:57:46', 1, '2015-07-16 09:57:46', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `title` tinyint(1) DEFAULT NULL COMMENT '1=Mr, 2=Miss, 3=Mrs',
  `salt` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` datetime DEFAULT NULL,
  `department_id` int(8) unsigned DEFAULT NULL,
  `position` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `smtp_username` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `smtp_password` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `smtp_host` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `resalty_username` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `resalty_password` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_signature` text COLLATE utf8_unicode_ci,
  `sms_used` int(10) unsigned NOT NULL DEFAULT '0',
  `sms_count_start_date` date NOT NULL DEFAULT '0000-00-00',
  `monthly_sms_allowed` int(10) unsigned NOT NULL DEFAULT '0',
  `lastactivity` int(10) unsigned NOT NULL,
  `country_id` smallint(5) unsigned NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `skype` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mandrill_password` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `users_username_index` (`username`),
  KEY `users_password_index` (`password`),
  KEY `users_email_index` (`email`),
  KEY `users_remember_token_index` (`remember_token`),
  KEY `users_deleted_at_index` (`deleted_at`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=34 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `mobile`, `password`, `title`, `salt`, `remember_token`, `verified`, `disabled`, `created_at`, `updated_at`, `deleted_at`, `department_id`, `position`, `image`, `smtp_username`, `smtp_password`, `smtp_host`, `resalty_username`, `resalty_password`, `email_signature`, `sms_used`, `sms_count_start_date`, `monthly_sms_allowed`, `lastactivity`, `country_id`, `deleted`, `skype`, `mandrill_password`) VALUES
(1, 'Admin', 'admin@admin.com', '01221098447', '$2y$10$qqJpwfziULdqoeXIo2hQlO/cLXiD2FRwDTnLN5ThPwbPeSizkagve', 1, '8d8035797e1e026be3b578bfc2a03ff3', 'QsJexnsskRBp3roGRQ9WHm73A8Hk1UEkEyjFoVqvxjLZyCTx12bmrdFxSHuv', 1, 0, '2015-01-27 12:30:06', '2015-07-22 14:48:03', NULL, 5, 'Manager', '2fc77fe245cd0b4.jpg', 'gamal@think-ds.com', 'gamal123', 'bh-48.webhostbox.net', 'tds2', '9535593', '<table cellspacing="0" width="100%" cellpadding="0" class="fr-tag"><tbody><tr><td class="copyright fr-tag" align="center" height="80" valign="top" style="color: #FFF; font-family: Verdana; font-size: 10px; text-transform: uppercase; text-align: center; line-height: 20px;" bgcolor="#484845"><br>account and the account logo are registered trademarks of account <br>account - 123 Some Street, City, ST 99999. Ph +1 4 1477 89 745</td></tr></tbody></table><p class="fr-tag">_______________________________________________________________</p><p class="fr-tag">Many thanks,</p>', 184, '2015-07-09', 20, 1437583683, 1, 0, NULL, 'sOLhN2yehH4KHKHLvfNcKA');

-- --------------------------------------------------------

--
-- Table structure for table `user_account`
--

CREATE TABLE IF NOT EXISTS `user_account` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(8) unsigned DEFAULT NULL,
  `user_id` int(9) DEFAULT NULL,
  `created_by` int(8) unsigned DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_activity`
--

CREATE TABLE IF NOT EXISTS `user_activity` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `activity_id` mediumint(8) unsigned DEFAULT NULL,
  `user_id` int(9) DEFAULT NULL,
  `created_by` int(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_contact`
--

CREATE TABLE IF NOT EXISTS `user_contact` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `contact_id` int(8) unsigned DEFAULT NULL,
  `user_id` int(9) DEFAULT NULL,
  `created_by` int(8) unsigned DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_department`
--

CREATE TABLE IF NOT EXISTS `user_department` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(9) DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(9) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_project`
--

CREATE TABLE IF NOT EXISTS `user_project` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` mediumint(8) unsigned DEFAULT NULL,
  `user_id` int(9) DEFAULT NULL,
  `created_by` int(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
