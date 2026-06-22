<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>

  <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/plugins.min.css" />
  <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/kaiadmin.min.css" />
  <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/style.css" />
  <style type="text/css">
    .title-detail{
      text-align: right;
    }
    .row {
      --bs-gutter-x: 0 !important;
    }
    body{
      background: #fff;
    }

    .fancybox__content, 
    .fancybox__iframe,
    #fancybox__iframe_1_0{
      height: 518px !important;
    }

    .header-details p{
      line-height: 10px;
    }

    .header-details{
      padding-top: 15px;
      padding-left: 1%;
    }
  </style>
</head>
<body>
  <div class="row">
    <div class="col-md-12 header-detail">
      <h2>Detail Pembelian</h2>
    </div>
  </div>

  <?php foreach($data['header_purchase'] as $row){ ?>
    <div class="row header-details">
      <div class="col-md-4">
        <p class="detail-company"><b><?php echo company ?> </b></p>
        <p><?php echo company_address ?></p>
        <p><?php echo company_phone ?></p>
      </div>
      <div class="col-md-4">
        <p class="detail-invoice"><?php echo $row['hd_purchase_invoice']; ?></p>
        <p>Supplier: <b><?php echo $row['supplier_name']; ?></b></p>
        <p>Golongan: 
          <b>
            <?php 
            if($row['hd_purchase_tax'] == 'Y'){
              echo '<span class="badge badge-success">BKP</span>';
            }else{
              echo '<span class="badge badge-danger">NON BKP</span>';
            }
            ?>
          </b>
        </p>
        <p>Metode Bayar: <b><?php echo $row['payment_name']; ?></b></p>
      </div>
      <div class="col-md-4">
        <p>Status: 
          <b>
            <?php 
            if($row['hd_purchase_status'] == 'Pending'){
              echo '<span class="badge badge-primary">Pending</span>';
            }else if($row['hd_purchase_status'] == 'Success'){
              echo '<span class="badge badge-success">Success</span>';
            }else{
              echo '<span class="badge badge-danfer">Cancel</span>';
            }
            ?>
          </b>
        </p>
        <p>Tanggal: <b><?php $date = date_create($row['hd_purchase_date']);  echo date_format($date,"d-M-Y"); ?></b></p>
        <p>Jth Tempo: <b><?php $date = date_create($row['hd_purchase_due_date']);  echo date_format($date,"d-M-Y"); ?></b></p>
        <p>Gudang: <b><?php echo $row['warehouse_name']; ?></b></p>
      </div>
    </div>
  <?php } ?>

  <div class="row">
    <div class="col-md-12"> 
      <table class="table table-striped mt-3" style="border:none !important; font-weight:500;">
        <thead>
          <tr>
            <th scope="col">SKU</th>
            <th scope="col">produk</th>
            <th scope="col">Satuan</th>
            <th scope="col">Harga Beli</th>
            <th scope="col">Qty</th>
            <th scope="col">Total</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($data['detail_purchase'] as $row){ ?>
            <tr>
              <td><?php echo $row['product_code']; ?></td>
              <td><?php echo $row['product_name']; ?></td>
              <td><?php echo $row['unit_name']; ?></td>
              <td><?php echo 'Rp. '.number_format($row['dt_purchase_price']); ?></td>
              <td><?php echo $row['dt_purchase_qty']; ?></td>
              <td><?php echo number_format($row['dt_purchase_total']); ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
  <p style="margin-left: 15px; font-size: 15px;">Logs:</p>
  <div class="row">
    <div class="col-md-4">
      <table class="table table-hover" style="border:none !important;">
        <tbody>
          <?php foreach($data['header_purchase'] as $row){ ?>
            <tr>
              <td scope="col"><b>Action</b></td>
              <td scope="col"><b>User</b></td>
              <td scope="col"><b>Created At</b></td>
            </tr>
            <tr>
              <td scope="col"><b>Dibuat</b></td>
              <td scope="col"><b><?php echo $row['user_name']; ?></b></td>
              <td scope="col"><b><?php $date = date_create($row['tanggal_purchase']);  echo date_format($date,"d-M-Y"); ?></b></td>
            </tr>
            <tr>
              <td style="border-bottom: none;"><b>Catatan:</b></td>
              <td style="border-bottom: none;"><?php echo $row['hd_purchase_note']; ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>

    <div class="col-md-4">

    </div>

    <div class="col-md-4">
      <table class="table" style="border:none !important; text-align:right;">
        <tbody>
          <?php foreach($data['header_purchase'] as $row){ ?>
            <tr>
              <td scope="col"><b>Sub Total: </b></td>
              <td scope="col">Rp. <?php echo number_format($row['hd_purchase_sub_total']); ?></td>
            </tr>
             <tr>
              <td scope="col"><b>Diskon 1: (<?php echo $row['hd_purchase_disc_percentage1']; ?> %)</b></td>
              <td scope="col">Rp. <?php echo number_format($row['hd_purchase_disc_1']); ?></td>
            </tr>
            <tr>
              <td scope="col"><b>Diskon 2: (<?php echo $row['hd_purchase_disc_percentage2']; ?> %)</b></td>
              <td scope="col">Rp. <?php echo number_format($row['hd_purchase_disc_2']); ?></td>
            </tr>
            <tr>
              <td scope="col"><b>Diskon 3: (<?php echo $row['hd_purchase_disc_percentage3']; ?> %)</b></td>
              <td scope="col">Rp. <?php echo number_format($row['hd_purchase_disc_3']); ?></td>
            </tr>
            <tr>
              <td scope="col"><b>DPP: </b></td>
              <td scope="col">Rp. <?php echo number_format($row['hd_purchase_dpp']); ?></td>
            </tr>
            <tr>
              <td scope="col"><b>PPN 11%: </b></td>
              <td scope="col">Rp. <?php echo number_format($row['hd_purchase_ppn']); ?></td>
            </tr>
            <tr>
              <td scope="col"><b>Grand Total: </b></td>
              <td scope="col">Rp. <?php echo number_format($row['hd_purchase_grand_total']); ?></td>
            </tr>
            <tr>
              <td scope="col"><b>DP: </b></td>
              <td scope="col">Rp. <?php echo number_format($row['hd_purchase_dp']); ?></td>
            </tr>
            <tr>
              <td scope="col"><b>Sisa Pembayaran: </b></td>
              <td scope="col">Rp. <?php echo number_format($row['hd_purchase_remaining_debt']); ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

</body>

</html>