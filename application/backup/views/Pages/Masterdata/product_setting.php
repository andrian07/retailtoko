<?php 
define('DOC_ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].'/');
require DOC_ROOT_PATH . $this->config->item('header');
?>
</div>

<div class="container">
  <div class="page-inner">
    <div class="page-header">

    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex align-items-left">
              <div>
                <h3 class="fw-bold mb-3">Pengaturan Harga Produk</h3>
              </div>
              <div class="ms-md-auto py-2 py-md-0">
                <div class="btn-group dropdown">
                 <a href="<?php echo base_url(); ?>Masterdata/product"><button class="btn btn-danger"><i class="fas fa-arrow-circle-left"></i> Kembali</button></a>
                 <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target=".bd-example-modal-xl"><span class="btn-label"><i class="far fa-edit sizing-fa"></i></span> Edit</button>
                 <div class="modal fade bd-example-modal-xl" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" >
                  <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Setting Harga</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>

                      <div class="modal-body">
                        <div class="row">
                          <div class="col-md-4 border-right">
                            <h4 style="text-align:center;">Detail Produk</h4>
                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Kode Produk / Barcode</label>
                              <div class="col-md-12 p-0">
                                <input type="hidden" class="form-control input-full" id="item_id" value="<?php echo $_GET['id']; ?>" readonly>
                                <input type="text" class="form-control input-full" id="item_code" readonly>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Nama Produk</label>
                              <div class="col-md-12 p-0">
                                <input type="text" class="form-control input-full" id="item_name" readonly>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Satuan</label>
                              <div class="col-md-12 p-0">
                                <input type="text" class="form-control input-full" id="item_unit" readonly>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Harga Beli</label>
                              <div class="col-md-12 p-0">
                                <input type="text" class="form-control input-full" id="item_purchase_price" value="0">
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">HPP</label>
                              <div class="col-md-12 p-0">
                                <input type="text" class="form-control input-full" id="item_hpp" value="0">
                              </div>
                            </div>

                          </div>



                          <div class="col-md-4 border-right">
                            <h4 style="text-align:center;">Margin & Harga Jual</h4>
                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Harga Jual Normal</label>
                              <div class="row">
                                <div class="col-sm-4">
                                  <input id="item_price_1_percentage" name="item_price_1_percentage" type="text" class="form-control text-right" value="0">
                                </div>

                                <div class="col-sm-8">
                                  <input id="item_price_1" name="item_price_1" type="text" class="form-control text-right"  value="0">
                                </div>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Harga Jual Toko</label>
                              <div class="row">
                                <div class="col-sm-4">
                                  <input id="item_price_2_percentage" name="item_price_2_percentage" type="text" class="form-control text-right" value="0">
                                </div>

                                <div class="col-sm-8">
                                  <input id="item_price_2" name="item_price_2" type="text" class="form-control text-right" value="0">
                                </div>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Harga Sales</label>
                              <div class="row">
                                <div class="col-sm-4">
                                  <input id="item_price_3_percentage" name="item_price_3_percentage" type="text" class="form-control text-right" value="0">
                                </div>

                                <div class="col-sm-8">
                                  <input id="item_price_3" name="item_price_3" type="text" class="form-control text-right" value="0">
                                </div>
                              </div>
                            </div>


                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Harga Khusus</label>
                              <div class="row">
                                <div class="col-sm-4">
                                  <input id="item_price_4_percentage" name="item_price_4_percentage" type="text" class="form-control text-right" value="0">
                                </div>

                                <div class="col-sm-8">
                                  <input id="item_price_4" name="item_price_4" type="text" class="form-control text-right" value="0">
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="col-md-4 border-right">
                            <h4 style="text-align:center;">Disc Seasonal</h4>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Disc</label>
                              <div class="row">
                                <div class="col-sm-12">
                                  <input id="disc_percentage" name="disc_percentage" type="text" class="form-control text-right" value="0">
                                </div>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Dari Tanggal: </label>
                              <div class="row">
                                <div class="col-sm-12">
                                  <input id="start_disc" name="start_disc" type="date" class="form-control text-right" value="0">
                                </div>
                              </div>
                            </div>

                            <div class="form-group form-inline">
                              <label for="inlineinput" class="col-md-3 col-form-label">Sampai Tanggal: </label>
                              <div class="row">
                                <div class="col-sm-12">
                                  <input id="end_disc" name="end_disc" type="date" class="form-control text-right" value="0">
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-times-circle"></i> Batal</button>
                        <button type="button" class="btn btn-primary" id="btnsave"><i class="fas fa-save"></i> Simpan</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-body">
            <?php foreach ($data['settingproduct'] as $row) { ?>
              <table width="100%" class="mb-3">
                <tbody>
                  <tr>
                    <th width="15%">Kode Produk</th>
                    <td width="1%">:</td>
                    <td width="84%" id="setup_product_code"><?php echo $row->product_code; ?></td>
                  </tr>
                  <tr>
                    <th>Nama Produk</th>
                    <td>:</td>
                    <td id="setup_product_name"><?php echo $row->product_name; ?></td>
                  </tr>
                </tbody>
              </table>

              <div class="row">
                <div class="col-md-6">
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
                          <td colspan="4"><?php echo $row->product_supplier_name; ?></td>
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
                          <td colspan="4"><?php echo $row->product_purchase_record; ?></td>
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
                          <td colspan="4"><?php echo $row->product_desc; ?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
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
                    <table class="table table-head-bg-info">
                      <thead>
                        <tr>
                          <th>Cabang / Gudang</th>
                          <th>Qty</th>
                        </tr>
                      </thead>
                      <tbody>
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
            <?php } ?>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
</div>


<?php 
require DOC_ROOT_PATH . $this->config->item('footer');
?>

<script>


  new bootstrap.Modal(document.getElementById('myModal'), {backdrop: 'static', keyboard: false})  
  
  let item_purchase_price = new AutoNumeric('#item_purchase_price', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let item_hpp = new AutoNumeric('#item_hpp', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let item_price_1 = new AutoNumeric('#item_price_1', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let item_price_2 = new AutoNumeric('#item_price_2', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });
  let item_price_3 = new AutoNumeric('#item_price_3', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });
  let item_price_4 = new AutoNumeric('#item_price_4', {
    currencySymbol : 'Rp. ',
    decimalCharacter : ',',
    decimalPlaces: 0,
    decimalPlacesShownOnFocus: 0,
    digitGroupSeparator : '.',
  });

  let item_price_1_percentage = new AutoNumeric('#item_price_1_percentage', {
    suffixText: "%",
    decimalPlaces: 0,
  });

  let item_price_2_percentage = new AutoNumeric('#item_price_2_percentage', {
    suffixText: "%",
    decimalPlaces: 0,
  });

  let item_price_3_percentage = new AutoNumeric('#item_price_3_percentage', {
    suffixText: "%",
    decimalPlaces: 0,
  });

  let item_price_4_percentage = new AutoNumeric('#item_price_4_percentage', {
    suffixText: "%",
    decimalPlaces: 0,
  });
  
  let disc_percentage = new AutoNumeric('#disc_percentage', {
    suffixText: "%",
    decimalPlaces: 0,
  });


  $('body').on('shown.bs.modal', '.modal', function() {
    $(this).find('.js-example-basic-multiple').each(function() {
      var dropdownParent = $(document.body);
      if ($(this).parents('#myModal').length !== 0)
        dropdownParent = $("#myModal");
      $(this).select2({
        dropdownParent: $("#myModal")
      // ...
      });
    });
  });

  $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
  });

  $('#btnsave').click(function(e){
    e.preventDefault();
    var item_id                       = $("#item_id").val();
    var item_purchase_price_val       = item_purchase_price.get();
    var item_hpp_val                  = item_hpp.get();
    var item_price_1_percentage_val   = item_price_1_percentage.get();
    var item_price_2_percentage_val   = item_price_2_percentage.get();
    var item_price_3_percentage_val   = item_price_3_percentage.get();
    var item_price_4_percentage_val   = item_price_4_percentage.get();
    var item_price_1_val              = item_price_1.get();
    var item_price_2_val              = item_price_2.get();
    var item_price_3_val              = item_price_3.get();
    var item_price_4_val              = item_price_4.get();
    var disc_percentage_val           = disc_percentage.get();
    var start_disc_val                = $("#start_disc").val();
    var end_disc_val                  = $("#end_disc").val();

    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Masterdata/edit_price",
      dataType: "json",
      data: {item_id:item_id, item_purchase_price_val:item_purchase_price_val, item_hpp_val:item_hpp_val, item_price_1_percentage_val:item_price_1_percentage_val, item_price_2_percentage_val:item_price_2_percentage_val, item_price_3_percentage_val:item_price_3_percentage_val, item_price_4_percentage_val:item_price_4_percentage_val, item_price_1_val:item_price_1_val, item_price_2_val:item_price_2_val, item_price_3_val:item_price_3_val, item_price_4_val:item_price_4_val, disc_percentage_val:disc_percentage_val, start_disc_val:start_disc_val, end_disc_val:end_disc_val},
      success : function(data){
        if (data.code == "200"){
          window.location.href = "<?php echo base_url(); ?>Masterdata/settingproduct?id="+item_id;
          Swal.fire('Saved!', '', 'success');
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: data.result,
          })
        }
      }
    });
  });


  $('#myModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var modal = $(this)
    modal.find('.modal-title').text('Edit Harga')
    var id = $("#item_id").val();

    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Masterdata/get_edit_product",
      dataType: "json",
      data: {id:id},
      success : function(data){
        if (data.code == "200"){
          let row = data.result[0];
          modal.find('#item_code').val(row.product_code)
          modal.find('#item_name').val(row.product_name)
          modal.find('#item_unit').val(row.unit_name)
          item_purchase_price.set(row.product_price)
          item_hpp.set(row.product_hpp)
          item_price_1.set(row.product_sell_price_1)
          item_price_2.set(row.product_sell_price_2)
          item_price_3.set(row.product_sell_price_3)
          item_price_4.set(row.product_sell_price_4)
          item_price_1_percentage.set(row.product_sell_percentage_1)
          item_price_2_percentage.set(row.product_sell_percentage_2)
          item_price_3_percentage.set(row.product_sell_percentage_3)
          item_price_4_percentage.set(row.product_sell_percentage_4)
          disc_percentage.set(row.product_disc_percentage)
          modal.find('#start_disc').val(row.product_disc_start_date)
          modal.find('#end_disc').val(row.product_disc_end_date)
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: data.result,
          })
        }
      }
    });
  })

  $('#item_price_1_percentage').on('input', function (event) {
    let item_price_1_percentage_cal = parseInt(item_price_1_percentage.get());
    let item_purchase_price_cal = parseInt(item_purchase_price.get());
    let item_price_1_cal = (item_purchase_price_cal + (item_purchase_price_cal * item_price_1_percentage_cal / 100));
    item_price_1.set(item_price_1_cal);
  })

  $('#item_price_2_percentage').on('input', function (event) {
    let item_price_2_percentage_cal = parseInt(item_price_2_percentage.get());
    let item_purchase_price_cal = parseInt(item_purchase_price.get());
    let item_price_2_cal = (item_purchase_price_cal + (item_purchase_price_cal * item_price_2_percentage_cal / 100));
    item_price_2.set(item_price_2_cal);
  })

  $('#item_price_3_percentage').on('input', function (event) {
    let item_price_3_percentage_cal = parseInt(item_price_3_percentage.get());
    let item_purchase_price_cal = parseInt(item_purchase_price.get());
    let item_price_3_cal = (item_purchase_price_cal + (item_purchase_price_cal * item_price_3_percentage_cal / 100));
    item_price_3.set(item_price_3_cal);
  })

  $('#item_price_4_percentage').on('input', function (event) {
    let item_price_4_percentage_cal = parseInt(item_price_4_percentage.get());
    let item_purchase_price_cal = parseInt(item_purchase_price.get());
    let item_price_4_cal = (item_purchase_price_cal + (item_purchase_price_cal * item_price_4_percentage_cal / 100));
    item_price_4.set(item_price_4_cal);
  })



  $('#item_price_1').on('input', function (event) {
    let item_price_1_cal = parseInt(item_price_1.get());
    let item_purchase_price_cal = parseInt(item_purchase_price.get());
    let item_price_1_percentage_cal = (item_price_1_cal / item_purchase_price_cal * 100) - 100;
    item_price_1_percentage.set(item_price_1_percentage_cal);
  })

  $('#item_price_2').on('input', function (event) {
    let item_price_2_cal = parseInt(item_price_2.get());
    let item_purchase_price_cal = parseInt(item_purchase_price.get());
    let item_price_2_percentage_cal = (item_price_2_cal / item_purchase_price_cal * 100) - 100;
    item_price_2_percentage.set(item_price_2_percentage_cal);
  })

  $('#item_price_3').on('input', function (event) {
    let item_price_3_cal = parseInt(item_price_3.get());
    let item_purchase_price_cal = parseInt(item_purchase_price.get());
    let item_price_3_percentage_cal = (item_price_3_cal / item_purchase_price_cal * 100) - 100;
    item_price_3_percentage.set(item_price_3_percentage_cal);
  })

  $('#item_price_4').on('input', function (event) {
    let item_price_4_cal = parseInt(item_price_4.get());
    let item_purchase_price_cal = parseInt(item_purchase_price.get());
    let item_price_4_percentage_cal = (item_price_4_cal / item_purchase_price_cal * 100) - 100;
    item_price_4_percentage.set(item_price_4_percentage_cal);
  })

  $('#item_purchase_price').on('input', function (event) {
    let item_purchase_price_cal = parseInt(item_purchase_price.get());
    let item_price_1_percentage_cal = parseInt(item_price_1_percentage.get());
    let item_price_2_percentage_cal = parseInt(item_price_2_percentage.get());
    let item_price_3_percentage_cal = parseInt(item_price_3_percentage.get());
    let item_price_4_percentage_cal = parseInt(item_price_4_percentage.get());
    let item_price_1_cal = (item_purchase_price_cal + (item_purchase_price_cal * item_price_1_percentage_cal / 100));
    let item_price_2_cal = (item_purchase_price_cal + (item_purchase_price_cal * item_price_2_percentage_cal / 100));
    let item_price_3_cal = (item_purchase_price_cal + (item_purchase_price_cal * item_price_3_percentage_cal / 100));
    let item_price_4_cal = (item_purchase_price_cal + (item_purchase_price_cal * item_price_4_percentage_cal / 100));
    item_price_1.set(item_price_1_cal);
    item_price_2.set(item_price_1_cal);
    item_price_3.set(item_price_1_cal);
    item_price_4.set(item_price_1_cal);
  })
  



</script>