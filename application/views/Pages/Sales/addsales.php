<?php 
define('DOC_ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].'/');
require DOC_ROOT_PATH . $this->config->item('header');
?>
</div>

<style>
	/* ===== Page Layout ===== */
	.sales-page-wrapper { background: #f0f4f8; min-height: 100vh; padding-bottom: 40px; }
	.page-title-bar { margin-top: 84px; background: linear-gradient(135deg, #1e3a5f 0%, #2d6a9f 100%); color: #fff; padding: 18px 28px; border-radius: 12px; margin-bottom: 22px; display: flex; align-items: center; gap: 14px; box-shadow: 0 4px 15px rgba(30,58,95,0.25); }
	.page-title-bar i { font-size: 1.8rem; opacity: .9; }
	.page-title-bar h4 { margin: 0; font-weight: 700; font-size: 1.25rem; letter-spacing: .3px; }
	.page-title-bar small { opacity: .75; font-size: .8rem; }

	/* ===== Cards ===== */
	.sales-card { border: none; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,.08); margin-bottom: 20px; overflow: visible; }
	.sales-card .card-header { border-radius: 12px 12px 0 0 !important; padding: 12px 20px; display: flex; align-items: center; gap: 10px; font-weight: 600; font-size: .95rem; border-bottom: none; }
	.sales-card .card-header i { font-size: 1rem; }
	.sales-card .card-body { padding: 20px 24px; }
	.header-blue  { background: linear-gradient(135deg, #1e3a5f, #2d6a9f); color: #fff; }
	.header-teal  { background: linear-gradient(135deg, #0f766e, #0d9488); color: #fff; }
	.header-amber { background: linear-gradient(135deg, #b45309, #d97706); color: #fff; }

	/* ===== Priority Badges ===== */
	.priority-badge { display: inline-flex; align-items: center; justify-content: center; width: 20px; height: 20px; border-radius: 50%; background: #1e3a5f; color: #fff; font-size: .7rem; font-weight: 700; margin-right: 5px; flex-shrink: 0; vertical-align: middle; }
	.section-pill { border-radius: 8px; padding: 4px 12px; font-size: .75rem; font-weight: 700; letter-spacing: .5px; text-transform: uppercase; display: inline-flex; align-items: center; gap: 5px; margin-bottom: 14px; }
	.pill-required { background: #dbeafe; color: #1d4ed8; }
	.pill-auto    { background: #dcfce7; color: #15803d; }
	.info-divider { border-right: 2px dashed #e5e7eb; }
	.auto-input-wrap .form-control-custom[readonly] { background: #f0fdf4; color: #374151; border-color: #bbf7d0; }
	.field-required-star::after { content: " *"; color: #dc2626; }

	/* ===== Form Styling ===== */
	.form-label-custom { font-size: .82rem; font-weight: 600; color: #374151; margin-bottom: 4px; display: block; text-transform: uppercase; letter-spacing: .4px; }
	.form-control-custom { border: 1.5px solid #e5e7eb; border-radius: 8px; padding: 8px 12px; font-size: .9rem; transition: border-color .2s, box-shadow .2s; background: #fff; }
	.form-control-custom:focus { border-color: #2d6a9f; box-shadow: 0 0 0 3px rgba(45,106,159,.12); outline: none; }
	.form-control-custom[readonly] { background: #f8fafc; color: #6b7280; }
	.select2-container .select2-selection--single { height: 40px !important; border: 1.5px solid #e5e7eb !important; border-radius: 8px !important; }
	.select2-container--default .select2-selection--single .select2-selection__rendered { line-height: 38px !important; font-size: .9rem; }
	.select2-container--default .select2-selection--single .select2-selection__arrow { height: 38px !important; }
	.input-group-text-custom { background: #f1f5f9; border: 1.5px solid #e5e7eb; border-right: none; border-radius: 8px 0 0 8px; padding: 8px 12px; color: #6b7280; font-size: .85rem; }

	/* ===== Product Input Panel ===== */
	.product-input-panel { background: linear-gradient(135deg, #f8fafc, #eef2ff); border: 1.5px dashed #93c5fd; border-radius: 10px; padding: 16px 20px; margin-bottom: 16px; }

	/* ===== Table ===== */
	#temp-sales-list thead th { background: #1e3a5f; color: #fff; font-size: .82rem; font-weight: 600; text-transform: uppercase; letter-spacing: .4px; border: none; padding: 10px 12px; }
	#temp-sales-list tbody tr:hover { background: #eff6ff; }
	#temp-sales-list tbody td { vertical-align: middle; font-size: .88rem; padding: 9px 12px; border-color: #e5e7eb; }

	/* ===== Summary Card ===== */
	.summary-card { background: #fff; border-radius: 12px; border: none; box-shadow: 0 2px 12px rgba(0,0,0,.08); }
	.summary-row { display: flex; justify-content: space-between; align-items: center; padding: 9px 0; border-bottom: 1px solid #f3f4f6; }
	.summary-row:last-child { border-bottom: none; }
	.summary-label { color: #6b7280; font-size: .88rem; font-weight: 500; }
	.summary-value input { border: 1.5px solid #e5e7eb; border-radius: 8px; padding: 6px 10px; font-size: .88rem; text-align: right; background: #f8fafc; width: 160px; }
	.summary-value input:focus { border-color: #2d6a9f; outline: none; box-shadow: 0 0 0 3px rgba(45,106,159,.12); }
	.summary-grand { background: linear-gradient(135deg, #1e3a5f, #2d6a9f); border-radius: 10px; padding: 12px 16px; margin: 10px 0; }
	.summary-grand .summary-label { color: #bfdbfe; font-weight: 600; }
	.summary-grand input { background: transparent; border: 1.5px solid rgba(255,255,255,.35) !important; color: #fff; font-size: 1.05rem; font-weight: 700; }
	.ppn-row { align-items: center; gap: 8px; }
	.ppn-check { width: 20px; height: 20px; accent-color: #2d6a9f; cursor: pointer; }

	/* ===== Dropship card ===== */
	#dropship-container .card { border: 1.5px dashed #f97316; border-radius: 12px; }
	#dropship-container .card-header { background: linear-gradient(135deg, #c2410c, #ea580c); color: #fff; border-radius: 10px 10px 0 0; font-weight: 600; }

	/* ===== Buttons ===== */
	.btn-save-main { background: linear-gradient(135deg, #059669, #10b981); color: #fff; border: none; border-radius: 10px; padding: 10px 28px; font-weight: 600; font-size: .95rem; transition: all .2s; }
	.btn-save-main:hover { background: linear-gradient(135deg, #047857, #059669); color: #fff; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(5,150,105,.3); }
	.btn-cancel-main { background: #fff; color: #dc2626; border: 1.5px solid #dc2626; border-radius: 10px; padding: 10px 28px; font-weight: 600; font-size: .95rem; transition: all .2s; }
	.btn-cancel-main:hover { background: #dc2626; color: #fff; transform: translateY(-1px); }
	.btn-add-item { background: linear-gradient(135deg, #1e3a5f, #2d6a9f); color: #fff; border: none; border-radius: 8px; padding: 8px 18px; font-weight: 600; font-size: .88rem; white-space: nowrap; }
	.btn-add-item:hover { background: linear-gradient(135deg, #1e3a5f, #1d4ed8); color: #fff; }

	/* ===== Modal ===== */
	.modal-header-disc { background: linear-gradient(135deg, #1e3a5f, #2d6a9f); color: #fff; border-radius: 10px 10px 0 0; }
	.modal-header-disc .btn-close { filter: invert(1); }
	.disc-group-label { font-size: .78rem; font-weight: 600; color: #374151; text-transform: uppercase; letter-spacing: .4px; margin-bottom: 6px; }
	.disc-badge { background: #eff6ff; color: #1d4ed8; border-radius: 6px; padding: 3px 8px; font-size: .75rem; font-weight: 600; }

	/* Hidden inputs */
	#sales_id, #sales_order_id, #sales_rate_customer, #hd_sales_type, #product_id { display: none; }
</style>

<div class="sales-page-wrapper">
<div class="container-fluid px-4">

	<!-- Page Title -->
	<div class="page-title-bar">
		<i class="fas fa-shopping-cart"></i>
		<div>
			<h4>Tambah Penjualan</h4>
			<small>Buat transaksi penjualan baru</small>
		</div>
	</div>

	<!-- ===== ROW 1: Info Header ===== -->
	<div class="sales-card card">
		<div class="card-header header-blue">
			<i class="fas fa-file-invoice"></i> Informasi Transaksi
		</div>
		<div class="card-body pb-3">
			<div class="row g-0">

				<!-- ── LEFT: Wajib Diisi ─────────────────────────────── -->
				<div class="col-lg-7 pe-lg-4 info-divider">
					<span class="section-pill pill-required"><i class="fas fa-pencil-alt"></i> Wajib Diisi</span>
					<div class="row g-3">

						<!-- 1. Customer -->
						<div class="col-md-6">
							<label class="form-label-custom field-required-star">
								<span class="priority-badge">1</span> Customer
							</label>
							<select class="form-control form-control-custom js-example-basic-single" id="sales_customer" name="sales_customer">
								<option value="">-- Pilih Customer --</option>
								<?php foreach ($data['customer_list'] as $row) { ?>
									<option value="<?php echo $row->customer_id; ?>"><?php echo $row->customer_name; ?></option>
								<?php } ?>
							</select>
						</div>


						<!-- 2. Jatuh Tempo -->
						<div class="col-md-6">
							<label class="form-label-custom field-required-star">
								<span class="priority-badge">2</span> Jatuh Tempo
								<small class="text-muted fw-normal text-lowercase ms-1" style="font-size:.72rem;"></small>
							</label>
							<input id="sales_due_date" name="sales_due_date" type="date" class="form-control form-control-custom">
						</div>

						<!-- 3. Metode Bayar -->
						<div class="col-md-6">
							<label class="form-label-custom field-required-star">
								<span class="priority-badge">3</span> Metode Bayar
							</label>
							<select class="form-control form-control-custom js-example-basic-single" id="sales_payment" name="sales_payment">
								<option value="">-- Pilih Metode Bayar --</option>
								<?php foreach ($data['payment_list'] as $row) { ?>
									<option value="<?php echo $row->payment_id; ?>"><?php echo $row->payment_name; ?></option>
								<?php } ?>
							</select>
						</div>

						<!-- 4. Jenis Harga -->
						<div class="col-md-6">
							<label class="form-label-custom field-required-star">
								<span class="priority-badge">4</span> Jenis Harga
							</label>
							<select class="form-control form-control-custom js-example-basic-single" id="sales_price_type" name="sales_price_type">
								<option value="">-- Pilih Jenis Harga --</option>
								<option value="Umum">Umum</option>
								<option value="Toko">Toko</option>
								<option value="Sales">Sales</option>
								<option value="Khusus">Khusus</option>
							</select>
						</div>

					</div>
				</div>

				<!-- ── RIGHT: Otomatis ───────────────────────────────── -->
				<div class="col-lg-5 ps-lg-4 mt-4 mt-lg-0 auto-input-wrap">
					<span class="section-pill pill-auto"><i class="fas fa-magic"></i> Terisi Otomatis</span>

					<!-- hidden meta inputs -->
					<input id="sales_id" name="sales_id" type="hidden">
					<input id="sales_order_id" name="sales_order_id" type="hidden">
					<input id="sales_rate_customer" name="sales_rate_customer" type="hidden">
					<input id="hd_sales_type" name="hd_sales_type" type="hidden">

					<div class="row g-3">

						<!-- No Invoice -->
						<div class="col-12">
							<label class="form-label-custom">
								<i class="fas fa-lock fa-xs me-1 text-muted"></i> No Invoice
							</label>
							<div class="input-group">
								<span class="input-group-text" style="background:#f0fdf4;border:1.5px solid #bbf7d0;border-right:none;border-radius:8px 0 0 8px;color:#15803d;font-size:.8rem;">AUTO</span>
								<input id="sales_invoice" name="sales_invoice" type="text" class="form-control form-control-custom" style="border-radius:0 8px 8px 0;border-left:none;" value="AUTO" readonly="">
							</div>
						</div>

						<!-- Tanggal + Jatuh Tempo -->
						<div class="col-6">
							<label class="form-label-custom">
								<i class="fas fa-lock fa-xs me-1 text-muted"></i> Tanggal
							</label>
							<input id="sales_date" name="sales_date" type="date" class="form-control form-control-custom" value="<?php echo date('Y-m-d'); ?>" readonly>
						</div>
						

						<!-- User -->
						<div class="col-6">
							<label class="form-label-custom">
								<i class="fas fa-lock fa-xs me-1 text-muted"></i> User
							</label>
							<input id="po_user_id" name="po_user_id" type="text" class="form-control form-control-custom" value="<?php echo $_SESSION['user_name']; ?>" readonly="">
						</div>

					</div>
				</div>

			</div>
		</div>
	</div>

	<!-- ===== Dropship (hidden by default) ===== -->
	<div style="display:none;" id="dropship-container">
		<div class="card sales-card">
			<div class="card-header" style="background:linear-gradient(135deg,#c2410c,#ea580c);color:#fff;border-radius:12px 12px 0 0;padding:12px 20px;display:flex;align-items:center;gap:10px;font-weight:600;">
				<i class="fas fa-shipping-fast"></i> Informasi Dropship
			</div>
			<div class="card-body">
				<div class="row g-3">
					<div class="col-md-4">
						<label class="form-label-custom">Nama Penerima</label>
						<input id="dropship_name" name="dropship_name" type="text" class="form-control form-control-custom" placeholder="Nama Dropship Pelanggan">
					</div>
					<div class="col-md-4">
						<label class="form-label-custom">No Telp</label>
						<input id="dropship_phone" name="dropship_phone" type="text" class="form-control form-control-custom" placeholder="Telp Dropship Pelanggan">
					</div>
					<div class="col-md-4">
						<label class="form-label-custom">Alamat</label>
						<textarea id="dropship_address" name="dropship_address" class="form-control form-control-custom" placeholder="Alamat Dropship" maxlength="500" rows="2"></textarea>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- ===== ROW 2: Tambah Item ===== -->
	<div class="sales-card card">
		<div class="card-header header-teal">
			<i class="fas fa-boxes"></i> Detail Barang
		</div>
		<div class="card-body">

			<!-- Product Input Panel -->
			<form id="formaddtemp">
				<div class="product-input-panel">
					<div class="row g-3 align-items-end">
						<div class="col-md-4">
							<label class="form-label-custom">Produk</label>
							<input id="product_name" name="product_name" type="text" class="form-control form-control-custom ui-autocomplete-input" placeholder="Ketikkan nama produk..." value="" required="" autocomplete="off" data-parsley-required data-parsley-required-message="*Masukan Nama Produk">
							<input id="product_id" type="hidden" name="product_id">
						</div>
						<div class="col-md-2">
							<label class="form-label-custom">Harga Jual / Unit</label>
							<input id="temp_price" name="temp_price" class="form-control form-control-custom text-end" value="0" required="">
						</div>
						<div class="col-md-2">
							<label class="form-label-custom">Stok Gudang</label>
							<input id="curent_stock" name="curent_stock" class="form-control form-control-custom text-end" value="0" required="" readonly>
						</div>
						<div class="col-md-1">
							<label class="form-label-custom">Qty</label>
							<input id="temp_qty" name="temp_qty" type="text" class="form-control form-control-custom text-end" value="0" required="">
						</div>
						<div class="col-md-2">
							<label class="form-label-custom">Discount</label>
							<input id="temp_discount" name="temp_discount" type="text" class="form-control form-control-custom text-end" value="0">
						</div>
						<div class="col-md-4">
							<label class="form-label-custom">Keterangan</label>
							<input id="desc_item" name="desc_item" class="form-control form-control-custom">
						</div>
						<div class="col-md-4">
							<label class="form-label-custom">Total</label>
							<input id="temp_total" name="temp_total" type="text" class="form-control form-control-custom text-end fw-bold" value="0" readonly="">
						</div>
						<div class="col-md-2 d-flex align-items-end">
							<button id="btnadd_temp" class="btn btn-primary btn-add-temp" title="Tambah Item"><i class="fas fa-plus"></i></button>
						</div>
					</div>
				</div>
			</form>

			<!-- Items Table -->
			<div class="table-responsive">
				<table id="temp-sales-list" class="display table table-hover" style="width:100%">
					<thead>
						<tr>
							<th>SKU</th>
							<th>Produk</th>
							<th>Qty</th>
							<th>Harga Satuan</th>
							<th>Discount</th>
							<th>Total</th>
							<th style="text-align:center;">Aksi</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>

			<!-- ===== Footer: Notes + Summary ===== -->
			<div class="row mt-4 g-4">

				<!-- Catatan -->
				<div class="col-lg-5">
					<label class="form-label-custom mb-2"><i class="fas fa-sticky-note me-1"></i> Catatan</label>
					<textarea id="sales_remark" name="sales_remark" class="form-control form-control-custom" placeholder="Tulis catatan transaksi di sini..." maxlength="500" rows="9"></textarea>
				</div>

				<!-- Summary -->
				<div class="col-lg-7">
					<div class="summary-card p-4">
						<!-- hidden discount inputs -->
						<input id="footer_discount1" name="footer_discount1" type="hidden" value="Rp 0.00">
						<input id="footer_discount2" name="footer_discount2" type="hidden" value="Rp 0.00">
						<input id="footer_discount3" name="footer_discount3" type="hidden" value="Rp 0.00">
						<input id="footer_discount_percentage1" name="footer_discount_percentage1" type="hidden" value="0.00%">
						<input id="footer_discount_percentage2" name="footer_discount_percentage2" type="hidden" value="0.00%">
						<input id="footer_discount_percentage3" name="footer_discount_percentage3" type="hidden" value="0.00%">

						<div class="summary-row">
							<span class="summary-label"><i class="fas fa-receipt me-2 text-secondary"></i>Sub Total</span>
							<div class="summary-value">
								<input id="footer_sub_total" name="footer_sub_total" type="text" value="0" readonly="">
							</div>
						</div>

						<div class="summary-row">
							<span class="summary-label"><i class="fas fa-tag me-2 text-warning"></i>Discount
								<small class="text-muted ms-1" style="font-size:.75rem;">(klik untuk ubah)</small>
							</span>
							<div class="summary-value">
								<input id="footer_total_discount" name="footer_total_discount" data-bs-toggle="modal" data-bs-target="#footerdiscount" type="text" value="0" readonly="" style="cursor:pointer;border-color:#fbbf24;">
							</div>
						</div>

						<div class="summary-row ppn-row d-flex justify-content-between">
							<span class="summary-label"><i class="fas fa-percent me-2 text-info"></i>PPN 11%</span>
							<div class="d-flex align-items-center gap-2">
								<input class="ppn-check" type="checkbox" id="ppnchecked">
								<div class="summary-value">
									<input id="footer_total_ppn" name="footer_total_ppn" type="text" value="0" readonly="">
								</div>
							</div>
						</div>

						<div class="summary-grand my-2">
							<div class="d-flex justify-content-between align-items-center">
								<span class="summary-label fs-6"><i class="fas fa-money-bill-wave me-2"></i>Grand Total</span>
								<div class="summary-value">
									<input id="footer_total_invoice" name="footer_total_invoice" type="text" value="0" readonly="" style="width:180px;">
								</div>
							</div>
						</div>

						<div class="summary-row">
							<span class="summary-label"><i class="fas fa-hand-holding-usd me-2 text-success"></i>Down Payment (DP)</span>
							<div class="summary-value">
								<input id="footer_dp" name="footer_dp" type="text" value="0" style="background:#fff;border-color:#d1d5db;">
							</div>
						</div>

						<div class="summary-row">
							<span class="summary-label"><i class="fas fa-credit-card me-2 text-danger"></i>Kredit / Sisa</span>
							<div class="summary-value">
								<input id="footer_remaining_debt" name="footer_remaining_debt" type="text" value="0" readonly="">
							</div>
						</div>

						<!-- Action Buttons -->
						<div class="d-flex justify-content-end gap-3 mt-4 pt-3 border-top">
							<button id="btncancel" class="btn btn-cancel-main">
								<i class="fas fa-times-circle me-2"></i> Batal
							</button>
							<button id="btnsave" class="btn btn-save-main button-header-custom-save">
								<i class="fas fa-save me-2"></i> Simpan Transaksi
							</button>
						</div>
					</div>
				</div>

			</div>

			<!-- Footer Modal Discount -->
			<div class="modal fade" id="footerdiscount" tabindex="-1" aria-labelledby="exampleModaleditLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content" style="border-radius:12px;overflow:hidden;border:none;">
						<div class="modal-header modal-header-disc">
							<h5 class="modal-title" id="title-frmfooterdiscount"><i class="fas fa-tag me-2"></i>Atur Diskon</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<form id="frmfooterdiscount" class="form-horizontal">
							<div class="modal-body p-4">
								<?php foreach ([1,2,3] as $n) : ?>
								<div class="mb-3 p-3" style="background:#f8fafc;border-radius:8px;border:1px solid #e5e7eb;">
									<div class="disc-group-label">Diskon <?php echo $n; ?> <span class="disc-badge">Tier <?php echo $n; ?></span></div>
									<div class="row g-2">
										<div class="col-6">
											<label class="form-label-custom" style="font-size:.75rem;">Persentase (%)</label>
											<input type="text" class="form-control form-control-custom" id="edit_footer_discount_percentage<?php echo $n; ?>" name="edit_footer_discount_percentage<?php echo $n; ?>" value="0">
										</div>
										<div class="col-6">
											<label class="form-label-custom" style="font-size:.75rem;">Nilai (Rp)</label>
											<input type="text" class="form-control form-control-custom" id="edit_footer_discount<?php echo $n; ?>" name="edit_footer_discount<?php echo $n; ?>" value="0" readonly>
										</div>
									</div>
								</div>
								<?php endforeach; ?>
							</div>
							<div class="modal-footer" style="border-top:1px solid #e5e7eb;">
								<button type="button" class="btn btn-cancel-main btn-sm" data-bs-dismiss="modal"><i class="fas fa-times-circle me-1"></i> Batal</button>
								<button type="button" id="btneditdisc" class="btn btn-save-main btn-sm"><i class="fas fa-check me-1"></i> Terapkan</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- /Footer Modal Discount -->

		</div>
	</div>

</div>
</div>

<?php 
require DOC_ROOT_PATH . $this->config->item('footer');
?>

<script>

	let temp_price = new AutoNumeric('#temp_price', {
		currencySymbol : 'Rp. ',
		decimalCharacter : ',',
		decimalPlaces: 0,
		decimalPlacesShownOnFocus: 0,
		digitGroupSeparator : '.',
	});

	let temp_total = new AutoNumeric('#temp_total', {
		currencySymbol : 'Rp. ',
		decimalCharacter : ',',
		decimalPlaces: 0,
		decimalPlacesShownOnFocus: 0,
		digitGroupSeparator : '.',
	});


	let temp_discount = new AutoNumeric('#temp_discount', {
		currencySymbol : 'Rp. ',
		decimalCharacter : ',',
		decimalPlaces: 0,
		decimalPlacesShownOnFocus: 0,
		digitGroupSeparator : '.',
	});

	let footer_sub_total = new AutoNumeric('#footer_sub_total', {
		currencySymbol : 'Rp. ',
		decimalCharacter : ',',
		decimalPlaces: 0,
		decimalPlacesShownOnFocus: 0,
		digitGroupSeparator : '.',
	});

	let footer_total_discount = new AutoNumeric('#footer_total_discount', {
		currencySymbol : 'Rp. ',
		decimalCharacter : ',',
		decimalPlaces: 0,
		decimalPlacesShownOnFocus: 0,
		digitGroupSeparator : '.',
	});

	let footer_total_ppn = new AutoNumeric('#footer_total_ppn', {
		currencySymbol : 'Rp. ',
		decimalCharacter : ',',
		decimalPlaces: 0,
		decimalPlacesShownOnFocus: 0,
		digitGroupSeparator : '.',
	});

	let footer_dp = new AutoNumeric('#footer_dp', {
		currencySymbol : 'Rp. ',
		decimalCharacter : ',',
		decimalPlaces: 0,
		decimalPlacesShownOnFocus: 0,
		digitGroupSeparator : '.',
	});

	let footer_remaining_debt = new AutoNumeric('#footer_remaining_debt', {
		currencySymbol : 'Rp. ',
		decimalCharacter : ',',
		decimalPlaces: 0,
		decimalPlacesShownOnFocus: 0,
		digitGroupSeparator : '.',
	});
	

	let footer_total_invoice = new AutoNumeric('#footer_total_invoice', {
		currencySymbol : 'Rp. ',
		decimalCharacter : ',',
		decimalPlaces: 0,
		decimalPlacesShownOnFocus: 0,
		digitGroupSeparator : '.',
	});

	let edit_footer_discount1 = new AutoNumeric('#edit_footer_discount1', {
		currencySymbol : 'Rp. ',
		decimalCharacter : ',',
		decimalPlaces: 0,
		decimalPlacesShownOnFocus: 0,
		digitGroupSeparator : '.',
	});

	let edit_footer_discount2 = new AutoNumeric('#edit_footer_discount2', {
		currencySymbol : 'Rp. ',
		decimalCharacter : ',',
		decimalPlaces: 0,
		decimalPlacesShownOnFocus: 0,
		digitGroupSeparator : '.',
	});

	let edit_footer_discount3 = new AutoNumeric('#edit_footer_discount3', {
		currencySymbol : 'Rp. ',
		decimalCharacter : ',',
		decimalPlaces: 0,
		decimalPlacesShownOnFocus: 0,
		digitGroupSeparator : '.',
	});
	

	let edit_footer_discount_percentage1 = new AutoNumeric('#edit_footer_discount_percentage1', {
		allowDecimalPadding: "floats",
		alwaysAllowDecimalCharacter: true,
		suffixText: "%"
	});

	let edit_footer_discount_percentage2 = new AutoNumeric('#edit_footer_discount_percentage2', {
		allowDecimalPadding: "floats",
		alwaysAllowDecimalCharacter: true,
		suffixText: "%"
	});

	let edit_footer_discount_percentage3 = new AutoNumeric('#edit_footer_discount_percentage3', {
		allowDecimalPadding: "floats",
		alwaysAllowDecimalCharacter: true,
		suffixText: "%"
	});


	$(document).ready(function() {
		tempsales_table();
	});

	function tempsales_table(){
		$('#temp-sales-list').DataTable( {
			serverSide: true,
			search: true,
			processing: true,
			ordering: false,
			retrieve: true,
			ajax: {
				url: '<?php echo base_url(); ?>Sales/temp_sales_list',
				type: 'POST',
				data:  {},
			},
			columns: 
			[
				{data: 0},
				{data: 1},
				{data: 2},
				{data: 3},
				{data: 4},
				{data: 5},
				{data: 6}
			]
		});
		check_tempt_data();
	}

	$('#product_name').autocomplete({ 
		minLength: 2,
		source: function(req, add) {
			if($('#sales_price_type').val() == '') {
				Swal.fire({
					icon: 'warning',
					title: 'Jenis Harga Belum Dipilih',
					text: 'Silakan pilih jenis harga terlebih dahulu sebelum mencari produk.',
				});
				$('#product_name').val('');
				return;
			}
			$.ajax({
				url: '<?php echo base_url(); ?>/Sales/search_product?pricetype='+$('#sales_price_type').val(),
				dataType: 'json',
				type: 'GET',
				data: req,
				success: function(res) {
					if (res.success == true) {
						add(res.data);
					}else{
						$('#submission_inv').val('');
					}
				},
			});
		},
		select: function(event, ui) {
			let id = ui.item.id;
			let product_name = ui.item.product_name;
			let product_id = ui.item.product_id;
			let product_price = ui.item.product_price;
			let curent_stock = ui.item.curent_stock;
			$('#product_name').val(product_name);
			$('#product_id').val(id);
			if(curent_stock == null){
				$('#curent_stock').val(0);
			}else{
				$('#curent_stock').val(curent_stock);
			}
			let sales_price_type = $('#sales_price_type').val();
			temp_price.set(product_price);
			$('#temp_qty').val(1);
			temp_total.set(product_price);
		},
	});




	$('#temp_price').on('input', function (event) {
		calculation_total_temp();
	})

	$('#temp_qty').on('input', function (event) {
		calculation_total_temp();
	})

	$('#temp_discount').on('input', function (event) {
		calculation_total_temp();
	})

	function calculation_total_temp()
	{
		let temp_price_val     = parseInt(temp_price.get());
		let temp_qty_val       = $('#temp_qty').val();
		let temp_discount_val  = parseInt(temp_discount.get());
		let temp_total_val = temp_price_val * temp_qty_val - temp_discount_val;
		temp_total.set(temp_total_val);
	}


	function edit_temp(id)
	{
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>Sales/get_edit_temp_sales",
			dataType: "json",
			data: {id:id},
			success : function(data){
				if (data.code == "200"){
					console.log(data);
					var row = data.result[0];
					$("#product_name").val(row.product_name);
					$("#product_id").val(row.temp_product_id);
					temp_price.set(row.temp_sales_price);
					$("#temp_qty").val(row.temp_sales_qty);
					$("#desc_item").val(row.temp_desc_item);
					temp_discount.set(row.temp_sales_discount);
					temp_total.set(row.temp_sales_total);
					$('#curent_stock').val(data.stock[0].stock);
				}
			}
		});  
	}


	function clear_input()
	{
		$('#product_name').val("");
		$('#product_id').val("");
		temp_price.set(0);
		$('#temp_qty').val(0);
		temp_discount.set(0);
		temp_total.set(0);
		$('#desc_item').val("");
		$('#curent_stock').val(0);
		footer_total_discount.set(0);
		edit_footer_discount_percentage1.set(0);
		edit_footer_discount_percentage2.set(0);
		edit_footer_discount_percentage3.set(0);
		edit_footer_discount1.set(0);
		edit_footer_discount2.set(0);
		edit_footer_discount3.set(0);
		$('#ppn_cheked').prop('checked', false);
		footer_total_ppn.set(0);
		footer_dp.set(0);
	}

	$('#btnadd_temp').click(function(e){
		e.preventDefault();
		var warehouse_id            = $("#sales_warehouse").val();
		var product_id              = $("#product_id").val();
		var temp_price_val          = parseInt(temp_price.get());
		var temp_qty                = $("#temp_qty").val();
		var temp_discount_val       = parseInt(temp_discount.get());
		var temp_total_val          = parseInt(temp_total.get());
		var desc_item               = $("#desc_item").val();

		if($('#formaddtemp').parsley().validate({force: true})){
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>Sales/add_temp_sales",
				dataType: "json",
				data: {warehouse_id:warehouse_id, product_id:product_id, temp_price_val:temp_price_val, temp_qty:temp_qty, temp_discount_val:temp_discount_val, temp_total_val:temp_total_val, desc_item:desc_item},
				success : function(data){
					if (data.code == "200"){
						let title = 'Tambah Data';
						let message = 'Data Berhasil Di Tambah';
						let state = 'info';
						notif_success(title, message, state);
						$('#temp-sales-list').DataTable().ajax.reload();
						check_tempt_data();
						clear_input();
					} else {
						Swal.fire({
							icon: 'error',
							title: 'Oops...',
							text: data.result,
						})
					}
				}
			});
		}
	});

	$('#btnsave').click(function(e){
		e.preventDefault();
		var sales_customer                           = $("#sales_customer").val();     
		var sales_payment                            = $("#sales_payment").val();
		var sales_due_date						     = $("#sales_due_date").val();
		var footer_sub_total_submit                  = parseInt(footer_sub_total.get());
		var footer_total_discount_submit             = parseInt(footer_total_discount.get());
		var edit_footer_discount_percentage1_submit  = parseInt(edit_footer_discount_percentage1.get());
		var edit_footer_discount_percentage2_submit  = parseInt(edit_footer_discount_percentage2.get());
		var edit_footer_discount_percentage3_submit  = parseInt(edit_footer_discount_percentage3.get());
		var edit_footer_discount1_submit             = parseInt(edit_footer_discount1.get());
		var edit_footer_discount2_submit             = parseInt(edit_footer_discount2.get());
		var edit_footer_discount3_submit             = parseInt(edit_footer_discount3.get());
		var footer_total_ppn_val                     = parseInt(footer_total_ppn.get());
		var footer_total_invoice_val                 = parseInt(footer_total_invoice.get());
		var footer_dp_val                            = parseInt(footer_dp.get());
		var footer_remaining_debt_val                = parseInt(footer_remaining_debt.get());
		var sales_remark                             = $("#sales_remark").val();
		var sales_date                               = $("#sales_date").val();
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>Sales/save_sales",
			dataType: "json",
			data: {sales_customer:sales_customer, sales_payment:sales_payment, sales_due_date:sales_due_date, footer_sub_total_submit:footer_sub_total_submit, footer_total_discount_submit:footer_total_discount_submit, edit_footer_discount_percentage1_submit:edit_footer_discount_percentage1_submit, edit_footer_discount_percentage2_submit:edit_footer_discount_percentage2_submit, edit_footer_discount_percentage3_submit:edit_footer_discount_percentage3_submit, edit_footer_discount1_submit:edit_footer_discount1_submit, edit_footer_discount2_submit:edit_footer_discount2_submit, edit_footer_discount3_submit:edit_footer_discount3_submit, footer_total_ppn_val:footer_total_ppn_val, footer_total_invoice_val:footer_total_invoice_val, footer_dp_val:footer_dp_val, footer_remaining_debt_val:footer_remaining_debt_val, sales_remark:sales_remark, sales_date:sales_date},
			success : function(data){
				if (data.code == "200"){
					window.location.href = "<?php echo base_url(); ?>/Sales/salespage";
				} else {
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: data.result,
					})
				}
			}
		});
	});

$('#edit_footer_discount_percentage1').on('input', function (event) {
	let footer_sub_total_val = parseInt(footer_sub_total.get());
	let edit_footer_discount_percentage1_val = parseInt(edit_footer_discount_percentage1.get());
	let edit_footer_discount1_val = footer_sub_total_val * edit_footer_discount_percentage1_val / 100;
	edit_footer_discount1.set(edit_footer_discount1_val);
})

$('#edit_footer_discount_percentage2').on('input', function (event) {
	let footer_sub_total_val = parseInt(footer_sub_total.get());
	let edit_footer_discount_percentage2_val = parseInt(edit_footer_discount_percentage2.get());
	let edit_footer_discount1_val = parseInt(edit_footer_discount1.get());
	let edit_footer_discount2_val = (footer_sub_total_val - edit_footer_discount1_val) * edit_footer_discount_percentage2_val / 100;
	edit_footer_discount2.set(edit_footer_discount2_val);
})

$('#edit_footer_discount_percentage3').on('input', function (event) {
	let footer_sub_total_val = parseInt(footer_sub_total.get());
	let edit_footer_discount_percentage3_val = parseInt(edit_footer_discount_percentage3.get());
	let edit_footer_discount1_val = parseInt(edit_footer_discount1.get());
	let edit_footer_discount2_val = parseInt(edit_footer_discount2.get());
	let edit_footer_discount3_val = (footer_sub_total_val - edit_footer_discount1_val - edit_footer_discount2_val) * edit_footer_discount_percentage3_val / 100;
	edit_footer_discount3.set(edit_footer_discount3_val);
})

$('#btneditdisc').click(function(e){
	e.preventDefault();
	var edit_footer_discount_percentage1_pop  = parseInt(edit_footer_discount_percentage1.get());
	var edit_footer_discount_percentage2_pop  = parseInt(edit_footer_discount_percentage2.get());
	var edit_footer_discount_percentage3_pop  = parseInt(edit_footer_discount_percentage3.get());
	var edit_footer_discount1_pop             = parseInt(edit_footer_discount1.get());
	var edit_footer_discount2_pop             = parseInt(edit_footer_discount2.get());
	var edit_footer_discount3_pop             = parseInt(edit_footer_discount3.get());
	var footer_sub_total_val                  = parseInt(footer_sub_total.get());
	var total_disc = parseInt(edit_footer_discount1_pop + edit_footer_discount2_pop + edit_footer_discount3_pop);
	footer_total_discount.set(total_disc);
	footer_total_invoice.set(footer_sub_total_val - total_disc);
	footer_remaining_debt.set(footer_sub_total_val - total_disc);
	$('#footerdiscount').modal('hide')
});

$('#ppnchecked').on('change', function (event) {
	const checked = $(this).is(':checked');
	if (checked == true) {
		let footer_sub_total_val = parseInt(footer_sub_total.get());
		let footer_total_discount_val = parseInt(footer_total_discount.get());
		let footer_dp_val = parseInt(footer_dp.get());
		let ppn = (footer_sub_total_val - footer_total_discount_val) * 11 / 100;
		footer_total_ppn.set(ppn);
		footer_total_invoice.set(footer_sub_total_val - footer_total_discount_val + ppn);
		footer_remaining_debt.set(footer_sub_total_val - footer_total_discount_val + ppn - footer_dp_val);
	}else{
		footer_total_ppn.set(0);
	}
})

$('#footer_dp').on('input', function (event) {
	let footer_dp_val =  parseInt(footer_dp.get());
	let footer_total_invoice_val = parseInt(footer_total_invoice.get());
	footer_remaining_debt.set(footer_total_invoice_val - footer_dp_val);
})

function check_tempt_data()
{
	$.ajax({
		type: "POST",
		url: "<?php echo base_url(); ?>Sales/check_temp_sales",
		dataType: "json",
		data: {},
		success : function(data){
			if (data.code == "200"){
				let sub_total = data.data[0].sub_total;
				console.log(sub_total);
				
				if(sub_total == null){
					sub_total = 0;
					edit_footer_discount_percentage1.set(0);
					edit_footer_discount_percentage2.set(0);
					edit_footer_discount_percentage3.set(0);
					edit_footer_discount1.set(0);
					edit_footer_discount2.set(0);
					edit_footer_discount3.set(0);
					footer_total_discount.set(0);
					$('#ppn_cheked').prop('checked', false);
					footer_total_ppn.set(0);
					footer_dp.set(0);
				}
				footer_sub_total.set(sub_total);
				footer_total_invoice.set(sub_total);
				footer_remaining_debt.set(sub_total);

			}
		}
	});
}

function deletes(id)
{
	Swal.fire({
		title: 'Konfirmasi?',
		text: "Apakah Anda Yakin Menghapus Data?",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Hapus'
	}).then((result) => {
		if (result.isConfirmed) {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>Sales/delete_temp_sales",
				dataType: "json",
				data: {id:id},
				success : function(data){
					if (data.code == "200"){
						$('#temp-sales-list').DataTable().ajax.reload();
						let title = 'Hapus Data';
						let message = 'Data Berhasil Di Hapus';
						let state = 'danger';
						notif_success(title, message, state);
						check_tempt_data();
					} else {
						Swal.fire({
							icon: 'error',
							title: 'Oops...',
							text: data.result,
						})
					}
				}
			});
		}
	})
}

$("#btncancel").click(function (e) {
	Swal.fire({
		title: 'Konfirmasi?',
		text: "Apakah Anda Yakin Membatalkan Inputan",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Hapus'
	}).then((result) => {
		if (result.isConfirmed) {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>Sales/clear_temp_sales",
				dataType: "json",
				data: {},
				success : function(data){
					if (data.code == "200"){
						window.location.href = "<?php echo base_url(); ?>/Sales/salespage";
					}else {
						Swal.fire({
							icon: 'error',
							title: 'Oops...',
							text: data.result,
						})
					}
				}
			});
		}
	})
});

new bootstrap.Modal(document.getElementById('footerdiscount'), {backdrop: 'static', keyboard: false})  

</script>