-- Migrasi: cara hitung laba baru (modal disimpan per transaksi)
-- Jalankan sekali di database retail.

-- 1) product_hpp_discount jadi angka. Kosong = NULL (artinya pakai product_hpp)
ALTER TABLE ms_product
  MODIFY COLUMN product_hpp_discount DECIMAL(15,2) NULL DEFAULT NULL;
UPDATE ms_product SET product_hpp_discount = NULL;

-- 2) simpan modal & laba per baris penjualan saat transaksi
ALTER TABLE dt_sales
  ADD COLUMN dt_sales_cost   DECIMAL(15,2) NOT NULL DEFAULT 0 AFTER dt_sales_total,
  ADD COLUMN dt_sales_profit DECIMAL(15,2) NOT NULL DEFAULT 0 AFTER dt_sales_cost;

-- 3) isi data penjualan lama dengan modal produk saat ini
--    (sama dengan hasil laporan lama, yang juga memakai product_hpp saat ini)
UPDATE dt_sales d
JOIN ms_product p ON d.dt_sales_product_id = p.product_id
SET d.dt_sales_cost   = COALESCE(NULLIF(p.product_hpp_discount, 0), p.product_hpp),
    d.dt_sales_profit = d.dt_sales_total - d.dt_sales_qty * COALESCE(NULLIF(p.product_hpp_discount, 0), p.product_hpp);

-- 4) Harga Hulu = harga jual ke-5
ALTER TABLE ms_product
  ADD COLUMN product_sell_percentage_5 INT NOT NULL DEFAULT 0 AFTER product_sell_percentage_4,
  ADD COLUMN product_sell_price_5      INT NOT NULL DEFAULT 0 AFTER product_sell_price_4;
