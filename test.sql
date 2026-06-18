-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for pionir
CREATE DATABASE IF NOT EXISTS `pionir` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `pionir`;

-- Dumping structure for table pionir.activity_table
CREATE TABLE IF NOT EXISTS `activity_table` (
  `activity_table_id` int NOT NULL AUTO_INCREMENT,
  `activity_table_desc` text COLLATE utf8mb4_general_ci NOT NULL,
  `activity_table_user` int NOT NULL,
  `activity_table_module` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `activity_table_ref` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`activity_table_id`)
) ENGINE=InnoDB AUTO_INCREMENT=344 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pionir.activity_table: ~330 rows (approximately)
INSERT IGNORE INTO `activity_table` (`activity_table_id`, `activity_table_desc`, `activity_table_user`, `activity_table_module`, `activity_table_ref`, `created_at`) VALUES
	(1, 'Tambah Retur Pembelian Cabang  Ref: ', 1, '', 'RP/S-00001/31/05/2025/000001', '2025-05-31 09:56:02'),
	(2, 'Tambah Retur Pembelian Ke PT SERU Ref: ', 1, '', 'RP/S-00001/31/05/2025/000002', '2025-05-31 09:56:28'),
	(3, 'Tambah Retur Pembelian Ke PT SERU Ref: RP/S-00001/31/05/2025/000003', 1, '', 'RP/S-00001/31/05/2025/000003', '2025-05-31 09:56:38'),
	(4, 'Tambah Pengajuan Baru', 1, '', '', '2025-05-31 09:57:09'),
	(5, 'Tambah Pengajuan Baru', 1, '', '', '2025-05-31 09:58:17'),
	(6, 'Batalkan Pengajuan PJ/ADA001/Pusat/31/05/2025/000008', 1, '', 'PJ/ADA001/Pusat/31/05/2025/000008', '2025-05-31 09:58:20'),
	(7, 'Tambah Pengajuan Baru PJ/ADA001/Pusat/31/05/2025/000009', 1, '', 'PJ/ADA001/Pusat/31/05/2025/000009', '2025-05-31 10:00:59'),
	(8, 'Batalkan Pengajuan PJ/ADA001/Pusat/31/05/2025/000009', 1, '', 'PJ/ADA001/Pusat/31/05/2025/000009', '2025-05-31 10:01:07'),
	(9, 'Tambah Pengajuan Baru PJ/ADA001/SERDAM/31/05/2025/000010', 1, '', 'PJ/ADA001/SERDAM/31/05/2025/000010', '2025-05-31 10:02:04'),
	(10, 'Edit Pengajuan PJ/ADA001/SERDAM/31/05/2025/000010', 1, '', 'PJ/ADA001/SERDAM/31/05/2025/000010', '2025-05-31 10:04:36'),
	(11, 'Tambah PO Cabang Pusat Ref: PO/S-00001/PST/31/05/2025/000002', 1, '', 'PO/S-00001/PST/31/05/2025/000002', '2025-05-31 10:08:03'),
	(12, 'Batalkan PO', 1, '', 'Batalkan PO', '2025-05-31 10:10:24'),
	(13, 'Tambah PO Cabang Pusat Ref: PO/S-00001/PST/31/05/2025/000003', 1, '', 'PO/S-00001/PST/31/05/2025/000003', '2025-05-31 10:12:46'),
	(14, 'Tambah Input Stok Ref: IS/31/05/2025/000002', 1, '', 'IS/31/05/2025/000002', '2025-05-31 10:13:00'),
	(15, 'Batalkan Input Stock', 1, '', '', '2025-05-31 10:13:40'),
	(16, 'Batalkan Input Stock Ref: IS/28/05/2025/000001', 1, '', 'IS/28/05/2025/000001', '2025-05-31 19:40:01'),
	(17, 'Tambah Retur Pembelian Ref: RP/S-00001/31/05/2025/000001', 1, '', 'RP/S-00001/31/05/2025/000001', '2025-05-31 19:48:45'),
	(18, 'Tambah Retur Pembelian Ref: RP/S-00001/31/05/2025/000002', 1, '', 'RP/S-00001/31/05/2025/000002', '2025-05-31 19:51:46'),
	(19, 'Tambah Retur Pembelian Ref: RP/S-00001/31/05/2025/000003', 1, '', 'RP/S-00001/31/05/2025/000003', '2025-05-31 19:52:21'),
	(20, 'Tambah Retur Pembelian Ref: RP/S-00001/31/05/2025/000001', 1, '', 'RP/S-00001/31/05/2025/000001', '2025-05-31 19:53:34'),
	(21, 'Batal Retur Pembelian Ref: RP/S-00001/31/05/2025/000001', 1, '', 'RP/S-00001/31/05/2025/000001', '2025-06-04 10:56:29'),
	(22, 'Batal Retur Pembelian Ref: RP/S-00001/31/05/2025/000001', 1, '', 'RP/S-00001/31/05/2025/000001', '2025-06-04 10:56:37'),
	(23, 'Batal Retur Pembelian Ref: RP/S-00001/31/05/2025/000001', 1, '', 'RP/S-00001/31/05/2025/000001', '2025-06-04 10:57:06'),
	(24, 'Tambah Retur Pembelian Ref: RP/S-00001/09/06/2025/000002', 1, '', 'RP/S-00001/09/06/2025/000002', '2025-06-09 10:36:04'),
	(25, 'Tambah Retur Pembelian Ref: RP/S-00001/09/06/2025/000003', 1, '', 'RP/S-00001/09/06/2025/000003', '2025-06-09 17:29:08'),
	(26, 'Tambah Produk Baru', 1, '', '', '2025-06-10 09:48:15'),
	(27, 'Tambah Penjualan Cabang SERDAM PJ/ADR001/SDM/07/07/2025/000003', 1, '', '', '2025-07-07 15:12:51'),
	(28, 'Tambah Penjualan Cabang SERDAM PJ/ADR001/SDM/07/07/2025/000004', 1, '', '', '2025-07-07 15:16:21'),
	(29, 'Tambah Retur Penjualan Ref: RS/ADR001/12/07/2025/000003', 1, '', 'RS/ADR001/12/07/2025/000003', '2025-07-12 12:16:46'),
	(30, 'Batal Retur Pembelian Ref: RP/S-00001/09/06/2025/000003', 1, '', 'RP/S-00001/09/06/2025/000003', '2025-07-19 10:05:25'),
	(31, 'Batal Retur Penjualan Ref: RS/ADR001/12/07/2025/000003', 1, '', 'RS/ADR001/12/07/2025/000003', '2025-07-19 10:19:36'),
	(32, 'Batal Retur Penjualan Ref: RS/ADR001/12/07/2025/000003', 1, '', 'RS/ADR001/12/07/2025/000003', '2025-07-19 10:19:44'),
	(33, 'Batal Retur Penjualan Ref: RS/ADR001/12/07/2025/000003', 1, '', 'RS/ADR001/12/07/2025/000003', '2025-07-19 10:19:58'),
	(34, 'Batal Retur Penjualan Ref: RS/ADR001/12/07/2025/000003', 1, '', 'RS/ADR001/12/07/2025/000003', '2025-07-19 10:20:40'),
	(35, 'Batal Retur Penjualan Ref: RS/ADR001/12/07/2025/000003', 1, '', 'RS/ADR001/12/07/2025/000003', '2025-07-19 10:22:00'),
	(36, 'Batal Retur Penjualan Ref: RS/ADR001/12/07/2025/000003', 1, '', 'RS/ADR001/12/07/2025/000003', '2025-07-19 10:22:17'),
	(37, 'Batal Retur Penjualan Ref: RS/ADR001/12/07/2025/000003', 1, '', 'RS/ADR001/12/07/2025/000003', '2025-07-19 10:22:49'),
	(38, 'Tambah Pengajuan Baru PJ/ADA001/PEOK/24/07/2025/000001', 1, '', 'PJ/ADA001/PEOK/24/07/2025/000001', '2025-07-24 21:59:46'),
	(39, 'Tambah PO Cabang PEOK Ref: PO/S-00001/P/24/07/2025/000001', 1, '', 'PO/S-00001/P/24/07/2025/000001', '2025-07-24 22:00:22'),
	(40, 'Tambah Input Stok Ref: IS/24/07/2025/000001', 1, '', 'IS/24/07/2025/000001', '2025-07-24 23:30:19'),
	(41, 'Tambah Pembelian Cabang PEOK Ref: LBM/S-00001/P/24/07/2025/000002', 1, '', 'LBM/S-00001/P/24/07/2025/000002', '2025-07-24 23:30:39'),
	(42, 'Tambah PO Cabang PEOK Ref: PO/S-00001/P/24/07/2025/000002', 1, '', 'PO/S-00001/P/24/07/2025/000002', '2025-07-24 23:43:44'),
	(43, 'Tambah Input Stok Ref: IS/24/07/2025/000002', 1, '', 'IS/24/07/2025/000002', '2025-07-24 23:46:07'),
	(44, 'Tambah Pembelian Cabang PEOK Ref: LBM/S-00001/P/24/07/2025/000003', 1, '', 'LBM/S-00001/P/24/07/2025/000003', '2025-07-24 23:46:38'),
	(45, 'Tambah Retur Pembelian Ref: RP/S-00001/24/07/2025/000001', 1, '', 'RP/S-00001/24/07/2025/000001', '2025-07-24 23:48:51'),
	(46, 'Tambah PO Cabang KUNING Ref: PO/S-00001/K/25/07/2025/000003', 1, '', 'PO/S-00001/K/25/07/2025/000003', '2025-07-25 13:06:33'),
	(47, 'Tambah Pelunasan Hutang Ref: PH/S-00001/28/07/2025/000004', 1, '', 'PH/S-00001/28/07/2025/000004', '2025-07-29 00:44:44'),
	(48, 'Tambah Pelunasan Hutang Ref: PH/S-00001/28/07/2025/000005', 1, '', 'PH/S-00001/28/07/2025/000005', '2025-07-29 00:45:17'),
	(49, 'Tambah Pelunasan Hutang Ref: PH/S-00001/30/07/2025/000006', 1, '', 'PH/S-00001/30/07/2025/000006', '2025-07-30 20:22:30'),
	(50, 'Tambah Pelunasan Hutang Ref: PH/S-00001/30/07/2025/000007', 1, '', 'PH/S-00001/30/07/2025/000007', '2025-07-30 20:22:32'),
	(51, 'Tambah Pelunasan Hutang Ref: PH/S-00001/30/07/2025/000008', 1, '', 'PH/S-00001/30/07/2025/000008', '2025-07-30 20:22:33'),
	(52, 'Tambah Pelunasan Hutang Ref: PH/S-00001/30/07/2025/000009', 1, '', 'PH/S-00001/30/07/2025/000009', '2025-07-30 20:22:39'),
	(53, 'Tambah Pelunasan Hutang Ref: PH/S-00001/30/07/2025/000010', 1, '', 'PH/S-00001/30/07/2025/000010', '2025-07-30 20:24:10'),
	(54, 'Tambah Pelunasan Hutang Ref: PH/S-00001/30/07/2025/000011', 1, '', 'PH/S-00001/30/07/2025/000011', '2025-07-30 20:24:29'),
	(55, 'Tambah Pelunasan Hutang Ref: PH/S-00001/30/07/2025/000013', 1, '', 'PH/S-00001/30/07/2025/000013', '2025-07-30 21:29:58'),
	(56, 'Tambah Pelunasan Piutang Ref: PP//09/08/2025/000001', 1, '', 'PP//09/08/2025/000001', '2025-08-09 12:32:01'),
	(57, 'Tambah Pelunasan Piutang Ref: PP/ADR001/09/08/2025/000001', 1, '', 'PP/ADR001/09/08/2025/000001', '2025-08-09 12:32:24'),
	(58, 'Tambah Pelunasan Piutang Ref: PP/ADR001/09/08/2025/000002', 1, '', 'PP/ADR001/09/08/2025/000002', '2025-08-09 12:34:46'),
	(59, 'Tambah Pelunasan Hutang Ref: PH/S-00001/10/08/2025/000014', 1, '', 'PH/S-00001/10/08/2025/000014', '2025-08-10 23:08:13'),
	(60, 'Tambah Penjualan Cabang SERDAM PJ/ADR001/SDM/23/08/2025/000004', 1, '', '', '2025-08-23 11:17:20'),
	(61, 'Tambah Penjualan Cabang Pusat PJ/ADR001/PST/27/08/2025/000004', 1, '', '', '2025-08-27 23:36:59'),
	(62, 'Tambah Penjualan Cabang Pusat PJ/ADR002/PST/27/08/2025/000005', 1, '', '', '2025-08-27 23:39:33'),
	(63, 'Tambah Penjualan Cabang Pusat PJ/ADR001/PST/27/08/2025/000006', 1, '', '', '2025-08-27 23:52:03'),
	(64, 'Tambah Penjualan Cabang Pusat PJ/ADR001/PST/27/08/2025/000001', 1, '', '', '2025-08-28 00:19:10'),
	(65, 'Tambah Penjualan Cabang Pusat PJ/ADR002/PST/27/08/2025/000002', 1, '', '', '2025-08-28 00:20:42'),
	(66, 'Tambah Penjualan Cabang Pusat PJ/ADR001/PST/27/08/2025/000003', 1, '', '', '2025-08-28 00:22:26'),
	(67, 'Batalkan Penjualan PJ/ADR001/PST/27/08/2025/000001', 1, '', '', '2025-08-28 00:22:32'),
	(68, 'Batalkan Penjualan PJ/ADR001/PST/27/08/2025/000001', 1, '', '', '2025-08-28 00:23:32'),
	(69, 'Batalkan Penjualan PJ/ADR001/PST/27/08/2025/000001', 1, '', '', '2025-08-28 00:23:41'),
	(70, 'Batalkan Penjualan PJ/ADR001/PST/27/08/2025/000001', 1, '', '', '2025-08-28 00:24:41'),
	(71, 'Batalkan Penjualan PJ/ADR001/PST/27/08/2025/000003', 1, '', '', '2025-08-28 00:25:44'),
	(72, 'Tambah Penjualan Cabang Pusat RPJ/ADR001/PST/27/08/2025/000003', 1, '', '', '2025-08-28 01:31:35'),
	(73, 'Tambah Penjualan Cabang SERDAM PJ/ADR002/SDM/28/08/2025/000003', 1, '', '', '2025-08-28 20:40:35'),
	(74, 'Tambah Input Stok Ref: IS/28/08/2025/000003', 1, '', 'IS/28/08/2025/000003', '2025-08-29 01:47:58'),
	(75, 'Tambah Pembelian Cabang KUNING Ref: LBM/S-00001/K/28/08/2025/000004', 1, '', 'LBM/S-00001/K/28/08/2025/000004', '2025-08-29 01:52:47'),
	(76, 'Tambah Opname Cabang SERDAM Ref: OP/SDM/02/09/2025/000001', 1, '', 'OP/SDM/02/09/2025/000001', '2025-09-02 11:45:26'),
	(77, 'Tambah Opname Cabang SERDAM Ref: OP/SDM/02/09/2025/000002', 1, '', 'OP/SDM/02/09/2025/000002', '2025-09-02 11:48:58'),
	(78, 'Batalkan Penjualan RPJ/ADR001/PST/27/08/2025/000003', 1, '', '', '2025-09-03 12:16:08'),
	(79, 'Batal Transfer Stok Ref: TS/1/03/09/2025/000001', 1, '', 'TS/1/03/09/2025/000001', '2025-09-03 20:37:49'),
	(80, 'Batal Transfer Stok Ref: TS/1/03/09/2025/000002', 1, '', 'TS/1/03/09/2025/000002', '2025-09-03 23:36:30'),
	(81, 'Tambah PO Cabang SERDAM Ref: PO/S-00001/SDM/04/09/2025/000004', 1, '', 'PO/S-00001/SDM/04/09/2025/000004', '2025-09-04 13:58:48'),
	(82, 'Tambah PO Cabang Pusat Ref: PO/S-00001/PST/04/09/2025/000005', 1, '', 'PO/S-00001/PST/04/09/2025/000005', '2025-09-04 14:30:34'),
	(83, 'Tambah PO Cabang Pusat Ref: PO/S-00001/PST/04/09/2025/000001', 1, '', 'PO/S-00001/PST/04/09/2025/000001', '2025-09-04 14:33:41'),
	(84, 'Tambah PO Cabang Pusat Ref: PO/S-00001/PST/04/09/2025/000003', 1, '', 'PO/S-00001/PST/04/09/2025/000003', '2025-09-04 14:36:09'),
	(85, 'Tambah PO Cabang Bongkar Barang Ref: PO/S-00001/BB/04/09/2025/000001', 1, '', 'PO/S-00001/BB/04/09/2025/000001', '2025-09-04 14:37:02'),
	(86, 'Tambah PO Cabang Pusat Ref: PO/S-00001/PST/04/09/2025/000002', 1, '', 'PO/S-00001/PST/04/09/2025/000002', '2025-09-04 15:01:06'),
	(87, 'Batalkan PO Ref: PO/S-00001/BB/04/09/2025/000001', 1, '', 'PO/S-00001/BB/04/09/2025/000001', '2025-09-04 15:01:55'),
	(88, 'Batalkan PO Ref: PO/S-00001/BB/04/09/2025/000001', 1, '', 'PO/S-00001/BB/04/09/2025/000001', '2025-09-04 15:02:09'),
	(89, 'Batalkan PO Ref: PO/S-00001/PST/04/09/2025/000002', 1, '', 'PO/S-00001/PST/04/09/2025/000002', '2025-09-04 15:02:22'),
	(90, 'Tambah PO Cabang Pusat Ref: PO/S-00001/PST/04/09/2025/000003', 1, '', 'PO/S-00001/PST/04/09/2025/000003', '2025-09-04 15:03:06'),
	(91, 'Batalkan PO Ref: PO/S-00001/PST/04/09/2025/000003', 1, '', 'PO/S-00001/PST/04/09/2025/000003', '2025-09-04 15:03:08'),
	(92, 'Tambah PO Cabang SERDAM Ref: PO/S-00001/SDM/04/09/2025/000004', 1, '', 'PO/S-00001/SDM/04/09/2025/000004', '2025-09-04 15:06:01'),
	(93, 'Tambah Input Stok Ref: IS/04/09/2025/000001', 1, '', 'IS/04/09/2025/000001', '2025-09-04 20:02:29'),
	(94, 'Tambah Input Stok Ref: IS/04/09/2025/000002', 1, '', 'IS/04/09/2025/000002', '2025-09-04 20:02:34'),
	(95, 'Tambah Input Stok Ref: IS/04/09/2025/000003', 1, '', 'IS/04/09/2025/000003', '2025-09-04 20:04:37'),
	(96, 'Tambah Input Stok Ref: IS/04/09/2025/000004', 1, '', 'IS/04/09/2025/000004', '2025-09-04 20:05:18'),
	(97, 'Tambah PO Cabang SERDAM Ref: PO/S-00001/SDM/04/09/2025/000005', 1, '', 'PO/S-00001/SDM/04/09/2025/000005', '2025-09-04 20:10:01'),
	(98, 'Tambah PO Cabang SERDAM Ref: PO/S-00001/SDM/08/09/2025/000001', 1, '', 'PO/S-00001/SDM/08/09/2025/000001', '2025-09-08 23:12:09'),
	(99, 'Tambah Input Stok Ref: IS/08/09/2025/000001', 1, '', 'IS/08/09/2025/000001', '2025-09-08 23:12:24'),
	(100, 'Tambah Pembelian Cabang SERDAM Ref: LBM/S-00001/SDM/08/09/2025/000001', 1, '', 'LBM/S-00001/SDM/08/09/2025/000001', '2025-09-08 23:19:44'),
	(101, 'Tambah Pengajuan Baru PJ/ADA001/Pusat/08/09/2025/000002', 1, '', 'PJ/ADA001/Pusat/08/09/2025/000002', '2025-09-09 01:28:52'),
	(102, 'Edit Pengajuan PJ/ADA001/Pusat/08/09/2025/000002', 1, '', 'PJ/ADA001/Pusat/08/09/2025/000002', '2025-09-09 01:33:10'),
	(103, 'Edit Pengajuan PJ/ADA001/Pusat/08/09/2025/000002', 1, '', 'PJ/ADA001/Pusat/08/09/2025/000002', '2025-09-09 01:34:02'),
	(104, 'Edit Pengajuan PJ/ADA001/Pusat/08/09/2025/000002', 1, '', 'PJ/ADA001/Pusat/08/09/2025/000002', '2025-09-09 01:34:13'),
	(105, 'Edit Pengajuan PJ/ADA001/Pusat/08/09/2025/000002', 1, '', 'PJ/ADA001/Pusat/08/09/2025/000002', '2025-09-09 01:34:42'),
	(106, 'Edit Pengajuan PJ/ADA001/Pusat/08/09/2025/000002', 1, '', 'PJ/ADA001/Pusat/08/09/2025/000002', '2025-09-09 01:34:48'),
	(107, 'Edit Pengajuan PJ/ADA001/Pusat/08/09/2025/000002', 1, '', 'PJ/ADA001/Pusat/08/09/2025/000002', '2025-09-09 01:34:55'),
	(108, 'Edit Pengajuan PJ/ADA001/Pusat/08/09/2025/000002', 1, '', 'PJ/ADA001/Pusat/08/09/2025/000002', '2025-09-09 01:38:24'),
	(109, 'Edit Pengajuan PJ/ADA001/Pusat/08/09/2025/000002', 1, '', 'PJ/ADA001/Pusat/08/09/2025/000002', '2025-09-09 01:38:31'),
	(110, 'Tambah Retur Pembelian Ref: RP/S-00001/09/09/2025/000002', 1, '', 'RP/S-00001/09/09/2025/000002', '2025-09-09 10:08:29'),
	(111, 'Tambah Sales Order Cabang SERDAM J/ADR001/SDM/09/09/2025/000001', 1, '', '', '2025-09-09 16:09:57'),
	(112, 'Tambah Sales Order Cabang Pusat J/ADR001/PST/09/09/2025/000002', 1, '', '', '2025-09-09 16:13:47'),
	(113, 'Tambah Sales Order Cabang Pusat J/ADR001/PST/09/09/2025/000003', 1, '', '', '2025-09-09 16:15:49'),
	(114, 'Tambah Pelunasan Hutang Ref: PH/S-00001/14/10/2025/000015', 1, '', 'PH/S-00001/14/10/2025/000015', '2025-10-15 02:26:02'),
	(115, 'Tambah Pelunasan Piutang Ref: PP/ADR002/14/10/2025/000003', 1, '', 'PP/ADR002/14/10/2025/000003', '2025-10-15 02:26:43'),
	(116, 'Tambah Pelunasan Piutang Ref: PP/ADR001/14/10/2025/000010', 1, '', 'PP/ADR001/14/10/2025/000010', '2025-10-15 02:32:43'),
	(117, 'Tambah Pelunasan Piutang Ref: PP/ADR001/14/10/2025/000011', 1, '', 'PP/ADR001/14/10/2025/000011', '2025-10-15 02:33:34'),
	(118, 'Tambah Pelunasan Piutang Ref: PP/ADR001/14/10/2025/000012', 1, '', 'PP/ADR001/14/10/2025/000012', '2025-10-15 02:33:48'),
	(119, 'Tambah PO Cabang SERDAM Ref: PO/S-00001/SDM/15/10/2025/000002', 1, '', 'PO/S-00001/SDM/15/10/2025/000002', '2025-10-15 11:49:06'),
	(120, 'Tambah PO Cabang Pusat Ref: PO/S-00001/PST/15/10/2025/000003', 1, '', 'PO/S-00001/PST/15/10/2025/000003', '2025-10-16 00:31:16'),
	(121, 'Tambah Input Stok Ref: IS/15/10/2025/000002', 1, '', 'IS/15/10/2025/000002', '2025-10-16 00:32:17'),
	(122, 'Edit Produk Baru', 1, '', '', '2025-11-03 09:33:33'),
	(123, 'Edit Produk Baru', 1, '', '', '2025-11-03 09:33:46'),
	(124, 'Edit Produk Baru', 1, '', '', '2025-11-03 09:38:48'),
	(125, 'Tambah Pembelian Cabang Pusat Ref: LBM/S-00001/PST/03/11/2025/000001', 1, '', 'LBM/S-00001/PST/03/11/2025/000001', '2025-11-03 10:37:33'),
	(126, 'Tambah Pembelian Cabang Pusat Ref: LBM/S-00001/PST/03/11/2025/000002', 1, '', 'LBM/S-00001/PST/03/11/2025/000002', '2025-11-03 10:38:34'),
	(127, 'Tambah Input Stok Ref: IS/03/11/2025/000003', 1, '', 'IS/03/11/2025/000003', '2025-11-03 12:45:17'),
	(128, 'Tambah Sales Order Cabang Pusat J/ADR001/PST/27/11/2025/000004', 1, '', '', '2025-11-28 01:46:27'),
	(129, 'Tambah Penjualan Cabang Pusat PJ/ADR001/PST/27/11/2025/000003', 1, '', '', '2025-11-28 01:53:04'),
	(130, 'Tambah Penjualan Cabang Pusat PJ/ADR001/PST/27/11/2025/000003', 1, '', '', '2025-11-28 01:53:28'),
	(131, 'Tambah Penjualan Cabang Pusat PJ/ADR001/PST/27/11/2025/000003', 1, '', '', '2025-11-28 01:54:04'),
	(132, 'Tambah Penjualan Cabang Pusat PJ/ADR001/PST/27/11/2025/000003', 1, '', '', '2025-11-28 01:54:29'),
	(133, 'Tambah Penjualan Cabang Pusat PJ/ADR001/PST/27/11/2025/000003', 1, '', '', '2025-11-28 01:56:49'),
	(134, 'Tambah Penjualan Cabang Pusat PJ/ADR001/PST/27/11/2025/000004', 1, '', '', '2025-11-28 01:56:59'),
	(135, 'Tambah Penjualan Cabang Pusat PJ/ADR001/PST/27/11/2025/000004', 1, '', '', '2025-11-28 01:57:14'),
	(136, 'Tambah Penjualan Cabang Pusat PJ/ADR001/PST/29/11/2025/000004', 1, '', '', '2025-11-29 16:38:11'),
	(137, 'Batalkan Penjualan PJ/ADR001/PST/29/11/2025/000004', 1, '', '', '2025-11-29 16:38:59'),
	(138, 'Tambah Penjualan Cabang Pusat PJ/ADR001/PST/29/11/2025/000004', 1, '', '', '2025-11-29 20:52:48'),
	(139, 'Tambah Sales Order Cabang Pusat J/ADR001/PST/29/11/2025/000001', 1, '', '', '2025-11-29 20:55:40'),
	(140, 'Tambah Penjualan Cabang Pusat PJ/ADR001/PST/29/11/2025/000001', 1, '', '', '2025-11-29 22:05:52'),
	(141, 'Batalkan Penjualan PJ/ADR001/PST/29/11/2025/000001', 1, '', '', '2025-11-29 22:06:01'),
	(142, 'Batalkan Penjualan PJ/ADR001/PST/29/11/2025/000001', 1, '', '', '2025-11-29 22:08:51'),
	(143, 'Batalkan Penjualan PJ/ADR001/PST/29/11/2025/000001', 1, '', '', '2025-11-29 22:09:14'),
	(144, 'Tambah Pengajuan Baru PJ/JAC00005/Pusat/02/12/2025/000003', 1, '', 'PJ/JAC00005/Pusat/02/12/2025/000003', '2025-12-02 18:07:46'),
	(145, 'Tambah Sales Order Cabang SERDAM J/ADR001/SDM/02/12/2025/000002', 1, '', '', '2025-12-02 18:30:34'),
	(146, 'Tambah PO Cabang Bongkar Barang Ref: PO/AL-012/BB/02/12/2025/000004', 1, '', 'PO/AL-012/BB/02/12/2025/000004', '2025-12-02 18:31:15'),
	(147, 'Tambah Input Stok Ref: IS/02/12/2025/000004', 1, '', 'IS/02/12/2025/000004', '2025-12-02 18:32:40'),
	(148, 'Tambah Pembelian Cabang Bongkar Barang Ref: LBM/AL-012/BB/02/12/2025/000001', 1, '', 'LBM/AL-012/BB/02/12/2025/000001', '2025-12-02 18:33:18'),
	(149, 'Tambah Pembelian Cabang Bongkar Barang Ref: LBM/AL-012/BB/02/12/2025/000001', 1, '', 'LBM/AL-012/BB/02/12/2025/000001', '2025-12-02 18:33:21'),
	(150, 'Tambah Pembelian Cabang Bongkar Barang Ref: LBM/AL-012/BB/02/12/2025/000001', 1, '', 'LBM/AL-012/BB/02/12/2025/000001', '2025-12-02 18:33:27'),
	(151, 'Tambah Pembelian Cabang Bongkar Barang Ref: LBM/AL-012/BB/02/12/2025/000001', 1, '', 'LBM/AL-012/BB/02/12/2025/000001', '2025-12-02 18:33:27'),
	(152, 'Tambah Pembelian Cabang Bongkar Barang Ref: LBM/AL-012/BB/02/12/2025/000001', 1, '', 'LBM/AL-012/BB/02/12/2025/000001', '2025-12-02 18:33:27'),
	(153, 'Tambah Pembelian Cabang Bongkar Barang Ref: LBM/AL-012/BB/02/12/2025/000001', 1, '', 'LBM/AL-012/BB/02/12/2025/000001', '2025-12-02 18:33:28'),
	(154, 'Tambah Pembelian Cabang Bongkar Barang Ref: LBM/AL-012/BB/02/12/2025/000001', 1, '', 'LBM/AL-012/BB/02/12/2025/000001', '2025-12-02 18:33:28'),
	(155, 'Tambah Pembelian Cabang Bongkar Barang Ref: LBM/AL-012/BB/02/12/2025/000001', 1, '', 'LBM/AL-012/BB/02/12/2025/000001', '2025-12-02 18:33:28'),
	(156, 'Tambah Pembelian Cabang Bongkar Barang Ref: LBM/AL-012/BB/02/12/2025/000001', 1, '', 'LBM/AL-012/BB/02/12/2025/000001', '2025-12-02 18:33:28'),
	(157, 'Tambah Pembelian Cabang Bongkar Barang Ref: LBM/AL-012/BB/02/12/2025/000001', 1, '', 'LBM/AL-012/BB/02/12/2025/000001', '2025-12-02 18:33:31'),
	(158, 'Tambah Pembelian Cabang Bongkar Barang Ref: LBM/AL-012/BB/02/12/2025/000001', 1, '', 'LBM/AL-012/BB/02/12/2025/000001', '2025-12-02 18:33:32'),
	(159, 'Tambah Pembelian Cabang Bongkar Barang Ref: LBM/AL-012/BB/02/12/2025/000001', 1, '', 'LBM/AL-012/BB/02/12/2025/000001', '2025-12-02 18:33:32'),
	(160, 'Tambah Pembelian Cabang Bongkar Barang Ref: LBM/AL-012/BB/02/12/2025/000001', 1, '', 'LBM/AL-012/BB/02/12/2025/000001', '2025-12-02 18:34:38'),
	(161, 'Tambah Pembelian Cabang Bongkar Barang Ref: LBM/AL-012/BB/02/12/2025/000001', 1, '', 'LBM/AL-012/BB/02/12/2025/000001', '2025-12-02 18:34:48'),
	(162, 'Tambah Retur Pembelian Ref: RP/AL-012/02/12/2025/000003', 1, '', 'RP/AL-012/02/12/2025/000003', '2025-12-02 18:36:00'),
	(163, 'Tambah Pengajuan Baru PJ/JAC00005/Bongkar Barang/30/01/2026/000004', 1, '', 'PJ/JAC00005/Bongkar Barang/30/01/2026/000004', '2026-01-30 14:44:47'),
	(164, 'Tambah Pengajuan Baru PJ/KAB00007/Bongkar Barang/30/01/2026/000005', 1, '', 'PJ/KAB00007/Bongkar Barang/30/01/2026/000005', '2026-01-30 14:47:17'),
	(165, 'Tambah PO Cabang Bongkar Barang Ref: PO/AL-012/BB/30/01/2026/000005', 1, '', 'PO/AL-012/BB/30/01/2026/000005', '2026-01-30 14:48:49'),
	(166, 'Tambah Input Stok Ref: IS/30/01/2026/000005', 1, '', 'IS/30/01/2026/000005', '2026-01-30 14:52:03'),
	(167, 'Tambah Pembelian Cabang Bongkar Barang Ref: LBM/AL-012/BB/30/01/2026/000002', 1, '', 'LBM/AL-012/BB/30/01/2026/000002', '2026-01-30 14:53:23'),
	(168, 'Edit Produk Baru', 1, '', '', '2026-02-16 12:10:00'),
	(169, 'Tambah Pengajuan Baru PJ/JAC00005/Bongkar Barang/16/02/2026/000006', 1, '', 'PJ/JAC00005/Bongkar Barang/16/02/2026/000006', '2026-02-16 12:43:53'),
	(170, 'Tambah Pengajuan Baru PJ/ADA001/Bongkar Barang/16/02/2026/000007', 1, '', 'PJ/ADA001/Bongkar Barang/16/02/2026/000007', '2026-02-16 12:44:14'),
	(171, 'Tambah PO Cabang Bongkar Barang Ref: PO/DO-010/BB/16/02/2026/000006', 1, '', 'PO/DO-010/BB/16/02/2026/000006', '2026-02-16 12:45:20'),
	(172, 'Tambah PO Cabang Bongkar Barang Ref: PO/AL-012/BB/16/02/2026/000007', 1, '', 'PO/AL-012/BB/16/02/2026/000007', '2026-02-16 12:45:57'),
	(173, 'Tambah Input Stok Ref: IS/16/02/2026/000006', 1, '', 'IS/16/02/2026/000006', '2026-02-16 12:54:38'),
	(174, 'Tambah Input Stok Ref: IS/16/02/2026/000007', 1, '', 'IS/16/02/2026/000007', '2026-02-16 12:54:38'),
	(175, 'Tambah Input Stok Ref: IS/16/02/2026/000008', 1, '', 'IS/16/02/2026/000008', '2026-02-16 12:54:38'),
	(176, 'Tambah Input Stok Ref: IS/16/02/2026/000009', 1, '', 'IS/16/02/2026/000009', '2026-02-16 12:54:38'),
	(177, 'Tambah Input Stok Ref: IS/16/02/2026/000010', 1, '', 'IS/16/02/2026/000010', '2026-02-16 12:54:38'),
	(178, 'Tambah Input Stok Ref: IS/16/02/2026/000011', 1, '', 'IS/16/02/2026/000011', '2026-02-16 12:55:27'),
	(179, 'Tambah Pembelian Cabang Bongkar Barang Ref: LBM/DO-010/BB/16/02/2026/000003', 1, '', 'LBM/DO-010/BB/16/02/2026/000003', '2026-02-16 13:03:26'),
	(180, 'Tambah Pembelian Cabang Bongkar Barang Ref: LBM/DO-010/BB/16/02/2026/000004', 1, '', 'LBM/DO-010/BB/16/02/2026/000004', '2026-02-16 13:03:48'),
	(181, 'Tambah Pengajuan Baru PJ/ADA001/Bongkar Barang/16/02/2026/000008', 1, '', 'PJ/ADA001/Bongkar Barang/16/02/2026/000008', '2026-02-16 13:05:08'),
	(182, 'Tambah Pengajuan Baru PJ/JAC00005/Bongkar Barang/16/02/2026/000009', 1, '', 'PJ/JAC00005/Bongkar Barang/16/02/2026/000009', '2026-02-16 13:05:24'),
	(183, 'Tambah Penjualan Cabang SERDAM PJ/ADR001/SDM/16/02/2026/000002', 1, '', '', '2026-02-16 13:11:25'),
	(184, 'Tambah Sales Order Cabang SERDAM J/ADR001/SDM/16/02/2026/000003', 1, '', '', '2026-02-16 13:13:29'),
	(185, 'Tambah Penjualan Cabang SERDAM PJ/ADR001/SDM/16/02/2026/000003', 1, '', '', '2026-02-16 13:14:14'),
	(186, 'Tambah Retur Penjualan Ref: RS/ADR001/16/02/2026/000004', 1, '', 'RS/ADR001/16/02/2026/000004', '2026-02-16 13:16:11'),
	(187, 'Tambah Pengajuan Baru PJ/JAC00005/Bongkar Barang/02/03/2026/000010', 1, '', 'PJ/JAC00005/Bongkar Barang/02/03/2026/000010', '2026-03-02 10:26:58'),
	(188, 'Tambah Pengajuan Baru PJ/ADA001/Bongkar Barang/02/03/2026/000011', 1, '', 'PJ/ADA001/Bongkar Barang/02/03/2026/000011', '2026-03-02 10:27:14'),
	(189, 'Tambah PO Cabang Bongkar Barang Ref: PO/AL-012/BB/02/03/2026/000008', 1, '', 'PO/AL-012/BB/02/03/2026/000008', '2026-03-02 10:29:25'),
	(190, 'Tambah Input Stok Ref: IS/02/03/2026/000012', 1, '', 'IS/02/03/2026/000012', '2026-03-02 10:30:10'),
	(191, 'Tambah Pembelian Cabang Bongkar Barang Ref: LBM/AL-012/BB/02/03/2026/000005', 1, '', 'LBM/AL-012/BB/02/03/2026/000005', '2026-03-02 10:30:47'),
	(192, 'Batalkan Pengajuan PJ/JAC00005/Bongkar Barang/16/02/2026/000009', 1, '', 'PJ/JAC00005/Bongkar Barang/16/02/2026/000009', '2026-03-02 10:37:30'),
	(193, 'Batalkan Pengajuan PJ/ADA001/Bongkar Barang/16/02/2026/000008', 1, '', 'PJ/ADA001/Bongkar Barang/16/02/2026/000008', '2026-03-02 10:37:32'),
	(194, 'Tambah Pengajuan Baru PJ/ADA001/Bongkar Barang/02/03/2026/000012', 1, '', 'PJ/ADA001/Bongkar Barang/02/03/2026/000012', '2026-03-02 10:37:44'),
	(195, 'Tambah Retur Pembelian Ref: RP/AL-012/02/03/2026/000004', 1, '', 'RP/AL-012/02/03/2026/000004', '2026-03-02 10:38:18'),
	(196, 'Tambah Pengajuan Baru PJ/JAC00005/Bongkar Barang/07/03/2026/000013', 1, '', 'PJ/JAC00005/Bongkar Barang/07/03/2026/000013', '2026-03-07 09:50:43'),
	(197, 'Tambah PO Cabang Bongkar Barang Ref: PO/S-00001/BB/07/03/2026/000009', 1, '', 'PO/S-00001/BB/07/03/2026/000009', '2026-03-07 09:51:50'),
	(198, 'Tambah Input Stok Ref: IS/07/03/2026/000013', 1, '', 'IS/07/03/2026/000013', '2026-03-07 09:53:38'),
	(199, 'Tambah Pembelian Cabang Bongkar Barang Ref: LBM/S-00001/BB/07/03/2026/000006', 1, '', 'LBM/S-00001/BB/07/03/2026/000006', '2026-03-07 09:54:51'),
	(200, 'Tambah Sales Order Cabang SERDAM J/BEN001/SDM/07/03/2026/000004', 1, '', '', '2026-03-07 10:08:31'),
	(201, 'Tambah Penjualan Cabang SERDAM PJ/BEN001/SDM/07/03/2026/000004', 1, '', '', '2026-03-07 10:11:35'),
	(202, 'Tambah Sales Order Cabang SERDAM J/BEN003/SDM/07/03/2026/000005', 1, '', '', '2026-03-07 10:14:49'),
	(203, 'Tambah Penjualan Cabang SERDAM PJ/BEN003/SDM/07/03/2026/000005', 1, '', '', '2026-03-07 10:17:19'),
	(204, 'Tambah Sales Order Cabang SERDAM J/BEN003/SDM/07/03/2026/000006', 1, '', '', '2026-03-07 10:22:14'),
	(205, 'Tambah Penjualan Cabang SERDAM PJ/BEN003/SDM/07/03/2026/000006', 1, '', '', '2026-03-07 10:22:40'),
	(206, 'Tambah Retur Penjualan Ref: RS/BEN003/07/03/2026/000005', 1, '', 'RS/BEN003/07/03/2026/000005', '2026-03-07 13:47:15'),
	(207, 'Tambah PO Cabang Pusat Ref: PO/S-00001/PST/07/03/2026/000010', 1, '', 'PO/S-00001/PST/07/03/2026/000010', '2026-03-07 14:09:42'),
	(208, 'Tambah Input Stok Ref: IS/07/03/2026/000014', 1, '', 'IS/07/03/2026/000014', '2026-03-07 14:10:12'),
	(209, 'Tambah Pembelian Cabang Pusat Ref: LBM/S-00001/PST/07/03/2026/000007', 1, '', 'LBM/S-00001/PST/07/03/2026/000007', '2026-03-07 14:10:28'),
	(210, 'Edit Produk Baru', 1, '', '', '2026-03-09 12:37:20'),
	(211, 'Edit Produk Baru', 1, '', '', '2026-03-09 12:38:42'),
	(212, 'Tambah PO Cabang Pusat Ref: PO/SF-011/PST/09/03/2026/000011', 1, '', 'PO/SF-011/PST/09/03/2026/000011', '2026-03-09 12:45:16'),
	(213, 'Tambah PO Cabang Pusat Ref: PO/SF-011/PST/09/03/2026/000011', 1, '', 'PO/SF-011/PST/09/03/2026/000011', '2026-03-09 12:45:33'),
	(214, 'Tambah PO Cabang Pusat Ref: PO/SF-011/PST/09/03/2026/000011', 1, '', 'PO/SF-011/PST/09/03/2026/000011', '2026-03-09 12:45:45'),
	(215, 'Tambah Opname Cabang SERDAM Ref: OP/SDM/09/03/2026/000003', 1, '', 'OP/SDM/09/03/2026/000003', '2026-03-09 12:47:59'),
	(216, 'Tambah Opname Cabang SERDAM Ref: OP/SDM/09/03/2026/000004', 1, '', 'OP/SDM/09/03/2026/000004', '2026-03-09 12:48:16'),
	(217, 'Tambah Sales Order Cabang SERDAM J/ADR001/SDM/09/03/2026/000007', 1, '', '', '2026-03-09 12:49:41'),
	(218, 'Tambah Penjualan Cabang SERDAM PJ/ADR001/SDM/09/03/2026/000007', 1, '', '', '2026-03-09 12:50:27'),
	(219, 'Tambah Sales Order Cabang SERDAM J/BEN003/SDM/09/03/2026/000008', 1, '', '', '2026-03-09 12:58:35'),
	(220, 'Tambah Penjualan Cabang SERDAM PJ/BEN003/SDM/09/03/2026/000008', 1, '', '', '2026-03-09 12:58:47'),
	(221, 'Tambah Pelunasan Piutang Ref: PP/BEN003/09/03/2026/000013', 1, '', 'PP/BEN003/09/03/2026/000013', '2026-03-09 12:59:14'),
	(222, 'Tambah Sales Order Cabang SERDAM J/BEN003/SDM/09/03/2026/000009', 1, '', '', '2026-03-09 13:05:52'),
	(223, 'Tambah Penjualan Cabang SERDAM PJ/BEN003/SDM/09/03/2026/000009', 1, '', '', '2026-03-09 13:06:30'),
	(224, 'Tambah Pelunasan Piutang Ref: PP/BEN003/09/03/2026/000014', 1, '', 'PP/BEN003/09/03/2026/000014', '2026-03-09 13:08:07'),
	(225, 'Tambah Sales Order Cabang SERDAM J/BEN003/SDM/09/03/2026/000010', 1, '', '', '2026-03-09 13:08:51'),
	(226, 'Tambah Penjualan Cabang SERDAM PJ/BEN003/SDM/09/03/2026/000010', 1, '', '', '2026-03-09 13:09:09'),
	(227, 'Tambah Sales Order Cabang SERDAM J/BEN003/SDM/09/03/2026/000011', 1, '', '', '2026-03-09 13:09:47'),
	(228, 'Tambah Penjualan Cabang SERDAM PJ/BEN003/SDM/09/03/2026/000011', 1, '', '', '2026-03-09 13:09:56'),
	(229, 'Tambah PO Cabang Bongkar Barang Ref: PO/SF-011/BB/09/03/2026/000012', 1, '', 'PO/SF-011/BB/09/03/2026/000012', '2026-03-09 13:38:04'),
	(230, 'Tambah Input Stok Ref: IS/09/03/2026/000015', 1, '', 'IS/09/03/2026/000015', '2026-03-09 13:38:25'),
	(231, 'Tambah Pembelian Cabang Bongkar Barang Ref: LBM/SF-011/BB/09/03/2026/000008', 1, '', 'LBM/SF-011/BB/09/03/2026/000008', '2026-03-09 13:38:54'),
	(232, 'Tambah PO Cabang Bongkar Barang Ref: PO/SF-011/BB/09/03/2026/000013', 1, '', 'PO/SF-011/BB/09/03/2026/000013', '2026-03-09 13:40:49'),
	(233, 'Tambah Input Stok Ref: IS/09/03/2026/000016', 1, '', 'IS/09/03/2026/000016', '2026-03-09 13:41:06'),
	(234, 'Tambah Pembelian Cabang Bongkar Barang Ref: LBM/SF-011/BB/09/03/2026/000009', 1, '', 'LBM/SF-011/BB/09/03/2026/000009', '2026-03-09 13:41:16'),
	(235, 'Tambah PO Cabang Bongkar Barang Ref: PO/SF-011/BB/09/03/2026/000014', 1, '', 'PO/SF-011/BB/09/03/2026/000014', '2026-03-09 13:42:24'),
	(236, 'Tambah Input Stok Ref: IS/09/03/2026/000017', 1, '', 'IS/09/03/2026/000017', '2026-03-09 13:45:55'),
	(237, 'Tambah Pembelian Cabang Bongkar Barang Ref: LBM/SF-011/BB/09/03/2026/000010', 1, '', 'LBM/SF-011/BB/09/03/2026/000010', '2026-03-09 13:46:09'),
	(238, 'Tambah Pelunasan Hutang Ref: PH/SF-011/09/03/2026/000016', 1, '', 'PH/SF-011/09/03/2026/000016', '2026-03-09 13:47:47'),
	(239, 'Tambah Input Stok Ref: IS/11/03/2026/000018', 1, '', 'IS/11/03/2026/000018', '2026-03-11 10:54:42'),
	(240, 'Tambah Pembelian Cabang Pusat Ref: LBM/SF-011/PST/11/03/2026/000011', 1, '', 'LBM/SF-011/PST/11/03/2026/000011', '2026-03-11 10:55:13'),
	(241, 'Edit Produk Baru', 1, '', '', '2026-03-11 11:02:51'),
	(242, 'Edit Produk Baru', 1, '', '', '2026-03-11 11:03:02'),
	(243, 'Tambah Pengajuan Baru PJ/ADA001/Pusat/17/03/2026/000014', 1, '', 'PJ/ADA001/Pusat/17/03/2026/000014', '2026-03-17 13:13:20'),
	(244, 'Tambah PO Cabang Pusat Ref: PO/SF-011/PST/17/03/2026/000015', 1, '', 'PO/SF-011/PST/17/03/2026/000015', '2026-03-17 13:14:38'),
	(245, 'Tambah Sales Order Cabang Pusat J/ADR001/PST/18/03/2026/000012', 1, '', '', '2026-03-18 10:30:50'),
	(246, 'Tambah Sales Order Cabang Pusat J/ADR001/PST/18/03/2026/000013', 1, '', '', '2026-03-18 10:44:05'),
	(247, 'Batalkan Sales Order J/ADR001/PST/18/03/2026/000013', 1, '', '', '2026-03-18 10:46:34'),
	(248, 'Batalkan Sales Order J/ADR001/PST/18/03/2026/000013', 1, '', '', '2026-03-18 10:46:44'),
	(249, 'Tambah Sales Order Cabang Pusat J/ADR001/PST/18/03/2026/000014', 1, '', '', '2026-03-18 15:32:33'),
	(250, 'Tambah Sales Order Cabang Pusat J/ADR001/PST/18/03/2026/000015', 1, '', '', '2026-03-18 15:32:55'),
	(251, 'Edit Sales Order Cabang Pusat J/ADR001/PST/18/03/2026/000015', 1, '', '', '2026-03-18 16:08:39'),
	(252, 'Tambah Sales Order Cabang Pusat J/ADR001/PST/18/03/2026/000016', 1, '', '', '2026-03-18 16:09:37'),
	(253, 'Edit Sales Order Cabang Pusat J/ADR001/PST/18/03/2026/000016', 1, '', '', '2026-03-18 16:09:48'),
	(254, 'Batalkan Penjualan PJ/BEN003/SDM/09/03/2026/000011', 1, '', '', '2026-03-18 17:59:47'),
	(255, 'Batalkan Penjualan PJ/BEN003/SDM/09/03/2026/000010', 1, '', '', '2026-03-18 18:24:33'),
	(256, 'Batalkan Penjualan PJ/BEN003/SDM/09/03/2026/000009', 1, '', '', '2026-03-18 18:24:44'),
	(257, 'Tambah Penjualan Cabang Pusat PJ/ADR001/PST/18/03/2026/000012', 1, '', '', '2026-03-18 19:47:03'),
	(258, 'Tambah Sales Order Cabang Pusat J/ADR001/PST/18/03/2026/000017', 1, '', '', '2026-03-18 19:50:32'),
	(259, 'Tambah Penjualan Cabang Pusat PJ/ADR001/PST/18/03/2026/000013', 1, '', '', '2026-03-18 19:50:45'),
	(260, 'Tambah Sales Order Cabang Pusat J/ADR001/PST/19/03/2026/000001', 1, '', '', '2026-03-19 09:18:14'),
	(261, 'Tambah Penjualan Cabang Pusat PJ/ADR001/PST/19/03/2026/000001', 1, '', '', '2026-03-19 09:19:09'),
	(262, 'Tambah Penjualan Cabang Pusat PJ/ADR001/PST/19/03/2026/000002', 1, '', '', '2026-03-19 09:19:58'),
	(263, 'Tambah Sales Order Cabang Pusat J/ADR001/PST/19/03/2026/000002', 1, '', '', '2026-03-19 09:21:22'),
	(264, 'Tambah Penjualan Cabang Pusat PJ/ADR001/PST/19/03/2026/000002', 1, '', '', '2026-03-19 09:21:33'),
	(265, 'Tambah Sales Order Cabang Pusat J/ADR001/PST/19/03/2026/000003', 1, '', '', '2026-03-19 09:22:09'),
	(266, 'Tambah Penjualan Cabang Pusat PJ/ADR001/PST/19/03/2026/000003', 1, '', '', '2026-03-19 09:22:22'),
	(267, 'Batalkan Penjualan PJ/ADR001/PST/19/03/2026/000002', 1, '', '', '2026-03-19 09:49:11'),
	(268, 'Batalkan Penjualan PJ/ADR001/PST/19/03/2026/000003', 1, '', '', '2026-03-19 09:55:00'),
	(269, 'Batalkan Penjualan PJ/ADR001/PST/19/03/2026/000002', 1, '', '', '2026-03-19 09:55:09'),
	(270, 'Tambah Retur Penjualan Ref: RS/ADR001/19/03/2026/000001', 1, '', 'RS/ADR001/19/03/2026/000001', '2026-03-19 10:13:04'),
	(271, 'Tambah Penjualan Cabang SERDAM PJ/ADR001/SDM/20/03/2026/000004', 1, '', '', '2026-03-20 14:14:22'),
	(272, 'Tambah Penjualan Cabang SERDAM PJ/ADR001/SDM/20/03/2026/000004', 1, '', '', '2026-03-20 19:20:49'),
	(273, 'Tambah Retur Penjualan Ref: RS/ADR001/20/03/2026/000002', 1, '', 'RS/ADR001/20/03/2026/000002', '2026-03-20 19:23:42'),
	(274, 'Tambah Penjualan Cabang Pusat PJ/ADR002/PST/20/03/2026/000001', 1, '', '', '2026-03-20 19:26:31'),
	(275, 'Tambah Penjualan Cabang SERDAM PJ/BEN001/SDM/20/03/2026/000002', 1, '', '', '2026-03-20 19:36:34'),
	(276, 'Tambah Retur Penjualan Ref: RS/BEN001/20/03/2026/000001', 1, '', 'RS/BEN001/20/03/2026/000001', '2026-03-20 19:46:06'),
	(277, 'Tambah Penjualan Cabang SERDAM PJ/BEN003/SDM/20/03/2026/000002', 1, '', '', '2026-03-20 19:47:04'),
	(278, 'Tambah Retur Penjualan Ref: RS/BEN003/20/03/2026/000002', 1, '', 'RS/BEN003/20/03/2026/000002', '2026-03-20 19:47:25'),
	(279, 'Tambah Sales Order Cabang SERDAM J/ADR001/SDM/22/03/2026/000004', 1, '', '', '2026-03-22 16:43:12'),
	(280, 'Edit Sales Order Cabang SERDAM J/ADR001/SDM/22/03/2026/000004', 1, '', '', '2026-03-22 16:47:43'),
	(281, 'Tambah Penjualan Cabang SERDAM PJ/ADR001/SDM/22/03/2026/000003', 1, '', '', '2026-03-22 16:48:01'),
	(282, 'Tambah Penjualan Cabang SERDAM PJ/ADR002/SDM/22/03/2026/000004', 1, '', '', '2026-03-22 16:51:10'),
	(283, 'Batalkan Penjualan PJ/ADR002/SDM/22/03/2026/000004', 1, '', '', '2026-03-22 16:51:38'),
	(284, 'Tambah Retur Penjualan Ref: RS/ADR001/22/03/2026/000003', 1, '', 'RS/ADR001/22/03/2026/000003', '2026-03-22 16:55:19'),
	(285, 'Tambah Retur Penjualan Ref: RS/ADR001/22/03/2026/000004', 1, '', 'RS/ADR001/22/03/2026/000004', '2026-03-22 16:57:36'),
	(286, 'Batalkan Pengajuan PJ/ADA001/Bongkar Barang/02/03/2026/000012', 1, '', 'PJ/ADA001/Bongkar Barang/02/03/2026/000012', '2026-03-30 10:18:12'),
	(287, 'Tambah Pengajuan Baru PJ/JAC00005/Pusat/30/03/2026/000015', 1, '', 'PJ/JAC00005/Pusat/30/03/2026/000015', '2026-03-30 10:18:41'),
	(288, 'Tambah Pengajuan Baru PJ/ADA001/Pusat/30/03/2026/000016', 1, '', 'PJ/ADA001/Pusat/30/03/2026/000016', '2026-03-30 10:18:53'),
	(289, 'Tambah PO Cabang Bongkar Barang Ref: PO/SF-011/BB/30/03/2026/000016', 1, '', 'PO/SF-011/BB/30/03/2026/000016', '2026-03-30 10:19:56'),
	(290, 'Tambah PO Cabang Bongkar Barang Ref: PO/SF-011/BB/30/03/2026/000016', 1, '', 'PO/SF-011/BB/30/03/2026/000016', '2026-03-30 10:20:40'),
	(291, 'Tambah Sales Order Cabang SERDAM J/ADR001/SDM/10/04/2026/000005', 1, '', '', '2026-04-10 11:38:28'),
	(292, 'Tambah Penjualan Cabang SERDAM PJ/ADR001/SDM/10/04/2026/000004', 1, '', '', '2026-04-10 11:38:55'),
	(293, 'Tambah Penjualan Cabang Pusat PJ/ADR001/PST/10/04/2026/000005', 1, '', '', '2026-04-10 11:39:41'),
	(294, 'Tambah Pengajuan Baru PJ/JAC00005/Bongkar Barang/08/05/2026/000017', 1, '', 'PJ/JAC00005/Bongkar Barang/08/05/2026/000017', '2026-05-08 14:33:39'),
	(295, 'Tambah Pengajuan Baru PJ/ADA001/Bongkar Barang/08/05/2026/000018', 1, '', 'PJ/ADA001/Bongkar Barang/08/05/2026/000018', '2026-05-08 14:34:12'),
	(296, 'Tambah PO Cabang Bongkar Barang Ref: PO/SF-011/BB/08/05/2026/000017', 1, '', 'PO/SF-011/BB/08/05/2026/000017', '2026-05-08 14:36:48'),
	(297, 'Batalkan PO Ref: PO/SF-011/BB/08/05/2026/000017', 1, '', 'PO/SF-011/BB/08/05/2026/000017', '2026-05-08 14:43:36'),
	(298, 'Tambah PO Cabang Bongkar Barang Ref: PO/SF-011/BB/08/05/2026/000018', 1, '', 'PO/SF-011/BB/08/05/2026/000018', '2026-05-08 15:12:44'),
	(299, 'Tambah Input Stok Ref: IS/08/05/2026/000019', 1, '', 'IS/08/05/2026/000019', '2026-05-08 15:13:00'),
	(300, 'Tambah PO Cabang Bongkar Barang Ref: PO/SF-011/BB/08/05/2026/000018', 1, '', 'PO/SF-011/BB/08/05/2026/000018', '2026-05-08 15:14:23'),
	(301, 'Tambah Pembelian Cabang Bongkar Barang Ref: LBM/AL-012/BB/08/05/2026/000012', 1, '', 'LBM/AL-012/BB/08/05/2026/000012', '2026-05-08 15:15:31'),
	(302, 'Edit Produk Baru', 1, '', '', '2026-05-08 15:16:19'),
	(303, 'Tambah Pengajuan Baru PJ/ADA001/Bongkar Barang/08/05/2026/000019', 1, '', 'PJ/ADA001/Bongkar Barang/08/05/2026/000019', '2026-05-08 15:19:47'),
	(304, 'Tambah Pengajuan Baru PJ/JAC00005/Bongkar Barang/08/05/2026/000020', 1, '', 'PJ/JAC00005/Bongkar Barang/08/05/2026/000020', '2026-05-08 15:19:56'),
	(305, 'Tambah Pengajuan Baru PJ/JAC00005/Bongkar Barang/08/05/2026/000021', 1, '', 'PJ/JAC00005/Bongkar Barang/08/05/2026/000021', '2026-05-08 15:20:10'),
	(306, 'Tambah PO Cabang Bongkar Barang Ref: PO/AL-012/BB/08/05/2026/000019', 1, '', 'PO/AL-012/BB/08/05/2026/000019', '2026-05-08 15:24:03'),
	(307, 'Edit Produk Baru', 1, '', '', '2026-05-08 15:26:47'),
	(308, 'Edit Produk Baru', 1, '', '', '2026-05-08 15:26:57'),
	(309, 'Edit Produk Baru', 1, '', '', '2026-05-08 15:26:57'),
	(310, 'Edit Produk Baru', 1, '', '', '2026-05-08 15:27:24'),
	(311, 'Edit Produk Baru', 1, '', '', '2026-05-08 15:27:35'),
	(312, 'Edit Produk Baru', 1, '', '', '2026-05-08 15:27:35'),
	(313, 'Tambah PO Cabang Bongkar Barang Ref: PO/AL-012/BB/08/05/2026/000019', 1, '', 'PO/AL-012/BB/08/05/2026/000019', '2026-05-08 15:31:23'),
	(314, 'Batalkan PO Ref: PO/AL-012/BB/08/05/2026/000019', 1, '', 'PO/AL-012/BB/08/05/2026/000019', '2026-05-08 15:33:34'),
	(315, 'Tambah PO Cabang Bongkar Barang Ref: PO/SF-011/BB/08/05/2026/000020', 1, '', 'PO/SF-011/BB/08/05/2026/000020', '2026-05-08 15:34:39'),
	(316, 'Tambah Input Stok Ref: IS/08/05/2026/000020', 1, '', 'IS/08/05/2026/000020', '2026-05-08 15:35:20'),
	(317, 'Tambah Pembelian Cabang Bongkar Barang Ref: LBM/SF-011/BB/08/05/2026/000013', 1, '', 'LBM/SF-011/BB/08/05/2026/000013', '2026-05-08 15:35:34'),
	(318, 'Tambah Retur Pembelian Ref: RP/SF-011/08/05/2026/000001', 1, '', 'RP/SF-011/08/05/2026/000001', '2026-05-08 15:37:51'),
	(319, 'Edit Produk Baru', 1, '', '', '2026-05-08 15:42:16'),
	(320, 'Edit Produk Baru', 1, '', '', '2026-05-08 15:42:26'),
	(321, 'Edit Produk Baru', 1, '', '', '2026-05-08 15:42:26'),
	(322, 'Edit Produk Baru', 1, '', '', '2026-05-08 15:42:26'),
	(323, 'Edit Produk Baru', 1, '', '', '2026-05-08 15:42:26'),
	(324, 'Edit Produk Baru', 1, '', '', '2026-05-08 15:42:26'),
	(325, 'Edit Produk Baru', 1, '', '', '2026-05-08 15:42:26'),
	(326, 'Edit Produk Baru', 1, '', '', '2026-05-08 15:42:26'),
	(327, 'Edit Produk Baru', 1, '', '', '2026-05-08 15:42:26'),
	(328, 'Edit Produk Baru', 1, '', '', '2026-05-08 15:42:26'),
	(329, 'Tambah PO Cabang Pusat Ref: PO/S-00001/PST/03/06/2026/000021', 1, '', 'PO/S-00001/PST/03/06/2026/000021', '2026-06-03 14:02:19'),
	(330, 'Tambah Input Stok Ref: IS/03/06/2026/000021', 1, '', 'IS/03/06/2026/000021', '2026-06-03 14:46:41'),
	(331, 'Tambah Pengajuan Baru PJ/ADA001/SERDAM/03/06/2026/000022', 1, '', 'PJ/ADA001/SERDAM/03/06/2026/000022', '2026-06-03 15:27:26'),
	(332, 'Tambah Pengajuan Baru PJ/ADA001/SERDAM/03/06/2026/000023', 1, '', 'PJ/ADA001/SERDAM/03/06/2026/000023', '2026-06-03 15:27:51'),
	(333, 'Batalkan Pengajuan PJ/ADA001/SERDAM/03/06/2026/000023', 1, '', 'PJ/ADA001/SERDAM/03/06/2026/000023', '2026-06-03 15:28:13'),
	(334, 'Tambah Pengajuan Baru PJ/ADA001/SERDAM/03/06/2026/000023', 1, '', 'PJ/ADA001/SERDAM/03/06/2026/000023', '2026-06-03 15:29:11'),
	(335, 'Tambah Pengajuan Baru PJ/ADA001/SERDAM/03/06/2026/000024', 1, '', 'PJ/ADA001/SERDAM/03/06/2026/000024', '2026-06-03 15:31:21'),
	(336, 'Tambah Pengajuan Baru PJ/ADA001/SERDAM/03/06/2026/000025', 1, '', 'PJ/ADA001/SERDAM/03/06/2026/000025', '2026-06-03 15:32:08'),
	(337, 'Tambah Pengajuan Baru PJ/ADA001/Bongkar Barang/03/06/2026/000026', 1, '', 'PJ/ADA001/Bongkar Barang/03/06/2026/000026', '2026-06-03 15:32:19'),
	(338, 'Tambah PO Cabang SERDAM Ref: PO/S-00001/SDM/03/06/2026/000022', 1, '', 'PO/S-00001/SDM/03/06/2026/000022', '2026-06-03 15:51:59'),
	(339, 'Tambah PO Cabang SERDAM Ref: PO/S-00001/SDM/03/06/2026/000022', 1, '', 'PO/S-00001/SDM/03/06/2026/000022', '2026-06-03 15:52:17'),
	(340, 'Tambah PO Cabang SERDAM Ref: PO/S-00001/SDM/03/06/2026/000022', 1, '', 'PO/S-00001/SDM/03/06/2026/000022', '2026-06-03 16:02:01'),
	(341, 'Tambah PO Cabang SERDAM Ref: PO/S-00001/SDM/03/06/2026/000022', 1, '', 'PO/S-00001/SDM/03/06/2026/000022', '2026-06-03 16:18:22'),
	(342, 'Tambah PO Cabang SERDAM Ref: PO/S-00001/SDM/03/06/2026/000022', 1, '', 'PO/S-00001/SDM/03/06/2026/000022', '2026-06-03 17:49:41'),
	(343, 'Tambah PO Cabang SERDAM Ref: PO/S-00001/SDM/03/06/2026/000022', 1, '', 'PO/S-00001/SDM/03/06/2026/000022', '2026-06-03 17:49:46');

-- Dumping structure for table pionir.dt_input_stock
CREATE TABLE IF NOT EXISTS `dt_input_stock` (
  `dt_is_id` int NOT NULL AUTO_INCREMENT,
  `hd_is_id` int NOT NULL,
  `dt_is_product_id` int NOT NULL,
  `dt_is_qty_order` int NOT NULL,
  `dt_is_note` text COLLATE utf8mb4_general_ci NOT NULL,
  `dt_is_qty` int NOT NULL,
  PRIMARY KEY (`dt_is_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pionir.dt_input_stock: ~22 rows (approximately)
INSERT IGNORE INTO `dt_input_stock` (`dt_is_id`, `hd_is_id`, `dt_is_product_id`, `dt_is_qty_order`, `dt_is_note`, `dt_is_qty`) VALUES
	(1, 1, 1, 2, '123', 2),
	(2, 1, 7, 2, '123', 2),
	(3, 2, 1, 1, '', 1),
	(4, 3, 1, 2, '', 2),
	(5, 4, 7, 500, 'MASUK SERDAM SEMUA', 500),
	(6, 5, 9, 20, 'simpan ke toko', 20),
	(7, 5, 7, 100, 'semua bawa ke gudang', 100),
	(8, 6, 1, 500, '', 500),
	(9, 11, 7, 500, '300 masuk serdam 200 masuk peok', 500),
	(10, 12, 7, 200, 'MASUK SDM SEMUA', 200),
	(11, 12, 1, 200, 'MASUK SDM SEMUA', 200),
	(12, 13, 7, 100, 'Masuk serdam semua', 100),
	(13, 14, 7, 100, '', 100),
	(14, 15, 1, 200, '', 200),
	(15, 16, 7, 200, '', 200),
	(16, 17, 7, 500, '', 500),
	(17, 18, 7, 200, '', 200),
	(18, 19, 1, 200, '', 200),
	(19, 19, 7, 200, '', 200),
	(20, 20, 1, 10, '', 10),
	(21, 20, 7, 100, '', 100),
	(22, 21, 1, 1, '', 1);

-- Dumping structure for table pionir.dt_opanme
CREATE TABLE IF NOT EXISTS `dt_opanme` (
  `dt_opanme_id` int NOT NULL AUTO_INCREMENT,
  `opname_id` int NOT NULL,
  `dt_opname_product_id` int NOT NULL,
  `dt_opname_stock_awal` int NOT NULL,
  `dt_opname_stock_akhir` int NOT NULL,
  `dt_opname_stock_difference` int NOT NULL,
  `dt_opname_stock_difference_hpp` int NOT NULL,
  `dt_opname_stock_status` enum('Minus','Plus') COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`dt_opanme_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pionir.dt_opanme: ~4 rows (approximately)
INSERT IGNORE INTO `dt_opanme` (`dt_opanme_id`, `opname_id`, `dt_opname_product_id`, `dt_opname_stock_awal`, `dt_opname_stock_akhir`, `dt_opname_stock_difference`, `dt_opname_stock_difference_hpp`, `dt_opname_stock_status`) VALUES
	(1, 1, 1, 11, 10, 1, 7000, 'Plus'),
	(2, 2, 1, 21, 2, -19, -133000, 'Minus'),
	(3, 3, 7, 1022, 1100, 78, 546000, 'Plus'),
	(4, 4, 1, 247, 240, -7, -49000, 'Minus');

-- Dumping structure for table pionir.dt_payment_debt
CREATE TABLE IF NOT EXISTS `dt_payment_debt` (
  `dt_payment_debt_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `payment_debt_id` int unsigned NOT NULL,
  `dt_payment_debt_purchase_id` int unsigned NOT NULL,
  `dt_payment_debt_discount` decimal(25,2) NOT NULL DEFAULT '0.00',
  `dt_payment_debt_retur` decimal(25,2) NOT NULL,
  `dt_payment_debt_desc` text NOT NULL,
  `dt_payment_debt_nominal` decimal(25,2) NOT NULL DEFAULT '0.00',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`dt_payment_debt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table pionir.dt_payment_debt: ~0 rows (approximately)

-- Dumping structure for table pionir.dt_payment_receivable
CREATE TABLE IF NOT EXISTS `dt_payment_receivable` (
  `dt_payment_receivable_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `payment_receivable_id` int unsigned NOT NULL,
  `dt_payment_receivable_sales_id` int unsigned NOT NULL,
  `dt_payment_receivable_discount` decimal(25,2) NOT NULL DEFAULT '0.00',
  `dt_payment_receivable_retur` decimal(25,2) NOT NULL,
  `dt_payment_receivable_desc` text NOT NULL,
  `dt_payment_receivable_nominal` decimal(25,2) NOT NULL DEFAULT '0.00',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`dt_payment_receivable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table pionir.dt_payment_receivable: ~0 rows (approximately)

-- Dumping structure for table pionir.dt_po
CREATE TABLE IF NOT EXISTS `dt_po` (
  `dt_po_id` int NOT NULL AUTO_INCREMENT,
  `hd_po_id` int NOT NULL,
  `submission_id` int NOT NULL,
  `submission_inv` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `dt_product_id` int NOT NULL,
  `dt_po_price` int NOT NULL,
  `dt_po_qty` int NOT NULL,
  `dt_po_weight` int NOT NULL,
  `dt_po_ongkir` int NOT NULL,
  `dt_po_total_weight` int NOT NULL,
  `dt_po_total_ongkir` int NOT NULL,
  `dt_po_total` int NOT NULL,
  `dt_po_note` text COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`dt_po_id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pionir.dt_po: ~26 rows (approximately)
INSERT IGNORE INTO `dt_po` (`dt_po_id`, `hd_po_id`, `submission_id`, `submission_inv`, `dt_product_id`, `dt_po_price`, `dt_po_qty`, `dt_po_weight`, `dt_po_ongkir`, `dt_po_total_weight`, `dt_po_total_ongkir`, `dt_po_total`, `dt_po_note`) VALUES
	(1, 1, 0, '', 1, 100000, 2, 12, 0, 24, 0, 200000, ''),
	(2, 1, 0, '', 7, 7000, 2, 25, 0, 50, 0, 14000, ''),
	(3, 2, 2, 'PJ/ADA001/Pusat/08/09/2025/000002', 1, 100000, 2, 12, 0, 24, 0, 200000, ''),
	(4, 3, 2, 'PJ/ADA001/Pusat/08/09/2025/000002', 1, 100000, 1, 25, 2200, 12, 55, 100055, ''),
	(5, 4, 3, 'PJ/JAC00005/Pusat/02/12/2025/000003', 7, 7000, 500, 25, 0, 12500, 0, 3500000, ''),
	(6, 5, 5, 'PJ/KAB00007/Bongkar Barang/30/01/2026/000005', 9, 450000, 20, 4500, 0, 90000, 0, 9000000, ''),
	(7, 5, 4, 'PJ/JAC00005/Bongkar Barang/30/01/2026/000004', 7, 7000, 100, 25, 0, 2500, 0, 700000, ''),
	(8, 6, 7, 'PJ/ADA001/Bongkar Barang/16/02/2026/000007', 1, 10000, 500, 12, 0, 6000, 0, 5000000, ''),
	(9, 7, 6, 'PJ/JAC00005/Bongkar Barang/16/02/2026/000006', 7, 7000, 500, 25, 0, 12500, 0, 3500000, ''),
	(10, 8, 10, 'PJ/JAC00005/Bongkar Barang/02/03/2026/000010', 7, 7000, 200, 25, 0, 5000, 0, 1400000, ''),
	(11, 8, 11, 'PJ/ADA001/Bongkar Barang/02/03/2026/000011', 1, 100000, 200, 12, 0, 2400, 0, 20000000, ''),
	(12, 9, 13, 'PJ/JAC00005/Bongkar Barang/07/03/2026/000013', 7, 7000, 100, 25, 2200, 2500, 55, 700055, ''),
	(13, 10, 0, '', 7, 7000, 100, 25, 2200, 2500, 55, 700055, ''),
	(16, 11, 0, '', 7, 6500, 200, 25, 2200, 5000, 55, 1300055, ''),
	(17, 12, 0, '', 1, 100000, 200, 12, 0, 2400, 0, 20000000, ''),
	(18, 13, 0, '', 7, 7000, 200, 25, 0, 5000, 0, 1400000, ''),
	(19, 14, 0, '', 7, 7000, 500, 25, 0, 12500, 0, 3500000, ''),
	(20, 15, 14, 'PJ/ADA001/Pusat/17/03/2026/000014', 1, 100000, 2, 12, 0, 24, 0, 200000, ''),
	(23, 16, 15, 'PJ/JAC00005/Pusat/30/03/2026/000015', 7, 7000, 50, 25, 0, 1250, 0, 350000, ''),
	(24, 17, 17, 'PJ/JAC00005/Bongkar Barang/08/05/2026/000017', 7, 7000, 200, 25, 0, 5000, 0, 1400000, ''),
	(25, 17, 18, 'PJ/ADA001/Bongkar Barang/08/05/2026/000018', 1, 100000, 200, 12, 0, 2400, 0, 20000000, ''),
	(29, 18, 17, 'PJ/JAC00005/Bongkar Barang/08/05/2026/000017', 7, 7000, 200, 25, 0, 5000, 0, 1400000, ''),
	(33, 19, 19, 'PJ/ADA001/Bongkar Barang/08/05/2026/000019', 1, 100000, 100, 12, 2200, 1200, 26, 10002640, ''),
	(34, 20, 19, 'PJ/ADA001/Bongkar Barang/08/05/2026/000019', 1, 100000, 10, 12, 2200, 120, 26, 1000264, ''),
	(35, 20, 21, 'PJ/JAC00005/Bongkar Barang/08/05/2026/000021', 7, 7000, 100, 25, 22000, 2500, 550, 755000, ''),
	(36, 21, 0, '', 1, 100000, 1, 12, 20000, 12, 240, 100240, ''),
	(47, 22, 0, '', 1, 100000, 2, 12, 0, 24, 0, 200000, ''),
	(48, 22, 0, '', 7, 7000, 2, 25, 0, 50, 0, 14000, '');

-- Dumping structure for table pionir.dt_purchase
CREATE TABLE IF NOT EXISTS `dt_purchase` (
  `dt_purchase_id` int NOT NULL AUTO_INCREMENT,
  `hd_purchase_id` int NOT NULL,
  `dt_product_id` int NOT NULL,
  `dt_purchase_price` int NOT NULL,
  `dt_purchase_qty` int NOT NULL,
  `dt_purchase_weight` int NOT NULL,
  `dt_purchase_ongkir` int NOT NULL,
  `dt_purchase_total_weight` int NOT NULL,
  `dt_purchase_total_ongkir` int NOT NULL,
  `dt_purchase_total` int NOT NULL,
  `dt_purchase_note` text COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`dt_purchase_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pionir.dt_purchase: ~20 rows (approximately)
INSERT IGNORE INTO `dt_purchase` (`dt_purchase_id`, `hd_purchase_id`, `dt_product_id`, `dt_purchase_price`, `dt_purchase_qty`, `dt_purchase_weight`, `dt_purchase_ongkir`, `dt_purchase_total_weight`, `dt_purchase_total_ongkir`, `dt_purchase_total`, `dt_purchase_note`) VALUES
	(1, 1, 1, 100000, 2, 12, 0, 24, 0, 200000, ''),
	(2, 1, 7, 7000, 2, 25, 0, 50, 0, 14000, ''),
	(3, 2, 1, 100000, 1, 25, 2200, 12, 55, 100055, ''),
	(4, 4, 7, 7000, 500, 25, 0, 12500, 0, 3500000, ''),
	(5, 18, 9, 450000, 20, 4500, 0, 90000, 0, 9000000, ''),
	(6, 18, 7, 7000, 20, 25, 0, 2500, 0, 700000, ''),
	(7, 19, 1, 10000, 500, 12, 0, 6000, 0, 5000000, ''),
	(8, 20, 7, 7000, 500, 25, 0, 12500, 0, 3500000, ''),
	(9, 21, 7, 7000, 200, 25, 0, 5000, 0, 1400000, ''),
	(10, 21, 1, 100000, 200, 12, 0, 2400, 0, 20000000, ''),
	(11, 22, 7, 7000, 100, 25, 2200, 2500, 55, 700055, ''),
	(12, 23, 7, 7000, 100, 25, 2200, 2500, 55, 700055, ''),
	(13, 24, 1, 100000, 200, 12, 0, 2400, 0, 20000000, ''),
	(14, 25, 7, 7000, 200, 25, 0, 5000, 0, 1400000, ''),
	(15, 26, 7, 7000, 500, 25, 0, 12500, 0, 3500000, ''),
	(16, 27, 7, 6500, 200, 25, 2200, 5000, 55, 1300055, ''),
	(17, 28, 1, 100000, 200, 12, 0, 2400, 0, 20000000, ''),
	(18, 28, 7, 7000, 200, 25, 0, 5000, 0, 1400000, ''),
	(19, 29, 1, 100000, 10, 12, 2200, 120, 26, 1000264, ''),
	(20, 29, 7, 7000, 10, 25, 22000, 2500, 550, 755000, '');

-- Dumping structure for table pionir.dt_retur_purchase
CREATE TABLE IF NOT EXISTS `dt_retur_purchase` (
  `dt_retur_purchase_id` int NOT NULL AUTO_INCREMENT,
  `hd_retur_purchase_id` int NOT NULL,
  `dt_retur_warehouse_id` int NOT NULL,
  `dt_retur_purchase_b_id` int NOT NULL,
  `dt_retur_purchase_product_id` int NOT NULL,
  `dt_retur_purchase_price` int NOT NULL,
  `dt_retur_purchase_qty` int NOT NULL,
  `dt_retur_purchase_ongkir` int NOT NULL,
  `dt_retur_purchase_total` int NOT NULL,
  `dt_retur_purchase_note` text COLLATE utf8mb4_general_ci NOT NULL,
  `dt_retur_purchase_process` enum('Y','N') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'N',
  PRIMARY KEY (`dt_retur_purchase_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pionir.dt_retur_purchase: ~0 rows (approximately)
INSERT IGNORE INTO `dt_retur_purchase` (`dt_retur_purchase_id`, `hd_retur_purchase_id`, `dt_retur_warehouse_id`, `dt_retur_purchase_b_id`, `dt_retur_purchase_product_id`, `dt_retur_purchase_price`, `dt_retur_purchase_qty`, `dt_retur_purchase_ongkir`, `dt_retur_purchase_total`, `dt_retur_purchase_note`, `dt_retur_purchase_process`) VALUES
	(1, 1, 13, 29, 1, 100000, 2, 26, 200026, 'RUSAK', 'N');

-- Dumping structure for table pionir.dt_retur_sales
CREATE TABLE IF NOT EXISTS `dt_retur_sales` (
  `dt_retur_sales_id` int NOT NULL AUTO_INCREMENT,
  `hd_retur_sales_id` int NOT NULL,
  `dt_retur_sales_b_id` int NOT NULL,
  `dt_retur_sales_product_id` int NOT NULL,
  `dt_retur_sales_price` int NOT NULL,
  `dt_retur_sales_qty` int NOT NULL,
  `dt_retur_sales_total` int NOT NULL,
  `dt_retur_sales_note` text COLLATE utf8mb4_general_ci NOT NULL,
  `dt_retur_sales_process` enum('Y','N') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'N',
  PRIMARY KEY (`dt_retur_sales_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pionir.dt_retur_sales: ~4 rows (approximately)
INSERT IGNORE INTO `dt_retur_sales` (`dt_retur_sales_id`, `hd_retur_sales_id`, `dt_retur_sales_b_id`, `dt_retur_sales_product_id`, `dt_retur_sales_price`, `dt_retur_sales_qty`, `dt_retur_sales_total`, `dt_retur_sales_note`, `dt_retur_sales_process`) VALUES
	(1, 1, 2, 7, 7000, 100, 700000, '', 'N'),
	(2, 2, 3, 7, 7000, 100, 700000, '', 'N'),
	(3, 3, 4, 7, 7000, 20, 140000, 'SALAH WARNA', 'N'),
	(4, 4, 4, 7, 7000, 4, 28000, '', 'N');

-- Dumping structure for table pionir.dt_sales
CREATE TABLE IF NOT EXISTS `dt_sales` (
  `dt_sales_id` int NOT NULL AUTO_INCREMENT,
  `hd_sales_id` int NOT NULL,
  `dt_sales_product_id` int NOT NULL,
  `dt_sales_rate` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `dt_sales_price` int NOT NULL,
  `dt_sales_qty` int NOT NULL,
  `dt_sales_discount` int NOT NULL,
  `dt_sales_total` int NOT NULL,
  `dt_sales_desc` text COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`dt_sales_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pionir.dt_sales: ~7 rows (approximately)
INSERT IGNORE INTO `dt_sales` (`dt_sales_id`, `hd_sales_id`, `dt_sales_product_id`, `dt_sales_rate`, `dt_sales_price`, `dt_sales_qty`, `dt_sales_discount`, `dt_sales_total`, `dt_sales_desc`) VALUES
	(1, 1, 7, 'Umum', 7000, 100, 0, 700000, 'asd'),
	(2, 2, 7, 'Umum', 7000, 100, 0, 700000, 'asd'),
	(3, 3, 7, 'Umum', 7000, 100, 0, 700000, 'asd'),
	(4, 4, 7, 'Umum', 15000, 30, 0, 450000, ''),
	(5, 5, 1, 'Umum', 100000, 20, 0, 2000000, 'A'),
	(6, 6, 1, 'Umum', 100000, 10, 0, 1000000, ''),
	(7, 7, 9, 'Umum', 450000, 1, 0, 450000, '');

-- Dumping structure for table pionir.dt_sales_order
CREATE TABLE IF NOT EXISTS `dt_sales_order` (
  `dt_sales_order_id` int NOT NULL AUTO_INCREMENT,
  `hd_sales_order_id` int NOT NULL,
  `dt_so_product_id` int NOT NULL,
  `dt_so_rate` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `dt_so_price` int NOT NULL,
  `dt_so_qty` int NOT NULL,
  `dt_so_discount` int NOT NULL,
  `dt_so_total` int NOT NULL,
  `dt_so_note` text COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`dt_sales_order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pionir.dt_sales_order: ~5 rows (approximately)
INSERT IGNORE INTO `dt_sales_order` (`dt_sales_order_id`, `hd_sales_order_id`, `dt_so_product_id`, `dt_so_rate`, `dt_so_price`, `dt_so_qty`, `dt_so_discount`, `dt_so_total`, `dt_so_note`) VALUES
	(1, 1, 7, 'Umum', 15000, 100, 0, 1500000, ''),
	(2, 2, 7, 'Umum', 15000, 2, 0, 30000, ''),
	(3, 3, 7, 'Umum', 15000, 200, 0, 3000000, ''),
	(5, 4, 7, 'Umum', 15000, 30, 0, 450000, ''),
	(6, 5, 1, 'Umum', 100000, 10, 0, 1000000, '');

-- Dumping structure for table pionir.dt_transfer_stock
CREATE TABLE IF NOT EXISTS `dt_transfer_stock` (
  `dt_transfer_stock_id` int NOT NULL AUTO_INCREMENT,
  `hd_transfer_stock_id` int NOT NULL,
  `dt_transfer_stock_product_id` int NOT NULL,
  `dt_transfer_stock_qty` int NOT NULL,
  `dt_transfer_stock_warehouse_from` int NOT NULL,
  `dt_transfer_stock_warehouse_to` int NOT NULL,
  `dt_transfer_stock_from_qty` int NOT NULL,
  `dt_transfer_stock_to_qty` int NOT NULL,
  `dt_transfer_stock_note` text COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`dt_transfer_stock_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pionir.dt_transfer_stock: ~0 rows (approximately)
INSERT IGNORE INTO `dt_transfer_stock` (`dt_transfer_stock_id`, `hd_transfer_stock_id`, `dt_transfer_stock_product_id`, `dt_transfer_stock_qty`, `dt_transfer_stock_warehouse_from`, `dt_transfer_stock_warehouse_to`, `dt_transfer_stock_from_qty`, `dt_transfer_stock_to_qty`, `dt_transfer_stock_note`) VALUES
	(2, 4, 7, 100, 2, 13, 290, 600, '');

-- Dumping structure for table pionir.hd_input_stock
CREATE TABLE IF NOT EXISTS `hd_input_stock` (
  `hd_input_stock_id` int NOT NULL AUTO_INCREMENT,
  `hd_input_stock_inv` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `hd_input_stock_warehouse` int NOT NULL,
  `hd_po_id` int NOT NULL,
  `hd_input_stock_date` date NOT NULL,
  `hd_input_stock_status` enum('Pending','Success','Cancel') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Pending',
  `hd_input_stock_desc` text COLLATE utf8mb4_general_ci NOT NULL,
  `created_by` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`hd_input_stock_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pionir.hd_input_stock: ~21 rows (approximately)
INSERT IGNORE INTO `hd_input_stock` (`hd_input_stock_id`, `hd_input_stock_inv`, `hd_input_stock_warehouse`, `hd_po_id`, `hd_input_stock_date`, `hd_input_stock_status`, `hd_input_stock_desc`, `created_by`, `created_at`) VALUES
	(1, 'IS/08/09/2025/000001', 2, 1, '2025-09-08', 'Pending', 'asd', 1, '2025-09-08 23:12:24'),
	(2, 'IS/15/10/2025/000002', 1, 3, '2025-10-15', 'Pending', '', 1, '2025-10-16 00:32:17'),
	(3, 'IS/03/11/2025/000003', 2, 2, '2025-11-03', 'Pending', '', 1, '2025-11-03 12:45:17'),
	(4, 'IS/02/12/2025/000004', 13, 4, '2025-12-02', 'Pending', '', 1, '2025-12-02 18:32:40'),
	(5, 'IS/30/01/2026/000005', 13, 5, '2026-01-30', 'Pending', '', 1, '2026-01-30 14:52:03'),
	(6, 'IS/16/02/2026/000006', 13, 6, '2026-02-16', 'Pending', '', 1, '2026-02-16 12:54:38'),
	(7, 'IS/16/02/2026/000007', 13, 6, '2026-02-16', 'Pending', '', 1, '2026-02-16 12:54:38'),
	(8, 'IS/16/02/2026/000008', 13, 6, '2026-02-16', 'Pending', '', 1, '2026-02-16 12:54:38'),
	(9, 'IS/16/02/2026/000009', 13, 6, '2026-02-16', 'Pending', '', 1, '2026-02-16 12:54:38'),
	(10, 'IS/16/02/2026/000010', 13, 6, '2026-02-16', 'Pending', '', 1, '2026-02-16 12:54:38'),
	(11, 'IS/16/02/2026/000011', 13, 7, '2026-02-16', 'Pending', '', 1, '2026-02-16 12:55:27'),
	(12, 'IS/02/03/2026/000012', 13, 8, '2026-03-02', 'Success', '', 1, '2026-03-02 10:30:10'),
	(13, 'IS/07/03/2026/000013', 13, 9, '2026-03-07', 'Success', '', 1, '2026-03-07 09:53:38'),
	(14, 'IS/07/03/2026/000014', 1, 10, '2026-03-07', 'Success', '', 1, '2026-03-07 14:10:12'),
	(15, 'IS/09/03/2026/000015', 13, 12, '2026-03-09', 'Success', '', 1, '2026-03-09 13:38:25'),
	(16, 'IS/09/03/2026/000016', 13, 13, '2026-03-09', 'Success', '', 1, '2026-03-09 13:41:06'),
	(17, 'IS/09/03/2026/000017', 13, 14, '2026-03-09', 'Success', '', 1, '2026-03-09 13:45:55'),
	(18, 'IS/11/03/2026/000018', 1, 11, '2026-03-11', 'Success', '', 1, '2026-03-11 10:54:41'),
	(19, 'IS/08/05/2026/000019', 13, 18, '2026-05-08', 'Success', '', 1, '2026-05-08 15:13:00'),
	(20, 'IS/08/05/2026/000020', 13, 20, '2026-05-08', 'Success', '', 1, '2026-05-08 15:35:20'),
	(21, 'IS/03/06/2026/000021', 1, 21, '2026-06-03', 'Pending', '', 1, '2026-06-03 14:46:41');

-- Dumping structure for table pionir.hd_payment_debt
CREATE TABLE IF NOT EXISTS `hd_payment_debt` (
  `payment_debt_id` int unsigned NOT NULL AUTO_INCREMENT,
  `payment_debt_invoice` varchar(100) NOT NULL,
  `payment_debt_supplier_id` int unsigned NOT NULL,
  `payment_debt_total_pay` decimal(25,2) NOT NULL DEFAULT '0.00',
  `payment_debt_total_retur` int NOT NULL,
  `payment_debt_total_discount` int NOT NULL,
  `payment_debt_total_nota` int NOT NULL,
  `payment_debt_method_id` int unsigned NOT NULL,
  `payment_debt_date` date NOT NULL,
  `user_id` int unsigned NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` enum('Success','Cancel') NOT NULL DEFAULT 'Success',
  PRIMARY KEY (`payment_debt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table pionir.hd_payment_debt: ~0 rows (approximately)

-- Dumping structure for table pionir.hd_payment_receivable
CREATE TABLE IF NOT EXISTS `hd_payment_receivable` (
  `payment_receivable_id` int unsigned NOT NULL AUTO_INCREMENT,
  `payment_receivable_invoice` varchar(100) NOT NULL,
  `payment_receivable_customer_id` int unsigned NOT NULL,
  `payment_receivable_total_pay` decimal(25,2) NOT NULL DEFAULT '0.00',
  `payment_receivable_total_retur` int NOT NULL,
  `payment_receivable_total_discount` int NOT NULL,
  `payment_receivable_total_nota` int NOT NULL,
  `payment_receivable_method_id` int unsigned NOT NULL,
  `payment_receivable_date` date NOT NULL,
  `user_id` int unsigned NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` enum('Success','Cancel') NOT NULL DEFAULT 'Success',
  PRIMARY KEY (`payment_receivable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table pionir.hd_payment_receivable: ~0 rows (approximately)

-- Dumping structure for table pionir.hd_po
CREATE TABLE IF NOT EXISTS `hd_po` (
  `hd_po_id` int NOT NULL AUTO_INCREMENT,
  `hd_po_invoice` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `hd_po_date` date NOT NULL,
  `hd_po_warehouse` int NOT NULL,
  `hd_po_supplier` int NOT NULL,
  `hd_po_tax` enum('PPN','NON PPN') COLLATE utf8mb4_general_ci NOT NULL,
  `hd_po_top` enum('CBD','JT7','JT15','JT30','JT45','JT60','JT90') COLLATE utf8mb4_general_ci NOT NULL,
  `hd_po_due_date` date NOT NULL,
  `hd_po_payment` int NOT NULL,
  `hd_po_ekspedisi` int NOT NULL,
  `hd_po_sub_total` int NOT NULL,
  `hd_po_disc_percentage1` int NOT NULL,
  `hd_po_disc_percentage2` int NOT NULL,
  `hd_po_disc_percentage3` int NOT NULL,
  `hd_po_disc_1` int NOT NULL,
  `hd_po_disc_2` int NOT NULL,
  `hd_po_disc_3` int NOT NULL,
  `hd_po_total_discount` int NOT NULL,
  `hd_po_dpp` int NOT NULL,
  `hd_po_ppn` int NOT NULL,
  `hd_po_ongkir` int NOT NULL,
  `hd_po_grand_total` int NOT NULL,
  `hd_po_status` enum('Pending','Success','Cancel') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Pending',
  `hd_po_purchase_status` enum('Pending','Success') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Pending',
  `hd_po_status_delivery` text COLLATE utf8mb4_general_ci NOT NULL,
  `hd_po_note` text COLLATE utf8mb4_general_ci,
  `created_by` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`hd_po_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pionir.hd_po: ~21 rows (approximately)
INSERT IGNORE INTO `hd_po` (`hd_po_id`, `hd_po_invoice`, `hd_po_date`, `hd_po_warehouse`, `hd_po_supplier`, `hd_po_tax`, `hd_po_top`, `hd_po_due_date`, `hd_po_payment`, `hd_po_ekspedisi`, `hd_po_sub_total`, `hd_po_disc_percentage1`, `hd_po_disc_percentage2`, `hd_po_disc_percentage3`, `hd_po_disc_1`, `hd_po_disc_2`, `hd_po_disc_3`, `hd_po_total_discount`, `hd_po_dpp`, `hd_po_ppn`, `hd_po_ongkir`, `hd_po_grand_total`, `hd_po_status`, `hd_po_purchase_status`, `hd_po_status_delivery`, `hd_po_note`, `created_by`, `created_at`) VALUES
	(1, 'PO/S-00001/SDM/08/09/2025/000001', '2025-09-08', 2, 1, 'PPN', 'CBD', '0000-00-00', 1, 1, 214000, 0, 0, 0, 0, 0, 0, 0, 214000, 23540, 0, 237540, 'Success', 'Success', '', NULL, 1, '2025-09-08 23:12:09'),
	(2, 'PO/S-00001/SDM/15/10/2025/000002', '2025-10-15', 2, 1, 'PPN', 'CBD', '0000-00-00', 1, 1, 200000, 0, 0, 0, 0, 0, 0, 0, 200000, 22000, 0, 222000, 'Success', 'Pending', '', NULL, 1, '2025-10-15 11:49:06'),
	(3, 'PO/S-00001/PST/15/10/2025/000003', '2025-10-15', 1, 1, 'PPN', 'CBD', '0000-00-00', 1, 1, 100055, 0, 0, 0, 0, 0, 0, 0, 100055, 11006, 55, 111116, 'Success', 'Success', '', NULL, 1, '2025-10-16 00:31:16'),
	(4, 'PO/AL-012/BB/02/12/2025/000004', '2025-12-02', 13, 13, 'NON PPN', 'JT30', '2025-12-31', 1, 5, 3500000, 0, 0, 0, 0, 0, 0, 0, 3500000, 0, 0, 3500000, 'Success', 'Success', '', NULL, 1, '2025-12-02 18:31:15'),
	(5, 'PO/AL-012/BB/30/01/2026/000005', '2026-01-30', 13, 13, 'NON PPN', 'JT7', '2026-02-05', 1, 4, 9700000, 0, 0, 0, 0, 0, 0, 0, 9700000, 0, 0, 9700000, 'Success', 'Success', '', NULL, 1, '2026-01-30 14:48:49'),
	(6, 'PO/DO-010/BB/16/02/2026/000006', '2026-02-16', 13, 10, 'PPN', 'CBD', '0000-00-00', 1, 5, 5000000, 0, 0, 0, 0, 0, 0, 0, 5000000, 550000, 0, 5550000, 'Success', 'Success', '', NULL, 1, '2026-02-16 12:45:20'),
	(7, 'PO/AL-012/BB/16/02/2026/000007', '2026-02-16', 13, 10, 'NON PPN', 'CBD', '2026-02-22', 1, 5, 3500000, 0, 0, 0, 0, 0, 0, 0, 3500000, 0, 0, 3500000, 'Success', 'Success', '', NULL, 1, '2026-02-16 12:45:57'),
	(8, 'PO/AL-012/BB/02/03/2026/000008', '2026-03-02', 13, 13, 'NON PPN', 'CBD', '0000-00-00', 1, 5, 21400000, 0, 0, 0, 0, 0, 0, 0, 21400000, 0, 0, 21400000, 'Success', 'Success', '', NULL, 1, '2026-03-02 10:29:25'),
	(9, 'PO/S-00001/BB/07/03/2026/000009', '2026-03-07', 13, 1, 'NON PPN', 'CBD', '0000-00-00', 1, 5, 700055, 0, 0, 0, 0, 0, 0, 0, 700055, 0, 55, 700110, 'Success', 'Success', '', NULL, 1, '2026-03-07 09:51:50'),
	(10, 'PO/S-00001/PST/07/03/2026/000010', '2026-03-07', 1, 1, 'NON PPN', 'CBD', '0000-00-00', 1, 1, 700055, 0, 0, 0, 0, 0, 0, 0, 700055, 0, 55, 700110, 'Success', 'Success', '', NULL, 1, '2026-03-07 14:09:42'),
	(11, 'PO/SF-011/PST/09/03/2026/000011', '2026-03-09', 1, 12, 'NON PPN', 'CBD', '2026-03-09', 1, 4, 1300055, 0, 0, 0, 0, 0, 0, 0, 1300055, 0, 55, 1300110, 'Success', 'Success', '', NULL, 1, '2026-03-09 12:45:16'),
	(12, 'PO/SF-011/BB/09/03/2026/000012', '2026-03-09', 13, 12, 'PPN', 'CBD', '2026-03-09', 1, 5, 20000000, 20, 0, 0, 4000000, 0, 0, 4000000, 16000000, 1760000, 0, 17760000, 'Success', 'Success', '', NULL, 1, '2026-03-09 13:38:04'),
	(13, 'PO/SF-011/BB/09/03/2026/000013', '2026-03-09', 13, 12, 'NON PPN', 'CBD', '2026-03-09', 1, 1, 1400000, 20, 0, 0, 280000, 0, 0, 280000, 1120000, 0, 0, 1243200, 'Success', 'Success', '', NULL, 1, '2026-03-09 13:40:49'),
	(14, 'PO/SF-011/BB/09/03/2026/000014', '2026-03-09', 13, 12, 'NON PPN', 'JT30', '2026-04-07', 1, 2, 3500000, 5, 0, 0, 175000, 0, 0, 175000, 3325000, 0, 0, 3690750, 'Success', 'Success', '', NULL, 1, '2026-03-09 13:42:24'),
	(15, 'PO/SF-011/PST/17/03/2026/000015', '2026-03-17', 1, 12, 'PPN', 'JT7', '2026-03-23', 1, 1, 200000, 0, 0, 0, 0, 0, 0, 0, 200000, 22000, 0, 222000, 'Pending', 'Pending', '', NULL, 1, '2026-03-17 13:14:38'),
	(16, 'PO/SF-011/BB/30/03/2026/000016', '2026-03-30', 13, 12, 'NON PPN', 'JT30', '2026-04-28', 1, 5, 350000, 0, 0, 0, 0, 0, 0, 0, 350000, 0, 0, 350000, 'Pending', 'Pending', '', NULL, 1, '2026-03-30 10:19:56'),
	(17, 'PO/SF-011/BB/08/05/2026/000017', '2026-05-08', 13, 12, 'NON PPN', 'JT7', '2026-05-14', 1, 4, 21400000, 0, 0, 0, 0, 0, 0, 0, 21400000, 0, 0, 21400000, 'Cancel', 'Pending', '', NULL, 1, '2026-05-08 14:36:48'),
	(18, 'PO/SF-011/BB/08/05/2026/000018', '2026-05-08', 13, 13, 'PPN', 'JT7', '2026-05-14', 1, 4, 21400000, 0, 0, 0, 0, 0, 0, 0, 21400000, 2354000, 0, 23754000, 'Success', 'Success', '', NULL, 1, '2026-05-08 15:12:44'),
	(19, 'PO/AL-012/BB/08/05/2026/000019', '2026-05-08', 13, 12, 'NON PPN', 'JT7', '2026-05-14', 1, 4, 10708140, 0, 0, 0, 0, 0, 0, 0, 10708140, 0, 81, 10708221, 'Cancel', 'Pending', '', NULL, 1, '2026-05-08 15:24:03'),
	(20, 'PO/SF-011/BB/08/05/2026/000020', '2026-05-08', 13, 12, 'PPN', 'JT7', '2026-05-14', 1, 4, 1755264, 2, 0, 0, 35105, 0, 0, 35105, 1720159, 189217, 576, 1909952, 'Success', 'Success', '', NULL, 1, '2026-05-08 15:34:39'),
	(21, 'PO/S-00001/PST/03/06/2026/000021', '2026-06-03', 1, 1, 'PPN', 'JT7', '2026-06-09', 1, 1, 100240, 0, 0, 0, 0, 0, 0, 0, 100240, 11026, 240, 111506, 'Success', 'Pending', '', NULL, 1, '2026-06-03 14:02:19'),
	(22, 'PO/S-00001/SDM/03/06/2026/000022', '2026-06-03', 2, 1, 'PPN', 'CBD', '2026-06-03', 1, 1, 214000, 0, 0, 0, 0, 0, 0, 0, 214000, 23540, 0, 237540, 'Pending', 'Pending', '', NULL, 1, '2026-06-03 15:51:59');

-- Dumping structure for table pionir.hd_purchase
CREATE TABLE IF NOT EXISTS `hd_purchase` (
  `hd_purchase_id` int NOT NULL AUTO_INCREMENT,
  `hd_purchase_invoice` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `hd_po_id` int NOT NULL,
  `hd_purchase_faktur` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `hd_purchase_faktur_date` date NOT NULL,
  `hd_purchase_date` date NOT NULL,
  `hd_purchase_warehouse` int NOT NULL,
  `hd_purchase_supplier` int NOT NULL,
  `hd_purchase_tax` enum('Y','N') COLLATE utf8mb4_general_ci NOT NULL,
  `hd_purchase_top` enum('CBD','JT7','JT15','JT30','JT45','JT60','JT90') COLLATE utf8mb4_general_ci NOT NULL,
  `hd_purchase_top_id` int NOT NULL,
  `hd_purchase_due_date` date NOT NULL,
  `hd_purchase_payment` int NOT NULL,
  `hd_purchase_ekspedisi` int NOT NULL,
  `hd_purchase_sub_total` int NOT NULL,
  `hd_purchase_disc_percentage1` int NOT NULL,
  `hd_purchase_disc_percentage2` int NOT NULL,
  `hd_purchase_disc_percentage3` int NOT NULL,
  `hd_purchase_disc_1` int NOT NULL,
  `hd_purchase_disc_2` int NOT NULL,
  `hd_purchase_disc_3` int NOT NULL,
  `hd_purchase_total_discount` int NOT NULL,
  `hd_purchase_dpp` int NOT NULL,
  `hd_purchase_ppn` int NOT NULL,
  `hd_purchase_ongkir` int NOT NULL,
  `hd_purchase_dp` int NOT NULL,
  `hd_purchase_grand_total` int NOT NULL,
  `hd_purchase_remaining_debt` int NOT NULL,
  `hd_purchase_status` enum('Pending','Success','Cancel') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Pending',
  `hd_purchase_status_delivery` text COLLATE utf8mb4_general_ci NOT NULL,
  `hd_purchase_note` text COLLATE utf8mb4_general_ci,
  `hd_purchase_type` enum('PURCHASE','REVISI') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'PURCHASE',
  `created_by` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`hd_purchase_id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pionir.hd_purchase: ~29 rows (approximately)
INSERT IGNORE INTO `hd_purchase` (`hd_purchase_id`, `hd_purchase_invoice`, `hd_po_id`, `hd_purchase_faktur`, `hd_purchase_faktur_date`, `hd_purchase_date`, `hd_purchase_warehouse`, `hd_purchase_supplier`, `hd_purchase_tax`, `hd_purchase_top`, `hd_purchase_top_id`, `hd_purchase_due_date`, `hd_purchase_payment`, `hd_purchase_ekspedisi`, `hd_purchase_sub_total`, `hd_purchase_disc_percentage1`, `hd_purchase_disc_percentage2`, `hd_purchase_disc_percentage3`, `hd_purchase_disc_1`, `hd_purchase_disc_2`, `hd_purchase_disc_3`, `hd_purchase_total_discount`, `hd_purchase_dpp`, `hd_purchase_ppn`, `hd_purchase_ongkir`, `hd_purchase_dp`, `hd_purchase_grand_total`, `hd_purchase_remaining_debt`, `hd_purchase_status`, `hd_purchase_status_delivery`, `hd_purchase_note`, `hd_purchase_type`, `created_by`, `created_at`) VALUES
	(1, 'LBM/S-00001/SDM/08/09/2025/000001', 1, 'asd123', '2025-09-08', '2025-09-08', 2, 1, '', 'CBD', 0, '0000-00-00', 1, 1, 214000, 0, 0, 0, 0, 0, 0, 0, 214000, 23540, 0, 0, 237540, 137540, 'Pending', '', NULL, 'PURCHASE', 1, '2025-09-08 23:19:44'),
	(2, 'LBM/S-00001/PST/03/11/2025/000001', 3, '', '2025-11-03', '2025-11-03', 1, 1, '', 'CBD', 0, '0000-00-00', 1, 1, 100055, 10, 0, 0, 10006, 0, 0, 10006, 90049, 11006, 55, 0, 100009, 100009, 'Pending', '', NULL, 'PURCHASE', 1, '2025-11-03 10:37:33'),
	(3, 'LBM/S-00001/PST/03/11/2025/000002', 3, '', '2025-11-03', '2025-11-03', 1, 1, '', 'CBD', 0, '0000-00-00', 1, 1, 100055, 10, 0, 0, 10006, 0, 0, 10006, 90049, 11006, 55, 0, 100009, 100009, 'Pending', '', NULL, 'PURCHASE', 1, '2025-11-03 10:38:34'),
	(4, 'LBM/AL-012/BB/02/12/2025/000001', 4, '', '2025-12-02', '2025-12-02', 13, 13, '', 'JT30', 30, '2025-12-31', 1, 5, 3500000, 0, 0, 0, 0, 0, 0, 0, 3500000, 0, 0, 0, 3500000, 3500000, 'Pending', '', NULL, 'PURCHASE', 1, '2025-12-02 18:33:18'),
	(5, 'LBM/AL-012/BB/02/12/2025/000001', 4, '', '2025-12-02', '2025-12-02', 13, 13, '', 'JT30', 30, '2025-12-31', 1, 5, 3500000, 0, 0, 0, 0, 0, 0, 0, 3500000, 0, 0, 0, 3500000, 3500000, 'Pending', '', NULL, 'PURCHASE', 1, '2025-12-02 18:33:21'),
	(6, 'LBM/AL-012/BB/02/12/2025/000001', 4, '', '2025-12-02', '2025-12-02', 13, 13, '', 'JT30', 30, '2025-12-31', 1, 5, 3500000, 0, 0, 0, 0, 0, 0, 0, 3500000, 0, 0, 0, 3500000, 3500000, 'Pending', '', NULL, 'PURCHASE', 1, '2025-12-02 18:33:27'),
	(7, 'LBM/AL-012/BB/02/12/2025/000001', 4, '', '2025-12-02', '2025-12-02', 13, 13, '', 'JT30', 30, '2025-12-31', 1, 5, 3500000, 0, 0, 0, 0, 0, 0, 0, 3500000, 0, 0, 0, 3500000, 3500000, 'Pending', '', NULL, 'PURCHASE', 1, '2025-12-02 18:33:27'),
	(8, 'LBM/AL-012/BB/02/12/2025/000001', 4, '', '2025-12-02', '2025-12-02', 13, 13, '', 'JT30', 30, '2025-12-31', 1, 5, 3500000, 0, 0, 0, 0, 0, 0, 0, 3500000, 0, 0, 0, 3500000, 3500000, 'Pending', '', NULL, 'PURCHASE', 1, '2025-12-02 18:33:27'),
	(9, 'LBM/AL-012/BB/02/12/2025/000001', 4, '', '2025-12-02', '2025-12-02', 13, 13, '', 'JT30', 30, '2025-12-31', 1, 5, 3500000, 0, 0, 0, 0, 0, 0, 0, 3500000, 0, 0, 0, 3500000, 3500000, 'Pending', '', NULL, 'PURCHASE', 1, '2025-12-02 18:33:28'),
	(10, 'LBM/AL-012/BB/02/12/2025/000001', 4, '', '2025-12-02', '2025-12-02', 13, 13, '', 'JT30', 30, '2025-12-31', 1, 5, 3500000, 0, 0, 0, 0, 0, 0, 0, 3500000, 0, 0, 0, 3500000, 3500000, 'Pending', '', NULL, 'PURCHASE', 1, '2025-12-02 18:33:28'),
	(11, 'LBM/AL-012/BB/02/12/2025/000001', 4, '', '2025-12-02', '2025-12-02', 13, 13, '', 'JT30', 30, '2025-12-31', 1, 5, 3500000, 0, 0, 0, 0, 0, 0, 0, 3500000, 0, 0, 0, 3500000, 3500000, 'Pending', '', NULL, 'PURCHASE', 1, '2025-12-02 18:33:28'),
	(12, 'LBM/AL-012/BB/02/12/2025/000001', 4, '', '2025-12-02', '2025-12-02', 13, 13, '', 'JT30', 30, '2025-12-31', 1, 5, 3500000, 0, 0, 0, 0, 0, 0, 0, 3500000, 0, 0, 0, 3500000, 3500000, 'Pending', '', NULL, 'PURCHASE', 1, '2025-12-02 18:33:28'),
	(13, 'LBM/AL-012/BB/02/12/2025/000001', 4, '', '2025-12-02', '2025-12-02', 13, 13, '', 'JT30', 30, '2025-12-31', 1, 5, 3500000, 0, 0, 0, 0, 0, 0, 0, 3500000, 0, 0, 0, 3500000, 3500000, 'Pending', '', NULL, 'PURCHASE', 1, '2025-12-02 18:33:31'),
	(14, 'LBM/AL-012/BB/02/12/2025/000001', 4, '', '2025-12-02', '2025-12-02', 13, 13, '', 'JT30', 30, '2025-12-31', 1, 5, 3500000, 0, 0, 0, 0, 0, 0, 0, 3500000, 0, 0, 0, 3500000, 3500000, 'Pending', '', NULL, 'PURCHASE', 1, '2025-12-02 18:33:32'),
	(15, 'LBM/AL-012/BB/02/12/2025/000001', 4, '', '2025-12-02', '2025-12-02', 13, 13, '', 'JT30', 30, '2025-12-31', 1, 5, 3500000, 0, 0, 0, 0, 0, 0, 0, 3500000, 0, 0, 0, 3500000, 3500000, 'Pending', '', NULL, 'PURCHASE', 1, '2025-12-02 18:33:32'),
	(16, 'LBM/AL-012/BB/02/12/2025/000001', 4, '', '2025-12-02', '2025-12-02', 13, 13, '', 'JT30', 30, '2025-12-31', 1, 5, 3500000, 0, 0, 0, 0, 0, 0, 0, 3500000, 0, 0, 0, 3500000, 3500000, 'Pending', '', NULL, 'PURCHASE', 1, '2025-12-02 18:34:38'),
	(17, 'LBM/AL-012/BB/02/12/2025/000001', 4, '', '2025-12-02', '2025-12-02', 13, 13, '', 'JT30', 30, '2025-12-31', 1, 5, 3500000, 0, 0, 0, 0, 0, 0, 0, 3500000, 0, 0, 0, 3500000, 3500000, 'Pending', '', NULL, 'PURCHASE', 1, '2025-12-02 18:34:48'),
	(18, 'LBM/AL-012/BB/30/01/2026/000002', 5, '', '2026-01-30', '2026-01-30', 13, 13, '', 'CBD', 0, '2026-02-05', 1, 4, 9700000, 0, 0, 0, 0, 0, 0, 0, 9700000, 0, 0, 0, 9700000, 9700000, 'Pending', '', NULL, 'PURCHASE', 1, '2026-01-30 14:53:23'),
	(19, 'LBM/DO-010/BB/16/02/2026/000003', 6, '', '2026-02-16', '2026-02-16', 13, 10, '', 'CBD', 0, '0000-00-00', 1, 5, 5000000, 10, 0, 0, 0, 0, 0, 0, 5000000, 550000, 0, 0, 5550000, 5550000, 'Pending', '', NULL, 'PURCHASE', 1, '2026-02-16 13:03:26'),
	(20, 'LBM/DO-010/BB/16/02/2026/000004', 7, '', '2026-02-16', '2026-02-16', 13, 10, '', 'CBD', 0, '0000-00-00', 1, 5, 3500000, 0, 0, 0, 0, 0, 0, 0, 3500000, 0, 0, 0, 3500000, 3500000, 'Pending', '', NULL, 'PURCHASE', 1, '2026-02-16 13:03:48'),
	(21, 'LBM/AL-012/BB/02/03/2026/000005', 8, '', '2026-03-02', '2026-03-02', 13, 13, '', 'CBD', 0, '0000-00-00', 1, 5, 21400000, 10, 0, 0, 0, 0, 0, 0, 21400000, 0, 0, 0, 21400000, 21400000, 'Pending', '', NULL, 'PURCHASE', 1, '2026-03-02 10:30:47'),
	(22, 'LBM/S-00001/BB/07/03/2026/000006', 9, '', '2026-03-07', '2026-03-07', 13, 1, '', 'CBD', 0, '0000-00-00', 1, 5, 700055, 0, 0, 0, 0, 0, 0, 0, 700055, 0, 55, 0, 700110, 700110, 'Pending', '', NULL, 'PURCHASE', 1, '2026-03-07 09:54:51'),
	(23, 'LBM/S-00001/PST/07/03/2026/000007', 10, '', '2026-03-07', '2026-03-07', 1, 1, '', 'CBD', 0, '0000-00-00', 1, 1, 700055, 0, 0, 0, 0, 0, 0, 0, 700055, 0, 55, 0, 700110, 700110, 'Pending', '', NULL, 'PURCHASE', 1, '2026-03-07 14:10:28'),
	(24, 'LBM/SF-011/BB/09/03/2026/000008', 12, '', '2026-03-09', '2026-03-09', 13, 12, '', 'CBD', 0, '2026-03-09', 1, 5, 20000000, 20, 0, 0, 4000000, 0, 0, 4000000, 17760000, 1760000, 0, 0, 17760000, 0, 'Pending', '', NULL, 'PURCHASE', 1, '2026-03-09 13:38:54'),
	(25, 'LBM/SF-011/BB/09/03/2026/000009', 13, '', '2026-03-09', '2026-03-09', 13, 12, '', 'CBD', 0, '2026-03-09', 1, 1, 1400000, 20, 0, 0, 280000, 0, 0, 280000, 1243200, 0, 0, 0, 1243200, 0, 'Pending', '', NULL, 'PURCHASE', 1, '2026-03-09 13:41:16'),
	(26, 'LBM/SF-011/BB/09/03/2026/000010', 14, '', '2026-03-09', '2026-03-09', 13, 12, '', 'JT30', 30, '2026-04-07', 1, 2, 3500000, 5, 0, 0, 175000, 0, 0, 175000, 0, 0, 0, 0, 3690750, 3390750, 'Pending', '', NULL, 'PURCHASE', 1, '2026-03-09 13:46:09'),
	(27, 'LBM/SF-011/PST/11/03/2026/000011', 11, '', '2026-03-11', '2026-03-11', 1, 12, '', 'CBD', 0, '2026-03-11', 1, 4, 1300055, 10, 0, 0, 130006, 0, 0, 130006, 1170104, 0, 55, 0, 1170104, 0, 'Pending', '', NULL, 'PURCHASE', 1, '2026-03-11 10:55:13'),
	(28, 'LBM/AL-012/BB/08/05/2026/000012', 18, '', '2026-05-08', '2026-05-08', 13, 13, '', 'JT7', 7, '2026-05-14', 1, 4, 21400000, 10, 0, 0, 2140000, 0, 0, 2140000, 0, 2118600, 0, 0, 21378600, 21378600, 'Pending', '', NULL, 'PURCHASE', 1, '2026-05-08 15:15:31'),
	(29, 'LBM/SF-011/BB/08/05/2026/000013', 20, '', '2026-05-08', '2026-05-08', 13, 12, '', 'JT7', 7, '2026-05-14', 1, 4, 1755264, 2, 0, 0, 35105, 0, 0, 35105, 0, 189217, 576, 0, 1909952, 1909952, 'Pending', '', NULL, 'PURCHASE', 1, '2026-05-08 15:35:34');

-- Dumping structure for table pionir.hd_retur_purchase
CREATE TABLE IF NOT EXISTS `hd_retur_purchase` (
  `hd_retur_purchase_id` int NOT NULL AUTO_INCREMENT,
  `hd_retur_purchase_inv` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `hd_retur_purchase_supplier_id` int NOT NULL,
  `hd_retur_purchase_date` date NOT NULL,
  `hd_retur_purchase_total` int NOT NULL,
  `hd_retur_purchase_note` text COLLATE utf8mb4_general_ci NOT NULL,
  `hd_retur_purchase_status` enum('Success','Cancel','Pending') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Pending',
  `hd_retur_purchase_payment_type` enum('Cash','PN','Garansi') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_by` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`hd_retur_purchase_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pionir.hd_retur_purchase: ~0 rows (approximately)
INSERT IGNORE INTO `hd_retur_purchase` (`hd_retur_purchase_id`, `hd_retur_purchase_inv`, `hd_retur_purchase_supplier_id`, `hd_retur_purchase_date`, `hd_retur_purchase_total`, `hd_retur_purchase_note`, `hd_retur_purchase_status`, `hd_retur_purchase_payment_type`, `created_by`, `created_at`) VALUES
	(1, 'RP/SF-011/08/05/2026/000001', 12, '2026-05-08', 200026, '', 'Success', 'Garansi', 1, '2026-05-08 15:37:51');

-- Dumping structure for table pionir.hd_retur_sales
CREATE TABLE IF NOT EXISTS `hd_retur_sales` (
  `hd_retur_sales_id` int NOT NULL AUTO_INCREMENT,
  `hd_retur_sales_inv` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `hd_retur_sales_customer_id` int NOT NULL,
  `hd_retur_sales_date` date NOT NULL,
  `hd_retur_sales_total` int NOT NULL,
  `hd_retur_sales_note` text COLLATE utf8mb4_general_ci NOT NULL,
  `hd_retur_sales_status` enum('Success','Cancel','Pending') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Pending',
  `hd_retur_sales_payment_type` enum('Cash','PN','Garansi') COLLATE utf8mb4_general_ci NOT NULL,
  `created_by` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`hd_retur_sales_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pionir.hd_retur_sales: ~4 rows (approximately)
INSERT IGNORE INTO `hd_retur_sales` (`hd_retur_sales_id`, `hd_retur_sales_inv`, `hd_retur_sales_customer_id`, `hd_retur_sales_date`, `hd_retur_sales_total`, `hd_retur_sales_note`, `hd_retur_sales_status`, `hd_retur_sales_payment_type`, `created_by`, `created_at`) VALUES
	(1, 'RS/BEN001/20/03/2026/000001', 3, '2026-03-20', 700000, '', 'Success', 'Garansi', 1, '2026-03-20 19:46:06'),
	(2, 'RS/BEN003/20/03/2026/000002', 8, '2026-03-20', 700000, '', 'Success', 'Garansi', 1, '2026-03-20 19:47:25'),
	(3, 'RS/ADR001/22/03/2026/000003', 1, '2026-03-22', 140000, '', 'Success', 'Cash', 1, '2026-03-22 16:55:19'),
	(4, 'RS/ADR001/22/03/2026/000004', 1, '2026-03-22', 28000, '', 'Success', 'Garansi', 1, '2026-03-22 16:57:36');

-- Dumping structure for table pionir.hd_sales
CREATE TABLE IF NOT EXISTS `hd_sales` (
  `hd_sales_id` int NOT NULL AUTO_INCREMENT,
  `hd_sales_inv` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `hd_sales_revisi_inv` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `hd_sales_order_id` int NOT NULL,
  `hd_sales_customer` int NOT NULL,
  `hd_sales_payment` int NOT NULL,
  `hd_sales_ekspedisi` int NOT NULL,
  `hd_sales_top` enum('CBD','JT7','JT15','JT30','JT45','JT60','JT90') COLLATE utf8mb4_general_ci NOT NULL,
  `hd_sales_top_id` int NOT NULL,
  `hd_sales_due_date` date NOT NULL,
  `hd_sales_dropship` enum('Y','N') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'N',
  `hd_sales_dropship_name` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `hd_sales_dropship_phone` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `hd_sales_dropship_address` text COLLATE utf8mb4_general_ci NOT NULL,
  `hd_sales_salesman` int NOT NULL,
  `hd_sales_prepare` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `hd_sales_prepare_id` int DEFAULT NULL,
  `hd_sales_colly` int NOT NULL,
  `hd_sales_date` date NOT NULL,
  `hd_sales_warehouse` int NOT NULL,
  `hd_sales_sub_total` int NOT NULL,
  `hd_sales_percentage1` int NOT NULL,
  `hd_sales_percentage2` int NOT NULL,
  `hd_sales_percentage3` int NOT NULL,
  `hd_sales_disc1` int NOT NULL,
  `hd_sales_disc2` int NOT NULL,
  `hd_sales_disc3` int NOT NULL,
  `hd_sales_total_discount` int NOT NULL,
  `hd_sales_ppn` int NOT NULL,
  `hd_sales_total` int NOT NULL,
  `hd_sales_dp` int NOT NULL,
  `hd_sales_remaining_debt` int NOT NULL,
  `hd_sales_status` enum('Success','Cancel') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Success',
  `hd_sales_note` text COLLATE utf8mb4_general_ci NOT NULL,
  `hd_sales_type` enum('SALES','REVISI') COLLATE utf8mb4_general_ci NOT NULL,
  `created_by` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`hd_sales_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pionir.hd_sales: ~7 rows (approximately)
INSERT IGNORE INTO `hd_sales` (`hd_sales_id`, `hd_sales_inv`, `hd_sales_revisi_inv`, `hd_sales_order_id`, `hd_sales_customer`, `hd_sales_payment`, `hd_sales_ekspedisi`, `hd_sales_top`, `hd_sales_top_id`, `hd_sales_due_date`, `hd_sales_dropship`, `hd_sales_dropship_name`, `hd_sales_dropship_phone`, `hd_sales_dropship_address`, `hd_sales_salesman`, `hd_sales_prepare`, `hd_sales_prepare_id`, `hd_sales_colly`, `hd_sales_date`, `hd_sales_warehouse`, `hd_sales_sub_total`, `hd_sales_percentage1`, `hd_sales_percentage2`, `hd_sales_percentage3`, `hd_sales_disc1`, `hd_sales_disc2`, `hd_sales_disc3`, `hd_sales_total_discount`, `hd_sales_ppn`, `hd_sales_total`, `hd_sales_dp`, `hd_sales_remaining_debt`, `hd_sales_status`, `hd_sales_note`, `hd_sales_type`, `created_by`, `created_at`) VALUES
	(1, 'PJ/ADR002/PST/20/03/2026/000001', '', 0, 2, 1, 1, 'CBD', 0, '2026-03-20', 'N', '', '', '', 1, '', NULL, 123, '2026-03-20', 1, 700000, 0, 0, 0, 0, 0, 0, 0, 0, 700000, 700000, 0, 'Success', '', 'SALES', 1, '2026-03-20 19:26:31'),
	(2, 'PJ/BEN001/SDM/20/03/2026/000002', '', 0, 3, 1, 1, 'CBD', 0, '2026-03-20', 'N', '', '', '', 1, '', NULL, 12, '2026-03-20', 2, 700000, 0, 0, 0, 0, 0, 0, 0, 0, 700000, 700000, 0, 'Success', '', 'SALES', 1, '2026-03-20 19:36:34'),
	(3, 'PJ/BEN003/SDM/20/03/2026/000002', '', 0, 8, 1, 1, 'CBD', 0, '2026-03-20', 'N', '', '', '', 1, '', NULL, 12, '2026-03-20', 2, 700000, 0, 0, 0, 0, 0, 0, 0, 0, 700000, 700000, 0, 'Success', '', 'SALES', 1, '2026-03-20 19:47:04'),
	(4, 'PJ/ADR001/SDM/22/03/2026/000003', '', 4, 1, 1, 1, 'CBD', 0, '2026-03-22', 'N', '', '', '', 1, '', NULL, 2, '2026-03-22', 2, 450000, 0, 0, 0, 0, 0, 0, 0, 0, 450000, 450000, 0, 'Success', '', 'SALES', 1, '2026-03-22 16:48:01'),
	(5, 'PJ/ADR002/SDM/22/03/2026/000004', '', 0, 2, 1, 1, 'JT45', 45, '2026-05-05', 'N', '', '', '', 1, '', NULL, 1, '2026-03-22', 2, 2000000, 0, 0, 0, 0, 0, 0, 0, 0, 2000000, 0, 2000000, 'Cancel', '', 'SALES', 1, '2026-03-22 16:51:10'),
	(6, 'PJ/ADR001/SDM/10/04/2026/000004', '', 5, 1, 1, 5, 'CBD', 0, '2026-04-10', 'N', '', '', '', 1, '', NULL, 1, '2026-04-10', 2, 1000000, 0, 0, 0, 0, 0, 0, 0, 0, 1000000, 1000000, 0, 'Success', '', 'SALES', 1, '2026-04-10 11:38:55'),
	(7, 'PJ/ADR001/PST/10/04/2026/000005', '', 0, 1, 1, 1, 'CBD', 0, '2026-04-10', 'N', '', '', '', 1, '', NULL, 0, '2026-04-10', 1, 450000, 0, 0, 0, 0, 0, 0, 0, 0, 450000, 450000, 0, 'Success', '', 'SALES', 1, '2026-04-10 11:39:41');

-- Dumping structure for table pionir.hd_sales_order
CREATE TABLE IF NOT EXISTS `hd_sales_order` (
  `hd_sales_order_id` int NOT NULL AUTO_INCREMENT,
  `hd_sales_order_inv` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `hd_sales_order_customer` int NOT NULL,
  `hd_sales_order_payment` int NOT NULL,
  `hd_sales_order_ekspedisi` int NOT NULL,
  `hd_sales_order_top` enum('CBD','JT7','JT15','JT30','JT45','JT60','JT90') COLLATE utf8mb4_general_ci NOT NULL,
  `hd_sales_order_top_id` int NOT NULL,
  `hd_sales_order_due_date` date NOT NULL,
  `hd_sales_order_dropship` enum('Y','N') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'N',
  `hd_sales_order_dropship_name` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `hd_sales_order_dropship_phone` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `hd_sales_order_dropship_address` text COLLATE utf8mb4_general_ci NOT NULL,
  `hd_sales_order_salesman` int NOT NULL,
  `hd_sales_order_prepare` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `hd_sales_order_prepare_id` int NOT NULL,
  `hd_sales_order_colly` int NOT NULL,
  `hd_sales_order_date` date NOT NULL,
  `hd_sales_order_warehouse` int NOT NULL,
  `hd_sales_order_sub_total` int NOT NULL,
  `hd_sales_order_percentage1` int NOT NULL,
  `hd_sales_order_percentage2` int NOT NULL,
  `hd_sales_order_percentage3` int NOT NULL,
  `hd_sales_order_disc1` int NOT NULL,
  `hd_sales_order_disc2` int NOT NULL,
  `hd_sales_order_disc3` int NOT NULL,
  `hd_sales_order_total_discount` int NOT NULL,
  `hd_sales_order_ppn` int NOT NULL,
  `hd_sales_order_total` int NOT NULL,
  `hd_sales_order_dp` int NOT NULL,
  `hd_sales_order_remaining_debt` int NOT NULL,
  `hd_sales_order_status` enum('Pending','Success','Cancel') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Pending',
  `hd_sales_order_note` text COLLATE utf8mb4_general_ci NOT NULL,
  `created_by` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`hd_sales_order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pionir.hd_sales_order: ~5 rows (approximately)
INSERT IGNORE INTO `hd_sales_order` (`hd_sales_order_id`, `hd_sales_order_inv`, `hd_sales_order_customer`, `hd_sales_order_payment`, `hd_sales_order_ekspedisi`, `hd_sales_order_top`, `hd_sales_order_top_id`, `hd_sales_order_due_date`, `hd_sales_order_dropship`, `hd_sales_order_dropship_name`, `hd_sales_order_dropship_phone`, `hd_sales_order_dropship_address`, `hd_sales_order_salesman`, `hd_sales_order_prepare`, `hd_sales_order_prepare_id`, `hd_sales_order_colly`, `hd_sales_order_date`, `hd_sales_order_warehouse`, `hd_sales_order_sub_total`, `hd_sales_order_percentage1`, `hd_sales_order_percentage2`, `hd_sales_order_percentage3`, `hd_sales_order_disc1`, `hd_sales_order_disc2`, `hd_sales_order_disc3`, `hd_sales_order_total_discount`, `hd_sales_order_ppn`, `hd_sales_order_total`, `hd_sales_order_dp`, `hd_sales_order_remaining_debt`, `hd_sales_order_status`, `hd_sales_order_note`, `created_by`, `created_at`) VALUES
	(1, 'J/ADR001/PST/19/03/2026/000001', 1, 1, 1, 'JT30', 30, '2026-04-17', 'N', '', '', '', 1, 'Ben', 0, 12, '2026-03-19', 1, 1500000, 0, 0, 0, 0, 0, 0, 0, 0, 1500000, 0, 1500000, 'Success', '', 1, '2026-03-19 09:18:14'),
	(2, 'J/ADR001/PST/19/03/2026/000002', 1, 1, 1, 'JT7', 7, '2026-03-25', 'N', '', '', '', 1, 'Hen', 0, 12, '2026-03-19', 1, 30000, 0, 0, 0, 0, 0, 0, 0, 0, 30000, 0, 30000, 'Success', '', 1, '2026-03-19 09:21:22'),
	(3, 'J/ADR001/PST/19/03/2026/000003', 1, 1, 1, 'CBD', 0, '2026-03-19', 'N', '', '', '', 1, 'Bun', 0, 12, '2026-03-19', 1, 3000000, 0, 0, 0, 0, 0, 0, 0, 0, 3000000, 0, 3000000, 'Success', '', 1, '2026-03-19 09:22:09'),
	(4, 'J/ADR001/SDM/22/03/2026/000004', 1, 1, 1, 'CBD', 0, '2026-03-22', 'N', '', '', '', 1, '', 0, 2, '2026-03-22', 2, 450000, 0, 0, 0, 0, 0, 0, 0, 0, 450000, 0, 450000, 'Success', '', 1, '2026-03-22 16:43:12'),
	(5, 'J/ADR001/SDM/10/04/2026/000005', 1, 1, 5, 'CBD', 0, '2026-04-10', 'N', '', '', '', 1, 'GR', 0, 1, '2026-04-10', 2, 1000000, 0, 0, 0, 0, 0, 0, 0, 0, 1000000, 1000000, 0, 'Success', '', 1, '2026-04-10 11:38:28');

-- Dumping structure for table pionir.hd_transfer_stock
CREATE TABLE IF NOT EXISTS `hd_transfer_stock` (
  `hd_transfer_stock_id` int NOT NULL AUTO_INCREMENT,
  `hd_transfer_stock_code` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `hd_transfer_stock_initial` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `hd_transfer_stock_date` date NOT NULL,
  `hd_transfer_stock_qty` int NOT NULL,
  `hd_transfer_stock_desc` text COLLATE utf8mb4_general_ci NOT NULL,
  `hd_transfer_stock_status` enum('Cancel','Success') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Success',
  `user_id` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`hd_transfer_stock_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pionir.hd_transfer_stock: ~0 rows (approximately)
INSERT IGNORE INTO `hd_transfer_stock` (`hd_transfer_stock_id`, `hd_transfer_stock_code`, `hd_transfer_stock_initial`, `hd_transfer_stock_date`, `hd_transfer_stock_qty`, `hd_transfer_stock_desc`, `hd_transfer_stock_status`, `user_id`, `created_at`) VALUES
	(4, 'TS/1/20/03/2026/000004', 'RA', '2026-03-20', 100, '', 'Success', 1, '2026-03-20 22:16:39');

-- Dumping structure for table pionir.ms_brand
CREATE TABLE IF NOT EXISTS `ms_brand` (
  `brand_id` int NOT NULL AUTO_INCREMENT,
  `brand_name` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `brand_desc` text COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` enum('Y','N') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Y',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`brand_id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pionir.ms_brand: ~29 rows (approximately)
INSERT IGNORE INTO `ms_brand` (`brand_id`, `brand_name`, `brand_desc`, `is_active`, `created_at`) VALUES
	(1, 'COMFORTA', ' ', 'Y', '2024-12-23 23:49:56'),
	(2, 'IMPORTA', ' ', 'Y', '2024-12-23 23:49:56'),
	(3, 'HOMEDOKI', ' ', 'Y', '2024-12-23 23:49:56'),
	(4, 'HOMELIVING', ' ', 'Y', '2024-12-23 23:49:56'),
	(5, 'BIGLAND', ' ', 'Y', '2024-12-23 23:49:56'),
	(6, 'OCEAN', ' ', 'Y', '2024-12-23 23:49:56'),
	(7, 'SPRINGAIR', ' ', 'Y', '2024-12-23 23:49:56'),
	(8, 'THERAPEDIC', ' ', 'Y', '2024-12-23 23:49:56'),
	(9, 'IMPORIAL', ' ', 'Y', '2024-12-23 23:49:56'),
	(10, 'BIGFOAM', ' ', 'Y', '2024-12-23 23:49:56'),
	(11, 'CAMEL', ' ', 'Y', '2024-12-23 23:49:56'),
	(12, 'INOAC', ' ', 'Y', '2024-12-23 23:49:56'),
	(13, 'KWANTOP', ' ', 'Y', '2024-12-23 23:49:56'),
	(14, 'VICA FOAM', ' ', 'Y', '2024-12-23 23:49:56'),
	(15, 'G-STAR OLYMPIC', ' ', 'Y', '2024-12-23 23:49:56'),
	(16, 'EAGLE KING', ' ', 'Y', '2024-12-23 23:49:56'),
	(17, 'MARCO', ' ', 'Y', '2024-12-23 23:49:56'),
	(18, 'OLYMBED', ' ', 'Y', '2024-12-23 23:49:56'),
	(19, 'LUXURY', ' ', 'Y', '2024-12-23 23:49:56'),
	(20, 'STEEL FOAM', ' ', 'Y', '2024-12-23 23:49:56'),
	(21, 'NAIBA', ' ', 'Y', '2024-12-23 23:49:56'),
	(22, 'AKAKO', '', 'Y', '2024-12-23 23:49:56'),
	(23, 'OLYMPLAST', ' ', 'Y', '2024-12-23 23:49:56'),
	(24, 'WDM KEA', ' ', 'Y', '2024-12-23 23:49:56'),
	(25, 'WAKANDA', ' ', 'Y', '2024-12-23 23:49:56'),
	(50, 'asd', 'asd', 'N', '2025-02-24 16:50:19'),
	(51, 'Brand 2', '', 'N', '2025-03-02 19:32:24'),
	(52, 'MAX', '', 'Y', '2025-05-16 20:10:47'),
	(53, 'CANARE', '', 'Y', '2025-05-16 20:10:52');

-- Dumping structure for table pionir.ms_category
CREATE TABLE IF NOT EXISTS `ms_category` (
  `category_id` int NOT NULL AUTO_INCREMENT,
  `category_name` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `category_desc` text COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` enum('Y','N') COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pionir.ms_category: ~5 rows (approximately)
INSERT IGNORE INTO `ms_category` (`category_id`, `category_name`, `category_desc`, `is_active`) VALUES
	(1, 'Speaker', '', 'Y'),
	(2, 'Kabel', '', 'Y'),
	(3, 'Lampu', '', 'Y'),
	(4, 'Jack', '', 'Y'),
	(5, 'Kabel Mic', '', 'Y');

-- Dumping structure for table pionir.ms_customer
CREATE TABLE IF NOT EXISTS `ms_customer` (
  `customer_id` int NOT NULL AUTO_INCREMENT,
  `customer_code` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `customer_name` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `customer_dob` date NOT NULL,
  `customer_gender` enum('L','P') COLLATE utf8mb4_general_ci NOT NULL,
  `customer_address` text COLLATE utf8mb4_general_ci NOT NULL,
  `customer_address_blok` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `customer_address_no` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `customer_rt` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `customer_rw` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `customer_phone` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `customer_email` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `customer_send_address` text COLLATE utf8mb4_general_ci NOT NULL,
  `customer_npwp` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `customer_nik` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `customer_rate` enum('Normal','Toko','Sales','Khusus') COLLATE utf8mb4_general_ci NOT NULL,
  `customer_poin` int NOT NULL,
  `customer_expedisi_tag` text COLLATE utf8mb4_general_ci NOT NULL,
  `customer_expedisi_tag_id` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` enum('Y','N') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Y',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pionir.ms_customer: ~5 rows (approximately)
INSERT IGNORE INTO `ms_customer` (`customer_id`, `customer_code`, `customer_name`, `customer_dob`, `customer_gender`, `customer_address`, `customer_address_blok`, `customer_address_no`, `customer_rt`, `customer_rw`, `customer_phone`, `customer_email`, `customer_send_address`, `customer_npwp`, `customer_nik`, `customer_rate`, `customer_poin`, `customer_expedisi_tag`, `customer_expedisi_tag_id`, `is_active`, `created_at`) VALUES
	(1, 'ADR001', 'Adrian', '2025-02-28', 'P', 'Jl Paris 2 Komp Nusa Indah', '', '8', '001', '002', '085245139056', 'test@yahoo.com', 'Jl Sei Raya Dalam Komp Taman Sei Raya', '0123.23231.231234454.452342', '12312312.3123123.123123123.123', 'Khusus', 0, 'JNE', '1', 'Y', '2025-03-02 14:20:11'),
	(2, 'ADR002', 'adron', '2025-01-09', 'L', 'Jl Nusa Indah 2', 'K', '9', '002', '009', '07232312312', 'ya@yahoo,com', 'Jl Sei Raya', '2131234312312', '12312312312312', 'Sales', 0, 'JNE', '1', 'Y', '2025-03-02 14:21:11'),
	(3, 'BEN001', 'Beni', '2025-01-09', 'L', 'Jl Indah 2', 'b', '2', '001', '003', '0852123123123', 'asd', 'asd', '123123', '123123', 'Toko', 0, 'JNE,Prima Jaya', '1,2', 'Y', '2025-03-02 14:49:50'),
	(4, 'BEN002', 'Beno', '1992-08-09', 'L', 'Jl Perintis Kemerdekaan', 'B', '9', '002', '223', '123123123', 'ya@yahoo,com', 'asdasdads', '0123.23231.231234454.452342', '123123', 'Khusus', 0, 'JNE,Prima Jaya', '1,2', 'N', '2025-03-02 14:56:58'),
	(8, 'BEN003', 'Beno', '0000-00-00', 'L', 'jl', '1', '1', '1', '1', '123123', '123123', 'asdasd', '123', '123', 'Normal', 0, 'JNE,Prima Jaya', '1,2', 'Y', '2025-03-03 00:23:59');

-- Dumping structure for table pionir.ms_customer_expedisi
CREATE TABLE IF NOT EXISTS `ms_customer_expedisi` (
  `customer_expedisi_id` int NOT NULL AUTO_INCREMENT,
  `customer_code` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `expedisi_id` int NOT NULL,
  PRIMARY KEY (`customer_expedisi_id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pionir.ms_customer_expedisi: ~20 rows (approximately)
INSERT IGNORE INTO `ms_customer_expedisi` (`customer_expedisi_id`, `customer_code`, `expedisi_id`) VALUES
	(1, 'Ben001', 1),
	(2, 'Ben001', 2),
	(3, 'asd001', 1),
	(4, 'asd001', 2),
	(5, 'ben002', 2),
	(6, 'asd002', 1),
	(9, 'ADR002', 1),
	(10, 'BEN001', 1),
	(11, 'BEN001', 2),
	(12, 'BEN002', 1),
	(13, 'BEN002', 2),
	(14, 'BEN003', 1),
	(15, 'BEN003', 2),
	(16, 'ASD001', 1),
	(17, 'ASD001', 2),
	(18, 'ASD002', 1),
	(19, 'ASD002', 2),
	(20, 'BEN003', 1),
	(21, 'BEN003', 2),
	(29, 'ADR001', 1);

-- Dumping structure for table pionir.ms_ekspedisi
CREATE TABLE IF NOT EXISTS `ms_ekspedisi` (
  `ekspedisi_id` int NOT NULL AUTO_INCREMENT,
  `ekspedisi_name` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `ekspedisi_phone` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `ekspedisi_address` text COLLATE utf8mb4_general_ci NOT NULL,
  `ekspedisi_desc` text COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` enum('Y','N') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`ekspedisi_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pionir.ms_ekspedisi: ~5 rows (approximately)
INSERT IGNORE INTO `ms_ekspedisi` (`ekspedisi_id`, `ekspedisi_name`, `ekspedisi_phone`, `ekspedisi_address`, `ekspedisi_desc`, `is_active`) VALUES
	(1, 'JNE', '0862231231', 'Jl Sei Raya Dlaam', 'Keterangan', 'Y'),
	(2, 'Prima Jaya', '0862231231', 'Jl Sei Raya Dlaam', 'Keterangan', 'Y'),
	(3, 'JET', 'asdasd', 'asd', '13asd', 'N'),
	(4, 'Jasa Karya', '', '', '', 'Y'),
	(5, 'Berkat', 'asdasda', '2312512412', 'dasddas', 'Y');

-- Dumping structure for table pionir.ms_module
CREATE TABLE IF NOT EXISTS `ms_module` (
  `module_id` int NOT NULL AUTO_INCREMENT,
  `module_name` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `module_title` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`module_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pionir.ms_module: ~28 rows (approximately)
INSERT IGNORE INTO `ms_module` (`module_id`, `module_name`, `module_title`) VALUES
	(1, 'Brand', 'Brand'),
	(2, 'Customer', 'Pelanggan'),
	(3, 'Ekspedisi', 'Ekspedisi'),
	(4, 'Warehouse', 'Gudang'),
	(5, 'Category', 'Kategori'),
	(6, 'Product', 'Produk'),
	(7, 'Payment', 'Payment'),
	(8, 'Salesman', 'Sales'),
	(9, 'Unit', 'Unit'),
	(10, 'Supplier', 'Supplier'),
	(11, 'Submission', 'Pengajuan'),
	(12, 'PO', 'PO'),
	(13, 'WarehouseInput', 'Input Gudang'),
	(14, 'Purchase', 'Pembelian'),
	(15, 'Search', 'Pencarian'),
	(16, 'SalesOrder', 'Sales Order'),
	(17, 'Sales', 'Penjualan'),
	(18, 'ReturPurchase', 'Retur Pembelian'),
	(19, 'ReturSales', 'Retur Penjualan'),
	(20, 'DebtPayment', 'Pelunasan Hutang'),
	(21, 'ReceivablePayment', 'Pelunasan Piutang'),
	(22, 'TransferStock', 'Transfer Stok'),
	(23, 'RevisiSales', 'Revisi Penjualan'),
	(24, 'RevisiPurchase', 'Revisi Pembelian'),
	(25, 'Opname', 'Opname'),
	(26, 'Report', 'Report'),
	(27, 'Role', 'Role'),
	(28, 'Accountuser', 'Accountuser');

-- Dumping structure for table pionir.ms_note
CREATE TABLE IF NOT EXISTS `ms_note` (
  `ms_note_id` int NOT NULL AUTO_INCREMENT,
  `ms_note_text` text COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`ms_note_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pionir.ms_note: ~0 rows (approximately)
INSERT IGNORE INTO `ms_note` (`ms_note_id`, `ms_note_text`) VALUES
	(1, '1.asd\n2.kabel\n3. jack\n4. hammer\n');

-- Dumping structure for table pionir.ms_payment
CREATE TABLE IF NOT EXISTS `ms_payment` (
  `payment_id` int NOT NULL AUTO_INCREMENT,
  `payment_name` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `payment_no_rek` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` enum('Y','N') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`payment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pionir.ms_payment: ~2 rows (approximately)
INSERT IGNORE INTO `ms_payment` (`payment_id`, `payment_name`, `payment_no_rek`, `is_active`) VALUES
	(1, 'BCA', '6343412323', 'Y'),
	(2, 'Mandri', '4344545345345', 'Y');

-- Dumping structure for table pionir.ms_product
CREATE TABLE IF NOT EXISTS `ms_product` (
  `product_id` int NOT NULL AUTO_INCREMENT,
  `product_code` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `product_name` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `product_brand` int NOT NULL,
  `product_unit` int NOT NULL,
  `product_category` int NOT NULL,
  `product_supplier_id_tag` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `product_supplier_tag` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `product_supplier_name` text COLLATE utf8mb4_general_ci NOT NULL,
  `is_package` enum('Y','N') COLLATE utf8mb4_general_ci NOT NULL,
  `is_ppn` enum('PPN','NON PPN') COLLATE utf8mb4_general_ci NOT NULL,
  `product_min_stock` int NOT NULL,
  `product_min_order` text COLLATE utf8mb4_general_ci NOT NULL,
  `product_weight` int NOT NULL,
  `product_location` text COLLATE utf8mb4_general_ci NOT NULL,
  `product_desc` text COLLATE utf8mb4_general_ci NOT NULL,
  `product_purchase_record` text COLLATE utf8mb4_general_ci NOT NULL,
  `product_key` text COLLATE utf8mb4_general_ci NOT NULL,
  `product_image` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `product_price` int NOT NULL,
  `product_hpp` int NOT NULL,
  `product_sell_percentage_1` int NOT NULL,
  `product_sell_percentage_2` int NOT NULL,
  `product_sell_percentage_3` int NOT NULL,
  `product_sell_percentage_4` int NOT NULL,
  `product_sell_price_1` int NOT NULL COMMENT 'Harga Jual Normal',
  `product_sell_price_2` int NOT NULL COMMENT 'Harga Jual Toko',
  `product_sell_price_3` int NOT NULL COMMENT 'Harga Jual Sales',
  `product_sell_price_4` int NOT NULL COMMENT 'Harga Jual Khusus',
  `product_disc_percentage` int NOT NULL COMMENT 'Harga Discount Normal',
  `product_disc_start_date` date NOT NULL,
  `product_disc_end_date` date NOT NULL,
  `product_status` enum('Aktif','Tidak Aktif','Discontinue') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Aktif',
  `product_po_status` int NOT NULL,
  `is_active` enum('Y','N') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pionir.ms_product: ~6 rows (approximately)
INSERT IGNORE INTO `ms_product` (`product_id`, `product_code`, `product_name`, `product_brand`, `product_unit`, `product_category`, `product_supplier_id_tag`, `product_supplier_tag`, `product_supplier_name`, `is_package`, `is_ppn`, `product_min_stock`, `product_min_order`, `product_weight`, `product_location`, `product_desc`, `product_purchase_record`, `product_key`, `product_image`, `product_price`, `product_hpp`, `product_sell_percentage_1`, `product_sell_percentage_2`, `product_sell_percentage_3`, `product_sell_percentage_4`, `product_sell_price_1`, `product_sell_price_2`, `product_sell_price_3`, `product_sell_price_4`, `product_disc_percentage`, `product_disc_start_date`, `product_disc_end_date`, `product_status`, `product_po_status`, `is_active`) VALUES
	(1, 'ADA001', 'Adaptor 12v 1A HK (Pipih) ⚪', 1, 1, 2, '1,9,10,12,13,12,13,1', 'PT SERU,Bon,DONO,SFG,ALIONG,SFG,ALIONG,PT SERU', '"ALTECH : ADAPTOR 12V / 1A MODEL TIPIS HK : AD003-H ADAPTOR 1A DC 12V"\r\nadas\r\njhgjhk\r\na\r\nb\r\nc', 'N', 'PPN', 12, '0', 12, 'asd', 'asd', 'asdasdas\r\nasdasd\r\nasdasd', 'asd\r\nasdasd\r\nasdasd', 'ADA001kBEsEgoCDC.png', 100000, 7000, 0, 20, 30, 40, 100000, 120000, 130000, 140000, 0, '0000-00-00', '0000-00-00', 'Aktif', 11, 'Y'),
	(7, 'JAC00005', 'Jack Akai Mono MAX Hitam Biru/Orange', 52, 1, 4, '1,9,10,12,13,12,1', 'PT SERU,Bon,DONO,SFG,ALIONG,SFG,PT SERU', ' ALIONG : Jack Akai Mono Max Black DY 1223 Biru / Orange\r\nSGF : Jack DLL\r\nak : abc\r\nabc : ada', 'N', 'NON PPN', 0, '', 25, '(T-SDM) ATAS BELAKANG  /  RUMAH E1', 'Jack Akai Mono MAX Hitam\r\nmono\r\nwarna hitam\r\nkantong biru', 'a\r\nb\r\nc\r\nd\r\ne', 'Jack Akai Mono MAX Hitam Jack Akai MAX Hitam Jack Akai MAX Mono Jack MAX Jack Akai Mono Super MAX Black Tembaga Biru Jack Akai Mono Max Black (B/O) DY 1223', 'JAC00005nPatyQKHg6.png', 7000, 7000, 114, 107, 100, 93, 15000, 14500, 14000, 13500, 0, '0000-00-00', '0000-00-00', 'Aktif', 14, 'Y'),
	(8, 'JAC00006', 'Jack Akai L Riviera / Super Plug Mono', 25, 1, 4, '1,10,12', 'PT SERU,DONO,SFG', 'HK : JC 014. JC Akai Mono L Riviera CJ J01008', 'N', 'NON PPN', 0, '>10 (T) >30 (S) >50 (VIP)', 0, '(T-SDM) GANTUNG ATAS  /  RUMAH E3', 'Jack Akai Mono L NP2C\r\nRiviera / Super Plug', '', 'Jack Akai Riviera L Mono Jack Akai Mono L NP2C riviera / super plugjack akai L super plug monoJC 014. JC Akai Mono L Riviera CJ J01008', 'JAC00006g0syUHWBLO.png', 5000, 5150, 80, 70, 60, 50, 9000, 8500, 8000, 7500, 0, '0000-00-00', '0000-00-00', 'Tidak Aktif', 0, 'Y'),
	(9, 'KAB00007', 'Kabel Mic Canare Besar Biasa Dus Hitam', 53, 3, 5, '12,1,10,13', 'SFG,PT SERU,DONO,ALIONG', 'SGF : Kabel Canare HT', 'N', 'NON PPN', 0, '', 4500, '(T-SDM) BELAKANG  /  SUEZ BAWAH BELAKANG', 'KW Dikabel Tertulis Japan Standard\r\nRoll As Plastik Putih\r\nDimensi Kotak : 29x29x8cm', '', 'Kabel Mic Canare L-2T2S Besar Kabel Canare Besar KW Kabel Canare Biasa Kabel Canare Besar Biasa Kabel Mic Besar Canare Biasa Kabel Mic Canare biasa besar Dus Tulisan Canare Hitam Roll As Plastik Putih Dimensi Kotak : 29x29x8cm KW Dikabel Tertulis Japan Standard', 'KAB000076oTPqWrgRy.png', 450000, 465000, 22, 17, 14, 11, 550000, 525000, 515000, 500000, 0, '0000-00-00', '0000-00-00', 'Aktif', 0, 'Y'),
	(10, 'KAB00008', 'Kabel Mic Canare Besar Biasa Dus Hitam', 53, 4, 5, '12', 'SFG', 'SGF : Kabel Canare HT', 'N', 'NON PPN', 0, '', 55, '(T-SDM) BELAKANG  /  SUEZ BAWAH BELAKANG', 'KW Dikabel Tertulis Japan Standard\r\nRoll As Plastik Putih\r\nDimensi Kotak : 29x29x8cm', '', 'Kabel Mic Canare L-2T2S Besar Kabel Canare Besar KW Kabel Canare Biasa Kabel Canare Besar Biasa Kabel Mic Besar Canare Biasa Kabel Mic Canare biasa besar Dus Tulisan Canare Hitam Roll As Plastik Putih Dimensi Kotak : 29x29x8cm KW Dikabel Tertulis Japan Standard', 'KAB00008YxsRqr7uUe.png', 5625, 5700, 42, 42, 33, 24, 8000, 8000, 7500, 7000, 0, '0000-00-00', '0000-00-00', 'Aktif', 0, 'Y'),
	(11, 'ASD00009', 'asd', 1, 1, 1, '1', 'PT SERU', 'asd', 'N', 'NON PPN', 123, 'a123', 123, '123', 'asd', 'asd', 'asd', 'ASD000097eDnPgGzpD.png', 0, 7000, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00', '0000-00-00', 'Discontinue', 0, 'Y');

-- Dumping structure for table pionir.ms_product_note
CREATE TABLE IF NOT EXISTS `ms_product_note` (
  `ms_product_note_id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `product_desc` text COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`ms_product_note_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pionir.ms_product_note: ~3 rows (approximately)
INSERT IGNORE INTO `ms_product_note` (`ms_product_note_id`, `product_id`, `product_desc`) VALUES
	(1, 1, 'ALIONG 2026-05-08 Jasa Karya<br /> Rp. 100.000 - (10% +0% +0%) = @Rp. 19.990.000 (200) <br /> Ongkir: Rp. 0'),
	(2, 7, 'ALIONG 2026-05-08 Jasa Karya<br /> Rp. 7.000 - (10% +0% +0%) = @Rp. 1.399.300 (200) <br /> Ongkir: Rp. 0'),
	(3, 1, 'SFG 2026-05-08 Jasa Karya<br /> Rp. 100.000 - (2% +0% +0%) = @Rp. 998.264 (10) <br /> Ongkir: Rp. 26');

-- Dumping structure for table pionir.ms_product_stock
CREATE TABLE IF NOT EXISTS `ms_product_stock` (
  `ms_product_stock_id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `warehouse_id` int NOT NULL,
  `stock` int NOT NULL,
  PRIMARY KEY (`ms_product_stock_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pionir.ms_product_stock: ~12 rows (approximately)
INSERT IGNORE INTO `ms_product_stock` (`ms_product_stock_id`, `product_id`, `warehouse_id`, `stock`) VALUES
	(1, 7, 2, 180),
	(3, 9, 2, 0),
	(4, 1, 2, 290),
	(5, 11, 1, 0),
	(6, 1, 14, 100),
	(7, 1, 13, 208),
	(8, 2, 2, 8),
	(9, 1, 15, 100),
	(10, 2, 15, 1),
	(11, 7, 13, 900),
	(12, 9, 13, 10),
	(13, 7, 14, 210);

-- Dumping structure for table pionir.ms_product_supplier
CREATE TABLE IF NOT EXISTS `ms_product_supplier` (
  `product_supplier_id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `supplier_id` int NOT NULL,
  `is_active` enum('Y','N') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`product_supplier_id`)
) ENGINE=InnoDB AUTO_INCREMENT=120 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pionir.ms_product_supplier: ~93 rows (approximately)
INSERT IGNORE INTO `ms_product_supplier` (`product_supplier_id`, `product_id`, `supplier_id`, `is_active`) VALUES
	(3, 2, 1, 'Y'),
	(4, 2, 3, 'Y'),
	(5, 3, 1, 'Y'),
	(6, 4, 1, 'Y'),
	(7, 5, 1, 'Y'),
	(10, 2, 10, 'Y'),
	(11, 2, 9, 'Y'),
	(13, 0, 0, 'Y'),
	(14, 0, 0, 'Y'),
	(15, 0, 0, 'Y'),
	(16, 0, 0, 'Y'),
	(19, 9, 12, 'Y'),
	(20, 10, 12, 'Y'),
	(22, 9, 1, 'Y'),
	(25, 9, 10, 'Y'),
	(32, 0, 0, 'Y'),
	(33, 0, 0, 'Y'),
	(34, 0, 0, 'Y'),
	(35, 0, 0, 'Y'),
	(36, 0, 0, 'Y'),
	(37, 0, 0, 'Y'),
	(38, 0, 0, 'Y'),
	(39, 0, 0, 'Y'),
	(40, 0, 0, 'Y'),
	(41, 9, 13, 'Y'),
	(42, 0, 0, 'Y'),
	(43, 0, 0, 'Y'),
	(44, 0, 0, 'Y'),
	(45, 0, 0, 'Y'),
	(46, 0, 0, 'Y'),
	(51, 0, 0, 'Y'),
	(52, 0, 0, 'Y'),
	(53, 0, 0, 'Y'),
	(54, 0, 0, 'Y'),
	(55, 0, 0, 'Y'),
	(56, 0, 0, 'Y'),
	(57, 0, 0, 'Y'),
	(58, 0, 0, 'Y'),
	(59, 0, 0, 'Y'),
	(60, 0, 0, 'Y'),
	(63, 0, 0, 'Y'),
	(64, 0, 0, 'Y'),
	(65, 0, 0, 'Y'),
	(66, 0, 0, 'Y'),
	(67, 0, 0, 'Y'),
	(68, 0, 0, 'Y'),
	(69, 0, 0, 'Y'),
	(70, 0, 0, 'Y'),
	(71, 0, 0, 'Y'),
	(72, 0, 0, 'Y'),
	(73, 1, 12, 'Y'),
	(75, 1, 13, 'Y'),
	(77, 0, 0, 'Y'),
	(78, 0, 0, 'Y'),
	(79, 0, 0, 'Y'),
	(80, 0, 0, 'Y'),
	(81, 0, 0, 'Y'),
	(83, 0, 0, 'Y'),
	(84, 0, 0, 'Y'),
	(85, 0, 0, 'Y'),
	(86, 0, 0, 'Y'),
	(87, 0, 0, 'Y'),
	(88, 0, 0, 'Y'),
	(89, 0, 0, 'Y'),
	(90, 0, 0, 'Y'),
	(91, 0, 0, 'Y'),
	(92, 0, 0, 'Y'),
	(93, 0, 0, 'Y'),
	(94, 0, 0, 'Y'),
	(95, 0, 0, 'Y'),
	(96, 0, 0, 'Y'),
	(97, 0, 0, 'Y'),
	(98, 0, 0, 'Y'),
	(99, 0, 0, 'Y'),
	(100, 0, 0, 'Y'),
	(101, 0, 0, 'Y'),
	(102, 0, 0, 'Y'),
	(103, 0, 0, 'Y'),
	(104, 0, 0, 'Y'),
	(105, 0, 0, 'Y'),
	(106, 0, 0, 'Y'),
	(107, 7, 12, 'Y'),
	(108, 0, 0, 'Y'),
	(109, 0, 0, 'Y'),
	(110, 0, 0, 'Y'),
	(111, 0, 0, 'Y'),
	(112, 0, 0, 'Y'),
	(113, 0, 0, 'Y'),
	(114, 0, 0, 'Y'),
	(115, 0, 0, 'Y'),
	(116, 0, 0, 'Y'),
	(117, 0, 0, 'Y'),
	(118, 1, 1, 'Y'),
	(119, 7, 1, 'Y');

-- Dumping structure for table pionir.ms_role
CREATE TABLE IF NOT EXISTS `ms_role` (
  `role_id` int NOT NULL AUTO_INCREMENT,
  `role_name` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` enum('Y','N') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pionir.ms_role: ~2 rows (approximately)
INSERT IGNORE INTO `ms_role` (`role_id`, `role_name`, `is_active`) VALUES
	(1, 'Superadmin', 'Y'),
	(8, 'Sales', 'Y');

-- Dumping structure for table pionir.ms_role_permision
CREATE TABLE IF NOT EXISTS `ms_role_permision` (
  `role_permision` int NOT NULL AUTO_INCREMENT,
  `role_id` int NOT NULL,
  `module_id` int NOT NULL,
  `view` enum('Y','N') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'N',
  `add` enum('Y','N') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'N',
  `edit` enum('Y','N') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'N',
  `delete` enum('Y','N') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'N',
  `nav_bar` enum('Y','N') COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`role_permision`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pionir.ms_role_permision: ~28 rows (approximately)
INSERT IGNORE INTO `ms_role_permision` (`role_permision`, `role_id`, `module_id`, `view`, `add`, `edit`, `delete`, `nav_bar`) VALUES
	(1, 1, 1, 'Y', 'Y', 'Y', 'Y', 'Y'),
	(2, 1, 2, 'Y', 'Y', 'Y', 'Y', 'Y'),
	(3, 1, 3, 'Y', 'Y', 'Y', 'Y', 'Y'),
	(4, 1, 4, 'Y', 'Y', 'Y', 'Y', 'Y'),
	(5, 1, 5, 'Y', 'Y', 'Y', 'Y', 'Y'),
	(6, 1, 6, 'Y', 'Y', 'Y', 'Y', 'Y'),
	(7, 1, 7, 'Y', 'Y', 'Y', 'Y', 'Y'),
	(8, 1, 8, 'Y', 'Y', 'Y', 'Y', 'Y'),
	(9, 1, 9, 'Y', 'Y', 'Y', 'Y', 'Y'),
	(10, 1, 10, 'Y', 'Y', 'Y', 'Y', 'Y'),
	(11, 1, 11, 'Y', 'Y', 'Y', 'Y', 'Y'),
	(12, 1, 12, 'Y', 'Y', 'Y', 'Y', 'Y'),
	(13, 1, 13, 'Y', 'Y', 'Y', 'Y', 'Y'),
	(14, 1, 14, 'Y', 'Y', 'Y', 'Y', 'Y'),
	(15, 1, 15, 'Y', 'Y', 'Y', 'Y', 'Y'),
	(16, 1, 16, 'Y', 'Y', 'Y', 'Y', 'Y'),
	(17, 1, 17, 'Y', 'Y', 'Y', 'Y', 'Y'),
	(18, 1, 18, 'Y', 'Y', 'Y', 'Y', 'Y'),
	(19, 1, 19, 'Y', 'Y', 'Y', 'Y', 'Y'),
	(20, 1, 20, 'Y', 'Y', 'Y', 'Y', 'Y'),
	(21, 1, 21, 'Y', 'Y', 'Y', 'Y', 'Y'),
	(22, 1, 22, 'Y', 'Y', 'Y', 'Y', 'Y'),
	(23, 1, 23, 'Y', 'Y', 'Y', 'Y', 'Y'),
	(24, 1, 24, 'Y', 'Y', 'Y', 'Y', 'Y'),
	(25, 1, 25, 'Y', 'Y', 'Y', 'Y', 'Y'),
	(26, 1, 26, 'Y', 'Y', 'Y', 'Y', 'Y'),
	(27, 1, 27, 'Y', 'Y', 'Y', 'Y', 'Y'),
	(28, 1, 28, 'Y', 'Y', 'Y', 'Y', 'Y');

-- Dumping structure for table pionir.ms_salesman
CREATE TABLE IF NOT EXISTS `ms_salesman` (
  `salesman_id` int NOT NULL AUTO_INCREMENT,
  `salesman_name` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `salesman_address` text COLLATE utf8mb4_general_ci NOT NULL,
  `salesman_phone` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `salesman_branch` int NOT NULL,
  `is_active` enum('Y','N') COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`salesman_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pionir.ms_salesman: ~2 rows (approximately)
INSERT IGNORE INTO `ms_salesman` (`salesman_id`, `salesman_name`, `salesman_address`, `salesman_phone`, `salesman_branch`, `is_active`) VALUES
	(1, 'Adrian', 'Jl Sepis', '085245139056', 1, 'Y'),
	(2, 'Budi', 'Jl', '07123123123', 2, 'N');

-- Dumping structure for table pionir.ms_supplier
CREATE TABLE IF NOT EXISTS `ms_supplier` (
  `supplier_id` int NOT NULL AUTO_INCREMENT,
  `supplier_code` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `supplier_name` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `supplier_address` text COLLATE utf8mb4_general_ci NOT NULL,
  `supplier_phone` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` enum('Y','N') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`supplier_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pionir.ms_supplier: ~5 rows (approximately)
INSERT IGNORE INTO `ms_supplier` (`supplier_id`, `supplier_code`, `supplier_name`, `supplier_address`, `supplier_phone`, `is_active`) VALUES
	(1, 'S-00001', 'PT SERU', 'seru', '085245139056', 'Y'),
	(9, 'BO009', 'Bon', 'asd', '123', 'Y'),
	(10, 'DO-010', 'DONO', '123', '123', 'Y'),
	(12, 'SF-011', 'SFG', 'aadsdas', '1312312312', 'Y'),
	(13, 'AL-012', 'ALIONG', 'ASDASDASDAS', '12312312312', 'Y');

-- Dumping structure for table pionir.ms_unit
CREATE TABLE IF NOT EXISTS `ms_unit` (
  `unit_id` int NOT NULL AUTO_INCREMENT,
  `unit_name` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `unit_desc` text COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` enum('Y','N') COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`unit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pionir.ms_unit: ~4 rows (approximately)
INSERT IGNORE INTO `ms_unit` (`unit_id`, `unit_name`, `unit_desc`, `is_active`) VALUES
	(1, 'Pcs', '', 'Y'),
	(2, 'Box', 'asd', 'N'),
	(3, 'Roll (80 Meter)', '', 'Y'),
	(4, 'Meter', '', 'Y');

-- Dumping structure for table pionir.ms_user
CREATE TABLE IF NOT EXISTS `ms_user` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `user_name` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `user_password` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `user_role` int NOT NULL,
  `user_branch` int NOT NULL,
  `is_active` enum('N','Y') COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pionir.ms_user: ~0 rows (approximately)
INSERT IGNORE INTO `ms_user` (`user_id`, `user_name`, `user_password`, `user_role`, `user_branch`, `is_active`, `created_at`) VALUES
	(1, 'admin', '827ccb0eea8a706c4c34a16891f84e7b', 1, 1, 'Y', '2024-02-14 20:40:37');

-- Dumping structure for table pionir.ms_warehouse
CREATE TABLE IF NOT EXISTS `ms_warehouse` (
  `warehouse_id` int NOT NULL AUTO_INCREMENT,
  `warehouse_code` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `warehouse_name` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `warehouse_address` text COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` enum('Y','N') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`warehouse_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pionir.ms_warehouse: ~5 rows (approximately)
INSERT IGNORE INTO `ms_warehouse` (`warehouse_id`, `warehouse_code`, `warehouse_name`, `warehouse_address`, `is_active`) VALUES
	(1, 'PST', 'Pusat', 'Jl. Gajahmada No 03', 'Y'),
	(2, 'SDM', 'SERDAM', 'JL. SEDAM', 'Y'),
	(13, 'BB', 'Bongkar Barang', 'adasdasd', 'Y'),
	(14, 'P', 'PEOK', 'HIJAU', 'Y'),
	(15, 'K', 'KUNING', 'YELLOW', 'Y');

-- Dumping structure for table pionir.product_filter
CREATE TABLE IF NOT EXISTS `product_filter` (
  `product_filter_id` int NOT NULL AUTO_INCREMENT,
  `supplier_filter` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `category_filter` int NOT NULL,
  `brand_filter` int NOT NULL,
  `product_status_filter` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `in_transit_filter` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`product_filter_id`)
) ENGINE=InnoDB AUTO_INCREMENT=118 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pionir.product_filter: ~0 rows (approximately)

-- Dumping structure for table pionir.stock_movement
CREATE TABLE IF NOT EXISTS `stock_movement` (
  `stock_movement_id` int NOT NULL AUTO_INCREMENT,
  `stock_movement_product_id` int NOT NULL,
  `stock_movement_qty` int NOT NULL,
  `stock_movement_before_stock` int NOT NULL,
  `stock_movement_new_stock` int NOT NULL,
  `stock_movement_desc` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `stock_movement_inv` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `stock_movement_calculate` enum('Plus','Minus') COLLATE utf8mb4_general_ci NOT NULL,
  `stock_movement_date` date NOT NULL,
  `stock_movement_creted_by` int NOT NULL,
  `stock_movement_created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`stock_movement_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pionir.stock_movement: ~16 rows (approximately)
INSERT IGNORE INTO `stock_movement` (`stock_movement_id`, `stock_movement_product_id`, `stock_movement_qty`, `stock_movement_before_stock`, `stock_movement_new_stock`, `stock_movement_desc`, `stock_movement_inv`, `stock_movement_calculate`, `stock_movement_date`, `stock_movement_creted_by`, `stock_movement_created_at`) VALUES
	(1, 7, 100, 400, 300, 'Penjualan', 'PJ/BEN001/SDM/20/03/2026/000002', 'Minus', '2026-03-20', 1, '2026-03-20 19:36:34'),
	(2, 7, 100, 300, 400, 'Confirm Retur Penjualan', 'RS/BEN001/20/03/2026/000001', 'Plus', '2026-03-20', 1, '2026-03-20 19:46:10'),
	(3, 7, 100, 400, 300, 'Penjualan', 'PJ/BEN003/SDM/20/03/2026/000002', 'Minus', '2026-03-20', 1, '2026-03-20 19:47:04'),
	(4, 7, 10, 300, 290, 'Transfer Stock', 'TS/1/20/03/2026/000001', 'Minus', '2026-03-20', 1, '2026-03-20 21:43:13'),
	(5, 7, 10, 200, 210, 'Transfer Stock', 'TS/1/20/03/2026/000001', 'Plus', '2026-03-20', 1, '2026-03-20 21:43:13'),
	(6, 7, 100, 290, 190, 'Transfer Stock', 'TS/1/20/03/2026/000004', 'Minus', '2026-03-20', 1, '2026-03-20 22:16:39'),
	(7, 7, 100, 500, 600, 'Transfer Stock', 'TS/1/20/03/2026/000004', 'Plus', '2026-03-20', 1, '2026-03-20 22:16:39'),
	(8, 7, 30, 190, 160, 'Penjualan', 'PJ/ADR001/SDM/22/03/2026/000003', 'Minus', '2026-03-22', 1, '2026-03-22 16:48:01'),
	(9, 1, 20, 320, 300, 'Penjualan', 'PJ/ADR002/SDM/22/03/2026/000004', 'Minus', '2026-03-22', 1, '2026-03-22 16:51:10'),
	(10, 7, 20, 160, 180, 'Confirm Retur Penjualan', 'RS/ADR001/22/03/2026/000003', 'Plus', '2026-03-22', 1, '2026-03-22 16:56:23'),
	(11, 1, 10, 300, 290, 'Penjualan', 'PJ/ADR001/SDM/10/04/2026/000004', 'Minus', '2026-04-10', 1, '2026-04-10 11:38:55'),
	(12, 1, 200, 0, 200, 'Input Stock Pembelian', 'IS/08/05/2026/000019', 'Plus', '2026-05-08', 1, '2026-05-08 15:13:00'),
	(13, 7, 200, 600, 800, 'Input Stock Pembelian', 'IS/08/05/2026/000019', 'Plus', '2026-05-08', 1, '2026-05-08 15:13:00'),
	(14, 1, 10, 200, 210, 'Input Stock Pembelian', 'IS/08/05/2026/000020', 'Plus', '2026-05-08', 1, '2026-05-08 15:35:20'),
	(15, 7, 100, 800, 900, 'Input Stock Pembelian', 'IS/08/05/2026/000020', 'Plus', '2026-05-08', 1, '2026-05-08 15:35:20'),
	(16, 1, 2, 210, 208, 'Confirm Retur Pembelian', 'RP/SF-011/08/05/2026/000001', 'Minus', '2026-05-08', 1, '2026-05-08 15:38:01');

-- Dumping structure for table pionir.submission
CREATE TABLE IF NOT EXISTS `submission` (
  `submission_id` int NOT NULL AUTO_INCREMENT,
  `submission_invoice` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `submission_product_id` int NOT NULL,
  `submission_product_code` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `submission_date` date NOT NULL,
  `submission_warehouse` int NOT NULL,
  `submission_salesman` int NOT NULL,
  `submission_qty` int NOT NULL,
  `last_stock` int NOT NULL,
  `submission_status` enum('Success','Pending','Cancel') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Pending',
  `submission_supplier` int NOT NULL,
  `submission_desc` enum('Urgent','New','Restock') COLLATE utf8mb4_general_ci NOT NULL,
  `submission_text` text COLLATE utf8mb4_general_ci NOT NULL,
  `submission_last_supplier` int DEFAULT NULL,
  `created_by` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`submission_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pionir.submission: ~21 rows (approximately)
INSERT IGNORE INTO `submission` (`submission_id`, `submission_invoice`, `submission_product_id`, `submission_product_code`, `submission_date`, `submission_warehouse`, `submission_salesman`, `submission_qty`, `last_stock`, `submission_status`, `submission_supplier`, `submission_desc`, `submission_text`, `submission_last_supplier`, `created_by`, `created_at`) VALUES
	(1, 'PJ/ADA001/PEOK/24/07/2025/000001', 1, 'ADA001', '2025-07-24', 14, 1, 1, 992, 'Success', 0, 'New', 'adzsd', 0, 1, '2025-07-24 21:59:46'),
	(2, 'PJ/ADA001/Pusat/08/09/2025/000002', 1, 'ADA001', '2025-09-08', 1, 1, 2, 405, 'Success', 0, 'Urgent', 'asd', 1, 1, '2025-09-09 01:28:52'),
	(3, 'PJ/JAC00005/Pusat/02/12/2025/000003', 7, 'JAC00005', '2025-12-02', 1, 0, 500, 2, 'Success', 0, 'Restock', '', 1, 1, '2025-12-02 18:07:46'),
	(4, 'PJ/JAC00005/Bongkar Barang/30/01/2026/000004', 7, 'JAC00005', '2026-01-30', 13, 1, 100, 402, 'Success', 0, 'Restock', '', 13, 1, '2026-01-30 14:44:47'),
	(5, 'PJ/KAB00007/Bongkar Barang/30/01/2026/000005', 9, 'KAB00007', '2026-01-30', 13, 1, 20, 0, 'Success', 0, 'Restock', 'ggg', 0, 1, '2026-01-30 14:47:17'),
	(6, 'PJ/JAC00005/Bongkar Barang/16/02/2026/000006', 7, 'JAC00005', '2026-02-16', 13, 1, 500, 502, 'Success', 0, 'Restock', '', 13, 1, '2026-02-16 12:43:53'),
	(7, 'PJ/ADA001/Bongkar Barang/16/02/2026/000007', 1, 'ADA001', '0000-00-00', 13, 1, 500, 407, 'Success', 0, 'Restock', '', 1, 1, '2026-02-16 12:44:14'),
	(8, 'PJ/ADA001/Bongkar Barang/16/02/2026/000008', 1, 'ADA001', '2026-02-16', 13, 1, 500, 307, 'Cancel', 0, 'Restock', '', 10, 1, '2026-02-16 13:05:08'),
	(9, 'PJ/JAC00005/Bongkar Barang/16/02/2026/000009', 7, 'JAC00005', '0000-00-00', 13, 1, 500, 1002, 'Cancel', 0, 'Restock', 'adasdas', 10, 1, '2026-02-16 13:05:24'),
	(10, 'PJ/JAC00005/Bongkar Barang/02/03/2026/000010', 7, 'JAC00005', '2026-03-02', 13, 1, 200, 992, 'Success', 0, 'Restock', '', 10, 1, '2026-03-02 10:26:58'),
	(11, 'PJ/ADA001/Bongkar Barang/02/03/2026/000011', 1, 'ADA001', '0000-00-00', 13, 1, 200, 287, 'Success', 0, 'Restock', '', 10, 1, '2026-03-02 10:27:14'),
	(12, 'PJ/ADA001/Bongkar Barang/02/03/2026/000012', 1, 'ADA001', '2026-03-02', 13, 1, 100, 487, 'Cancel', 0, 'Restock', '', 13, 1, '2026-03-02 10:37:44'),
	(13, 'PJ/JAC00005/Bongkar Barang/07/03/2026/000013', 7, 'JAC00005', '2026-03-07', 13, 1, 100, 1192, 'Success', 0, 'Restock', 'STOK', 13, 1, '2026-03-07 09:50:43'),
	(14, 'PJ/ADA001/Pusat/17/03/2026/000014', 1, 'ADA001', '2026-03-17', 1, 1, 2, 520, 'Success', 0, 'Urgent', 'test', 12, 1, '2026-03-17 13:13:20'),
	(15, 'PJ/JAC00005/Pusat/30/03/2026/000015', 7, 'JAC00005', '2026-03-30', 1, 1, 100, 990, 'Success', 0, '', '', 12, 1, '2026-03-30 10:18:41'),
	(16, 'PJ/ADA001/Pusat/30/03/2026/000016', 1, 'ADA001', '0000-00-00', 1, 1, 200, 500, 'Success', 0, '', '', 12, 1, '2026-03-30 10:18:53'),
	(17, 'PJ/JAC00005/Bongkar Barang/08/05/2026/000017', 7, 'JAC00005', '2026-05-08', 13, 1, 200, 990, 'Success', 0, 'Urgent', '', 12, 1, '2026-05-08 14:33:39'),
	(18, 'PJ/ADA001/Bongkar Barang/08/05/2026/000018', 1, 'ADA001', '0000-00-00', 13, 1, 200, 490, 'Success', 0, 'Restock', '', 12, 1, '2026-05-08 14:34:12'),
	(19, 'PJ/ADA001/Bongkar Barang/08/05/2026/000019', 1, 'ADA001', '2026-05-08', 13, 0, 0, 690, 'Success', 0, 'Restock', '', 12, 1, '2026-05-08 15:19:47'),
	(20, 'PJ/JAC00005/Bongkar Barang/08/05/2026/000020', 7, 'JAC00005', '0000-00-00', 13, 0, 0, 1190, 'Success', 0, 'Restock', '', 13, 1, '2026-05-08 15:19:56'),
	(21, 'PJ/JAC00005/Bongkar Barang/08/05/2026/000021', 7, 'JAC00005', '0000-00-00', 13, 0, 0, 1190, 'Success', 0, 'Restock', '', 13, 1, '2026-05-08 15:20:10'),
	(22, 'PJ/ADA001/SERDAM/03/06/2026/000022', 1, 'ADA001', '2026-06-03', 2, 1, 10, 698, 'Pending', 0, 'Urgent', '', 1, 1, '2026-06-03 15:27:26'),
	(24, 'PJ/ADA001/SERDAM/03/06/2026/000023', 1, 'ADA001', '2026-06-03', 2, 1, 2, 698, 'Pending', 0, 'Urgent', '', 1, 1, '2026-06-03 15:29:11'),
	(25, 'PJ/ADA001/SERDAM/03/06/2026/000024', 1, 'ADA001', '2026-06-03', 2, 1, 12, 698, 'Pending', 0, 'Urgent', '', 1, 1, '2026-06-03 15:31:21'),
	(26, 'PJ/ADA001/SERDAM/03/06/2026/000025', 1, 'ADA001', '2026-06-03', 2, 1, 12, 698, 'Pending', 0, 'Urgent', 'asd', 1, 1, '2026-06-03 15:32:08'),
	(27, 'PJ/ADA001/Bongkar Barang/03/06/2026/000026', 1, 'ADA001', '2026-06-03', 13, 1, 23, 698, 'Pending', 0, 'Urgent', 'asd', 1, 1, '2026-06-03 15:32:19');

-- Dumping structure for table pionir.temp_input_stock
CREATE TABLE IF NOT EXISTS `temp_input_stock` (
  `temp_is_product_id` int NOT NULL,
  `temp_is_qty_order` int NOT NULL,
  `temp_is_qty` int NOT NULL,
  `temp_is_supplier` int NOT NULL,
  `temp_is_po_id` int NOT NULL,
  `temp_is_po_code` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `temp_is_warehouse` int NOT NULL,
  `temp_is_ekspedisi` int NOT NULL,
  `temp_is_note` text COLLATE utf8mb4_general_ci NOT NULL,
  `temp_is_user_id` int NOT NULL,
  `created_at` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pionir.temp_input_stock: ~0 rows (approximately)

-- Dumping structure for table pionir.temp_opname
CREATE TABLE IF NOT EXISTS `temp_opname` (
  `temp_opname_product_id` int NOT NULL AUTO_INCREMENT,
  `temp_opname_warehouse_id` int NOT NULL,
  `temp_opname_system_stock` int NOT NULL,
  `temp_opname_fisik_stock` int NOT NULL,
  `temp_opname_diferent_stock` int NOT NULL,
  `temp_opname_diferent_hpp` int NOT NULL,
  `temp_opname_note` text COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`temp_opname_product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pionir.temp_opname: ~0 rows (approximately)

-- Dumping structure for table pionir.temp_payment_debt
CREATE TABLE IF NOT EXISTS `temp_payment_debt` (
  `temp_purchase_nominal` int NOT NULL DEFAULT '0',
  `temp_payment_debt_purchase_id` int NOT NULL,
  `temp_payment_debt_discount` int NOT NULL DEFAULT '0',
  `temp_payment_debt_nominal` int NOT NULL DEFAULT '0',
  `temp_payment_debt_retur` int NOT NULL,
  `temp_payment_debt_desc` text NOT NULL,
  `temp_payment_debt_new_remaining` int NOT NULL,
  `temp_payment_debt_is_edited` enum('Y','N') NOT NULL DEFAULT 'N',
  `temp_payment_debt_user_id` int unsigned NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table pionir.temp_payment_debt: ~0 rows (approximately)

-- Dumping structure for table pionir.temp_payment_receivable
CREATE TABLE IF NOT EXISTS `temp_payment_receivable` (
  `temp_sales_nominal` int NOT NULL DEFAULT '0',
  `temp_payment_receivable_sales_id` int NOT NULL,
  `temp_payment_receivable_discount` int NOT NULL DEFAULT '0',
  `temp_payment_receivable_nominal` int NOT NULL DEFAULT '0',
  `temp_payment_receivable_retur` int NOT NULL,
  `temp_payment_receivable_desc` text NOT NULL,
  `temp_payment_receivable_new_remaining` int NOT NULL,
  `temp_payment_receivable_is_edited` enum('Y','N') NOT NULL DEFAULT 'N',
  `temp_payment_receivable_user_id` int unsigned NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table pionir.temp_payment_receivable: ~0 rows (approximately)

-- Dumping structure for table pionir.temp_po
CREATE TABLE IF NOT EXISTS `temp_po` (
  `temp_po_id` int NOT NULL AUTO_INCREMENT,
  `temp_submission_id` int DEFAULT NULL,
  `temp_submission_inv` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `temp_supplier_id` int NOT NULL,
  `temp_product_id` int NOT NULL,
  `temp_po_price` int NOT NULL,
  `temp_po_qty` int NOT NULL,
  `temp_po_weight` int NOT NULL,
  `temp_po_ongkir` int NOT NULL,
  `temp_po_total_weight` int NOT NULL,
  `temp_po_total_ongkir` int NOT NULL,
  `temp_po_total` int NOT NULL,
  `temp_po_note` text COLLATE utf8mb4_general_ci NOT NULL,
  `temp_user_id` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`temp_po_id`)
) ENGINE=InnoDB AUTO_INCREMENT=273 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pionir.temp_po: ~0 rows (approximately)
INSERT IGNORE INTO `temp_po` (`temp_po_id`, `temp_submission_id`, `temp_submission_inv`, `temp_supplier_id`, `temp_product_id`, `temp_po_price`, `temp_po_qty`, `temp_po_weight`, `temp_po_ongkir`, `temp_po_total_weight`, `temp_po_total_ongkir`, `temp_po_total`, `temp_po_note`, `temp_user_id`, `created_at`) VALUES
	(271, 0, '', 1, 1, 100000, 2, 12, 0, 24, 0, 200000, '', 1, '2026-06-03 23:22:23'),
	(272, 0, '', 1, 7, 7000, 2, 25, 0, 50, 0, 14000, '', 1, '2026-06-03 23:22:23');

-- Dumping structure for table pionir.temp_purchase
CREATE TABLE IF NOT EXISTS `temp_purchase` (
  `temp_product_id` int NOT NULL,
  `temp_purchase_price` int NOT NULL,
  `temp_purchase_qty_order` int NOT NULL,
  `temp_purchase_qty` int NOT NULL,
  `temp_purchase_weight` int NOT NULL,
  `temp_purchase_ongkir` int NOT NULL,
  `temp_purchase_total_weight` int NOT NULL,
  `temp_purchase_total_ongkir` int NOT NULL,
  `temp_purchase_total` int NOT NULL,
  `temp_purchase_po_id` int NOT NULL,
  `temp_purchase_note` text COLLATE utf8mb4_general_ci NOT NULL,
  `temp_user_id` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pionir.temp_purchase: ~0 rows (approximately)

-- Dumping structure for table pionir.temp_retur_purchase
CREATE TABLE IF NOT EXISTS `temp_retur_purchase` (
  `temp_retur_purchase_b_id` int NOT NULL,
  `temp_retur_purchase_b_inv` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `temp_retur_purchase_warehouse_id` int NOT NULL,
  `temp_retur_purchase_product_id` int NOT NULL,
  `temp_retur_purchase_product_name` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `temp_retur_purchase_price` int NOT NULL,
  `temp_retur_purchase_qty` int NOT NULL,
  `temp_retur_purchase_qty_buy` int NOT NULL,
  `temp_retur_purchase_ongkir` int NOT NULL,
  `temp_retur_purchase_total` int NOT NULL,
  `temp_retur_purchase_note` text COLLATE utf8mb4_general_ci NOT NULL,
  `temp_retur_purchase_supplier` int NOT NULL,
  `temp_user_id` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pionir.temp_retur_purchase: ~0 rows (approximately)

-- Dumping structure for table pionir.temp_retur_sales
CREATE TABLE IF NOT EXISTS `temp_retur_sales` (
  `temp_retur_sales_b_id` int NOT NULL,
  `temp_retur_sales_b_inv` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `temp_retur_sales_product_id` int NOT NULL,
  `temp_retur_sales_product_name` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `temp_retur_sales_price` int NOT NULL,
  `temp_retur_sales_qty` int NOT NULL,
  `temp_retur_sales_qty_sales` int NOT NULL,
  `temp_retur_sales_total` int NOT NULL,
  `temp_retur_sales_note` text COLLATE utf8mb4_general_ci NOT NULL,
  `temp_retur_sales_customer` int NOT NULL,
  `temp_user_id` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pionir.temp_retur_sales: ~0 rows (approximately)

-- Dumping structure for table pionir.temp_sales
CREATE TABLE IF NOT EXISTS `temp_sales` (
  `temp_product_id` int NOT NULL,
  `temp_so_id` int NOT NULL,
  `temp_sales_rate` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `temp_sales_price` int NOT NULL,
  `temp_sales_qty` int NOT NULL,
  `temp_sales_discount` int NOT NULL,
  `temp_sales_total` int NOT NULL,
  `temp_user_id` int NOT NULL,
  `temp_desc_item` text COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pionir.temp_sales: ~0 rows (approximately)

-- Dumping structure for table pionir.temp_sales_order
CREATE TABLE IF NOT EXISTS `temp_sales_order` (
  `temp_product_id` int NOT NULL,
  `temp_so_rate` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `temp_so_price` int NOT NULL,
  `temp_so_qty` int NOT NULL,
  `temp_so_discount` int NOT NULL,
  `temp_so_total` int NOT NULL,
  `temp_so_note` text COLLATE utf8mb4_general_ci NOT NULL,
  `temp_user_id` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pionir.temp_sales_order: ~0 rows (approximately)

-- Dumping structure for table pionir.temp_transfer_stock
CREATE TABLE IF NOT EXISTS `temp_transfer_stock` (
  `temp_transfer_stock_product_id` int NOT NULL AUTO_INCREMENT,
  `temp_transfer_stock_qty` int NOT NULL DEFAULT '0',
  `temp_transfer_stock_warehouse_from` int NOT NULL DEFAULT '0',
  `temp_transfer_stock_warehouse_to` int NOT NULL DEFAULT '0',
  `temp_transfer_stock_from_qty` int NOT NULL DEFAULT '0',
  `temp_transfer_stock_to_qty` int NOT NULL DEFAULT '0',
  `temp_transfer_stock_note` int NOT NULL DEFAULT '0',
  `user_id` int NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`temp_transfer_stock_product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pionir.temp_transfer_stock: ~0 rows (approximately)
INSERT IGNORE INTO `temp_transfer_stock` (`temp_transfer_stock_product_id`, `temp_transfer_stock_qty`, `temp_transfer_stock_warehouse_from`, `temp_transfer_stock_warehouse_to`, `temp_transfer_stock_from_qty`, `temp_transfer_stock_to_qty`, `temp_transfer_stock_note`, `user_id`, `created_at`) VALUES
	(1, 21, 2, 1, 290, 0, 0, 1, '2026-06-04 07:24:04');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
