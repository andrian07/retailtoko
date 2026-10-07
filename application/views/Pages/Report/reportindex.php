<?php
define('DOC_ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].'/');
require DOC_ROOT_PATH . $this->config->item('header');

// daftar kartu laporan: [judul, deskripsi, ikon, ikon latar, warna, daftar laporan [nama, url]]
$report_groups = array(
  array('Laporan Master Data', 'Laporan data dasar sistem POS.', 'fas fa-layer-group', 'fas fa-layer-group', 'green', array(
    array('Laporan Brand', 'Reportmaster/reportbrand'),
    array('Laporan Customer', 'Reportmaster/reportcustomer'),
    array('Laporan Kategori', 'Reportmaster/reportcategory'),
    array('Laporan Produk', 'Reportmaster/reportproduct'),
    array('Laporan Supplier', 'Reportmaster/reportsupplier'),
  )),
  array('Laporan Pembelian', 'Laporan transaksi pembelian.', 'fas fa-shopping-cart', 'fas fa-shopping-bag', 'blue', array(
    array('Laporan PO', 'Reportpurchase/reportpo'),
    array('Laporan Pembelian', 'Reportpurchase/reportpurchases'),
    array('Laporan Retur Pembelian', 'Reportpurchase/reportreturpurchase'),
  )),
  array('Laporan Penjualan', 'Laporan transaksi penjualan.', 'fas fa-shopping-cart', 'fas fa-chart-bar', 'pink', array(
    array('Laporan Penjualan', 'Reportsales/reportsaless'),
    array('Laporan Retur Penjualan', 'Reportsales/reportretursales'),
  )),
  array('Laporan Hutang / Piutang', 'Laporan hutang dan piutang.', 'fas fa-wallet', 'fas fa-wallet', 'orange', array(
    array('Laporan Hutang Jatuh Tempo', 'Reportpayment/reportdebtduedate'),
    array('Laporan Piutang Jatuh Tempo', 'Reportpayment/reportrepaymentduedate'),
    array('Laporan Pelunasan Hutang', 'Reportpayment/reportrepayments'),
    array('Laporan Pelunasan Piutang', 'Reportpayment/reportpiutang'),
  )),
  array('Laporan Utility', 'Laporan stok dan utilitas lainnya.', 'fas fa-cog', 'fas fa-cog', 'purple', array(
    array('Laporan Stok', 'Reportstock/stockist'),
    array('Laporan Kartu Stok', 'Reportstock/stockcard'),
    array('Laba Rugi', 'Reportstock/profit_and_loss'),
  )),
);
?>
<style type="text/css">
  .report-page { padding-top: 28px !important; }

  .report-title { display: flex; align-items: center; gap: 18px; margin: 4px 0 22px; }
  .report-title-icon { width: 72px; height: 72px; border-radius: 18px; background: #dff3ea; color: #0f8a5f; display: flex; align-items: center; justify-content: center; font-size: 1.9rem; flex-shrink: 0; }
  .report-title h3 { margin: 0; font-size: 1.75rem; font-weight: 800; color: #111827; }
  .report-title p { margin: 4px 0 0; color: #6b7280; font-size: 1rem; }

  .report-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(290px, 1fr)); gap: 18px; }

  .report-card {
    --c: #0f8a5f; --c-soft: #eaf7f1; --c-bg: #f7fcfa;
    position: relative; overflow: hidden;
    background: linear-gradient(160deg, var(--c-bg) 0%, #fff 55%);
    border: 1px solid #eef0f3; border-radius: 16px;
    box-shadow: 0 4px 16px rgba(16, 24, 40, .05);
    padding: 22px 22px 18px;
    display: flex; flex-direction: column;
    transition: transform .15s, box-shadow .15s;
  }
  .report-card:hover { transform: translateY(-2px); box-shadow: 0 10px 26px rgba(16, 24, 40, .09); }
  .report-card.blue   { --c: #1d6ff2; --c-soft: #e8f0fe; --c-bg: #f5f8ff; }
  .report-card.pink   { --c: #e83e8c; --c-soft: #fde8f1; --c-bg: #fff6fa; }
  .report-card.orange { --c: #f07f1a; --c-soft: #fff1e3; --c-bg: #fff9f3; }
  .report-card.purple { --c: #7c4dff; --c-soft: #efe9ff; --c-bg: #faf8ff; }

  .report-card .bg-art { position: absolute; top: 14px; right: 18px; font-size: 5rem; color: var(--c); opacity: .08; pointer-events: none; }

  .report-card-icon { width: 64px; height: 64px; border-radius: 14px; background: var(--c); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.6rem; box-shadow: 0 6px 16px rgba(0,0,0,.12); margin-bottom: 18px; position: relative; }
  .report-card h4 { margin: 0; font-size: 1.2rem; font-weight: 800; color: #111827; position: relative; }
  .report-card .desc { margin: 4px 0 0; color: #6b7280; font-size: .95rem; position: relative; }

  .report-list { list-style: none; margin: 16px 0 16px; padding: 12px 0 0; border-top: 1px solid #e9ecef; flex: 1; }
  .report-list li a { display: flex; align-items: center; gap: 14px; padding: 8px 8px; border-radius: 8px; color: #1f2937; font-size: .98rem; text-decoration: none; transition: background .15s, color .15s; }
  .report-list li a i { color: #9aa3b1; font-size: 1.05rem; width: 16px; text-align: center; }
  .report-list li a:hover { background: var(--c-soft); color: var(--c); }
  .report-list li a:hover i { color: var(--c); }

  /* keterangan jumlah laporan (bukan tombol, tidak bisa diklik) */
  .report-open { display: flex; align-items: center; justify-content: space-between; padding: 12px 12px 12px 18px; border-radius: 12px; background: var(--c-soft); color: var(--c); font-weight: 700; font-size: .95rem; cursor: default; user-select: none; }
  .report-open span.arrow { min-width: 32px; height: 32px; padding: 0 8px; border-radius: 16px; background: #fff; color: var(--c); display: flex; align-items: center; justify-content: center; font-size: .9rem; font-weight: 800; box-shadow: 0 2px 6px rgba(0,0,0,.08); }

  @media (max-width: 575px) {
    .report-title-icon { width: 56px; height: 56px; font-size: 1.5rem; }
    .report-title h3 { font-size: 1.4rem; }
  }
</style>
</div>

<div class="container">
  <div class="page-inner report-page">

    <div class="report-title">
      <div class="report-title-icon"><i class="fas fa-file-alt"></i></div>
      <div>
        <h3>Laporan</h3>
        <p>Pilih jenis laporan yang ingin Anda lihat.</p>
      </div>
    </div>

    <div class="report-grid">
      <?php foreach ($report_groups as $group) { list($title, $desc, $icon, $art, $color, $reports) = $group; ?>
        <div class="report-card <?php echo $color; ?>">
          <i class="<?php echo $art; ?> bg-art"></i>
          <div class="report-card-icon"><i class="<?php echo $icon; ?>"></i></div>
          <h4><?php echo $title; ?></h4>
          <p class="desc"><?php echo $desc; ?></p>

          <ul class="report-list">
            <?php foreach ($reports as $report) { ?>
              <li><a href="<?php echo base_url().$report[1]; ?>"><i class="fas fa-file-alt"></i><?php echo $report[0]; ?></a></li>
            <?php } ?>
          </ul>

          <div class="report-open">
            <span><i class="fas fa-folder-open me-2"></i>Laporan tersedia</span>
            <span class="arrow"><?php echo count($reports); ?></span>
          </div>
        </div>
      <?php } ?>
    </div>

  </div>
</div>

<?php
require DOC_ROOT_PATH . $this->config->item('footer');
?>
