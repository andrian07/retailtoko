<?php
$this->load->view('Pages/Layout/detail_layout');
$h = $data['header_receivable_payment'][0];

dt_head('Detail Pembayaran Piutang', 'Informasi lengkap penerimaan pelunasan piutang.', 'fas fa-hand-holding-usd', array(
  array('Cetak', 'fas fa-print', 'print', true),
));

dt_cards(array(
  dt_company_card(),
  array('icon' => 'fas fa-user', 'html' =>
    '<div class="lbl">Pelanggan</div><div class="val">'.dt_e($h->customer_name).'</div>'),
  array('icon' => 'far fa-credit-card', 'html' =>
    '<div class="lbl">Metode Pembayaran</div><div class="val">'.dt_e($h->payment_name).'</div>'.
    '<div class="lbl mt-1">Tanggal</div><div class="val">'.dt_date($h->payment_receivable_date).'</div>'),
  array('icon' => 'fas fa-file-alt', 'highlight' => true, 'html' =>
    '<div class="lbl">No. Transaksi</div><div class="val">'.dt_e($h->payment_receivable_invoice).'</div>'.
    '<div class="dt-meta"><div><span class="lbl">Status</span>'.dt_status($h->status).'</div></div>'),
));

$rows = array();
foreach ($data['detail_receivable_payment'] as $r) {
  $rows[] = array(dt_e($r->hd_sales_inv), dt_date($r->hd_sales_date), dt_rp($r->dt_payment_receivable_discount), dt_rp($r->dt_payment_receivable_retur), dt_rp($r->dt_payment_receivable_nominal));
}
dt_table(array(array('No Invoice Penjualan'), array('Tgl'), array('Discount'), array('Potongan Retur'), array('Nominal Bayar')), $rows);

dt_bottom(
  false,
  array(array('Dibuat', $h->user_name, dt_date($h->trx_created_at, 'd-M-Y H:i'))),
  array(
    array('Total Pembayaran', dt_rp($h->payment_receivable_total_pay), 'fas fa-coins'),
    array('Total Diskon', dt_rp($h->payment_receivable_total_discount), 'fas fa-tag" style="color:#f59e0b'),
    array('Total Retur', dt_rp($h->payment_receivable_total_retur), 'fas fa-undo'),
    array('Total Nota', dt_rp($h->payment_receivable_total_nota), 'fas fa-money-bill-wave', 'grand'),
  )
);

dt_foot();
