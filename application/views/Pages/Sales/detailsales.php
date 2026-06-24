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
      <h2>Detail Sales</h2>
    </div>
  </div>

  <?php foreach($data['header_sales'] as $row){ ?>
    <div class="row header-details">
      <div class="col-md-3">
        <p class="detail-company"><b><?php echo company ?> </b></p>
        <p><?php echo company_address ?></p>
        <p><?php echo company_phone ?></p>
      </div>
      <div class="col-md-3">
        <p>Customer: <b><?php echo $row->customer_name; ?></b></p>
        <p>Address: <?php echo $row->customer_address; ?></p>
        <p>Phone: <?php echo $row->customer_phone; ?></p>

      </div>
      <div class="col-md-3">
        <p>Metode Pembayaran: <b><?php echo $row->payment_name; ?></b></p>
      </div>
      <div class="col-md-3">
        <p class="detail-invoice"><?php echo $row->hd_sales_inv; ?></p>
        <p>Status: 
          <b>
            <?php 
            if($row->hd_sales_status == 'Success'){
              echo '<span class="badge badge-success">Success</span>';
            }else{
              echo '<span class="badge badge-danger">Cancel</span>';
            }
            ?>
          </b>
        </p>
        <p>Gudang: <b><?php echo $row->warehouse_name; ?></b></p>
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
            <th scope="col">Qty</th>
            <th scope="col">Price</th>
            <th scope="col">Discount</th>
            <th scope="col">Total</th>
            <th scope="col">Catatan</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($data['detail_sales'] as $row){ ?>
            <tr>
              <td><?php echo $row->product_code; ?></td>
              <td><?php echo $row->product_name; ?></td>
              <td><?php echo $row->dt_sales_qty; ?></td>
              <td><?php echo number_format($row->dt_sales_price); ?></td>
              <td><?php echo number_format($row->dt_sales_discount); ?></td>
              <td><?php echo number_format($row->dt_sales_total); ?></td>
              <td><?php echo $row->dt_sales_desc; ?></td>
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
          <?php foreach($data['header_sales'] as $row){ ?>
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
              <td style="border-bottom: none;"><?php echo $row->hd_sales_note; ?></td>
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
          <?php foreach($data['header_sales'] as $row){ ?>
            <tr>
              <td scope="col"><b>Sub Total: </b></td>
              <td scope="col">Rp. <?php echo number_format($row->hd_sales_sub_total); ?></td>
            </tr>
            <tr>
              <td scope="col"><b>Diskon 1: (<?php echo $row->hd_sales_percentage1; ?>)</b></td>
              <td scope="col">Rp. <?php echo number_format($row->hd_sales_disc1); ?></td>
            </tr>
            <tr>
              <td scope="col"><b>Diskon 2: (<?php echo $row->hd_sales_percentage2; ?>)</b></td>
              <td scope="col">Rp. <?php echo number_format($row->hd_sales_disc2); ?></td>
            </tr>
            <tr>
              <td scope="col"><b>Diskon 3: (<?php echo $row->hd_sales_percentage3; ?>)</b></td>
              <td scope="col">Rp. <?php echo number_format($row->hd_sales_disc3); ?></td>
            </tr>
            <tr>
              <td scope="col"><b>PPN 11%: </b></td>
              <td scope="col">Rp. <?php echo number_format($row->hd_sales_ppn); ?></td>
            </tr>
            <tr>
              <td scope="col"><b>Grand Total: </b></td>
              <td scope="col">Rp. <?php echo number_format($row->hd_sales_total); ?></td>
            </tr>
            <tr>
              <td scope="col"><b>DP: </b></td>
              <td scope="col">Rp. <?php echo number_format($row->hd_sales_dp); ?></td>
            </tr>
            <tr>
              <td scope="col"><b>Sisa Piutang: </b></td>
              <td scope="col">Rp. <?php echo number_format($row->hd_sales_total - $row->hd_sales_dp); ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

</body>

</html>