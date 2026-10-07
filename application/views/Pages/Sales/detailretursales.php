<?php
$this->load->view('Pages/Layout/detail_layout');
$h = $data['header_retur_sales'][0];

dt_head('Detail Retur Penjualan', 'Informasi lengkap transaksi retur penjualan.', 'fas fa-undo-alt', array(
  array('Cetak', 'fas fa-print', 'print', true),
));

dt_cards(array(
  dt_company_card(),
  array('icon' => 'fas fa-user', 'html' =>
    '<div class="lbl">Customer</div><div class="val">'.dt_e($h->customer_name).'</div>'),
  array('icon' => 'far fa-calendar-alt', 'html' =>
    '<div class="lbl">Tanggal Retur</div><div class="val">'.dt_date($h->hd_retur_sales_date).'</div>'),
  array('icon' => 'fas fa-file-alt', 'highlight' => true, 'html' =>
    '<div class="lbl">No. Transaksi</div><div class="val">'.dt_e($h->hd_retur_sales_inv).'</div>'.
    '<div class="dt-meta"><div><span class="lbl">Status</span>'.dt_status($h->hd_retur_sales_status).'</div></div>'),
));

$rows = array();
foreach ($data['detail_retur_sales'] as $r) {
  $rows[] = array(dt_e($r->hd_sales_inv), dt_e($r->product_code), dt_e($r->product_name), dt_e($r->unit_name), dt_num($r->dt_retur_sales_qty), dt_rp($r->dt_retur_sales_total), dt_e($r->dt_retur_sales_note));
}
dt_table(array(array('Kode Penjualan'), array('SKU'), array('Produk'), array('Satuan'), array('Qty'), array('Total'), array('Catatan')), $rows);

dt_bottom(
  $h->hd_retur_sales_note,
  array(array('Dibuat', $h->user_name, dt_date($h->trx_created_at, 'd-M-Y H:i'))),
  array(
    array('Total Retur', dt_rp($h->hd_retur_sales_total), 'fas fa-money-bill-wave', 'grand'),
  ),
  'Ringkasan Retur'
);

dt_foot();
