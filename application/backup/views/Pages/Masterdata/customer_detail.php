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
      <h2>Data Customer</h2>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <table class="table table-bordered">
        <tbody>
          <?php foreach($get_customer_by_id as $row){ ?>
          <tr>
            <td class="title-detail">Kode Customer: </td>
            <td><?php echo $row->customer_code; ?></td>
          </tr>
          <tr>
            <td class="title-detail">Status:  </td>
            <td><span class="badge badge-success">Aktif</span></td>
          </tr>
          <tr>
            <td class="title-detail">Nama Customer : </td>
            <td><?php echo $row->customer_name; ?></td>
          </tr>
          <tr>
            <td class="title-detail">Tgl.Lahir :</td>
            <td><?php $date = date_create($row->customer_dob); echo date_format($date,"d M Y"); ?></td>
          </tr>
          <tr>
            <td class="title-detail">Rate Customer:  </td>
            <td>
              <?php if($row->customer_rate == 'Normal'){ ?>
              <span class="badge badge-primary">
              <?php }else if($row->customer_rate == 'Toko'){ ?>
              <span class="badge badge-warning">
              <?php }else if($row->customer_rate == 'Sales'){ ?>
              <span class="badge badge-info">
              <?php }else{ ?>
              <span class="badge badge-success">
              <?php } ?>
              <?php echo $row->customer_rate; ?></span>
            </td>
          </tr>
          <tr>
            <td class="title-detail">Jenis Kelamin :  </td>
            <td><?php if($row->customer_gender == 'L'){ echo 'Laki-Laki'; }else { echo 'Perempuan'; } ?></td>
          </tr>
          <tr>
            <td class="title-detail">Poin :  </td>
            <td width="70%"><?php echo $row->customer_poin; ?></td>
          </tr>
          <tr>
            <td class="title-detail">Alamat :  </td>
            <td width="70%"><?php echo $row->customer_address; ?></td>
          </tr>
          <tr>
            <td class="title-detail">Blok  :  </td>
            <td><?php echo $row->customer_address_blok; ?></td>
          </tr>
          <tr>
            <td class="title-detail">No Rumah  :  </td>
            <td><?php echo $row->customer_address_no; ?></td>
          </tr>
          <tr>
            <td class="title-detail">RT/RW :  </td>
            <td><?php echo $row->customer_rt; ?> / <?php echo $row->customer_rw; ?></td>
          </tr>
          <tr>
            <td class="title-detail">No Telp :   </td>
            <td><?php echo $row->customer_phone; ?></td>
          </tr>
          <tr>
            <td class="title-detail">Expedisi :   </td>
            <td><?php foreach(explode(",",$row->customer_expedisi_tag) as $rows){ echo '<span class="badge badge-primary" style="margin-right:5px;">'.$rows.'</span>';} ?></td>
          </tr>
          <tr>
            <td class="title-detail">Email :   </td>
            <td><?php echo $row->customer_email; ?></td>
          </tr>
           <tr>
            <td class="title-detail">Alamat Pengiriman: </td>
            <td><?php echo $row->customer_send_address; ?></td>
          </tr>
          <tr>
            <td class="title-detail">NPWP : </td>
            <td><?php echo $row->customer_npwp; ?></td>
          </tr>
          <tr>
            <td class="title-detail">NIK :</td>
            <td><?php echo $row->customer_nik; ?></td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

  
</body>

</html>