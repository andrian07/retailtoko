<?php
$this->load->view('Pages/Layout/detail_layout');
$h = $data['header_po'][0];

dt_head('Detail PO', 'Informasi lengkap purchase order.', 'fas fa-file-alt', array(
  array('Cetak PO', 'fas fa-print', base_url().'Purchase/printpo?id='.$h['hd_po_id'], true),
));

dt_cards(array(
  dt_company_card(),
  array('icon' => 'fas fa-truck', 'html' =>
    '<div class="lbl">Supplier</div><div class="val">'.dt_e($h['supplier_name']).'</div>'.
    '<div class="dt-meta"><div><span class="lbl">Golongan</span>'.($h['hd_po_tax'] == 'Y' ? '<span class="dt-badge">BKP</span>' : '<span class="dt-badge danger">NON BKP</span>').'</div>'.
    '<div><span class="lbl">Metode Bayar</span><span class="val">'.dt_e($h['payment_name']).'</span></div></div>'),
  array('icon' => 'far fa-calendar-alt', 'html' =>
    '<div class="lbl">Tanggal</div><div class="val">'.dt_date($h['hd_po_date']).'</div>'.
    '<div class="lbl mt-1">Jatuh Tempo</div><div class="val">'.dt_date($h['hd_po_due_date']).'</div>'),
  array('icon' => 'fas fa-file-alt', 'highlight' => true, 'html' =>
    '<div class="lbl">No. PO</div><div class="val">'.dt_e($h['hd_po_invoice']).'</div>'.
    '<div class="dt-meta"><div><span class="lbl">Status</span>'.dt_status($h['hd_po_status']).'</div>'.
    '<div><span class="lbl">Gudang</span><span class="val"><i class="fas fa-warehouse" style="color:#0f8a5f;"></i> '.dt_e($h['warehouse_name']).'</span></div></div>'),
));

$rows = array();
foreach ($data['detail_po'] as $r) {
  $rows[] = array(dt_e($r['product_code']), dt_e($r['product_name']), dt_e($r['unit_name']), dt_rp($r['dt_po_price']), dt_num($r['dt_po_qty']), dt_rp($r['dt_po_total']));
}
dt_table(array(array('SKU'), array('Produk'), array('Satuan'), array('Harga Beli'), array('Qty'), array('Total')), $rows);

dt_bottom(
  $h['hd_po_note'],
  array(array('Dibuat', $h['user_name'], dt_date($h['tanggal_po'], 'd-M-Y H:i'))),
  array(
    array('Sub Total', dt_rp($h['hd_po_sub_total']), 'fas fa-coins'),
    array('Diskon 1 <small>('.dt_e($h['hd_po_disc_percentage1']).'%)</small>', dt_rp($h['hd_po_disc_1']), 'fas fa-tag" style="color:#f59e0b'),
    array('Diskon 2 <small>('.dt_e($h['hd_po_disc_percentage2']).'%)</small>', dt_rp($h['hd_po_disc_2']), 'fas fa-tag" style="color:#f59e0b'),
    array('Diskon 3 <small>('.dt_e($h['hd_po_disc_percentage3']).'%)</small>', dt_rp($h['hd_po_disc_3']), 'fas fa-tag" style="color:#f59e0b'),
    array('DPP', dt_rp($h['hd_po_dpp']), 'fas fa-calculator'),
    array('PPN 11%', dt_rp($h['hd_po_ppn']), 'fas fa-percent" style="color:#0ea5e9'),
    array('Grand Total', dt_rp($h['hd_po_grand_total']), 'fas fa-money-bill-wave', 'grand'),
  )
);

dt_foot();
