<?php
$this->load->view('Pages/Layout/detail_layout');
$h = $data['header_retur_purchase'][0];

dt_head('Detail Retur Pembelian', 'Informasi lengkap transaksi retur pembelian.', 'fas fa-undo', array(
  array('Cetak', 'fas fa-print', 'print', true),
));

dt_cards(array(
  dt_company_card(),
  array('icon' => 'fas fa-truck', 'html' =>
    '<div class="lbl">Supplier</div><div class="val">'.dt_e($h->supplier_name).'</div>'),
  array('icon' => 'far fa-calendar-alt', 'html' =>
    '<div class="lbl">Tanggal Retur</div><div class="val">'.dt_date($h->hd_retur_purchase_date).'</div>'),
  array('icon' => 'fas fa-file-alt', 'highlight' => true, 'html' =>
    '<div class="lbl">No. Transaksi</div><div class="val">'.dt_e($h->hd_retur_purchase_inv).'</div>'.
    '<div class="dt-meta"><div><span class="lbl">Status</span>'.dt_status($h->hd_retur_purchase_status).'</div></div>'),
));

$rows = array();
foreach ($data['detail_retur_purchase'] as $r) {
  $rows[] = array(dt_e($r->hd_purchase_invoice), dt_e($r->product_code), dt_e($r->product_name), dt_e($r->unit_name), dt_num($r->dt_retur_purchase_qty), dt_rp($r->dt_retur_purchase_total), dt_e($r->dt_retur_purchase_note));
}
dt_table(array(array('Kode Pembelian'), array('SKU'), array('Produk'), array('Satuan'), array('Qty'), array('Total'), array('Catatan')), $rows);

dt_bottom(
  $h->hd_retur_purchase_note,
  array(array('Dibuat', $h->user_name, dt_date($h->trx_created_at, 'd-M-Y H:i'))),
  array(
    array('Total Retur', dt_rp($h->hd_retur_purchase_total), 'fas fa-money-bill-wave', 'grand'),
  ),
  'Ringkasan Retur'
);

dt_foot();
