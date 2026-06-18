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

  </style>
</head>
<body>
  <div class="row">
    <div class="col-md-12 header-detail">
      <h2>Data Pengajuan</h2>
    </div>
  </div>

  <div class="row title-detail-middle">
    <div class="col-md-4">
      <p class="detail-company"><b><?php echo company ?> </b><br /> <?php echo company_address ?> <br /> <?php echo company_phone ?></p>
    </div>
    <div class="col-md-4" class="col-detail-inv">

    </div>
    <?php foreach($submission_by_id as $row){ ?>
      <div class="col-md-4 detail-right" >
        <p class="detail-invoice"><?php echo $row['submission_invoice']; ?></p>
        <p>Tanggal: <b><?php $date = date_create($row['submission_date']);  echo date_format($date,"d-M-Y"); ?></b></p>
        <p>Sales: <b><?php echo $row['salesman_name']; ?></b></p>
        <p>Gudang: <b><?php echo $row['warehouse_name']; ?></b></p>
      </div>
    <?php } ?>
  </div>

  <div class="row">
    <div class="col-md-12"> 
      <table class="table table-striped mt-3" style="border:none !important; font-weight:500;">
        <thead>
          <tr>
            <th scope="col">Kode Produk</th>
            <th scope="col">Nama Produk</th>
            <th scope="col">Qty</th>
            <th scope="col">Keterangan</th>
            <th scope="col">Status</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($submission_by_id as $row){ ?>
            <tr>
              <td scope="col"><?php echo $row['product_code']; ?></td>
              <td scope="col"><?php echo $row['product_name']; ?></td>
              <td scope="col"><?php echo $row['submission_qty']; ?></td>
              <td scope="col"><?php echo $row['submission_desc']; ?></td>
              <td scope="col"><?php echo $row['submission_status']; ?></td>
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
          <tr>
            <td scope="col"><b>Action</b></td>
            <td scope="col"><b>User</b></td>
            <td scope="col"><b>Created At</b></td>
          </tr>
          <?php foreach($submission_by_id as $row){ ?>
            <tr>
              <td><b>Dibuat</b></td>
              <td><?php echo $row['user_name']; ?></td>
              <td><?php $date = date_create($row['created_at']);  echo date_format($date,"d-M-Y h:i:s"); ?></td>
            </tr>
         
          <tr>
            <td style="border-bottom: none;"><b>Catatan:</b></td>
            <td style="border-bottom: none;"><?php echo $row['submission_text']; ?></td>
          </tr>
           <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
  
</body>

</html>