-- Migrasi: satuan besar (package) per produk, misal 1 Ball = 10 Pcs
-- Jalankan sekali di database retail.
-- Stok tetap disimpan dalam satuan terkecil; saat jual 1 Ball, stok berkurang 10 Pcs.

CREATE TABLE IF NOT EXISTS `ms_product_package` (
  `package_id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `package_name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `package_qty` int NOT NULL COMMENT 'isi per satuan besar (dalam satuan terkecil)',
  `is_active` enum('Y','N') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`package_id`),
  KEY `idx_package_product` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- keranjang penjualan: satuan yang dipilih (0 = satuan terkecil), isi per satuan
ALTER TABLE temp_sales
  ADD COLUMN temp_package_id   INT NOT NULL DEFAULT 0 AFTER temp_sales_total,
  ADD COLUMN temp_package_conv INT NOT NULL DEFAULT 1 AFTER temp_package_id;

-- detail penjualan: dt_sales_qty tetap dalam satuan terkecil, ini hanya info tampilan
ALTER TABLE dt_sales
  ADD COLUMN dt_sales_package_name  VARCHAR(50) NOT NULL DEFAULT '' AFTER dt_sales_profit,
  ADD COLUMN dt_sales_package_conv  INT NOT NULL DEFAULT 1 AFTER dt_sales_package_name,
  ADD COLUMN dt_sales_package_count INT NOT NULL DEFAULT 0 AFTER dt_sales_package_conv;
