<?php
define('DOC_ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].'/');
require DOC_ROOT_PATH . $this->config->item('header');

function pos_category_icon($name){
	$name = strtolower($name);
	$map = array(
		'makan' => 'fas fa-utensils', 'minum' => 'fas fa-coffee', 'snack' => 'fas fa-cookie-bite',
		'pulsa' => 'fas fa-mobile-alt', 'ppob' => 'fas fa-mobile-alt', 'elektron' => 'fas fa-headphones',
		'tulis' => 'fas fa-pencil-alt', 'rumah' => 'fas fa-home', 'obat' => 'fas fa-pills',
		'kosmetik' => 'fas fa-spray-can', 'rokok' => 'fas fa-smoking', 'dus' => 'fas fa-box',
	);
	foreach($map as $key => $icon){
		if(strpos($name, $key) !== false) return $icon;
	}
	return 'fas fa-tag';
}
?>
</div>

<style>
	:root {
		--pos-green: #0f8a5f;
		--pos-green-dark: #0b6b4a;
		--pos-green-soft: #e3f5ee;
		--pos-red: #e5484d;
		--pos-text: #1f2937;
		--pos-muted: #6b7280;
		--pos-border: #e9edf2;
	}
	.pos-wrapper { background: #f3f5f8; min-height: 100vh; padding: 84px 0 30px; }
	.pos-card { background: #fff; border: 1px solid var(--pos-border); border-radius: 14px; box-shadow: 0 2px 10px rgba(16,24,40,.04); }
	.pos-card-title { display: flex; align-items: center; gap: 10px; font-size: 1.05rem; font-weight: 700; color: var(--pos-text); margin: 0; }
	.pos-card-title i { color: var(--pos-green); font-size: 1.15rem; }

	/* Toolbar */
	.pos-toolbar { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; margin-bottom: 14px; }
	.pos-search { position: relative; flex: 1 1 220px; }
	.pos-search i { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #9ca3af; }
	.pos-search input { width: 100%; border: 1px solid var(--pos-border); border-radius: 12px; padding: 12px 40px 12px 44px; font-size: .95rem; background: #fff; box-shadow: 0 2px 10px rgba(16,24,40,.04); }
	.pos-search input:focus { outline: none; border-color: var(--pos-green); box-shadow: 0 0 0 3px rgba(15,138,95,.15); }
	.pos-search .clear-search { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); border: none; background: none; color: #9ca3af; display: none; }
	.pos-key { display: inline-flex; align-items: center; gap: 8px; background: #fff; border: 1px solid var(--pos-border); border-radius: 10px; padding: 8px 12px; font-size: .82rem; color: var(--pos-text); cursor: pointer; white-space: nowrap; }
	.pos-key kbd { background: var(--pos-green-dark); color: #fff; border-radius: 6px; padding: 2px 7px; font-size: .75rem; font-weight: 700; }

	/* Hero */
	/* banner_pos.png berukuran 2172x724 dengan area putih di sekelilingnya;
	   area hijaunya (x 12-2158, y 122-600) dipotong lewat wrapper ini */
	.pos-hero { position: relative; overflow: hidden; border-radius: 16px; margin-bottom: 14px; aspect-ratio: 2147 / 479; background: #0b6b4a; }
	.pos-hero img { position: absolute; width: 101.164%; left: -0.559%; top: -25.47%; max-width: none; }

	/* Kategori */
	.cat-list { display: flex; gap: 10px; overflow-x: auto; padding-bottom: 4px; }
	.cat-item { flex: 0 0 auto; min-width: 88px; max-width: 120px; border: 1px solid var(--pos-border); background: #f8fafb; border-radius: 12px; padding: 14px 10px 10px; text-align: center; cursor: pointer; transition: all .15s; }
	.cat-item i { display: block; font-size: 1.4rem; color: var(--pos-green); margin-bottom: 8px; }
	.cat-item span { font-size: .8rem; color: var(--pos-text); line-height: 1.2; display: block; }
	.cat-item:hover { border-color: #b7e4cf; background: #f0faf5; }
	.cat-item.active { background: var(--pos-green); border-color: var(--pos-green); box-shadow: 0 4px 12px rgba(15,138,95,.3); }
	.cat-item.active i, .cat-item.active span { color: #fff; }

	/* Produk */
	.prod-tools { display: flex; align-items: center; gap: 8px; }
	.prod-tools label { font-size: .82rem; color: var(--pos-muted); margin: 0; }
	.prod-tools select { border: 1px solid var(--pos-border); border-radius: 8px; padding: 6px 10px; font-size: .85rem; background: #fff; }
	.view-toggle { display: flex; border: 1px solid var(--pos-border); border-radius: 8px; overflow: hidden; }
	.view-toggle button { border: none; background: #fff; padding: 6px 11px; color: var(--pos-muted); }
	.view-toggle button.active { background: var(--pos-green); color: #fff; }

	.prod-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 12px; }
	.prod-card { border: 1px solid var(--pos-border); border-radius: 12px; padding: 12px; cursor: pointer; transition: all .15s; background: #fff; position: relative; }
	.prod-card:hover { border-color: #9fd9bf; box-shadow: 0 6px 16px rgba(15,138,95,.12); transform: translateY(-2px); }
	.prod-card.out { opacity: .55; cursor: not-allowed; }
	.prod-img { height: 96px; display: flex; align-items: center; justify-content: center; margin-bottom: 10px; }
	.prod-img img { max-height: 96px; max-width: 100%; object-fit: contain; }
	.prod-img .no-img { width: 72px; height: 72px; border-radius: 14px; background: #f1f5f4; color: #a3b3ad; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; }
	.prod-name { font-size: .9rem; font-weight: 600; color: var(--pos-text); line-height: 1.25; height: 2.5em; overflow: hidden; }
	.prod-price { font-size: 1rem; font-weight: 800; color: var(--pos-red); margin: 4px 0 8px; }
	.prod-stock { display: inline-block; font-size: .72rem; font-weight: 700; padding: 3px 10px; border-radius: 20px; background: var(--pos-green-soft); color: var(--pos-green); }
	.prod-stock.low { background: #fdecec; color: var(--pos-red); }
	.prod-add { position: absolute; top: 10px; right: 10px; width: 28px; height: 28px; border-radius: 50%; background: var(--pos-green); color: #fff; display: flex; align-items: center; justify-content: center; font-size: .75rem; opacity: 0; transition: opacity .15s; }
	.prod-card:hover .prod-add { opacity: 1; }

	.prod-grid.list { grid-template-columns: 1fr; gap: 8px; }
	.prod-grid.list .prod-card { display: flex; align-items: center; gap: 14px; padding: 8px 12px; }
	.prod-grid.list .prod-card:hover { transform: none; }
	.prod-grid.list .prod-img { height: 48px; width: 48px; margin: 0; flex-shrink: 0; }
	.prod-grid.list .prod-img img { max-height: 48px; }
	.prod-grid.list .prod-img .no-img { width: 44px; height: 44px; font-size: 1.1rem; }
	.prod-grid.list .prod-name { flex: 1; height: auto; }
	.prod-grid.list .prod-price { margin: 0; min-width: 110px; text-align: right; }
	.prod-grid.list .prod-add { position: static; opacity: 1; flex-shrink: 0; }
	.prod-empty { grid-column: 1 / -1; text-align: center; color: #9ca3af; padding: 40px 0; }
	.prod-empty i { font-size: 2rem; display: block; margin-bottom: 8px; }

	/* Panel kanan */
	.pos-side { position: sticky; top: 84px; }
	.side-label { display: flex; align-items: center; gap: 10px; font-weight: 700; color: var(--pos-text); font-size: .95rem; margin-bottom: 8px; }
	.side-label i { color: var(--pos-green); font-size: 1.1rem; }
	.pos-select { width: 100%; border: 1px solid #dfe4ea; border-radius: 10px; padding: 9px 12px; font-size: .92rem; background: #fff; }
	.btn-new-cust { border: 1px solid var(--pos-green); color: var(--pos-green); background: #fff; border-radius: 8px; padding: 4px 10px; font-size: .78rem; font-weight: 600; text-decoration: none; }
	.btn-new-cust:hover { background: var(--pos-green); color: #fff; }
	.pos-side .select2-container .select2-selection--single { height: 42px !important; border: 1px solid #dfe4ea !important; border-radius: 10px !important; }
	.pos-side .select2-container--default .select2-selection--single .select2-selection__rendered { line-height: 40px !important; }
	.pos-side .select2-container--default .select2-selection--single .select2-selection__arrow { height: 40px !important; }

	.cart-box { border: 1px solid var(--pos-border); border-radius: 12px; overflow: hidden; }
	.cart-scroll { max-height: 290px; overflow-y: auto; }
	#pos-cart { width: 100%; margin: 0; font-size: .85rem; }
	#pos-cart thead th { background: #f6f8fa; color: #4b5563; font-size: .72rem; text-transform: uppercase; font-weight: 700; padding: 10px 8px; position: sticky; top: 0; z-index: 1; white-space: nowrap; }
	#pos-cart tbody td { padding: 8px; border-top: 1px solid var(--pos-border); vertical-align: middle; }
	#pos-cart .cart-name { font-weight: 600; color: var(--pos-text); line-height: 1.2; }
	.prod-unit { font-size: .7rem; font-weight: 700; color: #0b6b4a; background: #e3f5ee; border-radius: 6px; padding: 1px 6px; white-space: nowrap; }
	.prod-cost { font-size: .72rem; font-weight: 500; color: #d93025; white-space: nowrap; }
	#pos-cart .cart-sub { font-size: .72rem; color: var(--pos-muted); }
	#pos-cart .cart-input { width: 100%; min-width: 50px; text-align: right; border: 1px solid #dfe4ea; border-radius: 6px; padding: 3px 6px; font-size: .82rem; }
	#pos-cart .cart-remove { border: none; background: none; color: var(--pos-red); padding: 0 4px; }
	.cart-empty { text-align: center; padding: 34px 16px; color: var(--pos-muted); }
	.cart-empty i { font-size: 2.4rem; color: #9ca3af; display: block; margin-bottom: 10px; }
	.cart-empty b { display: block; color: #6b7280; margin-bottom: 4px; }
	.cart-empty small { color: #9ca3af; }

	.sum-box { border: 1px solid var(--pos-border); border-radius: 12px; overflow: hidden; margin-top: 12px; }
	.sum-row { display: flex; justify-content: space-between; align-items: center; padding: 6px 16px; font-size: .92rem; color: var(--pos-text); }
	.sum-row:first-child { padding-top: 12px; }
	.sum-row span i { width: 22px; color: #6b7280; }
	.sum-row b { font-weight: 700; }
	.sum-total { background: var(--pos-green-soft); padding: 12px 16px; margin-top: 6px; display: flex; justify-content: space-between; align-items: center; }
	.sum-total span { font-weight: 700; font-size: 1.05rem; color: var(--pos-text); }
	.sum-total span i { color: var(--pos-green); margin-right: 8px; }
	.sum-total b { font-size: 1.5rem; font-weight: 800; color: var(--pos-green); }

	.pay-box { display: flex; border-top: 1px solid var(--pos-border); border-bottom: 1px solid var(--pos-border); margin: 14px -20px 12px; padding: 12px 20px; gap: 16px; }
	.pay-box .pay-left { flex: 1; min-width: 0; border-right: 1px solid var(--pos-border); padding-right: 16px; }
	.pay-box .pay-right { width: 40%; display: flex; flex-direction: column; justify-content: space-between; }
	.pay-box .pay-right #pos_change { white-space: nowrap; text-align: right; margin-top: auto; }
	.pay-label { font-size: .85rem; font-weight: 600; color: var(--pos-text); margin-bottom: 6px; }
	.pay-label i { color: var(--pos-green); margin-right: 6px; }
	#pos_pay { width: 100%; border: 1px solid #dfe4ea; border-radius: 8px; padding: 6px 10px; font-weight: 600; }
	#pos_pay:focus { outline: none; border-color: var(--pos-green); box-shadow: 0 0 0 3px rgba(15,138,95,.15); }
	.quick-cash { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 8px; }
	.quick-cash button { border: 1px solid #dfe4ea; background: #fff; border-radius: 6px; padding: 3px 10px; font-size: .78rem; color: #4b5563; }
	.quick-cash button[data-cash="exact"] { border-color: #9fd9bf; color: var(--pos-green); }
	.quick-cash button:hover { border-color: var(--pos-green); color: var(--pos-green); }
	#pos_change { font-size: 1.2rem; font-weight: 800; }
	.change-ok { color: var(--pos-green); }
	.change-minus { color: var(--pos-red); }

	.btn-pos-pay { background: linear-gradient(135deg, #0b6b4a, #0f8a5f); color: #fff; border: none; border-radius: 10px; padding: 12px; font-weight: 700; font-size: 1rem; width: 100%; }
	.btn-pos-pay:hover { color: #fff; filter: brightness(1.08); }
	.btn-pos-pay:disabled { opacity: .6; }
	.btn-pos-pay kbd { background: rgba(0,0,0,.25); border-radius: 5px; margin-left: 8px; font-size: .72rem; }
	.btn-pos-cancel { background: #fff; color: var(--pos-red); border: 1.5px solid var(--pos-red); border-radius: 10px; padding: 10px; font-weight: 700; width: 100%; }
	.btn-pos-cancel:hover { background: var(--pos-red); color: #fff; }

	@media (max-width: 767px) {
		.pay-box { flex-direction: column; }
		.pay-box .pay-left { border-right: none; padding-right: 0; }
		.pay-box .pay-right { width: 100%; }
	}
</style>

<div class="pos-wrapper">
<div class="container-fluid px-3 px-lg-4">
	<div class="row g-3">

		<!-- ===== KIRI ===== -->
		<div class="col-12 col-xl-7 col-xxl-8">

			<div class="pos-toolbar">
				<div class="pos-search">
					<i class="fas fa-search"></i>
					<input id="pos_search" type="text" placeholder="Ketik nama atau kode produk, lalu Enter..." autocomplete="off" autofocus>
					<button type="button" class="clear-search" id="clear_search"><i class="fas fa-times" style="position:static;transform:none;"></i></button>
				</div>
				<span class="pos-key" data-key="F2"><kbd>F2</kbd> Cari Produk</span>
				<span class="pos-key" data-key="F8"><kbd>F8</kbd> Bayar</span>
				<span class="pos-key" data-key="F9"><kbd>F9</kbd> Simpan</span>
			</div>

			<div class="pos-hero">
				<img src="<?php echo base_url(); ?>assets/banner_pos.png" alt="Point of Sale - Transaksi Lebih Cepat dan Mudah">
			</div>

			<div class="pos-card p-3 px-4 mb-3">
				<div class="d-flex justify-content-between align-items-center mb-3">
					<h5 class="pos-card-title"><i class="fas fa-layer-group"></i> Kategori</h5>
				</div>
				<div class="cat-list" id="cat_list">
					<div class="cat-item active" data-category="">
						<i class="fas fa-th-large"></i><span>Semua</span>
					</div>
					<?php foreach($data['category_list'] as $cat){ ?>
						<div class="cat-item" data-category="<?php echo $cat['category_id']; ?>">
							<i class="<?php echo pos_category_icon($cat['category_name']); ?>"></i>
							<span><?php echo htmlspecialchars(ucwords(strtolower($cat['category_name']))); ?></span>
						</div>
					<?php } ?>
				</div>
			</div>

			<div class="pos-card p-3 px-4">
				<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
					<h5 class="pos-card-title"><i class="fas fa-box-open"></i> Daftar Produk</h5>
					<div class="prod-tools">
						<label for="prod_sort">Urutkan</label>
						<select id="prod_sort">
							<option value="">Default</option>
							<option value="name">Nama A-Z</option>
							<option value="price_asc">Harga Termurah</option>
							<option value="price_desc">Harga Termahal</option>
							<option value="stock">Stok Terbanyak</option>
						</select>
						<div class="view-toggle">
							<button type="button" class="active" data-view="grid" title="Grid"><i class="fas fa-th-large"></i></button>
							<button type="button" data-view="list" title="List"><i class="fas fa-list"></i></button>
						</div>
					</div>
				</div>
				<div class="prod-grid" id="prod_grid"></div>
			</div>
		</div>

		<!-- ===== KANAN ===== -->
		<div class="col-12 col-xl-5 col-xxl-4">
			<div class="pos-card p-3 px-4 pos-side">

				<div class="d-flex justify-content-between align-items-center mb-2">
					<div class="side-label mb-0"><i class="fas fa-user"></i> Pelanggan</div>
					<a href="<?php echo base_url(); ?>Masterdata/customer" target="_blank" class="btn-new-cust"><i class="fas fa-plus-circle me-1"></i>Baru</a>
				</div>
				<select class="pos-select js-example-basic-single" id="sales_customer">
					<?php
					// default pelanggan = CASH, kalau tidak ada pakai yang pertama
					$default_customer = 0;
					foreach ($data['customer_list'] as $i => $row) {
						if (strtoupper(trim($row->customer_name)) == 'CASH') { $default_customer = $i; break; }
					}
					foreach ($data['customer_list'] as $i => $row) { ?>
						<option value="<?php echo $row->customer_id; ?>" <?php echo $i == $default_customer ? 'selected' : ''; ?>><?php echo htmlspecialchars($row->customer_name); ?></option>
					<?php } ?>
				</select>

				<div class="row g-3 mt-1 mb-3">
					<div class="col-6">
						<div class="side-label"><i class="fas fa-credit-card"></i> Metode Bayar</div>
						<select class="pos-select" id="sales_payment">
							<?php foreach ($data['payment_list'] as $i => $row) { ?>
								<option value="<?php echo $row->payment_id; ?>" <?php echo $i == 0 ? 'selected' : ''; ?>><?php echo htmlspecialchars($row->payment_name); ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="col-6">
						<div class="side-label"><i class="fas fa-tag"></i> Jenis Harga</div>
						<select class="pos-select" id="sales_price_type">
							<option value="Umum" selected>Umum</option>
							<option value="Toko">Toko</option>
							<option value="Sales">Sales</option>
							<option value="Khusus">Khusus</option>
							<option value="Hulu">Hulu</option>
						</select>
					</div>
				</div>

				<div class="cart-box">
					<div class="cart-scroll">
						<table id="pos-cart">
							<thead>
								<tr>
									<th>#</th>
									<th>Produk</th>
									<th class="text-end">Harga</th>
									<th class="text-center" style="width:62px;">Qty</th>
									<th class="text-end" style="width:84px;">Diskon</th>
									<th class="text-end">Total</th>
									<th></th>
								</tr>
							</thead>
							<tbody id="pos-cart-body"></tbody>
						</table>
					</div>
				</div>

				<div class="sum-box">
					<div class="sum-row"><span><i class="fas fa-shopping-cart"></i> Total Item</span><b id="sum_item">0</b></div>
					<div class="sum-row"><span><i class="fas fa-receipt"></i> Subtotal</span><b id="sum_subtotal">Rp 0</b></div>
					<div class="sum-row"><span><i class="fas fa-percent"></i> Diskon</span><b id="sum_discount">Rp 0</b></div>
					<div class="sum-total"><span><i class="fas fa-wallet"></i>Total Bayar</span><b id="pos_total_text">Rp 0</b></div>
				</div>

				<div class="pay-box">
					<div class="pay-left">
						<div class="pay-label"><i class="fas fa-money-bill-wave"></i>Uang Diterima</div>
						<input id="pos_pay" type="text" value="0">
						<div class="quick-cash">
							<button type="button" data-cash="exact">Uang Pas</button>
							<button type="button" data-cash="20000">20rb</button>
							<button type="button" data-cash="50000">50rb</button>
							<button type="button" data-cash="100000">100rb</button>
						</div>
					</div>
					<div class="pay-right">
						<div class="pay-label"><i class="fas fa-undo"></i>Kembalian</div>
						<span id="pos_change" class="change-ok">Rp 0</span>
					</div>
				</div>

				<div class="form-check mb-3">
					<input class="form-check-input" type="checkbox" id="pos_print" checked>
					<label class="form-check-label" for="pos_print">Cetak struk setelah simpan</label>
				</div>

				<button id="btn_pos_save" type="button" class="btn btn-pos-pay mb-2"><i class="fas fa-check-circle me-2"></i>Simpan &amp; Bayar <kbd>F9</kbd></button>
				<button id="btn_pos_cancel" type="button" class="btn btn-pos-cancel"><i class="fas fa-trash-alt me-2"></i>Batal / Kosongkan</button>
			</div>
		</div>

	</div>
</div>
</div>

<?php
require DOC_ROOT_PATH . $this->config->item('footer');
?>

<script>
	let cart = [];
	let products = [];
	let saving = false;
	let activeCategory = '';
	let searchTimer = null;
	let productRequest = null;

	let pos_pay = new AutoNumeric('#pos_pay', {
		currencySymbol : 'Rp ',
		decimalCharacter : ',',
		decimalPlaces: 0,
		decimalPlacesShownOnFocus: 0,
		digitGroupSeparator : '.',
		minimumValue: '0',
	});

	function rupiah(n)
	{
		n = parseInt(n) || 0;
		return (n < 0 ? '-' : '') + 'Rp ' + Math.abs(n).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
	}

	function escapeHtml(s)
	{
		return $('<div>').text(s == null ? '' : s).html();
	}

	/* ===== Daftar Produk ===== */

	function load_products(callback)
	{
		if(productRequest){ productRequest.abort(); }
		productRequest = $.ajax({
			url: '<?php echo base_url(); ?>Sales/pos_products',
			dataType: 'json',
			type: 'GET',
			data: {
				keyword: $.trim($('#pos_search').val()),
				category: activeCategory,
				sort: $('#prod_sort').val(),
				pricetype: $('#sales_price_type').val()
			},
			success: function(res){
				products = res.code == 200 ? res.data : [];
				render_products();
				if(callback) callback(products);
			}
		});
	}

	function render_products()
	{
		let html = '';
		if(products.length == 0){
			html = '<div class="prod-empty"><i class="fas fa-search"></i>Produk tidak ditemukan</div>';
		}
		products.forEach(function(p, i){
			let stock = parseInt(p.curent_stock) || 0;
			let img = p.image ? '<img src="'+p.image+'" alt="" loading="lazy">' : '<div class="no-img"><i class="fas fa-box"></i></div>';
			html += '<div class="prod-card'+(stock <= 0 ? ' out' : '')+'" data-index="'+i+'" title="'+escapeHtml(p.product_code)+'">'+
				'<div class="prod-img">'+img+'</div>'+
				'<div class="prod-name">'+escapeHtml(p.product_name)+' <span class="prod-unit">'+escapeHtml(p.unit_name)+(p.conv > 1 ? ' (isi '+p.conv+')' : '')+'</span> <span class="prod-cost">Modal: '+rupiah(p.modal)+'</span></div>'+
				'<div class="prod-price">'+rupiah(p.product_price)+'</div>'+
				'<span class="prod-stock'+(stock <= 5 ? ' low' : '')+'">Stok: '+stock+' '+escapeHtml(p.unit_name)+'</span>'+
				'<span class="prod-add"><i class="fas fa-plus"></i></span>'+
			'</div>';
		});
		$('#prod_grid').html(html);
	}

	$('#prod_grid').on('click', '.prod-card', function(){
		add_to_cart(products[$(this).data('index')]);
	});

	$('#cat_list').on('click', '.cat-item', function(){
		$('.cat-item').removeClass('active');
		$(this).addClass('active');
		activeCategory = $(this).data('category');
		load_products();
	});

	$('#prod_sort').on('change', function(){ load_products(); });

	$('.view-toggle button').click(function(){
		$('.view-toggle button').removeClass('active');
		$(this).addClass('active');
		$('#prod_grid').toggleClass('list', $(this).data('view') == 'list');
		try { localStorage.setItem('pos_view', $(this).data('view')); } catch(e) {}
	});

	$('#sales_price_type').on('change', function(){ load_products(); });

	/* ===== Pencarian ===== */

	$('#pos_search').on('input', function(){
		$('#clear_search').toggle($(this).val() != '');
		clearTimeout(searchTimer);
		searchTimer = setTimeout(function(){ load_products(); }, 300);
	});

	$('#clear_search').click(function(){
		$('#pos_search').val('').trigger('input').focus();
	});

	// Enter: tambah langsung kalau kode cocok persis / hasil cuma satu (untuk scanner barcode)
	$('#pos_search').on('keydown', function(e){
		if(e.key !== 'Enter') return;
		e.preventDefault();
		let term = $.trim($(this).val());
		if(term == '') return;
		clearTimeout(searchTimer);
		load_products(function(list){
			// satu kode punya beberapa entri (satuan terkecil + satuan besar): scan memilih satuan terkecil
			let exact = list.filter(function(p){ return String(p.product_code).toLowerCase() == term.toLowerCase(); });
			let found = null;
			if(exact.length > 0){
				found = exact.find(function(p){ return p.package_id == 0; }) || exact[0];
			}else if(list.length == 1){
				found = list[0];
			}
			if(found){
				add_to_cart(found);
				$('#pos_search').val('');
				$('#clear_search').hide();
				load_products();
			}else if(list.length == 0){
				Swal.fire({ icon: 'info', title: 'Produk Tidak Ditemukan', text: term });
			}
		});
	});

	/* ===== Keranjang ===== */

	function cart_subtotal()
	{
		let total = 0;
		cart.forEach(function(item){ total += item.price * item.qty; });
		return total;
	}

	function cart_discount()
	{
		let total = 0;
		cart.forEach(function(item){ total += item.discount; });
		return total;
	}

	function cart_total()
	{
		return cart_subtotal() - cart_discount();
	}

	// total satuan terkecil produk ini di keranjang, tidak menghitung baris yang dikecualikan
	function cart_base_used(product_id, except_item)
	{
		let used = 0;
		cart.forEach(function(item){
			if(item.product_id == product_id && item !== except_item) used += item.qty * item.conv;
		});
		return used;
	}

	function render_cart()
	{
		let html = '';
		if(cart.length == 0){
			html = '<tr><td colspan="7" class="cart-empty"><i class="fas fa-shopping-basket"></i><b>Keranjang masih kosong</b><small>Scan produk atau pilih dari daftar untuk memulai transaksi.</small></td></tr>';
		}
		cart.forEach(function(item, i){
			html += '<tr>'+
				'<td>'+(i + 1)+'</td>'+
				'<td><div class="cart-name">'+escapeHtml(item.product_name)+' <span class="prod-unit">'+escapeHtml(item.unit_name)+(item.conv > 1 ? ' (isi '+item.conv+')' : '')+'</span> <span class="prod-cost">Modal: '+rupiah(item.modal)+'</span></div><div class="cart-sub">Stok: '+Math.floor(item.stock / item.conv)+' '+escapeHtml(item.unit_name)+'</div></td>'+
				'<td class="text-end text-nowrap">'+rupiah(item.price)+'</td>'+
				'<td><input type="number" min="1" class="cart-input cart-qty" data-index="'+i+'" value="'+item.qty+'"></td>'+
				'<td><input type="number" min="0" class="cart-input cart-disc" data-index="'+i+'" value="'+item.discount+'"></td>'+
				'<td class="text-end fw-bold text-nowrap">'+rupiah(item.price * item.qty - item.discount)+'</td>'+
				'<td><button type="button" class="cart-remove" data-index="'+i+'" title="Hapus"><i class="fas fa-times"></i></button></td>'+
			'</tr>';
		});
		$('#pos-cart-body').html(html);

		let qty_count = 0;
		cart.forEach(function(item){ qty_count += item.qty; });
		$('#sum_item').text(qty_count);
		$('#sum_subtotal').text(rupiah(cart_subtotal()));
		$('#sum_discount').text(rupiah(cart_discount()));
		$('#pos_total_text').text(rupiah(cart_total()));
		$('#sales_price_type').prop('disabled', cart.length > 0);
		update_change();
	}

	function update_change()
	{
		let pay = parseInt(pos_pay.get()) || 0;
		// belum ada uang diterima: tampilkan 0, bukan minus
		let change = pay == 0 ? 0 : pay - cart_total();
		$('#pos_change').text(rupiah(change))
			.toggleClass('change-ok', change >= 0)
			.toggleClass('change-minus', change < 0);
	}

	function add_to_cart(product)
	{
		if(!product) return;
		let conv = parseInt(product.conv) || 1;
		let package_id = parseInt(product.package_id) || 0;
		let base_stock = parseInt(product.base_stock) || 0;
		let price = parseInt(product.product_price) || 0;
		if(price <= 0){
			Swal.fire({ icon: 'warning', title: 'Harga Belum Diatur', text: 'Produk ini belum punya harga '+$('#sales_price_type').val()+'.' });
			return;
		}
		// satu baris per produk + satuan; stok dihitung gabungan dalam satuan terkecil
		let existing = cart.find(function(item){ return item.product_id == product.id && item.package_id == package_id; });
		if(cart_base_used(product.id, null) + conv > base_stock){
			Swal.fire({ icon: 'warning', title: 'Stok Tidak Cukup', text: 'Sisa stok: '+Math.floor(base_stock / conv)+' '+product.unit_name });
			return;
		}
		if(existing){
			existing.qty += 1;
		}else{
			cart.push({
				product_id   : product.id,
				product_name : product.product_name,
				modal        : product.modal,
				price        : price,
				unit_name    : product.unit_name,
				package_id   : package_id,
				conv         : conv,
				qty          : 1,
				discount     : 0,
				stock        : base_stock
			});
		}
		render_cart();
	}

	$('#pos-cart-body').on('change', '.cart-qty', function(){
		let item = cart[$(this).data('index')];
		let qty = parseInt($(this).val()) || 1;
		if(qty < 1) qty = 1;
		let max_qty = Math.floor((item.stock - cart_base_used(item.product_id, item)) / item.conv);
		if(qty > max_qty){
			Swal.fire({ icon: 'warning', title: 'Stok Tidak Cukup', text: 'Sisa stok: '+item.stock+' '+item.unit_name });
			qty = max_qty;
		}
		item.qty = qty;
		if(item.discount > item.price * item.qty) item.discount = item.price * item.qty;
		render_cart();
	});

	$('#pos-cart-body').on('change', '.cart-disc', function(){
		let item = cart[$(this).data('index')];
		let disc = parseInt($(this).val()) || 0;
		if(disc < 0) disc = 0;
		if(disc > item.price * item.qty) disc = item.price * item.qty;
		item.discount = disc;
		render_cart();
	});

	$('#pos-cart-body').on('click', '.cart-remove', function(){
		cart.splice($(this).data('index'), 1);
		render_cart();
		$('#pos_search').focus();
	});

	/* ===== Pembayaran ===== */

	$('#pos_pay').on('input', update_change);

	$('.quick-cash button').click(function(){
		let cash = $(this).data('cash');
		if(cash == 'exact'){
			pos_pay.set(cart_total());
		}else{
			pos_pay.set((parseInt(pos_pay.get()) || 0) + parseInt(cash));
		}
		update_change();
	});

	function reset_pos()
	{
		cart = [];
		pos_pay.set(0);
		render_cart();
		$('#pos_search').val('').focus();
		$('#clear_search').hide();
		load_products();
	}

	function save_pos()
	{
		if(saving) return;
		let total = cart_total();
		let pay = parseInt(pos_pay.get()) || 0;

		if(cart.length == 0){
			Swal.fire({ icon: 'warning', title: 'Keranjang Kosong', text: 'Tambahkan produk terlebih dahulu.' });
			return;
		}
		if(pay == 0){
			pos_pay.set(total);
			pay = total;
			update_change();
		}
		if(pay < total){
			Swal.fire({ icon: 'warning', title: 'Uang Kurang', text: 'Uang diterima kurang '+rupiah(total - pay) });
			return;
		}

		let items = cart.map(function(item){
			return { product_id: item.product_id, product_name: item.product_name, package_id: item.package_id, price: item.price, qty: item.qty, discount: item.discount };
		});

		saving = true;
		$('#btn_pos_save').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>Sales/save_pos",
			dataType: "json",
			data: { sales_customer: $('#sales_customer').val(), sales_payment: $('#sales_payment').val(), items: JSON.stringify(items) },
			success : function(data){
				if (data.code == "200"){
					if($('#pos_print').is(':checked')){
						window.open("<?php echo base_url(); ?>Sales/printpos?sales_id="+data.sales_id+"&pay="+pay, "_blank", "width=420,height=640");
					}
					Swal.fire({
						icon: 'success',
						title: 'Transaksi Tersimpan',
						html: data.invoice+'<br><b>Kembalian: '+rupiah(pay - total)+'</b>',
						timer: 2500,
						showConfirmButton: false
					});
					reset_pos();
				} else {
					Swal.fire({ icon: 'error', title: 'Oops...', text: data.result });
				}
			},
			error: function(){
				Swal.fire({ icon: 'error', title: 'Oops...', text: 'Terjadi kesalahan koneksi' });
			},
			complete: function(){
				saving = false;
				$('#btn_pos_save').prop('disabled', false);
			}
		});
	}

	$('#btn_pos_save').click(function(e){
		e.preventDefault();
		save_pos();
	});

	$('#btn_pos_cancel').click(function(){
		if(cart.length == 0){ reset_pos(); return; }
		Swal.fire({
			title: 'Konfirmasi?',
			text: "Kosongkan keranjang?",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya, Kosongkan'
		}).then((result) => {
			if (result.isConfirmed) reset_pos();
		});
	});

	/* ===== Shortcut ===== */

	function run_shortcut(key)
	{
		if(key === 'F2'){ $('#pos_search').focus().select(); }
		if(key === 'F8'){ $('#pos_pay').focus().select(); }
		if(key === 'F9'){ save_pos(); }
	}

	$(document).on('keydown', function(e){
		if(['F2', 'F8', 'F9'].indexOf(e.key) >= 0){
			e.preventDefault();
			run_shortcut(e.key);
		}
	});

	$('.pos-key').click(function(){ run_shortcut($(this).data('key')); });

	window.addEventListener('beforeunload', function(e){
		if(cart.length > 0){ e.preventDefault(); e.returnValue = ''; }
	});

	try {
		if(localStorage.getItem('pos_view') == 'list'){ $('.view-toggle button[data-view="list"]').click(); }
	} catch(e) {}

	$('#sales_customer').select2({ width: '100%' });

	render_cart();
	load_products();
</script>
