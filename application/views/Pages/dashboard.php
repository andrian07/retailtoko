<?php
define('DOC_ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].'/');
require DOC_ROOT_PATH . $this->config->item('header');

$dash = $data['dashboard'];

function dash_rp($n){ return 'Rp '.number_format((float) $n, 0, ',', '.'); }
function dash_growth_badge($g){
	if($g === null) return '';
	$up = $g >= 0;
	return '<span class="dash-trend '.($up ? 'up' : 'down').'"><i class="fas fa-chevron-'.($up ? 'up' : 'down').'"></i> '.($up ? '+' : '').$g.'%</span>';
}
function dash_product_img($image){
	if($image != '' && file_exists(FCPATH.'assets/products/'.$image)){
		return base_url().'assets/products/'.$image;
	}
	return null;
}
$bulan = array('January'=>'Januari','February'=>'Februari','March'=>'Maret','April'=>'April','May'=>'Mei','June'=>'Juni','July'=>'Juli','August'=>'Agustus','September'=>'September','October'=>'Oktober','November'=>'November','December'=>'Desember');
$hari  = array('Monday'=>'Senin','Tuesday'=>'Selasa','Wednesday'=>'Rabu','Thursday'=>'Kamis','Friday'=>'Jumat','Saturday'=>'Sabtu','Sunday'=>'Minggu');
$today_text = $hari[date('l')].', '.date('j').' '.$bulan[date('F')].' '.date('Y');
?>
</div>

<style>
	:root {
		--dash-green: #0f8a5f;
		--dash-green-dark: #0b6b4a;
		--dash-green-soft: #e3f5ee;
		--dash-orange: #f07f1a;
		--dash-orange-soft: #fff1e3;
		--dash-red: #e5484d;
		--dash-red-soft: #fdecec;
		--dash-blue: #2f6fed;
		--dash-blue-soft: #e8f0fe;
		--dash-purple: #7c4dff;
		--dash-purple-soft: #efe9ff;
		--dash-text: #1f2937;
		--dash-muted: #6b7280;
		--dash-border: #eef0f3;
	}
	.dash-page { background: #f3f5f8; }
	.dash-page .page-inner { padding-top: 20px; }

	/* Hero */
	.dash-hero { position: relative; overflow: hidden; border-radius: 16px; padding: 26px 30px; margin-bottom: 18px; color: #fff; background: linear-gradient(120deg, #0b6b4a 0%, #0f8a5f 55%, #13a36f 100%); box-shadow: 0 8px 24px rgba(11,107,74,.18); }
	.dash-hero::before, .dash-hero::after { content: ''; position: absolute; border-radius: 50%; background: rgba(255,255,255,.07); }
	.dash-hero::before { width: 260px; height: 260px; right: 120px; top: -120px; }
	.dash-hero::after { width: 200px; height: 200px; right: -40px; bottom: -110px; }
	.dash-hero h3 { font-size: 1.8rem; font-weight: 700; margin: 0 0 6px; display: flex; align-items: center; gap: 12px; }
	.dash-hero p { margin: 0; opacity: .9; font-size: 1rem; display: flex; align-items: center; gap: 8px; }
	.dash-hero .hero-store { position: absolute; right: 190px; bottom: 0; font-size: 5.5rem; color: rgba(255,255,255,.18); line-height: 1; }
	.dash-hero .badge-branch { position: relative; z-index: 1; background: rgba(255,255,255,.14); border: 1px solid rgba(255,255,255,.35); color: #fff; padding: 9px 20px; border-radius: 24px; font-weight: 700; letter-spacing: .5px; }

	/* Cards */
	.dash-card { background: #fff; border: 1px solid var(--dash-border); border-radius: 14px; box-shadow: 0 2px 10px rgba(16,24,40,.04); height: 100%; }
	.dash-card-header { display: flex; align-items: center; justify-content: space-between; gap: 10px; padding: 16px 20px 10px; }
	.dash-card-header h5 { margin: 0; font-size: 1.02rem; font-weight: 700; color: var(--dash-text); display: flex; align-items: center; gap: 10px; }
	.dash-card-header a.see-all { font-size: .82rem; color: var(--dash-green); text-decoration: none; font-weight: 500; white-space: nowrap; }
	.dash-card-body { padding: 4px 20px 16px; }
	.dash-empty { text-align: center; color: #9ca3af; padding: 28px 0; font-size: .9rem; }
	.dash-empty i { display: block; font-size: 1.6rem; margin-bottom: 8px; opacity: .6; }

	/* Stat cards */
	.stat-top { display: flex; align-items: flex-start; gap: 16px; padding-bottom: 14px; border-bottom: 1px solid var(--dash-border); margin-bottom: 10px; }
	.stat-icon { width: 58px; height: 58px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; flex-shrink: 0; }
	.stat-label { font-size: .78rem; font-weight: 600; text-transform: uppercase; letter-spacing: .04em; color: #4b5563; margin-bottom: 2px; }
	.stat-value { font-size: 1.65rem; font-weight: 800; line-height: 1.15; }
	.stat-row { display: flex; justify-content: space-between; align-items: center; font-size: .95rem; color: #374151; padding: 4px 0; }
	.stat-row i { color: #9ca3af; width: 20px; }
	.stat-row b { font-weight: 700; }
	.dash-trend { margin-left: auto; font-size: .8rem; font-weight: 700; padding: 5px 10px; border-radius: 20px; white-space: nowrap; }
	.dash-trend.up { background: var(--dash-green-soft); color: var(--dash-green); }
	.dash-trend.down { background: var(--dash-red-soft); color: var(--dash-red); }
	.soft-green { background: var(--dash-green-soft); color: var(--dash-green); }
	.soft-orange { background: var(--dash-orange-soft); color: var(--dash-orange); }
	.soft-red { background: var(--dash-red-soft); color: var(--dash-red); }
	.soft-blue { background: var(--dash-blue-soft); color: var(--dash-blue); }
	.soft-purple { background: var(--dash-purple-soft); color: var(--dash-purple); }
	.soft-gray { background: #f1f3f5; color: #6b7280; }
	.txt-green { color: var(--dash-green); }
	.txt-orange { color: var(--dash-orange); }

	/* Activity */
	.act-item { display: flex; gap: 14px; padding: 11px 0; border-bottom: 1px solid var(--dash-border); }
	.act-item:last-child { border-bottom: none; }
	.act-icon { width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: .95rem; }
	.act-info { flex: 1; min-width: 0; }
	.act-time { font-size: .75rem; color: #9ca3af; }
	.act-desc { font-size: .9rem; color: var(--dash-text); line-height: 1.35; }
	.act-inv { font-size: .8rem; color: var(--dash-blue); word-break: break-all; }
	.act-amount { font-size: .88rem; font-weight: 700; color: var(--dash-green); white-space: nowrap; }

	/* Chart */
	.chart-select { border: 1px solid #e5e7eb; border-radius: 8px; padding: 5px 10px; font-size: .82rem; color: #374151; background: #fff; }
	.chart-kpi { display: flex; align-items: center; gap: 10px; border: 1px solid var(--dash-border); border-radius: 12px; padding: 10px 12px; flex: 1; min-width: 0; }
	.chart-kpi .k-icon { width: 38px; height: 38px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
	.chart-kpi .k-label { font-size: .75rem; color: var(--dash-muted); }
	.chart-kpi .k-value { font-size: 1rem; font-weight: 700; color: var(--dash-text); white-space: nowrap; }
	.chart-kpi .dash-trend { margin-left: 6px; font-size: .7rem; padding: 3px 7px; }
	.chart-wrap { position: relative; height: 230px; margin-top: 14px; }
	.chart-legend { display: flex; justify-content: center; gap: 22px; font-size: .8rem; color: #4b5563; margin-top: 8px; }
	.chart-legend span::before { content: ''; display: inline-block; width: 10px; height: 10px; border-radius: 50%; margin-right: 6px; vertical-align: middle; }
	.chart-legend .lg-sales::before { background: #a7e3c8; }
	.chart-legend .lg-trx::before { background: var(--dash-green); }

	/* Top product */
	.top-item { display: flex; align-items: center; gap: 12px; padding: 9px 0; }
	.top-rank { width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: .8rem; font-weight: 700; flex-shrink: 0; background: #f1f3f5; color: #4b5563; }
	.top-rank.r1 { background: #fff4d6; color: #d99a00; border: 1px solid #f6d77a; }
	.top-rank.r3 { background: #ffe9dc; color: #e0701f; border: 1px solid #f7c3a0; }
	.top-img { width: 46px; height: 46px; border-radius: 10px; object-fit: cover; flex-shrink: 0; border: 1px solid var(--dash-border); background: #f8fafc; display: flex; align-items: center; justify-content: center; color: #9ca3af; }
	.top-info { flex: 1; min-width: 0; }
	.top-name { display: flex; justify-content: space-between; gap: 8px; font-size: .88rem; font-weight: 700; color: var(--dash-text); }
	.top-name span:first-child { white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
	.top-name span:last-child { white-space: nowrap; }
	.top-cat { font-size: .75rem; color: var(--dash-muted); margin-bottom: 4px; }
	.top-bar { height: 5px; border-radius: 5px; background: #eef0f3; overflow: hidden; }
	.top-bar div { height: 100%; background: var(--dash-green); border-radius: 5px; }

	/* Overdue */
	.od-item { display: flex; align-items: center; gap: 14px; padding: 12px 0; border-bottom: 1px solid var(--dash-border); }
	.od-item:last-child { border-bottom: none; }
	.od-icon { width: 38px; height: 38px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
	.od-info { flex: 1; min-width: 0; }
	.od-inv { font-size: .92rem; font-weight: 600; color: var(--dash-text); word-break: break-all; }
	.od-date { font-size: .78rem; color: var(--dash-muted); }
	.od-right { text-align: right; }
	.od-amount { font-size: .95rem; font-weight: 700; color: var(--dash-red); }
	.od-late { display: inline-block; margin-top: 4px; font-size: .72rem; font-weight: 600; padding: 3px 10px; border-radius: 20px; background: var(--dash-red-soft); color: var(--dash-red); }

	/* Low stock */
	.ls-table { width: 100%; font-size: .85rem; }
	.ls-table th { font-size: .72rem; text-transform: uppercase; color: #4b5563; font-weight: 700; padding: 7px 8px; background: #f8fafc; border-bottom: 1px solid var(--dash-border); }
	.ls-table td { padding: 7px 8px; border-bottom: 1px solid var(--dash-border); color: var(--dash-text); vertical-align: middle; }
	.ls-table tr:last-child td { border-bottom: none; }
	.ls-table .ls-img { width: 26px; height: 26px; border-radius: 6px; object-fit: cover; margin-right: 8px; background: #f8fafc; display: inline-flex; align-items: center; justify-content: center; color: #9ca3af; font-size: .7rem; vertical-align: middle; }
	.ls-stock { color: var(--dash-red); font-weight: 700; }

	/* sidebar terbuka membuat area konten lebih sempit */
	.stat-value { font-size: clamp(1.15rem, 1.5vw, 1.65rem); white-space: nowrap; }
	.chart-kpi-row { display: flex; flex-wrap: wrap; gap: 8px; }
	.chart-kpi { flex: 1 1 150px; }
	.chart-kpi .k-value { display: flex; flex-wrap: wrap; align-items: center; gap: 4px; white-space: normal; font-size: .95rem; }
	.chart-kpi .k-value span:first-child { white-space: nowrap; }
	.chart-kpi .dash-trend { margin-left: 0; }

	@media (max-width: 767px) {
		.dash-hero { padding: 20px; }
		.dash-hero .hero-store { display: none; }
		.stat-value { font-size: 1.35rem; }
	}
</style>

<div class="container dash-page">
	<div class="page-inner">

		<!-- ===== Hero ===== -->
		<div class="dash-hero d-flex align-items-center justify-content-between flex-wrap gap-3">
			<div style="position:relative;z-index:1;">
				<h3><i class="fas fa-chart-pie"></i> Dashboard</h3>
				<p><i class="far fa-calendar-alt"></i> <?php echo $today_text; ?></p>
			</div>
			<i class="fas fa-store hero-store"></i>
			<span class="badge-branch"><i class="fas fa-cart-plus me-2"></i>TOKO</span>
		</div>

		<!-- ===== Stat Cards ===== -->
		<div class="row g-3 mb-3">
			<div class="col-12 col-md-6 col-xl-4">
				<div class="dash-card p-3 px-4">
					<div class="stat-top">
						<div class="stat-icon soft-green"><i class="fas fa-shopping-cart"></i></div>
						<div>
							<div class="stat-label">Penjualan Hari Ini</div>
							<div class="stat-value txt-green"><?php echo dash_rp($dash['today']['total']); ?></div>
						</div>
						<?php echo dash_growth_badge($dash['today']['growth']); ?>
					</div>
					<div class="stat-row"><span><i class="fas fa-receipt"></i> Transaksi</span><b><?php echo number_format($dash['today']['trx'], 0, ',', '.'); ?> kali</b></div>
					<div class="stat-row"><span><i class="fas fa-box"></i> Barang Terjual</span><b><?php echo number_format($dash['today']['qty'], 0, ',', '.'); ?> item</b></div>
				</div>
			</div>
			<div class="col-12 col-md-6 col-xl-4">
				<div class="dash-card p-3 px-4">
					<div class="stat-top">
						<div class="stat-icon soft-green"><i class="fas fa-chart-bar"></i></div>
						<div>
							<div class="stat-label">Penjualan Bulan Ini</div>
							<div class="stat-value txt-green"><?php echo dash_rp($dash['month']['total']); ?></div>
						</div>
						<?php echo dash_growth_badge($dash['month']['growth']); ?>
					</div>
					<div class="stat-row"><span><i class="fas fa-receipt"></i> Transaksi</span><b><?php echo number_format($dash['month']['trx'], 0, ',', '.'); ?> kali</b></div>
					<div class="stat-row"><span><i class="fas fa-box"></i> Barang Terjual</span><b><?php echo number_format($dash['month']['qty'], 0, ',', '.'); ?> item</b></div>
				</div>
			</div>
			<div class="col-12 col-md-12 col-xl-4">
				<div class="dash-card p-3 px-4">
					<div class="stat-top">
						<div class="stat-icon soft-orange"><i class="fas fa-box-open"></i></div>
						<div>
							<div class="stat-label txt-orange">Total Aset Stok</div>
							<div class="stat-value txt-orange"><?php echo dash_rp($dash['asset']['asset']); ?></div>
						</div>
					</div>
					<div class="stat-row"><span><i class="fas fa-cubes"></i> Jumlah Item Stok</span><b><?php echo number_format($dash['asset']['qty'], 0, ',', '.'); ?> item</b></div>
				</div>
			</div>
		</div>

		<!-- ===== Middle Row ===== -->
		<div class="row g-3 mb-3">

			<!-- Aktifitas Terakhir -->
			<div class="col-12 col-lg-6 col-xxl-4">
				<div class="dash-card">
					<div class="dash-card-header">
						<h5><i class="fas fa-history" style="color:var(--dash-red);"></i> Aktifitas Terakhir</h5>
					</div>
					<div class="dash-card-body">
						<?php if(empty($dash['activity'])){ ?>
							<div class="dash-empty"><i class="far fa-clock"></i>Belum ada aktifitas</div>
						<?php } ?>
						<?php foreach($dash['activity'] as $act){ ?>
							<div class="act-item">
								<div class="act-icon soft-<?php echo $act['color']; ?>"><i class="<?php echo $act['icon']; ?>"></i></div>
								<div class="act-info">
									<div class="act-time"><?php echo date('d M Y H:i', strtotime($act['time'])); ?></div>
									<div class="act-desc"><?php echo htmlspecialchars($act['desc']); ?></div>
									<?php if($act['inv'] != ''){ ?><div class="act-inv"><?php echo htmlspecialchars($act['inv']); ?></div><?php } ?>
								</div>
								<?php if($act['amount'] !== null){ ?>
									<div class="act-amount"><?php echo dash_rp($act['amount']); ?></div>
								<?php } ?>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>

			<!-- Ringkasan Penjualan -->
			<div class="col-12 col-lg-6 col-xxl-4">
				<div class="dash-card">
					<div class="dash-card-header">
						<h5><i class="fas fa-chart-bar txt-green"></i> Ringkasan Penjualan</h5>
						<select id="chart_range" class="chart-select">
							<option value="7">7 Hari Terakhir</option>
							<option value="30">30 Hari Terakhir</option>
						</select>
					</div>
					<div class="dash-card-body">
						<div class="chart-kpi-row">
							<div class="chart-kpi">
								<div class="k-icon soft-green"><i class="fas fa-calendar-check"></i></div>
								<div style="min-width:0;">
									<div class="k-label">Total Penjualan</div>
									<div class="k-value"><span id="chart_sum"></span><span id="chart_growth"></span></div>
								</div>
							</div>
							<div class="chart-kpi">
								<div class="k-icon soft-blue"><i class="fas fa-calendar-alt"></i></div>
								<div style="min-width:0;">
									<div class="k-label">Rata-rata Harian</div>
									<div class="k-value" id="chart_avg"></div>
								</div>
							</div>
						</div>
						<div class="chart-wrap"><canvas id="salesChart"></canvas></div>
						<div class="chart-legend"><span class="lg-sales">Penjualan</span><span class="lg-trx">Transaksi</span></div>
					</div>
				</div>
			</div>

			<!-- Top Produk -->
			<div class="col-12 col-lg-6 col-xxl-4">
				<div class="dash-card">
					<div class="dash-card-header">
						<h5><i class="fas fa-trophy" style="color:#f5b100;"></i> Top Produk Terjual &ndash; 3 Bulan</h5>
					</div>
					<div class="dash-card-body">
						<?php if(empty($dash['top_product'])){ ?>
							<div class="dash-empty"><i class="fas fa-box-open"></i>Belum ada penjualan</div>
						<?php } ?>
						<?php $max_qty = !empty($dash['top_product']) ? max(1, (int) $dash['top_product'][0]['qty']) : 1; ?>
						<?php foreach($dash['top_product'] as $i => $row){ $img = dash_product_img($row['product_image']); ?>
							<div class="top-item">
								<div class="top-rank <?php echo $i == 0 ? 'r1' : ($i == 2 ? 'r3' : ''); ?>"><?php echo $i + 1; ?></div>
								<?php if($img){ ?>
									<img class="top-img" src="<?php echo $img; ?>" alt="">
								<?php }else{ ?>
									<div class="top-img"><i class="fas fa-box"></i></div>
								<?php } ?>
								<div class="top-info">
									<div class="top-name"><span><?php echo htmlspecialchars($row['product_name']); ?></span><span><?php echo number_format($row['qty'], 0, ',', '.'); ?> item</span></div>
									<div class="top-cat"><?php echo htmlspecialchars($row['category_name'] ?: $row['product_code']); ?></div>
									<div class="top-bar"><div style="width:<?php echo round($row['qty'] / $max_qty * 100); ?>%;"></div></div>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>

		<!-- ===== Bottom Row ===== -->
		<div class="row g-3 mb-4">

			<!-- Faktur Terlewat -->
			<div class="col-12 col-xl-7">
				<div class="dash-card">
					<div class="dash-card-header">
						<h5><i class="fas fa-exclamation-triangle" style="color:var(--dash-red);"></i> Faktur Terlewat
							<?php if($dash['overdue_count'] > 0){ ?><span class="od-late" style="margin:0;"><?php echo $dash['overdue_count']; ?> faktur</span><?php } ?>
						</h5>
						<a href="<?php echo base_url(); ?>Payment/receivable" class="see-all">Lihat Semua</a>
					</div>
					<div class="dash-card-body">
						<?php if(empty($dash['overdue'])){ ?>
							<div class="dash-empty"><i class="far fa-check-circle"></i>Tidak ada faktur yang terlewat</div>
						<?php } ?>
						<?php foreach($dash['overdue'] as $row){ ?>
							<div class="od-item">
								<div class="od-icon soft-red"><i class="fas fa-file-invoice"></i></div>
								<div class="od-info">
									<div class="od-inv"><?php echo htmlspecialchars($row['hd_sales_inv']); ?></div>
									<div class="od-date">Jatuh tempo <?php echo date('d M Y', strtotime($row['hd_sales_due_date'])); ?></div>
								</div>
								<div class="od-right">
									<div class="od-amount"><?php echo dash_rp($row['hd_sales_remaining_debt']); ?></div>
									<span class="od-late">Terlambat <?php echo $row['late_days']; ?> hari</span>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>

			<!-- Stok Menipis -->
			<div class="col-12 col-xl-5">
				<div class="dash-card">
					<div class="dash-card-header">
						<h5><i class="fas fa-box-open txt-orange"></i> Stok Menipis</h5>
						<a href="<?php echo base_url(); ?>Masterdata/product" class="see-all">Lihat Semua</a>
					</div>
					<div class="dash-card-body">
						<?php if(empty($dash['low_stock'])){ ?>
							<div class="dash-empty"><i class="far fa-check-circle"></i>Semua stok aman</div>
						<?php }else{ ?>
							<table class="ls-table">
								<thead><tr><th>Produk</th><th style="width:70px;">Stok</th><th style="width:80px;">Minimum</th></tr></thead>
								<tbody>
								<?php foreach($dash['low_stock'] as $row){ $img = dash_product_img($row['product_image']); ?>
									<tr>
										<td>
											<?php if($img){ ?><img class="ls-img" src="<?php echo $img; ?>" alt=""><?php }else{ ?><span class="ls-img"><i class="fas fa-box"></i></span><?php } ?>
											<?php echo htmlspecialchars($row['product_name']); ?>
										</td>
										<td class="ls-stock"><?php echo number_format($row['stock'], 0, ',', '.'); ?></td>
										<td><?php echo number_format($row['product_min_stock'], 0, ',', '.'); ?></td>
									</tr>
								<?php } ?>
								</tbody>
							</table>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>

<?php
require DOC_ROOT_PATH . $this->config->item('footer');
?>
<script>
	const chartData = <?php echo json_encode($dash['chart']); ?>;
	let salesChart = null;

	function rp(n){ return 'Rp ' + Math.round(n).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.'); }
	function shortRp(n){
		if(n >= 1000000000) return (n / 1000000000).toFixed(1).replace('.0', '') + 'M';
		if(n >= 1000000) return (n / 1000000).toFixed(1).replace('.0', '') + 'jt';
		if(n >= 1000) return Math.round(n / 1000) + 'rb';
		return n;
	}

	function renderChart(range){
		const d = chartData[range];
		$('#chart_sum').text(rp(d.sum));
		$('#chart_avg').text(rp(d.avg));
		if(d.growth === null){
			$('#chart_growth').html('');
		}else{
			const up = d.growth >= 0;
			$('#chart_growth').html('<span class="dash-trend ' + (up ? 'up' : 'down') + '"><i class="fas fa-arrow-' + (up ? 'up' : 'down') + '"></i> ' + Math.abs(d.growth) + '%</span>');
		}

		const barColors = d.totals.map(function(v, i){ return i == d.totals.length - 1 ? '#0f8a5f' : '#a7e3c8'; });
		if(salesChart){ salesChart.destroy(); }
		salesChart = new Chart(document.getElementById('salesChart').getContext('2d'), {
			type: 'bar',
			data: {
				labels: d.labels,
				datasets: [
					{
						type: 'line',
						label: 'Transaksi',
						data: d.trx,
						yAxisID: 'trx',
						borderColor: '#0f8a5f',
						backgroundColor: '#fff',
						pointBackgroundColor: '#fff',
						pointBorderColor: '#0f8a5f',
						pointBorderWidth: 2,
						pointRadius: range == 7 ? 4 : 2,
						borderWidth: 2.5,
						fill: false,
						lineTension: 0.3
					},
					{
						type: 'bar',
						label: 'Penjualan',
						data: d.totals,
						yAxisID: 'sales',
						backgroundColor: barColors,
						hoverBackgroundColor: '#0f8a5f'
					}
				]
			},
			options: {
				responsive: true,
				maintainAspectRatio: false,
				legend: { display: false },
				tooltips: {
					mode: 'index',
					intersect: false,
					callbacks: {
						label: function(item, data){
							const ds = data.datasets[item.datasetIndex];
							return ds.label + ': ' + (ds.yAxisID == 'sales' ? rp(item.yLabel) : item.yLabel + ' kali');
						}
					}
				},
				scales: {
					xAxes: [{ gridLines: { display: false }, barPercentage: 0.7, ticks: { fontColor: '#6b7280', fontSize: 11, maxRotation: 0, autoSkip: true, maxTicksLimit: range == 7 ? 7 : 10 } }],
					yAxes: [
						{ id: 'sales', position: 'left', gridLines: { color: '#eef0f3', drawBorder: false }, ticks: { beginAtZero: true, fontColor: '#6b7280', fontSize: 11, maxTicksLimit: 5, callback: shortRp } },
						{ id: 'trx', position: 'right', display: false, gridLines: { display: false }, ticks: { beginAtZero: true, precision: 0 } }
					]
				}
			}
		});
	}

	$('#chart_range').on('change', function(){ renderChart($(this).val()); });
	renderChart('7');
</script>
