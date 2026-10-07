<?php 
define('DOC_ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].'/');
require DOC_ROOT_PATH . $this->config->item('header');

$row     = isset($data['settingproduct'][0]) ? $data['settingproduct'][0] : null;
$access  = $data['check_access'][0];
$img_url = base_url().'assets/products/';
$price_types = array(
  1 => array('Umum',   'fas fa-user'),
  2 => array('Toko',   'fas fa-store'),
  3 => array('Sales',  'fas fa-user-tie'),
  4 => array('Khusus', 'fas fa-crown'),
  5 => array('Hulu',   'fas fa-sitemap'),
);
?>
</div>
<link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/product-detail.css?v=<?php echo @filemtime(FCPATH.'dist/css/product-detail.css'); ?>">

<div class="container">
<div class="page-inner pd-page">
<?php if($row == null){ ?>
  <div class="pd-card text-center">Produk tidak ditemukan. <a href="<?php echo base_url(); ?>Masterdata/product">Kembali ke daftar produk</a></div>
<?php } else {
  $image        = ($row->product_image != '' && file_exists(FCPATH.'assets/products/'.$row->product_image)) ? $row->product_image : 'default.png';
  $supplier_ids = array_filter(explode(',', $row->product_supplier_id_tag));
  $total_stock  = 0;
  foreach($data['product_stock'] as $st){ $total_stock += $st->stock; }
?>

  <div class="pd-top">
    <div class="pd-breadcrumb">
      <a href="<?php echo base_url(); ?>Dashboard"><i class="fas fa-home"></i></a>
      <i class="fas fa-chevron-right sep"></i>
      <span>Master Data</span>
      <i class="fas fa-chevron-right sep"></i>
      <a href="<?php echo base_url(); ?>Masterdata/product">Produk</a>
      <i class="fas fa-chevron-right sep"></i>
      <span class="cur">Detail Produk</span>
    </div>
    <div class="pd-actions">
      <a class="pd-btn" href="<?php echo base_url(); ?>Masterdata/product"><i class="fas fa-chevron-left"></i> Kembali</a>
      <?php if($access->delete == 'Y'){ ?><button type="button" class="pd-btn del" id="btn_delete"><i class="fas fa-trash-alt"></i> Hapus</button><?php } ?>
      <button type="button" class="pd-btn save" id="btn_save"><i class="fas fa-save"></i> Simpan Perubahan</button>
    </div>
  </div>

  <form id="pd_form" autocomplete="off" onsubmit="return false;">
  <input type="hidden" id="product_id" value="<?php echo (int) $row->product_id; ?>">

  <!-- ===== Hero ===== -->
  <div class="pd-hero">
    <div class="pd-photo">
      <img id="pd_img" src="<?php echo $img_url.htmlspecialchars($image); ?>" alt="">
      <button type="button" class="pd-photo-rm<?php echo $image != 'default.png' ? ' can' : ''; ?>" id="pd_img_rm" title="Hapus gambar"><i class="fas fa-trash-alt"></i></button>
      <button type="button" class="pd-photo-btn" id="pd_img_pick" title="Ganti gambar"><i class="fas fa-camera"></i></button>
      <input type="file" id="pd_file" accept="image/*" hidden>
    </div>
    <div class="pd-hero-main">
      <span class="pd-code-chip">Kode: <span id="hero_code"><?php echo htmlspecialchars($row->product_code); ?></span></span>
      <h2 id="hero_name"><?php echo htmlspecialchars($row->product_name); ?></h2>
      <div class="pd-chips">
        <span class="pd-chip" id="hero_status"></span>
        <span class="pd-chip blue"><i class="fas fa-layer-group"></i> <span id="hero_supplier"></span></span>
        <span class="pd-chip"><i class="fas fa-box"></i> <span id="hero_category"></span></span>
        <span class="pd-chip"><i class="fas fa-building"></i> <span id="hero_brand"></span></span>
      </div>
      <div class="pd-hero-desc" id="hero_desc"></div>
    </div>
  </div>

  <div class="pd-grid">
    <!-- ===== Kolom kiri: Informasi Produk ===== -->
    <div class="pd-col">
      <div class="pd-card">
        <div class="pd-card-head"><div class="pd-card-icon"><i class="far fa-id-card"></i></div><h4>Informasi Produk</h4></div>

        <div class="pd-row"><label>Kode Produk <span class="req">*</span></label>
          <input type="text" class="form-control" id="product_code" value="<?php echo htmlspecialchars($row->product_code); ?>"></div>
        <div class="pd-row"><label>Nama Produk <span class="req">*</span></label>
          <input type="text" class="form-control" id="product_name" value="<?php echo htmlspecialchars($row->product_name); ?>"></div>
        <div class="pd-row"><label>Kategori <span class="req">*</span></label>
          <select class="form-select" id="product_category">
            <?php foreach($data['category_list'] as $c){ ?><option value="<?php echo $c->category_id; ?>"<?php echo $c->category_id == $row->category_id ? ' selected' : ''; ?>><?php echo htmlspecialchars($c->category_name); ?></option><?php } ?>
          </select></div>
        <div class="pd-row"><label>Brand <span class="req">*</span></label>
          <select class="form-select" id="product_brand">
            <?php foreach($data['brand_list'] as $b){ ?><option value="<?php echo $b->brand_id; ?>"<?php echo $b->brand_id == $row->brand_id ? ' selected' : ''; ?>><?php echo htmlspecialchars($b->brand_name); ?></option><?php } ?>
          </select></div>
        <div class="pd-row"><label>Supplier <span class="req">*</span></label>
          <select class="form-select" id="product_supplier" multiple="multiple">
            <?php foreach($data['supplier_list'] as $s){ ?><option value="<?php echo $s->supplier_id; ?>"<?php echo in_array($s->supplier_id, $supplier_ids) ? ' selected' : ''; ?>><?php echo htmlspecialchars($s->supplier_name); ?></option><?php } ?>
          </select></div>

        <div class="pd-row"><label>Status <span class="req">*</span></label>
          <div class="pd-switch">
            <input type="checkbox" id="product_status" <?php echo $row->product_status == 'Aktif' ? 'checked' : ''; ?>>
            <label class="track" for="product_status"></label>
            <div><b id="status_label"></b><small>Nonaktifkan jika produk tidak dijual</small></div>
          </div></div>
        <div class="pd-row"><label>Paket</label>
          <div class="pd-switch">
            <input type="checkbox" id="is_package" <?php echo $row->is_package == 'Y' ? 'checked' : ''; ?>>
            <label class="track" for="is_package"></label>
            <div><b id="package_label"></b><small>Centang jika produk merupakan paket</small></div>
          </div></div>
        <div class="pd-row"><label>PPN</label>
          <div class="pd-switch">
            <input type="checkbox" id="is_ppn" <?php echo $row->is_ppn == 'PPN' ? 'checked' : ''; ?>>
            <label class="track" for="is_ppn"></label>
            <div><b id="ppn_label"></b><small>Centang jika menggunakan PPN</small></div>
          </div></div>

        <div class="pd-row"><label>Min Stock</label>
          <div><input type="number" min="0" class="form-control" id="product_min_stock" value="<?php echo (int) $row->product_min_stock; ?>"><small class="help">Peringatan stok minimum</small></div></div>
        <div class="pd-row"><label>Harga Beli</label>
          <div><div class="pd-addon"><input type="text" class="form-control" id="product_price"><span><?php echo htmlspecialchars($row->unit_name); ?></span></div><small class="help">Dasar perhitungan margin</small></div></div>
        <div class="pd-row"><label>Harga Pokok (HPP)</label>
          <div><div class="pd-addon"><input type="text" class="form-control" id="product_hpp"><span><?php echo htmlspecialchars($row->unit_name); ?></span></div><small class="help">Modal produk untuk hitung laba</small></div></div>
        <div class="pd-row"><label>HPP Discount</label>
          <div><div class="pd-addon"><input type="number" step="any" min="0" class="form-control" id="product_hpp_discount" placeholder="Kosong = pakai HPP" value="<?php echo $row->product_hpp_discount !== null ? htmlspecialchars($row->product_hpp_discount) : ''; ?>"><span><?php echo htmlspecialchars($row->unit_name); ?></span></div><small class="help">Jika diisi, dipakai sebagai modal menggantikan HPP</small></div></div>
        <div class="pd-row"><label>Harga Jual Umum</label>
          <div><div class="pd-addon"><input type="text" class="form-control" id="sell_general"><span><?php echo htmlspecialchars($row->unit_name); ?></span></div><small class="help">Sama dengan harga jual Umum di tabel harga</small></div></div>
        <div class="pd-row" style="align-items:start;"><label>Deskripsi</label>
          <textarea class="form-control" id="product_desc" rows="3"><?php echo htmlspecialchars($row->product_desc); ?></textarea></div>
      </div>
    </div>

    <!-- ===== Kolom kanan ===== -->
    <div class="pd-col">
      <div class="pd-card">
        <div class="pd-card-head">
          <div class="pd-card-icon"><i class="fas fa-percent"></i></div><h4>Harga &amp; Diskon per Periode</h4>
          <div class="pd-period right">Periode Diskon
            <span class="range"><i class="far fa-calendar-alt"></i>
              <input type="date" id="disc_start" value="<?php echo htmlspecialchars($row->product_disc_start_date); ?>">
              <span>-</span>
              <input type="date" id="disc_end" value="<?php echo htmlspecialchars($row->product_disc_end_date); ?>">
            </span>
          </div>
        </div>
        <div style="overflow-x:auto;">
        <table class="pd-table">
          <thead><tr><th>Tipe Harga</th><th>Margin</th><th>Harga Jual</th><th>Diskon (%)</th><th>Diskon (Rp)</th><th>Harga Setelah Diskon</th></tr></thead>
          <tbody>
          <?php foreach($price_types as $n => $pt){ ?>
            <tr data-n="<?php echo $n; ?>">
              <td class="tp"><i class="<?php echo $pt[1]; ?>"></i> <?php echo $pt[0]; ?></td>
              <td><div class="pd-pct"><input type="text" class="w-pct margin" id="margin_<?php echo $n; ?>" value="<?php echo (int) $row->{'product_sell_percentage_'.$n}; ?>"><span>%</span></div></td>
              <td><input type="text" class="w-price price" id="price_<?php echo $n; ?>"></td>
              <td><div class="pd-pct"><input type="text" class="w-disc disc-pct" value="<?php echo (int) $row->product_disc_percentage; ?>"><span>%</span></div></td>
              <td><input type="text" class="w-rp dsc" id="discrp_<?php echo $n; ?>" readonly></td>
              <td class="after" id="after_<?php echo $n; ?>">0</td>
            </tr>
          <?php } ?>
          </tbody>
        </table>
        </div>
        <small class="help" style="color:#9ca3af;font-size:.72rem;">Diskon (%) berlaku sama untuk semua tipe harga selama periode diskon.</small>
      </div>

      <div class="pd-card">
        <div class="pd-card-head"><div class="pd-card-icon"><i class="fas fa-cubes"></i></div><h4>Informasi Stok</h4></div>
        <table class="pd-stock">
          <thead><tr><th>Lokasi Stok</th><th>Qty (<?php echo htmlspecialchars($row->unit_name); ?>)</th></tr></thead>
          <tbody>
            <?php foreach($data['product_stock'] as $st){ ?>
              <tr><td><?php echo htmlspecialchars($st->warehouse_name); ?></td><td><?php echo number_format($st->stock, 0, ',', '.'); ?></td></tr>
            <?php } ?>
            <?php if(empty($data['product_stock'])){ ?><tr><td colspan="2" class="text-center text-muted">Belum ada data stok</td></tr><?php } ?>
          </tbody>
          <tfoot><tr><td>Total Stok</td><td><?php echo number_format($total_stock, 0, ',', '.'); ?> <?php echo htmlspecialchars($row->unit_name); ?></td></tr></tfoot>
        </table>
      </div>

      <div class="pd-card">
        <div class="pd-card-head"><div class="pd-card-icon"><i class="fas fa-boxes"></i></div><h4>Satuan Besar</h4>
          <span class="hint">Stok disimpan dalam <?php echo htmlspecialchars($row->unit_name); ?>. Saat dijual dalam satuan besar, stok berkurang sesuai isinya.</span></div>
        <table class="pd-pack">
          <thead><tr><th>Satuan Besar</th><th>Isi (<?php echo htmlspecialchars($row->unit_name); ?>)</th><th style="width:60px;"></th></tr></thead>
          <tbody id="package_body"></tbody>
        </table>
        <div class="pd-pack-add">
          <input type="text" id="package_name" class="form-control" placeholder="Nama satuan besar, mis. Ball" maxlength="50">
          <input type="number" id="package_qty" class="form-control" placeholder="Isi dalam <?php echo htmlspecialchars($row->unit_name); ?>, mis. 10" min="2">
          <button type="button" class="pd-btn" id="btn_add_package"><i class="fas fa-plus"></i> Tambah</button>
        </div>
      </div>
    </div>
  </div>
  </form>
<?php } ?>
</div>
</div>

<?php 
require DOC_ROOT_PATH . $this->config->item('footer');
?>

<?php if($row != null){ ?>
<script>
(function(){
  const productId       = <?php echo (int) $row->product_id; ?>;
  const originalStatus  = <?php echo json_encode($row->product_status); ?>;
  const defaultImg      = <?php echo json_encode($img_url.'default.png'); ?>;
  const initial = {
    price: <?php echo (int) $row->product_price; ?>,
    hpp: <?php echo (int) $row->product_hpp; ?>,
    prices: [0, <?php echo implode(',', array_map(function($n) use ($row){ return (int) $row->{'product_sell_price_'.$n}; }, array(1,2,3,4,5))); ?>]
  };
  let statusTouched = false;
  let resetImage    = 0;

  const moneyOpt = { currencySymbol: '', decimalCharacter: ',', decimalPlaces: 0, decimalPlacesShownOnFocus: 0, digitGroupSeparator: '.', minimumValue: '0', modifyValueOnWheel: false };
  const M = {
    price: new AutoNumeric('#product_price', moneyOpt),
    hpp: new AutoNumeric('#product_hpp', moneyOpt),
    general: new AutoNumeric('#sell_general', moneyOpt),
    prices: [null]
  };
  for(let n = 1; n <= 5; n++){ M.prices[n] = new AutoNumeric('#price_'+n, moneyOpt); }
  const D = {};
  for(let n = 1; n <= 5; n++){ D[n] = new AutoNumeric('#discrp_'+n, moneyOpt); }

  M.price.set(initial.price);
  M.hpp.set(initial.hpp);
  for(let n = 1; n <= 5; n++){ M.prices[n].set(initial.prices[n]); }
  M.general.set(initial.prices[1]);

  function rupiah(n){ return (parseInt(n) || 0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.'); }
  function num(el){ return Math.round(el.getNumber() || 0); }
  function pct(sel){ return parseFloat($(sel).val()) || 0; }

  function recalc_row(n)
  {
    let price = num(M.prices[n]);
    let p = parseFloat($('.disc-pct').first().val()) || 0;
    let disc = Math.round(price * p / 100);
    D[n].set(disc);
    $('#after_'+n).text(rupiah(price - disc));
  }
  function recalc_all(){ for(let n = 1; n <= 5; n++){ recalc_row(n); } }

  // margin <-> harga jual, dasar = harga beli (sama seperti sebelumnya)
  for(let n = 1; n <= 5; n++){
    $('#margin_'+n).on('input', function(){
      let beli = num(M.price);
      M.prices[n].set(Math.round(beli + beli * pct('#margin_'+n) / 100));
      if(n == 1) M.general.set(num(M.prices[1]));
      recalc_row(n);
    });
    $('#price_'+n).on('input', function(){
      let beli = num(M.price);
      $('#margin_'+n).val(beli > 0 ? Math.round(num(M.prices[n]) / beli * 100 - 100) : 0);
      if(n == 1) M.general.set(num(M.prices[1]));
      recalc_row(n);
    });
  }
  $('#sell_general').on('input', function(){
    M.prices[1].set(num(M.general));
    $('#price_1').trigger('input');
  });
  $('#product_price').on('input', function(){
    let beli = num(M.price);
    if(beli <= 0) return;
    for(let n = 1; n <= 5; n++){ M.prices[n].set(Math.round(beli + beli * pct('#margin_'+n) / 100)); }
    M.general.set(num(M.prices[1]));
    recalc_all();
  });
  $('.disc-pct').on('input', function(){
    $('.disc-pct').not(this).val($(this).val());
    recalc_all();
  });
  recalc_all();

  /* ===== Hero ===== */
  function text_of(sel){ return $.trim($(sel+' option:selected').toArray().map(function(o){ return o.text; }).join(', ')); }

  function status_value()
  {
    if(!statusTouched) return originalStatus;
    return $('#product_status').is(':checked') ? 'Aktif' : 'Tidak Aktif';
  }

  function refresh_hero()
  {
    $('#hero_code').text($('#product_code').val());
    $('#hero_name').text($('#product_name').val());
    $('#hero_supplier').text(text_of('#product_supplier') || '-');
    $('#hero_category').text(text_of('#product_category'));
    $('#hero_brand').text(text_of('#product_brand'));
    $('#hero_desc').text($.trim($('#product_desc').val()) || '-');
    let st = status_value();
    $('#hero_status').attr('class', 'pd-chip ' + (st == 'Aktif' ? 'ok' : (st == 'Discontinue' ? 'warn' : 'off')))
      .html('<i class="fas fa-' + (st == 'Aktif' ? 'check-circle' : 'ban') + '"></i> ' + st);
    $('#status_label').text(st);
    $('#package_label').text($('#is_package').is(':checked') ? 'Paket' : 'Bukan Paket');
    $('#ppn_label').text($('#is_ppn').is(':checked') ? 'PPN' : 'Non Aktif');
  }
  $('#product_status').on('change', function(){ statusTouched = true; refresh_hero(); });
  $('#pd_form').on('input change', 'input, select, textarea', refresh_hero);
  $('#product_supplier').on('change select2:select select2:unselect', refresh_hero);
  refresh_hero();

  /* ===== Gambar ===== */
  $('#pd_img_pick').click(function(){ $('#pd_file').click(); });
  $('#pd_file').on('change', function(){
    let f = this.files[0];
    if(!f) return;
    if(f.size > 2 * 1024 * 1024){
      Swal.fire({ icon: 'error', title: 'Oops...', text: 'Ukuran gambar maksimal 2MB' });
      this.value = '';
      return;
    }
    resetImage = 0;
    $('#pd_img').attr('src', URL.createObjectURL(f));
    $('#pd_img_rm').addClass('can');
  });
  $('#pd_img_rm').click(function(){
    $('#pd_file').val('');
    resetImage = 1;
    $('#pd_img').attr('src', defaultImg);
    $(this).removeClass('can');
  });

  /* ===== Simpan ===== */
  $('#btn_save').click(function(){
    let fd = new FormData();
    fd.append('product_id', productId);
    fd.append('product_code', $.trim($('#product_code').val()));
    fd.append('product_name', $.trim($('#product_name').val()));
    fd.append('product_category', $('#product_category').val() || '');
    fd.append('product_brand', $('#product_brand').val() || '');
    ($('#product_supplier').val() || []).forEach(function(v){ fd.append('product_supplier[]', v); });
    fd.append('product_status', status_value());
    fd.append('is_package', $('#is_package').is(':checked') ? 'Y' : 'N');
    fd.append('is_ppn', $('#is_ppn').is(':checked') ? 'PPN' : 'NON PPN');
    fd.append('product_min_stock', $('#product_min_stock').val() || 0);
    fd.append('product_desc', $('#product_desc').val());
    fd.append('product_price', num(M.price));
    fd.append('product_hpp', num(M.hpp));
    fd.append('product_hpp_discount', $('#product_hpp_discount').val());
    fd.append('product_disc_percentage', parseInt($('.disc-pct').first().val()) || 0);
    fd.append('product_disc_start_date', $('#disc_start').val());
    fd.append('product_disc_end_date', $('#disc_end').val());
    for(let n = 1; n <= 5; n++){
      fd.append('product_sell_percentage_'+n, parseInt($('#margin_'+n).val()) || 0);
      fd.append('product_sell_price_'+n, num(M.prices[n]));
    }
    let file = $('#pd_file')[0].files[0];
    if(file){ fd.append('screenshoot', file); }
    fd.append('reset_image', resetImage);

    let btn = $(this).prop('disabled', true);
    $.ajax({
      type: 'POST',
      url: '<?php echo base_url(); ?>Masterdata/save_product_detail',
      data: fd, processData: false, contentType: false, dataType: 'json',
      success: function(res){
        if(res.code == 200){
          Swal.fire({ icon: 'success', title: 'Tersimpan', timer: 1200, showConfirmButton: false }).then(function(){ location.reload(); });
        }else{
          Swal.fire({ icon: 'error', title: 'Oops...', text: res.result });
          btn.prop('disabled', false);
        }
      },
      error: function(){
        Swal.fire({ icon: 'error', title: 'Oops...', text: 'Terjadi kesalahan koneksi' });
        btn.prop('disabled', false);
      }
    });
  });

  /* ===== Hapus ===== */
  $('#btn_delete').click(function(){
    Swal.fire({ title: 'Hapus produk?', text: 'Produk tidak akan tampil lagi di daftar.', icon: 'warning', showCancelButton: true, confirmButtonColor: '#d33', confirmButtonText: 'Hapus' }).then(function(r){
      if(!r.isConfirmed) return;
      $.post('<?php echo base_url(); ?>Masterdata/delete_product', { id: productId }, function(res){
        if(res.code == 200){
          window.location.href = '<?php echo base_url(); ?>Masterdata/product';
        }else{
          Swal.fire({ icon: 'error', title: 'Oops...', text: res.result || res.msg });
        }
      }, 'json');
    });
  });

  /* ===== Satuan Besar ===== */
  function load_packages()
  {
    $.post('<?php echo base_url(); ?>Masterdata/package_list', { product_id: productId }, function(res){
      let html = '';
      if(res.code == 200 && res.data.length > 0){
        res.data.forEach(function(p){
          html += '<tr><td>'+$('<div>').text(p.package_name).html()+'</td><td>'+p.package_qty+'</td>'+
            '<td><button type="button" class="pd-pack-del" data-id="'+p.package_id+'"><i class="fas fa-trash-alt"></i></button></td></tr>';
        });
      }else{
        html = '<tr><td colspan="3" class="empty">Belum ada satuan besar</td></tr>';
      }
      $('#package_body').html(html);
    }, 'json');
  }

  $('#btn_add_package').click(function(){
    $.post('<?php echo base_url(); ?>Masterdata/add_package', { product_id: productId, package_name: $('#package_name').val(), package_qty: $('#package_qty').val() }, function(res){
      if(res.code == 200){
        $('#package_name').val('');
        $('#package_qty').val('');
        load_packages();
      }else{
        Swal.fire({ icon: 'error', title: 'Oops...', text: res.result });
      }
    }, 'json');
  });

  $('#package_body').on('click', '.pd-pack-del', function(){
    let package_id = $(this).data('id');
    Swal.fire({ title: 'Hapus satuan besar?', text: 'Penjualan lama tidak terpengaruh.', icon: 'warning', showCancelButton: true, confirmButtonText: 'Ya, Hapus' }).then(function(r){
      if(!r.isConfirmed) return;
      $.post('<?php echo base_url(); ?>Masterdata/delete_package', { product_id: productId, package_id: package_id }, function(){ load_packages(); }, 'json');
    });
  });

  load_packages();

  $('#product_supplier').select2({ width: '100%' });
  $('#product_category, #product_brand').select2({ width: '100%' });
})();
</script>
<?php } ?>
