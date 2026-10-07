<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Detail Product</title>

  <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/plugins.min.css" />
  <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/kaiadmin.min.css" />
    <script src="<?php echo base_url(); ?>dist/js/plugin/webfont/webfont.min.js"></script>
  <script>
    WebFont.load({
      google: { families: ["Public Sans:300,400,500,600,700"] },
      custom: {
        families: [
          "Font Awesome 5 Solid",
          "Font Awesome 5 Regular",
          "Font Awesome 5 Brands",
          "simple-line-icons",
        ],
        urls: ["<?php echo base_url(); ?>dist/css/fonts.min.css"],
      },
      active: function () {
        sessionStorage.fonts = true;
      },
    });
  </script>
  <style type="text/css">
    :root{
      --green:#0f9d58; --green-soft:#e6f6ee; --line:#e6ebf1; --text:#1c2733; --muted:#6b7785;
    }
    *{ box-sizing:border-box; }
    body{ background:#fff; font-family:"Public Sans",Arial,sans-serif; color:var(--text); margin:0; }
    .dp-wrap{ display:flex; flex-direction:column; min-height:100vh; }
    .dp-head{ display:flex; align-items:center; gap:14px; padding:14px 20px; border-bottom:1px solid var(--line); }
    .dp-head-icon{ width:48px; height:48px; border-radius:12px; background:var(--green-soft); color:var(--green); display:flex; align-items:center; justify-content:center; font-size:22px; }
    .dp-head h3{ margin:0; font-size:22px; font-weight:700; }
    .dp-head p{ margin:2px 0 0; color:var(--muted); font-size:14px; }
    .dp-body{ display:grid; grid-template-columns:270px 1fr 1.25fr; gap:14px; padding:14px 16px; background:#fff; flex:1; }
    .dp-card{ border:1px solid var(--line); border-radius:12px; padding:14px; background:#fff; }
    .dp-photo img{ width:100%; aspect-ratio:1/1; object-fit:cover; border-radius:10px; background:#f3f5f8; }
    .dp-name{ font-size:20px; font-weight:800; margin:14px 0 8px; text-transform:uppercase; }
    .dp-pill{ display:inline-flex; align-items:center; gap:6px; padding:5px 12px; border-radius:20px; font-size:13px; font-weight:600; }
    .dp-pill.ok{ background:var(--green-soft); color:var(--green); }
    .dp-pill.off{ background:#fdeaea; color:#d93025; }
    .dp-info{ width:100%; border-collapse:collapse; }
    .dp-info tr{ border-bottom:1px solid var(--line); }
    .dp-info tr:last-child{ border-bottom:none; }
    .dp-info td{ padding:9px 4px; font-size:14px; vertical-align:middle; }
    .dp-info td.ic{ width:34px; color:#2f6fed; text-align:center; }
    .dp-info td.lb{ width:150px; }
    .dp-tag{ display:inline-block; background:#1a73e8; color:#fff; font-size:11px; font-weight:700; padding:2px 8px; border-radius:4px; margin-right:3px; }
    .dp-dot{ display:inline-block; width:18px; height:18px; border-radius:50%; vertical-align:middle; margin-right:6px; }
    .dp-dot.ok{ background:#6fcf97; } .dp-dot.off{ background:#d93025; }
    .dp-x{ display:inline-flex; width:22px; height:22px; border-radius:50%; align-items:center; justify-content:center; color:#fff; font-size:11px; margin-right:6px; vertical-align:middle; }
    .dp-x.no{ background:#e5484d; } .dp-x.yes{ background:#30a46c; }
    .dp-money{ display:inline-block; padding:3px 10px; border-radius:6px; font-size:13px; font-weight:500; }
    .dp-money.red{ background:#fdeaea; color:#d93025; }
    .dp-money.blue{ background:#e8f0fe; color:#1a56db; }
    .dp-money.orange{ background:#fff1dc; color:#e07b00; }
    .dp-right{ display:flex; flex-direction:column; gap:14px; }
    .dp-sec-head{ display:flex; align-items:center; gap:12px; margin-bottom:10px; }
    .dp-sec-icon{ width:42px; height:42px; border-radius:10px; background:var(--green-soft); color:var(--green); display:flex; align-items:center; justify-content:center; font-size:18px; }
    .dp-sec-head b{ display:block; font-size:16px; }
    .dp-sec-head span{ color:var(--muted); font-size:13px; }
    .dp-table{ width:100%; border-collapse:collapse; font-size:14px; }
    .dp-table th{ background:var(--green-soft); text-align:left; padding:11px 14px; font-weight:700; }
    .dp-table td{ padding:11px 14px; border-bottom:1px solid var(--line); }
    .dp-badge{ display:inline-block; padding:3px 12px; border-radius:6px; font-weight:600; font-size:13px; }
    .b1{ background:#dbeafe; color:#1d4ed8; } .b2{ background:#dcfce7; color:#15803d; }
    .b3{ background:#fef3c7; color:#b45309; } .b4{ background:#ede9fe; color:#7c3aed; }
    .dp-period{ font-size:13px; color:var(--muted); margin:0 0 8px; }
    .dp-foot{ display:flex; justify-content:flex-end; gap:10px; padding:12px 16px; border-top:1px solid var(--line); }
    .dp-btn{ display:inline-flex; align-items:center; gap:8px; padding:10px 18px; border-radius:8px; border:1px solid var(--line); background:#f8fafc; color:var(--text); font-weight:600; font-size:14px; text-decoration:none; }
    .dp-btn.edit{ background:#eff6ff; border-color:#93c5fd; color:#1d4ed8; }
    @media (max-width:992px){ .dp-body{ grid-template-columns:1fr; } }
  </style>
</head>
<body>
<?php foreach($data['get_product_by_id'] as $row){
  $img = ($row->product_image != '') ? base_url().'assets/products/'.$row->product_image : '';
  $is_active = in_array(strtolower($row->product_status), array('aktif', 'active'));
  $disc = (float) $row->product_disc_percentage;
  $types = array(1=>array('Umum','b1'), 2=>array('Toko','b2'), 3=>array('Sales','b3'), 4=>array('Khusus','b4'), 5=>array('Hulu','b4'));
?>
<div class="dp-wrap">
  <div class="dp-head">
    <div class="dp-head-icon"><i class="fas fa-cube"></i></div>
    <div>
      <h3>Detail Product</h3>
      <p>Informasi lengkap data produk.</p>
    </div>
  </div>

  <div class="dp-body">
    <!-- KOLOM 1: FOTO -->
    <div class="dp-card dp-photo">
      <?php if($img != ''){ ?><img src="<?php echo $img; ?>" alt="Product Image"><?php } ?>
      <div class="dp-name"><?php echo htmlspecialchars($row->product_name); ?></div>
      <span class="dp-pill <?php echo $is_active ? 'ok' : 'off'; ?>"><i class="fas fa-<?php echo $is_active ? 'check-circle' : 'times-circle'; ?>"></i> <?php echo htmlspecialchars($row->product_status); ?></span>
    </div>

    <!-- KOLOM 2: INFORMASI -->
    <div class="dp-card">
      <table class="dp-info">
        <tr><td class="ic"><i class="fas fa-barcode"></i></td><td class="lb">Kode Produk</td><td><?php echo htmlspecialchars($row->product_code); ?></td></tr>
        <tr><td class="ic"><i class="fas fa-cube"></i></td><td class="lb">Nama Produk</td><td><?php echo htmlspecialchars($row->product_name); ?></td></tr>
        <tr><td class="ic"><i class="fas fa-tag"></i></td><td class="lb">Kategori</td><td><?php echo htmlspecialchars($row->category_name); ?></td></tr>
        <tr><td class="ic"><i class="fas fa-ruler"></i></td><td class="lb">Satuan</td><td><?php echo htmlspecialchars($row->unit_name); ?></td></tr>
        <tr><td class="ic"><i class="fas fa-bookmark"></i></td><td class="lb">Brand</td><td><?php echo htmlspecialchars($row->brand_name); ?></td></tr>
        <tr><td class="ic"><i class="fas fa-truck"></i></td><td class="lb">Supplier</td><td><?php foreach(explode(",", $row->product_supplier_tag) as $sup){ if(trim($sup) != ''){ echo '<span class="dp-tag">'.htmlspecialchars(trim($sup)).'</span>'; } } ?></td></tr>
        <tr><td class="ic"><i class="fas fa-circle-notch"></i></td><td class="lb">Status</td><td><span class="dp-dot <?php echo $is_active ? 'ok' : 'off'; ?>"></span><?php echo htmlspecialchars($row->product_status); ?></td></tr>
        <tr><td class="ic"><i class="fas fa-box-open"></i></td><td class="lb">Paket</td><td><?php $y = ($row->is_package == 'Y'); ?><span class="dp-x <?php echo $y ? 'yes' : 'no'; ?>"><i class="fas fa-<?php echo $y ? 'check' : 'times'; ?>"></i></span><?php echo $y ? 'Ya' : 'Tidak'; ?></td></tr>
        <tr><td class="ic"><i class="fas fa-percent"></i></td><td class="lb">PPN</td><td><?php $y = ($row->is_ppn == 'PPN'); ?><span class="dp-x <?php echo $y ? 'yes' : 'no'; ?>"><i class="fas fa-<?php echo $y ? 'check' : 'times'; ?>"></i></span><?php echo $y ? 'Ya' : 'Tidak'; ?></td></tr>
        <tr><td class="ic"><i class="fas fa-cubes"></i></td><td class="lb">Min Stock</td><td><?php echo $row->product_min_stock; ?></td></tr>
        <tr><td class="ic"><i class="fas fa-coins"></i></td><td class="lb">HPP</td><td><span class="dp-money red">Rp. <?php echo number_format($row->product_hpp, 0, ',', '.'); ?></span></td></tr>
        <tr><td class="ic"><i class="fas fa-shopping-cart"></i></td><td class="lb">Harga Beli</td><td><span class="dp-money red">Rp. <?php echo number_format($row->product_price, 0, ',', '.'); ?></span></td></tr>
        <tr><td class="ic"><i class="fas fa-file-alt"></i></td><td class="lb">Deskripsi</td><td><?php echo trim($row->product_desc) != '' ? nl2br(htmlspecialchars($row->product_desc)) : '-'; ?></td></tr>
      </table>
    </div>

    <!-- KOLOM 3: HARGA & STOK -->
    <div class="dp-right">
      <div class="dp-card">
        <div class="dp-sec-head">
          <div class="dp-sec-icon"><i class="fas fa-tags"></i></div>
          <div><b>Harga dan Diskon</b><span>Pengaturan harga per jenis penjualan.</span></div>
        </div>
        <?php if(!empty($row->product_disc_start_date) && !empty($row->product_disc_end_date)){ ?>
          <p class="dp-period">Periode diskon: <?php echo date('d-m-Y', strtotime($row->product_disc_start_date)); ?> / <?php echo date('d-m-Y', strtotime($row->product_disc_end_date)); ?></p>
        <?php } ?>
        <table class="dp-table">
          <thead><tr><th>Jenis</th><th>Margin</th><th>Harga Jual</th><th>Diskon (%)</th><th>Diskon (Rp)</th></tr></thead>
          <tbody>
          <?php foreach($types as $n => $t){
            $sell = $row->{'product_sell_price_'.$n};
            $pct  = $row->{'product_sell_percentage_'.$n};
          ?>
            <tr>
              <td><span class="dp-badge <?php echo $t[1]; ?>"><?php echo $t[0]; ?></span></td>
              <td><?php echo $pct; ?> %</td>
              <td><span class="dp-money blue">Rp. <?php echo number_format($sell, 0, ',', '.'); ?></span></td>
              <td><?php echo $disc; ?> %</td>
              <td><span class="dp-money orange">Rp. <?php echo number_format($sell - ($sell * $disc / 100), 0, ',', '.'); ?></span></td>
            </tr>
          <?php } ?>
          </tbody>
        </table>
      </div>

      <div class="dp-card">
        <div class="dp-sec-head">
          <div class="dp-sec-icon"><i class="fas fa-home"></i></div>
          <div><b>Cabang / Gudang</b><span>Informasi stok di setiap cabang atau gudang.</span></div>
        </div>
        <table class="dp-table">
          <thead><tr><th>Cabang / Gudang</th><th>Qty</th></tr></thead>
          <tbody>
          <?php foreach($data['product_stock'] as $rows){ ?>
            <tr><td>Stok Gudang</td><td><?php echo $rows->stock; ?> <?php echo $rows->unit_name; ?></td></tr>
          <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="dp-foot">
    <a class="dp-btn edit" target="_top" href="<?php echo base_url(); ?>Masterdata/settingproduct?id=<?php echo $row->product_id; ?>"><i class="fas fa-pen"></i> Edit Produk</a>
  </div>
</div>
<?php } ?>
</body>
</html>
