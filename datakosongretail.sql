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


-- Dumping database structure for retail
CREATE DATABASE IF NOT EXISTS `retail` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `retail`;

-- Dumping structure for table retail.activity_table
CREATE TABLE IF NOT EXISTS `activity_table` (
  `activity_table_id` int NOT NULL AUTO_INCREMENT,
  `activity_table_desc` text COLLATE utf8mb4_general_ci NOT NULL,
  `activity_table_user` int NOT NULL,
  `activity_table_module` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `activity_table_ref` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`activity_table_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table retail.activity_table: ~0 rows (approximately)

-- Dumping structure for table retail.dt_opname
CREATE TABLE IF NOT EXISTS `dt_opname` (
  `dt_opanme_id` int NOT NULL AUTO_INCREMENT,
  `opname_id` int NOT NULL,
  `dt_opname_product_id` int NOT NULL,
  `dt_opname_stock_awal` int NOT NULL,
  `dt_opname_stock_akhir` int NOT NULL,
  `dt_opname_stock_difference` int NOT NULL,
  `dt_opname_stock_difference_hpp` int NOT NULL,
  `dt_opname_stock_status` enum('Minus','Plus') COLLATE utf8mb4_general_ci NOT NULL,
  `dt_opname_note` text COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`dt_opanme_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table retail.dt_opname: ~0 rows (approximately)

-- Dumping structure for table retail.dt_payment_debt
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

-- Dumping data for table retail.dt_payment_debt: ~0 rows (approximately)

-- Dumping structure for table retail.dt_payment_receivable
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

-- Dumping data for table retail.dt_payment_receivable: ~0 rows (approximately)

-- Dumping structure for table retail.dt_po
CREATE TABLE IF NOT EXISTS `dt_po` (
  `dt_po_id` int NOT NULL AUTO_INCREMENT,
  `hd_po_id` int NOT NULL,
  `dt_product_id` int NOT NULL,
  `dt_po_price` int NOT NULL,
  `dt_po_qty` int NOT NULL,
  `dt_po_total` int NOT NULL,
  PRIMARY KEY (`dt_po_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table retail.dt_po: ~0 rows (approximately)

-- Dumping structure for table retail.dt_purchase
CREATE TABLE IF NOT EXISTS `dt_purchase` (
  `dt_purchase_id` int NOT NULL AUTO_INCREMENT,
  `hd_purchase_id` int NOT NULL,
  `dt_product_id` int NOT NULL,
  `dt_purchase_price` int NOT NULL,
  `dt_purchase_qty` int NOT NULL,
  `dt_purchase_total` int NOT NULL,
  PRIMARY KEY (`dt_purchase_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table retail.dt_purchase: ~0 rows (approximately)

-- Dumping structure for table retail.dt_retur_purchase
CREATE TABLE IF NOT EXISTS `dt_retur_purchase` (
  `dt_retur_purchase_id` int NOT NULL AUTO_INCREMENT,
  `hd_retur_purchase_id` int NOT NULL,
  `dt_retur_warehouse_id` int NOT NULL,
  `dt_retur_purchase_b_id` int NOT NULL,
  `dt_retur_purchase_product_id` int NOT NULL,
  `dt_retur_purchase_price` int NOT NULL,
  `dt_retur_purchase_qty` int NOT NULL,
  `dt_retur_purchase_total` int NOT NULL,
  `dt_retur_purchase_note` text COLLATE utf8mb4_general_ci NOT NULL,
  `dt_retur_purchase_process` enum('Y','N') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'N',
  PRIMARY KEY (`dt_retur_purchase_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table retail.dt_retur_purchase: ~0 rows (approximately)

-- Dumping structure for table retail.dt_retur_sales
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table retail.dt_retur_sales: ~0 rows (approximately)

-- Dumping structure for table retail.dt_sales
CREATE TABLE IF NOT EXISTS `dt_sales` (
  `dt_sales_id` int NOT NULL AUTO_INCREMENT,
  `hd_sales_id` int NOT NULL,
  `dt_sales_product_id` int NOT NULL,
  `dt_sales_price` int NOT NULL,
  `dt_sales_qty` int NOT NULL,
  `dt_sales_discount` int NOT NULL,
  `dt_sales_total` int NOT NULL,
  `dt_sales_cost` decimal(15,2) NOT NULL DEFAULT 0,
  `dt_sales_profit` decimal(15,2) NOT NULL DEFAULT 0,
  `dt_sales_desc` text COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`dt_sales_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table retail.dt_sales: ~0 rows (approximately)

-- Dumping structure for table retail.hd_opname
CREATE TABLE IF NOT EXISTS `hd_opname` (
  `opname_id` int unsigned NOT NULL AUTO_INCREMENT,
  `opname_code` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `opname_warehouse` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `opname_date` date NOT NULL,
  `opname_user` int NOT NULL DEFAULT '0',
  `opname_total` int NOT NULL DEFAULT '0',
  `opname_status` enum('Success','Cancel') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Success',
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`opname_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table retail.hd_opname: ~0 rows (approximately)

-- Dumping structure for table retail.hd_payment_debt
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

-- Dumping data for table retail.hd_payment_debt: ~0 rows (approximately)

-- Dumping structure for table retail.hd_payment_receivable
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

-- Dumping data for table retail.hd_payment_receivable: ~0 rows (approximately)

-- Dumping structure for table retail.hd_po
CREATE TABLE IF NOT EXISTS `hd_po` (
  `hd_po_id` int NOT NULL AUTO_INCREMENT,
  `hd_po_invoice` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `hd_po_date` date NOT NULL,
  `hd_po_warehouse` int NOT NULL,
  `hd_po_supplier` int NOT NULL,
  `hd_po_tax` enum('PPN','NON PPN') COLLATE utf8mb4_general_ci NOT NULL,
  `hd_po_due_date` date NOT NULL,
  `hd_po_payment` int NOT NULL,
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
  `hd_po_grand_total` int NOT NULL,
  `hd_po_status` enum('Pending','Success','Cancel') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Pending',
  `hd_po_note` text COLLATE utf8mb4_general_ci,
  `created_by` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`hd_po_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table retail.hd_po: ~0 rows (approximately)

-- Dumping structure for table retail.hd_purchase
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
  `hd_purchase_due_date` date NOT NULL,
  `hd_purchase_payment` int NOT NULL,
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
  `hd_purchase_dp` int NOT NULL,
  `hd_purchase_grand_total` int NOT NULL,
  `hd_purchase_remaining_debt` int NOT NULL,
  `hd_purchase_status` enum('Success','Cancel') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Success',
  `hd_purchase_note` text COLLATE utf8mb4_general_ci,
  `created_by` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`hd_purchase_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table retail.hd_purchase: ~0 rows (approximately)

-- Dumping structure for table retail.hd_retur_purchase
CREATE TABLE IF NOT EXISTS `hd_retur_purchase` (
  `hd_retur_purchase_id` int NOT NULL AUTO_INCREMENT,
  `hd_retur_purchase_inv` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `hd_retur_purchase_supplier_id` int NOT NULL,
  `hd_retur_purchase_date` date NOT NULL,
  `hd_retur_purchase_total` int NOT NULL,
  `hd_retur_purchase_note` text COLLATE utf8mb4_general_ci NOT NULL,
  `hd_retur_purchase_status` enum('Success','Cancel','Pending') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Success',
  `hd_retur_purchase_payment_type` enum('Cash','PN','Garansi') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_by` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`hd_retur_purchase_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table retail.hd_retur_purchase: ~0 rows (approximately)

-- Dumping structure for table retail.hd_retur_sales
CREATE TABLE IF NOT EXISTS `hd_retur_sales` (
  `hd_retur_sales_id` int NOT NULL AUTO_INCREMENT,
  `hd_retur_sales_inv` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `hd_retur_sales_customer_id` int NOT NULL,
  `hd_retur_sales_date` date NOT NULL,
  `hd_retur_sales_total` int NOT NULL,
  `hd_retur_sales_note` text COLLATE utf8mb4_general_ci NOT NULL,
  `hd_retur_sales_status` enum('Success','Cancel','Pending') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Success',
  `hd_retur_sales_payment_type` enum('Cash','PN','Garansi') COLLATE utf8mb4_general_ci NOT NULL,
  `created_by` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`hd_retur_sales_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table retail.hd_retur_sales: ~0 rows (approximately)

-- Dumping structure for table retail.hd_sales
CREATE TABLE IF NOT EXISTS `hd_sales` (
  `hd_sales_id` int NOT NULL AUTO_INCREMENT,
  `hd_sales_inv` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `hd_sales_customer` int NOT NULL,
  `hd_sales_payment` int NOT NULL,
  `hd_sales_due_date` date NOT NULL,
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
  `created_by` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`hd_sales_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table retail.hd_sales: ~0 rows (approximately)

-- Dumping structure for table retail.ms_brand
CREATE TABLE IF NOT EXISTS `ms_brand` (
  `brand_id` int NOT NULL AUTO_INCREMENT,
  `brand_name` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `brand_desc` text COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` enum('Y','N') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Y',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`brand_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table retail.ms_brand: ~3 rows (approximately)

-- Dumping structure for table retail.ms_category
CREATE TABLE IF NOT EXISTS `ms_category` (
  `category_id` int NOT NULL AUTO_INCREMENT,
  `category_name` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `category_desc` text COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` enum('Y','N') COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table retail.ms_category: ~4 rows (approximately)

-- Dumping structure for table retail.ms_customer
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
  `customer_npwp` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `customer_nik` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` enum('Y','N') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Y',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table retail.ms_customer: ~5 rows (approximately)

-- Dumping structure for table retail.ms_module
CREATE TABLE IF NOT EXISTS `ms_module` (
  `module_id` int NOT NULL AUTO_INCREMENT,
  `module_name` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `module_title` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`module_id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table retail.ms_module: ~19 rows (approximately)
INSERT IGNORE INTO `ms_module` (`module_id`, `module_name`, `module_title`) VALUES
	(1, 'Brand', 'Brand'),
	(2, 'Customer', 'Pelanggan'),
	(3, 'Category', 'Kategori'),
	(4, 'Product', 'Produk'),
	(5, 'Payment', 'Payment'),
	(6, 'Unit', 'Unit'),
	(7, 'Supplier', 'Supplier'),
	(8, 'PO', 'PO'),
	(9, 'Purchase', 'Pembelian'),
	(10, 'ReturPurchase', 'Retur Pembelian'),
	(11, 'Sales', 'Penjualan'),
	(12, 'ReturSales', 'Retur Penjualan'),
	(13, 'DebtPayment', 'Pelunasan Hutang'),
	(14, 'ReceivablePayment', 'Pelunasan Piutang'),
	(15, 'Opname', 'Opname'),
	(16, 'Report', 'Report'),
	(17, 'Role', 'Role'),
	(18, 'Accountuser', 'Accountuser'),
	(19, 'Search', 'Pencarian');

-- Dumping structure for table retail.ms_note
CREATE TABLE IF NOT EXISTS `ms_note` (
  `ms_note_id` int NOT NULL AUTO_INCREMENT,
  `ms_note_text` text COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`ms_note_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table retail.ms_note: ~0 rows (approximately)
INSERT IGNORE INTO `ms_note` (`ms_note_id`, `ms_note_text`) VALUES
	(1, '1.asd\n2.kabel\n3. jack\n4. hammer\n');

-- Dumping structure for table retail.ms_payment
CREATE TABLE IF NOT EXISTS `ms_payment` (
  `payment_id` int NOT NULL AUTO_INCREMENT,
  `payment_name` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `payment_no_rek` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` enum('Y','N') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`payment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table retail.ms_payment: ~3 rows (approximately)
INSERT IGNORE INTO `ms_payment` (`payment_id`, `payment_name`, `payment_no_rek`, `is_active`) VALUES
	(1, 'CASH', '0000000000', 'Y'),
	(2, 'Mandri', '4344545345345', 'Y'),
	(3, 'BCA', '6343412323', 'Y');

-- Dumping structure for table retail.ms_product
CREATE TABLE IF NOT EXISTS `ms_product` (
  `product_id` int NOT NULL AUTO_INCREMENT,
  `product_code` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `product_name` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `product_brand` int NOT NULL,
  `product_unit` int NOT NULL,
  `product_category` int NOT NULL,
  `product_supplier_id_tag` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `product_supplier_tag` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `is_package` enum('Y','N') COLLATE utf8mb4_general_ci NOT NULL,
  `is_ppn` enum('PPN','NON PPN') COLLATE utf8mb4_general_ci NOT NULL,
  `product_min_stock` int NOT NULL,
  `product_desc` text COLLATE utf8mb4_general_ci NOT NULL,
  `product_image` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `product_price` int NOT NULL,
  `product_hpp` int NOT NULL,
  `product_hpp_discount` decimal(15,2) DEFAULT NULL,
  `product_sell_percentage_1` int NOT NULL,
  `product_sell_percentage_2` int NOT NULL,
  `product_sell_percentage_3` int NOT NULL,
  `product_sell_percentage_4` int NOT NULL,
  `product_sell_percentage_5` int NOT NULL DEFAULT 0,
  `product_sell_price_1` int NOT NULL COMMENT 'Harga Jual Normal',
  `product_sell_price_2` int NOT NULL COMMENT 'Harga Jual Toko',
  `product_sell_price_3` int NOT NULL COMMENT 'Harga Jual Sales',
  `product_sell_price_4` int NOT NULL COMMENT 'Harga Jual Khusus',
  `product_sell_price_5` int NOT NULL DEFAULT 0,
  `product_disc_percentage` int NOT NULL COMMENT 'Harga Discount Normal',
  `product_disc_start_date` date NOT NULL,
  `product_disc_end_date` date NOT NULL,
  `product_status` enum('Aktif','Tidak Aktif','Discontinue') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Aktif',
  `is_active` enum('Y','N') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table retail.ms_product: ~9 rows (approximately)

-- Dumping structure for table retail.ms_product_stock
CREATE TABLE IF NOT EXISTS `ms_product_stock` (
  `ms_product_stock_id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `warehouse_id` int NOT NULL,
  `stock` int NOT NULL,
  PRIMARY KEY (`ms_product_stock_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table retail.ms_product_stock: ~9 rows (approximately)

-- Dumping structure for table retail.ms_product_supplier
CREATE TABLE IF NOT EXISTS `ms_product_supplier` (
  `product_supplier_id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `supplier_id` int NOT NULL,
  `is_active` enum('Y','N') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`product_supplier_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table retail.ms_product_supplier: ~9 rows (approximately)

-- Dumping structure for table retail.ms_role
CREATE TABLE IF NOT EXISTS `ms_role` (
  `role_id` int NOT NULL AUTO_INCREMENT,
  `role_name` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` enum('Y','N') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table retail.ms_role: ~0 rows (approximately)
INSERT IGNORE INTO `ms_role` (`role_id`, `role_name`, `is_active`) VALUES
	(1, 'Superadmin', 'Y');

-- Dumping structure for table retail.ms_role_permision
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
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table retail.ms_role_permision: ~20 rows (approximately)
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
	(20, 1, 20, 'Y', 'Y', 'Y', 'Y', 'Y');

-- Dumping structure for table retail.ms_role_permision_product
CREATE TABLE IF NOT EXISTS `ms_role_permision_product` (
  `ms_role_permision_product_id` int NOT NULL AUTO_INCREMENT,
  `role_id` int NOT NULL,
  `access_umum_price` enum('Y','N') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Y',
  `access_store_price` enum('Y','N') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Y',
  `access_sales_price` enum('Y','N') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Y',
  `access_special_price` enum('Y','N') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Y',
  `access_purchase_price` enum('Y','N') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Y',
  `access_stock` enum('Y','N') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Y',
  `access_item_supplier` enum('Y','N') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Y',
  `access_supplier` enum('Y','N') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Y',
  `access_status` enum('Y','N') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`ms_role_permision_product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table retail.ms_role_permision_product: ~2 rows (approximately)
INSERT IGNORE INTO `ms_role_permision_product` (`ms_role_permision_product_id`, `role_id`, `access_umum_price`, `access_store_price`, `access_sales_price`, `access_special_price`, `access_purchase_price`, `access_stock`, `access_item_supplier`, `access_supplier`, `access_status`) VALUES
	(1, 1, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y'),
	(2, 9, 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y');

-- Dumping structure for table retail.ms_supplier
CREATE TABLE IF NOT EXISTS `ms_supplier` (
  `supplier_id` int NOT NULL AUTO_INCREMENT,
  `supplier_code` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `supplier_name` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `supplier_address` text COLLATE utf8mb4_general_ci NOT NULL,
  `supplier_phone` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` enum('Y','N') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`supplier_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table retail.ms_supplier: ~7 rows (approximately)

-- Dumping structure for table retail.ms_unit
CREATE TABLE IF NOT EXISTS `ms_unit` (
  `unit_id` int NOT NULL AUTO_INCREMENT,
  `unit_name` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `unit_desc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `is_active` enum('Y','N') COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`unit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table retail.ms_unit: ~6 rows (approximately)
INSERT IGNORE INTO `ms_unit` (`unit_id`, `unit_name`, `unit_desc`, `is_active`) VALUES
	(1, 'PCS', NULL, 'Y'),
	(2, 'DUS', NULL, 'Y');

-- Dumping structure for table retail.ms_user
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

-- Dumping data for table retail.ms_user: ~0 rows (approximately)
INSERT IGNORE INTO `ms_user` (`user_id`, `user_name`, `user_password`, `user_role`, `user_branch`, `is_active`, `created_at`) VALUES
	(1, 'admin', '827ccb0eea8a706c4c34a16891f84e7b', 1, 1, 'Y', '2024-02-14 20:40:37');

-- Dumping structure for table retail.ms_warehouse
CREATE TABLE IF NOT EXISTS `ms_warehouse` (
  `warehouse_id` int NOT NULL AUTO_INCREMENT,
  `warehouse_code` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `warehouse_name` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `warehouse_address` text COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` enum('Y','N') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`warehouse_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table retail.ms_warehouse: ~0 rows (approximately)
INSERT IGNORE INTO `ms_warehouse` (`warehouse_id`, `warehouse_code`, `warehouse_name`, `warehouse_address`, `is_active`) VALUES
	(1, 'UTM', 'UTAMA', 'Jl. Gajahmada No 03', 'Y');

-- Dumping structure for table retail.product_filter
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

-- Dumping data for table retail.product_filter: ~0 rows (approximately)

-- Dumping structure for table retail.stock_movement
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table retail.stock_movement: ~0 rows (approximately)

-- Dumping structure for table retail.temp_input_stock
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

-- Dumping data for table retail.temp_input_stock: ~0 rows (approximately)

-- Dumping structure for table retail.temp_opname
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

-- Dumping data for table retail.temp_opname: ~0 rows (approximately)

-- Dumping structure for table retail.temp_payment_debt
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

-- Dumping data for table retail.temp_payment_debt: ~0 rows (approximately)

-- Dumping structure for table retail.temp_payment_receivable
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

-- Dumping data for table retail.temp_payment_receivable: ~0 rows (approximately)

-- Dumping structure for table retail.temp_po
CREATE TABLE IF NOT EXISTS `temp_po` (
  `temp_po_id` int NOT NULL AUTO_INCREMENT,
  `temp_supplier_id` int NOT NULL,
  `temp_product_id` int NOT NULL,
  `temp_po_price` int NOT NULL,
  `temp_po_qty` int NOT NULL,
  `temp_po_total` int NOT NULL,
  `temp_user_id` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`temp_po_id`)
) ENGINE=InnoDB AUTO_INCREMENT=383 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table retail.temp_po: ~0 rows (approximately)

-- Dumping structure for table retail.temp_purchase
CREATE TABLE IF NOT EXISTS `temp_purchase` (
  `temp_product_id` int NOT NULL,
  `temp_purchase_supplier_id` int NOT NULL,
  `temp_purchase_price` int NOT NULL,
  `temp_purchase_qty_order` int NOT NULL,
  `temp_purchase_qty` int NOT NULL,
  `temp_purchase_total` int NOT NULL,
  `temp_purchase_po_id` int NOT NULL,
  `temp_purchase_po_inv` varchar(50) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `temp_user_id` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table retail.temp_purchase: ~0 rows (approximately)

-- Dumping structure for table retail.temp_retur_purchase
CREATE TABLE IF NOT EXISTS `temp_retur_purchase` (
  `temp_retur_purchase_b_id` int NOT NULL,
  `temp_retur_purchase_b_inv` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `temp_retur_purchase_warehouse_id` int NOT NULL,
  `temp_retur_purchase_product_id` int NOT NULL,
  `temp_retur_purchase_product_name` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `temp_retur_purchase_price` int NOT NULL,
  `temp_retur_purchase_qty` int NOT NULL,
  `temp_retur_purchase_qty_buy` int NOT NULL,
  `temp_retur_purchase_total` int NOT NULL,
  `temp_retur_purchase_note` text COLLATE utf8mb4_general_ci NOT NULL,
  `temp_retur_purchase_supplier` int NOT NULL,
  `temp_user_id` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table retail.temp_retur_purchase: ~0 rows (approximately)

-- Dumping structure for table retail.temp_retur_sales
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

-- Dumping data for table retail.temp_retur_sales: ~0 rows (approximately)

-- Dumping structure for table retail.temp_sales
CREATE TABLE IF NOT EXISTS `temp_sales` (
  `temp_product_id` int NOT NULL,
  `temp_so_id` int NOT NULL,
  `temp_sales_price` int NOT NULL,
  `temp_sales_qty` int NOT NULL,
  `temp_sales_discount` int NOT NULL,
  `temp_sales_total` int NOT NULL,
  `temp_user_id` int NOT NULL,
  `temp_desc_item` text COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table retail.temp_sales: ~0 rows (approximately)

-- Dumping structure for table retail.temp_sales_order
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

-- Dumping data for table retail.temp_sales_order: ~0 rows (approximately)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
