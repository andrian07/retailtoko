<?php
$this->load->view('Pages/Layout/detail_layout');
$h = $data['header_debt_payment'][0];

dt_head('Detail Pembayaran Hutang', 'Informasi lengkap pelunasan hutang ke supplier.', 'fas fa-wallet', array(
  array('Cetak', 'fas fa-print', 'print', true),
));

dt_cards(array(
  dt_company_card(),
  array('icon' => 'fas fa-truck', 'html' =>
    '<div class="lbl">Supplier</div><div class="val">'.dt_e($h->supplier_name).'</div>'),
  array('icon' => 'far fa-credit-card', 'html' =>
    '<div class="lbl">Metode Pembayaran</div><div class="val">'.dt_e($h->payment_name).'</div>'.
    '<div class="lbl mt-1">Tanggal</div><div class="val">'.dt_date($h->payment_debt_date).'</div>'),
  array('icon' => 'fas fa-file-alt', 'highlight' => true, 'html' =>
    '<div class="lbl">No. Transaksi</div><div class="val">'.dt_e($h->payment_debt_invoice).'</div>'.
    '<div class="dt-meta"><div><span class="lbl">Status</span>'.dt_status($h->status).'</div></div>'),
));

$rows = array();
foreach ($data['detail_debt_payment'] as $r) {
  $rows[] = array(dt_e($r->hd_purchase_invoice), dt_date($r->hd_purchase_date), dt_rp($r->dt_payment_debt_discount), dt_rp($r->dt_payment_debt_retur), dt_rp($r->dt_payment_debt_nominal));
}
dt_table(array(array('No Invoice Pembelian'), array('Tgl'), array('Discount'), array('Potongan Retur'), array('Nominal Bayar')), $rows);

dt_bottom(
  false,
  array(array('Dibuat', $h->user_name, dt_date($h->trx_created_at, 'd-M-Y H:i'))),
  array(
    array('Total Pembayaran', dt_rp($h->payment_debt_total_pay), 'fas fa-coins'),
    array('Total Diskon', dt_rp($h->payment_debt_total_discount), 'fas fa-tag" style="color:#f59e0b'),
    array('Total Retur', dt_rp($h->payment_debt_total_retur), 'fas fa-undo'),
    array('Total Nota', dt_rp($h->payment_debt_total_nota), 'fas fa-money-bill-wave', 'grand'),
  )
);

dt_foot();
