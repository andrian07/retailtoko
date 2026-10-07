<?php
$this->load->view('Pages/Layout/detail_layout');
$h = $data['get_header_opname'][0];

dt_head('Detail Opname', 'Informasi lengkap penyesuaian stok hasil opname.', 'fas fa-clipboard-check', array(
  array('Cetak', 'fas fa-print', 'print', true),
));

dt_cards(array(
  dt_company_card(),
  array('icon' => 'far fa-calendar-alt', 'html' =>
    '<div class="lbl">Tanggal Opname</div><div class="val">'.dt_date($h['opname_date']).'</div>'),
  array('icon' => 'fas fa-file-alt', 'highlight' => true, 'html' =>
    '<div class="lbl">No. Opname</div><div class="val">'.dt_e($h['opname_code']).'</div>'.
    '<div class="dt-meta"><div><span class="lbl">Status</span>'.dt_status($h['opname_status']).'</div></div>'),
));

$rows = array();
foreach ($data['get_detail_opname'] as $r) {
  $rows[] = array(dt_e($r['product_code']), dt_e($r['product_name']), dt_num($r['dt_opname_stock_awal']), dt_num($r['dt_opname_stock_akhir']), dt_num($r['dt_opname_stock_difference']), dt_rp($r['dt_opname_stock_difference_hpp']), dt_e($r['dt_opname_note']));
}
dt_table(array(array('Kode Produk'), array('Nama Produk'), array('Stok Sebelum'), array('Stok Sesudah'), array('Selisih'), array('Selisih Rupiah'), array('Catatan')), $rows);

dt_bottom(
  false,
  array(array('Dibuat', $h['user_name'], dt_date($h['trx_created_at'], 'd-M-Y H:i'))),
  array(
    array('Total Selisih', dt_rp($h['opname_total']), 'fas fa-money-bill-wave', 'grand'),
  ),
  'Ringkasan Opname'
);

dt_foot();
