<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>

  <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/plugins.min.css" />
  <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/kaiadmin.min.css" />
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
  </style>
</head>
<body>
  <div class="row">
    <div class="col-md-12">
      <h2>Data Salesman</h2>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <table class="table table-bordered">
        <tbody>
          <?php foreach($salesman_detail as $row){ ?>
          <tr>
            <td class="title-detail">Nama Salesman:  </td>
            <td><?php echo $row->salesman_name; ?></td>
          </tr>
          <tr>
            <td class="title-detail">Alamat: </td>
            <td width="70%"><?php echo $row->salesman_address; ?></td>
          </tr>
          <tr>
            <td class="title-detail">Telp :</td>
            <td><?php echo $row->salesman_phone; ?></td>
          </tr>
          <tr>
            <td class="title-detail">Cabang:  </td>
            <td><span class="badge badge-primary"><?php echo $row->warehouse_name; ?></span></td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

  
</body>

</html>