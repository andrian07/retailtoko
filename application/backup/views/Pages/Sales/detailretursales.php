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
      <h2>Detail Retur Penjualan</h2>
    </div>
  </div>

  <?php foreach($data['header_retur_sales'] as $row){ ?>
    <div class="row header-details">
      <div class="col-md-4">
        <p class="detail-company"><b><?php echo company ?> </b></p>
        <p><?php echo company_address ?></p>
        <p><?php echo company_phone ?></p>
      </div>
      <div class="col-md-4">
        <p class="detail-invoice"><?php echo $row->hd_retur_sales_inv; ?></p>
        <p>Customer: <b><?php echo $row->customer_name; ?></b></p>
      </div>
      <div class="col-md-4">
        <p>Status: 
          <b>
            <?php 
            if($row->hd_retur_sales_status == 'Success'){
              echo '<span class="badge badge-success">Success</span>';
            }else if($row->hd_retur_sales_status == 'Cancel'){
              echo '<span class="badge badge-danger">Cancel</span>';
            }else{
               echo '<span class="badge badge-primary">Pending</span>';
            }
            ?>
          </b>
        </p>
        <p>Tanggal: <b><?php $date = date_create($row->hd_retur_sales_date);  echo date_format($date,"d-M-Y"); ?></b></p>
      </div>
    </div>
  <?php } ?>

  <div class="row">
    <div class="col-md-12"> 
      <table class="table table-striped mt-3" style="border:none !important; font-weight:500;">
        <thead>
          <tr>
            <th scope="col">Kode Penjualan</th>
            <th scope="col">SKU</th>
            <th scope="col">produk</th>
            <th scope="col">Satuan</th>
            <th scope="col">Qty</th>
            <th scope="col">Total</th>
            <th scope="col">Catatan</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($data['detail_retur_sales'] as $row){ ?>
            <tr>
              <td><?php echo $row->hd_sales_inv; ?></td>
              <td><?php echo $row->product_code; ?></td>
              <td><?php echo $row->product_name; ?></td>
              <td><?php echo $row->unit_name; ?></td>
              <td><?php echo $row->dt_retur_sales_qty; ?></td>
              <td><?php echo number_format($row->dt_retur_sales_total); ?></td>
              <td><?php echo $row->dt_retur_sales_note; ?></td>
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
          <?php foreach($data['header_retur_sales'] as $row){ ?>
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
          <?php foreach($data['header_retur_sales'] as $row){ ?>
            <tr>
              <td scope="col"><b>Total: </b></td>
              <td scope="col">Rp. <?php echo number_format($row->hd_retur_sales_total); ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

</body>

</html>