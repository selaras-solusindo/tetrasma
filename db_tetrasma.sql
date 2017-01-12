-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 13, 2017 at 01:48 AM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_tetrasma`
--

-- --------------------------------------------------------

--
-- Table structure for table `audittrail`
--

CREATE TABLE IF NOT EXISTS `audittrail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL,
  `script` varchar(255) DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `table` varchar(255) DEFAULT NULL,
  `field` varchar(255) DEFAULT NULL,
  `keyvalue` longtext,
  `oldvalue` longtext,
  `newvalue` longtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=262 ;

--
-- Dumping data for table `audittrail`
--

INSERT INTO `audittrail` (`id`, `datetime`, `script`, `user`, `action`, `table`, `field`, `keyvalue`, `oldvalue`, `newvalue`) VALUES
(1, '2016-12-25 12:17:18', '/tetrasma/login.php', 'admin', 'login', '::1', '', '', '', ''),
(2, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(28, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(29, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(30, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(31, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(32, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(33, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(34, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(35, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(36, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(37, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(38, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(39, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(40, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(41, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(42, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(43, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(45, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(46, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(47, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(48, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(49, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(50, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(51, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(52, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(53, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(54, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(55, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(56, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(57, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(58, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(59, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(60, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(61, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(62, '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(63, '2016-12-29 22:20:49', '/tetrasma/logout.php', 'admin', 'logout', '::1', '', '', '', ''),
(64, '2016-12-29 22:20:56', '/tetrasma/login.php', 'admin', 'login', '::1', '', '', '', ''),
(65, '2016-12-30 16:46:49', '/tetrasma/login.php', 'admin', 'login', '::1', '', '', '', ''),
(66, '2016-12-31 11:56:05', '/tetrasma/tb_level1add.php', 'admin', 'A', 'tb_level1', 'level1_no', '2', '', '2'),
(67, '2016-12-31 11:56:05', '/tetrasma/tb_level1add.php', 'admin', 'A', 'tb_level1', 'level1_nama', '2', '', 'Pasiva'),
(68, '2016-12-31 11:56:05', '/tetrasma/tb_level1add.php', 'admin', 'A', 'tb_level1', 'level1_id', '2', '', '2'),
(69, '2016-12-31 14:20:39', '/tetrasma/logout.php', 'admin', 'logout', '::1', '', '', '', ''),
(70, '2017-01-01 11:39:40', '/tetrasma/login.php', 'admin', 'login', '::1', '', '', '', ''),
(71, '2017-01-01 15:12:37', '/tetrasma/login.php', 'admin', 'login', '::1', '', '', '', ''),
(72, '2017-01-01 15:31:49', '/tetrasma/login.php', 'admin', 'login', '::1', '', '', '', ''),
(73, '2017-01-01 15:36:55', '/tetrasma/logout.php', 'admin', 'logout', '::1', '', '', '', ''),
(74, '2017-01-01 15:36:58', '/tetrasma/login.php', 'admin', 'login', '::1', '', '', '', ''),
(75, '2017-01-05 02:18:05', '/tetrasma/login.php', 'admin', 'login', '::1', '', '', '', ''),
(76, '2017-01-05 13:19:43', '/tetrasma/login.php', 'admin', 'login', '::1', '', '', '', ''),
(77, '2017-01-06 01:52:10', '/tetrasma/login.php', 'admin', 'login', '::1', '', '', '', ''),
(78, '2017-01-06 04:27:59', '/tetrasma/tb_jurnaladd.php', 'admin', '*** Batch insert begin ***', 'tb_detail', '', '', '', ''),
(79, '2017-01-06 04:27:59', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'akun_id', '1', '', '2'),
(80, '2017-01-06 04:27:59', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'nilai', '1', '', '10000'),
(81, '2017-01-06 04:27:59', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'anggota_id', '1', '', NULL),
(82, '2017-01-06 04:27:59', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'jurnal_id', '1', '', '1'),
(83, '2017-01-06 04:27:59', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'detail_id', '1', '', '1'),
(84, '2017-01-06 04:27:59', '/tetrasma/tb_jurnaladd.php', 'admin', '*** Batch insert successful ***', 'tb_detail', '', '', '', ''),
(85, '2017-01-06 04:27:59', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_jurnal', 'jenis_jurnal', '1', '', '0'),
(86, '2017-01-06 04:27:59', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_jurnal', 'no_bukti', '1', '', 'KM201701001'),
(87, '2017-01-06 04:27:59', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_jurnal', 'tgl', '1', '', '2017-01-06'),
(88, '2017-01-06 04:27:59', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_jurnal', 'ket', '1', '', 'tes'),
(89, '2017-01-06 04:27:59', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_jurnal', 'jurnal_id', '1', '', '1'),
(90, '2017-01-06 05:44:07', '/tetrasma/tb_jurnaladd.php', 'admin', '*** Batch insert begin ***', 'tb_detail', '', '', '', ''),
(91, '2017-01-06 05:44:07', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'akun_id', '1', '', '2'),
(92, '2017-01-06 05:44:07', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'nilai', '1', '', '11000'),
(93, '2017-01-06 05:44:07', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'anggota_id', '1', '', '5'),
(94, '2017-01-06 05:44:07', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'jurnal_id', '1', '', '1'),
(95, '2017-01-06 05:44:07', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'detail_id', '1', '', '1'),
(96, '2017-01-06 05:44:07', '/tetrasma/tb_jurnaladd.php', 'admin', '*** Batch insert successful ***', 'tb_detail', '', '', '', ''),
(97, '2017-01-06 05:44:07', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_jurnal', 'jenis_jurnal', '1', '', 'KM'),
(98, '2017-01-06 05:44:07', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_jurnal', 'no_bukti', '1', '', 'KM201701001'),
(99, '2017-01-06 05:44:07', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_jurnal', 'tgl', '1', '', '2017-01-06'),
(100, '2017-01-06 05:44:07', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_jurnal', 'ket', '1', '', 'tes1'),
(101, '2017-01-06 05:44:07', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_jurnal', 'jurnal_id', '1', '', '1'),
(102, '2017-01-06 05:48:32', '/tetrasma/tb_jurnaledit.php', 'admin', '*** Batch update begin ***', 'tb_detail', '', '', '', ''),
(103, '2017-01-06 05:48:32', '/tetrasma/tb_jurnaledit.php', 'admin', 'U', 'tb_detail', 'nilai', '1', '11000', '11500'),
(104, '2017-01-06 05:48:32', '/tetrasma/tb_jurnaledit.php', 'admin', '*** Batch update successful ***', 'tb_detail', '', '', '', ''),
(105, '2017-01-06 08:43:35', '/tetrasma/login.php', 'admin', 'login', '::1', '', '', '', ''),
(106, '2017-01-06 09:06:43', '/tetrasma/tb_jurnaladd.php', 'admin', '*** Batch insert begin ***', 'tb_detail', '', '', '', ''),
(107, '2017-01-06 09:06:43', '/tetrasma/tb_jurnaladd.php', 'admin', '*** Batch insert rollback ***', 'tb_detail', '', '', '', ''),
(108, '2017-01-06 09:07:01', '/tetrasma/tb_jurnaladd.php', 'admin', '*** Batch insert begin ***', 'tb_detail', '', '', '', ''),
(109, '2017-01-06 09:07:01', '/tetrasma/tb_jurnaladd.php', 'admin', '*** Batch insert rollback ***', 'tb_detail', '', '', '', ''),
(110, '2017-01-06 09:11:23', '/tetrasma/tb_jurnaladd.php', 'admin', '*** Batch insert begin ***', 'tb_detail', '', '', '', ''),
(111, '2017-01-06 09:11:23', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'akun_id', '1', '', '2'),
(112, '2017-01-06 09:11:23', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'nilai', '1', '', '13000'),
(113, '2017-01-06 09:11:23', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'anggota_id', '1', '', NULL),
(114, '2017-01-06 09:11:23', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'jurnal_id', '1', '', '1'),
(115, '2017-01-06 09:11:23', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'detail_id', '1', '', '1'),
(116, '2017-01-06 09:11:23', '/tetrasma/tb_jurnaladd.php', 'admin', '*** Batch insert successful ***', 'tb_detail', '', '', '', ''),
(117, '2017-01-06 09:11:23', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_jurnal', 'jenis_jurnal', '1', '', 'KM'),
(118, '2017-01-06 09:11:23', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_jurnal', 'no_bukti', '1', '', 'KM201701001'),
(119, '2017-01-06 09:11:23', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_jurnal', 'tgl', '1', '', '2017-01-06'),
(120, '2017-01-06 09:11:23', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_jurnal', 'ket', '1', '', 'tes3'),
(121, '2017-01-06 09:11:23', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_jurnal', 'jurnal_id', '1', '', '1'),
(122, '2017-01-06 09:13:47', '/tetrasma/tb_jurnaladd.php', 'admin', '*** Batch insert begin ***', 'tb_detail', '', '', '', ''),
(123, '2017-01-06 09:13:47', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'akun_id', '2', '', '2'),
(124, '2017-01-06 09:13:47', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'nilai', '2', '', '13500'),
(125, '2017-01-06 09:13:47', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'anggota_id', '2', '', NULL),
(126, '2017-01-06 09:13:47', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'jurnal_id', '2', '', '2'),
(127, '2017-01-06 09:13:47', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'detail_id', '2', '', '2'),
(128, '2017-01-06 09:13:47', '/tetrasma/tb_jurnaladd.php', 'admin', '*** Batch insert successful ***', 'tb_detail', '', '', '', ''),
(129, '2017-01-06 09:13:47', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_jurnal', 'jenis_jurnal', '2', '', 'KM'),
(130, '2017-01-06 09:13:47', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_jurnal', 'no_bukti', '2', '', 'KM201701002'),
(131, '2017-01-06 09:13:47', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_jurnal', 'tgl', '2', '', '2017-01-06'),
(132, '2017-01-06 09:13:47', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_jurnal', 'ket', '2', '', 'tes4'),
(133, '2017-01-06 09:13:47', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_jurnal', 'jurnal_id', '2', '', '2'),
(134, '2017-01-06 09:49:07', '/tetrasma/tb_jurnaladd.php', 'admin', '*** Batch insert begin ***', 'tb_detail', '', '', '', ''),
(135, '2017-01-06 09:49:07', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'akun_id', '3', '', '2'),
(136, '2017-01-06 09:49:07', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'nilai', '3', '', '14000'),
(137, '2017-01-06 09:49:07', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'anggota_id', '3', '', NULL),
(138, '2017-01-06 09:49:07', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'jurnal_id', '3', '', '3'),
(139, '2017-01-06 09:49:07', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'detail_id', '3', '', '3'),
(140, '2017-01-06 09:49:07', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'akun_id', '5', '', '2'),
(141, '2017-01-06 09:49:07', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'nilai', '5', '', '14500'),
(142, '2017-01-06 09:49:07', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'anggota_id', '5', '', NULL),
(143, '2017-01-06 09:49:07', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'jurnal_id', '5', '', '3'),
(144, '2017-01-06 09:49:07', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'detail_id', '5', '', '5'),
(145, '2017-01-06 09:49:07', '/tetrasma/tb_jurnaladd.php', 'admin', '*** Batch insert successful ***', 'tb_detail', '', '', '', ''),
(146, '2017-01-06 09:49:07', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_jurnal', 'jenis_jurnal', '3', '', 'KM'),
(147, '2017-01-06 09:49:07', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_jurnal', 'no_bukti', '3', '', 'KM201701003'),
(148, '2017-01-06 09:49:07', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_jurnal', 'tgl', '3', '', '2017-01-06'),
(149, '2017-01-06 09:49:07', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_jurnal', 'ket', '3', '', 'tes5'),
(150, '2017-01-06 09:49:07', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_jurnal', 'jurnal_id', '3', '', '3'),
(151, '2017-01-06 10:48:45', '/tetrasma/login.php', 'admin', 'login', '::1', '', '', '', ''),
(152, '2017-01-06 15:33:25', '/tetrasma/logout.php', 'admin', 'logout', '::1', '', '', '', ''),
(153, '2017-01-06 15:33:30', '/tetrasma/login.php', 'admin', 'login', '::1', '', '', '', ''),
(154, '2017-01-07 00:18:59', '/tetrasma/login.php', 'admin', 'login', '::1', '', '', '', ''),
(155, '2017-01-07 01:59:06', '/tetrasma/tb_level4edit.php', 'admin', 'U', 'tb_level4', 'jurnal', '1', '0', '1'),
(156, '2017-01-07 03:10:13', '/tetrasma/tb_level4edit.php', 'admin', 'U', 'tb_level4', 'jurnal_kode', '1', 'K', NULL),
(157, '2017-01-07 03:10:26', '/tetrasma/tb_level4edit.php', 'admin', 'U', 'tb_level4', 'jurnal_kode', '2', 'K', NULL),
(158, '2017-01-07 03:11:00', '/tetrasma/tb_level4edit.php', 'admin', 'U', 'tb_level4', 'jurnal_kode', '1', NULL, 'K,B'),
(159, '2017-01-07 03:11:23', '/tetrasma/tb_level4edit.php', 'admin', 'U', 'tb_level4', 'jurnal_kode', '2', NULL, 'B'),
(160, '2017-01-07 05:26:57', '/tetrasma/login.php', 'admin', 'login', '::1', '', '', '', ''),
(161, '2017-01-07 13:49:44', '/tetrasma/login.php', 'admin', 'login', '::1', '', '', '', ''),
(162, '2017-01-07 18:05:38', '/tetrasma/login.php', 'admin', 'login', '::1', '', '', '', ''),
(163, '2017-01-07 18:06:07', '/tetrasma/logout.php', 'admin', 'logout', '::1', '', '', '', ''),
(164, '2017-01-07 18:06:10', '/tetrasma/login.php', 'admin', 'login', '::1', '', '', '', ''),
(165, '2017-01-07 18:17:28', '/tetrasma/tb_level4edit.php', 'admin', 'U', 'tb_level4', 'jurnal', '2', '0', '1'),
(166, '2017-01-07 18:17:28', '/tetrasma/tb_level4edit.php', 'admin', 'U', 'tb_level4', 'jurnal_kode', '2', NULL, 'B'),
(167, '2017-01-07 18:31:32', '/tetrasma/tb_jurnaladd.php', 'admin', '*** Batch insert begin ***', 'tb_detail', '', '', '', ''),
(168, '2017-01-07 18:31:32', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'akun_id', '7', '', '2'),
(169, '2017-01-07 18:31:32', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'nilai', '7', '', '15000'),
(170, '2017-01-07 18:31:32', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'anggota_id', '7', '', NULL),
(171, '2017-01-07 18:31:32', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'jurnal_id', '7', '', '4'),
(172, '2017-01-07 18:31:32', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'detail_id', '7', '', '7'),
(173, '2017-01-07 18:31:32', '/tetrasma/tb_jurnaladd.php', 'admin', '*** Batch insert successful ***', 'tb_detail', '', '', '', ''),
(174, '2017-01-07 18:31:32', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_jurnal', 'akun_id', '4', '', '1'),
(175, '2017-01-07 18:31:32', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_jurnal', 'jenis_jurnal', '4', '', 'M'),
(176, '2017-01-07 18:31:32', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_jurnal', 'no_bukti', '4', '', 'KM201701004'),
(177, '2017-01-07 18:31:32', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_jurnal', 'tgl', '4', '', '2017-01-08'),
(178, '2017-01-07 18:31:32', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_jurnal', 'ket', '4', '', 'tes6'),
(179, '2017-01-07 18:31:32', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_jurnal', 'jurnal_id', '4', '', '4'),
(180, '2017-01-07 18:38:10', '/tetrasma/tb_jurnaladd.php', 'admin', '*** Batch insert begin ***', 'tb_detail', '', '', '', ''),
(181, '2017-01-07 18:38:10', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'akun_id', '8', '', '2'),
(182, '2017-01-07 18:38:10', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'nilai', '8', '', '15500'),
(183, '2017-01-07 18:38:10', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'anggota_id', '8', '', NULL),
(184, '2017-01-07 18:38:10', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'jurnal_id', '8', '', '5'),
(185, '2017-01-07 18:38:10', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'detail_id', '8', '', '8'),
(186, '2017-01-07 18:38:11', '/tetrasma/tb_jurnaladd.php', 'admin', '*** Batch insert successful ***', 'tb_detail', '', '', '', ''),
(187, '2017-01-07 18:38:11', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_jurnal', 'akun_id', '5', '', '1'),
(188, '2017-01-07 18:38:11', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_jurnal', 'jenis_jurnal', '5', '', 'M'),
(189, '2017-01-07 18:38:11', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_jurnal', 'no_bukti', '5', '', 'KM201701005'),
(190, '2017-01-07 18:38:11', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_jurnal', 'tgl', '5', '', '2017-01-08'),
(191, '2017-01-07 18:38:11', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_jurnal', 'ket', '5', '', 'tes7'),
(192, '2017-01-07 18:38:11', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_jurnal', 'jurnal_id', '5', '', '5'),
(193, '2017-01-07 18:39:27', '/tetrasma/tb_jurnaladd.php', 'admin', '*** Batch insert begin ***', 'tb_detail', '', '', '', ''),
(194, '2017-01-07 18:39:27', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'akun_id', '9', '', '1'),
(195, '2017-01-07 18:39:27', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'nilai', '9', '', '16000'),
(196, '2017-01-07 18:39:27', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'anggota_id', '9', '', NULL),
(197, '2017-01-07 18:39:27', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'jurnal_id', '9', '', '6'),
(198, '2017-01-07 18:39:27', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'detail_id', '9', '', '9'),
(199, '2017-01-07 18:39:27', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'akun_id', '10', '', '1'),
(200, '2017-01-07 18:39:27', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'nilai', '10', '', '16500'),
(201, '2017-01-07 18:39:27', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'anggota_id', '10', '', NULL),
(202, '2017-01-07 18:39:27', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'jurnal_id', '10', '', '6'),
(203, '2017-01-07 18:39:27', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'detail_id', '10', '', '10'),
(204, '2017-01-07 18:39:27', '/tetrasma/tb_jurnaladd.php', 'admin', '*** Batch insert successful ***', 'tb_detail', '', '', '', ''),
(205, '2017-01-07 18:39:27', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_jurnal', 'akun_id', '6', '', '2'),
(206, '2017-01-07 18:39:27', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_jurnal', 'jenis_jurnal', '6', '', 'M'),
(207, '2017-01-07 18:39:27', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_jurnal', 'no_bukti', '6', '', 'BM201701001'),
(208, '2017-01-07 18:39:27', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_jurnal', 'tgl', '6', '', '2017-01-08'),
(209, '2017-01-07 18:39:27', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_jurnal', 'ket', '6', '', 'tes8'),
(210, '2017-01-07 18:39:27', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_jurnal', 'jurnal_id', '6', '', '6'),
(211, '2017-01-08 15:17:21', '/tetrasma/login.php', 'admin', 'login', '::1', '', '', '', ''),
(212, '2017-01-08 15:44:19', '/tetrasma/tb_level4edit.php', 'admin', 'U', 'tb_level4', 'jurnal', '1', '0', '1'),
(213, '2017-01-08 15:44:19', '/tetrasma/tb_level4edit.php', 'admin', 'U', 'tb_level4', 'jurnal_kode', '1', NULL, 'K'),
(214, '2017-01-08 15:44:28', '/tetrasma/tb_level4edit.php', 'admin', 'U', 'tb_level4', 'jurnal', '2', '0', '1'),
(215, '2017-01-08 15:44:28', '/tetrasma/tb_level4edit.php', 'admin', 'U', 'tb_level4', 'jurnal_kode', '2', NULL, 'B'),
(216, '2017-01-08 15:44:58', '/tetrasma/tb_level4edit.php', 'admin', 'U', 'tb_level4', 'jurnal', '3', '0', '1'),
(217, '2017-01-08 15:44:58', '/tetrasma/tb_level4edit.php', 'admin', 'U', 'tb_level4', 'jurnal_kode', '3', NULL, 'B'),
(218, '2017-01-08 17:40:30', '/tetrasma/login.php', 'admin', 'login', '::1', '', '', '', ''),
(219, '2017-01-08 19:17:44', '/tetrasma/tb_jurnaladd.php', 'admin', '*** Batch insert begin ***', 'tb_detail', '', '', '', ''),
(220, '2017-01-08 19:17:44', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'akun_id', '1', '', '25'),
(221, '2017-01-08 19:17:44', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'nilai', '1', '', '5000'),
(222, '2017-01-08 19:17:44', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'anggota_id', '1', '', '4'),
(223, '2017-01-08 19:17:44', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'jurnal_id', '1', '', '1'),
(224, '2017-01-08 19:17:44', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'detail_id', '1', '', '1'),
(225, '2017-01-08 19:17:44', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'akun_id', '2', '', '25'),
(226, '2017-01-08 19:17:44', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'nilai', '2', '', '7500'),
(227, '2017-01-08 19:17:44', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'anggota_id', '2', '', '5'),
(228, '2017-01-08 19:17:44', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'jurnal_id', '2', '', '1'),
(229, '2017-01-08 19:17:44', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_detail', 'detail_id', '2', '', '2'),
(230, '2017-01-08 19:17:45', '/tetrasma/tb_jurnaladd.php', 'admin', '*** Batch insert successful ***', 'tb_detail', '', '', '', ''),
(231, '2017-01-08 19:17:45', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_jurnal', 'akun_id', '1', '', '1'),
(232, '2017-01-08 19:17:45', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_jurnal', 'jenis_jurnal', '1', '', 'M'),
(233, '2017-01-08 19:17:45', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_jurnal', 'no_bukti', '1', '', 'KM201701001'),
(234, '2017-01-08 19:17:45', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_jurnal', 'tgl', '1', '', '2017-01-09'),
(235, '2017-01-08 19:17:45', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_jurnal', 'ket', '1', '', 'coba'),
(236, '2017-01-08 19:17:45', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_jurnal', 'nilai', '1', '', '0'),
(237, '2017-01-08 19:17:45', '/tetrasma/tb_jurnaladd.php', 'admin', 'A', 'tb_jurnal', 'jurnal_id', '1', '', '1'),
(238, '2017-01-08 19:18:23', '/tetrasma/tb_jurnaledit.php', 'admin', '*** Batch update begin ***', 'tb_detail', '', '', '', ''),
(239, '2017-01-08 19:18:23', '/tetrasma/tb_jurnaledit.php', 'admin', '*** Batch delete begin ***', 'tb_detail', '', '', '', ''),
(240, '2017-01-08 19:18:23', '/tetrasma/tb_jurnaledit.php', 'admin', 'D', 'tb_detail', 'detail_id', '1', '1', ''),
(241, '2017-01-08 19:18:23', '/tetrasma/tb_jurnaledit.php', 'admin', 'D', 'tb_detail', 'jurnal_id', '1', '1', ''),
(242, '2017-01-08 19:18:23', '/tetrasma/tb_jurnaledit.php', 'admin', 'D', 'tb_detail', 'akun_id', '1', '25', ''),
(243, '2017-01-08 19:18:23', '/tetrasma/tb_jurnaledit.php', 'admin', 'D', 'tb_detail', 'dk', '1', '1', ''),
(244, '2017-01-08 19:18:23', '/tetrasma/tb_jurnaledit.php', 'admin', 'D', 'tb_detail', 'nilai', '1', '5000', ''),
(245, '2017-01-08 19:18:23', '/tetrasma/tb_jurnaledit.php', 'admin', 'D', 'tb_detail', 'anggota_id', '1', '4', ''),
(246, '2017-01-08 19:18:24', '/tetrasma/tb_jurnaledit.php', 'admin', '*** Batch delete successful ***', 'tb_detail', '', '', '', ''),
(247, '2017-01-08 19:18:24', '/tetrasma/tb_jurnaledit.php', 'admin', '*** Batch update successful ***', 'tb_detail', '', '', '', ''),
(248, '2017-01-08 19:18:43', '/tetrasma/tb_jurnaledit.php', 'admin', '*** Batch update begin ***', 'tb_detail', '', '', '', ''),
(249, '2017-01-08 19:18:43', '/tetrasma/tb_jurnaledit.php', 'admin', '*** Batch delete begin ***', 'tb_detail', '', '', '', ''),
(250, '2017-01-08 19:18:43', '/tetrasma/tb_jurnaledit.php', 'admin', 'D', 'tb_detail', 'detail_id', '2', '2', ''),
(251, '2017-01-08 19:18:43', '/tetrasma/tb_jurnaledit.php', 'admin', 'D', 'tb_detail', 'jurnal_id', '2', '1', ''),
(252, '2017-01-08 19:18:43', '/tetrasma/tb_jurnaledit.php', 'admin', 'D', 'tb_detail', 'akun_id', '2', '25', ''),
(253, '2017-01-08 19:18:43', '/tetrasma/tb_jurnaledit.php', 'admin', 'D', 'tb_detail', 'dk', '2', '1', ''),
(254, '2017-01-08 19:18:43', '/tetrasma/tb_jurnaledit.php', 'admin', 'D', 'tb_detail', 'nilai', '2', '7500', ''),
(255, '2017-01-08 19:18:43', '/tetrasma/tb_jurnaledit.php', 'admin', 'D', 'tb_detail', 'anggota_id', '2', '5', ''),
(256, '2017-01-08 19:18:43', '/tetrasma/tb_jurnaledit.php', 'admin', '*** Batch delete successful ***', 'tb_detail', '', '', '', ''),
(257, '2017-01-08 19:18:43', '/tetrasma/tb_jurnaledit.php', 'admin', '*** Batch update successful ***', 'tb_detail', '', '', '', ''),
(258, '2017-01-12 10:39:37', '/tetrasma/login.php', 'admin', 'login', '::1', '', '', '', ''),
(259, '2017-01-12 14:30:36', '/tetrasma/logout.php', 'admin', 'logout', '::1', '', '', '', ''),
(260, '2017-01-12 15:08:23', '/tetrasma/login.php', 'admin', 'login', '::1', '', '', '', ''),
(261, '2017-01-12 18:41:37', '/tetrasma/login.php', 'admin', 'login', '::1', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tb_anggota`
--

CREATE TABLE IF NOT EXISTS `tb_anggota` (
  `anggota_id` int(11) NOT NULL AUTO_INCREMENT,
  `no_anggota` varchar(25) DEFAULT NULL,
  `nama` varchar(25) DEFAULT NULL,
  `tgl_masuk` date DEFAULT NULL,
  `alamat` varchar(50) DEFAULT NULL,
  `kota` varchar(25) DEFAULT NULL,
  `no_telp` varchar(25) DEFAULT NULL,
  `pekerjaan` varchar(25) DEFAULT NULL,
  `jns_pengenal` varchar(5) DEFAULT NULL,
  `no_pengenal` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`anggota_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=254 ;

--
-- Dumping data for table `tb_anggota`
--

INSERT INTO `tb_anggota` (`anggota_id`, `no_anggota`, `nama`, `tgl_masuk`, `alamat`, `kota`, `no_telp`, `pekerjaan`, `jns_pengenal`, `no_pengenal`) VALUES
(4, '1.01.10.2009', 'Sigit Warsito', '0000-00-00', 'jl.Gunung Sari Indah YY-6 Sby', 'Surabaya', 'O81553791188', 'IPT REA KALTIM PLANTATION', 'KTP', 'x'),
(5, '2.01.10.2009', 'Resmi Setyaningsih', '0000-00-00', 'JL.Griya Pesona Asri Blok C-50 Sby', 'Surabaya', 'O81331501861', 'Guru SMA 4, Sby', 'KTP', 'x'),
(6, '3.03.10.2009', 'Wenny Williarso', '0000-00-00', 'Puri Taman Asri C-14 Sby', 'Surabaya', 'O318275800', 'Bank Indonesia', 'KTP', 'x'),
(7, '4.02.10.2009', 'Ira Wati', '0000-00-00', 'Puri Taman Asri C-14 Sby', 'Surabaya', 'O318275800', 'IRT', 'KTP', 'x'),
(8, '5.03.11.2009', 'Agus Laswiyana', '0000-00-00', 'Perum Permata Pekayon Bolk i-10 bekasi', 'Jakarta', 'O8131995411', 'Wiraswasta', 'KTP', 'x'),
(9, '6.03.10.2009', 'Gunawan Wibisono', '0000-00-00', 'x', 'Jakarta', 'X', 'X', 'KTP', 'x'),
(10, '7.09.10.2009', 'Endang Rahayu', '0000-00-00', 'Jl Tanjung Pura RT 28 No 2 Balikpapan', 'Balikpapan', 'O811530517', 'PT.Chevron', 'KTP', 'x'),
(11, '8.03.10.2009', 'Edi Suratman', '0000-00-00', 'x', 'Jakarta', 'X', 'X', 'KTP', 'x'),
(12, '9.01.10.2009', 'Wiken Sukesi', '0000-00-00', 'Jl Pandugo Timur 8/18', 'Surabaya', 'O318705211', 'Swasta', 'KTP', 'x'),
(13, '10.03.10.2009', 'Ibnu Perabowo', '0000-00-00', 'x', 'Jakarta', 'X', 'X', 'KTP', 'x'),
(14, '11.01.10.2009', 'Setyari Pangastuti', '0000-00-00', 'Jl. Kutisari Indah Selatan I/135', 'Sidoarjo', 'O318435247', 'PNS PT Telkom', 'KTP', 'x'),
(15, '12.02.10.2009', 'Didik Widianto', '0000-00-00', 'Jl Kawi 9 Pepelegi Indah', 'Surabaya', 'O318537791', 'PT PAL Indonesia', 'KTP', 'x'),
(16, '13.03.10.2009', 'Husain', '0000-00-00', 'Komp. DepKop Jl. Gas Alam Blok B/4 Cimanggis Depok', 'Jakarta', 'O218732559', 'Kementrian Negkop', 'KTP', 'x'),
(17, '14.03.10.2009', 'Didi Hasan Putra', '0000-00-00', 'Jl Ciater III/12 Puri Cinere Depok', 'Jakarta', 'O217543941', 'Perus Jawa Bali', 'KTP', 'x'),
(18, '15.03.10.2009', 'Ari Priyo Widagdo', '0000-00-00', 'Kav Ardhy Karya No 8 RT 5/2 Rangkapan Jaya Baru-Pa', 'Jakarta', 'O811412060', 'PT Adhi Karya (Persero) T', 'KTP', 'x'),
(19, '16.03.10.2009', 'Miko', '0000-00-00', 'Jl Pangadegan Utara 32Cikoko Paneoran, Jakarta', 'Jakarta', 'X', 'X', 'KTP', 'x'),
(20, '17.03.10.2009', 'Very', '0000-00-00', 'x', 'Jakarta', 'X', 'X', 'KTP', 'x'),
(21, '18.06.10.2009', 'Udi Triastoto', '0000-00-00', 'Kom Mekar Baru F1 Jl Jabaru II Ciomas Bogor', 'Bogor', 'O8881725162', 'Pusdiklat Kehutanan', 'KTP', 'x'),
(22, '19.03.10.2009', 'Niken', '0000-00-00', 'Barata Tama II/152 Karang Tengah Tangerang', 'Jakarta', 'O8129554240', 'X', 'KTP', 'x'),
(23, '20.03.10.2009', 'Ani Herawati', '0000-00-00', 'Jl Anggrek Garuda Blok E19 Slipi Jakarta Barat', 'Jakarta', 'O816816247', 'X', 'KTP', 'x'),
(24, '21.01.10.2009', 'Chulwatun Chasanah', '0000-00-00', 'Jl Simorejo XXI/29 A', 'Surabaya', 'O811332460', 'Guru SMAN 4 Sby', 'KTP', 'x'),
(25, '22.01.10.2009', 'Dihan', '0000-00-00', 'Jl Kedung Pengkol I/53', 'Surabaya', 'O81357894775', 'Guru SMAN 4 Sby', 'KTP', 'x'),
(26, '23.01.12.2009', 'Suhartini', '0000-00-00', 'Donokerto 8/9', 'Surabaya', '77756506', 'Guru SMAN 4 Sby', 'KTP', 'x'),
(27, '24.01.11.2009', 'Sri Mulyani', '0000-00-00', 'Jl Rungkut Mapan Barat VI / BF-04', 'Surabaya', 'O81330169188', 'Swasta', 'KTP', 'x'),
(28, '25.04.12.2009', 'Bambang Eko', '0000-00-00', 'Jl Taman Raden Intan 512 Blimbing Malang', 'Malang', 'X', 'DOSEN', 'KTP', 'x'),
(29, '26.01.01.2010', 'Setyo Adi Pratiwi', '0000-00-00', 'Jl Rungkut Asri Timur III/26', 'Surabaya', 'O8123532195', 'Wirausaha', 'KTP', 'x'),
(30, '27.01.01.2010', 'Partiningsih', '0000-00-00', 'Jl Tambang Boyo 24', 'Surabaya', 'O81703411141', 'TU SMAN 4 Sby', 'KTP', 'x'),
(31, '28.01.12.2009', 'Triastiti Indyah', '0000-00-00', 'Jl Ngagel Kebonsari 17', 'Surabaya', '78092445', 'Swasta', 'KTP', 'x'),
(32, '29.01.01.2010', 'Diana Tri Bandjaran Sar', '0000-00-00', 'Jl Pandugo Baru XII/86 U-3', 'Surabaya', 'O811377925', 'PNS PT Telkom', 'KTP', 'x'),
(33, '30.01.01.2010', 'Haryono', '0000-00-00', 'Jl Bronggalan Sawah I/16', 'Surabaya', 'O81332244774', 'Pegawai Negri', 'KTP', 'x'),
(34, '31.01.01.2010', 'Sri Eko Sri Eko Wahjunawa', '0000-00-00', 'l. Gunung Sari Indah YY - 6', 'Surabaya', 'O8155110701', 'Karyawan Bank Arta Graha', 'KTP', 'x'),
(35, '32.01.01.2010', 'Diyah Pursianti', '0000-00-00', 'Jl. Kertajaya VI A/1', 'Surabaya', 'O8123267651', 'PNS', 'KTP', 'x'),
(36, '33.04.01.2010', 'Wahyu Arbandini', '0000-00-00', 'Jl. Kebonsari Tengah 21 B', 'Surabaya', 'O811307113', 'Swasta', 'KTP', 'x'),
(37, '34.01.02.2010', 'Suyitno', '0000-00-00', 'Jl. Baruk Utara 7/4  B-112', 'Surabaya', 'O81615061161', 'Wiraswasta', 'KTP', 'x'),
(38, '35.01.02.2010', 'Sunu Wahjoto', '0000-00-00', 'Jl. Medokan Asri Utara IX/29', 'Surabaya', 'O811319068', 'Swasta', 'KTP', 'x'),
(39, '36.01.02.2010', 'Agung Pranoto', '0000-00-00', 'Perum IKIP E 186, Gunung Anyar', 'Surabaya', 'O318705309', 'Wiraswasta', 'KTP', 'x'),
(40, '37.01.01.2010', 'Rini Zoya Tambuwan', '2031-01-20', 'Perum Sakura Regency G/18', 'Surabaya', 'O3172022338', 'Swasta', 'KTP', 'x'),
(41, '38.02.02.2010', 'Etty Agustina', '0000-00-00', 'Jl. Delima 16 RT 07 RW 9 Wage', 'Sidoarjo', 'O8123529351', 'PNS', 'KTP', 'x'),
(42, '39.01.02.2010', 'Sayida', '0000-00-00', 'Jl. Bendul Merisi 3/10', 'Surabaya', 'O81230767773', 'PNS', 'KTP', 'x'),
(43, '40.02.02.2010', 'Kariyati', '0000-00-00', 'jl. Bluru Permai CM - 24', 'Sidoarjo', 'O85257476464', 'PNS', 'KTP', 'x'),
(44, '41.02.02.2010', 'Yayuk Sukaryati', '0000-00-00', 'Jl. Simowali Indah D/24 RT8 RW4', 'Sidoarjo', 'O81330153575', 'PNS', 'KTP', 'x'),
(45, '42.01.03.2010', 'Rus Elok Trihardini', '0000-00-00', 'l. Palem Selatan II MB - 32', 'Surabaya', 'O85731381296', 'Swasta', 'KTP', 'x'),
(46, '43.01.03.2010', 'Nur Chahasah', '0000-00-00', 'Jl. Grudo V/23 A', 'Surabaya', 'O315612638', 'PNS', 'KTP', 'x'),
(47, '44.02.03.2010', 'Kuntari Prasetyaningsih', '0000-00-00', 'Jl. Dewi Sartika Timur III/J15 Makarya Binangun', 'Sidoarjo', 'O318542518', 'Swasta', 'KTP', 'x'),
(48, '45.01.03.2010', 'Dina Apriliana', '0000-00-00', 'Jl. Pakis Tirtosari 9/1B', 'Surabaya', 'O81332314450', 'Wiraswasta', 'KTP', 'x'),
(49, '46.01.03.2010', 'Endang Sawitri', '0000-00-00', 'Jl. Candisari no.2', 'Surabaya', 'O315920747', 'Swasta', 'KTP', 'x'),
(50, '48.01.03.2010', 'Sujiati', '0000-00-00', 'Jl. Banyu Urip Kidul 10 - D/15', 'Surabaya', 'O8121056143', 'PNS', 'KTP', 'x'),
(51, '49.01.03.2010', 'Rustianti', '0000-00-00', 'Jl. Barata Jaya III/8', 'Surabaya', 'O8819012957', 'IRT', 'KTP', 'x'),
(52, '50.01.03.2010', 'Anastassia Duci.M', '0000-00-00', 'Jl. Klampis Sacharosa no. 3', 'Surabaya', 'O8121655566', 'IRT', 'KTP', 'x'),
(53, '51.01.03.2010', 'Djasito', '0000-00-00', 'Jl. Kalibutuh no.5', 'Surabaya', 'O811310882', 'Wiraswasta', 'KTP', 'x'),
(54, '52.01.03.2010', 'Agus Judiantara', '0000-00-00', 'Jl. Plampitan X/4', 'Surabaya', 'O85730204839', 'Swasta', 'KTP', 'x'),
(55, '53.02.03.2010', 'Riza Ellyza Hikmah', '0000-00-00', 'Jl. Wadungasih RT 14, RW 04', 'Sidoarjo', 'O3178089362', 'Wiraswasta', 'KTP', 'x'),
(56, '54.01.03.2010', 'Sumiati', '0000-00-00', 'Jl. Kedung Klinter 4/64-66', 'Surabaya', 'X', 'Swasta', 'KTP', 'x'),
(57, '55.01.03.2010', 'Sri Widodo Sayekti', '0000-00-00', 'Kedung Klinter 4/64', 'Surabaya', 'O87852185200', 'IRT', 'KTP', 'x'),
(58, '56.01.03.2010', 'Christina Ernaningsih', '0000-00-00', 'Jl. Candi Lontar Tengah II/43B/10', 'Surabaya', 'O81803297143', 'Swasta', 'KTP', 'x'),
(59, '57.01.03.2010', 'Pamahayu Pramesti', '0000-00-00', 'Jl. Pandugo Timur 8/18 C-36', 'Surabaya', 'O85624098423', 'PNS', 'KTP', 'x'),
(60, '58.02.04.2010', 'Doddy', '0000-00-00', 'Jl. Delima 15 RT 07 RW 08, Taman', 'Surabaya', 'X', 'Swasta', 'KTP', 'x'),
(61, '59.01.03.2010', 'No Name', '0000-00-00', 'x', 'X', 'X', 'X', 'KTP', 'x'),
(62, '60.01.04.2010', 'Evi Julianti', '0000-00-00', 'Jl. Jemur Wonosari I/19', 'Surabaya', 'O3171826326', 'Swasta', 'KTP', 'x'),
(63, '61.01.03.2010', 'Paguyuban Tetrasma', '0000-00-00', 'Jl. Juwingan 26', 'X', 'X', 'X', 'KTP', 'x'),
(64, '62.02.04.2010', 'Vera', '0000-00-00', 'Jl. Puri Taman Asri B-38', 'Sidoarjo', 'O318299326', 'IRT', 'KTP', 'x'),
(65, '63.02.04.2010', 'Bimo Ario', '0000-00-00', 'Jl. Puri Taman Asri C-14', 'Sidoarjo', 'O81554326680', 'Koperasi Tetrasma', 'KTP', 'x'),
(66, '64.01.05.2010', 'Sulis Tyanto', '0000-00-00', 'Jl. Kutisari Utara I/58', 'Surabaya', 'O811300043', 'Wiraswasta', 'KTP', 'x'),
(67, '65.01.05.2010', 'Anne Chadidjah', '0000-00-00', 'Jl. Kutisari Utara I/58', 'Surabaya', 'O8176343046', 'IRT', 'KTP', 'x'),
(68, '66.02.05.2010', 'Nanang Abdul Azis', '0000-00-00', 'Jl.Edoro Belahan RT 02 RW 07 Wru SDA', 'Surabaya', 'X', 'Wiraswasta', 'KTP', 'x'),
(69, '67.01.05.2010', 'Sri Indah Nurmiasih', '0000-00-00', 'Jl. Wonorejo I/106', 'Surabaya', 'O81331435459', 'IRT', 'KTP', 'x'),
(70, '68.02.05.2010', 'Ninik Tri Suryani', '0000-00-00', 'Jl. Dieng no 1/DO 25,Kepuh Permai', 'Sidoarjo', 'X', 'Wiraswasta', 'KTP', 'x'),
(71, '69.01.06.2010', 'Hari Sukamto', '0000-00-00', 'Jl. Menganti Satelit Indah B/1', 'Surabaya', 'O81330729397', 'PNS', 'KTP', 'x'),
(72, '71.01.06.2010', 'Wiwik Dwi Sasanti', '0000-00-00', 'Jl Rungkut Mapan Tengah V - DD/9', 'Surabaya', 'O8175289598', 'IRT', 'KTP', 'x'),
(73, '72.01.06.2010', 'Wirasanti', '0000-00-00', 'RF 2/13 sektor I 2 BSD', 'Surabaya', 'O816913589', 'Wiraswasta', 'KTP', 'x'),
(74, '73.01.06.2010', 'Endang Istianingsih', '0000-00-00', 'Jl. Dukuh Kupang Timur XVII/42', 'Surabaya', 'O81331610066', 'Konsultan', 'KTP', 'x'),
(75, '74.01.07.2010', 'Adeng Gumawan', '0000-00-00', 'Jl. Tenggilis Mulyo 113 - A', 'Surabaya', '92002737', 'Wiraswasta', 'KTP', 'x'),
(76, '75.02.07.2010', 'Anisyah', '0000-00-00', 'Jl. Wadungasih RT 013/004, Buduran', 'Sidoarjo', '8921058', 'Swasta', 'KTP', 'x'),
(77, '76.02.07.2010', 'Rachmad Illah', '0000-00-00', 'Wadung Asih RT013/ RW 004, Buduran', 'Sidoarjo', '8921058', 'Wiraswasta', 'KTP', 'x'),
(78, '77.01.07.2010', 'Indah Soesi Loveni', '0000-00-00', 'Jl. Manyar Tirtoyoso Sel IV/5', 'Surabaya', 'O85648111838', 'IRT', 'KTP', 'x'),
(79, '78.01.06.2010', 'Lik Ulfah Puspa Dewi', '0000-00-00', 'Desa Kandangan RT 002/ RW 001', 'Surabaya', 'X', 'PNS', 'KTP', 'x'),
(80, '79.01.07.2010', 'Devi Adam Yunitasari', '0000-00-00', 'Jl. Kedung Sroko Buntu 17', 'Surabaya', 'X', 'PNS', 'KTP', 'x'),
(81, '80.01.07.2010', 'Nur Hasanah', '0000-00-00', 'Jl. Labansari no. 43 B, Sutorejo', 'Surabaya', 'X', 'PNS', 'KTP', 'x'),
(82, '81.01.07.2010', 'Nunuk Warsiyah', '2014-07-02', 'Jl. Semampir Tengah IX/A Dalam no.3', 'Surabaya', 'O81272353117', 'Swasta', 'KTP', 'x'),
(83, '82.01.02.2010', 'Pujiastutik', '0000-00-00', 'Jl. Pemuda Tambak Bungkal, Ponorogo', 'Surabaya', 'X', 'PNS', 'KTP', 'x'),
(84, '83.02.02.2010', 'Yenny Sabaveni', '0000-00-00', 'Jl. Jambu 8/G 49 Pondok Tjanosa Indah', 'Sidoarjo', '031-8663624', 'Swasta', 'KTP', 'x'),
(85, '84.10.02.2010', 'Budi Wiranto', '0000-00-00', 'Bukit Bambe AE-23, Gresik', 'Surabaya', '031-71527763', 'Swasta', 'KTP', 'x'),
(86, '85.01.02.2010', 'Gusti Tantri Diniar', '0000-00-00', 'Jl. Margorejo 3E/ 46', 'Surabaya', 'O85764451279', 'Swasta', 'KTP', 'x'),
(87, '86.01.02.2010', 'Nur Hasim', '0000-00-00', 'Jl. Simorejo Sari A no 27', 'Surabaya', 'O85731236862', 'Swasta', 'KTP', 'x'),
(88, '87.10.02.2010', 'Melly', '0000-00-00', 'Jl. perum Sumput Asri Blok DB-37', 'Gersik', 'O871332844733', 'Perawat', 'KTP', 'x'),
(89, '88.01.02.2010', 'Roesli Arsono', '0000-00-00', 'JL.Kedung Anyar 3/16 SBY', 'Surabaya', 'O81332375888', 'Swasta', 'KTP', 'x'),
(90, '89.02.02.2010', 'Stevanus Edwar', '0000-00-00', 'Jl. Puri Taman Asri C-12', 'Sidoarjo', '031-8295679', 'Swasta', 'KTP', 'x'),
(91, '90.01.02.2010', 'Farid Budianto', '0000-00-00', 'Sidosermo 5/9 A', 'Surabaya', 'O8983363365', 'Swasta', 'KTP', 'x'),
(92, '91.01.02.2010', 'Eko Harianto', '0000-00-00', 'JL. Siwalan Kerto 3/16', 'Surabaya', 'O81216120082', 'Swasta', 'KTP', 'x'),
(93, '92.02.02.2010', 'Farida Novi', '0000-00-00', 'Keboan Sikep RT 07/04 Gedangan', 'Sidoarjo', '031-71513787', 'Swasta', 'KTP', 'x'),
(94, '93.01.02.2010', 'Miss Elfa Dora', '0000-00-00', 'Jl. Sidosermo 5/2', 'Surabaya', 'O8983363365', 'Swasta', 'KTP', 'x'),
(95, '94.01.08.2010', 'Muhammad Fauzi', '0000-00-00', 'Klampis Semalang 5/34', 'Surabaya', 'O81331424767', 'Swasta', 'KTP', 'x'),
(96, '95.01.02.2010', 'Muhammad Cholil', '0000-00-00', 'Jl. Klampis semalang 5/34', 'Surabaya', '031 70456737', 'Wiraswasta', 'KTP', 'x'),
(97, '96.01.02.2010', 'Sri Sismiati', '0000-00-00', 'x', 'Surabaya', 'X', 'PNS', 'KTP', 'x'),
(98, '97.01.02.2010', 'Muhammad Ali', '0000-00-00', 'Jl. Nginden 6/ 10', 'Surabaya', '031 83480662', 'Swasta', 'KTP', 'x'),
(99, '98.01.02.2010', 'Devi Yuliana', '0000-00-00', 'Karangrejo 6/105-A', 'Surabaya', '031-71487314', 'Swasta', 'KTP', 'x'),
(100, '99.01.02.2010', 'Indah Tri Lakmiani', '0000-00-00', 'Jalan Gubeng Kertajaya 4A/07', 'Surabaya', '031-5010424', 'Swasta', 'KTP', 'x'),
(101, '100.01.02.2010', 'Hendro Yulianto', '0000-00-00', 'Jl.Manyar Sabrangan 1/50 A', 'Surabaya', '031-81128090', 'Swasta', 'KTP', 'x'),
(102, '101.01.02.2010', 'Sonni Saputra', '0000-00-00', 'Jl.Cargo Indah 2/20 Denpasar', 'Surabaya', 'O81554034274', 'Swasta', 'KTP', 'x'),
(103, '102.01.02.2010', 'Sri Wulandari', '0000-00-00', 'Jl. Sidosermo 5/2', 'Surabaya', 'O85851535949', 'Swasta', 'KTP', 'x'),
(104, '103.01.02.2010', 'AFY.H Lukito', '0000-00-00', 'Jl. Tengku Umar No 12 Bojonegoro', 'Bojonegoro', '0353-7757669', 'Wiraswasta', 'KTP', 'x'),
(105, '104.01.02.2010', 'Gentur', '0000-00-00', 'jL. Gayung Kebon Sari No 167 SBY', 'Surabaya', 'O8123222255', 'PNS', 'KTP', 'x'),
(106, '105.01.02.2010', 'Endah Murti Wulan', '0000-00-00', 'x', 'Surabaya', 'O8123581925', 'PNS', 'KTP', 'x'),
(107, '106.01.02.2010', 'Harianto Subakti', '0000-00-00', 'Sidosermo 5/9 A', 'Surabaya', 'O85733366657', 'Swasta', 'KTP', 'x'),
(108, '107.02.02.2010', 'LD. Jeffry', '0000-00-00', 'Puri Taman Asri C-15 Sby', 'Sidoarjo', 'O816514530', 'PNS', 'KTP', 'x'),
(109, '108.01.02.2010', 'Fitria Anggun', '0000-00-00', 'Kutisari Selatan 15/4', 'Surabaya', 'O8563222741', 'Swasta', 'KTP', 'x'),
(110, '109.02.02.2010', 'Budhi Cahyani', '0000-00-00', 'Taman Pondok Jati AK-8', 'Sidoarjo', 'O81357505048', 'Swasta', 'KTP', 'x'),
(111, '110.01.02.2010', 'Desi Andriati', '0000-00-00', 'Jl.Baratajaya V/42', 'Surabaya', 'O811914733', 'Swasta', 'KTP', 'x'),
(112, '111.01.10.2010', 'Cuk Ellyanto', '0000-00-00', 'Ngagel Kebonsari 19', 'Surabaya', '031-5043434', 'Swasta', 'KTP', 'x'),
(113, '112.01.02.2010', 'Hermin Suwandani', '0000-00-00', 'Jl.Manyar Sabrangan I/50-A', 'Surabaya', '031-5939778', 'IRT', 'KTP', 'x'),
(114, '113.02.02.2010', 'Rifan Arif', '0000-00-00', 'Jl.Bebekan  Masjid 2 RT 13 RW 04', 'Sidoarjo', 'O85731254150', 'Swasta', 'KTP', 'x'),
(115, '114.02.02.2010', 'Antonius Suryanto', '0000-00-00', 'Perum Pejaya Anugrah Blok DD/17 ', 'Sidoarjo', '031-70822164', 'Swasta', 'KTP', 'x'),
(116, '115.04.02.2010', 'Yulia Dati ', '0000-00-00', 'Karanglo Indah Blok E-A ', 'Surabaya', 'O85749574562', 'Swasta', 'KTP', 'x'),
(117, '116.11.11.1010', 'Kusdianto', '0000-00-00', 'Dusun Bukolan RT 04/RW 05', 'Probolinggo', 'O81358417480', 'Wiraswasta', 'KTP', 'x'),
(118, '117.11.04.1010', 'Sudarmanto', '0000-00-00', 'Dusun Bukolan RT 04/RW 05', 'Probolinggo', 'O82142704071', 'Wiraswasta', 'KTP', 'x'),
(119, '118.01.02.2010', 'Sumarti', '0000-00-00', 'Kupang Gunung Timur VI/4', 'Surabaya', '031-895772', 'Guru ', 'KTP', 'x'),
(120, '119.02.02.2010', 'Rita Sri Yatmin', '0000-00-00', 'Mutiara Citra Asri H1/7', 'Sidoarjo', '031-8057352', 'Kepala Sekolah', 'KTP', 'x'),
(121, '120.02.02.2010', 'Pipit Toeningwati', '0000-00-00', 'Jl.Sidodadi Indah IV/10', 'Surabaya', 'O85232373911', 'IRT', 'KTP', 'x'),
(122, '121.01.02.2010', 'Andi Kurniawan', '0000-00-00', 'Jl.A.Yani 267', 'Surabaya', '031-8437886', 'Wiraswasta', 'KTP', 'x'),
(123, '122.01.10.2010', 'Tatang Efendi', '0000-00-00', 'Siwalan Kerto 5-A/16-B', 'Surabaya', 'O81331994178', 'Swasta', 'KTP', 'x'),
(124, '123.02.02.2010', 'Christine', '0000-00-00', 'Pondok Wage Indah II 6/7', 'Sidoarjo', '031-8543958', 'Swasta', 'KTP', 'x'),
(125, '124.01.10.2010', 'Nur Fadilah', '0000-00-00', 'Semampir GG kelurahan 119', 'Surabaya', '031-77194336', 'IRT', 'KTP', 'x'),
(126, '125.01.02.2010', 'Dwi Okta', '0000-00-00', 'Kopas Lor II/23', 'Surabaya', 'O87882098483', 'PNS', 'KTP', 'x'),
(127, '126.01.02.2010', 'Poppy Damayanti', '0000-00-00', 'Jl.Ngagel Kebonsari 11', 'Surabaya', '031-72707611', 'Swasta', 'KTP', 'x'),
(128, '127.04.02.2010', 'Iwiek Muzayana', '0000-00-00', 'DS Tambak Agung Kec Puri-Mojokerto', 'Mojokerto', 'O81225555509', 'PNS', 'KTP', 'x'),
(129, '128.01.02.2010', 'Diah Rahmawati Rahayu', '0000-00-00', 'Rungkut Asri Timur 3/28', 'Surabaya', 'X', 'PNS', 'KTP', 'x'),
(130, '129.01.02.2010', 'Ninuk Handayani', '0000-00-00', 'Sidosermo V/9A', 'Surabaya', 'O81335143365', 'Perawat', 'KTP', 'x'),
(131, '130.11.01.1010', 'Musdalifah', '0000-00-00', 'Dusun Bukolan RT 04/RW 05', 'Probolinggo', 'O81338417480', 'IRT', 'KTP', 'x'),
(132, '131.01.02.2010', 'Kuswarni', '0000-00-00', 'Jl.Dukuh Kupang gg 4/a', 'Surabaya', '031-77879242', 'Swasta', 'KTP', 'x'),
(133, '132.01.02.2010', 'Endang Sri Saptarena', '0000-00-00', 'Per ITS Hidrodinamika IV-T/73', 'Surabaya', 'O85746151312', 'Swasta', 'KTP', 'x'),
(134, '133.02.02.2010', 'Aditya Pramono Aji', '0000-00-00', 'Tebel Barat 34 RT 02,RW 02', 'Sidoarjo', 'O85630803375', 'Swasta', 'KTP', 'x'),
(135, '134.01.02.2010', 'Fitri Cherry', '0000-00-00', 'Wisma Medokan D/2', 'Surabaya', '031-71396258', 'IRT', 'KTP', 'x'),
(136, '135.01.02.2010', 'Suwambar Trisaningsih', '0000-00-00', 'Grudo 4/21-A', 'Surabaya', 'O81231399849', 'Perawat', 'KTP', 'x'),
(137, '136.02.02.2010', 'Suheni', '0000-00-00', 'Pondok Wage IndahII/Blok V-20', 'Sidoarjo', '031-91520461', 'Perawat', 'KTP', 'x'),
(138, '137.01.02.2010', 'Eko Novi Aviyani', '0000-00-00', 'Jl.A.Yani No 267', 'Surabaya', '031-8492931', 'Swasta', 'KTP', 'x'),
(139, '138.02.02.2010', 'Raditya Dermawan', '0000-00-00', 'Jl.Jati Selatan 1/31 RT ,RW 1', 'Sidoarjo', 'O87851551999', 'Wiraswasta', 'KTP', 'x'),
(140, '139.01.02.2010', 'Wiji Rahayu', '0000-00-00', 'Pulosari 2A/2-A', 'Surabaya', '031-5613055', 'Swasta', 'KTP', 'x'),
(141, '140.01.02.2010', 'Sukirman', '0000-00-00', 'Pulosari 2A/2-A', 'Surabaya', '5613055', 'Swasta', 'KTP', 'x'),
(142, '141.01.02.2010', 'Febriana', '0000-00-00', 'Jl. Jembatan Baru Gang 5', 'Surabaya', 'O81357225758', 'PNS', 'KTP', 'x'),
(143, '142.01.02.2010', 'Twiesa Bluema', '0000-00-00', 'Jl. Manukan LOR 2-1/3', 'Surabaya', 'O8123017852', 'Swasta', 'KTP', 'x'),
(144, '143.01.02.2010', 'Fanina Sari Nurlita', '0000-00-00', 'Medokan Asri Utara MA 3M/35', 'Surabaya', 'O85230486836', 'Swasta', 'KTP', 'x'),
(145, '144.01.02.2010', 'Supinah', '0000-00-00', 'Rungkut Lor gg I No 10', 'Surabaya', '031-8702014', 'Swasta', 'KTP', 'x'),
(146, '145.01.02.2010', 'Erna Suraswati', '0000-00-00', 'Bringin Telaga RT 02 RW 01', 'Surabaya', '031-34980118', 'Swasta', 'KTP', 'x'),
(147, '146.01.02.2010', 'Tri Yudani Samiasih', '0000-00-00', 'Kedung Asem gg 1 No 10', 'Surabaya', '031-78021376', 'Swasta', 'KTP', 'x'),
(148, '147.01.02.2010', 'Endah Yuswarini', '0000-00-00', 'Jl.Teknik Lingkungan BI 1-14', 'Sidoarjo', 'O8123568919', 'DOSEN', 'KTP', 'x'),
(149, '148.01.02.2010', 'Katrina', '0000-00-00', 'Perum ITS Jl.Teknik Lingkungan 1/14', 'Surabaya', 'X', 'IRT', 'KTP', 'x'),
(150, '149.01.02.2010', 'Noor Maulidah', '0000-00-00', 'Wisma Kedung Asem Indah H-6', 'Surabaya', '031-71720848', 'Guru', 'KTP', 'x'),
(151, '150.01.02.2010', 'Kusprianto', '0000-00-00', 'Kandangan Gunung Bakti 11/7', 'Surabaya', 'O8563021590', 'Swasta', 'KTP', 'x'),
(152, '151.01.02.2010', 'Arif Dharma', '0000-00-00', 'Griya Kebraon Barat 16 CI No 3', 'Surabaya', 'O85648182046', 'Swasta', 'KTP', 'x'),
(153, '152.01.02.2010', 'Rusri Anik', '0000-00-00', 'Kedung Anyar 3/16', 'Surabaya', 'O87853693286', 'Wiraswasta', 'KTP', 'x'),
(154, '153.11.02.2010', 'Ani Komaria', '0000-00-00', 'Dusun Bukolan RT 04/RW 05', 'Probolinggo', 'O81242704071', 'Swasta', 'KTP', 'x'),
(155, '154.01.02.2010', 'Ahmad Rizal', '0000-00-00', 'Jl. Sidosermo 4/24', 'Surabaya', 'O81554360640', 'Swasta', 'KTP', 'x'),
(156, '155.01.02.2010', 'Istirocha', '0000-00-00', 'Ngagel Kebon Sari 2/8', 'Surabaya', '031-5043738', 'IRT', 'KTP', 'x'),
(157, '156.01.02.2011', 'Yuni Tutsih Erlianti', '0000-00-00', 'Gubeng Kertajaya VY E/ 40', 'Surabaya', '031-5030400', 'Guru', 'KTP', 'x'),
(158, '157.01.02.2010', 'Titik Suparti', '0000-00-00', 'x', 'Surabaya', 'X', 'X', 'KTP', 'x'),
(159, '158.01.02.2011', 'Chilmi Syaripudin', '0000-00-00', 'Klampis Ngasem No 107', 'Surabaya', 'O85648613730', 'Swasta', 'KTP', 'x'),
(160, '159.01.02.2011', 'Rina Wati', '0000-00-00', 'Jl.Rungkut Mejoyo', 'Surabaya', 'O8563237621', 'Wiraswasta', 'KTP', 'x'),
(161, '160.01.02.2011', 'Hanif Abdul Latif', '0000-00-00', 'Sidoserma IV 66/10', 'Surabaya', 'O85730020787', 'Swasta', 'KTP', 'x'),
(162, '161.01.02.2011', 'Ananto Ariaji', '0000-00-00', 'Dukuh Kupang Timur 17/42', 'Surabaya', 'O85648053722', 'Swasta', 'KTP', 'x'),
(163, '162.01.02.2011', 'Chunaini', '0000-00-00', 'Sidosermo 4/18', 'Surabaya', 'O85733127463', 'Swasta', 'KTP', 'x'),
(164, '163.01.02.2011', 'Soehariani', '0000-00-00', 'Pandugo Timur 8/21 D. 10', 'Surabaya', 'X', 'X', 'KTP', 'x'),
(165, '164.01.02.2011', 'Sukarni', '0000-00-00', 'Gayungan Manggis 47', 'Surabaya', 'O8819754147', 'Wiraswasta', 'KTP', 'x'),
(166, '165.02.02.2011', 'Ferry Setiawan', '0000-00-00', 'Jati Selatan 1/31', 'Sidoarjo', 'O87851165999', 'Wiraswasta', 'KTP', 'x'),
(167, '166.01.02.2011', 'Kristanto Al Aaisory', '0000-00-00', 'Jl.Siwalan Kerto No 18', 'Surabaya', 'X', 'Swasta', 'KTP', 'x'),
(168, '167.01.01.2011', 'Theresia', '0000-00-00', 'Komp GBA Barat C4/14', 'Surabaya', '082128148048', 'Wiraswasta', 'KTP', 'x'),
(169, '168.01.02.2011', 'Ikya Ulummudin', '0000-00-00', 'Meteseh RT 004/RW 002', 'Lamongan', 'O85649051853', 'Swasta', 'KTP', 'x'),
(170, '169.01.02.2011', 'Sholati', '0000-00-00', 'Klampis Ngasem No 107', 'Surabaya', 'O8179385345', 'Wiraswasta', 'KTP', 'x'),
(171, '170.01.02.2011', 'Hipolita Sukawidarti', '0000-00-00', 'Wonorejo Permai Timur II DD/64', 'Surabaya', '031-83039091', 'Wiraswasta', 'KTP', 'x'),
(172, '171.01.02.2011', 'Novi Tri Budianto', '0000-00-00', 'Kupang Gunung Barat 8/20', 'Surabaya', 'O87853704688', 'Swasta', 'KTP', 'x'),
(173, '172.02.02.2011', 'Anie Diah Tarawati', '0000-00-00', 'Bukit Bambe AE-23', 'Sidoarjo', '031-9140331', 'Swasta', 'KTP', 'x'),
(174, '173.01.02.2011', 'Ponco Bayu Widodo', '0000-00-00', 'Dukuh Kupang Timur 17/42', 'Surabaya', '031-72529292', 'Swasta', 'KTP', 'x'),
(175, '174.01.02.2011', 'Rudy Suryanto', '0000-00-00', 'Perum ITS TL 1/14', 'Surabaya', 'O87851413233', 'Swasta', 'KTP', 'x'),
(176, '175.01.02.2011', 'Ida Rumasiyanti', '0000-00-00', 'Kalilom Lor I Pandan Wangi Indah No 2', 'Surabaya', 'O81931629909', 'Guru', 'KTP', 'x'),
(177, '176.01.02.2011', 'Nurul Chayati', '0000-00-00', 'JL.Karimat No 12', 'Surabaya', '031-60363787', 'Swasta', 'KTP', 'x'),
(178, '177.01.03.2011', 'Damita Nadia Sari', '0000-00-00', 'Rungkut Lor 5-F No 22', 'Surabaya', 'O811372662', 'Swasta', 'KTP', 'x'),
(179, '178.01.03.2011', 'Muklis', '0000-00-00', 'Menur Pumpungan 5 No 68', 'Surabaya', '031-70060020', 'Swasta', 'KTP', 'x'),
(180, '179.01.03.2011', 'Bagoes', '0000-00-00', 'Wisma Kedung Asem Indah FF No 16', 'Surabaya', 'X', 'DOSEN', 'KTP', 'x'),
(181, '180.01.03.2011', 'Yuni', '0000-00-00', 'Kedurus gg 2 No 102', 'Surabaya', 'O8563000863', 'Swasta', 'KTP', 'x'),
(182, '181.01.03.2011', 'Data Kosong', '0000-00-00', 'x', 'X', 'X', 'X', 'KTP', 'x'),
(183, '182.01.03.2011', 'Abdus Syakur', '0000-00-00', 'Banyu Urip Wetan Tengah 6/19 A', 'Surabaya', 'O8563147788', 'Wiraswasta', 'KTP', 'x'),
(184, '183.01.03.2011', 'Agan', '0000-00-00', 'Banyu Urip Wetan Tengah i No 20', 'Surabaya', 'O8563271112', 'Swasta', 'KTP', 'x'),
(185, '184.02.03.2011', 'Toni', '0000-00-00', 'Perum Mager Sari 0/19', 'Sidoarjo', 'O8563333385', 'Wiraswasta', 'KTP', 'x'),
(186, '185.01.03.2011', 'Hendra Stefan Saputra', '0000-00-00', 'x', 'Surabaya', 'O85737182999', 'Swasta', 'KTP', 'x'),
(187, '186.01.04.2011', 'Chrisatrya Mark.W', '0000-00-00', 'JL.Gubeng Kertajaya I D No 12', 'Surabaya', 'O8213100809', 'Swasta', 'KTP', 'x'),
(188, '187.01.04.2011', 'Dodo Ananto', '0000-00-00', 'Perum DAM TA No130', 'Surabaya', '031-34962537', 'Swasta', 'KTP', 'x'),
(189, '188.01.04.2011', 'Dewi Setyowati', '0000-00-00', 'Siwalan Kerto SEL gg Makam No 66', 'Surabaya', '031-70880132', 'Swasta', 'KTP', 'x'),
(190, '189.01.04.2011', 'Mujianah', '0000-00-00', 'JL. Bhaskara 3/46', 'Surabaya', '031-5991509', 'Swasta', 'KTP', 'x'),
(191, '190.01.04.2011', 'Djoko', '0000-00-00', 'Margorukun 10/9', 'Surabaya', 'O82131403848', 'Swasta', 'KTP', 'x'),
(192, '191.01.04.2011', 'Sigit Lukman', '0000-00-00', 'Manyar Sambrangan I No 50 A', 'Surabaya', 'O82131403848', 'X', 'KTP', 'x'),
(193, '192.01.04.2011', 'Sumaiyah', '0000-00-00', 'JL. Pucang 3 No 10', 'Surabaya', 'X', 'Guru SMAN 4 Sby', 'KTP', 'x'),
(194, '193.01.04.2011', 'Dwi Rahayu', '0000-00-00', 'Wisma Penjaringan Sari U No 29', 'Surabaya', '031-91152852', 'Guru SMAN 4 Sby', 'KTP', 'x'),
(195, '194.01.04.2011', 'Nur Sutopo', '0000-00-00', 'JL.Bogen 11/17 A', 'Surabaya', '031-70426778', 'Swasta', 'KTP', 'x'),
(196, '195.01.04.2011', 'Emilia', '0000-00-00', 'JL. Perum Pandugo Timur D No 23', 'Surabaya', '031-8706089', 'IRT', 'KTP', 'x'),
(197, '196.02.04.2011', 'Agung Dwi Putra', '0000-00-00', 'Cemeng Kalang RT02 RW01', 'Sidoarjo', 'O85223492235', 'Swasta', 'KTP', 'x'),
(198, '197.01.04.2011', 'Sri Hardinah', '0000-00-00', 'Kertajaya 4A/7 Sby', 'Surabaya', '031-5010424', 'Swasta', 'KTP', 'x'),
(199, '198.01.05.2011', 'Gatut Hendro Wardono', '0000-00-00', 'JL. SIMP Flamboyan 2 RT/RW 008/010', 'Surabaya', 'X', 'Swasta', 'KTP', 'x'),
(200, '199.03.05.2011', 'Endah Lestari', '0000-00-00', 'Perum.Paras Jajar A-2 MLG', 'Surabaya', 'X', 'DOSEN', 'KTP', 'x'),
(201, '200.02.05.2011', 'Ismanita Eka Dewi', '0000-00-00', 'Taman Pinang Indah H4/20 SDA', 'Sidoarjo', 'O81515141314', 'PNS', 'KTP', 'x'),
(202, '201.02.05.2011', 'Nur Afifah', '0000-00-00', 'JL.Nangka 3 Pekarungan RT 03 RW 02', 'Sidoarjo', 'O85731284439', 'Guru', 'KTP', 'x'),
(203, '202.05.05.2011', 'Nunuk', '0000-00-00', 'Perum. Griya Japan Raya RT 01 RW 12 Mojokerto', 'Mojokerto', 'X', 'Swasta', 'KTP', 'x'),
(204, '203.01.05.2011', 'Hendra', '0000-00-00', 'Jagir Sidomukti 6 No 23', 'Surabaya', 'O85733137398', 'Swasta', 'KTP', 'x'),
(205, '204.01.05.2011', 'Sofyan', '0000-00-00', 'Kebon Sari Selatan 1 No 17', 'Sidoarjo', 'O8563032344', 'Swasta', 'KTP', 'x'),
(206, '205.01.06.2011', 'Silvi Triana', '0000-00-00', 'Jl.Ngagel Mulyo 10/3', 'Surabaya', '031-5022326', 'Swasta', 'KTP', 'x'),
(207, '206.01.06.2011', 'Sukarti Widayani', '0000-00-00', 'x', 'Surabaya', 'X', 'X', 'KTP', 'x'),
(208, '207.01.06.2011', 'Saodah', '0000-00-00', 'JL.Candi Kempung Blok A/60 Surabaya', 'Surabaya', '031-7418370', 'TVRI Jatim', 'KTP', 'x'),
(209, '208.02.06.2011', 'Gustira Atra Widya', '0000-00-00', 'Perum Villa Yasmin 1B/18 Sidoarjo', 'Sidoarjo', 'X', 'Swasta', 'KTP', 'x'),
(210, '209.01.07.2011', 'Nasripah', '0000-00-00', 'Wonocolo Gang 1 No 8', 'Surabaya', 'X', 'IRT', 'KTP', 'x'),
(211, '210.01.07.2011', 'Setyokoi', '0000-00-00', 'x', 'Surabaya', 'x', 'Swasta', 'KTP', 'x'),
(212, '211.01.07.2011', 'Teddy Mulyad', '0000-00-00', 'x', 'Surabaya', 'X', 'X', 'KTP', 'x'),
(213, '212.01.07.2011', 'Edi Martono', '0000-00-00', 'Simo Mulyo Baru Blok 2D/17', 'Surabaya', 'X', 'Swasta', 'KTP', 'x'),
(214, '213.01.07.2011', 'Ratih Dharmawati', '0000-00-00', 'Jl.Dukuh Kupang 14/26', 'Surabaya', '031-91890457', 'Swasta', 'KTP', 'x'),
(215, '214.01.07.2011', 'Dekik Dhian Damayanti', '0000-00-00', 'Medokan Asri Utara 6/4 Surabaya', 'Surabaya', 'X', 'Swasta', 'KTP', 'x'),
(216, '215.01.08.2011', 'Sri Minarni', '0000-00-00', 'YKP. Pandugo II-L/35', 'Surabaya', '031-72143643', 'IRT', 'KTP', 'x'),
(217, '216.01.08.2011', 'M.Ayub', '0000-00-00', 'Rungkut Tengah 3 B/20', 'Surabaya', 'X', 'Wiraswasta', 'KTP', 'x'),
(218, '217.01.08.2011', 'Susilowati', '0000-00-00', 'Ngagel Kebon Sari 2/4', 'Surabaya', 'X', 'IRT', 'KTP', 'x'),
(219, '218.01.08.2011', 'Rita TK', '0000-00-00', 'x', 'Surabaya', 'X', 'Guru', 'KTP', 'X'),
(220, '219.01.08.2011', 'Istyo Wibowo', '0000-00-00', 'JL.Jemur Andayani VI/8', 'Surabaya', '031-8496477', 'Swasta', 'KTP', 'x'),
(221, '220.01.08.2011', 'Prihandoyo', '0000-00-00', 'x', 'Surabaya', 'X', 'X', 'KTP', 'x'),
(222, '221.01.09.2011', 'Enny H', '0000-00-00', 'Karang Rejo Timur 3/11 A', 'Surabaya', '081331728729', 'Guru', 'KTP', 'x'),
(223, '222.01.10.2011', 'lisa Chamila', '0000-00-00', 'JL.Pelampitan X/4 Surabaya', 'Surabaya', '031-5474905', 'Swasta', 'KTP', 'x'),
(224, '223.01.10.2011', 'Siti Alimah', '0000-00-00', 'Gunung Sari Indah uu/22', 'Surabaya', '031-7661922', 'DOSEN', 'KTP', 'x'),
(225, '224.01.10.2011', 'Ertha Rosely Bernita', '0000-00-00', 'JL.Teknik Sipil Blok J-35 ITS', 'Surabaya', '031-70069042', 'Swasta', 'KTP', 'x'),
(226, '225.01.10.2011', 'Christine Denni', '0000-00-00', 'Keputih Tegal Timur 3A/C2 Surabaya', 'Surabaya', '031-71902016', 'Swasta', 'KTP', 'x'),
(227, '226.02.10.2011', 'Titin Hernanik', '0000-00-00', 'Griyo Wage Asri II Blok Ai/08', 'Sidoarjo', '031-60705549', 'Swasta', 'KTP', 'x'),
(228, '227.05.10.2011', 'Ferry Indra', '0000-00-00', 'JL.Anggrek IX Blok C/22', 'Surabaya', '031-81960143', 'Swasta', 'KTP', 'x'),
(229, '228.01.10.2011', 'Lilik SR', '0000-00-00', 'Wonorejo Selatan II Kav 100', 'Surabaya', '031-70076222', 'Swasta', 'KTP', 'x'),
(230, '229.02.10.2011', 'Henni', '0000-00-00', 'Wisma Permai Regncy EE-2 Sidoarjo', 'Sidoarjo', 'X', 'Swasta', 'KTP', 'x'),
(231, '230.01.11.2011', 'Binti Susminantik', '0000-00-00', 'Jl. Sidosermo 4/24', 'Surabaya', 'O81553202014', 'Swasta', 'KTP', 'x'),
(232, '231.01.11.2011', 'Nova', '0000-00-00', 'JL.Kalibokor No 69A', 'Surabaya', 'O87853900516', 'Swasta', 'KTP', 'x'),
(233, '232.01.11.2011', 'Sandy Debby', '0000-00-00', 'JL.Susanto 22 RT 007 RW 004 Kenjeran', 'Surabaya', 'O81233366770', 'Swasta', 'KTP', 'x'),
(234, '233.01.11.2011', 'Yunita R', '0000-00-00', 'Bagong Ginayan 7/10', 'Surabaya', 'X', 'Swasta', 'KTP', 'x'),
(235, '234.02.11.2011', 'Berfitto', '0000-00-00', 'Tridasa Windu Asri H 12 Sidoarjo', 'Sidoarjo', 'O87851566166', 'Swasta', 'KTP', 'x'),
(237, '234.01.11.2011', 'Barfitto', '2011-11-23', 'Perum Tridasa Windu Asri H/12', 'Buduran-Sidoarjo', '087851566166', 'karyawan BCA cab Darmo', 'KTP', 'x'),
(238, '236.01.12.2011', 'Tri Karyani', '2011-12-31', 'Jl. Tambak Gringsing I/27 A', 'Surabaya', '031-3539751', 'karyawan Batik Danar Hadi', 'KTP', 'x'),
(239, '238.01.02.2012', 'Arnold Priajaya  ', '2012-02-14', 'Manyar Sabrangan VIII B/15', 'Surabaya', '081332390099', 'karyawan BCA cab Darmo', 'KTP', 'X'),
(240, '239.01.02.2012', 'Yulia Horoni ', '2012-02-11', 'Pandugo Baru A - 1 ', 'Surabaya', '081217708167', 'Ibu Rumah Tangga', 'KTP', 'X'),
(241, '240.02.02.2012', 'Siti Nurhayati', '2012-02-25', 'Desa Mlaten RT. 26 RW. 06 Sidokepung ', 'Buduran-Sidoarjo', 'x', 'Ibu Rumah Tangga', 'KTP', 'x'),
(242, '241.01.03.2012', 'Kolifah', '2012-03-02', 'Banyu Urip Jaya I No. 44 B', 'Surabaya', '085730976360', 'karyawan Batik Danar Hadi', 'KTP', 'x'),
(243, '243.01.03.2012', 'Fadhu Rahmi', '2012-03-10', 'Ngagel Kebonsari No. 17', 'Surabaya', '081346222604', 'Ibu Rumah Tangga', 'KTP', 'x'),
(244, '244.04.05.2012', 'Soemartono', '2012-05-17', 'Cengger Ayam Dalam II / 17 ', 'Malang', '08123511759', 'PNS', 'KTP', 'x'),
(245, '245.01.05.2012', 'Sintawati', '2012-05-10', 'Panjang Jiwo Permai 2 / 31 - 32 ', 'Surabaya', '081331000770 / 0817500555', 'Ibu Rumah Tangga', 'KTP', 'x'),
(246, '246.01.07.2012', 'Ineke Coborahayu', '2012-07-31', 'Ploso Timur II / 30', 'Surabaya', '087856053900', 'karyawan BCA cab Darmo', 'KTP', 'x'),
(247, '247.02.09.2012', 'Aisah Lilis Ely', '2012-09-04', 'Perum Bluru Permai Blok CU - 24 ', 'Sidoarjo', '031-91788547', 'Karyawan Swasta', 'KTP', 'x'),
(248, '248.02.09.2012', 'Reny Diah Purwandhani', '2012-09-20', 'Griya Bhayangkara Suko B / 8', 'Sidoarjo', '085640058721', 'Pegawai Koperasi Tetrasma', 'KTP', 'x'),
(249, '249.02.10.2012', 'Ermyn Soesy Widijati', '2012-10-12', 'Jatisari Permai VI. I / 32', 'Sidoarjo', '081387299777', 'Karyawan BCA', 'KTP', 'x'),
(250, '250.02.12.2012', 'Wasisto Budiawan ', '2012-12-03', 'Cendrawasih Bunderan 110 Rewwin Waru', 'Sidoarjo', '08123130512', 'Swasta', 'KTP', 'x'),
(251, 'x', 'xx', '2016-07-10', 'x', 'x', 'x', 'x', 'x', 'x'),
(252, 'x', 'x', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(253, 'xxx', 'xxx', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_detail`
--

CREATE TABLE IF NOT EXISTS `tb_detail` (
  `detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `jurnal_id` int(11) NOT NULL,
  `akun_id` int(11) NOT NULL,
  `dk` tinyint(1) NOT NULL DEFAULT '0',
  `nilai` bigint(20) NOT NULL,
  `anggota_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`detail_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tb_detail`
--


-- --------------------------------------------------------

--
-- Table structure for table `tb_detailm`
--

CREATE TABLE IF NOT EXISTS `tb_detailm` (
  `detailm_id` int(11) NOT NULL AUTO_INCREMENT,
  `jurnalm_id` int(11) NOT NULL,
  `akunm_id_debet` int(11) NOT NULL,
  `nilaim_debet` bigint(20) NOT NULL,
  `akunm_id_kredit` int(11) NOT NULL,
  `nilaim_kredit` bigint(20) NOT NULL,
  PRIMARY KEY (`detailm_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tb_detailm`
--


-- --------------------------------------------------------

--
-- Table structure for table `tb_jurnal`
--

CREATE TABLE IF NOT EXISTS `tb_jurnal` (
  `jurnal_id` int(11) NOT NULL AUTO_INCREMENT,
  `no_bukti` varchar(25) NOT NULL,
  `tgl` date NOT NULL,
  `ket` text NOT NULL,
  `jenis_jurnal` varchar(2) NOT NULL,
  `akun_id` int(11) NOT NULL,
  `nilai` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`jurnal_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tb_jurnal`
--


-- --------------------------------------------------------

--
-- Table structure for table `tb_jurnalm`
--

CREATE TABLE IF NOT EXISTS `tb_jurnalm` (
  `jurnalm_id` int(11) NOT NULL AUTO_INCREMENT,
  `no_buktim` varchar(25) NOT NULL,
  `tglm` date NOT NULL,
  `ketm` text NOT NULL,
  PRIMARY KEY (`jurnalm_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tb_jurnalm`
--


-- --------------------------------------------------------

--
-- Table structure for table `tb_level1`
--

CREATE TABLE IF NOT EXISTS `tb_level1` (
  `level1_id` int(11) NOT NULL AUTO_INCREMENT,
  `level1_no` varchar(2) NOT NULL,
  `level1_nama` varchar(50) NOT NULL,
  PRIMARY KEY (`level1_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tb_level1`
--

INSERT INTO `tb_level1` (`level1_id`, `level1_no`, `level1_nama`) VALUES
(1, '1', 'Aktiva'),
(2, '2', 'Hutang'),
(3, '3', 'Modal'),
(4, '4', 'Pendapatan'),
(5, '5', 'HPP'),
(6, '6', 'Biaya');

-- --------------------------------------------------------

--
-- Table structure for table `tb_level2`
--

CREATE TABLE IF NOT EXISTS `tb_level2` (
  `level2_id` int(11) NOT NULL AUTO_INCREMENT,
  `level1_id` int(11) NOT NULL,
  `level2_no` varchar(2) NOT NULL,
  `level2_nama` varchar(50) NOT NULL,
  PRIMARY KEY (`level2_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `tb_level2`
--

INSERT INTO `tb_level2` (`level2_id`, `level1_id`, `level2_no`, `level2_nama`) VALUES
(1, 1, '1', 'Aktiva Lancar'),
(2, 1, '2', 'Aktiva Tetap'),
(3, 2, '1', 'Hutang Jk. Pendek'),
(4, 3, '1', 'Modal Sendiri'),
(5, 4, '1', 'Pendapatan Usaha'),
(6, 5, '1', 'Biaya Langsung'),
(7, 6, '1', 'Biaya'),
(8, 2, '2', 'Hutang Jk. Panjang');

-- --------------------------------------------------------

--
-- Table structure for table `tb_level3`
--

CREATE TABLE IF NOT EXISTS `tb_level3` (
  `level3_id` int(11) NOT NULL AUTO_INCREMENT,
  `level1_id` int(11) NOT NULL,
  `level2_id` int(11) NOT NULL,
  `level3_no` varchar(2) NOT NULL,
  `level3_nama` varchar(50) NOT NULL,
  PRIMARY KEY (`level3_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `tb_level3`
--

INSERT INTO `tb_level3` (`level3_id`, `level1_id`, `level2_id`, `level3_no`, `level3_nama`) VALUES
(1, 1, 1, '1', 'Kas'),
(2, 1, 1, '3', 'Piutang'),
(3, 1, 1, '4', 'Aktiva Lain'),
(4, 1, 2, '1', 'Aktiva Tetap'),
(5, 2, 3, '1', 'Hutang Lancar'),
(6, 2, 3, '2', 'Hutang Jangka Panjang'),
(7, 3, 4, '1', 'Simpanan Pokok'),
(8, 3, 4, '2', 'Simpanan Wajib'),
(9, 4, 5, '1', 'Pendapatan Bunga Pinjaman'),
(10, 5, 6, '1', 'Biaya Langsung'),
(11, 6, 7, '1', 'Biaya Keuangan'),
(12, 6, 7, '2', 'Biaya Organisasi'),
(13, 6, 7, '3', 'Biaya Karyawan'),
(14, 6, 7, '4', 'Biaya Operasional Kantor'),
(15, 1, 1, '2', 'Bank'),
(16, 3, 4, '3', 'Simpanan Sukarela');

-- --------------------------------------------------------

--
-- Table structure for table `tb_level4`
--

CREATE TABLE IF NOT EXISTS `tb_level4` (
  `level4_id` int(11) NOT NULL AUTO_INCREMENT,
  `level1_id` int(11) NOT NULL,
  `level2_id` int(11) NOT NULL,
  `level3_id` int(11) NOT NULL,
  `level4_no` varchar(2) NOT NULL,
  `level4_nama` varchar(50) NOT NULL,
  `saldo_awal` bigint(20) DEFAULT NULL,
  `saldo` bigint(20) DEFAULT NULL,
  `jurnal` tinyint(1) DEFAULT '0',
  `jurnal_kode` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`level4_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=63 ;

--
-- Dumping data for table `tb_level4`
--

INSERT INTO `tb_level4` (`level4_id`, `level1_id`, `level2_id`, `level3_id`, `level4_no`, `level4_nama`, `saldo_awal`, `saldo`, `jurnal`, `jurnal_kode`) VALUES
(1, 1, 1, 1, '01', 'Kas', NULL, NULL, 1, 'K'),
(2, 1, 1, 1, '02', 'Bank BCA', NULL, NULL, 1, 'B'),
(3, 1, 1, 1, '03', 'Bank Mandiri', NULL, NULL, 1, 'B'),
(4, 1, 1, 2, '01', 'Pinjaman yang diberikan', NULL, NULL, 0, NULL),
(5, 1, 1, 2, '02', 'Asuransi dibayar dimuka', NULL, NULL, 0, NULL),
(6, 1, 1, 2, '03', 'Beban dibayar dimuka', NULL, NULL, 0, NULL),
(7, 1, 1, 2, '04', 'Penyisihan piutang tak tertagih', NULL, NULL, 0, NULL),
(8, 1, 1, 2, '05', 'Pendapatan ymh diterima', NULL, NULL, 0, NULL),
(9, 1, 1, 3, '01', 'Aktiva lain', NULL, NULL, 0, NULL),
(10, 1, 2, 4, '01', 'Tanah', NULL, NULL, 0, NULL),
(11, 1, 2, 4, '02', 'Bangunan', NULL, NULL, 0, NULL),
(12, 1, 2, 4, '03', 'Akumulasi Penyusutan Bangunan', NULL, NULL, 0, NULL),
(13, 1, 2, 4, '04', 'Peralatan / Mebel', NULL, NULL, 0, NULL),
(14, 1, 2, 4, '05', 'Akumulasi Penyusutan Peralatan / Mebel', NULL, NULL, 0, NULL),
(15, 1, 2, 4, '06', 'Inventaris Kantor', NULL, NULL, 0, NULL),
(16, 1, 2, 4, '07', 'Akumulasi Penyusutan Inventaris Kantor', NULL, NULL, 0, NULL),
(17, 2, 3, 5, '01', 'Simpanan Sukarela', NULL, NULL, 0, NULL),
(18, 2, 3, 5, '02', 'Simpanan Berjangka', NULL, NULL, 0, NULL),
(19, 2, 3, 5, '03', 'Simpanan Karyawan', NULL, NULL, 0, NULL),
(20, 2, 3, 5, '04', 'Hutang Bank', NULL, NULL, 0, NULL),
(21, 2, 3, 5, '05', 'Beban YMH Dibayar', NULL, NULL, 0, NULL),
(22, 2, 3, 5, '99', 'Hutang Lain-Lain', NULL, NULL, 0, NULL),
(23, 2, 3, 6, '01', 'Hutang Sewa', NULL, NULL, 0, NULL),
(24, 3, 4, 7, '01', 'Simpanan Pokok', NULL, NULL, 0, NULL),
(25, 3, 4, 7, '02', 'Simpanan Wajib', NULL, NULL, 0, NULL),
(26, 3, 4, 7, '03', 'Donasi', NULL, NULL, 0, NULL),
(27, 3, 4, 7, '04', 'Modal Penyertaan', NULL, NULL, 0, NULL),
(28, 3, 4, 7, '05', 'Cad. Tujuan Resiko', NULL, NULL, 0, NULL),
(29, 3, 4, 8, '01', 'Laba Periode Berjalan', NULL, NULL, 0, NULL),
(30, 3, 4, 8, '02', 'Cadangan SHU', NULL, NULL, 0, NULL),
(31, 4, 5, 9, '01', 'Pendapatan Bunga', NULL, NULL, 0, NULL),
(32, 4, 5, 9, '02', 'Pendapatan Provisi', NULL, NULL, 0, NULL),
(33, 4, 5, 9, '03', 'Pendapatan Administrasi', NULL, NULL, 0, NULL),
(34, 4, 5, 9, '99', 'Pendapatan Lainnya', NULL, NULL, 0, NULL),
(35, 5, 6, 10, '01', 'Biaya Langsung', NULL, NULL, 0, NULL),
(36, 6, 7, 11, '01', 'Bunga Simpanan', NULL, NULL, 0, NULL),
(37, 6, 7, 11, '02', 'Bunga Bank', NULL, NULL, 0, NULL),
(38, 6, 7, 11, '03', 'Bunga Simpanan Lain-Lain', NULL, NULL, 0, NULL),
(39, 6, 7, 11, '04', 'Bunga Simpanan Berjangka', NULL, NULL, 0, NULL),
(40, 6, 7, 11, '05', 'Bunga Simpanan Khusus', NULL, NULL, 0, NULL),
(41, 6, 7, 11, '06', 'Biaya Penysh. Piut. Tak Tertg.', NULL, NULL, 0, NULL),
(42, 6, 7, 11, '07', 'Biaya Asuransi', NULL, NULL, 0, NULL),
(43, 6, 7, 11, '08', 'Biaya Audit', NULL, NULL, 0, NULL),
(44, 6, 7, 11, '09', 'Biaya Pajak', NULL, NULL, 0, NULL),
(45, 6, 7, 11, '99', 'Biaya Keu. Lain-Lain', NULL, NULL, 0, NULL),
(46, 6, 7, 12, '01', 'Biaya Rapat Pengurus', NULL, NULL, 0, NULL),
(47, 6, 7, 12, '02', 'Biaya Rapat Anggota', NULL, NULL, 0, NULL),
(48, 6, 7, 12, '03', 'Biaya Perjalanan Dinas', NULL, NULL, 0, NULL),
(49, 6, 7, 12, '04', 'Biaya Diklat', NULL, NULL, 0, NULL),
(50, 6, 7, 12, '05', 'Biaya Honorarium Pengurus', NULL, NULL, 0, NULL),
(51, 6, 7, 12, '06', 'Biaya Pembinaan', NULL, NULL, 0, NULL),
(52, 6, 7, 12, '99', 'Biaya Org. Lain-Lain', NULL, NULL, 0, NULL),
(53, 6, 7, 13, '01', 'Gaji Karyawan', NULL, NULL, 0, NULL),
(54, 6, 7, 13, '02', 'Tunjangan', NULL, NULL, 0, NULL),
(55, 6, 7, 13, '03', 'Konsumsi', NULL, NULL, 0, NULL),
(56, 6, 7, 13, '04', 'Biaya Transport Dinas', NULL, NULL, 0, NULL),
(57, 6, 7, 13, '05', 'Biaya Pendidikan', NULL, NULL, 0, NULL),
(58, 6, 7, 14, '99', 'Biaya Kary. Lain-Lain', NULL, NULL, 0, NULL),
(59, 6, 7, 14, '01', 'Biaya Alat Tulis', NULL, NULL, 0, NULL),
(60, 6, 7, 14, '02', 'Biaya Listrik xx', NULL, NULL, 0, NULL),
(61, 6, 7, 14, '03', 'Biaya Telepon', NULL, NULL, 0, NULL),
(62, 6, 7, 14, '04', 'Biaya Air', NULL, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE IF NOT EXISTS `tb_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `userlevel` int(11) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`user_id`, `username`, `password`, `userlevel`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', -1);

-- --------------------------------------------------------

--
-- Table structure for table `view_akun_jurnal`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `db_tetrasma`.`view_akun_jurnal` AS select `db_tetrasma`.`tb_level4`.`level4_id` AS `level4_id`,concat(`db_tetrasma`.`tb_level1`.`level1_no`,'.',`db_tetrasma`.`tb_level2`.`level2_no`,'.',`db_tetrasma`.`tb_level3`.`level3_no`,'.',`db_tetrasma`.`tb_level4`.`level4_no`,' - ',`db_tetrasma`.`tb_level4`.`level4_nama`) AS `no_nama_akun`,`db_tetrasma`.`tb_level4`.`jurnal` AS `jurnal`,`db_tetrasma`.`tb_level4`.`jurnal_kode` AS `jurnal_kode` from (((`db_tetrasma`.`tb_level4` join `db_tetrasma`.`tb_level1` on((`db_tetrasma`.`tb_level4`.`level1_id` = `db_tetrasma`.`tb_level1`.`level1_id`))) join `db_tetrasma`.`tb_level2` on((`db_tetrasma`.`tb_level4`.`level2_id` = `db_tetrasma`.`tb_level2`.`level2_id`))) join `db_tetrasma`.`tb_level3` on((`db_tetrasma`.`tb_level4`.`level3_id` = `db_tetrasma`.`tb_level3`.`level3_id`)));

--
-- Dumping data for table `view_akun_jurnal`
--

INSERT INTO `view_akun_jurnal` (`level4_id`, `no_nama_akun`, `jurnal`, `jurnal_kode`) VALUES
(1, '1.1.1.01 - Kas', 1, 'K'),
(2, '1.1.1.02 - Bank BCA', 1, 'B'),
(3, '1.1.1.03 - Bank Mandiri', 1, 'B'),
(4, '1.1.3.01 - Pinjaman yang diberikan', 0, NULL),
(5, '1.1.3.02 - Asuransi dibayar dimuka', 0, NULL),
(6, '1.1.3.03 - Beban dibayar dimuka', 0, NULL),
(7, '1.1.3.04 - Penyisihan piutang tak tertagih', 0, NULL),
(8, '1.1.3.05 - Pendapatan ymh diterima', 0, NULL),
(9, '1.1.4.01 - Aktiva lain', 0, NULL),
(10, '1.2.1.01 - Tanah', 0, NULL),
(11, '1.2.1.02 - Bangunan', 0, NULL),
(12, '1.2.1.03 - Akumulasi Penyusutan Bangunan', 0, NULL),
(13, '1.2.1.04 - Peralatan / Mebel', 0, NULL),
(14, '1.2.1.05 - Akumulasi Penyusutan Peralatan / Mebel', 0, NULL),
(15, '1.2.1.06 - Inventaris Kantor', 0, NULL),
(16, '1.2.1.07 - Akumulasi Penyusutan Inventaris Kantor', 0, NULL),
(17, '2.1.1.01 - Simpanan Sukarela', 0, NULL),
(18, '2.1.1.02 - Simpanan Berjangka', 0, NULL),
(19, '2.1.1.03 - Simpanan Karyawan', 0, NULL),
(20, '2.1.1.04 - Hutang Bank', 0, NULL),
(21, '2.1.1.05 - Beban YMH Dibayar', 0, NULL),
(22, '2.1.1.99 - Hutang Lain-Lain', 0, NULL),
(23, '2.1.2.01 - Hutang Sewa', 0, NULL),
(24, '3.1.1.01 - Simpanan Pokok', 0, NULL),
(25, '3.1.1.02 - Simpanan Wajib', 0, NULL),
(26, '3.1.1.03 - Donasi', 0, NULL),
(27, '3.1.1.04 - Modal Penyertaan', 0, NULL),
(28, '3.1.1.05 - Cad. Tujuan Resiko', 0, NULL),
(29, '3.1.2.01 - Laba Periode Berjalan', 0, NULL),
(30, '3.1.2.02 - Cadangan SHU', 0, NULL),
(31, '4.1.1.01 - Pendapatan Bunga', 0, NULL),
(32, '4.1.1.02 - Pendapatan Provisi', 0, NULL),
(33, '4.1.1.03 - Pendapatan Administrasi', 0, NULL),
(34, '4.1.1.99 - Pendapatan Lainnya', 0, NULL),
(35, '5.1.1.01 - Biaya Langsung', 0, NULL),
(36, '6.1.1.01 - Bunga Simpanan', 0, NULL),
(37, '6.1.1.02 - Bunga Bank', 0, NULL),
(38, '6.1.1.03 - Bunga Simpanan Lain-Lain', 0, NULL),
(39, '6.1.1.04 - Bunga Simpanan Berjangka', 0, NULL),
(40, '6.1.1.05 - Bunga Simpanan Khusus', 0, NULL),
(41, '6.1.1.06 - Biaya Penysh. Piut. Tak Tertg.', 0, NULL),
(42, '6.1.1.07 - Biaya Asuransi', 0, NULL),
(43, '6.1.1.08 - Biaya Audit', 0, NULL),
(44, '6.1.1.09 - Biaya Pajak', 0, NULL),
(45, '6.1.1.99 - Biaya Keu. Lain-Lain', 0, NULL),
(46, '6.1.2.01 - Biaya Rapat Pengurus', 0, NULL),
(47, '6.1.2.02 - Biaya Rapat Anggota', 0, NULL),
(48, '6.1.2.03 - Biaya Perjalanan Dinas', 0, NULL),
(49, '6.1.2.04 - Biaya Diklat', 0, NULL),
(50, '6.1.2.05 - Biaya Honorarium Pengurus', 0, NULL),
(51, '6.1.2.06 - Biaya Pembinaan', 0, NULL),
(52, '6.1.2.99 - Biaya Org. Lain-Lain', 0, NULL),
(53, '6.1.3.01 - Gaji Karyawan', 0, NULL),
(54, '6.1.3.02 - Tunjangan', 0, NULL),
(55, '6.1.3.03 - Konsumsi', 0, NULL),
(56, '6.1.3.04 - Biaya Transport Dinas', 0, NULL),
(57, '6.1.3.05 - Biaya Pendidikan', 0, NULL),
(58, '6.1.4.99 - Biaya Kary. Lain-Lain', 0, NULL),
(59, '6.1.4.01 - Biaya Alat Tulis', 0, NULL),
(60, '6.1.4.02 - Biaya Listrik xx', 0, NULL),
(61, '6.1.4.03 - Biaya Telepon', 0, NULL),
(62, '6.1.4.04 - Biaya Air', 0, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
