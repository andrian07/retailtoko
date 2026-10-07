<?php
define('DOC_ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].'/');
require DOC_ROOT_PATH . $this->config->item('header');
?>
</div>
<link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/form-page.css?v=<?php echo @filemtime(FCPATH.'dist/css/form-page.css'); ?>">

<div class="container">
<div class="page-inner fp-page">

	<!-- ===== Judul ===== -->
	<div class="fp-hero">
		<div class="fp-hero-title">
			<div class="fp-hero-icon"><i class="fas fa-shopping-cart"></i></div>
			<div>
				<h3>Tambah Penjualan</h3>
				<p>Buat transaksi penjualan baru dengan mudah dan cepat.</p>
			</div>
		</div>
		<div class="fp-breadcrumb">
			<a href="<?php echo base_url(); ?>Dashboard"><i class="fas fa-home"></i></a>
			<i class="fas fa-chevron-right sep"></i>
			<a href="<?php echo base_url(); ?>Sales/salespage">Penjualan</a>
			<i class="fas fa-chevron-right sep"></i>
			<span>Tambah Penjualan</span>
		</div>
	</div>

	<!-- ===== Informasi Transaksi ===== -->
	<div class="fp-card">
		<div class="fp-section"><i class="fas fa-file-invoice"></i> Informasi Transaksi</div>

		<!-- hidden meta inputs -->
		<input id="sales_id" name="sales_id" type="hidden">
		<input id="sales_order_id" name="sales_order_id" type="hidden">
		<input id="sales_rate_customer" name="sales_rate_customer" type="hidden">
		<input id="hd_sales_type" name="hd_sales_type" type="hidden">

		<div class="fp-grid fp-cols-3">
			<div class="fp-field">
				<label><i class="fas fa-user-tag"></i> Customer <span class="req">*</span></label>
				<div class="fp-ig">
					<span class="fp-ig-icon"><i class="fas fa-user"></i></span>
					<select class="form-control js-example-basic-single" id="sales_customer" name="sales_customer">
						<option value="">-- Pilih Customer --</option>
						<?php foreach ($data['customer_list'] as $row) { ?>
							<option value="<?php echo $row->customer_id; ?>"><?php echo $row->customer_name; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="fp-grid fp-cols-2">
				<div class="fp-field">
					<label><i class="fas fa-cart-arrow-down"></i> Tanggal Transaksi</label>
					<div class="fp-ig">
						<span class="fp-ig-icon"><i class="far fa-calendar-alt"></i></span>
						<input id="sales_date" name="sales_date" type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" readonly>
					</div>
				</div>
				<div class="fp-field">
					<label><i class="far fa-calendar-check"></i> Jatuh Tempo <span class="req">*</span></label>
					<div class="fp-ig">
						<span class="fp-ig-icon"><i class="far fa-calendar-alt"></i></span>
						<input id="sales_due_date" name="sales_due_date" type="date" class="form-control">
					</div>
				</div>
			</div>
			<div class="fp-field fp-divider-l">
				<label><i class="far fa-file-alt"></i> No Invoice</label>
				<div class="fp-ig">
					<span class="fp-ig-icon"><i class="fas fa-hashtag"></i></span>
					<div class="fp-auto">
						<span class="fp-auto-badge">AUTO</span>
						<span>Dibuat otomatis saat disimpan</span>
						<input id="sales_invoice" name="sales_invoice" type="text" value="AUTO" readonly="">
					</div>
				</div>
			</div>

			<div class="fp-field">
				<label><i class="far fa-credit-card"></i> Metode Bayar <span class="req">*</span></label>
				<div class="fp-ig">
					<span class="fp-ig-icon"><i class="far fa-credit-card"></i></span>
					<select class="form-control js-example-basic-single" id="sales_payment" name="sales_payment">
						<option value="">-- Pilih Metode Bayar --</option>
						<?php foreach ($data['payment_list'] as $row) { ?>
							<option value="<?php echo $row->payment_id; ?>"><?php echo $row->payment_name; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="fp-field">
				<label><i class="fas fa-tag"></i> Jenis Harga <span class="req">*</span></label>
				<div class="fp-ig">
					<span class="fp-ig-icon"><i class="fas fa-tags"></i></span>
					<select class="form-control js-example-basic-single" id="sales_price_type" name="sales_price_type">
						<option value="">-- Pilih Jenis Harga --</option>
						<option value="Umum">Umum</option>
						<option value="Toko">Toko</option>
						<option value="Sales">Sales</option>
						<option value="Khusus">Khusus</option>
						<option value="Hulu">Hulu</option>
					</select>
				</div>
			</div>
			<div class="fp-field fp-divider-l">
				<label><i class="fas fa-user"></i> User</label>
				<div class="fp-ig">
					<span class="fp-ig-icon"><i class="fas fa-user"></i></span>
					<input id="po_user_id" name="po_user_id" type="text" class="form-control" value="<?php echo $_SESSION['user_name']; ?>" readonly="">
				</div>
			</div>
		</div>
	</div>

	<!-- ===== Dropship (tersembunyi, sama seperti sebelumnya) ===== -->
	<div style="display:none;" id="dropship-container">
		<div class="fp-card">
			<div class="fp-section"><i class="fas fa-shipping-fast"></i> Informasi Dropship</div>
			<div class="fp-grid fp-cols-3">
				<div class="fp-field">
					<label><i class="fas fa-user"></i> Nama Penerima</label>
					<div class="fp-ig"><span class="fp-ig-icon"><i class="fas fa-user"></i></span><input id="dropship_name" name="dropship_name" type="text" class="form-control" placeholder="Nama Dropship Pelanggan"></div>
				</div>
				<div class="fp-field">
					<label><i class="fas fa-phone"></i> No Telp</label>
					<div class="fp-ig"><span class="fp-ig-icon"><i class="fas fa-phone"></i></span><input id="dropship_phone" name="dropship_phone" type="text" class="form-control" placeholder="Telp Dropship Pelanggan"></div>
				</div>
				<div class="fp-field">
					<label><i class="fas fa-map-marker-alt"></i> Alamat</label>
					<div class="fp-ig"><span class="fp-ig-icon"><i class="fas fa-map-marker-alt"></i></span><textarea id="dropship_address" name="dropship_address" class="form-control" placeholder="Alamat Dropship" maxlength="500" rows="2"></textarea></div>
				</div>
			</div>
		</div>
	</div>

	<!-- ===== Detail Barang ===== -->
	<div class="fp-card">
		<div class="fp-section"><i class="fas fa-box-open"></i> Detail Barang</div>

		<form id="formaddtemp">
			<div class="fp-grid" style="grid-template-columns: 2.2fr 1.1fr 1fr .8fr 1.1fr;">
				<div class="fp-field">
					<label><i class="fas fa-info-circle"></i> Cari Produk (Nama / SKU / Barcode)</label>
					<div class="fp-ig">
						<span class="fp-ig-icon"><i class="fas fa-search"></i></span>
						<input id="product_name" name="product_name" type="text" class="form-control ui-autocomplete-input" placeholder="Ketik nama produk, SKU atau scan barcode..." value="" required="" autocomplete="off" data-parsley-required data-parsley-required-message="*Masukan Nama Produk">
					</div>
					<input id="product_id" type="hidden" name="product_id">
				</div>
				<div class="fp-field">
					<label>Harga Jual / Unit</label>
					<input id="temp_price" name="temp_price" class="form-control text-end" value="0" required="">
				</div>
				<div class="fp-field">
					<label>Stok Gudang</label>
					<input id="curent_stock" name="curent_stock" class="form-control text-end" value="0" required="" readonly>
				</div>
				<div class="fp-field">
					<label>Qty</label>
					<input id="temp_qty" name="temp_qty" type="text" class="form-control text-end" value="0" required="">
				</div>
				<div class="fp-field">
					<label>Discount</label>
					<input id="temp_discount" name="temp_discount" type="text" class="form-control text-end" value="0">
				</div>
			</div>
			<div class="fp-grid mt-3" style="grid-template-columns: 2.2fr 1.9fr 1.9fr;">
				<div class="fp-field">
					<label><i class="far fa-sticky-note"></i> Keterangan</label>
					<div class="fp-ig"><span class="fp-ig-icon"><i class="far fa-sticky-note"></i></span><input id="desc_item" name="desc_item" class="form-control" placeholder="Keterangan item (opsional)"></div>
				</div>
				<div class="fp-field">
					<label>Total</label>
					<input id="temp_total" name="temp_total" type="text" class="form-control text-end fw-bold" value="0" readonly="">
				</div>
				<div class="fp-field">
					<button id="btnadd_temp" class="fp-btn-add btn-add-temp" title="Tambah Item"><i class="fas fa-plus-circle"></i> Tambah</button>
				</div>
			</div>
		</form>

		<div class="table-responsive fp-table">
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

		<!-- ===== Catatan + ringkasan ===== -->
		<div class="fp-bottom">
			<div class="fp-note">
				<h6><i class="far fa-file-alt"></i> Catatan</h6>
				<textarea id="sales_remark" name="sales_remark" class="form-control" placeholder="Tulis catatan transaksi di sini..." maxlength="500" rows="9"></textarea>
			</div>

			<div>
				<div class="fp-summary">
					<!-- hidden discount inputs -->
					<input id="footer_discount1" name="footer_discount1" type="hidden" value="Rp 0.00">
					<input id="footer_discount2" name="footer_discount2" type="hidden" value="Rp 0.00">
					<input id="footer_discount3" name="footer_discount3" type="hidden" value="Rp 0.00">
					<input id="footer_discount_percentage1" name="footer_discount_percentage1" type="hidden" value="0.00%">
					<input id="footer_discount_percentage2" name="footer_discount_percentage2" type="hidden" value="0.00%">
					<input id="footer_discount_percentage3" name="footer_discount_percentage3" type="hidden" value="0.00%">

					<div class="fp-sum-row">
						<span><i class="fas fa-receipt" style="color:#4b5563;"></i> Sub Total</span>
						<input id="footer_sub_total" name="footer_sub_total" type="text" value="0" readonly="">
					</div>
					<div class="fp-sum-row">
						<span><i class="fas fa-tag" style="color:#f59e0b;"></i> Discount <small>(klik untuk ubah)</small></span>
						<input id="footer_total_discount" name="footer_total_discount" class="fp-sum-click" data-bs-toggle="modal" data-bs-target="#footerdiscount" type="text" value="0" readonly="">
					</div>
					<div class="fp-sum-row">
						<span><i class="fas fa-percent" style="color:#4b5563;"></i> PPN 11%</span>
						<span class="fp-sum-val">
							<input type="checkbox" id="ppnchecked">
							<input id="footer_total_ppn" name="footer_total_ppn" type="text" value="0" readonly="">
						</span>
					</div>
					<div class="fp-sum-row fp-sum-grand">
						<span><i class="fas fa-money-bill-wave"></i> Grand Total</span>
						<input id="footer_total_invoice" name="footer_total_invoice" type="text" value="0" readonly="">
					</div>
					<div class="fp-sum-row">
						<span><i class="fas fa-hand-holding-usd" style="color:#0f8a5f;"></i> Down Payment (DP)</span>
						<input id="footer_dp" name="footer_dp" type="text" value="0">
					</div>
					<div class="fp-sum-row">
						<span><i class="far fa-credit-card" style="color:#dc2626;"></i> Kredit / Sisa</span>
						<input id="footer_remaining_debt" name="footer_remaining_debt" type="text" value="0" readonly="">
					</div>
				</div>

				<div class="fp-actions">
					<button id="btncancel" class="btn fp-btn-cancel"><i class="fas fa-times-circle"></i> Batal</button>
					<button id="btnsave" class="btn fp-btn-save button-header-custom-save"><i class="fas fa-save"></i> Simpan Transaksi</button>
				</div>
			</div>
		</div>

		<!-- Footer Modal Discount -->
		<div class="modal fade" id="footerdiscount" tabindex="-1" aria-labelledby="exampleModaleditLabel" aria-hidden="true" data-icon="fas fa-tag" data-subtitle="Atur diskon bertingkat untuk transaksi ini.">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="title-frmfooterdiscount">Atur Diskon</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form id="frmfooterdiscount" class="form-horizontal">
						<div class="modal-body">
							<?php foreach ([1,2,3] as $n) : ?>
							<div class="mb-3 p-3" style="background:#f6fcf9;border-radius:10px;border:1px solid #e0efe8;">
								<div class="mb-2" style="font-weight:700;font-size:.85rem;">Diskon <?php echo $n; ?> <span class="badge" style="background:#e3f5ee;color:#0b6b4a;">Tier <?php echo $n; ?></span></div>
								<div class="row g-2">
									<div class="col-6">
										<label class="form-label">Persentase (%)</label>
										<input type="text" class="form-control" id="edit_footer_discount_percentage<?php echo $n; ?>" name="edit_footer_discount_percentage<?php echo $n; ?>" value="0">
									</div>
									<div class="col-6">
										<label class="form-label">Nilai (Rp)</label>
										<input type="text" class="form-control" id="edit_footer_discount<?php echo $n; ?>" name="edit_footer_discount<?php echo $n; ?>" value="0" readonly>
									</div>
								</div>
							</div>
							<?php endforeach; ?>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-times-circle"></i> Batal</button>
							<button type="button" id="btneditdisc" class="btn btn-primary"><i class="fas fa-check"></i> Terapkan</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- /Footer Modal Discount -->

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
		// buka jendela print sekarang (di dalam klik) supaya tidak diblokir popup blocker
		var print_win = window.open('', '_blank');
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>Sales/save_sales",
			dataType: "json",
			data: {sales_customer:sales_customer, sales_payment:sales_payment, sales_due_date:sales_due_date, footer_sub_total_submit:footer_sub_total_submit, footer_total_discount_submit:footer_total_discount_submit, edit_footer_discount_percentage1_submit:edit_footer_discount_percentage1_submit, edit_footer_discount_percentage2_submit:edit_footer_discount_percentage2_submit, edit_footer_discount_percentage3_submit:edit_footer_discount_percentage3_submit, edit_footer_discount1_submit:edit_footer_discount1_submit, edit_footer_discount2_submit:edit_footer_discount2_submit, edit_footer_discount3_submit:edit_footer_discount3_submit, footer_total_ppn_val:footer_total_ppn_val, footer_total_invoice_val:footer_total_invoice_val, footer_dp_val:footer_dp_val, footer_remaining_debt_val:footer_remaining_debt_val, sales_remark:sales_remark, sales_date:sales_date},
			success : function(data){
				if (data.code == "200"){
					if (print_win) {
						print_win.location.href = "<?php echo base_url(); ?>Sales/printnota?print_type=1&sales_id=" + data.sales_id;
					}
					window.location.href = "<?php echo base_url(); ?>/Sales/salespage";
				} else {
					if (print_win) { print_win.close(); }
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: data.result,
					})
				}
			},
			error: function(){
				if (print_win) { print_win.close(); }
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
		confirmButtonColor: '#0f8a5f',
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
		confirmButtonColor: '#0f8a5f',
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