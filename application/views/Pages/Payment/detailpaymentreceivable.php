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
      <h2>Detail Pembayaran Piutang</h2>
    </div>
  </div>

  <?php foreach($data['header_receivable_payment'] as $row){ ?>
    <div class="row header-details">
      <div class="col-md-4">
        <p class="detail-company"><b><?php echo company ?> </b></p>
        <p><?php echo company_address ?></p>
        <p><?php echo company_phone ?></p>
      </div>
      <div class="col-md-4">
        <p class="detail-invoice"><?php echo $row->payment_receivable_invoice; ?></p>
        <p>Pelanggan: <b><?php echo $row->customer_name; ?></b></p>
        <p>Metode Bayar: <b><?php echo $row->payment_name; ?></b></p>
      </div>
      <div class="col-md-4">
        <p>Status: 
          <b>
            <?php 
            if($row->status == 'Success'){
              echo '<span class="badge badge-primary">Success</span>';
            }else{
              echo '<span class="badge badge-danfer">Cancel</span>';
            }
            ?>
          </b>
        </p>
        <p>Tanggal: <b><?php $date = date_create($row->payment_receivable_date);  echo date_format($date,"d-M-Y"); ?></b></p>
      </div>
    </div>
  <?php } ?>

  <div class="row">
    <div class="col-md-12"> 
      <table class="table table-striped mt-3" style="border:none !important; font-weight:500;">
        <thead>
          <tr>
            <th scope="col">No Invoice Pembelian</th>
            <th scope="col">Tgl</th>
            <th scope="col">Discount</th>
            <th scope="col">Potongan Retur</th>
            <th scope="col">Nominal Bayar</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($data['detail_receivable_payment'] as $row){ ?>
            <tr>
              <td><?php echo $row->hd_sales_inv; ?></td>
              <td><?php $date = date_create($row->hd_sales_date);  echo date_format($date,"d-M-Y"); ?></td>
              <td><?php echo number_format($row->dt_payment_receivable_discount); ?></td>
              <td><?php echo number_format($row->dt_payment_receivable_retur); ?></td>
              <td><?php echo number_format($row->dt_payment_receivable_nominal); ?></td>
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
          <?php foreach($data['header_receivable_payment'] as $row){ ?>
            <tr>
              <td scope="col"><b>Action</b></td>
              <td scope="col"><b>User</b></td>
              <td scope="col"><b>Created At</b></td>
            </tr>
            <tr>
              <td scope="col"><b>Dibuat</b></td>
              <td scope="col"><b><?php echo $row->user_name; ?></b></td>
              <td scope="col"><b><?php $date = date_create($row->created_at);  echo date_format($date,"d-M-Y"); ?></b></td>
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
          <?php foreach($data['header_receivable_payment'] as $row){ ?>
            <tr>
              <td scope="col"><b>Total Pembayaran: </b></td>
              <td scope="col">Rp. <?php echo number_format($row->payment_receivable_total_pay); ?></td>
            </tr>
            <tr>
              <td scope="col"><b>Total Diskon: </b></td>
              <td scope="col">Rp. <?php echo number_format($row->payment_receivable_total_discount); ?></td>
            </tr>
            <tr>
              <td scope="col"><b>Total Retur: </b></td>
              <td scope="col">Rp. <?php echo number_format($row->payment_receivable_total_retur); ?></td>
            </tr>
            <tr>
              <td scope="col"><b>Total Nota: </b></td>
              <td scope="col">Rp. <?php echo number_format($row->payment_receivable_total_nota); ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

</body>

</html>