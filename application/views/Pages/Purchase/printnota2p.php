<!DOCTYPE html>
<html>
<head>
	<title>PO</title>

	<style>

		body{
			font-family: "Courier New", monospace;
			font-size:13px;
			margin:0;
			padding:0;
		}

		.container{
			width:1000px;
			margin:auto;
		}

		table{
			width:100%;
			border-collapse:collapse;
		}

		td,th{
			padding:3px;
		}

		.box{
			border:1px solid #000;
			padding:5px;
		}

		.table-item{
			border:1px solid #000;
		}

		.table-item th{
			border-bottom:1px solid #000;
		}

		.table-item td{
			border-right:1px dotted #000;
		}

		.table-item td:last-child{
			border-right:none;
		}

		.table-item th{
			border-right:1px solid #000;
		}

		.table-item th:last-child{
			border-right:none;
		}

		.text-right{
			text-align:right;
		}

		.text-center{
			text-align:center;
		}

		.address td{
			padding:0;
			margin:0;
			line-height:1;
		}

		.page-break{
			page-break-after:always;
		}

		@media print{
			@page{
				margin:5mm;
			}
		}

	</style>
</head>

<body>

	<?php

		$items_per_page = 12;
		$chunks = array_chunk($data['detail_po'], $items_per_page);

		$total_page = count($chunks);
		$page = 1;

		foreach($chunks as $chunk){

		?>

		<div class="container">

			<!-- HEADER -->

			<table class="header">

				<tr>
					<td width="10%" class="text-center">
						<img src="<?php echo base_url('assets/logo.png'); ?>" width="100">
					</td>

					<td width="50%">
						<table class="address">

							<tr>
								<td colspan="2"><b style="font-size:22px; text-decoration: underline;">TOKO PIONIR SUDIRMAN</b></td>
							</tr>

							<tr>
								<td colspan="2">JL NUSA INDAH 2 BLOCK D5 NO.10-11</td>
							</tr>

							<tr>
								<td colspan="2">(0561) 731219</td>
							</tr>

							<tr>
								<td width="60%">PONTIANAK</td>
								<td><b style="font-size:18px;">Purchase Order</b></td>
							</tr>

						</table>
					</td>

					<td width="40%">

						<div class="box">

							<?php foreach($data['header_po'] as $header){ ?>

							<?php echo $header->hd_po_date; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							INVOICE <?php echo $page; ?>/<?php echo $total_page; ?>

							<br><br>

							KEPADA YTH,
							<br>

							<b><?php echo $header->supplier_name; ?> - <?php echo $header->supplier_phone; ?></b>

							<br><br>

							<?php echo $header->supplier_address; ?>

							<?php } ?>

						</div>

					</td>
				</tr>

				<tr>
					<td style="text-align:right;">No Faktur</td>
					<td>: <?php echo $header->hd_po_invoice; ?></td>
					<td style="text-align:left;">
						Metode Pembayaran: <b><?php echo $header->payment_name; ?></b>
						
						<span style="margin-left:40px;">
							T.O.P : <b><?php echo $header->hd_po_top; ?></b>
						</span>
					</td>
				</tr>

			</table>


			<!-- TABLE -->

			<table class="table-item">

				<thead>

					<tr>
						<th width="5%">NO</th>
						<th width="8%">QTY</th>
						<th width="15%">SKU</th>
						<th>BARANG</th>
						<th width="15%">HARGA</th>
						<th width="15%">JUMLAH</th>
					</tr>

				</thead>

				<tbody>

					<?php
						$no = 1 + (($page-1) * $items_per_page);

						foreach($chunk as $row){
						?>

						<tr>
							<td><?php echo $no++; ?></td>
							<td class="text-center"><?php echo $row->dt_po_qty; ?> X</td>
							<td><?php echo $row->product_code; ?></td>
							<td><?php echo $row->product_name; ?></td>
							<td class="text-right"><?php echo number_format($row->dt_po_price); ?></td>
							<td class="text-right"><?php echo number_format($row->dt_po_total); ?></td>
						</tr>

						<?php } ?>

						<?php
							$empty = $items_per_page - count($chunk);

							for($i=0;$i<$empty;$i++){
							?>

							<tr>
								<td>&nbsp;</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>

							<?php } ?>

						</tbody>

					</table>

					<br>

					<?php if($page == $total_page){ ?>

					<!-- TOTAL -->

					<table>

						<tr>

							<td width="70%"></td>

							<td width="15%"><b>TOTAL FAKTUR</b></td>

							<td class="text-right">
								<b>Rp. <?php echo number_format($header->hd_po_grand_total); ?></b>
							</td>

						</tr>

					</table>


					<!-- FOOTER -->

					<table class="sign">

						<tr>

							<td width="30%" class="text-center">
								PENERIMA
								<br><br><br><br><br>
								(.................)
							</td>

							<td width="30%" class="text-center">
								HORMAT KAMI
								<br><br><br><br><br>
								(.................)
							</td>

							<td width="40%">

								<table border="1" width="100%">


								</table>

								<br>

								KETERANGAN :
                                <br>
                                 <?php echo $header->hd_po_note; ?>

							</td>

						</tr>

					</table>

					<?php } ?>

				</div>

				<?php if($page < $total_page){ ?>
				<div class="page-break"></div>
				<?php } ?>

				<?php $page++; } ?>

			</body>
			</html>