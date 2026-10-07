<?php
$this->load->view('Pages/Layout/detail_layout');
$h = $data['header_transfer'][0];

dt_head('Detail Transfer Stok', 'Informasi lengkap perpindahan stok antar gudang.', 'fas fa-exchange-alt', array(
  array('Cetak Surat Jalan', 'fas fa-truck', base_url().'Transferstock/printdispatch?transfer_id='.$h->hd_transfer_stock_id, true),
));

dt_cards(array(
  dt_company_card(),
  array('icon' => 'far fa-calendar-alt', 'html' =>
    '<div class="lbl">Tanggal Transfer</div><div class="val">'.dt_date($h->hd_transfer_stock_date).'</div>'),
  array('icon' => 'fas fa-file-alt', 'highlight' => true, 'html' =>
    '<div class="lbl">No. Transfer</div><div class="val">'.dt_e($h->hd_transfer_stock_code).'</div>'.
    '<div class="dt-meta"><div><span class="lbl">Status</span>'.dt_status($h->hd_transfer_stock_status).'</div></div>'),
));

$rows = array();
foreach ($data['detail_transfer'] as $r) {
  $rows[] = array(dt_e($r['product_code']), dt_e($r['product_name']), dt_e($r['unit_name']), dt_num($r['dt_transfer_stock_qty']), dt_e($r['from']), dt_e($r['to']), dt_num($r['dt_transfer_stock_from_qty']), dt_num($r['dt_transfer_stock_to_qty']), dt_e($r['dt_transfer_stock_note']));
}
dt_table(array(array('SKU'), array('Item'), array('Satuan'), array('Qty'), array('Dari'), array('Tujuan'), array('Stok Akhir Dari'), array('Stok Akhir Ke'), array('Catatan')), $rows);

dt_bottom(
  $h->hd_transfer_stock_desc,
  array(array('Dibuat', $h->user_name, dt_date($h->trx_created_at, 'd-M-Y H:i'))),
  array(
    array('Total Item', dt_num($h->hd_transfer_stock_qty), 'fas fa-boxes', 'grand'),
  ),
  'Ringkasan Transfer'
);

dt_foot();
