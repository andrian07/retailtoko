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
      <h2>Detail Transfer Stok</h2>
    </div>
  </div>

  <?php foreach($data['header_transfer'] as $row){ ?>
    <div class="row header-details">
      <div class="col-md-4">
        <p class="detail-company"><b><?php echo company ?> </b></p>
        <p><?php echo company_address ?></p>
        <p><?php echo company_phone ?></p>
      </div>
      <div class="col-md-4">
        <p class="detail-invoice"><?php echo $row->hd_transfer_stock_code; ?></p>
      </div>
      <div class="col-md-4">
        <p>Status: 
          <b>
            <?php 
            if($row->hd_transfer_stock_status == 'Success'){
              echo '<span class="badge badge-success">Success</span>';
            }else{
              echo '<span class="badge badge-danfer">Cancel</span>';
            }
            ?>
          </b>
        </p>
        <p>Tanggal: <b><?php $date = date_create($row->hd_transfer_stock_date);  echo date_format($date,"d-M-Y"); ?></b></p>
      </div>
    </div>
  <?php } ?>

  <div class="row">
    <div class="col-md-12"> 
      <table class="table table-striped mt-3" style="border:none !important; font-weight:500;">
        <thead>
          <tr>
            <th scope="col">SKU</th>
            <th scope="col">Item</th>
            <th scope="col">Satuan</th>
            <th scope="col">Qty</th>
            <th scope="col">Dari</th>
            <th scope="col">Tujuan</th>
             <th scope="col">Stok Akhir Dari</th>
            <th scope="col">Stok Akhir Ke</th>
            <th scope="col">Catatan</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($data['detail_transfer'] as $row){ ?>
            <tr>
              <td><?php echo $row['product_code']; ?></td>
              <td><?php echo $row['product_name']; ?></td>
              <td><?php echo $row['unit_name']; ?></td>
              <td><?php echo $row['dt_transfer_stock_qty']; ?></td>
              <td><?php echo $row['from']; ?></td>
              <td><?php echo $row['to']; ?></td>
              <td><?php echo $row['dt_transfer_stock_from_qty']; ?></td>
              <td><?php echo $row['dt_transfer_stock_to_qty']; ?></td>
              <td><?php echo $row['dt_transfer_stock_note']; ?></td>
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
          <?php foreach($data['header_transfer'] as $row){ ?>
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
            <tr>
              <td style="border-bottom: none;"><b>Catatan:</b></td>
              <td style="border-bottom: none;"><?php echo $row->hd_transfer_stock_desc; ?></td>
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
          <?php foreach($data['header_transfer'] as $row){ ?>
            <tr>
              <td scope="col"><b>Total Item: </b></td>
              <td scope="col"><?php echo $row->hd_transfer_stock_qty ; ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

</body>

</html>