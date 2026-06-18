<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>

  <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/plugins.min.css" />
  <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/kaiadmin.min.css" />
    <script src="<?php echo base_url(); ?>dist/js/plugin/webfont/webfont.min.js"></script>
  <script>
    WebFont.load({
      google: { families: ["Public Sans:300,400,500,600,700"] },
      custom: {
        families: [
          "Font Awesome 5 Solid",
          "Font Awesome 5 Regular",
          "Font Awesome 5 Brands",
          "simple-line-icons",
        ],
        urls: ["<?php echo base_url(); ?>dist/css/fonts.min.css"],
      },
      active: function () {
        sessionStorage.fonts = true;
      },
    });
  </script>
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
  <div class="card" style="padding:0;">
    <div class="d-flex align-items-left">
      <div>
        <h3 class="fw-bold mb-3">Detail Product</h3>
      </div>
      <div class="ms-md-auto py-2 py-md-0">
      </div>
    </div>
    <div class="card-body" style="padding:0;">
      <?php foreach($data['get_product_by_id'] as $row){ ?>
        <div class="row">
          <div class="col-md-5">
            <div class="table-responsive">
              <table class="table table-bordered">
               <tbody>

                <tr>
                  <th scope="col" class="productinfo-text-right">Kode:</th>
                  <td colspan="4"><?php echo $row->product_code; ?></td>
                </tr>
                <tr>
                  <th scope="col" class="productinfo-text-right">Nama Produk:</th>
                  <td colspan="4"><?php echo $row->product_name; ?></td>
                </tr>
                <tr>
                  <th scope="col" class="productinfo-text-right">Satuan:</th>
                  <td colspan="4"><?php echo $row->unit_name; ?></td>
                </tr>
                <tr>
                  <th scope="col" class="productinfo-text-right">Kategori:</th>
                  <td colspan="4"><?php echo $row->category_name; ?></td>
                </tr>
                <tr>
                  <th scope="col" class="productinfo-text-right">Brand:</th>
                  <td colspan="4"><?php echo $row->brand_name; ?></td>
                </tr>
                <tr>
                  <th scope="col" class="productinfo-text-right">Supplier:</th>
                  <td colspan="4"><?php foreach(explode(",",$row->product_supplier_tag) as $rows){ echo '<span class="badge badge-primary " style="margin-right:1px;">'.$rows.'</span>';} ?></td>
                </tr>
                <tr>
                  <th scope="col" class="productinfo-text-right">Item Supplier:</th>
                  <td colspan="4"><?php echo nl2br($row->product_supplier_name); ?></td>
                </tr>
                <tr>
                  <th scope="col" class="productinfo-text-right">Status:</th>
                  <td colspan="4"><?php echo $row->product_status; ?></td>
                </tr>
                <tr>
                  <th scope="col" class="productinfo-text-right">Paket:</th>
                  <td colspan="4">
                    <?php if($row->is_package == 'Y'){
                      echo '<span class="badge badge-success"><i class="fas fa-check-circle"></i></span>';
                    }else{
                      echo '<span class="badge badge-danger multi-badge"><i class="fas fa-times-circle"></i></span>';
                    } ?>
                  </td>
                </tr>
                <tr>
                  <th scope="col" class="productinfo-text-right">PPN:</th>
                  <td colspan="4">
                    <?php if($row->is_ppn == 'PPN'){
                      echo '<span class="badge badge-success"><i class="fas fa-check-circle"></i></span>';
                    }else{
                      echo '<span class="badge badge-danger multi-badge"><i class="fas fa-times-circle"></i></span>';
                    } ?>
                  </td>
                </tr>
                
                <tr>
                  <th scope="col" class="productinfo-text-right">Min Stock:</th>
                  <td colspan="4"><?php echo $row->product_min_stock; ?></td>
                </tr>
                
                <tr>
                  <th scope="col" class="productinfo-text-right">Catatan Penting:</th>
                  <td colspan="4"><?php echo nl2br($row->product_purchase_record); ?></td>
                </tr>
                <tr>
                  <th scope="col" class="productinfo-text-right">Min Order:</th>
                  <td colspan="4"><?php echo $row->product_min_order; ?></td>
                </tr>
                <tr>
                  <th scope="col" class="productinfo-text-right">Berat:</th>
                  <td colspan="4"><?php echo $row->product_weight; ?> Gram</td>
                </tr>
                <tr>
                  <th scope="col" class="productinfo-text-right">HPP:</th>
                  <td colspan="4"><span class="badge badge-danger"><?php echo number_format($row->product_hpp); ?></span></td>
                </tr>
                <tr>
                  <th scope="col" class="productinfo-text-right">Harga Beli:</th>
                  <td colspan="4"><span class="badge badge-danger"><?php echo number_format($row->product_price); ?></span></td>
                </tr>
                <tr>
                  <th scope="col" class="productinfo-text-right">Lokasi Stok:</th>
                  <td colspan="4"><?php echo $row->product_location; ?></td>
                </tr>
                <tr>
                  <th scope="col" class="productinfo-text-right">Deskripsi:</th>
                  <td colspan="4"><?php echo nl2br($row->product_desc); ?></td>
                </tr>

              </tbody>
            </table>
          </div>
        </div>
        <div class="col-md-1">
        </div>
        <div class="col-md-6">
          <div class="table-responsive">
           <table class="table table-bordered">
            <tbody>
              <tr>
                <th>Disc Periode:</th>
                <td colspan="5"><?php $date_start = date_create($row->product_disc_start_date); echo date_format($date_start,"d-m-Y"); ?> / <?php $date_end = date_create($row->product_disc_end_date); echo date_format($date_end,"d-m-Y"); ?></td>
              </tr>
              <tr>
                <th scope="col" rowspan="2">Umum</th>
                <td>Margin</td>
                <td>Hrg.Jual</td>
                <td>Diskon(%)</td>
                <td>Diskon(Rp)</td>
              </tr>
              <tr>
                <td><?php echo $row->product_sell_percentage_1; ?> %</td>
                <td><span class="badge badge-primary"><?php echo number_format($row->product_sell_price_1); ?></span></td>
                <td><?php echo $row->product_disc_percentage; ?> %</td>
                <td><span class="badge badge-warning"><?php echo number_format($row->product_sell_price_1 - ($row->product_sell_price_1 * $row->product_disc_percentage / 100)); ?></span></td>
              </tr>
              <tr>
                <th scope="col" rowspan="2">Toko</th>
                <td>Margin</td>
                <td>Hrg.Jual</td>
                <td>Diskon(%)</td>
                <td>Diskon(Rp)</td>
              </tr>
              <tr>
                <td><?php echo $row->product_sell_percentage_2; ?> %</td>
                <td><span class="badge badge-primary"><?php echo number_format($row->product_sell_price_2); ?></span></td>
                <td><?php echo $row->product_disc_percentage; ?> %</td>
                <td><span class="badge badge-warning"><?php echo number_format($row->product_sell_price_2 - ($row->product_sell_price_2 * $row->product_disc_percentage / 100)); ?></span></td>
              </tr>
              <tr>
                <th scope="col" rowspan="2">Sales</th>
                <td>Margin</td>
                <td>Hrg.Jual</td>
                <td>Diskon(%)</td>
                <td>Diskon(Rp)</td>
              </tr>
              <tr>
                <td><?php echo $row->product_sell_percentage_3; ?> %</td>
                <td><span class="badge badge-primary"><?php echo number_format($row->product_sell_price_3); ?></span></td>
                <td><?php echo $row->product_disc_percentage; ?> %</td>
                <td><span class="badge badge-warning"><?php echo number_format($row->product_sell_price_3 - ($row->product_sell_price_3 * $row->product_disc_percentage / 100)); ?></span></td>
              </tr>
              <tr>
                <th scope="col" rowspan="2">Khusus</th>
                <td>Margin</td>
                <td>Hrg.Jual</td>
                <td>Diskon(%)</td>
                <td>Diskon(Rp)</td>
              </tr>
              <tr>
                <td><?php echo $row->product_sell_percentage_4; ?> %</td>
                <td><span class="badge badge-primary"><?php echo number_format($row->product_sell_price_4); ?></span></td>
                <td><?php echo $row->product_disc_percentage; ?> %</td>
                <td><span class="badge badge-warning"><?php echo number_format($row->product_sell_price_4 - ($row->product_sell_price_4 * $row->product_disc_percentage / 100)); ?></span></td>
              </tr>
            </tbody>
          </table>
        <?php } ?>  
        <table class="table table-bordered">
          <tbody>
            <tr>
              <th>Cabang / Gudang</th>
              <th>Qty</th>
            </tr>
            <?php foreach($data['product_stock'] as $rows){ ?>
              <tr>
                <td><?php echo $rows->warehouse_name; ?></td>
                <td><?php echo $rows->stock; ?> <?php echo $rows->unit_name; ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</div>
</body>

</html>  


