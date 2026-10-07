<?php
$this->load->view('Pages/Layout/detail_layout');
$h = $data['header_sales'][0];

dt_head('Detail Sales', 'Informasi lengkap transaksi penjualan.', 'fas fa-file-invoice', array(
  array('Cetak', 'fas fa-print', base_url().'Sales/printnota?print_type=1&sales_id='.$h->hd_sales_id),
  array('Surat Jalan', 'fas fa-truck', base_url().'Sales/printnota?print_type=2&sales_id='.$h->hd_sales_id),
  array('Cetak Struk', 'fas fa-receipt', base_url().'Sales/printpos?sales_id='.$h->hd_sales_id, true),
));

dt_cards(array(
  dt_company_card(),
  array('icon' => 'fas fa-user', 'html' =>
    '<div class="lbl">Customer</div><div class="val">'.dt_e($h->customer_name).'</div><div>'.dt_e($h->customer_address).'</div><div>'.dt_e($h->customer_phone).'</div>'),
  array('icon' => 'far fa-credit-card', 'html' =>
    '<div class="lbl">Metode Pembayaran</div><div class="val">'.dt_e($h->payment_name).'</div>'),
  array('icon' => 'fas fa-file-alt', 'highlight' => true, 'html' =>
    '<div class="lbl">No. Transaksi</div><div class="val">'.dt_e($h->hd_sales_inv).'</div>'.
    '<div class="dt-meta"><div><span class="lbl">Status</span>'.dt_status($h->hd_sales_status).'</div>'.
    '<div><span class="lbl">Gudang</span><span class="val"><i class="fas fa-warehouse" style="color:#0f8a5f;"></i> '.dt_e($h->warehouse_name).'</span></div></div>'),
));

$rows = array();
foreach ($data['detail_sales'] as $r) {
  $rows[] = array(dt_e($r->product_code), dt_e($r->product_name), dt_num($r->dt_sales_qty), dt_rp($r->dt_sales_price), dt_rp($r->dt_sales_discount), dt_rp($r->dt_sales_total), dt_e($r->dt_sales_desc));
}
dt_table(array(array('SKU'), array('Produk'), array('Qty'), array('Harga Satuan'), array('Discount'), array('Total'), array('Catatan')), $rows);

dt_bottom(
  $h->hd_sales_note,
  array(array('Dibuat', $h->user_name, dt_date($h->trx_created_at, 'd-M-Y H:i'))),
  array(
    array('Sub Total', dt_rp($h->hd_sales_sub_total), 'fas fa-coins'),
    array('Diskon 1 <small>('.dt_e($h->hd_sales_percentage1).'%)</small>', dt_rp($h->hd_sales_disc1), 'fas fa-tag" style="color:#f59e0b'),
    array('Diskon 2 <small>('.dt_e($h->hd_sales_percentage2).'%)</small>', dt_rp($h->hd_sales_disc2), 'fas fa-tag" style="color:#f59e0b'),
    array('Diskon 3 <small>('.dt_e($h->hd_sales_percentage3).'%)</small>', dt_rp($h->hd_sales_disc3), 'fas fa-tag" style="color:#f59e0b'),
    array('PPN 11%', dt_rp($h->hd_sales_ppn), 'fas fa-percent" style="color:#0ea5e9'),
    array('Grand Total', dt_rp($h->hd_sales_total), 'fas fa-money-bill-wave', 'grand'),
    array('Down Payment (DP)', dt_rp($h->hd_sales_dp), 'fas fa-hand-holding-usd" style="color:#0f8a5f'),
    array('Sisa Piutang', dt_rp($h->hd_sales_total - $h->hd_sales_dp), 'fas fa-file-invoice-dollar" style="color:#0f8a5f', 'soft'),
  )
);

dt_foot();
