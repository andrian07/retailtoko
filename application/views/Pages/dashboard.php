<?php 
define('DOC_ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].'/');
require DOC_ROOT_PATH . $this->config->item('header');
?>
</div>

<style>
/* ===== Dashboard Custom Styles ===== */
.dash-hero {
	background: linear-gradient(135deg, #1a73e8 0%, #0d47a1 100%);
	border-radius: 16px;
	padding: 28px 32px;
	color: #fff;
	margin-bottom: 24px;
	position: relative;
	overflow: hidden;
}
.dash-hero::after {
	content: '';
	position: absolute;
	right: -40px; top: -40px;
	width: 220px; height: 220px;
	background: rgba(255,255,255,0.07);
	border-radius: 50%;
}
.dash-hero h3 { font-size: 1.7rem; font-weight: 700; margin-bottom: 4px; }
.dash-hero p  { margin: 0; opacity: .85; font-size: .92rem; }
.dash-hero .badge-branch {
	background: rgba(255,255,255,0.2);
	border: 1px solid rgba(255,255,255,0.35);
	color: #fff;
	padding: 6px 16px;
	border-radius: 20px;
	font-size: .85rem;
	font-weight: 600;
	backdrop-filter: blur(4px);
}

/* Stat cards */
.stat-card {
	border: none;
	border-radius: 14px;
	overflow: hidden;
	box-shadow: 0 4px 20px rgba(0,0,0,0.08);
	transition: transform .2s, box-shadow .2s;
}
.stat-card:hover { transform: translateY(-4px); box-shadow: 0 8px 28px rgba(0,0,0,0.13); }
.stat-card .card-body { padding: 22px 24px; }
.stat-card .stat-icon {
	width: 52px; height: 52px;
	border-radius: 12px;
	display: flex; align-items: center; justify-content: center;
	font-size: 1.4rem;
	flex-shrink: 0;
}
.stat-card .stat-label { font-size: .75rem; font-weight: 600; text-transform: uppercase; letter-spacing: .06em; opacity: .7; margin-bottom: 4px; }
.stat-card .stat-value { font-size: 1.45rem; font-weight: 800; line-height: 1.1; margin-bottom: 12px; }
.stat-card .stat-meta { font-size: 1rem; color: #6c757d; }
.stat-card .stat-meta span { font-weight: 600; color: inherit; }

.bg-soft-blue   { background: #e8f1fd; color: #1a73e8; }
.bg-soft-green  { background: #e6f4ea; color: #1e8f35; }
.bg-soft-orange { background: #fff3e0; color: #e65100; }
.text-blue  { color: #1a73e8 !important; }
.text-green { color: #1e8f35 !important; }
.text-orange{ color: #e65100 !important; }

/* Section panels */
.panel-card {
	border: none;
	border-radius: 14px;
	box-shadow: 0 2px 16px rgba(0,0,0,0.07);
}
.panel-card .card-header {
	background: transparent;
	border-bottom: 1px solid #f0f0f0;
	padding: 16px 20px 12px;
	font-weight: 700;
	font-size: .95rem;
	display: flex; align-items: center; justify-content: space-between;
}
.panel-card .card-header .header-badge {
	font-size: .78rem; font-weight: 600;
	padding: 3px 10px; border-radius: 20px;
}
.panel-card .card-body { padding: 16px 20px; }

/* Activity feed redesign */
.activity-list { list-style: none; padding: 0; margin: 0; }
.activity-list li {
	display: flex; gap: 12px; align-items: flex-start;
	padding: 10px 0;
	border-bottom: 1px solid #f5f5f5;
}
.activity-list li:last-child { border-bottom: none; }
.activity-dot {
	width: 36px; height: 36px; border-radius: 50%;
	display: flex; align-items: center; justify-content: center;
	font-size: .85rem; flex-shrink: 0; margin-top: 1px;
}
.activity-dot.danger  { background: #fde8e8; color: #e53935; }
.activity-dot.primary { background: #e3f2fd; color: #1a73e8; }
.activity-info .ai-time  { font-size: .80rem; color: #9e9e9e; margin-bottom: 2px; }
.activity-info .ai-text  { font-size: .95rem; color: #424242; line-height: 1.45; }
.activity-info .ai-text a { font-weight: 600; color: #1a73e8; text-decoration: none; }

/* Top products */
.top-product-item {
	display: flex; align-items: center; gap: 12px;
	padding: 9px 0; border-bottom: 1px solid #f5f5f5;
}
.top-product-item:last-child { border-bottom: none; }
.product-rank {
	width: 28px; height: 28px; border-radius: 8px;
	display: flex; align-items: center; justify-content: center;
	font-size: .78rem; font-weight: 700; flex-shrink: 0;
}
.rank-1 { background: #fff8e1; color: #f9a825; }
.rank-2 { background: #f3f3f3; color: #757575; }
.rank-3 { background: #fbe9e7; color: #e64a19; }
.rank-other { background: #f0f4ff; color: #3d5afe; }
.product-info { flex: 1; min-width: 0; }
.product-info .pname { font-size: .95rem; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-bottom: 1px; }
.product-info .pcode { font-size: .90rem; color: #9e9e9e; }
.product-qty { font-size: 1rem; font-weight: 700; color: #1a73e8; white-space: nowrap; }

/* Overdue invoices */
.faktur-item {
	display: flex; align-items: center; gap: 12px;
	padding: 9px 0; border-bottom: 1px solid #f5f5f5;
}
.faktur-item:last-child { border-bottom: none; }
.faktur-icon {
	width: 36px; height: 36px; border-radius: 10px;
	background: #fde8e8; color: #e53935;
	display: flex; align-items: center; justify-content: center;
	font-size: .9rem; flex-shrink: 0;
}
.faktur-info { flex: 1; min-width: 0; }
.faktur-info .finv  { font-size: .83rem; font-weight: 700; color: #212121; }
.faktur-info .ftotal{ font-size: .78rem; color: #e53935; font-weight: 600; margin-top: 1px; }
.faktur-date { font-size: .72rem; color: #9e9e9e; white-space: nowrap; }

/* Note textarea */
.note-area {
	border: 1.5px solid #e0e0e0;
	border-radius: 10px;
	resize: none;
	font-size: .88rem;
	padding: 12px 14px;
	transition: border-color .2s;
}
.note-area:focus { border-color: #1a73e8; box-shadow: 0 0 0 3px rgba(26,115,232,.1); outline: none; }
</style>

<div class="container">
	<div class="page-inner">

		<!-- ===== Hero Header ===== -->
		<div class="dash-hero d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
			<div>
				<h3 class="mb-1"><i class="fas fa-chart-pie me-2"></i>Dashboard</h3>
				<p><i class="far fa-calendar-alt me-1"></i><?php echo date('l, d F Y'); ?></p>
			</div>
			<span class="badge-branch">
				<i class="fas fa-store me-1"></i>Pionir
			</span>
		</div>

		<!-- ===== Stat Cards ===== -->
		<div class="row g-3 mb-4">
			<!-- Penjualan Hari Ini -->
			<div class="col-12 col-sm-6 col-xl-4">
				<div class="card stat-card h-100">
					<div class="card-body">
						<div class="d-flex align-items-center gap-3 mb-3">
							<div class="stat-icon bg-soft-blue">
								<i class="fas fa-shopping-cart text-blue"></i>
							</div>
							<div>
								<div class="stat-label text-blue">Penjualan Hari Ini</div>
								<div class="stat-value text-blue">Rp <?php echo number_format($data['get_transaction_today'][0]['total_today'] ?? 0); ?></div>
							</div>
						</div>
						<div class="d-flex justify-content-between stat-meta">
							<div><i class="fas fa-receipt me-1"></i>Transaksi</div>
							<span><?php echo number_format($data['get_transaction_today'][0]['total_transaction'] ?? 0); ?> kali</span>
						</div>
						<div class="d-flex justify-content-between stat-meta mt-1">
							<div><i class="fas fa-boxes me-1"></i>Barang Terjual</div>
							<span><?php echo number_format($data['get_transaction_today_item'][0]['total_item'] ?? 0); ?> item</span>
						</div>
					</div>
				</div>
			</div>

			<!-- Penjualan Bulan Ini -->
			<div class="col-12 col-sm-6 col-xl-4">
				<div class="card stat-card h-100">
					<div class="card-body">
						<div class="d-flex align-items-center gap-3 mb-3">
							<div class="stat-icon bg-soft-green">
								<i class="fas fa-chart-line text-green"></i>
							</div>
							<div>
								<div class="stat-label text-green">Penjualan Bulan Ini</div>
								<div class="stat-value text-green">Rp <?php echo number_format($data['get_transaction_month'][0]['total_month'] ?? 0); ?></div>
							</div>
						</div>
						<div class="d-flex justify-content-between stat-meta">
							<div><i class="fas fa-receipt me-1"></i>Transaksi</div>
							<span><?php echo number_format($data['get_transaction_month'][0]['total_transaction'] ?? 0); ?> kali</span>
						</div>
						<div class="d-flex justify-content-between stat-meta mt-1">
							<div><i class="fas fa-boxes me-1"></i>Barang Terjual</div>
							<span><?php echo number_format($data['get_transaction_month_item'][0]['total_item'] ?? 0); ?> item</span>
						</div>
					</div>
				</div>
			</div>

			<!-- Total Aset -->
			<div class="col-12 col-sm-6 col-xl-4">
				<div class="card stat-card h-100">
					<div class="card-body">
						<div class="d-flex align-items-center gap-3 mb-3">
							<div class="stat-icon bg-soft-orange">
								<i class="fas fa-warehouse text-orange"></i>
							</div>
							<div>
								<div class="stat-label text-orange">Total Aset Stok</div>
								<div class="stat-value text-orange">Rp <?php echo number_format($data['get_total_asset'][0]['total_omzet'] ?? 0); ?></div>
							</div>
						</div>
						<div class="d-flex justify-content-between stat-meta">
							<div><i class="fas fa-cubes me-1"></i>Jumlah Item Stok</div>
							<span><?php echo number_format($data['get_total_asset_item'][0]['total_item'] ?? 0); ?> item</span>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- ===== Middle Row: Catatan | Aktifitas Terakhir | Aktifitas Mendatang ===== -->
		<div class="row g-3 mb-4">

			<!-- Aktifitas Terakhir -->
			<div class="col-md-4">
				<div class="card panel-card h-100">
					<div class="card-header">
						<span><i class="fas fa-history me-2 text-danger"></i>Aktifitas Terakhir</span>
						<span class="header-badge bg-danger bg-opacity-10" style="color:#ffffff;"><?php echo date('d M'); ?></span>
					</div>
					<div class="card-body" style="max-height:320px;overflow-y:auto;">
						<ul class="activity-list">
							<?php foreach($data['get_last_activity'] as $row_last_asctivity){ ?>
								<li>
									<div class="activity-dot danger"><i class="fas fa-bolt"></i></div>
									<div class="activity-info">
										<div class="ai-time"><i class="far fa-clock me-1"></i><?php echo date('d M, H:i', strtotime($row_last_asctivity['created_at'])) ?></div>
										<div class="ai-text">
											<?php 
											$string = $row_last_asctivity['activity_table_desc'];
											$result = explode('Ref:', $string)[0];
											echo trim($result);
											?>
											<a href="#">"<?php echo $row_last_asctivity['activity_table_ref'] ?>"</a>
										</div>
									</div>
								</li>
							<?php } ?>
						</ul>
					</div>
				</div>
			</div>

			<!-- Aktifitas Mendatang -->
			<div class="col-md-4">
				<div class="card panel-card h-100">
					<div class="card-header">
						<span><i class="fas fa-calendar-check me-2 text-primary"></i>Aktifitas Mendatang</span>
						<span class="header-badge bg-primary bg-opacity-10" style="color:#ffffff;"><?php echo date('d M', strtotime('+1 day')); ?></span>
					</div>
					<div class="card-body" style="max-height:320px;overflow-y:auto;">
						<ul class="activity-list">
							<?php foreach($data['get_next_activity'] as $row_next_activity){ ?>
								<li>
									<div class="activity-dot primary"><i class="fas fa-clock"></i></div>
									<div class="activity-info">
										<div class="ai-time"><i class="far fa-calendar me-1"></i><?php echo date('d M', strtotime($row_next_activity['due_date'])) ?></div>
										<div class="ai-text">
											<?php if($row_next_activity['keterangan'] == 'purchase'){ ?>
												Jatuh Tempo <span style="color:#e65100;font-weight:600;">Pembelian</span><br>
											<?php }else{ ?>
												Jatuh Tempo <span style="color:#1a73e8;font-weight:600;">Penjualan</span><br>
											<?php } ?>
											<a href="#">"<?php echo $row_next_activity['inv']; ?>"</a>
										</div>
									</div>
								</li>
							<?php } ?>
						</ul>
					</div>
				</div>
			</div>

			<div class="col-md-4">
				<div class="card panel-card h-100">
					<div class="card-header">
						<span><i class="fas fa-trophy me-2 text-warning"></i>Top Produk Terjual &ndash; 3 Bulan</span>
					</div>
					<div class="card-body">
						<?php $rank = 1; foreach($data['top_product_3_month'] as $row_3){ ?>
							<div class="top-product-item">
								<div class="product-rank <?php 
								if($rank==1) echo 'rank-1';
								elseif($rank==2) echo 'rank-2';
								elseif($rank==3) echo 'rank-3';
								else echo 'rank-other';
							?>">#<?php echo $rank; ?></div>
							<div class="product-info">
								<div class="pname"><?php echo $row_3['product_name']; ?></div>
								<div class="pcode"><?php echo $row_3['product_code']; ?></div>
							</div>
							<div class="product-qty"><?php echo number_format($row_3['total_transaction']); ?> item</div>
						</div>
						<?php $rank++; } ?>
					</div>
				</div>
			</div>
		</div>

		<!-- ===== Bottom Row: Top Products | Faktur Terlewat ===== -->
		<div class="row g-3 mb-4">
			<!-- Faktur Terlewat -->
			<div class="col-md-8">
				<div class="card panel-card">
					<div class="card-header">
						<span><i class="fas fa-exclamation-triangle me-2 text-danger"></i>Faktur Terlewat</span>
						<span class="header-badge bg-danger bg-opacity-10" style="color:#ffffff;"><?php echo count($data['lost_faktur']); ?> faktur</span>
					</div>
					<div class="card-body" style="max-height:380px;overflow-y:auto;">
						<?php foreach($data['lost_faktur'] as $row_lost_faktur){ ?>
							<div class="faktur-item">
								<div class="faktur-icon"><i class="fas fa-file-invoice-dollar"></i></div>
								<div class="faktur-info">
									<div class="finv"><?php echo $row_lost_faktur['hd_sales_inv']; ?></div>
									<div class="ftotal">Rp <?php echo number_format($row_lost_faktur['hd_sales_remaining_debt']); ?></div>
								</div>
								<div class="faktur-date">
									<i class="far fa-calendar me-1"></i><?php echo date('d-m-Y', strtotime($row_lost_faktur['hd_sales_due_date'])) ?>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>

		</div><!-- /bottom row -->

	</div>
</div>

<?php 
require DOC_ROOT_PATH . $this->config->item('footer');
?>
<script>
	$('#save_note').click(function(e){
		e.preventDefault();
		var comment  = $("#comment").val();
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>Dashboard/save_comment",
			dataType: "json",
			data: {comment:comment},
			success : function(data){
				if (data.code == "200"){
					window.location.href = "<?php echo base_url(); ?>/Dashboard/Admin";
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
</script>
