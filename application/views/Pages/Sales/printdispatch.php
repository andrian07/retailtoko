<!DOCTYPE html>
<html>
<head>
	<title>Surat Jalan</title>

	<style>

		body{
			font-family:"Courier New", monospace;
			font-size:13px;
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
			padding:4px;
		}

		.text-center{
			text-align:center;
		}

		.text-right{
			text-align:right;
		}

		.box{
			border:1px solid #000;
		}

		.header-title{
			font-size:22px;
			font-weight:bold;
			text-decoration:underline;
		}

		.colly-box{
			height:100px;
			font-size:80px;
			font-weight:bold;
		}

		.item-box{
			height:260px;
		}

		.sign td{
			border:1px solid #000;
			height:70px;
		}

		@media print{
			@page{
				margin:5mm;
			}
		}

	</style>

</head>

<body>

	<div class="container">

		<!-- HEADER -->

		<table>

			<tr>

				<td width="50%">

					<div class="header-title">
						TOKO PIONIR SUDIRMAN
					</div>

					JL NUSA INDAH 2 BLOCK D5 NO.10-11<br>
					(0561) 731219<br>
					PONTIANAK

					<br><br>

					NO SURAT JALAN : <?php echo $data['header_sales'][0]->hd_sales_inv; ?><br>
					KIRIM VIA : <?php echo $data['header_sales'][0]->ekspedisi_name; ?>

				</td>

				<td width="50%">

					<table class="box">

						<tr>
							<td class="text-left">
								<?php echo $data['header_sales'][0]->hd_sales_date; ?><br>
								Kepada,
							</td>
						</tr>

						<tr>
							<td>
								<b><?php echo $data['header_sales'][0]->customer_name; ?> - <?php echo $data['header_sales'][0]->customer_phone; ?></b><br><br>
								<?php echo $data['header_sales'][0]->customer_address; ?>
							</td>
						</tr>

					</table>

				</td>

			</tr>

			<tr>

				<td colspan="2" class="text-center" style="font-size:20px; padding-top:10px;">
					<b>SURAT JALAN</b>
				</td>

			</tr>

		</table>

		<br>

		<!-- BODY -->

		<table>

			<tr>

				<!-- JUMLAH COLLY -->

				<td width="45%">

					<table class="box">

						<tr>
							<td class="text-center">
								Jumlah Colly
							</td>
						</tr>

						<tr>
							<td class="text-center colly-box">
								<?php echo $data['header_sales'][0]->hd_sales_colly; ?> X
							</td>
						</tr>
						

					</table>

					<table class="ttd" style="border:1px solid #000; border-collapse:collapse; margin-top:20px;">
						<tr>
							<td width="50%" class="text-center" style="border:1px solid #000;">
								Tanda Terima,
							</td>

							<td width="50%" class="text-center" style="border:1px solid #000;">
								Hormat Kami,
							</td>
						</tr>

						<tr>
							<td width="50%" class="text-center" style="border:1px solid #000; height:50px;">
								
							</td>

							<td width="50%" class="text-center" style="border:1px solid #000; height:50px; vertical-align: bottom;">
								Toko Pionir
							</td>
						</tr>
					</table>

				</td>

				<td width="2%"></td>

				<!-- BARANG -->

				<td width="50%">

					<table class="box">
						<tr>
							<th width="10%">No</th>
							<th>Barang</th>
						</tr>

						<?php 
							$no = 1;
							$max_row = 10;
							$current_row = count($data['detail_sales']);

							foreach($data['detail_sales'] as $item){ 
							?>
							<?php } ?>

							<?php
								$empty = $max_row - $current_row;

								for($i = 0; $i < $empty; $i++){
								?>
								<tr>
									<td>&nbsp;</td>
									<td></td>
								</tr>
								<?php } ?>

							</table>

						</td>

					</tr>

				</table>

				<br>

				<!-- FOOTER -->

				<br>

				Item prepared by : <?php echo $data['header_sales'][0]->hd_sales_prepare; ?>

			</div>

		</body>
		</html>